<?php

namespace HappyLin\OldPlugin\SingleClass\FileSystem\Directories;




class DirectoryFunctions
{


    /**
     * @param string $path
     * @param resource|null $context
     * @return resource
     */
    public static function opendir( string $path, resource $context = null) : resource
    {
       return opendir( $path, $context = null);
    }


    /**
     * 从目录句柄中读取条目
     * 返回目录中下一个文件的文件名。文件名以在文件系统中的排序返回。
     * @param resource $dir_handle 目录句柄的 resource，之前由 opendir() 打开
     * @return string 成功则返回文件名 或者在失败时返回 FALSE
     */
    public static function readdir(resource $dir_handle) : string
    {
        return readdir($dir_handle);
    }


    /**
     * 倒回目录句柄
     * 将 dir_handle 指定的目录流重置到目录的开头。
     * @param resource $dir_handle 目录句柄的 resource，之前由 opendir() 打开
     */
    public static function rewinddir( resource $dir_handle) : void
    {
        rewinddir($dir_handle);
    }


    /**
     * 关闭目录句柄
     * @param resource $dir_handle 目录句柄的 resource，之前由 opendir() 打开
     */
    public static function closedir(resource $dir_handle) : void
    {
        closedir($dir_handle);
    }


    /**
     * 列出指定路径中的文件和目录
     *
     * @param string $directory 要被浏览的目录
     * @param int $sorting_order 默认的排序顺序是按字母升序排列。如果使用了可选参数 sorting_order（设为 1），则排序顺序是按字母降序排列。
     * @param resource $context context 参数的说明见手册中的 Streams API 一章。
     * @return array
     */
    public static function scandir( string $directory, int $sorting_order = null, resource $context = null ) : array
    {
        return scandir($directory, $sorting_order, $context );
    }


    /**
     * 将 PHP 的当前目录改为 directory
     * @param string $directory 新的当前目录
     * @return bool
     */
    public static function chdir( string $directory) : bool
    {
        return chdir($directory);
    }

    /**
     * 取得当前工作目录
     * @return string
     */
    public static function getcwd() : string
    {
        return getcwd();
    }


    /**
     * 将当前进程的根目录改变为 directory。
     * 本函数仅在系统支持且运行于 CLI，CGI 或嵌入 SAPI 版本时才能正确工作。此外本函数还需要 root 权限。
     * @param string $directory
     * @return bool
     */
    public static function chroot( string $directory) : bool
    {
        return chroot($directory);
    }


}







