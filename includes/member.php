<?php
include("config.php");
include("function.php");
include("common.php");
$html="no";
if(isset($_GET['username'])){
	$old = $_GET['old']?$_GET['old']:"";
	$username = mysql_real_escape_string($_GET['username']);
	
	if($old != $username){
		$q = "SELECT username FROM tbl_user WHERE username LIKE '{$username}%'";
		$r = mysql_query($q);
		while($u = mysql_fetch_array($r)){
			if($username == $u['username']){
				$html =  "yes";
			}
		}
		
	}else{
		$html="old";
	}
	
    echo $html;
}

?>