<?php 
    //Xac nhan bien GET ton tai va dung loai du lieu cho phep.
    if(isset($_GET['mid'])&& filter_var($_GET['mid'], FILTER_VALIDATE_INT, array('min_range'=>0))){
        $mid = $_GET['mid'];
    }
	
    $menu = $_GET['mn']?$_GET['mn']:"";
	$report = $_GET['rp']?$_GET['rp']:"";
	$act_details = $_GET['ad']?$_GET['ad']:"";
	switch($report){
		case "1":
			if($_GET['ad']=="link")
				$messages_rp = report($report, "Thêm Liên kết <b> {$menu}</b> thành công.");
			else if($_GET['ad']=="cat")
				$messages_rp = report($report, "Thêm danh mục <b> {$menu}</b> thành công.");
			else if($_GET['ad']=="new")
				$messages_rp = report($report, "Thêm tin tức  <b> {$menu}</b> thành công.");
			break;
		case "2":
			$messages_rp = report($report, "Có lỗi xảy ra, hãy kiểm tra lại.");
			break;
		case "3":
			$messages_rp = report($report, "Có lỗi xảy ra.");
			break;
	}
?>        
		<div class="container_12">
        <?php if(!empty($messages_rp)) echo $messages_rp;?>
            <div class="grid_4">
            <!-- Form elements -->  
			<form id="add_to_menu" action="index.php?mod=menu&act=process_edit_level" method="post">
            <input type="hidden" name="mid" value="<?php echo $mid;?>" />	
                <div class="module">
                     <h2><span>Liên kết</span></h2>
                     <div class="module-body">
                            <p>
                                <label>Tên: </label>
                                <input type="text" class="input-long" name="link_name" />
                            </p>
                            <p>
                                <label>Link:</label>
                                <input type="text" class="input-long" name="permalink" />
                            </p>
                            <fieldset>
                                <input class="submit-green" type="submit" value="Thêm vào menu" name="submit_link" /> 
                            </fieldset>
                     </div> <!-- End .module-body -->
                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            
                <div class="module">
                     <h2><span>Danh mục</span></h2>
                     <div class="module-body">
						<legend>Lựa chọn danh mục bài viết</legend>
						<ul class="grid_12">
                        <?php
                            $q = "SELECT id, name FROM tbl_category";
                            $r = mysql_query($q);
                            if(mysql_affected_rows($conn) > 0){
                            while($cats = mysql_fetch_array($r)){
								$qr = "select * from tbl_category where level = {$cats['id']}";
								$rs = mysql_query($qr);
								if(mysql_affected_rows($conn)==0){
                        ?>
							<li class="grid_6"><label><input type="checkbox" name="catID[]" value="<?php echo $cats['id'] ?>" /> <?php echo $cats['name'] ?></label></li>
                        <?php } } }?>
						</ul>
						<fieldset>
							<input class="submit-green" type="submit" value="Thêm vào menu" name="submit_cat" /> 
						</fieldset>
                     </div> <!-- End .module-body -->
                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
                
                <div class="module">
                     <h2><span>Bài viết</span></h2>
                     <div class="module-body">
                            <p>
                                <label>ID bài viết: </label>
                                <input type="text" class="input-short" name="post_id" />
                                <?php
                                    if(isset($errors) && in_array("post_id", $errors)){
                                        echo "<span class='notification-input ni-error'>ID không tồn tại</span>";
                                    }
                                ?>
                            </p>
                            <p>
                                <label>Tên hiển thị: </label>
                                <input type="text" class="input-long" name="post_name" />
                            </p>
                            <fieldset>
                                <input class="submit-green" type="submit" value="Thêm vào menu" name="submit_post" /> 
                            </fieldset>
                     </div> <!-- End .module-body -->
                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </form>
            </div>
			
			<!-- View menu to sort by position -->
			<div class="grid_8">
            <?php if(!empty($messages)) echo $messages; ?>
            <span class="notification n-success" id="response" ></span>
                <div class="module">
					<h2><span>Sắp xếp: </span></h2>
					<div class="module-body">
						<ul class="list_box">
                            <?php 
                                $q = "SELECT id, name, permalink, position FROM tbl_link WHERE level={$mid} AND type='menu' ORDER BY position ASC";
                                $r = mysql_query($q);
                                if(mysql_affected_rows($conn) > 0):
                                while($m = mysql_fetch_array($r)):
                            ?>
							<li id="arrayorder_<?php echo $m['id']; ?>"><?php echo "{$m['position']} {$m['name']} ({$m['permalink']})"; ?>
								<a href="delete_link.php?lid=<?php echo $m['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa mục <?php echo $m['name']; ?>?');"><img src="images/cross-on-white.gif" width="16" height="16" alt="delete" /></a>
								<a href="edit_child_menu.php?child=<?php echo $m['id']; ?>"><img src="images/pencil.gif" width="16" height="16" alt="edit" /></a>
                                <a href="edit_menu.php?mid=<?php echo $m['id']; ?>"><img src="images/right-arrow.png" width="16" height="16" alt="edit" /></a>
							</li>
                            <?php endwhile; endif; ?>
						</ul>
					</div><!-- End .module-body -->
				</div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div> <!-- End .grid_4 -->
						
            <div style="clear:both;"></div>
        </div> <!-- End .container_12 -->
