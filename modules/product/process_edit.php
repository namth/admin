<?php
if(isset($_POST['product_id'])&& filter_var($_POST['product_id'], FILTER_VALIDATE_INT, array('min_range'=>0))){
		$product_id = $_POST['product_id'];
}else{
	?>
	<SCRIPT LANGUAGE="JavaScript">
	history.back();
	</SCRIPT>
	<?php
}
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
                    //$errors[]="seolink";
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
    		$messages = "<span class='notification n-error'>Hệ thống không hỗ trợ upload loại file này.</span>";
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
    
    if($sale == 0){
        $sale = $price;
    }
    
    if(isset($_POST['amount'])&&filter_var($_POST['amount'], FILTER_VALIDATE_INT, array('min_range'=>0))){
        $amount = mysql_real_escape_string($_POST['amount']);
    }else{
        $amount = 0;
    }

    if(empty($errors)){
        $cat_prod = $_POST['cat_product']?$_POST['cat_product']:1;
        if($filename != null)
            $q1 = "UPDATE  tbl_products SET lang_id =  {$lang}, name =  '{$name}', thumbnail =  '{$filename}', content =  '{$post_content}', seolink =  '{$seolink}', price =  $price, sale ={$sale}, amount =  {$amount}, category_id = {$cat_prod}, user_id = {$_SESSION['uid']} WHERE  `id` =$product_id";
        else
            $q1 = "UPDATE  tbl_products SET lang_id =  {$lang}, name =  '{$name}', content =  '{$post_content}', seolink =  '{$seolink}', price =  $price, sale ={$sale}, amount =  {$amount},  category_id = {$cat_prod}, user_id = {$_SESSION['uid']} WHERE  `id` =$product_id";
    
        if(mysql_query($q1))
            	header("location: index.php?mod=product&rp=1&ad=edit&mn=$product_id");
			else
				header('location: index.php?mod=product&rp=2&ad=edit');
    }else{
        header('location: index.php?mod=product&rp=3&ad=edit');
    }
}else if(isset($_POST['cancel'])){
    header('location: index.php?mod=news');
}
    
?>