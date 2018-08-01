<?php
include 'emailsend.php'; //连接发送邮件功能
function regemail($username, $toemail, $token)
{
    $emailsubject = "用户帐号激活";
    $emailbody = "亲爱的" . $username . "：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/>
    <a href = 'http://localhost/spidersweb/active.php?verify=" . $token . "' target='_blank'>激活邮箱</a>
    <br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。
    <br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>XXX网站</p>";
    $rs = sendMail($toemail, $emailsubject, $emailbody);
    return $re;
}
