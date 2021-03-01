<?php
/**
 * 策略模式
 * 说明：将一组特定的行为和算法封装成类，以适应某些特定上下文环境。
 * 应用举例：假如一个电商网站系统，针对男性女性用户要各自跳转到不同的商品类目，
 * 并且所有广告位展示不同的广告。
 * 说明：策略模式可以实现Ioc、依赖倒置、控制反转
 */

/**
* 用户策略接口
*/
interface UserStrategy
{
	function showAd();			//展示广告
	function showCategory();	//展示商品分类
}

/**
* 女装策略
*/
class FemaleUserStrategy implements UserStrategy
{
	
	public function showAd()
	{
		echo "female ad\n";
	}

	public function showCategory()
	{
		echo "female category\n";
	}

}

/**
* 男装策略
*/
class maleUserStrategy implements UserStrategy
{
	
	public function showAd()
	{
		echo "male ad\n";
	}

	public function showCategory()
	{
		echo "male category\n";
	}

}

/**
* 展示页面
*/
class Show
{
	
	protected	$strategy; 		//存储策略对象

	public function Index()
	{
		$this->strategy->showAd();
		$this->strategy->showCategory();
	}

	public function setStrategy(UserStrategy $strategy)
	{
		$this->strategy = $strategy;
	}
}

header("content-type:text/html;charset=utf-8");
$show = new Show;
$show->setStrategy(new FemaleUserStrategy);
$show->Index();

