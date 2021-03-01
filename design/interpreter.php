<?php
/**
 * 解释器：
 */
// 所有表达式的基类，包括变量、字符以及运算符
abstract class Expression
{
    private static $keycount = 0;     #所有子类共享的，默认作为键值对的键
    private $key;                   #存储键值对的键，以便后面能在Context::expressionstore数组中获取到对应值

    abstract function interpret(Context $context);    #解释器方法

    function getKey()
    {
        if (!isset($this->key)) {
            self::$keycount++;      #返回以后的键值+1；
            $this->key = self::$keycount;
        }
        return $this->key;
    }
}

//字符表达式
class LiteralExpression extends Expression
{
    private $value;

    function __construct($value)
    {
        $this->value = $value;
    }

    function interpret(Context $context)
    {
        $context->replace($this, $this->value);   #其实是存储键值对的一个功能
    }
}

//上下文类，起到一个储存和显示键值对的作用，存储的是变量类似于键和值，而运算符就表示键和运算结果
class Context
{
    private $expressionstore = array(); #存储键值数组

    //存入self::expressionstore数组的方法
    function replace(Expression $exp, $value)
    {
        $this->expressionstore[$exp->getKey()] = $value;
    }

    //获取具体值的方法
    function lookup(Expression $exp)
    {
        return $this->expressionstore[$exp->getKey()];
    }
}

class VariableExpression extends Expression
{
    private $name;
    private $val;

    function __construct($name, $val = null)
    {
        $this->name = $name;
        $this->val = $val;
    }

    function interpret(Context $context)
    {
        if (!is_null($this->val)) {
            $context->replace($this, $this->val);
            $this->val = null;
        }
    }

    function setValue($value)
    {
        $this->val = $value;
    }

    function getKey()
    {
        return $this->name;
    }
}

// end previous

//操作符基类
abstract class OperatorExpression extends Expression
{
    protected $l_op;    #左边表达式对象
    protected $r_op;    #右边表达式对象

    function __construct(Expression $l_op, Expression $r_op)
    {
        $this->l_op = $l_op;
        $this->r_op = $r_op;
    }

    function interpret(Context $context)
    {
        $this->l_op->interpret($context);
        $this->r_op->interpret($context);
        $result_l = $context->lookup($this->l_op);
        $result_r = $context->lookup($this->r_op);
        $this->doInterpret($context, $result_l, $result_r);
    }

    //实际操作方法
    protected abstract function doInterpret(Context $context, $result_l, $result_r);
}


class EqualsExpression extends OperatorExpression
{
    //实现了具体操作方法
    protected function doInterpret(Context $context, $result_l, $result_r)
    {
        $context->replace($this, $result_l == $result_r);     #把操作结果存储
    }
}

class BooleanOrExpression extends OperatorExpression
{
    protected function doInterpret(Context $context, $result_l, $result_r)
    {
        $context->replace($this, $result_l || $result_r);
    }
}

class BooleanAndExpression extends OperatorExpression
{
    protected function doInterpret(Context $context, $result_l, $result_r)
    {
        $context->replace($this, $result_l && $result_r);
    }
}

$context = new Context();
$input = new VariableExpression('input');     #即值为null
$statement = new BooleanOrExpression(
//EqualsExpression是判断两个形参对象的值是否相等，$input暂时未被赋值
    new EqualsExpression($input, new LiteralExpression('four')),
    new EqualsExpression($input, new LiteralExpression('4'))
);

foreach (array("four", "4", "52") as $val) {
    $input->setValue($val);
    print "$val:\n";
    /**
     * 注意：这儿的流程会执行BooleanOrExpression的interpret()，但又里面会先执行
     * 两个形参EqualsExpression的interpret()方法，继而会进一步先执行$input 和 LiteralExpression
     * 的interpret()方法，然后每一个的doInterpret()，存储 键为Expression::keycount+1
     * (每new Expression,获取到keycount都会不同，因为是类的变量)
     * 相应的结果作为值，存储在Context::expressionstore中
     */
    $statement->interpret($context);
    if ($context->lookup($statement)) {
        print "top marks\n\n";
    } else {
        print "dunce hat on\n\n";
    }
}


