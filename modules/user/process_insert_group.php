<?php
if(($_SERVER['REQUEST_METHOD'] == 'POST')&& isset($_POST['submit'])){
    $errors = array();
    $allowed = array('png', 'jpg', 'gif');
    $filename = NULL;

   
    if(isset($_POST["name"])){
        $name = mysql_real_escape_string($_POST["name"]);
    } else { 
        $errors[] = "name"; 
    }
	
    
    if(empty($_POST['sumary'])){
        $sumary = "";
    }else{
        $sumary = mysql_real_escape_string($_POST['sumary']);
    }
	
	if(empty($_POST['detail'])){
        $detail = "";
    }else{
        $detail = mysql_real_escape_string($_POST['detail']);
    }
    
    
	if(isset($_POST["module"])){
        $module = $_POST["module"];
    } else {
        $errors[] = "catID";
    }
	
    foreach($errors as $a)
		echo $a."<br>".$_POST["name"];
	
	
    if(empty($errors)){
        $check = true;
        $q1 = "INSERT INTO `default`.`tbl_group_user` (`name`, `sumary`, `detail`, user_id) VALUES ('{$name}', '{$sumary}', '{$detail}', {$_SESSION['uid']} )";
		echo $q1;
        if(!mysql_query($q1))
            $check = false;
			
		//kiem tra danh muc duoc chon co cha khac 0 hay khong thi bo sung vao danh sach catID
		foreach($module as $mod){
			$q = "SELECT * FROM tbl_link WHERE id={$mod}";
			$r = mysql_query($q);
			$c = mysql_fetch_array($r);
			if((!in_array($c['level'], $module))&&($c['level'])) $module[] = $c['level'];
		}
        
        $str_group = "SELECT * FROM `tbl_group_user` WHERE name = '".$name."'";
        $rs_group = mysql_query($str_group);
        $ro_group = mysql_fetch_array($rs_group);
        $group_id = $ro_group['id'];
        foreach($module as $m){
			$q = "INSERT INTO `default`.`tbl_permision` (`group_user_id`, `modules_id`) VALUES ({$group_id}, '{$m}');";
			echo $q;
			if(!mysql_query($q))
				$check = false;
				
        }
        
		if($check)
            header("location: index.php?mod=user&act=list_group&rp=1&ad=ins&mn=$name");
		else
			header('location: index.php?mod=user&act=list_group&rp=2&ad=ins');
    } else{
        header('location: index.php?mod=user&act=list_group&rp=3&ad=ins');
    }
}elseif(isset($_POST['cancel'])){
    header('location: index.php?mod=user&act=list_group');;
}
?>