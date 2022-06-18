<?php

namespace HappyLin\OldPlugin\SingleClass\FileSystem\Directories;


use \Directory as D;

class Directory extends D
{

    /**
     * 被打开目录的地址
     * @var string
     */
    public string $path;

    /**
     * 目录句柄。可以被其他的目录操作函数使用，例如 readdir(), rewinddir() and closedir()。
     * @var resource
     */
    public resource $handle;

    public function __construct($path)
    {
        $this->path = $path;
        $this->handle = opendir($this->path);
    }


    /**
     *  从目录句柄中读取条目
     * 与 readdir() 函数功能一样, 只是 dir_handle 默认为 $this 变量。
     *
     * @param resource  $dir_handle
     * @return string
     */
    public function read(resource $dir_handle = null) : string
    {
        return parent::read($dir_handle);
    }


    /**
     * 倒回目录句柄
     * 与 rewinddir() 函数功能一样, 只是 dir_handle 默认为 $this 变量。
     * @param resource $dir_handle
     */
    public function rewind(resource $dir_handle = null) : void
    {
        parent::rewind($dir_handle);
    }


    /**
     * 释放目录句柄
     * 与 closedir() 函数功能一样，只是 dir_handle 默认为 $this 变量。
     * @param resource|null $dir_handle
     */
    public function close(resource $dir_handle = null) : void
    {
        parent::close($dir_handle);
    }


}







