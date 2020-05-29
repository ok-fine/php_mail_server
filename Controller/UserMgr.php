<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>用户管理</title>
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .error {
            color: #FF0000;
            top: 8px;
            position: relative;
        }
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
        .deal{
            position:relative;
            left: 10px;
            top: 165px;
            height: 30px;
            z-index: 1000;
            font-size: 20px;
            color: teal;
        }
        .choose{
            position:relative;
            left: 0;
            top: 35px;
            height: 30px;
            width: 150px;
            z-index: 1000;
        }
        .power{
            position:relative;
            left: -215px;
            top:390px;
            width: 500px;
            z-index: 1000;
        }
    </style>
</head>
<body>
<?php
require_once '../MailClient/Admin.php';
require_once '../db/MailUser.php';

session_start();

if (isset($_SESSION["login"])) {
    $info = $_SESSION["user_info"];
    $admin = $info['is_admin'];
    $admin_name = $info['user_name'];
    if(!$admin){
        header('location:HomePage.php');
    }
}else{
    header('location:Login.php');
}

$account = $user_name = $password = $mail = $mail_pwd = $mail_type = $user_power = "";
$show = 0;

$accountErr = $pwdErr = $mailErr = $mailpwdErr = $typeErr = "";
//$error = "<br>";
$errnum = 1;

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(!empty($_GET["user_name"])) {
        $user_name = test_input($_GET["user_name"]);

        if(!empty($_GET['delete'])){

//            删除用户
            if(\src\MailServer\Admin::delete($admin_name, $user_name)){
                echo "<script> alert('删除用户成功'); window.location.href='UserMgr.php';</script>";

            }else{
                echo "<script> alert('删除用户失败，请重试');</script>";
            }

        }else{

            //选择用户信息
            //设置用户需要管理的用户信息
            $user_info = \src\MailUser::get_user_info($user_name);

            $mail = $user_info['mail_addr'];
            $mail_pwd = $user_info['mail_pwd'];
            $send_power = $user_info['send_power'];
            $get_power = $user_info['get_power'];
            $mod_power = $user_info['mod_power'];

            if(!empty($_GET['show'])){
                $show = $_GET['show'];
                //            echo "show" . $show;
            }


            if(!empty($_GET["mail_pwd"])){
                $mail_pwd = test_input($_GET["mail_pwd"]);
                if (!preg_match("/^[a-zA-Z0-9]*$/",$mail_pwd))
                {
//                $accountErr = "只允许字母和数字";
                    $logErr = "只允许字母和数字";
                }else{
                    $errnum--;
                }
            }

            if(!empty($_GET['send_power'])){
                $send_power = $_GET['send_power'][0];
            }else{
                $send_power = '0';
            }

            if(!empty($_GET['get_power'])){
                $get_power = $_GET['get_power'][0];
            }else{
                $get_power = '0';
            }

            if(!empty($_GET['mod_power'])){
                $mod_power = $_GET['mod_power'][0];
            }else{
                $mod_power = '0';
            }

            //        //填写正确的话
            if($errnum == 0){

                $res = \src\MailServer\Admin::modify($user_name, $mail_pwd, $send_power, $get_power, $mod_power, $admin_name);

                if($res != false){
//                    $error = "信息修改成功";
                    echo "<script> alert('信息修改成功');</script>";

                    //修改信息
                    $user_info = \src\MailUser::get_user_info($user_name);;

                }else{
                    $error = "信息修改失败，请重试";
                }

            }
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

$users = \src\MailUser::getUsers();
$user_count = count($users);

?>

<body>

<div class="materialContainer">
    <div class="box">
        <div class="title"><strong>系统管理</strong> <a href="SystemMgr.php?front=admin">系统设置</a></div>
        <div class="button login">
            <button type="button" onclick="window.location.href='AddUser.php'">
                <span>创建用户</span>
                <i class="fa fa-check"></i>
            </button>
        </div>
        <form method="get" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="login_form">
            <div class="input">
                <label style="line-height: 18px; font-size: 18px; font-weight: 100; top: 0px;">用户列表</label>
                <div class="choose">
                    <select name="user_name" style="width: 115px;">
                        <?php
                        for($i = 0; $i < $user_count; $i++){
                            //value 为 user_name，而显示的内容为user_name
                            if($user_name == $users[$i][0]){  ?>
                                <option value="<?php echo $users[$i][0];?>" selected="selected"><?php echo $users[$i][0]; ?></option>
                            <?php   }else{ ?>
                                <option value="<?php echo $users[$i][0];?>"><?php echo $users[$i][0]; ?></option>
                            <?php   } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <input class="deal" type="submit" value="选择">
            <input class="deal" type="submit" name="delete" value="删除">
        </form>
        <form method="get" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="login_form">

        </form>
        <?php if(!empty($user_name)){ ?>
        <form method="get" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="login_form">
            <input type="hidden" hidden="hidden" name="user_name" value="<?php echo $user_name; ?>">
            <div class="input">
                <label for="mail" style="line-height: 18px; font-size: 18px; font-weight: 100; top: 0px;">邮箱号</label>
                <input readonly type="text" name="mail" id="mail" required="required" value="<?php echo $user_info['mail_addr']; ?>">
                <span class="error"><?php echo $mailErr;?></span>
            </div>
            <div class="input">
                <label for="smtp" style="line-height: 18px; font-size: 18px; font-weight: 100; top: 0px;">SMTP授权码</label>
                <?php if($show == 1){?>
                    <input type="text" name="mail_pwd" required="required" value="<?php echo $user_info['mail_pwd']; ?>">
                <?php }else{?>
                    <input type="password" name="mail_pwd" required="required" value="<?php echo $user_info['mail_pwd']; ?>">
                <?php }?>
                <button class="show" type="button" onclick="window.location.href='UserMgr.php?user_name=<?php echo $user_name; ?>&show=<?php echo !$show; ?>'">显示</button>
                <span class="error"><?php echo $mailpwdErr;?></span>
            </div>
            <div class="input">
                <label for="name" style="line-height: 18px; font-size: 18px; font-weight: 100; top: 0px;">授权</label>
            </div>
            <div class="power">
                <?php if($user_info['send_power']){ ?>
                    <input type="checkbox" name="send_power" value="1" checked="checked">发邮件(SMTP)&nbsp
                <?php }else{ ?>
                    <input type="checkbox" name="send_power" value="1">发邮件(SMTP)&nbsp
                <?php } ?>

                <?php if($user_info['get_power']){ ?>
                    <input type="checkbox" name="get_power" value="1" checked="checked">收邮件(POP3)&nbsp
                <?php }else{ ?>
                    <input type="checkbox" name="get_power" value="1">收邮件(POP3)&nbsp
                <?php } ?>

                <?php if($user_info['mod_power']){ ?>
                    <input type="checkbox" name="mod_power" value="1" checked="checked">修改个人信息
                <?php }else{ ?>
                    <input type="checkbox" name="mod_power" value="1">修改个人信息
                <?php } ?>
            </div>
            <input type="hidden" name="show" value="false">
            <div class="button login">
                <button type="submit" value="修改">
                    <span>修改</span>
                    <i class="fa fa-check"></i>
                </button>
            </div>
            <?php } ?>
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
