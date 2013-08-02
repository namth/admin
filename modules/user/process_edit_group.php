<?php
if(($_SERVER['REQUEST_METHOD'] == 'POST')&& isset($_POST['submit'])){
    $errors = array();
    $allowed = array('png', 'jpg', 'gif');
    $filename = NULL;

	$ug_id = $_GET['ug_id']?$_GET['ug_id']:0;
   
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
        $errors[] = "module";
    }
	
	foreach($errors as $category){
        echo "check".$category;
        
    }
    
    if(empty($errors)){
        $check = true;			
		$q1 = "UPDATE  `default`.`tbl_group_user` SET  `name` =  '{$name}',`sumary` =  '{$sumary}',`detail` =  '$detail', user_id = {$_SESSION['uid']}  WHERE  `tbl_group_user`.`id` ={$ug_id}";
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
        
        //Xu ly update danh muc bai viet
        $q = "SELECT modules_id FROM tbl_permision WHERE group_user_id = {$ug_id}";
        $r = mysql_query($q);
        //Neu danh muc cu khong duoc chon thi se xoa khoi bang cat_posts
        while($c = mysql_fetch_array($r)){
            if(!in_array($c['modules_id'],$module)){
                $q2 = "DELETE FROM tbl_permision WHERE group_user_id={$ug_id} AND modules_id={$c['modules_id']}";
				echo $q2;
                mysql_query($q2);
            }            
            $cat[] = $c['modules_id'];
        }
    
        //Neu danh muc moi duoc chon thi se them vao bang cat_posts            
        foreach($module as $c){
            if((!in_array($c,$cat))||!(isset($cat))){
                $q3 = "INSERT INTO tbl_permision(group_user_id,modules_id) VALUES ({$ug_id},{$c})";
                echo $q3;
                if(!mysql_query($q3))
					$check = false;
            }
        }
		
		if($check)
            header("location: index.php?mod=user&act=list_group&rp=1&ad=edit&mn=$name");
		else
			header('location: index.php?mod=user&act=list_group&rp=2&ad=edit');
    } else{
    	header('location: index.php?mod=user&act=list_group&rp=3&ad=edit');
    }
}elseif(isset($_POST['cancel'])){
    header('location: index.php?mod=user&act=list_group');;
}
?>