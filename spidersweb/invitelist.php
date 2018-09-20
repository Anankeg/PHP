<?php
include_once 'connect.php';
include_once 'sqlStatement.php';
include_once 'invitetree.php';

$data = getinvitetree('1', 3);
// var_dump($data);
$arr['data'] = $data;
echo json_encode($arr);
// foreach ($data as $val1) {
//     foreach ($val1 as $val2) {
//         foreach ($val2 as $val3) {

//             echo "$val3\n";

//         }
//     }
// }
