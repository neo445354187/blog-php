<?php
/**
 * 参考：<https://www.cnblogs.com/V1haoge/p/6518603.html>
 * 参考：<https://www.cnblogs.com/not2/p/10844226.html>
 * 调停者模式：将各个类之间的互相调用耦合，转变为所有请求都向调停者请求
 *
 * 一般问题：系统内部经常会出现多个类互相耦合，形成网状结构。任意一个类发生改变，
 * 所有调用者也会受到影响，造成阅读和维护困难。
 * 引入调停者模式的意图是将一对多转化成一对一，降低整个系统的交互复杂度。
 *
 * 优点：集中控制交互，将一对多转化成一对一，降低了耦合度
 * 缺点：中介类会庞大，变得复杂难以维护
 * 总结：调停者模式是一种行为型设计模式，是对交互的封装。它的目的在于降低系统内部各组件之间的耦合，
 * 集中控制交互，所以它是内向闭合的，要与外观模式的外向公开特性区分。同时，中介类的内部设计要有条理，
 * 规范注释，避免随着系统需求不断升级而变得过于臃肿，难以维护。
 */
// 调停者接口
interface Mediator
{
    public function change(Staff $staff, $from, $msg);
}

class Manager implements Mediator
{
    public function change(Staff $staff, $from, $msg)
    {
        echo "manager receive from {$from}, msg is {$msg}\n\r";
        echo "manager forwards {$msg} to {$staff->name}\n\r";
        $staff->callByMediator($from, $msg);            // 控制反转了
    }
}

abstract class Staff
{
    public $name;
    private $mediator;

    public function __construct($mediator, $name)
    {
        $this->name = $name;
        $this->mediator = $mediator;
    }

    // 被调停者调用的方法，用于控制反转
    public function callByMediator($from, $msg)
    {
        echo "{$this->name} receive {$msg} from {$from}\n\r";
    }

    // 调用调停者
    public function callMediator($staff, $msg)
    {
        echo "{$this->name} call mediator to coordinate {$staff->name} {$msg}\n\r";
        $this->mediator->change($staff, $this->name, $msg);
    }
}

// 职员01
class Staff01 extends Staff
{
}

// 职员02
class Staff02 extends Staff
{
}

// 职员03
class Staff03 extends Staff
{
}

$mediator = new Manager();
$neo = new Staff01($mediator, "neo");
$lydia = new Staff02($mediator, "lydia");
$jordan = new Staff03($mediator, "jordan");
// neo给jordan发需求
$neo->callMediator($jordan, 'just do it');
$lydia->callMediator($neo, 'thanks!');