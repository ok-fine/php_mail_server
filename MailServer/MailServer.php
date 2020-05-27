<?php

namespace src\MailServer;

use src\Config;
use src\Log;
use src\MailClient\User;
use src\MailUser;

require_once "../db/Log.php";
require_once "../db/Mail.php";
require_once "UserServer.php";

require_once "../Config.php";


class MailServer
{

    var $host;
    var $port;

    var $socket;
    var $flag;

    public function __construct()
    {
        set_time_limit(0);
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
        $this->flag= -1;
        $this->host = Config::$HOSTIP;
    }


    public function bind($port){
        //是让套接字端口释放后立即就可以被再次使用，方便调试
        socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);

        if (($ret = socket_bind($this->socket, $this->host, $port)) < 0) { //绑定Socket到端口
            print "MailServer has bound on" . $port . "\n";
            print "socket_bind() 失败的原因是:" . socket_strerror(socket_last_error()) . "\n";
        }else{
            $this->port = $port;
            print "MailServer bind on" . $this->port . "\n";
        }
    }

    public function start(){
        socket_listen($this->socket, 128);
        while(true){
            $client_socket = socket_accept($this->socket);
            socket_getpeername($client_socket, $client_address, $port);
            echo "peername: " . $client_address . $port . "\n";

//            为客户端创建一个进程来调用client_handle()
            $client_process_pid = pcntl_fork();
//            print "get pid : " . posix_getpid() . "\n";
            if($client_process_pid == -1){
                print "Error : fork defeat\n";

            }else if($client_process_pid){
                //父进程会得到子进程号，所以这里是父进程执行的逻辑
                print "father process\n";

//                pcntl_wait($status); //等待子进程中断，防止子进程成为僵尸进程。

                print "exit father process\n";
            }else{
                //返回子进程号
                print "child process, PID : " . $client_process_pid . "\n";

                $this->client_handle($client_socket, $client_address, $port);

                //子进程处理结束后一定要退出
                //否则再次fork是在子进程的基础上进行的fork
                exit();
            }

        }
    }

    public function client_handle($client_socket, $client_address, $port){
        $user_server = new UserServer();

        while (true){
            $request = socket_read($client_socket, 1024);
//            $data = $request;
//            $data = mb_convert_decoding($request, "utf-8");

            if($request == "QUIT"){
                //quit之后userServer仍然处于运行状态
                break;
            }

            print "Request: " . $request . "\n";
            $msg = $this->command_del($request, $user_server, $client_address, $port);
            print "send to client msg: " . $msg . "\n";
            socket_send($client_socket, $msg, strlen($msg), MSG_DONTROUTE);

            if($this->flag == 1){
                $user_server->start();
            }

        }
        socket_close($client_socket);

    }

    //cmd:命令    user_server:UserServer类  client_address:用户ip地址
    private function command_del($cmd, UserServer $user_server, $client_address, $port){
        $command = explode(" ", $cmd);

        if($command[0] == "register" && count($command) == 3){

            $mail_name = $command[1];
            $mail_pwd = $command[2];

            $flag = 0;
            while($flag != 1){
                //为用户随机分配端口号
                $usport = mt_rand(50000, 59999);

                print "random client port: " . $usport . "\n";

                if($user_server->bind($usport) == 1){
                    $flag = 1;
                }else{
                    $flag = 0;
                }
            }

            $data = json_encode(array('User' => $mail_name, 'Password' => $mail_pwd));

            if(MailUser::register($mail_name, $mail_pwd, $port, '1', '1', '0')){
                Log::create($client_address, $port,"register", $data, "Successful");

                return "OK : register succeed!\nmailaddr = " . $mail_name . Config::$DOMAIN;
            }else{
                Log::create($client_address, $port, "register", $data, "Failed : user already exist");

                return "Error : register error!";
            }

        }else if($command[0] == "login" && count($command) == 3){

            $mail_name = $command[1];
            $mail_pwd = $command[2];

            $data = json_encode(array('User' => $mail_name, 'Password' => $mail_pwd));

            if(MailUser::login($mail_name, $mail_pwd)){
                $usport = MailUser::getPort($mail_name);

                $user_server->bind($usport);

                Log::create($client_address, $port, "login", $data, "Successful");

                //register表示还没有分配端口，不可以start，要login之后才可以start
                $this->flag = 1;

                return "OK : Login Success! Port: " . $usport;
//                return 1;
            }else{

                Log::create($client_address, $port, "login", $data, "Failed : password error");

                return "Error : password error";
//                return 0;
            }

        }else if($command[0] == "delete" && count($command) == 3){
            $mail_name = $command[1];
            $admin_name = $command[2];

            $data = json_encode(array(
                'Admin' => $admin_name,
                'Deleted User' => $mail_name
                ));

            if(MailUser::delete($mail_name)){
                Log::create($client_address, $port, "detele user", $data, "Successful");
                return "OK : delete user succeed!";
            }else{
                Log::create($client_address, $port, "detele user", $data, "Fail : fail to delete");
                return "Error : delete user error";
            }

        }else if(($command[0] . $command[1]) == "changepassword" && count($command) == 4){
            $mail_name = $command[2];
            $new_pwd  =$command[3];
            if(MailUser::modify($mail_name, $new_pwd)){
                return "OK : change password succeed!";
            }else{
                return "Error : fail to change password";
            }

        }else if($command[0]  == "mod" && count($command) == 6){
            $mail_name = $command[1];
            $new_pwd  = $command[2];
            $stmp_state = $command[3];
            $pop_state = $command[4];
            $mod_power = $command[5];

            $data = json_encode(array(
                'Admin' => "('" . $client_address . "' " . $port . ")",
                'Modified User' => $mail_name
            ));

            if(MailUser::mod_info($mail_name, $new_pwd, $stmp_state, $pop_state, $mod_power)){
                Log::create($client_address, $port, "manage user", $data, "Successful");
                return "OK : manage user succeed!";
            }else{
                Log::create($client_address, $port, "manage user", $data, "Fail : fail to modify");
                return "Error : fail to manage info";
            }

        }else if(($command[0] . $command[1]) == "startsmtp" && count($command) == 3){
            $mail_name = $command[2];
            if(MailUser::start_smtp($mail_name)){
                return "OK : smtp open succeed!";
            }else{
                return "Error : fail to open smtp";
            }

        }else if(($command[0] . $command[1]) == "stopsmtp" && count($command) == 3){
            $mail_name = $command[2];
            if(MailUser::stop_smtp($mail_name)){
                return "OK : smtp close succeed!";
            }else{
                return "Error : fail to close smtp";
            }

        }else if(($command[0] . $command[1]) == "startpop" && count($command) == 3){
            $mail_name = $command[2];
            if(MailUser::start_pop($mail_name)){
                return "OK : pop open succeed!";
            }else{
                return "Error : fail to open pop";
            }

        }else if(($command[0] . $command[1]) == "stoppop" && count($command) == 3){
            $mail_name = $command[2];
            if(MailUser::stop_pop($mail_name)){
                return "OK : pop close succeed!";
            }else{
                return "Error : fail to close pop";
            }

        }else{
            return "Error : command error";
//            return 0;
        }

    }

}

$socket = new MailServer();
$socket->bind(Config::$HOSTPORT);
$socket->start();

//$data = array('user' => "user", 'pwd' => "pwd"); // {"user":"user","pwd":"pwd"}
//$data = array('user', "user", 'pwd', "pwd");     //["user","user","pwd","pwd"]
//$a = json_encode($data);
//$b = json_decode($a, true);
//print $a;


