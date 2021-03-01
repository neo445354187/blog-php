<?php
/**
 * 迭代器模式
 * 说明：在不需要了解内部实现的前提下，遍历一个聚合对象的内部元素
 *      相对于传统的编程模式，迭代器模式可以隐藏遍历元素的所需的操作。
 * 思想：要实现迭代器，必须继承原生的Iterator接口，且实现rewind()、valid()、current()
 * next()、key()五个方法
 */
class AllUser implements \Iterator
{
    protected $data = array(); //存储要迭代的数据数组
    protected $index; //存储迭代当前位置下标

    function __construct()
    {
        $this->data = array(
            ["id"=>1,"name"=>"neo"],
            ["id"=>2,"name"=>"hehe"]
        );
    }

    /**
     * 迭代调用第一步 ：重置迭代器
     */
    public function rewind()
    {
        echo "one\n";
        $this->index = 0;
    }

    /**
     * 迭代调用第二步 ：验证是否还有下一个
     * @return boolean
     */
    public function valid()
    {
        echo "two\n";
        return $this->index < count($this->data);
    }

    /**
     * 迭代调用第三步 ：返回当前的元素
     */
    public function current()
    {
        echo "three\n";
        return $this->data[$this->index];
    }

    /**
     * 迭代调用第四步 ：返回当前元素的下标
     */
    public function key()
    {
        echo "four\n";
        return $this->index;
    }

    /**
     * 迭代调用第五步 ：返回下一个元素的下标，这一步是在foreach迭代一次后，执行的
     * 类似于步骤 123,next,23,23
     */
    public function next()
    {
        echo "five\n";
        $this->index ++;
    }
}

$users = new AllUser;
foreach ($users as $key => $value) {
    echo "\n";
}