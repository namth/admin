<div class="container_12">
    <div class="grid_12">
        <!-- Example table -->
        <div class="module">
        <?php
            if(isset($_GET['ug_id'])&& filter_var($_GET['ug_id'], FILTER_VALIDATE_INT, array('min_range'=>0))){
                $ug_id = $_GET['ug_id'];
                $check = true;
                $q = "DELETE FROM tbl_group_user WHERE id = {$ug_id} LIMIT 1";
                //Neu xoa thanh cong thi thong bao ra va xoa het cac danh muc con cua no
				if(!mysql_query($q))
					$check = false;
				$q1 = "DELETE FROM tbl_user WHERE group_user_id = {$ug_id}";
				if(!mysql_query($q1))
					$check = false;
					
                if($check){
                    header("location: index.php?mod=user&act=list_group&rp=1&ad=del&mn=$ug_id");
                }else{
                    echo "<script type='text/javascript'>alert('Không thể xóa được danh mục này.')</script>";
                }
            }else{
                header('location: index.php?mod=user&act=list_group');
            }
        ?>
        <input class="view_category.php" type="submit" value="Quay l?i" />
        </div> <!-- End .module -->
    </div> <!-- End .grid_12 -->
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->