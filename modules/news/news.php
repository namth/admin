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
		include("modules/news/insert.php");
		break;
	case "process_insert":
		include("modules/news/process_insert.php");
		break;
	case "edit":
		include("modules/news/edit.php");
		break;
	case "process_edit":
		include("modules/news/process_edit.php");
		break;
	case "delete":
		include("modules/news/delete.php");
		break;				
	case "list":
		include("modules/news/list.php");
		break;	
		case "insert_group":
		include("modules/news/insert_group.php");
		break;
	case "process_insert_group":
		include("modules/news/process_insert_group.php");
		break;
	case "edit_group":
		include("modules/news/edit_group.php");
		break;
	case "process_edit_group":
		include("modules/news/process_edit_group.php");
		break;
	case "delete_group":
		include("modules/news/delete_group.php");
		break;				
	case "list_group":
		include("modules/news/list_group.php");
		break;	
	default:
		include("modules/news/list.php");
		break;
}
?>