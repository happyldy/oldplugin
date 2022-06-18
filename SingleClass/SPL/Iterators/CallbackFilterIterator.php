<?php
/**
 * CallbackFilterIterator::__construct — 从另一个迭代器创建一个过滤的迭代器
 * 使用回调创建过滤迭代器以确定接受或拒绝哪些项目。
 *
 */


namespace HappyLin\OldPlugin\SingleClass\SPL\Iterators;


use \CallbackFilterIterator as CFI, Iterator;



class CallbackFilterIterator extends CFI
{


    /**
     * 使用回调创建过滤迭代器以确定接受或拒绝哪些项目。
     *
     * @param Iterator $iterator 要过滤的迭代器。
     * @param callable $callback 回调，应返回 TRUE 以接受当前项目，否则为 FALSE。可以是任何有效的可调用值。
     */
    public function __construct(Iterator $iterator, $callback)
    {
        parent::__construct($iterator, $callback);
    }



    /**
     * 使用当前值、当前键和内部迭代器作为参数调用回调
     * 如果要接受当前项目，则回调应返回 TRUE，否则返回 FALSE。
     * @return bool 返回 TRUE 以接受当前项目，否则返回 FALSE。
     */
    public function accept(): bool
    {
        return parent::accept();
    }

    /**
     * @return Iterator 获取内部迭代器
     */
    public function getInnerIterator(): Iterator
    {
        parent::getInnerIterator();
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

