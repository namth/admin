<div class="container_12">
    <div class="grid_12">
        <!-- Example table -->
        <div class="module">
        <?php
            if(isset($_GET['oid'])&& filter_var($_GET['oid'], FILTER_VALIDATE_INT, array('min_range'=>0))){
                $oid = $_GET['oid'];
				$check = true;
                $q = "DELETE FROM tbl_orders WHERE id = {$oid} LIMIT 1";
				if(!mysql_query($q))
					$check = false;
               	$q1 = "DELETE FROM tbl_order_details WHERE order_id = {$oid}";
				if(!mysql_query($q1))
					$check = false;
			   
			   
                if($check){
                    header("location: index.php?mod=order&rp=1&ad=del&mn=$oid");
                }else{
                    echo "<script type='text/javascript'>alert('Không thể xóa được danh mục này.')</script>";
                }
            }else{
                header('location: index.php?mod=order');
            }
        ?>
        <input class="view_category.php" type="submit" value="Quay l?i" />
        </div> <!-- End .module -->
    </div> <!-- End .grid_12 -->
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->