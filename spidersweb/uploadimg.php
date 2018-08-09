<?php
if($_FILES["file"]["error"]){
    $result = array('status' => 'fail', 'message' => $_FILES["file"]["error"]);
}else{
    $dir = "./images/avatar/";  
    file_exists($dir) || (mkdir($dir,0777,true) && chmod($dir,0777));  
    try{
        
        if(!is_array($_FILES["file"]["name"])) {
            $ext = pathinfo($_FILES["file"]['name'])['extension'];
            
            $fileName = $dir.'avatar_'.$dUserId.'_300x300.'.$ext;  

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
$jsonstring = json_encode($result);
header('Content-Type: application/json');
echo $jsonstring;
?>