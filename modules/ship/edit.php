<?php
	$ship_id = $_GET['ship_id']?$_GET['ship_id']:0;
	$q = "SELECT * FROM tbl_shipping_fee WHERE id={$ship_id}";
	$r = mysql_query($q);
	//Neu category ton tai trong database thi xuat du lieu ra ngoai trinh duyet
	if(mysql_num_rows($r)>0){
		$ro = mysql_fetch_array($r);
		
		list($id, $add, $parents,$fee, $lang_id, $seolink) = $ro;
	}else{
		$messages = "<span class='notification-input ni-error'>Ship ID không tồn tại</span>";
	}
?>

<script language = "javascript">
$(document).ready(function() { 
	var add = $('#add');
	var seolink = $('#seolink');
	var fee = $("#fee");
	
	add.blur(validateadd);
	seolink.blur(validateseolink);
	fee.blur(validatefee);
	
	add.keyup(validateadd);
	seolink.keyup(validateseolink);
	fee.keyup(validatefee);
	
	$('#frm_ship').submit(function(){
		if(validateadd() & validatecheckseolink() & validatefee()){
			return true
		}else{
			return false;
		}
	});
	
	function validateadd(){
		var add = $("#add").val();
		if(add.length == 0){
			document.getElementById("rpadd").innerHTML = "<span class=\"notification-input ni-error\">Bạn chưa điền tên địa điểm</span>";
			return false;
		}else{
			document.getElementById("rpadd").innerHTML = "<span class=\"notification-input ni-correct\">Bạn có thể sủ dụng tên này</span>";
			return true;
		}	
	}
	
	function validatefee(){
		var fee = $("#fee").val();
		if(fee.length == 0){
			document.getElementById("rpfee").innerHTML = "<span class=\"notification-input ni-error\">Bạn chưa nhập giá vận chuyển đến địa điểm này</span>";
			return false;
		}else{
			if(isNaN(fee)){
				document.getElementById("rpfee").innerHTML = "<span class=\"notification-input ni-error\">Bạn nhập chưa đúng định dạng</span>";
				return false;
			}else{
				document.getElementById("rpfee").innerHTML = "<span class=\"notification-input ni-correct\">&nbsp;</span>";
				return true;	
			}
		}	
	}
	
	function validatecheckseolink(){
		var check_seolink = $("#check_seolink").val();
		var seolink = $("#seolink").val();
		if(seolink == ""){
			document.getElementById("rpseolink").innerHTML = "<span class=\"notification-input ni-correct\">Hệ thống tự sinh seolink</span>";
			return true;
		}else{
			if(check_seolink == "error")
				return false;	
			else
				return true;
		}
	}
	
	function validateseolink(){
		var seolink = $("#seolink").val();
		if(seolink != ""){
			$.ajax({
				type: "get",
				url: "<?php echo $sitepath; ?>admin/includes/seolink.php",
				data: "seolink="+ seolink + "&mod=ship",
				success: function(response){
					switch(response){
						case "yes":
							$('#rpseolink').html("<span class=\"notification-input ni-error\">Đã tồn tại seolink này! Vui lòng nhập seolink khác</span>");
							frm_ship.check_seolink.value = "error";
							break;
						case "no":
							$('#rpseolink').html("<span class=\"notification-input ni-correct\">Bạn có thể sử dụng seolink này</span>");
							frm_ship.check_seolink.value = "";
							break;	
					}
				}
			});
		}else{
			document.getElementById("rpseolink").innerHTML = "<span class=\"notification-input ni-correct\">Hệ thống tự sinh seolink</span>";
		}
	}
	
	
	
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
                <form id="frm_ship" action="index.php?mod=ship&act=process_edit&ship_id=<?php echo $ship_id;?>" method="post">
                	 <p>
                        <label>Tên địa điểm</label>
                        <input id="add" name="add" type="text" class="input-medium" value="<?php if(isset($add)) echo $add; ?>" />
                        <span id = "rpadd" style="font-style:italic; font-size:11px; color:#CCC">Nhập tên của địa điểm</span>
                    </p>
                    
                    <p>
                         <label>Link thân thiện (có thể để trống)</label>
                        <input id="seolink" name="seolink" type="text" class="input-medium" value="<?php if(isset($seolink)) echo $seolink; ?>"/>
                        <span id = "rpseolink" style="font-style:italic; font-size:11px; color:#CCC">Nhập seolink (nếu bạn để trống hệ thống sẽ tự sinh)</span>
                        <input type="hidden" value="" id="check_seolink" />
                    </p>
                    <p>
                        <label>Giá vận chuyển</label>
                        <input id="fee" name="fee" type="text" class="input-medium" value="<?php if(isset($add)) echo $fee; ?>"/>
                        <span id = "rpfee" style="font-style:italic; font-size:11px; color:#CCC">Nhập vào giá vận chuyển</span>
                    </p>
                    <p>
                        <label>Lựa chọn danh mục cha</label>
                        <select name="parents" class="input-medium">
                            <option value="0">Danh mục gốc</option>
                            <?php
                                $result = mysql_query("SELECT * FROM tbl_shipping_fee where lang_id = $lang");
                                while($rows = mysql_fetch_array($result)){
                                    ?>
                                <option value="<?php echo $rows['id']?>" <?php if($rows['id']==$ro['level']) echo "selected = 'selected'";?>><?php echo $rows['add']?></option>	
                                    <?php
                                }
                            ?>
                        </select>
                    </p>                   
                    <fieldset>
                        <input class="submit-green" type="submit" value="Xác nhận" name="submit" /> 
                        <input class="submit-gray" type="submit" value="Quay lại" name="cancel" />
                    </fieldset>
                </form>
             </div> <!-- End .module-body -->

        </div>  <!-- End .module -->
        <div style="clear:both;"></div>
    </div> <!-- End .grid_12 -->
        
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->