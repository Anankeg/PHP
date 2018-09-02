<?php
session_start();
header("Content-Type: text/html; charset=utf8");
include 'connect.php'; //链接数据库
include 'sqlStatement.php';//连接数据库操作函数
include 'regemail.php'; //连接发送邮件功能
include 'checkinput.php';
if (isset($_POST["cancel"])) {
    header("refresh:0;url=login.html"); //按取消按钮后跳转至之前的index.html页面
} else if (!isset($_POST['submit'])) {
    exit("错误执行");
} //判断是否有submit操作
else {
    $name = $_POST['name']; //post获取表单里的name
    $password = $_POST['password']; //post获取表单里的password
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $verifycode = $_POST['verifycode'];
    $regtime = time();
    $token = md5($username . $check . $regtime); //创建用于激活识别码
    $token_exptime = time() + 60 * 60 * 24; //过期时间为24小时后
    $url = 'invite.html'.$_POST['parenturl'];
    // echo $url;
    $parentid = $_POST['parentid'];
    //$regstatus = 0;
    // echo $name;
    // echo $_SESSION['code'];
    // $checkphone = "select "
    if(checkpidEmpty($parentid)){
        if (checkregEmpty($name, $password, $phone, $email, $verifycode, $url)) { //检查判空
            if (checkPhoneNum($phone, $url)) { //检查手机号格式
                if (checkEmail($email, $url)) { //检查email格式
                    if (checkVerifycode($verifycode, $_SESSION['code'],$url)) { //检查验证码
                        if (checkregUser($phone, $password, $url)) { //检查用户是否存在
                            $result = invite_insert($name, $password, $phone, $email, $token, $token_exptime, $regtime, $parentid);
                            if ($result) {
                                echo '恭喜您，注册成功！<br/>请登录到您的邮箱及时激活您的帐号！';
                                $toemail = $email;
                                $rs = regemail($name, $toemail, $token);
                                if ($rs) {
                                    echo "恭喜您，邮箱激活成功请登录您的账号";
                                    header("refresh:1;url=login.html"); //如果成功跳转至welcome.html页面
                                } else {
                                    echo "邮箱激活失败，请登录后进入您的个人中心->邮箱激活来重新激活您的邮箱";
                                    header("refresh:1;url=login.html"); //如果成功跳转至welcome.html页面
                                }
                            } else {
                                echo "注册失败，请重新注册";
                                header("refresh:1;url=".$url); //如果成功跳转至welcome.html页面

                            }
                        }
                    }
                }
            }
        }
    }
}
