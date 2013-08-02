<?php
if(($_SERVER['REQUEST_METHOD'] == 'POST')&& isset($_POST['submit'])){
        $errors = array();
        //Kiem tra gia tri cua option
        if(empty($_POST['opvalue'])){
            $errors[] = "opvalue";
        }else{
            $opvalue = $_POST['opvalue'];
        }
        
        //Kiem tra ID cua option
        if(empty($_POST['optionID'])){
            $errors[] = "optionID";
        }else{
            $optionID = $_POST['optionID'];
        }
        
        if(empty($errors)){
            for($i=0; $i<count($optionID); $i++){
                $q = "UPDATE tbl_option SET value='{$opvalue[$i]}' WHERE id={$optionID[$i]} LIMIT 1";
                $r = mysql_query($q);
            }
            header("location: index.php?mod=setup&rp=1");
        } else{
            header("location: index.php?mod=setup&rp=2");
        }
    }elseif(isset($_POST['cancel'])){
        header("location: index.php");
    }
?>