<?php 
    $c_id = $_GET['c_id']?$_GET['c_id']:0;
    $rs_cus = mysql_query("select email from tbl_customer where id = $c_id");
    $ro_cus = mysql_fetch_array($rs_cus);
    $email = $ro_cus['email'];  
    $pass = rand_string(4)."-".rand_string(4)."-".rand_string(4)."-".rand_string(4);
    $password = md5($pass);
    $str = "UPDATE  `default`.`tbl_customer` SET  `pass` =  '{$password}' WHERE  `tbl_customer`.`id`={$c_id}";
    if(mysql_query($str)){
        echo 'Reset successful!<br />';
    	$to      = $email;
    	$subject = "Lấy lại mật khẩu từ $sitename!";
    	$message = "Email này được gửi từ $sitename vì có thể bạn đã yêu cầu khôi phục mật khẩu. \n 
    				Mật khẩu mới của bạn là: $pass\n";			
    	$headers = "From: $sitename<$emailadmin>" . "\r\n" .
    		"Reply-To: $e" . "\r\n" .
    		'X-Mailer: PHP/' . phpversion();			
    	$chk = mail($to, $subject, $message, $headers);
    	if($chk)
            header("location: index.php?mod=customer&act=edit&rp=1&ad=reset&c_id=$c_id&mn=$email");
    	else
 		    header("location: index.php?mod=customer&act=edit&rp=2&ad=reset&c_id=$c_id&mn=$email");
        
    }else{
        header("location: index.php?mod=customer&act=edit&rp=3&ad=reset&c_id=$c_id&mn=$email");
    }
?>