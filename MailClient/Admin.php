<?php


namespace src\MailServer;

require_once '../MailServer/UserClient.php';

class Admin
{

    static public function delete($admin_name, $mail_name){
        $client = new UserClient();
        $client->bind(3);

        $client->connect("register", \src\Config::$HOSTIP);

        $res = $client->execute("delete " . $mail_name . " " . $admin_name);
        $client->execute("QUIT");

        return $res;
    }


    static public function modify($mail_name, $mail_pwd, $send_power, $get_power, $mod_power, $admin_name){
        $client = new UserClient();
        $client->bind(3);

        $client->connect("register", \src\Config::$HOSTIP);

        $res = $client->execute("mod " . $mail_name . " " . $mail_pwd . " " . $send_power . " " . $get_power . " " . $mod_power . " " . $admin_name);
        $client->execute("QUIT");

        return $res;

    }

    static public function start_smtp($admin_name, $mail_name){
        $client = new UserClient();
        $client->bind(3);

        //链接MailServer的socket
        $client->connect($admin_name, \src\Config::$HOSTIP);

        $client->execute("start smtp " . $mail_name);
        $client->execute("QUIT");
    }

    static public function stop_smtp($admin_name, $mail_name){
        $client = new UserClient();
        $client->bind(3);

        //链接MailServer的socket
        $client->connect($admin_name, \src\Config::$HOSTIP);

        $client->execute("stop smtp " . $mail_name);
        $client->execute("QUIT");
    }

    static public function start_pop($admin_name, $mail_name){
        $client = new UserClient();
        $client->bind(3);

        //链接MailServer的socket
        $client->connect($admin_name, \src\Config::$HOSTIP);

        $client->execute("start pop " . $mail_name);
        $client->execute("QUIT");
    }

    static public function stop_pop($admin_name, $mail_name){
        $client = new UserClient();
        $client->bind(3);

        //链接MailServer的socket
        $client->connect($admin_name, \src\Config::$HOSTIP);

        $client->execute("stop pop " . $mail_name);
        $client->execute("QUIT");
    }



}