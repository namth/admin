<?php
$c_id = $_GET['c_id']?$_GET['c_id']:0;
$rs_cus = mysql_query("select email from tbl_customer where id = $c_id");
$ro_cus = mysql_fetch_array($rs_cus);
$email = $ro_cus['email']; 

$today = date("F j, Y, g:i a"); 
$rand = rand_string(8);
$rk = $email.$key.$today.$rand;
$active = md5($rk);

//Chen gia tri vao csdl

$q1 ="UPDATE  `default`.`tbl_customer` SET  `active` =  '{$active}' WHERE  `tbl_customer`.`id` ={$c_id}";
$r1 = mysql_query($q1);
if(mysql_affected_rows($conn) == 1){
    echo 'Register successful!<br />';
	$to      = $email;
	$subject = "K�ch ho?t t�i kho?n dang k� t�i $sitename!";
	$message = "Email n�y du?c g?i t? $sitename v� c� th? b?n d� dang k� th�nh vi�n. \n 
				H�y click v�o link sau d�y k�ch ho?t t�i kho?n:\n					
				$sitepath/index.php?mod=customer&act=active&email=$e&resetkey=$resetkey \n
				N?u d� th?t s? l� y�u c�uu c?a b?n!";			
	$headers = "From: $sitename<$emailadmin>" . "\r\n" .
		"Reply-To: $e" . "\r\n" .
		'X-Mailer: PHP/' . phpversion();			
	$chk = mail($to, $subject, $message, $headers);
	if($chk)
        header("location: index.php?mod=customer&act=edit&rp=1&ad=active&c_id=$c_id&mn=$email");
	else
	    header("location: index.php?mod=customer&act=edit&rp=2&ad=active&c_id=$c_id&mn=$email");
    
}else{
    header("location: index.php?mod=customer&act=edit&rp=3&ad=active&c_id=$c_id&mn=$email");
}
?>