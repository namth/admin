<?php
if(($_SERVER['REQUEST_METHOD'] == 'POST')&& isset($_POST['submit'])){
        $errors = array();
        //Kiem tra ten cua category
        if(empty($_POST['category'])){
            $errors[] = "category";
        }else{
            $cat_name = mysql_real_escape_string(strip_tags($_POST['category']));
        }
        //Kiem tra seolink, neu khong nhap thi tu sinh ra, seolink khong duoc trung nhau
        if(empty($_POST['seolink'])){
            $seolink = link_convert($_POST['category']);
        }else{ 
            $seolink = link_convert(mysql_real_escape_string(strip_tags($_POST['seolink'])));
        }
        
        
        //Kiem tra danh muc cha cua danh muc hien tai
        if(isset($_POST['parents']) && filter_var($_POST['parents'], FILTER_VALIDATE_INT, array('min_range'=>0))){
            $parents = $_POST['parents'];
        }else{
            if($_POST['parents']==0) $parents=0;else $errors[] = "parents";
        }
        
        if(empty($errors)){
			if($parents == 1){
				$q = "INSERT INTO tbl_category (name, lang_id, user_id, level, seolink, grouptype) VALUES ('{$cat_name}', $lang, {$_SESSION['uid']}, {$parents}, '{$seolink}', 1)";	
			}else if($parents == 2){
				$q = "INSERT INTO tbl_category (name, lang_id, user_id, level, seolink, grouptype) VALUES ('{$cat_name}', $lang, 1, {$parents}, '{$seolink}', 2)";	
			}else{
           	 	$q = "INSERT INTO tbl_category (name, lang_id, user_id, level, seolink) VALUES ('{$cat_name}', $lang, 1, {$parents}, '{$seolink}')";
			}
            if(mysql_query($q))
            	header("location: index.php?mod=category&rp=1&ad=ins&mn=$cat_name");
			else
				header('location: index.php?mod=category&rp=2&ad=ins');
        }else{
            header('location: index.php?mod=category&rp=3&ad=ins');
        }
    }elseif(isset($_POST['cancel'])){
        header('location: index.php?mod=category');
    }
?>
