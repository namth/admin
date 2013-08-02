<div class="container_12">
    <div class="grid_12">
        <!-- Example table -->
        <div class="module">
        <?php
            if(isset($_GET['com_id'])&& filter_var($_GET['com_id'], FILTER_VALIDATE_INT, array('min_range'=>0))){
                $com_id = $_GET['com_id'];
                $q = "DELETE FROM tbl_comments WHERE id = {$com_id} LIMIT 1";
                //Neu xoa thanh cong thi thong bao ra va xoa het cac danh muc con cua no
                if(mysql_query($q)){
                    //Xoa thanh cong, chuyen huong ve trang categor
                    header("location: index.php?mod=comment&rp=1&ad=del&mn=$cat_name");
                }else{
                    echo "<script type='text/javascript'>alert('Không th? xóa du?c danh m?c này.')</script>";
                }
            }else{
                header('location: index.php?mod=comment');
            }
        ?>
        <input class="view_category.php" type="submit" value="Quay l?i" />
        </div> <!-- End .module -->
    </div> <!-- End .grid_12 -->
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->