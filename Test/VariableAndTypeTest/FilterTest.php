<?php
/**
 * 此扩展通过验证或清理数据来过滤数据。
 * 过滤有两种主要类型：验证和消毒。
 *
 * 验证用于验证或检查数据是否符合某些条件。 例如，传入 FILTER_VALIDATE_EMAIL 将确定数据是否为有效的电子邮件地址，但不会更改数据本身。
 * 清理将清理数据，因此它可能会通过删除不需要的字符来更改数据。例如，传入 FILTER_SANITIZE_EMAIL 将删除不适合电子邮件地址包含的字符。也就是说，它不会验证数据。
 * 标志可以选择与验证和清理一起使用，以根据需要调整行为。 例如，在过滤 URL 时传入 FILTER_FLAG_PATH_REQUIRED 将需要存在路径（如 http://example.org/foo 中的 /foo）。
 *
 *
 * $filter
 *  Validate filters 验证过滤器
 *
 *      FILTER_VALIDATE_BOOLEAN  "boolean"              对于“1”、“true”、“on”和“yes”，返回 TRUE。否则返回 FALSE。
 *          options:
 *              default：
 *          Flags:
 *              FILTER_NULL_ON_FAILURE                      如果设置了 FILTER_NULL_ON_FAILURE，则仅对“0”、“false”、“off”、“no”和“”返回 FALSE，对所有非布尔值返回 NULL。
 *
 *      FILTER_VALIDATE_DOMAIN  "validate_domain"       验证域名标签长度是否有效。根据 RFC 1034、RFC 1035、RFC 952、RFC 1123、RFC 2732、RFC 2181 和 RFC 1123 验证域名。
 *          options:
 *              default：
 *          Flags:
 *              FILTER_FLAG_HOSTNAME                        可选标志,添加了专门验证主机名的能力（它们必须仅以字母数字字符开头，并且包含非字母数字字母字符）。
 *
 *      FILTER_VALIDATE_EMAIL "validate_email"          验证该值是否为有效的电子邮件地址。通常，这会根据 RFC 822 中的语法验证电子邮件地址，但不支持注释和空白折叠以及无点域名。
 *          options:
 *              default:
 *          Flags:
 *              FILTER_FLAG_EMAIL_UNICODE
 *
 *      FILTER_VALIDATE_FLOAT "float"                   将值验证为浮点数，可选地来自指定范围，并在成功时转换为浮点数。
 *          options:
 *              default:
 *              decimal:                                    表示十进制符号['.', ',']。
 *              min_range
 *              max_range
 *          Flags:
 *              FILTER_FLAG_ALLOW_THOUSAND
 *
 *      FILTER_VALIDATE_INT "int"                       将值验证为整数，可以选择指定的范围，并在成功时转换为 int。
 *          options:
 *              default:
 *              min_range
 *              max_range
 *          Flags:
 *              FILTER_FLAG_ALLOW_OCTAL
 *              FILTER_FLAG_ALLOW_HEX
 *
 *
 *      FILTER_VALIDATE_IP "validate_ip"                将值验证为 IP 地址，可选择仅 IPv4 或 IPv6 或不来自私有或保留范围
 *          options:
 *              default:
 *          Flags:
 *              FILTER_FLAG_IPV4
 *              FILTER_FLAG_IPV6
 *              FILTER_FLAG_NO_PRIV_RANGE
 *              FILTER_FLAG_NO_RES_RANGE
 *
 *
 *      FILTER_VALIDATE_MAC "validate_mac_address"      验证值作为 MAC 地址。
 *          options:
 *              default:
 *
 *      FILTER_VALIDATE_REGEXP "validate_regexp"        根据 regexp（一种与 Perl 兼容的正则表达式）验证值。
 *          options:
 *              default:
 *              regexp
 *
 *      FILTER_VALIDATE_URL "validate_url"              将值验证为 URL（根据 » http://www.faqs.org/rfcs/rfc2396），可选择使用所需的组件。
 *                                                      请注意，有效的 URL 可能未指定 HTTP 协议 http://，因此可能需要进一步验证以确定 URL 使用预期的协议，例如 ssh:// 或 mailto:。
 *                                                      请注意，该函数只会找到有效的 ASCII URL； 国际化域名（包含非 ASCII 字符）将失败。
 *          options:
 *              default:
 *          Flags:
 *              FILTER_FLAG_SCHEME_REQUIRED
 *              FILTER_FLAG_HOST_REQUIRED
 *              FILTER_FLAG_PATH_REQUIRED
 *              FILTER_FLAG_QUERY_REQUIRED
 *
 *
 *
 *  Sanitize filters 消毒过滤器
 *
 *      FILTER_SANITIZE_EMAIL       "email"             删除除字母、数字和 !#$%&'*+-=?^_`{|}~@.[] 之外的所有字符。
 *
 *      FILTER_SANITIZE_ENCODED     "encoded"           URL 编码字符串，可选择去除或编码特殊字符。
 *          Flags:
 *              FILTER_FLAG_STRIP_LOW
 *              FILTER_FLAG_STRIP_HIGH
 *              FILTER_FLAG_STRIP_BACKTICK
 *              FILTER_FLAG_ENCODE_LOW
 *              FILTER_FLAG_ENCODE_HIGH
 *
 *      FILTER_SANITIZE_MAGIC_QUOTES "magic_quotes"     应用 addslashes()。使用反斜线引用字符串
 *
 *      FILTER_SANITIZE_NUMBER_FLOAT "number_float"     删除除数字、+- 和可选的 .,eE 之外的所有字符。
 *          Flags:
 *              FILTER_FLAG_ALLOW_FRACTION
 *              FILTER_FLAG_ALLOW_THOUSAND
 *              FILTER_FLAG_ALLOW_SCIENTIFIC
 *
 *
 *
 *      FILTER_SANITIZE_NUMBER_INT "number_int"         删除除数字、加号和减号以外的所有字符。
 *
 *
 *      FILTER_SANITIZE_SPECIAL_CHARS "special_chars"   HTML 转义 '"<>& 和 ASCII 值小于 32 的字符，可选择剥离或编码其他特殊字符。
 *          Flags:
 *              FILTER_FLAG_STRIP_LOW
 *              FILTER_FLAG_STRIP_HIGH
 *              FILTER_FLAG_STRIP_BACKTICK
 *              FILTER_FLAG_ENCODE_HIGH
 *
 *
 *
 *
 *      FILTER_SANITIZE_FULL_SPECIAL_CHARS "full_special_chars"     等同于调用带有 ENT_QUOTES 集的 htmlspecialchars()将特殊字符转换为 HTML 实体。 可以通过设置 FILTER_FLAG_NO_ENCODE_QUOTES 来禁用编码引号。
 *                                                                  与 htmlspecialchars()将特殊字符转换为 HTML 实体 一样，此过滤器知道 default_charset，如果检测到构成当前字符集中无效字符的字节序列，则拒绝整个字符串，从而导致长度为 0 的字符串
 *                                                                  使用此过滤器作为默认值时 过滤器，请参阅下面有关将默认标志设置为 0 的警告。
 *          Flags:
 *              FILTER_FLAG_NO_ENCODE_QUOTES
 *
 *      FILTER_SANITIZE_STRING "string"                 字符串剥离标签，可选择剥离或编码特殊字符。
 *          Flags:
 *              FILTER_FLAG_NO_ENCODE_QUOTES
 *              FILTER_FLAG_STRIP_LOW
 *              FILTER_FLAG_STRIP_HIGH
 *              FILTER_FLAG_STRIP_BACKTICK
 *              FILTER_FLAG_ENCODE_LOW
 *              FILTER_FLAG_ENCODE_HIGH
 *              FILTER_FLAG_ENCODE_AMP
 *
 *      FILTER_SANITIZE_STRIPPED "stripped"             “字符串”过滤器的别名。
 *
 *      FILTER_SANITIZE_URL "url"                       删除除字母、数字和 $-_.+!*'(),{}|\\^~[]`<>#%";/?:@&= 之外的所有字符。
 *
 *      FILTER_UNSAFE_RAW "unsafe_raw"                  什么都不做，可选择去除或编码特殊字符。 此过滤器也别名为 FILTER_DEFAULT。
 *          Flags:
 *              FILTER_FLAG_STRIP_LOW
 *              FILTER_FLAG_STRIP_HIGH
 *              FILTER_FLAG_STRIP_BACKTICK
 *              FILTER_FLAG_ENCODE_LOW
 *              FILTER_FLAG_ENCODE_HIGH
 *              FILTER_FLAG_ENCODE_AMP
 *
 * Other filters:
 *      FILTER_CALLBACK   "callback"                    调用自定义函数过滤数据。
 *          options:
 *              callable function or method
 *          Flags: 所有标志都被忽略
 *
 *
 *
 *  Filter flags: 过滤标志
 *
 *      FILTER_FLAG_STRIP_LOW           去除数值 <32 的字符。
 *              FILTER_SANITIZE_ENCODED, FILTER_SANITIZE_SPECIAL_CHARS,FILTER_SANITIZE_STRING, FILTER_UNSAFE_RAW
 *
 *      FILTER_FLAG_STRIP_HIGH          去除数值 >127 的字符。
 *              FILTER_SANITIZE_ENCODED, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_SANITIZE_STRING, FILTER_UNSAFE_RAW
 *
 *      FILTER_FLAG_STRIP_BACKTICK      去除反引号字符。
 *              FILTER_SANITIZE_ENCODED, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_SANITIZE_STRING, FILTER_UNSAFE_RAW
 *
 *      FILTER_FLAG_ALLOW_FRACTION      允许将句点 (.) 作为数字中的小数分隔符。
 *              FILTER_SANITIZE_NUMBER_FLOAT
 *
 *      FILTER_FLAG_ALLOW_THOUSAND      允许逗号 (,) 作为数字中的千位分隔符。
 *              FILTER_SANITIZE_NUMBER_FLOAT, FILTER_VALIDATE_FLOAT
 *
 *      FILTER_FLAG_ALLOW_SCIENTIFIC    允许使用 e 或 E 表示数字中的科学记数法。
 *              FILTER_SANITIZE_NUMBER_FLOAT
 *
 *      FILTER_FLAG_NO_ENCODE_QUOTES     如果存在此标志，则不会对单 (') 和双 (") 引号进行编码。
 *              FILTER_SANITIZE_STRING
 *
 *
 *
 *      FILTER_FLAG_ENCODE_LOW          对数值 <32 的所有字符进行编码。
 *              FILTER_SANITIZE_ENCODED, FILTER_SANITIZE_STRING, FILTER_SANITIZE_RAW
 *
 *      FILTER_FLAG_ENCODE_HIGH         对数值 >127 的所有字符进行编码。
 *              FILTER_SANITIZE_ENCODED, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_SANITIZE_STRING, FILTER_SANITIZE_RAW
 *
 *      FILTER_FLAG_ENCODE_AMP          对与符号 (&) 进行编码。
 *              FILTER_SANITIZE_STRING, FILTER_SANITIZE_RAW
 *
 *      FILTER_NULL_ON_FAILURE          对于无法识别的布尔值，返回 NULL。
 *              FILTER_VALIDATE_BOOLEAN
 *
 *      FILTER_FLAG_ALLOW_OCTAL         将以零 (0) 开头的输入视为八进制数。 那只允许后面的数字是 0-7。
 *              FILTER_VALIDATE_INT
 *
 *      FILTER_FLAG_ALLOW_HEX           将以 0x 或 0X 开头的输入视为十六进制数。 这仅允许后继字符为 a-fA-F0-9。
 *              FILTER_VALIDATE_INT
 *
 *      FILTER_FLAG_EMAIL_UNICODE       允许电子邮件地址的本地部分包含 Unicode 字符。
 *              FILTER_VALIDATE_EMAIL
 *
 *      FILTER_FLAG_IPV4                允许 IP 地址采用 IPv4 格式。
 *              FILTER_VALIDATE_IP
 *
 *      FILTER_FLAG_IPV6                允许 IP 地址采用 IPv6 格式。
 *              FILTER_VALIDATE_IP
 *
 *      FILTER_FLAG_NO_PRIV_RANGE       无法验证以下私有 IPv4 范围：10.0.0.0/8、172.16.0.0/12 和 192.168.0.0/16。验证以 FD 或 FC 开头的 IPv6 地址失败。
 *              FILTER_VALIDATE_IP
 *
 *      FILTER_FLAG_NO_RES_RANGE        未能验证以下保留的 IPv4 范围：0.0.0.0/8、169.254.0.0/16、127.0.0.0/8 和 240.0.0.0/4。未能验证以下保留的 IPv6 范围：::1/128、::/128、::ffff:0:0/96 和 fe80::/10。
 *              FILTER_VALIDATE_IP
 *
 *      FILTER_FLAG_SCHEME_REQUIRED     要求 URL 包含方案部分。 已废弃！！！！！！
 *              FILTER_VALIDATE_URL
 *
 *      FILTER_FLAG_HOST_REQUIRED       要求 URL 包含主机部分  已废弃！！！！！！
 *              FILTER_VALIDATE_URL
 *
 *      FILTER_FLAG_PATH_REQUIRED       要求 URL 包含路径部分。
 *              FILTER_VALIDATE_URL
 *
 *
 *      FILTER_FLAG_QUERY_REQUIRED      要求 URL 包含查询字符串。
 *              FILTER_VALIDATE_URL
 *
 *      FILTER_REQUIRE_SCALAR           要求值是标量。
 *
 *      FILTER_REQUIRE_ARRAY            要求值是一个数组。
 *
 *      FILTER_FORCE_ARRAY              如果值是标量，则将其视为仅包含标量值元素的数组。
 *
 *
 * 警告
 *  当通过您的 ini 文件或 Web 服务器的配置使用这些过滤器之一作为默认过滤器时，默认标志设置为 FILTER_FLAG_NO_ENCODE_QUOTES。 您需要将filter.default_flags 显式设置为0 以在默认情况下对引号进行编码。 像这样：
 *  Example #1 将默认过滤器配置为类似于 htmlspecialchars
 *      filter.default = full_special_chars
 *      filter.default_flags = 0
 *
 */

namespace HappyLin\OldPlugin\Test\VariableAndTypeTest;

use HappyLin\OldPlugin\SingleClass\VariableAndType\Filter;


use HappyLin\OldPlugin\Test\TraitTest;

use stdclass;


class FilterTest
{

    use TraitTest;



    public function __construct()
    {

    }

    /**
     * @note 过滤器函数 检测字符串
     */
    public function filterTest()
    {
        var_dump(static::toStr(
            '获取所支持的过滤器列表; filter_list()',
            filter_list()
        ));

        var_dump(static::toStr(
            '获取与某个特定名称的过滤器相关联的id;filter_list中的float filter_id("float"))',
            filter_id("float")
        ));

        var_dump(static::toStr(
            '检测是否存在指定类型的变量; INPUT_GET、 INPUT_POST、 INPUT_COOKIE、 INPUT_SERVER、 INPUT_ENV 里的其中一个; filter_has_var(INPUT_GET, "f")',
            filter_has_var(INPUT_GET, "f")
        ));

        var_dump(static::toStr(
            "通过名称获取特定的外部变量，并且可以通过过滤器处理它; filter_input(INPUT_GET, 'f', FILTER_SANITIZE_ENCODED) \n",
            Filter::filterInput(INPUT_GET, 'f', FILTER_SANITIZE_ENCODED)
        ));

        $args = [
            'f' => FILTER_SANITIZE_ENCODED,
            'm' => [
                'filter'    => FILTER_SANITIZE_STRING,
                'flags'     => [FILTER_FLAG_STRIP_LOW,FILTER_FLAG_STRIP_HIGH]
            ],
            'noExist' => FILTER_SANITIZE_ENCODED
        ];
        var_dump(static::toStr(
            "获取一系列外部变量，并且通过过滤器处理它们; filter_input_array(INPUT_GET, %s , true)",
            json_encode($args),
            Filter::filterInputArray(INPUT_GET, $args, true)
        ));

        var_dump(static::toStr(
            '使用特定的过滤器过滤一个变量; filter_var(\'bob@example.com\', FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE)'. PHP_EOL,
            Filter::filterVar('bob@example.com', FILTER_VALIDATE_EMAIL,FILTER_FLAG_EMAIL_UNICODE)
        ));

        $data = array(
            'product_id'    => 'libgd<script>',
            'testint'    =>  '10',
        );

        $args = array(
            'product_id'   => FILTER_SANITIZE_ENCODED,
            'testint'   => array(
                    'filter'    => FILTER_VALIDATE_INT,
                    'flags'     => FILTER_FORCE_ARRAY,
                    'options'   => array('min_range' => 1, 'max_range' => 10)
                ),
        );
        var_dump(static::toStr(
            '获取多个变量并且过滤它们; filter_var_array( %s , %s , true)',
            json_encode($data),
            json_encode($args),
            Filter::filterVarArray($data, $args, true)
        ));

    }


    /**
     * @note Validate filters 验证过滤器；判断例子
     */
    public function filterValidateFiltersTest()
    {
        $data = ["1","true","on","yes",'other'];
        $options = [];
        shuffle($data);
        var_dump(static::toStr(
            "bool判断; Flags: FILTER_NULL_ON_FAILURE 返回 false 或 null,没什么用； \nfilter_var( %s ,FILTER_VALIDATE_BOOLEAN, %s )",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_VALIDATE_BOOLEAN, $options)
        ));


        $data = ["1.0001","1","-1,231.0001","20000"];
        $options = [
            'flags' => FILTER_FLAG_ALLOW_THOUSAND,
            'options' => array(
                'default' => 'Can\'t find',
                'decimal' =>  '.',
                'min_range' => 0,  //7.4.0
                'max_range' => 10000  //7.4.0
            ),
        ];
        shuffle($data);
        var_dump(static::toStr(
            "float判断; Flags: FILTER_FLAG_ALLOW_THOUSAND 允许逗号 (,) 作为数字中的千位分隔符； \nfilter_var( %s ,FILTER_VALIDATE_DOMAIN, %s ) \n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[2],FILTER_VALIDATE_FLOAT, $options)
        ));


        $data = ["5", "5.1", "-12", "101", "0x41", "0x7f", "0101"];
        $options = [
            'flags' => FILTER_FLAG_ALLOW_HEX | FILTER_FLAG_ALLOW_OCTAL,
            'options' => array(
                'default' => 'Can\'t find',
                'min_range' => -100,
                'max_range' => 100
            ),
        ];
        shuffle($data);
        var_dump(static::toStr(
            "int判断; Flags: FILTER_FLAG_ALLOW_OCTAL 八进制；FILTER_FLAG_ALLOW_HEX：十六进制； \nfilter_var( %s ,FILTER_VALIDATE_INT, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_VALIDATE_INT, $options)
        ));


        $data = ["AstarendZ", "test"];
        $options = [
            'options' => array(
                'default' => 'Can\'t find',
                'regexp' => '/^a.+z$/i',
            ),
        ];
        shuffle($data);
        var_dump(static::toStr(
            "正则判断; 自定义正则 \nfilter_var( %s ,FILTER_VALIDATE_REGEXP, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_VALIDATE_REGEXP, $options)
        ));


        $data = ["https://www.toutiao.com/","https://so.toutiao.com/search","https://so.toutiao.com/search?keyword=keyword"];
        $options = [
            'flags' =>  FILTER_FLAG_PATH_REQUIRED | FILTER_FLAG_QUERY_REQUIRED,
            'options' => array(
                'default' => 'Can\'t find',
            ),
        ];
        shuffle($data);
        var_dump(static::toStr(
            "url判断; flags[必须有 SCHEME(https) HOST PATH(/XX) QUERY(?XX)];  \nfilter_var( %s ,FILTER_VALIDATE_URL, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_VALIDATE_URL, $options)
        ));


        $data = ["bob@example.com","email.163.com","webmail30.189.cn"];
        $options = [
            'flags' => FILTER_FLAG_EMAIL_UNICODE,
        ];
        shuffle($data);
        var_dump(static::toStr(
            "邮箱判断; 验证该值是否为有效的电子邮件地址。Flags: FILTER_FLAG_EMAIL_UNICODE 允许电子邮件地址的本地部分包含 Unicode 字符； \nfilter_var( %s ,FILTER_VALIDATE_DOMAIN, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_VALIDATE_EMAIL, $options)
        ));


        $data = ["https://www.toutiao.com/","www.toutiao.com","测试myhtml"];
        $options = [
            'flags' => FILTER_FLAG_HOSTNAME,
        ];
        shuffle($data);
        var_dump(static::toStr(
            "域名判断; 验证域名标签长度是否有效。Flags: FILTER_FLAG_HOSTNAME 验证主机名（必须仅以字母数字字符开头，并且包含非字母数字字母字符）； \nfilter_var( %s ,FILTER_VALIDATE_DOMAIN, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_VALIDATE_DOMAIN, $options)
        ));


        $data = ["203.208.41.66","203.208.41.66:443","192.168.31.205","127.0.0.1"];
        $options = [
            'flags' => FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6, // | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ];
        shuffle($data);
        var_dump(static::toStr(
            "IP判断; 将值验证为 IP 地址。Flags:  FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE(排除 IPv4 范围：10.0.0.0/8、172.16.0.0/12 和 192····) | FILTER_FLAG_NO_RES_RANGE（排除 IPv4 范围：0.0.0.0/8、169.254.0.0/16、127.0.0.0/8 和 240···） ； \nfilter_var( %s ,FILTER_VALIDATE_IP, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_VALIDATE_IP, $options)
        ));


        $data = ["B0-7D-64-EA-CC-ED"];
        $options = [];
        //shuffle($data);
        var_dump(static::toStr(
            "MAC判断; 验证值作为 MAC 地址； \nfilter_var( %s ,FILTER_VALIDATE_MAC, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_VALIDATE_MAC, $options)
        ));

    }

    /**
     * @note Sanitize filters 消毒过滤器: 例子
     */
    public function filterSanitizeFiltersTest()
    {

        $data = ["5", "5.1", "-12", "101", "0x41", "0x7f", "0101"];
        $options = [];
        shuffle($data);
        var_dump(static::toStr(
            "int过滤; 删除除数字、加号和减号以外的所有字符。 \nfilter_var( %s ,FILTER_SANITIZE_NUMBER_INT, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_SANITIZE_NUMBER_INT, $options)
        ));


        $data = ["1.0001","1","-1,231.0001","20000"];
        $options = [
            'flags' => FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND | FILTER_FLAG_ALLOW_SCIENTIFIC,
        ];
        shuffle($data);
        var_dump(static::toStr(
            "float过滤; 删除除数字、+- 和可选的 .,eE 之外的所有字符。flags[允许 FRACTION(.) THOUSAND(,) SCIENTIFIC(e 或 E )] \nfilter_var( %s ,FILTER_SANITIZE_NUMBER_FLOAT, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_SANITIZE_NUMBER_FLOAT, $options)
        ));


        $data = ["https://www.toutiao.com/","https://so.toutiao.com/search'","https://so.toutiao.com/search?keyword=keyword"];
        $options = [
            //'flags' => FILTER_FLAG_NO_ENCODE_QUOTES,
        ];
        shuffle($data);
        var_dump(static::toStr(
            "url过滤; 删除除字母、数字和 $-_.+!*'(),{}|\\^~[]`<>#%\";/?:@&= 之外的所有字符。flags： FILTER_FLAG_NO_ENCODE_QUOTES(您需要将filter.default_flags 显式设置为0) 如果存在此标志，则不会对单 (') 和双 (\") 引号进行编码。 \nfilter_var( %s ,FILTER_SANITIZE_URL, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_SANITIZE_URL, $options)
        ));


        $data = ["bob@example例如.com","email.163.com","webmail30.189.cn"];
        $options = [];
        shuffle($data);
        var_dump(static::toStr(
            "邮箱过滤; 删除除字母、数字和 !#$%&'*+-=?^_`{|}~@.[] 之外的所有字符。 \nfilter_var( %s ,FILTER_SANITIZE_EMAIL, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_SANITIZE_EMAIL, $options)
        ));



        $data = ["<div><h3>标题</h3><p>第一行</p><p>第二行</p></div>"];
        $options = [];
        //shuffle($data);
        var_dump(static::toStr(
            "HTML过滤; 等同于调用带有 ENT_QUOTES 集的 htmlspecialchars()将特殊字符转换为 HTML 实体;flags： FILTER_FLAG_NO_ENCODE_QUOTES; \nfilter_var( %s ,FILTER_SANITIZE_FULL_SPECIAL_CHARS, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_SANITIZE_FULL_SPECIAL_CHARS, $options)
        ));



        $data = ["<div><h3>标题</h3><p>第一行</p><p>第二行</p></div>"];
        $options = [
            'flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_HIGH  //
        ];
        //shuffle($data);
        var_dump(static::toStr(
            "HTML过滤; HTML 转义 '\"<>& 和 ASCII 值小于 32 的字符，可选择剥离或编码其他特殊字符。;flags： FILTER_FLAG_NO_ENCODE_QUOTES; \nfilter_var( %s ,FILTER_SANITIZE_SPECIAL_CHARS, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_SANITIZE_SPECIAL_CHARS, $options)
        ));

        $data = ['bo\n\t<div>b@example例如.com'];
        $options = [];
        //shuffle($data);
        var_dump(static::toStr(
            "反斜线过滤; 应用 addslashes()。使用反斜线引用字符串。 \nfilter_var( %s ,FILTER_SANITIZE_MAGIC_QUOTES, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_SANITIZE_MAGIC_QUOTES, $options)
        ));


        echo '<p>
                <font color="#8b0000">
                 FILTER_FLAG_STRIP_LOW         => 去除数值 <32 的字符。   <br>
                 FILTER_FLAG_STRIP_HIGH        => 去除数值 >127 的字符。   <br> 
                 FILTER_FLAG_STRIP_BACKTICK    => 去除反引号字符。   <br>
                 FILTER_FLAG_ENCODE_LOW        => 对数值 <32 的所有字符进行编码。   <br>
                 FILTER_FLAG_ENCODE_HIGH       => 对数值 >127 的所有字符进行编码。   <br>
                 FILTER_FLAG_ENCODE_AMP        => 对与符号 (&) 进行编码   <br>
                 FILTER_FLAG_NO_ENCODE_QUOTES  => 如果存在此标志，则不会对单 (\') 和双 (") 引号进行编码。(您需要将filter.default_flags 显式设置为0)
                </font>    
            </p>';



        $data = ['?a=1&b=2&c=<div><h3>标题</h3><p>第一行</p><p>第二行</p></div>'];
        $options = [
            //'flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH
        ];
        //shuffle($data);
        var_dump(static::toStr(
            "URL-encode字符串过滤; URL-encode字符串，可选择去除或编码特殊字符。;flags：FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH ; \nfilter_var( %s ,FILTER_SANITIZE_ENCODED, %s ) \n;",
            ($data[0]),
            json_encode($options),
            $res = Filter::filterVar($data[0],FILTER_SANITIZE_ENCODED, $options),
            "\n解压结果：" . urldecode($res)
        ));


        $data = ['dfgdf234gdf\n\t<div><h3>标题</h3><p>第一行</p><p>第二行</p></div>'];
        $options = [
            //'flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_ENCODE_AMP | FILTER_FLAG_NO_ENCODE_QUOTES //
        ];
        //shuffle($data);
        var_dump(static::toStr(
            "字符串剥离标签过滤; 可选择剥离或编码特殊字符。;flags：FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_ENCODE_AMP | FILTER_FLAG_NO_ENCODE_QUOTES ; \nfilter_var( %s ,FILTER_SANITIZE_STRING, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_SANITIZE_STRING, $options)
        ));


        $data = ['dfgdf234gdf\n\t<div><h3>标题</h3><p>第一行</p><p>第二行</p></div>'];
        $options = [
            //'flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_ENCODE_AMP
        ];
        //shuffle($data);
        var_dump(static::toStr(
            "过滤; 什么都不做，可选择去除或编码特殊字符。 此过滤器也别名为 FILTER_DEFAULT;flags：FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_ENCODE_AMP ; \nfilter_var( %s ,FILTER_UNSAFE_RAW, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_UNSAFE_RAW, $options)
        ));


        $data = ['dfgdf234gdf\n\t<div><h3>标题</h3><p>第一行</p><p>第二行</p></div>'];
        $array = [];
        $options = [
            'options' => function($value = null) use ($array) {
                if (in_array($value, $array)) return $value;
                return strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','', $value));
            }
        ];
        //shuffle($data);
        var_dump(static::toStr(
            "自定义函数过滤; 调用自定义函数过滤数据; \nfilter_var( %s ,FILTER_CALLBACK, %s )\n",
            ($data[0]),
            json_encode($options),
            Filter::filterVar($data[0],FILTER_CALLBACK, $options)
        ));

    }



}

