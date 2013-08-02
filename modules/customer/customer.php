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
		include("modules/customer/insert.php");
		break;
	case "process_insert":
		include("modules/customer/process_insert.php");
		break;
	case "edit":
		include("modules/customer/edit.php");
		break;
	case "process_edit":
		include("modules/customer/process_edit.php");
		break;
	case "delete":
		include("modules/customer/delete.php");
		break;				
	case "reset_pass":
		include("modules/customer/reset_pass.php");
		break;
    case "re_active":
		include("modules/customer/re_active.php");
		break;	
    case "list":
		include("modules/customer/list.php");
		break;
	default:
		include("modules/customer/list.php");
		break;
}
?>