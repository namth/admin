<?php
    $menu = $_GET['mn']?$_GET['mn']:"";
	$report = $_GET['rp']?$_GET['rp']:"";
	$act_details = $_GET['ad']?$_GET['ad']:"";
	switch($report){
		case "1":
			if($_GET['ad']=="ins")
				$messages = report($report, "Thêm sản phẩm <b> {$menu}</b> thành công.");
			else if($_GET['ad']=="del")
				$messages = report($report, "Xóa sản phẩm<b> {$menu}</b> thành công.");
			else if($_GET['ad']=="edit")
				$messages = report($report, "Sửa sản phẩm  <b>id = {$menu}</b> thành công.");
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
                <a href="?mod=product&act=insert" class="button">
                    <span>Thêm sản phẩm mới <img src="images/plus-small.gif" width="12" height="9" alt="New article" /></span>
                </a>
            </div>
            
        </div>
        
        
        <!-- Example table -->
        <div class="module">
            <h2><span>Danh sách sản phẩm</span></h2>
            
            <div class="module-table-body">
                <form action="">
                <table id="myTable" class="tablesorter">
                    <thead>
                        <tr>
                            <th style="width:5%">ID</th>
                            <th style="width:13%">Hình ảnh</th>
                            <th style="width:30%">Tên sản phẩm</th>
                            <th style="width:30%">Link thân thiện</th>
                            <th style="width:13%">Danh mục gốc</th>
                            <th style="width:10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $result = mysql_query("SELECT * FROM  tbl_products") or die("Query {$q} \n<br/> MySQL Error: " . mysql_error($dbc));
                        while($rows = mysql_fetch_array($result)){
                        $cat_id = $rows['category_id'];
                        $rs_cat = mysql_query("select name from  tbl_category where id = $cat_id");
                        $rows_cat = mysql_fetch_array($rs_cat);
                    ?>
                        <tr>
                            <td class="align-center"><?php echo $rows['id']; ?></td>
                            <td class="align-center"><img src="../uploads/<?php echo $rows['thumbnail']; ?>" height="60">
                            </td>
                            <td><a href="?mod=product&act=edit&pro_id=<?php echo $rows['id']?>"><?php echo $rows['name']; ?></a></td>
                            <td><?php echo $rows['seolink']; ?></td>
                            <td><?php echo $rows_cat['name']; ?></td>
                            <td>
                                <input type="checkbox" />
                                <a href="?mod=product&act=edit&pro_id=<?php echo $rows['id']?>"><img src="images/pencil.gif" width="16" height="16" alt="edit" /></a>
                                <?php 
                                //Dem so luong comment cua bai viet
                                    $pro_id = $rows['id'];
                                    $q_comment = "SELECT COUNT(id) AS count FROM  tbl_comments WHERE product_id=$pro_id";
                                    $rs_comment = mysql_query($q_comment);
                                    $num = mysql_fetch_array($rs_comment);
                                
                                ?>
                                <a href="#"><img src="images/balloon.gif" width="16" height="16" alt="comments" /><?php echo $num['count']; ?></a>
                                <a href="?mod=product&act=delete&pro_id=<?php echo $rows['id']?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm <?php echo $rows['name'] ?>?');"><img src="images/bin.gif" width="16" height="16" alt="delete" /></a>
                            </td>
                        </tr>
                    <?php } ?>
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
        
                <div style="clear: both;"></div> 
             </div>
    </div> <!-- End .grid_12 -->
    
    <div style="clear:both;"></div>
    
</div> <!-- End .container_12 -->