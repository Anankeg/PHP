<?PHP
include "checkinput.php"; //连接检查处理php
include 'connect.php'; //链接数据库
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
                    echo "登录成功,正在跳转到商品页面，请稍后。。。";
                    $_SESSION['logflag'] = 1;
                    $_SESSION['name'] = $userinfo['username'];
                    $_SESSION['phone'] = $phone;
                    $_SESSION['userinfo'] = $userinfo;
                    header("refresh:1;url=index.php"); //如果成功跳转至welcome.html页面
                    exit;
                
            }
        }

    }
    // mysqli_close(); //关闭数据库
}
