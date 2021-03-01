<?php
/**
 * 数据对象映射模式
 * 说明：是将对象和数据存储映射起来，对一个对象的操作会映射为对数据存储的操作。
 * 应用：在代码中实现数据对象映射模式，我们将实现一个ORM类，将复杂的SQL语句映
 * 射成对象属性的操作；
 * 结合使用数据对象映射模式，工厂模式，注册模式(这里就是简单应用，暂时没写代码)
 */


/**
* 以User表为例，User表中有id、name、mobile、regtime四个字段
*/
class ClassName extends AnotherClass
{
    public $id;
    public $name;
    public $mobile;
    public $regtime;

    protected $db;

    function __construct($id)
    {
        $this->db = new MySQLi();
        $this->db->connect('127.0.0.1','root','root','test');
        $this->db->query("select * from user where id = {$id}");
        $data = $res->fetch_assoc();
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->mobile = $data['mobile'];
        $this->regtime = $data['regtime'];
    }


    function __destruct()
    {
        $this->db->query("update user set name = '{$this->name}',mobile = '{$this->mobile}',
            regtime = '{$this->regtime}' where id = '{$this->id}' limit 1");
    }
}
