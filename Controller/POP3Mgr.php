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
$start = 0;
$end = 0;

if(!empty($_GET['delete'])){
    $id = $_GET['delete'];
    POP3::mail_delete($user_name, $mail_pwd, $id);
    $start = $_GET['page'];
    echo "<script> alert('邮件删除成功');</script>";
}

//进入该页面才刷新
if(!empty($_GET['start']) && !empty($_SESSION['mail_list']) ){
    $mail_list = $_SESSION['mail_list'];
    $mail_num = count($mail_list);

    $start = max(0, $_GET['start']);
    if($start >= $mail_num){
        $start -= \src\Config::$PAGENUM;
    }
    $end = min($mail_num, $start + \src\Config::$PAGENUM);

}else{
    $mail_list = json_decode(POP3::mail_list($user_name, $mail_pwd));
    $_SESSION['mail_list'] = $mail_list;
    $mail_num = count($mail_list);

//    $start = 0;
    $end = min($mail_num, $start + \src\Config::$PAGENUM);
}

echo $info['user_name'] . ", 好好学习 天天向上";

?>

<button type="button" class="btn btn-primary" onclick="window.location.href='HomePage.php'">返回</button><br><br>

<body>

    <div class="title">收件箱</div>
        <table width="100%" border="1" >
            <tr>
                <td width="5%">读否</td><td width="30%">发件人</td><td width="42%">主题</td><td width="15%">时间</td><td width="8%" colspan="2">操作</td>
            </tr>
            <?php if($mail_num == 0){  ?>
                <tr>
                    <td colspan="4">没有邮件了！</td>
                </tr>
            <?php }else{ ?>
                <?php for($i = $start; $i < $end; $i++){  ?>
                <tr>
                    <td>
                        <?php if($mail_list[$i][4]){ ?>
                            已读
                        <?php }else{ ?>
                            未读
                        <?php } ?>
                    </td>
                    <td><?php echo $mail_list[$i][1] ?></td>
                    <td><?php echo $mail_list[$i][2] ?></td>
                    <td><?php echo getTime($mail_list[$i][3])?></td>
                    <td>
                        <a href="./MailInfo.php?email_id=<?php echo $mail_list[$i][0] ?>">读取</a>
                    </td>
                    <td>
                        <a href="./POP3Mgr.php?delete=<?php echo $mail_list[$i][0] ?>&page=<?php echo $start ?>">删除</a>
                    </td>
                </tr>
                <?php } ?>
            <?php } ?>
        </table>
    第<?php $page_num = ceil($mail_num / \src\Config::$PAGENUM); echo min($page_num, $start / \src\Config::$PAGENUM + 1); ?>页/共<?php echo $page_num;?>页
    <a href="POP3Mgr.php?start=<?php echo $start - \src\Config::$PAGENUM ?>" >上一页</a>
    <a href="POP3Mgr.php?start=<?php echo $start + \src\Config::$PAGENUM ?>">下一页</a>

</body>
<?php
function getTime($time){
    $date = substr($time, 0, 10);
    date_default_timezone_set('Asia/Shanghai');
    if($date == date("Y-m-d")){
        $date = substr($time, 11);
    }
    return $date;
}

?>
