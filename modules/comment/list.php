		<div class="container_12">
            <div class="grid_12">
                
                <!-- Example table -->
                <div class="module">
                	<h2><span>Danh sách bình luận</span></h2>
                    
                    <div class="module-table-body">
                    	<form action="">
                        <table id="myTable" class="tablesorter">
                        	<thead>
                                <tr>
                                    <th style="width:5%">ID</th>
                                    <th style="width:15%">Tên khách hàng</th>
                                    <th style="width:35%">Nội dung</th>
                                    <th style="width:25%">Mục bình luận</th>
                                    <th style="width:10%">Cấp độ</th>
                                    <th style="width:15%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $reusult = mysql_query("SELECT * FROM  tbl_comments") or die("Query {$q} \n<br/> MySQL Error: " . mysqli_error($dbc));
                                while($rows = mysql_fetch_array($reusult)){
                            ?>
                                <tr>
                                    <td class="align-center"><?php echo $rows['id']; ?></td>
                                    <td><a href=""><b><?php echo $rows['name']; ?></b></a></td>
                                    <td><?php echo truncateString($rows['content'], 140, true); ?></td>
                                    <td>
                                    <?php
                                    	if($rows['new_id']!= ""){
											$n_id = $rows['new_id'];
											$n_result = mysql_query("select * from tbl_news where id = '$n_id'");
											$n_rows = mysql_fetch_array($n_result);
											echo "<a href='#'>".truncateString($n_rows['title'], 100, true)."</a>";
										}
										
										if($rows['product_id']!= ""){
											$p_id = $rows['product_id'];
											$p_result = mysql_query("select * from tbl_products where id = '$p_id'");
											$p_rows = mysql_fetch_array($p_result);
											echo "<a href='#'>".truncateString($p_rows['name'], 100, true)."</a>";
										}
									?>
                                  	
                                    </td>
                                    <td>
                                    <?php
                                        switch($rows['type']){
                                            case "nocustomer":
                                                echo "Khách vãng lai";
                                                break;   
                                            case "customer":
                                                echo "thành viên";
                                                break;
                                            case "admin":
                                                echo "Quản trị";
                                                break;
                                        }
                                    
                                    ?>
                                    </td>
                                    <td>
                                    	<input type="checkbox" />
                                        <a href="#"><img src="images/tick-circle.gif" width="16" height="16" alt="published" /></a>
                                        <a href="#"><img src="images/pencil.gif" width="16" height="16" alt="edit" /></a>
                                        <a href="?mod=comment&act=delete&com_id=<?php echo $rows['id']; ?>" onclick="return confirm('BẠN CÓ CHẮC CHẮN MUỐN XÓA KHÔNG????')"><img src="images/bin.gif" width="16" height="16" alt="delete" /></a>
                                    </td>
                                </tr>
                           <?php
							} ?>
                            </tbody>
                        </table>
                        </form>
                        <div class="pager" id="pager">
                            <form action="">
                                <div>
                                <img class="first" src="images/arrow-stop-180.gif" alt="Đầu tiên"/>
                                <img class="prev" src="images/arrow-180.gif" alt="Trước"/> 
                                <input type="text" class="pagedisplay input-short align-center"/>
                                <img class="next" src="images/arrow.gif" alt="Sau"/>
                                <img class="last" src="images/arrow-stop.gif" alt="Cuối cùng"/> 
                                <select class="pagesize input-short align-center">
                                    <option value="10" selected="selected">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                </select>
                                </div>
                            </form>
                        </div>
                        <div class="table-apply">
                            <form action="">
                            <div>
                            <span>Apply action to selected:</span> 
                            <select class="input-medium">
                                <option value="1" selected="selected">Select action</option>
                                <option value="2">Publish</option>
                                <option value="3">Unpublish</option>
                                <option value="4">Delete</option>
                            </select>
                            </div>
                            </form>
                        </div>
                        <div style="clear: both"></div>
                     </div> <!-- End .module-table-body -->
                </div> <!-- End .module -->
                
			</div> <!-- End .grid_12 -->
            
            <div style="clear:both;"></div>
            
        </div> <!-- End .container_12 -->