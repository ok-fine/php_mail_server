<?php

namespace src\MailServer;

use src\Config;
use src\MailUser;

require_once '../db/MailUser.php';
require_once "SMTP.php";
require_once "POP3.php";

require_once "../Config.php";

class UserServer
{
    var $host;
    var $port;

    private $socket;

    public function __construct()
    {
        set_time_limit(0);
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
        $this->port = -1;
//        $this->host = gethostbyname(gethostname());//设置为本机ip
//        print "本机ip：" . $this->host . "\n";
        $this->host = Config::$HOSTIP;
    }

    public function bind($port)
    {

//        //接收套接流的最大超时时间1秒，后面是微秒单位超时时间，设置为零，表示不管它
//        socket_set_option($this->socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 0));
//        //发送套接流的最大超时时间为6秒
//        socket_set_option($this->socket, SOL_SOCKET, SO_SNDTIMEO, array("sec" => 6, "usec" => 0));


        //是让套接字端口释放后立即就可以被再次使用，方便调试
        socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);

        if (($ret = socket_bind($this->socket, $this->host, $port)) < 0) { //绑定Socket到端口
            print "UserServer has bound on" . $port . "\n";
            print "socket_bind() 失败的原因是:" . socket_strerror($ret) . "\n";

            return 0;
        }else{
            $this->port = $port;
            print "UserServer bind on" . $this->port . "\n";
            return 1;
        }
    }


    public function start()
    {
        if (($ret = socket_listen($this->socket, 10)) < 0) { // 开始监听链接链接
            print "socket_listen() 失败的原因是:" . socket_strerror($ret) . "\n";
        }

        //让服务器无限获取client传来的信息，每个信息将会在accept的时候创建一个新的socket，
        while (true){
            print "Port: " . $this->port . "\n";

            $state = MailUser::getState($this->port);
            $smtp_state = $state[0];
            $pop_state = $state[1];
            print "Mail State: smtp-" . $smtp_state . "  pop-" . $pop_state . "\n";

            $client_socket = socket_accept($this->socket);

            //获得accept的客户端的ip地址和链接端口号；
            socket_getpeername($client_socket, $client_address, $port);
            print $client_address . "用户已连接. " . "port: " . $port . "\n";

//            //获得本服务器的ip地址
//            socket_getsockname($client_socket, $client_address1);
//            print "sockname:" . $client_address1 . "peername:" . $client_address ."  已连接.   " . "port: " . $port . "\n";


            if($port >= 50000 && $port <= 59999){
                //服务器连接，此时应该是处于登陆状态的时候
//                print "服务器连接\n";

                $server_process_pid = pcntl_fork();

                if($server_process_pid == -1){
//                    print "Error : fork defeat\n";

                }else if($server_process_pid == 0){
                    //返回子进程号
                    print "child process, PID : " . $server_process_pid . "\n";

                    \SMTP::us_mail_recv($client_socket);

                    //子进程处理结束后一定要退出
                    //否则再次fork是在子进程的基础上进行的fork
                    exit();

                }else{
                    //父进程会得到子进程号，所以这里是父进程执行的逻辑
                    print "father process\n";
//                    pcntl_wait($status); //等待子进程中断，防止子进程成为僵尸进程。
                    print "exit father process\n";

                }

            }else if($port >= 40000 && $port <= 49999){
                //客户端的SMTP链接，创建一个新的进程
                print "发邮件 SMTP\n";

                $server_process_pid = pcntl_fork();

                if($server_process_pid == -1){
                    print "Error : fork defeat\n";

                }else if($server_process_pid == 0){
                    //返回子进程号
                    print "child process, PID : " . $server_process_pid . "\n";

                    //客户端发送邮件给服务器
                    \SMTP::uc2us($client_socket, $client_address, $port);

                    //子进程处理结束后一定要退出
                    //否则再次fork是在子进程的基础上进行的fork
                    exit();

                }else{
                    //父进程会得到子进程号，所以这里是父进程执行的逻辑
                    print "father process\n";
//                    pcntl_wait($status); //等待子进程中断，防止子进程成为僵尸进程。
                    print "exit father process\n";

                }

            }else if($port >= 30000 && $port <= 39999){
                //客户端的POP链接，创建一个新的进程
                print "收邮件 POP3\n";

                $server_process_pid = pcntl_fork();

                if($server_process_pid == -1){
                    print "Error : fork defeat\n";

                }else if($server_process_pid == 0){
                    //返回子进程号
                    print "child process, PID : " . $server_process_pid . "\n";

                    \POP3::uc2us($client_socket, $client_address, $port);

                    //子进程处理结束后一定要退出
                    //否则再次fork是在子进程的基础上进行的fork
                    exit();

                }else{
                    //父进程会得到子进程号，所以这里是父进程执行的逻辑
                    print "father process\n";
//                    pcntl_wait($status); //等待子进程中断，防止子进程成为僵尸进程。
                    print "exit father process\n";

                }

            }else{
                $msg = "Error : Your service is stopped!\n";
                print $msg . "\n";
                socket_send($this->socket, $msg, strlen($msg), MSG_DONTROUTE);
            }

        }

        $this->close();
    }

    public function close(){
        print "User Server Closed!\n";
        socket_close($this->socket);
    }


}

//$server = new UserServer();
//$server->try1();