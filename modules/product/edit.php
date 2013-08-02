<?php
    $product_id = $_GET['pro_id']?$_GET['pro_id']:0;
    $q = "SELECT * FROM tbl_products WHERE id={$product_id}";
    $r = mysql_query($q);
    //Neu category ton tai trong database thi xuat du lieu ra ngoai trinh duyet
    if(mysql_num_rows($r)){
		$ro = mysql_fetch_array($r);
		
        list($catname, $parents, $seolink) = $ro;
    }else{
        $messages = "<span class='notification-input ni-error'>Product ID không tồn tại</span>";
    }
    
?>
<script language = "javascript">
$(document).ready(function() { 
	var name = $('#name');
	var seolink = $('#seolink');
	var cat_product = $('#cat_product');
	var price = $("#price");
	var amount = $("#amount");
	var sale = $("#sale")
	
	name.blur(validatename);
	seolink.blur(validateseolink);		
	price.blur(validateprice);	
	amount.blur(validateamount);	
	sale.blur(validatesale);
	
	name.keyup(validatename);
	seolink.keyup(validateseolink);
	price.keyup(validateprice);
	amount.keyup(validateamount);
	sale.keyup(validatesale);
	
	cat_product.change(validatecatpro);
	
	
	$('#frm_product').submit(function(){
		if(validatename() & validatecheckseolink() & validatecatpro() & validateprice() & validateamount() & validatesale()){
			return true
		}else{
			return false;
		}
	});
	
	function validatename(){
		var name = $("#name").val();
		if(name.length == 0){
			document.getElementById("rpname").innerHTML = "<span class=\"notification-input ni-error\">Bạn chưa điền tên của sản phẩm</span>";
			return false;
		}else{
			document.getElementById("rpname").innerHTML = "<span class=\"notification-input ni-correct\">Bạn có thể sủ dụng tên này</span>";
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
			if(seolink == '<?php echo $ro['seolink']?>'){
				document.getElementById("rpseolink").innerHTML = "<span class=\"notification-input ni-correct\">Giữ nguyên seolink cũ</span>";
				return true;
			}else{
				if(check_seolink == "error")
					return false;	
				else
					return true;
			}
		}
	}
	
	function validateseolink(){
		
		var seolink = $("#seolink").val();
		if(seolink != ""){
			$.ajax({
				type: "get",
				url: "<?php echo $sitepath; ?>admin/includes/seolink.php",
				data: "seolink="+ seolink +"&mod=product&old=<?php echo $ro['seolink']?>",
				success: function(response){
					switch(response){
						case "yes":
							$('#rpseolink').html("<span class=\"notification-input ni-error\">Đã tồn tại seolink này! Vui lòng nhập seolink khác</span>");
							frm_product.check_seolink.value = "error";
							break;
						case "old":
							$('#rpseolink').html("<span class=\"notification-input ni-correct\">Giữ nguyên seolink cũ</span>");
							frm_product.check_seolink.value = "";
							break;
						case "no":
							$('#rpseolink').html("<span class=\"notification-input ni-correct\">Bạn có thể sử dụng seolink này</span>");
							frm_product.check_seolink.value = "";
							break;	
					}
				}
			});
		}else{
			document.getElementById("rpseolink").innerHTML = "<span class=\"notification-input ni-correct\">Hệ thống tự sinh seolink</span>";
		}
	}
	
	function validatecatpro(){
		var cat_product = $("#cat_product").val();
		if(cat_product == 1){
			document.getElementById("rpcat_product").innerHTML = "<span class=\"notification-input ni-error\">Bạn chưa chọn nhóm cho sản phẩm này</span>";
			return false;
		}else{
			document.getElementById("rpcat_product").innerHTML = "<span class=\"notification-input ni-correct\">&nbsp;</span>";
			return true;
		}	
	}
	
	function validateprice(){
		var price = $("#price").val();
		var valRegExp = new RegExp("^[0-9]"); 
		if(price == ""){
			document.getElementById("rpprice").innerHTML = "<span class=\"notification-input ni-error\">Bạn chưa nhập giá gốc</span>";
			return false;
		}else{
			if(isNaN(price)){
				document.getElementById("rpprice").innerHTML = "<span class=\"notification-input ni-error\">Giá trị không hợp lệ</span>";
				return false;
			}else{
				document.getElementById("rpprice").innerHTML = "<span class=\"notification-input ni-correct\">&nbsp;</span>";
			return true;
				return true;
			}
		}	
	}
	
	function validateamount(){
		var amount = $("#amount").val();
		if(amount == ""){
			document.getElementById("rpamount").innerHTML = "<span class=\"notification-input ni-error\">Bạn chưa nhập số lượng trong kho</span>";
			return false;
		}else{
			if(!isNaN(amount)){
				document.getElementById("rpamount").innerHTML = "<span class=\"notification-input ni-correct\">&nbsp;</span>";
			return true;
				return true;	
			}else{
				document.getElementById("rpamount").innerHTML = "<span class=\"notification-input ni-error\">Giá trị không hợp lệ</span>";
				return false;
			}
		}	
	}
	
	function validatesale(){
		var price = $("#price").val();
		var sale = $("#sale").val();
		if(sale == ""){
			if(price == "")
				document.getElementById("rpsale").innerHTML = "<span class=\"notification-input ni-error\">Hãy nhập số tiền của giá gốc trước đã</span>";
			else
				document.getElementById("rpsale").innerHTML = "<span class=\"notification-input ni-correct\">Lấy số tiền của giá gốc</span>";
			return true;
		}else{
			if(!isNaN(sale)){
				if(isNaN(price) || price == ""){
					if(price == ""){
						document.getElementById("rpsale").innerHTML = "<span class=\"notification-input ni-error\">Bạn chưa nhập giá gốc</span>";
						return false;	
					}else{
						document.getElementById("rpsale").innerHTML = "<span class=\"notification-input ni-error\">Giá gốc không đúng định dạng</span>";
						return false	
					}
						
				}else{
					
					if(parseInt(sale) < parseInt(price)){
						document.getElementById("rpsale").innerHTML = "<span class=\"notification-input ni-correct\">&nbsp;</span>";
						return true;	
					}else{
						document.getElementById("rpsale").innerHTML = "<span class=\"notification-input ni-error\">Giảm giá mà lớn hơn giá gốc à bạn ????</span>";
						return false;	
					}
				}	
			}else{
				document.getElementById("rpsale").innerHTML = "<span class=\"notification-input ni-error\">Giá trị không hợp lệ</span>";
				return false;
			}
		}	
	}
	
})

</script>
<div class="container_12">
    <!-- Form elements --> 
    <div class="grid_12">  
    <?php if(!empty($messages)) echo $messages;?>
    <span id="error"></span> 
        <div class="module">
             <h2><span>Thêm danh mục</span></h2>
             
             <div class="module-body">
                <form id="frm_product" action="index.php?mod=product&act=process_edit" method="post" name="frm_product" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?php echo $ro['id']?>" /> 
                    <p>
                        <label>Tên sản phẩm</label>
                        <input id="name" name="name" type="text" class="input-medium" value="<?php echo $ro['name']?>"/>
                        <span id = "rpname"  style="font-style:italic; font-size:11px; color:#CCC">Nhập tên sản phẩm</span>
                    </p>
                    <p>
                        <label>Link thân thiện (có thể để trống)</label>
                        <input id="seolink" name="seolink" type="text" class="input-medium"  value="<?php echo $ro['seolink']?>"/>
                        <span id = "rpseolink" style="font-style:italic; font-size:11px; color:#CCC">Nhập seolink (nếu bạn để trống hệ thống sẽ tự sinh)</span>
                        <input type="hidden" value="" id="check_seolink" />
                    </p>
                    
                    
                    <p>
                        <label>Ngôn ngữ</label>
                        <?php
                            $rs_lang = mysql_query("SELECT * FROM tbl_lang") or die("Query {$q} \n<br/> MySQL Error: " . mysqli_error($dbc));
                            while($rows_lang = mysql_fetch_array($rs_lang)){
                                ?>
                                <input type="radio" name="lang" disabled value="<?php echo $rows_lang['id']?>" <?php if($rows_lang['id']==$ro['lang_id']) echo "checked"?>> <?php echo $rows_lang['description']?>
                                <?php
                            }
                        ?>
                    </p>
                    <p>
                       <label>Nhóm sản phẩm <span id = "rpcat_product"  style="font-style:italic; font-size:11px; color:#CCC">(Lựa chọn nhóm sản phẩm trong danh sách bên dưới)</span></label>
                        <select id="cat_product" name="cat_product" class="input-medium">
                            <option value="1">Nhóm sản phẩm</option>
                             <?php
                            $rs_cat = get_categories(0);
                            foreach($rs_cat as $rows_cat){
                            ?>
                            <option value="<?php echo $rows_cat['id']?>"<?php if($rows_cat['id'] == $ro['category_id']) echo " selected";?>><?php echo $rows_cat['name']?></option>
                            <?php
                            }
                        ?>
                        </select>
                    </p>
                    <p>
                        <label>Ảnh sản phẩm</label>
                        <input name="thumbnail" type="file" class="input-medium" value="<?php echo $ro['thumbnail']?>"/>
                        <?php
                         if(!empty($ro['thumbnail'])){
                            echo "<br/><img src='".$sitepath."uploads/{$ro['thumbnail']}' height='105' />";
                         }
                        ?>
                    </p>
                    
                    <p>
                        <label>Nội dung</label>
                        <textarea class="ckeditor" name="content"><?php echo $ro['content'];?></textarea><br />
                    </p>
					<p>
                        <label>Giá gốc<span id = "rpprice"  style="font-style:italic; font-size:11px; color:#CCC">(Giá khi nhập kho)</span></label>
                        <input id="price" name="price" type="text" class="input-medium" value="<?php echo $ro['price']?>"/>
                    </p>
                    <p>
                        <label>Giảm giá<span id = "rpsale"  style="font-style:italic; font-size:11px; color:#CCC">(Giá sau khi được giảm- nếu bạn ko nhập thì sẽ mặc định bằng Giá gốc)</span></label>
                        <input id="sale" name="sale" type="text" class="input-medium" value="<?php echo $ro['sale']?>"/>
                    </p>
                    <p>
                        <label>Số lượng <span id = "rpamount"  style="font-style:italic; font-size:11px; color:#CCC">(Số lượng hàng còn lại trong kho)</span></label>
                        <input id="amount" name="amount" type="text" class="input-medium" value="<?php echo $ro['amount']?>"/>
                    </p>
                    
                    
                    <fieldset>
                        <input class="submit-green" type="submit" value="Xác nhận" name="submit"/> 
                        <input class="submit-gray" type="submit" value="Hủy" name="cancel" />
                    </fieldset>
                </form>
             </div> <!-- End .module-body -->

        </div>  <!-- End .module -->
		<div style="clear:both;"></div>
    </div> <!-- End .grid_12 -->
        
    <div style="clear:both;"></div>
</div> <!-- End .container_12 -->