<?php
/**
 * 这个迭代器允许在遍历数组和对象时删除和更新值与键。
 * ArrayIterator  implements ArrayAccess  , SeekableIterator  , Countable  , Serializable
 */


namespace HappyLin\OldPlugin\SingleClass\SPL\Iterators;


use \ArrayIterator as AT;

/**
 * 这个迭代器允许在遍历数组和对象时删除和更新值与键。
 * 当你想多次遍历相同数组时你需要实例化 ArrayObject，然后让这个实例创建一个 ArrayIteratror 实例。当你想遍历相同数组时多次你需要实例 ArrayObject 并且让这个实例创建一个 ArrayIteratror 实例，然后使用foreach 或者手动调用 getIterator() 方法。
 * ArrayAccess  , SeekableIterator  , Countable  , Serializable
 *
 * 索引一旦被使用就被列入黑名单，即使它们未设置也不会再次使用。
 *
 * @package HappyLin\OldPlugin\SingleClass\SPL\Iterators
 */
class ArrayIterator extends AT
{


    /**
     * ArrayIterator constructor.
     * @param array $array 要迭代的数组或对象。
     * @param int $flags 控制 ArrayIterator 对象行为的标志。参见 ArrayIterator::setFlags()。
     * @throws InvalidArgumentException 如果除了数组或对象之外的任何东西被给出。
     */
    public function __construct($array = array(), $flags = 0)
    {
        parent::__construct($array, $flags);
    }


    /**
     * 新的 ArrayIterator 行为。它采用位掩码或命名常量。强烈鼓励使用命名常量以确保未来版本的兼容性。
     *
     * $flags
     *  ArrayIterator::STD_PROP_LIST
     *      当作为列表（var_dump、foreach 等）访问时，对象的属性具有其正常功能。
     *  ArrayIterator::ARRAY_AS_PROPS
     *      可以通过属性访问条目（读写都支持）。
     *
     * @param string $flags
     */
    public function setFlags($flags): void
    {
        parent::setFlags($flags);
    }

    /**
     * 获取 ArrayIterator 的行为标志。 有关可用标志的列表，请参阅 ArrayIterator::setFlagsmethod。
     * @return int 返回 ArrayIterator 的行为标志
     */
    public function getFlags():int
    {
        return parent::getFlags();
    }



    /**
     * 附加值作为最后一个元素。
     * @param mixed $value
     */
    public function append($value):void
    {
        parent::append($value);
    }



    /**
     * 按值对数组进行排序。
     * @param int $flags
     */
    public function asort($flags = SORT_REGULAR): void
    {
        parent::asort($flags);
    }

    /**
     * 按键对数组进行排序
     * @param int $flags
     */
    public function ksort($flags = SORT_REGULAR): void
    {
        parent::ksort($flags);
    }

    /**
     * 使用“自然顺序”算法按值对条目进行排序
     */
    public function natsort(): void
    {
        parent::natsort();
    }

    /**
     * 使用不区分大小写的“自然顺序”算法按值对条目进行排序。
     */
    public function natcasesort(): void
    {
        parent::natcasesort();
    }


    /**
     * 此方法使用用户定义的比较函数对元素进行排序，以便索引保持它们与其关联的值的相关性。
     * 如果两个成员完全相同，那么它们在排序数组中的相对顺序是未定义的。
     * @param callable $callback callback ( mixed $a, mixed $b ) : int
     */
    public function uasort($callback)
    {
        parent::uasort($callback);
    }

    /**
     * 此方法使用用户提供的比较函数按关键字对元素进行排序。
     * 如果两个成员完全相同，那么它们在排序数组中的相对顺序是未定义的。
     * @param callable $callback callback ( mixed $a, mixed $b ) : int
     */
    public function uksort($callback)
    {
        parent::uksort($callback);
    }

    /**
     * 获取数组的副本
     * @return array
     */
    public function getArrayCopy():array
    {
        return parent::getArrayCopy();
    }



    /**
     * 统计元素数
     *
     * @return int 返回堆中的元素数。
     */
    public function count():int
    {
        return parent::count();
    }


    /**
     * 寻求定位
     * @param int $offset 要寻求的位置。
     */
    public function seek($offset): void
    {
        parent::seek($offset);
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

