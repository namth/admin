<?php  
    $permis = 1;
    if($permis == 1)
        $disable = "";
    else
        $disable = "disabled";

    $menu = $_GET['mn']?$_GET['mn']:"";
	$report = $_GET['rp']?$_GET['rp']:"";
	$act_details = $_GET['ad']?$_GET['ad']:"";
	switch($report){
		case "1":
            if($act_details == "reset")
			     $messages = report($report, "Thiết lại mật khẩu của  <b>{$menu}</b> thành công.");
            else
                 $messages = report($report, "Active lại $menu  <b>{$menu}</b> thành công.");
			break;
		case "2":
            if($act_details == "reset")
			     $messages = report(1, "Thiết lại mật khẩu của  <b>{$menu}</b> thành công.").report(2, "Không gửi được mail tới <b>{$menu}</b>!");
            else
                 $messages = report(2, "Không gửi được mail tới <b>{$menu}</b>!");
			break;
		case "3":
            if($act_details == "reset")
			     $messages = report($report, "Không thể thay đổi được của <b>{$menu}</b> mật khẩu do lỗi hệ thống vui lòng kiểm tra lại.");
            else
                 $messages = report($report, "Không thể active được tài khoản <b>{$menu}</b>. do lỗi hệ thống vui lòng kiểm tra lại.");
			break;
	}
	
	$ug_id = $_GET['ug_id']?$_GET['ug_id']:0;
    $rs = mysql_query("select * from tbl_group_user where id = {$ug_id}");
    if(mysql_affected_rows($conn)>0){
        $ro = mysql_fetch_array($rs);
    }
	
?>
<script language = "javascript">
$(document).ready(function() { 
	var name = $('#name');
	var sumary = $('#sumary');
	
	name.blur(validatename);
	sumary.blur(validatesumary);
	
	name.keyup(validatename);
	sumary.keyup(validatesumary);
	
	$('#frm_groupuser').submit(function(){
		if(validatename() & validatesumary() & validatecatid()){
			return true
		}else{
			if(validatecatid() == false)
				document.getElementById("rpcatid").innerHTML = "<span class=\"notification-input ni-error\">Bạn phải chọn ít nhất 1 phần quản lý </span>";
			return false;
		}
	});
	
	function validatename(){
		var name = $("#name").val();
		if(name.length == 0){
			document.getElementById("rpname").innerHTML = "<span class=\"notification-input ni-error\">Bạn chưa điền tên danh mục</span>";
			return false;
		}else{
			document.getElementById("rpname").innerHTML = "<span class=\"notification-input ni-correct\">Bạn có thể sủ dụng tên này</span>";
			return true;
		}	
	}
	
	function validatesumary(){
		var sumary = $("#sumary").val();
		if(sumary.length == 0){
			document.getElementById("rpsumary").innerHTML = "<span class=\"notification-input ni-error\">Bạn chưa nhập mô tả</span>";
			return false;
		}else{
			document.getElementById("rpsumary").innerHTML = "<span class=\"notification-input ni-correct\">&nbsp;</span>";
			return true;
		}	
	}
	
	function validatecatid(){
	var check_cat = false;
	var contents, vals = [], p_contents =  document.forms['frm_groupuser']['module[]'];
	for(var i=0,elm;elm = p_contents[i];i++) {
		if(elm.checked) {
			check_cat = true;   
		}
	}	
	return check_cat;
}
	
})


function validatecatid(){
	var check_cat = false;
	var contents, vals = [], p_contents =  document.forms['frm_groupuser']['module[]'];
	for(var i=0,elm;elm = p_contents[i];i++) {
		if(elm.checked) {
			check_cat = true;   
		}
	}	
	return check_cat;
}

function check(){
	if(validatecatid())
		document.getElementById("rpcatid").innerHTML = "<span class=\"notification-input ni-correct\">&nbsp;</span>";
	else
		document.getElementById("rpcatid").innerHTML = "<span class=\"notification-input ni-error\">Bạn phải chọn ít nhất 1 phần</span>";
}
</script>
<div class="container_12">
    <!-- Form elements -->    
    <div class="grid_12">
    
        <div class="module">
             <h2><span>Form</span></h2>
             <div class="module-body">
                <form id="frm_groupuser" action="index.php?mod=user&act=process_edit_group&ug_id=<?php echo $ug_id?>" method="post" enctype="multipart/form-data" name="frm_groupuser">
                    <div>
                        <?php if(!empty($messages)) echo $messages;?>
                    </div>
                    <p>
                        <label>Tên chức năng</label>
                        <input id="name" name="name" type="text" class="input-medium"  value="<?php echo $ro['name'];?>"/>
                        <span id = "rpname" style="font-style:italic; font-size:11px; color:#CCC">Nhập tên nhóm quản trị</span>
                    </p>
                    <p>
                        <label>Mô tả <span id = "rpsumary" style="font-style:italic; font-size:11px; color:#CCC">(Nhập mổ tả quyền của nhóm này)</span></label>
                        <textarea id="sumary" name="sumary" class="input-medium" rows="5" ><?php echo $ro['sumary'];?></textarea>
                        
                    </p>
                    <p>
                        <label>Chi tiết</label>
                        <textarea name="detail" class="input-medium" rows="12" ><?php echo $ro['detail'];?></textarea>
                        
                    </p>
                    <fieldset class="grid_12">
                        <legend>Chọn nội dung quản lý <span id = "rpcatid"  style="font-style:italic; font-size:11px; color:#CCC">(Bạn phải chọn ít nhất 1 trong các danh mục sau)</span></legend>
                        <ul class="grid_9">
                        <?php
                            $q1 = "SELECT modules_id FROM  tbl_permision WHERE group_user_id={$ug_id}";
                            $r1 = mysql_query($q1);
                            while($cat = mysql_fetch_array($r1)){
                                $catid[] = $cat['modules_id'];
                            }
                            $q = "SELECT * FROM  tbl_link where type = 'menu_admin'";
                            $r = mysql_query($q);
                            while($cats = mysql_fetch_array($r)){
								$rs_count = mysql_query("select count(*) as count from tbl_link where level = ".$cats['id']);
								$ro_count = mysql_fetch_array($rs_count);
								//echo "select count(*) as count from tbl_link where level = ".$cats['id'];
								if($ro_count['count']==0){
								?>
									<li class='grid_3'><input type='checkbox' name='module[]' onclick='check()' value='<?php echo $cats['id'];?>' id='<?php echo $cats['id'];?>' <?php if(in_array($cats['id'],$catid)) echo " checked='yes'";?> /><label for='<?php echo $cats['id'];?>' style='display:inline;'><?php echo $cats['name'];?></label></li>
								<?php
								}}
                        ?>
                        </ul>
                    </fieldset>
                    <fieldset>
                        <input class="submit-green" type="submit" value="Chỉnh sửa" name="submit" onclick="return check_form_news()"/> 
                        <input class="submit-gray" type="submit" value="Hủy" name="cancel"/>
                    </fieldset>
                </form>
             </div> <!-- End .module-body -->
        </div>  <!-- End .module -->
		<div style="clear:both;"></div>
    </div> <!-- End .grid_12 -->
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->
