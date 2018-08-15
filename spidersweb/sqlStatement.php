<?php
include_once "connect.php";


//方法：插入元组
function insert($name, $password, $phone, $email, $token, $token_exptime, $regtime)
{
    $con = my_sqli();
    $sql = "insert into account(id,username,password,phone,email,`token`,`token_exptime`,`regtime`) values (null,'$name','$password','$phone','$email','$token','$token_exptime','$regtime');"; //向数据库插入表单传来的值的sql
    // echo $addaccount;
    $result = mysqli_query($con, $sql); //执行sql
    return $result;
}

//方法：查询数据库行数
function getrows($tablename)
{
    $con = my_sqli();
    $sql = "select * from goods;";
    $res = mysqli_query($con, $sql);
    $rows = mysqli_num_rows($res); //获取行数
    if ($rows) {
        return $rows;
    } else {
        return 0;
    }

}

//查询数据库列数
function getcolums($tablename)
{
    $con = my_sqli();
    $sql = "select * from '.$tablename.';";
    $res = mysqli_query($con, $sql);
    $colums = mysqli_num_fields($res); //获取行数
    if ($colums) {
        return $colums;
    } else {
        return 0;
    }

}

//查询数据库中从$start开始的$limit条元组
function getdata($tablename,$condition,$start,$limit)
{
    $con = my_sqli();
    $sql = "select id,name,`desc`,price from goods order by '.$condition.' desc limit $start,$limit;";
    $res = mysqli_query($con,$sql);
    return $res;
}

//从数据库中查询某列
function getid($tablename)
{
    $con = my_sqli();
    $sql = "select id from '.$tablename.';";
    $res = mysqli_query($con, $sql);
    if ($res) {
        return $res;
    } else {
        return "id empty";
    }

}

//从数据库中用id查询数据
function getaccount($id)
{
    $con = my_sqli();
    $sql = "select * from account where `id`=$id;";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($res);
    if ($row) {
        return $row;
    } else {
        return false;
    }

}

//根据id更改数据库中account表相应元组的avatar数据
function addavatar($url, $id)
{
    $con = my_sqli();
    $sql = "update account set avatar='$url' where `id`='$id';";
    $res = mysqli_query($con, $sql);
    return $res;
}

//根据id更改数据库中account表相应元组的smallavatar数据
function addsmallavatar($url, $id)
{
    $con = my_sqli();
    $sql = "update account set smallavatar='$url' where `id`='$id';";
    $res = mysqli_query($con, $sql);
    return $res;
}

//更改password
function updatePassword($newpassword, $password, $phone)
{
    $con = my_sqli();
    $sql = "update account set `password`='$newpassword' where `phone`='$phone' and `password`='$password';";
    $res = mysqli_query($con, $sql);
    return $res;
}
