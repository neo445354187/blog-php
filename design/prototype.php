<?php
/**
 * 原型模式
 * 说明：
 * 1、与工厂模式作用类似，都是用来创建对象。
 * 2、与工厂模式的实现不同，原型模式是先创建好一个原型对象，然后通过clone原型对象来创建
 *    新的对象。这样就免去了类创建时的重复初始化操作
 * 示例：原型模式适用于大对象的创建。创建一个大对象需要很大的开销，如果每次new就会消耗
 * 很大，原型模式仅需要内存拷贝即可(其实就是用关键字clone)
 */
class BigObject
{
    protected $data = 0;

    function __construct($data)
    {
//        echo "消耗大量资源";
        $this->data = $data;
    }

    public function getData()
    {
        echo $this->data."\n";
    }

    public function __clone()
    {
        $this->data = 0;
    }
}

$bigOne = new BigObject(1);    //创建大对象
$bigOne->getData();
$bigTwo = clone $bigOne;
$bigTwo->getData();
//结果：
// 消耗大量资源               #说明：clone关键字复制对象，不会再调用__construct()初始化
// 1
// 0                          #clone默认是将对象所有数据都复制，包括类属性值，如果不需要
                              #复制，则需要在__clone()魔术方法中定义；如例所示
