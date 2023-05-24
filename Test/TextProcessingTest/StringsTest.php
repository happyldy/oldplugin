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

        // 配置地区信息 setlocale(LC_CTYPE, 'C');
        var_dump(static::toStr('获取地区信息', Strings::setlocale(LC_ALL, 0)));
        var_dump(static::toStr('设置地区信息', Strings::setlocale(LC_ALL, 'nl_NL')));
        var_dump(static::toStr('设置地区信息', Strings::setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge')));
        var_dump(static::toStr('nlLanginfo — nl_langinfo（）允许您选择任何特定元素;ocaleconv（）不同，它返回所有元素;此函数未在 Windows 平台下实现。'));
        var_dump(static::toStr('返回包含本地化数字和货币格式信息的关联数组', localeconv()));


        var_dump(static::toStr('放弃的方法，到对象函数里面看', array(
            'strGetcsv()解析 CSV 字符串为一个数组',
            'money_format — 将数字格式化成货币字符串；'

        )));
    }







    public function mbstring_binary_safe_encoding( $reset = false ) {
        static $encodings  = array();
        static $overloaded = null;
    
        if ( is_null( $overloaded ) ) {
            if ( function_exists( 'mb_internal_encoding' )
                && ( (int) ini_get( 'mbstring.func_overload' ) & 2 ) // phpcs:ignore PHPCompatibility.IniDirectives.RemovedIniDirectives.mbstring_func_overloadDeprecated
            ) {
                $overloaded = true;
            } else {
                $overloaded = false;
            }
        }
    
        if ( false === $overloaded ) {
            return;
        }
    
        if ( ! $reset ) {
            $encoding = mb_internal_encoding();
            array_push( $encodings, $encoding );
            mb_internal_encoding( 'ISO-8859-1' );
        }
    
        if ( $reset && $encodings ) {
            $encoding = array_pop( $encodings );
            mb_internal_encoding( $encoding );
        }
    }
    


    /**
     * Checks to see if a string is utf8 encoded.
     *
     * NOTE: This function checks for 5-Byte sequences, UTF8
     *       has Bytes Sequences with a maximum length of 4.
     *
     * @author bmorel at ssi dot fr (modified)
     * @since 1.2.1
     *
     * @param string $str The string to be checked
     * @return bool True if $str fits a UTF-8 model, false otherwise.
     */
    function seems_utf8( $str ) {
        $this->mbstring_binary_safe_encoding();
        $length = strlen( $str );
        $this->mbstring_binary_safe_encoding( true );
        for ( $i = 0; $i < $length; $i++ ) {
            $c = ord( $str[ $i ] );
            if ( $c < 0x80 ) {
                $n = 0; // 0bbbbbbb
            } elseif ( ( $c & 0xE0 ) == 0xC0 ) {
                $n = 1; // 110bbbbb
            } elseif ( ( $c & 0xF0 ) == 0xE0 ) {
                $n = 2; // 1110bbbb
            } elseif ( ( $c & 0xF8 ) == 0xF0 ) {
                $n = 3; // 11110bbb
            } elseif ( ( $c & 0xFC ) == 0xF8 ) {
                $n = 4; // 111110bb
            } elseif ( ( $c & 0xFE ) == 0xFC ) {
                $n = 5; // 1111110b
            } else {
                return false; // Does not match any model.
            }
            for ( $j = 0; $j < $n; $j++ ) { // n bytes matching 10bbbbbb follow ?
                if ( ( ++$i == $length ) || ( ( ord( $str[ $i ] ) & 0xC0 ) != 0x80 ) ) {
                    return false;
                }
            }
        }
        return true;
    }



/**
 * Sanitizes a title, replacing whitespace and a few other characters with dashes.
 *
 * Limits the output to alphanumeric characters, underscore (_) and dash (-).
 * Whitespace becomes a dash.
 *
 * @since 1.2.0
 *
 * @param string $title     The title to be sanitized.
 * @param string $raw_title Optional. Not used. Default empty.
 * @param string $context   Optional. The operation for which the string is sanitized.
 *                          When set to 'save', additional entities are converted to hyphens
 *                          or stripped entirely. Default 'display'.
 * @return string The sanitized title.
 */
function sanitize_title_with_dashes( $title, $raw_title = '', $context = 'display' ) {
	$title = strip_tags( $title );
	// Preserve escaped octets.
	$title = preg_replace( '|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title );
	// Remove percent signs that are not part of an octet.
	$title = str_replace( '%', '', $title );
	// Restore octets.
	$title = preg_replace( '|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title );

	if ( $this->seems_utf8( $title ) ) {
		if ( function_exists( 'mb_strtolower' ) ) {
			$title = mb_strtolower( $title, 'UTF-8' );
		}
		$title = $this->utf8_uri_encode( $title, 200 );
	}

	$title = strtolower( $title );

	if ( 'save' === $context ) {
		// Convert &nbsp, &ndash, and &mdash to hyphens.
		$title = str_replace( array( '%c2%a0', '%e2%80%93', '%e2%80%94' ), '-', $title );
		// Convert &nbsp, &ndash, and &mdash HTML entities to hyphens.
		$title = str_replace( array( '&nbsp;', '&#160;', '&ndash;', '&#8211;', '&mdash;', '&#8212;' ), '-', $title );
		// Convert forward slash to hyphen.
		$title = str_replace( '/', '-', $title );

		// Strip these characters entirely.
		$title = str_replace(
			array(
				// Soft hyphens.
				'%c2%ad',
				// &iexcl and &iquest.
				'%c2%a1',
				'%c2%bf',
				// Angle quotes.
				'%c2%ab',
				'%c2%bb',
				'%e2%80%b9',
				'%e2%80%ba',
				// Curly quotes.
				'%e2%80%98',
				'%e2%80%99',
				'%e2%80%9c',
				'%e2%80%9d',
				'%e2%80%9a',
				'%e2%80%9b',
				'%e2%80%9e',
				'%e2%80%9f',
				// Bullet.
				'%e2%80%a2',
				// &copy, &reg, &deg, &hellip, and &trade.
				'%c2%a9',
				'%c2%ae',
				'%c2%b0',
				'%e2%80%a6',
				'%e2%84%a2',
				// Acute accents.
				'%c2%b4',
				'%cb%8a',
				'%cc%81',
				'%cd%81',
				// Grave accent, macron, caron.
				'%cc%80',
				'%cc%84',
				'%cc%8c',
			),
			'',
			$title
		);

		// Convert &times to 'x'.
		$title = str_replace( '%c3%97', 'x', $title );
	}

	// Kill entities.
	$title = preg_replace( '/&.+?;/', '', $title );
	$title = str_replace( '.', '-', $title );

	$title = preg_replace( '/[^%a-z0-9 _-]/', '', $title );
	$title = preg_replace( '/\s+/', '-', $title );
	$title = preg_replace( '|-+|', '-', $title );
	$title = trim( $title, '-' );

	return $title;
}
/**
 * Encode the Unicode values to be used in the URI.
 *
 * @since 1.5.0
 *
 * @param string $utf8_string
 * @param int    $length Max  length of the string
 * @return string String with Unicode encoded for URI.
 */
function utf8_uri_encode( $utf8_string, $length = 0 ) {
	$unicode        = '';
	$values         = array();
	$num_octets     = 1;
	$unicode_length = 0;

	$this->mbstring_binary_safe_encoding();
	$string_length = strlen( $utf8_string );
	$this->mbstring_binary_safe_encoding(true);

	for ( $i = 0; $i < $string_length; $i++ ) {

		$value = ord( $utf8_string[ $i ] );

		if ( $value < 128 ) {
			if ( $length && ( $unicode_length >= $length ) ) {
				break;
			}
			$unicode .= chr( $value );
			$unicode_length++;
		} else {
			if ( count( $values ) == 0 ) {
				if ( $value < 224 ) {
					$num_octets = 2;
				} elseif ( $value < 240 ) {
					$num_octets = 3;
				} else {
					$num_octets = 4;
				}
			}

			$values[] = $value;

			if ( $length && ( $unicode_length + ( $num_octets * 3 ) ) > $length ) {
				break;
			}
			if ( count( $values ) == $num_octets ) {
				for ( $j = 0; $j < $num_octets; $j++ ) {
					$unicode .= '%' . dechex( $values[ $j ] );
				}

				$unicode_length += $num_octets * 3;

				$values     = array();
				$num_octets = 1;
			}
		}
	}

	return $unicode;
}


    /**
     * 
    * @param string $string Text that might have accent characters
    * @return string Filtered string with replaced "nice" characters.
    */
   function remove_accents( $string ) {
       if ( ! preg_match( '/[\x80-\xff]/', $string ) ) {
           return $string;
       }
   
       if ( $this->seems_utf8( $string ) ) {
           $chars = array(
               // Decompositions for Latin-1 Supplement.
               'ª' => 'a',
               'º' => 'o',
               'À' => 'A',
               'Á' => 'A',
               'Â' => 'A',
               'Ã' => 'A',
               'Ä' => 'A',
               'Å' => 'A',
               'Æ' => 'AE',
               'Ç' => 'C',
               'È' => 'E',
               'É' => 'E',
               'Ê' => 'E',
               'Ë' => 'E',
               'Ì' => 'I',
               'Í' => 'I',
               'Î' => 'I',
               'Ï' => 'I',
               'Ð' => 'D',
               'Ñ' => 'N',
               'Ò' => 'O',
               'Ó' => 'O',
               'Ô' => 'O',
               'Õ' => 'O',
               'Ö' => 'O',
               'Ù' => 'U',
               'Ú' => 'U',
               'Û' => 'U',
               'Ü' => 'U',
               'Ý' => 'Y',
               'Þ' => 'TH',
               'ß' => 's',
               'à' => 'a',
               'á' => 'a',
               'â' => 'a',
               'ã' => 'a',
               'ä' => 'a',
               'å' => 'a',
               'æ' => 'ae',
               'ç' => 'c',
               'è' => 'e',
               'é' => 'e',
               'ê' => 'e',
               'ë' => 'e',
               'ì' => 'i',
               'í' => 'i',
               'î' => 'i',
               'ï' => 'i',
               'ð' => 'd',
               'ñ' => 'n',
               'ò' => 'o',
               'ó' => 'o',
               'ô' => 'o',
               'õ' => 'o',
               'ö' => 'o',
               'ø' => 'o',
               'ù' => 'u',
               'ú' => 'u',
               'û' => 'u',
               'ü' => 'u',
               'ý' => 'y',
               'þ' => 'th',
               'ÿ' => 'y',
               'Ø' => 'O',
               // Decompositions for Latin Extended-A.
               'Ā' => 'A',
               'ā' => 'a',
               'Ă' => 'A',
               'ă' => 'a',
               'Ą' => 'A',
               'ą' => 'a',
               'Ć' => 'C',
               'ć' => 'c',
               'Ĉ' => 'C',
               'ĉ' => 'c',
               'Ċ' => 'C',
               'ċ' => 'c',
               'Č' => 'C',
               'č' => 'c',
               'Ď' => 'D',
               'ď' => 'd',
               'Đ' => 'D',
               'đ' => 'd',
               'Ē' => 'E',
               'ē' => 'e',
               'Ĕ' => 'E',
               'ĕ' => 'e',
               'Ė' => 'E',
               'ė' => 'e',
               'Ę' => 'E',
               'ę' => 'e',
               'Ě' => 'E',
               'ě' => 'e',
               'Ĝ' => 'G',
               'ĝ' => 'g',
               'Ğ' => 'G',
               'ğ' => 'g',
               'Ġ' => 'G',
               'ġ' => 'g',
               'Ģ' => 'G',
               'ģ' => 'g',
               'Ĥ' => 'H',
               'ĥ' => 'h',
               'Ħ' => 'H',
               'ħ' => 'h',
               'Ĩ' => 'I',
               'ĩ' => 'i',
               'Ī' => 'I',
               'ī' => 'i',
               'Ĭ' => 'I',
               'ĭ' => 'i',
               'Į' => 'I',
               'į' => 'i',
               'İ' => 'I',
               'ı' => 'i',
               'Ĳ' => 'IJ',
               'ĳ' => 'ij',
               'Ĵ' => 'J',
               'ĵ' => 'j',
               'Ķ' => 'K',
               'ķ' => 'k',
               'ĸ' => 'k',
               'Ĺ' => 'L',
               'ĺ' => 'l',
               'Ļ' => 'L',
               'ļ' => 'l',
               'Ľ' => 'L',
               'ľ' => 'l',
               'Ŀ' => 'L',
               'ŀ' => 'l',
               'Ł' => 'L',
               'ł' => 'l',
               'Ń' => 'N',
               'ń' => 'n',
               'Ņ' => 'N',
               'ņ' => 'n',
               'Ň' => 'N',
               'ň' => 'n',
               'ŉ' => 'n',
               'Ŋ' => 'N',
               'ŋ' => 'n',
               'Ō' => 'O',
               'ō' => 'o',
               'Ŏ' => 'O',
               'ŏ' => 'o',
               'Ő' => 'O',
               'ő' => 'o',
               'Œ' => 'OE',
               'œ' => 'oe',
               'Ŕ' => 'R',
               'ŕ' => 'r',
               'Ŗ' => 'R',
               'ŗ' => 'r',
               'Ř' => 'R',
               'ř' => 'r',
               'Ś' => 'S',
               'ś' => 's',
               'Ŝ' => 'S',
               'ŝ' => 's',
               'Ş' => 'S',
               'ş' => 's',
               'Š' => 'S',
               'š' => 's',
               'Ţ' => 'T',
               'ţ' => 't',
               'Ť' => 'T',
               'ť' => 't',
               'Ŧ' => 'T',
               'ŧ' => 't',
               'Ũ' => 'U',
               'ũ' => 'u',
               'Ū' => 'U',
               'ū' => 'u',
               'Ŭ' => 'U',
               'ŭ' => 'u',
               'Ů' => 'U',
               'ů' => 'u',
               'Ű' => 'U',
               'ű' => 'u',
               'Ų' => 'U',
               'ų' => 'u',
               'Ŵ' => 'W',
               'ŵ' => 'w',
               'Ŷ' => 'Y',
               'ŷ' => 'y',
               'Ÿ' => 'Y',
               'Ź' => 'Z',
               'ź' => 'z',
               'Ż' => 'Z',
               'ż' => 'z',
               'Ž' => 'Z',
               'ž' => 'z',
               'ſ' => 's',
               // Decompositions for Latin Extended-B.
               'Ș' => 'S',
               'ș' => 's',
               'Ț' => 'T',
               'ț' => 't',
               // Euro sign.
               '€' => 'E',
               // GBP (Pound) sign.
               '£' => '',
               // Vowels with diacritic (Vietnamese).
               // Unmarked.
               'Ơ' => 'O',
               'ơ' => 'o',
               'Ư' => 'U',
               'ư' => 'u',
               // Grave accent.
               'Ầ' => 'A',
               'ầ' => 'a',
               'Ằ' => 'A',
               'ằ' => 'a',
               'Ề' => 'E',
               'ề' => 'e',
               'Ồ' => 'O',
               'ồ' => 'o',
               'Ờ' => 'O',
               'ờ' => 'o',
               'Ừ' => 'U',
               'ừ' => 'u',
               'Ỳ' => 'Y',
               'ỳ' => 'y',
               // Hook.
               'Ả' => 'A',
               'ả' => 'a',
               'Ẩ' => 'A',
               'ẩ' => 'a',
               'Ẳ' => 'A',
               'ẳ' => 'a',
               'Ẻ' => 'E',
               'ẻ' => 'e',
               'Ể' => 'E',
               'ể' => 'e',
               'Ỉ' => 'I',
               'ỉ' => 'i',
               'Ỏ' => 'O',
               'ỏ' => 'o',
               'Ổ' => 'O',
               'ổ' => 'o',
               'Ở' => 'O',
               'ở' => 'o',
               'Ủ' => 'U',
               'ủ' => 'u',
               'Ử' => 'U',
               'ử' => 'u',
               'Ỷ' => 'Y',
               'ỷ' => 'y',
               // Tilde.
               'Ẫ' => 'A',
               'ẫ' => 'a',
               'Ẵ' => 'A',
               'ẵ' => 'a',
               'Ẽ' => 'E',
               'ẽ' => 'e',
               'Ễ' => 'E',
               'ễ' => 'e',
               'Ỗ' => 'O',
               'ỗ' => 'o',
               'Ỡ' => 'O',
               'ỡ' => 'o',
               'Ữ' => 'U',
               'ữ' => 'u',
               'Ỹ' => 'Y',
               'ỹ' => 'y',
               // Acute accent.
               'Ấ' => 'A',
               'ấ' => 'a',
               'Ắ' => 'A',
               'ắ' => 'a',
               'Ế' => 'E',
               'ế' => 'e',
               'Ố' => 'O',
               'ố' => 'o',
               'Ớ' => 'O',
               'ớ' => 'o',
               'Ứ' => 'U',
               'ứ' => 'u',
               // Dot below.
               'Ạ' => 'A',
               'ạ' => 'a',
               'Ậ' => 'A',
               'ậ' => 'a',
               'Ặ' => 'A',
               'ặ' => 'a',
               'Ẹ' => 'E',
               'ẹ' => 'e',
               'Ệ' => 'E',
               'ệ' => 'e',
               'Ị' => 'I',
               'ị' => 'i',
               'Ọ' => 'O',
               'ọ' => 'o',
               'Ộ' => 'O',
               'ộ' => 'o',
               'Ợ' => 'O',
               'ợ' => 'o',
               'Ụ' => 'U',
               'ụ' => 'u',
               'Ự' => 'U',
               'ự' => 'u',
               'Ỵ' => 'Y',
               'ỵ' => 'y',
               // Vowels with diacritic (Chinese, Hanyu Pinyin).
               'ɑ' => 'a',
               // Macron.
               'Ǖ' => 'U',
               'ǖ' => 'u',
               // Acute accent.
               'Ǘ' => 'U',
               'ǘ' => 'u',
               // Caron.
               'Ǎ' => 'A',
               'ǎ' => 'a',
               'Ǐ' => 'I',
               'ǐ' => 'i',
               'Ǒ' => 'O',
               'ǒ' => 'o',
               'Ǔ' => 'U',
               'ǔ' => 'u',
               'Ǚ' => 'U',
               'ǚ' => 'u',
               // Grave accent.
               'Ǜ' => 'U',
               'ǜ' => 'u',
           );
   
        //    // Used for locale-specific rules.
        //    $locale = get_locale();
   
        //    if ( in_array( $locale, array( 'de_DE', 'de_DE_formal', 'de_CH', 'de_CH_informal', 'de_AT' ), true ) ) {
        //        $chars['Ä'] = 'Ae';
        //        $chars['ä'] = 'ae';
        //        $chars['Ö'] = 'Oe';
        //        $chars['ö'] = 'oe';
        //        $chars['Ü'] = 'Ue';
        //        $chars['ü'] = 'ue';
        //        $chars['ß'] = 'ss';
        //    } elseif ( 'da_DK' === $locale ) {
        //        $chars['Æ'] = 'Ae';
        //        $chars['æ'] = 'ae';
        //        $chars['Ø'] = 'Oe';
        //        $chars['ø'] = 'oe';
        //        $chars['Å'] = 'Aa';
        //        $chars['å'] = 'aa';
        //    } elseif ( 'ca' === $locale ) {
        //        $chars['l·l'] = 'll';
        //    } elseif ( 'sr_RS' === $locale || 'bs_BA' === $locale ) {
        //        $chars['Đ'] = 'DJ';
        //        $chars['đ'] = 'dj';
        //    }
   
           $string = strtr( $string, $chars );
       } else {
           $chars = array();
           // Assume ISO-8859-1 if not UTF-8.
           $chars['in'] = "\x80\x83\x8a\x8e\x9a\x9e"
               . "\x9f\xa2\xa5\xb5\xc0\xc1\xc2"
               . "\xc3\xc4\xc5\xc7\xc8\xc9\xca"
               . "\xcb\xcc\xcd\xce\xcf\xd1\xd2"
               . "\xd3\xd4\xd5\xd6\xd8\xd9\xda"
               . "\xdb\xdc\xdd\xe0\xe1\xe2\xe3"
               . "\xe4\xe5\xe7\xe8\xe9\xea\xeb"
               . "\xec\xed\xee\xef\xf1\xf2\xf3"
               . "\xf4\xf5\xf6\xf8\xf9\xfa\xfb"
               . "\xfc\xfd\xff";
   
           $chars['out'] = 'EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy';
   
           $string              = strtr( $string, $chars['in'], $chars['out'] );
           $double_chars        = array();
           $double_chars['in']  = array( "\x8c", "\x9c", "\xc6", "\xd0", "\xde", "\xdf", "\xe6", "\xf0", "\xfe" );
           $double_chars['out'] = array( 'OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th' );
           $string              = str_replace( $double_chars['in'], $double_chars['out'], $string );
       }
   
       return $string;
   }












}



