<?php
if($_SESSION['ok']!=1){
	header('location: index.php?mod=member&act=login');
	break;
}	
if(!chk_permision())
	header('location: index.php?mod=member&act=error');	
	
$a = $_GET['act'];
switch($a){
	case "delete":
		include("modules/comment/delete.php");
		break;				
	case "list":
		include("modules/comment/list.php");
		break;	
	default:
		include("modules/comment/list.php");
		break;
}
?>