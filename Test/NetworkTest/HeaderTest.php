<?php
/**
/**
 * 常用 200 302 403 404 500
 * 
 * public $HTTPCode = [
 *     100 => '100 Continue',              // 目前为止一切正常, 客户端应该继续请求
 *     101 => '101 Switching Protocol',    // （协议切换）状态码表示服务器应客户端升级协议的请求（Upgrade (en-US)请求头）正在切换协议。
 *     103 => '103 Early Hints',           // 信息状态响应码，一般和 Link header（首部）一起使用，来允许用户在服务器还在准备响应数据的时候预加载一些资源。
 *     200 => '200 OK',                    // 请求已经成功; TRACE: 响应的消息体中包含服务器接收到的请求信息。HEAD: 响应的消息体为头部信息。 PUT 和 DELETE 的请求成功通常并不是响应200 OK的状态码而是 204 No Content 表示无内容(或者  201  Created表示一个资源首次被创建成功)。
 *     201 => '201 Created',               //  请求已经成功处理，并且创建了新的资源;同时新增的资源会在应答消息体中返回，其地址或者是原始请求的路径，或者是 Location 首部的值。
 *     202 => '202 Accepted',              // 收到请求消息，但是尚未进行处理;这个状态码被设计用来将请求交由另外一个进程或者服务器来进行处理，或者是对请求进行批处理的情形。
 *     203 => '203 Non-Authoritative Information', //请求已经成功，但是获得的负载与源头服务器的状态码为 200 (OK)的响应相比，经过了拥有转换功能的 proxy （代理服务器）的修改。
 *     204 => '204 No Content',            // 请求已经成功; 在 PUT 请求中进行资源更新，但是不需要改变当前展示给用户的页面，那么返回 204 No Content。如果创建了资源，则返回 201 Created 。如果应将页面更改为新更新的页面，则应改用 200 。
 *     205 => '205 Reset Content',         // 用来通知客户端重置文档视图，比如清空表单内容、重置 canvas 状态或者刷新用户界面。
 *     206 => '206 Partial Content',       // 请求已成功; 主体包含所请求的数据区间，该数据区间是在请求的 Range 首部指定的。如果只包含一个数据区间，那么整个响应的 Content-Type 首部的值为所请求的文件的类型，同时包含  Content-Range 首部。如果包含多个数据区间，那么整个响应的  Content-Type  首部的值为 multipart/byteranges ，其中一个片段对应一个数据区间，并提供  Content-Range 和 Content-Type  描述信息。
 *     300 => '300 Multiple Choices',      // 重定向的响应状态码，表示该请求拥有多种可能的响应
 *     301 => '301 Moved Permanently',     // 永久重定向 说明请求的资源已经被移动到了由 Location 头部指定的url上，是固定的不会再改变。搜索引擎会根据该响应修正。
 *     302 => '302 Found',                 // 重定向状态码表明请求的资源被暂时的移动到了由该HTTP响应的响应头Location 指定的 URL 上
 *     303 => '303 See Other',             // 重定向状态码，通常作为 PUT 或 POST 操作的返回结果
 *     304 => '304 Not Modified',          // 未改变说明无需再次传输请求的内容，也就是说可以使用缓存的内容。这通常是在一些安全的方法（safe），例如GET 或HEAD 或在请求中附带了头部信息： If-None-Match 或If-Modified-Since
 *     307 => '307 Temporary Redirect',    // 同302；307 与 302 之间的唯一区别在于，当发送重定向请求的时候，307 状态码可以确保请求方法和消息主体不会发生变化。如果使用 302 响应状态码，一些旧客户端会错误地将请求方法转换为 GET：
 *     308 => '308 Permanent Redirect',    // 同301；301 状态码的情况下，请求方法有时候会被客户端错误地修改为 GET 方法。
 *     400 => '400 Bad Request',           // 由于语法无效，服务器无法理解该请求。
 *     401 => '401 Unauthorized',          // 客户端错误，指的是由于缺乏目标资源要求的身份验证凭证，发送的请求未得到满足。这个状态码会与  WWW-Authenticate 首部一起发送，其中包含有如何进行验证的信息。类似于 403， 但是在该情况下，依然可以进行身份验证
 *     402 => '402 Payment Required',      // 被保留
 *     403 => '403 Forbidden',             // 客户端错误，指的是服务器端有能力处理该请求，但是拒绝授权访问。（例如不正确的密码）
 *     404 => '404 Not Found',             // 客户端错误，指的是服务器端无法找到所请求的资源。404 状态码并不能说明请求的资源是临时还是永久丢失。如果服务器知道该资源是永久丢失，那么应该返回 410 (Gone) 而不是 404 。
 *     405 => '405 Method Not Allowed',    // 服务器禁止了使用当前 HTTP 方法的请求。
 *     406 => '406 Not Acceptable',        // 客户端错误，指代服务器端无法提供与  Accept-Charset 以及 Accept-Language 消息头指定的值相匹配的响应。
 *     407 => '407 Proxy Authentication Required', //客户端错误，指的是由于缺乏位于浏览器与可以访问所请求资源的服务器之间的代理服务器（proxy server ）要求的身份验证凭证，发送的请求尚未得到满足。这个状态码会与 Proxy-Authenticate 首部一起发送，其中包含有如何进行验证的信息
 *     408 => '408 Request Timeout',       // 服务器想要将没有在使用的连接关闭。一些服务器会在空闲连接上发送此信息，即便是在客户端没有发送任何请求的情况下。
 *     409 => '409 Conflict',              // 服务器端目标资源的当前状态相冲突;冲突最有可能发生在对 PUT 请求的响应中。例如，当上传文件的版本比服务器上已存在的要旧，从而导致版本冲突的时候，那么就有可能收到状态码为 409 的响应。
 *     410 => '410 Gone',                  // 丢失 说明请求的目标资源在原服务器上不存在了，并且是永久性的丢失。如果不清楚是否为永久或临时的丢失，应该使用404
 *     411 => '411 Length Required',       // 客户端错误，表示由于缺少确定的Content-Length 首部字段，服务器拒绝客户端的请求。当使用分块模式传输数据的时候， Content-Length 首部是不存在的，但是需要在每一个分块的开始添加该分块的长度，用十六进制数字表示。 Transfer-Encoding
 *     412 => '412 Precondition Failed',   // 客户端错误，意味着对于目标资源的访问请求被拒绝。这通常发生于采用除 GET 和 HEAD 之外的方法进行条件请求时，由首部字段 If-Unmodified-Since 或 If-None-Match 规定的先决条件不成立的情况下。
 *     413 => '413 Payload Too Large',     // 请求主体的大小超过了服务器愿意或有能力处理的限度，服务器可能会（may）关闭连接以防止客户端继续发送该请求。
 *     414 => '414 URI Too Long',          // URI 超过了服务器允许的范围
 *     415 => '415 Unsupported Media Type',// 服务器由于不支持其有效载荷的格式，从而拒绝接受客户端的请求。格式问题的出现有可能源于客户端在 Content-Type 或 Content-Encoding 首部中指定的格式，也可能源于直接对负载数据进行检测的结果。
 *     416 => '416 Range Not Satisfiable', // 服务器无法处理所请求的数据区间。最常见的情况是所请求的数据区间不在文件范围之内，也就是说，Range 首部的值，虽然从语法上来说是没问题的，但是从语义上来说却没有意义。
 *     417 => '417 Expectation Failed',    // 客户端错误，意味着服务器无法满足 Expect 请求消息头中的期望条件。
 *     418 => '418 Im a teapot',           // 客户端错误响应代码表示服务器拒绝冲泡咖啡，因为它是个茶壶。
 *     422 => '422 Unprocessable Entity',  // 服务器理解请求实体的内容类型，并且请求实体的语法是正确的，但是服务器无法处理所包含的指令。
 *     425 => '425 Too Early',             // 服务器不愿意冒风险来处理该请求，原因是处理该请求可能会被“重放”，从而造成潜在的重放攻击。
 *     426 => '426 Upgrade Required',      // 服务器拒绝处理客户端使用当前协议发送的请求，但是可以接受其使用升级后的协议发送的请求。
 *     428 => '428 Precondition Required', // 服务器端要求发送条件请求。一般的，这种情况意味着必要的条件首部——如 If-Match ——的缺失。当一个条件首部的值不能匹配服务器端的状态的时候，应答的状态码应该是 412 Precondition Failed，前置条件验证失败。
 *     429 => '429 Too Many Requests',     // 一定的时间内用户发送了太多的请求，即超出了“频次限制”。在响应中，可以提供一个  Retry-After 首部来提示用户需要等待多长时间之后再发送新的请求。
 *     431 => '431 Request Header Fields Too Large', // 请求中的首部字段的值过大，服务器拒绝接受客户端的请求。客户端可以在缩减首部字段的体积后再次发送请求。
 *     451 => '451 Unavailable For Legal Reasons', // 服务器由于法律原因，无法提供客户端请求的资源，例如可能会导致法律诉讼的页面。
 *     500 => '500 Internal Server Error', // 服务器端错误的响应状态码，意味着所请求的服务器遇到意外的情况并阻止其执行请求。这个错误代码是一个通用的“万能”响应代码。
 *     501 => '501 Not Implemented',       // 请求的方法不被服务器支持，因此无法被处理。服务器必须支持的方法（即不会返回这个状态码的方法）只有 GET 和 HEAD。501 响应默认是可缓存的。
 *     502 => '502 Bad Gateway',           // 网关或代理角色的服务器，从上游服务器（如tomcat、php-fpm）中接收到的响应是无效的。
 *     503 => '503 Service Unavailable',   // 服务器尚未处于可以接受请求的状态。通常造成这种情况的原因是由于服务器停机维护或者已超载。在可行的情况下，应该在 Retry-After 首部字段中包含服务恢复的预期时间。
 *     504 => '504 Gateway Timeout',       // 扮演网关或者代理的服务器无法在规定的时间内获得想要的响应。
 *     505 => '505 HTTP Version Not Supported', // 服务器不支持请求所使用的 HTTP 版本。
 *     506 => '506 Variant Also Negotiates', // 内部服务器配置错误，其中所选变量/变元自身被配置为参与内容协商，因此并不是合适的协商端点。
 *     507 => '507 Insufficient Storage',  // 服务器不能存储相关内容。准确地说，一个方法可能没有被执行，因为服务器不能存储其表达形式，这里的表达形式指：方法所附带的数据，而且其请求必需已经发送成功。
 *     508 => '508 Loop Detected',         // 服务器中断一个操作，因为它在处理具有“Depth: infinity”的请求时遇到了一个无限循环。508码表示整个操作失败。
 *     510 => '510 Not Extended',          // 一个客户端可以发送一个包含扩展声明的请求，该声明描述了要使用的扩展。如果服务器接收到这样的请求，但是请求不支持任何所描述的扩展，那么服务器将使用510状态码进行响应。
 *     511 => '511 Network Authentication Required' // 客户端需要通过验证才能使用该网络。该状态码不是由源头服务器生成的，而是由控制网络访问的拦截代理服务器生成的。
 * ];
 */
namespace HappyLin\OldPlugin\Test\NetworkTest;

use HappyLin\OldPlugin\SingleClass\{Url, Curl};

use HappyLin\OldPlugin\SingleClass\Network\{HeaderHelp, DownLoad\DownloadClass, NetworkFunction};

//use HappyLin\OldPlugin\SingleClass\FileSystem\FileProcess;
//
//use HappyLin\OldPlugin\SingleClass\SPL\FileHandling\Shortcut\FileObject;





use HappyLin\OldPlugin\Test\TraitTest;
//use HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits\System;


class HeaderTest
{

    use TraitTest;


    public $fileSaveDir;


    public function __construct()
    {
        $this->fileSaveDir = static::getTestDir() . '/Public/SingleClass';

    }


    /**
     * @note 为了方便查看意思；写的类HeaderHelp
     */
    public function headerHelpTest()
    {

        var_dump(static::toStr('header; 注册一个函数，在 PHP 开始发送输出时调用; header_register_callback(callable);  这个时候已经发送了，没办法执行; HappyLin\OldPlugin\SingleClass\Network\HeaderHelp就是这么干的'));
        var_dump(static::toStr('header; 发送原生 HTTP 头; header("X-Test: foo") '));  //  NetworkFunction::header("X-Test: foo");
        var_dump(static::toStr('header; 删除之前设置的 HTTP 头; header_remove("X-Test") '));  // NetworkFunction::header_remove("X-Test");
        var_dump(static::toStr('header; 获取/设置响应的 HTTP 状态码; http_response_code() ', NetworkFunction::http_response_code()));
        var_dump(static::toStr('header; 获取准备发送给浏览器/客户端的 HTTP 头列表', NetworkFunction::headers_list()));
        var_dump(static::toStr('header; 检测 HTTP 头是否已经发送', NetworkFunction::headers_sent()));
        echo "<hr><br>";


        // 获取 HeaderHelp 单例
        $headerHelp = HeaderHelp::getInstance();


        // 调用底层方法； 单独配置参数
        $headerHelp->_transformation('Keep-Alive', 'timeout=5, max=1000', true);
        // 单独配置参数
        $headerHelp->setKeepAlive('timeout=5, max=1000', true);

        $headerHelp->setHttpCode(200)->execute();

        // 调用 shortcut* 开头的常用配置函数
        $headerHelp->shortcutCommon();


        // 获取header配置的所有选项
        var_dump(static::toStr('获取header配置的所有选项', $headerHelp->getHeaderOptionRecords()));


        var_dump(static::toStr('30秒后跳转头条地址；  $headerHelp->shortcutRedirect(\'https://www.toutiao.com/\',30)'));
    }

    /**
     * @note 测试断点续传自定义类DownloadClass
     */
    public function headerDownloadTest()
    {
        // 调试保存参数
        //$fileName = $this->fileSaveDir . '/download.txt';
        //$file = FileObject::getInstance($fileName,'write');
        //$file->add(print_r($_SERVER, true) . PHP_EOL);

        // 下载 文件
        $downloadFile = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR.'/SingleClass/test.txt';
        $downloadFile = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR.'/SingleClass/video/move1.mp4';

        $downloadObject = new DownloadClass($downloadFile, 'test.txt');

        // 下传整个文件
        // $downloadObject->downloadFile();
        // 分段传输，支持断点续传
        $downloadObject->downloadLargeFile();

        // 下传字符串
        //\HappyLin\OldPlugin\SingleClass\Network\Download\DownloadClass::downloadString('3333333', 'test.txt');

    }






}
