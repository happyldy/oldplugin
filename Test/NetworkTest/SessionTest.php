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



namespace HappyLin\OldPlugin\Test\NetworkTest;

use HappyLin\OldPlugin\SingleClass\{Url};

use HappyLin\OldPlugin\SingleClass\Network\Session\{Session, SessionHandler};

use HappyLin\OldPlugin\Test\TraitTest;

class SessionTest
{

    use TraitTest;

    public $fileSaveDir;

    public function __construct()
    {
        $this->fileSaveDir = static::getTestDir() . '/Public/SingleClass';

    }


    /**
     * @note session相关操作函数 （自定义 my_session_start）
     */
    public function sessionTest()
    {

        var_dump(static::toStr('读取或设置会话模块名称，也被称做：session.save_handler。', Session::session_module_name()));
        var_dump(static::toStr('读取/设置会话名称;指定了新字符串作为会话 cookie 的名字，函数会修改 HTTP 响应中的 cookie;', Session::session_name()));
        var_dump(static::toStr('读取/设置当前会话的保存路径; Session::session_save_path(realpath(dirname($_SERVER["DOCUMENT_ROOT"]) . "/tmp"))')); // Session::session_save_path(realpath(dirname($_SERVER["DOCUMENT_ROOT"]) . "/tmp"))
        //var_dump(static::toStr('读取/设置缓存限制器; public, private_no_expire, private, nocache', Session::session_cache_limiter('private') ));
        var_dump(static::toStr('读取/设置缓存限制器; public, private_no_expire, private, nocache', Session::session_cache_limiter()));
        var_dump(static::toStr('读取/设置 session.cache_expire 的设定值(分钟)。仅在 session.cache_limiter 的设置不是 nocache 的时候', Session::session_cache_expire() ));
        var_dump(static::toStr('设置会话 cookie 参数; session_set_cookie_params(2*3600, "/", null, false, false)')); // Session::session_set_cookie_params(2*3600, "/", null, false, false)
        var_dump(static::toStr('获取会话 cookie 参数', Session::session_get_cookie_params()));
        var_dump(static::toStr(
            '返回当前会话状态。[PHP_SESSION_DISABLED %s  会话是被禁用的。 PHP_SESSION_NONE %s  会话是启用的，但不存在当前会话。 PHP_SESSION_ACTIVE %s  会话是启用的，而且存在当前会话。 ]',
            PHP_SESSION_DISABLED,
            PHP_SESSION_NONE,
            PHP_SESSION_ACTIVE,
            Session::session_status()
        ));

        var_dump(static::toStr('获取/设置当前会话 ID; 可以使用常量 SID;', Session::session_id()));
        echo '<hr>以上需要 session_start() 之前操作</hr><br>';

        var_dump(static::toStr('启动新会话或者重用现有会话; session_start([])')); // Session::session_start([])
        var_dump(static::toStr('创建新会话 ID', Session::session_create_id(null) ));
        var_dump(static::toStr('使用新生成的会话 ID 更新现有会话 ID; session_create_id()和session_id($new_session_id)的结合体; session_regenerate_id(false)')); // Session::session_regenerate_id(false)
        var_dump(static::toStr('改；用原始值重新初始化会话数组', Session::session_reset()));
        var_dump(static::toStr('解码，通过设置 session.serialize_handler 解码数据填充 $_SESSION 超级全局变量。session_decode()')); //, Session::session_decode()
        var_dump(static::toStr('编码，通过设置 session.serialize_handler 编码数据填充 $_SESSION 超级全局变量。session_decode()')); //, Session::session_decode()
        var_dump(static::toStr(
            '删；销毁当前会话中的全部数据; 但是不会重置当前会话所关联的全局变量，也不会重置会话 cookie。再次使用会话变量，必须重新调用 session_start() 函数; 通常情况下可以直接清除 $_SESSION 数组中的数据; 如果是通过 cookie 方式传送会话 ID 的，那么同时也需要调用 setcookie() 函数来删除客户端的会话 cookie;'
        )); //  Session::session_destroy()

        var_dump(static::toStr('删；释放当前会话注册的所有会话变量。 ； session_unset', Session::session_unset()));
        var_dump(static::toStr('结束当前会话并存储会话数据。会话数据通常在您的脚本终止后存储，无需调用;  session_write_close() 别名session_commit', Session::session_write_close()));
        var_dump(static::toStr('结束会话而不保存数据。会话数据中的原始值得以保留', Session::session_abort() ));
        var_dump(static::toStr('执行会话数据垃圾收集;session_gc()')); // Session::session_gc()
        var_dump(static::toStr('其他函数', [
            'session_register_shutdown  — 关闭会话;将 session_write_close() 函数注册为关闭会话的函数',
            'session_set_save_handler(new SessionHandler())     设置用户自定义会话存储函数'
        ]));
    }


    /**
     * @note 开启 session 基础配置参数
     */
    public function prepareSessionStart(){
        // Session::session_module_name('file');
        Session::session_name('cookieSessionName');
        Session::session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/tmp'));
        Session::session_cache_limiter('private');
        Session::session_cache_expire(180);
    }


    /**
     * @note 开启session(my_session_regenerate_id 创建的session可预防网络不稳定)
     */
    function my_session_start() {
        session_start();
        if (isset($_SESSION['destroyed'])) {
            if ($_SESSION['destroyed'] < time()-300) {
                // 通常不会发生这种情况。如果发生，那么可能是由于不稳定的网络状况或者被攻击导致的
                // 移除用户会话中的认证信息
                remove_all_authentication_flag_from_active_sessions($_SESSION['userid']);
                throw(new DestroyedSessionAccessException);
            }
            if (isset($_SESSION['new_session_id'])) {
                // 尚未完全过期，可能是由于网络不稳定引起的。
                // 尝试再次设置正确的会话 ID cookie。
                // 注意：如果你需要移除认证标记，那么不要尝试再次设置会话 ID。
                session_commit();
                session_id($_SESSION['new_session_id']);
                // 现在有了新的会话 ID 了。
                session_start();
                return;
            }
        }
    }

    /**
     * @note 创建session可预防网络不稳定
     */
    function my_session_regenerate_id()
    {
        // 如果由于不稳定的网络导致没有创建会话 ID，那么就创建一个
        $new_session_id = session_create_id();
        $_SESSION['new_session_id'] = $new_session_id;

        // 设置销毁时间戳
        $_SESSION['destroyed'] = time();

        // 保存并关闭会话
        session_commit();

        // 使用新的会话 ID 开始会话
        session_id($new_session_id);
        // 如果启用此模式, 模块不接受未初始化的会话 ID。 如果未初始化的会话 ID 是从浏览器发送的，则新的会话 ID 将发送到浏览器。
        ini_set('session.use_strict_mode', 0);
        session_start();
        ini_set('session.use_strict_mode', 1);

        // 新的会话不需要这 2 个数据了
        unset($_SESSION['destroyed']);
        unset($_SESSION['new_session_id']);
    }





}
