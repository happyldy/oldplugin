<?php
/**
 * SplFixedArray 类提供数组的主要功能。
 * SplFixedArray 和普通 PHP 数组的主要区别在于 SplFixedArray 是固定长度的，并且只允许范围内的整数作为索引。 优点是它比标准数组使用更少的内存。
 *
 */


namespace HappyLin\OldPlugin\SingleClass\SPL\Datastructures;


use \SplFixedArray;

/**
 * SplFixedArray 类提供数组的主要功能。
 * SplFixedArray 和普通 PHP 数组的主要区别在于 SplFixedArray 是固定长度的，并且只允许范围内的整数作为索引。 优点是它比标准数组使用更少的内存。
 *
 *
 *  Countable  , Iterator  , Serializable  , ArrayAccess
 *
 * @package HappyLin\OldPlugin\SingleClass\SPL\Datastructures
 */
class FixedArray extends SplFixedArray
{

    /**
     * FixedArray constructor. 构造一个新的固定数组
     *
     * 当 size 为负数时抛出 InvalidArgumentException。
     *
     * 当大小无法解析为数字时引发 E_WARNING。
     *
     * @param int $size 固定数组的大小。这需要一个介于 0 和 PHP_INT_MAX 之间的数字。
     */
    public function __construct(int $size)
    {
        parent::__construct($size);
    }

    /**
     * 在新的 SplFixedArray 实例中导入 PHP 数组数组
     *
     *
     *
     * @param array $array 要导入的数组
     * @param bool $preserveKeys 尝试保存原始数组中使用的数字索引。
     * @return SplFixedArray 返回包含数组内容的 SplFixedArray 实例。
     */
    public static function fromArray( $array,  $preserveKeys = true): SplFixedArray
    {
        return parent::fromArray($array, $preserveKeys);
    }


    /**
     * 获取数组的大小
     * 此方法在功能上等效于 SplFixedArray::count()
     * @return int 以 int 形式返回数组的大小。
     */
    public function getSize():int
    {
        return parent::getSize();
    }


    /**
     * 将数组的大小更改为新的大小大小。
     * 如果大小小于当前数组大小，则新大小之后的任何值都将被丢弃。 如果 size 大于当前数组大小，则数组将用 NULL 值填充。
     *
     * @param int $size 固定数组的大小。这需要一个介于 0 和 PHP_INT_MAX 之间的数字。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public function setSize($size):bool
    {
        return parent::setSize($size);
    }


    /**
     * 从固定数组中返回一个 PHP 数组。
     *
     * @return array 返回一个 PHP 数组，类似于固定数组。
     */
    public function toArray()
    {
        return parent::toArray();
    }

    /**
     *  反序列化后重新初始化数组
     */
    public function __wakeup()
    {
        parent::__wakeup();
    }





















    // ··························· ·························


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

