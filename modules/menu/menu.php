<?php
if($_SESSION['ok']!=1){
	header('location: index.php?mod=member&act=login');
	break;
}	
if(!chk_permision())
	header('location: index.php?mod=member&act=error');	
	
$a = $_GET['act'];
switch($a){
	case "edit_level":
		include("modules/menu/edit_level.php");
		break;
	case "process_edit_level":
		include("modules/menu/process_edit_level.php");
		break;
	case "insert":
		include("modules/menu/insert.php");
		break;
	case "process_insert":
		include("modules/menu/process_insert.php");
		break;
	case "edit":
		include("modules/menu/edit.php");
		break;
	case "process_edit":
		include("modules/menu/process_edit.php");
		break;
	case "delete":
		include("modules/menu/delete.php");
		break;				
	case "list":
		include("modules/menu/list.php");
		break;	
	default:
		include("modules/menu/list.php");
		break;
}
?>