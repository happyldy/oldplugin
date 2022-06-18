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

namespace HappyLin\OldPlugin\SingleClass\TextProcessing\HLCharacterEncoding;


class MultibyteString
{




    /**
     * 获取 mbstring 的内部设置
     *
     * $type
     *  如果没有设定 type，或者将其设定为 "all"，将会返回一个 array，并且包含了以下所有元素："internal_encoding","http_output", "http_input", "func_overload", "mail_charset","mail_header_encoding", "mail_body_encoding"。
     *  如果 type 设定为类似 "http_output","http_input", "internal_encoding", "func_overload"，将返回该参数的设置。
     *
     * @param string $type
     * @return mixed 如果没有指定 type 将返回类型信息的数组，否则将返回指定 type 的信息。
     */
    public static function mbGetInfo(string $type = "all")
    {
        return mb_get_info($type);
    }

    /**
     * 返回所有支持编码的数组
     * @return array
     */
    public static function mbListEncodings() : array
    {
        return mb_list_encodings();
    }


    /**
     * 获取已知编码类型的别名
     * 返回已知编码类型的别名数组。
     *
     * @param string $encoding 正在检查别名的编码类型。
     * @return array|false 成功返回编码别名的数字索引数组，或者在失败时返回 错误的
     */
    public static function mbEncodingAliases( string $encoding)
    {
        return mb_encoding_aliases($encoding);
    }


    /**
     *  设置/获取当前的语言
     *
     * @param string|bool $language 语言和它的设置，日文是 ISO-2022-JP/Base64，uni 是 UTF-8/Base64，英文是 ISO-8859-1/quoted。 用于编码邮件信息。有效的语言有："Japanese","ja","English","en" 和 "uni"（UTF-8）。 mb_send_mail() 使用了该设置来对邮件进行编码。
     * @return mixed 如果设置了 language，并且 language 是有效的，它将返回 TRUE。否则将返回 FALSE。当省略了 language 参数，它将返回语言名称的 string。如果之前没有设置过语言，则将返回 FALSE。
     */
    public static function mbLanguage(string $language = null)
    {
        return mb_language( ...func_get_args());
    }


    /**
     * 设置/获取内部字符编码
     *
     * @param string $encoding encoding 字符编码名称使用于 HTTP 输入字符编码转换、HTTP 输出字符编码转换、mbstring 模块系列函数字符编码转换的默认编码。 您应该注意到内部编码与多字节正则表达式的编码完全不同。
     * @return string | bool 如果设置了 encoding，则成功时返回 TRUE， 或者在失败时返回 FALSE;在这种情况下，多字节正则表达式的字符编码不会改变。 如果省略了编码，则返回当前的字符编码名称
     */
    public static function mbInternalEncoding(string $encoding = null)
    {
        return mb_internal_encoding(...func_get_args());
    }


    /**
     * 检查字符串在指定的编码里是否有效
     * 检查指定的字节流在指定的编码里是否有效。它能有效避免所谓的"无效编码攻击（Invalid Encoding Attack）"。
     *
     *
     * @param string $var 要检查的字节流。如果省略了这个参数，此函数会检查所有来自最初请求所有的输入。
     * @param string $encoding 期望的编码。  mb_internal_encoding()
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function mbCheckEncoding(string $var = NULL, string $encoding = null ) : bool
    {
        return mb_check_encoding(...func_get_args());
    }


    /**
     * 设置/获取 字符编码的检测顺序
     * 为编码列表 encoding_list 设置自动检测字符编码的顺序。
     *
     * mbstring 当前实现了以下编码检测筛选器。如有以下编码列表的无效字节序列，编码的检测将会失败。
     *  UTF-8, UTF-7, ASCII, EUC-JP,SJIS, eucJP-win, SJIS-win, JIS, ISO-2022-JP
     *  对于 ISO-8859-*，mbstring 总是检测为 ISO-8859-*。
     *  对于 UTF-16、UTF-32、 UCS2 和 UCS4，编码检测总是会失败。
     *
     * @param string|array|string[] $encoding_list  encoding_list 是一个 array 或者逗号分隔的字符编码列表。参见支持的编码。 如果省略了 encoding_list 参数，它将返回当前字符编码检测顺序的数组。  该设置会影响 mb_detect_encoding() 和 mb_send_mail()。
     * @return bool|string[] 设置编码检测顺序时候，成功时返回 TRUE，识别时候返回 FALSE。  在获取编码检测顺序的时候，会返回排序过的编码数组。
     */
    public static function mbDetectOrder( $encoding_list = null )
    {
        return mb_detect_order(...func_get_args());
    }


    /**
     * 检测字符的编码
     *
     * @param string $str 待检查的字符串。
     * @param string|array|string[] $encoding_list  是一个字符编码列表。编码顺序可以由数组或者逗号分隔的列表字符串指定。如果省略了 encoding_list 将会使用 detect_order。
     * @param bool $strict strict 指定了是否严格地检测编码。默认是 FALSE。
     * @return string 检测到的字符编码，或者无法检测指定字符串的编码时返回 FALSE。
     */
    public static function mbDetectEncoding( string $str, $encoding_list = NULL, bool $strict = false )
    {
        return mb_detect_encoding(...func_get_args());
    }





    /**
     * 检测 HTTP 输入字符编码
     *
     * @param string $type 设置的字符串指定了输入类型。 "G" 是 GET，"P" 是 POST，"C" 是 COOKIE，"S" 是 string，"L" 是 list，以及 "I" 是整个列表（将会返回 array）。如果省略了 type，它将返回最后处理的一种输入类型。
     * @return false|string 每个 type 的字符编码名称。如果 mb_http_input() 没有处理过任何指定的 HTTP 输入，它将返回 FALSE。
     */
    public static function mbTttpInput( string $type = "" )
    {
        return mb_http_input(...func_get_args());
    }


    /**
     * 设置/获取 HTTP 输出字符编码
     *
     * @param string|bool $encoding  如果设置了 encoding，mb_http_output() 设置 HTTP 输出字符编码为 encoding。 如果省略了 encoding，mb_http_output() 返回当前的 HTTP 输出字符编码。
     * @return mixed 如果省略了 encoding，mb_http_output() 返回当前的 HTTP 输出字符编码。否则成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function mbHttpOutput(string $encoding = null)
    {
        return mb_http_output(...func_get_args());
    }

    /**
     * 在输出缓冲中转换字符编码的回调函数
     * 是一个 ob_start() 回调函数。 mb_output_handler() 将输出缓冲中的字符从内部字符编码转换为 HTTP 输出的字符编码。
     *
     * 当遇到以下条件的时候，该函数将添加 HTTP 字符编码头：
     * ◦ 未使用 header() 设置 Content-Type。
     * ◦ 默认 MIME 类型以 text/ 开始。
     * ◦ mbstring.http_input 是除 pass 外的任意设置。
     *
     * Note:如果你想要输出二进制数据，比如图片，必须在任何二进制数据发送到客户端之前使用 header() 来设置 Content-Type: 头。（例如 header("Content-Type: image/png")）。如果 Content-Type: 头已发送，输出字符编码的转换将不会执行。
     *      注意，如果发送了 'Content-Type: text/*'，则内容被认为是文本，将发生转换。
     *
     * @param string $contents 输出缓冲的内容。
     * @param int $status 输出缓冲的状态。
     * @return string 转换后的 string。
     */
    public static function mbOutputHandler( string $contents, int $status) : string
    {
        return mb_output_handler(...func_get_args());
    }


    /**
     * 获取 MIME 字符串
     * 获取指定编码的 MIME 字符 string。
     *
     * @param string $encoding 要检查的字符串。
     * @return string 字符编码 encoding 的 MIME charset string。
     */
    public static function mbPreferredMimeName( string $encoding) : string
    {
        return mb_preferred_mime_name( $encoding);
    }


    /**
     *  解码 MIME 头字段中的字符串
     *
     * @param string $str 要解码的 string。
     * @return string 以内部（internal）字符编码解码的 string。
     */
    public static function mbDecodeMimeheader( string $str) : string
    {
        return mb_decode_mimeheader($str);
    }



    /**
     * 为 MIME 头编码字符串
     * 按 MIME 头编码方案将指定的字符串 str 进行编码。
     * 这个函数没有设计成据更高级上下文的中断点来换行（单词边界等）。这个特性将导致意外的空格可能会让原始字符串看上去很乱。
     *
     * @param string $str 要编码的 string。它的编码应该和 mb_internal_encoding() 一样。
     * @param string $charset  指定了 str 的字符集名。其默认值由当前的 NLS 设置（mbstring.language）来确定。
     * @param string $transfer_encoding 指定了 MIME 的编码方案。它可以是 "B"（Base64）也可以是 "Q"（Quoted-Printable）。如果未设置，将回退为 "B"。
     * @param string $linefeed linefeed 指定了 EOL（行尾）标记，使 mb_encode_mimeheader() 执行了一个换行（» RFC 文档中规定，超过长度的一行将换成多行，当前该长度硬式编码为 74 个字符）。如果没有设定，则回退为 "\r\n" (CRLF)。
     * @param int $indent 首行缩进（header 里 str 前的字符数目）。
     * @return string 转换后的字符串版本以 ASCII 形式表达。
     */
    public static function mbEncodeMimeheader( string $str, string $charset = null, string $transfer_encoding = "B", string $linefeed = "\r\n", int $indent = 0 ) : string
    {
        return mb_encode_mimeheader(...func_get_args());
    }


    /**
     * 发送编码过的邮件
     * 发送邮件。邮件头和内容根据 mb_language() 设置来转换编码。这是 mail() 的一个包装器函数，所以详情参见 mail()。
     *
     * $additional_headers
     *  发送邮件时，邮件必须包含发件人标头。 这可以使用 additional_headers 参数设置，或者可以在 php.ini 中设置默认值。
     *  如果未收到消息，请尝试仅使用 LF (\n)。一些 Unix 邮件传输代理（最著名的是 » qmail）自动将 LF 替换为 CRLF（如果使用 CRLF，则会导致 CR 加倍）。这应该是最后的手段， 因为它不符合 » RFC 2822
     *
     * $additional_parameter
     *  该参数由escapeshellcmd() 内部转义以防止命令执行。 escapeshellcmd() 阻止命令执行，但允许添加附加参数。 出于安全原因，应验证此参数。
     *  由于 escapeshellcmd() 是自动应用的，因此无法使用 Internet RFC 允许作为电子邮件地址的某些字符。 不能使用需要使用这些字符 mail() 的程序
     *  当使用此方法设置信封发件人 (-f) 时，应将网络服务器运行的用户作为受信任用户添加到 sendmail 配置中，以防止将“X-Warning”标头添加到邮件中。对于 sendmail 用户，这 文件是 /etc/mail/trusted-users。
     * @param string $to 被发送到该邮件地址。可通过逗号分隔地址的 to 来指定多个收件人。该参数不会被自动编码。
     * @param string $subject 邮件标题。
     * @param string $message 邮件消息。
     * @param string $additional_headers  要插入到电子邮件标题末尾的字符串。这通常用于添加额外的标头（From、Cc 和 Bcc）。多个额外的标头应使用 CRLF (\r\n) 分隔。验证参数不会被攻击者注入不需要的标头。
     * @param string $additional_parameter 是一个 MTA 命令行参数。在使用 sendmail 时对设置正确的返回路径头很有帮助。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function mb_send_mail( string $to, string $subject, string $message, string $additional_headers = NULL, string $additional_parameter = NULL ) : bool
    {
        return mb_send_mail(...func_get_args());
    }


    /**
     * 清理损坏的多字节字符串。
     *
     * @param $string
     * @param null $encoding
     * @return false|string|string[]|null
     */
    public static function mbScrub($string, $encoding = null)
    {
        return mb_scrub(...func_get_args());
    }




    // ··············································· 正则 ························································



    /**
     * 设置/获取多字节正则表达式的字符编码
     *
     * mb_ereg 功能是通过 Oniguruma RegEx 库而不是通过 PCRE 提供的。
     * 与 mb_list_encodings() 和 mb_encoding_aliases() 相比，mb_regex_encoding() 仅支持编码名称的子集。
     * 目前支持以下名称（不区分大小写）：
     *
     *  UCS-4
     *  UCS-4LE
     *  UTF-32
     *  UTF-32BE
     *  UTF-32LE
     *  UTF-16
     *  UTF-16BE
     *  UTF-16LE
     *  UTF-8
     *  utf8
     *  ASCII
     *  US-ASCII
     *  EUC-JP
     *  eucJP
     *  x-euc-jp
     *  SJIS
     *  eucJP-win
     *  SJIS-win
     *  CP932
     *  MS932
     *  Windows-31J
     *  ISO-8859-1
     *  ISO-8859-2
     *  ISO-8859-3
     *  ISO-8859-4
     *  ISO-8859-5
     *  ISO-8859-6
     *  ISO-8859-7
     *  ISO-8859-8
     *  ISO-8859-9
     *  ISO-8859-10
     *  ISO-8859-13
     *  ISO-8859-14
     *  ISO-8859-15
     *  ISO-8859-16
     *  EUC-CN
     *  EUC_CN
     *  eucCN
     *  gb2312
     *  EUC-TW
     *  EUC_TW
     *  eucTW
     *  BIG-5
     *  CN-BIG5
     *  BIG-FIVE
     *  BIGFIVE
     *  EUC-KR
     *  EUC_KR
     *  eucKR
     *  KOI8-R
     *  KOI8R
     *
     * @param string|bool $encoding 字符编码。如果省略，则使用内部字符编码。
     * @return mixed 如果设置了encoding，则成功时返回TRUE，或者在失败时返回FALSE。在这种情况下，不改变内部字符编码。如果省略encoding，则返回多字节正则表达式的当前字符编码名称。
     */
    public static function mbRegexEncoding(string $encoding = null )
    {
        return mb_regex_encoding(...func_get_args());
    }


    /**
     * 设置/获取mbregex函数的默认选项
     * 设置由多字节正则表达式函数的选项描述的默认选项。
     *
     * options
     *  i   Ambiguity match on  歧义匹配(不区分大小写)
     *  x   Enables extended pattern form 启用扩展模式形式（注释）
     *  m   '.' matches with newlines 与换行符匹配
     *  s   '^' -> '\A', '$' -> '\Z'
     *  p   与 m 和 s 选项相同
     *  l   查找最长匹配
     *  n   忽略空匹配
     *  e   eval() 结果代码
     *
     *
     * options model
     *  j   Java (Sun java.util.regex)
     *  u   GNU regex
     *  g   grep
     *  c   Emacs
     *  r   Ruby
     *  z   Perl
     *  b   POSIX Basic regex
     *  d   POSIX Extended regex
     *
     * @param string $options 要设置的选项。 这是一个字符串，其中每个字符都是一个选项。 要设置模式，模式字符必须是最后一组，但只能设置一种模式，但可以设置多个选项。
     * @return string 之前的选项。 如果省略选项，则返回描述当前选项的字符串。  php8 如果给出了参数选项，则返回先前的选项。 以前，已返回当前选项。
     */
    public static function mbRegexSetOptions(string $options = null) : string
    {
        return mb_regex_set_options(...func_get_args());
    }


    /**
     * 正则表达式匹配多字节支持
     * 执行具有多字节支持的正则表达式匹配
     *
     * @param string $pattern 搜索模式。
     * @param string $string 搜索字符串。
     * @param array $regs 如果找到带括号的模式子串的匹配项; $regs[1] 将包含从第一个左括号开始的子字符串； $regs[2] 将包含从第二个开始的子字符串，依此类推。 $regs[0] 将包含完整字符串匹配的副本
     * @return int 如果在字符串中找到模式匹配，则返回匹配字符串的字节长度，如果未找到匹配或发生错误，则返回 FALSE。如果未传递可选参数 regs 或匹配字符串的长度为 0，则此函数返回 1。
     */
    public static function mbEreg( string $pattern, string $string, array &$regs = null ) : int
    {
        if(isset($regs)){
            return mb_ereg( $pattern, $string, $regs );
        }
        return mb_ereg( ...func_get_args());
    }



    /**
     * 正则表达式匹配忽略大小写，支持多字节
     * 使用多字节支持执行不区分大小写的正则表达式匹配。
     *
     * @param string $pattern 正则表达式模式。
     * @param string $string 正在搜索的字符串
     */
    /**
     * 正则表达式匹配忽略大小写，支持多字节
     * 使用多字节支持执行不区分大小写的正则表达式匹配。
     *
     * @param string $pattern 正则表达式模式。
     * @param string $string 正在搜索的字符串
     * @param array $regs  如果找到带括号的模式子串的匹配项; $regs[1] 将包含从第一个左括号开始的子字符串； $regs[2] 将包含从第二个开始的子字符串，依此类推。 $regs[0] 将包含完整字符串匹配的副本
     * @return int | bool  如果在字符串中找到模式匹配，则返回匹配字符串的字节长度，如果未找到匹配或发生错误，则返回 FALSE。如果未传递可选参数 regs 或匹配字符串的长度为 0，则此函数返回 1。
     */
    public static function mbEregi( string $pattern, string $string, array &$regs = null) : int
    {

        if(isset($regs)){
            return mb_eregi( $pattern, $string, $regs );
        }
        return mb_eregi( ...func_get_args());
    }



    /**
     * 多字节字符串的正则表达式匹配
     *
     * @param string $pattern 正则表达式模式。
     * @param string $string 被评估的字符串。
     * @param string $option 搜索选项。 有关解释，请参阅 mb_regex_set_options()。
     * @return bool 如果字符串与正则表达式模式匹配，则返回 TRUE，否则返回 FALSE。
     */
    public static function mbEregMatch( string $pattern, string $string, string $option = "msr" ) : bool
    {
        return mb_ereg_match( ...func_get_args());
    }


    /**
     * 用多字节支持替换正则表达式
     * 扫描与模式匹配的字符串，然后用替换替换匹配的文本
     *
     * @param string $pattern 正则表达式模式。
     * @param string $replacement 替换文本。
     * @param string $string 被检查的字符串
     * @param string $option 搜索选项。 有关解释，请参阅 mb_regex_set_options()。
     * @return string | false  成功时返回结果字符串，错误时返回 FALSE。
     */
    public static function mbEregReplace( string $pattern, string $replacement, string $string, string $option = "msr")
    {
        return mb_ereg_replace(...func_get_args());
    }


    /**
     * 用忽略大小写的多字节支持替换正则表达式
     * 扫描与模式匹配的字符串，然后用替换替换匹配的文本。
     *
     * @param string $pattern 正则表达式模式。 可以使用多字节字符。 大小写将被忽略。
     * @param string $replace 替换文本。
     * @param string $string 被检查的字符串
     * @param string $option 搜索选项。 有关解释，请参阅 mb_regex_set_options()。
     * @return string | false 结果字符串或错误时为 FALSE。
     */
    public static function mbEregiReplace( string $pattern, string $replace, string $string, string $option = "msri" )
    {
        return mb_eregi_replace(...func_get_args());
    }





    /**
     * 为多字节正则表达式匹配设置字符串和正则表达式
     * 为多字节正则表达式设置字符串和模式。 这些值用于 mb_ereg_search()、mb_ereg_search_pos() 和 mb_ereg_search_regs()。
     *
     * @param string $string 搜索字符串。
     * @param string $pattern 搜索模式。
     * @param string $option 搜索选项。 有关解释，请参阅 mb_regex_set_options()。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function mbEregSearchInit( string $string, string $pattern = null, string $option = "msr" ) : bool
    {
        return mb_ereg_search_init(...func_get_args());
    }


    /**
     * 预定义多字节字符串的多字节正则表达式匹配
     *
     * @param string $pattern 搜索模式。
     * @param string $option 搜索选项。 有关解释，请参阅 mb_regex_set_options()。
     * @return bool 如果多字节字符串与正则表达式匹配，返回 TRUE，否则返回 FALSE。 匹配的字符串由mb_ereg_search_init() 设置。 如果未指定模式，则使用前一个模式。
     */
    public static function mbEregSearch( string $pattern = null, string $option = "ms" ) : bool
    {
        return mb_ereg_search(...func_get_args());
    }

    /**
     * 返回预定义多字节字符串的多字节正则表达式匹配部分的位置和长度
     *
     * @param string $pattern 搜索模式。
     * @param string $option 搜索选项。 有关解释，请参阅 mb_regex_set_options()。
     * @return array | false 包含两个元素的数组。 第一个元素是偏移量（以字节为单位），其中匹配相对于搜索字符串的开头开始，第二个元素是匹配的长度（以字节为单位）。如果发生错误，则返回 FALSE
     */
    public static function mbEregSearchPos(string $pattern = null, string $option = "ms")
    {
        return mb_ereg_search_pos(...func_get_args());
    }



    /**
     * 返回多字节正则表达式的匹配部分
     *
     * @param string $pattern 搜索模式。
     * @param string $option 搜索选项。 有关解释，请参阅 mb_regex_set_options()。
     * @return array 如果有匹配的部分，则返回一个数组，包括匹配部分的子串作为第一个元素，第一个带括号的分组部分作为第二个元素，第二个分组的部分作为第三个元素，依此类推。 出错时返回 FALSE。
     */
    public static function mbEregSearchRegs(string $pattern = null, string $option = "ms" ) : array
    {
        return mb_ereg_search_regs(...func_get_args());
    }

    /**
     * 从最后一个多字节正则表达式匹配中检索结果
     * 一个包含最后一个 mb_ereg_search(), mb_ereg_search_pos(), mb_ereg_search_regs() 匹配部分的子串的数组。
     *
     * @return array 如果有匹配，第一个元素将有匹配的子字符串，第二个元素将第一部分用括号分组，第三个元素将第二部分用括号分组，依此类推。 出错时返回 FALSE；
     */
    public static function mbEregSearchGetregs()
    {
        return mb_ereg_search_getregs();
    }

    /**
     * 设置下一个正则表达式匹配的起点
     *
     * @param int $position 要设置的位置。 如果是负数，则从字符串的末尾开始计数。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function mbEregSearchSetpos( int $position) : bool
    {
        return mb_ereg_search_setpos($position);
    }


    /**
     * 返回下一个正则表达式匹配的起点
     * @return int  返回 mb_ereg_search()、mb_ereg_search_pos()、mb_ereg_search_regs() 正则表达式匹配的起始点。 该位置由从字符串头部开始的字节表示。
     */
    public static function mbEregSearchGetpos() : int
    {
        return mb_ereg_search_getpos();
    }




    // ······························· 编码转换 ··························································


    /**
     * 转换字符的编码
     * 将 string 类型 str 的字符编码从可选的 from_encoding 转换到 to_encoding。
     *
     * @param string $str 要编码的 string。
     * @param string $to_encoding str 要转换成的编码类型。
     * @param string|string[] $from_encoding 在转换前通过字符代码名称来指定。它可以是一个 array 也可以是逗号分隔的枚举列表。如果没有提供 from_encoding，则会使用内部（internal）编码。 mb_internal_encoding()
     * @return string 编码后的 string。
     */
    public static function mbConvertEncoding( string $str, string $to_encoding, $from_encoding = null ) : string
    {
        return mb_convert_encoding( ...func_get_args());
    }


    /**
     * 转换一个或多个变量的字符编码
     * 将变量 vars 的编码从 from_encoding 转换成编码 to_encoding。
     *
     * 会拼接变量数组或对象中的字符串来检测编码，因为短字符串的检测往往会失败。因此，不能在一个数组或对象中混合使用编码。
     *
     * @param string $to_encoding 将 string 转换成这个编码
     * @param $from_encoding from_encoding 可以指定为一个 array 或者逗号分隔的 string，它将尝试根据 from-coding 来检测编码。当省略了 from_encoding，将使用 detect_order。
     * @param mixed ...$vars vars 是要转换的变量的引用。参数可以接受 String、Array 和 Object 的类型。 mb_convert_variables() 假设所有的参数都具有同样的编码。
     * @return string 成功时返回转换前的字符编码，失败时返回 FALSE。
     */
    public static function mbConvertVariables(string $to_encoding, $from_encoding, &...$vars) : string
    {
        return mb_convert_variables($to_encoding, $from_encoding, ...$vars);
    }


    /**
     * 转换字符串第一个字节为指定编码的int值
     *
     * @param string $str
     * @param string $encoding
     * @return int|false
     */
    public static function mbOrd( string $str, string $encoding = null)
    {
        return mb_ord(...func_get_args());
    }


    /**
     * 返回相对应于 $encoding 编码所指定的单个字符。
     *
     * @param int $cp
     * @param string $encoding
     * @return string|false
     */
    public static function mbChr( int $cp, string $encoding = null )
    {
        return mb_chr(...func_get_args());
    }


    /**
     * 根据 HTML 数字字符串解码成字符
     * 将数字字符串的引用str 按指定的字符块转换成字符串。
     *
     * $convmap = array (
     *  int start_code1, int end_code1, int offset1, int mask1,
     *  int start_code2, int end_code2, int offset2, int mask2,
     *  ........
     *  int start_codeN, int end_codeN, int offsetN, int maskN );
     *
     *
     * @param string $str 要解码的 string。
     * @param array $convmap  convmap 是一个 array，指定了要转换的代码区域。
     * @param string|bool $encoding encoding 参数为字符编码。如果省略，则使用内部字符编码。mb_internal_encoding()
     * @return string 转换后的字符串。
     */
    public static function mbDecodeNumericentity( string $str, array $convmap, string $encoding = null ) : string
    {
        return mb_decode_numericentity(...func_get_args());
    }



    /**
     * 将字符串 str 中的指定字符代码从字符代码转换为 HTML 数字字符引用。
     *
     * $convmap = array (
     *  int start_code1, int end_code1, int offset1, int mask1,
     *  int start_code2, int end_code2, int offset2, int mask2,
     *  ........
     *  int start_codeN, int end_codeN, int offsetN, int maskN );
     *
     * @param string $str 被编码的字符串。
     * @param array $convmap 数组指定要转换的代码区域。
     * @param string|bool $encoding 参数为字符编码。如果省略，则使用内部字符编码。 mb_internal_encoding()
     * @param bool $is_hex 返回的实体引用是否应为十六进制表示法（否则为十进制表示法）
     * @return string 转换后的字符串。
     */
    public static function mbEncodeNumericentity( string $str, array $convmap, string $encoding = null, bool $is_hex = FALSE ) : string
    {
        return mb_encode_numericentity(...func_get_args());
    }


    /**
     * 解析 GET/POST/COOKIE 数据并设置全局变量
     * 由于 PHP 不提供原始 POST/COOKIE 数据，目前它仅能够用于 GET 数据。它解析了 URL 编码过的数据，检测其编码，并转换编码为内部编码，然后设置其值为 array 的 result 或者全局变量。
     *
     * @param string $encoded_string URL 编码过的数据。
     * @param array $result 一个 array，包含解码过的、编码转换后的值。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function mbParseStr( string $encoded_string, array &$result ) : bool
    {
        return mb_parse_str($encoded_string, $result );
    }


    /**
     * 从另一个转换“假名”（“zen-kaku”、“han-kaku”等）
     * 将半角的平假名、片假名转化为全角，或者是全角转化为半角。主要用在对用户的输入进行处理。在日语中使用
     * $option
     *  r   将“zen-kaku”字母转换为“han-kaku”
     *  R   将“han-kaku”字母转换为“zen-kaku”
     *  n   将“zen-kaku”数字转换为“han-kaku”
     *  N   将“han-kaku”数字转换为“zen-kaku”
     *  a   将“zen-kaku”字母和数字转换为“han-kaku”
     *  A   将“han-kaku”字母和数字转换为“zen-kaku”（“a”、“A”选项中包含的字符为U+0021 - U+007E，不包括U+0022、U+0027、U+005C、U+ 007E)
     *  s   将“zen-kaku”空间转换为“han-kaku”（U+3000 -> U+0020）
     *  S   将“han-kaku”空间转换为“zen-kaku”（U+0020 -> U+3000）
     *  k   将“zen-kaku kata-kana”转换为“han-kaku kata-kana”
     *  K   将“han-kaku kata-kana”转换为“zen-kaku kata-kana”
     *  h   将“zen-kaku hira-gana”转换为“han-kaku kata-kana”
     *  H   将“han-kaku kata-kana”转换为“zen-kaku hira-gana”
     *  c   将“zen-kaku kata-kana”转换为“zen-kaku hira-gana”
     *  C   将“zen-kaku hira-gana”转换为“zen-kaku kata-kana”
     *  V   折叠浊音符号并将它们转换为字符。 与“K”、“H”一起使用
     *
     * @param string $str 被转换的字符串。
     * @param string $option 转换选项。
     * @param string|bool $encoding encoding 参数为字符编码。如果省略，则使用内部字符编码。
     * @return string 转换后的字符串
     */
    public static function mb_convert_kana( string $str, string $option = "KV", string $encoding = null ) : string
    {
        return mb_convert_kana(...func_get_args());
    }




    /**
     * 设置/获取替代字符
     * 当输入字符的编码是无效的，或者字符代码不存在于输出的字符编码中时，可以为其指定一个替代字符。无效字符可以被替换为 NULL（不输出）、string 或者 integer 值（Unicode 字符代码的值）。
     * 该设置会影响 mb_convert_encoding()、 mb_convert_variables()、 mb_output_handler() 和 mb_send_mail()。
     *
     * substchar
     * 指定 Unicode 值为一个 integer，或者是以下字符串中的一个：
     * ◦ "none":：不输出
     * ◦ "long"：输出字符代码的值（比如：U+3000、JIS+7E7E）
     * ◦ "entity"：输出字符的实体（比如：&#x200;）
     *
     * @param mixed|bool|int|string $substchar
     * @return mixed 如果设置了 substchar，在成功时返回 TRUE，失败时返回 FALSE。如果没有设置 substchar，它将返回当前设置。
     */
    public static function mbSubstituteCharacter( $substchar = null)
    {
        return mb_substitute_character(...func_get_args());
    }












    // ··············································· 字符串操作 ························································


    /**
     * 获取字符串的长度
     *
     * @param string $str 要检查长度的字符串。
     * @param string|bool $encoding 字符编码。如果省略，则使用内部字符编码。
     * @return mixed 具有 encoding 编码的字符串 str 包含的字符数。多字节的字符被计为 1。如果给定的 encoding 无效则返回 FALSE
     */
    public static function mbStrlen( string $str , string $encoding = null)
    {
        return mb_strlen(...func_get_args());
    }


    /**
     * 使字符串小写
     *
     * @param string $str 要被小写的字符串。
     * @param string|bool $encoding 字符编码。如果省略，则使用内部字符编码。
     * @return string 返回所有字母字符转换成小写的 str。
     */
    public static function mbStrtolower( string $str, string $encoding = null) : string
    {
        return mb_strtolower(...func_get_args());
    }

    /**
     * 使字符串大写
     *
     * @param string $str 要大写的 string。
     * @param string|bool $encoding 字符编码。如果省略，则使用内部字符编码。
     * @return string str 里所有的字母都转换成大写的。
     */
    public static function mbStrtoupper( string $str, string $encoding = null) : string
    {
        return mb_strtoupper(...func_get_args());
    }

    /**
     * 对字符串进行大小写转换
     * 和类似 strtolower()、strtoupper() 的标准大小写转换函数相比，大小写转换的执行根据 Unicode 字符属性的基础。因此此函数的行为不受语言环境（locale）设置的影响，能够转换任意具有"字母"属性的字符，例如元音变音A（?）。
     *
     * @param string $str 要被转换的 string。
     * @param int $mode 转换的模式。它可以是 MB_CASE_UPPER、 MB_CASE_LOWER 和 MB_CASE_TITLE 的其中一个。
     * @param string $encoding encoding 参数为字符编码。如果省略，则使用内部字符编码。 mb_internal_encoding()
     * @return string 按 mode 指定的模式转换 string 大小写后的版本
     */
    public static function mbConvertCase( string $str, int $mode, string $encoding = null ) : string
    {
        return mb_convert_case(...func_get_args());
    }


    /**
     * 使用正则表达式分割多字节字符串
     * 使用正则表达式 pattern 分割多字节 string 并返回结果 array。
     *
     * @param string $pattern 正则表达式。
     * @param string $string 待分割的 string。
     * @param int $limit 如果指定了可选参数 limit，将最多分割为 limit 个元素。
     * @return array
     */
    public static function mbSplit( string $pattern, string $string, int $limit = -1 ) : array
    {
        return mb_split(...func_get_args());
    }


    /**
     * 给定一个多字节字符串，返回它的字符数组
     * 此函数将返回一个字符串数组，它是 str_split() 的一个版本，支持可变字符大小的编码以及 1,2 或 4 字节字符的固定大小编码。
     * 如果指定了 split_length 参数，则字符串 被分解为以字符（而不是字节）为单位的指定长度的块。
     * 可以选择指定编码参数，这样做是一种很好的做法。
     *
     * @param string $string 要拆分为字符或块的字符串
     * @param int $split_length 如果指定，则返回数组的每个元素将由多个字符组成，而不是单个字符。
     * @param string $encoding encoding 参数为字符编码。如果省略，则使用内部字符编码。
     * @return array|false 返回一个字符串数组，或者在失败时返回 FALSE。
     */
    public static function mbStrSplit( string $string, int $split_length = 1, string $encoding = null )
    {
        return mb_str_split(...func_get_args());
    }



    /**
     * 获取部分字符串
     * 根据字符数执行一个多字节安全的 substr() 操作。位置是从 str 的开始位置进行计数。第一个字符的位置是 0。第二个字符的位置是 1，以此类推。
     *
     * @param string $str 从该 string 中提取子字符串
     * @param int $start 如果 start 不是负数，返回的字符串会从 str 第 start 的位置开始，从 0 开始计数。如果 start 是负数，返回的字符串是从 str 末尾处第 start 个字符开始的。
     * @param int $length str 中要使用的最大字符数。如果省略了此参数或者传入了 NULL，则会提取到字符串的尾部。
     * @param string $encoding encoding 参数为字符编码。如果省略，则使用内部字符编码。
     * @return string 根据 start 和 length 参数返回 str 中指定的部分。
     */
    public static function mbSubstr( string $str, int $start, int $length = NULL, string $encoding = null) : string
    {
        return mb_substr(...func_get_args());
    }

    /**
     * 获取字符的一部分
     * mb_strcut() 和 mb_substr() 类似，都是从字符串中提取子字符串，但是按字节数来执行，而不是字符个数。
     * 如果截断位置位于多字节字符两个字节的中间，将于该字符的第一个字节开始执行。这也是和 substr() 函数的不同之处，后者简单地将字符串在字节之间截断，这将导致一个畸形的字节序列。
     *
     * @param string $str 要截断的 string。
     * @param int $start 如果 start 不是负数，返回的字符串会从 str 第 start 的位置开始，从 0 开始计数。如果 start 是负数，返回的字符串是从 str 末尾处第 start 个字符开始的。
     * @param int $length str 中要使用的最大字符数。如果省略了此参数或者传入了 NULL，则会提取到字符串的尾部。
     * @param string $encoding encoding 参数为字符编码。如果省略，则使用内部字符编码。
     * @return string mb_strcut() 根据 start 和 length 参数返回 str 的一部分。
     */
    public static function mbStrcut( string $str, int $start, int $length = NULL, string $encoding = null ) : string
    {
        return mb_strcut(...func_get_args());
    }


    /**
     * 返回字符串的宽度
     * 多字节字符通常是单字节字符的两倍宽度。
     *
     *  U+0000 - U+0019     0           0-25
     *  U+0020 - U+1FFF     1           32-8191
     *  U+2000 - U+FF60     2           8192-65376
     *  U+FF61 - U+FF9F     1           65377-65439
     *  U+FFA0 -            2           65440-
     *
     * @param string $str 待解码的 string。
     * @param string|bool $encoding 参数为字符编码。如果省略，则使用内部字符编码。
     * @return int string str 的宽度。
     */
    public static function mbStrwidth( string $str, string $encoding = null ) : int
    {
        return mb_strwidth(...func_get_args());
    }

    /**
     * 获取按指定宽度截断的字符串
     * 按 width 将字符串 str 截短。
     *
     * @param string $str 要截短的 string。
     * @param int $start 开始位置的偏移。从这些字符数开始的截取字符串。（默认是 0 个字符）如果 start 是负数，就是字符串结尾处的字符数。
     * @param int $width  所需修剪的宽度。负数的宽度是从字符串结尾处统计的。
     * @param string $trimmarker 当字符串被截短的时候，将此字符串添加到截短后的末尾。
     * @param string|bool $encoding encoding 参数为字符编码。如果省略，则使用内部字符编码。
     * @return string 截短后的 string。如果设置了 trimmarker，还将结尾处的字符替换为 trimmarker ，并符合 width 的宽度。
     */
    public static function mbStrimwidth( string $str, int $start, int $width, string $trimmarker = "", string $encoding = null ) : string
    {
        return mb_strimwidth(...func_get_args());
    }



    /**
     * 查找字符串在另一个字符串中首次出现的位置
     * 基于字符数执行一个多字节安全的 strpos() 操作。第一个字符的位置是 0，第二个字符的位置是 1，以此类推。
     *
     * @param string $haystack 要被检查的 string。
     * @param string $needle 在 haystack 中查找这个字符串。和 strpos() 不同的是，数字的值不会被当做字符的顺序值。
     * @param int $offset 搜索位置的偏移。如果没有提供该参数，将会使用 0。负数的 offset 会从字符串尾部开始统计。
     * @param string|bool $encoding encoding 参数为字符编码。如果省略，则使用内部字符编码。
     * @return int 返回 string 的 haystack 中 needle 首次出现位置的数值。如果没有找到 needle，它将返回 FALSE。
     */
    public static function mbStrpos( string $haystack, string $needle, int $offset = 0, string $encoding = null)
    {
        return mb_strpos(...func_get_args());
    }

    /**
     * 大小写不敏感地查找字符串在另一个字符串中首次出现的位置
     * 返回 needle 在字符串 haystack 中首次出现位置的数值。和 mb_strpos() 不同的是，mb_stripos() 是大小写不敏感的。如果 needle 没找到，它将返回 FALSE。
     *
     * @param string $haystack 要被检查的 string。
     * @param string $needle 在 haystack 中查找这个字符串。和 strpos() 不同的是，数字的值不会被当做字符的顺序值。
     * @param int $offset 搜索位置的偏移。如果没有提供该参数，将会使用 0。负数的 offset 会从字符串尾部开始统计。
     * @param string|bool $encoding encoding 参数为字符编码。如果省略，则使用内部字符编码。
     * @return int 返回字符串 haystack 中 needle 首次出现位置的数值。如果没有找到 needle，它将返回 FALSE。
     */
    public static function mbStripos( string $haystack, string $needle, int $offset = 0, string $encoding = null)
    {
        return mb_stripos(...func_get_args());
    }


    /**
     * 查找字符串在一个字符串中最后出现的位置
     * 基于字符数执行一个多字节安全的 strrpos() 操作。 needle 的位置是从 haystack 的开始进行统计的。第一个字符的位置是 0，第二个字符的位置是 1。
     *
     * @param string $haystack 查找 needle 在这个 string 中最后出现的位置。
     * @param string $needle 在 haystack 中查找这个 string。
     * @param int $offset 可以用于指定 string 里从任意字符数开始进行搜索。负数的值将导致搜索会终止于指向 string 末尾的任意点。
     * @param string|null $encoding 字符编码。如果省略，则使用内部字符编码。
     * @return int 返回 string 的 haystack 中，needle 最后出现位置的数值。如果没有找到 needle，它将返回 FALSE。
     */
    public static function mbStrrpos( string $haystack, string $needle, int $offset = 0, string $encoding = null)
    {
        return mb_strrpos(...func_get_args());
    }


    /**
     * 大小写不敏感地在字符串中查找一个字符串最后出现的位置
     * 基于字符数执行一个多字节安全的 strripos() 操作。 needle 的位置是从 haystack 的开始进行统计的。第一个字符的位置是 0，第二个字符的位置是 1。和 mb_strrpos() 不同的是，mb_strripos() 是大小写不敏感的。
     *
     * @param string $haystack 查找 needle 在这个字符串中最后出现的位置。
     * @param string $needle 在 haystack 中查找这个字符串。
     * @param int $offset 在 haystack 中开始搜索的位置
     * @param string|null $encoding 使用的字符编码名称。如果省略了，则将使用内部编码。
     * @return int 返回 string 的 haystack 中，needle 最后出现位置的数值。如果没有找到 needle，它将返回 FALSE。
     */
    public static function mbStrripos( string $haystack, string $needle, int $offset = 0, string $encoding = null)
    {
        return mb_strripos(...func_get_args());
    }


    /**
     * 查找字符串在另一个字符串里的首次出现
     * mb_strstr() 查找了 needle 在 haystack 中首次的出现并返回 haystack 的一部分。如果 needle 没有找到，它将返回 FALSE。
     *
     * @param string $haystack  要获取 needle 首次出现的字符串。
     * @param string $needle 在 haystack 中查找这个字符串。
     * @param bool $before_needle 决定这个函数返回 haystack 的哪一部分。如果设置为 TRUE，它返回 haystack 中从开始到 needle 出现位置的所有字符（不包括 needle）。如果设置为 FALSE，它返回 haystack 中 needle 出现位置到最后的所有字符（包括了 needle）。
     * @param string|bool $encoding  要使用的字符编码名称。如果省略该参数，将使用内部字符编码。
     * @return string 返回 haystack 的一部分，或者 needle 没找到则返回 FALSE。
     */
    public static function mbStrstr( string $haystack, string $needle, bool $before_needle = false, string $encoding = null )
    {
        return mb_strstr(...func_get_args());
    }


    /**
     * 大小写不敏感地查找字符串在另一个字符串里的首次出现
     * mb_strstr() 查找了 needle 在 haystack 中首次的出现并返回 haystack 的一部分。和 mb_strstr() 不同的是，mb_stristr() 是大小写不敏感的。如果 needle 没有找到，它将返回 FALSE。
     *
     * @param string $haystack 要获取 needle 首次出现的字符串。
     * @param string $needle 在 haystack 中查找这个字符串。
     * @param bool $before_needle 决定这个函数返回 haystack 的哪一部分。如果设置为 TRUE，它返回 haystack 中从开始到 needle 出现位置的所有字符（不包括 needle）。如果设置为 FALSE，它返回 haystack 中 needle 出现位置到最后的所有字符（包括了 needle）。
     * @param string|bool $encoding 要使用的字符编码名称。如果省略该参数，将使用内部字符编码。
     * @return string 返回 haystack 的一部分，或者 needle 没找到则返回 FALSE。
     */
    public static function mbStristr( string $haystack, string $needle, bool $before_needle = false, string $encoding = null)
    {
        return mb_stristr(...func_get_args());
    }


    /**
     * 查找指定字符在另一个字符串中最后一次的出现
     * mb_strrchr() 查找了 needle 在 haystack 中最后一次出现的位置，并返回 haystack 的部分。如果没有找到 needle，它将返回 FALSE。
     *
     * @param string $haystack 在该字符串中查找 needle 最后出现的位置
     * @param string $needle 在 haystack 中查找这个字符串
     * @param bool $part 决定这个函数返回 haystack 的哪一部分。如果设置为 TRUE，它将返回的字符是从 haystack 的开始到 needle 最后出现的位置。如果设置为 FALSE，它将返回的字符是从 needle 最后出现的位置到 haystack 的末尾。
     * @param string|bool $encoding 使用的字符编码名称。如果省略了，则将使用内部编码。
     * @return string 返回 haystack 的一部分。或者在没有找到 needle 时返回 FALSE。
     */
    public static function mbStrrchr( string $haystack, string $needle, bool $part = false, string $encoding = null ) : string
    {
        return mb_strrchr(...func_get_args());
    }


    /**
     * 大小写不敏感地查找指定字符在另一个字符串中最后一次的出现
     * 大小写不敏感地查找指定字符在另一个字符串中最后一次的出现
     *
     * @param string $haystack 在该字符串中查找 needle 最后出现的位置
     * @param string $needle 在 needle 中查找该字符串
     * @param bool|mixed $part 决定这个函数返回 haystack 的哪一部分。如果设置为 TRUE，它将返回的字符是从 haystack 的开始到 needle 最后出现的位置。如果设置为 FALSE，它将返回的字符是从 needle 最后出现的位置到 haystack 的末尾。
     * @param string|bool $encoding 使用的字符编码名称。如果省略了，则将使用内部编码。
     * @return string 返回 haystack 的一部分。或者在没有找到 needle 时返回 FALSE。
     */
    public static function mbStrrichr( string $haystack, string $needle, bool $part = false, string $encoding = null) : string
    {
        return mb_strrichr(...func_get_args());
    }


    /**
     * 统计字符串出现的次数
     * 统计子字符串 needle 出现在字符串 haystack 中的次数。
     *
     * @param string $haystack  要检查的字符串。
     * @param string $needle 待查找的字符串。
     * @param string|bool $encoding  参数为字符编码。如果省略，则使用内部字符编码。
     * @return int 子字符串 needle 出现在字符串 haystack 中的次数。
     */
    public static function mbSubstrCount( string $haystack, string $needle, string $encoding = null) : int
    {
        return mb_substr_count(...func_get_args());
    }



}

