<!DOCTYPE HTML>
<?php
session_start();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>商品列表</title>
        <style type="text/css">
            h1{
                font-size:48px;
                color:#930;
                text-align:center;
            }
            .user{
                color:#B0C4DE;
                text-align:right;

            }
        </style>
    </head>
    <body>
        <div class="user">
            <?php
if ($_SESSION['logflag']) {
            print '<span>'.$_SESSION['name'].'</span>';
    ?>
            <span>&nbsp|&nbsp</span>
            <a href=".\exitlog.php">退出登录</a>
            <?php
} else {
    ?>
            <a href=".\login.html">登录</a>
            <?php
}
?>
        <span>&nbsp|&nbsp</span>
        <a href=".\register.html">注册</a>
        </div>
        <hr/>
        <h1 align="center" >商品列表</h1>
        <br/>
        <hr border="5" color="#930"/>
        <br/>
        <br/>
        <br/>
        <div>
        <?php
if ($_SESSION['logflag']) {
    ?>
            <table width="800" height="80" border="1" align="center">
                <?php
$fh = fopen('D:/GitHub/Python/data2.csv', 'rb');
    if (!$fh) {
        die("Can't open csvdata.csv: $php_errormsg");
    }

    // print "<table>\n";

    for ($line = fgetcsv($fh, 1024);!feof($fh); $line = fgetcsv($fh, 1024)) {
        print '<tr><td>' . implode('</td><td>', $line) . "</td></tr>\n";
    }

    // print '</table>';
    ?>
            </table>
            <?php
} else {
    print '<h2 align="center">' . '客官，想浏览数据请先登录哦↑' . '</h2>';
}
?>
        </div>
    </body>
</html>