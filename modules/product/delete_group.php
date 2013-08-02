<div class="container_12">
    <div class="grid_12">
        <!-- Example table -->
        <div class="module">
        <?php
            if(isset($_GET['catid'])&& filter_var($_GET['catid'], FILTER_VALIDATE_INT, array('min_range'=>0))){
                $catid = $_GET['catid'];
				$result_menu = mysql_query("SELECT * FROM tbl_category WHERE id={$catid}");
				$rows_menu = mysql_fetch_array($result_menu);
				$cat_name = $rows_menu['name'];
				
                //Neu catid ton tai thi se xoa category khoi csdl
                $q = "DELETE FROM tbl_category WHERE id = {$catid} LIMIT 1";
                //Neu xoa thanh cong thi thong bao ra va xoa het cac danh muc con cua no
                if(mysql_query($q)){
                    header("location: index.php?mod=product&act=list_group&rp=1&ad=del&mn=$cat_name");
                }else{
                    echo "<script type='text/javascript'>alert('Không thể xóa được danh mục này.')</script>";
                }
            }else{
                header('location: index.php?mod=product&act=list_group');
            }
        ?>
        <input class="view_category.php" type="submit" value="Quay lại" />
        </div> <!-- End .module -->
    </div> <!-- End .grid_12 -->
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->