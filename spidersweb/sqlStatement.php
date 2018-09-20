<?php
include_once "connect.php";

//方法：插入元组
function insert($name, $password, $phone, $email, $token, $token_exptime, $regtime)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "insert into account(id,username,password,phone,email,`token`,`token_exptime`,`regtime`) values (null,'$name','$password','$phone','$email','$token','$token_exptime','$regtime');"; //向数据库插入表单传来的值的sql
    // echo $addaccount;
    $result = mysqli_query($con, $sql); //执行sql
    return $result;
}

//方法：查询数据库行数
function getrows($tablename)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select * from goods;";
    $res = mysqli_query($con, $sql);
    $rows = mysqli_num_rows($res); //获取行数
    if ($rows) {
        return $rows;
    } else {
        return 0;
    }

}

//查询条件下数据库行数
function getConditionRows($tablename, $where)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select * from goods where name like '%$where%' or `desc` like '%$where%'";
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
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
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
function getdata($tablename, $condition, $start, $limit)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select id,name,`desc`,price from goods order by '.$condition.' desc limit $start,$limit;";
    $res = mysqli_query($con, $sql);
    return $res;
}

//从数据库中查询某列
function getid($tablename)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
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
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select * from account where `id`=$id;";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($res);
    if ($row) {
        return $row;
    } else {
        return false;
    }

}

//avatar
//根据id更改数据库中account表相应元组的avatar数据
function addavatar($url, $id)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "update account set avatar='$url' where `id`='$id';";
    $res = mysqli_query($con, $sql);
    return $res;
}

//根据id更改数据库中account表相应元组的smallavatar数据
function addsmallavatar($url, $id)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "update account set smallavatar='$url' where `id`='$id';";
    $res = mysqli_query($con, $sql);
    return $res;
}
//avatar

//password
//更改password
function updatePassword($newpassword, $password, $phone)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "update account set `password`='$newpassword' where `phone`='$phone' and `password`='$password';";
    $res = mysqli_query($con, $sql);
    return $res;
}
//password

//collec
//查询数据库收藏表中的收藏数据
function getCollectStatus($gid, $uid)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select * from collect where `gid`='$gid' and `uid`='$uid'";
    $res = mysqli_query($con, $sql);
    $rows = mysqli_num_rows($res); //获取行数
    return $rows;
}

//删除数据库中的收藏表的元组
function delCollectitem($gid, $uid)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "delete from collect where `gid`='$gid' and `uid`='$uid'";
    $res = mysqli_query($con, $sql);
    return $res;
}

//增加数据库中的收藏表的元组
function addCollectitem($gid, $uid)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = " insert into collect (`gid`,`uid`) values ('$gid','$uid');";
    $res = mysqli_query($con, $sql);
    return $res;
}

//收藏条数
function getCollectrows($uid)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select * from collect where uid='$uid';";
    $res = mysqli_query($con, $sql);
    $rows = mysqli_num_rows($res); //获取行数
    if ($rows) {
        return $rows;
    } else {
        return 0;
    }

}

//收藏表查询商品函数
function getCollectgoods($gid)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select id,name,`desc`,price from goods where id='$gid'";
    $sqlquery = mysqli_query($con, $sql);
    $rowg = mysqli_fetch_array($sqlquery);
    if ($rowg) {
        return $rowg;
    } else {
        return 0;
    }
}
//collect
//invite
//方法：插入元组含邀请人
function invite_insert($name, $password, $phone, $email, $token, $token_exptime, $regtime, $parentid)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "insert into account(id,username,password,phone,email,`token`,`token_exptime`,`regtime`,`parentid`) values (null,'$name','$password','$phone','$email','$token','$token_exptime','$regtime','$parentid');"; //向数据库插入表单传来的值的sql
    // echo $addaccount;
    $result = mysqli_query($con, $sql); //执行sql
    return $result;
}

//方法：查询invite parent
function getinviteid($parentid)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select id, username, parentid from account where `parentid`='$parentid';";
    $res = mysqli_query($con, $sql);
    $rows = mysqli_fetch_all($res, MYSQLI_ASSOC); //获取行数
    if ($rows) {
        return $rows;
    } else {
        return 0;
    }

}

//
function getinviteroot($id)
{
    $con = my_sqli();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select id, username, parentid from account where `id`='$id';";
    $res = mysqli_query($con, $sql);
    $rows = mysqli_fetch_array($res, MYSQLI_ASSOC); //获取行数
    if ($rows) {
        return $rows;
    } else {
        return 0;
    }

}

//invite
