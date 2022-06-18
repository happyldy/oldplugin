<?php
/**
 * 该 PHP 扩展支持的字符编码有以下几种：
 *  UCS-4*
 *  UCS-4BE
 *  UCS-4LE*
 *  UCS-2
 *  UCS-2BE
 *  UCS-2LE
 *  UTF-32*
 *  UTF-32BE*
 *  UTF-32LE*
 *  UTF-16*
 *  UTF-16BE*
 *  UTF-16LE*
 *  UTF-7
 *  UTF7-IMAP
 *  UTF-8*
 *  ASCII*
 *  EUC-JP*
 *  SJIS*
 *  eucJP-win*
 *  SJIS-win*
 *  ISO-2022-JP
 *  ISO-2022-JP-MS
 *  CP932
 *  CP51932
 *  SJIS-mac** (别名： MacJapanese)
 *  SJIS-Mobile#DOCOMO** (别名： SJIS-DOCOMO)
 *  SJIS-Mobile#KDDI** (别名： SJIS-KDDI)
 *  SJIS-Mobile#SOFTBANK** (别名： SJIS-SOFTBANK)
 *  UTF-8-Mobile#DOCOMO** (别名： UTF-8-DOCOMO)
 *  UTF-8-Mobile#KDDI-A**
 *  UTF-8-Mobile#KDDI-B** (别名： UTF-8-KDDI)
 *  UTF-8-Mobile#SOFTBANK** (别名： UTF-8-SOFTBANK)
 *  ISO-2022-JP-MOBILE#KDDI** (别名： ISO-2022-JP-KDDI)
 *  JIS
 *  JIS-ms
 *  CP50220
 *  CP50220raw
 *  CP50221
 *  CP50222
 *  ISO-8859-1*
 *  ISO-8859-2*
 *  ISO-8859-3*
 *  ISO-8859-4*
 *  ISO-8859-5*
 *  ISO-8859-6*
 *  ISO-8859-7*
 *  ISO-8859-8*
 *  ISO-8859-9*
 *  ISO-8859-10*
 *  ISO-8859-13*
 *  ISO-8859-14*
 *  ISO-8859-15*
 *  ISO-8859-16*
 *  byte2be
 *  byte2le
 *  byte4be
 *  byte4le
 *  BASE64
 *  HTML-ENTITIES
 *  7bit
 *  8bit
 *  EUC-CN*
 *  CP936
 *  GB18030**
 *  HZ
 *  EUC-TW*
 *  CP950
 *  BIG-5*
 *  EUC-KR*
 *  UHC (CP949)
 *  ISO-2022-KR
 *  Windows-1251 (CP1251)
 *  Windows-1252 (CP1252)
 *  CP866 (IBM866)
 *  KOI8-R*
 *  KOI8-U*
 *  ArmSCII-8 (ArmSCII8)
 *
 * * 表示该编码也可以在正则表达式中使用。
 * ** 表示该编码自 PHP 5.4.0 始可用。
 */

namespace HappyLin\OldPlugin\Test\TextProcessingTest;


use HappyLin\OldPlugin\SingleClass\TextProcessing\HLCharacterEncoding\Iconv;
use HappyLin\OldPlugin\Test\TraitTest;


class IconvTest
{

    use TraitTest;


    public function __construct()
    {

    }


    /**
     * @note iconv 扩展; iconv 字符集转换功能的接口
     */
    public function iconvTest()
    {

        var_dump(static::toStr(' 获取 iconv 扩展的内部配置变量', Iconv::iconvGetEncoding('all')));

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
        var_dump(static::toStr('一次性解码多个 MIME 头字段', Iconv::iconvMimeDecodeHeaders($headers_string, 0, "UTF-8")));
        var_dump(static::toStr('解码一个MIME头字段', Iconv::iconvMimeDecode($headers_string, 0, "UTF-8")));

        $preferences = array(
            "scheme" => "B",
            "input-charset" => "UTF-8",
            "output-charset" => "UTF-8",
            "line-length" => 76,
            "line-break-chars" => "\n"
        );
        var_dump(static::toStr('组成一个MIME头字段', Iconv::iconvMimeEncode("Subject", "Prüfung Prüfung", $preferences)));

        var_dump(static::toStr('为字符编码转换设定当前设置 iconv_set_encoding("internal_encoding", "UTF-8"); 警告 不推荐使用！！'));

        var_dump(static::toStr('返回字符串的字符数统计； "abc张三123"', Iconv::iconvStrlen("abc张三123", "UTF-8")));

        var_dump(static::toStr('查找字符串中第一次出现子字符串的位置(单位是字符数，不是字节)； "abc张三123"', Iconv::iconvStrpos("abc张三123", "1", 0,"UTF-8")));

        var_dump(static::toStr('查找字符串中最后一次出现子字符串的位置(单位是字符数，不是字节)； "123abc张三123"', Iconv::iconvStrrpos("123abc张三123", "1","UTF-8")));

        var_dump(static::toStr('截取字符串的部分(单位是字符数，不是字节)； "123abc张三123"', Iconv::iconvSubstr("123abc张三123", "3", -3,"UTF-8")));

        var_dump(static::toStr('字符串按要求的字符编码来转换; iconv("UTF-8", \'GBK\', "UTF-8") ', Iconv::iconv("UTF-8", 'GBK', "UTF-8")));

        var_dump(static::toStr('以输出缓冲处理程序转换字符编码 ob_start(\'ob_iconv_handler\');但iconv_set_encoding()这个有警告 用 ob_start("mb_output_handler") 替换'));


    }









}



