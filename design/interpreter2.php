<?php
/**
 * 编程语言总是用其他编程语言编写的。例如：PHP 就是 C 语言编写的。所以，换个思维去考虑，
 * 使用 PHP 能否开发其他类型编程语言的东西呢？
 * 答案是肯定的，smarty 模版引擎就是解释器模式的最好应用。
 * 其工作原理就是在静态的模版页面能够使用指定的标签语法完成各种比如：取值，条件判断，循环，
 * 函数等编程语言所具备的功能。
 * 主要是为了是实现业务和视图的分离 ，而视图又要使用一部分取值、判断和循环业务操作，所以产生了模版引擎。
 * 通过父类 Compile 编译类，可以实现各种语法，比如条件判断，循环，函数功能等。
 */
//header('Content-Type:text/html; charset=utf-8');

abstract class Compile
{
    abstract public function express($parse, $str);
}

//变量操作
class Variable extends Compile
{
    public function express($parse, $str)
    {
        $patten = '/{\$([\w]+)}/';
        if (preg_match($patten, $str)) {
            $str = preg_replace_callback($patten, function ($matches) use ($parse) {
                return $parse->vars[$matches[1]];
            }, $str);
        }
        return $str;
    }
}

// 解析类
class Parse
{
    private $vars = [];

    public function __get($_key)
    {
        return $this->$_key;
    }

    public function assign($var, $value)
    {
        $this->vars[$var] = $value;
    }

    public function display($str)
    {
        $variable = new Variable();
        $str = $variable->express($this, $str);
        return $str;
    }
}

$parse = new Parse();
$parse->assign('name', 'neo');
$parse->assign('age', 20);

$str = '

This is {$name}, {$age} year.

';

echo $parse->display($str);