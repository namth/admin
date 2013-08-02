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
		include("modules/category/insert.php");
		break;
	case "process_insert":
		include("modules/category/process_insert.php");
		break;
	case "edit":
		include("modules/category/edit.php");
		break;
	case "process_edit":
		include("modules/category/process_edit.php");
		break;
	case "delete":
		include("modules/category/delete.php");
		break;				
	case "list":
		include("modules/category/list.php");
		break;	
	default:
		include("modules/category/list.php");
		break;
}
?>