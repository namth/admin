<?php 
include("../../includes/config.php");
include("../../includes/function.php");
include("../../includes/common.php");

$array	= $_POST['arrayorder'];

if ($_POST['update'] == "update"){
	
	$count = 1;
	$check = true;
	foreach ($array as $idval) {
		$query = "UPDATE tbl_link SET position = " . $count . " WHERE id = " . $idval;
		if(!mysql_query($query))
			$check = false;
		$count ++;
	}
	
	if($check)
		echo 'Đã lưu thứ tự mới vào cơ sở dữ liệu';
	else 
		echo 'Lỗi truy cập csdl';
}
?>