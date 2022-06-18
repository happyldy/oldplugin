<?php
/**
 *
 *
 *
 * DirectoryIterator: 类提供了一个简单的界面来查看文件系统目录的内容。
 *
 * FilesystemIterator:(extends DirectoryIterator  implements SeekableIterator) 文件系统迭代器
 *
 * RecursiveDirectoryIterator: 提供了一个用于递归遍历文件系统目录的接口。
 *
 *      extends FilesystemIterator  implements SeekableIterator  , RecursiveIterator
 *
 * 靠他就isDot是继承类没有
 *
 */


namespace HappyLin\OldPlugin\SingleClass\SPL\Iterators;


use FilesystemIterator;
use \RecursiveDirectoryIterator as RDI, Iterator;



class RecursiveDirectoryIterator extends RDI
{


    /**
     * RecursiveDirectoryIterator constructor.
     *
     *
     * @param string $directory 要迭代的目录的路径。
     * @param int $flags 可能会提供标志，这将影响某些方法的行为。标志列表可以在 FilesystemIterator 预定义常量下找到。它们也可以稍后使用 FilesystemIterator::setFlags() 设置。
     */
    public function __construct($directory, $flags = FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO)
    {
        parent::__construct($directory, $flags);
    }


    /**
     * 设置处理标志
     *
     * FilesystemIterator::CURRENT_AS_PATHNAME
     *      使 FilesystemIterator::current() 返回路径名。
     * FilesystemIterator::CURRENT_AS_FILEINFO
     *      使 FilesystemIterator::current() 返回一个 SplFileInfo 实例。
     * FilesystemIterator::CURRENT_AS_SELF
     *      使 FilesystemIterator::current() 返回 $this（FilesystemIterator）。
     * FilesystemIterator::CURRENT_MODE_MASK
     *      掩码 FilesystemIterator::current()
     *
     * FilesystemIterator::KEY_AS_PATHNAME
     *      使 FilesystemIterator::key() 返回路径名。
     * FilesystemIterator::KEY_AS_FILENAME
     *     使 FilesystemIterator::key() 返回文件名。
     * FilesystemIterator::FOLLOW_SYMLINKS
     *      使 RecursiveDirectoryIterator::hasChildren() 遵循符号链接。
     * FilesystemIterator::KEY_MODE_MASK
     *      掩码 FilesystemIterator::key()
     *
     * FilesystemIterator::NEW_CURRENT_AND_KEY
     *      与 FilesystemIterator::KEY_AS_FILENAME | FilesystemIterator::CURRENT_AS_FILEINFO  相同。
     * FilesystemIterator::SKIP_DOTS
     *      跳过点文件（. 和 ..）。
     * FilesystemIterator::UNIX_PATHS
     *      Makes paths use Unix-style forward slash irrespective of system default.Note that the path that is passed to theconstructor is not modified.
     *      使路径使用 Unix 风格的正斜杠而不考虑系统默认值。注意传递给构造函数的路径没有被修改。
     *
     *
     * @param null $flags 要设置的处理标志。请参阅 FilesystemIterator 常量。
     */
    public function setFlags($flags = null): void
    {
        parent::setFlags($flags);
    }


    /**
     * 获取在 FilesystemIterator::__construct() 或 FilesystemIterator::setFlags() 中设置的处理标志。
     * @return int 设置标志的整数值。
     */
    public function getFlags(): int
    {
        parent::getFlags();
    }


    /**
     * 返回相对于构造函数中给定目录的子路径
     * @return string
     */
    public function getSubPath():string
    {
        return parent::getSubPath();
    }


    /**
     * 获取子路径和文件名。
     * @return string
     */
    public function getSubPathname():string
    {
        return parent::getSubPathname();
    }


    /**
     * 确定当前 DirectoryIteratoritem 是否为目录，或者 . 或者 ..
     * @return bool
     */
    public function isDot(): bool
    {
        return parent::isDot();
    }


    /**
     * 如果当前条目是目录，则返回当前条目的迭代器
     * @return object 文件名、文件信息或 $this 取决于设置的标志。请参阅 FilesystemIteratorconstants。
     */
    public function getChildren()
    {
        return parent::getChildren();
    }


    /**
     * 返回当前条目是否是目录而不是 '.' 或者 '..'
     * @param null $allowLinks
     * @return bool|void
     */
    public function hasChildren($allow_links = null):bool
    {
        return parent::hasChildren();
    }

    /**
     * 迭代器索引回到开始
     * 这将迭代器倒回到开头
     */
    public function rewind():void
    {
        parent::rewind();
    }




    /**
     * 返回当前数组条目
     * 获取当前的节点。
     *
     * @return mixed 当前的双链接列表节点值
     */
    public function current()
    {
        
        
        
        return parent::current();
    }


    /**
     * 此函数返回当前节点索引
     * @return bool|float|int|string|void|null 当前节点索引。
     */
    public function key()
    {
        return parent::key();
    }

    /**
     * 移至下一个条目
     * 将迭代器移动到下一个节点。
     */
    public function next()
    {
        parent::next();
    }

    /**
     * 检查是否包含更多节点
     * @return bool 如果包含更多节点，则返回TRUE，否则返回FALSE
     */
    public function valid():bool
    {
        return parent::valid();
    }





}

