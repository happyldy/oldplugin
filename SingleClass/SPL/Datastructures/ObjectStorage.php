<?php
/**
 * SplObjectStorage 类提供从对象到数据的映射，或者通过忽略数据提供对象集。
 * 在涉及唯一标识对象的需要的许多情况下，这种双重目的非常有用。
 * Countable  , Iterator  , Serializable  , ArrayAccess
 *
 */


namespace HappyLin\OldPlugin\SingleClass\SPL\Datastructures;


use \SplObjectStorage;

/**
 * Class ObjectStorage 类提供从对象到数据的映射，或者通过忽略数据提供对象集。
 * 在涉及唯一标识对象的需要的许多情况下，这种双重目的非常有用。
 * Countable  , Iterator  , Serializable  , ArrayAccess
 *
 * @package HappyLin\OldPlugin\SingleClass\SPL\Datastructures
 */
class ObjectStorage extends SplObjectStorage
{


    public function __construct()
    {
    }





    /**
     * 在存储中添加一个对象，并可选择将其与某些数据相关联。
     *
     * @param object $object 要添加的对象。
     * @param mixed $info 要与对象关联的数据。
     */
    public function attach($object, $info = null):void
    {
        parent::attach($object, $info);
    }



    /**
     * 检查存储是否包含提供的对象
     * @param object $object
     * @return bool 如果对象在存储中，则返回 TRUE，否则返回 FALSE。
     */
    public function contains($object):bool
    {
        return parent::contains($object);
    }


    /**
     * 从存储中删除对象。
     * @param object $object
     */
    public function detach($object):void
    {
        parent::detach($object);
    }






    /**
     * 计算包含对象的唯一标识符
     * 此方法计算添加到 SplObjectStorage 对象的对象的标识符。
     *
     * SplObjectStorage 中的实现返回与 spl_object_hash() 相同的值。
     *
     * 存储对象永远不会包含多个具有相同标识符的对象。因此，它可用于实现一组（唯一值的集合），其中唯一对象的质量取决于此函数返回的值 独特的。
     *
     * @param object $object
     * @return string 带有计算标识符的字符串。
     */
    public function getHash($object):string
    {
        return parent::getHash($object);
    }


    /**
     * 返回与当前迭代器位置指向的对象关联的数据或信息。
     * @return mixed 要与当前迭代器项关联的数据
     */
    public function getInfo()
    {
        return parent::getInfo();
    }

    /**
     * 设置与当前迭代器项关联的数据
     * @param mixed $info
     */
    public function setInfo($info):void
    {
        parent::setInfo($info);
    }


    /**
     * 在当前存储中添加来自不同存储的所有对象-数据对。
     * @param SplObjectStorage $storage 要导入的存储。
     */
    public function addAll($storage):void
    {
        parent::addAll($storage);
    }


    /**
     * 从当前存储器中删除另一存储器中包含的对象
     * @param SplObjectStorage $storage 包含要删除的元素的存储器
     */
    public function removeAll($storage):void
    {
        parent::removeAll($storage);
    }


    /**
     * 从当前存储中删除除其他存储中包含的对象以外的所有对象
     * @param SplObjectStorage $storage 包含要保留在当前存储器中的元素的存储器。
     */
    public function removeAllExcept($storage)
    {
        parent::removeAllExcept($storage);
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

