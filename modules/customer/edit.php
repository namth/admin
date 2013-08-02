<?php
    $c_id = $_GET['c_id']?$_GET['c_id']:0;
    $rs = mysql_query("select * from tbl_customer where id = '{$c_id}'");
    
    if(mysql_affected_rows($conn)>0){
        $ro = mysql_fetch_array($rs);
    }
    
    $permis = 1;
    if($permis == 1)
        $disable = "";
    else
        $disable = "disabled";

    $menu = $_GET['mn']?$_GET['mn']:"";
	$report = $_GET['rp']?$_GET['rp']:"";
	$act_details = $_GET['ad']?$_GET['ad']:"";
	switch($report){
		case "1":
            if($act_details == "reset")
			     $messages = report($report, "Thiết lại mật khẩu của  <b>{$menu}</b> thành công.");
            else
                 $messages = report($report, "Active lại $menu  <b>{$menu}</b> thành công.");
			break;
		case "2":
            if($act_details == "reset")
			     $messages = report(1, "Thiết lại mật khẩu của  <b>{$menu}</b> thành công.").report(2, "Không gửi được mail tới <b>{$menu}</b>!");
            else
                 $messages = report(2, "Không gửi được mail tới <b>{$menu}</b>!");
			break;
		case "3":
            if($act_details == "reset")
			     $messages = report($report, "Không thể thay đổi được của <b>{$menu}</b> mật khẩu do lỗi hệ thống vui lòng kiểm tra lại.");
            else
                 $messages = report($report, "Không thể active được tài khoản <b>{$menu}</b>. do lỗi hệ thống vui lòng kiểm tra lại.");
			break;
	}
?>
<script language = "javascript">
$(document).ready(function() { 

	var email = $('#email');
	var firstname = $('#firstname');
	var lastname = $('#lastname');
	var pass = $('#pass');
	var confpass = $('#conf');
	var phone = $('#phone');
	var add = $('#add');
	
	email.blur(validateEmail);
	firstname.blur(validateFirstname);
	lastname.blur(validateLastname);
	phone.blur(validatePhone);
	add.blur(validateAdd);
	
	email.keyup(validateEmail);
	firstname.keyup(validateFirstname);
	lastname.keyup(validateLastname);
	phone.keyup(validatePhone);
	add.keyup(validateAdd);
	
	$('#edit_customer').submit(function(){
		if(validateCheckEmail() & validateFirstname() & validateLastname() & validateLastname()  & validatePhone() & validateAdd()){
			return true
		}else{
			return false;
		}
	});
	
	function validateCheckEmail(){
		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
		var checkmail = $('#check_email').val();
		var email = $('#email').val();
		if(email == ""){
			
			return false;
		}else{
			if(filter.test(email)){
				if(email == '<?php echo $ro['email']?>')
					document.getElementById("rpemail").innerHTML = "<span class=\"notification-input ni-correct\">Giữ email cũ</span>";
				if(checkmail == "error")
					return false;
				else
					return true;	
			}else{
				document.getElementById("rpemail").innerHTML = "<span class=\"notification-input ni-error\">Email không đúng định dạng</span>";
				return false;
			}
			
		}
	}
	
	function validateEmail(){
		var email = $('#email').val();
		if(email != ""){
			$.ajax({
				type: "get",
				url: "<?php echo $sitepath; ?>admin/includes/email.php",
				data: "email="+ email +"&old=<?php echo $ro['email']?>",
				success: function(response){
					switch(response){
						case "yes":
							$('#rpemail').html("<span class=\"notification-input ni-error\">Đã tồn tại email này! Vui lòng nhập email khác</span>");
							edit_customer.check_email.value = "error";
							return false;
							break;
						case "notavail":
							$('#rpemail').html("<span class=\"notification-input ni-error\">Email không đúng định dạng</span>");
							edit_customer.check_email.value = "error";
							return false;
							break;
						case "old":
							$('#rpemail').html("<span class=\"notification-input ni-correct\">Giữ email cũ</span>");
							edit_customer.check_email.value = "error";
							return false;
							break;
						case "no":
							$('#rpemail').html("<span class=\"notification-input ni-correct\">Bạn có thể dùng email này</span>");
							edit_customer.check_email.value = "";
							return true;
							break;
					}
				}
			});
		}else{
			document.getElementById("rpemail").innerHTML = "<span class=\"notification-input ni-error\">Email không được để trống</span>";
			edit_customer.check_email.value = "error";
		}
	}
	
	function validateFirstname(){
		var firstname = $("#firstname").val();
		if(firstname == ""){
			document.getElementById("rpfirstname").innerHTML = "<span class=\"notification-input ni-error\">Họ(và đệm) không được để trống</span>";
			return false;
		}else{
			document.getElementById("rpfirstname").innerHTML = "<span class=\"notification-input ni-correct\">&nbsp;</span>";
			return true;
		}
	}
	
	function validateLastname(){
		var lastname = $("#lastname").val();
		if(lastname == ""){
			document.getElementById("rplastname").innerHTML = "<span class=\"notification-input ni-error\">Tên không được để trống</span>";
			return false;
		}else{
			document.getElementById("rplastname").innerHTML = "<span class=\"notification-input ni-correct\">&nbsp;</span>";
			return true;
		}
	}

	
	function validatePhone(){
		var phone = $("#phone").val();
		//re=/[0-9]/;
		//str=re.test(phone)
		if(phone != ""){
			if(isNaN(phone)){
				document.getElementById("rpphone").innerHTML = "<span class=\"notification-input ni-error\">Số điện thoại phải là số</span>"
				return false;
			}else{
				document.getElementById("rpphone").innerHTML = "<span class=\"notification-input ni-correct\">&nbsp;</span>";
				return true;	
			}	
		}else{
			document.getElementById("rpphone").innerHTML = "<span class=\"notification-input ni-error\">Số điện thoại không được để trống</span>";
			return false;
		}
	}

	function validateAdd(){
		var add = $("#add").val();
		if(add == ""){
			document.getElementById("rpadd").innerHTML = "<span class=\"notification-input ni-error\">Địa chỉ không được để trống</span>";
			return false;
		}else{
			document.getElementById("rpadd").innerHTML = "<span class=\"notification-input ni-correct\">&nbsp;</span>";
			return true;
		}
	}
		
});
</script>
<div class="container_12">

    <!-- Form elements -->    
    <div class="grid_12">
    <?php if(!empty($messages)) echo $messages; ?>   
    <div class="bottom-spacing">
            <!-- Button -->
            <div class="float-right" >
                <a href="?mod=customer&act=reset_pass&c_id=<?php echo $ro['id'];?>" class="button">
                    <span>Khôi phục mật khẩu <img src="images/notification-exclamation.gif" width="12" height="9" alt="New article" /></span>
                </a>
                <a href="?mod=customer&act=re_active&c_id=<?php echo $ro['id'];?>" class="button">
                    <span>Active lại tài khoản <img src="images/notification-tick.gif" width="12" height="9" alt="New article" /></span>
                </a>
            </div>
        </div>
        <div class="module">
             <h2><span>Sửa thông tin khách hàng</span></h2>
             <div class="module-body">
                <form id="edit_customer" action="index.php?mod=customer&act=process_edit&per=<?php echo $permis;?>&c_id=<?php echo $c_id;?>" method="post">
                
                    <p>
                        <?php
                         if(!empty($ro['avatar']))
                            echo "<img src='".$sitepath."uploads/{$ro['avatar']}' height='105' />";
                         else
                            echo "<img src='".$sitepath."uploads/noavatar.jpg' height='105' />";
                        ?>
                        
                    </p>
                    
                    <p>
                        <label>Email: </label>
                        <input id="email" name="email" type="text" class="input-medium" value="<?php echo $ro['email']?>" <?php echo $disable;?>  />
                        <span id = "rpemail" style="font-style:italic; font-size:11px; color:#CCC">Nhập email đăng nhập website</span>
                        <input type="hidden" value="" id="check_email" />
                    </p>
                    
					<p>
                        <label>Họ (và đệm): </label>
                        <input id="firstname" name="firstname" type="text" class="input-medium" value="<?php echo $ro['first_name']?>" <?php echo $disable;?>/>
                    	<span id = "rpfirstname" style="font-style:italic; font-size:12px; color:#CCC">Nhập Họ và tên đệm</span>
                    </p>
                    
                    <p>
                        <label>Tên: </label>
                        <input id="lastname" name="lastname" type="text" class="input-medium" value="<?php echo $ro['last_name']?>" <?php echo $disable;?>/>
                        <span id = "rplastname" style="font-style:italic; font-size:11px; color:#CCC">Nhập tên gọi</span>
                    </p>

                    </p>
                    <p>
                        <label>Số điện thoại: </label>
                        <input id="phone" name="phone" type="text" class="input-medium" value="<?php echo $ro['phone']?>" <?php echo $disable;?>/>
                    	<span id = "rpphone" style="font-style:italic; font-size:11px; color:#CCC">Nhập số điện thoại liên lạc (homephone hoặc cellphone)</span>
                    </p>
                    <p>
                        <label>Địa chỉ:  <span id = "rpadd" style="font-style:italic; font-size:11px; color:#CCC">Nhập địa chỉ liên lạc</span></label>
                        <textarea id="add" name="add"  class="input-long" rows="10" <?php echo $disable;?>><?php echo $ro['add']?></textarea>
                    </p>
                    
                    <p>
                        <label>Yahoo: </label>
                        <input name="yahoo" type="text" class="input-long" value="<?php echo $ro['yahoo']; ?>" <?php echo $disable;?>/>
                    </p>
                    
                    <p>
                        <label>Website: </label>
                        <input name="website" type="text" class="input-long" value="<?php echo $ro['website']; ?>" <?php echo $disable;?>/> 
                    </p>
                    <p>
                        <label>Năng lực: </label>
                        <input name="bio" type="text" class="input-long" value="<?php echo $ro['bio']; ?>" <?php echo $disable;?> <?php echo $disable;?>/> 
                    </p>
                    
                    <p>
                        <label>Lựa chọn cấp độ khách hàng</label>
                        <select name="userlevel" class="input-long">
                            <option value="0" <?php if($ro['user_level']==0) echo "selected";?>>Thông thường</option>
                            <option value="1" <?php if($ro['user_level']==1) echo "selected";?>>Vip bạc</option>
                            <option value="2" <?php if($ro['user_level']==2) echo "selected";?>>Vip vàng</option>
                        </select>
                    </p>
                    <fieldset>
                        <input class="submit-green" type="submit" value="Xác nhận" name="submit" />
                        <input class="submit-gray" type="submit" value="Hủy" name="cancel" />
                    </fieldset>
                </form>
             </div> <!-- End .module-body -->

        </div>  <!-- End .module -->
		<div style="clear:both;"></div>
    </div> <!-- End .grid_12 -->
        
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->