<?php
/**
 * 观察者模式
 * 说明：当一个对象状态发生改变时，依赖它的对象全部会收到通知(其实是执行所有观察者对象
 *      的一些方法,例如下例执行的是是update()方法)，并自动更新
 * 思想：将实例储存起来，然后批量调用他们的方法
 * 示例：一个事件发生后，要执行一连串的更新操作。传统的编程方式，就是在事件的代码
 * 之后直接加入处理逻辑。当更新的逻辑增多之后，代码会变得难以维护。这种方式是耦合
 * 的，侵入式的，增加新的逻辑需要修改事件主体代码
 * 观察者模式实现了低耦合，非侵入式的通知与更新机制
 *
 * 为啥叫观察者模式？
 * 事件发生，大家围观(执行相同动作)
 */

/**
* 事件发生者
*/
abstract class EventGenerator
{
    protected $observers = array();     //存储观察者对象

    function addObserver(Observer $observer){
        $this->observers[] = $observer;
    }

    function notify(){
        foreach ($this->observers as $observer) {
            $observer->update();
        }
    }
    
    abstract function trigger();
    
}

/**
* 事件
*/
class Event extends EventGenerator
{
    /**
    *事件触发
    */
    public function trigger()
    {
        echo "It happened\n";
        $this->notify();        #通知所有观察者
    }
}

/**
* 观察者，即被通知对象
*/
interface Observer{

    function update();
    
}


/**
* 观察者1
*/
class Observer1 implements Observer
{
    
    public function update()
    {
        echo "I am Observer1, I received the event message\n";
    }
}

/**
* 观察者2
*/
class Observer2 implements Observer
{
    
    public function update()
    {
        echo "I am Observer2, I received the event message\n";
    }
}

$event = new Event;
$event->addObserver(new Observer1);     //添加观察者
$event->addObserver(new Observer2);
$event->trigger();



