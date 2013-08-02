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
		include("modules/order/insert.php");
		break;
	case "process_insert":
		include("modules/order/process_insert.php");
		break;
	case "edit":
		include("modules/order/edit.php");
		break;
	case "process_edit":
		include("modules/order/process_edit.php");
		break;
	case "delete":
		include("modules/order/delete.php");
		break;				
	case "list":
		include("modules/order/list.php");
		break;	
	default:
		include("modules/order/list.php");
		break;
}
?>