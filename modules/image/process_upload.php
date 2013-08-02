<?php
// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip','pdf','xlsx','xls','doc','docx');

if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0){

	$extension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
    $filename = uniqid(rand(),true).".".$extension;

	if(!in_array(strtolower($extension), $allowed)){
		echo 'Hệ thống không hỗ trợ upload loại file này.';
		exit;
	}

	if(move_uploaded_file($_FILES['thumbnail']['tmp_name'], '../uploads/'.$filename)){
	   $q = "INSERT INTO tbl_link(name, lang_id, image, level, position, type) 
              VALUES ('{$filename}', 1, '{$filename}', 0, 0, 'images')";
        $r = mysql_query($q);
        if(mysql_affected_rows($r) == 1){
            $messages = "<span class='notification n-success'>Upload ảnh thành công.</span>";
        }else{
            $messages = "<span class='notification-input ni-error'>Upload thành công nhưng không update được vào CSDL.</span>";
        }
	}
}
if(isset($_FILES['thumbnail']['tmp_name'])&& is_file($_FILES['thumbnail']['tmp_name'])&&file_exists($_FILES['thumbnail']['tmp_name'])){
    unlink($_FILES['thumbnail']['tmp_name']);
}

echo '{"status":"error"}';
exit;