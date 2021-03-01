<?php

/**
 * 参考：<https://www.cnblogs.com/V1haoge/p/6497919.html>
 * 桥接模式：将多对多连接解耦代码，一般应用于连接数据库
 */
// 目的地接口
interface Brige
{
    public function arrive();
}

// 来源地接口
abstract class Source
{
    public $brige = null;

    public function __construct($dest)
    {
        $this->brige = $dest;
    }

    abstract public function from();
}

// 设置目的地01
class Dest01 implements Brige
{
    public function arrive()
    {
        echo("I want arrive to Dest01\n\r");
    }
}

// 设置目的地02
class Dest02 implements Brige
{
    public function arrive()
    {
        echo("I want arrive to Dest02\n\r");
    }
}

// 设置来源地01
class Sour01 extends Source
{
    public function from()
    {
        echo("I am from Sour01\n\r");
    }
}

// 设置来源地02
class Sour02 extends Source
{
    public function from()
    {
        echo("I am from Sour02\n\r");
    }
}

$source = new Sour01(new Dest02);// 由配置获取对应的类
$source->from();
$source->brige->arrive();
