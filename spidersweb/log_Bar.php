<?php
include "connect.php";
include "sqlStatement.php";
session_start();
if ($_SESSION['logflag'] == 1) {
    $log = 1;
    $row = getaccount($_SESSION['id']);
    $list = array("_log" => $log, "_name" => $row['username']);
} else {
    $log = 0;
    $list = array("_log" => $log);
}
echo json_encode($list);
