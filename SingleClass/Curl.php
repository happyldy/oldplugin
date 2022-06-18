<?php
/**
 * 获取请求地址参数
 */


namespace HappyLin\OldPlugin\SingleClass;

use HappyLin\OldPlugin\SingleClass\FileSystem\Fileinfo\FInfo;


class Curl
{

    /**
     * curl_setopt 其他选项
     * @var array 
     */
    private $extraOptions = [];


    /**
     * 清除curl 公共选项
     * @return $this
     */
    public function clearExtraOptions():Curl
    {
        $this->extraOptions = [];
        return $this;
    }


    /**
     * post提交数据
     * @param $url  URL地址
     * @param string|array $param 请求参数
     * @param false $useCert 使用证书
     * @return bool|string
     */
    public function curlPost(string $url, $param, $useCert = false)
    {

        if (empty($url) || empty($param)) return false;

        $ch = curl_init();

        // 需要获取的 URL 地址，也可以在curl_init() 初始化会话的时候
        curl_setopt($ch, CURLOPT_URL, $url);
        // TRUE 时会发送 POST 请求，类型为：application/x-www-form-urlencoded
        curl_setopt($ch, CURLOPT_POST, 1);
        // 如果value是一个数组，Content-Type头将会被设置成multipart/form-data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        // 允许 cURL 函数执行的最长秒数
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        // TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 启用时会将头文件的信息作为数据流输出。
        curl_setopt($ch, CURLOPT_HEADER, 0);


        // 添加额外选项
        if (!empty($this->extraOptions)) {
            curl_setopt_array($ch, $this->extraOptions);
        }

        $result = curl_exec($ch);

        if (!$result) {
            $errno = curl_errno($ch);
            $errmes = curl_error($ch);
            curl_close($ch);
            throw new \UnexpectedValueException("curl出错:{$errmes}，错误码:{$errno}");
        }
        curl_close($ch);
        return $result;

    }

    /**
     * get获取数据
     * @param string $url URL地址
     * @param array $param 参数
     * @return bool|string
     */
    public function curlGet(string $url, array $param = [])
    {

        $ch = curl_init();

        // 需要获取的 URL 地址，也可以在curl_init() 初始化会话的时候
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($param));
        // TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 启用时会将头文件的信息作为数据流输出。
        curl_setopt($ch, CURLOPT_HEADER, 0);


        // 添加额外选项
        if (!empty($this->extraOptions)) {
            curl_setopt_array($ch, $this->extraOptions);
        }

        $result = curl_exec($ch);

        if (!$result) {
            $errno = curl_errno($ch);
            $errmes = curl_error($ch);
            curl_close($ch);
            throw new \UnexpectedValueException("curl出错:{$errmes}，错误码:{$errno}");
        }
        curl_close($ch);
        return $result;
    }
    
    
    
    

    /**
     * 批量请求数据
     * @param array $urls
     * @param string $callback
     * @param array $post_data
     * @return array
     */
    public function multiPostCurl($urls = array(), $callback = null, $post_data = array()): array
    {

        $response = array();

        if (empty($urls)) {
            return $response;
        }
        // 一个新cURL批处理句柄
        $chs = curl_multi_init();

        foreach ($urls as $url) {
            $ch = curl_init();
            // 需要获取的 URL 地址，也可以在curl_init() 初始化会话的时候
            curl_setopt($ch, CURLOPT_URL, $url);
            // TRUE 时会发送 POST 请求，类型为：application/x-www-form-urlencoded
            curl_setopt($ch, CURLOPT_POST, 1);
            // 如果value是一个数组，Content-Type头将会被设置成multipart/form-data
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            // 允许 cURL 函数执行的最长秒数
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            // TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // 启用时会将头文件的信息作为数据流输出。
            curl_setopt($ch, CURLOPT_HEADER, 0);


            // TRUE 时忽略所有的 cURL 传递给 PHP 进行的信号。在 SAPI 多线程传输时此项被默认启用，所以超时选项仍能使用。
            curl_setopt($ch, CURLOPT_NOSIGNAL, true);

            // 添加额外选项
            if (!empty($this->extraOptions)) {
                curl_setopt_array($ch, $this->extraOptions);
            }

            // 向curl批处理会话中添加单独的curl句柄
            curl_multi_add_handle($chs, $ch);

        }


        do {
            // 运行当前 cURL 句柄的子连接;  $active:一个用来判断操作是否仍在执行的标识的引用
            if (($status = curl_multi_exec($chs, $active)) != CURLM_CALL_MULTI_PERFORM) {

                // 如果没有准备就绪，就再次调用curl_multi_exec
                if ($status != CURLM_OK) {
                    break;
                }

                //  查询批处理句柄是否单独的传输线程中有消息或信息返回; 重复调用这个函数，它每次都会返回一个新的结果; 通过msgs_in_queue返回的整数指出将会包含当这次函数被调用后，还剩余的消息数。
                while ($info = curl_multi_info_read($chs, $msgs_in_queue)) {

                    // 获取最后一次传输的相关信息
                    $option = curl_getinfo($info["handle"]);
                    // 返回当前会话最后一次错误的字符串
                    $error = curl_error($info["handle"]);
                    // 如果设置了CURLOPT_RETURNTRANSFER，则返回获取的输出的文本流
                    $result = curl_multi_getcontent($info["handle"]);

                    $rtn = compact('option', 'error', 'result', 'url');

                    // 调用回调函数
                    if ($callback) {
                        $callback($rtn);
                    }

                    $response[] = $rtn;

                    // 从给定的批处理句柄mh中移除ch句柄。当ch句柄被移除以后，仍然可以合法地用curl_exec()执行这个句柄。如果要移除的句柄正在被使用，则这个句柄涉及的所有传输任务会被中止。
                    curl_multi_remove_handle($chs, $info['handle']);
                    // 关闭 cURL 会话并且释放所有资源。cURL 句柄 ch 也会被删除。
                    curl_close($info['handle']);

                    //如果仍然有未处理完毕的句柄，那么就select
                    if ($active > 0) {
                        // 阻塞直到cURL批处理连接中有活动连接; timeout 以秒为单位，等待响应的时间
                        curl_multi_select($chs, 1);
                    }
                }

            }
        } while ($active > 0); //还有句柄处理还在进行中

        // 关闭一组cURL句柄
        curl_multi_close($chs);
        return $response;

    }


    /**
     * HTTP请求头中"Accept-Encoding: "的值。这使得能够解码响应的内容。支持的编码有"identity"，"deflate"和"gzip"。如果为空字符串""，会发送所有支持的编码类型。
     * 
     * gzip,      表示采用 Lempel-Ziv coding (LZ77) 压缩算法，以及32位CRC校验的编码方式。
     * compress,  采用 Lempel-Ziv-Welch (LZW) 压缩算法。
     * deflate,   采用 zlib 结构和 deflate 压缩算法。
     * br,        表示采用 Brotli 算法的编码方式。
     * identity,  用于指代自身（例如：未经过压缩和修改）。除非特别指明，这个标记始终可以被接受
     * *,         匹配其他任意未在该请求头字段中列出的编码方式。假如该请求头字段不存在的话，这个值是默认值。它并不代表任意算法都支持，而仅仅表示算法之间无优先次序。
     * ;q= (qvalues weighting), // 值代表优先顺序，用相对质量价值 表示，又称为权重。
     * 
     * @param string $type 格式： 'gzip,deflate' ； 'identity' 等等
     * @return $this
     */
    public function setEncoding(string $type='')
    {
        $this->extraOptions[CURLOPT_ENCODING] = $type;
        return $this;

    }


    /**
     * 设置 HTTP 头字段的数组。
     * @param array $header 格式： array('Content-type: text/plain', 'Content-length: 100')
     * @return $this
     */
    public function setHeader(array $header = []): Curl
    {
        if (empty($header)) {
            $header = array(
//                'Content-type: text/plain', 
//                'Content-length: 100',
                "Connection: Keep-Alive",
                "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
                "Pragma: no-cache",
                "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3",
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0",
                           
            );
        }
        // 设置 HTTP 头字段的数组。格式： array('Content-type: text/plain', 'Content-length: 100')
        $this->extraOptions[CURLOPT_HTTPHEADER] = $header;
        // TRUE 时将根据 Location: 重定向时，自动设置 header 中的Referer:信息。
        $this->extraOptions[CURLOPT_AUTOREFERER] = true;
        return $this;
    }


    /**
     * 验证对等ca证书
     * @param bool $verify 默认不验证
     * @param string|null $caCert ca证书地址
     * @return $this
     */
    public function setSSLVerify(bool $verify = false, string $caCert = null): Curl
    {
        if ($verify) {

            if(!$caCert){
                throw new \InvalidArgumentException('The certificate file address is missing');
            }

            if(!is_file($caCert)){
                throw new \InvalidArgumentException('The certificate file address does not exist');
            }

            
            // FALSE 禁止 cURL 验证对等ca证书（peer'scertificate）。要验证的交换证书可以在 CURLOPT_CAINFO 选项中设置，或在 CURLOPT_CAPATH中设置证书目录
            $this->extraOptions[CURLOPT_SSL_VERIFYPEER] = true;
            // 是检查服务器SSL证书中是否存在一个公用名(common name); 设置成 2，会检查公用名是否存在，并且是否与提供的主机名匹配。 0 为不检查名称。在生产环境中，这个值应该是 2（默认值）。
            $this->extraOptions[CURLOPT_SSL_VERIFYHOST] = 2;
            // 一个保存着1个或多个用来让服务端验证的证书的文件名。这个参数仅仅在和CURLOPT_SSL_VERIFYPEER一起使用时才有意义。  CA 证书下载地址：https://curl.haxx.se/docs/caextract.html 页面去选择下载或：https://curl.haxx.se/ca/cacert.pem
            $this->extraOptions[CURLOPT_CAINFO] = $caCert;
//            // 一个保存着多个CA证书的目录。这个选项是和CURLOPT_SSL_VERIFYPEER一起使用的。
//            $this->extraOptions[CURLOPT_CAPATH]= $caCert;
            return $this;
        }

        // FALSE 禁止 cURL 验证对等ca证书（peer'scertificate）。要验证的交换证书可以在 CURLOPT_CAINFO 选项中设置，或在 CURLOPT_CAPATH中设置证书目录
        $this->extraOptions[CURLOPT_SSL_VERIFYPEER] = false;
        // 是检查服务器SSL证书中是否存在一个公用名(common name); 设置成 2，会检查公用名是否存在，并且是否与提供的主机名匹配。 0 为不检查名称。在生产环境中，这个值应该是 2（默认值）。
        $this->extraOptions[CURLOPT_SSL_VERIFYHOST] = false;

        return $this;
    }


    /**
     * 使用cookie
     * @param string $cookieFile cookie文件路劲
     * @param bool $cookieSession 设为 TRUE 时将开启新的一次 cookie 会话。它将强制 libcurl 忽略之前会话时存的其他
     * @param string|null $strCookie 设定 HTTP 请求中"Cookie: "部分的内容
     * @return Curl
     */
    public function setCookieJar(string $cookieFile, bool $cookieSession = false, string $strCookie = null): Curl
    {

        // 连接结束后，比如，调用 curl_close 后，保存 cookie 信息的文件
        $this->extraOptions[CURLOPT_COOKIEJAR] = $cookieFile;
        // 包含 cookie 数据的文件名，cookie 文件的格式可以是 Netscape 格式，或者只是纯 HTTP 头部风格，存入文件
        $this->extraOptions[CURLOPT_COOKIEFILE] = $cookieFile;

        if ($strCookie) {
            // 设定 HTTP 请求中"Cookie: "部分的内容。多个 cookie 用分号分隔，分号后带一个空格(例如， "fruit=apple; colour=red")。
            $this->extraOptions[CURLOPT_COOKIEFILE] = $strCookie;
        }

        // 设为 TRUE 时将开启新的一次 cookie 会话。它将强制 libcurl 忽略之前会话时存的其他 cookie。 libcurl 在默认状况下无论是否为会话，都会储存、加载所有 cookie
        $this->extraOptions[CURLOPT_COOKIESESSION] = $cookieSession;

        return $this;

    }


    /**
     * 证书双向认证
     * @param $SSLCertPath 证书绝对地址
     * @param $SSLKeyPath 私钥绝对地址
     * @return $this
     */
    public function setSSLCert($SSLCertPath, $SSLKeyPath): Curl
    {
        // 证书的类型。支持的格式有"PEM" (默认值), "DER"和"ENG"。
        $this->extraOptions[CURLOPT_SSLCERTTYPE] = 'PEM';
        // 一个包含 PEM 格式证书的文件名。
        $this->extraOptions[CURLOPT_SSLCERT] = $SSLCertPath;
        // CURLOPT_SSLKEY中规定的私钥的加密类型，支持的密钥类型为"PEM"(默认值)、"DER"和"ENG"。
        $this->extraOptions[CURLOPT_SSLKEYTYPE] = 'PEM';
        // 证书的类型。支持的格式有"PEM" (默认值), "DER"和"ENG"。
        $this->extraOptions[CURLOPT_SSLKEY] = $SSLKeyPath;
        return $this;

    }


    /**
     * 是否根据服务器返回 HTTP 头中的 "Location: " 重定向
     * @param bool $follow 是否重定向
     * @param int $num 最大重定向次数
     * @return $this
     */
    public function setFollowLocation(bool $follow, int $num = 5): Curl
    {
        if ($follow) {
            // TRUE 时将会根据服务器返回 HTTP 头中的 "Location: " 重定向。（注意：这是递归的，"Location: " 发送几次就重定向几次，除非设置了 CURLOPT_MAXREDIRS，限制最大重定向次数。）。
            $this->extraOptions[CURLOPT_FOLLOWLOCATION] = $follow;
            $this->extraOptions[CURLOPT_MAXREDIRS] = $num;
            return $this;
        }
        // TRUE 时将会根据服务器返回 HTTP 头中的 "Location: " 重定向。（注意：这是递归的，"Location: " 发送几次就重定向几次，除非设置了 CURLOPT_MAXREDIRS，限制最大重定向次数。）。
        $this->extraOptions[CURLOPT_FOLLOWLOCATION] = $follow;

        return $this;
    }


    /**
     * 与选项 CURLOPT_POSTFIELDS 一同使用用于上传文件
     *
     * @param $filename 文件路劲
     * @param null $postname 上传数据中的文件名称
     * @param null $mimetype 文件的 MIME type。
     * @return CURLFile
     */
    public function fileSerialize($filename, $postname = null, $mimetype = null): CURLFile
    {
        if (!is_file($filename)) {
            throw new \InvalidArgumentException('file does not exist');
        }

        if (!$postname) {
            // 返回路径中的文件名部分
            $postname = basename($filename);
        }
        if (!$mimetype) {
            // 检测文件的 MIME 类型
            $mimetype = FInfo::getInstance($filename)->getMimeType();
            if (!$mimetype) {
                throw new \UnexpectedValueException('Failed to detect MIME type of file');
            }
        }
        return new CURLFile($filename, $mimetype, $postname);
    }


    /**
     * 输出xml字符
     * @param array $xml
     * @return string
     */
    public function ToXml(array $xml): string
    {
        if (count($this->values) <= 0) {
            throw new WxPayException("数组数据异常！");
        }

        $xml = "<xml>";
        foreach ($this->values as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * 将xml转为array
     * @param string $xml
     * @return array
     */
    public function FromXml(string $xml): array
    {
        if (!$xml) {
            throw new \InvalidArgumentException("xml数据异常！");
        }
        // 获取格式正确的 XML 字符串并将其作为对象返回。
        $this->values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $this->values;
    }


}












