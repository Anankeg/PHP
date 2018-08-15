<?PHP
include "checkinput.php"; //连接检查处理php
include 'connect.php'; //链接数据库
include 'sqlStatement.php';//连接数据库操作函数
session_start();
header("Content-Type: text/html; charset=utf8");
if (isset($_POST["cancel"])) {
    header("refresh:0;url=register.html"); //按取消按钮后跳转至之前的index.html页面
} else if (!isset($_POST["submit"])) {
    exit("错误执行"); //若按登录后没有收到submit的信息，则返回错误执行
} //检测是否有submit操作
else { //若收到submit消息则处理登录信息
    $phone = $_POST['phone']; //post获得用户名表单值
    $password = $_POST['password']; //post获得用户密码单值
    $verifycode = $_POST['verifycode'];
    $url ='login.html';
    if (checkEmpty($phone, $password, $verifycode,$url)) { //验证账号密码验证码不为空
        if (checkVerifycode($verifycode, $_SESSION['code'],$url)) { //验证验证码正确
            $userinfo = checkUser($phone, $password,$url);
            if ($userinfo) { //验证用户存在
                    $_SESSION['logflag'] = 1;
                    $_SESSION['name'] = $userinfo['username'];
                    $_SESSION['phone'] = $userinfo['phone'];
                    $_SESSION['id'] = $userinfo['id'];
                    echo '<html><head><Script Language="JavaScript">alert("登录成功");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url='index.html'\">"; //修改成功
                
            }
        }

    }
    // mysqli_close(); //关闭数据库
}
