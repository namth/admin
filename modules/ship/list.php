<?php
    $menu = $_GET['mn']?$_GET['mn']:"";
	$report = $_GET['rp']?$_GET['rp']:"";
	$act_details = $_GET['ad']?$_GET['ad']:"";
	switch($report){
		case "1":
			if($_GET['ad']=="ins")
				$messages = report($report, "Thêm địa điểm <b> {$menu}</b> thành công.");
			else if($_GET['ad']=="del")
				$messages = report($report, "Xóa địa điểm<b> {$menu}</b> thành công.");
			else if($_GET['ad']=="edit")
				$messages = report($report, "Sửa địa điểm <b>id = {$menu}</b> thành công.");
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
                        <a href="?mod=ship&act=insert" class="button">
                        	<span>Thêm địa điểm mới <img src="images/plus-small.gif" width="12" height="9" alt="New article" /></span>
                        </a>
                    </div>
                    
                </div>
                
                
                <!-- Example table -->
                <div class="module">
                	<h2><span>Danh sách địa điểm</span></h2>
                    
                    <div class="module-table-body">
                    	<form action="">
                        <table id="myTable" class="tablesorter">
                        	<thead>
                                <tr>
                                    <th style="width:5%">ID</th>
                                    <th style="width:25%">Địa chỉ</th>
                                    <th style="width:25%">Thành phố trực thuộc</th>
                                    <th style="width:13%">Mức phí</th>
                                    <th style="width:24%">Link thân thiện</th>
                                    <th style="width:8%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $reusult = mysql_query("SELECT * FROM  tbl_shipping_fee WHERE level = 0");
                                while($rows = mysql_fetch_array($reusult)){
                            ?>
                                <tr>
                                    <td class="align-center"><?php echo $rows['id']; ?></td>
                                    <td><a href="?mod=ship&act=edit&ship_id=<?php echo $rows['id']?>"><b><?php echo $rows['add']; ?></b></a></td>
                                    <td>Cấp trung ương</td>
                                    <td><?php echo number_format($rows['fee']); ?>&nbsp;VND</td>
                                    <td><?php echo $rows['seolink']; ?></td>
                                    <td>
                                        <input type="checkbox" />
                                        <a href="?mod=ship&act=edit&ship_id=<?php echo $rows['id']?>"><img src="images/pencil.gif" width="16" height="16" alt="edit" /></a>
                                        <?php
                                            $ship_id = $rows['id'];
                                            $rs_ship = mysql_query("select count(*) as count from  tbl_shipping_fee where lang_id = $lang  and level = $ship_id");
                                            $rows_ship = mysql_fetch_array($rs_ship);
                                            if((int)$rows_ship['count'] > 0)
                                                echo "<a href='#' onclick=\"javascript: alert('Vui lòng xóa danh mục trực thuộc danh mục này. trước khi xóa nó.');\"><img src='images/bin.gif' width='16' height='16' alt='delete' /></a>"; 
                                            else
                                                //echo "<a href='#' onclick=\"javascript: alert('Vui lòng xóa danh mục trực thuộc danh mục này. trước khi xóa nó.');\"><img src='images/bin.gif' width='16' height='16' alt='delete' /></a>"; 
                                                echo "<a href='?mod=ship&act=delete&ship_id=".$rows['id']."' onclick=\"return confirm('BẠN CÓ CHẮC CHẮN MUỐN XÓA KHÔNG????')\"><img src='images/bin.gif' width='16' height='16' alt='delete' /></a>";
                                            
                                        ?>	
                                    </td>
                                </tr>
                            
							
							<?php
							echo fetch_ship($rows['id'], $rows['add'], 0);
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