<?php
session_start();
include "Upload.php";
include "createImg.php";
$upload = new Upload();
$imgArr = $upload->start('file');
// print_r($_FILES["file"]);
// print_r($imgArr);
//   //实例化
//   $banner = M('banner');

//接收图片路径信息（就是上面表单提交图片的路径）
$img_url = $imgArr["path"];

//上传图片路径
// $img_url = "." . $data['pic_url'];

//建立新的缩略图的宽和高，参数（宽，高，图片对象）
$show_pic_scal = show_pic_scal(150, 150, $img_url);

//生成缩略图，并返回图片路径信息
$data['compress_name'] = resize($img_url, $show_pic_scal[0], $show_pic_scal[1]);

//打印出缩略图的路径信息
//dump($data['compress_name']);exit;
$img = $imgArr;
$res = addsmallavatar($data['compress_name'], $_SESSION['id']);
if ($res) {
    $img["path"] = $data['compress_name']; // 生成的新文件名
    $img["status"] = 0;
} else {
    $img["message"] = "文件上传失败";
    $img["status"] = 1;
}

/*
if($_FILES["file"]["error"]){
$result = array('status' => 'fail', 'message' => $_FILES["file"]["error"]);
}else{
$dir = "./images/avatar/";
file_exists($dir) || (mkdir($dir,0777,true) && chmod($dir,0777));
try{
print_r($_FILES["file"]);
if(!is_array($_FILES["file"]["name"])) {
$ext = pathinfo($_FILES["file"]['name'])['extension'];
print_r($ext);
$fileName = $dir.'avatar_'.$_SESSION['name'].'_300x300.'.$ext;

$width = 300;//缩放后的图片宽度
$height = 300;//缩放后的图片高度
$uploadimg = $_FILES["file"]["tmp_name"];
list($src_w,$src_h,$src_type)=getimagesize($uploadimg);  // 获取原图尺寸类型
$img = '';
if($src_type==1){
$img = imagecreatefromgif($uploadimg);
}else if($src_type==2){
$img = imagecreatefromjpeg($uploadimg);
}else if($src_type==3){
$img = imagecreatefrompng($uploadimg);
}
$newimg = imagecreatetruecolor($width,$height);
imagecopyresampled($newimg,$img,0,0,0,0,$width,$height,$src_w,$src_h);
imagepng($newimg,$fileName);
imagedestroy($newimg);
imagedestroy($img);

$result = array('status' => 'success','message'=>'','url' =>$fileName);
}
}catch(Exception $e){
$result = array('status' => 'fail', 'message' =>$e);
}

}
 */
$jsonstring = json_encode($img);
header('Content-Type: application/json');
echo $jsonstring;
