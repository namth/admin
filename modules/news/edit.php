<?php 
    $nid = $_GET['nid']?$_GET['nid']:0;
    $q = "SELECT title, thumbnail, content, seolink FROM tbl_news WHERE id={$nid}";
    $r = mysql_query($q);
    //Neu category ton tai trong database thi xuat du lieu ra ngoai trinh duyet
    if(mysql_num_rows($r)){
		$ro = mysql_fetch_array($r);
		
        list($title, $thumbnail, $content, $seolink) = $ro;
    }else{
        $messages = "<span class='notification-input ni-error'>News ID không tồn tại</span>";
    }
    
?>
<script language = "javascript">
$(document).ready(function() { 
	var title = $('#title');
	var seolink = $('#seolink');
	var content = $('#content');
	
	title.blur(validatetitle);
	seolink.blur(validateseolink);	
	
	title.keyup(validatetitle);
	seolink.keyup(validateseolink);
	
	
	$('#frm_news').submit(function(){
		if(validatetitle() & validatecheckseolink() & validatecatid()){
			return true
		}else{
			if(validatecatid() == false)
				document.getElementById("rpcatid").innerHTML = "<span class=\"notification-input ni-error\">Bạn phải chọn ít nhất 1 danh mục </span>";
			return false;
		}
	});
	
	function validatetitle(){
		var title = $("#title").val();
		if(title.length == 0){
			document.getElementById("rptitle").innerHTML = "<span class=\"notification-input ni-error\">Bạn chưa điền tiêu đề của tin tức</span>";
			return false;
		}else{
			document.getElementById("rptitle").innerHTML = "<span class=\"notification-input ni-correct\">Bạn có thể sủ dụng tiêu đề này</span>";
			return true;
		}	
	}
	
	function validatecheckseolink(){
		var check_seolink = $("#check_seolink").val();
		var seolink = $("#seolink").val();
		if(seolink == ""){
			document.getElementById("rpseolink").innerHTML = "<span class=\"notification-input ni-correct\">Hệ thống tự sinh seolink</span>";
			return true;
		}else{
			if(seolink == '<?php echo $seolink?>')
				document.getElementById("rpseolink").innerHTML = "<span class=\"notification-input ni-correct\">Giữ nguyên seolink cũ</span>";
			if(check_seolink == "error")
				return false;	
			else
				return true;
		}
	}
	
	function validateseolink(){
		var seolink = $("#seolink").val();
		if(seolink != ""){
			$.ajax({
				type: "get",
				url: "<?php echo $sitepath; ?>admin/includes/seolink.php",
				data: "seolink="+ seolink +"&mod=news&old=<?php echo $seolink?>",
				success: function(response){
					switch(response){
						case "yes":
							$('#rpseolink').html("<span class=\"notification-input ni-error\">Đã tồn tại seolink này! Vui lòng nhập seolink khác</span>");
							frm_news.check_seolink.value = "error";
							break;
						case "old":
							$('#rpseolink').html("<span class=\"notification-input ni-correct\">Giữ nguyên seolink cũ</span>");
							frm_news.check_seolink.value = "";
							break;
						case "no":
							$('#rpseolink').html("<span class=\"notification-input ni-correct\">Bạn có thể sử dụng seolink này</span>");
							frm_news.check_seolink.value = "";
							break;	
					}
				}
			});
		}else{
			document.getElementById("rpseolink").innerHTML = "<span class=\"notification-input ni-correct\">Hệ thống tự sinh seolink</span>";
		}
	}
	
	function validatecatid(){
	var check_cat = false;
	var contents, vals = [], p_contents =  document.forms['frm_news']['catID[]'];
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
	var contents, vals = [], p_contents =  document.forms['frm_news']['catID[]'];
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
		document.getElementById("rpcatid").innerHTML = "<span class=\"notification-input ni-error\">Bạn phải chọn ít nhất 1 danh mục</span>";
}
</script>

<div class="container_12">
    <!-- Form elements -->    
    <div class="grid_12">
    
        <div class="module">
             <h2><span>Chỉnh sửa tin tức</span></h2>
             <div class="module-body">
                <form id="frm_news" action="index.php?mod=news&act=process_edit" method="post" enctype="multipart/form-data" name="frm_news">
                <input type="hidden" name="news_id" value="<?php echo $nid?>"/>
                    <div>
                        <?php if(!empty($messages)) echo $messages;?>
                    </div>
                    <p>
                        <label>Tiêu đề tin tức</label>
                        <input id="title" name="post_title" type="text" class="input-medium" value="<?php echo $title?>" />
                        <span id = "rptitle" style="font-style:italic; font-size:11px; color:#CCC">Nhập tiêu đề của tin tức</span>
                    </p>
                    <p>
                        <label>Link thân thiện (có thể để trống)</label>
                        <input id="seolink" name="seolink" type="text" class="input-medium"  value="<?php echo $seolink ?>"/>
                        <span id = "rpseolink" style="font-style:italic; font-size:11px; color:#CCC">Nhập seolink (nếu bạn để trống hệ thống sẽ tự sinh)</span>
                        <input type="hidden" value="" id="check_seolink" />
                    </p>
                    <fieldset>
                        <legend>Chọn danh mục bài viết   <span id = "rpcatid"  style="font-style:italic; font-size:11px; color:#CCC">(Bạn phải chọn ít nhất 1 trong các danh mục sau)</span></legend>
                        <ul class="grid_8">
                        <?php
                            $q1 = "SELECT category_id FROM  tbl_cat_new WHERE new_id={$nid}";
                            $r1 = mysql_query($q1);
                            while($cat = mysql_fetch_array($r1)){
                                $catid[] = $cat['category_id'];
                            }
                            $q = "SELECT id, name FROM tbl_category where id <> 2 and grouptype = 2";
                            $r = mysql_query($q);
                            while($cats = mysql_fetch_array($r)){
                        ?>
                            <li class="grid_3"><label><input name="catID[]" type="checkbox" value="<?php echo $cats['id'] ?>" id="cb1"  onclick='check()' <?php if(in_array($cats['id'],$catid)) echo " checked='yes'";?>/> <?php echo $cats['name'] ?></label></li>
                        <?php }?>
                        </ul>
                    </fieldset>
                    <p>
                        <label>Ảnh bài viết</label>
                        <input name="thumbnail" type="file" class="input-medium" />
                        <?php
                         if(!empty($post['thumbnail'])){
                            echo "<br/><img src='".$sitepath."uploads/{$post['thumbnail']}' height='105' />";
                         }
                        ?>
                    </p>
                    <fieldset>
                        <label>Nội dung</label>
                        <textarea id="content" class="ckeditor" rows="25" cols="90" name="post_content"><?php echo $content; ?></textarea> 
                        
                    </fieldset>
                    
                    <fieldset>
                        <input class="submit-green" type="submit" value="Đăng bài" name="submit"/> 
                        <input class="submit-gray" type="submit" value="Hủy" name="cancel"/>
                    </fieldset>
                </form>
             </div> <!-- End .module-body -->
        </div>  <!-- End .module -->
		<div style="clear:both;"></div>
    </div> <!-- End .grid_12 -->
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->
