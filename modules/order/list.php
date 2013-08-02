<?php
    $menu = $_GET['mn']?$_GET['mn']:"";
	$report = $_GET['rp']?$_GET['rp']:"";
	$act_details = $_GET['ad']?$_GET['ad']:"";
	switch($report){
		case "1":
			if($_GET['ad']=="ins")
				$messages = report($report, "Thêm hóa đơn <b> {$menu}</b> thành công.");
			else if($_GET['ad']=="del")
				$messages = report($report, "Xóa hóa đơn<b> id = {$menu}</b> thành công.");
			else if($_GET['ad']=="edit")
				$messages = report($report, "Sửa hóa đơn  <b>id = {$menu}</b> thành công.");
			break;
		case "2":
			$messages = report($report, "Có lỗi xảy ra, hãy kiểm tra lại.");
			break;
		case "3":
			$messages = report($report, "Có lỗi xảy ra.");
			break;
	}
?>

<div class="container_12">
    <div class="grid_12">
    <?php if(!empty($messages)) echo $messages;?>
        <div class="bottom-spacing">
            <!-- Button -->
            <div class="float-right" >
                <a href="" class="button">
                	<span>Thêm Đơn hàng mới <img src="images/plus-small.gif" width="12" height="9" alt="New article" /></span>
                </a>
            </div>
            
        </div>
        
        
        <!-- Example table -->
        <div class="module">
        	<h2><span>Danh sách Đơn hàng</span></h2>
            
            <div class="module-table-body">
            	<form action="">
                <table id="myTable" class="tablesorter">
                	<thead>
                        <tr>
                            <th style="width:5%">ID</th>
                            <th style="width:35%">Thông tin khách hàng</th>
                            <th style="width:38%">
                                <div style="width:100%; float:left">
                                    <div style="width:70%; float:left;">Tên SP</div>
                                    <div style="width:30%; float:left;">Giá&nbsp;(VND)</div>
                                </div>
                            </th>
                            <th style="width:12%">Ngày đặt hàng</th>
                            <th style="width:10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $reusult = mysql_query("SELECT * FROM  tbl_orders");
                        while($rows = mysql_fetch_array($reusult)){
							$email = $rows['email'];
							$oid = $rows['id'];
							$result_cus = mysql_query("SELECT * FROM tbl_customer WHERE email = '{$email}'");
							$rows_cus = mysql_fetch_array($result_cus);
                            
                    ?>
                        <tr>
                             <td class="align-center"><?php echo $rows['id']; ?></td>
                            <?php
                            if(mysql_affected_rows($conn)>0){
                            ?>
                            <td>
                            	 <a href="?mod=customer&act=edit&c_id=<?php echo $rows_cus['id']; ?>">
									<?php echo $rows_cus['first_name']."&nbsp;".$rows_cus['last_name']."<br>"."Email: ".$rows_cus['email']."<br>"."ĐT: ".$rows_cus['phone'];?>
                                </a>
                            </td>
                            <td>
                            <?php
                            }else{
                             ?>
                            <td>
                            	 <a href="index.php?mod=customer&act=profile&cid=<?php echo $rows['email']; ?>">
									<?php echo $rows['name']."&nbsp;"."<br>"."Email: ".$rows['email']."<br>"."ĐT: ".$rows['phone'];?>
                                </a>
                            </td>
                            <td>
                             <?php   
                            }
								$str_product = "SELECT * FROM tbl_order_details t1 INNER JOIN tbl_products t2 ON t1.product_id = t2.id WHERE order_id = $oid";
								$result_product = mysql_query($str_product);
								$total=0; 
								while($rows_product = mysql_fetch_array($result_product)){
				                if($rows_product['sale'] >0)
                                    $price = $rows_product['sale'];
                                else
                                    $price = $rows_product['price'];
								$name = truncateString($rows_product['name'], 35, true);
								$total += (int)$rows_product['quantity']*$price;	
								?>
								<div style="width:70%; float:left"> 
								<a href="?mod=product&act=edit&pro_id=<?php echo $rows_product['id']?>">
								<?php echo $name;?> 
								</a>
								<b style="color: red;">x</b> <?php echo $rows_product['quantity'];?>
								</div>
								<div style="width:30%; float:left;"> 
								<?php echo number_format($price);?>
								</div>
								<?php
								}
							?>
							<div style="float:left; width:100%;">
                            <div style="float:left; width:70%; text-align:right"><b>Tổng Giá:&nbsp;</b></div>
                            <div style="float:left; width:30%; text-align:left">
                            <?php 
                            $fee_id = $rows['shipping_fee_id'];
                            $rs_fee = mysql_query("select fee from tbl_shipping_fee where id = $fee_id");
                            $ro_fee = mysql_fetch_array($rs_fee);
                            $total = $total + $ro_fee['fee'];
                            if($rows['total'] == $total)
                                echo "<font color='#FF0000'><b>".number_format($total)."</b></font>";
                            else
                                echo "<span style='text-decoration: line-through; font-size: 14px; font-style: italic; color: silver;'>".number_format($rows['total'])."</span><br><font color='#FF0000'><b>".number_format($total)."</b></font>";  
                            ?>
                            </div>
                            </div>
                            
                            
                            </td>
                            <td>
								<?php echo $rows['order_date']; ?>
                            </td>
                            <td>
                            	<input type="checkbox" />
                                <a href="">
                                	<?php
										switch($rows['status']){
											case "0":
												echo "<img src='images/new_icon.gif' width='16' height='16' alt='published' />";
												break;
											case "1":
												echo "<img src='images/notification-exclamation.gif' width='16' height='16' alt='published' />";
												break;
											case "2":
												echo "<img src='images/tick-circle.gif' width='16' height='16' alt='published' />";
												break;
											case "3":
												echo "<img src='images/minus-circle.gif' width='16' height='16' alt='published' />";
												break;
										}
									?>
                                </a>
                                <a href="index.php?mod=order&act=edit&oid=<?php echo $rows['id']; ?>"><img src="images/pencil.gif" width="16" height="16" alt="edit" /></a>
                                <a href="index.php?mod=order&act=delete&oid=<?php echo $rows['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng id = <?php echo $rows['id']; ?>?');"><img src="images/bin.gif" width="16" height="16" alt="delete" /></a>
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