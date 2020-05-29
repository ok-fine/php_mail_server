<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>账号管理</title>
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .error {color: #FF0000;}
        .select {
            position:relative;
            left: 80%;
            top:-35px;
            height: 0;
            z-index: 1000;
        }
        .show {
            font-size: 20px;
            color: teal;
            position: relative;
            left: 80%;
            top: -35px;
            z-index: 1000;
        }
    </style>
</head>
<body>


<?php
require_once '../MailClient/User.php';
require_once '../db/MailUser.php';

session_start();

if (isset($_SESSION["login"])) {
    $info = $_SESSION["user_info"];
    $admin = $info['is_admin'];
}else{
    header('location:Login.php');
}

$account = $info['user_name'];
$mail = $info["mail_addr"];
$mail_pwd = $info["mail_pwd"];
$show = 0;

$accountErr = $pwdErr = $mailErr = $mailpwdErr = $typeErr = "";
$error = "<br>";
$errnum = 1;

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(!empty($_GET['show'])){
        $show = $_GET['show'];
//        echo "show" . $show;
    }

    if(!empty($_GET["mail_pwd"])){
        $mail_pwd = test_input($_GET["mail_pwd"]);

        if (!preg_match("/^[a-zA-Z0-9]*$/",$mail_pwd))
        {
//            $accountErr = "只允许字母和数字";
            $logErr = "只允许字母和数字";
        }else{
            $errnum--;
        }
    }

    //填写正确的话
    if($errnum == 0){
//        echo "right";
        if(\src\MailClient\User::modify($account, $mail_pwd) != false){
            $error = "信息修改成功";
            echo "<script> alert('信息修改成功');</script>";

            //修改信息
            $_SESSION['user_info'] = \src\MailUser::get_user_info($account);
            $info = $_SESSION['user_info'];
        }else{
            $error = "信息修改失败，请重试";
        }

    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<body>

<div class="materialContainer">
    <div class="box">
        <div class="title"><strong>账号设置</strong> <a href="SystemMgr.php?front=user">系统设置</a></div>
        <form method="get" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="login_form">
            <div class="input">
                <label for="name" style="line-height: 18px; font-size: 18px; font-weight: 100; top: 0px;">用户名</label>
                <br><tr><?php echo $info['user_name']; ?></tr>
<!--                <input type="text" name="account" id="name" required="required" value="--><?php //echo $info['user_name']; ?><!--">-->
<!--                <span class="spin">--><?php //echo $accountErr;?><!--</span>-->
            </div>
            <div class="input">
                <label for="mail" style="line-height: 18px; font-size: 18px; font-weight: 100; top: 0px;">邮箱号</label>
                <br><?php echo $info['mail_addr']; ?>
<!--                <input type="text" name="mail" id="mail" required="required" value="--><?php //echo $info['user_mail']; ?><!--">-->
<!--                <span class="error">--><?php //echo $mailErr;?><!--</span>-->
            </div>
            <div class="input">
                <label for="smtp" style="line-height: 18px; font-size: 18px; font-weight: 100; top: 0px;">密&nbsp&nbsp码</label>
                <?php if($show == 1){?>
                    <input type="text" name="mail_pwd" required="required" value="<?php echo $mail_pwd; ?>">
                <?php }else{?>
                    <input type="password" name="mail_pwd" required="required" value="<?php echo $mail_pwd; ?>">
                <?php }?>
                <button class="show" type="button" onclick="window.location.href='InfoMgr.php?show=<?php echo !$show;  ?>'">显示</button>
                <span class="error" required="required"><?php echo $mailpwdErr;?></span>
            </div>
            <input type="hidden" name="show" value="0">
            <div class="button login">
                <button type="submit" value="修改">
                    <span>修改</span>
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