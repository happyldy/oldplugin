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


namespace HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\Output\Contract;

use Generator;

interface Flush
{

    

    /**
     * 打开输出缓冲区
     *
     */
    public function start ();


    /**
     * 输出缓冲区并清空缓冲区
     * 例子：
     *         $info = new class implements Flush
     *         {
     *             public function start (){}
     *             public function loop ():Generator{
     *
     *                 $flag = true;
     *                 $limit = 5;
     *                 foreach(Tool::xrange(1,$limit) as $k=>$v){
     *                     echo "<div>$v</div>";
     *                     sleep(1);
     *                     if($k>=$limit){
     *                         $flag = 1;
     *                     }
     *                     yield false;
     *                 }
     *             }
     *             public function end (){}
     *         };
     *
     * @return bool 判断是否输出完成； true 以输出完成； false: 需要继续输出
     */
    public function loop ():Generator;



    /**
     * 关闭输出缓冲
     */
    public function end ();



}












