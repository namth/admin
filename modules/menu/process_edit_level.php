<?php 
    //Xac nhan bien GET ton tai va dung loai du lieu cho phep.
    if(isset($_POST['mid'])&& filter_var($_POST['mid'], FILTER_VALIDATE_INT, array('min_range'=>0))){
        $mid = $_POST['mid'];
        //Đếm xem có bao nhiêu menu con có trong menu có ID là $mid và tính ra vị trí tiếp theo.
        $q1 = "SELECT COUNT(id) AS count FROM tbl_link WHERE tbl_link.level={$mid}";
        $r1 = mysql_query($q1);
        if(mysql_num_rows($r1) > 0){
            list($count) = mysql_fetch_array($r1);
            $count += 1;
        }else{
            $count = 1;
        }
		
        //Kiem tra xem position co bi trung lap khong, neu co thi sap xep lai position cua menu.
        $q = "SELECT id FROM tbl_link WHERE level={$mid} GROUP BY position HAVING COUNT(*)>1";
        $r = mysql_query($q);
        //Neu co ton tai thi tien hanh sap xep lai.
        if (mysql_affected_rows($conn) > 0){
            $q1 = "SELECT id FROM tbl_link WHERE level={$mid} ORDER BY position ASC";
            $r1 = mysql_query($q1);
            $position_new = 1;
            while($menu = mysql_fetch_array($r1)){
                $q2 = "UPDATE tbl_link SET position={$position_new} WHERE id={$menu['id']}";
                $r2 = mysql_query($q2);
                $position_new++;
            }
        }
    }else{
        header('location: index.php?mod=menu');
    }
	
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $errors = array();
        //Kiem tra xem nut submit link co duoc nhan khong
        if(isset($_POST['submit_link'])){
            //Kiem tra xem truong link name co duoc dien khong
            if(empty($_POST['link_name'])){
                $errors[] = "link_name";
            }else{
                $link_name = mysql_real_escape_string(strip_tags($_POST['link_name']));
            }
            //Kiem tra xem truong permalink co duoc dien khong
            if(empty($_POST['permalink'])){
                $errors[] = "permalink";
            }else{
                $permalink = mysql_real_escape_string(strip_tags($_POST['permalink']));
            }
            //Neu khong co loi thi tien hanh insert
            if(empty($errors)){
                $q = "INSERT INTO tbl_link (name, permalink, level, position, type) 
                      VALUES ('{$link_name}', '{$permalink}', {$mid},{$count},'menu')";
                $r = mysql_query($q);
                if(mysql_affected_rows($conn) > 0){
					header("location: index.php?mod=menu&act=edit_level&rp=1&ad=link&mn=$link_name&mid=".$mid);
                }else{
                    header("location: index.php?mod=menu&act=edit_level&rp=2&mid=".$mid);
                }
            } else{
                header("location: index.php?mod=menu&act=edit_level&rp=3&mid=".$mid);
            }
        }else if(isset($_POST['submit_cat'])){
            if(isset($_POST["catID"])){
                $catID = $_POST["catID"];
                $q1 = "SELECT COUNT(id) AS count FROM tbl_link WHERE tbl_link.level={$mid}";
                $r1 = mysql_query($q1);
                if(mysql_num_rows($r1) == 1){
                    list($count) = mysql_fetch_array($r1);
                    $count += 1;
                }
				
				//kiem tra danh muc duoc chon co cha khac 0 hay khong thi bo sung vao danh sach catID
				foreach($catID as $cat_id){
					$q_cat = "SELECT * FROM tbl_category WHERE id={$cat_id}";
					$r_cat = mysql_query($q_cat);
					$c = mysql_fetch_array($r_cat);
					if((!in_array($c['level'], $catID))&&($c['level'])) $catID[] = $c['level'];
				}
				
               foreach($catID as $cat){
                    if(filter_var($_POST['mid'], FILTER_VALIDATE_INT, array('min_range'=>0))){
						$qr = "SELECT * FROM tbl_category WHERE id={$cat}";
						$rs = mysql_query($qr);
						$category = mysql_fetch_array($rs);
                       
                        $permalink = $sitepath."danh-muc/{$category['seolink']}";
                        $q = "INSERT INTO tbl_link(name,permalink,level,position,type)
                              VALUE ('{$category['name']}', '{$permalink}', {$mid},{$count},'menu')";
						
						echo $q;
                        $r = mysql_query($q);
                        if(mysql_affected_rows($conn) > 0){
                            header("location: index.php?mod=menu&act=edit_level&rp=1&ad=cat&mn={$category['name']}&mid=".$mid);
                        }else{
                             header("location: index.php?mod=menu&act=edit_level&rp=2&ad=cat&mid=".$mid);
                        }
                    }
                    $count++;
                }
            }
        }elseif(isset($_POST['submit_post'])){
            //Kiem tra id cua bai viet nhap dung form chua
            if(isset($_POST['post_id']) && filter_var($_POST['post_id'], FILTER_VALIDATE_INT, array('min_range'=>0))){
                $post_id = $_POST['post_id'];
            }else{
                $errors[] = "post_id";
            }
            //Kiem tra xem truong ten hien thi co duoc dien khong
            if(empty($_POST['post_name'])){
                $post_name = "";
            }else{
                $post_name = mysql_real_escape_string(strip_tags($_POST['post_name']));
            }
            
            //Lay catname de tao ra link than thien
            $q = "SELECT c.seolink FROM tbl_category AS c, tbl_cat_new as cn,tbl_news as n WHERE c.id = cn.category_id and cn.new_id = n.id and n.id={$post_id}";
            $r = mysql_query($q);
            $catlink = mysql_fetch_array($r);
            
            if(empty($errors)){
                $q1 = "SELECT title, seolink, thumbnail FROM tbl_news WHERE id={$post_id}";
			echo $q1."<br>";
                $r1 = mysql_query($q1);
                if(mysql_affected_rows($conn) >0 ){
                    $post = mysql_fetch_array($r1);
                    if(empty($post_name)){
                        $post_name = $post['title'];
                        //Lay anh thumbnail de lam anh cho menu
                        $imagelink = $post['thumbnail'];
                    }
                    $permalink = $sitepath."{$catlink['seolink']}/{$post['seolink']}.html";
                    $q = "INSERT INTO tbl_link(name,permalink,image,level,position,type)
                          VALUE ('{$post_name}', '{$permalink}', '{$imagelink}', {$mid},{$count},'menu')";
				echo $q;
                    $r = mysql_query($q);
                    if(mysql_affected_rows($conn) > 0){
                        header("location: index.php?mod=menu&act=edit_level&rp=1&ad=new&mn={$post_name}&mid=".$mid);
                    }else{
                        header("location: index.php?mod=menu&act=edit_level&rp=2&mid=".$mid);
                    }
                }else{
                    header("location: index.php?mod=menu&act=edit_level&rp=3&mid=".$mid);
                }
            }
        }
    }
	
	if(isset($messages)) echo $messages;
?>  