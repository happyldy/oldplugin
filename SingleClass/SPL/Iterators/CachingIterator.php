<?php
/**
 * 此对象支持对另一个迭代器的缓存迭代。
 *
 *
 * CachingIterator::CALL_TOSTRING
 *      将每个元素转换为字符串
 * CachingIterator::CATCH_GET_CHILD
 *      不要在访问子集时抛出异常。
 * CachingIterator::TOSTRING_USE_KEY
 *      使用键转换为字符串。
 * CachingIterator::TOSTRING_USE_CURRENT
 *      Use current forconversion to string. 使用当前值转换为字符串。
 * CachingIterator::TOSTRING_USE_INNER
 *      Use innerfor conversion to string. 使用 innerfor 转换为字符串。
 * CachingIterator::FULL_CACHE
 *      缓存所有读取的数据
 *

 */


namespace HappyLin\OldPlugin\SingleClass\SPL\Iterators;


use \CachingIterator as CI, Iterator;



class CachingIterator extends CI
{


    /**
     * CachingIterator constructor.
     * @param Iterator $iterator 缓存迭代器
     * @param int $flags 标志位掩码。
     */
    public function __construct(Iterator $iterator, $flags = CI::CALL_TOSTRING)
    {
        CI::__construct($iterator, $flags);
    }

    /**
     * 为 CachingIterator 对象设置标志。
     * @param int $flags 要设置的标志的位掩码。
     */
    public function setFlags($flags): void
    {
        parent::setFlags($flags);
    }

    /**
     * 获取用于此 CachingIterator 实例的标志的位掩码
     * @return int
     */
    public function getFlags(): int
    {
        return parent::getFlags();
    }

    /**
     * 检索缓存的内容。
     * 必须使用 CachingIterator::FULL_CACHE 标志。
     * @return array 包含缓存项的数组
     * @throws BadMethodCallException 当未使用 CachingIterator::FULL_CACHE 标志时抛出 。
     */
    public function getCache():array
    {
        return parent::getCache();
    }


    /**
     * 检查内部迭代器是否具有有效的下一个元素
     * @return bool
     */
    public function hasNext():bool
    {
        return parent::hasNext();
    }

    /**
     * 一个类被当成字符串时应怎样回应
     * @return string
     */
    public function __toString():string
    {
        return parent::__toString();
    }


    /**
     * 此方法返回当前的内部迭代器。
     * @return \Iterator 当前项的内部迭代器
     */
    public function getInnerIterator(): Iterator
    {
        return parent::getInnerIterator();
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

