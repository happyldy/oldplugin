<?php
/**
 * 这个迭代器包装器允许将任何可遍历的东西转换为迭代器。
 * 重要的是要了解大多数未实现迭代器的类都有原因，因为它们很可能不允许完整的迭代器功能集。 如果是这样，应该提供技术来防止误用，否则就会出现异常或致命错误。
 * 此类允许通过 __call 魔术方法访问内部迭代器的方法。
 */


namespace HappyLin\OldPlugin\SingleClass\SPL\Iterators;


use \IteratorIterator as II, Iterator;
use Traversable;


class IteratorIterator extends II
{


    /**
     * IteratorIterator constructor.
     *
     * @param Traversable $iterator 支持（遍历）接口
     * @param string $class php8
     */
    public function __construct(Traversable $iterator, $class = '')
    {
        parent::__construct($iterator, $class);
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

