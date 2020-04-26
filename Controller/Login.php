<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>登陆</title>
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
        <style>
            .error {color: #FF0000;}
            .admin {
                position: relative;
                top: 30px;
            }
        </style>
</head>

<?php
require_once '../MailClient/User.php';
require_once '../db/MailUser.php';

//每次进入login的时候都需要先销毁session
//避免退出到login页面后仍能够直接访问用户界面
exitUser();

$account = $password = "";
$accountErr = $pwdErr = "";
$errnum = 2;
$logErr = "必需字段";

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    if (!empty($_GET["account"]))
    {
        $account = test_input($_GET["account"]);
        // 检测名字是否只包含字母和下划线
        if (!preg_match("/^[a-zA-Z0-9_]*$/",$account))
        {
//            $accountErr = "只允许字母数字下划线_";
            $logErr = "只允许字母数字下划线_";
        }else{
            $errnum--;
        }
    }

    if (!empty($_GET["password"]))
    {
        $password = test_input($_GET["password"]);
        $errnum--;
    }

//    echo $account . $password . ' ' . $errnum .'<br>';

    //填写正确的话
    if($errnum == 0){
        $log = \src\MailClient\User::login($account, $password);
        if($log){

            $life_time = 1800; //3600为 1 小时
            session_set_cookie_params($life_time);
            //在登陆时打开全局session，用来存储user；
            session_start();
            $_SESSION['user_info'] = \src\MailUser::get_user_info($account);
            $_SESSION['login'] = 1;

            header('location:HomePage.php');
        }else{
            $logErr = "账号或密码错误";
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

function exitUser(){
    session_start();
    if(isset($_SESSION['user_info'])){
        unset($_SESSION['user_info']);
        session_destroy();
    }

    //调用服务器的退出功能
}
?>

<body>

<div class="materialContainer">
    <div class="box">
        <div class="title">登录</div>
        <p><span class="error">* <?php echo $logErr?></span></p>
        <form method="get" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="login_form">
            <div class="input">
                <label for="name">账号*</label>
                <input type="text" name="account" id="name" required="required">
                <span class="error"><?php echo $accountErr;?></span>
            </div>
            <div class="input">
                <label for="pass">密码*</label>
                <input type="password" name="password" id="pass" required="required">
                <span class="error"><?php echo $pwdErr;?></span>
            </div>
<!--            <div class="admin">-->
<!--                <input type="checkbox" name="admin"  value="1">-->
<!--                <span>是否是管理员</span>-->
<!--                </input>-->
<!--            </div>-->
            <div class="button login admin">
                <button type="submit" value="登陆">
                    <span>登录</span>
                    <i class="fa fa-check"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="overbox">
        <a href="Register.php">
            <div class="material-button alt-2">
                <span class="shape"></span>
            </div>
        </a>
    </div>

</div>

<script src="js/jquery.min.js"></script>
<script src="js/index.js"></script>

</body>
</html>
