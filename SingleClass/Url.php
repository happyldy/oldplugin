<?php
/**
 * 从$_SERVER获取请求地址参数
 * 
 * Array
 * (
 *     [PATH] => C:\Program Files (x86)\Common Files\Oracle\Java\javapath;C:\Windows\system32;C:\Windows;C:\Windows\System32\Wbem;C:\Windows\System32\WindowsPowerShell\v1.0\;C:\Windows\System32\OpenSSH\;C:\Program Files (x86)\NVIDIA Corporation\PhysX\Common;C:\Program Files\NVIDIA Corporation\NVIDIA NvDLISR;D:\Program_Files\nodejs\;D:\Program_Files\php\php729n;D:\Program_Files\mysql\mysql57\bin;D:\Program_Files\java\jdk-8;C:\Windows\system32\config\systemprofile\AppData\Local\Microsoft\WindowsApps
 *     [SYSTEMROOT] => C:\Windows
 *     [COMSPEC] => C:\Windows\system32\cmd.exe
 *     [PATHEXT] => .COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH;.MSC
 *     [WINDIR] => C:\Windows
 *     [PHPRC] => D:\Program_Files\php\php729n
 *     [PHP_FCGI_MAX_REQUESTS] => 1000
 *     [_FCGI_SHUTDOWN_EVENT_] => 1240
 *     [SCRIPT_NAME] => /composer/composer_test/vendor/happylin/oldplugin/index.php
 *     [REQUEST_URI] => /composer/composer_test/vendor/happylin/oldplugin/index.php
 *     [QUERY_STRING] => 
 *     [REQUEST_METHOD] => POST
 *     [SERVER_PROTOCOL] => HTTP/1.1
 *     [GATEWAY_INTERFACE] => CGI/1.1
 *     [REMOTE_PORT] => 59968
 *     [SCRIPT_FILENAME] => E:/HTML/composer/composer_test/vendor/happylin/oldplugin/index.php
 *     [SERVER_ADMIN] => admin@example.com
 *     [CONTEXT_DOCUMENT_ROOT] => E:/HTML
 *     [CONTEXT_PREFIX] => 
 *     [REQUEST_SCHEME] => http
 *     [DOCUMENT_ROOT] => E:/HTML
 *     [REMOTE_ADDR] => 127.0.0.1
 *     [SERVER_PORT] => 80
 *     [SERVER_ADDR] => 127.0.0.1
 *     [SERVER_NAME] => www.myhtml
 *     [SERVER_SOFTWARE] => Apache/2.4.46 (Win64) mod_fcgid/2.3.9
 *     [SERVER_SIGNATURE] => 
 *     [SystemRoot] => C:\Windows
 *     [HTTP_CACHE_CONTROL] => max-age=0
 *     [HTTP_REFERER] => http://127.0.0.1:8080/
 *     [HTTP_CONNECTION] => close
 *     [HTTP_ORIGIN] => http://127.0.0.1:8080
 *     [CONTENT_LENGTH] => 183
 *     [CONTENT_TYPE] => multipart/form-data; boundary=---------------------------368415129332319447884057066160
 *     [HTTP_X_REQUESTED_WITH] => XMLHttpRequest
 *     [HTTP_ACCEPT_ENCODING] => gzip, deflate
 *     [HTTP_ACCEPT_LANGUAGE] => zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2
 *     [HTTP_ACCEPT] => * / *
 *     [HTTP_USER_AGENT] => Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0
 *     [HTTP_HOST] => www.myhtml
 *     [FCGI_ROLE] => RESPONDER
 *     [PHP_SELF] => /composer/composer_test/vendor/happylin/oldplugin/index.php
 *     [REQUEST_TIME_FLOAT] => 1632124324.5736
 *     [REQUEST_TIME] => 1632124324
 * )
 * 
 */


namespace HappyLin\OldPlugin\SingleClass;


class Url
{

    /**
     * 返回域名根目录 'E:/HTML'
     * @return string
     */
    public static function dcoumentRoot(): string
    {
        return $_SERVER['CONTEXT_DOCUMENT_ROOT'];
    }
    
    /**
     * 入口文件index.php根目录 'E:/HTML/composer/composer_test/vendor/HappyLin/oldplugin'
     * @return string
     */
    public static function scriptRootDir(): string
    {
        return dirname($_SERVER['SCRIPT_FILENAME']);
    }


    /**
     * 请求方法 REQUEST_METHOD
     * @return string
     */
    public static function requestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    

    /**
     * 返回域名 www.myhtml
     * @return mixed
     */
    public static function getHost(): string
    {
        return $_SERVER['HTTP_HOST'];
    }



    /**
     * 入口文件index.php根目录相对路劲 '/composer/composer_test/vendor/HappyLin/oldplugin'
     * @return string
     */
    public static function scriptDir(): string
    {
        return dirname($_SERVER['SCRIPT_NAME']);
    }





    public static function getContentType(){

        if(empty($_SERVER['CONTENT_TYPE'])){
            return '';
        }
        return explode(',', $_SERVER['CONTENT_TYPE'])[0];

    }


    /**
     * 取得服务器响应一个 HTTP 请求所发送的所有标头
     *
     * @param string $url
     * @param int $format 如果将可选的 format 参数设为 1，则 get_headers() 会解析相应的信息并设定数组的键名。
     * @return array|false
     */
    public static function getHeaders(string $url, int $format)
    {
        return get_headers($url);
    }




//    /**
//     * 解析url中参数信息，返回参数数组
//     */
//    function convertUrlQuery($query)
//    {
//        $queryParts = explode('&', $query);
//        $params = array();
//        foreach ($queryParts as $param) {
//            $item = explode('=', $param);
//            $params[$item[0]] = $item[1];
//        }
//        return $params;
//    }





//    /**
//     * @return string
//     */
//    public static function currentDir(): string
//    {
//        return __DIR__;
//    }
//
//    /**
//     * @return string
//     */
//    public static function currentFile(): string
//    {
//        return __FILE__;
//    }


}












