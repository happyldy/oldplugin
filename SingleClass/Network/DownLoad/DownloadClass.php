<?php
/**
 *
 *
 *
 * output_buffering = 4096          PHP_INI_PERDIR  输出缓冲是一种控制输出数据量的机制（不包括标题和cookie）在推送之前，PHP应该在内部保留将数据发送到客户端。如果应用程序的输出超过此设置，PHP将以大约您指定的大小的块发送该数据。
 * zlib.output_compression = Off    PHP_INI_ALL     使用 zlib 库进行透明输出压缩; 注意：您需要使用 zlib.output_handler 而不是标准output_handler，否则输出将被破坏。
 *
 */

namespace HappyLin\OldPlugin\SingleClass\Network\Download;

use HappyLin\OldPlugin\SingleClass\Network\HeaderHelp;
use HappyLin\OldPlugin\SingleClass\SPL\FileHandling\Shortcut\FileObject;
use OutOfBoundsException;

class DownloadClass
{

    /**
     * 缓冲单元
     */
    const BUFF_SIZE = 4096;//1024 * 4


    /**
     * @var HeaderHelp 对象
     */
    public $headerHelp;


    /**
     * @var FileObject 对象
     */
    public $fileObject;


    /**
     * @var string 输出文件名称
     */
    public $outFileName;


    /**
     * @var string 资源的MIME类型
     */
    public $mimeType;

    /**
     * @var mixed isset($_SERVER['HTTP_RANGE']) ? $_SERVER['HTTP_RANGE'] : 'bytes=0-102400000, 2000-6576, 19000-'; //bytes=200-1000, 2000-6576, 19000-(1024*100000)  |  ['start' => 0; 'end' => 4096]
     */
    public $range;


    /**
     * DownloadClass constructor.
     * @param string $fileName 文件路劲
     * @param string $outFileName 输出文件名称
     * @param string | array $range  例如： bytes=0-102400000；或 ['start' => 0; 'end' => 4096]；
     * @param string|null $mimeType 可指定资源的MIME类型
     */
    public function __construct(string $fileName, string $outFileName='', string $mimeType = null, $range = null)
    {
        $this->headerHelp = HeaderHelp::getInstance();

        $this->fileObject = new FileObject($fileName);

        if(!$this->fileObject->isFile()){
            throw new OutOfBoundsException("the object not references a regular file");
        }

        if($outFileName === ''){
            $outFileName = $this->fileObject->getBasename();
        }
        $this->outFileName = $outFileName;


        $this->mimeType = $this->analyzeMimeType($mimeType);
        $this->range = $this->analyzeRange($range);

    }



    /**
     * 下传整个文件
     */
    public function downloadFile(): void
    {
        // 清空缓冲区，开启一个缓冲；
        ob_end_clean();
        ob_start();

        //$size = $this->fileObject->getSize();
        $size = $this->range['end'] - $this->range['start'];

        // 就不用 readfile 了
        echo $this->fileObject->read();


        // 设置资源的MIME类型
        $this->headerHelp->setContentType($this->mimeType);

        // 设置用来指明发送给接收方的消息主体的大小，即用十进制数字表示的八位元组的数目。
        $this->headerHelp->setContentLength($size);

        // 服务器认定的资源做出修改的日期及时间。由于精确度比  ETag 要低，
        $this->headerHelp->setLastModified(gmdate("D, d M Y h:i:s T ", $this->fileObject->getMTime()));

        // 资源的特定版本的标识符
        $this->headerHelp->setETag(sprintf('w/"%s:%s"', md5($this->fileObject->getMTime()), $size));

        // attachment: 下传到本地;  filename 后面是要传送的文件的初始名称的字符串。
        $this->headerHelp->setContentDisposition(sprintf(' attachment; filename="%s"', $this->outFileName));

        $this->headerHelp->setHttpCode(200);

        ob_end_flush();
    }



    /**
     * 发送大型文件或分段发送; 支持断点续传
     */
    public function downloadLargeFile(): void
    {
        // 清空之前的输出缓存
        ob_end_clean();
        // 启用一个输出缓存
        ob_start();

        $size = $this->range['end'] - $this->range['start'];

        // 设置资源的MIME类型
        $this->headerHelp->setContentType($this->mimeType);

        // 设置用来指明发送给接收方的消息主体的大小，即用十进制数字表示的八位元组的数目。
        $this->headerHelp->setContentLength($size);

        // 服务器认定的资源做出修改的日期及时间。由于精确度比  ETag 要低，
        $this->headerHelp->setLastModified(gmdate("D, d M Y h:i:s T ", $this->fileObject->getMTime()));

        // 资源的特定版本的标识符
        $this->headerHelp->setETag(sprintf('w/"%s:%s"', md5($this->fileObject->getMTime()), $size));

        // 字段值用于定义范围请求的单位
        $this->headerHelp->setAcceptRanges('bytes');

        // 设置显示的是一个数据片段在整个文件中的位置
        $this->headerHelp->setContentRange(sprintf('Content-Range: bytes %s-%s/%s', $this->range['start'], $this->range['end'], $this->fileObject->getSize()));

        // attachment: 下传到本地;  filename 后面是要传送的文件的初始名称的字符串。
        $this->headerHelp->setContentDisposition(sprintf(' attachment; filename="%s"', $this->outFileName));

        $this->headerHelp->setHttpCode(206);

        $this->fileObject->fseek($this->range['start']);

        while (!$this->fileObject->eof() && !connection_aborted())
        {
            // 文件流中下一个偏移量的文件指针的位置。不知道会不会出现不是整数问题，用 BCMath 函数吧
            $lastSize = sprintf(
                "%u",
                bcsub(
                    $this->fileObject->getSize(),
                    sprintf("%u", $this->fileObject->ftell())
                )
            );

            // 如果大于一个缓冲单元
            if (bccomp($lastSize, self::BUFF_SIZE) > 0) {
                $lastSize = self::BUFF_SIZE;
            }

            echo $this->fileObject->fread($lastSize);

            ob_flush();
            flush();

            // $file->fread($file->getSize())； $file->eof() 还是false没办法； 但是$file->fgetc()返回false; 无语；
            if($lastSize >= $this->fileObject->getSize()){
                break;
            }

            // 测试限制下载速度
            time_nanosleep( 0, 300000000);
        }

        ob_end_flush();
    }




    /**
     * 直接下传字符串
     *
     * @param string $content 要下传的字符串内容
     * @param string $outFileName 输出文件名； 输出内容时此项必选
     */
    public static function downloadString(string $content, string $outFileName): void
    {
        // 清空之前的输出缓存
        ob_end_clean();
        // 启用一个输出缓存
        ob_start();

        $headerHelp = HeaderHelp::getInstance();

        $size = strlen($content);

        //$fp = new \SplFileObject("php://output","a+");
        //$fp->fwrite($content);

        echo $content;

        // 二进制兼容所有类型
        $headerHelp->setContentType('application/octet-stream');
        // 设置用来指明发送给接收方的消息主体的大小，即用十进制数字表示的八位元组的数目。
        $headerHelp->setContentLength($size);

        // attachment: 下传到本地;  filename 后面是要传送的文件的初始名称的字符串。
        $headerHelp->setContentDisposition(sprintf(' attachment; filename="%s"', $outFileName));

        $headerHelp->setHttpCode(200);

        ob_end_flush();
    }





    /**
     * 获取请求的文件区域
     *
     * @param string $range isset($_SERVER['HTTP_RANGE']) ? $_SERVER['HTTP_RANGE'] : 'bytes=0-102400000, 2000-6576, 19000-'; //bytes=200-1000, 2000-6576, 19000-(1024*100000)
     * @param int $fileSize 文件大小
     * @return array|null
     */
    public function analyzeRange($range)
    {

        if(is_string($range)){

            // 只匹配第一组，空格或逗号后面的剔除
            $range = preg_replace('/[\s|,].*/', '', $range);

            // 剔除 bytes= 按 - 分组
            $range = explode('-', substr($range, 6));

            // 可能：19000- ；-6576 ；
            if (count($range) < 2) {
                $range[1] = $this->fileSize;
            }

            $range = array_combine(array('start', 'end'), $range);

        }else if(!is_array($range)){
            $range = ['start' => 0, 'end'=>$this->fileObject->getSize()];
            return $range;
        }


        if (!isset($range['start'])) {
            $range['start'] = 0;
        }

        if(!is_int($range['start'])){
            $range['start'] = intval($range['start']);
        }

        if (!isset($range['end'])) {
            $range['end'] = $this->fileObject->getSize();
        }

        if(!is_int($range['end'])){
            $range['end'] = intval($range['end']);
        }

        if($range['start'] > $range['end']  || $range['start'] > $this->fileObject->getSize()){
            throw new OutOfBoundsException("Parameter '\$range' has wrong range ");
        }

        return $range;

    }


    /**
     * 查找不到默认 二进制
     */
    public function analyzeMimeType($mimeType)
    {
        if(!empty($mimeType)){
            return trim($mimeType);
        }

        $mimeType = $this->fileObject->getMimeType();
        if(!$mimeType){
            // 二进制兼容所有类型
            $mimeType = 'application/octet-stream';
        }
        return $mimeType;
    }







}












