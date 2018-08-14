<?php
/**
 * 计算生成等比缩略图的宽和高
 * @param $width
 * @param $height
 * @param $picpath
 * @return mixed
 */

//参数（宽，高，图片路径）

function show_pic_scal($width, $height, $src)
{

    //获取上传图片的宽高
    $imginfo = getImageInfo($src);
    $imgw = $imginfo [0];
    $imgh = $imginfo [1];

    //将宽高比以千位分组格式保存在变量中
    $ra = number_format(($imgw / $imgh), 1); //宽高比
    $ra2 = number_format(($imgh / $imgw), 1); //高宽比

    //如果图片的宽大于缩略图的宽 或者图片的高大于缩略图的高
    if ($imgw > $width or $imgh > $height) {

        //如果缩略图的宽大于缩略图的高
        if ($imgw > $imgh) {
            $newWidth = $width;
            $newHeight = round($newWidth / $ra);
        } elseif ($imgw < $imgh) {
            $newHeight = $height;
            $newWidth = round($newHeight / $ra2);
        } else {
            $newWidth = $width;
            $newHeight = round($newWidth / $ra);
        }
    } else {
        $newHeight = $imgh;
        $newWidth = $imgw;
    }
    $newsize [0] = $newWidth;
    $newsize [1] = $newHeight;

    //返回图片等比例压缩后的能生成的实际宽和高
    return $newsize;
}

/**
 * 获取图片信息
 * @param $src
 * @return array
 */
function getImageInfo($src)
{
    //读取文件大小信息
    return getimagesize($src);
}

/**
 * 创建图片，返回资源类型
 * @param string $src 图片路径
 * @return resource $im 返回资源类型
 * **/
function create($src)
{
    //读取图片信息
    $info = getImageInfo($src);

    //$info[2]图片类型，根据图片类型选择
    switch ($info[2]) {
        case 1:
            //从gif文件新建一图像
            $im = imagecreatefromgif($src);
            break;
        case 2:
            //从jpeg文件新建一图像
            $im = imagecreatefromjpeg($src);
            break;
        case 3:
            //从png文件新建一图像
            $im = imagecreatefrompng($src);
            break;
    }
    return $im;
}

/**
 * 缩略图主函数
 * @param string $src 图片路径
 * @param int $w 缩略图宽度
 * @param int $h 缩略图高度
 * @return mixed 返回缩略图路径
 * **/
function resize($src, $w, $h)
{
    //读取图片所有信息信息
    $temp = pathinfo($src);
    $name = $temp["filename"];//文件名
    $thumbname = $name.'_slt';//要生成的文件名
    $dir = $temp["dirname"];//文件所在的文件夹
    $extension = $temp["extension"];//文件扩展名
    $savepath = "{$dir}/{$thumbname}" . ".$extension";//缩略图保存路径,生成新的的文件名（可以根据自己的实际需求改动）
    // print_r($temp);
    //获取图片的基本信息
    $info = getImageInfo($src);
    $width = $info[0];//获取图片宽度
    $height = $info[1];//获取图片高度
    $per1 = round($width / $height, 2);//计算原图长宽比
    $per2 = round($w / $h, 2);//计算缩略图长宽比

    //计算缩放比例
    if ($per1 > $per2 || $per1 == $per2) {

        //原图长宽比大于或者等于缩略图长宽比，则按照宽度优先
        $per = $w / $width;
    }
    if ($per1 < $per2) {

        //原图长宽比小于缩略图长宽比，则按照高度优先
        $per = $h / $height;
    }
    $temp_w = intval($width * $per);//计算原图缩放后的宽度
    $temp_h = intval($height * $per);//计算原图缩放后的高度
    $temp_img = imagecreatetruecolor($temp_w, $temp_h);//创建画布
    $im = create($src);//生成缩略图

    //重采样拷贝部分图像并调整大小（目标图象连接资源，源图象连接资源，目标 X坐标点,目标 Y坐标点,源的 X 坐标点,源的 Y 坐标点,目标宽度,目标高度，源图象的宽度，源图象的高度）
    imagecopyresampled($temp_img, $im, 0, 0, 0, 0, $temp_w, $temp_h, $width, $height);
    if ($per1 > $per2) {
        //输出图象到浏览器或文件，参数（由图象创建函数返回的图象资源，文件保存路径，图像质量，范围从 0（最差质量，文件更小）到 100（最佳质量，文件最大））
        imagejpeg($temp_img, $savepath, 100);
        //释放与$im关联的内存
        imagedestroy($im);
        return addBg($savepath, $w, $h, "w");
        //宽度优先，在缩放之后高度不足的情况下补上背景
    }
    if ($per1 == $per2) {
        imagejpeg($temp_img, $savepath, 100);
        imagedestroy($im);
        return $savepath;
        //等比缩放
    }
    if ($per1 < $per2) {
        imagejpeg($temp_img, $savepath, 100);
        imagedestroy($im);
        return addBg($savepath, $w, $h, "h");
        //高度优先，在缩放之后宽度不足的情况下补上背景
    }
}

/**
 * 添加背景
 * @param string $src 图片路径
 * @param int $w 背景图像宽度
 * @param int $h 背景图像高度
 * @param String $first 决定图像最终位置的，w 宽度优先 h 高度优先 wh:等比
 * @return 返回加上背景的图片
 * **/
function addBg($src, $w, $h, $fisrt = "w")
{
    //新建一个真彩色图像，参数（图像宽度，图像高度）
    $bg = imagecreatetruecolor($w, $h);

    //为一幅图像分配颜色，参数（图片对象，分配颜色），如果填充失败，返回-1;
    $white = imagecolorallocate($bg, 255, 255, 255);

    //填充背景(图像对象，X坐标，Y坐标，分配的颜色)
    imagefill($bg, 0, 0, $white);

    //获取目标图片信息
    $info = getImageInfo($src);
    $width = $info[0];//目标图片宽度
    $height = $info[1];//目标图片高度

    //创建图片
    $img = create($src);
    if ($fisrt == "wh") {

        //等比缩放
        return $src;
    } else {
        if ($fisrt == "w") {
            $x = 0;
            $y = ($h - $height) / 2;//垂直居中
        }
        if ($fisrt == "h") {
            $x = ($w - $width) / 2;//水平居中
            $y = 0;
        }
        imagecopymerge($bg, $img, $x, $y, 0, 0, $width, $height, 100);
        imagejpeg($bg, $src, 100);
        imagedestroy($bg);
        imagedestroy($img);
        return $src;
    }

}

