<div class="container_12">
    <div class="grid_12">
        <!-- Example table -->
        <div class="module">
        <?php
            if(isset($_GET['c_id'])&& filter_var($_GET['c_id'], FILTER_VALIDATE_INT, array('min_range'=>0))){
                $c_id = $_GET['c_id'];
                $r = mysql_query("SELECT avatar FROM tbl_user WHERE id = {$c_id}");
                $img = mysql_fetch_array($r);
                if(!empty($img['avatar'])) unlink("../uploads/".$img['avatar']);
                //echo "SELECT * FROM tbl_user WHERE id = {$c_id}";
                
                $q = "DELETE FROM tbl_user WHERE id = {$c_id} LIMIT 1";
                //Neu xoa thanh cong thi thong bao ra va xoa het cac danh muc con cua no
                if(mysql_query($q)){
                    header("location: index.php?mod=user&rp=1&ad=del&mn=$c_id");
                }else{
                    echo "<script type='text/javascript'>alert('Không th? xóa du?c danh m?c này.')</script>";
                }
            }else{
                header('location: index.php?mod=user');
            }
        ?>
        <input class="view_category.php" type="submit" value="Quay l?i" />
        </div> <!-- End .module -->
    </div> <!-- End .grid_12 -->
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->