<?php 
    if(($_SERVER['REQUEST_METHOD'] == 'POST')&& isset($_POST['submit'])){
        if(empty($_POST['menu_name'])){
            $errors[] = "menu_name";
        }else{
            $menu_name = mysql_real_escape_string(strip_tags($_POST['menu_name']));
        }
        if(empty($errors)){
            $q = "INSERT INTO tbl_link(name,position,type) VALUES ('{$menu_name}',0,'image')";
            if(mysql_query($q))
            	header("location: index.php?mod=image&rp=1&ad=ins&mn=$menu_name");
			else
				header('location: index.php?mod=image&rp=2&ad=ins');
        }else{
            header('location: index.php?mod=image&rp=3&ad=ins');
        }
    }elseif(isset($_POST['cancel'])){
        header('location: index.php?mod=image');
    }
?>