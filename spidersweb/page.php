<?php
include_once 'connect.php'; //连接数据库
include 'sqlStatement.php'; //连接数据库操作函数
session_start();

$logflag = $_SESSION['logflag'];

$page = intval($_POST['pageNum']);
$total = getrows('goods'); //总记录数
$pageSize = 30; //每页显示数
$totalPage = ceil($total / $pageSize); //总页数

$startPage = $page * $pageSize;
$arr['total'] = $total;
$arr['pageSize'] = $pageSize;
$arr['totalPage'] = $totalPage;
//$res = getdata('goods','id',$startPage,$pageSize);
$con = my_sqli();
mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
$query = mysqli_query($con, "select id,name,`desc`,price from goods order by id desc limit $startPage,$pageSize");
if ($logflag == 1) {
    while ($row = mysqli_fetch_array($query)) {
        $arr['list'][] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'desc' => $row['desc'],
            'price' => $row['price'],
        );
    }
} else {
    while ($row = mysqli_fetch_array($query)) {
        $arr['list'][] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'desc' => $row['desc'],
            'price' => '',
        );
    }
}

// print_r($arr);
echo json_encode($arr);
