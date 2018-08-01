<?PHP
session_start();
header("Content-Type: text/html; charset=utf8");
if (isset($_POST["cancel"])) {
    header("refresh:0;url=index.php"); //按取消按钮后跳转至之前的index.html页面
} else if (!isset($_POST["submit"])) {
    exit("错误执行"); //若按登录后没有收到submit的信息，则返回错误执行
} //检测是否有submit操作
else { //若收到submit消息则处理登录信息
    include 'connect.php'; //链接数据库
    $phone = $_POST['phone']; //post获得用户名表单值
    $passowrd = $_POST['password']; //post获得用户密码单值
    // echo "phone:".$phone;
    // echo "password:".$passowrd;
    if ($phone && $passowrd) { //如果用户名和密码都不为空
        $sql = "select * from account where phone='$phone' and password='$passowrd'"; //检测数据库是否有对应的username和password的sql
        $result = mysqli_query($con, $sql); //执行sql
        $userinfo = mysqli_fetch_array($result);
        $rows = mysqli_num_rows($result); //返回一个数值
        if ($rows) { //0 false 1 true
            echo "登录成功,正在跳转到商品页面，请稍后。。。";
            $_SESSION['logflag'] = $rows;
            $_SESSION['name'] = $userinfo['username'];
            $_SESSION['phone'] = $phone;
            $_SESSION['userinfo'] = $userinfo;
            header("refresh:1;url=index.php"); //如果成功跳转至welcome.html页面
            exit;
        } else {
            echo "用户名或密码错误";
            echo "
                        <script>
                                setTimeout(function(){window.location.href='login.html';},1000);
                        </script>

                    "; //如果错误使用js 1秒后跳转到登录页面重试;
        }

    } else { //如果用户名或密码有空
        echo "表单填写不完整";
        echo "
                        <script>
                                setTimeout(function(){window.location.href='login.html';},1000);
                        </script>";

        //如果错误使用js 1秒后跳转到登录页面重试;
    }

    mysqli_close(); //关闭数据库
}
