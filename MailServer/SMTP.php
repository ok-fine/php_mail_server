<?php

use src\MailServer\UserClient;
use src\Config;
require_once "../MailServer/UserClient.php";

require_once "../db/Mail.php";
require_once "../db/Log.php";
require_once "../db/MailUser.php";
require_once "../db/Mysql.php";

require_once "../Config.php";

class SMTP
{
    /*
     * mail服务器格式：
     * c: HELO
     * c: AUTH LOGIN
     * s: dXNlcm5hbWU9
     * c: d2p5 --wjy
     * c: UGFzc3dvcmQ9
     * c: MTIz --123
     * c: MAIL FROM: wjy@123.com
     * c: RCPT TO: kaia@123.com
     * c: SUBJECT: hava a try!
     * c: DATA
     * s: Enter mail...
     * c: body
     */

    static public function send_mail($mail_name, $mail_pwd, $send_to, $subject, $body){
        $client = new UserClient();
        $client->bind(1);
        $client->connect($mail_name, Config::$HOSTIP);

        $client->execute("HELO");
        $client->execute("AUTH LOGIN");
        $client->execute(base64_encode($mail_name));
        $client->execute(base64_encode($mail_pwd));
        $client->execute("MAIL FROM: " . $mail_name . Config::$DOMAIN);
        $client->execute("RCPT TO: " . $send_to);
        $client->execute("SUBJECT: " . $subject);
        $client->execute("DATA");
        $res = $client->execute($body);
        $client->execute("QUIT");

        return $res;
    }

    //UserClient - UserServer
    //保持client_socket监听状态，服务器us与客户端(输入设备)的会话
    static public function uc2us($client_socket, $client_address, $port){
        $welcome_state = 0;   //欢迎状态              -- HELO
        $login_state = 0;     //记录用户认证状态       -- AUTH LOGIN
        $source_state = 0;    //记录是否填写邮件发送发
        $des_state = 0;       //记录是否填写邮件接收方
        $subject_state = 0;   //记录是否填写邮件主题
        $mail_source = "";    //记录信的来源
        $mail_des = "";       //记录信的去处(可群发)
        $mail_subject = "";   //记录邮件主题

        $user_name = "";      //记录用户名字，在日志中

        while(true){
            $request = socket_read($client_socket, 1024);
            print "request: " . $request . "\n";

            //并不知道为什么要切割一下。。。。
            if(strpos($request, ']')){
                $request = substr($request, strpos($request, "]") + 1);
            }
            $sstr = explode(" ", $request);


            print "login_state" . $login_state . "\n";
            print "command[0]: " . $sstr[0] . "\n";

            //注意下标越界
            if($sstr[0] == "HELO"){
                $response = "250-smtp." . substr(\src\Config::$DOMAIN, 1) . "\n" .
                    "250-PIPELINING\n" .
                    "250-STARTTLS\n" .
                    "250-AUTH LOGIN PLAIN\n" .
                    "250-AUTH=LOGIN\n" .
                    "250-MAILCOMPRESS\n" .
                    "250 8BITMIME";
                $welcome_state = 1;
                socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);
            }
            else if(count($sstr) == 2 && ($sstr[0] . $sstr[1]) == "AUTHLOGIN" && $welcome_state == 1){
                //base-64编码：

                //用户名认证
                $response = base64_encode("username=");
                socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);

                $recv_data = socket_read($client_socket, 1024);
                $username = base64_decode($recv_data);
                print "username: " . $username . "\n";

                //用户密码认证
                $response = base64_encode("Password=");
                socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);

                $recv_data = socket_read($client_socket, 1024);
                $password = base64_decode($recv_data);
                print "password: " . $password . "\n";

                //日志内容
                $data = array(
                    'User' => $username,
                    'Password' => $password
                );

                //用户名密码数据库验证
                if(\src\MailUser::login($username, $password)){
                    $response = "235 auth successfully";  //认证成功
                    $user_name = $username;
                    $login_state = 1;

                    \src\Log::create($client_address, $port,"SMTP auth", json_encode($data) , "Successful", $user_name, "SMTP");

                }else{
                    $response = "535 Error : auth failed";  //认证失败

                    \src\Log::create($client_address, $port,"SMTP auth", json_encode($data) , "Failed : password error", $user_name, "SMTP");
                }

                socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);

            }
            else if(count($sstr) == 3 && ($sstr[0] . $sstr[1]) == "MAILFROM:" && $login_state == 1){
                $mail_source = $sstr[2];
                $source_state = 1;
                $response = "250 ok";
                socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);
            }
            //RCPT TO: 地址1 地址2...   (空格分开多人地址)
            //mail_des存放格式，string - 地址1 地址2...   (空格分开多人地址)
            else if(count($sstr) >= 3 && ($sstr[0] . $sstr[1]) == "RCPTTO:" && $login_state == 1){
                $mail_des = $sstr[2];
                for($i = 3; $i < count($sstr); $i++){
                    $mail_des .= " " .  $sstr[$i];
                }
                $des_state = 1;
                $response = "250 ok";
                socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);
            }
            else if($sstr[0] == "SUBJECT:" && $login_state == 1){
                $mail_subject = $sstr[1];
                for($i = 2; $i < count($sstr) ; $i++){
                    $mail_subject .= " ";
                    $mail_subject .= $sstr[$i];
                }

                print "mail subject: " . $mail_subject . "\n";

                $subject_state = 1;
                $response = "250 ok";
                socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);
            }
            //请求发送邮件
            else if($sstr[0] == "DATA" && count($sstr) == 1 && $des_state == 1 && $source_state == 1 && $subject_state == 1){
                $response = "Enter mail, end with . on a line by itself";
                //S: "Enter mail, end with "." on a line by itself"
                //C: this is my mail body.
                //C: .
                socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);

                $recv_data = socket_read($client_socket, 2048);
//                $mail_body = mb_convert_case($recv_data, "utf-8");
                $mail_body = $recv_data;
                print "body: ";
                var_dump($mail_body);

                $mail = json_encode(array(
                    'from' => $mail_source,
                    'to' => $mail_des,
                    'subject' => $mail_subject,
                    'body' => $mail_body
                ));

                $response = "get the letter";
                socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);
                $res = self::us_mail_send($mail, $client_address, $port, $user_name);

                if($res){
                    $response = "250 Message sent";
                }else{
                    $response = "Error : fail to sent";
                }
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
        }

        socket_close($client_socket);
    }


    //UserServer将从客户端（client_address，port）处读到的邮件发送到另一个us服务器
    static  public function us_mail_send($mail, $client_address, $port, $user_name){
        print "mail: ";
        var_dump($mail);


        $mail_array = json_decode($mail, true);       //用于群发
        $mail_log = json_decode($mail, true); //用于日志记录

        //日志部分需要去掉body
        array_pop($mail_log);

        $hostip = \src\Config::$HOSTIP;
        $clientip = gethostbyname(gethostname());

        //开始投递邮件
        \src\Log::create($client_address, $port,"start deliver", json_encode($mail_log), "Mail Delivering...", $user_name, "SMTP");

        //有多少个人成功
        $succ = 0;
        //群fa：
        $mail_des = explode(" ", $mail_array['to']);
        for($i = 0; $i < count($mail_des); $i++){
            print "mail to: " . $mail_des[$i] . "\n";
            $mail__log['to'] = $mail_array['to'] = $mail_des[$i];

            $client_socket = socket_create(AF_INET, SOCK_STREAM, 0);

            $flag = 0;
            while($flag != 1){
                $ucport = mt_rand(50000, 59999);
                if(socket_bind($client_socket, $clientip , $ucport)){
                    $flag = 1;
                }else{
                    print "端口号被占用\n";
                    $flag = 0;
                }
            }

            $usport = \src\MailUser::getPort($mail_array['to']); //另一个邮件的端口号
            print "send to host and Port: '" . $hostip . "' ". $usport . "\n";

            $flagi = 0;
            $num = 0;//当尝试链接目标服务器失败后，自动保存到邮箱中，
            //这个问题还没有解决：只能发送给登陆好的用户，发送后，用户再登陆，是没法就收的
            while ($flagi != 1){
                try{
                    $num++;
                    if($num >= 2){
                        $flagi = 1 ;
                    }else{
                        if(socket_connect($client_socket, $hostip, $usport)){
                            $flagi = 1;
                        }else{
                            print "目的服务器程序('" . $hostip . "' " . $usport . ")未启动\n";
                            time_sleep_until(time() + 120); //1800每半小时发一次
                        }
                    }
                }catch (Error $e){
                    throw $e;
                }
            }


            if($num >= 2){
//                //直接保存
//                \src\Mail::saveMail(json_encode($mail_array));

                //直接抛弃
                continue;
            }else{
                socket_send($client_socket, json_encode($mail_array), strlen(json_encode($mail_array)), MSG_DONTROUTE);
                $result = socket_read($client_socket, 1024);
                socket_close($client_socket);

                echo "send result: " . $result . "\n";

                $result = explode(" ", $result);
                var_dump($result);
                if($result[1] == "Error"){
                    continue;
                }
            }

            echo "succnum：" . $succ . "\n";
            $succ++;

            //投递邮件
            \src\Log::create($client_address, $port,"deliver mail", json_encode($mail_log), "Successful", $user_name, "SMTP");
        }
        echo "succnum：" . $succ . "\n";
        return $succ == count($mail_des);
    }

    //UserServer接收从服务器发来的邮件，并存储到邮箱，之后通过pop协议获取到客户端
    static public function us_mail_recv($client_socket){
        socket_getpeername($client_socket, $ip, $port);

        $mail = socket_read($client_socket, 1024); //json格式
        print "request mail: ";
        echo $mail . "\n";
        $mail = json_decode($mail, true);
        var_dump($mail);

        echo "username:" ;
        var_dump($mail['to']);
        echo "\n过滤地址:";
        var_dump($mail['from']);
        echo "\n过滤IP:";
        var_dump($ip);
        echo "\n";

        //过滤邮件地址和ip
        if(\src\Mail::filter_addr($mail['to'], $mail['from'], $ip )) {
            $response = "250 ok";
            socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);

            \src\Mail::saveMail(json_encode($mail));
        }else{
            $response = "501 Error : the mail has be intercepted!";
            socket_send($client_socket, $response, strlen($response), MSG_DONTROUTE);

            //拦截邮件的日志
            $mail_log = $mail;
            array_pop($mail_log);
            $user_name = substr($mail['to'],0, strripos($mail['to'], Config::$DOMAIN));
            \src\Log::create($ip, $port, "intercept mail", json_encode($mail_log), "Successful", $user_name, "SMTP");
        }
    }


}

//$mail = array(
//    "from" => "wjy@123.com",
//    "to" => "kaia@123.com"
//);
//$mail = json_encode($mail);
//var_dump($mail);
//echo "<br>";
//
//$mail = json_decode($mail, true);
//var_dump($mail);
//echo "<br>";


//$a = "12345]6789";
//$b = substr($a, strpos($a, "]") + 1);
////$b = $a[strpos($a, "]") + 1];
//print ($a . $b == "12345]67896789");

//$mail = array(
//    "from" => "123",
//    "to" => "456",
//    "subject" => "hahahah"
//);
////from->123,to->456,subject->hahahah

//$mail2 = array("12", "34", "56");
////0->12,1->34,2->56
//
//print array2string($mail);

//SMTP::try1($mail);

//$request = "RCPT TO: 123 32 323 123 4";
//if(strpos($request, ']')){
//    $request = substr($request, strpos($request, "]") + 1);
//}
//$data = substr($request, strpos($request, "]") + 1);
//$sstr = explode(" ", $request);
//var_dump($sstr);
//date_default_timezone_set('Asia/Shanghai');
//echo date("Y-m-d H:i:s", time());