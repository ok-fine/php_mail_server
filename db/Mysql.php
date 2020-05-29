<?php

namespace src;

use mysqli;

require_once "../Config.php";

class Mysql
{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    public function __construct()
    {
        $this->servername = Config::$SERVERNAME;
        $this->username = Config::$USERNAME;
        $this->password = Config::$PASSWORD;
        $this->dbname = Config::$DBNAME;
    }

    private function Connect()
    {
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $conn->set_charset('utf8');
//        $conn->autocommit(false);//设置为非自动提交 - 事务处理

        // 检测连接
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        } else {
//            print "连接成功";
        }
        return $conn;
    }

    //type - 1:Query   2:Insert    3:Update
    public function commit($sql, $type){
        $db = $this->Connect();
        $db->autocommit(false);
        $result = array();

        for($i = 0; $i < count($sql); $i++){
            $res = "";
            switch ($type[$i]){
                case 1:
                    $res = $this->Query($sql[$i]);
                    break;
                case 2:
                    $res = $this->Insert($sql[$i]);
                    break;
                case 3:
                    $res = $this->Updata($sql[$i]);
                    break;
            }
            if($res){
                array_push($result, $res);
            }
        }

        if(count($result) == count($sql)){
            $db->commit();
            print "submit";
        }else{
            $db->rollback(); //有任何错误发生，回滚并取消执行结果
            print "rollback";
        }

        $db->autocommit(true);
        $db->close();

        return $result;
    }

    public function Query($sql)//查询
    {
        //造一个连接对象，参数是上面的那四个
        $db = $this->Connect();
        $result = $db->query($sql);
//        print "Query Error: " . $db->error . "\n";
        $db->close();

        //因为初始化需要有参数，所以得到的数据数组下标从1开始
        $res = array();
//        if ($type == "1") {
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            array_push($res, array());
            foreach ($row as $data) {
                array_push($res[$i], $data);
            }
            $i++;
        }

        return $res;
//            return $res->fetch_all();//查询语句，返回数组.执行sql的返回方式是all，也可以换成row

    }

    public function Insert($sql)
    {
        //造一个连接对象，参数是上面的那四个
        $db = $this->Connect();
        $res = $db->query($sql);

        if ($res === true) {
            $db->close();
//            print "新记录添加成功!";
            return true;
        } else {
            print "mysql error:" . $db->error . "\n";
            $db->close();
            return false;
//            die("新记录添加失败，错误信息:" . $db->error);
//            $db->close();
//            return false;
        }
    }

    //修改和删除使用
    public function Updata($sql)
    {
        $db = $this->Connect();
        $res = $db->query($sql);

        if ($res === true) {
            $db->close();
//            print "数据更新成功!";
            return true;
        } else {
            die("数据更新失败，错误信息:" . $db->error . '<br>' . $sql);
//            $db->close();
//            return false;
        }
    }

}

//$db = new Mysql();
//$sql = array(
//        "INSERT INTO log(time, ip, op, content) VALUES(1, 1, 1, 1)",
//        "INSERT INTO log(time, ip, op, content) VALUES(2, 2, 2, 2)",
//        "INSERT INTO log(time, ip, op, content) VALUES(3, 3, 3, 4)",
//        "UPDATE log SET content = 3 WHERE ip = 3",
//        "SELECT from FROM log"
//);
//$type = array(2, 2, 2, 3, 1);
//$res = $db->commit($sql, $type);
//print $res[4][1][1] . ' ' . $res[0] . '<br>';

//$db = new Mysql();
//$mail_name = 'wjy';
//$res = $db->Query("SELECT mail_pwd FROM mail_user WHERE mail_name = \"$mail_name\"");
//echo count($res);

