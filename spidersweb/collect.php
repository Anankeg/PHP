<?php
include_once 'connect.php'; //连接数据库
include 'sqlStatement.php'; //连接数据库操作函数
session_start();

//判断用户是否已收藏该图片
$uid = $_SESSION['id'];
$gid = $_POST['gid'];
$status = $_POST['collectStatus'];
$logflag = $_SESSION['logflag'];
$message = array(   //文件上传错误信息
    '0' => '收藏。',
    '1' => '取消收藏。',
    '2' => '未登录。',
    '3' => '收藏失败。',
    '4' => '取消收藏失败。',
);

//收藏成功
// $data['pid'] = isset($_POST['id']) ? intval(trim($_POST['id'])) : 0;
// $data['uid'] = $_SESSION['id'];
//默认o收藏 1取消收藏
// $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
if($logflag){
    if ($status == 0) {
        //收藏
        $res = addCollectitem($gid, $uid);
        if ($res) {
            $arr['collectStatus'] = 1;
            $arr['message'] = $message[$collectStatus];
            $arr['collect'] = "取消收藏";
            $arr['class'] = "btn btn-1 btn-primary";
            
        } else {
            $arr['collectStatus'] = 3;
            $arr['message'] = $message[$collectStatus];
            $arr['collect'] = "收藏失败";
            $arr['class'] = "btn btn-1 btn-primary";
        }
    } else {
        //取消收藏
        $res = delCollectitem($gid, $uid);
        if ($res) {
            $arr['collectStatus'] = 0;
            $arr['message'] = $message[$collectStatus];
            $arr['collect'] = "收藏";
            $arr['class'] = "btn btn-1 btn-default";
            
        } else {
            $arr['collectStatus'] = 4;
            $arr['message'] = $message[$collectStatus];
            $arr['collect'] = "取消收藏失败";
            $arr['class'] = "btn btn-1 btn-default";;
        }
    }

}else{
    $arr['collectStatus'] = 2;
            $arr['message'] = $message[$collectStatus];
            $arr['collect'] = "未登录";
            $arr['class'] = "btn btn-1 btn-default";
}

echo json_encode($arr);

