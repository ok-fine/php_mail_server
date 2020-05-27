<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>收件箱</title>
    <style>
        .subject {
            font-weight: bold;
            font-size: x-large;
        }
        .info {
            color: darkgrey;
            font-size: small;
        }
    </style>
</head>
<body>

<?php

/**
 * Created by PhpStorm.
 * User: weiyixi
 * Date: 2018/8/30
 * Time: 11:30
 */

require_once '../Config.php';
require_once '../MailServer/POP3.php';

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

if(!empty($_GET['email_id'])){
    $email_id = $_GET['email_id'];
//    echo "id " . $email_id . "\n";
    $mail_info = json_decode(POP3::mail_info($user_name, $mail_pwd, $email_id));
}else{
    header('location:POP3Mgr.php');
}

echo $info['user_name'] . ", 好好学习 天天向上";

?>

<button type="button" class="btn btn-primary" onclick="window.location.href='POP3Mgr.php'">返回</button><br><br>

<body>

<div class="title">邮件详情</div>
<table width="100%" border="1" >
    <tr>
        <td>
            <div class="subject"><?php echo $mail_info[3]?></div>
            <div class="info">
                发件人：<?php echo $mail_info[1]?><br>
                收件人：<?php echo $mail_info[2]?><br>
                时  间：<?php echo $mail_info[5]?><br>
                大  小：<?php echo $mail_info[6]?>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $mail_info[4]?>
        </td>
    </tr>
</table>

</body>

