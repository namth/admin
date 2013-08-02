<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors = array();
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
        if(empty($errors)){
            $q1 ="UPDATE  `default`.`tbl_customer` SET  `first_name` =  '{$firstname}',`last_name` =  '{$lastname}',`phone` =  '{$phone}',`add` =  '{$address}',`website` =  '{$website}',`yahoo` =  '{$yahoo}',`bio` =  '{$bio}',`user_level` =  {$userlevel}, `email` =  '{$email}' WHERE  id = {$c_id}";
            if(mysql_query($q1))
            	header("location: index.php?mod=customer&rp=1&ad=edit&mn=$c_id");
			else
				header('location: index.php?mod=customer&rp=2&ad=edit');
        }else{
            header('location: index.php?mod=customer&rp=3&ad=edit');
        }
            
    }else{
        
        $q1 ="UPDATE  `default`.`tbl_customer` SET  `user_level` =  {$userlevel} WHERE  id = {$c_id}";
        if(mysql_query($q1))
        	header("location: index.php?mod=customer&rp=1&ad=edit&mn=$c_id");
		else
			header('location: index.php?mod=customer&rp=2&ad=edit');
    }
}else if(isset($_POST['cancel'])){
    header('location: index.php?mod=customer');
}
?>