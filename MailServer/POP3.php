<?php

use src\MailServer\UserClient;
use src\Config;
require_once "../MailServer/UserClient.php";

require_once "../db/Mail.php";
require_once "../db/Log.php";
require_once "../db/MailUser.php";
require_once "../db/Mysql.php";

require_once "../Config.php";

/*
 * mail服务器格式：
 * USER username 认证用户名
 * PASS password 认证密码认证，认证通过则状态转换
 * STAT 处理请求 server 回送邮箱统计资料，如邮件数、 邮件总字节数
 * UIDL n 处理 server 返回用于该指定邮件的唯一标识， 如果没有指定，返回所有的。
 * LIST n 处理 server 返回指定邮件的大小等
 * RETR n 处理 server 返回邮件的全部文本
 * DELE n 处理 server 标记删除，QUIT 命令执行时才真正删除
 * RSET 处理撤消所有的 DELE 命令
 * TOP n,m 处理 返回 n 号邮件的前 m 行内容，m 必须是自然数
 * NOOP 处理 server 返回一个肯定的响应
 * QUIT 希望结束会话。如果 server 处于"处理" 状态，则现在进入"更新"状态，删除那些标记成删除的邮件。如果 server 处于"认可"状态，则结束会话时 server 不进入"更新"状态 。
 */

class POP3
{
    static public function mail_list($mail_name, $mail_pwd){
        $client = new UserClient();
        $client->bind(2);
        $client->connect($mail_name, Config::$HOSTIP);

        if($client->execute("USER " . base64_encode($mail_name))){
            $client->execute("PASS " . base64_encode($mail_pwd));
            $res = $client->execute("LIST");
            $client->execute("QUIT");

            return $res;
        }else{
            $client->execute("QUIT");

            return array();
        }
    }

    static public function mail_info($mail_name, $mail_pwd, $mail_id){
        $client = new UserClient();
        $client->bind(2);
        $client->connect($mail_name, Config::$HOSTIP);

        if($client->execute("USER " . base64_encode($mail_name))){
            $client->execute("PASS " . base64_encode($mail_pwd));
//            echo "id: " . $mail_id;
            $res = $client->execute("RETR ". $mail_id );
            $client->execute("QUIT");

            return $res;
        }else{
            $client->execute("QUIT");

            return 0;
        }
    }

    static public function mail_delete($mail_name, $mail_pwd, $mail_id){
        $client = new UserClient();
        $client->bind(2);
        $client->connect($mail_name, Config::$HOSTIP);

        if($client->execute("USER " . base64_encode($mail_name))){
            $client->execute("PASS " . base64_encode($mail_pwd));
            $res = $client->execute("DELE " . $mail_id);
            $client->execute("QUIT");

            return $res;
        }else{
            $client->execute("QUIT");

            return 0;
        }
    }

    //UserClient到us的pop服务
    //获取邮件列表
    static public function uc2us($client_socket, $client_address, $port){
        $login_state = 0;   //记录用户登录状态  0-认正状态 1-操作状态 2-更新状态
        $user_name = "";    //记录用户名
        $delete_list = array(); //记录QUIT时要删除的东西

        while(true){
            $request = socket_read($client_socket, 1024);
            print "request: " . $request . "\n";

            $sstr = explode(" ", $request);
            try {
                //登陆
                if(count($sstr) == 2 && $sstr[0] == "USER" && $login_state == 0){
                    //base-64编码:

                    //用户名认证
                    $temp_user = base64_decode($sstr[1]);
                    $res = \src\MailUser::getPass($temp_user);
                    if(count($res) == 0){
                        $response = "535 Error : sorry, no mailbox for frated here";  //用户不存在
                    }else{
                        $temp_pwd1 = $res[0][0];
                        $response = "+OK mrose is a real hoopy frood";
                        socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);

                        $recv_data = socket_read($client_socket, 1024);
                        $sstr = explode(" ", $recv_data);
                        if(count($sstr) == 2 && $sstr[0] == "PASS"){
                            $temp_pwd2 = base64_decode($sstr[1]);
                            print "password: " . $temp_pwd1 . " ". $temp_pwd2 . "\n";

                            //日志内容
                            $data = array(
                                'User' => $temp_user,
                                'Password' => $temp_pwd2
                            );

                            //验证密码正确性
                            if($temp_pwd1 == $temp_pwd2){
                                $response = "235 auth successfully";  //认证成功
                                $login_state = 1;
                                $user_name = $temp_user;

                                \src\Log::create($client_address, $port,"POP3 auth", json_encode($data), "Successful", $user_name, "POP3");

                            }else{
                                $response = "535 Error : auth failed";  //认证失败

                                \src\Log::create($client_address, $port,"POP3 auth", json_encode($data) , "Failed : password error", $user_name, "POP3");
                            }

                        }else {
                            $response = "Error : operate failed";  //认证失败
                        }
                    }

                    socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);
                }
                //获取邮件列表
                else if($login_state == 1 && $sstr[0] == "LIST"){
                    $mails = \src\Mail::listMail($user_name);  //mails(mail_from, subject, body, time)
                    $response = json_encode($mails);
                    print "response:" . $response . "\n";
                    socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);
                }
                //获取邮件详情
                else if($login_state == 1 && count($sstr) == 2 && $sstr[0] == "RETR"){
                    $mail_id = $sstr[1];
                    $mail_info =\src\Mail::getMail($mail_id);  //mails(mail_from, subject, body, time)
                    echo "mail_info:" . $mail_info[3] . "\n";
                    $response = json_encode($mail_info);
                    print "response:" . $response . "\n";
                    socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);

                    $mail = json_encode(array(
                        'from' => $mail_info[1],
                        'to' => $mail_info[2],
                        'subject' => $mail_info[3],
                        'body' => $mail_info[4]
                    ));

                    //查看邮件
                    \src\Log::create($client_address, $port,"check mail", $mail, "Successful", $user_name, "POP3");
                }
                //删除邮件
                else if($login_state == 1 && count($sstr) == 2 && $sstr[0] == "DELE"){
                    array_push($delete_list, $sstr[1]);
                    $response = "+OK message " . $sstr[1] . " deleted";
                    socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);
                }
                //撤销删除命令
                else if($login_state == 1 && $sstr[0] == "RSET"){
                    $delete_list = array();
                    $response = "+OK delete reset";
                    socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);
                }
                else if($sstr[0] == "QUIT"){
                    //关闭客户端连接,并删除delete_list

                    if($login_state == 1) {
                        $login_state = 2;  //更新状态
                    }

                    for($i = 0 ; $i < count($delete_list) ; $i++){
                        \src\Mail::deleteMail($delete_list[$i]);

                        $mail_info = \src\Mail::getMail($delete_list[$i]);
                        $mail = json_encode(array(
                            'from' => $mail_info[1],
                            'to' => $mail_info[2],
                            'subject' => $mail_info[3]
                        ));

                        //删除邮件日志
                        \src\Log::create($client_address, $port,"delete mail", $mail, "Successful", $user_name, "POP3");
                    }

                    break;
                }
                else{
                    $response = "501 Error : command not implemented";
                    socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);
                }

            }catch (Error $e){
                    $response = "letters get error!";
                    socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);
            }
        }

        socket_close($client_socket);

    }

}