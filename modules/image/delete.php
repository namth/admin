<?php 
    if(isset($_GET['lid'])&& filter_var($_GET['lid'], FILTER_VALIDATE_INT, array('min_range'=>0))){
        $lid = $_GET['lid'];
		$str_link = mysql_query("select * from tbl_link where id = $lid");
		$result_link = mysql_fetch_array($str_link);
        //Xoa file khoi csdl
        $q = "DELETE FROM tbl_link WHERE id = {$lid} LIMIT 1";
        //Xac dinh vi tri cua file
        $dir = "../uploads/".$result_link['image'];
        //Xoa file khoi thu muc
        if(mysql_query($q)){
            unlink($dir);
		?>
			<SCRIPT LANGUAGE="JavaScript">
			history.back();
			</SCRIPT>
		<?php
        }
		header($check);
    }
    
?>
