<?php

/**
 * Created by Vs Code.
 * User: YYCX
 * Date: 2018/7/26
 * Time: 下午5:41
 * Description:
 *
 * 当前仅测试了163邮箱，qq邮箱测试失败，可能原因见下。有空测试outlook和gmail
 */

// echo postmail('15658050107@163.com', '注册', 'token', 'name', 'signup');

/**
 * Undocumented function
 *
 * @param [type] $to      //收件人地址
 * @param string $subject //邮件主题
 * @param string $body    //邮件正文
 *
 * @return void
 */
function postmail($to, $subject = '', $body = '', $username = '', $type = '')
{
    error_reporting(E_STRICT);
    date_default_timezone_set('Asia/Shanghai'); //设定时区东八区
    include_once 'PHPMailer.php'; //用的直接从官方GitHub clone的最新6.0.5版本
    include 'SMTP.php';
    include 'Exception.php'; // 参考教程并没有包含该文件，但是会报错，不明白。包含之后就好了
    $mail = new PHPMailer\PHPMailer\PHPMailer(); //new一个PHPMailer对象出来
    // （直接new PHPMailer会保存找不到，需要加上命名空间）
    // $body = str_replace("[\]", '', $body); //对邮件内容进行必要的过滤
    $mail->CharSet = "utf-8"; //设定邮件编码，默认ISO-8859-1，参考代码使用GBK，依旧乱码，使用utf-8可以解决
    $mail->IsSMTP(); // 设定使用SMTP服务
    // $mail->SMTPDebug = 3; // 启用SMTP调试功能（好像是数字越大显示信息越详细）
    // 官方GitHub（https://github.com/PHPMailer/PHPMailer/wiki/SMTP-Debugging）介绍2最实用。
    // 1输出客户端发送的消息。2加上从服务器收到的响应（这是最有用的设置）。
    $mail->SMTPAuth = true; // 启用 SMTP 验证功能
    $mail->SMTPSecure = "ssl"; // 安全协议，加密信息
    $mail->isHTML = true; //允许发送
    $mail->Host = 'smtp.qq.com'; // SMTP 服务器
    $mail->Port = 465; // SMTP服务器的端口号
    $mail->Username = '747346001@qq.com'; // SMTP服务器用户名
    $mail->Password = 'inwpmndlayzmbfhf'; // SMTP服务器密码（亲测邮箱密码不行，需要用授权码）
    // qq邮箱测试失败，提示验证失败。更换163邮箱同时使用授权码后成功。未测试qq邮箱是否是因为授权码问题
    // 之后有时间再去测试gmail和outlook邮箱
    $mail->SetFrom('747346001@qq.com', '东铎'); //设置收件人看到的邮箱和用户
    // $mail->AddReplyTo('xxx@xxx.xxx','who');
    $mail->Subject = $subject;
    $mail->Body = "亲爱的" . $username . "：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/>
    <a href='http://localhost/web_PHP/active.php?verify=" . $body . "&type=" . $type . "' target=
'_blank'>http://localhost/web_PHP/active.php?verify=" . $body . "&type=" . $type . "</a><br/>
    如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。";
    // $mail->Body ='This is the HTML 信息 body <b>in bold!</b>. Time:'.date('Y-m-d H:i:s');
    $mail->AltBody = '为了查看该邮件，请切换到支持 HTML 的邮件客户端.';

    // $mail->MsgHTML("$body");
    $address = $to;

    $mail->AddAddress($address, '');
    if (!$mail->Send()) {
        // echo 'Mailer Error';
        return 'Mailer Error: ' . " $mail->ErrorInfo";
    } else {
        // echo '恭喜，邮件发送成功！';
        return "恭喜，邮件发送成功！";
    }
}
