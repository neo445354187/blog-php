<?php

/**
 * 参考：<https://www.cnblogs.com/V1haoge/p/6484128.html>
 * 外观模式：用于请求与子系统，那么将各个子系统进行封装为一个大系统，大系统统一对接请求
 */
class Part01
{
    public function show()
    {
        echo "I am header\n\r";
    }
}

class Part02
{
    public function show()
    {
        echo "I am body\n\r";
    }
}

class Part03
{
    public function show()
    {
        echo "I am footer\n\r";
    }
}

class Human
{
    public function show()
    {
        (new Part01)->show();
        (new Part02)->show();
        (new Part03)->show();
    }
}

(new Human())->show();