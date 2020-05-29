<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>注册</title>
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .error {color: #FF0000;}
        .select {
            position:relative;
            left: 78%;
            top:-30px;
            height: 0;
            z-index: 1000;
        }
    </style>
</head>

<?php
require_once '../MailClient/User.php';
require_once '../db/MailUser.php';

$account = $password = $mail = $mail_pwd = $mail_type = "";
$accountErr = $pwdErr = $mailErr = $mailpwdErr = $typeErr = "";
$logErr = "必需字段";
$errnum = 2;


if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(!empty($_GET["account"])) {
        $account = test_input($_GET["account"]);

        // 检测名字是否只包含字母和下划线
        if (!preg_match("/^[a-zA-Z0-9_]*$/",$account))
        {
//            $accountErr = "只允许字母数字和下划线_";
            $logErr = "只允许字母数字和下划线_";
        }else{
            $errnum--;
        }
    }

    if(!empty($_GET["password"])){
        $password = test_input($_GET["password"]);

        if (!preg_match("/^[a-zA-Z0-9]*$/",$password))
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

        $res = \src\MailClient\User::register($account, $password);
        if($res != false){
            if(\src\MailClient\User::login($account, $password)){
                $life_time = 1800; //3600为 1 小时
                session_set_cookie_params($life_time);

                session_start();
                $_SESSION['user_info'] = \src\MailUser::get_user_info($account);
                $_SESSION['login'] = 1;

                header('location:HomePage.php');
            }else{
                header('location:Login.php');
            }
        }else{
            $logErr = "该用户已存在";
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
        <div class="title">注册</div>
        <p><span class="error">* <?php echo $logErr?></span></p>
        <form method="get" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="login_form">
            <div class="input">
                <label for="name">账号*</label>
                <input type="text" name="account" id="name" required="required">
                <span class="spin"><?php echo $accountErr;?></span>
            </div>
            <div class="input">
                <label for="pass">密码*</label>
                <input type="password" name="password" id="pass" required="required">
                <span class="spin"><?php echo $pwdErr;?></span>
            </div>
            <div class="button login">
                <button type="submit" value="注册">
                    <span>注册</span>
                    <i class="fa fa-check"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="overbox">
        <a href="Login.php">
            <div class="material-button alt-2">
                <span class="shape" style="transform: rotate(45deg);"></span>
            </div>
        </a>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/index.js"></script>

</body>
</html>

