<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>收件箱</title>
    <style>
        .breadcrumb {
            background-color: #ffffff;
            padding: 0;
            margin-bottom: 0;
        }
        .breadcrumb > li {
            display: inline;
        }
        .breadcrumb > li a {
            color: inherit;
            text-decoration: none;
        }
        .breadcrumb > .active {
            color: inherit;
        }
        .breadcrumb > a {
            /*color: inherit;*/
            float: right;
            text-align: right;
        }
        a {
            color: black;
            text-decoration: none;
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
require_once '../db/Log.php';

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

//显示内容设置
$type = "ALL";// ALL POP3 SMTP SERVER
if(!empty($_GET['type'])){
    $type = $_GET['type'];
}


//页数设置
$start = 0;
$end = 0;

//删除操作
if(!empty($_GET['delete'])){
    $id = $_GET['delete'];
    \src\Log::delete($id);
    $start = $_GET['page'];
    echo "<script> alert('日志删除成功');</script>";
}

//是否显示详情
$detail = array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1);
if(!empty($_GET['detail'])){
    $detail = json_decode($_GET['detail']);
    $detail[(int)$_GET['i']] *= -1;
    $start = $_GET['page'];
}

//进入该页面才刷新
if(!empty($_GET['start']) && !empty($_SESSION['log_list']) ){
    $log_list = $_SESSION['log_list'];
    $log_num = count($log_list);

    $start = max(0, $_GET['start']);
    if($start >= $log_num){
        $start -= \src\Config::$PAGENUM;
    }
    $end = min($log_num, $start + \src\Config::$PAGENUM);

}else{
    if($admin){
        $log_list = \src\Log::get_all($type);
    }else{
        $log_list = \src\Log::get($user_name, $type);
    }

    $_SESSION['log_list'] = $log_list;
    $log_num = count($log_list);

//    $start = 0;
    $end = min($log_num, $start + \src\Config::$PAGENUM);
}

echo $info['user_name'] . ", 好好学习 天天向上";

?>

<button type="button" class="btn btn-primary" onclick="window.location.href='HomePage.php'">返回</button><br><br>

<body>

    <div> <h3>日志管理</h3></div >
    <ol class="breadcrumb" style="display: inline">
        <?php switch ($type){
            case "SMTP": ?>
                <li class="active">
                    <a href="LogMgr.php?type=ALL" onclick="user.exit()">全部</a>
                </li>
                <li>
                    <strong>SMTP</strong>
                </li>
                <li >
                    <a href="LogMgr.php?type=POP3" onclick="user.exit()">POP3</a>
                </li>
                <li>
                    <a href="LogMgr.php?type=SERVER" onclick="user.exit()">系统日志</a>
                </li>
            <?php break; case "POP3": ?>
                <li class="active">
                    <a href="LogMgr.php?type=ALL" onclick="user.exit()">全部</a>
                </li>
                <li>
                    <a href="LogMgr.php?type=SMTP" onclick="user.exit()">SMTP</a>
                </li>
                <li >
                    <strong>POP3</strong>
                </li>
                <li>
                    <a href="LogMgr.php?type=SERVER" onclick="user.exit()">系统日志</a>
                </li>
            <?php break; case "SERVER": ?>
                <li class="active">
                    <a href="LogMgr.php?type=ALL" onclick="user.exit()">全部</a>
                </li>
                <li>
                    <a href="LogMgr.php?type=SMTP" onclick="user.exit()">SMTP</a>
                </li>
                <li >
                    <a href="LogMgr.php?type=POP3" onclick="user.exit()">POP3</a>
                </li>
                <li>
                    <strong>系统日志</strong>
                </li>
            <?php break; default: ?>
                <li class="active">
                    <strong>全部</strong>
                </li>
                <li>
                    <a href="LogMgr.php?type=SMTP" onclick="user.exit()">SMTP</a>
                </li>
                <li >
                    <a href="LogMgr.php?type=POP3" onclick="user.exit()">POP3</a>
                </li>
                <li>
                    <a href="LogMgr.php?type=SERVER" onclick="user.exit()">系统日志</a>
                </li>
        <?php }?>
    </ol>
    <br>
    <table width="100%" border="1" align="center">
        <tr>
            <td width="10%">登陆ip</td><td width="15%">事件状态</td><td width="10%">操作用户</td>
            <td width="10%">事件类型</td><td width="25%">事件内容</td><td width="20%">操作时间</td>
            <td width="10%" colspan="2">操作</td>
        </tr>
        <?php for($i = $start; $i < $end; $i++){  ?>
        <tr>
            <td><?php echo getIp($log_list[$i][2]); ?></td>
            <td><?php echo $state = getState($log_list[$i][5], $detail[$i % \src\Config::$PAGENUM]); ?></td>
            <td><?php echo $log_list[$i][6]; ?></td>
            <td><?php echo $log_list[$i][3]; ?></td>
            <td><?php echo getContent($log_list[$i][4], $detail[$i % \src\Config::$PAGENUM]); ?></td>
            <td><?php echo $log_list[$i][1]; ?></td>
            <td align="center">
                <a href="./LogMgr.php?detail=<?php echo json_encode($detail);?>&i=<?php echo $i % \src\Config::$PAGENUM; ?>&page=<?php echo $start ?>&type=<?php echo $type;?>">详情</a>
            </td>
            <td align="center">
                <a href="./LogMgr.php?delete=<?php echo $log_list[$i][0] ?>&page=<?php echo $start ?>&type=<?php echo $type;?>">删除</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <div>
        第<?php $page_num = ceil($log_num / \src\Config::$PAGENUM); echo min($page_num, $start / \src\Config::$PAGENUM + 1); ?>页/共<?php echo $page_num;?>页
        <a href="LogMgr.php?start=<?php echo $start - \src\Config::$PAGENUM ?>&type=<?php echo $type;?>" >上一页</a>
        <a href="LogMgr.php?start=<?php echo $start + \src\Config::$PAGENUM ?>&type=<?php echo $type;?>">下一页</a>
    </div>


</body>
<?php
function getIp($ip){
    $ip = explode('\'', $ip);
    return $ip[1];
}

function getState($state, $detail){
    $state = $ip = explode(' : ', $state);
    if($detail == 1 && count($state) > 1){
        $res = $state[0] . "<br>" . $state[1];
    }else{
        $res = $state[0];
    }
    return $res;
}

function getContent($data, $detail){
    $cont = "";
    $data = explode('\'', $data);
    if($detail != 1){
        $cont = $cont .= $data[1] . " : " . $data[3];
    }else{
        for($i = 1 ; $i < count($data) ; $i += 4){
            $cont .= $data[$i] . " : " . $data[$i + 2] . "<br>";
        }
    }
    return $cont;
}
?>


