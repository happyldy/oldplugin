<?php
/**
 * SplPriorityQueue 类提供优先队列的主要功能，使用最大堆实现。
 *
 * 注意：具有相同优先级的元素的顺序未定义。它可能与它们插入的顺序不同。
 *
 */


namespace HappyLin\OldPlugin\SingleClass\SPL\Datastructures;


use \SplPriorityQueue;

/**
 * SplPriorityQueue 类提供优先队列的主要功能，使用最大堆实现。
 * @package HappyLin\OldPlugin\SingleClass\SPL\Datastructures
 */
class PriorityQueue extends SplPriorityQueue
{


    public function __construct()
    {
    }

    /**
     * 比较优先级以便在筛选时将元素正确放置在堆中
     * @param mixed $priority1
     * @param mixed $priority2
     * @return int|void
     */
    public function compare($priority1, $priority2)
    {
        return parent::compare($priority1, $priority2); // TODO: Change the autogenerated stub
    }

    /**
     * 定义由 SplPriorityQueue::current()、SplPriorityQueue::top() 和 SplPriorityQueue::extract() 提取的内容。
     *
     *      SplPriorityQueue::EXTR_DATA (0x00000001): Extract the data  提取数据
     *      SplPriorityQueue::EXTR_PRIORITY (0x00000002): Extract the priority  提取优先级
     *      SplPriorityQueue::EXTR_BOTH (0x00000003): Extract an array containing both 提取包含两者的数组
     *
     * The default mode is SplPriorityQueue::EXTR_DATA.
     *
     *
     * @param int $flags
     */
    public function setExtractFlags($flags)
    {
        parent::setExtractFlags($flags); // TODO: Change the autogenerated stub
    }


    /**
     * 在队列中插入具有优先级优先级的值。
     * @param mixed $value 要插入的值
     * @param mixed $priority 关联的优先级
     * @return true|void
     */
    public function insert($value, $priority)
    {
        parent::insert($value, $priority); // TODO: Change the autogenerated stub
    }


    /**
     * 统计元素数
     *
     * @return int 返回列表中的元素数。
     */
    public function count():int
    {
        return parent::count();
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

