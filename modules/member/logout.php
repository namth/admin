<td>
<?php
unset($_SESSION['ok']);
unset($_SESSION['user']);
unset($_SESSION['uid']);
unset($_SESSION['idgu']);
unset($_SESSION['cus']);
session_destroy();
setcookie(session_name(),'',time()-3600);
header("location: index.php?mod=member&act=login&rp=1");;
?>
</td>