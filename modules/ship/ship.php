<?php
if($_SESSION['ok']!=1){
	header('location: index.php?mod=member&act=login');
	break;
}	
if(!chk_permision())
	header('location: index.php?mod=member&act=error');	
	
$a = $_GET['act'];
switch($a){
	case "insert":
		include("modules/ship/insert.php");
		break;
	case "process_insert":
		include("modules/ship/process_insert.php");
		break;
	case "edit":
		include("modules/ship/edit.php");
		break;
	case "process_edit":
		include("modules/ship/process_edit.php");
		break;
	case "delete":
		include("modules/ship/delete.php");
		break;				
	case "list":
		include("modules/ship/list.php");
		break;	
	default:
		include("modules/ship/list.php");
		break;
}
?>