<?php
include_once 'connect.php'; //连接数据库
include 'sqlStatement.php'; //连接数据库操作函数
session_start();


$logflag = $_SESSION['logflag'];
$page = intval($_POST['pageNum']);
$pageSize = intval($_POST['pageSize']); //每页显示数

$uid = $_POST['uid'];
$total = getCollectrows($uid); //总记录数
$totalPage = ceil($total / $pageSize); //总页数
$startPage = $page * $pageSize;
$arr['total'] = $total;
$arr['pageSize'] = $pageSize;
$arr['totalPage'] = $totalPage;
$arr['page'] = $page + 1;
$arr['uid'] = $uid;
//$res = getdata('goods','id',$startPage,$pageSize);
$con = my_sqli();
mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
$query = mysqli_query($con, "select * from collect where uid='$uid' order by id desc limit $startPage,$pageSize");

if($logflag == 1){
while ($row = mysqli_fetch_array($query)) {
$rowg = getCollectgoods($row['gid']);
    $arr['list'][] = array(
        'id' => $rowg['id'],
        'name' => $rowg['name'],
        'desc' => $rowg['desc'],
        'price' => $rowg['price'],
    );
}
}else{
    while ($row = mysqli_fetch_array($query)) {
        $rowg = getCollectgoods($row['gid']);
            $arr['list'][] = array(
                'id' => $rowg['id'],
                'name' => $rowg['name'],
                'desc' => $rowg['desc'],
                'price' => '',
            );
        }
}

// print_r($arr);
echo json_encode($arr);
