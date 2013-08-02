<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors = array();
    $allowed = array('png', 'jpg', 'gif');
    $filename = NULL;
    //Mac dinh cho cac truong nhap lieu la FALSE
    $permis = $_GET['per']?$_GET['per']:0;
    $c_id = $_GET['c_id']?$_GET['c_id']:0;
    if(isset($_POST['userlevel'])){
        $userlevel = $_POST['userlevel'];
    }else{
        $errors[] = "userlevel";
    }
    if($permis == 1){
        $phone = $address = $firstname = $lastname = $email = $password = FALSE;
    
        if(empty($_POST['website'])){
            $website = "";
        }else{
            $website = mysql_real_escape_string(strip_tags($_POST['website']));
        }
        
        if(empty($_POST['yahoo'])){
            $yahoo = "";
        }else{
            $yahoo = mysql_real_escape_string(strip_tags($_POST['yahoo']));
        }
        
        if(empty($_POST['bio'])){
            $bio = "";
        }else{
            $bio = mysql_real_escape_string(strip_tags($_POST['bio']));
        }
        
        if(empty($_POST['phone'])){
            $errors[] = "phone";
        }else{
            $phone = mysql_real_escape_string(strip_tags($_POST['phone']));
        }
        
        if(empty($_POST['add'])){
            $errors[] = "add";
        }else{
            $address = mysql_real_escape_string(strip_tags($_POST['add']));
        }
        //Kiem tra ho
        if(empty($_POST['firstname'])){
            $errors[] = "firstname";
        }else{
            $firstname = mysql_real_escape_string(strip_tags($_POST['firstname']));
        }
    
        //Kiem tra ten
        if(empty($_POST['lastname'])){
            $errors[] = "lastname";
        }else{
            $lastname = mysql_real_escape_string(strip_tags($_POST['lastname']));
        }
        
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $email = mysql_real_escape_string($_POST['email']);
        }else{
            $errors[] = 'email';
        }
        
        
        //Kiem tra xem file anh da up dung khong, neu dung thi uploads len
        if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0){
    
        	$extension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
            $filename = uniqid(rand(),true).".".$extension;
        
        	if(!in_array(strtolower($extension), $allowed)){
        		$messages = "<span class='notification n-error'>H? th?ng không h? tr? upload lo?i file này.</span>";
        		exit;
        	}
        
        	if(!move_uploaded_file($_FILES['thumbnail']['tmp_name'], '../uploads/'.$filename)){
        	    $filename = NULL;
        	}
        }
    
        foreach($errors as $check)
            echo $check;
         
        if(empty($errors)){
            if($filename != null)
                $q1 = "UPDATE  `default`.`tbl_user` SET  `first_name` =  '{$firstname}',`last_name` =  '{$lastname}',`email` =  '{$email}',`website` =  '{$website}',`yahoo` =  '{$yahoo}',`bio` =  '{$bio}',`avatar` =  '{$filename}',`group_user_id` =  {$userlevel},`phone` =  '{$phone}',`add` =  '{$address}', user_id = {$_SESSION['uid']} WHERE  id = {$c_id}";
            else
                $q1 = "UPDATE  `default`.`tbl_user` SET  `first_name` =  '{$firstname}',`last_name` =  '{$lastname}',`email` =  '{$email}',`website` =  '{$website}',`yahoo` =  '{$yahoo}',`bio` =  '{$bio}',`group_user_id` =  {$userlevel},`phone` =  '{$phone}',`add` =  '{$address}', user_id = {$_SESSION['uid']}  WHERE  id = {$c_id}";
            
			echo $q1;
            
            if(mysql_query($q1))
            	header("location: index.php?mod=user&rp=1&ad=edit&mn=$c_id");
			else
				header('location: index.php?mod=user&rp=2&ad=edit');
        }else{
            header('location: index.php?mod=user&rp=3&ad=edit');
        }
            
    }else{
        
        $q1 ="UPDATE  `default`.`tbl_user` SET  `group_user_id` =  {$userlevel} WHERE  id = {$c_id}";
        if(mysql_query($q1))
        	header("location: index.php?mod=user&rp=1&ad=edit&mn=$c_id");
		else
			header('location: index.php?mod=user&rp=2&ad=edit');
    }
}else if(isset($_POST['cancel'])){
    header('location: index.php?mod=user');
}
?>