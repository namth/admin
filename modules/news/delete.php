<div class="container_12">
    <div class="grid_12">
        <!-- Example table -->
        <div class="module">
        <?php
            if(isset($_GET['nid'])&& filter_var($_GET['nid'], FILTER_VALIDATE_INT, array('min_range'=>0))){
                $nid = $_GET['nid'];
                //Get ten anh trong csdl de xoa khoi thu muc he thong
                $r = mysql_query("SELECT * FROM tbl_news WHERE id = {$nid}");
                $img = mysql_fetch_array($r);
                //xoa file
                if(!empty($img['thumbnail'])) unlink("../uploads/".$img['thumbnail']);
                //Neu nid ton tai thi se xoa post khoi csdl
                //trong CSDL phai setup RELATIONSHIP voi cat_posts
                //vi vay khi xoa post se tu dong xoa trong cat_posts tuong ung
                $q = "DELETE FROM tbl_news WHERE id = {$nid} LIMIT 1";

                if(mysql_query($q)){
                    mysql_query("DELETE FROM tbl_cat_new WHERE new_id = {$nid}");
                    //Xoa thanh cong, chuyen huong ve trang post
                    //echo "<script type='text/javascript'>alert('B?n dã xóa thành công')</script>";
                    ob_clean();
                    $news_name = $img['seolink'];
                    header("location: index.php?mod=news&rp=1&ad=del&mn=$news_name");
                }else{
                    echo "<script type='text/javascript'>alert('Không th? xóa du?c bài vi?t này.')</script>";
                }
                
            }else{
                header('location: index.php?mod=news');
            }
        ?>
        <input class="view_category.php" type="submit" value="Quay l?i" />
        </div> <!-- End .module -->
	</div> <!-- End .grid_12 -->
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->