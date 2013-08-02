<?php
if(($_SERVER['REQUEST_METHOD'] == 'POST')&& isset($_POST['submit'])){
        $errors = array();
        //Kiem tra ten cua category
        if(empty($_POST['add'])){
            $errors[] = "add";
        }else{
            $add = mysql_real_escape_string(strip_tags($_POST['add']));
        }
        //Kiem tra seolink, neu khong nhap thi tu sinh ra, seolink khong duoc trung nhau
        if(empty($_POST['seolink'])){
            $seolink = link_convert($_POST['add']);
        }else{ 
            $seolink = link_convert(mysql_real_escape_string(strip_tags($_POST['seolink'])));
        }
        
        
        //Kiem tra danh muc cha cua danh muc hien tai
        if(isset($_POST['parents']) && filter_var($_POST['parents'], FILTER_VALIDATE_INT, array('min_range'=>0))){
            $parents = $_POST['parents'];
        }else{
            if($_POST['parents']==0) $parents=0;else $errors[] = "parents";
        }
        
        if(isset($_POST['fee'])&&filter_var($_POST['fee'], FILTER_VALIDATE_INT, array('min_range'=>0))){
            $price = mysql_real_escape_string($_POST['fee']);
        }else{
            $price = 0;
        }
        
        if(empty($errors)){
            $q = "INSERT INTO  `default`.`tbl_shipping_fee` ( `add` ,`level` ,`fee` ,`lang_id` ,`seolink`, user_id )VALUES ('{$add}',  {$parents},  {$price},  $lang,  '{$seolink}', {$_SESSION['uid']})";
            if(mysql_query($q))
            	header("location: index.php?mod=ship&rp=1&ad=ins&mn=$cat_name");
			else
				header('location: index.php?mod=ship&rp=2&ad=ins');
        }else{
            header('location: index.php?mod=ship&rp=3&ad=ins');
        }
    }elseif(isset($_POST['cancel'])){
        header('location: index.php?mod=ship');
    }
?>
