<?php
/**
 * 'r' 只读方式打开，将文件指针指向文件头。
 * 'r+' 读写方式打开，将文件指针指向文件头。
 * 'w' 写入方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。
 * 'w+' 读写方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。
 * 'a' 写入方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之。
 * 'a+' 读写方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之。
 * 'x' 创建并以写入方式打开，将文件指针指向文件头。如果文件已存在，则 fopen() 调用失败并返回 FALSE，并生成一条 E_WARNING 级别的错误信息。如果文件不存在则尝试创建之。这和给底层的 open(2) 系统调用指定 O_EXCL|O_CREAT 标记是等价的。
 * 'x+' 创建并以读写方式打开，其他的行为和 'x' 一样。
 * 'c' Open the file for writing only. If the file does not exist, it iscreated. If it exists, it is neither truncated (as opposed to 'w'), nor the call to this function fails (as isthe case with 'x'). The file pointer ispositioned on the beginning of the file. This may be useful if it'sdesired to get an advisory lock (see flock())before attempting to modify the file, as using 'w' could truncate the file before the lockwas obtained (if truncation is desired, ftruncate() can be used after the lock isrequested).
 * 'c+' Open the file for reading and writing; otherwise it has the samebehavior as 'c'.
 *
 */


//namespace HappyLin\OldPlugin\SingleClass\FileSystem\FileObject;
namespace HappyLin\OldPlugin\SingleClass\SPL\FileHandling\Shortcut;

use HappyLin\OldPlugin\SingleClass\FileSystem\Fileinfo\FInfo;
use \SplFileObject;


class FileObject extends \SplFileObject
{
    /**
     * 默认的转换模式依赖于 SAPI 和所使用的 PHP 版本，因此为了便于移植鼓励总是指定恰当的标记。如果是操作纯文本文件并在脚本中使用了 \n 作为行结束符，但还要期望这些文件可以被其它应用程序例如 Notepad 读取，则在 mode 中使用 't'。在所有其它情况下使用 'b'。
     */
    const MODE = ['read'=>'rb','write'=>'wb','add'=>'ab'];

    /**
     * 保留 写入字符格式，（加上时间，加上session等等）
     * @var
     */
    private $style;

    /**
     * \SplFileObject 没有获取文件的 MIME 类型的方法；为了它创建 FInfo 对象用来自动获取
     * @var FInfo 对象
     */
    public $fInfo;


    /**
     * 写入数据时；getSize 不会自动更新，这个补充记录
     * （目前只争对$this->write和$this->add）
     * @var int
     */
    public $changeSize = 0;


    /**
     * FileObject constructor.
     * 
     * 改默认为a+;默认r后使用$this->openFile('a+b')无效，因为它是返回新对象;[函数内可以new一个，代替$this，但感觉不好]
     * add完成后去read是看不到实时信息。因为getSize不是最新的，需要自己加上；但用file_get_contents()可以查看到
     * 
     * 
     * @param $filename 文件路劲
     * @param string $mode read|write|add 只读|只写|往后添加; 不设置默认可读可写
     */
    public function __construct($filename, $mode = null)
    {
        $mode = static::MODE[$mode]??'a+b';

        if (!is_dir(dirname($filename)) && !mkdir(dirname($filename), 0777, true)) {
            throw new \DomainException('The file cannot be created automatically');
        }

        parent::__construct($filename, $mode = 'a+', $useIncludePath = false, $context = null);
    }
    

    /**
     * 通过懒加载获得实例
     * @param $fileName 文件路劲
     * @param null $model
     * @return FileObject read|write|add 只读|只写|往后添加; 不设置默认可读可写
     */
    public static function getInstance($fileName, $model=null): FileObject
    {
        return new FileObject($fileName,$model);
    }

    /**
     * 写入样式： log:首行添加时间,以后可以扩展为多输入类
     */
    public function style($style=''){
        
    }


    /**
     * 获取文件内容
     */
    public function read():string
    {
        $this->rewind();
        $size = $this->getRealSize();
        if($size>0){
            return $this->fread($size);
        }
        return '';
    }


//    /**
//     * 逐行获取内容 外层foreach就行了；不写函数了
//     */
//    public function more(){
//
//        foreach ($this as $line) {
//            echo $this->key() . ". " . $line . "\n<br>";
//        }
//
//    }

    /**
     * 分行获取内容
     * @param int $begin 开始行数
     * @param int $num 截取行数
     * @return array
     */
    public function less($begin=0, $num=10)
    {
        $data = [];
        $countRow = $this->getCountRow();
        if($countRow>$begin){
            $this->seek($begin);
            $i=0;
            $data = [];
            while ($this->valid() && $i<$num) {
                array_push($data, $this->current());
                $this->next();
                $i++;
            }
        }
        return $data;
    }


    /**
     * 获取开头几行内容
     * @param int $num 截取行数
     * @return array
     */
    public function head(int $num):array
    {
        $this->rewind();
        $i=0;
        $data = [];
        while ($this->valid() && $i<$num) {
            array_push($data, $this->current());
            $this->next();
            $i++;
        }
        return $data;
    }

    /**
     * 获取末尾几行内容
     * @param int $num 截取行数
     * @return array 
     */
    public function tail(int $num):array
    {
        $countRow = $this->getCountRow();

        // 跳转到最大行数-要截取行数, 总行数不足就全取
        $seekIndex = $countRow-$num+1;
        if($seekIndex<0){
            $seekIndex = 0;
        }
        
        $this->seek($seekIndex);
        $i=0;
        $data = [];
        while ($this->valid() && $i<$num) {
            array_push($data, $this->current());
            $this->next();
            $i++;
        }
        return $data;
    }



    /**
     * 文件信息 wc('lc')
     * @param string $str -l: lines 行数； -w: words 单词数 ；-c: bytes 字节
     * @return array
     */
    public function wc(string $str):array
    {
        $data = [];
        foreach(str_split($str) as $i){
            switch($i){
                case 'l':
                    $data['line'] = $this->getCountRow();
                   break;
                case 'c':
                    $data['size'] = $this->getSize();
                    break;
                default:
                    break;
            }
        }
        return $data;
    }

    /**
     * 获取总行数
     * @return int
     */
    public function getCountRow():int
    {
        $this->seek($this->getRealSize());
        return $this->key();
    }

    /**
     * 获取字符串实时长度（目前只争对$this->write和$this->add）
     */
    public function getRealSize()
    {
        return $this->getSize() + $this->changeSize;
    }
   
    /**
     * 重写内容
     * @param string $str
     * @return int
     */
    public function write(string $str):int
    {
        $this->rewind();

        $this->fflush();

        $this->ftruncate(0);

        $size = $this->fwrite($str);

        $this->changeSize += $size;
        return $size;

    }

    /**
     * 添加内容
     * @param string $str 添加内容
     * @return int
     */
    public function add(string $str):int
    {
        $size = $this->fwrite($str);
        $this->changeSize += $size;
        return $size;
    }


    /**
     * 获取文件的 MIME 类型： 例如 text/plain 或 application/octet-stream。 或者在失败时返回 FALSE。
     * $fileName = E:/HTML/image/verifyCode.png';
     * $finfo = new \finfo();
     * echo $finfo->file($fileName,FILEINFO_NONE) . '<br>';        // PNG image data, 121 x 15, 8-bit colormap, non-interlaced
     * echo $finfo->file($fileName,FILEINFO_SYMLINK ). '<br>';     // PNG image data, 121 x 15, 8-bit colormap, non-interlaced
     * echo $finfo->file($fileName,FILEINFO_MIME_TYPE). '<br>';    // image/png
     * echo $finfo->file($fileName,FILEINFO_MIME_ENCODING). '<br>';// binary
     * echo $finfo->file($fileName,FILEINFO_MIME). '<br>';         // image/png; charset=binary
     * echo $finfo->file($fileName,FILEINFO_DEVICES). '<br>';      // PNG image data, 121 x 15, 8-bit colormap, non-interlaced
     * echo $finfo->file($fileName,FILEINFO_CONTINUE). '<br>';     // PNG image data, 121 x 15, 8-bit colormap, non-interlaced\012- data
     * echo $finfo->file($fileName,FILEINFO_PRESERVE_ATIME). '<br>';   // PNG image data, 121 x 15, 8-bit colormap, non-interlaced
     * echo $finfo->file($fileName,FILEINFO_RAW). '<br>';          // PNG image data, 121 x 15, 8-bit colormap, non-interlaced
     * echo $finfo->file($fileName,FILEINFO_EXTENSION). '<br>';    // ???
     *
     * @return string | false
     */
    public function getMimeType()
    {
        if(!isset($this->fInfo)) $this->finfo = new FInfo($this->getRealPath());

        return $this->finfo->getMimeType();
    }




    /**
     * 将数组下载为 Csv 文件
     */
    public static function exportToCsv($data,$fileName)
    {
        $fileName = iconv('UTF-8', 'GBK', $fileName);

        //设置header头
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $fileName . '.csv');

        //打开PHP文件句柄,php://output,表示直接输出到浏览器
        $fp = new \SplFileObject("php://output","a");

        $num = 0;
        //每隔$limit行，刷新一下输出buffer,不要太大亦不要太小
        $limit = 100000;
        //逐行去除数据,不浪费内存
        $count = count($data);
        for($i = 0 ; $i < $count ; $i++){
            $num++;
            //刷新一下输出buffer，防止由于数据过多造成问题
            if($limit == $num){
                ob_flush();
                flush();
                $num = 0;
            }
            $row = $data[$i];

            foreach ($row as $key => $value) {
                $row[$key] = iconv('UTF-8', 'GBK', $value);
            }

            $fp->fputcsv($row);
        }


    }







}







