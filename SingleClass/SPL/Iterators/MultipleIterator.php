<?php
/**
 * MultipleIterator  implements Iterator
 * 对所有附加的迭代器进行顺序迭代的迭代器 (其实就是同索引的混合成一个数组，形成多维迭代器)
 *
 * MultipleIterator::MIT_NEED_ANY
 *      不要求所有子迭代器在迭代中都有效。
 * MultipleIterator::MIT_NEED_ALL
 *      要求所有子迭代器在迭代中都有效。
 * MultipleIterator::MIT_KEYS_NUMERIC
 *      键是从子迭代器位置创建的。
 * MultipleIterator::MIT_KEYS_ASSOC
 *      键是根据子迭代器相关信息创建的。
 *
 *
 */


namespace HappyLin\OldPlugin\SingleClass\SPL\Iterators;


use MultipleIterator as MI, Iterator;



class MultipleIterator extends MI
{


    /**
     * MultipleIterator constructor.
     *
     * flags
     * The flags to set, according to the Flag Constants.
     *  MultipleIterator::MIT_NEED_ALL (要求所有子迭代器在迭代中都有效) or MultipleIterator::MIT_NEED_ANY (不要求所有子迭代器在迭代中都有效)
     *  MultipleIterator::MIT_KEYS_NUMERIC (键是从子迭代器位置创建的) or MultipleIterator::MIT_KEYS_ASSOC (键是根据子迭代器相关信息创建的)
     *
     * Defaults to MultipleIterator::MIT_NEED_ALL|MultipleIterator::MIT_KEYS_NUMERIC.
     *
     * @param int|string $flags
     */
    public function __construct($flags = MI::MIT_NEED_ALL | MI::MIT_KEYS_NUMERIC)
    {
        parent::__construct($flags);
    }

    /**
     * 设置标志。
     * @param int $flags
     */
    public function setFlags($flags): void
    {
        parent::setFlags($flags);
    }

    /**
     * 获取标志
     * @return int
     */
    public function getFlags(): int
    {
        return parent::getFlags(); // TODO: Change the autogenerated stub
    }


    /**
     * 附加迭代器信息
     * @param Iterator $iterator 要附加的新迭代器。
     * @param null $info 迭代器的关联信息，必须是int、字符串或NULL。
     */
    public function attachIterator(Iterator $iterator, $info = null) : void
    {
        parent::attachIterator($iterator, $info);
    }

    /**
     * 分离迭代器。
     * @param Iterator $iterator
     */
    public function detachIterator(Iterator $iterator)
    {
        parent::detachIterator($iterator);
    }


    /**
     * 检查是否附加了迭代器。
     * @param Iterator $iterator 要检查的迭代器。
     * @return bool|void
     */
    public function containsIterator(Iterator $iterator): bool
    {
        return parent::containsIterator($iterator);
    }

    /**
     * 获取附加的迭代器实例数
     * @return int 附加迭代器实例的数量（作为 int）。
     */
    public function countIterators():int
    {
        return parent::countIterators();
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

