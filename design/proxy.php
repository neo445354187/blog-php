<?php
/**
 * 代理模式
 * 说明：在客户端与实体之间建立一个代理对象(proxy)，客户端对实体进行操作全部委派给代理
 * 对象，隐藏实体的具体实现细节。
 * Proxy还可以与业务代码分离，部署到另外的服务器。业务代码中通过PRC来委派任务。
 * 其实就是做了一层简单的封装；
 */

/**
 * 规范
 */
interface IUserProxy
{
    public function getUserName($id);
    public function setUserName($id, $name);
}

/**
 * 实际操作
 */
class Proxy implements IUserProxy
{
    public function getUserName($id)
    {
        $db = Factory::getDatabase('slave');
        $db->query("select name from user where id = $id limit 1");
    }

    public function setUserName($id, $name)
    {
        $db = Factory::getDatabase('master');
        $db->query("update user set name = $name where id = 1 limit 1");
    }
}

$proxy = new Proxy;
$proxy->getUserName('1');
$proxy->setUserName('1', 'neo');
