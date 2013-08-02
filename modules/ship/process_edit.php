<?php
//Xac nhan bien GET ton tai va dung loai du lieu cho phep.
	if(isset($_GET['ship_id'])&& filter_var($_GET['ship_id'], FILTER_VALIDATE_INT, array('min_range'=>0))){
		$ship_id = $_GET['ship_id'];
	}else{
		?>
		<SCRIPT LANGUAGE="JavaScript">
		history.back();
		</SCRIPT>
		<?php
	}
	
	if(($_SERVER['REQUEST_METHOD'] == 'POST')&& isset($_POST['submit'])){
		$errors = array();
		//Kiem tra seolink, neu khong nhap thi tu sinh ra, seolink khong duoc trung nhau
		if(empty($_POST['add'])){
			$errors[] = "add";
		}else{
			$add = $_POST['add'];
		}
		
		
		 if(empty($_POST['seolink'])){
            $seolink = link_convert($_POST['add']);
        }else{ 
            $seolink = link_convert(mysql_real_escape_string(strip_tags($_POST['seolink'])));
        }
		//Kiem tra danh muc cha cua danh muc hien tai
		if(!isset($_POST['parents']) && filter_var($_POST['parents'], FILTER_VALIDATE_INT, array('min_range'=>0))){
			$errors[] = "parents";
		}else{
			$parents = $_POST['parents'];
		}
		
        if(isset($_POST['fee'])&&filter_var($_POST['fee'], FILTER_VALIDATE_INT, array('min_range'=>0))){
            $fee = mysql_real_escape_string($_POST['fee']);
        }else{
            $fee = 0;
        }
        
		if(empty($errors)){
            $q = "UPDATE  `default`.`tbl_shipping_fee` SET  `add` =  '{$add}',`level` =  {$parents},`fee` =  {$fee},`lang_id` =  $lang,`seolink` =  '{$seolink}', user_id = {$_SESSION['uid']}  WHERE  `tbl_shipping_fee`.`id` ={$ship_id}";
			if(mysql_query($q))
            	header("location: index.php?mod=ship&rp=1&ad=edit&mn=$ship_id");
			else
				header('location: index.php?mod=ship&rp=2&ad=edit');
        }else{
            header('location: index.php?mod=ship&rp=3&ad=edit');
        }
	}elseif(isset($_POST['cancel'])){
		header('location: index.php?mod=ship');
	}
?>
