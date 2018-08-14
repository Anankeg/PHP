<?php
include "connect.php";
include "sqlStatement.php";
session_start();
if ($_SESSION['logflag'] == 1) {
    $log = 1;
    $row = getaccount($_SESSION['id']);
    $list = array("_log" => $log, "_id" => $row['id'], "_name" => $row['username'], "_phone" => $row['phone'], "_email" => $row['email'], "_avatar" => $row['smallavatar']);
} else {
    $log = 0;
    $list = array("log" => $log);
}
echo json_encode($list);
