<?php
namespace src\MailClient;

use src\MailServer\UserClient;

require_once "../MailServer/UserClient.php";

class User
{
    //hostip是需要链接的服务器的ip
    static public function register($mail_name, $mail_pwd){
        $client = new UserClient();
        $client->bind(3);

        //链接MailServer的socket
        $client->connect("register", \src\Config::$HOSTIP);


        $res = $client->execute("register " . $mail_name . " " . $mail_pwd);
        $client->execute("QUIT");

        return $res;


    }

    static public function login($mail_name, $mail_pwd){
        $client = new UserClient();
        $client->bind(3);

        //链接MailServer的socket
        $client->connect("register", \src\Config::$HOSTIP);

        $res = $client->execute("login " . $mail_name . " " . $mail_pwd);
        $client->execute("QUIT");

        return $res;
    }

    //修改密码
    static public function modify($mail_name, $mail_pwd){
        $client = new UserClient();
        $client->bind(3);

        //链接MailServer的socket
        $client->connect("register", \src\Config::$HOSTIP);

        $res = $client->execute("change password " . $mail_name . " " . $mail_pwd);
        $client->execute("QUIT");

        return $res;
    }



}

//User::register("kaia2", "123");
//User::login("kaia", "123");
