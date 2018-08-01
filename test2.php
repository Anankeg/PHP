<?php
$connect=mysqli_connect("127.0.0.1","root","123456");
if(!$connect) echo "Mysql Connect Error!";
else echo "MySQL OK!";
mysql_close();
?>
