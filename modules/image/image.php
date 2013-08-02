<?php
if($_SESSION['ok']!=1){
	header('location: index.php?mod=member&act=login');
	break;
}	
if(!chk_permision())
	header('location: index.php?mod=member&act=error');	
$a = $_GET['act'];
switch($a){
	case "upload":
		include("modules/image/upload.php");
		break;
	case "process_upload":
		include("modules/image/process_upload.php");
		break;
	case "delete":
		include("modules/image/delete.php");
		break;
	case "delete_level":
		include("modules/image/delete_level.php");
		break;
	case "insert":
		include("modules/image/insert.php");
		break;
	case "process_insert":
		include("modules/image/process_insert.php");
		break;
	case "list":
		include("modules/image/list.php");
		break;	
	default:
		include("modules/image/list.php");
		break;
}
?>