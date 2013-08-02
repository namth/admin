<?php
	$rp = $_GET["rp"]?$_GET["rp"]:0;
	switch($rp){
		case 1:
			$messages = "<span class='notification n-success'>Tùy chọn đã được cập nhật</span>";
			break;
		case 2:
			$messages = "<span class='notification n-error'>Hãy nhập đầy đủ thông tin.</span>";
			break;	
	}
		 
?>
<div class="container_12">
<!-- Form elements -->    
<div class="grid_8 prefix_2 suffix_2">
<?php if(!empty($messages)) echo $messages; ?>   
    <div class="module">
         <h2><span>Tùy chọn</span></h2>
         
         <div class="module-body">
            <form id="option" action="index.php?mod=setup&act=process_edit" method="post">
            <?php 
                $i=1;
                $q = "SELECT id, name, value FROM  tbl_option where lang_id = $lang";
                $r = mysql_query($q);
                while($opt = mysql_fetch_array($r)){
            ?>
                <p>
                    <label><?php echo $i++.". ".$opt['name']; ?></label>
                    <input name="opvalue[]" type="text" class="input-long" value="<?php echo $opt['value']; ?>" />
                    <input name="optionID[]" type="hidden" value="<?php echo $opt['id']; ?>" />
                </p>
            <?php
                }
            ?>
                
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
