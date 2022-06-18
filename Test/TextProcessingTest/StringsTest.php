<?php
/**
 *
 *
 */



namespace HappyLin\OldPlugin\Test\TextProcessingTest;


use HappyLin\OldPlugin\SingleClass\TextProcessing\Strings\Strings;
use HappyLin\OldPlugin\SingleClass\Url;
use HappyLin\OldPlugin\Test\TraitTest;
use HappyLin\OldPlugin\SingleClass\TextProcessing\Strings\Traits\Str;
use Symfony\Component\HttpKernel\EventListener\ValidateRequestListener;


class StringsTest
{

    use TraitTest;
    use Str;


    public $fileSaveDir;

    public function __construct()
    {
        $this->fileSaveDir = static::getTestDir() . '/Public/SingleClass';

//        $fileName = $this->fileSaveDir . '/download.txt';
//        $file = \HappyLin\OldPlugin\SingleClass\SPL\FileHandling\Shortcut\FileObject::getInstance($fileName,'write');
//        $file->add(print_r($_SERVER, true) . PHP_EOL);
    }


    /**
     * @note 字符操作函数 杂项
     */
    public function stringsTest()
    {
        $filename = $this->fileSaveDir . '/test.txt';

        var_dump(static::toStr('字符输出； 语言结构 echo( string $arg1[, string $...] ) : void；  print( string $arg) : int 1;  vprintf( string $format, array $args) : int 与 printf() 函数类似，但是接收一个数组参数') );

        var_dump(static::toStr('获取字符串长度', Strings::strlen("abcd")));
        var_dump(static::toStr('获取字符串子字符串', Strings::substr("abcdef", 0, -1)));


        var_dump(static::toStr('添加字符； 使用另一个字符串填充字符串为指定长度', Strings::strPad("abcd", 10, '-=', STR_PAD_BOTH)));
        var_dump(static::toStr('添加字符； 重复一个字符串', Strings::strRepeat("abcd ", 3)));
        var_dump(static::toStr('添加字符； 将字符串按长度分割成小块（添加特定字符）； 不支持多字节', Strings::chunkSplit("abcdefg", 3, '|')));
        var_dump(static::toStr('添加字符； 将字符串按长度分割成小块（添加特定字符）； 不支持多字节; 多了个单词分割参数', Strings::wordwrap("a 你我他 c defg", 2, '|',false)));

        var_dump(static::toStr('删除字符串开头的空白字符或其他字符"; "\t\x09Hello World\x0A\t" 去除空白 ', Strings::ltrim("\t\x09Hello World\x0A\t", " \t\n\r\0\x0B")));
        var_dump(static::toStr('删除字符串开头的空白字符或其他字符"; "\x09\tHello World\t\x0A" 去除 World\x0A\t ', Strings::rtrim("\t\x09Hello World\x0A\t", 'World' ."\x0A\t")));
        var_dump(static::toStr('删除字符串开头的空白字符（或其他字符）"\x09\tHello World\t\x0A" 去除任何非图形非ASCII字符 ', Strings::trim("\t\x09Hello World\x0A\t", "\x7f..\xff\x0..\x1f")));



        var_dump(static::toStr('更新字符串的第一个字符小写', Strings::lcfirst("Hello World")));
        var_dump(static::toStr('更新字符串的第一个字符大写', Strings::ucfirst("hello world")));
        var_dump(static::toStr('更新字符串紧跟在 delimiters 参数之后的子字符串首字母大写, 附加了逗号', Strings::ucwords("hello world a,b,c",  " \t\r\n\f\v,")));

        var_dump(static::toStr('更新字符串转化为小写', Strings::strtolower("HELLO WORLD")));
        var_dump(static::toStr('更新字符串转化为大写', Strings::strtoupper("hello world")));

        var_dump(static::toStr('更新字符串,替换字符串;三个参数都是(string|array)!!! str_replace() array("\r\n", "\n", "\r") ->"-->"  '. PHP_EOL, $replaceStr = Strings::strReplace(array("\r\n", "\n", "\r"),"-->","Line One\nLine Two\rLine Three\r\nLine Four\n")));

        var_dump(static::toStr('更新字符串,替换字符串; 上面str_replace() 的忽略大小写版本; array("f", "t", "o")-->array("f", "t", "o") '. PHP_EOL, Strings::strIreplace(array("f", "t", "o"),array("f", "t", "o"),$replaceStr)));

        $input = array('A: XXX', 'B: XXX', 'C: XXX');
        //var_dump(substr_replace($input, 'YYY', 3, 3));
        $replace = array('AAA', 'BBB', 'CCC');
        //var_dump(substr_replace($input, $replace, 3, 3));
        $length = array(1, 2, 3);
        //var_dump(substr_replace($input, $replace, 3, $length));
        $offset = array(2,3,4);
        //var_dump(substr_replace($input, $replace, $offset, $length));

        var_dump(static::toStr('更新字符串,替换字符串;四个参数都是(string|array)!!! ; array("f", "t", "o")-->array("f", "t", "o") ', Strings::substrReplace($input, $replace, $offset, $length)));

        var_dump(static::toStr('更新字符串,替换字符串;  array("\r\n" => \'\', "\n"=> \'\', "\r"=> \'\') '. PHP_EOL, Strings::strtr("Line One\nLine Two\rLine Three\r\nLine Four\n",array("\r\n" => '', "\n"=> '', "\r"=> ''))));

        var_dump(static::toStr('更新字符串,替换字节一一对应的字符集;  "\r\n" => "  " '. PHP_EOL, Strings::strtr("Line One\nLine Two\rLine Three\r\nLine Four\n","\r\n","  ")));

        var_dump(static::toStr('更新字符串(替换\n)在 string 所有新行之前插入 \'<br />\' 或 \'<br>\';("foo isn\'t\n bar")=>', Strings::nl2br("foo isn't\n bar")));

        var_dump(static::toStr('查找字符串首次出现的位置', Strings::strpos('Aabcd ABCD', 'AB', 0)));
        var_dump(static::toStr('查找字符串首次出现的位置（不区分大小写）', Strings::stripos('Aabcd ABCD', 'A', 0)));

        var_dump(static::toStr('查找字符串在目标字符串中最后一次出现的位置', Strings::strrpos('Aabcd ABCD', 'AB', 0)));
        var_dump(static::toStr('查找字符串在目标字符串中最后一次出现的位置（不区分大小写）', Strings::strripos('Aabcd ABCD', 'A', 0)));

        var_dump(static::toStr('查找字符串首次出现的位置, 但返回之后（之前）字符串', Strings::strstr('Aabcd ABCD', 'AB', true)));
        var_dump(static::toStr('查找字符串首次出现的位置, 但返回之后（之前）字符串（不区分大小写）', Strings::stristr('Aabcd ABCD', 'A', false)));

        var_dump(static::toStr('查找字符串中某字符首次出现在 $characters 字符集中的位置, 但返回之后字符串', Strings::strpbrk('Aabcd ABCD', 'Bc')));

        var_dump(static::toStr('查找统计，从 $start 开始算；所有字符连续不存在于 $characters 字符集中的字符串的长度； strcspn', Strings::strcspn('hello', 'worled', 0, -1)));

        var_dump(static::toStr('查找统计，从 $start 开始算；所有字符连续存在于 $characters 字符集中的字符串的长度； strspn', Strings::strspn('hello', 'worled', 0, -1)));

        var_dump(static::toStr('查找统计 string 中每个字节值（0..255）出现的次数 或 使用的字符 或未使用的字符', Strings::countChars("Two Ts and one F.",1)));

        var_dump(static::toStr('查找统计 string 中子字符串出现的次数', Strings::substrCount('This is a test','is',1, 6)));

        var_dump(static::toStr('查找统计 字符串中单词的使用情况; "Hello fri3nd,you\'re\n\tlooking\t\tgood today!" =>', Strings::strWordCount("Hello fri3nd,you're\n\tlooking\t\tgood today!", 1, 'àá??3')));


        var_dump(static::toStr('排序反转字符串.逆向排序', Strings::strrev("abcd")));
        var_dump(static::toStr('排序随机打乱一个字符串', Strings::strShuffle("abcdefg")));

        var_dump(static::toStr('比较字符串;strcoll() 基于区域设置的字符串比较;', Strings::strcoll("abcdefg",'Abcdefg')));

        var_dump(static::toStr('比较字符串;substr_compare() 如果 main_str 从偏移位置 offset 起的子字符串小于 str，则返回小于 0 的数；如果大于 str，则返回大于 0 的数；如果二者相等，则返回 0。', Strings::substrCompare("abcdefg",'bcDefg', 1,2)));

        var_dump(static::toStr('比较字符串;strcmp() 二进制安全;  如果 str1 < str2 返回 < 0；如果 str1 > str2 返回 > 0；两者相等返回 0', Strings::strcmp("abcdefg",'Abcdefg')));
        var_dump(static::toStr('比较字符串;strcasecmp() 二进制安全;  与上面对比，不区分大小写', Strings::strcasecmp("abcdefg",'Abcdefg')));

        var_dump(static::toStr('比较字符串;strncmp() 二进制安全; 指定两个字符串比较时使用的长度; 如果 str1 < str2 返回 < 0；如果 str1 > str2 返回 > 0；两者相等返回 0', Strings::strncmp("abcdefg",'Abcdefg',4)));
        var_dump(static::toStr('比较字符串;strncasecmp() 二进制安全; 指定两个字符串比较时使用的长度;  与上面对比，不区分大小写', Strings::strncasecmp("abcdefg",'Abcdefg',4)));

        var_dump(static::toStr('比较字符串;strnatcmp() 使用自然排序算法;  如果 str1 < str2 返回 < 0；如果 str1 > str2 返回 > 0；两者相等返回 0', Strings::strnatcmp("abcdefg",'Abcdefg')));
        var_dump(static::toStr('比较字符串;strnatcasecmp() 使用自然排序算法;  与上面对比，不区分大小写', Strings::strnatcasecmp("abcdefg",'Abcdefg')));

        var_dump(static::toStr('分割字符串按标记集，一次只分割一段;  strtok("This is\tan example\nstring", " \n\t") '));
        $tok = Strings::strtok("This is\tan example\nstring", " \n\t");
        while ($tok !== false) {
            echo "$tok<br />";
            $tok = Strings::strtok(" \n\t");
        }

        var_dump(static::toStr('分割字符串转换为数组; 不支持多字节', Strings::strSplit("abcdefg", 3)));

        var_dump(static::toStr('分割字符串按特定字符 delimiter 作为边界点分割；返回由字符串组成的 array', Strings::explode(' ', 'a b c d e f g', 3)));

        var_dump(static::toStr('将一个一维数组的值按特定字符 delimiter 作为边界点转化为字符串', Strings::implode(" ", Strings::explode(' ', 'a b c d e f g', 3))));

    }




    /**
     * @note 字符串进制转换
     */
    public function stringsBinConversionTest()
    {

        var_dump(static::toStr('把包含数据的二进制字符串转换为十六进制值', Strings::bin2hex("d'NULL'das")));

        var_dump(static::toStr('把包含数据的十六进制字符串转换为二进制值 (数字使用base_convert())', Strings::bin2hex("d'NULL'das")));



    }




    /**
     * @note 字符串解析（指定格式解析和分割）
     */
    public function stringsEscapeStringTest()
    {
        $urlVars = [];
        Strings::parseStr("first=value&arr[]=foo+bar&arr[]=baz", $urlVars);
        var_dump(static::toStr('将字符串解析成多个变量;解析 parse_url($url)[query]用  ；', $urlVars));

        var_dump(static::toStr('numberFormat()格式化一个数字;以千位分隔符方式', Strings::numberFormat(1234.5678, 2, '.', ',')));

        // 原始字符 The tree contains -5 monkeys;
        $num = -5.01123;
        $location = 'tree';
        var_dump(
            static::toStr('
            sprintf()【printf():int 直接输出】【vsprintf()接收一个数组参数】格式化的字符串;  Strings::sprintf("The %2\$\'~-8.3s contains %1$\'0-+4.2f monkeys",$num,$location)',
                Strings::sprintf(
                    "The %2\$'~-8.3s contains %1$'0-+4.2f monkeys",
                    $num,
                    $location
                )
            )
        );

        var_dump(static::toStr('根据指定格式解析输入的字符; The tr~~~~~~ contains -5.01 monkeys; ', Strings::sscanf("The tr~~~~~~ contains -5.01 monkeys", "The %2s~~~~~~ contains %6f monkeys")));


    }


    /**
     * @note 字符注释（加上反斜线）；
     */
    public function stringsEscapeCharacterTest()
    {


        var_dump(static::toStr('字符前都加上了反斜线; 特定ASCII码范围内的字符, addcslashes() \'abcdefg \n ABCDEFG\'', $addcslashes = Strings::addcslashes('abcdefg \n ABCDEFG', "b..e!@B..E")));

        var_dump(static::toStr('反引用一个使用 addcslashes() 转义的字符串 ', Strings::stripcslashes($addcslashes)));

        var_dump(static::toStr('字符前都加上了反斜线; 转义单引号（\'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）', Strings::addslashes("d'NULL'das")));

        var_dump(static::toStr('反引用一个引用字符串 -（\\\' 转换为 \' 等等）。双反斜线（\\\\）被转换为单个反斜线（\）。', Strings::stripslashes(Strings::addslashes("d'NULL'das"))));




    }



    /**
     * @note 字符串加密和转码
     */
    public function encryptionTest()
    {

        $filename = $this->fileSaveDir . '/test.txt';

        var_dump(static::toStr('crc32；生成str的32位循环冗余校验码多项式。这通常用于检查传输的数据是否完整。使用 hash("crc32b", $str) 代替', Strings::crc32("The quick brown fox jumped over the lazy dog.")));

        var_dump(static::toStr("crypt() 返回一个基于标准 UNIX DES 算法；可用来自动生成盐值；密码验证推荐使用password_hash()\n", Strings::crypt('user_password',Strings::crypt('my_salt'))));


        var_dump(static::toStr("md5_file() 计算指定文件的 MD5 散列值", Strings::md5File($filename,false)));
        var_dump(static::toStr("md5() 计算字符串的 MD5 散列值", Strings::md5('Hello World',false)));


        var_dump(static::toStr("sha1_file() 计算文件的 sha1 散列值", Strings::sha1File($filename,false)));
        var_dump(static::toStr("sha1() 计算字符串的 sha1 散列值", Strings::sha1('Hello World',false)));




        var_dump(static::toStr('返回相转换字符串第一个字节为 0-255 之间的值。', Strings::ord('~')));
        var_dump(static::toStr('返回相对应于 ascii 所指定的单个字符。', Strings::chr(Strings::ord('~'))));


        var_dump(static::toStr('str_rot13() 编码简单地使用字母表中后面第 13 个字母替换当前字母;编码和解码都使用相同的函数', Strings::strRot13(str_rot13('PHP 7.2.0'))));


        $uuencode = Strings::convertUuencode("test text text");
        var_dump(static::toStr('使用 uuencode 算法对一个字符串进行编码', $uuencode));
        var_dump(static::toStr('使用 uuencode 算法将所有（含二进制数据）字符串转化为可输出的字符', Strings::convertUudecode($uuencode)));

        // 已废弃
        //var_dump(static::toStr('返回给定的字符串从一种 Cyrillic 字符转换成另一种之后的字符串', Strings::convertCyrString("Hello world! æøå",'w','a')));

        var_dump(static::toStr('将逻辑顺序希伯来文（logical-Hebrew）转换为视觉顺序希伯来文  hebrev  hebrevc  永远用不到的东西'));




    }


    /**
     * @note 资源操作
     */
    public function stringsResourceTest()
    {
        if (!($fp = fopen($this->fileSaveDir . '/test.txt', 'w'))) {
            return;
        }

        $year = 2021;
        $month = 10;
        $day = 17;
        var_dump(static::toStr('fprintf 将格式化后的字符串写入到流(覆盖);返回写入的字符串长度。 没用的玩儿！', fprintf($fp, "%04d-%02d-%02d", $year, $month, $day)));
        var_dump(static::toStr('vfprintf 作用与 fprintf() 函数类似，但是接收一个数组参数，而不是一系列可变数量的参数。 ', vfprintf($fp, "%04d-%02d-%02d", [$year, $month, $day])));


    }


    /**
     * @note html标签解析
     */
    public function stringsHtmlTest()
    {

        $htmlOrig = "<div>I'll \"walk\" the <b>&nbsp;dog</b> now</div>";
        var_dump(static::toStr('原始 HTML 标签'. PHP_EOL, $htmlOrig));


        $htmlOrig = Strings::htmlentities($htmlOrig ,ENT_QUOTES | ENT_HTML5, 'UTF-8' );
        var_dump(static::toStr('将HTML实体转换回普通字符'. PHP_EOL,$htmlOrig));
        echo $htmlOrig;



        $htmlOrig = Strings::htmlEntityDecode($htmlOrig,ENT_QUOTES | ENT_HTML5, 'UTF-8');
        var_dump(static::toStr('将HTML实体转换为其对应的字符'. PHP_EOL,$htmlOrig));
        echo $htmlOrig;


        $htmlOrig = "<div>I'll \"walk\" the <b>&nbsp;dog</b> now</div>";

        $htmlOrig = Strings::htmlspecialchars($htmlOrig,ENT_QUOTES | ENT_HTML5, 'UTF-8');
        var_dump(static::toStr('将特殊的 HTML 实体转换回普通字符'. PHP_EOL,$htmlOrig));
        echo $htmlOrig;


        $htmlOrig = Strings::htmlspecialcharsDecode($htmlOrig,ENT_QUOTES | ENT_HTML5, 'UTF-8');
        var_dump(static::toStr('将特殊的 HTML 实体转换回普通字符 '. PHP_EOL,$htmlOrig));
        echo $htmlOrig;



        $text = '<div><p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a></div>';
        var_dump(static::toStr('从字符串中去除 HTML 和 PHP 标记; '. $text . PHP_EOL, Strings::stripTags($text, '<a>')));



        var_dump(static::toStr('将返回 htmlspecialchars() 和 htmlentities() 处理后的转换表', get_html_translation_table(HTML_ENTITIES, ENT_QUOTES | ENT_HTML5)));


    }


    /**
     * @note 用不到或有代替对象类
     */
    public function otherTest()
    {

        var_dump(static::toStr('编辑距离;两个字串之间，通过替换、插入、删除等操作将字符串str1转换成str2所需要操作的最少字符数量', Strings::levenshtein('1 apple', '2 apples',1,1,1)));

        var_dump(static::toStr('计算字符串的变音键', Strings::metaphone('programming', 5)));

        // 配置地区信息
        var_dump(static::toStr('设置地区信息', Strings::setlocale(LC_ALL, 'nl_NL')));
        var_dump(static::toStr('设置地区信息', Strings::setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge')));
        var_dump(static::toStr('nlLanginfo — nl_langinfo（）允许您选择任何特定元素;ocaleconv（）不同，它返回所有元素;此函数未在 Windows 平台下实现。'));
        var_dump(static::toStr('返回包含本地化数字和货币格式信息的关联数组', localeconv()));


        var_dump(static::toStr('放弃的方法，到对象函数里面看', array(
            'strGetcsv()解析 CSV 字符串为一个数组',
            'money_format — 将数字格式化成货币字符串；'

        )));
    }


}



