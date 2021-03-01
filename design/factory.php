<?php

/**
 * 工厂模式
 * 说明：工厂模式顾名思义，就是批量生成对象
 * 优点：由统一方法生成对象，如果以后类需要改名，可以只修改一处就完成，而不需要整个项目修改；
 * 备注：这里只是实现简单的样例，实际中还需要考虑依赖注入的实现
 */

//批量产品类
class Product
{
    public function Say()
    {
        echo "I am a product!";
    }
}

//批量生成的工厂
class Factory
{

    public static function CreateObject($className)
    {
        //这里只是实例，真实项目$className中还需要命名空间，以及依赖注入配合
        return new $className;
    }
}

$product = Factory::CreateObject('Product');
$product->say();
