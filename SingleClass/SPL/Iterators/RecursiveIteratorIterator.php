<?php
/**
 * $mode
 *  RecursiveIteratorIterator  implements OuterIterator  可用于遍历递归迭代器。
 *
 *  RecursiveIteratorIterator::LEAVES_ONLY
 *
 *  RecursiveIteratorIterator::SELF_FIRST
 *
 *  RecursiveIteratorIterator::CHILD_FIRST
 *
 *
 *
 * $flags
 *  RecursiveIteratorIterator::CATCH_GET_CHILD
 *
 *
 *
 */


namespace HappyLin\OldPlugin\SingleClass\SPL\Iterators;


use \RecursiveIteratorIterator as RII, Iterator;
use Traversable;


class RecursiveIteratorIterator extends RII
{

    /**
     *
     * mode
     * 可选模式。 可能的值为
     * • RecursiveIteratorIterator::LEAVES_ONLY     - The default. Lists only leaves in iteration.  默认值。只列出迭代中的叶子。
     * • RecursiveIteratorIterator::SELF_FIRST      - Lists leaves and parents in iteration with parents coming first. 列出迭代中的叶和父项，父项优先。
     * • RecursiveIteratorIterator::CHILD_FIRST     - Lists leaves and parents in iteration with leaves coming first.  列出迭代中的叶和父项，叶优先。
     *
     *
     * RecursiveIteratorIterator constructor.
     * @param Traversable $iterator  正在构造的迭代器。任何 RecursiveIterator（递归迭代器）或IteratorAggregate迭代器聚合
     * @param int $mode RecursiveIteratorIterator::LEAVES_ONLY   RecursiveIteratorIterator::SELF_FIRST RecursiveIteratorIterator::CHILD_FIRST
     * @param int $flags 可选标志。 可能的值是 RecursiveIteratorIterator::CATCH_GET_CHILD，它将忽略调用 RecursiveIteratorIterator::getChildren() 时抛出的异常。
     */
    public function __construct(Traversable $iterator, $mode = RII::LEAVES_ONLY, $flags = 0)
    {
        RII::__construct($iterator, $mode, $flags);
    }




    /**
     * 在调用 RecursiveIteratorIterator::getChildren() 及其关联的 RecursiveIteratorIterator::rewind() 之后调用。
     */
    public function beginChildren(): void
    {
        parent::beginChildren();
    }

    /**
     * 当结束递归一级时调用。
     */
    public function endChildren(): void
    {
        parent::endChildren();
    }

    /**
     * 在迭代开始时调用（在第一次 RecursiveIteratorIterator::rewind() 调用之后。
     */
    public function beginIteration(): void
    {
        parent::beginIteration();
    }

    /**
     * 在迭代结束时调用（当 RecursiveIteratorIterator::valid() 首先返回 FALSE 时。
     */
    public function endIteration(): void
    {
        parent::endIteration();
    }


    /**
     * 为每个元素调用以测试它是否有子元素。
     * @return bool
     */
    public function callHasChildren(): bool
    {
        return parent::callHasChildren();
    }

    /**
     * 为每个元素调用以测试它是否有子元素。
     * @return \RecursiveIterator 如果元素有子元素，则为 TRUE，否则为 FALSE
     */
    public function callGetChildren()
    {
        return parent::callGetChildren();
    }


    /**
     * 获取递归迭代的当前深度
     * @return int 递归迭代的当前深度。
     */
    public function getDepth(): int
    {
        return parent::getDepth();
    }

    /**
     * 设置允许的最大深度。
     * @param int $maxDepth
     */
    public function setMaxDepth($max_depth = -1)
    {
        parent::setMaxDepth($maxDepth);
    }

    /**
     * 获取最大允许深度。
     * @return false|int 可接受的最大深度，如果允许任何深度，则为 FALSE。
     */
    public function getMaxDepth()
    {
        return parent::getMaxDepth();
    }


    /**
     * 当下一个元素可用时调用。
     */
    public function nextElement(): void
    {
        parent::nextElement();
    }

    /**
     * 当前活动的子迭代器。
     * @param int $level
     * @return \RecursiveIterator
     */
    public function getSubIterator( $level = null)
    {
        return parent::getSubIterator($level);
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

