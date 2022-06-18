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
 *  平衡组的一个最常见的应用就是匹配HTML,下面这个例子可以匹配嵌套的<div>标签：<div[^>]*>[^<>]*(((?'Open'<div[^>]*>)[^<>]*)+((?'-Open'</div>)[^<>]*)+)*(?(Open)(?!))</div>.
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
 *
 */

namespace HappyLin\OldPlugin\SingleClass\TextProcessing\PCRE;


class PCRE
{

    /**
     * 返回给定数组input中与模式pattern 匹配的元素组成的数组.
     *
     * @param string $pattern 要搜索的模式, 字符串形式.
     * @param array $input 输入数组.
     * @param int $flags 如果设置为PREG_GREP_INVERT (1), 这个函数返回输入数组中与给定模式pattern不匹配的元素组成的数组.
     * @return array 返回使用input中key做索引的数组.
     */
    public function pregGrep( string $pattern, array $input, int $flags = 0 )
    {
        return preg_grep( $pattern, $input, $flags);
    }


    /**
     * 执行匹配正则表达式
     *
     * 搜索subject与pattern给定的正则表达式的一个匹配.
     * preg_match()返回 pattern 的匹配次数。它的值将是0次（不匹配）或1次，因为preg_match()在第一次匹配后将会停止搜索。
     * preg_match_all()不同于此，它会一直搜索subject 直到到达结尾。如果发生错误preg_match()返回 FALSE。
     *
     * $flags
     *  PREG_OFFSET_CAPTURE  改变填充到matches参数的数组，使其每个元素成为一个由第0个元素是匹配到的字符串，第1个元素是该匹配字符串在目标字符串subject中的偏移量。的长度为2的数组
     *  PREG_UNMATCHED_AS_NULL  使用该标记，未匹配的子组会报告为 NULL；未使用时，报告为空的 string。
     *
     * $offset
     *  使用offset参数不同于向preg_match() 传递按照位置通过substr($subject, $offset)截取目标字符串结果，因为pattern可以包含断言比如^， $ 或者(?<=x)。
     *  要避免使用 substr()，可以用 \G 断言而不是 ^ 锚，或者 A 修改器，它们都能和 offset 参数一起运行。
     *
     * @param string $pattern 要搜索的模式，字符串类型。
     * @param string $subject 输入字符串。
     * @param array $matches 如果提供了参数matches，它将被填充为搜索结果。 $matches[0]将包含完整模式匹配到的文本， $matches[1] 将包含第一个捕获子组匹配到的文本，以此类推。
     * @param int $flags 标记值的组合： PREG_OFFSET_CAPTURE PREG_UNMATCHED_AS_NULL
     * @param int $offset 通常，搜索从目标字符串的开始位置开始。可选参数 offset 用于指定从目标字符串的某个位置开始搜索(单位是字节)。
     * @return int
     */
    public function pregMatch( string $pattern, string $subject, array &$matches = null, int $flags = 0, int $offset = 0 ): int
    {
        return preg_match($pattern, $subject, $matches, $flags,  $offset);
    }


    /**
     * 执行一个全局正则表达式匹配
     *
     * 搜索subject与pattern给定的正则表达式的一个匹配.
     *
     * $flags
     *  PREG_PATTERN_ORDER      结果排序为$matches[0]保存完整模式的所有匹配, $matches[1] 保存第一个子组的所有匹配，以此类推。
     *  PREG_SET_ORDER          结果排序为$matches[0]包含第一次匹配得到的所有匹配(包含子组)， $matches[1]是包含第二次匹配到的所有匹配(包含子组)的数组，以此类推。
     *  PREG_OFFSET_CAPTURE     改变matches中的每一个匹配结果字符串元素，使其成为一个第0个元素为匹配结果字符串，第1个元素为匹配结果字符串在subject中的偏移量。
     *  PREG_UNMATCHED_AS_NULL  使用该标记，未匹配的子组会报告为 NULL；未使用时，报告为空的 string。
     *
     *
     * @param string $pattern 要搜索的模式，字符串类型。
     * @param string $subject 输入字符串。
     * @param array $matches 多维数组，作为输出参数输出所有匹配结果, 数组排序通过flags指定。
     * @param int $flags 标记值的组合(注意不能同时使用PREG_PATTERN_ORDER和 PREG_SET_ORDER)： PREG_OFFSET_CAPTURE PREG_UNMATCHED_AS_NULL
     * @param int $offset 通常， 查找时从目标字符串的开始位置开始。可选参数offset用于从目标字符串中指定位置开始搜索(单位是字节)。
     * @return int 返回完整匹配次数（可能是0），或者如果发生错误返回FALSE。
     */
    public function pregMatchAll( string $pattern, string $subject, array &$matches, int $flags = PREG_PATTERN_ORDER, int $offset = 0 ): int
    {
        return preg_match_all( $pattern, $subject,$matches, $flags, $offset);
    }




    /**
     * 执行一个正则表达式的搜索和替换
     *
     *
     * $replacement
     *  如果 pattern 是一个数组，replacement是一个字符串，并且 那么所有的模式都使用这个字符串进行替换。
     *  如果 pattern 和 replacement 都是数组，每个 pattern 使用 replacement 中对应的元素进行替换。
     *  如果 replacement 中的元素比 pattern 中的少，多出来的 pattern 使用空字符串进行替换。
     *
     *  replacement 中可以包含后向引用 \\n 或 $n，语法上首选后者。 每个这样的引用将被匹配到的第 n 个捕获子组捕获到的文本替换。 n 可以是0-99，\\0 和 $0 代表完整的模式匹配文本。捕获子组的序号计数方式为：代表捕获子组的左括号从左到右， 从1开始数。
     *      当在替换模式下工作并且后向引用后面紧跟着需要是另外一个数字;\\11将会使preg_replace() 不能理解你希望的是一个 \\1 后向引用紧跟一个原文 1，还是一个 \\11 后向引用后面不跟任何东西。
     *      解决方案是使用 ${1}1
     *  当使用被弃用的 e 修饰符时, 这个函数会转义一些字符 (即：'、"、 \ 和 NULL) 然后进行后向引用替换。
     *
     * @param mixed $pattern 要搜索的模式。可以是一个字符串或字符串数组。
     * @param mixed $replacement  用于替换的字符串或字符串数组。
     * @param mixed $subject 要进行搜索和替换的字符串或字符串数组。 如果 subject 是一个数组，搜索和替换回在 subject 的每一个元素上进行, 并且返回值也会是一个数组。
     * @param int $limit 每个模式在每个 subject 上进行替换的最大次数。默认是 -1(无限)。
     * @param int $count 如果指定，将会被填充为完成的替换次数。
     * @return mixed 如果 subject 是一个数组，preg_replace() 返回一个数组，其他情况下返回一个字符串。如果匹配被查找到，替换后的 subject 被返回；如果发生错误，返回 NULL 。
     */
    public function pregReplace( $pattern, $replacement, $subject, int $limit = -1, int &$count = null)
    {

        return preg_replace($pattern, $replacement, $subject, $limit,$count);
    }


    /**
     * 执行一个正则表达式搜索并且使用一个回调进行替换
     * 这个函数的行为除了可以指定一个 callback 替代 replacement 进行替换字符串的计算，其他方面等同于 preg_replace()。
     *
     * @param mixed $pattern 要搜索的模式，可以是字符串或一个字符串数组。
     * @param callable $callback 一个回调函数，在每次需要替换时调用，调用时函数得到的参数是从 subject 中匹配到的结果。回调函数返回真正参与替换的字符串。这是该回调函数的签名： handler( array $matches) : string
     * @param mixed $subject 要搜索替换的目标字符串或字符串数组。
     * @param int $limit 对于每个模式用于每个 subject 字符串的最大可替换次数。默认是 -1（无限制）。
     * @param int $count 如果指定，这个变量将被填充为替换执行的次数。
     * @return mixed
     */
    public function pregReplaceCallback($pattern, callable $callback, $subject, int $limit = -1, int &$count = null )
    {
        return preg_replace_callback( $pattern, $callback, $subject, $limit, $count);
    }


    /**
     * 使用回调执行正则表达式搜索和替换
     * 此函数的行为类似于preg_replace_callback（），只是回调是基于每个模式执行的。
     *
     *
     *
     * @param array $patterns_and_callbacks 将模式（键）映射到可调用对象（值）的关联数组。
     * @param mixed $subjec 要搜索和替换的字符串或带有字符串的数组。
     * @param int $limit 每个主题字符串中每个模式的最大可能替换。 默认为 -1（无限制）。
     * @param int $count 如果指定，此变量将填充完成的替换次数。
     * @param int $flags 标志可以是 PREG_OFFSET_CAPTURE 和 PREG_UNMATCHED_AS_NULL 标志的组合，这会影响匹配数组的格式。有关更多详细信息，请参阅 preg_match() 中的说明。
     * @return mixed
     */
    public function pregReplaceCallbackArray( array $patterns_and_callbacks, $subjec, int $limit = -1, int &$count = null, int $flags = 0 )
    {
        if(version_compare(  PHP_VERSION, '7.4.0', '>=')){
            return preg_replace_callback_array( $patterns_and_callbacks, $subjec, $limit, $count, $flags );
        }
        return preg_replace_callback_array( $patterns_and_callbacks, $subjec, $limit, $count );
    }




    /**
     * 通过一个正则表达式分隔给定字符串.
     *
     * $flags
     *  PREG_SPLIT_NO_EMPTY         如果这个标记被设置， preg_split() 将仅返回分隔后的非空部分。
     *  PREG_SPLIT_DELIM_CAPTURE    如果这个标记设置了，用于分隔的模式中的括号表达式将被捕获并返回。
     *  PREG_SPLIT_OFFSET_CAPTURE
     *      如果这个标记被设置, 对于每一个出现的匹配返回时将会附加字符串偏移量. 注意：这将会改变返回数组中的每一个元素, 使其每个元素成为一个由第0 个元素为分隔后的子串，第1个元素为该子串在subject 中的偏移量组成的数组。
     *
     * @param string $pattern 用于搜索的模式，字符串形式。
     * @param string $subject 输入字符串
     * @param int $limit 如果指定，将限制分隔得到的子串最多只有limit个，返回的最后一个子串将包含所有剩余部分。limit值为-1， 0或null时都代表"不限制"。
     * @param int $flags 组合(以位或运算 | 组合)： PREG_SPLIT_NO_EMPTY  PREG_SPLIT_DELIM_CAPTURE PREG_SPLIT_OFFSET_CAPTURE
     * @return array
     */
    public function pregSplit( string $pattern, string $subject, int $limit = -1, int $flags = 0) : array
    {
        return preg_split( $pattern, $subject, $limit, $flags);
    }



    /**
     * 转义正则表达式字符
     *
     * 需要参数 str 并向其中每个正则表达式语法中的字符前增加一个反斜线。
     * 这通常用于你有一些运行时字符串需要作为正则表达式进行匹配的时候。
     *
     * 注意：preg_quote() 的应用场景不是用于 preg_replace() 的 $replacement 字符串参数。
     *
     * @param string $str 输入字符串
     * @param string $delimiter 如果指定了可选参数 delimiter，它也会被转义。这通常用于转义PCRE函数使用的分隔符。 / 是最常见的分隔符。
     * @return string 返回转义后的字符串。
     */
    public function pregQuote( string $str, string $delimiter = NULL ) : string
    {
        return preg_quote($str, $delimiter);
    }


    /**
     * 返回最后一个PCRE正则执行产生的错误代码
     *
     *  PREG_NO_ERROR                                           没有匹配错误时
     *  PREG_INTERNAL_ERROR                                     如果有 PCRE 内部错误时
     *  PREG_BACKTRACK_LIMIT_ERROR （参见 pcre.backtrack_limit） 如果调用回溯限制超出，
     *  PREG_RECURSION_LIMIT_ERROR （参见 pcre.recursion_limit） 如果递归限制超出
     *  PREG_BAD_UTF8_ERROR                                     如果最后一个错误时由于异常的utf-8数据(仅在运行在 UTF-8 模式正则表达式下可用)。导致的，
     *  PREG_BAD_UTF8_OFFSET_ERROR （自 PHP 5.3.0 起）           如果偏移量与合法的 UTF-8 代码不匹配(仅在运行在 UTF-8 模式正则表达式下可用)。
     *  PREG_JIT_STACKLIMIT_ERROR (自 PHP 7.0.0 起)              当 PCRE 函数因 JIT 栈空间限制而失败，preg_last_error() 就会返回此常量。
     *
     * @return int
     */
    public function pregLastError() : int
    {
        return preg_last_error();
    }


    /**
     * 返回上次执行PCRE正则表达式的错误消息。
     *
     * @return string 成功时返回错误消息，如果未发生错误，则返回“无错误”。
     */
    public function pregLastErrorMsg() : string
    {
        return \preg_last_error_msg();
    }








    public function shortcutTable()
    {

        $str=<<<E
<tr>
    <tr><td id="data">A</td></tr>
    <td head="data">a</td>
    <td head="data">b</td>
</tr>
//----------第一部分分割符------------
<tr>
    <tr><td id="data">B</td></tr>
    <td head="data">a1</td>
    <td head="data">b2</td>
</tr>
<tr>
<td head="data">a2</td>
<td head="data">b2</td>
</tr>
<tr>
<td head="data">a3</td>
<td head="data">b3</td>
</tr>
<tr>
<td head="data">a4</td>
<td head="data">b4</td>
</tr>
//------------第二部分分割--------
<tr>
    <tr><td id="data">C</td></tr>
    <td head="data">a5</td>
    <td head="data">b5</td>
</tr>
<tr>
<td head="data">a6</td>
<td head="data">b6</td>
</tr>
<tr>
<td head="data">a7</td>
<td head="data">b7</td>
</tr>
E;
        $p='#
<tr>\s*
<tr>\s*
<td \s* id="data">([^<>]*)</td>\s*
</tr>\s*
<td [^<>]*>([^<>]*)</td>\s*
<td [^<>]*>([^<>]*)</td>\s*
</tr>\s*
(?:<tr>\s*
<td [^<>]*>([^<>]*)</td>\s*
<td [^<>]*>([^<>]*)</td>\s*
</tr>\s*){0,}#xs';
        preg_match_all($p, $str, $re);
        var_dump($re);

    }


}







