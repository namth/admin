<?php
//Xac nhan bien GET ton tai va dung loai du lieu cho phep.
	if(isset($_GET['catid'])&& filter_var($_GET['catid'], FILTER_VALIDATE_INT, array('min_range'=>0))){
		$catid = $_GET['catid'];
	}else{
		?>
		<SCRIPT LANGUAGE="JavaScript">
		history.back();
		</SCRIPT>
		<?php
	}
	
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
		if(!isset($_POST['parents']) && filter_var($_POST['parents'], FILTER_VALIDATE_INT, array('min_range'=>0))){
			$errors[] = "parents";
		}else{
			$parents = $_POST['parents'];
		}
		
		if(empty($errors)){
		$q = "UPDATE tbl_category SET name='{$cat_name}', user_id=1, level={$parents}, seolink='{$seolink}', user_id = {$_SESSION['uid']} 
			  WHERE id={$catid} LIMIT 1";
		$r = mysql_query($q) or die("Query {$q} \n<br/> MySQL Error: " . mysqli_error($dbc));
		
			if(mysql_query($q))
            	header("location: index.php?mod=product&act=list_group&rp=1&ad=edit&mn=$catid");
			else
				header('location: index.php?mod=product&act=list_group&rp=2&ad=edit');
        }else{
            header('location: index.php?mod=product&act=list_group&rp=3&ad=edit');
        }
	}elseif(isset($_POST['cancel'])){
		header('location: index.php?mod=product&act=list_group');
	}
?>
