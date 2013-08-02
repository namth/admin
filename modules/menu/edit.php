
<div class="container_12">
	<?php 
		//Xac nhan bien GET ton tai va dung loai du lieu cho phep.
		if(isset($_GET['child'])&& filter_var($_GET['child'], FILTER_VALIDATE_INT, array('min_range'=>0))){
				$child = $_GET['child'];
		}else{
			?>
			<SCRIPT LANGUAGE="JavaScript">
			history.back();
			</SCRIPT>
			<?php
		}
		$q = "SELECT name, permalink, image FROM tbl_link WHERE id={$child}";
		$r = mysql_query($q);
		//Neu menu con ton tai trong database thi xuat du lieu ra ngoai trinh duyet
		if(mysql_num_rows($r) == 1){
			list($name, $permalink, $image) = mysql_fetch_array($r);
		}else{
			$messages = "<span class='notification-input ni-error'>ID menu con không tồn tại</span>";
		}
		
		if(!empty($messages)) echo $messages; 
	?>
	<!-- Form elements -->    
	<div class="grid_12">
	
		<div class="module">
			 <h2><span>Sửa một mục con</span></h2>
				
			 <div class="module-body">
				<form id="edit_menu" action="index.php?mod=menu&act=process_edit&child=<?php echo $child; ?>" method="post" enctype="multipart/form-data">
				
					<p>
						<label>Tên hiển thị: </label>
						<input type="text" class="input-medium" name="link_name" value="<?php echo $name; ?>" />
						<?php
							if(isset($errors) && in_array("name", $errors)){
								echo "<span class='notification-input ni-error'>Bạn chưa điền tên hiển thị</span>";
							}
						?>
					</p>
					
					<p>
						<label>Liên kết tới:</label>
						<input type="text" class="input-medium" name="permalink" value="<?php echo $permalink; ?>" />
					</p>
					
					<p>
						<label>Ảnh menu (nếu có)</label>
						<input name="thumbnail" type="file" class="input-medium" />
					<?php if(isset($image)) { ?>
						<br />
						<img src="../uploads/<?php echo $image; ?>" />    
					<?php } ?>
					</p>
					
					<fieldset>
						<input class="submit-green" type="submit" value="Xác nhận" name="submit" /> 
						<input class="submit-gray" type="submit" value="Hủy" name="cancel" />
					</fieldset>
				</form>
			 </div> <!-- End .module-body -->

		</div>  <!-- End .module -->
		<div style="clear:both;"></div>
	</div> <!-- End .grid_12 -->
		
	<div style="clear:both;"></div>
</div> <!-- End .container_12 -->
