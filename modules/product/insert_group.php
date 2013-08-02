<script language = "javascript">
$(document).ready(function() { 
	var name = $('#name');
	var seolink = $('#seolink');
	
	name.blur(validatename);
	seolink.blur(validateseolink);
	
	name.keyup(validatename);
	seolink.keyup(validateseolink);
	
	
	$('#add_cat').submit(function(){
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
				data: "seolink="+ seolink +"&mod=category",
				success: function(response){
					switch(response){
						case "yes":
							$('#rpseolink').html("<span class=\"notification-input ni-error\">Đã tồn tại seolink này! Vui lòng nhập seolink khác</span>");
							add_cat.check_seolink.value = "error";
							break;
						case "no":
							$('#rpseolink').html("<span class=\"notification-input ni-correct\">Bạn có thể sử dụng seolink này</span>");
							add_cat.check_seolink.value = "";
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
            <?php if(!empty($messages)) echo $messages; ?>  
            <span id="error"></span> 
                <div class="module">
                     <h2><span>Thêm danh mục</span></h2>
                     
                     <div class="module-body">
                        <form id="add_cat" action="index.php?mod=product&act=process_insert_group" method="post" name="frm_cat">
                        
                            <p>
                                <label>Tên danh mục</label>
                                <input id="name" name="category" type="text" class="input-medium" />
                                <span id = "rpname" style="font-style:italic; font-size:11px; color:#CCC">Nhập tên của danh mục</span>
                            </p>
                            
                            <p>
                                <label>Link thân thiện (có thể để trống)</label>
                                <input id="seolink" name="seolink" type="text" class="input-medium" />
                                <span id = "rpseolink" style="font-style:italic; font-size:11px; color:#CCC">Nhập seolink (nếu bạn để trống hệ thống sẽ tự sinh)</span>
                                <input type="hidden" value="" id="check_seolink" />
                            </p>
                                   
                                   
                            <p>
                                <label>Lựa chọn danh mục cha</label>
                                <select name="parents" class="input-medium">
                                    <option value="1">Danh mục gốc</option>
                                    <?php
                                       $result = mysql_query("SELECT * FROM tbl_category where lang_id = $lang and id <> 1 and grouptype = 1");
                                        while($rows = mysql_fetch_array($result)){
                                            ?>
                                        <option value="<?php echo $rows['id']?>"><?php echo $rows['name']?></option>	
                                            <?php
                                        }
                                    ?>
                                </select>
                            </p>
                            
                            <fieldset>
                                <input class="submit-green" type="submit" value="Xác nhận" name="submit" onClick="return checkname()"/> 
                                <input class="submit-gray" type="submit" value="Hủy" name="cancel" />
                            </fieldset>
                        </form>
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div> <!-- End .grid_12 -->
                
            <div style="clear:both;"></div>
        </div> <!-- End .container_12 -->