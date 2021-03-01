<?php
/**
*概念：
* 访问者模式实际上是让外部类能够获取树形结构的每个节点的对象，对每个对象进行操作的模式，
* 他能让我们在不改动原有树形结构的基础上扩展功能。比如统计等等
*
*在这种模式下，必须有的几个要素：
*1： 具体的元素对象， 访问者实际要访问的位置（即节点）
*2： 稳定的树形结构， 每个节点都是一个元素对象， 一般在组合模式下比较多， 他提供了让访问者能够进行访问的实际位置（即访问者访问的是具体的树形结构的某个节点的实例化对象）：
*3： 访问者接口，这里定义了访问者的接口方法 ， 这是个在每个节点都会用到的方法，用以节点处引用访问者，从而使得访问者能够访问当前节点
*4： 访问者的具体实现. 继承了访问者接口，以实现接口方法
*（还可以加一个要素： 元素的接口,对应 要点1）
*
* 访问者与观察者的异同：
* 同：都是反向调用对象（访问者或观察者对象）方法
* 异：
*     访问者模式，反向调用(参数是对象)储存对象的同一方法名，方法内容不同，如方法里再调用不同积分方法
*     观察者模式，反向调用(参数是对象)储存对象的同一个方法名，方法内容基本相同，如update()；
* 用途：要给不同用户组的用户添加不同的积分。
*/
//定义元素接口
abstract class User
{
    public function getPoint()
    {
        return rand(); //该数据应该由数据库中读取，这里就直接模拟某个值了
    }

    //这里的accept方法用于把访问者引入，在这个方法里，($visitor)访问者可以通过User类获取需要的数据进而进行相应的操作
    abstract public function accept(UserVisitor $vitor);

}

//实现元素接口
class VipUser extends User
{
    //这里的getPoint()具体实现就由接口中实现了

    //在这里就把当前对象传递给了visitor 访问者， 在访问者类的visitVip方法中就能根据$this获取必要的数据进行相应的操作
    public function accept(UserVisitor $vitor)
    {
        $vitor->visitVip($this);    //这里反转控制，与观察者模式不同
    }
}

class NormalUser extends User
{
    //同上的getPoint()具体实现就由接口中实现了

    //同VipUser类中的accept
    public function accept(UserVisitor $vitor)
    {
        $vitor->visitNormal($this);
    }
}

//定义访问者接口
abstract class UserVisitor
{
    //访问者必须要实现的访问不同用户的接口方法
    abstract public function visitVip(User $user);
    abstract public function visitNormal(User $user);
}

//积分操作的访问者实现，关键点：这里以后可以扩展功能，如MoneyActVisitor等类
class PointActVisitor extends UserVisitor
{
    public function visitVip(User $user)
    {
        echo "Vip用户+10分\n";     #其实这里可以调用形参$user中的方法
    }

    public function visitNormal(User $user)
    {
        echo "Normal用户+5分\n";
    }
}

//用户的树形结构
class Users
{
    protected $users;
    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    //让所有的用户都能被访问者访问
    public function handleVisitor(UserVisitor $visitor) // 与观察者模式的区别在于这里，注入的反转控制实例
    {
        foreach ($this->users as $user) {
            $user->accept($visitor);        // 到这里还跟观察者模式一样，只是accept($visitor)里面形成了反转
        }
    }
}

$pointVisitor = new PointActVisitor();

$users = new Users();
$users->addUser(new VipUser()); //添加新用户
$users->addUser(new NormalUser());
$users->addUser(new NormalUser());

$users->handleVisitor($pointVisitor); //执行PointActVisitor访问者的操作

//结果
// Vip用户+10分 
// Normal用户+5分
// Normal用户+5分