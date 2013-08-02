		<div class="container_12">
            <!-- Form elements -->    
            <div class="grid_12">
                <div class="module">
                     <h2><span>Thêm <?php echo $type; ?> mới</span></h2>
                        
                     <div class="module-body">
                        <form id="add_menu" action="index.php?mod=image&act=process_insert" method="post">
                        
                            <p>
                                <label>Tên <?php echo $type; ?>: </label>
                                <input type="text" class="input-medium" name="menu_name" />
                                <?php
                                    if(isset($errors) && in_array("menu_name", $errors)){
                                        echo "<span class='notification-input ni-error'>Bạn chưa điền tên menu</span>";
                                    }
                                ?>
                            </p>
                            
							<fieldset>
                                <input class="submit-green" type="submit" value="Xác nhận" name="submit" /> 
                                <input class="submit-gray" type="submit" value="Quay lại" name="cancel" />
                            </fieldset>
                        </form>
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>
            </div> <!-- End .grid_12 -->
                
            <div style="clear:both;"></div>
        </div> <!-- End .container_12 -->