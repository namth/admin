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
		include("modules/product/insert.php");
		break;
	case "process_insert":
		include("modules/product/process_insert.php");
		break;
	case "edit":
		include("modules/product/edit.php");
		break;
	case "process_edit":
		include("modules/product/process_edit.php");
		break;
	case "delete":
		include("modules/product/delete.php");
		break;				
	case "list":
		include("modules/product/list.php");
		break;	
		case "insert_group":
		include("modules/product/insert_group.php");
		break;
	case "process_insert_group":
		include("modules/product/process_insert_group.php");
		break;
	case "edit_group":
		include("modules/product/edit_group.php");
		break;
	case "process_edit_group":
		include("modules/product/process_edit_group.php");
		break;
	case "delete_group":
		include("modules/product/delete_group.php");
		break;				
	case "list_group":
		include("modules/product/list_group.php");
		break;	
	default:
		include("modules/product/list.php");
		break;
}
?>