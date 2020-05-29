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
require_once '../db/Mail.php';

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

//获取用户过滤信息
//$filter_cont = array();
//array_push($filter_cont, \src\Mail::get_ac_filter($account));
//array_push($filter_cont, \src\Mail::get_ip_filter($account));
//var_dump($filter_cont);

$front_page = "user";
$ac_list = \src\Mail::get_ac_filter($account);
$ip_list = \src\Mail::get_ip_filter($account);
$anum = $inum = 1;
var_dump($ac_list);
var_dump($ip_list);

$logErr = "";
$err_num = 2;

if(!empty($_GET['front'])){
    $front_page = $_GET['front'];
}

if(!empty($_GET['ac_list'])){
    array_merge($ac_list, $_GET['ac_list']);
//    $ac_list = $_GET['ac_list'];
}

if(!empty($_GET['ip_list'])){
    array_merge($ip_list, $_GET['ip_list']);
//    $ip_list = $_GET['ip_list'];
}

var_dump($ac_list);

if(!empty($_GET['anum'])){
    $anum = $_GET['anum'];
}

if(!empty($_GET['inum'])){
    $inum = $_GET['inum'];
}

//邮件格式检查
$temp = count($ac_list);
for($i = 0 ; $i < count($ac_list) ; $i++){
    if(!empty($ac_list[$i])){
        if (!preg_match("/(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]|[0-9])/",$ac_list[$i]) || !strpos($ac_list[$i], \src\Config::$DOMAIN)){
            $logErr = "非法邮箱格式";
            break;
        }
    }else{
        unset($ac_list[$i]);
    }
    $temp--;
}
if($temp == 0 && count($ac_list) != 0){
    $err_num--;
}

//ip格式检查
$temp = count($ip_list);
for($i = 0 ; $i < count($ip_list) ; $i++){
    if(!empty($ip_list[$i])){
        if (!text_ip($ip_list[$i])){
            $logErr = "非法IP格式";
            break;
        }
    }else{
        unset($ip_list[$i]);
    }
    $temp--;
}
if($temp == 0 && count($ip_list) != 0){
    $err_num--;
}

echo $err_num;

//all right
if($err_num == 0){
    echo "aclist:";
    var_dump($ac_list);

    if(\src\Mail::set_filter($account, $ac_list, $ip_list)) {
        echo "<script> alert('系统设置成功'); window.location.href='SystemMgr.php' </script>";
    }else{
        echo "<script> alert('系统设置失败'); window.location.href='SystemMgr.php' </script>";
    }

}

?>

<body>

<div class="materialContainer">
    <div class="box">
        <div class="title">
            <?php if($front_page == "admin"){ ?>
                <a href="UserMgr.php">账号设置</a>
            <?php  }else{ ?>
                <a href="InfoMgr.php">账号设置</a>
            <?php  } ?>
            <strong>系统设置</strong>
        </div>
        <form method="get" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="login_form">
            <div>
               <label for="mail" style="line-height: 18px; font-size: 18px; font-weight: 100; top: 0px;">邮件过滤(不包含)<span class="error"> <?php echo $logErr?></span></label><br><br>
                <table border="1" width="100%"  >
                    <tr>
                        <td width="25%">账号过滤:</td>
                        <td width="65%">
                            <?php for($i = 0 ; $i < count($ac_list) ; $i++){ ?>
                                <input name="ac_list[]" type="text" value="<?php echo $ac_list[$i]; ?>"><br>
                            <?php  } ?>
                            <?php for($i = count($ac_list) ; $i < $anum ; $i++){ ?>
                                <input name="ac_list[]" type="text"><br>
                            <?php  } ?>
                        </td>
                        <td width="10%" align="center">
                            <a href="SystemMgr.php?front=<?php echo $front_page;?>&anum=<?php echo $anum + 1;?>&inum=<?php echo $inum;?>">+</a>
                        </td>
                    </tr>
                    <tr>
                        <td>IP过滤：</td>
                        <td>
                            <?php for($i = 0 ; $i < count($ip_list) ; $i++){ ?>
                                <input name="ac_list[]" type="text" value="<?php echo $ip_list[$i]; ?>"><br>
                            <?php  } ?>
                            <?php for($i = count($ip_list) ; $i < $inum ; $i++){ ?>
                                <input name="ip_list[]" type="text"><br>
                            <?php  } ?>
                        </td>
                        <td align="center">
                            <a href="SystemMgr.php?front=<?php echo $front_page;?>&anum=<?php echo $anum;?>&inum=<?php echo $inum + 1;?>">+</a>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="anum" value="<?php echo $anum;?>">
                <input type="hidden" name="inum" value="<?php echo $inum;?>">
                <div class="button login">
                    <button type="submit" value="修改">
                        <span>设置</span>
                        <i class="fa fa-check"></i>
                    </button>
                </div>
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

function text_ip($ip){
    $ip = explode('.', $ip);
    if(count($ip) == 4 &&
        preg_match("/^(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])$/", $ip[0]) &&
        preg_match("/^(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])$/", $ip[1]) &&
        preg_match("/^(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])$/", $ip[2]) &&
        preg_match("/^(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])$/", $ip[3])){

        return true;
    }
    return false;
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>