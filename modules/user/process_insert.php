<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors = array();
    //Mac dinh cho cac truong nhap lieu la FALSE
    $phone = $address = $firstname = $lastname = $email = $password = FALSE;
    if(empty($_POST['username'])){
        $errors[] = "username";
    }else{
        $username = mysql_real_escape_string(strip_tags($_POST['username']));
    }
    
    if(empty($_POST['phone'])){
        $errors[] = "phone";
    }else{
        $phone = mysql_real_escape_string(strip_tags($_POST['phone']));
    }
    
    if(empty($_POST['add'])){
        $errors[] = "add";
    }else{
        $address = mysql_real_escape_string(strip_tags($_POST['add']));
    }
    
    
    //Kiem tra ho
    if(empty($_POST['firstname'])){
        $errors[] = "firstname";
    }else{
        $firstname = mysql_real_escape_string(strip_tags($_POST['firstname']));
    }

    //Kiem tra ten
    if(empty($_POST['lastname'])){
        $errors[] = "lastname";
    }else{
        $lastname = mysql_real_escape_string(strip_tags($_POST['lastname']));
    }
    
    if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $email = mysql_real_escape_string($_POST['email']);
    }else{
        $errors[] = 'email';
    }
    
    if(isset($_POST['password'])){
        if($_POST['password'] == $_POST['confirm']){
            //Neu 2 mat khau trung nhau thi luu vao bien
            $password = md5($_POST['password']);
        }else{
            //Neu mat khau khong phu hop voi nhau
            $errors[] = "confirm";
        }
    }else{
        $errors[] = "password";
    }
    //Kiem tra cap do thanh vien
    if(isset($_POST['userlevel'])){
        $userlevel = $_POST['userlevel'];
    }else{
        $errors[] = "userlevel";
    }
    foreach($errors as $check)
        echo $check;
    if(empty($errors)){
        $q = "SELECT * FROM tbl_user WHERE email='{$email}' or username='{$username}'";
        $r = mysql_query($q);
        if(mysql_affected_rows($conn)==0){
            
            $today = date("F j, Y, g:i a"); 
            $rand = rand_string(8);
            $rk = $email.$key.$today.$rand;
            $active = md5($rk);
            
            //Chen gia tri vao csdl
           
            $q1 = "INSERT INTO `default`.`tbl_user` (`username`, `first_name`, `last_name`, `email`, `password`, `group_user_id`, `active`, `reg_date`, `phone`, `add`, user_id) VALUES ('{$username}', '{$firstname}', '{$lastname}', '{$email}', '{$password}', '{$userlevel}', '{$active}', NOW(), '{$phone}', '{$address}', {$_SESSION['uid']} )";
            $r1 = mysql_query($q1);
            if(mysql_affected_rows($conn) == 1){
                echo 'Register successful!<br />';
            	$to      = $email;
            	$subject = "Kích hoạt tài khoản dang ký tài $sitename!";
            	$message = "Email này được gửi từ $sitename vì có thể bạn đã đăng ký thành viên. \n 
            				Hãy click vào link sau đây kích hoạt tài khoản:\n					
            				$sitepath/index.php?mod=user&act=active&email=$e&resetkey=$resetkey \n
            				Nếu dó thật sự là yêu cêuu của bạn!";			
            	$headers = "From: $sitename<$emailadmin>" . "\r\n" .
            		"Reply-To: $e" . "\r\n" .
            		'X-Mailer: PHP/' . phpversion();			
            	$chk = mail($to, $subject, $message, $headers);
            	if($chk)
                    header("location: index.php?mod=user&rp=1&ad=ins&e=1&mn=$email");
            	else
         		    header("location: index.php?mod=user&rp=1&ad=ins&e=2&mn=$email");
                
            }else{
                header("location: index.php?mod=user&rp=1&ad=ins&e=4&mn=$email");
            }
        }else{
            header("location: index.php?mod=user&rp=1&ad=ins&e=3&mn=$email");
        }
    } else{
        //Neu mot trong so cac truong bi thieu du lieu thi bao ra ngoai
        header("location: index.php?mod=user");
    }
}
?>