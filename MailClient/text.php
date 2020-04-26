<?php

namespace src\MailServer;

use src\Config;

require_once "../MailServer/UserClient.php";
require_once "../Config.php";

//测试函数
function try1(){
    while(!feof(STDIN)){
        $client = new UserClient();
        print "请输入操作：1-写信   2-收信件   3-连接用户服务器   0-exit\n";
        $line = fread(STDIN, 1024);
        $line = str_replace(array("\r\n", "\r", "\n"), "", $line);

        if($line == 0){
            break;
        }
        else if($line == 1 || $line == 2 || $line == 3){
            $client->bind($line);
        }

        print "\n连接对象：1-MailServer   2-UserServer\n";
        $line = fread(STDIN, 1024);
        $line = str_replace(array("\r\n", "\r", "\n"), "", $line);
        if($line == 2){

            print "请输入用户名：\n";
            $line = fread(STDIN, 1024);
            $line = str_replace(array("\r\n", "\r", "\n"), "", $line);
            //链接UserServer的socket(本机ip)
            $client->connect($line, Config::$HOSTIP);
        }else{
            //链接MailServer的socket
            $client->connect("register", Config::$HOSTIP);
        }

        //执行指令操作
        while (!feof(STDIN)) {
            print "\n操作指令：QUIT-退出\n";
            $line = fread(STDIN, 1024);
            $line = str_replace(array("\r\n", "\r", "\n"), "", $line);

//                $this->execute("register register 123");
//                $this->execute("login wjy 123");
//                $this->execute("logout wjy 123");//失败
//                $this->execute("QUIT");
            if($line == "QUIT"){
                $client->execute("QUIT");
                break;
            }
            $client->execute($line);
        }

    }
}

function try2(){
    $client = new UserClient();
    $client->bind(3);
    $client->connect("register", Config::$HOSTIP);
    $client->execute("login wjy 123");
    $client->execute("QUIT");

    $client = new UserClient();
    $client->bind(1);
    $client->connect("wjy", Config::$HOSTIP);
    $client->execute("HELO");
    $client->execute("AUTH LOGIN");
    $client->execute("d2p5");
    $client->execute("MTIz");
    $client->execute("MAIL FROM: wjy@123.com");
    $client->execute("RCPT TO: kaia@123.com");
    $client->execute("SUBJECT: hava a try!");
    $client->execute("DATA");
    $client->execute("试一下time wait!");
}



try1();
