<?php
session_start();
unset($_SESSION['name']);
unset($_SESSION['phone']);
unset($_SESSION['logflag']);
unset($_SESSION['id']);
//删除含登陆信息的session
header("refresh:0;url=login.html"); //如果成功跳转至index.html页面
