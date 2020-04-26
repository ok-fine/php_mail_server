<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>发送邮件</title>
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .error {color: #FF0000;}
        .copy {
            position: relative;
            top: 120px;
            left: 50px;
        }
    </style>
</head>
<body>

<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/4/13
 * Time: 11:31
 */

require_once '../MailServer/SMTP.php';
set_time_limit(0);

/**
 * @param $sendto_email  收件地址
 * @param $sendto_name   收件人
 * @param $subject       邮件标题
 * @param $body          邮件内容
 * @param $user_name     送件人名字
 * @param $post_array =[
 *          'server_address'=>'smtp.qq.com',    //smtp  服务器
 *          'port'=>465,                        //端口
 *          'mail_id'=>'xxxxx@qq.com',          //账号
 *          'mail_pwd'=>'xx',                   //密码
 *          'mail_address'=>'发件人邮箱'
 * ]
 * @return bool
 * @throws \src\Moudel\Exception
 */

session_start();

if(!isset($_SESSION['user_info'])){
    header('location:Login.php');
} else {
    $info = $_SESSION['user_info'];

    //设置发件人信息
    $admin = $info['is_admin'];
    $user_name = $info['user_name'];
    $mail_pwd = $info['mail_pwd'];
}

$mail_count = 0;
$sendto_email = $sendto_name = $subject = $body = $is_copy = "";
$emailErr = $nameErr = $subjectErr = $bodyErr = "";
$logErr = "必需字段";
$err_num = 3;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(!empty($_POST['add'])){
        if (!empty($_POST["sendto_email"]))
        {
            $sendto_email = $_POST["sendto_email"];
            $mail_count = count($sendto_email);
        }

        $subject = $_POST["subject"];
        $body = $_POST["body"];
    }else{

        //不是添加联系人时
        if (empty($_POST["sendto_email"]))
        {
            $logErr = "收件人地址是必需的";
        }
        else
        {
            $sendto_email = $_POST["sendto_email"];
            $mail_count = count($sendto_email);
            $err_num += $mail_count - 1;
            $empty = 0;

//            echo "email:" . count($sendto_email) . '<br>';
            for($i = 0; $i < $mail_count; $i++){
                if(empty($sendto_email[$i])){
                    $empty++;
                    $err_num--;
                }else{
                    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$sendto_email[$i]) || !strpos($sendto_email[$i], \src\Config::$DOMAIN))
                    {
                        $logErr = "非法邮箱格式";
                        $sendto_email[$i] = "";
//                      break;
                    }else{
                        $sendto_email[$i] =  test_input($sendto_email[$i]);
//                        var_dump($sendto_email[$i]);
                        $err_num--;
                    }
                }
            }
            if($empty == $mail_count){
                $logErr = "收件人地址是必需的";
            }
        }

        if (empty($_POST["subject"])) {
            $logErr = "标题必须填写";
        } else {
            $subject = test_input($_POST["subject"]);
            $err_num--;
        }

        if (empty($_POST["body"])) {
            $logErr = "正文必须填写";
        } else {
            $body = test_input($_POST["body"]);
            $err_num--;
        }

        if (!empty($_POST['is_copy'])) {
            array_push($sendto_email, $user_name . \src\Config::$DOMAIN);
        }
    }
}

?>
<div class="materialContainer">
    <div class="box">
        <div class="title">发邮件</div>
        <p><span class="error">* <?php echo $logErr?></span></p>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="send_form">
            <?php for($i = 0; $i < $mail_count; $i++){ ?>
                <div class="input">
                    <label for="<?php echo $i; ?>" >收件人邮箱*</label>
                    <input type="text" id="<?php echo $i; ?>" name="sendto_email[]" value="<?php echo $sendto_email[$i]; ?>">
                </div>
            <?php } ?>
            <?php if(empty($_POST['send'])){ ?>
                <div class="input">
                    <label for="ste" >收件人邮箱*</label>
                    <input type="text" id="ste" name="sendto_email[]">
                </div>
            <?php } ?>
            <div class="button login">
                <button type="submit" name="add" value="+" onclick="window.location.href='try.php?'">
                    <span>+</span>
                    <i class="fa fa-check"></i>
                </button>
                <span class="error"><?php echo $emailErr;?></span>
            </div>
            <div class="input">
                <label for="subject">标题*</label>
                <input type="text" id="subject" name="subject" value="<?php echo $subject;?>">
                <span class="spin"><?php echo $subjectErr;?></span>
            </div>
            <div class="textarea" style="margin-bottom: 60px">
                <label for="content">正文*</label>
                <textarea name="body" id="content" cols="50" rows="5" style="background-color: gainsboro;color: black"><?php echo $body;?></textarea>
                <span class="spin"><?php echo $bodyErr;?></span>
            </div>
            <div class="copy">
                <input type="checkbox" name="is_copy">
                <span>是否抄送</span>
                </input>
            </div>
            <div class="button login" style="height: auto">
                <button type="submit" name="send" value="发送">
                    <span>发送</span>
                    <i class="fa fa-check"></i>
                </button>
            </div>

        </form>
    </div>

     <div class="overbox">
        <button type="button" class="btn btn-primary" onclick="window.location.href='HomePage.php'">
            <div class="material-button alt-2">
                <span class="shape" style="transform: rotate(45deg);"></span>
            </div>
        </button>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/index.js"></script>

</body>
</html>


<?php

//    echo "err_num:" . $err_num;
if($err_num == 0){

    $sendto = $sendto_email[0];
    for($i = 1; $i < $mail_count; $i++){
        if(!empty($sendto_email[$i])){
            $sendto .= " ";
            $sendto .= $sendto_email[$i];
        }
    }

    print "RCPT TO: " . $sendto . "\n";

    $res = SMTP::send_mail($user_name, $mail_pwd, $sendto, $subject, $body);

    if($res){
        echo "<script> alert('邮件发送成功'); window.location.href='SMTPMgr.php' </script>";
    }else{
        echo "<script> alert('部分邮件发送失败，请重试'); </script>";
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
