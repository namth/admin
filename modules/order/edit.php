<div class="container_12">
    <div class="grid_12">
        
        <?php
        if(isset($_GET['oid'])&& filter_var($_GET['oid'], FILTER_VALIDATE_INT, array('min_range'=>0))){
            $oid = $_GET['oid'];
        }else{
            header('location: index.php?mod=order');
        }
    	$q = "SELECT * FROM tbl_orders WHERE id = {$oid}";
        $r = mysql_query($q);
        $order = mysql_fetch_array($r);
        $email = $rows['email'];
		$oid = $rows['id'];
		$result_cus = mysql_query("SELECT * FROM tbl_customer WHERE email = '{$email}'");
		$rows_cus = mysql_fetch_array($result_cus);
        if(mysql_affected_rows($conn)>0){
            $name = $rows_cus['name'];
            $add = $rows_cus['add'];
            $email = $rows_cus['email'];
            $phone = $rows_cus['phone'];
        }else{
            $name = $order['name'];
            $add = $order['add'];
            $email = $order['email'];
            $phone = $order['phone'];
        }
        
        ?>
        <!-- Example table -->
        <div class="module">
        	<h2><span>Chi tiết đơn hàng</span></h2>
            
            <div class="module-table-body">
            	<form id="update_order" action="index.php?mod=order&act=process_edit&oid=<?php echo $order['id']?>" method="post">
                <div class="grid_10 suffix_2" style="margin: 20px;">
                    <p>
                        <label>Tên khách hàng: </label>
                        <b><?php  echo $name; ?></b>
                    </p>
                    <p>
                        <label>Địa chỉ: </label>
                        <b><?php echo $add; ?></b>
                    </p>
                    <p>
                        <label>Email: </label>
                        <b><?php echo $email; ?></b>
                    </p>
                    <p>
                        <label>Điện thoại: </label>
                        <b><?php echo $phone; ?></b>
                    </p>
                    <p>
                        <label>Hình thức thanh toán: </label>
                        <b><?php echo $order['payment']; ?></b>
                    </p>
                    <p>
                        <label>Nội dung liên hệ: </label>
                        <p><?php echo $order['require']; ?></p>
                    </p>
               
                <table id="myTable" class="tablesorter">
                	<thead>
                        <tr>
                            <th style="width:5%">ID</th>
                            <th style="width:12%">Hình ảnh</th>
                            <th style="width:40%">Tên sản phẩm</th>
                            <th style="width:13%">Số lượng</th>
                            <th style="width:15%">Đơn giá(VND)</th>
                            <th style="width:15%">Tổng giá(VND)</th>
                        </tr>
                    </thead>
                    <tbody>
                   <?php
                   ;
                    	$q = "SELECT t1.product_id, t1.quantity, t2.thumbnail, t2.price, t2.name, t3.total FROM tbl_order_details t1 
                                INNER JOIN tbl_products t2 ON t1.product_id = t2.id 
                                INNER JOIN tbl_orders t3 ON t3.id = t1.order_id
                                WHERE t1.order_id = ".$order['id'];
                        $r = mysql_query($q);
                        while($item = mysql_fetch_array($r)){
                            $total = 0;
                    ?>
                        <tr>
                            <td class="align-center"><?php echo $item['id']; ?></td>
                            <td><img src="<?php echo $sitepath."uploads/{$item['thumbnail']}"; ?>" width="60"/></td>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($item['price']); ?></td>
                            <td><?php echo number_format($item['price']*$item['quantity']); ?></td>
                        </tr>
                    <?php } ?>
                        <tr>
                            <td colspan="5" style="text-align: right;"><b>Tổng tiền:</b></td>
                            <td style="color: red; font-weight: bold; font-size: 14px;"><?php echo number_format($order['total'])?>&nbsp;VND</td>
                        </tr>
                    </tbody>
                </table>
                
                <fieldset>
                    <b>Tình trạng xử lý</b>
                    <ul>
                        <li><label><img src="images/new_icon.gif" width="16" height="16" alt="published" /><input type="radio" name="c"  value="0" <?php if($order['status'] == 0) echo "checked"; ?>/> Chưa xử lý</label></li>
                        <li><label><img src="images/notification-exclamation.gif" width="16" height="16" alt="published" /><input type="radio" name="c" value="1" <?php if($order['status'] == 1) echo "checked"; ?>/> Đang xử lý</label></li>
                        <li><label><img src="images/tick-circle.gif" width="16" height="16" alt="published" /><input type="radio" name="c" value="2" <?php if($order['status'] == 2) echo "checked"; ?>/>Đã xử lý</label></li>
                        <li><label><img src="images/minus-circle.gif" width="16" height="16" alt="published" /><input type="radio" name="c" value="3" <?php if($order['status'] == 3) echo "checked"; ?>/> Đơn hàng bị hủy</label></li>
                    </ul>
                </fieldset>
                
                <input class="submit-green" type="submit" value="Xác nhận" name="submit" /> 
                <input class="submit-gray" type="submit" value="Quay lại" name="cancel" />
                
                
               </div>
            </form>
                
                <div style="clear: both"></div>
             </div> <!-- End .module-table-body -->
        </div> <!-- End .module -->
	</div> <!-- End .grid_12 -->
    
    <div style="clear:both;"></div>
    
</div> <!-- End .container_12 -->