# PHP

**说明：包含php的杂项知识，没有通过md排版**

## 基础知识

1 ip+端口：可以访问

2 配置DNS：把域名翻译地址；

3 操作系统      Web服务器     数据库              语言
 Windows        IIS             SQL Server       Asp(#)
 Linux         Apache           MySQL            php
 Unix          Tomcat           Oracle             jsp

4 PHP配置文件：php.ini
   Apache的配置文件：httpd.conf
   MySQL配置文件：my.ini

5 开始结束符
- 方式一(采用)
`<?php` 为开始符；
?>为结束符；备注：a 结束符后就不要空格或者enter，这样有可能会出错(在单独的PHP文件中)，如果后面后html代码，那么先enter出空隙，再按标准做；
    b 嵌入html中的位置任意，php在服务器端被执行；
    c 如果以<?php 开始，后面整个文件都是php文件，最好就不要用结束符；
 - 方式二：`<script language="php">  <script>`
 - 方式三：`<? ?>`
 - 方式四：`<% %>`
   

6 分号：功能执行语句都要加分号，如 `echo "aaaa";$a=100;`都要加分号；
        结构定义语句不加分号，如if，或者while 不能加分号；

7 注释符   单行注释：  //或者# 
		   多行注释：/* */       备注：多行注释里不能再有多行注释了；
		   文档注释：/**  */    备注：多行注释里不能再有多行注释了,可以用软件提出来作为一个单独文档；
		   注释写在代码上面或者右边；

8 变量 ，php为弱类型语言，不用声明类型；
  a 变量名以$开始；
  b 变量的名称声明时一定要有意义；
  c 不合法的变量名：不能以数字开头，变量名中不能存在运算符和空格，但是php可以用系统关键字作为变量名（因为$）；
  d 变量名称严格区分大小写（驼峰式命名）；

9 简单函数
var_dump()：输出变量类型和值；
isset()：判断空号中变量存不存在，返回布尔值；
unset():清除括号中的变量；
empty()：判断字符串是否为空(例:$d=""或者$d=null或者这个变量不存在，那么为空)，为空返回为true；

10 可变变量：获取一个普通变量值作为可变变量名；
例：
$name="age";
$$name=16;//相当于$age=16;

11 变量的引用，相当于给变量取了个别名；
例：
$a=10;
$b=&$a;
备注：变量$a或者$b其中任何一个变化，另一个的值也要跟着变化；但是用unset()删除其中一个，另一个还在；
一个变量b只能是另外一个变量a的引用，如果变量b又成为变量c 的引用，那么变量b将和变量a解除引用关系，也就是说一个引用名只能引用一个变量（且只有变量才能有引用，如直接数字100，不能引用）；
注意:$a=$b=10;这个是同时声明两个变量，其中一个变化，另一个不会跟随变化；
 
12 php八种原始类型
标量类型：布尔型（boolean），整型（integer），浮点型（float），字符串（string）；
复合类型：数组（array），对象（object）；
特殊类型：资源（Resourse），NULL；
a 布尔型，boolean为false情况：
// boolean    false
// int            0
//float          0.0          0.00   后面可添加0；
//string        ""            "0"
//array         空数组
//NULL         null(包括没有声明的变量)
其余都为true; 
b 0开头为八进制 ，如：077；
   0x开头为十六进制 ，如：0xff；
备注：如果在浏览器中输出会换算为十进制的数字；
整型用32位存储，如果数字大于2e+31后（e大写也行，省略+默认为+），自动转为浮点数（用64位存储）；
备注2：浮点数是个近似数，最好不要判断相等；如：8==8.0，可能会返回false，但是php是返回true；
c 字符串与JavaScript中一样，连转义字符\都一样；条件是在双引号中 \n表示换行，\r表示回车，\t表示tab键；
注意：字符串的单引号和双引号有区别：
       c-a 双引号中可以解析变量（如：echo "this $int is demo"，echo "this{$int}is demo"），而单引号不能解析变量；
      c-b 在双引号中可以使用转义字符，条件是在双引号中 \n表示换行，\r表示回车，\t表示tab键，\\表示转义\，\$转义（用在改变变量），\[0-7] {1,3}  此正则表达式匹配一个用八进制表示的字符，\x[0-9A-Fa-f] {1,2} 此正则表达式匹配一个用十六进制表示的字符；    在单引号中只能转义单引号自己或者转义转义符号自己，如\\；
备注：如果字符串没有涉及双引号才能使用的功能，那么尽量用单引号；
      c-c 用定界符号声明字符串
           c-c-a 使用<<<三个小于号；
           c-c-b 在开始的定界符（自定义的字符串中）一定要左边挨着<<< ，写完定界符一定要直接回车（空格都不能有）
           c-c-c 在结尾的字符串定界中，一定要顶头写，和开始的字符串字符串要一致，加上分号后并直接回车；
           c-c-d 使用''在开始的定界符号中，将声明的该字符串默认支持双引号的功能，改为单引号功能；
例1(默认支持双引号功能)：

    $str = <<<string
           this is a demo.
    string;
例2(支持单引号功能)：
         $str = <<<'string'
       this is a demo.
string;


d   NULL类型：d-a 被赋值为null的变量；d-b 尚未被赋值的变量；d-c 被unset()函数销毁的变量；

f  伪类型：在写函数说明时用；
    mixed：说明一个参数可以接受多种不同的类型；
    number：说明一个参数可以是integer或者float；
    callback：说明参数是用户自定义函数或者方法；

13 A 强制转换
       getType(变量);获取变量类型；
    A-a   setType(变量，类型名称字符串);强制设置变量转为其他变量类型；
例1：
$int=10;
setType($int,"string");将$int类型转为字符串；
    A-b  在变量使用时，前面加上类型符号，进行转换--是在赋值给新变量新类型，原变量类型不变；
例：
$int=10;
$b=(string)$int;
备注：变量$b将是string类型，但$int将不变；
    A-c  intval(变量)，floatval(变量),strval(变量)，分别强制转化为整型，浮点型，字符串型变量赋值给新变量，但是原变量类型不变哦！
备注：如果float类型强制转化为integer类型，是将float类型小数点后去掉，不是四舍五入，如果转化过来超出integer最大值，多的部分也溢出；
    B 自动转化：小类型转化为大类型（大小类型依据存储大小）；小类型：boolean类型和string类型；稍大类型integer类型；大类型为float（即double类型）；小类型之间不能相互转化（即boolean和string不能相互转化，如果这两种类型相加，则先转化为整型，然后再相加），只能转化为integer或者float；
备注："2sdf"转为整型为2；

布尔类型 ：
a 转化为整型，布尔值为true，则转化后值为1，若布尔值为false，则转化后值为0；
b 转化为字符串型，布尔值为true，则转化后值为'1'，若布尔值为false，则转化后值为 ''；
备注：用echo 来输出布尔类型，则页面将其转化为字符串来输出，即true输出1，false输出     （'' 即空）；

字符串类型：
a 转化为整型，字符串开头含有数字或者科学计数法，则转化为该数字，若开头没有数字，则转化为0；例：$str="12e3sdfsdf"，转化后$str=12e3;
b 转化为布尔类型，字符串不为空或者不是"0"，则转化后值为true(甚至'0.0'也为真)，若为空，则为false；

整型；
a 转化为布尔类型：整型原值不为0，则转化后为true，原值为0，则转化后为false；
b 转化为字符串：转化后就是原值加上引号的字符串，包括原值为0；
备注：浮点型跟整型一样，0.00转化为boolean也是false；


14 变量类型的测试函数
a  is_bool():判断是否是布尔型；
b  is_int()、is_integer()或者is_long():判断是否为整型；
c  is_float()、is_double()和is_real():判断是否为浮点型；
d  is_string()：判断是否为字符串
e  is_array():判断是否为数组；
f  is_object()：判断是否为对象；
g  is_resource():判断是否为资源类型；
h  is_null():判断是否为null类型；注意empty()是判断是否为空；
i   is_scalar(): 判断是否为标量;
j   is_numberic():判断是否是任何类型的数字或者说数字字符串；
k  is_callable():判断是否是有效的函数名；

15常量：在整个脚本运行过程中不变的量（直接是全局的），语法：define("常量名",常量值)；例：define("ROOT","localhost");define("integer",100);备注：a 如果常量没有声明，则常量名自动转化字符串（但效率低）；
         b 常量名称前不要加$符号；
         c 常量名称，默认区分大小写，但是习惯全大写；
         d 可以使用define()第三个参数来决定是否这个常量名称区分大小写（true为不区分，false为默认区分）；
         e 常量的值只支持标量数据类型（int，float，boolean以及string）；
         f  常量不能使用unset()清除一个常量；
         g 可以使用defined();判断一个常量是否存在，返回布尔型；例：defined("ROOT");
         h 可以通过函数constant()来读取常量的值，当然直接用常量名就行了；
         i  get_defined_constants(),可以获得已定义的常量列表（即数组，用var_dump(get_defined_constants());）

16 A 预定义常量：预先已经定义好的常量，可以查看PHP手册，如：M_PI；
    B 魔术常量：在不同位置可能有不同的值；
如(大小写都行)：
__LINE__     文件中的当前行号；
__FILE__     文件中的完整路径和文件名，如果用在被包含文件中，则返回被包含的文件名；
__DIR__      文件所在的目录，如果用在被包含文件中，则返回被包含的文件所在的目录；
__FUNCTION__    函数名称；
__CLASS__       类的名称；
__METHOD__       类的方法名；
__NAMESPACE__  当前命名空间的名称（大小写敏感）；

17 运算符
A 算数运算符号   +, -, *,  /,  %, ++,  --  
B 赋值运算符号    = , +=, -=, *=, /+ ,%=，  .=
C 比较运算符号   > , <, ==, >=, <= ,===, != ,!==
D 逻辑运算符号   && , ||,  !，xor（异或，操作符两边一真一假才返回true）；
E  位运算符号      &  ,  | ,  ^ ,  ~,  >>,  <<
F  其他运算符号   ?  : , @ ,    =>  , ->
备注：
a 加号在PHP中没有连接字符串功能；连接符号是  .  ，其两边是字符串或者字符串及其他类型的变量（其他类型就不能直接在它两边，必须是其他类型的变量）；
例：
echo '这个变量的值：'.$a.'<br />';
echo "这个变量的值：{$a}<br />";
echo "这个变量的值：",$a,"<br />";  （这个用逗号隔开是表示echo的三个参数）
备注：这三个输出一样的；

b %求模（求余数）的正负号由被除数的正负号决定；小数求模没有意义，PHP先把小数转化为整型，再求模；
c  分析：
$i++    直接连续的两个运算：$a = $i;$i = $i + 1; 其中：变量$a为这个位置$i++在整个运算中表现的值；
++$i	直接连续的两个运算：$i = $i + 1; $a = $i;
其中：变量$a为这个位置++$i在整个运算中表现的值；

例：$a=5;
$b=$a++ + ++$a;
$b的值为12；


备注：
布尔型不参与++和--运算，例true++结果还是true;
字符串中++和--是
字符串中++和--是操作字符串中最后一位，若最后一个是数字，则数字+1或-1，如果是字母，则对字母进行升序和降序，如果最后一位是空格或者其他符号，则不变；例1："a"++ 结果为"b"；例2："z"++结果为"aa";例3：$a="bz9";$a++;结果为：ca0 ；

d 比较运算符号，返回值是boolean；例：7=="007";返回值为true；
   逻辑运算符号，返回值也是boolean，逻辑运算符不能在同一运算集中出现，如要用()隔开；
例：if ( ($year%4 == 0 && $year%100 != 0) || ($year%400 == 0) ){}
逻辑运算符号具有短路特性：
      逻辑与    条件1&&条件2，条件1不成立，则条件2根本不执行代码；（用位运算&，代码全部执行）
      逻辑或    条件1  ||   条件2，条件1成立，则条件2的代码也不执行；
例1：
$a=0;$b=0;
if($a =3 || $b=3){
   $a++;
   $b++;
    }
   echo $a.",".$b;
   

结果：1,1
解释：首先赋值优先级只比后++高，比 || 低，先运算后面的逻辑运算符，由于3转化为bool型，为true，则后面直接短路，true赋值给$a，但是bool型不参与++运算，则还是true，true用echo输出则为1
例2：
$a=0;$b=0;
if($a =3 && $b=3){
   $a++;
   $b++;
    }
   echo $a.",".$b;
结果：1,4

f 位运算：二进制的运算；
与运算  值1  &  值2    值1和值2二进制中相对应位置都为1才取1，其余都是0；
或运算  值1   |   值2    值1和值2二进制中相对应位置只要一个为1就取1，其余都是0；
异或运算  值1   ^  值2    值1和值2二进制中相对应位置值不同则取1，相同则是0；
按位非运算    ~值1     按值1的二进制取反；
左右移动运算  值1<<2   按二进制全部左移2位（值1*2^2，左移乘以2的左移位数次方，右移则除），前面溢出，后面两位补00；
备注：
f-a   位运算除了字符串与字符串进行位运算，返回结果为字符串外，其他的数据类型进行位运算都返回整型（包括字符串与整型，布尔型与布尔型等进行位运算都是返回整型）；
f-b   & 和 | 可以分别充当逻辑运算符 && 和 ||，但是前者没有短路；

g 其他运算符
g-a  三元运算符：条件 ？ 表达式1 ：表达式2
备注：表达式类型时直接的值或者赋值等式，不能为复杂功能语句（如：true?echo "这就不行":"不行"）
g-b 反引号``   但是反引号里是系统命令；

g-c @ 临时屏蔽错误信息（错误级别不高可以被屏蔽）；例：@echo $a;(了解)

18 
A多条分支
if(条件1){
}else if(条件2){
}else if(条件3){
}····
}else{
}
备注：a 最终的else(){}可以省略，且else if是js中式分开的，在php中既可以是else if也可以是elseif；
b 多路分支只能进入最先满足条件的一个；

B switch(变量){
case 值1:
case 值2:
case 值3:
             语句1;
             break;


case 值4:
             语句3;
             break;
·····
 default：语句；break(可选);
}
备注：switch（）括号必须是变量；default在前面值不匹配时，执行其中代码；
switch-case 注意细节：
a 如果在case中的语句过多，就需要将多个语句做成一个函数之类的；
b switch（变量）中的变量类型 只有两种：整型和字符串；
c break是退出switch结构使用的，如果需要同时匹配多个值时，可以使用多个case而不加break，如上例；流程进入switch后，要么通过break出去，要么从最后出去；
d else if 判断范围时使用（用switch写的也可以用else if 写）；
   switch case  单个值匹配进行分支；

19
php中两个预定义数组:$_POST 和$_GET
语法：$_POST[name]；获取传过来与name相对于value的值（value值包括属性中的value值和标签中间的值）；
语法：$_GET[name]；获取传过来与name相对于value的值（value值包括属性中的value值和标签中间的值）；
备注：
       标签<select></select>是取标签<select></select>的name值，不是标签<option></option>的name值；
       但是设置提交后保留在某个选项，又是在标签<option></option>中操作，如下例：
<option <?php echo $selector=="+" ? "selected='selected'" : "" ;?>>+</option>
<option <?php echo $selector=="-" ? "selected='selected'" : "" ;?>>-</option>

屏蔽注意警告：error_reporting(E_ALL & ~E_NOTICE);

20 php是内嵌html的脚步语言；几乎除了标签字母中不能嵌入以外，其他地方都能嵌入，并且改变html文档，然后html文档被浏览器执行；

21 循环
A while 大量应用于条件循环；
语法：while(条件){循环体}

B do-while
语法：do{循环体}while(条件);     特别注意后面的分号一定要加上；

C for
语法：for(初始条件;判读条件;自增条件)；
例：for($i=0,$j=0;$i<100 || $j>0;$i++,$j--){} 
      echo $i;
   特别注意：在循环外，$i依然存在，如果经过前例那么$i为100；if和循环的{}中声明的变量，后面代码依然可以用，但是函数内部声明变量或者形参，只能在函数内部调用（形参可以传值）；

D goto 利用标志，直接跳到标志位置代码处执行；
   标志的定义,    标志名：{代码}；注意：标志本身并不会阻碍代码执行，且代码外的{}不是必须的；
   语法：goto  标志名；
备注：结束goto循环不用break，而是采用另一个goto跳出循环；

E 特殊循环语句：
  E-a  break 功能：退出for循环，while循环和do-while循环，当然也可以退出switch-case；
备注：语法：break 数字；数字表示退出循环层数；例：break 2; 表示退出二层循环；（实践后可行）

  E-b  continue 功能：跳过for循环，while循环和do-while循环本次循环，进行下一次循环；
备注：语法：continue 数字；数字表示跳过循环次数；例：continue 2; 表示跳过两次循环；（实践后好像不行）
特别注意：
$i=0;
while($i<100){
if($i%3==0) continue;
echo "这个是个死循环！";
$i++;
}

说明：这是一个死循环，因为用continue跳过此次循环后$i不会自增，永远停留在那里，这一点值得注意，计数循环还是用for吧！
  E-c  exit（别名die）    功能：退出脚本；写法：exit 或者exit("这句话输出后，程序结束")；


22 函数：是一段完成指定任务的已命名代码块；  ；种类：自定义函数和系统函数；
备注：
a 调用函数可以在声明该函数之前；
b 形参是声明时括号中的参数，实参是函数调用时括号中的参数；
c 用return 终止函数，写在return后面的代码不会被执行；
d 函数不能重名（包括与系统函数也不能重名，大写A和小写a也算重名）；
e 函数名不区分大小写；
f 用function_exists("函数名")判断函数是否存在，返回boolean； 

23
A  全局变量：在函数外部声明的变量，可以在每个函数中都能使用；
a  PHP规定：所有在函数内部写的变量都是新声明的局部变量；
b  在函数内部如果需要使用函数外部的变量，需要使用global关键字，将外部变量引入，不引入将会报错；
   例1：global $a,$b;
   例2：
         $name="hehe";
 function demo(){
        $name="haha"; //新的局部变量；
        global $name;
        echo $name;     //输出全局变量；
}

c  常量可以直接被函数内部引用；
d  全局数组也可以被函数内部引用，如$_POST["name"];
e  如果函数内部需要调用全局变量，全局变量只要声明在调用函数的代码之前就行，不一定要声明在函数声明之前； 
B 局部变量：函数内部声明的变量；

C 静态变量：用关键字static声明的变量；
a  在函数中（函数外跟全局变量就没区别了，没必要）声明的静态变量，只在第一次调用时声明；
b  第二次以及更多次，要先判断静态区是否已经存储该变量（同一变量名，但是在不同函数中声明，存储是不同的），如果有，将跳过声明，直接引用；
c  静态变量，在同一函数多次调用中共享（记着是同一函数）；
d  生命期：由声明-脚本结束；

24 
A   只有在内存中的变量才有地址；
B   函数形参中有&$变量名，那么调用函数时的实参只能是变量，不能为具体的值，并且函数中该变量自动为实参变量的引用，即如果函数中变量改变，那么函数外的实参变量也要改变；
例：
    $a=10;
    function func(&$b){
  	  $b++;
   	 echo $b;
    }
    func($a);
备注：$a的值也变为了11；总结：a 实参必须是变量 b 建立的引用关系；

C   默认参数：就是给形参的变量赋值；在调用函数时没给实参时，就调用默认参数值；
例：function($age,$name[,$email="445354187@qq.com"[，$neo="liu"]]){}  
备注：$age和$name是必选参数；$email和$neo是分别可选参数；
利用默认参数可以使实参个数小于形参个数；

D   func_get_args();在函数内部接收实参值，返回实参数组；
    func_num_args();在函数内部接收实参个数（返回为int型）；
    func_get_arg(int);在函数内部接收实参数组下标为int的值；
利用上面函数可以使实参个数大于形参个数；
例：
 function demo(){
     $arr = func_get_args();
     echo $arr[0];
}
   demo(1,2,3,4,5,6);
备注：func_get_args()就可以将所有实参赋值给数组$arr;即实参和形参个数之间没有对应关系；

25 变量函数：函数名用变量代替，语法：$变量名();
原理：将函数名赋值给变量，用  $变量名();  来替代函数的调用；
应用：赋不同函数名给变量，变量函数将调用不同函数；
例：
function demo($a,$b){
              echo $a+$b;
     }
$var = "demo";
$var(2,4);


26  print_r(数组) ；打印数组；
    strlen();该函数返回字符串长度；

27 回调函数：在函数调用时，将一个函数（函数名）作为实参进行传递，那么作为实参的函数就是回调函数；
备注：
a  第一种：在调用的函数中，回调函数的函数名是作为实参，变量函数的变量是作为形参（如：变量函数$demo(),那么变量是$demo）；
b  第二种：调用类的方法（也就是函数）或者对象方法时，就不能用变量函数来调用这个函数；而是利用 call_user_func_array()；（采用）
语法一，函数为全局函数：call_user_func_array(函数b的名，传去函数b的参数的数组)；
语法二，函数时类或者对象的方法：call_user_func_array(array(对象或者类名，方法c的名)，传去方法c的参数的数组)；*************

28 
遍历文件夹：
A opendir(路径);路径： .表示当前文件夹，..表示父文件夹，/表示根路径；文件夹名时路径的一部分；
返回路劲中文件夹中所有文件信息，假设赋值给$dir；
B readdir($dir); 一个一个遍历指定文件夹中文件，返回文件名字以及其类型（文件夹只有名字）；是一个readdir($dir)操作一个文件，其中最开始两个为 .   ..  
C closedir（$dir） 关闭打开文件夹；

29 递归函数：在函数中调用自己的函数；分为两个过程：递---归；特殊注意“归”；

30 include 引用其他文件进入php文件，并不是复制文件进入php文件，而是经过了特殊处理;
语法1：include 路劲+文件 ；
语法2：include (路劲+文件) ;（采用）
语法1：include_once 路劲+文件 ；这种能处理重复包含同一个函数库，导致的错误；
语法2：include_once (路劲+文件) ; 这种能处理重复包含同一个函数库，导致的错误；
例：
include "function.inc.php";
include "function.inc.php";
备注：调用一次，将会重新定义一次，那么就像函数重复定义将会产生错误；
include_once "functin.inc.php";
include_once "functin.inc.php";
备注：这个先判断，则不会出错；当然如果是include "hehe.txt";如果hehe.txt内容aaaa<br/>这种，重复包含只是多次输出而已，不会出错，只有重复定义函数时才会出错；
语法1：require 路径+文件；
语法2：require (路径+文件)；（采用）
语法1：require_once 路径+文件；
语法2：require_once (路径+文件)；
备注：include与require功能几乎相同，只是include包含函数失败，会使一个警告，require则是致命错误（程序崩溃），情况：在必须包含一个文件，如果包含失败，脚本就无法执行，那么选择require；情况：根据不同情况包含，则选择include；
例：
require "demo.txt";
例2：
if($a==true) include "hehe.txt";
else include "neo.txt";



32 数组：若干个变量的集合；
分类：
a 索引数组，下标为整数型；例：$arr[0]="aaaa";
b 关联数组：下标为字符串；例：$arr["one"]="bbbb";

声明：
A 
a 直接赋值：$arr[0]="aaaa";或者$arr["one"]="bbbb";（备注：$arr[0]中[]也可以换成{}，但建议[];）
备注：echo "11111$arr['one']1111111"; $arr['one']不是特殊符号，能成功获取到值；
b 关联数组下标一定要使用引号，不要使用常量名称（虽然也会显示，但效率低）；
c 关联数组和索引数组的下标在同一个数组中是可以同时存在的；例： $arr['one']=1;$arr[2]=2;是可以同时存在的；
d key会有如下强制转化：
     包含合法整型值得字符串会被转化为整型。如键值名“8”实际会被储存为8.但是'08'不会强制转化，因为不是一个合法的十进制数值，同时“8asdf“也不会被转化整型，而本身就是字符串，为关联数组；
      浮点数也会转为整型，采用割舍，9.8转化后为9；
      布尔型也转化为整型，true为1，false为0；
      null则转化为空字符串，为$arr[];数组和对象不能为键名；
****索引数组的自动增涨下标，默认是从0开始的，自动增涨的都是出现过（'出现过'意思为上面的代码）的最大值加1；关联数组不会影响索引数组下标的排列规则；
例：
$arr[]=0; //下标0
$arr[]=1;//下标1
$arr[]=2;//下标2
$arr[8]=8;//下标8
$arr[]=9;//下标9
$arr[9]=10;//下标9,覆盖前面那个；
$arr[-100]=-100;是可以的，下标就是﹣100；
$arr[]=10; //下标为10，因为最大值+1；

B 使用array()函数声明数组，默认是索引下标，也可以使用=>符号指定下标,key=>value；
例：$arr=array("aaaa","two"=>"bbbb",9=>"cccc");

C $arr=["aaa","bbb",9=>"ccc"];在php5.4版本后；(采用)

D unset可以删除数组的key=>value;而设置某个键value为null，key不会消失；并且注意：这种方式删除后，不会重新索引；如果要重新索引，则在删除后，用array_values()函数；
例：
unset($arr[1]);
$arr=array_values($arr);

E 二维数组声明，注意元素也不一定非要是数组；
语法1：$group=array(array(),array(),array());
            $group=[[],[],[]];
备注：
$group[][]="";  自动增涨//下标[0][0]
$group[][]="";//下标[1][0]
$group[][]="";//下标[2][0]

F 遍历数组
F-a for循环遍历数组（效率最高），但下标不连续和关联数组就不太实用；
F-b foreach     （采用）
语法1：foreach(数组  as 自定义变量){};
数组有多少个元素，foreach就循环多少遍；
foreach会将数组中的元素在每次循环中，依次将元素的值给自定义变量，并适用于下标不连续或者关联数组等所有类型数组；

语法2：foreach(数组  as 下标变量 => 值变量){}
备注：当然'值变量'也可以是数组（因为有可能是二维及多维数组）；

F-c list() each()和while()协同遍历；不足：如果不用reset()将指针回执，就只能遍历一次；
c-a  list() 函数，但这个函数跟其他函数用法不同；
语法：list() = 数组;
作用：将数组中的元素赋值给变量使用；说明：通常数组中有几个元素，在list()中就有几个参数，而且参数必须是变量（新声明的自定义变量），不能为值，并且只能是索引数组（且下标连续，猜测：list()函数中应该用的是for循环），转为变量；例1：list($a, ,$c)=["a","b","c"];只接收第一个和第三个元素，注意中间空着；
例2：list($a,$b)=["a","b","c"];只接收第一个和第二个元素；

c-b each() 只是一个函数，参数只能是一个数组的变量（不能直接为数组），返回的值也是一个数组；
   返回的数组包括四个固定元素，而且下标也是固定的；下标：1  value  0 key  分别对应参数数组中被操作的元素的：值   值   下标   下标；
   each()只处理当前的元素，将当前的元素（默认为第一个元素）转为数组信息，处理完成后，指针指向下一个元素移动；如果指针已经在结束位置了，如果再使用each()获取元素，则返回false；
例：
$arr=["aaa","bbb","ccc"];
while(list($a,$b)=each($arr)){
	echo $a."=>".$b."<br />";
}
备注：each()返回为四个元素的数组，而在这儿list($a,$b)只能直能接收两个，因为list()只能是索引且下标连续的数组；

G 控制指针函数

next() 参数为数组，负责将指针向后移动；
prev()  参数为数组，负责将指针向前移动；
end()  参数为数组，负责将指针移动到最后；
reset() 参数为数组，负责将指针无条件移至第一个索引位置；
key() 参数为数组，获取当前元素的键；
current() 参数为数组，获取当前元素的值；

33 超全局数组（变量），在php的脚步中，已经声明好的变量，可以直接使用（名字不变）；
$_SERVER       服务器变量，获取服务器的信息；
$_ENV          环境变量（了解）
$_GET          HTTP GET变量，接收用户通过URL向服务器传递的参数
$_POST         HTTP GET变量，接收用户通过http协议向服务器传递的数据
$_REQUEST      request变量    ，不管什么方式传递到服务器的信息都能接收（不建议采用）；
$_FILES	      HTTP文件上传变量
$_COOKIE       HTTP Cookies
$_SESSION      Session变量
$GLOBALS      Global变量   所有已定义全局变量组成的数组（包括预定义和自定义），变量名就是该组的索引（没有$符号）；
备注：
1. 数组（关联数组），就和你自己声明的数组是一样的操作方式；
2. 全局：在函数内部调用，不用添加关键字global；
3.每个预定义数组都有独特的能力；
4.不要用超全局数组作为形参；

34 数组和字符串操作函数都要会；
a     array_values(数组) 返回数组的值（并不改变原来数组）；
b     array_keys(数组 [,值 [,bool]]) 返回数组的键值（并不改变原来数组）；
例：$arr=array_keys($arr,"bbb",true);备注：第三个参数为true，则要求类型和值都要符合；
c      in_array(被查询值，数组 [,bool])      检查数组中是否存在某个值（也可以为数组），返回bool，可选参数为true，则要求被查询值与数组中的值不仅值相同且类型也要相同；
d     array_search(被查询值，数组 [,bool])   在数组中搜索给定的值，如果成功则返回第一个匹配元素的键名；
e     array_key_exists(键值，数组)     检查数组中的键值存不存在，返回bool；
f     isset()         判断变量存不存在，返回bool型，注意数组中某元素空值isset返回为false，但e中函数为true；
g     array_flip(数组) 交换数组中的键和值（类型只能是整型和字符串）；注意：交换后键出现重复，那么后面的值覆盖前面的值；
h     array_reverse(数组 [,bool])   返回将数组中元素倒序组成新的数组；可选参数为true，则保留索引数组键值（即 1=>"bb" 0=>"aa" ）,默认为false不保留，但对于关联数组这个参数每意义；

统计数组元素个数和唯一性
i count(数组 [,int])  统计数组的个数，如果参数为字符串包括空字符串，返回int 1；统计字符串用strlen();可选参数默认为0 ，表示统计数组0层，设置int后，就统计0,1,2---int 层一共的元素多少个数
例：
$arr=[["hehe","haha"],"bbb","xxx","aaa","bbb"];
echo count($arr,1);
结果为7个；
j array_count_values(数组)  返回一个数组，键名是原来数组的值，元素值为出现次数；

k array_unique(数组)  移出数组中重复的值（保留第一个出现的值和键）；

l array_filter(数组 [,callback])用回调函数过滤数组中的单元；默认情况下（没有回调函数），数组中值为假值（如：'',null,false）会被过滤（空格不是假值哦）；回调函数接收一个变量（数组中每个元素依次赋值给该变量），回调函数返回true，则该数组元素保留，返回false，则删除（是在新的数组中删除，对原数组没影响），返回的新数组并不会重新索引，如果需要用array_values();
例：
$arr=[-1,0,1,2];
var_dump(array_filter($arr,function($val){
	return ($val>0);
}));

m  array_walk(数组（自动形成引用），callback [,另外传入回执函数参数]) 对数组的每个成员应用用户函数，返回bool；（好像只有这个函数，操作的是本数组，没有返回新数组）
例：
$arr=[-1,0,1,2];
array_walk($arr,function($value,$key,$str){
  	$value++;
	echo $key.$str.$value."<br />";
},"=>");  //注意有这个参数，才有回调函数中第三个参数；
备注：如果要改变原数组，则回调函数参数需变成&$value（一般都采用引用）;****

n array_map(callback，数组1 [,数组2---]) :将回调函数作用在给定数组的值(
