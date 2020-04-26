<?php


class POP3
{
    //UserClient到us的pop服务
    static public function uc2us($clien_socket){
        $login_state = 0;   //记录用户登录状态
        $user_name = "";    //记录用户名
        $pass_word = "";    //记录密码

        $request = socket_read($clien_socket, 1024);
        print "request: " . $request . "\n";

        $sstr = explode(" ", $request);
        try {
            if($sstr[0] == "RecvLetters"){
                $user_name = $sstr[1];
                $mails = \src\Mail::getAllMails($user_name);  //mails(mail_from, subject, body, time)
                $response = json_encode($mails);
//                $response = \src\Mail::array2string($mails);
                socket_send($clien_socket, $response, strlen($response), MSG_DONTROUTE);
            }

        }catch (Error $e){
            $response = "letters get error!";
            socket_send($clien_socket, $response, strlen($response), MSG_DONTROUTE);
        }

        socket_close($clien_socket);

    }

}