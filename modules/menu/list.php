<?php
    $menu = $_GET['mn']?$_GET['mn']:"";
	$lname = $_GET['lname']?$_GET['lname']:"";
	$report = $_GET['rp']?$_GET['rp']:"";
	$act_details = $_GET['ad']?$_GET['ad']:"";
	
	switch($report){
		case "1":
			if($_GET['ad']=="ins")
				$messages = report($report, "Thêm menu <b> {$menu}</b> thành công.");
			else if($_GET['ad']=="del"){
				if($menu!="")
					$messages = report($report, "Xóa đường dẫn <b> {$lname}</b> khỏi menu <b> {$menu} </b>thành công.");
				else
					$messages = report($report, "Xóa menu <b> {$lname} </b>thành công.");
			}else if($_GET['ad']=="edit")
				$messages = report($report, "Sửa tin tức  <b>id = {$menu}</b> thành công.");
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
    <div class="float-right" style="margin-top: -25px;">
        <a href="index.php?mod=menu&act=insert" class="button">
            <span>Thêm menu mới <img src="images/plus-small.gif" width="12" height="9" alt="New article" /></span>
        </a>
    </div>
    <div style=" width:100%; " id="check"><div style="width:100%">&nbsp;</div><?php if(!empty($messages)) echo $messages;?></div>
    <?php
        //Dem so menu co trong CSDL
        $r1 = mysql_query("SELECT COUNT(id) AS count FROM tbl_link WHERE level=0 AND type='menu'");
        $count = mysql_fetch_array($r1);
        //Tinh so col hien thi tren trinh duyet, toi da la 4
        if(($count['count']<5)&&($count['count']!=0)){
            $col = 12/$count['count'];
        }else $col=4;
        
        $q = "SELECT id, name FROM tbl_link WHERE level=0 AND type='menu'";
        $r = mysql_query($q);
        if(mysql_affected_rows($conn) > 0 ):
        while($menu = mysql_fetch_array($r)){
    ?>
    <!-- Form elements -->
    <div class="grid_<?php echo $col; ?>">
        <div class="module">
            <h2><span><?php echo $menu['name']; ?>
                <a href="index.php?mod=menu&act=delete&lid=<?php echo $menu['id']; ?>&lname=<?php echo $menu['name']?>" onclick="return confirm('Bạn có chắc chắn muốn xóa mục <?php echo $menu['linkname']; ?>?');" style="float: right;padding-right: 15px;"><img src="images/cross-on-white.gif" width="16" height="16" alt="delete" /></a>
                <a href="index.php?mod=menu&act=edit&child=<?php echo $menu['id']; ?>" style="float: right;padding-right: 7px;"><img src="images/pencil.gif" width="16" height="16" alt="edit" /></a>
                <a href="index.php?mod=menu&act=edit_level&mid=<?php echo $menu['id']; ?>" style="float: right;padding-right: 5px;"><img src="images/right-arrow.png" width="16" height="16" alt="edit" /></a>
            </span></h2>
            <div class="module-body">
                <ul class="list_box">
                <?php
                    $q1 = "SELECT id,name,position FROM tbl_link WHERE tbl_link.level={$menu['id']} AND type='menu' ORDER BY position ASC";
                    $r1 = mysql_query($q1);
                    while($child = mysql_fetch_array($r1)){
                ?>
                    <li><?php echo $child['position']." ".$child['name']; ?>
                        <a href="index.php?mod=menu&act=delete&lid=<?php echo $child['id']; ?>&mn=<?php echo $menu['name']?>&lname=<?php echo $child['name'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa mục <?php echo $child['name']; ?>?');"><img src="images/cross-on-white.gif" width="16" height="16" alt="delete" /></a>
                        <a href="index.php?mod=menu&act=edit&child=<?php echo $child['id']; ?>"><img src="images/pencil.gif" width="16" height="16" alt="edit" /></a>
                        <a href="index.php?mod=menu&act=edit_level&mid=<?php echo $child['id']; ?>"><img src="images/right-arrow.png" width="16" height="16" alt="edit" /></a>
                    </li>
                <?php } ?>
                </ul>
            </div><!-- End .module-body -->
        </div>  <!-- End .module -->
        <div style="clear:both;"></div>
    </div><!-- End .grid_6 --> 
    <?php } endif; ?>
    <div style="clear:both;"></div>
    
</div> <!-- End .container_12 -->
