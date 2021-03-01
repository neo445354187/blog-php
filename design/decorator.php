<?php
/**
 * 装饰器模式
 * 说明：可以动态的添加修改类的功能；
 *      装饰器是继承功能的补充，继承是一个父类，多个子类；装饰器可以一个装饰类，多个基类（类似父类那种感觉，虽然不是继承）
 * 思想：通过将基类实例注入装饰类，装饰类可以进行功能扩展；当然还可以切换不同的基类实例
 * 功能：能实现效果的叠加
 *
 *
①优点：装饰类和被装饰类可以独立发展，不会相互耦合，装饰模式是继承的一个替代模式，
 装饰模式可以动态扩展一个实现类的功能。例如：类A有个incr()方法，方法作用是在数字上+1，
 * 类B对类A的incr()进行装饰，需要在数字上+1+1，即+2；
 此时，又有一个类A2有incr()方法，作用是在数字上+10，此时仍然需要在类A2的incr()方法基础上+1，
 * 此时，如果采用的是继承，就得重写一个类B2，
 但是装饰模式，可以直接将类A2注入类B，即可完成功能实现

②缺点：多层装饰比较复杂。

③使用场景：1、扩展一个类的功能。 2、动态增加功能，动态撤销。
 */

//定义原始功能抽象类
abstract class Tile
{
	//获取健康因子功能
	abstract function getWealthFactor();
}

//实现原始功能类
class Plains extends Tile
{
	private $wealthfactor = 2;
	function getWealthFactor()
	{
		return $this->wealthfactor;
	}
}

//定义装饰类
abstract class TileDecorator extends Tile
{
	protected $tile;	#存储Tile实例
	function __construct(Tile $tile)
	{
		$this->tile = $tile;
	}
}

//具体实现类，都是继承于装饰类，而实现原始功能类作为基础功能，被装饰类包裹
class DiamondDecorator extends TileDecorator
{
	function getWealthFactor()
	{
		return $this->tile->getWealthFactor()+2;
	}
	
}

class PollutionDecorator extends TileDecorator
{
	function getWealthFactor()
	{
		return $this->tile->getWealthFactor()-4;
	}
	
}

// 测试
$tile = new Plains;
var_dump($tile->getWealthFactor());#返回 	2

//将plains实例作为形参实例化DiamondDecorator，形成了效果叠加
$tile = new DiamondDecorator(new plains);
var_dump($tile->getWealthFactor());#返回 	4

//将DiamondDecorator实例作为形参实例化PollutionDecorator，进一步形成了效果叠加
$tile = new PollutionDecorator(new DiamondDecorator(new plains));
var_dump($tile->getWealthFactor());#返回 	0
