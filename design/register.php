<?php
/**
 * 注册树模式
 * 说明：将注册的对象存储在类的静态变量里，可以随时获取，感觉有点像服务定位，
 * Yii的服务定位还实现了按需分配；
 * 优点：可以统一获取管理注册后的对象，方便获取与删除，当然单例也可以放入注册树
 */
class Register
{
    protected static $objects; #存储已经注册过的对象；
    protected static $definations; #这里只是提示，Yii中存储的类的定义以及依赖关系，并且实现了按需分配

    /**
     * 获取已经注册过的对象
     * @param  string $alias 对应对象的键
     * @return 返回具体的对象
     */
    public static function get($alias)
    {
        return self::$objects[$alias];
    }

    /**
     * 获取已经注册过的对象
     * @param  string $alias 对应对象的键
     * @return 返回具体的对象
     */
    public static function set($alias, $obj)
    {
        return self::$objects[$alias];
    }
}


