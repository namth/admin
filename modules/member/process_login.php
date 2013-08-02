<td>
<?php
$u = $_POST['username'];
$p = md5($_POST['password']);
//echo "$u - $p";
$str = "SELECT * FROM tbl_user WHERE username='$u' AND password= '{$p}'";

$result = mysql_query($str);
$rows = mysql_fetch_array($result);
if($rows){
	if($rows['active']!=""){
		header("location: index.php?mod=member&act=login&rp=3");
	}else{
		$_SESSION['ok'] = 1;	
		$_SESSION['user'] = $u;
		$_SESSION['uid'] = $rows['id'];
		$_SESSION['idgu'] = $rows['group_user_id'];
		header('location: index.php?mod=home');	
	}
		
}
else{
	header("location: index.php?mod=member&act=login&rp=2");
}
?>

