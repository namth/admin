<?php 
	//Xac nhan bien GET ton tai va dung loai du lieu cho phep.
	if(isset($_GET['child']) && filter_var($_GET['child'], FILTER_VALIDATE_INT, array('min_range'=>0))){
	$child = $_GET['child'];
	}else{
		?>
		<SCRIPT LANGUAGE="JavaScript">
		history.back();
		</SCRIPT>
		<?php
	}

	if(($_SERVER['REQUEST_METHOD'] == 'POST')&& isset($_POST['submit'])){
		$errors = array();
		$allowed = array('png', 'jpg', 'gif');//cac file duoc phep upload
		$filename = NULL;//default la null
		//Kiem tra ten cua menu con
		if(empty($_POST['link_name'])){
			$errors[] = "link_name";
		}else{
			$link_name = mysql_real_escape_string(strip_tags($_POST['link_name']));
		}
		//Kiem tra permalink
		if(empty($_POST['permalink'])){
			$permalink = "";
		}else{
			$permalink = link_convert(mysql_real_escape_string(strip_tags($_POST['permalink'])));
		}
		
		//Kiem tra xem da ton tai file anh chua
		$q = "SELECT imagename FROM fc_link WHERE linkID={$child}";
		$r = mysql_query($q);
		if(mysql_affected_rows($conn) == 1)
			list($image) = mysql_fetch_array($r);
		$filename = $image;
		
		//Kiem tra file anh duoc upload
		if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0){

			$extension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
			$filename = uniqid(rand(),true).".".$extension;
			if(!in_array(strtolower($extension), $allowed)){
				$messages = "<span class='notification n-error'>Hệ thống không hỗ trợ upload loại file này.</span>";
				exit;
			}
			if(!move_uploaded_file($_FILES['thumbnail']['tmp_name'], '../uploads/'.$filename)){
				$filename = NULL;
			}
		}
		
		//Neu khong co loi thi update du lieu
		if(empty($errors)){
			$q1 = "UPDATE tbl_link SET name='{$link_name}', permalink='{$permalink}',  image='{$filename}'
			  		WHERE id={$child} LIMIT 1";
			if(mysql_query($q1))
            	header("location: index.php?mod=menu&rp=1&ad=edit&mn=$nid");
			else
				header('location: index.php?mod=menu&rp=2&ad=edit');
		} else{
			header('location: index.php?mod=menu&rp=3&ad=edit');
		}
	}elseif(isset($_POST['cancel'])){
		header("location: index.php?mod=menu");
	}
	if(!empty($messages)) echo $messages; 
?>