<?php
$u_id = $_GET['u_id']?$_GET['u_id']:0;
$rs_cus = mysql_query("select email from tbl_user where id = $u_id");
$ro_cus = mysql_fetch_array($rs_cus);
$email = $ro_cus['email']; 

$today = date("F j, Y, g:i a"); 
$rand = rand_string(8);
$rk = $email.$key.$today.$rand;
$active = md5($rk);

//Chen gia tri vao csdl

$q1 ="UPDATE  `default`.`tbl_user` SET  `active` =  '{$active}' WHERE  `tbl_user`.`id` ={$u_id}";
$r1 = mysql_query($q1);
if(mysql_affected_rows($conn) == 1){
    echo 'Register successful!<br />';
	$to      = $email;
	$subject = "Kích ho?t tài kho?n dang ký tài $sitename!";
	$message = "Email này du?c g?i t? $sitename vì có th? b?n dã dang ký thành viên. \n 
				Hãy click vào link sau dây kích ho?t tài kho?n:\n					
				$sitepath/index.php?mod=user&act=active&email=$e&resetkey=$resetkey \n
				N?u dó th?t s? là yêu cêuu c?a b?n!";			
	$headers = "From: $sitename<$emailadmin>" . "\r\n" .
		"Reply-To: $e" . "\r\n" .
		'X-Mailer: PHP/' . phpversion();			
	$chk = mail($to, $subject, $message, $headers);
	if($chk)
        header("location: index.php?mod=user&act=edit&rp=1&ad=active&u_id=$u_id&mn=$email");
	else
	    header("location: index.php?mod=user&act=edit&rp=2&ad=active&u_id=$u_id&mn=$email");
    
}else{
    header("location: index.php?mod=user&act=edit&rp=3&ad=active&u_id=$u_id&mn=$email");
}
?>