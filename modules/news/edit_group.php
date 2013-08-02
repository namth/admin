<?php
$catid = $_GET['catid']?$_GET['catid']:0;
$q = "SELECT name, level, seolink FROM tbl_category WHERE id={$catid}";
$r = mysql_query($q);
//Neu category ton tai trong database thi xuat du lieu ra ngoai trinh duyet
if(mysql_num_rows($r)){
	$ro = mysql_fetch_array($r);
	
	list($catname, $parents, $seolink) = $ro;
}else{
	$messages = "<span class='notification-input ni-error'>Category ID không tồn tại</span>";
}
?>
<script language = "javascript">
$(document).ready(function() { 
$(document).ready(function() { 
	var name = $('#name');
	var seolink = $('#seolink');
	
	name.blur(validatename);
	seolink.blur(validateseolink);
	
	name.keyup(validatename);
	seolink.keyup(validateseolink);
	
	
	$('#edit_cat').submit(function(){
		if(validatename() & validatecheckseolink()){
			return true
		}else{
			return false;
		}
	});
	
	function validatename(){
		var name = $("#name").val();
		if(name.length == 0){
			document.getElementById("rpname").innerHTML = "<span class=\"notification-input ni-error\">Bạn chưa điền tên danh mục</span>";
			return false;
		}else{
			document.getElementById("rpname").innerHTML = "<span class=\"notification-input ni-correct\">Bạn có thể sủ dụng tên này</span>";
			return true;
		}	
	}
	
	function validatecheckseolink(){
		var check_seolink = $("#check_seolink").val();
		var seolink = $("#seolink").val();
		if(seolink == ""){
			document.getElementById("rpseolink").innerHTML = "<span class=\"notification-input ni-correct\">Hệ thống tự sinh seolink</span>";
			return true;
		}else{
			if(seolink == '<?php echo $seolink?>')
				document.getElementById("rpseolink").innerHTML = "<span class=\"notification-input ni-correct\">Giữ nguyên seolink cũ</span>";
			if(check_seolink == "error")
				return false;	
			else
				return true;
		}
	}
	
	function validateseolink(){
		var seolink = $("#seolink").val();
		if(seolink == ""){
			document.getElementById("rpseolink").innerHTML = "<span class=\"notification-input ni-correct\">Nếu bạn để trống hệ thống sẽ tự sinh seolink</span>";
		}else{
			$.ajax({
				type: "get",
				url: "<?php echo $sitepath; ?>admin/includes/seolink.php",
				data: "seolink="+ seolink +"&mod=category&old=<?php echo $ro['seolink']?>",
				success: function(response){
					switch(response){
				case "yes":
					$('#rpseolink').html("<span class=\"notification-input ni-error\">Đã tồn tại seolink này! Vui lòng nhập seolink khác</span>");
					edit_cat.check_seolink.value = "error";
					break;
				case "no":
					$('#rpseolink').html("<span class=\"notification-input ni-correct\">Bạn có thể sử dụng seolink này</span>");
					edit_cat.check_seolink.value = "";
					break;
				case "old":
					$('#rpseolink').html("<span class=\"notification-input ni-correct\">Giữ nguyên seolink cũ.</span>");
					edit_cat.check_seolink.value = "";
					break;
			}
					

			}
			});
		}
	}
})
})
</script>
<div class="container_12">
    <!-- Form elements -->    
    <div class="grid_12">
    <?php 
        if(!empty($messages)) echo $messages; ?>   
        <div class="module">
             <h2><span>Sửa danh mục</span></h2>
             <div class="module-body">
                <form id="edit_cat" action="index.php?mod=news&act=process_edit_group&catid=<?php echo $catid;?>" method="post" name="check" onsubmit="return check_form()">
                
                    <p>
                        <label>Tên danh mục</label>
                        <input id="name" name="category" type="text" class="input-medium" value="<?php if(isset($catname)) echo $catname; ?>" />
                        <span id = "rpname" style="font-style:italic; font-size:11px; color:#CCC">Nhập tên của danh mục</span>
                    </p>
                    
                    <p>
                        <label>Link thân thiện (có thể để trống)</label>
                        <input id="seolink" name="seolink" type="text" class="input-medium" value="<?php if(isset($seolink)) echo $seolink; ?>"/>
                        <span id = "rpseolink" style="font-style:italic; font-size:11px; color:#CCC">Nhập seolink (nếu bạn để trống hệ thống sẽ tự sinh)</span>
                        <input type="hidden" value="" id="check_seolink" />
                    </p>
                    
                    <p>
                        <label>Lựa chọn danh mục cha</label>
                        <select name="parents" class="input-medium">
                            <option value="0">Dang mục gốc</option>
                            <?php
								$result = mysql_query("SELECT * FROM tbl_category where lang_id = $lang and id <> 2 and grouptype = 2");
								while($rows = mysql_fetch_array($result)){
									?>
								<option value="<?php echo $rows['id']?>" <?php if($rows['id']==$ro['level']) echo "selected = 'selected'";?>><?php echo $rows['name']?></option>	
									<?php
								}
							?>
                        </select>
                    </p>
                    
                    <fieldset>
                        <input class="submit-green" type="submit" value="Xác nhận" name="submit"/> 
                        <input class="submit-gray" type="submit" value="Quay lại" name="cancel" />
                    </fieldset>
                </form>
             </div> <!-- End .module-body -->

        </div>  <!-- End .module -->
        <div style="clear:both;"></div>
    </div> <!-- End .grid_12 -->
        
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->