<?php
if(($_SERVER['REQUEST_METHOD'] == 'POST')&& isset($_POST['submit'])){
    $errors = array();
    $allowed = array('png', 'jpg', 'gif');
    $filename = NULL;
    //Kiem tra tieu de bai viet da nhap chua
    
    if(empty($_POST['name'])){
        $errors[] = "name";
    }else{
        $name = mysql_real_escape_string(strip_tags($_POST['name']));
        //Kiem tra seolink, neu khong nhap thi tu sinh ra, seolink khong duoc trung nhau
        if(empty($_POST['seolink'])){
            $seolink = link_convert($name);
            $q = "SELECT seolink FROM tbl_products WHERE seolink LIKE '{$seolink}%'";
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
            $q = "SELECT seolink FROM tbl_products WHERE seolink LIKE '{$seolink}%'";
            $r = mysql_query($q);
            while($p = mysql_fetch_array($r)){
                if($seolink == $p['seolink']){
                    $errors[]="seolink";
                    break;
                }
            }
        }
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
    
    if(empty($_POST['content'])){
        $post_content = "";
    }else{
        $post_content = mysql_real_escape_string($_POST['content']);
    }
    
    if(isset($_POST['price'])&&filter_var($_POST['price'], FILTER_VALIDATE_INT, array('min_range'=>0))){
        $price = mysql_real_escape_string($_POST['price']);
    }else{
        $price = 0;
    }
    
    if(isset($_POST['sale'])&&filter_var($_POST['sale'], FILTER_VALIDATE_INT, array('min_range'=>0))){
        $sale = mysql_real_escape_string($_POST['sale']);
    }else{
        $sale = 0;
    }
    
    if(isset($_POST['amount'])&&filter_var($_POST['amount'], FILTER_VALIDATE_INT, array('min_range'=>0))){
        $amount = mysql_real_escape_string($_POST['amount']);
    }else{
        $amount = 0;
    } 
    
    if($sale == 0){
        $sale = $price;
    }
    if(empty($errors)){
        $cat_prod = $_POST['cat_product']?$_POST['cat_product']:1;
        $q1 = "INSERT INTO tbl_products (user_id,lang_id,name,thumbnail,content,post_date,seolink,price, sale, amount, category_id) 
               VALUE ({$_SESSION['uid']},$lang,'{$name}','{$filename}','$post_content', NOW(),'{$seolink}',{$price},{$sale},{$amount}, {$cat_prod})";
        if(mysql_query($q1))
        	header("location: index.php?mod=product&rp=1&ad=ins&mn=$name");
		else
			header('location: index.php?mod=product&rp=2&ad=ins');
    }else{
        header('location: index.php?mod=product&rp=3&ad=ins');
    }
}else if(isset($_POST['cancel'])){
    header('location: index.php?mod=product');
}
    
?>