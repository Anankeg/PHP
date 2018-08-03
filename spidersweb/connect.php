<?php
function my_sqli()
{
    // echo "数据库连接页面";
    $server = "localhost"; //主机
    $db_username = "root"; //你的数据库用户名
    $db_password = "123456"; //你的数据库密码

    $con = mysqli_connect($server, $db_username, $db_password, 'spiders'); //链接数据库
    // echo mysqli_get_host_info($con).PHP_EOL;
    if (!$con) {
        die("can't connect" . mysqli_error()); //如果链接失败输出错误
        // echo "数据库连接失败";
    } else {
        return $con;
        // echo mysqli_get_host_info($con).PHP_EOL;
        // echo "数据库连接成功";
    }
    //
    //mysqli_select_db('spiders', $con);//选择数据库（我的是test）
}
 //方法：插入元组
function insert($name,$password,$phone,$email,$token,$token_exptime,$regtime)
    {
        $con = my_sqli();
        $addaccount = "insert into account(id,username,password,phone,email,`token`,`token_exptime`,`regtime`) values (null,'$name','$password','$phone','$email','$token','$token_exptime','$regtime');"; //向数据库插入表单传来的值的sql
        // echo $addaccount;
        $result = mysqli_query($con, $addaccount); //执行sql
        return $result;
    }
