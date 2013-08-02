<?php
$nid = $_POST['news_id']?$_POST['news_id']:0;
//Doc truoc du lieu ra bien de su dung
$q_post = "SELECT * FROM tbl_news WHERE id='{$nid}'";
$r_post = mysql_query($q_post);
$post = mysql_fetch_array($r_post);
//if(is_string($post)) redirect_to('css-admin/view_post.php');

if(($_SERVER['REQUEST_METHOD'] == 'POST')&& isset($_POST['submit'])){
    $errors = array();
    $filename = NULL;
    $allowed = array('png', 'jpg', 'gif');
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
                //Them so thu tu vao sau seolink va kiem tra xem co trong mang da select hay chua
                for($i=sizeof($sl);;$i++){
                    $link = $seolink.'-'.$i;
                    //Neu chua co trong mang da select thi chon va nhay ra khoi vong lap
                    if(!in_array($link,$sl)){
                        $seolink = $link;
                        break;
                    }
                }
            }
        }else{
            //Neu seolink do nguoi dung nhap vao thi kiem tra xem no da ton tai chua
            //Neu da ton tai thi bao loi ra cho nguoi dung
            $seolink = link_convert(mysql_real_escape_string(strip_tags($_POST['seolink'])));
            $q = "SELECT seolink FROM tbl_news WHERE seolink LIKE '{$seolink}%' AND id!={$nid}";
            $r = mysql_query($q);
            while($p = mysql_fetch_array($r)){
                if($seolink == $p['seolink']){
                    //$errors[]="seolink";
                    break;
                }
            }
        }
    }
    //Kiem tra xem category co hop le khong
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
    		$messages = "<span class='notification n-error'>H? th?ng không h? tr? upload lo?i file này.H? th?ng không h? tr? upload lo?i file này.</span>";
    		exit;
    	}
    
    	if(!move_uploaded_file($_FILES['thumbnail']['tmp_name'], '../uploads/'.$filename)){
    	    $filename = NULL;
    	}
    }
        
    if(empty($_POST['post_content'])){
        $post_content = "";
    }else{
        $post_content = $_POST['post_content'];
    }
	
	foreach($errors as $a)
		echo $a;
    
    if(empty($errors)){
        //kiem tra danh muc duoc chon co cha khac 0 hay khong thi bo sung vao danh sach catID
        foreach($catID as $category){
            $q_cat = "SELECT * FROM tbl_category WHERE id={$category}";
            $r_cat = mysql_query($q_cat);
            $c = mysql_fetch_array($r_cat);
            if((!in_array($c['level'], $catID))&&($c['level'])) $catID[] = $c['level'];
        }
        
        //Xu ly update danh muc bai viet
        $q = "SELECT category_id FROM tbl_cat_new WHERE new_id = {$nid}";
        $r = mysql_query($q);
        //Neu danh muc cu khong duoc chon thi se xoa khoi bang cat_posts
        while($c = mysql_fetch_array($r)){
            if(!in_array($c['category_id'],$catID)){
                $q1 = "DELETE FROM tbl_cat_new WHERE new_id={$nid} AND category_id={$c['category_id']}";
                echo $q1;
                $r1 = mysql_query($q1);
            }            
            $cat[] = $c['category_id'];
        }
    
        //Neu danh muc moi duoc chon thi se them vao bang cat_posts            
        foreach($catID as $c){
            if((!in_array($c,$cat))||!(isset($cat))){
                $q = "INSERT INTO tbl_cat_new(new_id,category_id) VALUES ({$nid},{$c})";
                echo $q;
                $r = mysql_query($q);
            }
        }
        
        if(empty($errors)){
            $q1 = "UPDATE tbl_news SET title='{$post_title}',";
            if($filename) $q1 .= "thumbnail='{$filename}',";
            $q1 .= "content='{$post_content}',seolink='{$seolink}', use_id={$_SESSION['uid']}
                    WHERE id={$nid}";
            if(mysql_query($q1))
            	header("location: index.php?mod=news&rp=1&ad=edit&mn=$nid");
			else
				header('location: index.php?mod=news&rp=2&ad=edit');
        }
    } else{
       // header('location: index.php?mod=news&rp=3&ad=edit');
    }
}elseif(isset($_POST['cancel'])){
    header('location: index.php?mod=news');
}
?>