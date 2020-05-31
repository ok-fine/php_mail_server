<?php

/*
 * 执行邮件(email)的各类操作
 */


namespace src;

require_once "../Config.php";
require_once "Mysql.php";

class Mail
{

//    static public $DOMAIN = "@123.com";

    static private function bodyHandle($body){
        $body = explode("$$", $body);
        $cont = "";
        for($i = 0; $i < count($body); $i++){
            $cont .= $body[$i];
            $cont .= "\n";
        }
        return $cont;
    }

    //传过来的邮件为json格式，解析后存在数据库中
    static public function saveMail($mail){
        $db = new Mysql();

        $mail = json_decode($mail, true);

        $from = $mail['from'];
        $to = $mail['to'];
        $subject = $mail['subject'];
        $body = self::bodyHandle($mail['body']);
        //设置时区，不然时间会早8个小时
        date_default_timezone_set('Asia/Shanghai');
        $time = date('Y-m-d H:i:s', time()); // 2019-4-23 15:57:05;
        $size = strlen($mail['body']);

        $sql = "INSERT INTO email(mail_from, mail_to, subject, body, time, size) " .
            "VALUES (\"$from\", \"$to\", \"$subject\", \"$body\", \"$time\", \"$size\")";

        $db->Insert($sql);
    }

    //取出服务器中用户的收到的所有邮件
    //用户查看收件箱
    static public function listMail($mail_name){
        $mail_addr = $mail_name . Config::$DOMAIN;
        $db = new Mysql();
        $sql = "SELECT email_id, mail_from, subject, time, is_read, size FROM email WHERE mail_to = \"$mail_addr\" ORDER BY time DESC ";
        return $db->Query($sql);
    }

    //获取邮件详情
    //只要获取了，就相当于读了，需要标为已读
    static public function getMail($email_id){
        $db = new Mysql();
        $sql = array(
            "SELECT * FROM email WHERE email_id = \"$email_id\"",
            "UPDATE email SET is_read = '1' WHERE email_id = \"$email_id\""
        );
        $type = array(1, 3);
        $res = $db->commit($sql, $type);
        return $res[0][0];
    }

    //删除邮件
    static public function deleteMail($email_id){
        $db = new Mysql();
        $sql = "DELETE FROM email WHERE email_id = \"$email_id\"";
        return $db->Updata($sql);
    }

    //系统设置，即过滤设置
    static public function get_ac_filter($user_name){
        $db = new Mysql();
        $sql = "SELECT cont FROM ac_filter WHERE mail_name = \"$user_name\"";

        $res = $db->Query($sql);
        $result = array();
        for($i = 0 ; $i < count($res); $i++){
            array_push($result, $res[$i][0]);
        }

        return $result;
    }

    //系统设置，即过滤设置
    static public function get_ip_filter($user_name){
        $db = new Mysql();
        $sql = "SELECT cont FROM ip_filter WHERE mail_name = \"$user_name\"";

        $res = $db->Query($sql);
        $result = array();
        for($i = 0 ; $i < count($res); $i++){
            array_push($result, $res[$i][0]);
        }

        return $result;
    }

    //系统设置，即过滤设置
    static public function set_filter($user_name, $ac_list, $ip_list){
        $db = new Mysql();
        //注意：因为插入过的不能插入，
        $sql = array(
            "DELETE FROM ac_filter WHERE mail_name = \"$user_name\"",
            "DELETE FROM ip_filter WHERE mail_name = \"$user_name\"",
        );
        $type = array(3, 3);

        for($i = 0; $i < count($ac_list) ; $i++){
            array_push($sql, "INSERT INTO ac_filter VALUES (\"$user_name\", \"$ac_list[$i]\")");
            array_push($type, 2);
        }
        for($i = 0; $i < count($ip_list) ; $i++){
            array_push($sql, "INSERT INTO ip_filter VALUES (\"$user_name\", \"$ip_list[$i]\")");
            array_push($type, 2);
        }
        return $db->Commit($sql, $type);
    }

    static public function filter_addr($user_name, $ac, $ip){
        $user_name = substr($user_name,0, strripos($user_name, Config::$DOMAIN));

        $ac_list = self::get_ac_filter($user_name);
        $ip_list = self::get_ip_filter($user_name);
        if($ac_list == null) $ac_list = array();
        if($ip_list == null) $ip_list = array();

        var_dump($ac_list);
        var_dump($ip_list);

        $ac_all = "begin:";
        $ip_all = "begin:";
        for($i = 0 ; $i < count($ac_list) ; $i++){
            $ac_all .= $ac_list[$i];
        }

        for($i = 0 ; $i < count($ip_list) ; $i++){
            $ip_all .= $ip_list[$i];
        }

        echo "ac:" . $ac_all . "<br>";
        echo "ip:" . $ip_all . "<br>";

        echo strpos($ac_all, $ac);

        if(strpos($ac_all, $ac) || strpos($ip_all, $ip)){
            return false;
        }else{
            return true;
        }
    }

}
//
//if(Mail::filter_addr("kaia@123.com", "wjy@123.com", "1.1.1.1")){
//    echo "能发";
//}else{
//    echo "不能发";
//}
//
//echo "<br>" . strpos("wjy@123.com", "sss");

