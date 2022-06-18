<?php
/**
 * SplFileInfo 类为单个文件的信息提供了一个高级的面向对象的接口。
 */


namespace HappyLin\OldPlugin\SingleClass\SPL\FileHandling;


use SplFileInfo, SplFileObject;



class FileInfo extends SplFileInfo
{


    public function __construct($filename)
    {
        parent::__construct($filename);
    }


    /**
     * 此方法返回不带路径信息的文件、目录或链接的基本名称。
     * SplFileInfo::getBasename() 可以识别区域设置，因此要查看具有多字节字符路径的正确基本名称，必须使用 setlocale() 函数设置匹配的区域设置。
     * @param null $suffix 从返回的基本名称中省略的可选后缀。
     * @return string|void
     */
    public function getBasename($suffix = null): string
    {
        return parent::getBasename($suffix);
    }


    /**
     * 获取不包含任何路径信息的文件名。
     * @return string
     */
    public function getFilename(): string
    {
       return parent::getFilename();
    }

    /**
     * 返回文件的路径，省略文件名和任何尾部斜杠。
     * @return string
     */
    public function getPath():string
    {
        return parent::getPath();
    }


    /**
     * 获取文件路径
     * @return string
     */
    public function getPathname(): string
    {
        return parent::getPathname();
    }


    /**
     * 此方法展开所有符号链接，解析相对引用并返回文件的真实路径。
     * @return string 返回文件的路径，如果文件不存在，则返回 FALSE。
     */
    public function getRealPath(): string
    {
        return parent::getRealPath();
    }



    /**
     * 检索文件扩展名。
     * @return string 返回包含文件扩展名的字符串，如果文件没有扩展名，则返回空字符串。
     */
    public function getExtension(): string
    {
        return parent::getExtension();
    }

    /**
     * 返回所引用文件的类型。
     * @return string
     */
    public function getType(): string
    {
        return parent::getType();
    }

    /**
     * 返回引用文件的文件大小（以字节为单位）。
     * @return int
     */
    public function getSize(): int
    {
        return parent::getSize();
    }

    /**
     * 此方法可用于确定文件是否为目录。
     * @return bool 如果是目录，则返回 TRUE，否则返回 FALSE。
     */
    public function isDir(): bool
    {
        return parent::isDir();
    }

    /**
     * 检查此 SplFileInfo 对象引用的文件是否存在并且是常规文件。
     * @return bool
     */
    public function isFile(): bool
    {
        return parent::isFile();
    }

    /**
     * 使用此方法检查 SplFileInfo 对象引用的文件是否为链接。
     * @return bool
     */
    public function isLink(): bool
    {
        return parent::isLink();
    }

    /**
     * 检查文件是否可读。
     * @return bool
     */
    public function isReadable(): bool
    {
        return parent::isReadable();
    }

    /**
     * 检查当前条目是否可写。
     * @return bool
     */
    public function isWritable(): bool
    {
        return parent::isWritable();
    }


    /**
     * 获取文件系统链接的目标。
     * 目标可能不是文件系统上的真实路径。 使用 SplFileInfo::getRealPath() 确定文件系统上的真实路径。
     * @return string 返回文件系统链接的目标。
     */
    public function getLinkTarget(): string
    {
        return parent::getLinkTarget();
    }

    /**
     * 使用此方法设置将在调用 SplFileInfo::openFile() 时使用的自定义类。 传递给此方法的类名必须是 SplFileObject 或从 SplFileObject 派生的类。
     * @param null $class 调用 SplFileInfo::openFile() 时使用的类名。
     */
    public function setFileClass($class = null)
    {
        parent::setFileClass($class);
    }


    /**
     * 创建文件的 SplFileObject 对象。 这很有用，因为 SplFileObject 包含用于操作文件的其他方法，而 SplFileInfo 仅用于获取信息，例如文件是否可写。
     * @param string $mode 打开文件的模式。 有关可能模式的说明，请参阅 fopen() 文档。 默认为只读。
     * @param false $useIncludePath 值 设为 TRUE 时, 也会在 include_path搜索文件名。
     * @param null $context 上下文（context）的说明请参考手册中的 上下文（context）章节.
     * @return \SplFileObject
     * @throws RuntimeException 如果无法打开文件（例如访问权限不足） 。
     */
    public function openFile($mode = 'r', $useIncludePath = false, $context = null): SplFileObject
    {
        if($context){
            return parent::openFile($mode, $useIncludePath, $context);
        }
        return parent::openFile($mode, $useIncludePath);
    }


    /**
     * @return int 返回上次访问文件的时间。
     * @throws RunTimeException
     */
    public function getATime(): int
    {
        return parent::getATime();
    }

    /**
     * 返回文件内容更改的时间。 返回的时间是 Unix 时间戳。
     * @return int
     */
    public function getMTime(): int
    {
        return parent::getMTime();
    }



    /**
     * 返回此文件 inode 的修改时间，返回的时间是个 Unix 时间戳。
     * @return int|void
     */
    public function getCTime():int
    {
        return parent::getCTime();
    }


    /**
     * 获取文件组。组ID以数字格式返回。
     * @return int
     */
    public function getGroup(): int
    {
        return parent::getGroup();
    }

    /**
     * 获取文件所有者。 所有者 ID 以数字格式返回。
     * @return int 数字格式的所有者 ID。
     */
    public function getOwner():int
    {
        return parent::getOwner();
    }

    /**
     * 返回文件系统对象的 inode 编号。
     * @return int
     */
    public function getInode(): int
    {
        return parent::getInode();
    }

    /**
     * 获取文件的文件权限。
     * @return int 返回文件权限
     */
    public function getPerms(): int
    {
        return parent::getPerms();
    }

    /**
     * 检查文件是否可执行。
     * @return bool
     */
    public function isExecutable(): bool
    {
        return parent::isExecutable();
    }

    /**
     * 获取当前文件父级的SplFileInfo对象。
     * @param null $class 要使用的SplFileInfo派生类的名称。
     * @return SplFileInfo 返回文件父路径的SplFileInfo对象。
     */
    public function getPathInfo($class = null): SplFileInfo
    {
        return parent::getPathInfo();
    }


    /**
     * 此方法获取引用文件的SplFileInfo对象。
     * @param string $class 要使用的SplFileInfo派生类的名称。
     * @return SplFileInfo 为文件创建的SplFileInfo对象
     */
    public function getFileInfo($class = null): SplFileInfo
    {
        return parent::getFileInfo($class);
    }


    /**
     * 用此方法设置调用SplFileInfo:：getFileInfo（）和SplFileInfo:：getPathInfo（）时将使用的自定义类。传递给此方法的类名必须是SplFileInfo或从SplFileInfo派生的类。
     * @param string $class 调用SplFileInfo:：getFileInfo（）和SplFileInfo:：getPathInfo（）时要使用的类名
     */
    public function setInfoClass($class = null): void
    {
        parent::setInfoClass($class);
    }








}

