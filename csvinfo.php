//导入csv
<?php
    public function import()
    {
        if (!$_FILES['file']['name']){//判断是否为空
            echo '上传文件不能为空，请导入csv文件';exit;
        }

        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);//取后缀名

        if ($extension != 'csv') {//判断是否为csv文件
            echo '该文件不是csv文件，请导入csv文件';exit;
        }
        
        $file_path = 'D:/GitHub/Python/data2.csv';
        $status = move_uploaded_file($_FILES['file']['tmp_name'], $file_path);//将文件保存到指定的路径

        if (!$status) {
            echo "上传失败!";exit;
        }

        $handle = fopen($file_path, "r");
        $sql_str = '';
        while (($fileop = fgetcsv($handle, 1000, ",")) !== false) {
            $name = mb_convert_encoding($fileop[0], "UTF-8", "GBK");
            $sex = mb_convert_encoding($fileop[1], "UTF-8", "GBK");
            $age = $fileop[2];
            $str = "('".$name."', '".$sex."', $age), ";
            $sql_str .= $str;
        }
        $sqlstr = substr($sql_str, 0, strlen($sql_str)-2);//去除最后的空格和逗号
        fclose($handle);
        $sql = "INSERT INTO `user` (`name`, `sex`, `age`) VALUES $sqlstr";//sql语句
        $query = mysql_query($sql);
        if (!$query) {
            echo "导入失败！";exit;
        }else{
            echo "导入完成！";exit;
        }
    }
?>