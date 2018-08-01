<?php
header("Content-Type: text/html; charset=utf8");
include 'connect.php'; //链接数据库
include 'regemail.php'; //连接发送邮件功能
if (isset($_POST["cancel"])) {
    header("refresh:0;url=index.php"); //按取消按钮后跳转至之前的index.html页面
} else if (!isset($_POST['submit'])) {
    exit("错误执行");
} //判断是否有submit操作
else {
    $name = $_POST['name']; //post获取表单里的name
    $password = $_POST['password']; //post获取表单里的password
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $regtime = time();
    $token = md5($username . $check . $regtime); //创建用于激活识别码
    $token_exptime = time() + 60 * 60 * 24; //过期时间为24小时后
    //$regstatus = 0;
    echo $name;

    $addaccount = "insert into account(id,username,password,phone,email,`token`,`token_exptime`,`regtime`) values (null,'$name','$password','$phone','$email','$token','$token_exptime','$regtime');"; //向数据库插入表单传来的值的sql
    // echo $addaccount;
    $result = mysqli_query($con, $addaccount); //执行sql
    // echo $result;

    if (!$result) {
        echo "注册失败请重新注册";
        print_r('Error: ' . mysqli_error($con)); //如果sql执行失败输出错误
        header("refresh:10;url=register.html"); //如果成功跳转至welcome.html页面
    } else {
        // echo "注册成功,请再次登录"; //成功输出注册成功
        // header("refresh:1;url=login.html"); //如果成功跳转至welcome.html页面
        $toemail = $email;
        // $emailsubject = "用户帐号激活";
        // $emailbody = "亲爱的" . $username . "：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/>
        // <a href = 'http://localhost/spidersweb/active.php?verify='" . $token . "' target='_blank'>激活邮箱</a>
        // <br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。
        // <br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>XXX网站</p>";
        // $rs = sendMail($toemail, $emailsubject, $emailbody);

        $rs = regemail($name, $toemail, $token);
        if ($rs) {
            $msg = '恭喜您，注册成功！<br/>请登录到您的邮箱及时激活您的帐号！';
            echo $msg;
        } else {
            $msg = "对不起，您的邮件发送失败，请刷新页面来重新发送您的邮件";
            echo $msg;
        }

    }

    mysqli_close($con); //关闭数据库
}
