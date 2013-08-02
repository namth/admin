<?php	
$a = $_GET['act'];
switch ($a){
	case 'login':
		include('modules/member/login.php');
		break;
	case 'process_login':
		include('modules/member/process_login.php');
		break; 
	case 'logout':
		include('modules/member/logout.php');
		break;	
	case 'error':
		include('modules/member/error.php');
		break;
	case 'edit':
		include('modules/member/edit.php');
		break;
	case 'process_edit':
		include('modules/member/process_edit.php');
		break;			
	default:
		header('location: index.php');
		break;		
}
?>