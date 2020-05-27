<?php


namespace src;

require_once 'Mysql.php';

class Log
{
    //将日志写入文件
    static private function write($time, $ip, $op, $data, $state){
        $log = '【' . $time . '】' . "\n";
        $log .= "ScrIp: " . $ip . "\n";
        $log .= "Operate: " . $op . "\n";

        if($data[0] == '{'){
            $data_array = json_decode($data, true);
            foreach ($data_array as $key => $value){
                $log .= $key . ': ' . $value . "\n";
            }
        }else{
            $log .= $data . "\n";
        }

        $log .= $state . "\n";

        $myfile = fopen("../log.txt", "a");
        fwrite($myfile, $log);
        fclose($myfile);
    }

    //创建日志 - 数据库
    static public function create($ip, $port, $op, $data, $state){
        //设置时区，不然时间会早8个小时
        date_default_timezone_set('Asia/Shanghai');
        $time = date('Y-m-d H:i:s', time());
        $ip = "('" . $ip . "', " . $port . ")";

        self::write($time, $ip, $op, $data, $state);

        $db = new Mysql();
        $data = str_replace("\"", "'", $data);
        $sql = "INSERT INTO log(time, ip, op, data, state) VALUES (\"$time\", \"$ip\", \"$op\", \"$data\", \"$state\")";

        $db->Insert($sql);

    }

    //读取日志
    static public function get($user_name){
        $db = new Mysql();
        $data = str_replace("\"", "'", $data);
        $sql = "INSERT INTO log(time, ip, op, data, state) VALUES (\"$time\", \"$ip\", \"$op\", \"$data\", \"$state\")";

        $db->Insert($sql);

    }

}

//Log::write(date('Y-m-d h:i:s', time()), "123", "reg", "wjy", "successful");
