<?php
    $menu = $_GET['mn']?$_GET['mn']:"";
	$report = $_GET['rp']?$_GET['rp']:"";
	$act_details = $_GET['ad']?$_GET['ad']:"";
    $e = $_GET['e']?$_GET['e']:0;
	switch($report){
		case "1":
			if($act_details=="ins" && $e == 1)
				$messages = report($report, "Đăng ký tài khoản <b> {$menu}</b> thành công.");
			else if($act_details=="ins" && $e == 2)
				$messages = report($report, "Đăng ký tài khoản <b> {$menu}</b> thành công.").report(2, "Gửi thông báo kích hoạt tới <b> {$menu}</b> thất bại");
            else if($act_details=="ins" && $e == 3)
				$messages = report(2, "Đăng ký thất bại! Email: <b> {$menu}</b> đã tồn tại.");
            else if($act_details=="ins" && $e == 4)
				$messages = report(2, "Yêu cầu của bạn không thể thực hiện được do lỗi hệ thống.");
            else if($_GET['ad']=="del")
				$messages = report($report, "Xóa khách hàng<b> {$menu}</b> thành công.");
			else if($_GET['ad']=="edit")
				$messages = report($report, "Sửa khách hàng  <b>id = {$menu}</b> thành công.");
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
                <a href="?mod=customer&act=insert" class="button">
                	<span>Thêm khách hàng mới <img src="images/plus-small.gif" width="12" height="9" alt="New article" /></span>
                </a>
            </div>
            
        </div>
        
        
        <!-- Example table -->
        <div class="module">
        	<h2><span>Danh sách khách hàng</span></h2>
            
            <div class="module-table-body">
            	<form action="">
                <table id="myTable" class="tablesorter">
                	<thead>
                        <tr>
                            <th style="width:4%">ID</th>
                            <th style="width:25%">Email</th>
                            <th style="width:20%">Họ và tên</th>
                            <th style="width:10%">Điện thoại</th>
                            <th style="width:30%">Địa chỉ</th>
                            <th style="width:11%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $reusult = mysql_query("SELECT * FROM  tbl_customer") or die("Query {$q} \n<br/> MySQL Error: " . mysqli_error($dbc));
                         while($rows = mysql_fetch_array($reusult)){
                    ?>
                        <tr>
                            <td><?php echo $rows['id']; ?></td>
                            <td><a href="?mod=customer&act=edit&c_id=<?php echo $rows['id']; ?>"><?php echo $rows['email']; ?></a></td>
                            <td><?php echo $rows['first_name']."&nbsp;".$rows['last_name'] ?></td>
                            <td><font color="#FF0000"><b><?php echo $rows['phone']; ?></b></font></td>
                            <td><?php echo truncateString($rows['add'], 40, true); ?></td>
                            <td>
                            	<input type="checkbox" />
                                <a href="">
                                <?php
                                	if($rows["active"] == "")
										echo "<img src='images/tick-circle.gif' width='16' height='16' alt='published' />";
									else
										echo "<img src='images/notification-slash.gif' width='16' height='16' alt='published' />";
								?>
                                </a>
                                <a href="?mod=customer&act=edit&c_id=<?php echo $rows['id']; ?>"><img src="images/pencil.gif" width="16" height="16" alt="edit" /></a>
                                <?php
                                $email = $rows['email'];
                                $rs_order = mysql_query("select count(*) as count from  tbl_orders where email = '{$email}'");
                                $rows_order = mysql_fetch_array($rs_order);
                                if((int)$rows_order['count'] > 0){
                                    ?>
                                 <a href='?mod=customer&act=delete&c_id=<?php echo $rows['id']; ?>' onclick="return confirm('Khách hàng <?php echo $rows['first_name']."&nbsp;".$rows['last_name'] ?> này hiện có đơn hàng(đã hoàn thành hay chưa hoàn thành) trong kho.\nBạn có chắc chắn muốn xóa <?php echo $rows['first_name']."&nbsp;".$rows['last_name']; ?>?');"><img src='images/bin.gif' width='16' height='16' alt="delete" /></a>
                                    <?php
                                }else{
                                    ?>
                                <a href='?mod=customer&act=delete&c_id=<?php echo $rows['id']; ?>' onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng  <?php echo $rows['first_name']."&nbsp;".$rows['last_name'] ?>?');"><img src='images/bin.gif' width='16' height='16' alt="delete" /></a>
                                    <?php
                                }
                                ?>
                                
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