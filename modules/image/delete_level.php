		<div class="container_12">
            <div class="grid_12">
                <!-- Example table -->
                <div class="module">
                <?php
					$lid = $_GET['lid']?$_GET['lid']:"";
					$result_menu = mysql_query("SELECT * FROM tbl_link WHERE id={$lid}");
					$rows_menu = mysql_fetch_array($result_menu);
					$lname = $rows_menu['name'];
                    if(isset($_GET['lid'])&& filter_var($_GET['lid'], FILTER_VALIDATE_INT, array('min_range'=>0))){
                        $lid = $_GET['lid'];
                        //Kiem tra xem $lid co chua cac con khong?
                        $result = mysql_query("SELECT id, image FROM tbl_link WHERE level={$lid}");
                        //Neu co ton tai con cua $lid thi xoa con truoc
                        if(mysql_num_rows($result) > 0){
                            //Duyet tung con cua $lid va xoa khoi CSDL
                            while($rows= mysql_fetch_array($result)){
                                if(mysql_query("DELETE FROM tbl_link WHERE id={$rows['id']}")){
                                    $link = "../uploads/".$rows['image'];
                                    unlink($link);
                                }
							}
						}
                        //Sau do moi xoa den $lid khoi CSDL
						
                        
                        if(mysql_query("DELETE FROM tbl_link WHERE id = {$lid} LIMIT 1")){
                            //Xoa thanh cong, chuyen huong ve trang menu
							header("location: index.php?mod=image&rp=1&ad=del&mn=$lname");
                        }else{
                            echo "<script type='text/javascript'>alert('Không thể xóa được.')</script>";
                        }
                        //Xoa cac category chua bai viet
                    }else{
                        header('location: index.php?mod=image');
                    }
                ?>
                <input class="admin.php" type="submit" value="Quay lại" />
                </div> <!-- End .module -->
			</div> <!-- End .grid_12 -->
            <div style="clear:both;"></div>
        </div> <!-- End .container_12 -->