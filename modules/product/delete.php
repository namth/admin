<div class="container_12">
    <div class="grid_12">
        <!-- Example table -->
        <div class="module">
        <?php
            if(isset($_GET['pro_id'])&& filter_var($_GET['pro_id'], FILTER_VALIDATE_INT, array('min_range'=>0))){
                $pid = $_GET['pro_id'];
                //Get ten anh trong csdl de xoa khoi thu muc he thong
                $r = mysql_query("SELECT * FROM tbl_products WHERE id = {$pid}");
                $img = mysql_fetch_array($r);
                //xoa file
                if(!empty($img['thumbnail'])) unlink("../uploads/".$img['thumbnail']);
                //Neu pid ton tai thi se xoa post khoi csdl
                //trong CSDL phai setup RELATIONSHIP voi cat_posts
                //vi vay khi xoa post se tu dong xoa trong cat_posts tuong ung
                $q = "DELETE FROM tbl_products WHERE id = {$pid} LIMIT 1";

                if(mysql_query($q)){
                    //Xoa thanh cong, chuyen huong ve trang post
                    //echo "<script type='text/javascript'>alert('Bạn đã xóa thành công')</script>";
                    ob_clean();
                    $product_name = $img['seolink'];
                    header("location: index.php?mod=product&rp=1&ad=del&mn=$product_name");
                }else{
                    echo "<script type='text/javascript'>alert('Không thể xóa được bài viết này.')</script>";
                }
                
            }else{
                header('location: index.php?mod=product');
            }
        ?>
        <input class="view_category.php" type="submit" value="Quay lại" />
        </div> <!-- End .module -->
	</div> <!-- End .grid_12 -->
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->