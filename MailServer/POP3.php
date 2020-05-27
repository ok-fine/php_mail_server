<?php

use src\MailServer\UserClient;
use src\Config;
require_once "../MailServer/UserClient.php";

require_once "../db/Mail.php";
require_once "../db/Log.php";
require_once "../db/MailUser.php";
require_once "../db/Mysql.php";

require_once "../Config.php";

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
            $res = $client->execute("DELETE " . $mail_id);
            $client->execute("QUIT");

            return $res;
        }else{
            $client->execute("QUIT");

            return 0;
        }
    }

    //UserClient到us的pop服务
    //获取邮件列表
    static public function uc2us($client_socket){
        $login_state = 0;   //记录用户登录状态  0-认正状态 1-操作状态 2-更新状态
        $user_name = "";    //记录用户名
        $pass_word = "";    //记录密码

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

                            //验证密码正确性
                            if($temp_pwd1 == $temp_pwd2){
                                $response = "235 auth successfully";  //认证成功
                                $login_state = 1;
                                $user_name = $temp_user;
                                $pass_word = $temp_pwd2;

                            }else{
                                $response = "535 Error : auth failed";  //认证失败
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
                    $response = json_encode($mail_info);
                    print "response:" . $response . "\n";
                    socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);
                }
                //删除邮件
                else if($login_state == 1 && count($sstr) == 2 && $sstr[0] == "DELETE"){
                    $mail_id = $sstr[1];
                    \src\Mail::deleteMail($mail_id);
                    $response = "+OK message " . $mail_id . " deleted";
                    socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);

                }
                else if($sstr[0] == "QUIT"){
                    //关闭客户端连接
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