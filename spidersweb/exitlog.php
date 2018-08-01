<?php
session_start();
unset($_SESSION['name']);
unset($_SESSION['phone']);
unset($_SESSION['userinfo']);
unset($_SESSION['logflag']);
//删除含登陆信息的session
header("refresh:0;url=index.php"); //如果成功跳转至index.html页面
