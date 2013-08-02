<?php 
    //Xac nhan bien GET ton tai va dung loai du lieu cho phep.
    if(isset($_GET['lid']) && filter_var($_GET['lid'], FILTER_VALIDATE_INT, array('min_range'=>0))){
        $lid = $_GET['lid'];
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $errors = array();
        //Kiem tra xem anh co duoc chon khong
        if(isset($_POST["imgID"])){
            $imgID = $_POST["imgID"];
        } else {
            $errors[] = "imgID";
        }
        
		//Kiem tra xem groups co dung dinh dang khong
        if(!isset($_POST['groups']) && filter_var($_POST['groups'], FILTER_VALIDATE_INT, array('min_range'=>0))){
            $errors[] = "groups";
        }else{
            $groups = $_POST['groups'];
            $type = $groups==0?'images':'image';
        }
        if(empty($errors)){
            foreach($imgID as $img){
                $q = "UPDATE tbl_link SET level={$groups}, type='{$type}' WHERE id={$img}";
                $r = mysql_query($q); 
            }
        }
    }
	
	$menu = $_GET['mn']?$_GET['mn']:"";
	$report = $_GET['rp']?$_GET['rp']:"";
	$act_details = $_GET['ad']?$_GET['ad']:"";
	switch($report){
		case "1":
			if($_GET['ad']=="ins")
				$messages = report($report, "Thêm chuyên mục<b> {$menu}</b> thành công.");
			else if($_GET['ad']=="del")
				$messages = report($report, "Xóa chuyên mục<b> {$menu}</b> thành công.");
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
            <!-- Dashboard icons -->
            <div class="grid_12">
            <?php if(!empty($messages)) echo $messages;?>
                <div class="bottom-spacing">
                    <!-- Button -->
                    <div class="float-right">
                        <a href="?mod=image&act=insert" class="button">
                        	<span>Tạo chuyên mục ảnh mới <img src="images/plus-small.gif" width="12" height="9" alt="New article" /></span>
                        </a>
                    <?php
                        if(isset($_GET['lid'])){
                    ?>
                        <a onclick="return confirm('Nếu xóa chuyên mục này thì toàn bộ ảnh thuộc chuyên mục này sẽ mất.\nNếu bạn muốn giữ lại ảnh vui lòng chuyển sang chuyên mục khác.\n BẠN CÓ CHẮC CHẮN MUỐN XÓA KHÔNG????')" href="?mod=image&act=delete_level&lid=<?php echo $_GET['lid']; ?>&type=image" class="button">
                        	<span>Xóa chuyên mục này <img src="images/cross-on-white.gif" width="9" height="9" alt="New article" /></span>
                        </a>
                    <?php
                        }
                    ?>
                    </div>
                    
                </div>
            <form id="manager_imgs" action="" method="POST">
            <ul class="grid_images">
                <?php
                $q = "SELECT id, image FROM tbl_link WHERE";
                if(!isset($_GET['lid'])){
                    $q .= " type='images' ";
                }else{
                    $q .= " type='image' AND level={$lid}";
                }
                $r = mysql_query($q);
                if(mysql_num_rows($r)>0){
                    while($img = mysql_fetch_array($r)):
                ?>
                <li><label for="<?php echo $img['id']; ?>">
                    <img src="<?php echo $sitepath."uploads/".$img['image']; ?>"/></label>
                    <input type="checkbox" id="<?php echo $img['id']; ?>" value="<?php echo $img['id']; ?>" style="display: block;" name="imgID[]" />
                    <a href="?mod=image&act=delete&lid=<?php echo $img['id']; ?>" class="delete_icon">X</a>
                </li>
                <?php endwhile; } ?>
            </ul>
            <div style="clear: both"></div>
            <fieldset style="float: left;" class="grid_8">
                <label>Chuyển đến mục: </label>
                <select class="input-short" name="groups">
                <option value="0">Ảnh chưa phân mục</option>
                <?php
                    $q = "SELECT id, name FROM tbl_link WHERE type='image' AND level=0";
                    $r = mysql_query($q);
                    while($links = mysql_fetch_array($r)){
                ?>
                    <option value="<?php echo $links['id']; ?>" ><?php echo $links['name']; ?></option>
                    
                <?php } ?>
                </select>
                <input class="submit-green" type="submit" value="Chuyển" name="submit" /> 
            </fieldset>
            
            </form>
            </div> <!-- End .grid_12 -->
            
            <div style="clear:both;"></div>



        </div> <!-- End .container_12 -->
