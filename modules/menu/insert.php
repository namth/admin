<?php 
    if(($_SERVER['REQUEST_METHOD'] == 'POST')&& isset($_POST['submit'])){
        if(empty($_POST['menu_name'])){
            $errors[] = "menu_name";
        }else{
            $menu_name = mysql_real_escape_string(strip_tags($_POST['menu_name']));
        }
        if(empty($errors)){
            $q = "INSERT INTO tbl_link(name,position,type) VALUES ('{$menu_name}',0,'menu')";
            $r = mysql_query($q);
            header("location: index.php?mod=menu&rp=1&ad=ins&mn=$menu_name");
        }else{
            header("location: index.php?mod=menu&rp=2");
        }
    }elseif(isset($_POST['cancel'])){
        redirect_to("css-admin/admin.php");
    }
?>
<div class="container_12">

    <!-- Form elements -->    
    <div class="grid_12">
    <?php if(!empty($messages)) echo $messages;?>
        <div class="module">
             <h2><span>Thêm <?php echo $type; ?> mới</span></h2>
                
             <div class="module-body">
                <form id="add_menu" action="" method="post">
                
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