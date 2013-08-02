<?php
function rand_string($length) { 
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
    $size = strlen($chars); 
    for($i = 0; $i < $length; $i++) { 
    $str .= $chars[rand(0, $size - 1)]; 
     } 
    return $str; 
} 
function report($report, $mssg){
	switch($report){
		case "1":
			$messages = "<span class='notification n-success'>$mssg</span>";
			break;
		case "2":
			$messages = "<span class='notification n-error'>$mssg</span>";
			break;
		case "3":
			$messages = "<span class='notification n-error'>$mssg</span>";
			break;
	}
	return $messages;	
}

function link_convert ($str){
	$marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
					"ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
					,"ế","ệ","ể","ễ",
					"ì","í","ị","ỉ","ĩ",
					"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
					,"ờ","ớ","ợ","ở","ỡ",
					"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
					"ỳ","ý","ỵ","ỷ","ỹ",
					"đ",
					"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
					,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
					"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
					"Ì","Í","Ị","Ỉ","Ĩ",
					"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
					,"Ờ","Ớ","Ợ","Ở","Ỡ",
					"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
					"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
					"Đ"," ","?","&");
					
	$marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
					,"a","a","a","a","a","a",
					"e","e","e","e","e","e","e","e","e","e","e",
					"i","i","i","i","i",
					"o","o","o","o","o","o","o","o","o","o","o","o"
					,"o","o","o","o","o",
					"u","u","u","u","u","u","u","u","u","u","u",
					"y","y","y","y","y",
					"d",
					"A","A","A","A","A","A","A","A","A","A","A","A"
					,"A","A","A","A","A",
					"E","E","E","E","E","E","E","E","E","E","E",
					"I","I","I","I","I",
					"O","O","O","O","O","O","O","O","O","O","O","O"
					,"O","O","O","O","O",
					"U","U","U","U","U","U","U","U","U","U","U",
					"Y","Y","Y","Y","Y",
					"D","-","","-");

  return strtolower(str_replace($marTViet,$marKoDau,trim($str)));
}

/**
 * fetch_category()
 * 
 * @param mixed $cat_id
 * @return
 */
function fetch_category($cat_id, $cat_name, $count){
    global $lang;
	global $module;
    $c = $count;
    $html = "";
    $str = "SELECT * FROM tbl_category WHERE lang_id = $lang and level = $cat_id";
    $rs_cat_items = mysql_query($str);
    while($rows_cat_items = mysql_fetch_array($rs_cat_items)){
        $ro_item  = $rows_cat_items['id'];
        $c += 2;
        $html .= "<tr><td class='align-center'>";
        $html .= $rows_cat_items['id']."</td><td>";
        /*for($i = 0; $i < $c; $i++){
            $html.="&nbsp";
            
        }*/
		if($module != "category")
			$html .= "&nbsp;&nbsp;&nbsp;<a href='?mod=".$module."&act=edit_group&catid=".$rows_cat_items['id']."'>".$rows_cat_items['name']."</a></td>";
		else
        	$html .= "&nbsp;&nbsp;&nbsp;<a href='?mod=category&act=edit&catid=".$rows_cat_items['id']."'>".$rows_cat_items['name']."</a></td>";
			
        $html .= "<td>".$rows_cat_items['seolink']."</td>";
        $html .= "<td>".$cat_name."</td>";
		
		if($module != "category")
        	$html .= "<td><input type='checkbox' />&nbsp;<a href='?mod=".$module."&act=edit_group&catid=".$rows_cat_items['id']."'><img src='images/pencil.gif' width='16' height='16' alt='edit' /></a>&nbsp;";
		else
			$html .= "<td><input type='checkbox' />&nbsp;<a href='?mod=category&act=edit&catid=".$rows_cat_items['id']."'><img src='images/pencil.gif' width='16' height='16' alt='edit' /></a>&nbsp;";
        
		$rs_new = mysql_query("select count(*) as count from  tbl_cat_new where category_id = $cat_id");
		$rows_new = mysql_fetch_array($rs_new);
		
		
        
		$rs_count = mysql_query("select count(*) as count from  tbl_category where level = $ro_item");
		$rows_count = mysql_fetch_array($rs_count);
		if($module == 'category'){
			if($rows_count['count'] > 0){
				$html .= "<a href='#' onclick=\"javascript: alert('Vui lòng xóa danh mục trực thuộc. trước khi xóa nó.');\"><img src='images/bin.gif' width='16' height='16' alt='delete' /></a>";
			}else{
				$html .= "<a href='?mod=category&act=delete&catid=".$rows_cat_items['id']."' onclick=\"return confirm('BẠN CÓ CHẮC CHẮN XÓA???');\"><img src='images/bin.gif' width='16' height='16' alt='delete' /></a>";	
			}
		}else{
			if($rows_count['count'] > 0){
				$html .= "<a href='#' onclick=\"javascript: alert('Vui lòng xóa danh mục trực thuộc. trước khi xóa nó.');\"><img src='images/bin.gif' width='16' height='16' alt='delete' /></a>";
			}else{
				$html .= "<a href='?mod=".$module."&act=delete_group&catid=".$rows_cat_items['id']."' onclick=\"return confirm('BẠN CÓ CHẮC CHẮN XÓA???');\"><img src='images/bin.gif' width='16' height='16' alt='delete' /></a>";	
			}
		}
            
        
        $html .= "</td></tr>";
        $html .= fetch_category($rows_cat_items['id'], $rows_cat_items['name'], $c);
    }
    
    return $html;
}

function fetch_ship($ship_id, $add, $count){
    global $lang;
    $c = $count;
    $html = "";
    $str = "SELECT * FROM  tbl_shipping_fee WHERE lang_id = $lang and level = $ship_id";
    $rs_ship_items = mysql_query($str);
    while($rows_ship_items = mysql_fetch_array($rs_ship_items)){
        $ro_item  = $rows_ship_items['id'];
        $c += 2;
        $html .= "<tr><td class='align-center'>";
        $html .= $rows_ship_items['id']."</td><td>";
        /*for($i = 0; $i < $c; $i++){
            $html.="&nbsp";
            
        }*/
        $html .= "&nbsp;&nbsp;&nbsp;<a href='?mod=ship&act=edit&ship_id=".$rows_ship_items['id']."'>".$rows_ship_items['add']."</a></td>";
        
        $html .= "<td>".$add."</td>";
        $html .= "<td>".number_format($rows_ship_items['fee'])." VND</td>";    
        $html .= "<td>".$rows_ship_items['seolink']."</td>";
        $html .= "<td><input type='checkbox' />&nbsp;<a href='?mod=ship&act=edit&ship_id=".$rows_ship_items['id']."'><img src='images/pencil.gif' width='16' height='16' alt='edit' /></a>&nbsp;";
      
        
        $ship_item = $rows_ship_items['id'];
        $rs_ship = mysql_query("select count(*) as count from  tbl_shipping_fee where lang_id = $lang  and level = $ship_item");
        $rows_ship = mysql_fetch_array($rs_ship);
        if((int)$rows_ship['count'] > 0)
            $html .= "<a href='#' onclick=\"javascript: alert('Vui lòng xóa danh mục trực thuộc danh mục này. trước khi xóa nó.');\"><img src='images/bin.gif' width='16' height='16' alt='delete' /></a>"; 
        else
            $html .= "<a href='?mod=ship&act=delete&ship_id=".$ship_item."' onclick=\"return confirm('BẠN CÓ CHẮC CHẮN MUỐN XÓA KHÔNG????')\"><img src='images/bin.gif' width='16' height='16' alt='delete' /></a>";
        
        
        
        $html .= "</td></tr>";
        $html .= fetch_ship($rows_ship_items['id'], $rows_ship_items['add'], $c);
    }
    
    return $html;

}

function chk_email(){
	$e = $_POST['email'];
	$str = "SELECT * FROM tbl_customer WHERE email = '$e'";	
	$result = mysql_query($str);
	$rows = mysql_fetch_array($result);
	if($rows)
		return true;
	else
		return false;	
}

function chk_resetkey(){
	$rk = $_GET['resetkey'];
	$e = $_GET['email'];
	$str = "SELECT * FROM tbl_customer WHERE resetkey = '$rk' AND email = '$e'";	
	$result = mysql_query($str);
	$rows = mysql_fetch_array($result);
	if($rows)
		return true;
	else
		return false;	
}

function chk_permision(){
	$idgu = $_SESSION['idgu'];
	$m = $_GET['mod'];
	$strm = "SELECT * FROM tbl_link WHERE permalink like '$m%' and type = 'menu_admin'";
	$resultm = mysql_query($strm);
	$rowsm = mysql_fetch_array($resultm);
	$idm = $rowsm['id'];
	
	$str = "SELECT * FROM tbl_permision WHERE modules_id = '$idm' AND group_user_id = '$idgu'";
	$result = mysql_query($str);
	$rows = mysql_fetch_array($result); 				
	if($rows)
		return true;
	else	
		return false;
}


function truncateString($str, $chars, $to_space, $replacement="...") {
   if($chars > strlen($str)) return $str;

   $str = substr($str, 0, $chars);

   $space_pos = strrpos($str, " ");
   if($to_space && $space_pos >= 0) {
       $str = substr($str, 0, strrpos($str, " "));
   }

   return($str . $replacement);
}

function pagenav($base_url, $start, $max_value, $num_per_page) {
//Chuyen Dao Tao PHP & MySQL thuc te, chuyen nghiep tai Ha Noi.
//Pham Hung Thang
//DT: 0982.858506
//YM: hungthangitv
//Email: hungthangitvn@gmail.com
//Website: www.htvsite.com
$pgcont = 4;
$pgcont = (int) ($pgcont - ($pgcont % 2)) / 2;
if ($start >= $max_value)
$start = max(0, (int) $max_value - (((int) $max_value % (int) $num_per_page) == 0 ? $num_per_page : ((int) $max_value % (int) $num_per_page)));
else
$start = max(0, (int) $start - ((int) $start % (int) $num_per_page));
$base_link = '<a class="navpg" href="' . strtr($base_url, array('%' => '%%')) . 'start=%d' . '">%s</a> ';
$pageindex = $start == 0 ? '' : sprintf($base_link, $start - $num_per_page, '&lt;');
if ($start > $num_per_page * $pgcont)
$pageindex .= sprintf($base_link, 0, '1');
if ($start > $num_per_page * ($pgcont + 1))
$pageindex .= '<span style="font-weight: bold;"> ... </span>';
for ($nCont = $pgcont; $nCont >= 1; $nCont--)
if ($start >= $num_per_page * $nCont) {
$tmpStart = $start - $num_per_page * $nCont;
$pageindex .= sprintf($base_link, $tmpStart, $tmpStart / $num_per_page + 1);
}
$pageindex .= '[<b>' . ($start / $num_per_page + 1) . '</b>] ';
$tmpMaxPages = (int) (($max_value - 1) / $num_per_page) * $num_per_page;
for ($nCont = 1; $nCont <= $pgcont; $nCont++)
if ($start + $num_per_page * $nCont <= $tmpMaxPages) {
$tmpStart = $start + $num_per_page * $nCont;
$pageindex .= sprintf($base_link, $tmpStart, $tmpStart / $num_per_page + 1);
}
if ($start + $num_per_page * ($pgcont + 1) < $tmpMaxPages)
$pageindex .= '<span style="font-weight: bold;"> ... </span>';
if ($start + $num_per_page * $pgcont < $tmpMaxPages)
$pageindex .= sprintf($base_link, $tmpMaxPages, $tmpMaxPages / $num_per_page + 1);
if ($start + $num_per_page < $max_value) {
$display_page = ($start + $num_per_page) > $max_value ? $max_value : ($start + $num_per_page);
$pageindex .= sprintf($base_link, $display_page, '&gt;');
}
return $pageindex;
}

function get_categories($parentid = 0,$space = '-----', $trees = NULL){ 
    if(!$trees) $trees = array(); 
    $sql = mysql_query("SELECT * FROM tbl_category where level =".intval($parentid)); 
    while($rs = mysql_fetch_assoc($sql)){ 
        $trees[] = array('id'=>$rs['id'],'name'=>$space.$rs['name']); 
        $trees = get_categories($rs['id'],$space.'-----',$trees); 
    } 
    return $trees; 
} 
?>
