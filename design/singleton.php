<?php
/**
 * 单例模式
 * 说明：单例模式，是指在整个项目中只能有一个对象
 * 优点：避免资源浪费。
 */
class Singleton
{
    private $props = array(); #存储属性键值对
    private static $instance; #存储单例对象

    //这里是重点：构造函数私有化
    private function __construct()
    {}

    public static function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function setProperty($key, $val)
    {
        $this->props[$key] = $val;
    }

    public function getProperty($key)
    {
        return $this->props[$key];
    }
}

$pref = Singleton::getInstance();
$pref->setProperty("name", "matt");
// remove the reference，从这里可以看出方法通过return返回的值是与等号的变量建立的引用
// 即这里只是删除引用的变量而已，对引用并无影响
unset($pref);

$pref2 = Singleton::getInstance();
print $pref2->getProperty("name") . "\n"; // 值还在
