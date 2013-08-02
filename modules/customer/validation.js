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
		if(validateCheckEmail() & validateFirstname() & validateLastname() & validateLastname() & validateConfPass() & validatePhone() & validateAdd()){
			alert('Handler for .submit() called.');
			return true
		}else{
			alert('Handler.');
			return false;
		}
	});
	
	function validateCheckEmail(){
		var checkmail = $('#check_email').val();
		var email = $('#email').val();
		if(email == ""){
			document.getElementById("rpemail").innerHTML = "<span class=\"notification-input ni-error\">Email không được để trống</span>";
		}else{
			if(checkmail == "error")
				return false;
			else
				return true;
		}
	}
	
	function validateEmail(){
		var email = $('#email').val();
		$.ajax({
			type: "get",
			url: "<?php echo $sitepath; ?>admin/includes/email.php",
			data: "email="+ email,
			success: function(response){
				switch(response){
					case "yes":
						$('#rpemail').html("<span class=\"notification-input ni-error\">Đã tồn tại email này! Vui lòng nhập email khác</span>");
						add_customer.check_email.value = "error";
						break;
					case "notavail":
						$('#rpemail').html("<span class=\"notification-input ni-error\">Email không đúng định dạng</span>");
						add_customer.check_email.value = "error";
						break;
					case "no":
						$('#rpemail').html("<span class=\"notification-input ni-correct\">Bạn có thể dùng email này</span>");
						add_customer.check_email.value = "";
						break;
				}
			}
		});
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
		
})