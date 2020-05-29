<?php


namespace src;

require_once 'Mysql.php';

class Log
{
    //处理html页面字符类型问题，兼容中文字符等
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //将日志写入文件
    static private function write($time, $ip, $op, $data, $state, $user_name){
        $log = '【' . $time . '】' . "\n";
        $log .= "ScrIp: " . $ip . "\n";
        $log .= "Operate: " . $op . "\n";
        $log .= "Operate User: " . $user_name . "\n";

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
    static public function create($ip, $port, $op, $data, $state, $user_name, $type){
        //设置时区，不然时间会早8个小时
        date_default_timezone_set('Asia/Shanghai');
        $time = date('Y-m-d H:i:s', time());
        $ip = "('" . $ip . "', " . $port . ")";

        //解决json_encode中文乱码问题
        $data = json_decode($data);
        $data = json_encode($data, JSON_UNESCAPED_UNICODE); //这样中文在json理就不会因为不转义而出现乱码问题了

        self::write($time, $ip, $op, $data, $state, $user_name);

        $db = new Mysql();
        $data = str_replace("\"", "'", $data);
        $sql = "INSERT INTO log(time, ip, op, data, state, op_user, type) VALUES (\"$time\", \"$ip\", \"$op\", \"$data\", \"$state\", \"$user_name\", \"$type\")";

        $db->Insert($sql);

    }

    //读取所有用户的日志
    static public function get_all($type){
        $db = new Mysql();
        $sql = "SELECT * FROM log ";
        if($type != "ALL"){
            $sql .= "WHERE type = \"$type\" ";
        }
        $sql .= "ORDER BY time DESC";
        return $db->Query($sql);
    }

    //读取日志
    static public function get($user_name, $type){
        $db = new Mysql();
        $sql = "SELECT * FROM log WHERE op_user = \"$user_name\" ";
        if($type != "ALL"){
            $sql .= "AND type = \"$type\" ";
        }
        $sql .= "ORDER BY time DESC";
        return $db->Query($sql);
    }

    static public function delete($log_id){
        $db = new Mysql();
        $sql = "DELETE FROM log WHERE log_id = \"$log_id\"";
        return $db->Updata($sql);
    }

}

//$ad = array(
//    '中文' => '中文',
//    '英文' => 'afasd',
//    '数字' => '1234');
//var_dump($ad);
//$ad = json_encode($ad, JSON_UNESCAPED_UNICODE);
//var_dump($ad);
//$ad = json_decode($ad);
//var_dump($ad);

//Log::write(date('Y-m-d h:i:s', time()), "123", "reg", "wjy", "successful");
