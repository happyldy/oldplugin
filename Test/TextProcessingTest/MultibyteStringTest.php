<?php
/**
 * Unicode 可以使用的编码有三种，分别是：
 *     UFT-8：一种变长的编码方案，使用 1~6 个字节来存储；
 *     UFT-32：一种固定长度的编码方案，不管字符编号大小，始终使用 4 个字节来存储；
 *     UTF-16：介于 UTF-8 和 UTF-32 之间，使用 2 个或者 4 个字节来存储，长度既固定又可变。
 * UTF 是 Unicode Transformation Format 的缩写，意思是“Unicode转换格式”，后面的数字表明至少使用多少个比特位（Bit）来存储字符。
 *
 * 具体的表现形式为：
 *      十进制 	        十六进制 	    编码形式
 *      0~127 	        0~7F 	        0xxxxxxx                                单字节编码形式，这和 ASCII 编码完全一样，因此 UTF-8 是兼容 ASCII 的；
 *      128~2047 	    80~7FF 	        110xxxxx 10xxxxxx                       双字节编码形式；
 *      2048~55295 	    800~D7FF 	    1110xxxx 10xxxxxx 10xxxxxx              三字节编码形式；
 *      55296~57343 	D800~DFFF 	    未定义
 *      57344~65535 	E000~FFFF 	    1110xxxx 10xxxxxx 10xxxxxx
 *      65536~1114111 	10000~10FFFF 	11110xxx 10xxxxxx 10xxxxxx 10xxxxxx     四字节编码形式。
 *
 *      10进制编码范围   16进制编码范围 	            UTF-16表示方法（二进制） 	     	字节数量
 *      0-65535         0000 0000-0000 FFFF 	    xxxxxxxx xxxxxxxx 	            2
 *      65536-1114111   0001 0000-0010 FFFF 	    110110xx xxxxxxxx            	4
 *                                                  110111xx xxxxxxxx
 *
 * 该 PHP 扩展支持的字符编码有以下几种：
 *  UCS-4   *
 *  UCS-4BE
 *  UCS-4LE *
 *  UCS-2
 *  UCS-2BE
 *  UCS-2LE
 *  UTF-32*
 *  UTF-32BE    *
 *  UTF-32LE    *
 *  UTF-16  *
 *  UTF-16BE    *
 *  UTF-16LE    *
 *  UTF-7
 *  UTF7-IMAP
 *  UTF-8   *
 *  ASCII   *
 *  EUC-JP  *
 *  SJIS    *
 *  eucJP-win   *
 *  SJIS-win    *
 *  ISO-2022-JP
 *  ISO-2022-JP-MS
 *  CP932
 *  CP51932
 *  SJIS-mac                ** (别名： MacJapanese)
 *  SJIS-Mobile#DOCOMO      ** (别名： SJIS-DOCOMO)
 *  SJIS-Mobile#KDDI        ** (别名： SJIS-KDDI)
 *  SJIS-Mobile#SOFTBANK    ** (别名： SJIS-SOFTBANK)
 *  UTF-8-Mobile#DOCOMO     ** (别名： UTF-8-DOCOMO)
 *  UTF-8-Mobile#KDDI-A     **
 *  UTF-8-Mobile#KDDI-B     ** (别名： UTF-8-KDDI)
 *  UTF-8-Mobile#SOFTBANK   ** (别名： UTF-8-SOFTBANK)
 *  ISO-2022-JP-MOBILE#KDDI ** (别名： ISO-2022-JP-KDDI)
 *  JIS
 *  JIS-ms
 *  CP50220
 *  CP50220raw
 *  CP50221
 *  CP50222
 *  ISO-8859-1  *
 *  ISO-8859-2  *
 *  ISO-8859-3  *
 *  ISO-8859-4  *
 *  ISO-8859-5  *
 *  ISO-8859-6  *
 *  ISO-8859-7  *
 *  ISO-8859-8  *
 *  ISO-8859-9  *
 *  ISO-8859-10 *
 *  ISO-8859-13 *
 *  ISO-8859-14 *
 *  ISO-8859-15 *
 *  ISO-8859-16 *
 *  byte2be
 *  byte2le
 *  byte4be
 *  byte4le
 *  BASE64
 *  HTML-ENTITIES
 *  7bit
 *  8bit
 *  EUC-CN  *
 *  CP936
 *  GB18030 **
 *  HZ
 *  EUC-TW  *
 *  CP950
 *  BIG-5   *
 *  EUC-KR  *
 *  UHC (CP949)
 *  ISO-2022-KR
 *  Windows-1251 (CP1251)
 *  Windows-1252 (CP1252)
 *  CP866 (IBM866)
 *  KOI8-R  *
 *  KOI8-U  *
 *  ArmSCII-8 (ArmSCII8)
 * * 表示该编码也可以在正则表达式中使用。
 * ** 表示该编码自 PHP 5.4.0 始可用。
 *
 * ISO-10646-UCS-4  ISO 10646       31位编码空间的通用字符集，以 ISO/IEC 10646 标准化为 UCS-4。它和最新的 Unicode 代码映射表保持同步。  如果在编码转化程序中使用了这个名字，转换器将尝试识别前缀的 BOM头（字节顺序标记），即表示后续字节的字节序。
 * ISO-10646-UCS-4  UCS-4           参见以上。  和 UCS-4 相比较，字符串总是设为大端序（big endian）的形式。
 * ISO-10646-UCS-4  UCS-4           参见以上。  和 UCS-4 相比较，字符串总是设为小端序（little endian）的形式。
 * ISO-10646-UCS-2  UCS-2           16位编码空间的通用字符集，以 ISO/IEC 10646 标准化为 UCS-2。它和最新的 Unicode 代码映射表保持同步。  如果在编码转化程序中使用了这个名字，转换器将尝试识别前缀的 BOM头（字节顺序标记），即表示后续字节的字节序。
 * ISO-10646-UCS-2  UCS-2           参见以上。  和 UCS-2 相比较，字符串总是设为大端序（big endian）的形式。
 * ISO-10646-UCS-2  UCS-2           参见以上。  和 UCS-2 相比较，字符串总是设为小端序（little endian）的形式。
 * UTF-32           Unicode         32 位单位宽度的 Unicode 转换格式，涉及到了 Unicode 字符集标准。该编码方案和 UCS-4 没有完全相同，因为 Unicode 编码空间限制为 21 位的值。  如果在编码转化程序中使用了这个名字，转换器将尝试识别前缀的 BOM头（字节顺序标记），即表示后续字节的字节序。
 * UTF-32BE         Unicode         参见以上    和 UTF-32 相比较，字符串总是设为大端序（big endian）的形式。
 * UTF-32LE         Unicode         参见以上 和 UTF-32 相比较，字符串总是设为小端序（little endian）的形式。
 * UTF-16           Unicode         16 位单位宽度的 Unicode 转换格式。值得一记的是，UTF-16 的规格不再和 UCS-2 一样，因为 Unicode 2.0 引入了代理机制（surrogate mechanism），UTF-16 现在指向了 21 位的编码空间。  如果在编码转化程序中使用了这个名字，转换器将尝试识别前缀的 BOM头（字节顺序标记），即表示后续字节的字节序。
 * UTF-16BE         Unicode         参见以上。  和 UTF-16 相比较，字符串总是设为大端序（big endian）的形式。
 * UTF-16LE         Unicode         参见以上。  和 UTF-16 相比较，字符串总是设为小端序（little endian）的形式。
 * UTF-8            Unicode/UCS     8 位单位宽度的 Unicode 转换格式。  none
 * UTF-7            Unicode         一种邮件安全的 Unicode 转换格式，规格是 » RFC2152。  none
 * (none)           Unicode         UTF-7 的一种变体，其规格在 » IMAP 协议 中用到了。  none
 * US-ASCII (首选 MIME 名称) / iso-ir-6 / ANSI_X3.4-1986 /ISO_646.irv:1991 / ASCII / ISO646-US / us / IBM367 / CP367 / csASCII  ASCII / ISO 646 美国标准代码（American Standard Code）是一种常用的 7-bit 信息交换编码。同样，标准化为 ISO 646 国际标准。  (none)
 * EUC-JP (首选 MIME 名称) / Extended_UNIX_Code_Packed_Format_for_Japanese / csEUCPkdFmtJapanese  US-ASCII / JIS X0201:1997 (半角假名部分) / JIS X0208:1990 / JIS X0212:1990 的复合  就像你所看到的，名字来源于扩展 Extended UNIX Code Packed Format for Japanese 的缩写，该编码常用于 UNIX 或类似平台。原始编码方案 Extended UNIX Code 基于 ISO 2022 而设计。  EUC-JP 涉及的字符集和 IBM932 / CP932 是不一样的，后者使用于 OS/2® 和 Microsoft® Windows®。这些平台上的信息交换，使用 EUCJP-WIN 来代替。
 * Shift_JIS (首选 MIME 名称) / MS_Kanji / csShift_JIS JIS X0201:1997 / JIS X0208:1997 的复合 80 年代初，个人日文文字处理软件进入了市场之时，为了兼容传统编码方案 JIS X 0201:1976，开发了 Shift_JIS。根据 IANA 对 Shift_JIS 编码集的定义，和 IBM932 / CP932 稍有不同。但 "SJIS"、"Shift_JIS" 的名称常被错误得指向这些编码集。  要使用 CP932，使用 SJIS-WIN 作为替代。
 * (none) JIS X0201:1997 / JIS X0208:1997 / IBM extensions / NEC extensions 的复合  虽然此 "encoding" 使用了 EUC-JP 同样的方案，一些字符集有所不同。也就是说，一些编码映射到了和 EUC-JP 不同的字符。  none
 * Windows-31J / csWindows31J JIS X0201:1997 / JIS X0208:1997 / IBM extensions / NEC extensions 的符合  虽然此 "encoding" 使用了 Shift_JIS 同样的方案，一些字符集有所不同。也就是说，一些编码映射到了和 Shift_JIS 不同的字符。  (none)
 * ISO-2022-JP (首选 MIME 名称) / csISO2022JP US-ASCII / JIS X0201:1976 / JIS X0208:1978 / JIS X0208:1983  » RFC1468 (none)
 */



namespace HappyLin\OldPlugin\Test\TextProcessingTest;


use HappyLin\OldPlugin\SingleClass\TextProcessing\HLCharacterEncoding\MultibyteString;
use HappyLin\OldPlugin\Test\TraitTest;
use Symfony\Component\HttpKernel\EventListener\ValidateRequestListener;


class MultibyteStringTest
{

    use TraitTest;


    public function __construct()
    {

    }

    /**
     * @note 多字节字符串 函数(信息和编码转换)
     */
    public function MultibyteStringTest()
    {
        // GBK 类型的字符串；下方判断编码类型用
        $str  = '甲乙丙丁';
        $strGBK = MultibyteString::mbConvertEncoding($str, "GBK", "UTF-8");

        var_dump(static::toStr('获取 mbstring 的内部设置 ', MultibyteString::mbGetInfo()));

        var_dump(static::toStr('设置/获取替代字符; 63 => ? ', MultibyteString::mbSubstituteCharacter()));


        var_dump(static::toStr('设置/获取当前的语言', MultibyteString::mbLanguage()));

        var_dump(static::toStr('编码设置/获取内部字符编码 mb_internal_encoding() ', MultibyteString::mbInternalEncoding()));
        var_dump(static::toStr('编码检查字节流；指定的字节流在指定的编码 mb_internal_encoding() 里是否有效；', MultibyteString::mbCheckEncoding()));

        var_dump(static::toStr('编码检测；设置/获取 字符编码的检测顺序；mb_detect_order()', MultibyteString::mbDetectOrder()));
        var_dump(static::toStr('编码检测；检测字符的编码在 mb_detect_order() 内 ；', MultibyteString::mbDetectEncoding($strGBK), MultibyteString::mbDetectEncoding($strGBK, array('UTF-8', 'GBK'))));

        var_dump(static::toStr('编码HTTP 输入; 检测 HTTP 输入字符编码；', MultibyteString::mbTttpInput()));
        var_dump(static::toStr('编码HTTP 输出; 设置/获取 HTTP 输出字符编码；', MultibyteString::mbHttpOutput()));
        var_dump(static::toStr('编码回调函数; 在输出缓冲中转换字符编码的回调函数 mb_output_handler() ob_start("mb_output_handler") 回调函数 '));

        var_dump(static::toStr('MIME 获取 MIME 字符串', MultibyteString::mbPreferredMimeName("sjis-win")));

        $headers_string = <<<EOF
Subject: =?UTF-8?B?UHLDvGZ1bmcgUHLDvGZ1bmc=?=
To: example@example.com
Date: Thu, 1 Jan 1970 00:00:00 +0000
Message-Id: <example@example.com>
Received: from localhost (localhost [127.0.0.1]) by localhost
    with SMTP id example for <example@example.com>;
    Thu, 1 Jan 1970 00:00:00 +0000 (UTC)
    (envelope-from example-return-0000-example=example.com@example.com)
Received: (qmail 0 invoked by uid 65534); 1 Thu 2003 00:00:00 +0000

EOF;
        var_dump(static::toStr('MIME 解码头MIME字段中的字符串；【iconv_mime_decode()更详细】', MultibyteString::mbDecodeMimeheader($headers_string)));

        $preferences = array(
            "scheme" => "B",
            "input-charset" => "UTF-8",
            "output-charset" => "UTF-8",
            "line-length" => 76,
            "line-break-chars" => "\n"
        );
        var_dump(static::toStr('MIME 编码MIME头字符串; 【iconv_mime_encode()更详细】',MultibyteString::mbEncodeMimeheader(
            "Prüfung Prüfung",
            'UTF-8',
            'B',
            '\n'
        ) ));

        // 编码转换
        var_dump(static::toStr('编码转换；转换字符串第一个字节为指定编码 $encoding 的int值;mb_ord()', MultibyteString::mbOrd('甲')));
        var_dump(static::toStr('编码转换；返回相对应于 $encoding 编码所指定的单个字符；mb_chr()', MultibyteString::mbChr(MultibyteString::mbOrd('甲'))));

        var_dump(static::toStr('编码转换；转换字符的编码', MultibyteString::mbConvertEncoding($strGBK, "UTF-8", "UCS-2,GBK")));

        $strGBK1 = MultibyteString::mbConvertEncoding('张三李四', "GBK", "UTF-8");
        var_dump(static::toStr('编码转换； 转换一个或多个变量的字符编码', MultibyteString::mbConvertVariables('UTF-8',array("UCS-2", 'GBK'), $strGBK, $strGBK1), $strGBK, $strGBK1));

        $htmlStr = "<div>张三</div>";
        $convmap = [ 0x0, 0xffff, 0, 0xffff ];
        var_dump(static::toStr('HTML编码转换；; 将字符串 str 中的指定字符代码从字符代码转换为 HTML 数字字符引用。（比 mbOrd() 多了&#*;）' . $htmlStr, $htmlNum = MultibyteString::mbEncodeNumericentity($htmlStr,$convmap, "UTF-8")));

        var_dump(static::toStr('HTML编码转换；; 根据 HTML 数字字符串解码成字符', MultibyteString::mbDecodeNumericentity($htmlNum,$convmap, "UTF-8")));

        $urlParam = [];
        var_dump(static::toStr('解析 GET/POST/COOKIE 数据并设置全局变量; 由于 PHP 不提供原始 POST/COOKIE 数据，目前它仅能够用于 GET 数据', MultibyteString::mbParseStr('email=kehaovista@qq.com&city=shanghai&job=Phper', $urlParam), $urlParam));

        var_dump(static::toStr('从另一个转换“假名”（“zen-kaku”、“han-kaku”等）;将半角的平假名、片假名转化为全角，或者是全角转化为半角。主要用在对用户的输入进行处理。在日语中使用; mb_convert_kana()'));

        var_dump(static::toStr('清理损坏的多字节字符串。', MultibyteString::mbScrub('GBK')));
        var_dump(static::toStr('编码类型别名; 获取已知编码类型的别名', MultibyteString::mbEncodingAliases('GBK')));
        var_dump(static::toStr('编码类型;返回所有支持编码的数组', MultibyteString::mbListEncodings()));




    }


    /**
     * @note 多字节字符串 函数(字符串操作)
     */
    public function MultibyteStringStringTest()
    {

        var_dump(static::toStr('获取字符串的长度', MultibyteString::mbStrlen('123ABC甲乙丙', 'UTF-8')));
        var_dump(static::toStr('改；对字符串进行大小写转换；模式有：大写、小写、首字母大写', MultibyteString::mbConvertCase('123ABC甲乙丙', MB_CASE_UPPER)));

        var_dump(static::toStr('改；使字符串小写', MultibyteString::mbStrtolower("123ABC甲乙丙",'UTF-8')));
        var_dump(static::toStr('改；使字符串大写', MultibyteString::mbStrtoupper("123ABC甲乙丙",'UTF-8')));


        var_dump(static::toStr('分割操作；使用正则表达式分割多字节字符串', MultibyteString::mbSplit("\\d+",'123ab32c4d')));

        var_dump(static::toStr('分割操作；按长度分割给定一个多字节字符串，返回它的字符数组', MultibyteString::mbStrSplit('123ABC甲乙丙',2, 'UTF-8')));

        var_dump(static::toStr('截取操作；根据字符数执行一个多字节安全的 substr() 操作', MultibyteString::mbSubstr('123ABC甲乙丙',3, 6,'UTF-8')));

        var_dump(static::toStr('截取操作；根据字节执行一个多字节安全的 mb_strcut() 操作', MultibyteString::mbStrcut('123ABC甲乙丙',3, 6,'UTF-8')));


        $str = '123甲、乙、丙、丁、戊、己、庚、辛、壬、癸';
        var_dump(static::toStr('信息；返回多字节字符串的宽度', MultibyteString::mbStrwidth($str,'UTF-8')));

        var_dump(static::toStr(
            '截取 & 增加操作；按多字节字符串的宽度 width 将字符串 str 截短；($width 包含 $trimmarker 长度； 但是这里的汉字包括字符占位 2 ；而 $trimmarker 汉字占位 1 ；！！！！)',
            MultibyteString::mbStrimwidth($str,3, 17, '···','UTF-8')
        ));


        var_dump(static::toStr('查找字符串在另一个字符串中首次出现的位置', MultibyteString::mbStrpos($str,'戊、', 3,'UTF-8')));
        var_dump(static::toStr('查找字符串在另一个字符串中首次出现的位置;大小写不敏感', MultibyteString::mbStripos($str,'戊、', 3,'UTF-8')));

        var_dump(static::toStr('查找字符串在一个字符串中最后出现的位置;', MultibyteString::mbStrrpos('Aabcd aABCD','a', 0,'UTF-8')));
        var_dump(static::toStr('查找字符串在一个字符串中最后出现的位置;大小写不敏感', MultibyteString::mbStrripos('Aabcd aABCD','a', 0,'UTF-8')));

        var_dump(static::toStr('查找字符串在另一个字符串里的首次出现; "Aabcd aABCD"', MultibyteString::mbStrstr('Aabcd aABCD','b', true,'UTF-8')));
        var_dump(static::toStr('查找字符串在另一个字符串里的首次出现;大小写不敏感; "Aabcd aABCD"', MultibyteString::mbStristr('Aabcd aABCD','b', false,'UTF-8')));

        var_dump(static::toStr('查找字符串在另一个字符串里的最后一次出现; "Aabcd aABCD"', MultibyteString::mbStrrchr('Aabcd aABCD','b', true,'UTF-8')));
        var_dump(static::toStr('查找字符串在另一个字符串里的最后一次出现;大小写不敏感; "Aabcd aABCD"', MultibyteString::mbStrrichr('Aabcd aABCD','b', false,'UTF-8')));


        var_dump(static::toStr('统计字符串出现的次数; "Aabcd aABCD"', MultibyteString::mbSubstrCount('Aabcd aABCD','a', 'UTF-8')));









    }


    /**
     * @note 多字节字符串 函数(正则操作)
     */
    public function MultibyteStringEregTest()
    {
        var_dump(static::toStr('设置/获取多字节正则表达式的字符编码 "UTF-8"', MultibyteString::mbRegexEncoding("UTF-8")));

        var_dump(static::toStr('设置mbregex函数的选项: r Ruby ', MultibyteString::mbRegexSetOptions('r')));

        var_dump(static::toStr('设置/获取mbregex函数的默认选项', MultibyteString::mbRegexSetOptions()));

        $res = [];
        var_dump(static::toStr('正则表达式匹配,支持多字节; 搜索字符串  "_ABCDE_abcde_"', MultibyteString::mbEreg('a(bc)de', '_ABCDE_abcde_',$res), $res));
        var_dump(static::toStr('正则表达式匹配，支持多字节, 除忽略大小写；同上', MultibyteString::mbEregi('a(bc)de', '_ABCDE_abcde_',$res), $res));

        var_dump(static::toStr('正则表达式匹配 bool; 开头要有匹配符，不然单词匹配不到 !!', MultibyteString::mbEregMatch('\w*abcde', '_ABCDE_abcde_','msr')));

        var_dump(static::toStr('正则表达式替换; “_ABCDE_abcde#fghft_” ', MultibyteString::mbEregReplace('abcde#fghft', '---','_ABCDE_abcde#fghft_','msixr')));

        var_dump(static::toStr('正则表达式替换;忽略大小写; 除了强制加 i 其他同上； “_ABCDE_abcde#fghft_” ', MultibyteString::mbEregiReplace('abcde#fghft', '---','_ABCDE_abcde#fghft_','msxr')));

        var_dump('多次搜索同一字符串（mb_ereg()只获取一个结果）的系列函数：mb_ereg_search_init() mb_ereg_search()、mb_ereg_search_pos() 和 mb_ereg_search_regs() mb_ereg_search_getregs()  mb_ereg_search_setpos() mb_ereg_search_getpos()； 操作如下：');

        $str = "中国abc + abc  ?!？！字符＃ china string";

        $pattern = "(\w)+";
        echo sprintf('搜索字符串 $str：%s;<br> 匹配规则 \$pattern：%s;<br>', $str, $pattern );

        $iflag = mb_ereg_search_init($str, $pattern);
        echo "<br>设置字符串和正则表达式: mb_ereg_search_init(\$str, \$pattern) :". var_export($iflag, true) ."<br>";


        $rflag = mb_ereg_search();
        echo sprintf('多字节字符串与正则表达式匹配校验: mb_ereg_search() : %s<br>', var_export($rflag, true) );

        if($rflag)
        {
            $i = 0; //预防进入死循环

            // 重置检索位置为0； mb_ereg_search()虽然返回bool; 但是它有检索操作，检索位置变了
            echo sprintf('重置检索位置为0； mb_ereg_search()虽然返回bool; 但是它有检索操作，检索位置变了； mb_ereg_search_setpos(0): %s<br>', var_export(mb_ereg_search_setpos(0), true) );

            // 检索第一条数据
            $res = mb_ereg_search_regs();
            do
            {
                echo sprintf('下一个正则表达式匹配的起点(字节表示) mb_ereg_search_getpos() ：%d; 匹配结果 mb_ereg_search_regs() ：%s<br>', mb_ereg_search_getpos(), var_export($res, true));
                // 从最后一个多字节正则表达式匹配中检索结果； 当前的 $res === mb_ereg_search_getregs()；
                //var_dump(mb_ereg_search_getregs());

                // 获取下一条数据
                $res = mb_ereg_search_regs();
            }
            while($res && ++$i < 100);

        }



    }







}



