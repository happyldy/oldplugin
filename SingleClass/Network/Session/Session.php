<?php
/**
 * 关于配置的函数
 * PHP_INI_USER     可在用户脚本（例如 ini_set()）或 Windows 注册表（自 PHP 5.3 起）以及 .user.ini 中设定
 * PHP_INI_PERDIR   可在 php.ini，.htaccess 或 httpd.conf 中设定
 * PHP_INI_SYSTEM   可在 php.ini 或 httpd.conf 中设定
 * PHP_INI_ALL      可在任何地方设定
 *
 *
 *
 * // 通用配置
 * session.save_handler         string      定义了来存储和获取与会话关联的数据的处理器的名字。默认为 files。注意个别扩展可能会注册自己的save_handler； 通过引用 phpinfo()，可以在每次安装的基础上获得注册的处理程序。
 * session.save_path            string      定义了传递给存储处理器的参数。如果选择了默认的 files 文件处理器，则此值是创建文件的路径。默认为 /tmp。 此指令还有一个可选的 N 参数来决定会话文件分布的目录深度。例如，设定为 '5;/tmp' 将使创建的会话文件和路径类似于 /tmp/4/b/1/e/3/sess_4b1e384ad74619bd212e236e52a5a174If。要使用 N 参数，必须在使用前先创建好这些目录。此外注意如果使用了 N 参数并且大于 0，那么将不会执行自动垃圾回收，
 * session.serialize_handler    string      定义用来序列化／解序列化的处理器名字。当前支持 PHP 序列化格式 (名为 php_serialize)、 PHPPHP 内部格式 (名为 php 及 php_binary) 和 WDDX (名为 wddx)。
 *
 *
 * // 使用配置
 * session.name                 string      指定会话名以用做 cookie 的名字。只能由字母数字组成，默认为 PHPSESSID
 * session.cache_limiter        string      指定会话页面所使用的缓冲控制方法（none/nocache/private/private_no_expire/public）。默认为 nocache。
 * session.cache_expire         integer     以分钟数指定缓冲的会话页面的存活期，此设定对 nocache 缓冲控制方法无效。默认为 180。参见 session_cache_expire()。
 *
 *
 *
 * session.use_trans_sid        boolean     指定是否启用透明 SID 支持。默认为 0（禁用）。
 * session.trans_sid_tags       string      指定在启用透明 sid 支持时重写哪些 HTML 标签以包含会话 ID。 默认为 a=href,area=href,frame=src,input=src,form= 表单是特殊标签。 <input hidden="session_id" name="session_name">作为表单变量添加。自 PHP 7.1.0 起，fieldset 不再被视为特殊标签。
 * url_rewriter.tags            string      指定在使用透明 SID 支持时哪些 HTML 标记会被修改以加入会话 ID。默认为 a=href,area=href,frame=src,input=src,form=fakeentry,fieldset=。自 PHP 7.1.0 起，fieldset 不再被视为特殊标签。
 * session.trans_sid_hosts      string      指定在启用透明 sid 支持时重写哪些主机以包含会话 ID。 默认为$_SERVER['HTTP_HOST']可以用“,”指定多个主机，主机之间不允许有空格。 例如 php.net,wiki.php.net,bugs.php.net
 * session.sid_length-PHP7.1    integer     允许您指定会话 ID 字符串的长度。 会话 ID 长度可以在 22 到 256 之间。默认为 32。如果您需要兼容性，您可以指定 32,40 等。会话 ID 越长越难以猜测。 建议至少 32 个字符。
 * session.sid_bits_per_character-PHP7.1    integer     允许您指定编码的会话 ID 字符中的位数。 可能的值是“4”（0-9，a-f），“5”（0-9，a-v）和“6”（0-9，a-z，A-Z，“-”，“，”）。 默认值为 4。位数越多，会话 ID 越强。 5 是大多数环境的推荐值。
 *
 * session.use_strict_mode      boolean     指定模块是否将使用严格的会话 ID 模式。 如果启用此模式，则模块不接受未初始化的会话 ID。 如果未初始化的会话 ID 是从浏览器发送的，则新的会话 ID 将发送到浏览器。通过会话采用严格模式来保护应用程序免受会话固定。默认为 0（禁用）。
 *
 *
 *
 * // cookie 配置
 * session.use_cookies          boolean     指定是否在客户端用 cookie 来存放会话 ID。默认为 1（启用）。
 * session.cookie_lifetime      integer     以秒数指定了发送到浏览器的 cookie 的生命周期。值为 0 表示"直到关闭浏览器"。默认为 0;
 * session.cookie_path          string      指定了要设定会话 cookie 的路径。默认为 /
 * session.cookie_domain        string      指定了要设定会话 cookie 的域名。默认为无，表示根据 cookie 规范产生 cookie 的主机名。
 * session.cookie_secure        boolean     指定是否仅仅通过安全的 HTTPS 连接传给客户端 cookie。默认为 off
 * session.cookie_httponly      boolean     将 cookie 标记为只能通过 HTTP 协议访问。 这意味着脚本语言（例如 JavaScript）将无法访问 cookie。 此设置可以有效帮助减少通过 XSS 攻击进行的身份盗用（尽管并非所有浏览器都支持）。
 * session.cookie_samesite      string      允许服务器断言 cookie 不应与跨站点请求一起发送。 该断言允许用户代理降低跨源信息泄露的风险，并提供一些针对跨站点请求伪造攻击的保护。 请注意，所有浏览器都不支持此功能。
 *
 *
 *
 * // 暂时不会用的
 * session.auto_start           boolean     指定会话模块是否在请求开始时自动启动一个会话。默认为 0（不启动）。
 * session.gc_probability       integer     与 session.gc_divisor 合起来用来管理 gc（garbage collection 垃圾回收）进程启动的概率。默认为 1
 * session.gc_divisor           integer     与 session.gc_probability 合起来定义了在每个会话初始化时启动 gc（garbage collection 垃圾回收）进程的概率。此概率用 gc_probability/gc_divisor 计算得来。例如 1/100 意味着在每个请求中有 1% 的概率启动 gc 进程。session.gc_divisor 默认为 100。
 * session.gc_maxlifetime       integer     指定过了多少秒之后数据就会被视为"垃圾"并被清除。垃圾搜集可能会在 session 启动的时候开始（取决于session.gc_probability 和 session.gc_divisor）。
 * session.referer_check        string      包含有用来检查每个 HTTPReferer（前请求页面的来源页面的地址） 的子串。如果客户端发送了 Referer 信息但是在其中并未找到该子串，则嵌入的会话 ID 会被标记为无效。默认为空字符串。
 * session.entropy_file         string      给出了一个到外部资源（文件）的路径，该资源将在会话 ID 创建进程中被用作附加的熵值资源。
 * session.entropy_length       integer     指定了从上面的文件中读取的字节数。默认为 0（禁用）。
 * session.hash_function        mixed       允许用户指定生成会话 ID 的散列算法。'0' 表示 MD5（128 位），'1' 表示 SHA-1（160 位）。
 * session.hash_bits_per_character          integer     session.hash_bits_per_character 允许用户定义将二进制散列数据转换为可读的格式时每个字符存放多少个比特。可能值为 '4'（0-9，a-f），'5'（0-9，a-v），以及 '6'（0-9，a-z，A-Z，"-"，","）。
 *
 * session.upload_progress.enabled          boolean     启用上传进度跟踪，填充 $_SESSION 变量。默认为 1，启用。
 * session.upload_progress.cleanup          boolean     读取所有 POST 数据（即上传完成）后立即清除进度信息。 默认为 1，启用。
 * session.upload_progress.prefix           string      $_SESSION 中用于上传进度键的前缀。此键将与 $_POST[ini_get("session.upload_progress.name")] 的值连接以提供唯一索引。 默认为“upload_progress_”。
 * session.upload_progress.name             string      在 $_SESSION 存储进度信息中使用的键的名称。 另见 session.upload_progress.prefix。 如果 $_POST[ini_get("session.upload_progress.name")] 未通过或不可用，则不会记录上传进度。 默认为“PHP_SESSION_UPLOAD_PROGRESS”。
 * session.upload_progress.freq             mixed       定义上传进度信息应该多久更新一次。这可以以字节为单位（即“每 100 字节后更新进度信息”）或百分比（即“每接收到整个文件大小的 1% 后更新进度信息”）来定义 . 默认为“1%”。
 * session.upload_progress.min_freq         integer     更新之间的最小延迟，以秒为单位。默认为“1”（一秒）。
 *
 * session.lazy_write           boolean     当设置为 1 时，意味着 sessiondata 只有在它发生变化时才会被重写。 默认为 1，启用。
 *
 *
 */

namespace HappyLin\OldPlugin\SingleClass\Network\Session;



class Session
{

    /** ························ 配置 ········································· */


    /**
     * 获取或设置会话模块名称，也被称做：session.save_handler。
     *
     * @param string $module 如果指定 module 参数，则使用指定值作为会话模块。禁止传入 "user" 作为此参数的值，请使用 set_set_save_handler() 来设置用户自定义的会话处理器。
     * @return string 返回当前所用的会话模块名称。
     */
    public static function session_module_name(string $module = null) : string
    {
        return session_module_name( ...func_get_args());
    }

    /**
     * 读取/设置会话名称
     * 函数返回当前会话名称。如果指定 name 参数， session_name() 函数会更新会话名称，并返回 原来的 会话名称。
     * 如果使用 name 指定了新字符串作为会话 cookie 的名字， session_name() 函数会修改 HTTP 响应中的 cookie （如果启用了 session.transid，还会输出会话 cookie 的内容）。
     *
     * 一旦在 HTTP 响应中发送了 cookie 的内容之后，调用 session_name() 函数会产生错误。所以，一定要在调用 session_start() 函数之前调用此函数。
     *
     * @param string $name 用在 cookie 或者 URL 中的会话名称，例如：PHPSESSID。只能使用字母和数字作为会话名称，建议尽可能的短一些，并且是望文知意的名字
     * @return string 返回当前会话名称。如果指定 name 参数，那么此函数会更新会话名称，并且返回 原来的 会话名称。
     */
    public static function session_name(string $name = null) : string
    {
        return session_name(...func_get_args());
    }

    /**
     * 读取/设置当前会话的保存路径

     *
     * Note:在某些操作系统上，建议使用可以高效处理大量小尺寸文件的文件系统上的路径来保存会话数据。例如，在 Linux 平台上，对于会话数据保存的工作而言，reiserfs 文件系统会比 ext2fs 文件系统能够提供更好的性能。
     *
     * @param string $path 指定会话数据保存的路径。必须在调用 session_start() 函数之前调用 session_save_path() 函数。
     * @return string 返回保存会话数据的路径。
     */
    public static function session_save_path(string $path = null) : string
    {
        return session_save_path(...func_get_args());
    }


    /**
     * 读取/设置缓存限制器
     *
     * session.cache_limiter
     *
     * $cache_limiter
     *  public
     *      Expires：（根据 session.cache_expire 的设定计算得出）
     *      Cache-Control： public, max-age=（根据 session.cache_expire 的设定计算得出）
     *      Last-Modified：（会话最后保存时间）
     *
     *  private_no_expire
     *      Cache-Control: private, max-age=（根据 session.cache_expire 的设定计算得出）, pre-check=（根据 session.cache_expire 的设定计算得出）
     *      Last-Modified: （会话最后保存时间）
     *
     *  private
     *      Expires: Thu, 19 Nov 1981 08:52:00 GMT
     *      Cache-Control: private, max-age=（根据 session.cache_expire 的设定计算得出）, pre-check=（根据 session.cache_expire 的设定计算得出）
     *      Last-Modified: （会话最后保存时间）
     *
     *  nocache
     *      Expires: Thu, 19 Nov 1981 08:52:00 GMT
     *      Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
     *      Pragma: no-cache
     *
     * @param string $cache_limiter 如果指定了 cache_limiter 参数，将使用指定值作为缓存限制器的值。
     * @return string 返回当前所用的缓存限制器名称。
     */
    public static function session_cache_limiter(string $cache_limiter = null) : string
    {
        return session_cache_limiter( ...func_get_args());
    }


    /**
     * 返回当前缓存的到期时间
     * 请求开始的时候，缓存到期时间会被重置为 180，并且保存在 session.cache_expire 配置项中。
     * 因此，针对每个请求，需要在 session_start() 函数调用之前调用 session_cache_expire() 来设置缓存到期时间。
     *
     * Note: 仅在 session.cache_limiter 的设置值 不是 nocache 的时候，才可以设置 new_cache_expire 参数。
     *
     * @param string $new_cache_expire 如果给定 new_cache_expire ，就使用 new_cache_expire 的值设置当前缓存到期时间。
     * @return int 返回 session.cache_expire 的当前设置值，以分钟为单位，默认值是 180 （分钟）。
     */
    public static function session_cache_expire(string $new_cache_expire = null) : int
    {
        return session_cache_expire(...func_get_args());
    }





    /**
     * 设置会话 cookie 参数
     *
     * @param int $lifetime Cookie 的 生命周期，以秒为单位。
     * @param string $path 此 cookie 的有效 路径。 on the domain where 设置为"/"表示对于本域上所有的路径此 cookie 都可用
     * @param string $domain Cookie 的作用 域。例如："www.php.net"。如果要让 cookie 在所有的子域中都可用，此参数必须以点（.）开头，例如：".php.net"。
     * @param bool $secure  设置为 TRUE 表示 cookie 仅在使用 安全 链接时可用。
     * @param bool $httponly 设置为 TRUE 表示 PHP 发送 cookie 的时候会使用 httponly 标记。禁止JavaScript操作cookie,并非所有浏览器都支持
     * @return bool
     */
    public static function session_set_cookie_params( int $lifetime, string $path = null, string $domain= null, bool $secure = FALSE, bool $httponly = FALSE) : bool
    {
        return session_set_cookie_params(...func_get_args());
    }




    /**
     * 获取会话 cookie 参数
     *
     * "lifetime" - cookie 的生命周期，以秒为单位。
     * "path" - cookie 的访问路径。
     * "domain" - cookie 的域。
     * "secure" - 仅在使用安全连接时发送 cookie。
     * "httponly" - 只能通过 http 协议访问 cookie
     *
     * @return array 返回一个包含当前会话 cookie 信息的数组：
     */
    public static function session_get_cookie_params() : array
    {
        return session_get_cookie_params();
    }

    /**
     * 返回当前会话状态。
     *
     * 返回值
     * ◦ PHP_SESSION_DISABLED 会话是被禁用的。
     * ◦ PHP_SESSION_NONE 会话是启用的，但不存在当前会话。
     * ◦ PHP_SESSION_ACTIVE 会话是启用的，而且存在当前会话。
     *
     * @return int
     */
    public static function session_status() : int
    {
        return session_status();
    }




    /**
     * 获取/设置当前会话 ID
     * Note: 如果使用 cookie 方式传送会话 ID，并且指定了 id 参数，在调用 session_start() 之后都会向客户端发送新的 cookie，无论当前的会话 ID 和新指定的会话 ID 是否相同。
     *
     * 为了能够将会话 ID 很方便的附加到 URL 之后，你可以使用常量 SID 获取以字符串格式表达的会话名称和 ID。请参考 会话处理。
     *
     * @param string $id 如果指定了 id 参数的值，则使用指定值作为会话 ID。必须在调用 session_start() 函数之前调用 session_id() 函数。
     * @return string session_id() 返回当前会话ID。如果当前没有会话，则返回空字符串（""）。
     */
    public static function session_id(string $id = null) : string
    {
        return session_id(...func_get_args());
    }





    /** ························ 操作········································· */

    /**
     * 启动新会话或者重用现有会话
     * 会创建新会话或者重用现有会话。如果通过 GET 或者 POST 方式，或者使用 cookie 提交了会话 ID，则会重用现有会话。
     *
     * 当会话自动开始或者通过 session_start() 手动开始的时候， PHP 内部会调用会话管理器的 open 和 read 回调函数。会话管理器可能是 PHP 默认的，也可能是扩展提供的（SQLite 或者 Memcached 扩展），也可能是通过 session_set_save_handler() 设定的用户自定义会话管理器。
     * 通过 read 回调函数返回的现有会话数据（使用特殊的序列化格式存储）， PHP 会自动反序列化数据并且填充 $_SESSION 超级全局变量。
     *
     * @param array $options 此参数是一个关联数组，如果提供，那么会用其中的项目覆盖 会话配置指示 中的配置项。此数组中的键无需包含 session. 前缀。
     * @return bool
     */
    public static function session_start(array $options = array()) : bool
    {
        return session_start(...func_get_args());
    }

    /**
     * 为当前会话创建新会话 ID
     *
     * 如果会话未处于活动状态，则忽略冲突检查。
     * 会话 ID 根据 php.ini 设置创建。
     *
     * @param string|null $prefix 如果指定了前缀，则新会话 idi 以前缀为前缀。 会话 ID 中不允许使用所有字符。 允许使用 a-z A-Z 0-9 、（逗号）和 -（减号）范围内的字符。
     * @return string 为当前会话返回新的无碰撞会话 ID。 如果在没有 activesession 的情况下使用它，它会忽略冲突检查。
     */
    public static function session_create_id(string $prefix = null) : string
    {
        return session_create_id(...func_get_args());
    }


    /**
     * 使用新生成的会话 ID 更新现有会话 ID
     * 在不修改当前会话中数据的前提下使用新的 ID 替换原有会话 ID。
     * 如果启用了 session.use_trans_sid 选项，那么必须在调用 session_regenerate_id() 函数之后开始进行输出工作，否则会导致使用原有的会话 ID。
     *
     * @param bool $delete_old_session 是否删除原 ID 所关联的会话存储文件。如果你需要避免会话并发访问冲突，那么不应该立即删除会话中的数据。如果你需要防止会话劫持攻击，那么可以立即删除会话数据。
     * @return bool
     */
    public static function session_regenerate_id(bool $delete_old_session = FALSE) : bool
    {
        return session_regenerate_id( $delete_old_session);
    }





//    /**
//     * 在当前会话中注册一个或多个全局变量
//     * 接受可变数量的参数，其中任何一个都可以是包含变量名称的字符串，也可以是由变量名称或其他数组组成的数组。对于每个名称， session_register() 在当前会话中使用该名称注册全局变量。
//     *
//     * 您还可以通过简单地设置 $_SESSION 数组的适当成员来创建会话变量。
//     *
//     * Warning  本函数已自 PHP 5.3.0 起废弃并将自 PHP 5.4.0 起移除。
//     *
//     * @param mixed $name
//     * @param mixed ...$names
//     * @return bool
//     */
//    public static function session_register( $name, ...$names) : bool
//    {
//        return session_register( $name, ...$names);
//    }


//    /**
//     * 检查变量是否在会话中已经注册
//     * @param string $name 变量名称。
//     * @return bool
//     */
//    public static function session_is_registered( string $name) : bool
//    {
//        return session_is_registered( $name);
//    }



    /**
     * 用原始值重新初始化会话数组
     * 使用存储在会话存储中的原始值重新初始化会话。 此函数需要活动会话并放弃 $_SESSION 中的更改。
     *
     * @return bool
     */
    public static function session_reset() : bool
    {
        return session_reset();
    }


    /**
     * 将当前会话数据编码为一个字符串
     * 返回一个序列化后的字符串，包含被编码的、储存于 $_SESSION 超全局变量中的当前会话数据。
     * 请注意，序列方法 和 serialize() 是不一样的。该序列方法是内置于 PHP 的，能够通过设置 session.serialize_handler 来设置。
     * @return string
     */
    public static function session_encode() : string
    {
        return session_encode();
    }


    /**
     * 解码会话数据
     * 对 $data 参数中的已经序列化的会话数据进行解码，并且使用解码后的数据填充 $_SESSION 超级全局变量。
     * 请注意，这里的反序列化方法不同于 unserialize() 函数。序列化方法是 PHP 内置的，并且可以通过 session.serialize_handler 配置项进行修改。
     *
     * @param string $data  编码后的数据
     * @return bool
     */
    public static function session_decode( string $data) : bool
    {
        return session_decode( $data);
    }






    /**
     * 销毁一个会话中的全部数据
     * 不会重置当前会话所关联的全局变量，也不会重置会话 cookie。如果需要再次使用会话变量，必须重新调用 session_start() 函数。
     * 为了彻底销毁会话，必须同时重置会话 ID。如果是通过 cookie 方式传送会话 ID 的，那么同时也需要调用 setcookie() 函数来删除客户端的会话 cookie。
     * 当启用了 session.use_strict_mode 配置项的时候，你不需要删除过期会话 ID 对应的 cookie，因为会话模块已经不再接受携带过期会话 ID 的 cookie 了，然后它会生成一个新的会话 ID cookie。建议所有的站点都启用 session.use_strict_mode 配置项。
     *
     * Note: 通常情况下，在你的代码中不必调用 session_destroy() 函数，可以直接清除 $_SESSION 数组中的数据来实现会话数据清理。
     *
     * @return bool
     */
    public static function session_destroy(): bool
    {
        return session_destroy();
    }


    /** ························ 结束 ········································· */


    /**
     * 释放当前会话注册的所有会话变量。
     *
     * Caution 请不要使用unset($_SESSION)来释放整个$_SESSION，因为它将会禁用通过全局$_SESSION去注册会话变量
     *
     */
    public static function session_unset() : void
    {
        session_unset();
    }


    /**
     * 结束当前会话并存储会话数据。 别名session_commit
     * 会话数据通常在您的脚本终止后存储，无需调用
     * 但由于会话数据被锁定以防止并发写入，因此任何时候只有一个脚本可以对会话进行操作; 您可以通过在对会话变量的所有更改完成后立即结束会话来减少加载所有帧所需的时间。
     *
     * @return bool
     */
    public static function session_write_close() : bool
    {
        return session_write_close();
    }




    /**
     * 放弃会话数组更改; 并完成会话
     * session_abort() 结束会话而不保存数据。 因此，会话数据中的原始值得以保留。
     *
     * @return bool 7.2.0该函数的返回类型现在为bool，以前为void。
     */
    public static function session_abort() : bool
    {
        return session_abort();
    }



    /** ························ 其他 ········································· */


//    /**
//     *  设置用户自定义会话存储函数
//     *
//     *  session_set_save_handler( object $sessionhandler[, bool $register_shutdown = TRUE] ) : bool
//     *
//     *
//     * @param callable $open
//     * @param callable $close
//     * @param callable $read
//     * @param callable $write
//     * @param callable $destroy
//     * @param callable $gc
//     * @param callable|null $create_sid
//     * @param callable|null $validate_sid
//     * @param callable|null $update_timestamp
//     * @return bool
//     */
//    public static function session_set_save_handler( callable $open, callable $close, callable $read, callable $write, callable $destroy, callable $gc, callable $create_sid = null, callable $validate_sid = null , callable $update_timestamp = null ) : bool
//    {
//        return session_set_save_handler(...func_get_args());
//    }


    /**
     * 设置用户自定义会话存储函数
     *
     * 设置用户自定义会话存储函数。如果想使用 PHP 内置的会话存储机制之外的方式，可以使用本函数。例如，可以自定义会话存储函数来将会话数据存储到数据库。
     *
     *
     * @param object $sessionhandler 实现了 SessionHandlerInterface， SessionIdInterface 和/或 SessionUpdateTimestampHandlerInterface 接口的对象，例如 SessionHandler。
     * @param bool $register_shutdown 将函数 session_write_close() 注册为 register_shutdown_function() 函数。
     * @return bool
     */
    public static function session_set_save_handler( object $sessionhandler, bool $register_shutdown = TRUE) : bool
    {
        return session_set_save_handler(...func_get_args());
    }



    /**
     * 执行会话数据垃圾收集
     * @return int
     */
    public static function session_gc() : int
    {
        return session_gc();
    }






}

