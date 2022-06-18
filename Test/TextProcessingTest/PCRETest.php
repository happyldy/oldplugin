<?php
/**
 *
 *
 * 分隔符： 任意非字母非数字，除反斜杠(\)和空字节之外的非空白ascii字符;常用：正斜线(/)、hash符号(#) 以及取反符号(~)等。
 * 元字符：
 *  在方括号外； 使用的元字符如下
 *  \   一般用于转义字符^断言目标的开始位置(或在多行模式下是行首)
 *  $   断言目标的结束位置(或在多行模式下是行尾)
 *  .   匹配除换行符外的任何字符(默认)
 *  []  开始结束字符类定义（一个字母就是匹配对象）
 *  |   开始一个可选分支
 *  ()  子组的开始结束标记 （一组字母为匹配对象）
 *  ?   作为量词，表示 0 次或 1 次匹配。位于量词后面用于改变量词的贪婪特性。 (查阅量词)
 *  *   量词，0 次或多次匹配+量词，1 次或多次匹配
 *  {}  自定义量词开始结束标记 （都好隔离的最大最小或确定的匹配次数）
 *  在方括号内； 的部分称为"字符类"。 在一个字符类中可用元字符如下
 *  \   转义字符
 *  ^   仅在作为第一个字符(方括号内)时，表明字符类取反
 *  -   标记字符范围
 *
 *
 * 转义序列(反斜线)： 可能用到的，其余看手册
 *  \n  匹配一个换行符。等价于 \x0a 和 \cJ。
 *  \r  匹配一个回车符。等价于 \x0d 和 \cM。
 *  \f  匹配一个换页符。等价于 \x0c 和 \cL。
 *  \t  匹配一个制表符。等价于 \x09 和 \cI。
 *  \v  匹配一个垂直制表符。等价于 \x0b 和 \cK。
 *
 *  \d  匹配一个数字字符。等价于 [0-9]。
 *  \D  匹配一个非数字字符。等价于 [^0-9]。
 *  \s  匹配任何空白字符，包括空格、制表符、换页符等等。等价于 [ \f\n\r\t\v]。
 *  \S  匹配任何非空白字符。等价于 [^ \f\n\r\t\v]。
 *  \w  匹配字母、数字、下划线。等价于'[A-Za-z0-9_]'。
 *  \W  匹配非字母、数字、下划线。等价于 '[^A-Za-z0-9_]'。
 *  \h  任意水平空白字符(从php 5.2.4起)
 *  \H  任意非水平空白字符(从php 5.2.4起)
 *
 *  \b  匹配一个单词边界，也就是指单词和空格间的位置。例如， 'er\b' 可以匹配"never" 中的 'er'，但不能匹配 "verb" 中的 'er'。
 *  \B  匹配非单词边界。'er\B' 能匹配 "verb" 中的 'er'，但不能匹配 "never" 中的 'er'。
 *  \A  目标的开始位置(独立于多行模式)
 *  \Z  目标的结束位置或结束处的换行符(独立于多行模式)
 *  \z  目标的结束位置(独立于多行模式)
 *  \G  在目标中首次匹配位置
 *  \K 可以用于重置匹配
 *  \Q 和 \E 可以用于在模式中忽略正则表达式元字符
 *
 *  \a  \cx \e \p{xx}  \x  \ddd  \xhh  \040 等等进制转化的 和 Unicode字符属性的 看不懂
 *  \a	报警字符(打印它的效果是电脑嘀一声)
 *  \0nn	ASCII代码中八进制代码为nn的字符
 *  \xnn	ASCII代码中十六进制代码为nn的字符
 *  \unnnn	Unicode代码中十六进制代码为nnnn的字符
 *  \cN	    ASCII控制字符。比如\cC代表Ctrl+C
 *  \p{name}	Unicode中命名为name的字符类，例如\p{Greek}  \p{Lu} 始终匹配大写字母。
 *
 *
 *
 *
 *
 * 模式修饰符：
 *  下面列出了当前可用的 PCRE 修饰符。括号中提到的名字是 PCRE 内部这些修饰符的名称。模式修饰符中的空格，换行符会被忽略，其他字符会导致错误。
 *  i (PCRE_CASELESS)
 *      如果设置了这个修饰符，模式中的字母会进行大小写不敏感匹配。
 *
 *  m (PCRE_MULTILINE 行首与行末相关) --> 这等同于 perl 的 /m 修饰符。
 *      默认情况下，PCRE 认为目标字符串是由单行字符组成的(然而实际上它可能会包含多行)，"行首"元字符 (^) 仅匹配字符串的开始位置， 而"行末"元字符 ($) 仅匹配字符串末尾，或者最后的换行符(除非设置了 D 修饰符)。这个行为和 perl 相同。
 *      当这个修饰符设置之后，"行首"和"行末"就会匹配目标字符串中任意换行符之前或之后，另外，还分别匹配目标字符串的最开始和最末尾位置。
 *      如果目标字符串中没有 "\n" 字符，或者模式中没有出现 ^ 或 $，设置这个修饰符不产生任何影响。
 *  D (PCRE_DOLLAR_ENDONLY  行末相关)
 *      如果这个修饰符被设置，模式中的元字符美元符号仅仅匹配目标字符串的末尾。
 *      如果这个修饰符没有设置，当字符串以一个换行符结尾时， 美元符号还会匹配该换行符(但不会匹配之前的任何换行符)。
 *      如果设置了修饰符m，这个修饰符被忽略. 在 perl 中没有与此修饰符等同的修饰符。
 *
 *  s小写 (PCRE_DOTALL 非空白字符与\n相关) --> 这个修饰符等同于 perl 中的/s修饰符。
 *      如果设置了这个修饰符，模式中的点号元字符匹配所有字符，包含换行符。
 *      如果没有这个修饰符，点号不匹配换行符。 一个取反字符类比如 [^a] 总是匹配换行符，而不依赖于这个修饰符的设置。
 *
 *  U (PCRE_UNGREEDY 可以被？替换)
 *      这个修饰符逆转了量词的"贪婪"模式。 使量词默认为非贪婪的，通过量词后紧跟? 的方式可以使其成为贪婪的。这和 perl 是不兼容的。
 *      它同样可以使用 模式内修饰符设置 (?U)进行设置， 或者在量词后以问号标记其非贪婪(比如.*?)。
 *
 *      Note:
 *      在非贪婪模式，通常不能匹配超过 pcre.backtrack_limit 的字符。
 *
 *  x小写 (PCRE_EXTENDED 给搜索模式加注释) --> 这个修饰符等同于 perl 中的 /x 修饰符，使被编译模式中可以包含注释。
 *      如果设置了这个修饰符，模式中的没有经过转义的或不在字符类中的空白数据字符总会被忽略，并且位于一个未转义的字符类外部的#字符和下一个换行符之间的字符也被忽略。
 *      注意：这仅用于数据字符。 空白字符还是不能在模式的特殊字符序列中出现，
 *      比如序列 (?( 引入了一个条件子组(译注: 这种语法定义的特殊字符序列中如果出现空白字符会导致编译错误。
 *      比如(?(就会导致错误)。
 *
 *  X (PCRE_EXTRA 反斜线可否跟无意义字符)
 *      这个修饰符打开了 PCRE 与 perl 不兼容的附件功能。
 *      模式中的任意反斜线后就 ingen 一个没有特殊含义的字符都会导致一个错误，以此保留这些字符以保证向后兼容性。
 *      默认情况下，在 perl 中，反斜线紧跟一个没有特殊含义的字符被认为是该字符的原文。当前没有其他特性由这个修饰符控制。
 *
 *
 *  A (PCRE_ANCHORED)
 *      如果设置了这个修饰符，模式被强制为"锚定"模式，也就是说约束匹配使其仅从目标字符串的开始位置搜索。
 *      这个效果同样可以使用适当的模式构造出来，并且这也是 perl 种实现这种模式的唯一途径。
 *
 *  S
 *      当一个模式需要多次使用的时候，为了得到匹配速度的提升，值得花费一些时间对其进行一些额外的分析。如果设置了这个修饰符，这个额外的分析就会执行。
 *      当前，这种对一个模式的分析仅仅适用于非锚定模式的匹配(即没有单独的固定开始字符)。
 *
 *
 *  J (PCRE_INFO_JCHANGED)
 *      内部选项设置(?J)修改本地的PCRE_DUPNAMES选项。允许子组重名， (译注：只能通过内部选项设置，外部的 /J 设置会产生错误。)
 *
 *  u小写 (PCRE_UTF8)
 *      此修正符打开一个与 perl 不兼容的附加功能。
 *      模式和目标字符串都被认为是 utf-8 的。无效的目标字符串会导致 preg_* 函数什么都匹配不到；无效的模式字符串会导致 E_WARNING 级别的错误。
 *      PHP 5.3.4 后，5字节和6字节的 UTF-8 字符序列被考虑为无效（resp. PCRE 7.32007-08-28）。 以前就被认为是无效的 UTF-8。
 *
 *
 *
 *
 *
 *
 *  语法
 *  (?>exp)	贪婪子表达式
 *  (?<x>-<y>exp)	平衡组
 *  (?im-nsx:exp)	在子表达式exp中改变处理选项
 *  (?im-nsx)	为表达式后面的部分改变处理选项
 *  (?(exp)yes|no)	把exp当作零宽正向先行断言，如果在这个位置能匹配，使用yes作为此组的表达式；否则使用no
 *  (?(exp)yes)	同上，只是使用空表达式作为no
 *  (?(name)yes|no)	如果命名为name的组捕获到了内容，使用yes作为表达式；否则使用no
 *  (?(name)yes)	同上，只是使用空表达式作为no
 *
 *  ab(?i)c匹配abC和abc
 *  (?i)+原子
 *      表示(?i)后的原子不区分大小写
 *      如果在后向引用时被强制进行了大小写敏感匹配
 *  ((?i)abc)\s+\1
 *      匹配 abc abc
 *      ABC ABC
 *      AbC AbC
 *      只要两个一样不分大小写
 *      但不匹配 ABC aBC等
 *  (?s) 表示所在位置右侧的表达式开启单行模式。通常在匹配有换行的文本时使用
 *  (?m) 表示所在位置右侧的表示式开启指定多行模式。只有在正则表达式中涉及到多行的“^”和“$”的匹配时，才使用Multiline模式。
 *  (?i:exp)或者(?i)exp(?-i)来指定匹配的有效范围。
 *  组合使用，比如(?is),(?im)
 *
 *  (?<name>exp) 	匹配exp,并捕获文本到名称为name的组里，也可以写成 (?'name'exp)
 *  (?:exp) 	匹配exp,不捕获匹配的文本，也不给此分组分配组号
 *  (?=exp) 	匹配exp前面的位置
 *  (?<=exp) 	匹配exp后面的位置
 *  (?!exp) 	匹配后面跟的不是exp的位置
 *  (?<!exp) 	匹配前面不是exp的位置
 *  (?#comment) 	这种类型的分组不对正则表达式的处理产生任何影响
 *
 *  *? 	重复任意次，但尽可能少重复
 *  +? 	重复1次或更多次，但尽可能少重复
 *  ?? 	重复0次或1次，但尽可能少重复
 *  {n,m}? 	重复n到m次，但尽可能少重复
 *  {n,}? 	重复n次以上，但尽可能少重复
 *
 *
 *
 * 平衡组/递归匹配:
 *  (?'group') 把捕获的内容命名为group,并压入堆栈(Stack)
 *  (?'-group') 从堆栈上弹出最后压入堆栈的名为group的捕获内容，如果堆栈本来为空，则本分组的匹配失败
 *  (?(group)yes|no) 如果堆栈上存在以名为group的捕获内容的话，继续匹配yes部分的表达式，否则继续匹配no部分
 *  (?!) 零宽负向先行断言，由于没有后缀表达式，试图匹配总是失败
 *  我们需要做的是每碰到了左括号，就在压入一个"Open",每碰到一个右括号，就弹出一个，到了最后就看看堆栈是否为空－－如果不为空那就证明左括号比右括号多，那匹配就应该失败。正则表达式引擎会进行回溯(放弃最前面或最后面的一些字符)，尽量使整个表达式得到匹配。
 *  <                         #最外层的左括号
 *     [^<>]*                #最外层的左括号后面的不是括号的内容
 *     (
 *         (
 *             (?'Open'<)    #碰到了左括号，在黑板上写一个"Open"
 *             [^<>]*       #匹配左括号后面的不是括号的内容
 *         )+
 *         (
 *             (?'-Open'>)   #碰到了右括号，擦掉一个"Open"
 *             [^<>]*        #匹配右括号后面不是括号的内容
 *         )+
 *     )*
 *     (?(Open)(?!))         #在遇到最外层的右括号前面，判断黑板上还有没有没擦掉的"Open"；如果还有，则匹配失败
 *  >                         #最外层的右括号
 *  平衡组的一个最常见的应用就是匹配HTML,下面这个例子可以匹配嵌套的<div>标签：  <div[^>]*>[^<>]*(((?'Open'<div[^>]*>)[^<>]*)+((?'-Open'</div>)[^<>]*)+)*(?(Open)(?!))</div>.
 *
 *
 *
 *
 * \C可以被用于匹配单字节， 也就是说在UTF-8模式下，句点可以匹配多字节字符;  "#.*(?<alpha>[a-z]{3})(?'digit'\d{3}).*#";
 *  Character classes
 *  alnum 字母和数字
 *  alpha 字母
 *  ascii 0 - 127的ascii字符
 *  blank 空格和水平制表符
 *  cntrl 控制字符
 *  digit 十进制数(same as \d)
 *  graph 打印字符, 不包括空格
 *  lower 小写字母
 *  print 打印字符,包含空格
 *  punct 打印字符, 不包括字母和数字
 *  space 空白字符 (比\s多垂直制表符)
 *  upper 大写字母
 *  word 单词字符(same as \w)
 *  xdigit 十六进制数字
 *
 *
 *
 *
 *
 *
 * 这是配置指令的简短说明。
 *  pcre.backtrack_limit integer
 *      PCRE的回溯限制.
 *  pcre.recursion_limit integer
 *      PCRE的递归限制. 请注意, 如果 讲这个值设置为一个很大的数字, 你可能会消耗掉所有的进程可用堆栈, 最终导致php崩溃(直到达到系统限制的堆栈大小).
 *  pcre.jit boolean
 *      是否使用 PCRE 的 JIT 编译.
 *
 */



namespace HappyLin\OldPlugin\Test\TextProcessingTest;


use HappyLin\OldPlugin\SingleClass\TextProcessing\PCRE\PCRE;
use HappyLin\OldPlugin\Test\TraitTest;


class PCRETest
{

    use TraitTest;


    public function __construct()
    {
        //$this->PCREModelTest();
        //$this->PCRETest();
    }
    



    /**
     *
     *
        // 参考地址 https://www.cnblogs.com/HKUI/p/3205027.html 以下四个是解释验证子组(子模式);有时需要多个匹配可以在一个正则表达式中选用子组;
        preg_match_all("/(a|b)\d/","b2a1",$res);
        var_dump($res);
        //第一次完整匹配到的内容是b2,所以包括匹配内容b的括号即为其第一个子模式是即为b，第二个子模式由于(a)没有匹配，所以为空
        //第二次完整匹配到a1,其第一个子模式为a,第二次的由于((a)|b)是外层大括号里包含的
        preg_match_all("/((a)|b)\d/","b2a1",$res);
        var_dump($res);
        preg_match_all("/((a)|(b))\d/","b2a1",$res);
        var_dump($res);
        preg_match_all("/(?:(a)|(b))\d/","b2a1",$res);
        var_dump($res);
     *
     * @note 正则函数根据【\A \Z \G \Q \K】匹配模式
     */
    public function PCREModelTest()
    {

        preg_match_all('/[a-z]{3}/m',"abc\ndefg\nhijkl",$res);
        var_dump(static::toStr('m 模式多行匹配 preg_match_all(\'/[a-z]{3}/m\',"abc\ndefg\nhijkl",$res)', $res));

        preg_match_all("/\A[a-z]{3}/m","abc\ndefg\nhijkl",$res);
        var_dump(static::toStr('验证 \A  目标的开始位置(独立于多行模式) preg_match_all("/\A[a-z]{3}/m","abc\ndefg\nhijkl",$res)', $res));

        preg_match_all("/[a-z]{3}\Z/m","abc\ndefg\nhijkl\n",$res);
        var_dump(static::toStr('验证 \Z  目标的结束位置或结束处的换行符(独立于多行模式) preg_match_all("/[a-z]\Z/m","abc\ndefg\nhijkl\n",$res)', $res));

        preg_match_all("/\G[a-z]{3}/","2abc\ndefg\nhijkl\n",$res,0,1);
        var_dump(static::toStr('验证 \G  在目标中首次匹配位置$offset=1;   preg_match_all("/\G[a-z]{3}/","2abc\ndefg\nhijkl\n",$res,0,1);', $res));


        preg_match_all("/\w+\Q.$.\E$/","a.$.",$res);
        var_dump(static::toStr('验证 \Q 和 \E 可以用于在模式中忽略正则表达式元字符; preg_match_all("/\w+\Q.$.\E$/","a.$.",$res)', $res));

        preg_match_all("/(foot)\Kbar/","footbar",$res);
        var_dump(static::toStr('验证 \K 可以用于重置匹配; preg_match_all("/(foot)\Kbar/","footbar",$res);', $res));

        preg_match_all("/p(hp|ython|erl)/","php python perl",$res);
        var_dump(static::toStr('验证可选路径|;  preg_match_all("/p(hp|ython|erl)/","php python perl",$res)', $res));


        //preg_match_all('/te(?# comments)st/',"test",$res);
        preg_match_all("/te# comments\nst/x","test",$res);
        var_dump(static::toStr(
            '注释 ; preg_match_all("/te# comments\nst/x","test",$res) 或者  preg_match_all(\'/te(?# comments)st/\',"test",$res) ',
            $res
        ));


    }


    /**
     * @note 正则函数验证子组(子模式)
     */
    public function PCREModelSubgroupTest()
    {

        preg_match_all("/(\d)/","abc123",$res);
        var_dump(static::toStr('验证子组(子模式)； preg_match_all("/(\d)/","abc123",$res); ', $res));
        var_dump(static::toStr(
            '验证子组(子模式); preg_replace("/(\d)/",\'<font color=red>\1</font>\',"abc12df3sd")'
        ));
        echo preg_replace("/(\d)/",'<font color=red>\1</font>',"abc12df3sd");


        preg_match_all("/.*(?:\d).*([a-z])/U","3df5g",$res);
        var_dump(static::toStr('验证子组(子模式); preg_match_all("/.*(?:\d).*([a-z])/U","3df5g",$res)', $res));
        var_dump(static::toStr(
                '验证子组(子模式); preg_replace("/.*(?:\d).*([a-z])/U",\'<font color=red>\1</font>\',"3df5g")'
        ));
        echo preg_replace("/.*(?:\d).*([a-z])/U",'<font color=red>\1</font>',"3df5g");

        preg_match_all("/.*(?<alpha>[a-z]{3})(?'digit'\d{3}).*/","abc123111def111g",$res);
        var_dump(static::toStr(
            '验证子组(子模式); 子组命名的语法： (?<name>pattern) 和 (?’name’pattern)。不能双引号; 
            preg_match_all("/.*(?<alpha>[a-z]{3})(?\'digit\'\d{3}).*/","abc123111def111g",$res)', $res
        ));


        preg_match_all("/(?:(sat)ur|(sun))day/","sunday saturday",$res);
        var_dump(static::toStr('验证子组(子模式);有时需要多个匹配可以在一个正则表达式中选用子组; preg_match_all("/(?:(sat)ur|(sun))day/","sunday saturday",$res)', $res));


        preg_match_all("/(?|(sat)ur|(sun))day/","sunday saturday",$res);
        var_dump(static::toStr('验证子组(子模式);有时需要多个匹配可以在一个正则表达式中选用子组; preg_match_all("/(?|(sat)ur|(sun))day/","sunday saturday",$res)', $res));


        preg_match_all("/(?>[a-z]+)(?<=abcd)/","234abcdgdfabcd",$res);
        var_dump(static::toStr(
            '一次性子组可以和后瞻断言结合 ; preg_match_all("/(?>[a-z]+)(?<=abcd)/","234abcdgdfabcd",$res)',
            $res
        ));

        preg_match_all("/(?(?=[^a-z]*[a-z])\d{2}-[a-z]{3}-\d{2}|\d{2}-\d{2}-\d{2})/","dd12-aaa-34dd",$res);
        var_dump(static::toStr(
            '条件子组  (?(condition)yes-pattern|no-pattern); preg_match_all("/(?(?=[^a-z]*[a-z])\d{2}-[a-z]{3}-\d{2}|\d{2}-\d{2}-\d{2})/","dd12-aaa-34dd",$res)',
            $res
        ));
    }





    /**
     * @note 正则函数验证后向引用
     */
    public function PCREModelQuoteTest()
    {

        // 如果紧跟反斜线的数字小于 10， 它总是一个后向引用。模式中的捕获数要大于等于后向引用的个数; 后向引用会直接匹配被引用捕获组在目标字符串中实际捕获到的内容， 而不是匹配子组模式的内容
        preg_match_all('/(sens|respons)e and \1ibility/',"sense and sensibility response and responsibility  sense and responsibility",$res);
        var_dump(static::toStr(
            '后向引用; 如果紧跟反斜线的数字小于 10， 它总是一个后向引用。模式中的捕获数要大于等于后向引用的个数;
            preg_match_all(\'/(sens|respons)e and \1ibility/\',"sense and sensibility response and responsibility  sense and responsibility",$res)', $res
        ));


        preg_match_all('/((?i)abc)\s+\1/',"abc abc |ABC ABC  |AbC AbC |abc Abc",$res);
        var_dump(static::toStr(
                '后向引用 会直接匹配被引用捕获组在目标字符串中实际捕获到的内容， 而不是匹配子组模式的内容;
                preg_match_all(\'/((?i)abc)\s+\1/\',"abc abc |ABC ABC  |AbC AbC |abc Abc",$res)', $res)
        );

        preg_match_all('/(a|((bc)))/',"aabcbc",$res);
        var_dump(static::toStr(
            '后向引用 00 ;  后向引用会直接匹配被引用捕获组在目标字符串中实际捕获到的内容， 而不是匹配子组模式的内容;
            preg_match_all(\'/(a|(bc))\',"aabcbc",$res)', $res)
        );


        preg_match_all('/(a|(bc))\1/',"aabcbc",$res);
        var_dump(static::toStr('后向引用 01; preg_match_all(\'/(a|(bc))\1/\',"aabcbc",$res)', $res));


        preg_match_all('/(a|(bc))\2/',"aabcbc",$res);
        var_dump(static::toStr('后向引用 02; preg_match_all(\'/(a|(bc))\2/\',"aabcbc",$res)', $res));





        preg_match_all('/(a|b\1)+/',"abcba",$res);
        var_dump(static::toStr(
            '后向引用; 如果一个后向引用出现在它所引用的子组内部， 它的匹配就会失败; 
                preg_match_all(\'/(a|b\1)+/\',"abcba",$res)',
            $res
        ));



        // \g转义序列可以用于子模式的绝对和相对引用。 这个转义序列必须紧跟一个无符号数字或一个负数， 可以选择性的使用括号对数字进行包裹。  '/([a-z]{3})\1 5/x' === '/([a-z]{3})\g{1}5/';
        // 序列\1， \g1，\g{1} 之间是同义词关系。 这种用法可以消除使用反斜线紧跟数值描述反向引用时候产生的歧义。 这种转义序列有利于区分后向引用和八进制数字字符， 也使得后向引用后面紧跟一个原文匹配数字变的更明了，比如 \g{2}1。
        //  preg_match_all(,"aaaaaa5dfgf",$res); === preg_match_all(,"aaaaaa5dfgf",$res);
        //  \g 转义序列紧跟一个负数代表一个相对的后向引用。比如： (foo)(bar)\g{-1} 可以匹配字符串 ”foobarbar”， (foo)(bar)\g{-2} 可以匹配 ”foobarfoo”。
        preg_match_all('/([a-z]{2})\g{1}5/',"abab5",$res);
        var_dump(static::toStr(
            '后向引用; \g转义序列可以用于子模式的绝对和相对引用。 这个转义序列必须紧跟一个无符号数字或一个负数; 
                preg_match_all(\'/(a|b\1)+/\',"abcba",$res)',
            $res
        ));


        preg_match_all("/(?'alpha'[a-z]{2})(?<digt>[0-9]{3})\k<digt>(?P=alpha)/","aa123123aa",$res);
        var_dump(static::toStr(
            '后向引用; 子组命名的语法方式描述, 比如 (?P=name) 或者 PHP 5.2.2 开始可以实用\k<name> 或 \k’name’。 另外在 PHP 5.2.4 中加入了对\k{name} 和 \g{name} 的支持。; 
                preg_match_all("/(?\'alpha\'[a-z]{2})(?<digt>[0-9]{3})\k<digt>(?P=alpha)/","aa123123aa",$res)',
            $res
        ));

    }




    /**
     * @note 正则函数验证递归模式
     */
    public function PCREModelRecursionTest()
    {

        preg_match_all("/\(((?>[^()]+)|(?R))*\)/","(ab(cd)ef)",$res);
        var_dump(static::toStr(
            '递归模式 (?R) ; preg_match_all("/\(((?>[^()]+)|(?R))*\)/","(ab(cd)ef)",$res);',
            $res
        ));

        preg_match_all("/(sens|respons)e and (?1)ibility/","sense and responsibility",$res);
        var_dump(static::toStr(
            '递归模式 (?R); (?1)、(?2) 等可以用于递归子组。这同样可以用于命名子组： (?P>name) 或 (?P&name); preg_match_all("/\(((?>[^()]+)|(?R))*\)/","(ab(cd)ef)",$res);',
            $res
        ));


        preg_match_all('/a (?<R>\{(?:[^{}]+|(?1))*\})/', "a { b { 1 } c { d { 2 } } }", $m);
        var_dump(static::toStr(
            '递归模式 (?R); preg_match_all(\'/a (?<R>\{(?:[^{}]+|(?1))*\})/\', "a { b { 1 } c { d { 2 } } }", $m);',
            $res
        ));

        preg_match_all('/a (?<R>\{(?:[^{}]+|(?&R))*\})/', "a { b { 1 } c { d { 2 } } }", $m);
        var_dump(static::toStr(
            '递归模式 (?R); preg_match_all(\'/a (?<R>\{(?:[^{}]+|(?&R))*\})/\', "a { b { 1 } c { d { 2 } } }", $m);',
            $res
        ));

    }


    /**
     * @note 正则函数基础字符串操作
     */
    public function PCRETest()
    {
        $pcre = new PCRE();

        $pattern = '/^(\d+)?\.\d+$/';
        $input = [
            1,
            1.0,
            1.1,
            2,
            2.0,
            2.1
        ];
        var_dump(static::toStr('返回匹配模式的数组条目; \'/^(\d+)?\.\d+$/\'筛选一维数组' . json_encode($input), $pcre->pregGrep($pattern,$input)));


        $res = $pcre->pregMatch('/(foo)(bar)(bar)*(baz)/', 'erwefoobarbaz', $matches);
        var_dump(static::toStr('preg_match() 只匹配一次；默认配置下$pcre->pregMatch(\'/(foo)(bar)(bar)*(baz)/\', \'erwefoobarbaz\', $matches); ' . $res, $matches));


        $res = $pcre->pregMatch('/(foo)(bar)(bar)*(baz)/', 'erwefoobarbaz', $matches, PREG_OFFSET_CAPTURE | PREG_UNMATCHED_AS_NULL);
        var_dump(static::toStr('preg_match() 添加配置参数$flags: PREG_OFFSET_CAPTURE | PREG_UNMATCHED_AS_NULL; ' . $res, $matches));



        $res = $pcre->pregMatchAll("|<[^>]+>(.*)</[^>]+>|U", "<b>example: </b><div align=left>this is a test</div>", $matches);
        var_dump(static::toStr('preg_match_all() 完整匹配次数；默认排序 PREG_PATTERN_ORDER； $pcre->pregMatchAll("|<[^>]+>(.*)</[^>]+>|U", "<b>example: </b><div align=left>this is a test</div>", $matches); ' . $res, $matches));



        $res = $pcre->pregMatchAll("|<[^>]+>(.*)</[^>]+>|U", "<b>example: </b><div align=left>this is a test</div>", $matches, PREG_SET_ORDER);
        var_dump(static::toStr('preg_match_all() 添加配置参数$flags: PREG_SET_ORDER' . $res, $matches));


        $res = $pcre->pregMatchAll("/(\w+) (\d+), (\d+)/i", "April 15, 2003", $matches);
        var_dump(static::toStr('preg_replace() pattern 和 replacement 和 subject字符串搜索和替换; $pcre->pregMatchAll("/(\w+) (\d+), (\d+)/i", "April 15, 2003", $matches);' . $res, $matches));

        $res = preg_replace("/(\w+) (\d+), (\d+)/i", '${1}1,$3', "April 15, 2003");
        var_dump(static::toStr('preg_replace() pattern字符串 和 replacement字符串 搜索和替换; preg_replace("/(\w+) (\d+), (\d+)/i", \'${1}1,$3\', "April 15, 2003");' . "\n {$res}"));



        $string = 'The quick brown fox jumps over the lazy dog.and so on';
        $patterns = array();
        $patterns[0] = '/quick/';
        $patterns[1] = '/brown/';
        $patterns[2] = '/fox/';
        $patterns[3] = '/and so on/';
        $replacements = array();
        $replacements[2] = 'bear';
        $replacements[1] = 'black';
        $replacements[0] = 'slow';

        $res = $pcre->pregReplace($patterns, $replacements, $string);
        var_dump(static::toStr('preg_replace() pattern数组 和 replacement数组 搜索和替换; $pcre->pregReplace(' . var_export($patterns, true) . ', ' . var_export($replacements,true) . ', '. $string ."); \n 结果:" . "{$res}"));


        ksort($patterns);
        ksort($replacements);
        var_dump(static::toStr('preg_replace() pattern数组 和 replacement数组 搜索和替换; $pcre->pregReplace(' . var_export($patterns, true) . ', ' . var_export($replacements,true) . ', '. $string ."); \n 结果:" . "{$res}"));


        $string = '{startDate} = 1999-5-27';
        $patterns = array ('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/',
            '/^\s*{(\w+)}\s*=/');
        $replacement = array ('\3/\4/\1\2', '$\1 =');
        $res = $pcre->pregReplace($patterns, $replacement, $string);
        var_dump(static::toStr('preg_replace() pattern数组 和 replacement数组 搜索和替换; $pcre->pregReplace(' . var_export($patterns, true) . ', ' . var_export($replacement,true) . ', '. $string ."); \n 结果:" . "{$res}"));




        $string = 'xp 2 456to';
        $patterns = array('/\d/', '/\s/');
        $replacement = '*';
        $res = $pcre->pregReplace($patterns, $replacement, $string, 3 , $count);
        var_dump(static::toStr('preg_replace() pattern数组 和 replacement字符串 搜索和替换; 使用参数 count 完成的替换次数; $pcre->pregReplace(' . var_export($patterns, true) . ', ' . var_export($replacement,true) . ', '. $string . ", 3, \$count); \n结果:" . "{$res}; 匹配次数$count (数字三次，空格两次)"));


        $res = $pcre->pregSplit("/[\s,]+/", "hypertext language,programming");
        var_dump(static::toStr('preg_split() 分隔字符串; $pcre->pregSplit("/[\s,]+/", "hypertext language,programming")', $res));



        $content = '
                    <strong>Lorem ipsum dolor</strong>
                       sit
                    <img src="test.png" />
                    amet
                    <span class="test" style="color:red">
                        consec
                        <i>tet</i>
                        uer
                    </span>';

        $contentFiltered = $pcre->pregReplace('/\s/', '',$content);

        $res = $pcre->pregMatchAll("/(<[^>]*[^\/]>)/i", $contentFiltered, $matches);
        var_dump(static::toStr("preg_split() 分隔字符串 00; 查看分隔符匹配结果 \n\$pcre->pregMatchAll(\"/(<[^>]*[^\/]>)/i\", $content, \$matches);\n 结果", $matches));

        $res = $pcre->pregSplit('/(<[^>]*[^\/]>)/i', $contentFiltered);
        var_dump(static::toStr('preg_split() 分隔字符串 01; $pcre->pregSplit(\'/(<[^>]*[^\/]>)/i\', $contentFiltered)', $res));


        $res = $pcre->pregSplit('/(<[^>]*[^\/]>)/i', $contentFiltered, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        var_dump(static::toStr("preg_split() 分隔字符串 02; 添加配置参数\$flags: PREG_SPLIT_NO_EMPTY（去除空部分） | PREG_SPLIT_DELIM_CAPTURE(括号表达式的捕获) \n \$pcre->pregSplit('/(<[^>]*[^\/]>)/i', \$contentFiltered, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE)", $res));




        $format = <<<SQL
CREATE DATABASE IF NOT EXISTS :database;
GRANT ALL PRIVILEGES ON :database_name.* TO ':user'@':host';
SET PASSWORD = PASSWORD(':pass');
SQL;
        $args = ["database"=>"people", "user"=>"staff", "pass"=>"pass123", "host"=>"localhost"];
        $res =  $pcre->pregReplaceCallback("/:(\w+)/", function ($matches) use ($args) {
            return @$args[$matches[1]] ?: $matches[0];
        }, $format);



        var_dump(static::toStr(
            "preg_replace_callback() 回调替换; \n\$pcre->pregReplaceCallback(\"/:(\w+)/\", function (\$matches) use (\$args = " . json_encode($args) . ") {
            return @\$args[\$matches[1]] ?: \$matches[0];
        }, " . var_export($format, true) . "); \n\n结果：",
            $res
        ));



        $res = preg_replace ("/" . preg_quote("*very*", '/') . "/","<i>*very*</i>","This book is *very* difficult to find.");
        var_dump(static::toStr(
            "preg_quote() 转义正则表达式字符;\n preg_replace (\"/\" . preg_quote(\"*very*\", \'/\') . \"/\",\"<i>*very*</i>\",\"This book is *very* difficult to find.\") \n结果",
            $res
        ));


        var_dump(static::toStr(
            "返回最后一个PCRE正则执行产生的错误代",
            $pcre->pregLastError() . ':' . $pcre->pregLastErrorMsg()
        ));




        // 完全可以被preg_replace_callback替换
//        $subject = 'Aaaaaa Bbb';
//        $pcre->pregReplaceCallbackArray(
//            [
//                '~[a]+~i' => function ($match) {
//                    echo strlen($match[0]), ' matches for "a" found', PHP_EOL;
//                },
//                '~[b]+~i' => function ($match) {
//                    echo strlen($match[0]), ' matches for "b" found', PHP_EOL;
//                }
//            ],
//            $subject
//        );



//        preg_match_all(
//            '/(?J)(?<match>foo)|(?<match>bar)/',
//            'foo bar',
//            $matches,
//            PREG_PATTERN_ORDER
//        );
//        var_dump($matches);



    }
















}



