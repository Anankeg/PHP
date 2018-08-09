<?php
include('connect.php');
$con = my_sqli();
$query = mysqli_query($con,"select id,name,`desc`,price from goods");
$row=mysqli_fetch_array($query);
echo $row['id'];
echo $row['price'];
?>
