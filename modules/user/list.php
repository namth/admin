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
				$messages = report($report, "Xóa thành viên<b> {$menu}</b> thành công.");
			else if($_GET['ad']=="edit")
				$messages = report($report, "Sửa thành viên  <b>id = {$menu}</b> thành công.");
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
                <a href="?mod=user&act=insert" class="button">
                	<span>Thêm thành viên mới <img src="images/plus-small.gif" width="12" height="9" alt="New article" /></span>
                </a>
            </div>
            
        </div>
        
        
        <!-- Example table -->
        <div class="module">
        	<h2><span>Thông tin thành viên</span></h2>
            
            <div class="module-table-body">
            	<form action="">
                <table id="myTable" class="tablesorter">
                	<thead>
                        <tr>
                            <th style="width:5%">ID</th>
                            <th style="width:17%">Username</th>
                            <th style="width:20%">Họ và tên</th>
                            <th style="width:20%">Email</th>
                            <th style="width:12%">Điện thoại</th>
                            <th style="width:15%">Quyền hạn</th>
                            <th style="width:11%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
						if($_SESSION['idgu'] == 1)
							$reusult = mysql_query("SELECT * FROM  tbl_user");
						else
							$reusult = mysql_query("SELECT * FROM  tbl_user where group_user_id <> 1");
                        while($rows = mysql_fetch_array($reusult)){
						$group_user_id = $rows['group_user_id'];
						$reusult_g = mysql_query("select * from tbl_group_user where id = $group_user_id");
						$rows_g = mysql_fetch_array($reusult_g);
                    ?>
                        <tr>
                            <td class="align-center"><?php echo $rows['id']; ?></td>
                            <td><a href="?mod=user&act=edit&u_id=<?php echo $rows['id']?>"><b><?php echo $rows['username']; ?></b></a></td>
                            <td><?php echo $rows['first_name'].$rows['last_name'] ?></td>
                            <td><?php echo $rows['email']; ?></td>
                            <td><?php echo $rows['phone']; ?></td>
                            <td><font color="#FF0000"><b><?php echo $rows_g['name']; ?></b></font></td>
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
                                <a href="?mod=user&act=edit&u_id=<?php echo $rows['id']; ?>"><img src="images/pencil.gif" width="16" height="16" alt="edit" /></a>
                                <?php
                                $id = $rows['id'];
                                $rs_pro = mysql_query("select count(*) as count from  tbl_products where user_id = {$id}");
                                $rows_pro = mysql_fetch_array($rs_pro);
                                
                                $rs_new = mysql_query("select count(*) as count from tbl_news where use_id = {$id}");
                                $rows_new = mysql_fetch_array($rs_new);
                                if(((int)$rows_pro['count'] > 0)||((int)$rows_new['count'] > 0)){
                                    ?>
                                 <a href='?mod=user&act=delete&c_id=<?php echo $rows['id']; ?>' onclick="return confirm('Thành viên <?php echo $rows['first_name']."&nbsp;".$rows['last_name'] ?> này hiện có sản phẩm hoặc tin tức.\nBạn có chắc chắn muốn xóa <?php echo $rows['first_name']."&nbsp;".$rows['last_name']; ?>?');"><img src='images/bin.gif' width='16' height='16' alt="delete" /></a>
                                    <?php
                                }else{
                                    ?>
                                <a href='?mod=user&act=delete&c_id=<?php echo $rows['id']; ?>' onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng  <?php echo $rows['first_name']."&nbsp;".$rows['last_name'] ?>?');"><img src='images/bin.gif' width='16' height='16' alt="delete" /></a>
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