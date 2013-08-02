<?php
$conn = mysql_connect('localhost','root','');
if(!$conn)
	echo 'Ket noi that bai!';
$db = mysql_select_db('dnt');	
if(!$db)
	echo 'Sai CSDL!';
?>