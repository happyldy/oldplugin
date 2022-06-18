<?php
/**
 *
 * 这个迭代器能陆续遍历几个迭代器
 *
 * extends IteratorIterator  implements OuterIterator
 *
 */


namespace HappyLin\OldPlugin\SingleClass\SPL\Iterators;



use AppendIterator as AT,Iterator,ArrayIterator;

/**
 * Class AppendIterator 这个迭代器能陆续遍历几个迭代器
 * @package HappyLin\OldPlugin\SingleClass\SPL\Iterators
 */
class AppendIterator extends AT
{


    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 附加一个迭代器
     * @param Iterator $iterator 要追加的迭代器。
     */
    public function append(Iterator $iterator):void
    {
        parent::append($iterator);
    }

    /**
     * 此方法获取用于存储通过 AppendIterator::append() 添加的迭代器的 ArrayIterator。
     * @return \ArrayIterator 返回一个包含附加迭代器的 ArrayIterator
     */
    public function getArrayIterator() :ArrayIterator
    {
        return parent::getArrayIterator();
    }





    /**
     * 返回当前项的内部迭代器
     * @return \Iterator 当前项的内部迭代器
     */
    public function getInnerIterator(): Iterator
    {
        return parent::getInnerIterator();
    }

    /**
     * 获取当前内部迭代器的索引。
     * @return int|void
     */
    public function getIteratorIndex():int
    {
        return parent::getIteratorIndex();
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

