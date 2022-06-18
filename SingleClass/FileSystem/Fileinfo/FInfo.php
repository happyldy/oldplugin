<?php
/**
 * 获取文件的 MIME 类型
 *
 * FILEINFO_NONE(integer)           无特殊处理。
 * FILEINFO_SYMLINK(integer)        跟随符号链接。
 * FILEINFO_MIME_TYPE(integer)      返回 mime 类型。  自 PHP 5.3.0 可用。
 * FILEINFO_MIME_ENCODING(integer)  返回文件的 mime 编码。  自 PHP 5.3.0 可用。
 * FILEINFO_MIME(integer)           按照 RFC 2045 定义的格式返回文件 mime 类型和编码。
 * FILEINFO_COMPRESS(integer)       解压缩压缩文件。  由于线程安全问题，自 PHP 5.3.0 禁用。
 * FILEINFO_DEVICES(integer)        查看设备的块内容或字符。  FILEINFO_CONTINUE(integer) 返回全部匹配的类型。
 * FILEINFO_PRESERVE_ATIME(integer) 如果可以的话，尽可能保持原始的访问时间。
 * FILEINFO_RAW(integer)            对于不可打印字符不转换成 \ooo 八进制表示格式。
 * FILEINFO_EXTENSION(integer)      根据 MIME 类型返回适当的文件扩展名。  有的文件类型具有多种扩展名，例如 JPEG 将会返回多个扩展名，以斜杠分隔，比如 "jpeg/jpg/jpe/jfif"。如果在 magic.mime 数据库里类型未知，则返回的是 "???"。  PHP 7.2.0 起有效。
 *
 */


namespace HappyLin\OldPlugin\SingleClass\FileSystem\Fileinfo;


class FInfo extends \finfo
{
    
    /**
     * 文件绝对路劲
     * @var
     */
    public $fileName;


    /**
     *
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
     *
     * FInfo constructor.
     * @param string $fileName 文件绝对路劲
     * @param int $flags 一个 Fileinfo 常量  或多个 Fileinfo 常量  进行逻辑或运算。
     * @param string $magic_database  魔数数据库文件名称，通常是 /path/to/magic.mime。如果未指定，则使用 MAGIC 环境变量。如果未指定此环境变量，则使用 PHP 绑定的魔数数据库。传入 NULL 或者空字符串，等同于使用默认值。
     */
    public function __construct(string $fileName, int $flags=null, string $magic_database=null)
    {
        $this->fileName = $fileName;
        parent::__construct($flags, $magic_database);
    }
    
    
    /**
     * 通过懒加载获得实例
     * @param string $fileName 文件绝对路劲
     * @param null $flags 一个 Fileinfo 常量  或多个 Fileinfo 常量  进行逻辑或运算。
     * @param null $magic_database 魔数数据库文件名称，通常是 /path/to/magic.mime。
     * @return FInfo
     */
    public static function getInstance(string $fileName, int $flags=null, string $magic_database=null): finfo
    {
        return new FInfo($fileName, $flags, $magic_database);
    }



    /**
     *  返回一个字符串缓冲区的信息
     *
     * @param string $string 要检查的文件内容。
     * @param int $options 一个 Fileinfo 常量  或多个 Fileinfo 常量  进行逻辑或运算。
     * @param resource $context  关于 contexts 的更多描述，请参考 Stream 函数。
     * @return string 返回 string 参数所指定内容的类型描述。发生错误时返回 FALSE 。
     */
    public function buffer( $string = NULL,  $options = FILEINFO_NONE, $context = NULL ) : string
    {
        if(isset($context)){
            return parent::buffer($string, $options, $context);
        }
        return parent::buffer($string, $options);
    }


    /**
     * 返回一个文件的信息
     *
     * @param string $file_name 要检查的文件名。
     * @param int $options 一个 Fileinfo 常量  或多个 Fileinfo 常量  进行逻辑或运算。
     * @param resource $context 关于 contexts 的更多描述，请参考 Stream 函数。
     * @return string
     */
    public function file( $file_name = NULL, $options = FILEINFO_NONE, $context = NULL ) : string
    {
        if(isset($context)){
            return parent::file( $file_name, $options, $context);
        }
        return parent::file( $file_name, $options);
    }


    /**
     * 设置 libmagic 配置选项
     *
     * @param int $options 一个 Fileinfo 常量  或多个 Fileinfo 常量  进行逻辑或运算。
     * @return bool
     */
    public function set_flags($options) : bool
    {
        return parent::set_flags( $options);
    }


    /**
     * 返回通过使用 magic.mime 检测到的文件 MIME 类型。
     * 模拟实现mime_content_type( string $filename) : string
     *
     * @return string | false 返回文件的 MIME 内容类型，例如 text/plain 或 application/octet-stream。 或者在失败时返回 FALSE。
     */
    public function getMimeType()
    {
        return $this->file($this->fileName,FILEINFO_MIME_TYPE);
    }




}







