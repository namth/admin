<?php
ob_start();
session_start();

if(isset($_SESSION['lang'])){
	if(isset($_GET['lang']))
		$_SESSION['lang'] = $_GET['lang'];
}
else
	$_SESSION['lang'] = 1;
    
$lang = $_SESSION['lang'];

$module = $_GET['mod']?$_GET['mod']:'home';
include("includes/config.php");
include("includes/function.php");
include("includes/common.php");

include("modules/header/header.php");		
switch($module){	
	case 'home':
		include("modules/home/home.php");
		break;
	case 'category':
		include("modules/category/category.php");
		break;
	case 'product':
		include("modules/product/product.php");
		break;
	case 'news':
		include("modules/news/news.php");
		break;
	case 'ship':
		include("modules/ship/ship.php");
		break;
	case 'order':
		include("modules/order/order.php");
		break;		
	case 'comment':
		include("modules/comment/comment.php");
		break;				
	case 'image':
		include("modules/image/image.php");
		break;		
	case 'user':
		include("modules/user/user.php");
		break;
	case 'customer':
		include("modules/customer/customer.php");
		break;	
	case 'menu':
		include("modules/menu/menu.php");
		break;
	case 'member':
		include("modules/member/member.php");
		break;
	case 'setup':
		include("modules/setup/setup.php");
		break;
	default:
		include("modules/home/home.php");
		break;		
}
include("modules/footer/footer.php");
?>