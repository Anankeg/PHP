<?PHP
include "checkinput.php"; //连接检查处理php
include 'connect.php'; //链接数据库
include 'sqlStatement.php'; //连接数据库操作函数
session_start();
header("Content-Type: text/html; charset=utf8");
if (isset($_POST["cancel"])) {
    header("refresh:0;url=account.html"); //按取消按钮后跳转至之前的index.html页面
} else if (!isset($_POST["submit"])) {
    exit("错误执行"); //若按登录后没有收到submit的信息，则返回错误执行
} //检测是否有submit操作
else { //若收到submit消息则处理登录信息
    $password = $_POST['password']; //post获得用户名表单值
    $newpassword = $_POST['newpassword']; //post获得用户密码单值
    $newpasswordagain = $_POST['newpasswordagain'];
    $verifycode = $_POST['verifycode'];
    $url = 'changePassword.html';
    if (checkLogStatus()) {
        if (checkPasswordEmpty($password, $newpassword, $newpasswordagain, $verifycode, $url)) { //验证账号密码验证码不为空
            if (checkVerifycode($verifycode, $_SESSION['code'], $url)) { //验证验证码正确
                $userinfo = checkUser($_SESSION['phone'], $password, $url);
                if ($userinfo) { //验证用户存在
                    $res = updatePassword($newpassword, $password, $_SESSION['phone']);
                    if ($res) {

                        echo '<html><head><Script Language="JavaScript">alert("密码修改成功，请使用新密码重新登录");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url='exitlog.php'\">"; //修改成功
                    } else {
                        echo '<html><head><Script Language="JavaScript">alert("密码修改失败，请重新修改");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url='changePassword.html'\">"; //修改成功
                    }

                }
            }

        }
    }
    // mysqli_close(); //关闭数据库
}
