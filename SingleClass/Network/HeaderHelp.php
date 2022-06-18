<?php
/**
 * header函数帮助 参考文档 https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers
 *
 * 方法以
 * set*开头就是单独缓存header选项方法；返回$this
 * execute()方法执行全部header选项然后清空所有选项； 无返回
 *
 * shortcut*开头函数为，为立即执行header的快捷方法；返回不定【这个可以拉出去独立，以后说吧】
 * flexible*开头批量缓存header选项的快捷方法；返回$this
 */


namespace HappyLin\OldPlugin\SingleClass\Network;

use HappyLin\OldPlugin\SingleClass\Network\HeaderShortcut;

use http\Exception\InvalidArgumentException;

final class HeaderHelp
{
    
    use HeaderShortcut;

    /**
     * @var HeaderHelp 单例实例
     */
    private static $instance;

    /**
     * @var array 历史记录; execute() 过的
     */
    public $headerOptionsRecords = [];


    /**
     * @var array 实时记录; 未execute() 过的
     */
    public $headerOptions = [];


    /**
     * HTTP request methods 列表:
     * GET（获取数据）,
     * POST（新增数据）,
     * PUT（更新数据）,
     * DELETE（删除数据），
     * HEAD（同get但没有响应主体）,
     * CONNECT（连接改为管道方式的代理服务器），
     * OPTIONS（HEAD类似，请求服务器返回该资源所支持的所有HTTP请求方法），
     * TRACE（请求服务器回显其收到的请求信息，该方法主要用于HTTP请求的测试或诊断）；
     * PATCH（同PUT,但当资源不存在时，PATCH会创建一个新的资源，而PUT只会对已在资源进行更新。）
     * @var array
     */
    public $Methods = [
        'GET','POST','PUT','DELETE','HEAD','CONNECT','OPTIONS','TRACE','PATCH'
    ];

    /**
     * 实体头部用于指示资源的MIME类型
     * 文档地址：https://www.iana.org/assignments/media-types/media-types.xhtml#text
     * 指令： media-type 资源或数据的MIME type 。charset 字符编码标准。 boundary 对于多部分实体，boundary 是必需的，其包括来自一组字符的1到70个字符，已知通过电子邮件网关是非常健壮的，而不是以空白结尾。它用于封装消息的多个部分的边界。
     * Content-Type: text/html; charset=UTF-8
     * Content-Type: multipart/form-data; boundary=something
     * @var string[]
     */
    public $ContentType = [
        'html' => 'text/html;charset=utf-8', //charset=iso-8859-1
        'css' => 'text/css',
        'js' => 'text/javascript',
        'xml' => 'text/xml',
        'txt' => 'text/plain',

        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'webp' => 'image/webp',
        'avif' => 'image/avif',

        'mp4' => 'video/mpeg4',
        'mp3' => 'audio/mpeg',

        'json' => 'application/json',
        'pdf' => 'application/pdf',
        'zip' => 'application/zip',
        'atom' => 'application/atom+xml',
        'excel' => 'application/vnd.ms-excel',

        'form-data' => 'multipart/form-data',
        'x-www-form-urlencoded' => 'multipart/x-www-form-urlencoded',

        // 二进制所有类型
        'octet-stream' => 'application/octet-stream'
    ];


    /**
     * 可以处理的字符集类型
     * 诸如 utf-8 或 iso-8859-15的字符集。
     * 在这个消息头中未提及的任意其他字符集；'*' 用来表示通配符。
     * ;q= (q-factor weighting)  值代表优先顺序，用相对质量价值表示，又称为权重。
     * Accept-Charset: utf-8
     * Accept-Charset: utf-8, iso-8859-1;q=0.5
     * Accept-Charset: utf-8, iso-8859-1;q=0.5, *;q=0.1
     *
     * @var array
     */
    public $Charset = [
        'utf-8' => 'utf-8',
        'iso-8859-15' => 'iso-8859-15',
        '*' => 'utf-8, iso-8859-1;q=0.5, *;q=0.1'
    ];


    /**
     * 某种压缩算法
     * gzip,      表示采用 Lempel-Ziv coding (LZ77) 压缩算法，以及32位CRC校验的编码方式。
     * compress,  采用 Lempel-Ziv-Welch (LZW) 压缩算法。
     * deflate,   采用 zlib 结构和 deflate 压缩算法。
     * br,        表示采用 Brotli 算法的编码方式。
     * identity,  用于指代自身（例如：未经过压缩和修改）。除非特别指明，这个标记始终可以被接受
     * *,         匹配其他任意未在该请求头字段中列出的编码方式。假如该请求头字段不存在的话，这个值是默认值。它并不代表任意算法都支持，而仅仅表示算法之间无优先次序。
     * ;q= (qvalues weighting), // 值代表优先顺序，用相对质量价值 表示，又称为权重。
     *
     * Accept-Encoding: gzip
     * Accept-Encoding: gzip, compress, br
     * Accept-Encoding: br;q=1.0, gzip;q=0.8, *;q=0.1
     *
     * Content-Encoding: gzip
     *
     * @var array
     */
    public $Encoding = [
        'gzip' => 'gzip',
        'compress' => 'compress',
        'deflate' => 'deflate',
        'br' => 'br',
        'identity' => 'identity',
        '*' => '*',
    ];


    /**
     * 用含有两到三个字符的字符串表示的语言码或完整的语言标签。除了语言本身之外，还会包含其他方面的信息，显示在中划线（"-"）后面; 如"en-US" "de-DE"
     * *  任意语言；"*" 表示通配符（wildcard）。
     * ;q= (q-factor weighting)  此值代表优先顺序，用相对质量价值表示，又称为权重。
     *
     * Accept-Language: en-US,en;q=0.5;
     * Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2
     *
     * Content-Language: en-US
     *
     * <html lang="de">
     *
     * @var string[]
     */
    public $Language = [
        'en' => 'en-US',
        'zh' => 'zh-CN',
        'de' => 'de-DE',
        '*' => 'zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2'
    ];


    /**
     * 通用消息头字段，缓存指令是单向的，这意味着在请求中设置的指令，不一定被包含在响应中。 (Pragma 仅用于向后兼容 HTTP/1.0 客户端)
     * public                               表明响应可以被任何对象（包括：发送请求的客户端，代理服务器，等等）缓存，即使是通常不可缓存的内容。如果请求没有 Authorization 标头，或者您已经在响应中使用了 s-maxage 或 must-revalidate，那么您不需要使用 public。
     *                                        Cache-Control: public, max-age=604800
     * private                              表明响应只能被单个用户缓存，不能作为共享缓存（即代理服务器不能缓存它）。私有缓存可以缓存响应内容，比如：对应用户的本地浏览器。
     *                                        Cache-Control: private
     * no-cache                 both        并不意味着“不缓存”。 no-cache 允许缓存存储响应，但要求它们在重用之前重新验证它。
     *                                        Cache-Control: no-cache
     * no-store                 both        任何类型的缓存（私有或共享）不应存储此响应。
     *                                        Cache-Control: no-store
     * no-transform             both        任何中介（无论是否实现缓存）都不应转换响应内容。一些中介出于各种原因转换内容。 例如，一些转换图像以减少传输大小。 在某些情况下，这对于内容提供者来说是不可取的。no-transform指令不允许这样做。
     * max-age=<seconds>        both        缓存可以存储此响应，N 秒之前保持新鲜，并在响应新鲜时将其重用于后续请求。。与Expires相反，时间是相对于请求的时间。
     *                                        Cache-Control: max-age=3600
     * s-maxage=<seconds>                   覆盖max-age或者Expires头，但是仅适用于共享缓存(比如各个代理)，私有缓存会忽略它。
     *                                        Cache-Control: s-maxage=604800
     * must-revalidate                      一旦资源过期，在成功向原始服务器验证之前，缓存不能用该资源响应后续请求。通常，must-revalidate 与 max-age 一起使用。
     *                                        Cache-Control: max-age=604800, must-revalidate
     * must-understand                      表明只有当缓存理解基于状态代码的缓存要求时，它才应该存储响应。应该与 no-store 相结合，以实现后备行为。
     *                                        Cache-Control: must-understand, no-store
     * proxy-revalidate                     与 must-revalidate 等效，但仅适用于共享缓存，但它仅适用于共享缓存（例如代理），并被私有缓存忽略。
     * immutable                            告诉缓存响应在它新鲜时是不可变的; 静态资源的现代最佳实践是在其 URL 中包含版本/哈希值，同时从不修改资源——而是在必要时使用具有新版本号/哈希值的新版本更新资源，以便它们的 URL 不同 . 这就是所谓的缓存破坏模式。
     *                                        Cache-Control: public, max-age=604800, immutable
     * stale-while-revalidate               表明客户端愿意接受陈旧的响应，同时在后台异步检查新的响应。秒值指示客户愿意接受陈旧响应的时间长度。Cache-Control: max-age=604800, stale-while-revalidate=86400
     *                                        Cache-Control: max-age=604800, stale-while-revalidate=86400
     * stale-if-error=<seconds> both        响应指令指示当源服务器响应错误（500、502、503 或 504）时，缓存可以重用旧响应。秒数值表示客户在初始到期后愿意接受陈旧响应的时间。 Cache-Control: max-age=604800, stale-if-error=86400
     *
     *
     * only-if-cached           client      表明客户端只接受已缓存的响应，并且不要向原始服务器检查是否有更新的拷贝。
     * max-stale[=<seconds>]    client      表明客户端愿意接收一个已经过期的资源。可以设置一个可选的秒数，表示响应不能已经过时超过该给定的时间。
     * min-fresh=<seconds>      client      表示客户端希望获取一个能在指定的秒数内保持其最新状态的响应。
     *
     * php:  post-check=0, pre-check=0  禁用浏览器回退缓存
     *
     * Cache-Control: no-store, must-revalidate     //关闭缓存。此外，可以参考Expires和Pragma消息头。
     * Cache-Control:public, max-age=31536000   //缓存静态资源, 例如图像，CSS文件和JavaScript文件
     * Cache-Control: no-cache     //需要重新验证  Cache-Control: max-age=0, must-revalidate
     *
     * @var array
     */
    public $CacheControl = [
        'no-store' => 'no-store',
        'cache' => 'public, max-age=31536000',
        'no-cache' => 'no-cache, max-age=0, must-revalidate',
    ];


    /**
     * 常用 200 302 403 404 500
     *
     * @var array
     */
    public $HTTPCode = [
        100 => '100 Continue',              // 目前为止一切正常, 客户端应该继续请求
        101 => '101 Switching Protocol',    // （协议切换）状态码表示服务器应客户端升级协议的请求（Upgrade (en-US)请求头）正在切换协议。
        103 => '103 Early Hints',           // 信息状态响应码，一般和 Link header（首部）一起使用，来允许用户在服务器还在准备响应数据的时候预加载一些资源。
        200 => '200 OK',                    // 请求已经成功; TRACE: 响应的消息体中包含服务器接收到的请求信息。HEAD: 响应的消息体为头部信息。 PUT 和 DELETE 的请求成功通常并不是响应200 OK的状态码而是 204 No Content 表示无内容(或者  201  Created表示一个资源首次被创建成功)。
        201 => '201 Created',               //  请求已经成功处理，并且创建了新的资源;同时新增的资源会在应答消息体中返回，其地址或者是原始请求的路径，或者是 Location 首部的值。
        202 => '202 Accepted',              // 收到请求消息，但是尚未进行处理;这个状态码被设计用来将请求交由另外一个进程或者服务器来进行处理，或者是对请求进行批处理的情形。
        203 => '203 Non-Authoritative Information', //请求已经成功，但是获得的负载与源头服务器的状态码为 200 (OK)的响应相比，经过了拥有转换功能的 proxy （代理服务器）的修改。
        204 => '204 No Content',            // 请求已经成功; 在 PUT 请求中进行资源更新，但是不需要改变当前展示给用户的页面，那么返回 204 No Content。如果创建了资源，则返回 201 Created 。如果应将页面更改为新更新的页面，则应改用 200 。
        205 => '205 Reset Content',         // 用来通知客户端重置文档视图，比如清空表单内容、重置 canvas 状态或者刷新用户界面。
        206 => '206 Partial Content',       // 请求已成功; 主体包含所请求的数据区间，该数据区间是在请求的 Range 首部指定的。如果只包含一个数据区间，那么整个响应的 Content-Type 首部的值为所请求的文件的类型，同时包含  Content-Range 首部。如果包含多个数据区间，那么整个响应的  Content-Type  首部的值为 multipart/byteranges ，其中一个片段对应一个数据区间，并提供  Content-Range 和 Content-Type  描述信息。
        300 => '300 Multiple Choices',      // 重定向的响应状态码，表示该请求拥有多种可能的响应
        301 => '301 Moved Permanently',     // 永久重定向 说明请求的资源已经被移动到了由 Location 头部指定的url上，是固定的不会再改变。搜索引擎会根据该响应修正。
        302 => '302 Found',                 // 重定向状态码表明请求的资源被暂时的移动到了由该HTTP响应的响应头Location 指定的 URL 上
        303 => '303 See Other',             // 重定向状态码，通常作为 PUT 或 POST 操作的返回结果
        304 => '304 Not Modified',          // 未改变说明无需再次传输请求的内容，也就是说可以使用缓存的内容。这通常是在一些安全的方法（safe），例如GET 或HEAD 或在请求中附带了头部信息： If-None-Match 或If-Modified-Since
        307 => '307 Temporary Redirect',    // 同302；307 与 302 之间的唯一区别在于，当发送重定向请求的时候，307 状态码可以确保请求方法和消息主体不会发生变化。如果使用 302 响应状态码，一些旧客户端会错误地将请求方法转换为 GET：
        308 => '308 Permanent Redirect',    // 同301；301 状态码的情况下，请求方法有时候会被客户端错误地修改为 GET 方法。
        400 => '400 Bad Request',           // 由于语法无效，服务器无法理解该请求。
        401 => '401 Unauthorized',          // 客户端错误，指的是由于缺乏目标资源要求的身份验证凭证，发送的请求未得到满足。这个状态码会与  WWW-Authenticate 首部一起发送，其中包含有如何进行验证的信息。类似于 403， 但是在该情况下，依然可以进行身份验证
        402 => '402 Payment Required',      // 被保留
        403 => '403 Forbidden',             // 客户端错误，指的是服务器端有能力处理该请求，但是拒绝授权访问。（例如不正确的密码）
        404 => '404 Not Found',             // 客户端错误，指的是服务器端无法找到所请求的资源。404 状态码并不能说明请求的资源是临时还是永久丢失。如果服务器知道该资源是永久丢失，那么应该返回 410 (Gone) 而不是 404 。
        405 => '405 Method Not Allowed',    // 服务器禁止了使用当前 HTTP 方法的请求。
        406 => '406 Not Acceptable',        // 客户端错误，指代服务器端无法提供与  Accept-Charset 以及 Accept-Language 消息头指定的值相匹配的响应。
        407 => '407 Proxy Authentication Required', //客户端错误，指的是由于缺乏位于浏览器与可以访问所请求资源的服务器之间的代理服务器（proxy server ）要求的身份验证凭证，发送的请求尚未得到满足。这个状态码会与 Proxy-Authenticate 首部一起发送，其中包含有如何进行验证的信息
        408 => '408 Request Timeout',       // 服务器想要将没有在使用的连接关闭。一些服务器会在空闲连接上发送此信息，即便是在客户端没有发送任何请求的情况下。
        409 => '409 Conflict',              // 服务器端目标资源的当前状态相冲突;冲突最有可能发生在对 PUT 请求的响应中。例如，当上传文件的版本比服务器上已存在的要旧，从而导致版本冲突的时候，那么就有可能收到状态码为 409 的响应。
        410 => '410 Gone',                  // 丢失 说明请求的目标资源在原服务器上不存在了，并且是永久性的丢失。如果不清楚是否为永久或临时的丢失，应该使用404
        411 => '411 Length Required',       // 客户端错误，表示由于缺少确定的Content-Length 首部字段，服务器拒绝客户端的请求。当使用分块模式传输数据的时候， Content-Length 首部是不存在的，但是需要在每一个分块的开始添加该分块的长度，用十六进制数字表示。 Transfer-Encoding
        412 => '412 Precondition Failed',   // 客户端错误，意味着对于目标资源的访问请求被拒绝。这通常发生于采用除 GET 和 HEAD 之外的方法进行条件请求时，由首部字段 If-Unmodified-Since 或 If-None-Match 规定的先决条件不成立的情况下。
        413 => '413 Payload Too Large',     // 请求主体的大小超过了服务器愿意或有能力处理的限度，服务器可能会（may）关闭连接以防止客户端继续发送该请求。
        414 => '414 URI Too Long',          // URI 超过了服务器允许的范围
        415 => '415 Unsupported Media Type',// 服务器由于不支持其有效载荷的格式，从而拒绝接受客户端的请求。格式问题的出现有可能源于客户端在 Content-Type 或 Content-Encoding 首部中指定的格式，也可能源于直接对负载数据进行检测的结果。
        416 => '416 Range Not Satisfiable', // 服务器无法处理所请求的数据区间。最常见的情况是所请求的数据区间不在文件范围之内，也就是说，Range 首部的值，虽然从语法上来说是没问题的，但是从语义上来说却没有意义。
        417 => '417 Expectation Failed',    // 客户端错误，意味着服务器无法满足 Expect 请求消息头中的期望条件。
        418 => '418 Im a teapot',           // 客户端错误响应代码表示服务器拒绝冲泡咖啡，因为它是个茶壶。
        422 => '422 Unprocessable Entity',  // 服务器理解请求实体的内容类型，并且请求实体的语法是正确的，但是服务器无法处理所包含的指令。
        425 => '425 Too Early',             // 服务器不愿意冒风险来处理该请求，原因是处理该请求可能会被“重放”，从而造成潜在的重放攻击。
        426 => '426 Upgrade Required',      // 服务器拒绝处理客户端使用当前协议发送的请求，但是可以接受其使用升级后的协议发送的请求。
        428 => '428 Precondition Required', // 服务器端要求发送条件请求。一般的，这种情况意味着必要的条件首部——如 If-Match ——的缺失。当一个条件首部的值不能匹配服务器端的状态的时候，应答的状态码应该是 412 Precondition Failed，前置条件验证失败。
        429 => '429 Too Many Requests',     // 一定的时间内用户发送了太多的请求，即超出了“频次限制”。在响应中，可以提供一个  Retry-After 首部来提示用户需要等待多长时间之后再发送新的请求。
        431 => '431 Request Header Fields Too Large', // 请求中的首部字段的值过大，服务器拒绝接受客户端的请求。客户端可以在缩减首部字段的体积后再次发送请求。
        451 => '451 Unavailable For Legal Reasons', // 服务器由于法律原因，无法提供客户端请求的资源，例如可能会导致法律诉讼的页面。
        500 => '500 Internal Server Error', // 服务器端错误的响应状态码，意味着所请求的服务器遇到意外的情况并阻止其执行请求。这个错误代码是一个通用的“万能”响应代码。
        501 => '501 Not Implemented',       // 请求的方法不被服务器支持，因此无法被处理。服务器必须支持的方法（即不会返回这个状态码的方法）只有 GET 和 HEAD。501 响应默认是可缓存的。
        502 => '502 Bad Gateway',           // 网关或代理角色的服务器，从上游服务器（如tomcat、php-fpm）中接收到的响应是无效的。
        503 => '503 Service Unavailable',   // 服务器尚未处于可以接受请求的状态。通常造成这种情况的原因是由于服务器停机维护或者已超载。在可行的情况下，应该在 Retry-After 首部字段中包含服务恢复的预期时间。
        504 => '504 Gateway Timeout',       // 扮演网关或者代理的服务器无法在规定的时间内获得想要的响应。
        505 => '505 HTTP Version Not Supported', // 服务器不支持请求所使用的 HTTP 版本。
        506 => '506 Variant Also Negotiates', // 内部服务器配置错误，其中所选变量/变元自身被配置为参与内容协商，因此并不是合适的协商端点。
        507 => '507 Insufficient Storage',  // 服务器不能存储相关内容。准确地说，一个方法可能没有被执行，因为服务器不能存储其表达形式，这里的表达形式指：方法所附带的数据，而且其请求必需已经发送成功。
        508 => '508 Loop Detected',         // 服务器中断一个操作，因为它在处理具有“Depth: infinity”的请求时遇到了一个无限循环。508码表示整个操作失败。
        510 => '510 Not Extended',          // 一个客户端可以发送一个包含扩展声明的请求，该声明描述了要使用的扩展。如果服务器接收到这样的请求，但是请求不支持任何所描述的扩展，那么服务器将使用510状态码进行响应。
        511 => '511 Network Authentication Required' // 客户端需要通过验证才能使用该网络。该状态码不是由源头服务器生成的，而是由控制网络访问的拦截代理服务器生成的。
    ];



    /**
     * 不允许从外部调用以防止创建多个实例
     * 要使用单例，必须通过 HeaderHelp::getInstance() 方法获取实例
     */
    private function __construct()
    {
        header_register_callback([$this, 'execute']);
    }

    /**
     * 防止实例被克隆（这会创建实例的副本）
     */
    private function __clone()
    {
    }

    /**
     * 防止反序列化（这将创建它的副本）
     */
    private function __wakeup()
    {
    }


    /**
     * 通过懒加载获得实例（在第一次使用的时候创建）
     */
    public static function getInstance(): HeaderHelp
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }



    /**
     * 获取header配置选项 历史和实时记录；
     */
    public function getHeaderOptionRecords():array
    {
        return $this->headerOptionsRecords;
    }


    /**
     * 获取header配置选项；实时记录；未execute()；
     */
    public function getHeaderOption():array
    {
        return $this->headerOptions;
    }


    /**
     * 执行header配置选项
     */
    public function execute():void
    {
        if (headers_sent()) {
           return;
        }

        if(isset($this->headerOptions['HTTP/1.1'])){
            header("HTTP/1.1  {$this->headerOptions['HTTP/1.1']}");
            unset($this->headerOptions['HTTP/1.1']);
        }

        foreach($this->headerOptions as $key=>$v){
            header("{$key}: $v");
        }

        $this->headerOptionsRecords = array_merge($this->headerOptionsRecords, $this->headerOptions);

        $this->headerOptions = [];
    }


    /**
     * 可以配置多个值的选项的判断是否存在，用逗号分割，并储存
     * @param string $option  header的选项option; header("option: optionVal")
     * @param string $optionVal header的选项值optionVal; header("option: optionVal")
     * @param bool $reset 覆盖先前的选项值 true覆盖，false拼接
     * @return bool
     */
    public function _transformation(string $option, string $optionVal, bool $reset, $separator = ','):bool
    {
        if (headers_sent()) {
            return false;
        }

        if(empty($optionVal)) return false;

//        $optionValArr = array_map(function($v) {return trim($v);},explode(',',$optionVal));
//        $optionValArr = array_filter($optionValArr);

        $optionValArr = [];
        // 分割字符并去除空格
        foreach(explode($separator,$optionVal) as $v){
            $v = trim($v);
            if(!$v) continue;
            $optionArr[] = $v;
        }

        if(count($optionArr)<=0) return false;
        if(empty($this->headerOptions[$option]) || $reset){
            $this->headerOptions[$option] = implode($separator, $optionArr);
        }else{
            $headerOptionsArr = explode($separator, $this->headerOptions[$option]);
            // 判断选项是否存在，添加选项
            foreach($optionArr as $val){
                if(in_array($val,$headerOptionsArr)){
                    continue;
                }
                $headerOptionsArr[] = $val;
            }
            $this->headerOptions[$option] = implode($separator, $headerOptionsArr);
        }
        return true;
    }


    /**
     * 设置http状态码; 或 使用内部函数 http_response_code($code);
     * $this->HTTPCode
     * @param int $code
     */
    public function setHttpCode(int $code):HeaderHelp
    {
        if(!$this->HTTPCode[$code]){
            throw new InvalidArgumentException("{$code} undefined HTTP CODE");
        }
        http_response_code($code);
        $this->_transformation('HTTP/1.1', $this->HTTPCode[$code], true);
        return $this;
    }


    /**
     * 请求头用来告知（服务器）客户端可以处理的内容类型
     * Accept: <MIME_type>/<MIME_subtype>   text/html
     * Accept: <MIME_type>/*   image/*
     * Accept: * / *
     * // Multiple types,
     * Accept: text/html, application/xhtml+xml, application/xml;q=0.9, image/webp, * / *;q=0.8
     *
     * @param string $type 可选$this->ContentType选项('html' / 'css' / 'js')，或自定义
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setAccept(string $type = '', bool $reset = false):HeaderHelp
    {
        $this->_transformation('Accept', $type, $reset);
        return $this;
    }


    /**
     * 请求头用来告知（服务器）客户端可以处理的字符集类型
     * Accept-Charset: <charset>
     * Accept-Charset: utf-8, iso-8859-1;q=0.5, *;q=0.1
     *
     * @param string $type 可选$this->Charset选项('utf-8' / 'iso-8859-15' / '*')，或自定义
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setAcceptCharset(string $type='', bool $reset = false):HeaderHelp
    {
        $this->_transformation('Accept-Charset', $type, $reset);
        return $this;
    }


    /**
     * 会将客户端能够理解的内容编码方式——通常是某种压缩算法——进行通知（给服务端）。
     * Accept-Encoding: *
     * Accept-Encoding: deflate, gzip;q=1.0, *;q=0.5
     *
     * @param string $type 可选$this->Charset选项('gzip' / 'deflate' / 'br' ··· )，或自定义， 默认 *
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setAcceptEncoding(string $type = '', bool $reset = false):HeaderHelp
    {
        $this->_transformation('Accept-Encoding', $type, $reset);
        return $this;
    }


    /**
     * 客户端声明它可以理解的自然语言，以及优先选择的区域方言。
     * Accept-Language: *
     * Accept-Language: fr-CH, fr;q=0.9, en;q=0.8, de;q=0.7, *;q=0.5
     *
     * @param string $type 可选$this->Language('en' / 'zh' / 'de' ··· )，或自定义， 默认 *
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setAcceptLanguage(string $type = '', bool $reset = false):HeaderHelp
    {
        $this->_transformation('Accept-Language', $type, $reset);
        return $this;
    }


    /**
     * 通知浏览器请求的媒体类型(media-type)可以被服务器理解。
     *
     * Accept-Patch: application/example, text/example
     * Accept-Patch: text/example;charset=utf-8
     * Accept-Patch: application/merge-patch+json
     *
     * @param string $type 可选$this->ContentType('html' / 'js' / 'css' ··· )，或自定义， 默认 html
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setAcceptPatch(string $type = '', bool $reset = false):HeaderHelp
    {
        $this->_transformation('Accept-Patch', $type, $reset);
        return $this;
    }

    /**
     * 设置服务器接受HTTP Post请求的媒体类型。 它没有首选项的概念（即“Accept params”或“q”参数不重要）。
     * Accept-Post: application/example, text/example
     * Accept-Post: image/webp
     * Accept-Post: * / *
     *
     * @param string $type 可选$this->ContentType('html' / 'js' / 'css' ··· )，或自定义， 默认 html
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return $this
     */
    public function setAcceptPost(string $type='', bool $reset = false):HeaderHelp
    {
        $this->_transformation('Accept-Post', $type, $reset);
        return $this;
    }


    /**
     * 标识自身支持范围请求(partial requests)。字段的具体值用于定义范围请求的单位。当浏览器发现 Accept-Ranges 头时，可以尝试继续中断了的下载，而不是重新开始。
     * Accept-Ranges: bytes
     * Accept-Ranges: none
     *
     * @param string $type 只能是 none 或 bytes
     * @return $this
     */
    public function setAcceptRanges(string $type='bytes'):HeaderHelp
    {
        $this->_transformation('Accept-Ranges', $type, true);
        return $this;
    }


    /**
     * 当前端请求包含credentials时是否回复;（credentials可以时cookies或 authorization headers 或 TLS client certificates.）若一个对资源的请求带了credentials，如果这个响应头没有随资源返回，响应就会被浏览器忽视，不会返回到web内容。
     * @param bool $bool
     * @return HeaderHelp $this
     */
    public function setAccessControlAllowCredentials(bool $bool):HeaderHelp
    {
        $this->_transformation('Access-Control-Allow-Credentials', $type, true);
        return $this;
    }


    /**
     * 用于 preflight request （预检请求）中，列出了将会在正式请求的 Access-Control-Request-Headers 字段中出现的首部信息
     * 简单首部，如 simple headers、Accept、Accept-Language、Content-Language、Content-Type （只限于解析后的值为 application/x-www-form-urlencoded、multipart/form-data 或 text/plain 三种MIME类型（不包括参数）），它们始终是被支持的，不需要在这个首部特意列出。
     * Access-Control-Allow-Headers: <header-name>[, <header-name>]*    : Access-Control-Allow-Headers: X-Custom-Header, Upgrade-Insecure-Requests
     * 
     * @param string $type 例如：X-Custom-Header, Upgrade-Insecure-Requests  默认 Content-Type,X-Requested-With
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setAccessControlAllowHeaders(string $type, bool $reset = false):HeaderHelp
    {
        $this->_transformation('Access-Control-Allow-Headers', $type, $reset);
        return $this;
    }

    /**
     * 用逗号隔开的允许使用的 HTTP request methods 列表:
     * 选项查看$this->Methods
     * Access-Control-Allow-Methods: <method>, <method>, ...
     * Access-Control-Allow-Methods: POST, GET, OPTIONS
     *
     * @param string $method 必须是$this->Methods数组中数据
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setAccessControlAllowMethods(string $method, bool $reset = false):HeaderHelp
    {
        $method = str_replace(' ','',strtoupper($method));
        $method = array_intersect($this->Methods, explode(',' ,$method ));

        if(count($method)>0) $this->_transformation('Access-Control-Allow-Methods', implode(', ',$method), $reset);

        return $this;
    }


    /**
     * 响应头指定了该响应的资源是否被允许与给定的origin共享
     * 如果服务器未使用“*”，而是指定了一个域，那么为了向客户端表明服务器的返回会根据Origin请求头而有所不同，必须在Vary响应头中包含Origin。
     *
     * Access-Control-Allow-Origin: *
     * Access-Control-Allow-Origin: <origin>  : Access-Control-Allow-Origin: https://developer.mozilla.org
     * @param string $origin 给定的origin; https://developer.mozilla.org
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setAccessControlAllowOrigin(string $origin='*', bool $reset = false):HeaderHelp
    {
        $this->_transformation('Access-Control-Allow-Origin', $origin, $reset);
        return $this;
    }



    /**
     * 列出了哪些首部可以作为响应的一部分暴露给外部
     * Access-Control-Expose-Headers: <header-name>, <header-name>, ... :   Access-Control-Expose-Headers: Content-Length, X-Kuma-Revision
     *
     * @param string $header  例如：Content-Length,X-Requested-With
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setAccessControlExposeHeaders(string $header, bool $reset = false):HeaderHelp
    {
        $this->_transformation('Access-Control-Expose-Headers', $header, $reset);
        return $this;
    }


    /**
     * 返回结果可以被缓存的最长时间（秒）。
     * 在 Firefox 中，上限是24小时 （即 86400 秒）。
     * 在 Chromium v76 之前， 上限是 10 分钟（即 600 秒)。
     * 从 Chromium v76 开始，上限是 2 小时（即 7200 秒)。
     * Chromium 同时规定了一个默认值 5 秒。
     * 如果值为 -1，表示禁用缓存，则每次请求前都需要使用 OPTIONS 预检请求。
     *
     * @param int $maxAge 时间 秒 86400、7200、600
     * @return HeaderHelp $this
     */
    public function setAccessControlMaxAge($maxAge=86400):HeaderHelp
    {
        $this->_transformation('Access-Control-Max-Age', $maxAge, true);
        return $this;
    }


    /**
     * 出现于 preflight request （预检请求）中，用于通知服务器在真正的请求中会采用哪些请求头。
     * Access-Control-Request-Headers: <header-name>, <header-name>, ...
     * Access-Control-Request-Headers: X-PINGOTHER, Content-Type
     *
     * @param string $header 自定义选项； 例如：Content-Length, X-Kuma-Revision
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setAccessControlRequestHeaders($header, bool $reset = false):HeaderHelp
    {
        $this->_transformation('Access-Control-Request-Headers', $header, $reset);
        return $this;
    }

    /**
     * 出现于 preflight request （预检请求）中，用于通知服务器在真正的请求中会采用哪种  HTTP 方法。因为预检请求所使用的方法总是 OPTIONS ，与实际请求所使用的方法不一样，所以这个请求头是必要的。
     * Access-Control-Request-Method: <method>
     *
     * @param string $method 必须是$this->Methods数组中数据
     * @return HeaderHelp $this
     */
    public function setAccessControlRequestMethod(string $method):HeaderHelp
    {
        $this->_transformation('Access-Control-Request-Method', strtoupper(trim($method)), true);
        return $this;
    }


    /**
     * 消息头里包含对象在缓存代理中存贮的时长，以秒为单位。
     * Age: <delta-seconds>
     * <delta-seconds>
     *     一个非负整数，表示对象在缓存代理服务器中存贮的时长，以秒为单位。
     * Age: 24
     *
     * @param string $method 必须是$this->Methods数组中数据
     * @return HeaderHelp $this
     */
    public function setAge(int $second):HeaderHelp
    {
        $this->_transformation('Age', $second, true);
        return $this;
    }


    /**
     * 用于枚举资源所支持的 HTTP 方法的集合。
     * 若服务器返回状态码 405 Method Not Allowed，则该首部字段亦需要同时返回给客户端。如果 Allow  首部字段的值为空，说明资源不接受使用任何 HTTP 方法的请求。这是可能的，比如服务器需要临时禁止对资源的任何访问。
     * 选项查看$this->Methods
     * Allow: <http-methods>
     * Allow: GET, POST, HEAD
     *
     * @param string $method 必须是$this->Methods数组中数据
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setAllow(string $method, bool $reset = false):HeaderHelp
    {
        $method = str_replace(' ','',strtoupper($method));
        $method = array_intersect($this->Methods, explode(',' ,$method ));

        if(count($method)>0) $this->_transformation('Allow', implode(', ',$method), $reset);

        return $this;
    }




    /**
     * Alt-Svc 全称为“Alternative-Service”，直译为“备选服务”。该头部列举了当前站点备选的访问方式列表。一般用于在提供 “QUIC” 等新兴协议支持的同时，实现向下兼容。
     * Alt-Svc: clear
     * Alt-Svc: <service-list>; ma=<max-age>; persist=1
     *
     * <service-list>
     *     使用分号隔离的访问方式列表，格式形如：<service-name>="<host-name>:<port-number>"。这里的<service-name>应当是一个有效的 ALPN 标识符。
     * <max-age>可选
     *     当前访问方式的有效期，超过该时间后，服务端将不保证该访问方式依旧可用，客户端应当重新获取更新后的 Alt-Svc 列表。单位为秒，默认值为 24 小时（86400)。
     * persist可选
     *     可选参数，用于标识当前访问方式在网络环境改变时或者会话间始终保持。
     *
     * @param string $method 必须是$this->Methods数组中数据
     * @return HeaderHelp $this
     */
    public function setAltSvc(int $second):HeaderHelp
    {
        $this->_transformation('Alt-Svc', $second, true);
        return $this;
    }



    /**
     * HTTP协议中的 Authorization 请求消息头含有服务器用于验证用户代理身份的凭证，通常会在服务器返回401 Unauthorized 状态码以及WWW-Authenticate 消息头之后在后续请求中发送此消息头。
     * Authorization: <type> <credentials>
     *
     * <type>
     *     验证类型。 常见的是 "基本验证（Basic）" 。其他类型包括：
     *         在IANA机构注册的验证方案
     *         AWS服务器的验证方案 (AWS4-HMAC-SHA256)
     *
     * <credentials>
     *     如果使用“基本验证”方案，凭证通过如下步骤生成：
     *         用冒号将用户名和密码进行拼接（如：aladdin:opensesame）。
     *         将第一步生成的结果用 base64 方式编码(YWxhZGRpbjpvcGVuc2VzYW1l)。
     *     注意: Base64编码并不是一种加密方法或者hashing方法！这种方法的安全性与明文发送等同（base64可以逆向解码）。“基本验证”方案需要与HTTPS协议配合使用。
     *
     * @param string $method 示例： Authorization: Basic YWxhZGRpbjpvcGVuc2VzYW1l
     * @return HeaderHelp $this
     */
    public function setAuthorization(int $cred):HeaderHelp
    {
        $this->_transformation('Authorization', $cred, true);
        return $this;
    }



    /**
     * 现缓存机制
     *
     * 客户端可以在HTTP请求中使用的标准 Cache-Control 指令。
     * Cache-Control: max-age=<seconds>
     * Cache-Control: max-stale[=<seconds>]
     * Cache-Control: min-fresh=<seconds>
     * Cache-control: no-cache
     * Cache-control: no-store
     * Cache-control: no-transform
     * Cache-control: only-if-cached
     *
     *
     * 服务器可以在响应中使用的标准 Cache-Control 指令。
     * Cache-control: must-revalidate
     * Cache-control: no-cache
     * Cache-control: no-store
     * Cache-control: no-transform
     * Cache-control: public
     * Cache-control: private
     * Cache-control: proxy-revalidate
     * Cache-Control: max-age=<seconds>
     * Cache-control: s-maxage=<seconds>
     *
     * @param string $type 可选$this->CacheControl选项('no-store' / 'cache' / 'no-cache')，或自定义
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setCacheControl(string $type='', bool $reset = false):HeaderHelp
    {
        $this->_transformation('Cache-Control', isset($this->CacheControl[$type])?$this->CacheControl[$type]:$type, $reset);
        return $this;
    }


    /**
     * 表示清除当前请求网站有关的浏览器数据（cookie，存储，缓存）。它让Web开发人员对浏览器本地存储的数据有更多控制能力。
     * Clear-Site-Data  可以接受一个或多个参数，如果想要清除所有类型的数据，可以使用通配符("*")
     *
     * // 单个参数
     * Clear-Site-Data: "cache"
     * // 多个参数 (用逗号分隔)
     * Clear-Site-Data: "cache", "cookies"
     * // 通配
     * Clear-Site-Data: "*"
     *
     * 指令
     * "cache"
     *     表示服务端希望删除本URL原始响应的本地缓存数据（即 ：浏览器缓存，请参阅HTTP缓存）。根据浏览器的不同，可能还会清除预渲染页面，脚本缓存，WebGL着色器缓存或地址栏建议等内容。
     * "cookies"
     *     表示服务端希望删除URL响应的所有cookie。 HTTP身份验证凭据也会被清除。会影响整个主域，包括子域。所以https://example.com以及https://stage.example.com的Cookie都会被清除。
     * "storage"
     *     表示服务端希望删除URL原响应的所有DOM存储。这包括存储机制，如
     *         localStorage (执行 localStorage.clear),
     *         sessionStorage (执行 sessionStorage.clear),
     *         IndexedDB (对每个库执行  IDBFactory.deleteDatabase (en-US)),
     *         服务注册线程 (对每个服务之注册线程执行 ServiceWorkerRegistration.unregister),
     *         AppCache,
     *         WebSQL 数据库,
     *         FileSystem API data,
     *         Plugin data (Flash via NPP_ClearSiteData).
     *
     * "executionContexts"
     *     表示服务端希望浏览器重新加载本请求(Location.reload).
     * "*" (通配符)
     *     表示服务端希望清除原请求响应的所有类型的数据。如果在此头的未来版本中添加了更多数据类型，它们也将被涉及。
     *
     *
     * @param string $type "cache", "cookies", "storage", "executionContexts"
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setClearSiteData(string $type='', bool $reset = false):HeaderHelp
    {
        $this->_transformation('Clear-Site-Data', $type, $reset);
        return $this;
    }





    /**
     * 决定当前的事务完成后，是否会关闭网络连接。如果该值是“keep-alive”，网络连接就是持久的，不会关闭，使得对同一个服务器的请求可以继续在该连接上完成。
     * 特定于连接的标头字段（例如Connection）不得与HTTP / 2一起使用。
     * Connection: keep-alive  表明客户端想要保持该网络连接打开，HTTP/1.1的请求默认使用一个持久连接
     * Connection: close       表明客户端或服务器想要关闭该网络连接，这是HTTP/1.0请求的默认值
     *
     * @param string $status keep-alive close 二选一
     * @return HeaderHelp $this
     */
    public function setConnection(string $status=''):HeaderHelp
    {
        $this->_transformation('Connection', ($status==='close')?'close':'keep-alive', true);
        return $this;
    }

    /**
     * 响应头指示回复的内容该以何种形式展示，是以内联的形式（即网页或者页面的一部分），还是以附件的形式下载并保存到本地。
     * Content-Disposition 作为消息主体中的消息头
     * Content-Disposition: inline;  默认值，表示回复中的消息体会以页面的一部分或者整个页面的形式展示
     * Content-Disposition: attachment; filename="filename.jpg"; 意味着消息体应该被下载到本地；大多数浏览器会呈现一个“保存为”的对话框
     *
     * Content-Disposition 作为multipart body中的消息头
     * Content-Disposition: form-data; name="fieldName"; filename="filename.jpg"
     *
     * 指令:
     * name 后面是一个表单字段名的字符串，每一个字段名会对应一个子部分。在同一个字段名对应多个文件的情况下（例如，带有 multiple 属性的 < input type=file > 元素），则多个子部分共用同一个字段名。如果 name 参数的值为 '_charset_' ，意味着这个子部分表示的不是一个 HTML 字段，而是在未明确指定字符集信息的情况下各部分使用的默认字符集。
     * filename     后面是要传送的文件的初始名称的字符串。这个参数总是可选的，而且不能盲目使用：路径信息必须舍掉，同时要进行一定的转换以符合服务器文件系统规则。
     * filename*    "filename" 和 "filename*" 两个参数的唯一区别在于，"filename*" 采用了  RFC 5987 中规定的编码方式。当 "filename" 和 "filename*" 同时出现的时候，应该优先采用 "filename*"，
     * 
     * @param string $type attachment; filename="filename.jpg" | form-data; name="fieldName"; filename="filename.jpg"
     * @return HeaderHelp $this
     */
    public function setContentDisposition(string $type=''):HeaderHelp
    {
        $this->_transformation('Content-Disposition', $type, true);
        return $this;
    }



    /**
     * 设置告知客户端应该怎样解码才能获取在 Content-Type 中标示的媒体类型内容
     * Content-Encoding: gzip
     * Content-Encoding: deflate
     *
     * @param string $type 可选$this->Encoding选项('gzip' / 'deflate' / 'br' ··· )，
     * @return HeaderHelp $this
     */
    public function setContentEncoding(string $type = ''):HeaderHelp
    {
        if(in_array(strtolower($type),$this->Encoding) && $type !='*'){
            $this->_transformation('Content-Encoding', strtolower($type), true);
        }
        return $this;
    }

    /**
     * 设置说明访问者希望采用的语言或语言组合
     * Content-Language: en-US
     * Content-Language: de-DE, en-CA
     *
     * @param string $type 可选$this->Language('en' / 'zh' / 'de' ··· )，或自定义, 默认 *
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setContentLanguage(string $type = '', bool $reset = false):HeaderHelp
    {
        $this->_transformation('Content-Language', isset($this->Language[$type])?$this->Language[$type]:$type, $reset);
        return $this;
    }


    /**
     * 设置用来指明发送给接收方的消息主体的大小，即用十进制数字表示的八位元组的数目。
     * Content-Length: <length>
     *
     * @param string $size 十进制数字表示的八位元组的数目
     * @return HeaderHelp $this
     */
    public function setContentLength(int $size):HeaderHelp
    {
        $this->_transformation('Content-Length', $size, true);
        return $this;
    }



    /**
     * 设置首部指定的是要返回的数据的地址选项。最主要的用途是用来指定要访问的资源经过内容协商后的结果的URL。
     * Location 与 Content-Location是不同的，前者（Location ）指定的是一个重定向请求的目的地址（或者新创建的文件的URL），而后者（ Content-Location） 指向的是可供访问的资源的直接地址，不需要进行进一步的内容协商。Location 对应的是响应，而Content-Location对应的是要返回的实体。
     * Content-Location: <url>
     *
     * @param string $url 相对地址（相对于要访问的URL）或绝对地址。
     * @return HeaderHelp $this
     */
    public function setContentLocation(string $url):HeaderHelp
    {
        $this->_transformation('Content-Location', $url, true);
        return $this;
    }



    /**
     * 设置显示的是一个数据片段在整个文件中的位置
     * <unit>:        数据区间所采用的单位。通常是字节（byte）。
     * <range-start>: 一个整数，表示在给定单位下，区间的起始值。
     * <range-end>:   一个整数，表示在给定单位下，区间的结束值。
     * <size>:        整个文件的大小（如果大小未知则用"*"表示）。
     * Content-Range: <unit> <range-start>-<range-end>/<size>
     * Content-Range: <unit> <range-start>-<range-end>/*
     * Content-Range: <unit> * /<size>
     * Content-Range: bytes 200-1000/67589
     *
     * @param string $range 例如： bytes 200-1000/67589
     * @return HeaderHelp $this
     */
    public function setContentRange(string $range):HeaderHelp
    {
        $this->_transformation('Content-Range', $range, true);
        return $this;
    }


    /**
     * 允许web开发人员通过监测(但不强制执行)政策的影响来尝试政策。这些违反报告由 JSON 文档组成通过一个HTTP POST请求发送到指定的URI。
     * Content-Security-Policy header 的指令也可应用于 Content-Security-Policy-Report-Only. CSP report-uri (en-US) 指令需要跟这个header一起用, 否则这个header将会是一个昂贵却无操作(无作用)的机器(设置)。
     *
     * Content-Security-Policy-Report-Only: <policy-directive>; <policy-directive>
     * Content-Security-Policy-Report-Only: default-src https:; report-uri /csp-violation-report-endpoint/
     *
     * 报告的JSON对象包括下面的数据：
     * document-uri
     *     发生违规的文档URI。
     * referrer
     *     发生违规的文档referrer。
     * blocked-uri
     *     被内容安全政策阻塞加载的资源的URI。如果被阻塞的URI与文档URI不同源，则被阻塞的URI被截断为只包含scheme（协议），host（域名），和port（端口）。
     * violated-directive
     *     被违反的策略名。
     * original-policy
     *      Content-Security-Policy HTTP 头部所指定的原始策略。
     * disposition
     *     “执行”或“报告”取决于是使用Content-Security-Policy 头还是使用 Content-Security-Header-Report-Only 头。
     *
     * @param string $range 例如： bytes 200-1000/67589
     * @return HeaderHelp $this
     */
    public function setContentSecurityPolicyReportOnly(string $range):HeaderHelp
    {
        $this->_transformation('Content-Security-Policy-Report-Only', $range, true);
        return $this;
    }


    /**
     * 允许站点管理者控制用户代理能够为指定的页面加载哪些资源。除了少数例外情况，设置的政策主要涉及指定服务器的源和脚本结束点。这将帮助防止跨站脚本攻击（Cross-Site Script）（XSS (en-US)）。
     * Content-Security-Policy: <policy-directive>; <policy-directive>
     *
     * 获取指令：Fetch directives  通过获取指令来控制某些可能被加载的确切的资源类型的位置。
     * child-src
     *     child-src：为 web workers 和其他内嵌浏览器内容（例如用<frame>和<iframe>加载到页面的内容）定义合法的源地址。
     *     如果开发者希望管控内嵌浏览器内容和 web worker 应分别使用frame-src (en-US)和worker-src 指令，来相对的取代 child-src。
     * connect-src
     *     connect-src：限制能通过脚本接口加载的URL。
     * default-src
     *     default-src：为其他取指令提供备用服务fetch directives。
     * font-src
     *     font-src：设置允许通过@font-face加载的字体源地址。
     * frame-src (en-US)
     *     frame-src： 设置允许通过类似<frame>和<iframe>标签加载的内嵌内容的源地址。
     * img-src (en-US)
     *     img-src: 限制图片和图标的源地址
     * manifest-src (en-US)
     *     manifest-src ： 限制应用声明文件的源地址。
     * media-src (en-US)
     *     media-src：限制通过<audio>、<video>或<track>标签加载的媒体文件的源地址。
     * object-src (en-US)
     *     object-src：限制<object>、<embed>、<applet>标签的源地址。
     *     被object-src控制的元素可能碰巧被当作遗留HTML元素，导致不支持新标准中的功能（例如<iframe>中的安全属性sandbox和allow）。因此建议限制该指令的使用（比如，如果可行，将object-src显式设置为'none'）。
     * prefetch-src (en-US)
     *     指定预加载或预渲染的允许源地址。
     * script-src (en-US)
     *     限制JavaScript的源地址。
     * style-src (en-US)
     *     限制层叠样式表文件源。
     * worker-src
     *     限制Worker、SharedWorker或者ServiceWorker脚本源。
     *
     *
     * 文档指令 | Document directives  文档指令管理文档属性或者worker环境应用的策略。
     * base-uri
     *     限制在DOM中<base>元素可以使用的URL。
     * plugin-types (en-US)
     *     通过限制可以加载的资源类型来限制哪些插件可以被嵌入到文档中。
     * sandbox
     *     类似<iframe> sandbox属性，为请求的资源启用沙盒。
     *
     *
     * 导航指令 | Navigation directives  导航指令管理用户能打开的链接或者表单可提交的链接
     * form-action
     *     限制能被用来作为给定上下文的表单提交的目标 URL（说白了，就是限制 form 的 action 属性的链接地址）
     * frame-ancestors
     *     指定可能嵌入页面的有效父项<frame>, <iframe>, <object>, <embed>, or <applet>.
     *
     *
     * 报告指令控制 CSP 违规的报告过程. 更多请看 Content-Security-Policy-Report-Only 报头.
     * report-uri (en-US)
     *     当出现可能违反CSP的操作时，让客户端提交报告。这些违规报告会以JSON文件的格式通过POST请求发送到指定的URI
     * report-to
     *     Fires a SecurityPolicyViolationEvent.
     *
     *
     * 其他指令 | Other directives
     * block-all-mixed-content
     *     当使用HTTPS加载页面时阻止使用HTTP加载任何资源。
     * require-sri-for
     *     需要使用 SRI (en-US) 作用于页面上的脚本或样式。
     * upgrade-insecure-requests
     *     让浏览器把一个网站所有的不安全 URL（通过 HTTP 访问）当做已经被安全的 URL 链接（通过 HTTPS 访问）替代。这个指令是为了哪些有量大不安全的传统 URL 需要被重写时候准备的。
     *
     *
     * // header
     * Content-Security-Policy: default-src https:
     *
     * // meta tag
     * <meta http-equiv="Content-Security-Policy" content="default-src https:">
     *
     *
     * @param string $type 例如： Content-Security-Policy: default-src https:
     * @return HeaderHelp $this
     */
    public function setContentSecurityPolicy(string $type):HeaderHelp
    {
        $this->_transformation('Content-Security-Policy', $type, true);
        return $this;
    }






    /**
     * 设置资源的MIME类型
     * 在响应中，Content-Type标头告诉客户端实际返回的内容的内容类型。浏览器会在某些情况下进行MIME查找，并不一定遵循此标题的值; 为了防止这种行为，可以将标题 X-Content-Type-Options 设置为 nosniff。
     * Content-Type: text/html; charset=utf-8
     * Content-Type: multipart/form-data; boundary=something
     *
     * 指令
     * media-type
     *     资源或数据的 MIME type 。
     * charset
     *     字符编码标准。
     * boundary
     *     对于多部分实体，boundary 是必需的，其包括来自一组字符的1到70个字符，已知通过电子邮件网关是非常健壮的，而不是以空白结尾。它用于封装消息的多个部分的边界。
     *
     * @param string $type  可选$this->ContentType('txt' / 'html' / 'js' ··· ), 或自定义
     * @return HeaderHelp $this
     */
    public function setContentType(string $type):HeaderHelp
    {
        $this->_transformation('Content-Type', isset($this->ContentType[$type])?$this->ContentType[$type]:$type, true);

//        // 被服务器用来提示客户端一定要遵循在 Content-Type 首部中对  MIME 类型 的设定，而不能对其进行修改。这就禁用了客户端的 MIME 类型嗅探行为，换句话说，也就是意味着网站管理员确定自己的设置没有问题。
//        $this->_transformation('X-Content-Type-Options', 'nosniff', true);
        return $this;
    }



    /**
     * 其中含有先前由服务器通过 Set-Cookie  首部投放并存储到客户端的 HTTP cookies。
     * Cookie: <cookie-list>
     *
     * <cookie-list>
     *     一系列的名称/值对，形式为 <cookie-name>=<cookie-value>。名称/值对之间用分号和空格 ('; ')隔开。
     *
     * Cookie: name=value
     * Cookie: name=value; name2=value2; name3=value3
     * Cookie: PHPSESSID=298zf09hf012fh2; csrftoken=u32t4o3tb3gg43; _gat=1;
     * @param string $cookie
     * @return HeaderHelp $this
     */
    public function setCookie(string $cookie):HeaderHelp
    {
        $this->_transformation('Cookie', $cookie, true);
        return $this;
    }



    /**
     * (COEP) 响应标头可防止文档加载未明确授予文档权限(通过 CORP或者 CORS)的任何跨域资源 。
     * Cross-Origin-Embedder-Policy: unsafe-none | require-corp
     *
     * 指令
     * unsafe-none
     *     这是默认值. 允许文档获取跨源资源，而无需通过CORS协议或 Cross-Origin-Resource-Policy 头。
     * require-corp
     *     文档只能从相同的源加载资源，或显式标记为可从另一个源加载的资源。
     *     如果跨源资源支持CORS，则 crossorigin 属性或 Cross-Origin-Resource-Policy 头必须使用它来加载资源，而不会被COEP阻止。
     *
     *
     * @param string $policy
     * @return HeaderHelp $this
     */
    public function setCrossOriginEmbedderPolicy(string $policy):HeaderHelp
    {
        if($policy !== 'require-corp' || $policy === 'unsafe-none'){
            $this->_transformation('Cross-Origin-Embedder-Policy', $policy, true);
        }
        return $this;
    }



    /**
     * (COOP）允许你通过将其他文档放在不同的浏览器上下文组中，确保将其与其他文档隔离开，这样它们就不能直接与顶层窗口进行交互。例如，如果带有 COOP 的文档打开一个弹出窗口，则其 window.opener 属性将为 null。同样，打开器引用的 .closed 属性将返回 true。
     * 如果在新窗口中打开带有COOP的跨来源文档，则打开的文档将没有对该文档的引用，并且新窗口的window.opener属性将为空。这使您能够比rel=noopener更有效地控制对窗口的引用，rel=noopener只影响传出的导航。
     * Cross-Origin-Opener-Policy: unsafe-none
     *
     * 指令
     * unsafe-none
     *     是默认设置，并且允许将文档添加到 opener 的浏览上下文组中，除非 opener 本身的 COOP 为 same-origin 或 same-origin-allow-popups。
     * same-origin-allow-popups
     *     保留了对未设置 COOP 或通过把 COOP 设置为 unsafe-none 而选择退出隔离的任何弹出窗口的引用。
     * same-origin
     *     将浏览上下文组隔离到相同的原始文档。跨源文档不会加载到同一浏览上下文中。可以与标有 same-origin 的同源文件共享相同的浏览上下文组。
     *
     * @param string $policy
     * @return HeaderHelp $this
     */
    public function setCrossOriginOpenerPolicy(string $policy):HeaderHelp
    {
        if($policy !== 'same-origin' && $policy !== 'same-origin-allow-popups' || $policy === 'unsafe-none'){
            $this->_transformation('Cross-Origin-Opener-Policy', $policy, true);
        }
        return $this;
    }



    /**
     * （CORP） 响应头会指示浏览器阻止对指定资源的无源跨域/跨站点请求。
     * 注意: 由于Chrome 浏览器中的一个Bug, 设置 Cross-Origin-Resource-Policy（跨域资源策略）会使文件下载失败：当从设置了CORP请求头的资源服务器下载资源时，浏览器会阻止用户使用“保存”或“另存为”按钮将文件保存到本地。在决定生产环境中是否使用这一特性（CORP）之前需要慎重考虑。
     * Cross-Origin-Resource-Policy: same-site | same-origin
     *
     * same-site
     * 资源只能从相同站点加载
     * same-origin
     * 资源只能从相同的来源加载
     *
     * @param string $policy
     * @return HeaderHelp $this
     */
    public function setCrossOriginResourcePolicy(string $policy):HeaderHelp
    {
        if($policy !== 'same-origin' || $policy === 'same-site'){
            $this->_transformation('Cross-Origin-Resource-Policy', $policy, true);
        }

        return $this;
    }






    /**
     * 报文创建的日期和时间
     * Date: <day-name>, <day> <month> <year> <hour>:<minute>:<second> GMT
     * <day-name>   "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", 或 "Sun" 之一 （区分大小写）。
     * <day>       2位数字表示天数，例如， "04" 或 "23"。
     * <month>     "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" 之一（区分大小写）。
     * <year>      4位数字表示年份，例如， "1990" 或 "2016"。
     * <hour>      2位数字表示小时数，例如， "09" 或 "23"。
     * <minute>    2位数字表示分钟数，例如， "04" 或 "59"。
     * <second>    2位数字表示秒数，例如， "04" 或 "59"。
     * GMT         格林尼治标准时间。 在HTTP协议中，时间都是用格林尼治标准时间来表示的，而不是本地时间。
     * Date: Wed, 21 Oct 2015 07:28:00 GMT
     * @param string $date  gmdate("D, d M Y h:i:s T ")   Wed, 21 Oct 2015 07:28:00 GMT
     * @return HeaderHelp $this
     */
    public function setDate(string $date):HeaderHelp
    {
        $this->_transformation('Date', $date, true);
        return $this;
    }



    /**
     * 请求资源一个 摘要 。
     * 在 RFC 7231 术语中，它是一个资源的选定表示。这个选定代表依赖于 Content-Type 和 Content-Encoding 头部值：所以一个单一的资源可能有多个不同的摘要值。
     *
     * 摘要是整个表示的计算。这个表示可以是：
     *     完全包含在响应消息体中
     *     完全不包含在消息体中中 (例如，在一个 HEAD 请求的响应中)
     *     部分包含在消息体中 (例如，在一个 range request 的响应中)。
     *
     * Digest: <digest-algorithm>=<digest-value>,<digest-algorithm>=<digest-value>
     *
     * 指令
     * <digest-algorithm>
     *     已支持的摘要算法在 RFC 3230 和 RFC 5843,中定义，包括 SHA-256 和 SHA-512。一些支持的算法(如 unixsum 和 MD5) 容易发生冲突，因此不适合冲突阻力很重要的应用。
     * <digest-value>
     *     对资源表示的摘要算法的结果和编码的结果。摘要算法的选择决定了编码类型：例如 SHA-256 用 base64 编码。
     *
     * Digest: sha-256=X48E9qOokqqrvdts8nOJRJN3OWDUoyWxBf7kbu9DBPE=,unixsum=30637
     *
     * @param string $digest  例如 sha-256=X48E9qOokqqrvdts8nOJRJN3OWDUoyWxBf7kbu9DBPE=,unixsum=30637
     * @return HeaderHelp $this
     */
    public function setDigest(string $digest):HeaderHelp
    {
        $this->_transformation('Digest', $digest, true);
        return $this;
    }


    /**
     * 请求首部 DNT (Do Not Track) 表明了用户对于网站追踪的偏好。它允许用户指定自己是否更注重个人隐私还是定制化内容。
     * DNT: 0
     * DNT: 1
     *
     * 指令
     * 0
     *     表示用户愿意目标站点追踪用户个人信息。
     * 1
     *     表示用户不愿意目标站点追踪用户个人信息。
     *
     * 使用 JavaScript 读取 “不追踪” （Do Not Track）状态: 用户对 DNT 的设置还可以使用 Navigator.doNotTrack 属性进行读取:
     *
     * @param int $DNT  0 | 1
     * @return HeaderHelp $this
     */
    public function setDNT(int $DNT):HeaderHelp
    {
        if($DNT === 0 || $DNT === 1){
            $this->_transformation('DNT', $DNT, true);
        }
        return $this;
    }



    /**
     * 是资源的特定版本的标识符。如果给定URL中的资源更改，则一定要生成新的Etag值。 因此Etags类似于指纹，也可能被某些服务器用于跟踪。
     *
     * 在ETag和 If-Match 头部的帮助下，您可以检测到"空中碰撞"的编辑冲突。
     * 例如，当编辑MDN时，当前的wiki内容被散列，并在响应中放入Etag：
     * ETag: "33a64df551425fcc55e4d42a148795d9f25f89d4
     * 将更改保存到Wiki页面（发布数据）时，POST请求将包含有ETag值的If-Match头来检查是否为最新版本。
     * If-Match: "33a64df551425fcc55e4d42a148795d9f25f89d4"
     * 如果哈希值不匹配，则意味着文档已经被编辑，抛出412前提条件失败错误。
     *
     * 缓存未更改的资源
     * ETag头的另一个典型用例是缓存未更改的资源。 如果用户再次访问给定的URL（设有ETag字段），显示资源过期了且不可用，客户端就发送值为ETag的If-None-Match header字段：
     * If-None-Match: "33a64df551425fcc55e4d42a148795d9f25f89d4"
     * 服务器将客户端的ETag（作为If-None-Match字段的值一起发送）与其当前版本的资源的ETag进行比较，如果两个值匹配（即资源未更改），服务器将返回不带任何内容的304未修改状态，告诉客户端缓存版本可用（新鲜）。
     *
     *
     * ETag: W/"<etag_value>"
     * ETag: "<etag_value>"
     *
     * W/ 可选 'W/'(大小写敏感) 表示使用弱验证器。 弱验证器很容易生成，但不利于比较。
     * "<etag_value>"  实体标签唯一地表示所请求的资源。 它们是位于双引号之间的ASCII字符串（如“675af34563dc-tr34”）。 没有明确指定生成ETag值的方法。 通常，使用内容的散列，最后修改时间戳的哈希值，或简单地使用版本号。 例如，MDN使用wiki内容的十六进制数字的哈希值。
     * ETag: "33a64df551425fcc55e4d42a148795d9f25f89d4"
     * ETag: W/"0815"
     *
     * @param string $code  例如 "33a64df551425fcc55e4d42a148795d9f25f89d4"
     * @return HeaderHelp $this
     */
    public function setETag(string $code):HeaderHelp
    {
        $this->_transformation('ETag', $code, true);
        return $this;
    }




    /**
     * 允许站点选择性报告和/或执行证书透明度 (Certificate Transparency) 要求，来防止错误签发的网站证书的使用不被察觉。当站点启用 Expect-CT 头，就是在请求浏览器检查该网站的任何证书是否出现在公共证书透明度日志之中。
     * Expect-CT: report-uri="<uri>";
     *            enforce;
     *            max-age=<age>
     * 指令
     * max-age
     *     该指令指定接收到 Expect-CT 头后的秒数，在此期间用户代理应将收到消息的主机视为已知的 Expect-CT 主机。
     *     如果缓存接收到的值大于它可以表示的值，或者如果其随后计算溢出，则缓存将认为该值为2147483648（2的31次幂）或其可以方便表示的最大正整数。
     * report-uri="<uri>" 可选
     *     该指令指定用户代理应向其报告 Expect-CT 失效的 URI。
     *     当 enforce 指令和 report-uri 指令共同存在时，这种配置被称为“强制执行和报告”配置，示意用户代理既应该强制遵守证书透明度政策，也应当报告违规行为。
     *
     * Expect-CT: max-age=86400; enforce; report-uri="https://foo.example/report"
     *
     * @param string $code  例如 max-age=86400; enforce; report-uri="https://foo.example/report"
     * @return HeaderHelp $this
     */
    public function setExpectCT(string $code):HeaderHelp
    {
        $this->_transformation('Expect-CT', $code, true);
        return $this;
    }



    /**
     * 是一个请求消息头，包含一个期望条件，表示服务器只有在满足此期望条件的情况下才能妥善地处理请求。
     * 规范中只规定了一个期望条件，即 Expect: 100-continue, 对此服务器可以做出如下回应：
     *     100 如果消息头中的期望条件可以得到满足，使得请求可以顺利进行的话，
     *     417 (Expectation Failed) 如果服务器不能满足期望条件的话；也可以是其他任意表示客户端错误的状态码（4xx）。
     *
     * Expect: 100-continue
     *     通知接收方客户端要发送一个体积可能很大的消息体，期望收到状态码为100 (Continue)  的临时回复。
     *
     * 示例
     * 大消息体
     *
     * 客户端发送带有Expect消息头的请求，等服务器回复后再发送消息体。
     *
     * PUT /somewhere/fun HTTP/1.1
     * Host: origin.example.com
     * Content-Type: video/h264
     * Content-Length: 1234567890987
     * Expect: 100-continue
     *
     * 服务器开始检查请求消息头，可能会返回一个状态码为 100 (Continue) 的回复来告知客户端继续发送消息体，也可能会返回一个状态码为417 (Expectation Failed) 的回复来告知对方要求不能得到满足。
     *
     * @param int $code 100
     * @return HeaderHelp $this
     */
    public function setExpect(int $httpCode):HeaderHelp
    {
        $this->_transformation('Expect', $this->HTTPCode[$httpCode], true);
        return $this;
    }



    /**
     * Expires 响应头包含日期/时间， 即在此时候之后，响应过期。 无效的日期，比如 0, 代表着过去的日期，即该资源已经过期。
     * 如果在Cache-Control响应头设置了 "max-age" 或者 "s-max-age" 指令，那么 Expires 头会被忽略。
     *
     * Expires: <http-date>
     * Expires: Wed, 21 Oct 2015 07:28:00 GMT
     *
     * @param string $date  gmdate("D, d M Y h:i:s T ")  Date: Wed, 21 Oct 2015 07:28:00 GMT
     * @return HeaderHelp $this
     */
    public function setExpires(string $date):HeaderHelp
    {
        $this->_transformation('Expires', $date, true);
        return $this;
    }



    /**
     * 首部中包含了代理服务器的客户端的信息，即由于代理服务器在请求路径中的介入而被修改或丢失的信息。
     * 其他可用来替换的，已经成为既成标准的首部是 X-Forwarded-For 、 X-Forwarded-Host 以及X-Forwarded-Proto 。
     *
     * Forwarded: by=<identifier>; for=<identifier>; host=<host>; proto=<http|https>
     *
     * 指令
     * <identifier>
     *     一个 identifier 显示了在使用代理的过程中被修改或者丢失的信息。它们可以是以下几种形式：
     *         一个IP地址（V4 或 V6，端口号可选，ipv6 地址需要包含在方括号里面，同时用引号括起来），
     *         语意不明的标识符（比如 "_hidden" 或者 "_secret"）,
     *         或者是 "unknown"，当当前信息实体不可知的时候（但是你依然想要说明请求被进行了转发）。
     * by=<identifier>
     *     该请求进入到代理服务器的接口。
     * for=<identifier>
     *     发起请求的客户端以及代理链中的一系列的代理服务器。
     * host=<host>
     *     代理接收到的 Host  首部的信息。
     * proto=<http|https>
     *     表示发起请求时采用的何种协议（通常是 "http" 或者 "https"）。
     *
     * 使用 Forwarded
     * Forwarded: for="_mdn"
     * # 大小写不敏感
     * Forwarded: For="[2001:db8:cafe::17]:4711"
     * # for proto by 之间可用分号分隔
     * Forwarded: for=192.0.2.60; proto=http; by=203.0.113.43
     * # 多值可用逗号分隔
     * Forwarded: for=192.0.2.43, for=198.51.100.17
     *
     * @param string $data  例如 for=192.0.2.60; proto=http; by=203.0.113.43
     * @return HeaderHelp $this
     */
    public function setForwarded(string $data):HeaderHelp
    {
        $this->_transformation('Forwarded', $data, true);
        return $this;
    }




    /**
     * 包含一个电子邮箱地址，这个电子邮箱地址属于发送请求的用户代理的实际掌控者的人类用户。
     * 不可以将 From 首部用于访问控制或者身份验证。
     *
     * From: <email>
     * From: webmaster@example.org
     *
     * @param string $email  例如 webmaster@example.org
     * @return HeaderHelp $this
     */
    public function setFrom(string $email):HeaderHelp
    {
        $this->_transformation('From', $email, true);
        return $this;
    }


    /**
     * Host 请求头指明了请求将要发送到的服务器主机名和端口号。
     * 所有HTTP/1.1 请求报文中必须包含一个Host头字段。对于缺少Host头或者含有超过一个Host头的HTTP/1.1 请求，可能会收到400（Bad Request）状态码。
     *
     * Host: <host>:<port>
     * Host: developer.mozilla.org
     *
     * @param string $email  例如 developer.mozilla.org
     * @return HeaderHelp $this
     */
    public function setHost(string $email):HeaderHelp
    {
        $this->_transformation('Host', $email, true);
        return $this;
    }



    /**
     * 表示这是一个条件请求。在请求方法为 GET 和 HEAD 的情况下，服务器仅在请求的资源满足此首部列出的 ETag值时才会返回资源。而对于 PUT 或其他非安全方法来说，只有在满足条件的情况下才可以将资源上传。
     *
     * 以下是两个常见的应用场景：
     *     对于 GET  和 HEAD 方法，搭配  Range首部使用，可以用来保证新请求的范围与之前请求的范围是对同一份资源的请求。如果  ETag 无法匹配，那么需要返回 416 (Range Not Satisfiable，范围请求无法满足) 响应。
     *     对于其他方法来说，尤其是 PUT, If-Match 首部可以用来避免更新丢失问题。它可以用来检测用户想要上传的不会覆盖获取原始资源之后做出的更新。如果请求的条件不满足，那么需要返回  412 (Precondition Failed，先决条件失败) 响应。
     *
     * If-Match: <etag_value>, <etag_value>, …
     *
     * 指令
     * <etag_value>
     *     唯一地表示一份资源的实体标签。标签是由 ASCII 字符组成的字符串，用双引号括起来（如 "675af34563dc-tr34"）。前面可以加上 W/ 前缀表示应该采用弱比较算法。
     * *
     *     星号是一个特殊值，可以指代任意资源。
     *
     * 示例
     * If-Match: "bfc13a64729c4290ef5b2c2730249c88ca92d82d"
     * If-Match: W/"67ab43", "54ed21", "7892dd"           // W/ 前缀表示可以采用相对宽松的算法。
     * If-Match: *
     *
     * @param string $data  例如 "54ed21"
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setIfMatch(string $data, bool $reset = false):HeaderHelp
    {
        $this->_transformation('If-Match', $data, $reset);
        return $this;
    }




    /**
     * 是一个条件式请求首部，服务器只在所请求的资源在给定的日期时间之后对内容进行过修改的情况下才会将资源返回，状态码为 200  。如果请求的资源从那时起未经修改，那么返回一个不带有消息主体的  304  响应，而在 Last-Modified 首部中会带有上次修改时间。
     * 不同于  If-Unmodified-Since, If-Modified-Since 只可以用在 GET 或 HEAD 请求中。
     * 当与 If-None-Match 一同出现时，它（If-Modified-Since）会被忽略掉，除非服务器不支持 If-None-Match。
     * 最常见的应用场景是来更新没有特定 ETag 标签的缓存实体。
     *
     * If-Modified-Since: <day-name>, <day> <month> <year> <hour>:<minute>:<second> GMT
     *
     * <day-name>   "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", 或 "Sun" 之一 （区分大小写）。
     * <day>       2位数字表示天数，例如， "04" 或 "23"。
     * <month>     "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" 之一（区分大小写）。
     * <year>      4位数字表示年份，例如， "1990" 或 "2016"。
     * <hour>      2位数字表示小时数，例如， "09" 或 "23"。
     * <minute>    2位数字表示分钟数，例如， "04" 或 "59"。
     * <second>    2位数字表示秒数，例如， "04" 或 "59"。
     * GMT         格林尼治标准时间。 在HTTP协议中，时间都是用格林尼治标准时间来表示的，而不是本地时间。
     *
     * If-Modified-Since: Wed, 21 Oct 2015 07:28:00 GMT
     *
     * @param string $date  gmdate("D, d M Y h:i:s T ")   Wed, 21 Oct 2015 07:28:00 GMT
     * @return HeaderHelp $this
     */
    public function setIfModifiedSince(string $date):HeaderHelp
    {
        $this->_transformation('If-Modified-Since', $date, true);
        return $this;
    }


    /**
     * 是一个条件式请求首部。对于 GETGET 和 HEAD 请求方法来说，当且仅当服务器上没有任何资源的 ETag 属性值与这个首部中列出的相匹配的时候，服务器端会才返回所请求的资源，响应码为  200  。
     * 对于  GET 和 HEAD 方法来说，当验证失败的时候，服务器端必须返回响应码 304 （Not Modified，未改变）。对于能够引发服务器状态改变的方法，则返回 412 （Precondition Failed，前置条件失败）。需要注意的是，服务器端在生成状态码为 304 的响应的时候，必须同时生成以下会存在于对应的 200 响应中的首部：Cache-Control、Content-Location、Date、ETag、Expires 和 Vary 。
     * 当与  If-Modified-Since  一同使用的时候，If-None-Match 优先级更高（假如服务器支持的话）。
     *
     * 以下是两个常见的应用场景：
     *     采用 GET 或 HEAD  方法，来更新拥有特定的ETag 属性值的缓存。
     *     采用其他方法，尤其是  PUT，将 If-None-Match used 的值设置为 * ，用来生成事先并不知道是否存在的文件，可以确保先前并没有进行过类似的上传操作，防止之前操作数据的丢失。这个问题属于更新丢失问题的一种。
     *
     * 语法
     * If-None-Match: <etag_value>
     * If-None-Match: <etag_value>, <etag_value>, …
     * If-None-Match: *
     *
     * 指令
     * <etag_value>
     *     唯一地表示所请求资源的实体标签。形式是采用双引号括起来的由 ASCII 字符串（如"675af34563dc-tr34"），有可能包含一个 W/ 前缀，来提示应该采用弱比较算法（这个是画蛇添足，因为 If-None-Match 用且仅用这一算法）。
     * *
     *     星号是一个特殊值，可以代表任意资源。它只用在进行资源上传时，通常是采用 PUT 方法，来检测拥有相同识别ID的资源是否已经上传过了。
     *
     * 示例
     * If-None-Match: "bfc13a64729c4290ef5b2c2730249c88ca92d82d"
     * If-None-Match: W/"67ab43", "54ed21", "7892dd"
     * If-None-Match: *
     *
     * @param string $data  "54ed21"
     * @return HeaderHelp $this
     */
    public function setIfNoneMatch(string $data):HeaderHelp
    {
        $this->_transformation('If-None-Match', $data, true);
        return $this;
    }


    /**
     * 用来使得 Range 头字段在一定条件下起作用：当字段值中的条件得到满足时，Range 头字段才会起作用，同时服务器回复206 部分内容状态码，以及Range 头字段请求的相应部分；如果字段值中的条件没有得到满足，服务器将会返回 200 OK 状态码，并返回完整的请求资源。
     * 字段值中既可以用 Last-Modified 时间值用作验证，也可以用ETag标记作为验证，但不能将两者同时使用。
     * If-Range 头字段通常用于断点续传的下载过程中，用来自从上次中断后，确保下载的资源没有发生改变。
     *
     * If-Range: <day-name>, <day> <month> <year> <hour>:<minute>:<second> GMT
     * If-Range: <etag>
     *
     * <etag>      一个资源标签（entity tag）代表着所请求的资源。它是由被双引号包围的ACSII 编码的字符串组成的（例如"675af34563dc-tr34"）。当应用弱匹配算法时，E-Tag会有一个 W/ 前缀。
     * <day-name>   "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", 或 "Sun" 之一 （区分大小写）。
     * <day>       2位数字表示天数，例如， "04" 或 "23"。
     * <month>     "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" 之一（区分大小写）。
     * <year>      4位数字表示年份，例如， "1990" 或 "2016"。
     * <hour>      2位数字表示小时数，例如， "09" 或 "23"。
     * <minute>    2位数字表示分钟数，例如， "04" 或 "59"。
     * <second>    2位数字表示秒数，例如， "04" 或 "59"。
     * GMT         格林尼治标准时间。 在HTTP协议中，时间都是用格林尼治标准时间来表示的，而不是本地时间。
     *
     * If-Range: Wed, 21 Oct 2015 07:28:00 GMT
     *
     *
     * @param string $data  gmdate("D, d M Y h:i:s T ")   Wed, 21 Oct 2015 07:28:00 GMT |
     * @return HeaderHelp $this
     */
    public function setIfRange(string $data):HeaderHelp
    {
        $this->_transformation('If-Range', $data, true);
        return $this;
    }


    /**
     * 用于请求之中，使得当前请求成为条件式请求：只有当资源在指定的时间之后没有进行过修改的情况下，服务器才会返回请求的资源，或是接受 POST 或其他 non-safe 方法的请求。如果所请求的资源在指定的时间之后发生了修改，那么会返回 412 (Precondition Failed) 错误。
     * 常见的应用场景有两种：
     *     与 non-safe 方法如 POST 搭配使用，可以用来优化并发控制，例如在某些wiki应用中的做法：假如在原始副本获取之后，服务器上所存储的文档已经被修改，那么对其作出的编辑会被拒绝提交。
     *     与含有 If-Range 消息头的范围请求搭配使用，用来确保新的请求片段来自于未经修改的文档。
     *
     * If-Unmodified-Since: <day-name>, <day> <month> <year> <hour>:<minute>:<second> GMT
     *
     * <etag>      一个资源标签（entity tag）代表着所请求的资源。它是由被双引号包围的ACSII 编码的字符串组成的（例如"675af34563dc-tr34"）。当应用弱匹配算法时，E-Tag会有一个 W/ 前缀。
     * <day-name>   "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", 或 "Sun" 之一 （区分大小写）。
     * <day>       2位数字表示天数，例如， "04" 或 "23"。
     * <month>     "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" 之一（区分大小写）。
     * <year>      4位数字表示年份，例如， "1990" 或 "2016"。
     * <hour>      2位数字表示小时数，例如， "09" 或 "23"。
     * <minute>    2位数字表示分钟数，例如， "04" 或 "59"。
     * <second>    2位数字表示秒数，例如， "04" 或 "59"。
     * GMT         格林尼治标准时间。 在HTTP协议中，时间都是用格林尼治标准时间来表示的，而不是本地时间。
     *
     * If-Unmodified-Since: Wed, 21 Oct 2015 07:28:00 GMT
     *
     *
     * @param string $data  gmdate("D, d M Y h:i:s T ")   Wed, 21 Oct 2015 07:28:00 GMT
     * @return HeaderHelp $this
     */
    public function setIfUnmodifiedSince(string $date):HeaderHelp
    {
        $this->_transformation('If-Unmodified-Since', $date, true);
        return $this;
    }



    /**
     * 允许消息发送者暗示连接的状态，还可以用来设置超时时长和最大请求
     * 需要将 The Connection 首部的值设置为  "keep-alive" 这个首部才有意义。同时需要注意的是，在HTTP/2 协议中， Connection 和 Keep-Alive  是被忽略的；在其中采用其他机制来进行连接管理。
     * Keep-Alive: parameters 一系列用逗号隔开的参数，每一个参数由一个标识符和一个值构成，并使用等号 ('=') 隔开。下述标识符是可用的：
     *          timeout：指定了一个空闲连接需要保持打开状态的最小时长（以秒为单位）。
     *          max：在连接关闭之前，在此连接可以发送的请求的最大值。
     * Keep-Alive: timeout=5, max=1000
     *
     * @param string $type  timeout=5, max=1000
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setKeepAlive(string $type = 'timeout=5, max=1000', bool $reset = false):HeaderHelp
    {
        $this->_transformation('Keep-Alive', $type, $reset);
        return $this;
    }




    /**
     * 服务器认定的资源做出修改的日期及时间。由于精确度比  ETag 要低，所以这是一个备用机制。包含有  If-Modified-Since 或 If-Unmodified-Since 首部的条件请求会使用这个字段。
     *
     * @param string $date   gmdate("D, d M Y h:i:s T ") Date: Wed, 21 Oct 2015 07:28:00 GMT
     * @return HeaderHelp $this
     */
    public function setLastModified(string $date):HeaderHelp
    {
        $this->_transformation('Last-Modified', $date, true);
        return $this;
    }


    /**
     * 首部指定的是需要将页面重新定向至的地址。一般在响应码为3xx的响应中才会有意义。
     * Location 与 Content-Location是不同的，前者（Location ）指定的是一个重定向请求的目的地址（或者新创建的文件的URL），而后者（ Content-Location） 指向的是经过内容协商后的资源的直接地址，不需要进行进一步的内容协商。Location 对应的是响应，而Content-Location对应的是要返回的实体。
     *
     * Location: <url>
     * <url>    相对地址（相对于要访问的URL）或绝对地址。
     * Location: /index.html
     *
     * @param string $url  /index.html
     * @return HeaderHelp $this
     */
    public function setLocation(string $url):HeaderHelp
    {
        $this->_transformation('Location', $url, true);
        return $this;
    }



    /**
     * 指示了请求来自于哪个站点。该字段仅指示服务器名称，并不包含任何路径信息。该首部用于 CORS 请求或者 POST 请求。除了不包含路径信息，该字段与 Referer 首部字段相似。
     * Origin: <scheme> "://" <host> [ ":" <port> ]
     * <scheme> 请求所使用的协议，通常是HTTP协议或者它的安全版本HTTPS协议。
     * <host>    服务器的域名或 IP 地址。
     * <port> 可选  服务器正在监听的TCP 端口号。缺省为服务的默认端口（对于 HTTP 请求而言，默认端口为 80）。
     *
     * Origin: https://developer.mozilla.org
     * @param string $origin  https://developer.mozilla.org
     * @return HeaderHelp $this
     */
    public function setOrigin(string $origin):HeaderHelp
    {
        $this->_transformation('Origin', $origin, true);
        return $this;
    }



    /**
     * 是一个响应首部，指定了获取 proxy server （代理服务器）上的资源访问权限而采用的身份验证方式。代理服务器对请求进行验证，以便它进一步传递请求。
     * Proxy-Authenticate 首部需要与 407 Proxy Authentication Required 响应一起发送。
     *
     * 语法
     * Proxy-Authenticate: <type> realm=<realm>
     *
     * 指令
     * <type>
     *     身份验证类型。一个常见的类型是 "基本验证"。IANA 机构维护了 一系列的身份验证机制。
     * realm=<realm>
     *     对于被保护区域（即安全域）的描述。如果没有指定安全域，客户端通常用一个格式化的主机名来代替。
     *
     * 示例
     * Proxy-Authenticate: Basic
     * Proxy-Authenticate: Basic realm="Access to the internal site"
     *
     * @param string $data  Basic realm="Access to the internal site"
     * @return HeaderHelp $this
     */
    public function setProxyAuthenticate(string $data):HeaderHelp
    {
        $this->_transformation('Proxy-Authenticate', $data, true);
        return $this;
    }



    /**
     * 是一个请求首部，其中包含了用户代理提供给代理服务器的用于身份验证的凭证。这个首部通常是在服务器返回了 407 Proxy Authentication Required 响应状态码及 Proxy-Authenticate 首部后发送的。
     *
     * 语法
     * Proxy-Authorization: <type> <credentials>
     *
     * 指令
     * <type>
     *     身份验证类型。一个常见的类型是 "基本验证"。IANA 机构维护了 一系列的身份验证机制。
     * <credentials>
     *     凭证的构成方式如下：
     *         将用户名和密码用冒号拼接（aladdin:opensesame）。
     *         将拼接生成的字符串使用 base64 编码方式进行编码（YWxhZGRpbjpvcGVuc2VzYW1l）。
     *     注意： Base64 编码方式不是用来加密或者获取摘要的！这种方法的安全性相当于将凭证使用明文发送（base64 是一种可逆编码方式）。在使用基本身份验证方式的时候推荐与 HTTPS 搭配使用。
     *
     * 示例
     * Proxy-Authorization: Basic YWxhZGRpbjpvcGVuc2VzYW1l
     *
     * @param string $data  Basic YWxhZGRpbjpvcGVuc2VzYW1l
     * @return HeaderHelp $this
     */
    public function setProxyAuthorization(string $data):HeaderHelp
    {
        $this->_transformation('Proxy-Authorization', $data, true);
        return $this;
    }




    /**
     * 是一个请求首部，告知服务器返回文件的哪一部分。在一个  Range 首部中，可以一次性请求多个部分，服务器会以 multipart 文件的形式将其返回。如果服务器返回的是范围响应，需要使用 206 Partial Content 状态码。假如所请求的范围不合法，那么服务器会返回  416 Range Not Satisfiable 状态码，表示客户端错误。服务器允许忽略  Range  首部，从而返回整个文件，状态码用 200 。
     * Range: <unit>=<range-start>-
     * Range: <unit>=<range-start>-<range-end>
     * Range: <unit>=<range-start>-<range-end>, <range-start>-<range-end>
     * Range: <unit>=<range-start>-<range-end>, <range-start>-<range-end>, <range-start>-<range-end>
     *
     * <unit>
     *     范围所采用的单位，通常是字节（bytes）。
     * <range-start>
     *     一个整数，表示在特定单位下，范围的起始值。
     * <range-end>
     *     一个整数，表示在特定单位下，范围的结束值。这个值是可选的，如果不存在，表示此范围一直延伸到文档结束。
     *
     * Range: bytes=200-1000, 2000-6576, 19000-
     *
     * @param string $range  bytes=200-1000
     * @return HeaderHelp $this
     */
    public function setRange(string $range):HeaderHelp
    {
        $this->_transformation('Range', $range, true);
        return $this;
    }



    /**
     * 当前请求页面的来源页面的地址，即表示当前页面是通过此来源页面里的链接进入的。服务端一般使用 Referer 请求头识别访问来源，可能会以此进行统计分析、日志记录以及缓存优化等。
     * 在以下两种情况下，Referer 不会被发送：
     *     来源页面采用的协议为表示本地文件的 "file" 或者 "data" URI；
     *     当前请求页面采用的是非安全协议，而来源页面采用的是安全协议（HTTPS）。
     * <url>
     *     当前页面被链接而至的前一页面的绝对路径或者相对路径。不包含 URL fragments (例如 "#section") 和 userinfo (例如 "https://username:password@example.com/foo/bar/" 中的 "username:password" )。
     * Referer: <url>
     *
     * @param string $range  <url>
     * @return HeaderHelp $this
     */
    public function setReferer(string $referrer):HeaderHelp
    {
        $this->_transformation('Referer', $referrer, true);
        return $this;
    }



    /**
     *  首部用来监管哪些访问来源信息——会在 Referer  中发送——应该被包含在生成的请求当中。
     *
     * Referrer-Policy: no-referrer
     * Referrer-Policy: no-referrer-when-downgrade
     * Referrer-Policy: no-referrer, strict-origin-when-cross-origin
     *
     * 指令
     * no-referrer
     *     整个 Referer  首部会被移除。访问来源信息不随着请求一起发送。
     * no-referrer-when-downgrade （默认值）
     *     在没有指定任何策略的情况下用户代理的默认行为。在同等安全级别的情况下，引用页面的地址会被发送(HTTPS->HTTPS)，但是在降级的情况下不会被发送 (HTTPS->HTTP)。
     * origin
     *     在任何情况下，仅发送文件的源作为引用地址。例如  https://example.com/page.html 会将 https://example.com/ 作为引用地址。
     * origin-when-cross-origin
     *     对于同源的请求，会发送完整的URL作为引用地址，但是对于非同源请求仅发送文件的源。
     * same-origin
     *     对于同源的请求会发送引用地址，但是对于非同源请求则不发送引用地址信息。
     * strict-origin
     *     在同等安全级别的情况下，发送文件的源作为引用地址(HTTPS->HTTPS)，但是在降级的情况下不会发送 (HTTPS->HTTP)。
     * strict-origin-when-cross-origin
     *     对于同源的请求，会发送完整的URL作为引用地址；在同等安全级别的情况下，发送文件的源作为引用地址(HTTPS->HTTPS)；在降级的情况下不发送此首部 (HTTPS->HTTP)。
     * unsafe-url
     *     无论是同源请求还是非同源请求，都发送完整的 URL（移除参数信息之后）作为引用地址。
     *     这项设置会将受 TLS 安全协议保护的资源的源和路径信息泄露给非安全的源服务器。进行此项设置的时候要慎重考虑。
     *
     * 集成到 HTML
     * <meta name="referrer" content="origin">
     * <a href="http://example.com" referrerpolicy="origin">
     * <a href="http://example.com" rel="noreferrer">
     *
     *
     * @param string $referrer  no-referrer, strict-origin-when-cross-origin
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setReferrerPolicy(string $referrer, bool $reset = false):HeaderHelp
    {
        $this->_transformation('Referrer-Policy', $referrer, $reset);
        return $this;
    }



    /**
     * 响应首部 Retry-After 表示用户代理需要等待多长时间之后才能继续发送请求。这个首部主要应用于以下两种场景：
     *     当与 503 (Service Unavailable，当前服务不存在) 响应一起发送的时候，表示服务下线的预期时长。
     *     当与重定向响应一起发送的时候，比如 301 (Moved Permanently，永久迁移)，表示用户代理在发送重定向请求之前需要等待的最短时间。
     *
     * 语法
     * Retry-After: <http-date>
     * Retry-After: <delay-seconds>
     *
     * 指令
     * <http-date>
     *     表示在此时间之后可以重新尝试。参见  Date  首部来获取HTTP协议中关于日期格式的细节信息。
     * <delay-seconds>
     *     一个非负的十进制整数，表示在重试之前需要等待的秒数。
     *
     * Retry-After: Wed, 21 Oct 2015 07:28:00 GMT
     * Retry-After: 120
     *
     * 不同的客户端与服务器端应用对于 Retry-After 首部的支持依然不太一致。不过，一些爬虫程序，比如谷歌的爬虫程序 Googlebot，会遵循 Retry-After 首部的规则。将其与  503 (Service Unavailable，当前服务不存在)  响应一起发送有助于互联网引擎做出判断，在宕机结束之后继续对网站构建索引。
     *
     * @param string $referrer  gmdate("D, d M Y h:i:s T ") Date: Wed, 21 Oct 2015 07:28:00 GMT
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setRetryAfter(string $referrer):HeaderHelp
    {
        $this->_transformation('Retry-After', $referrer, true);
        return $this;
    }




    /**
     * 请求头字段是一个布尔值，在请求中，表示客户端对减少数据使用量的偏好。 这可能是传输成本高，连接速度慢等原因。
     *
     * 语法
     * Save-Data: <sd-token>
     * 指令
     * <sd-token>
     *     一个数值，表示客户端是否想要选择简化数据使用模式。 on表示是，而off（默认值）表示不。
     *
     * 示例
     * 请求头Vary 确保正确缓存内容（例如，当Save-Data标头不再存在时，确保不从缓存向用户提供较低质量的图像[例如在从蜂窝网络切换到Wi-Fi后]）
     * 携带 Save-Data: on 请求头
     *
     * 请求示例:
     * GET /image.jpg HTTP/1.0
     * Host: example.com
     * Save-Data: on
     *
     * 响应示例:
     * HTTP/1.0 200 OK
     * Content-Length: 102832
     * Vary: Accept-Encoding, Save-Data
     * Cache-Control: public, max-age=31536000
     * Content-Type: image/jpeg
     *
     * @param string $type   on | off
     * @return HeaderHelp $this
     */
    public function setSaveData(string $type):HeaderHelp
    {
        if($type === 'on' || $type === 'off'){
            $this->_transformation('Save-Data', $referrer, true);
        }
        return $this;
    }


    /**
     *  标头传达在一个给定请求-响应周期中的一个或多个参数和描述。它用于在用户浏览器的开发工具或 PerformanceServerTiming (en-US) 接口中显示任何后端服务器定时参数（例如，数据库读/写、CPU 时间、文件系统访问等）。
     *
     * 语法
     * Server-Timing 头的语法允许您以不同方式传达参数：仅服务器参数名称，具有值的参数，具有值和描述的度参数以及具有描述的参数。
     *
     * // Single metric without value
     * Server-Timing: missedCache
     * // Single metric with value
     * Server-Timing: cpu;dur=2.4
     * // Single metric with description and value
     * Server-Timing: cache;desc="Cache Read";dur=23.2
     * // Two metrics with value
     * Server-Timing: db;dur=53, app;dur=47.2
     * // Server-Timing as trailer
     * Trailer: Server-Timing
     * --- response body ---
     * Server-Timing: total;dur=123.4
     *
     * @param string $data   db;dur=53, app;dur=47.2
     * @return HeaderHelp $this
     */
    public function setServerTiming(string $data):HeaderHelp
    {
        $this->_transformation('Server-Timing', $data, true);
        return $this;
    }


    /**
     * 首部包含了处理请求的源头服务器所用到的软件相关信息
     *
     * 语法
     * Server: <product>
     *
     * 指令
     * <product>
     *     处理请求的软件或者产品（或组件产品）的名称。
     * 示例
     * Server: Apache/2.4.1 (Unix)
     *
     * @param string $data   Apache/2.4.1 (Unix)
     * @return HeaderHelp $this
     */
    public function setServer(string $data):HeaderHelp
    {
        $this->_transformation('Server', $data, true);
        return $this;
    }


    /**
     * 响应首部 Set-Cookie 被用来由服务器端向客户端发送 cookie。
     *
     * 语法
     * Set-Cookie: <cookie-name>=<cookie-value>; SameSite=Lax
     * // Multiple directives are also possible, for example:
     * Set-Cookie: <cookie-name>=<cookie-value>; Domain=<domain-value>; Secure; HttpOnly
     *
     * 指令
     * <cookie-name>=<cookie-value>
     *     一个 cookie 开始于一个名称/值对：
     *         <cookie-name> 可以是除了控制字符 (CTLs)、空格 (spaces) 或制表符 (tab)之外的任何 US-ASCII 字符。同时不能包含以下分隔字符： ( ) < > @ , ; : \ " /  [ ] ? = { }.
     *         <cookie-value> 是可选的，如果存在的话，那么需要包含在双引号里面。支持除了控制字符（CTLs）、空格（whitespace）、双引号（double quotes）、逗号（comma）、分号（semicolon）以及反斜线（backslash）之外的任意 US-ASCII 字符。关于编码：许多应用会对 cookie 值按照URL编码（URL encoding）规则进行编码，但是按照 RFC 规范，这不是必须的。不过满足规范中对于 <cookie-value> 所允许使用的字符的要求是有用的。
     *         __Secure- 前缀：以 __Secure- 为前缀的 cookie（其中连接符是前缀的一部分），必须与 secure 属性一同设置，同时必须应用于安全页面（即使用 HTTPS 访问的页面）。
     *         __Host- 前缀： 以 __Host- 为前缀的 cookie，必须与 secure 属性一同设置，必须应用于安全页面（即使用 HTTPS 访问的页面），必须不能设置 domain 属性 （也就不会发送给子域），同时 path 属性的值必须为“/”。
     * Expires=<date> 可选
     *     cookie 的最长有效时间，形式为符合 HTTP-date 规范的时间戳。参考 Date 可以获取详细信息。如果没有设置这个属性，那么表示这是一个会话期 cookie 。一个会话结束于客户端被关闭时，这意味着会话期 cookie 在彼时会被移除。然而，很多Web浏览器支持会话恢复功能，这个功能可以使浏览器保留所有的tab标签，然后在重新打开浏览器的时候将其还原。与此同时，cookie 也会恢复，就跟从来没有关闭浏览器一样。
     * Max-Age=<non-zero-digit> 可选
     *     在 cookie 失效之前需要经过的秒数。秒数为 0 或 -1 将会使 cookie 直接过期。一些老的浏览器（ie6、ie7 和 ie8）不支持这个属性。对于其他浏览器来说，假如二者 （指 Expires 和Max-Age） 均存在，那么 Max-Age 优先级更高。
     * Domain=<domain-value> 可选
     *     指定 cookie 可以送达的主机名。假如没有指定，那么默认值为当前文档访问地址中的主机部分（但是不包含子域名）。与之前的规范不同的是，域名之前的点号会被忽略。假如指定了域名，那么相当于各个子域名也包含在内了。
     * Path=<path-value> 可选
     *     指定一个 URL 路径，这个路径必须出现在要请求的资源的路径中才可以发送 Cookie 首部。字符  %x2F ("/") 可以解释为文件目录分隔符，此目录的下级目录也满足匹配的条件（例如，如果 path=/docs，那么 "/docs", "/docs/Web/" 或者 "/docs/Web/HTTP" 都满足匹配的条件）。
     * Secure 可选
     *     一个带有安全属性的 cookie 只有在请求使用SSL和HTTPS协议的时候才会被发送到服务器。然而，保密或敏感信息永远不要在 HTTP cookie 中存储或传输，因为整个机制从本质上来说都是不安全的，比如前述协议并不意味着所有的信息都是经过加密的。
     *     注意：非安全站点（http:）已经不能再在 cookie 中设置 secure 指令了（在Chrome 52+ and Firefox 52+ 中新引入的限制）。
     * HttpOnly 可选
     *     设置了 HttpOnly 属性的 cookie 不能使用 JavaScript 经由  Document.cookie 属性、XMLHttpRequest 和  Request APIs 进行访问，以防范跨站脚本攻击（XSS (en-US)）。
     * SameSite=Strict
     * SameSite=Lax 可选
     *     允许服务器设定一则 cookie 不随着跨域请求一起发送，这样可以在一定程度上防范跨站请求伪造攻击（CSRF）。
     *
     * 示例
     *
     * 会话期 cookies; 将会在客户端关闭时被移除。 会话期 cookie 不设置 Expires 或 Max-Age 指令。注意浏览器通常支持会话恢复功能。
     * Set-Cookie: sessionid=38afes7a8; HttpOnly; Path=/
     *
     * 持久化 Cookie; 不会在客户端关闭时失效，而是在特定的日期（Expires）或者经过一段特定的时间之后（Max-Age）才会失效。
     * Set-Cookie: id=a3fWa; Expires=Wed, 21 Oct 2015 07:28:00 GMT; Secure; HttpOnly
     *
     * 非法域; 属于特定域的 cookie，假如域名不能涵盖原始服务器的域名，那么应该被用户代理拒绝。下面这个 cookie 假如是被域名为 originalcompany.com 的服务器设置的，那么将会遭到用户代理的拒绝：
     * Set-Cookie: qwerty=219ffwef9w0f; Domain=somecompany.co.uk; Path=/; Expires=Wed, 30 Aug 2019 00:00:00 GMT
     *
     * Cookie 前缀; 名称中包含 __Secure- 或 __Host- 前缀的 cookie，只可以应用在使用了安全连接（HTTPS）的域中，需要同时设置 secure 指令。另外，假如 cookie 以 __Host- 为前缀，那么 path 属性的值必须为 "/" （表示整个站点），且不能含有 domain 属性。对于不支持 cookie 前缀的客户端，无法保证这些附加的条件成立，所以 cookie 总是被接受的。
     * // 当响应来自于一个安全域（HTTPS）的时候，二者都可以被客户端接受
     * Set-Cookie: __Secure-ID=123; Secure; Domain=example.com
     * Set-Cookie: __Host-ID=123; Secure; Path=/
     * // 缺少 Secure 指令，会被拒绝
     * Set-Cookie: __Secure-id=1
     * // 缺少 Path=/ 指令，会被拒绝
     * Set-Cookie: __Host-id=1; Secure
     * // 由于设置了 domain 属性，会被拒绝
     * Set-Cookie: __Host-id=1; Secure; Path=/; domain=example.com
     *
     *
     * @param string $data   sessionid=38afes7a8; HttpOnly; Path=/
     * @return HeaderHelp $this
     */
    public function setSetCookie(string $data):HeaderHelp
    {
        $this->_transformation('Set-Cookie', $data, true);
        return $this;
    }


    /**
     *  HTTP 响应头链接生成的代码到一个 source map，使浏览器能够重建原始的资源然后显示在调试器里。
     *
     * 语法
     * SourceMap: <url>
     * X-SourceMap: <url> (deprecated)
     *
     * 指令
     * <url>
     *     指向一个source map文件的一个相对（于请求的URL）或者一个绝对的URL。
     *
     * 例子
     * SourceMap: /path/to/file.js.map
     *
     * @param string $url   /path/to/file.js.map
     * @return HeaderHelp $this
     */
    public function setSourceMap(string $url):HeaderHelp
    {
        $this->_transformation('SourceMap', $url, true);
        return $this;
    }


    /**
     * （通常简称为HSTS）是一个安全功能，它告诉浏览器只能通过HTTPS访问当前资源，而不是HTTP。
     * 注意: Strict-Transport-Security 在通过 HTTP 访问时会被浏览器忽略; 因为攻击者可以通过中间人攻击的方式在连接中修改、注入或删除它
     *
     * 语法
     * Strict-Transport-Security: max-age=<expire-time>
     * Strict-Transport-Security: max-age=<expire-time>; preload
     *
     * 指令
     * max-age=<expire-time>
     *     设置在浏览器收到这个请求后的<expire-time>秒的时间内凡是访问这个域名下的请求都使用HTTPS请求。
     * includeSubDomains 可选
     *     如果这个可选的参数被指定，那么说明此规则也适用于该网站的所有子域名。
     * preload 可选
     *     查看 预加载 HSTS 获得详情。不是标准的一部分。
     *
     * Strict-Transport-Security: max-age=31536000; includeSubDomains
     *
     * @param string $url   max-age=31536000; includeSubDomains
     * @return HeaderHelp $this
     */
    public function setHTTPStrictTransportSecurity(string $url):HeaderHelp
    {
        $this->_transformation('HTTP Strict Transport Security', $url, true);
        return $this;
    }


    /**
     * 请求型头部用来指定用户代理希望使用的传输编码类型。(可以将其非正式称为 Accept-Transfer-Encoding， 这个名称显得更直观一些)。
     *
     * 语法
     * TE: compress
     * TE: deflate
     * TE: gzip
     * TE: trailers
     * // 多个指令, 使用 quality value 语法来表示优先级:
     * TE: trailers, deflate;q=0.5
     *
     * 指令
     * compress
     *     这个名称代表采用了  Lempel-Ziv-Welch (LZW) 压缩算法的传输编码格式。
     * deflate
     *     这个名称代表采用了 zlib 结构的传输编码格式。
     * gzip
     *     这个名称代表采用了  Lempel-Ziv coding (LZ77) 压缩算法，以及32位CRC校验的传输编码格式。
     * trailers
     *     表示客户端期望在采用分块传输编码的响应中接收挂载字段。
     * q
     *     当多种形式的传输编码格式都可以接受的时候，这个采用了质量价值语法的参数可以用来对不同的编码形式按照优先级进行排序。
     *
     *
     * @param string $data   trailers, deflate;q=0.5
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setTE(string $data, bool $reset = false):HeaderHelp
    {
        $this->_transformation('TE', $data, true);
        return $this;
    }


    /**
     * 响应头Timing-Allow-Origin用于指定特定站点，以允许其访问Resource Timing API提供的相关信息，否则这些信息会由于跨源限制将被报告为零
     *
     * 语法
     * Timing-Allow-Origin: *
     * Timing-Allow-Origin: <origin>[, <origin>]*
     *
     * 指令
     * *
     *     服务器可以以“*”作为通配符，从而允许所有域都具有访问定时信息的权限。
     * <origin>
     *     指定一个可以访问资源的URI。你也可以通过逗号隔开，指定多个URI。
     *
     * 示例
     * 如需允许任何资源都可以看到的计时(timing)信息，你可以如此设置：
     * Timing-Allow-Origin: *
     * 如需允许https://developer.mozilla.org查看你的计时信息，你可以设置：
     * Timing-Allow-Origin: https://developer.mozilla.org
     *
     * @param string $url   https://developer.mozilla.org
     * @return HeaderHelp $this
     */
    public function setTimingAllowOrigin(string $url):HeaderHelp
    {
        $this->_transformation('Timing-Allow-Origin', $url, true);
        return $this;
    }



    /**
     * Tk 响应首部显示了对相应请求的跟踪情况。
     *
     * 语法
     * Tk: !  (under construction)
     * Tk: ?  (dynamic)
     * Tk: G  (gateway or multiple parties)
     * Tk: N  (not tracking)
     * Tk: T  (tracking)
     * Tk: C  (tracking with consent)
     * Tk: P  (potential consent)
     * Tk: D  (disregarding DNT)
     * Tk: U  (updated)
     *
     * 指令
     * !    待建。源头服务器目前正在测试它对跟踪情况的通信功能。
     * ?    不确定。源头服务器需要更多的信息来确定跟踪状态。
     * G    网关或多方。服务器扮演了网关的角色，与多方进行信息交换。
     * N    不跟踪。
     * T    跟踪。
     * C    在经过用户同意的情况下进行跟踪。源头服务器相信它事先得到了许可来跟踪用户、用户代理或者设备。
     * P    尚未接收到的许可。 源头服务器不能实时知道它是否获得了事先许可来跟踪用户、用户代理或者设备，但是会承诺不采用或者共享标记为 DNT:1 的数据，直到获得了事先许可，并进一步承诺将会在 48 小时之内对未经许可的资源进行删除或者对其进行消除身份识别信息处理。
     *
     * @param string $type   N
     * @return HeaderHelp $this
     */
    public function setTk(string $type):HeaderHelp
    {
        $this->_transformation('Tk', $type, true);
        return $this;
    }



    /**
     * 一个响应首部，允许发送方在分块发送的消息后面添加额外的元信息，这些元信息可能是随着消息主体的发送动态生成的，比如消息的完整性校验，消息的数字签名，或者消息经过处理之后的最终状态等。
     * 请求首部 TE 需要设置trailers来允许挂载字段。
     *
     * 语法
     * Trailer: header-names
     *
     * 指令
     * header-names
     *     出现在分块信息挂载部分的消息首部。以下首部字段不允许出现：
     *         用于信息分帧的首部 (例如Transfer-Encoding 和  Content-Length),
     *         用于路由用途的首部 (例如 Host)，
     *         请求修饰首部 (例如控制类和条件类的，如Cache-Control，Max-Forwards，或者 TE)，
     *         身份验证首部 (例如 Authorization 或者 Set-Cookie)，
     *         Content-Encoding, Content-Type, Content-Range，以及 Trailer 自身。
     *
     * 在这个例子中, Expires 首部出现在分块信息的结尾，作为挂载（trailer）首部。
     * HTTP/1.1 200 OK
     * Content-Type: text/plain
     * Transfer-Encoding: chunked
     * Trailer: Expires
     *
     * 7\r\n
     * Mozilla\r\n
     * 9\r\n
     * Developer\r\n
     * 7\r\n
     * Network\r\n
     * 0\r\n
     * Expires: Wed, 21 Oct 2015 07:28:00 GMT\r\n
     * \r\n
     *
     * @param string $header
     * @return HeaderHelp $this
     */
    public function setTrailer(string $header):HeaderHelp
    {
        $this->_transformation('Trailer', $header, true);
        return $this;
    }

    /**
     * 消息首部指明了将 entity 安全传递给用户所采用的编码形式。
     *
     * 语法
     * Transfer-Encoding: chunked
     * Transfer-Encoding: compress
     * Transfer-Encoding: deflate
     * Transfer-Encoding: gzip
     * Transfer-Encoding: identity
     *
     * // Several values can be listed, separated by a comma
     * Transfer-Encoding: gzip, chunked
     *
     * 指令
     * chunked
     *     数据以一系列分块的形式进行发送。 Content-Length 首部在这种情况下不被发送。。在每一个分块的开头需要添加当前分块的长度，以十六进制的形式表示，后面紧跟着 '\r\n' ，之后是分块本身，后面也是'\r\n' 。终止块是一个常规的分块，不同之处在于其长度为0。终止块后面是一个挂载（trailer），由一系列（或者为空）的实体消息首部构成。
     * compress
     *     采用 Lempel-Ziv-Welch (LZW) 压缩算法。这个名称来自UNIX系统的 compress 程序，该程序实现了前述算法。
     *     与其同名程序已经在大部分UNIX发行版中消失一样，这种内容编码方式已经被大部分浏览器弃用，部分因为专利问题（这项专利在2003年到期）。
     * deflate
     *     采用 zlib 结构 (在 RFC 1950 中规定)，和 deflate 压缩算法(在 RFC 1951 中规定)。
     * gzip
     *     表示采用  Lempel-Ziv coding (LZ77) 压缩算法，以及32位CRC校验的编码方式。这个编码方式最初由 UNIX 平台上的 gzip 程序采用。处于兼容性的考虑， HTTP/1.1 标准提议支持这种编码方式的服务器应该识别作为别名的 x-gzip 指令。
     * identity
     *     用于指代自身（例如：未经过压缩和修改）。除非特别指明，这个标记始终可以被接受。
     *
     * @param string $type
     * @return HeaderHelp $this
     */
    public function setTransferEncoding(string $type):HeaderHelp
    {
        $this->_transformation('Transfer-Encoding', $type, true);
        return $this;
    }




    /**
     * 请求首部，用来向服务器端发送信号，表示客户端优先选择加密及带有身份验证的响应，并且它可以成功处理 upgrade-insecure-requests CSP 指令
     *
     * 语法
     * Upgrade-Insecure-Requests: 1
     *
     * 示例
     * 客户端向服务器端发送信号表示它支持 upgrade-insecure-requests 的升级机制：
     * GET / HTTP/1.1
     * Host: example.com
     * Upgrade-Insecure-Requests: 1
     *
     * 服务器现在可以重定向到这个站点的安全版本。在响应中可以添加一个 Vary  首部，这样的话，响应就不会被缓存服务器提供给不支持升级机制的客户端了。
     * Location: https://example.com/
     * Vary: Upgrade-Insecure-Requests
     *
     * @param string $data   1
     * @return HeaderHelp $this
     */
    public function setUpgradeInsecureRequests(string $data):HeaderHelp
    {
        if($data === 1){
            $this->_transformation('Upgrade-Insecure-Requests', $data, true);
        }
        return $this;
    }

    /**
     * 升级标头可用于将已建立的客户端/服务器连接升级到不同的协议（通过相同的传输协议）
     *
     * 语法
     * Connection: upgrade
     * Upgrade: protocol_name[/protocol_version]
     *
     * 升级类型的连接头必须始终与升级头一起发送（如上所示）。
     * 协议按首选项降序排列，以逗号分隔。协议版本是可选的
     * Connection: upgrade
     * Upgrade: a_protocol/1, example ,another_protocol/2.2
     *
     * Connection: upgrade
     * Upgrade: HTTP/2.0, SHTTP/1.3, IRC/6.9, RTA/x11
     *
     * Connection: Upgrade
     * Upgrade: websocket
     *
     * @param string $data   HTTP/2.0, SHTTP/1.3, IRC/6.9, RTA/x11
     * @return HeaderHelp $this
     */
    public function setUpgrade(string $data):HeaderHelp
    {
        $this->_transformation('Connection', 'Upgrade', true);
        $this->_transformation('Upgrade', $data, true);
        return $this;
    }




    /**
     * 用来让网络协议的对端来识别发起请求的用户代理软件的应用类型、操作系统、软件开发商以及版本号。
     * User-Agent: <product> / <product-version> <comment>
     * <product>   产品识别码。
     * <product-version>  产品版本号。
     * <comment>  零个或多个关于组成产品信息的注释。
     * 浏览器： User-Agent: Mozilla/<version> (<system-information>) <platform> (<platform-details>) <extensions>
     *
     *
     * Mozilla/5.0 (platform; rv:geckoversion) Gecko/geckotrail Firefox/firefoxversion  //Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0
     * Chrome UA 字符串     Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36
     * 爬虫和机器人的 UA 字符串  Googlebot/2.1 (+http://www.google.com/bot.html)
     *
     * @param string $agent  timeout=5, max=1000
     * @return HeaderHelp $this
     */
    public function setUserAgent($agent):HeaderHelp
    {
        $this->_transformation('User-Agent', $agent, true);
        return $this;
    }



    /**
     * 响应头部信息，它决定了对于未来的一个请求头，应该用一个缓存的回复(response)还是向源服务器请求一个新的回复。它被服务器用来表明在 content negotiation algorithm（内容协商算法）中选择一个资源代表的时候应该使用哪些头部信息（headers）.
     * 在响应状态码为 304 Not Modified  的响应中，也要设置 Vary 首部，而且要与相应的 200 OK 响应设置得一模一样。
     *
     * 语法
     * Vary: *
     * Vary: <header-name>, <header-name>, ...
     *
     * 说明
     * *
     *     所有的请求都被视为唯一并且非缓存的，使用Cache-Control: no-store,来实现则更适用，这样用于说明不存储该对象更加清晰。
     * <header-name>
     *      逗号分隔的一系列http头部名称，用于确定缓存是否可用。
     *
     * 例子
     * 动态服务
     * 哪种情况下使用 Vary: 对于User-Agent 头部信息，例如你提供给移动端的内容是不同的，可用防止你客户端误使用了用于桌面端的缓存。 并可帮助Google和其他搜索引擎来发现你的移动端版本的页面，同时告知他们不需要Cloaking。
     * Vary: User-Agent
     *
     * @param string $data   User-Agent
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setVary(string $data, bool $reset = false):HeaderHelp
    {
        $this->_transformation('Vary', $data, $reset);
        return $this;
    }



    /**
     * 是一个通用首部，是由代理服务器添加的，适用于正向和反向代理，在请求和响应首部中均可出现。这个消息首部可以用来追踪消息转发情况，防止循环请求，以及识别在请求或响应传递链中消息发送者对于协议的支持能力。
     *
     * 语法
     * Via: [ <protocol-name> "/" ] <protocol-version> <host> [ ":" <port> ]
     * or
     * Via: [ <protocol-name> "/" ] <protocol-version> <pseudonym>
     *
     * 指令
     * <protocol-name>
     *     可选。所使用的协议名称，如 "HTTP"。
     * <protocol-version>
     *     所使用的协议版本号， 例如 "1.1"。
     * <host> and <port>
     *     公共代理的URL及端口号。
     * <pseudonym>
     *     内部代理的名称或别名。
     *
     * 示例
     * Via: 1.1 vegur
     * Via: HTTP/1.1 GWA
     * Via: 1.0 fred, 1.1 p.example.net
     *
     * @param string $data   HTTP/1.1 GWA
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setVia(string $data, bool $reset = false):HeaderHelp
    {
        $this->_transformation('Via', $data, $reset);
        return $this;
    }






    /**
     * Want Digest HTTP头主要用于HTTP请求中，要求服务器使用Digest response头提供请求资源的摘要。
     *
     * 语法
     * Want-Digest: <digest-algorithm>
     * // Multiple algorithms, weighted with the quality value syntax:
     * Want-Digest: <digest-algorithm><q-value>,<digest-algorithm><q-value>
     *
     * 指令
     * <digest-algorithm>
     *     已支持的摘要算法在 RFC 3230 和 RFC 5843,中定义，包括 SHA-256 和 SHA-512。一些支持的算法(如 unixsum 和 MD5) 容易发生冲突，因此不适合冲突阻力很重要的应用。
     *
     * Want-Digest: sha-256
     * Want-Digest: SHA-512;q=0.3, sha-256;q=1, md5;q=0
     *
     * @param string $data  SHA-512;q=0.3, sha-256;q=1, md5;q=0
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setWantDigest(string $data, bool $reset = false):HeaderHelp
    {
        $this->_transformation('Want-Digest', $data, $reset);
        return $this;
    }






    /**
     * Warning 是一个通用报文首部，包含报文当前状态可能存在的问题。在响应中可以出现多个 Warning 首部。
     *
     * 语法
     * Warning: <warn-code> <warn-agent> <warn-text> [<warn-date>]
     *
     * 指令
     * <warn-code>
     *     三位数字警告码。第一位数字表示 Warning 信息在验证之后是否需要从已存储的响应中删除。
     *         1xx 警告码描述了关于当前响应的新鲜度或者验证状态的警告信息，并且将会在验证之后被缓存服务器删除。
     *         2xx 警告码描述了验证之后不会被修复的某些展现内容方面的警告信息，并且在验证之后不会被缓存服务器删除。
     * <warn-agent>
     *     添加到 Warning 首部的服务器或者软件的名称或者伪名称（当代理不可知的时候可以用 "-" 代替）。
     * <warn-text>
     *     用来描述错误信息的警告文本。
     * <warn-date>
     *     可选。假如多个 Warning 被发送，那么需包含一个与 Date 首部相对应的日期字段。
     *
     * 警告码
     * 由 iana.org 维护的 HTTP 警告码登记表规定了警告码的命名空间。
     * 码值 	文字描述 	详细说明
     * 110 	Response is Stale 	由缓存服务器提供的响应已过期（设置的失效时间已过）。
     * 111 	Revalidation Failed 	 由于无法访问服务器，响应验证失败。
     * 112 	Disconnected Operation 	缓存服务器断开连接。
     * 113 	Heuristic Expiration 	如果缓存服务器采用启发式方法，将缓存的有效时间设定为24小时，而在该响应的年龄超过24小时时发送。
     * 199 	Miscellaneous Warning 	任意的、未明确指定的警告信息。
     * 214 	Transformation Applied 	由代理服务器添加，如果它对返回的展现内容进行了任何转换，比如改变了内容编码、媒体类型等。
     * 299 	Miscellaneous Warning 	与199类似，只不过指代的是持久化警告。
     *
     * 示例
     * Warning: 110 anderson/1.3.37 "Response is stale"
     *
     * Date: Wed, 21 Oct 2015 07:28:00 GMT
     * Warning: 112 - "cache down" "Wed, 21 Oct 2015 07:28:00 GMT"
     *
     * @param string $data  112 - "cache down" "Wed, 21 Oct 2015 07:28:00 GMT"
     * @param bool $reset 覆盖先前的内容 true覆盖，false拼接
     * @return HeaderHelp $this
     */
    public function setWarning(string $data, bool $reset = false):HeaderHelp
    {
        $this->_transformation('Warning', $data, $reset);
        return $this;
    }





    /**
     * 响应头定义了使用何种验证方式去获取对资源的连接。
     * WWW-Authenticate header通常会和一个 401 Unauthorized 的响应一同被发送。
     *
     * 语法
     * WWW-Authenticate: <type> realm=<realm>
     *
     * 指令
     * <type>
     *     Authentication type，一个通用类型 "Basic"。 IANA 维护了一个 list of Authentication schemes。
     * realm=<realm>
     *     一个保护区域的描述。如果未指定realm, 客户端通常显示一个格式化的主机名来替代。
     * charset=<charset>
     *     当提交用户名和密码时，告知客户端服务器首选的编码方案。唯一的允许值是不区分大小写的字符串"UTF-8"。这与realm字符串的编码无关。
     *
     * 示例
     * 通常的, 一个服务器响应包含一个像如下WWW-Authenticate的头信息：
     * WWW-Authenticate: Basic
     * WWW-Authenticate: Basic realm="Access to the staging site"
     * 作为一个例子，可以查看 HTTP authentication 页面，了解如何配置Apache和nginx服务器来使用HTTP basic authentication密码保护你的站点。
     *
     * @param string $data  Basic realm="Access to the staging site"
     * @return HeaderHelp $this
     */
    public function setWWWAuthenticate(string $data):HeaderHelp
    {
        $this->_transformation('WWW-Authenticate', $data, true);
        return $this;
    }





    /**
     * HTTP 消息头相当于一个提示标志，被服务器用来提示客户端一定要遵循在 Content-Type 首部中对  MIME 类型 的设定，而不能对其进行修改。这就禁用了客户端的 MIME 类型嗅探行为，换句话说，也就是意味着网站管理员确定自己的设置没有问题。
     *
     * 语法
     * X-Content-Type-Options: nosniff
     *
     * 指令
     * nosniff
     *     下面两种情况的请求将被阻止：
     *         请求类型是"style" 但是 MIME 类型不是 "text/css"，
     *         请求类型是"script" 但是 MIME 类型不是  JavaScript MIME 类型。
     *
     * @param string $type  nosniff
     * @return HeaderHelp $this
     */
    public function setXContentTypeOptions(string $type):HeaderHelp
    {
        if($type === 'nosniff'){
            $this->_transformation('X-Content-Type-Options', $type, true);
        }
        return $this;
    }


    /**
     * 控制着浏览器的 DNS 预读取功能。 DNS 预读取是一项使浏览器主动去执行域名解析的功能，其范围包括文档的所有链接，无论是图片的，CSS 的，还是 JavaScript 等其他用户能够点击的 URL。
     * 在浏览器中设置预读取配置
     * 一般来说并不需要去管理预读取，但是可能会有用户希望关闭预读取功能。这时只需要将 network.dns.disablePrefetch 选项值设置为 true 就可以了。
     * 另外，默认情况下，通过 HTTPS 加载的页面上内嵌链接的域名并不会执行预加载。在 Firefox 浏览器中，可以通过 about:config 设置 network.dns.disablePrefetchFromHTTPS 值为 false 来改变这一默认行为。
     *
     *
     * 语法
     * X-DNS-Prefetch-Control: on
     * X-DNS-Prefetch-Control: off
     * 参数
     * on   启用 DNS 预解析。在浏览器支持 DNS 预解析的特性时即使不使用该标签浏览器依然会进行预解析。
     * off  关闭 DNS 预解析。这个属性在页面上的链接并不是由你控制的或是你根本不想向这些域名引导数据时是非常有用的。
     *
     * <meta http-equiv="x-dns-prefetch-control" content="off">
     *
     * 强制查询特定主机名
     * 你可以通过使用 rel 属性值为 link type 中的 dns-prefetch 的 <link> 标签来对特定域名进行预读取：
     * <link rel="dns-prefetch" href="http://www.spreadfirefox.com/">
     * 在这个例子中，Firefox 将预解析域名"www.spreadfirefox.com"。
     * 而且，<link> 元素也可以使用不完整的 URL 的主机名来标记预解析，但这些主机名前必需要有双斜线：
     * <link rel="dns-prefetch" href="//www.spreadfirefox.com">
     * 强制对域名进行预读取在一些情况下很有用, 比如, 在网站的主页上，强制在整个网站上频繁引用的域名的预解析，即使它们不在主页本身上使用。即使主页的性能可能不受影响，这将提高整体站点性能。
     *
     * @param string $type  on | of
     * @return HeaderHelp $this
     */
    public function setXDNSPrefetchControl(string $type):HeaderHelp
    {
        if($type === 'on' || $type === 'of'){
            $this->_transformation('X-DNS-Prefetch-Control', $type, true);
        }
        return $this;
    }




    /**
     * 响应头是用来给浏览器 指示允许一个页面 可否在 <frame>, <iframe>, <embed> 或者 <object> 中展现的标记。站点可以通过确保网站没有被嵌入到别人的站点里面，从而避免 clickjacking 攻击。
     *
     * 语法
     * X-Frame-Options 有三个可能的值：
     * X-Frame-Options: deny
     * X-Frame-Options: sameorigin
     * X-Frame-Options: allow-from https://example.com/
     *
     * 指南
     * 换一句话说，如果设置为 deny，不光在别人的网站 frame 嵌入时会无法加载，在同域名页面中同样会无法加载。另一方面，如果设置为sameorigin，那么页面就可以在同域名页面的 frame 中嵌套。
     * deny
     *     表示该页面不允许在 frame 中展示，即便是在相同域名的页面中嵌套也不允许。
     * sameorigin
     *     表示该页面可以在相同域名页面的 frame 中展示。
     * allow-from uri
     *     表示该页面可以在指定来源的 frame 中展示。
     *
     * 例子
     * Note: 设置 meta 标签是无效的！例如 <meta http-equiv="X-Frame-Options" content="deny"> 没有任何效果。不要这样用！只有当像下面示例那样设置 HTTP 头 X-Frame-Options 才会生效。
     *
     *
     * 配置 Apache 在所有页面上发送 X-Frame-Options 响应头，需要把下面这行添加到 'site' 的配置中:
     * Header always set X-Frame-Options "sameorigin"
     * 要将 Apache 的配置 X-Frame-Options 设置成 deny , 按如下配置去设置你的站点：
     * Header set X-Frame-Options "deny"
     * 要将 Apache 的配置 X-Frame-Options 设置成 allow-from，在配置里添加：
     * Header set X-Frame-Options "allow-from https://example.com/"
     *
     *
     * 配置 nginx
     * 配置 nginx 发送 X-Frame-Options 响应头，把下面这行添加到 'http', 'server' 或者 'location' 的配置中:
     * add_header X-Frame-Options sameorigin always;
     *
     * @param string $type  deny | sameorigin | allow-from uri
     * @return HeaderHelp $this
     */
    public function setXFrameOptions(string $type):HeaderHelp
    {
        if($type === 'deny' || $type === 'sameorigin' || stripos($type,'allow-from ') === 0){
            $this->_transformation('X-Frame-Options', $type, true);
        }
        return $this;
    }




    /**
     * 响应头是 Internet Explorer，Chrome 和 Safari 的一个特性，当检测到跨站脚本攻击 (XSS (en-US))时，浏览器将停止加载页面。若网站设置了良好的 Content-Security-Policy 来禁用内联 JavaScript ('unsafe-inline')，现代浏览器不太需要这些保护， 但其仍然可以为尚不支持 CSP 的旧版浏览器的用户提供保护。
     * 
     * 语法
     * X-XSS-Protection: 0
     * X-XSS-Protection: 1
     * X-XSS-Protection: 1; mode=block
     * X-XSS-Protection: 1; report=<reporting-uri>
     * 
     * 0    禁止XSS过滤。
     * 1    启用XSS过滤（通常浏览器是默认的）。 如果检测到跨站脚本攻击，浏览器将清除页面（删除不安全的部分）。
     * 1;mode=block
     *     启用XSS过滤。 如果检测到攻击，浏览器将不会清除页面，而是阻止页面加载。
     * 1; report=<reporting-URI>  (Chromium only)
     *     启用XSS过滤。 如果检测到跨站脚本攻击，浏览器将清除页面并使用CSP report-uri (en-US)指令的功能发送违规报告。
     * 
     * 范例
     * 当检测到XSS攻击时阻止页面加载：
     * X-XSS-Protection: 1;mode=block
     * 
     * PHP
     * header("X-XSS-Protection: 1; mode=block");
     * 
     * Apache (.htaccess)
     * <IfModule mod_headers.c>
     *   Header set X-XSS-Protection "1; mode=block"
     * </IfModule>
     * 
     * Nginx
     * add_header "X-XSS-Protection" "1; mode=block";
     *
     * @param string $type  on | of
     * @return HeaderHelp $this
     */
    public function setXXSSProtection(string $type):HeaderHelp
    {
        if($type === 'on' || $type === 'of'){
            $this->_transformation('X-XSS-Protection', $type, true);
        }
        return $this;
    }



}












