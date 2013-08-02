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
		include("modules/user/insert.php");
		break;
	case "process_insert":
		include("modules/user/process_insert.php");
		break;
	case "edit":
		include("modules/user/edit.php");
		break;
	case "process_edit":
		include("modules/user/process_edit.php");
		break;
	case "delete":
		include("modules/user/delete.php");
		break;				
	case "reset_pass":
		include("modules/user/reset_pass.php");
		break;
    case "re_active":
		include("modules/user/re_active.php");
		break;	
    case "list":
		include("modules/user/list.php");
		break;
    case "list_group":
		include("modules/user/list_group.php");
		break;
	case "insert_group":
		include("modules/user/insert_group.php");
		break;
	case "process_insert_group":
		include("modules/user/process_insert_group.php");
		break;
	case "edit_group":
		include("modules/user/edit_group.php");
		break;
	case "process_edit_group":
		include("modules/user/process_edit_group.php");
		break;
	case "delete_group":
		include("modules/user/delete_group.php");
		break;				
	default:
		include("modules/user/list.php");
		break;
}
?>