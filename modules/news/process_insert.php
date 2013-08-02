<?php
if(($_SERVER['REQUEST_METHOD'] == 'POST')&& isset($_POST['submit'])){
    $errors = array();
    $allowed = array('png', 'jpg', 'gif');
    $filename = NULL;
    //Kiem tra tieu de bai viet da nhap chua
    if(empty($_POST['post_title'])){
        $errors[] = "post_title";
    }else{
        $post_title = mysql_real_escape_string(strip_tags($_POST['post_title']));
        //Kiem tra seolink, neu khong nhap thi tu sinh ra, seolink khong duoc trung nhau
        if(empty($_POST['seolink'])){
            $seolink = link_convert($post_title);
            $q = "SELECT seolink FROM tbl_news WHERE seolink LIKE '{$seolink}%' AND id!={$nid}";
            $r = mysql_query($q);
            while($p = mysql_fetch_array($r)){
                $sl[] = $p['seolink'];
            }
            if(isset($sl)){
                for($i=sizeof($sl);;$i++){
                    $link = $seolink.'-'.$i;
                    if(!in_array($link,$sl)){
                        $seolink = $link;
                        break;
                    }
                }
            }
        }else{
            $seolink = link_convert(mysql_real_escape_string(strip_tags($_POST['seolink'])));
            $q = "SELECT seolink FROM tbl_news WHERE seolink LIKE '{$seolink}'";
            $r = mysql_query($q);
            while($p = mysql_fetch_array($r)){
                if($seolink == $p['seolink']){
                    $errors[]="seolink";
                    break;
                }
            }
        }
    }
    if(isset($_POST["catID"])){
        $catID = $_POST["catID"];
    } else {
        $errors[] = "catID";
    }
    //Kiem tra xem file anh da up dung khong, neu dung thi uploads len
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
    
    if(empty($_POST['post_content'])){
        $post_content = "";
    }else{
        $post_content = mysql_real_escape_string($_POST['post_content']);
    }
    
    
    foreach($errors as $category){
        echo "check".$category;
        
    }
    
    $check = true;
    if(empty($errors)){        
        $q1 = "INSERT INTO  tbl_news(use_id, lang_id, title, thumbnail, content, post_date , seolink) 
               VALUE ({$_SESSION['uid']}, $lang,'{$post_title}','{$filename}','{$post_content}', NOW(),'{$seolink}')";
        if(!mysql_query($q1))
            $check = false;
        //kiem tra danh muc duoc chon co cha khac 0 hay khong thi bo sung vao danh sach catID
        foreach($catID as $category){
            $q_cat = "SELECT * FROM tbl_category WHERE id={$category}";
            $r_cat = mysql_query($q_cat);
            $c = mysql_fetch_array($r_cat);
            if((!in_array($c['level'], $catID))&&($c['level'])) $catID[] = $c['level'];
        }
			
        $str_news = "SELECT * FROM `tbl_news` WHERE seolink = '".$seolink."'";
        $rs_news = mysql_query($str_news);
        $ro_news = mysql_fetch_array($rs_news);
        $new_add_id = $ro_news['id'];
        
        foreach($catID as $c){
            
            if((!in_array($c,$cat))||!(isset($cat))){
                $q = "INSERT INTO tbl_cat_new(new_id,category_id) VALUES ({$new_add_id},{$c})";
                echo $q;
                if(!mysql_query($q))
                    $check = false;
            }
        }
        
        $q1 = "INSERT INTO  tbl_news(use_id, lang_id, title, thumbnail, content, post_date , seolink) 
               VALUE (1, $lang,'{$post_title}','{$filename}','{$post_content}', NOW(),'{$seolink}')";
        if($check)
            header("location: index.php?mod=news&rp=1&ad=ins&mn=$post_title");
		else
			header('location: index.php?mod=news&rp=2&ad=ins');
    } else{
        header('location: index.php?mod=news&rp=3&ad=ins');
    }
}elseif(isset($_POST['cancel'])){
    header('location: index.php?mod=news');;
}
?>