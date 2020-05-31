<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>首页</title>
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
require_once '../MailClient/User.php';
require_once '../db/MailUser.php';

session_start();

if (isset($_SESSION["login"])) {
    $info = $_SESSION["user_info"];
    $admin = $info['is_admin'];
    $login = $_SESSION['login'];
    $logErr = $info['user_name'] . ", 好好学习 天天向上";
}else{
    header('location:Login.php');
}
?>


<div class="materialContainer">
    <div class="box">
        <div class="title">首页</div>
        <p><span style="color: teal"><?php echo $logErr?></span></p><br><br>
        <?php

        if(!$admin){
            if($info['send_power']){ ?>
                <a href="SMTPMgr.php" class="button login">
                    <button>
                        <span>发邮件</span>
                        <i class="fa fa-check"></i>
                    </button>
                </a>
            <?php }else{ ?>
                <a href="HomePage.php" onclick="alert('没有发邮件的权限');" class="button login">
                    <button>
                        <span>发邮件</span>
                        <i class="fa fa-check"></i>
                    </button>
                </a>
            <?php }
            if($info['get_power']){ ?>
                <a href="POP3Mgr.php" class="button login">
                    <button>
                        <span>收件箱</span>
                        <i class="fa fa-check"></i>
                    </button>
                </a>
            <?php }else{ ?>
                <a href="HomePage.php" onclick="alert('没有收邮件的权限');" class="button login">
                    <button>
                        <span>收件箱</span>
                        <i class="fa fa-check"></i>
                    </button>
                </a>
            <?php }
            if($info['mod_power']){ ?>
                <a href="InfoMgr.php" class="button login">
                    <button>
                        <span>账号管理</span>
                        <i class="fa fa-check"></i>
                    </button>
                </a>
            <?php }else{ ?>
                <a href="HomePage.php" onclick="alert('没有修改账户信息的权限');" class="button login">
                    <button>
                        <span>账号管理</span>
                        <i class="fa fa-check"></i>
                    </button>
                </a>
            <?php }

        }else{ ?>

            <a href="SMTPMgr.php" class="button login">
                <button>
                    <span>发邮件</span>
                    <i class="fa fa-check"></i>
                </button>
            </a>
            <a href="POP3Mgr.php" class="button login">
                <button>
                    <span>收件箱</span>
                    <i class="fa fa-check"></i>
                </button>
            </a>
            <a href="InfoMgr.php" class="button login">
                <button>
                    <span>账号管理</span>
                    <i class="fa fa-check"></i>
                </button>
            </a>
            <a href="UserMgr.php" class="button login">
                <button>
                    <span>系统管理</span>
                    <i class="fa fa-check"></i>
                </button>
            </a>
        <?php }  ?>
        <a href="LogMgr.php" class="button login">
            <button>
                <span>日志管理</span>
                <i class="fa fa-check"></i>
            </button>
        </a>
    </div>
    <div class="overbox">
        <button type="button" class="btn btn-primary" onclick="window.location.href='Login.php'">
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



