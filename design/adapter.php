<?php
/**
 * 适配器模式
 * 说明：适配器模式将截然不同的函数接口封装成统一个API
 * 优点：避免资源浪费。
 * 示例：php的数据库操作有mysql、mysqli、pdo 共3种，可以用数据库统一成一致。
 * 类似的场景还有cache适配器，将memcache、redis、file、apc等不同的缓存函数统一成
 * 一致的接口。
 */


/**
 * 接口统一规范，适配器模式主要体现在规范
 */
interface IDatabase{
    /**
     * 存储连接
     * @var $conn
     */
    protected $conn;

    function connect($host,$user,$passwd,$dbname);
    function query($sql);
    function close();
}

/**
 * MySQL连接
 */
/**
* 
*/
class MySQL implements IDatabase
{
    protected $conn;
    function connect($host,$user,$passwd,$dbname)
    {
        $conn = mysql_connect($host,$user,$passwd);
        mysql_select_db($dbname,$conn);
        $this->conn = $conn;
    }

    function query($sql)
    {
        $res = mysql_query($sql,$this->conn);
        return $res;
    }

    function close()
    {
        mysql_close($this->conn);
    }
}

/**
 * MySQLi连接
 */
/**
* 
*/
class MySQLi implements IDatabase
{
    protected $conn;
    function connect($host,$user,$passwd,$dbname)
    {
        $conn = mysqli_connect($host,$user,$passwd,$dbname);
        $this->conn = $conn;
    }

    function query($sql)
    {
        $res = mysqli_query($this->conn,$sql);
        return $res;
    }

    function close()
    {
        mysqli_close($this->conn);
    }
}

/**
 * PDO连接
 */
/**
* 
*/
class MyPDO implements IDatabase
{
    protected $conn;
    function connect($host,$user,$passwd,$dbname)
    {
        $conn = new PDO("mysql:host=$host;dbname=$dbname",$user,$passwd);
        $this->conn = $conn;
    }

    function query($sql)
    {
        return $this->conn->query($sql);
    }

    function close()
    {
        unset($this->conn);
    }
}

//使用
$db = new MySQL();//这里可以换成MySQLi()或者MyPDO()，这就是适配器
$db->connect('127.0.0.1','root','root','test');
$db->query('show databases');
$db->close();
