<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>收件箱</title>
</head>
<body>

<?php

/**
 * Created by PhpStorm.
 * User: weiyixi
 * Date: 2018/8/30
 * Time: 11:30
 */

set_time_limit(0);

session_start();

if (isset($_SESSION["user_info"])) {
    $info = $_SESSION["user_info"];
    $admin = $info['is_admin'];
}else{
    header('location:Login.php');
}

$user_name = $info['user_name'];
$mail_pwd = $info['mail_pwd'];

echo $info['user_name'] . ", 好好学习 天天向上";

?>

<button type="button" class="btn btn-primary" onclick="window.location.href='HomePage.php'">返回</button><br><br>

<body>

    <div class="title">账号管理</div>
    <form method="get" action="MailInfo.php" class="login_form">
        <table width="100%" border="1" >
            <tr>
                <td width="5%">读否</td><td width="30%">发件人</td><td width="50%">主题</td><td width="15%">时间</td>
            </tr>
            <?php for($i = 0; $i < \src\Config::$PAGENUM; $i++){  ?>
            <tr>

            </tr>
            <?php } ?>
        </table>

    </form>

</body>

