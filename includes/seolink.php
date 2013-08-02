<?php
include("config.php");
include("function.php");
include("common.php");
$html="no";
if(isset($_GET['seolink'])){
	$mod = $_GET['mod']?$_GET['mod']:0;
	$old = $_GET['old']?$_GET['old']:"";
    $seolink = mysql_real_escape_string(strip_tags($_GET['seolink']));
	
	if($old != $seolink){
		/*if($mod == "product"){
			 $q = "SELECT seolink FROM tbl_products WHERE seolink LIKE '{$seolink}'";
		}else if($mod == "category"){
			$q = "SELECT seolink FROM  tbl_category WHERE seolink LIKE '{$seolink}'";
		}*/
		switch($mod){
			case "category":
				$q = "SELECT seolink FROM  tbl_category WHERE seolink LIKE '{$seolink}'";
				break;
			case "news":
				$q = "SELECT seolink FROM tbl_news WHERE seolink LIKE '{$seolink}'";
				break;
			case "product":
				$q = "SELECT seolink FROM tbl_products WHERE seolink LIKE '{$seolink}'";
				break;
			case "ship":
				$q = "SELECT seolink FROM  tbl_shipping_fee WHERE seolink LIKE '{$seolink}'";
				break;
		}
   
		$r = mysql_query($q);
		while($p = mysql_fetch_array($r)){
			if($seolink == $p['seolink']){
				$html =  "yes";
			}
		}
	}else{
		$html="old";
	}
    echo $html;
}
?>