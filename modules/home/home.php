<?php
if($_SESSION['ok']!=1){
	header('location: index.php?mod=member&act=login');
	break;
}	
?>
		<div class="container_12">
            <!-- Dashboard icons -->
            <div class="grid_7">
            	<?php
                $q_g = "select permalink ,name from tbl_link as t1, tbl_permision as t2 where t1.id = t2.modules_id and t2.group_user_id = {$_SESSION['idgu']}";
				$rs_g = mysql_query($q_g);
				$per = array();
				while($ro_g = mysql_fetch_array($rs_g)){
					$per[] = $ro_g['permalink'];
				}
					
				if(in_array("news", $per))
					echo "<a href='index.php?mod=news&act=insert' class='dashboard-module'>
                    <img src='images/Crystal_Clear_write.gif' width='64' height='64' alt='edit' />
                    <span>Viết bài mới</span> </a>";
					
				if(in_array("image", $per))
					echo "<a href='index.php?mod=image&act=upload' class='dashboard-module'>
                    <img src='images/Crystal_Clear_file.gif' width='64' height='64' alt='edit' />
                    <span>Upload file</span></a>";
					
				if(in_array("category", $per))
					echo "<a href='index.php?mod=category&act=insert' class='dashboard-module'>
                    <img src='images/Crystal_Clear_files.gif' width='64' height='64' alt='edit' />
                    <span>Thêm danh mục</span></a>";
					
				if(in_array("setup", $per))
					echo "<a href='index.php?mod=menu' class='dashboard-module'>
                    <img src='images/Crystal_Clear_settings.gif' width='64' height='64' alt='edit' />
                    <span>Cài đặt</span></a>";
				?>
                	
                 
                    
                    
                    
                    <a href='index.php?mod=member&act=edit&u_id=<?php echo $_SESSION['uid']?>' class='dashboard-module'>
                    <img src='images/Crystal_Clear_user.gif' width='64' height='64' alt='edit' />
                    <span>Hồ sơ cá nhân</span></a>
                    
                    
                <div style="clear: both"></div>
            </div> <!-- End .grid_7 -->
            
            <!-- Account overview -->
            <div class="grid_5">
                <div class="module">
                <?php
                    $result = mysql_query("SELECT * FROM tbl_user WHERE id={$_SESSION['uid']}");
                    if(!($user = mysql_fetch_array($result)))
						die("Không truy xuất được cơ sở dữ liệu.");
                ?>
                        <h2><span>Thông tin thành viên</span></h2>
                        
                        <div class="module-body">
                        
                        	<p>
                                <strong>Tên thành viên: </strong><?php echo $user['first_name']." ".$user['last_name']; ?><br />
                                <strong>Thời điểm tham gia: </strong><?php echo $user['reg_date']; ?><br />
                                <strong>Thông tin thêm: </strong><br />
                                &nbsp;&nbsp;&nbsp;&nbsp;Năng lực:&nbsp;<?php echo $user['bio']; ?><br /><br />
                                &nbsp;&nbsp;&nbsp;&nbsp;Điện thoại:&nbsp;<?php echo $user['phone']; ?><br /><br />
								&nbsp;&nbsp;&nbsp;&nbsp;Yahoo:&nbsp;<?php echo $user['yahoo']; ?><br /><br />
                               	&nbsp;&nbsp;&nbsp;&nbsp;Mail:&nbsp;<?php echo $user['email']; ?><br />:<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;Địa chỉ:&nbsp;<?php echo $user['add']; ?><br /><br />
                                    
                            </p>
                            
                        	<p>
                                Muốn chỉnh sửa thông tin?<br />
                                <a href="index.php?mod=member&act=edit&u_id=<?php echo $_SESSION['uid']?>">click here</a><br />
                            </p>

                        </div>
                </div>
                <div style="clear:both;"></div>
            </div> <!-- End .grid_5 -->
            
            <div style="clear:both;"></div>



        </div> <!-- End .container_12 -->
