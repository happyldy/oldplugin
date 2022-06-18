<?php
/**
 * 允许您实现自己的协议处理程序和流，以便与所有其他文件系统函数（例如 fopen()、fread() 等）一起使用。
 *
 *  这不是一个真正的类，只是一个定义自己协议的类的原型。
 */


namespace HappyLin\OldPlugin\SingleClass\Streams;


//use \streamWrapper as SW;

class StreamWrapper
{

    public $dirHandle;

    /**
     * StreamWrapper constructor. 构造一个新的流包装器
     *
     * 在打开流包装器时调用，就在 streamWrapper::stream_open() 之前。
     *
     */
    public function __construct()
    {

    }


    /**
     * 关闭目录句柄
     * 这个方法被调用以响应 closedir()。
     * 在打开和使用目录流期间被锁定或分配的任何资源都应该被释放。
     *
     * @return bool
     */
    public function dirClosedir() : bool
    {
        return closedir($this->dirHandle);
    }


    /**
     * 打开目录句柄
     * 响应 opendir() 调用此方法。
     *
     * @param string $path 指定传递给opendir（）的URL。 可以使用parse_URL（）将URL拆分。
     * @param int $options
     * @return bool
     */
    public function dirOpendir(string $path, int $options) : bool
    {
        $this->dirHandle = opendir( $path,  $options);
        if($this->dirHandle){
            return true;
        }
        return false;
    }


    /**
     * 从目录句柄读取条目
     * 调用此方法是为了响应readdir（）。
     * @return string 应返回表示下一个文件名的字符串，如果没有下一个文件，则返回FALSE。
     */
    public function dir_readdir() : string
    {
        return readdir($this->dirHandle);
    }


    /**
     * 响应 rewinddir() 调用此方法。
     * 应该重置 streamWrapper::dir_readdir() 生成的输出。即： 下一次调用 streamWrapper::dir_readdir() 应该返回 streamWrapper::dir_opendir() 返回的位置中的第一个条目。
     * @return bool
     */
    public function dir_rewinddir() : bool
    {
        rewinddir( $this->dirHandle);
        return true;
    }

    /**
     * 响应 mkdir() 调用此方法。
     * 为了返回适当的错误消息，如果包装器不支持创建目录，则不应定义此方法。
     *
     * @param string $path 应该创建的目录。
     * @param int $mode 传递给 mkdir() 的值。 默认的 mode 是 0777，意味着最大可能的访问权。有关 mode 的更多信息请阅读 chmod() 页面。
     * @param int $options 允许递归创建由 pathname 所指定的多级嵌套目录。 它的说明是，不懂！！！！！！！！ 值的按位掩码，例如 STREAM_MKDIR_RECURSIVE。
     * @return bool
     */
    public function mkdir( string $path, int $mode = 0777, int $options = 0) : bool
    {
        return mkdir(  $path,$mode = 0777, $options);
    }


    /**
     * 这个方法被调用以响应 rename()。
     * 应该尝试将 path_from 重命名为 path_to
     * 为了返回适当的错误消息，如果包装器不支持重命名文件，则不应定义此方法。
     * @param string $path_from 当前文件的 URL。
     * @param string $path_to path_from 应重命名为的 URL。
     * @return bool
     */
    public function rename( string $path_from, string $path_to) : bool
    {
        return rename( $path_from, $path_to);
    }


    /**
     * 响应 rmdir() 调用此方法。
     * 为了返回适当的错误消息，如果包装器不支持删除目录，则不应定义此方法。
     * @param string $path 应删除的目录 URL。
     * @param int $options 值的按位掩码，例如 STREAM_MKDIR_RECURSIVE。
     * @return bool
     */
    public function rmdir( string $path, int $options) : bool
    {
        return rmdir(  $path );
    }


    /**
     * 响应stream_select() 调用此方法。
     * @param int $cast_as 当 stream_select() 调用 stream_cast() 或 STREAM_CAST_AS_STREAM 时，可以是 STREAM_CAST_FOR_SELECT 当 stream_cast() 被调用用于其他用途时。
     * @return resource 应返回包装器使用的底层流资源，或返回 FALSE。
     */
    public function stream_cast( int $cast_as) : resource
    {

    }


}


