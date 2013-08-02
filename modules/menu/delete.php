<div class="container_12">
    <div class="grid_12">
        <!-- Example table -->
        <div class="module">
        <?php
            if(isset($_GET['lid'])&& filter_var($_GET['lid'], FILTER_VALIDATE_INT, array('min_range'=>0))){
                $lid = $_GET['lid'];
				$menu = $_GET['mn']?$_GET['mn']:"";
				$lname = $_GET['lname']?$_GET['lname']:"";
                //Kiem tra xem $lid co chua cac con khong?
                $q1 = "SELECT id, name, image FROM tbl_link WHERE level={$lid}";
                $r1 = mysql_query($q1);
                //Neu co ton tai con cua $lid thi xoa con truoc
                if(mysql_affected_rows($conn) > 0):
                    //Duyet tung con cua $lid va xoa khoi CSDL
                    while($lid_child = mysql_fetch_array($r1)):
                        $q = "DELETE FROM tbl_link WHERE id={$lid_child['id']}";
                        if($lid_child['image'] != ''){
                            $link = "../uploads/".$lid_child['imagename'];
                            unlink($link);
                        }
						$r = mysql_query($q);
                    endwhile;
                endif;
                //Sau do moi xoa den $lid khoi CSDL
                $q1 = "DELETE FROM tbl_link WHERE id = {$lid} LIMIT 1";
                $r1 = mysql_query($q1);
                
                if(mysql_affected_rows($conn) > 0 ){
                    header("location: index.php?mod=menu&rp=1&ad=del&lname=$lname&mn=$menu");
                }else{
                    echo "<script type='text/javascript'>alert('Không thể xóa được.')</script>";
                }
                //Xoa cac category chua bai viet
            }else{
                 header("location: index.php?mod=menu");
            }
        ?>
        <input class="admin.php" type="submit" value="Quay lại" />
        </div> <!-- End .module -->
    </div> <!-- End .grid_12 -->
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->