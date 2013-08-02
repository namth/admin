<?php
$menu = $_GET['mn']?$_GET['mn']:"";
$report = $_GET['rp']?$_GET['rp']:"";
$act_details = $_GET['ad']?$_GET['ad']:"";
switch($report){
case "1":
	if($_GET['ad']=="ins")
		$messages = report($report, "Thêm chức năng <b> {$menu}</b> thành công.");
	else if($_GET['ad']=="del")
		$messages = report($report, "Xóa chức năng <b> id = {$menu}</b> thành công.");
	else if($_GET['ad']=="edit")
		$messages = report($report, "Sửa chức năng <b>{$menu}</b> thành công.");
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
                <a href="?mod=user&act=insert_group" class="button">
                	<span>Thêm chức năng mới <img src="images/plus-small.gif" width="12" height="9" alt="New article" /></span>
                </a>
            </div>
            
        </div>
        
        
        <!-- Example table -->
        <div class="module">
        	<h2><span>Danh sách danh mục</span></h2>
            
            <div class="module-table-body">
            	<form action="">
                <table id="myTable" class="tablesorter">
                	<thead>
                        <tr>
                            <th style="width:5%">ID</th>
                            <th style="width:15%">Tên chức năng</th>
                            <th style="width:33%">Mô tả</th>
                            <th style="width:41%">Chi tiết</th>
                            <th style="width:6%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
					if($_SESSION['idgu'] == 1)
                        $reusult = mysql_query("SELECT * FROM tbl_group_user");
					else
						$reusult = mysql_query("SELECT * FROM tbl_group_user where id <> 1");
                        while($rows = mysql_fetch_array($reusult)){
                    ?>
                        <tr>
                            <td class="align-center"><?php echo $rows['id']; ?></td>
                            <td><a href="?mod=user&act=edit_group&ug_id=<?php echo $rows['id']?>"><b><?php echo $rows['name']; ?></b></a></td>
                            <td><?php echo $rows['sumary']; ?></td>
                            <td><?php echo $rows['detail']; ?></td>
                            <td>
                            	<input type="checkbox" />
                                <a href="?mod=user&act=edit_group&ug_id=<?php echo $rows['id']?>"><img src="images/pencil.gif" width="16" height="16" alt="edit" /></a>
                                <?php
                                    $ug_id = $rows['id'];
                                    $rs_grop = mysql_query("select count(*) as count from  tbl_user where group_user_id = {$ug_id}");
									
                                    $rows_group = mysql_fetch_array($rs_grop);
                                    if((int)$rows_group['count'] > 0 && $rows['id']!=$_SESSION['idgu']){
                                        ?>
                                     <a href="?mod=user&act=delete_group&ug_id=<?php echo $rows['id']; ?>" onclick="javascript: confirm('Hiện có thành viên quản trị nằm trong nhóm này. \n nếu bạn xóa nhóm mọi thành viên cũng bị xóa.\n BẠN CÓ CHẮC CHẮN XÓA <?php echo$rows['name'] ?>?');"><img src="images/bin.gif" width="16" height="16" alt="delete" /></a>   
                                        <?php
                                    }else if((int)$rows_group['count'] > 0 && $rows['id']==$_SESSION['idgu']){
										?>
									<a href="" onclick="javascript: confirm('Bạn hiện đang là thành viên của nhóm này.\n nếu bạn muốn xóa xin vui lòng liên hệ quản trị cấp cao hơn.\n Nếu quản trị cao nhất thì xin vui lòng liên hệ coder.');"><img src="images/bin.gif" width="16" height="16" alt="delete" /></a> 	
										<?php
									}else{
                                        ?>
                                    <a href="?mod=user&act=delete_group&ug_id=<?php echo $rows['id']; ?>" onclick="return confirm('BẠN CÓ CHẮC CHẮN MUỐN XÓA KHÔNG????')"><img src="images/bin.gif" width="16" height="16" alt="delete" /></a>
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