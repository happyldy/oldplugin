<?php
/**
 *
 *
 */



namespace HappyLin\OldPlugin\Test\SPLTest;


use HappyLin\OldPlugin\SingleClass\SPL\Datastructures\{DoublyLinkedList, Heap, PriorityQueue,FixedArray, ObjectStorage};
use HappyLin\OldPlugin\Test\TraitTest;
use HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits\System;


class DatastructuresTest
{

    use TraitTest;
    use System;

    public function __construct()
    {

        //$this->doublyLinkedListTest();
        //$this->heapTest();
        //$this->priorityQueueTest();
        //$this->fixedArrayTest();
        //$this->objectStorageTest();
    }
    



    /**
     * @note 双链接列表 SplDoublyLinkedList
     */
    public function doublyLinkedListTest()
    {
        $dataSet = [
            ['id' => 1],
            ['id' => 2],
            ['id' => 4],
            ['id' => 5],
        ];

        $doublyLinkedList = new DoublyLinkedList();
        // 设置迭代模式，队列样式 删除
        $doublyLinkedList->setIteratorMode($doublyLinkedList::IT_MODE_FIFO | $doublyLinkedList::IT_MODE_KEEP);

        var_dump("迭代模式:队列样式-" . $doublyLinkedList->getIteratorMode());
        foreach ($dataSet as $row) {
            // 末尾加数据
            $doublyLinkedList->push($row);
        }
        var_dump(static::toStr('末尾添加数据', $dataSet));

        // 向指定位置加数据
        $doublyLinkedList->add(2,['id'=>3]);
        var_dump(static::toStr('向指定位置下标2加数据', ['id'=>3]));

        // 向开头加数据
        $doublyLinkedList->unshift(['id'=>0]);

        var_dump(static::toStr('向开头加数据', ['id'=>0]));

        var_dump($doublyLinkedList);


        var_dump(static::toStr("双链接列表中的元素数", $doublyLinkedList->count()));


        while (!$doublyLinkedList->isEmpty()){
            // var_dump(static::toStr("弹出尾部数据", $doublyLinkedList->pop()));
            var_dump(static::toStr("弹出开头数据", $doublyLinkedList->shift()));

        }

        // var_dump(static::toStr("索引下标", $doublyLinkedList->key()));
        // var_dump(static::toStr("检查双向链表是否为空", $doublyLinkedList->isEmpty()));
        // var_dump(static::toStr("获取开头数据", $doublyLinkedList->bottom()));
        // var_dump(static::toStr("弹出开头数据", $doublyLinkedList->shift()));


        // var_dump("迭代器索引回到开始" . $doublyLinkedList->rewind());
        // /**   下面都依赖 rewind方法；Iterator（迭代器）接口； 还有ArrayAccess（数组式访问）接口 不写了   */
        // var_dump(static::toStr("双链接列表是否包含更多节点", $doublyLinkedList->valid()));
        // var_dump(static::toStr("当前索引位置数据", $doublyLinkedList->current()));
        // var_dump(static::toStr("移动到下一个节点", $doublyLinkedList->next()));// 模式为IT_MODE_DELETE时 一样删除数据
        // var_dump(static::toStr("移动到上一个节点", $doublyLinkedList->prev()));// 模式为IT_MODE_DELETE时 一样删除数据

    }




    /**
     *  @note 堆 SplHeap 需要自己写compare方法, 排序的堆
     */
    public function heapTest()
    {
        // 需要自己写compare方法；
        $heap = new Heap();

        $heap->insert('E');
        $heap->insert('B');
        $heap->insert('D');

        var_dump("给堆添加数据‘E’、‘B’,'D'");

        var_dump(static::toStr("堆数量", $heap->count()));

        var_dump(static::toStr("堆是否损坏", $heap->isCorrupted()));


        var_dump("extract从堆的顶部提取一个节点并进行筛选，打印");
        // extract使用后数据删除
        while(!$heap->isEmpty())
        {
            echo $heap->extract(), PHP_EOL;
            // 如果堆已损坏
            if($heap->isCorrupted()){
                $heap->recoverFromCorruption();
            }
        }

        var_dump(static::toStr("堆数量", $heap->count()));

        $heap->insert('h');
        $heap->insert('k');
        $heap->insert('l');

        var_dump("给堆添加数据‘h’、‘k’,'l'; foreach 打印：");
        // foreach使用后数据删除 就是next后删除数据
        foreach ($heap as $v) echo($v), PHP_EOL;
        //var_dump($heap);

        var_dump(static::toStr("堆数量", $heap->count()));


        //它有两个子集 SplMaxHeap类提供堆的主要功能，将最大值保持在顶部。SplMinHeap类提供堆的主要功能，将最小值保持在顶部。

        // $heap = new \SplMaxHeap(); # Ascending order
        // $heap->insert('E');
        // $heap->insert('B');
        // $heap->insert('D');
        // $heap->insert('A');
        // $heap->insert('C');
        // $heap->insert('O');
        // echo $heap->extract(), PHP_EOL; # E
        // echo $heap->extract(), PHP_EOL; # D
        // echo $heap->top(), PHP_EOL; # E

        // $heap = new \SplMinHeap(); # Descending order
        // $heap->insert('E');
        // $heap->insert('B');
        // $heap->insert('D');
        // $heap->insert('A');
        // $heap->insert('C');
        // $heap->insert('O');
        // print PHP_EOL;
        // echo $heap->extract(), PHP_EOL; # A
        // echo $heap->extract(), PHP_EOL; # B
        // echo $heap->top(), PHP_EOL; # C


    }


    /**
     * @note SplPriorityQueue 类提供优先队列的主要功能，使用最大堆实现。就是有优先级的堆(自带compare方法)
     *
     */
    public function priorityQueueTest()
    {
        // 用法和heap堆一样， 它多了个设置模式 并要指定优先级数值，而不是自己写compare方法
        $priorityQueue = new PriorityQueue();

        $priorityQueue->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);


        var_dump($priorityQueue->getExtractFlags());

        $priorityQueue->insert('E', 1);
        $priorityQueue->insert('B', 2);
        $priorityQueue->insert('D', 3);

        var_dump("给堆添加数据‘E’、‘B’,'D'");

        var_dump(static::toStr("堆数量", $priorityQueue->count()));

        var_dump(static::toStr("堆是否损坏", $priorityQueue->isCorrupted()));


        var_dump("extract从堆的顶部提取一个节点并进行筛选，打印");
        // extract使用后数据删除
        while(!$priorityQueue->isEmpty())
        {
            var_export($priorityQueue->extract()) ;
            // 如果堆已损坏
            if($priorityQueue->isCorrupted()){
                $priorityQueue->recoverFromCorruption();
            }
        }
    }


    /**
     * @note 和普通 PHP 数组的主要区别在于 SplFixedArray 是固定长度的，
     */
    public function fixedArrayTest()
    {
        // 创建实例
        $fixedArray = new FixedArray(5);

        $fixedArray[0] = 1;
        $fixedArray[1] = FixedArray::fromArray([1,2]);


        var_dump('添加数据$fixedArray[0] = 1');
        var_dump('添加数据$fixedArray[1] = FixedArray::fromArray([1,2]');

        var_dump($fixedArray);

        var_dump(static::toStr('数组大小', $fixedArray->getSize()));
        var_dump(static::toStr('设置数组大小为10', $fixedArray->setSize(10)));
        var_dump(static::toStr('数组大小', $fixedArray->getSize()));

        var_dump(static::toStr('从固定数组中返回一个PHP 数组', $fixedArray->toArray()));

//        $m = static::memoryGetPeakUsage();
//
//        // 占内存152992 bytes
//        $fixedArray = new FixedArray(1200);
//        for($i=0; $i<1200; $i++){
//            $fixedArray[$i] = FixedArray::fromArray([$i]);
//        }
//
//        // 占内存481056 bytes
//        $fixedArray = [];
//        for($i=0; $i<1200; $i++){
//            $fixedArray[$i] = [$i];
//        }
//
//        echo "total memory comsuption: " . (static::memoryGetPeakUsage() - $m) . " bytes\n";

    }


    /**
     * @note ObjectStorage 类提供从对象到数据的映射，或者通过忽略数据提供对象集。
     */
    public function objectStorageTest()
    {
        $objectStorage = new ObjectStorage();

        $object1 = new \StdClass();
        $object2 = new \StdClass();


        var_dump(static::toStr('在存储中添加一个对象$object1。', $objectStorage->attach($object1)));
        var_dump(static::toStr('在存储中添加一个对象$object1，并可选择将其与"hello"数据相关联。',$objectStorage->attach($object2, "hello")));

        var_dump(static::toStr('读取$object1关联数据', $objectStorage[$object1]));
        var_dump(static::toStr('读取$object2关联数据', $objectStorage[$object2]));
        var_dump(static::toStr('获取$object2对象的标识符', $objectStorage->getHash($object2)));

        $objectStorage->rewind();

        var_dump(static::toStr('当前的节点', $objectStorage->current()));
        var_dump(static::toStr('修改当前的节点关联数据为”hello world“', $objectStorage->setInfo('hello world')));
        var_dump(static::toStr('读取当前的节关联数据', $objectStorage->getInfo($object2)));




        //$objectStorage02 = clone $objectStorage;
        $objectStorage02 = new ObjectStorage();
        var_dump(static::toStr('$objectStorage02 添加 $objectStorage所有数据', $objectStorage02->addAll($objectStorage)));

        var_dump(static::toStr('$objectStorage02对象：'));
        var_dump($objectStorage02);


        var_dump(static::toStr("检查\$objectStorage存储是否包含提供的对象\$object1", $objectStorage->contains($object1)));
        var_dump(static::toStr("从\$objectStorage存储中删除对象\$object1", $objectStorage->detach($object1)));
        var_dump(static::toStr("检查\$objectStorage存储是否包含提供的对象\$object1", $objectStorage->contains($object1)));


        // removeAllExcept 与 removeAll相反
        var_dump(static::toStr('$objectStorage02 删除 $objectStorage中有的数据:', $objectStorage02->removeAll($objectStorage)));

        var_dump($objectStorage02);


    }










}















