<?php

namespace HappyLin\OldPlugin\Test\NetworkTest;


use HappyLin\OldPlugin\SingleClass\Network\{HeaderHelp, NetworkFunction};


use HappyLin\OldPlugin\Test\TraitTest;

class NetworkFunctionTest
{

    use TraitTest;


    public $fileSaveDir;


    public function __construct()
    {
    }

    /**
     * @note 网络通信相关函数（主机信息，网络协议，日志，header）
     */
    public function networkFunctionTest()
    {
        // "www.baidu.com"  "14.215.177.38" ;  "www.toutiao.com"  "125.77.164.244"

        var_dump(static::toStr('主机信息；获取指定主机的DNS记录; dns_get_record("www.baidu.com"); 报错 DNS Query failed')); //NetworkFunction::dns_get_record("www.runoob.com");
        var_dump(static::toStr('主机信息；检查DNS通信给指定的主机（域名）或者IP地址; 别名 dns_check_record', NetworkFunction::checkdnsrr('www.toutiao.com')));
        $mxhosts = [];
        $res = NetworkFunction::getmxrr('www.toutiao.com', $mxhosts);
        var_dump(static::toStr('主机信息；获取互联网主机名对应的 MX 记录; 别名 dns_get_mx', $res, $mxhosts));
        echo "<hr><br>";

        var_dump(static::toStr('主机信息；获取本地机器的标准主机名。', NetworkFunction::gethostname()));
        var_dump(static::toStr('主机信息；获取主机名 hostname 对应的 IPv4 互联网地址。www.toutiao.com ',  $ip = NetworkFunction::gethostbyname('www.toutiao.com')));
        var_dump(static::toStr('主机信息；获取指定的IP地址对应的主机名',  NetworkFunction::gethostbyname($ip)));
        var_dump(static::toStr('主机信息；获取互联网主机名 hostname 解析出来的 IPv4 地址列表。www.toutiao.com ',  NetworkFunction::gethostbynamel('www.toutiao.com')));
        echo "<hr><br>";

        var_dump(static::toStr('网络协议; 获取与协议名称关联的协议编号；根据 /etc/protocols', $number = NetworkFunction::getprotobyname('tcp')));
        var_dump(static::toStr('网络协议; 获取与协议编号关联的协议名称 。', $name = NetworkFunction::getprotobynumber($number)));
        $services = array('http', 'ftp', 'ssh', 'telnet', 'imap',
            'smtp', 'nicname', 'gopher', 'finger', 'pop3', 'www');
        $services_res = [];
        foreach ($services as $service) {
            $port = NetworkFunction::getservbyname($service, 'tcp');
            $services_res[] = $service . ": " . $port;
        }
        var_dump(static::toStr('网络协议; 获取互联网服务协议对应的端口', $services_res));
        var_dump(static::toStr('网络协议; 获取端口和协议对应的Internet服务', NetworkFunction::getservbyport(80, 'tcp')));
        echo "<hr><br>";

        var_dump(static::toStr('IP 地址; 将人类可读的 IP 地址转换为其打包的 in_addr 表示; chr(127) . chr(0) . chr(0) . chr(1) === inet_pton("127.0.0.1")', $expanded = NetworkFunction::inet_pton("127.0.0.1")));
        var_dump(static::toStr('IP 地址; 将打包的互联网地址转换为人类可读的表示;  ',  NetworkFunction::inet_ntop($expanded)));
        var_dump(static::toStr('IP 地址; 将 IPV4 的字符串互联网协议转换成长整型数字; ip2long("127.0.0.1")', $ip = NetworkFunction::ip2long("127.0.0.1")));
        var_dump(static::toStr('IP 地址; 将长整型转化为字符串形式带点的互联网标准格式地址（IPV4）', NetworkFunction::long2ip($ip)));
        echo "<hr><br>";

        //var_dump(static::toStr('初始化所有与系统日志相关的变量 php <= 5.4',  NetworkFunction::define_syslog_variables()));
        var_dump(static::toStr('日志;打开与系统记录器的连接',  NetworkFunction::openlog("myScriptLog", LOG_PID | LOG_PERROR, LOG_USER)));
        var_dump(static::toStr('日志;生成系统日志消息',  NetworkFunction::syslog(LOG_ALERT, "Unauthorized client: ". date("Y/m/d H:i:s") ." {$_SERVER['REMOTE_ADDR']} ({$_SERVER['HTTP_USER_AGENT']})")));
        var_dump(static::toStr('日志;关闭系统日志链接',  NetworkFunction::closelog()));

        echo "<hr><br>";

        // 这个时候已经发送了，没办法执行
        var_dump(static::toStr('header; 注册一个函数，在 PHP 开始发送输出时调用; header_register_callback(callable);  这个时候已经发送了，没办法执行; HappyLin\OldPlugin\SingleClass\Network\HeaderHelp就是这么干的'));
        var_dump(static::toStr('header; 发送原生 HTTP 头; header("X-Test: foo") '));  //  NetworkFunction::header("X-Test: foo");
        var_dump(static::toStr('header; 删除之前设置的 HTTP 头; header_remove("X-Test") '));  // NetworkFunction::header_remove("X-Test");
        var_dump(static::toStr('header; 获取/设置响应的 HTTP 状态码; http_response_code() ', NetworkFunction::http_response_code()));
        var_dump(static::toStr('header; 获取准备发送给浏览器/客户端的 HTTP 头列表', NetworkFunction::headers_list()));
        var_dump(static::toStr('header; 检测 HTTP 头是否已经发送', NetworkFunction::headers_sent()));
        echo "<hr><br>";

        var_dump(static::toStr('Cookie; 发送 Cookie; setcookie("cookie[three]", "cookiethree", 0, "/") ')); // NetworkFunction::setcookie("cookie[three]", "cookiethree", 0, "/");
        echo "<hr><br>";

        var_dump(static::toStr('其他函数', [
            'fsockopen — 打开一个网络连接或者一个Unix套接字连接',
            'pfsockopen — 打开一个持久的网络连接或者Unix套接字连接',

            'socket_get_status — 别名 stream_get_meta_data()',
            'socket_set_blocking — 别名 stream_set_blocking()',
            'socket_set_timeout — 别名 stream_set_timeout()',
        ]));
        //var_dump(static::toStr('打开一个网络连接或者一个Unix套接字连接;stream_socket_client()与之非常相似; fsockopen("www.baidu.com", 80, $errno, $errstr, 30)')); //NetworkFunction::fsockopen()


////        openlog("myScriptLog", LOG_PID | LOG_PERROR, LOG_USER);
////            $access = date("Y/m/d H:i:s");
////            $res = syslog(LOG_ALERT, "Unauthorized client: $access {$_SERVER['REMOTE_ADDR']} ({$_SERVER['HTTP_USER_AGENT']})");
////            var_dump($res);
////        closelog();
//
//        $facilities = array(
//            LOG_AUTH,
//            LOG_AUTHPRIV,
//            LOG_CRON,
//            LOG_DAEMON,
//            LOG_KERN,
////            LOG_LOCAL0,
//            LOG_LPR,
//            LOG_MAIL,
//            LOG_NEWS,
//            LOG_SYSLOG,
//            LOG_USER,
//            LOG_UUCP,
//        );
//        for ($i = 0; $i < 20; $i++) {
//            foreach ($facilities as $facility) {
//                $res = openlog('test', LOG_PID, $facility);
////                var_dump($res);
//
//                $res = syslog(LOG_ERR, "This is a test: " . memory_get_usage(true));
////                var_dump($res);
//            }
//        }

//        $fp = fsockopen("www.baidu.com", 80, $errno, $errstr, 30);
//
//        if (!$fp) {
//            echo "$errstr ($errno)<br />\n";
//        } else {
//            $out = "GET / HTTP/1.1\r\n";
//            $out .= "Host: www.example.com\r\n";
//            $out .= "Connection: Close\r\n\r\n";
//            fwrite($fp, $out);
//            while (!feof($fp)) {
//                echo fgets($fp, 128);
//            }
//            fclose($fp);
//        }

    }

    /**
     * @note 网址字符串操作函数
     */
    public function URLsTest(){

        $data = array('foo', 'bar','cow' => 'milk', 'php' =>'hypertext processor');
        var_dump(static::toStr("使用关联数组生成一个经过 URL-encode 的请求字符串;\n http_build_query( %s , 'myvar_', '&',PHP_QUERY_RFC1738);\n", json_encode($data), $httpQuery = http_build_query($data, 'myvar_', '&',PHP_QUERY_RFC1738)));

        var_dump(static::toStr('base64;使用 MIME base64 对数据进行编码;使二进制数据可以通过非纯 8-bit 的传输层传输，例如电子邮件的主体;比原始数据多占用 33% 左右的空间 base64_encode("测试")'. PHP_EOL, $base64Str = base64_encode($httpQuery)));
        var_dump(static::toStr("base64;对使用 MIME base64 编码的数据进行解码; base64_decode({$base64Str}, false)". PHP_EOL, base64_decode($base64Str, false)));

        var_dump(static::toStr('rawurlencode; 按照 RFC 3986 对 URL 进行编码。除了 -_. 之外的所有非字母数字字符都将被替换成百分号（%）后跟两位十六进制数'. PHP_EOL, $httpQueryEn = rawurlencode($httpQuery)));
        var_dump(static::toStr('rawurldecode;对按照 RFC 3986 URL 进行编码的字符串进行解码'. PHP_EOL, rawurldecode($httpQueryEn)));

        var_dump(static::toStr('urlencode;编码 URL 字符串; 此编码在将空格编码为加号（+）方面与 » RFC3986 编码不同'. PHP_EOL, $httpQueryEn = urlencode($httpQuery)));
        var_dump(static::toStr('urldecode;解码已编码的 URL 字符串'. PHP_EOL, urldecode($httpQueryEn)));

        var_dump(static::toStr("解析 URL，返回其组成部分;指定 PHP_URL_SCHEME、 PHP_URL_HOST、 PHP_URL_PORT、 PHP_URL_USER、 PHP_URL_PASS、 PHP_URL_PATH、 PHP_URL_QUERY 或 PHP_URL_FRAGMENT 的其中一个来获取 URL 中指定的部分的 string; \n parse_url( 'http://username:password@hostname/path?arg=value#anchor'); ",  parse_url('http://username:password@hostname/path?arg=value#anchor')));

        var_dump(static::toStr('从一个文件中提取所有的 meta 标签 content 属性;只用于本地文件，不适用于 URL。', get_meta_tags(HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR . '/View/PHPFileLinkMethod.php')));

        var_dump(static::toStr('取得服务器响应一个 HTTP 请求所发送的所有标头; get_headers("https://www.baidu.com")', get_headers("https://www.baidu.com")));

    }


}
