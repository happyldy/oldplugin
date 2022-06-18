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
 *
 *  Sanitize filters 消毒过滤器:
 *
 *      FILTER_SANITIZE_EMAIL       "email"             删除除字母、数字和 !#$%&'*+-=?^_`{|}~@.[] 之外的所有字符。
 *
 *      FILTER_SANITIZE_URL "url"                       删除除字母、数字和 $-_.+!*'(),{}|\\^~[]`<>#%";/?:@&= 之外的所有字符。
 *
 *      FILTER_SANITIZE_MAGIC_QUOTES "magic_quotes"     应用 addslashes()。使用反斜线引用字符串
 *
 *      FILTER_SANITIZE_NUMBER_INT "number_int"         删除除数字、加号和减号以外的所有字符。
 *
 *      FILTER_SANITIZE_NUMBER_FLOAT "number_float"     删除除数字、+- 和可选的 .,eE 之外的所有字符。
 *          Flags:
 *              FILTER_FLAG_ALLOW_FRACTION
 *              FILTER_FLAG_ALLOW_THOUSAND
 *              FILTER_FLAG_ALLOW_SCIENTIFIC
 *
 *
 *      FILTER_SANITIZE_FULL_SPECIAL_CHARS "full_special_chars"     等同于调用带有 ENT_QUOTES 集的 htmlspecialchars()将特殊字符转换为 HTML 实体。 可以通过设置 FILTER_FLAG_NO_ENCODE_QUOTES 来禁用编码引号。
 *                                                                  与 htmlspecialchars()将特殊字符转换为 HTML 实体 一样，此过滤器知道 default_charset，如果检测到构成当前字符集中无效字符的字节序列，则拒绝整个字符串，从而导致长度为 0 的字符串
 *                                                                  使用此过滤器作为默认值时 过滤器，请参阅下面有关将默认标志设置为 0 的警告。
 *          Flags:
 *              FILTER_FLAG_NO_ENCODE_QUOTES
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
 *      FILTER_SANITIZE_ENCODED     "encoded"           URL编码字符串，可选择去除或编码特殊字符。
 *          Flags:
 *              FILTER_FLAG_STRIP_LOW
 *              FILTER_FLAG_STRIP_HIGH
 *              FILTER_FLAG_STRIP_BACKTICK
 *              FILTER_FLAG_ENCODE_LOW
 *              FILTER_FLAG_ENCODE_HIGH
 *
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
 *
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
 *      FILTER_FLAG_SCHEME_REQUIRED     要求 URL 包含方案部分。
 *              FILTER_VALIDATE_URL
 *
 *      FILTER_FLAG_HOST_REQUIRED       要求 URL 包含主机部分
 *              FILTER_VALIDATE_URL
 *
 *      FILTER_FLAG_PATH_REQUIRED       要求 URL 包含路径部分。
 *              FILTER_VALIDATE_URL
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


namespace HappyLin\OldPlugin\SingleClass\VariableAndType;


class Filter
{




    /**
     * 通过名称获取特定的外部变量，并且可以通过过滤器处理它
     *
     * 验证过滤器： bool、 域名、 邮箱、 float、 int、 IP地址、 MAC地址、 根据regexp ASCII的URL
     * 消毒过滤器： email、 URL编码字符串、url、 addslashes()使用反斜线、  float、 int、 special_chars、 full_special_chars、 string
     *
     *
     *
     * @param int $type INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER或 INPUT_ENV之一。
     * @param string $variable_name 待获取的变量名。
     * @param int $filter 要应用的过滤器的 ID。 过滤器类型手册页面列出了可用的过滤器。如果省略，将使用 FILTER_DEFAULT，它等效于 FILTER_UNSAFE_RAW。这将导致默认情况下不进行过滤。
     * @param mixed $options 一个选项的关联数组，或者按位区分的标示。如果过滤器接受选项，可以通过数组的 "flags" 位去提供这些标示。
     * @return mixed 如果成功的话返回所请求的变量。如果过滤失败则返回 FALSE ，如果variable_name 不存在的话则返回 NULL 。如果标示 FILTER_NULL_ON_FAILURE 被使用了，那么当变量不存在时返回 FALSE ，当过滤失败时返回 NULL 。
     */
    public static function filterInput( int $type, string $variable_name, int $filter = FILTER_DEFAULT,  $options = [] )
    {
        return filter_input(...func_get_args());
    }


    /**
     * 获取一系列外部变量，并且可以通过过滤器处理它们
     * 这个函数当需要获取很多变量却不想重复调用filter_input()时很有用。
     *
     * definition
     *      一个定义参数的数组。一个有效的键必须是一个包含变量名的string，一个有效的值要么是一个filter type，或者是一个array 指明了过滤器、标示和选项。
     *      如果值是一个数组，那么它的有效的键可以是 filter，用于指明 filter type，flags 用于指明任何想要用于过滤器的标示，或者 options 用于指明任何想要用于过滤器的选项。
     *      参考下面的例子来更好的理解这段说明。
     *
     * @param int $type INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV之一。
     * @param mixed $definition [ string => ['filter'=> XX, 'flags'=> XX, 'options'=> [XX]] ··· ];  一个定义参数的数组
     * @param bool $add_empty 在返回值中添加 NULL 作为不存在的键。
     * @return mixed 如果成功的话返回一个所请求的变量的数组，如果失败的话返回 FALSE 。对于数组的值，如果过滤失败则返回 FALSE ，如果variable_name 不存在的话则返回 NULL 。如果标示 FILTER_NULL_ON_FAILURE 被使用了，那么当变量不存在时返回 FALSE ，当过滤失败时返回 NULL 。
     */
    public static function filterInputArray( int $type, $definition, bool $add_empty = true )
    {
        return filter_input_array(...func_get_args());
    }


    /**
     * 使用特定的过滤器过滤一个变量
     *
     * @param mixed $variable 待过滤的变量。注意：标量的值在过滤前，会被转换成字符串。
     * @param int $filter 要应用的过滤器的 ID。如果省略，将使用 FILTER_DEFAULT，它等效于 FILTER_UNSAFE_RAW。这将导致默认情况下不进行过滤。
     * @param mixed $options 一个选项的关联数组，或者按位区分的标示。如果过滤器接受选项，可以通过数组的 "flags" 位去提供这些标示。对于回调型的过滤器，应该传入 callable。这个回调函数必须接受一个参数，即待过滤的值，并且返回一个在过滤/净化后的值。
     * @return mixed 返回过滤后的数据，如果过滤失败，则返回 FALSE。
     */
    public static function filterVar( $variable, int $filter = FILTER_DEFAULT, $options = null )
    {
        return filter_var(...func_get_args());
    }


    /**
     * 获取多个变量并且过滤它们
     * 不需要重复调用 filter_var() 就能获取多个变量。
     *
     * definition
     *      一个定义参数的数组。一个有效的键必须是一个包含变量名的string，一个有效的值要么是一个filter type，或者是一个array 指明了过滤器、标示和选项。
     *      如果值是一个数组，那么它的有效的键可以是 filter，用于指明 filter type，flags 用于指明任何想要用于过滤器的标示，或者 options 用于指明任何想要用于过滤器的选项。参考下面的例子来更好的理解这段说明。
     *      这个参数也可以是一个filter constant的整数。那么数组中的所有值都会被这个过滤器所过滤。
     *
     * @param array $data 数组，键为字符串，值为待过滤的数据。
     * @param mixed $definition  [ string => ['filter'=> XX, 'flags'=> XX, 'options'=> [XX]] ··· ];  一个定义参数的数组; 也可以是一个filter constant的整数;那么数组中的所有值都会被这个过滤器所过滤。
     * @param bool $add_empty  在返回值中添加 NULL 作为不存在的键。
     * @return mixed 如果成功则返回一个包含所请求变量的数组，或者当失败时返回 FALSE 。一个数组的值如果过滤失败则为 FALSE ，或者为 NULL 如果变量不存在的话。
     */
    public static function filterVarArray( array $data, $definition, bool $add_empty = true)
    {
        return filter_var_array( $data, $definition, $add_empty);
    }



}


