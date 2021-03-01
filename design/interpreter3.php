<?php
/**
 * 参考：https://www.cnblogs.com/javazhiyin/p/10255287.html
 * 参考：https://www.cnblogs.com/edisonchou/p/7512733.html
 * 4.1 主要优点
　　（1）易于改变和扩展文法 => 通过继承来改变或扩展

　　（2）增加新的解释表达式较为方便 => 只需对应新增一个新的终结符或非终结符表达式，原有代码无须修改，符合开闭原则！

4.2 主要缺点
　　（1）对于复杂文法难以维护 => 一条规则一个类，如果太多文法规则，类的个数会剧增！

　　（2）执行效率较低 => 使用了大量循环和递归，在解释复杂句子时速度很慢！
 *
 * 解释器：将收到的信息，分解为各个终极表达式（语义树中的叶），利用代码实现各个终极表达式功能，最终以复合结构(嵌套之类的)
 *          完整实现接收到的所有信息
 * 用途：应用于语言或者模板解析
 */
/**
 * AbstractExpression. All implementations of this interface
 * are ConcreteExpressions.表达式
 */
interface MathExpression
{
    /**
     * Calculates the value assumed by the expression.
     * Note that $values is passed to all expression but it
     * is used by Variable only. This is required to abstract
     * away the tree structure.
     */
    public function evaluate(array $values);
}

/**
 * A terminal expression which is a literal value.
 * 一个终端表达式，它只是一个值，evaluate()也只是返回这个值没有其他操作
 */
class Literal implements MathExpression
{
    private $_value;

    public function __construct($value)
    {
        $this->_value = $value;
    }

    public function evaluate(array $values)
    {
        return $this->_value;
    }
}

/**
 * A terminal expression which represents a variable.
 */
class Variable implements MathExpression
{
    private $_letter;

    public function __construct($letter)
    {
        $this->_letter = $letter;
    }

    public function evaluate(array $values)
    {
        return $values[$this->_letter];
    }
}

/**
 * Nonterminal expression.
 */
class Sum implements MathExpression
{
    private $_a;
    private $_b;

    public function __construct(MathExpression $a, MathExpression $b)
    {
        $this->_a = $a;
        $this->_b = $b;
    }

    public function evaluate(array $values)
    {
        return $this->_a->evaluate($values) + $this->_b->evaluate($values);
    }
}

/**
 * Nonterminal expression.
 */
class Product implements MathExpression
{
    private $_a;
    private $_b;

    public function __construct(MathExpression $a, MathExpression $b)
    {
        $this->_a = $a;
        $this->_b = $b;
    }

    public function evaluate(array $values)
    {
        return $this->_a->evaluate($values) * $this->_b->evaluate($values);
    }
}

// 10(a + 3)
$expression = new Product(new Literal(10), new Sum(new Variable('a'), new Literal(3)));
echo $expression->evaluate(array('a' => 4)), "\n";
// adding new rules to the grammar is easy:
// e.g. Power, Subtraction...
// thanks to the Composite, manipulation is even simpler:
// we could add substitute($letter, MathExpression $expr)
// to the interface...