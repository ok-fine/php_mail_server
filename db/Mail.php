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
        $sql = "SELECT email_id, mail_from, subject, time, id_read FROM email WHERE to = \"$mail_addr\" ORDER BY time DESC ";
        return $db->Query($sql);
    }

    //获取邮件详情
    static public function getMail($email_id){
        $db = new Mysql();
        $sql = "SELECT * FROM email WHERE to = \"$email_id\"";
        return $db->Query($sql);
    }

    //删除邮件
    static public function deleteMail($email_id){
        $db = new Mysql();
        $sql = "DELETE FROM email WHERE email_id = \"$email_id\"";
        return $db->Updata($sql);
    }

    //获取所有邮件
    static public function getAllMails($mail_name){
        $mail_addr = $mail_name . Config::$DOMAIN;
        $db = new Mysql();
        $sql = "SELECT mail_from, subject, body, time FROM email WHERE mail_to = \"$mail_addr\"";
        return $db->Query($sql);
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

}