<?php
if($_SESSION['ok']!=1){
	header('location: index.php?mod=member&act=login');
	break;
}	
if(!chk_permision())
	header('location: index.php?mod=member&act=error');		
$a = $_GET['act'];
switch($a){
	case "edit":
		include("modules/setup/edit.php");
		break;
	case "process_edit":
		include("modules/setup/process_edit.php");
		break;
	default:
		include("modules/setup/edit.php");
		break;
}
?>