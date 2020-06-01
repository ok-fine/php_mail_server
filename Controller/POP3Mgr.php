<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>收件箱</title>
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style type="text/css">
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
        .STYLE1 {
          color: #FFFFFF;
          font-size: 14px;
          font-weight: bold;
        }
        .STYLE2 {font-size: 14px}
        .STYLE3 {
          color: #666666;
          font-weight: bold;
          font-size: 14px;
        }
    </style>
</head>

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


<body>
  <div class="title">收件箱</div>
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: white">
    <tr>
      <td height="25" bgcolor="#1078b5" style="padding-left:15px;"><span class="STYLE1"></span>
      <button type="button" class="btn btn-primary" onclick="window.location.href='HomePage.php'">返回</button></td>
    </tr>
    <tr>
      <td valign="top" style="border:solid 1px #8db6cf;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="22"  style="border-bottom:solid 1px #8db6cf; padding-top:1px; padding-bottom:1px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="9%" height="22" style=" border-right: solid 1px #6daed6; border-left:solid 1px #e7f4fc;"><div align="center"><span class="STYLE2"></span> 读否 </div></td>
              <td width="11%" style="padding-left:1px; border-right: solid 1px #6daed6; border-left:solid 1px #e7f4fc;"><div align="center"><span class="STYLE2"> 发件人</span></div></td>
              <td width="56%" style="padding-left:1px; border-right: solid 1px #6daed6; border-left:solid 1px #e7f4fc;"><div align="center"><span class="STYLE2">主题</span></div></td>
              <td width="12%" style="padding-left:1px; border-right: solid 1px #6daed6; border-left:solid 1px #e7f4fc;"><div align="center"><span class="STYLE2">时间</span></div></td>
              <td width="12%" style="padding-left:1px; border-right: solid 1px #6daed6; border-left:solid 1px #e7f4fc;"><div align="center"><span class="STYLE2">操作</span></div></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td style="padding-top:10px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <?php if($mail_num == 0){  ?>
                <tr>
                    <td colspan="4">没有邮件了！</td>
                </tr>
            <?php }else{ ?>
                <?php for($i = $start; $i < $end; $i++){  ?>
                <tr>
                   <td style="padding-top:10px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="9%" height="22" style="border-bottom:solid 1px #c3d7e3;">
                          <?php if($mail_list[$i][4]){ ?>
                            <div align="center"><img src="images/yidu.png" width="24" height="24"></div>
                          <?php }else{ ?>
                            <div align="center"><img src="images/weidu.png" width="24" height="24"></div>
                          <?php } ?>
                      </td>
                      <td width="11%" style="border-bottom:solid 1px #c3d7e3;"class="STYLE2"><div align="center"><span class="STYLE2"><?php echo $mail_list[$i][1] ?> </span></div></td>
                      <td width="56%" style="border-bottom:solid 1px #c3d7e3;"class="STYLE2"><div align="center"><span class="STYLE2"> <?php echo $mail_list[$i][2] ?> </span></div></td>
                      <td width="12%" style="border-bottom:solid 1px #c3d7e3;"class="STYLE2" ><div align="center"><?php echo $mail_list[$i][3] ?></div></td>
                      <td width="6%"style="border-bottom:solid 1px #c3d7e3;text-align: center;" class="STYLE2" >
                          <a align="center" href="./MailInfo.php?email_id=<?php echo $mail_list[$i][0] ?>"><img src="images/chakan.png" width="24" height="24"></a>
                      </td>
                      <td width="6%"style="border-bottom:solid 1px #c3d7e3;text-align: center;" class="STYLE2" >
                          <a align="center" href="./POP3Mgr.php?delete=<?php echo $mail_list[$i][0] ?>&page=<?php echo $start ?>"><img src="images/shanchu.png" width="24" height="24"></a>
                      </td>
                    </tr>
                  </table></td>
                </tr>
              <?php } ?>
            <?php } ?>
            <td>
              第<?php $page_num = ceil($mail_num / \src\Config::$PAGENUM); echo min($page_num, $start / \src\Config::$PAGENUM + 1); ?>页/共<?php echo $page_num;?>页
              <a href="POP3Mgr.php?start=<?php echo $start - \src\Config::$PAGENUM ?>" >上一页</a>
              <a href="POP3Mgr.php?start=<?php echo $start + \src\Config::$PAGENUM ?>">下一页</a>
            </td>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table></td>
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
