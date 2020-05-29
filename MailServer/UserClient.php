<?php

namespace src\MailServer;

use src\MailUser;

require_once "../db/MailUser.php";


class UserClient
{
    var $ip;
    var $port;

    var $socket;

    public function __construct()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
        $this->port = -1;
        $this->ip = gethostbyname(gethostname());
        print "本机IP：" . $this->ip . "\n";
    }

    //type: 1-写信,SMTP    2-收信,POP
    public function bind($op){

        //是让套接字端口释放后立即就可以被再次使用，方便调试
        socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);

        if($op == 1){
            $flag = 0;
            while($flag != 1){

                $port = mt_rand(40000, 49999);
                if(socket_bind($this->socket, $this->ip ,$port)){
                    $flag = 1;
                }else{
                    $flag = 0;
                }
            }

        }else if($op == 2){
            $flag = 0;
            while($flag != 1){

                $port = mt_rand(30000, 39999);
                if(socket_bind($this->socket, $this->ip ,$port)){
                    $flag = 1;
                }else{
                    $flag = 0;
                }
            }

        }else if($op == 3){
            //用户的注册登陆
            $flag = 0;
            while($flag != 1){

                //暂时连接
                $port = mt_rand(50000, 59999);
                if(socket_bind($this->socket, $this->ip ,$port)){
                    $flag = 1;
                }else{
                    $flag = 0;
                }
            }

        }else{
            print "该操作不存在\n";
            return 0;
        }

//        print "bindIP：" . $this->ip . "\n";
    }

    public function connect($mail_name, $hostip){
        $this->port = MailUser::getPort($mail_name);

        if($this->port == -1){
            print "用户'" . $mail_name . "'不存在\n";
            return 0;
        }

        print "User Port:" . $this->port . "\n";

        print "Client connect \n";

        return socket_connect($this->socket, $hostip, $this->port);

    }

    public function execute($msg){

        socket_send($this->socket, $msg, strlen($msg), MSG_DONTROUTE);
        if($msg == "QUIT"){
            print "QUIT\n";
            socket_close($this->socket);

        }else{
            $callback = socket_read($this->socket, 1024);
//            print $callback . "\n";
            print "From Server: " .$callback . "\n";

            $error = explode(" ", $callback);

            if(count($error) >= 2 && ($error[0] == "Error" || $error[1] == "Error")){
                return false;
            }else{
                return $callback;
            }
        }

        return true;
    }

}
