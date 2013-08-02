<div class="container_12">
    <div class="grid_12">
        <!-- Example table -->
        <div class="module">
        <?php
            if(isset($_GET['ship_id'])&& filter_var($_GET['ship_id'], FILTER_VALIDATE_INT, array('min_range'=>0))){
                $ship_id = $_GET['ship_id'];
				
                $rs = mysql_query("select * from tbl_shipping_fee where id = {$ship_id}");
                $ro = mysql_fetch_array($rs);
                $add = $ro['add'];
                //Neu catid ton tai thi se xoa category khoi csdl
                $q = "DELETE FROM tbl_shipping_fee WHERE id = {$ship_id} LIMIT 1";
                //Neu xoa thanh cong thi thong bao ra va xoa het cac danh muc con cua no
                if(mysql_query($q)){
                    header("location: index.php?mod=ship&rp=1&ad=del&mn=$add");
                }else{
                    echo "<script type='text/javascript'>alert('Không thể xóa được danh mục này.')</script>";
                }
            }else{
                header('location: index.php?mod=ship');
            }
        ?>
        <input class="view_category.php" type="submit" value="Quay l?i" />
        </div> <!-- End .module -->
    </div> <!-- End .grid_12 -->
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->