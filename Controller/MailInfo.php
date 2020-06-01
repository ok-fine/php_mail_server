<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>邮件详情</title>
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
         html,body {
          height: 100%;
        }
        body {
          margin-left: 60px;
          margin-top: 60px;
          margin-right: 60px;
          margin-bottom: 60px;
          overflow:hidden;
        }
        .subject {
            font-weight: bold;
            font-size: x-large;
            margin-left: 10px;
            margin-top: 10px;
        }
        .info {
            color: black;
            font-size: large;
            margin-left: 20px;
            margin-top: 20px;
        }
        .comments {
             width:90%;/*自动适应父布局宽度*/
             height: 90%;
             overflow:auto;
             word-break:break-all;
             color: black;
             font-size: 18px;
             margin-left: 5%;
             margin-top: 5%；
             border: 0;
             border-radius:5px;
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



<body>

<div class="title">邮件详情</div>
<button type="button" class="btn btn-primary" onclick="window.location.href='POP3Mgr.php'">返回</button><br><br>
<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0" style="background-color: white">
    <tr>
        <td height="25%">
            <div class="subject">111<?php echo $mail_info[3]?></div>
            <div class="info">
                发件人：<?php echo $mail_info[1]?><br>
                收件人：<?php echo $mail_info[2]?><br>
                时  间：<?php echo $mail_info[5]?><br>
                大  小：<?php echo $mail_info[6]?>
            </div>
        </td>
    </tr>
    <tr>
        <td height="75%" width="100%" >
            <div class="comments" >
                正文：<br><br><?php echo $mail_info[4]?>
            </div>
        </td>
    </tr>
</table>

</body>

