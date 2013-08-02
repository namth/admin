<?php
include("config.php");
include("function.php");
include("common.php");
$html="no";
if(isset($_GET['email'])){
	$old = $_GET['old']?$_GET['old']:"";
	
	if(filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)){
        $email = mysql_real_escape_string($_GET['email']);
    }else{
        $email = "notavail";
    }
	
	if($email != "notavail"){
		if($old != $email){
			$q_cus = "SELECT email FROM tbl_customer WHERE email LIKE '{$email}%'";
			$r_cus = mysql_query($q_cus);
			while($e_cus = mysql_fetch_array($r_cus)){
				if($email == $e_cus['email']){
					$html =  "yes";
				}
			}
			
			$q_user = "SELECT email FROM tbl_user WHERE email LIKE '{$email}%'";
			$r_user = mysql_query($q_user);
			while($e_user = mysql_fetch_array($r_user)){
				if($email == $e_user['email']){
					$html =  "yes";
				}
			}
			
		}else{
			$html="old";
		}
	}else{
		$html = "notavail";	
	}
	
    echo $html;
}
?>