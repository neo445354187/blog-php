<?php
/**
 * ArrayAccess：像数组一样取对象的数据；
 * 要求：必须继承SPL标准库中的ArrayAccess接口，并实现下面4个方法
 * boolean offsetExists($index)
 * mixed offsetGet($index)
 * void offsetSet($index, $newvalue)
 * void offsetUnset($index)
 */
class Configuration implements ArrayAccess
{

    private static $config;     //单例
    private $configarray;

    private function __construct()
    {
        // init
        $this->configarray = array("Binzy" => "Male", "Jasmin" => "Female");
    }

    /**
    * 实现单例
    */
    public static function instance()
    {
        if (self::$config == null) {
            self::$config = new Configuration();
        }
        return self::$config;
    }

    //检查一个偏移位置是否存在(必须实现)
    public function offsetExists($index)
    {
        return isset($this->configarray[$index]);
    }

    //获取一个偏移位置的值(必须实现)
    public function offsetGet($index)
    {
        return $this->configarray[$index];
    }

    //设置一个偏移位置的值(必须实现)
    public function offsetSet($index, $newvalue)
    {
        $this->configarray[$index] = $newvalue;
    }

    //复位一个偏移位置的值(必须实现)
    public function offsetUnset($index)
    {
        unset($this->configarray[$index]);
    }

}

$config = Configuration::instance();
print_r($config);
echo "<br/>";
echo $config['Binzy'];
echo "<br/>";
$config['Binzy'] = '1222';
echo $config['Binzy'];
