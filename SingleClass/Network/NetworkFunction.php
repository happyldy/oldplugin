<?php


namespace HappyLin\OldPlugin\SingleClass\Network;


class NetworkFunction{


    /**
     * 给指定的主机（域名）或者IP地址做DNS通信检查
     *
     * 别名 dns_check_record
     *
     * Note: 出于对低版本在windows平台上的兼容性，可以试试» PEAR扩展包里面提供的 » Net_DNS类。
     *
     * @param string $host 主机（host）可以是一个IP地址也可以是域名。
     * @param string $type 解析记录类型（type）可能是下面这些类型中的任何一个：A，MX，NS，SOA，PTR，CNAME，AAAA，A6， SRV，NAPTR，TXT 或者 ANY。
     * @return bool  如果记录能找到，就返回TRUE；如果查找不到该DNS记录或者发生了错误，就返回FALSE。
     */
    public static function checkdnsrr( string $host, string $type = "MX" ) : bool
    {
        return checkdnsrr( $host, $type = "MX" );
    }


    /**
     * 获取互联网主机名对应的 MX 记录
     *
     * 别名 dns_get_mx
     *
     * Note:本函数不应使用于地址验证。仅在 MX 记录在 DNS 中找到时才会返回，然而根据 » RFC 2821，没有 MX 记录时， hostname 本身就是 MX 主机，优先级为 0。
     * Note:在兼容 Windows 实现之前的版本， 可以使用 » PEAR class 的 » Net_DNS。
     *
     * @param string $hostname 互联网主机名。
     * @param array $mxhosts 找到的 MX 记录列表存放于 mxhosts 数组。
     * @param array|null $weight 提供了 weight 数组后，它会用找到的权重信息填充数组。
     * @return bool 找到记录返回 TRUE，没找到或者出错时返回 FALSE。
     */
    public static function getmxrr( string $hostname, array &$mxhosts, array &$weight = null) : bool
    {
        return getmxrr( $hostname, $mxhosts, $weight);
    }


    /**
     * 获取指定主机的DNS记录
     *
     * Note: 每个DNS标准，邮件地址必须是user.host这样的格式（例如hostmaster.example.com而不是hostmaster@example.com），在使用mail()这个函数之前请检查这个值，有必要的话还需要修改。
     *
     *
     * @param string $hostname 主机名（hostname）应该是一个DNS解析生效的域名，例如"www.example.com"。主机名也可以是通过对逆向解析域做DNS逆向域名解析而得到，但是在大多数情况下gethostbyaddr()更加适合做逆向域名解析。
     * @param int $type 默认情况下，dns_get_record()将会搜索所有与hostname相关的记录，可以通过设置type来限定查询。type的值可以是下面的其中的任何一个： DNS_A，DNS_CNAME，DNS_HINFO，DNS_MX，DNS_NS，DNS_PTR，DNS_SOA，DNS_TXT，DNS_AAAA，DNS_SRV，DNS_NAPTR，DNS_A6，DNS_ALL或者DNS_ANY。
     * @param array $authns 以引用方式传递，如果写了该参数，那么将会得到该解析记录的DNS服务器（Authoritative Name Servers）的信息。
     * @param array $addtl 以引用方式传递，如果填写了该参数，将会得到其他所有的DNS解析记录。
     * @param bool $raw 在原生模式下，在进行额外的查询的时候之前我们只执行请求的DNS类型，而不是循环查询所有的类型。
     * @return array 这个函数返回一个关联数组，如果失败则 或者在失败时返回 FALSE。每个关联数组都至少包含了以下的这些键。 at minimum the following keys
     */
    public static function dns_get_record( string $hostname, int $type = DNS_ANY, array &$authns = null, array &$addtl = null, bool &$raw = false )
    {
        return dns_get_record( $hostname,  $type,$authns, $addtl, $raw);
    }


    /**
     * 获取本地机器的标准主机名。
     *
     * @return string | false 成功时返回主机名称字符串，失败时返回 FALSE。
     */
    public static function gethostname()
    {
        return gethostname();
    }



    /**
     * 返回主机名 hostname 对应的 IPv4 互联网地址。
     * @param string $hostname 主机名
     * @return string 成功时返回 IPv4 地址，失败时原封不动返回 hostname 字符串。
     */
    public static function gethostbyname( string $hostname) : string
    {
        return gethostbyname( $hostname);
    }


    /**
     * 返回互联网主机名 hostname 解析出来的 IPv4 地址列表。
     * @param string $hostname 主机名。
     * @return array | false 返回 IPv4 地址数组，或在 hostname 无法解析时返回 FALSE。
     */
    public static function gethostbynamel( string $hostname) : array
    {
        return gethostbynamel( $hostname);
    }


    /**
     * 获取指定的IP地址对应的主机名
     *
     * @param string $ip_address 主机的IP地址。
     * @return string | false 成功则返回主机名；失败则原样输出（输出IP地址）；如果输入的格式不正常，则返回FALSE。
     */
    public static function gethostbyaddr( string $ip_address)
    {
        return gethostbyaddr( $ip_address);
    }


    /**
     * 初始化所有与系统日志相关的变量 php <=5.4
     */
    public static function define_syslog_variables() : void
    {
        \define_syslog_variables();
    }



    /**
     * 获取与协议名称关联的协议编号
     * 根据 /etc/protocols 返回与协议名称关联的协议编号。
     *
     * @param string $name 协议名称。
     * @return int|false 返回协议号，或者在失败时返回 FALSE。
     */
    public static function getprotobyname( string $name)
    {
        return  getprotobyname( $name) ;
    }


    /**
     * 获取与协议编号关联的协议名称
     * 根据 /etc/protocols 返回与协议编号关联的协议名称。
     * @param int $number 协议编号。
     * @return string|false 以字符串形式返回协议名称，或者在失败时返回 FALSE。
     */
    public static function getprotobynumber( int $number)
    {
        return getprotobynumber( $number);
    }



    /**
     * 获取互联网服务协议对应的端口
     * 返回互联网服务 service 指定的协议 protocol 中对应的端口，依据 /etc/services。
     *
     * @param string $service 互联网服务名称的字符串。
     * @param string $protocol protocol 既可以是 "tcp" 也可以是 "udp" (小写)。
     * @return int 返回端口号，如果 service 或 protocol 未找到返回 FALSE。
     */
    public static function getservbyname( string $service, string $protocol)
    {
        return getservbyname(  $service, $protocol);
    }

    /**
     * 获取端口和协议对应的Internet服务
     * 根据 /etc/services 返回与指定协议的端口相关联的 Internet 服务。
     * @param int $port  端口号。
     * @param string $protocol 协议是“tcp”或“udp”（小写）。
     * @return string 以字符串形式返回 Internet 服务名称。
     */
    public static function getservbyport( int $port, string $protocol) : string
    {
        return getservbyport( $port, $protocol);
    }



    /**
     * 将打包的互联网地址转换为人类可读的表示
     * 此函数将 32 位 IPv4 或 128 位 IPv6 地址（如果 PHP 构建时启用了 IPv6 支持）转换为地址族适当的字符串表示。
     *
     * @param string $in_addr 32 位 IPv4 或 128 位 IPv6 地址。
     * @return string|false 返回地址的字符串表示形式或者在失败时返回 FALSE。
     */
    public static function inet_ntop( string $in_addr)
    {
        return inet_ntop( $in_addr);
    }

    /**
     * 将人类可读的 IP 地址转换为其打包的 in_addr 表示
     * 此函数将人类可读的 IPv4 或 IPv6 地址（如果 PHP 构建时启用了 IPv6 支持）转换为适合 32 位或 128 位二进制结构的地址族。
     * @param string $address 人类可读的 IPv4 或 IPv6 地址。
     * @return string 返回给定地址的 in_addr 表示，如果给出了语法无效的地址（例如，没有点的 IPv4 地址或没有冒号的 IPv6 地址），则返回 FALSE。
     */
    public static function inet_pton( string $address)
    {
        return inet_pton( $address);
    }




    /**
     * 将 IPV4 的字符串互联网协议转换成长整型数字
     * 函数 ip2long() 返回 IPV4 网络地址的长整型格式，从标准网络地址格式(点字符串)转化得到。
     * ip2long() 还可以与非完整IP进行工作。阅读 » http://publibn.boulder.ibm.com/doc_link/en_US/a_doc_lib/libs/commtrf2/inet_addr.htm 获得更多信息。
     *
     * @param string $ip_address 一个标准格式的地址。
     * @return int 返回IP地址转换后的数字 或 FALSE 如果 ip_address 是无效的。
     */
    public static function ip2long( string $ip_address) : int
    {
        return ip2long( $ip_address);
    }

    /**
     * 将长整型转化为字符串形式带点的互联网标准格式地址（IPV4）
     * long2ip() 函数通过长整型的表达形式转化生成带点格式的互联网地址（例如：aaa.bbb.ccc.ddd ）。
     * @param int $proper_address 合格的地址，长整型的表达形式。
     * @return string 返回字符串的互联网 IP 地址。
     */
    public static function long2ip( int $proper_address) : string
    {
        return long2ip( $proper_address);
    }








    /**
     * 打开与系统记录器的连接
     * 为程序打开与系统记录器的连接
     * openlog() 的使用是可选的。 如果需要，它将被 syslog() 自动调用，在这种情况下，ident 将默认为 FALSE。
     *
     * $option
     * 您可以使用这些选项中的一个或多个。 当使用多个选项时，您需要对它们进行 OR 运算，即立即打开连接，写入控制台并在每条消息中包含 PID，您将使用：LOG_CONS | LOG_NDELAY | LOG_PID
     *  LOG_CONS        如果在向系统记录器发送数据时出现错误，则直接写入系统控制台
     *  LOG_NDELAY      立即打开与记录器的连接
     *  LOG_ODELAY      （默认）延迟打开连接，直到记录第一条消息
     *  LOG_PERROR      也将日志消息打印到标准错误
     *  LOG_PID         包含每条消息的 PID
     *
     * $facility
     * Note: LOG_USER 是 Windows 操作系统下唯一有效的日志类型
     *  LOG_AUTH        安全/授权消息（在定义该常量的系统中使用 LOG_AUTHPRIV 代替）
     *  LOG_AUTHPRIV    安全/授权消息（私有）
     *  LOG_CRON        时钟守护进程（cron 和 at）
     *  LOG_DAEMON      其他系统守护进程
     *  LOG_KERN        内核消息
     *  LOG_LOCAL0 ... LOG_LOCAL7   保留供本地使用，这些在 Windows 中不可用
     *  LOG_LPR         行式打印机子系统
     *  LOG_MAIL        邮件子系统
     *  LOG_NEWS USENET 新闻子系统
     *  LOG_SYSLOG      由 syslogd 内部生成的  消息
     *  LOG_USER        通用用户级消息
     *  LOG_UUCP        UUCP 子系统
     *
     * @param string $ident 字符串 ident 被添加到每条消息中。
     * @param int $option option 参数用于指示生成日志消息时将使用哪些日志记录选项。
     * @param int $facility 设施参数用于指定记录消息的程序类型。 这允许您指定（在您机器的系统日志配置中）如何处理来自不同设施的消息。
     * @return bool
     */
    public static function openlog( string $ident, int $option, int $facility) : bool
    {
        return openlog( $ident, $option, $facility);
    }

    /**
     * 生成系统日志消息
     * syslog() 生成将由系统记录器分发的日志消息。
     * 有关设置用户定义的日志处理程序的信息，请参阅 syslog.conf (5) Unix 手册页。 有关 syslog 工具和选项的更多信息可以在 Unix 机器上的 syslog (3) 联机帮助页中找到。
     *
     * 在 Windows NT 上，系统日志服务是使用 EventLog 模拟的。
     *
     *
     * $priority
     *  LOG_EMERG   系统不可用
     *  LOG_ALERT   必须立即采取操作
     *  LOG_CRIT    临界条件
     *  LOG_ERR     错误条件
     *  LOG_WARNING 警告条件
     *  LOG_NOTICE  正常但重要的条件
     *  LOG_INFO    信息性消息
     *  LOG_DEBUG   调试级消息
     *
     * @param int $priority 优先级是设施和级别的组合。 可能的值为
     * @param string $message 要发送的消息，除了两个字符 %m 将被替换为与 errno 当前值对应的错误消息字符串（strerror）
     * @return bool
     */
    public static function syslog( int $priority, string $message) : bool
    {
        return syslog( $priority, $message);
    }



    /**
     * 关闭系统日志链接
     * 关闭用于通信的描述符并写入系统日志。closelog()是可选的。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function closelog() : bool
    {
        return closelog();
    }




    /**
     * 用于发送原生的 HTTP 头。关于 HTTP 头的更多信息请参考 » HTTP/1.1 specification。
     * 请注意 header() 必须在任何实际输出之前调用，不管是普通的 HTML 标签，还是文件或 PHP 输出的空行，空格。这是个常见的错误，在通过include，require，或者其访问其他文件里面的函数的时候，如果在header()被调用之前，其中有空格或者空行。同样的问题也存在于单独的 PHP/HTML 文件中。
     *
     * @param string $string  头字符串。第一种以"HTTP/"开头的 (case is notsignificant)，将会被用来计算出将要发送的HTTP状态码。第二种特殊情况是"Location:"的头信息。它不仅把报文发送给浏览器，而且还将返回给浏览器一个 REDIRECT（302）的状态码
     * @param bool $replace 可选参数 replace 表明是否用后面的头替换前面相同类型的头。默认情况下会替换。如果传入 FALSE，就可以强制使相同的头信息并存。例如：header('WWW-Authenticate: Negotiate'); header('WWW-Authenticate: NTLM', false);
     * @param int $http_response_code 强制指定HTTP响应的值。注意，这个参数只有在报文字符串（string）不为空的情况下才有效。
     */
    public static function header( string $string, bool $replace = true, int $http_response_code = null) : void
    {
        header( $string,  $replace, $http_response_code);
    }

    /**
     * 删除之前设置的 HTTP 头
     * @param string $name 要移除的头名称 Note: 参数不分大小写。
     */
    public static function header_remove(string $name = null ) : void
    {
        header_remove($name);
    }

    /**
     * 获取/设置响应的 HTTP 状态码
     *
     * 如果在非 Web 服务器环境里调用（比如 CLI 应用里），不提供 response_code 就会返回 FALSE 。在非 Web 服务器环境里，提供 response_code 会返回 TRUE （仅仅在先前没有设置过状态码的时候）。
     *
     * @param int|null $response_code  可选的 response_code 会设置响应的状态码。
     * @return mixed 如果提供了 response_code，将返回先前的状态码。如果未提供 response_code，会返回当前的状态码。在 Web 服务器环境里，这些状态码的默认值都是 200。
     */
    public static function http_response_code(int $response_code = null)
    {
        return http_response_code( $response_code);
    }

    /**
     * 返回已发送的 HTTP 响应头（或准备发送的）
     * 返回准备发送给浏览器/客户端的 HTTP 头列表。检测这些头是否已经发送，使用 headers_sent()。
     * @return array
     */
    public static function headers_list() : array
    {
        return headers_list();
    }

    /**
     * 检测 HTTP 头是否已经发送。
     * HTTP 头已经发送时，就无法通过 header() 添加更多头字段。使用此函数起码可以防止 HTTP 头出错。另一个解决方案是用 输出缓冲。
     *
     * @param string $file 若设置了可选参数 file and line， headers_sent() 会把 PHP 文件名放在 file 变量里，输出开始的行号放在 line 变量里。
     * @param int $line 输出开始的行号。
     * @return bool HTTP 头未发送时，headers_sent() 返回 FALSE，否则返回 TRUE。
     */
    public static function headers_sent(string &$file = null, int &$line = null ) : bool
    {
        return headers_sent($file, $line);
    }



    /**
     * 调用一个 header 函数
     * 注册一个函数，在 PHP 开始发送输出时调用。
     * PHP 准备好所有响应头，在发送内容之前执行 callback，创建了一个发送响应头的操作窗口。
     *
     * @param callable $callback 在头发送前调用函数。它没有参数，返回的值也会被忽略。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function header_register_callback( callable $callback) : bool
    {
        return header_register_callback( $callback);
    }


    /**
     * 发送 Cookie
     * setcookie() 定义了 Cookie，会和剩下的 HTTP 头一起发送给客户端。和其他 HTTP 头一样，必须在脚本产生任意输出之前发送 Cookie（由于协议的限制）。请在产生任何输出之前（包括 <html> 和 <head> 或者空格）调用本函数。
     * 一旦设置 Cookie 后，下次打开页面时可以使用 $_COOKIE 读取。 Cookie 值同样也存在于 $_REQUEST。
     *
     * » RFC 6265 提供了 setcookie() 每个参数的参考标准。
     *
     * @param string $name Cookie 名称。
     * @param string $value Cookie 值。这个值储存于用户的电脑里，请勿储存敏感信息。比如 name 是 'cookiename'，可通过 $_COOKIE['cookiename'] 获取它的值。
     * @param int $expire Cookie 的过期时间。这是个 Unix 时间戳;可以用 time() 函数的结果加上希望过期的秒数。或者也可以用 mktime()。如果设置成零，或者忽略参数， Cookie 会在会话结束时过期（也就是关掉浏览器时）。
     * @param string $path Cookie 有效的服务器路径。设置成 '/' 时，Cookie 对整个域名 domain 有效。如果设置成 '/foo/'， Cookie 仅仅对 domain 中 /foo/ 目录及其子目录有效（比如 /foo/bar/）。默认值是设置 Cookie 时的当前目录。
     * @param string $domain Cookie 的有效域名/子域名。设置成子域名（例如 'www.example.com'），会使 Cookie 对这个子域名和它的三级域名有效（例如 w2.www.example.com）。要让 Cookie 对整个域名有效（包括它的全部子域名），只要设置成域名就可以了（这个例子里是 'example.com'
     * @param bool $secure 设置这个 Cookie 是否仅仅通过安全的 HTTPS 连接传给客户端。设置成 TRUE 时，只有安全连接存在时才会设置 Cookie。如果是在服务器端处理这个需求，程序员需要仅仅在安全连接上发送此类 Cookie （通过 $_SERVER["HTTPS"] 判断）。
     * @param bool $httponly 设置成 TRUE，Cookie 仅可通过 HTTP 协议访问。这意思就是 Cookie 无法通过类似 JavaScript 这样的脚本语言访问。要有效减少 XSS 攻击时的身份窃取行为，
     * @return bool 如果在调用本函数以前就产生了输出，setcookie() 会调用失败并返回 FALSE。如果 setcookie() 成功运行，返回 TRUE。当然，它的意思并非用户是否已接受 Cookie。
     */
    public static function setcookie( string $name, string $value = "", int $expire = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false ) : bool
    {
        return setcookie( $name, $value, $expire, $path, $domain, $secure, $httponly );
    }

    /**
     * 发送未经 URL 编码的 cookie
     * setrawcookie() 和 setcookie() 非常相似，唯一不同之处是发送到浏览器的 cookie 值没有自动经过 URL 编码（urlencode）。
     *
     * @param string $name
     * @param string $value
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httponly
     * @return bool
     */
    public static function setrawcookie( string $name, string $value, int $expire = 0, string $path, string $domain, bool $secure = false, bool $httponly = false ) : bool
    {
        return setrawcookie( $name, $value, $expire, $path, $domain, $secure, $httponly );
    }


    /**
     * 打开一个网络连接或者一个Unix套接字连接
     * 初始化一个套接字连接到指定主机（hostname）。
     *
     * 默认情况下将以阻塞模式开启套接字连接。当然你可以通过stream_set_blocking()将它转换到非阻塞模式。
     *
     * stream_socket_client()与之非常相似，而且提供了更加丰富的参数设置，包括非阻塞模式和提供上下文的的设置。
     * Note:注意：如果你要对建立在套接字基础上的读写操作设置操作时间设置连接时限，请使用stream_set_timeout()，fsockopen()的连接时限（timeout）的参数仅仅在套接字连接的时候生效。
     *
     * @param string $hostname 如果安装了OpenSSL，那么你也许应该在你的主机名地址前面添加访问协议ssl://或者是tls://，从而可以使用基于TCP/IP协议的SSL或者TLS的客户端连接到远程主机。
     * @param int $port 端口号。如果对该参数传一个-1，则表示不使用端口，例如unix://。
     * @param int $errno 返回值为0，而且这个函数的返回值为FALSE，那么这表明该错误发生在套接字连接（connect()）调用之前，导致连接失败的原因最大的可能是初始化套接字的时候发生了错误。
     * @param string $errstr 错误信息将以字符串的信息返回。
     * @param float|string $timeout 设置连接的时限，单位为秒。 ini_get("default_socket_timeout")
     * @return resource fsockopen()将返回一个文件句柄，之后可以被其他文件类函数调用（例如：fgets()，fwrite()，fclose()还有feof()）。如果调用失败，将返回FALSE。
     */
    public static function fsockopen( string $hostname, int $port = -1, int &$errno = null, string &$errstr = null, float $timeout = null) : resource
    {
        return fsockopen( $hostname, $port, $errno, $errstr, $timeout);
    }


    /**
     * 打开一个持久的网络连接或者Unix套接字连接。
     * 这个函数的作用与fsockopen()完全一样的，不同的地方在于当在脚本执行完后，连接一直不会关闭。可以说它是fsockopen()的长连接版本。
     *
     * @param string $hostname
     * @param int $port
     * @param int $errno
     * @param string $errstr
     * @param float|string $timeout ini_get("default_socket_timeout")
     * @return resource
     */
    public static function pfsockopen( string $hostname, int $port = -1, int &$errno, string &$errstr, $timeout = null ) : resource
    {
        return pfsockopen(  $hostname, $port,$errno,$errstr, $timeout );
    }



}

