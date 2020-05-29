<?php

/*
 * 处理邮件服务器中的用户
 */

namespace src;

use src\MailServer\MailServer;
use src\Mysql;

require_once 'Mysql.php';
require_once "../Config.php";

class MailUser
{
    var $mail_pwd;
    var $port;

    static public function register($mail_name, $mail_pwd, $port, $smtp_state, $pop_state, $is_admin){
        $mail_addr = $mail_name . Config::$DOMAIN;
        print "mail address: " . $mail_addr . "\n";

//        $mail_addr = $mail_name . "@123.com";

        $db = new Mysql();
        $sql1 = "SELECT COUNT(*) FROM mail_user WHERE mail_name = \"$mail_name\"";
        $sql2 =  "INSERT INTO mail_user(mail_name, mail_addr, mail_pwd, port, is_admin, smtp_state, pop_state) " .
            "VALUES (\"$mail_name\", \"$mail_addr\", \"$mail_pwd\", \"$port\", \"$is_admin\", \"$smtp_state\", \"$pop_state\")";

        $res = $db->Query($sql1);
//        print "user count: " . $res[0][0] . "\n";
        if($res[0][0] == 1){
            print "该用户已存在\n";
            return 0;
        }else{
            return $db->Insert($sql2);
        }
    }

    static public function login($mail_name, $mail_pwd){
        $db = new Mysql();
        $sql = "SELECT mail_pwd FROM mail_user WHERE mail_name = \"$mail_name\"";
        $pwd = $db->Query($sql);

        if(count($pwd[0]) == 1 && $pwd[0][0] == $mail_pwd){
            print $mail_name . "邮箱登陆成功\n";
            return 1;
        }else{
            print "登陆失败\n";
            return 0;
        }
    }

    //删除用户
    static public function delete($mail_name){
        $db = new Mysql();
        $sql = "DELETE FROM mail_user WHERE mail_name = \"$mail_name\"";

        if($db->Insert($sql)){
            print "用户删除成功\n";
            return 1;
        }else{
            print "删除失败\n";
            return 0;
        }
    }

    //修改账户密码
    static public function modify($mail_name, $new_pwd){
        $db = new Mysql();
        $sql = "UPDATE mail_user SET mail_pwd = \"$new_pwd\" WHERE mail_name = \"$mail_name\"";

        if($db->Updata($sql)){
            print "密码修改成功\n";
            return 1;
        }else{
            print "修改失败\n";
            return 0;
        }
    }

    //修改账户密码
    static public function mod_info($mail_name, $new_pwd, $smtp_state, $pop_state, $mod_power){
        $db = new Mysql();
        $sql = "UPDATE mail_user SET mail_pwd = \"$new_pwd\", smtp_state = \"$smtp_state\", pop_state = \"$pop_state\", mod_power = \"$mod_power\" WHERE mail_name = \"$mail_name\"";

        if($db->Updata($sql)){
            print "信息修改成功\n";
            return 1;
        }else{
            print "修改失败\n";
            return 0;
        }
    }

    //设置账户是否可以修改用户信息
    static public function is_mod($mail_name, $mode_power){
        $db = new Mysql();
        $sql = "UPDATE mail_user SET mode_power = \"$mode_power\" WHERE mail_name = \"$mail_name\"";

        if($db->Updata($sql)){
            print "密码修改成功\n";
            return 1;
        }else{
            print "修改失败\n";
            return 0;
        }
    }

    static public function getUsers(){
        $db = new Mysql();
        $sql = "SELECT mail_name FROM mail_user ORDER BY mail_name ASC ";
        $users = $db->Query($sql);
        return $users;
    }

    static public function getPass($mail_name){
        $db = new Mysql();
        $sql = "SELECT mail_pwd FROM mail_user WHERE mail_name = \"$mail_name\"";
        $pass = $db->Query($sql);
        return $pass;
    }

    //通过用户的邮箱号获得用户端口号
    static public function getPort($mail_addr){
        if(!strpos($mail_addr, Config::$DOMAIN)){
            $mail_addr .= Config::$DOMAIN;
        }

        $db = new Mysql();
        $sql = "SELECT port FROM mail_user WHERE mail_addr = \"$mail_addr\"";
        $res = $db->Query($sql);

        if($res){
            return $res[0][0];
        }else{
//            print "该用户不存在";
            return -1;
        }
    }

    //查询端口收(smtp)发(pop)邮件权限
    static public function getState($port){
        $db = new Mysql();
        $sql = "SELECT smtp_state, pop_state FROM mail_user WHERE port = \"$port\"";
        $res = $db->Query($sql);
        return $res[0];
    }


    //管理用户的收(smtp)发(pop)邮件权限
    static public function start_smtp($mail_name){
        $db = new Mysql();
        $sql = "UPDATE mail_user SET smtp_state = '1' WHERE mail_name = \"$mail_name\"";
        return $db->Updata($sql);
    }

    static public function stop_smtp($mail_name){
        $db = new Mysql();
        $sql = "UPDATE mail_user SET smtp_state = '0' WHERE mail_name = \"$mail_name\"";
        return $db->Updata($sql);
    }

    static public function start_pop($mail_name){
        $db = new Mysql();
        $sql = "UPDATE mail_user SET pop_state = '1' WHERE mail_name = \"$mail_name\"";
        return $db->Updata($sql);
    }

    static public function stop_pop($mail_name){
        $db = new Mysql();
        $sql = "UPDATE mail_user SET pop_state = '0' WHERE mail_name = \"$mail_name\"";
        return $db->Updata($sql);
    }


    //获取某个用户信息
    static public function get_user_info($mail_name){
        $db = new Mysql();
        $sql = "SELECT * FROM mail_user WHERE mail_name = \"$mail_name\"";
        $res = $db->Query($sql);

        $user_info['user_name'] = $res[0][0];
        $user_info['mail_addr'] = $res[0][1];
        $user_info['mail_pwd'] = $res[0][2];
        $user_info['port'] = $res[0][3];
        $user_info['send_power'] = $res[0][4];
        $user_info['get_power'] = $res[0][5];
        $user_info['is_admin'] = $res[0][6];
        $user_info['mod_power'] = $res[0][7];
        return $user_info;
    }


}

//
//$user_id = 1;
//$is_admin = 1;
//$mail_addr = "wjy@123.com";
//$mail_pwd = 123;
//$port = 50081;
//$smtp_state = 1;
//$pop_state = 1;
//MailUser::register($user_id, $is_admin, $mail_addr, $mail_pwd, $port, $smtp_state, $pop_state);
//
//MailUser::login($mail_addr, $mail_pwd);
//
//print MailUser::getPort($mail_addr);
//
//print MailUser::stop_pop($mail_addr);
//print MailUser::start_pop($mail_addr);
