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
            "UPDATE email SET is_read = 1 WHERE email_id = \"$email_id\""
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

    //数组转字符串函数
    static public function array2string($array){
        $string = [];

        if($array && is_array($array)){
            foreach ($array as $key=> $value){
                $string[] = $key.'->'.$value;
            }
        }

        return implode(',',$string);
    }

    //系统设置，即过滤设置
    static public function get_filter($user_name){
        $db = new Mysql();
        $sql = array(
            "SELECT cont FROM ac_filter WHERE mail_name = \"$user_name\"",
            "SELECT cont FROM ip_filter WHERE mail_name = \"$user_name\""
        );
        $type = array(1, 1);
        return $db->commit($sql, $type);
    }

    //系统设置，即过滤设置
    static public function set_filter($user_name, $ac_list, $ip_list){
        $db = new Mysql();
        $sql = array();
        $type = array();
        for($i = 0; $i = count($ac_list) ; $i++){
            array_push($sql, "INSERT INTO ac_filter VALUES (\"$user_name\", \"$ac_list[$i]\")");
            array_push($type, 2);
        }
        for($i = 0; $i = count($ip_list) ; $i++){
            array_push($sql, "INSERT INTO ip_filter VALUES (\"$user_name\", \"$ip_list[$i]\")");
            array_push($type, 2);
        }
        return $db->Commit($sql, $type);
    }

    static public function del_all(){
        $db = new Mysql();
        $sql = "DELETE FROM ";

    }
    static public function del_filter($user_name, $cont, $table ){
        $db = new Mysql();
        $sql = "DELETE FROM \"$table\" WHERE mail_name = \"$user_name\" AND cont = \"$cont\"";
        return $db->Updata($sql);
    }

}


