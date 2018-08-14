<?php
include_once "connect.php"; //连接数据库
include 'sqlStatement.php';//连接数据库操作函数
$verify = stripslashes(trim($_GET['verify']));
echo $verify;
//print_r($verify);
$nowtime = time();
$con = my_sqli();
$sql = "select id,token_exptime from account where regstatus='0' and token='$verify'";
echo $sql;
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query);
if ($row) {
    if ($nowtime > $row['token_exptime']) { //24hour
        $msg = '您的激活有效期已过，请点击重新发送激活邮件.';
    } else {
        //更新数据库,更新状态，删除token
        mysqli_query($con, "update account set regstatus='1',token=NULL where id=" . $row['id']);

        // if (mysql_affected_rows($link) != 1) {
        //     die(0);
        // }
        echo '激活成功！';
        header("refresh:4;url=login.html"); //如果成功跳转至login.html页面
    }
} else {
    echo '激活失败，请点击重新发送激活邮件.';
    // print_r('Error: ' . mysqli_error($row)); //如果sql执行失败输出错误
}
