<?php
/**
 * RecursiveTreeIterator  extends RecursiveIteratorIterator  implements OuterIterator
 * 允许迭代 RecursiveIterator 以生成 ASCII 图形树。
 *
 * RecursiveTreeIterator::BYPASS_CURRENT
 *
 * RecursiveTreeIterator::BYPASS_KEY
 *
 * RecursiveTreeIterator::PREFIX_LEFT
 *
 * RecursiveTreeIterator::PREFIX_MID_HAS_NEXT
 *
 * RecursiveTreeIterator::PREFIX_MID_LAST
 *
 * RecursiveTreeIterator::PREFIX_END_HAS_NEXT
 *
 * RecursiveTreeIterator::PREFIX_END_LAST
 *
 * RecursiveTreeIterator::PREFIX_RIGHT
 *
 *
 *
 *
 *
 */


namespace HappyLin\OldPlugin\SingleClass\SPL\Iterators;


use CachingIterator;
use RecursiveTreeIterator as RTI, Iterator;



class RecursiveTreeIterator extends RTI
{


    /**
     * RecursiveTreeIterator constructor.
     *
     *
     *
     * @param $iterator
     * @param int $flags
     * @param int $cachingIteratorFlags
     * @param int $mode
     */
    public function __construct($iterator, $flags = RTI::BYPASS_KEY, $cachingIteratorFlags = CachingIterator::CATCH_GET_CHILD, $mode = RTI::SELF_FIRST)
    {
        parent::__construct($iterator, $flags, $cachingIteratorFlags, $mode);
    }


    /**
     * 返回为当前元素构建的树的一部分。
     * @return string
     */
    public function getEntry(): string
    {
        return parent::getEntry();
    }


//    /**
//     * 设置 RecursiveTreeIterator::getPostfix() 中使用的后缀。
//     * @param string $postfix
//     */
//    public function setPostfix($postfix): void
//    {
//        parent::setPostfix($postfix);
//    }

    /**
     * 获取要放置在当前元素之后的字符串。
     * @return string 返回放置在当前元素之后的字符串。
     */
    public function getPostfix(): string
    {
        return parent::getPostfix();
    }

    /**
     * 设置图形树中使用的前缀的一部分。
     *
     *
     *
     * @param int $part RecursiveTreeIterator::PREFIX_* 常量之一。
     * @param string $value 要分配给 part 中指定的前缀部分的值。
     */
    public function setPrefixPart($part, $value):void
    {
        parent::setPrefixPart($part, $value);
    }

    /**
     * 获取放置在当前元素前面的字符串
     * @return string
     */
    public function getPrefix(): string
    {
        return parent::getPrefix();
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

