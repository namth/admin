<?php 
    //Xac nhan bien GET ton tai va dung loai du lieu cho phep.
    if(isset($_GET['oid'])&& filter_var($_GET['oid'], FILTER_VALIDATE_INT, array('min_range'=>0))){
        $oid = $_GET['oid'];
    }else{
        header("location: index.php?mod=order");
    }
    
    if(($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])){
        $status = $_POST['c'];
        $q = "UPDATE tbl_orders SET status = {$status}, user_id={$_SESSION['uid']} WHERE id={$oid}";
        if(mysql_query($q)){
            header("location: index.php?mod=order&rp=1&ad=edit&mn=$oid");
        }
    }elseif(isset($_POST['cancel'])){
        header("location: index.php?mod=order");
    }
    
?>