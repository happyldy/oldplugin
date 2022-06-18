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

namespace HappyLin\OldPlugin\SingleClass\TextProcessing\HLCharacterEncoding;


class Iconv{


    /**
     * 获取 iconv 扩展的内部配置变量。
     *
     * type
     *  选项 type 的值可以是：
     *      •all
     *      •input_encoding
     *      •output_encoding
     *      •internal_encoding
     *
     * @param string $type input_encoding output_encoding internal_encoding
     * @return mixed 成功时返回当前内部配置变量的值， 或者在失败时返回 FALSE。
     */
    public static function iconvGetEncoding(string $type = "all")
    {
        return iconv_get_encoding($type);
    }


    /**
     *  以输出缓冲处理程序转换字符编码
     * 将字符编码从 internal_encoding 转换到 output_encoding。
     *
     * internal_encoding 和 output_encoding 应当在 php.ini 文件 中定义。
     *
     * @param string $contents
     * @param int $status
     * @return string 关于处理程序返回值的信息，参见 ob_start()。
     */
    public static function obIconvHandler( string $contents, int $status) : string
    {
        return ob_iconv_handler( $contents, $status);
    }





    /**
     * 一次性解码多个 MIME 头字段
     *
     * $mode
     *  ICONV_MIME_DECODE_STRICT                1   如果设置了，给定的头将会以 » RFC2047 定义的标准完全一致。这个选项默认禁用，因为大量有问题的邮件用户代理不遵循标准并产生不正确的 MIME 头。
     *  ICONV_MIME_DECODE_CONTINUE_ON_ERROR     2   如果设置了，iconv_mime_decode_headers() 尝试忽略任何语法错误并继续处理指定的头。
     *
     *
     * 返回元素的每个键代表独立字段名，相应的元素代表一个字段值。如果有多个同一名称的字段， iconv_mime_decode_headers() 自动将他们按出现顺序结合成数字索引的数组。
     *
     * @param string $encoded_headers 编码过的头，是一个字符串。
     * @param int $mode 决定了 iconv_mime_decode_headers() 遇到畸形 MIME 头字段时的行为。你可以指定为以下位掩码的任意组合。
     * @param string $charset 可选参数 charset 指定了字符集结果的表现。如果省略了，将使用 iconv.internal_encoding(已废弃)。用： default_charset
     * @return array 成功时返回 encoded_headers 指定的 MIME 头的整套关联数组，解码时出现错误则返回 FALSE。
     */
    public static function iconvMimeDecodeHeaders( string $encoded_headers, int $mode = 0, string $charset = null )
    {
        $charset = $charset??ini_get("default_charset");
        return iconv_mime_decode_headers($encoded_headers, $mode, $charset);
    }


    /**
     *  解码一个MIME头字段
     *
     * $mode
     *  ICONV_MIME_DECODE_STRICT                1   如果设置了，给定的头将会以 » RFC2047 定义的标准完全一致。这个选项默认禁用，因为大量有问题的邮件用户代理不遵循标准并产生不正确的 MIME 头。
     *  ICONV_MIME_DECODE_CONTINUE_ON_ERROR     2   如果设置了，iconv_mime_decode_headers() 尝试忽略任何语法错误并继续处理指定的头。
     *
     * @param string $encoded_header 编码头,是一个字符串.
     * @param int $mode 决定了 iconv_mime_decode_headers() 遇到畸形 MIME 头字段时的行为。你可以指定为以下位掩码的任意组合。
     * @param string $charset 可选的字符集参数,用指定的字符集表示结果.如果省略, iconv.internal_encoding(已废弃)。用： default_charset
     * @return string
     */
    public static function iconvMimeDecode( string $encoded_header, int $mode = 0, string $charset = null ) : string
    {
        $charset = $charset??ini_get("default_charset");
        return iconv_mime_decode( $encoded_header, $mode, $charset );
    }


    /**
     * 组成一个MIME头字段
     * 组合并返回表示有效MIME头字段的字符串，如下所示：
     * Subject: =?ISO-8859-1?Q?Pr=FCfung_f=FCr?= Entwerfen von einer MIME kopfzeile
     * 在上述示例中，“主题”是字段名，以“=？ISO-8859-1？…”开头的部分是字段值。
     *
     *
     * $preferences
     *
     *    值             类型      默认值               例子
     *  scheme          string      B                   B           指定对字段值进行编码的方法。 此项的值可以是“B”或“Q”，其中“B”代表base64编码方案，“Q”代表引用打印编码方案。
     *  input-charset   string  default_charset     ISO-8859-1      指定显示第一个参数 field_name 和第二个参数 field_value 的字符集。 如果没有给出， ini_get("default_charset")
     *  output-charset  string  default_charset     UTF-8           指定用于组成 MIME 标头的字符集
     *  line-length     int     76                  996             指定标题行的最大长度。 根据 » RFC2822 - Internet 消息格式，结果头将被“折叠”为一组多行，以防结果头字段长于此参数的值。如果未给出，长度将限制为 76 个字符。
     *  line-break-chars string \r\n                \n              指定在长标题字段上执行“折叠”时要附加到每行的字符序列作为行尾符号。 如果未给出，则默认为 "\r\n"(CR LF)。 请注意，无论 input-charset 的值如何，此参数始终被视为 ASCII 字符串。
     *
     * @param string $field_name 字段名。
     * @param string $field_value 字段值
     * @param array $preferences 您可以通过将包含配置项的关联数组指定为可选的第三个参数首选项来控制 iconv_mime_encode() 的行为。
     * @return string 成功时返回已编码的 MIME 字段，如果在编码期间发生错误，则返回 FALSE。
     */
    public static function iconvMimeEncode( string $field_name, string $field_value, array $preferences = NULL )
    {
        return iconv_mime_encode($field_name, $field_value, $preferences );
    }


    /**
     * 为字符编码转换设定当前设置
     *
     * type
     *  选项 type 的值可以是：
     *      •all
     *      •input_encoding
     *      •output_encoding
     *      •internal_encoding
     *
     *
     * @param string $type input_encoding output_encoding internal_encoding
     * @param string $charset 字符集。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE
     */
    public static function iconvSetEncoding( $type, $charset) : bool
    {
        return iconv_set_encoding( $type, $charset);
    }


    /**
     * 返回字符串的字符数统计
     * 和 strlen() 不同的是，iconv_strlen() 统计了给定的字节序列 str 中出现字符数的统计，基于指定的字符集，其产生的结果不一定和字符字节数相等。
     *
     * @param string $str 该字符串。
     * @param string $charset 如果省略了 charset 参数，假设 str 的编码为 default_charset
     * @return int | false
     */
    public static function iconvStrlen( string $str, string $charset = null )
    {
        $charset = $charset??ini_get("default_charset");
        return iconv_strlen($str, $charset);
    }


    /**
     * 查找字符串中第一次出现子字符的位置
     *
     * 与 strpos() 相比，iconv_strpos() 的返回值是出现在子字符之前的字符数，而不是到子字符位置的偏移量（以字节为单位）。 字符是根据指定的字符集字符集计算的。
     *
     *
     * @param string $haystack 整个字符串。
     * @param string $needle 搜索到的子串。
     * @param int $offset 可选的 offset 参数指定应该从哪个位置开始搜索。如果偏移量为负，则从字符串的末尾开始计数
     * @param string $charset 如果省略 charset 参数，假设 str 的编码为 default_charset
     * @return int | false 返回 haystack 中第一次出现 Needle 的数字位置。
     */
    public static function iconvStrpos( string $haystack, string $needle, int $offset = 0, string $charset = null )
    {
        $charset = $charset??ini_get("default_charset");
        return iconv_strpos($haystack, $needle, $offset, $charset );
    }


    /**
     * 查找字符串中最后一次出现子字符的位置
     * 与 strrpos() 相比，iconv_strrpos() 的返回值是出现在针头之前的字符数，而不是到针头所在位置的偏移量（以字节为单位）。 字符是根据指定的字符集字符集计算的。
     *
     * @param string $haystack 整个字符串
     * @param string $needle 搜索到的子串
     * @param string $charset 如果省略 charset 参数，假设 str 的编码为 default_charset
     * @return int | false 返回 haystack 中最后一次出现 Needle 的数字位置。
     */
    public static function iconvStrrpos( string $haystack, string $needle, string $charset = null )
    {
        $charset = $charset??ini_get("default_charset");
        return iconv_strrpos(  $haystack,  $needle,  $charset);
    }


    /**
     * 截取字符串的部分
     * 根据 offset 和 length 参数指定 str 截取的部分
     *
     * @param string $str 原始字符串。
     * @param int $offset 如果 offset 是非负数，iconv_substr() 从 str 开头第 offset 个字符开始截出部分，从 0 开始计数。如果 offset 是负数，iconv_substr() 从 str 末尾向前 offset 个字符开始截取。
     * @param int $length 如果指定了 length 并且是正数，返回的值从 offset 截取部分，最多包含 length 个字符（取决于 string 的长度）。如果传入了负数的 length， iconv_substr() 将从第 offset 个字符到离末尾 length 个字符截出 str 的部分。
     * @param string $charset 如果省略了参数 charset，string 的编码被认定为 default_charset
     * @return string | false
     */
    public static function iconvSubstr( string $str, int $offset, int $length = null, string $charset = null )
    {
        return iconv_substr( ...func_get_args() );
    }


    /**
     * 字符串按要求的字符编码来转换
     * 将字符串 str 从 in_charset 转换编码到 out_charset。
     *
     * @param string $in_charset 输入的字符集。
     * @param string $out_charset 输出的字符集。 如果你在 out_charset 后添加了字符串 //TRANSLIT，将启用转写（transliteration）功能。这个意思是，当一个字符不能被目标字符集所表示时，它可以通过一个或多个形似的字符来近似表达。如果你添加了字符串 //IGNORE，不能以目标字符集表达的字符将被默默丢弃。否则，会导致一个 E_NOTICE并返回 FALSE。
     * @param string $str 要转换的字符串。
     * @return string | false 返回转换后的字符串， 或者在失败时返回 FALSE。
     */
    public static function iconv( string $in_charset, string $out_charset, string $str)
    {
        return iconv( $in_charset, $out_charset, $str);
    }











}

