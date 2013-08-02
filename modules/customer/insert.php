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
	pass.blur(validatePass);
	confpass.blur(validateConfPass);
	phone.blur(validatePhone);
	add.blur(validateAdd);
	
	email.keyup(validateEmail);
	firstname.keyup(validateFirstname);
	lastname.keyup(validateLastname);
	pass.keyup(validatePass);
	confpass.keyup(validateConfPass);
	phone.keyup(validatePhone);
	add.keyup(validateAdd);
	
	$('#add_customer').submit(function(){
		if(validateCheckEmail() & validateFirstname() & validateLastname() & validateLastname() & validateConfPass() & validateConfPass() & validatePhone() & validateAdd()){
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
				data: "email="+ email,
				success: function(response){
					switch(response){
						case "yes":
							$('#rpemail').html("<span class=\"notification-input ni-error\">Đã tồn tại email này! Vui lòng nhập email khác</span>");
							add_customer.check_email.value = "error";
							return false;
							break;
						case "notavail":
							$('#rpemail').html("<span class=\"notification-input ni-error\">Email không đúng định dạng</span>");
							add_customer.check_email.value = "error";
							return false;
							break;
						case "no":
							$('#rpemail').html("<span class=\"notification-input ni-correct\">Bạn có thể dùng email này</span>");
							add_customer.check_email.value = "";
							return true;
							break;
					}
				}
			});
		}else{
			document.getElementById("rpemail").innerHTML = "<span class=\"notification-input ni-error\">Email không được để trống</span>";
			add_customer.check_email.value = "error";
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
		
	function validatePass(){
		var pass = $("#pass").val();
		if(pass.length < 6){
			document.getElementById("rppass").innerHTML = "<span class=\"notification-input ni-error\">Mật khẩu phải ít nhất 6 ký tự</span>";
			return false;
		}else{
			document.getElementById("rppass").innerHTML = "<span class=\"notification-input ni-correct\">Bạn có thể sủ dụng mật khẩu này</span>";
			return true;
		}
	}
	
	function validateConfPass(){
		var pass = $("#pass").val();
		var conf = $("#conf").val();
		if(pass == conf){
			document.getElementById("rpconf").innerHTML = "<span class=\"notification-input ni-correct\">Bạn đã nhập chính xác</span>";
			return true;
		}else{
			document.getElementById("rpconf").innerHTML = "<span class=\"notification-input ni-error\">Không trùng với mật khẩu bên trên</span>";
			return false;
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
        <div class="module">
             <h2><span>Thêm khách hàng</span></h2>
             
             <div class="module-body">
                <form id="add_customer" action="index.php?mod=customer&act=process_insert" method="post">
                
                    <p>
                        <label>Email: </label>
                        <input id="email" name="email" type="text" class="input-medium" />
                        <span id = "rpemail" style="font-style:italic; font-size:11px; color:#CCC">Nhập email đăng nhập website</span>
                        <input type="hidden" value="" id="check_email" />
                    </p>
                    <p>
                        <label>Mật khẩu: </label>
                        <input id="pass" name="password" type="password" class="input-medium" />
                        <span id = "rppass" style="font-style:italic; font-size:11px; color:#CCC">Nhập mật khẩu đăng nhập website</span>
                    </p>
                    
                    <p>
                        <label>Xác nhận mật khẩu: </label>
                        <input id="conf" name="confirm" type="password" class="input-medium" />
                        <span id = "rpconf" style="font-style:italic; font-size:11px; color:#CCC">Nhập lại mật khẩu</span>
                    </p>
					<p>
                        <label>Họ (và đệm): </label>
                        <input id="firstname" name="firstname" type="text" class="input-medium" />
                        <span id = "rpfirstname" style="font-style:italic; font-size:12px; color:#CCC">Nhập Họ và tên đệm</span>
                    </p>
                    
                    <p>
                        <label>Tên: </label>
                        <input id="lastname" name="lastname" type="text" class="input-medium" />
                        <span id = "rplastname" style="font-style:italic; font-size:11px; color:#CCC">Nhập tên gọi</span>
                    </p>
                    <p>
                        <label>Số điện thoại: </label>
                        <input id="phone" name="phone" type="text" class="input-medium" />
                        <span id = "rpphone" style="font-style:italic; font-size:11px; color:#CCC">Nhập số điện thoại liên lạc (homephone hoặc cellphone)</span>
                    </p>
                    <p>
                        <label>Địa chỉ: 
                        <span id = "rpadd" style="font-style:italic; font-size:11px; color:#CCC">Nhập địa chỉ liên lạc</span>
                        </label>
                        <textarea id="add" name="add"  class="input-long" rows="10"></textarea>
                    </p>
                    <p>
                        <label>Lựa chọn cấp độ khách hàng</label>
                        <select name="userlevel" class="input-medium">
                            <option value="0">Thông thường</option>
                            <option value="1">Vip bạc</option>
                            <option value="2">Vip vàng</option>
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