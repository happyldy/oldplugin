<?php
/**
 *
 */



namespace HappyLin\OldPlugin\Test\SPLTest;


use HappyLin\OldPlugin\SingleClass\SPL\{SPLFunctions, ArrayObject, Observer, Subject};


use HappyLin\OldPlugin\Test\TraitTest;
use HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits\System;




class SPLRootFileTest
{

    use TraitTest;
    use System;

    public function __construct()
    {

        //$this->SPLFunctionsTest();
        //$this->arrayObjectTest();
        //$this->observerDesignPatternTest();
        //$this->splTypeTest();
    }
    


    /**
     * @note 与类相关操作的函数
     */
    public function SPLFunctionsTest()
    {


        var_dump(static::toStr('类操作；返回指定的类实现的所有接口(implements); class_implements(new \RecursiveArrayIterator([]))', class_implements(new \RecursiveArrayIterator([]))));

        var_dump(static::toStr('类操作；返回指定类的父类(extends);  class_parents(new \RecursiveArrayIterator([]))', class_parents(new \RecursiveArrayIterator([]))));

        var_dump(static::toStr('类操作；返回给定类使用的特征(use trait-class);  class_uses( $this)', class_uses( $this)));



        $arrayIterator = new \ArrayIterator(array("Apples", "Bananas", "Cherries"));

        var_dump(static::toStr('定义一对象；$arrayIterator = new \ArrayIterator(array("Apples", "Bananas", "Cherries"))',$arrayIterator));

        var_dump(static::toStr('类操作；返回指定对象的hash id;对同一个对象它总是相同  spl_object_hash($arrayIterator)',spl_object_hash($arrayIterator)));

        var_dump(static::toStr('类操作；返回指定对象的hash id;对同一个对象它总是相同( 对象 ID 在对象的生命周期内是唯一的)  spl_object_id($arrayIterator)',spl_object_id($arrayIterator)));

        var_dump(static::toStr('迭代器操作；为迭代器中每个元素调用一个用户自定义函数 iterator_apply()
        iterator_apply(
            $arrayIterator,
            function(\Iterator $iterator) {echo strtoupper($iterator->current()) . "\n";return TRUE;},
            array($arrayIterator)
        );'));
        iterator_apply(
            $arrayIterator,
            function(\Iterator $iterator) {echo strtoupper($iterator->current()) . "\n";return TRUE;},
            array($arrayIterator)
        );

        var_dump(static::toStr('迭代器操作；计算迭代器中元素的个数 iterator_count(); iterator_count($arrayIterator)',iterator_count($arrayIterator)));


        var_dump(static::toStr('迭代器操作；将迭代器中的元素拷贝到数组 iterator_to_array(); iterator_to_array($arrayIterator)',iterator_to_array($arrayIterator)));


        var_dump(static::toStr('自动装载操作； 注册并返回 spl_autoload 函数使用的默认文件扩展名 spl_autoload_extensions([ string $file_extensions] ); '));

        var_dump(static::toStr('自动装载操作； 注册给定的函数作为 __autoload 的实现 spl_autoload_register([ callable $autoload_function[, bool $throw = true[, bool $prepend = false]]] ) : bool '));

        var_dump(static::toStr('自动装载操作； 注销已注册的 __autoload() 函数 spl_autoload_unregister( mixed $autoload_function) : bool'));


        var_dump(static::toStr('自动装载操作；返回所有已注册的 __autoload() 函数 spl_autoload_functions(); '));

        var_dump(static::toStr('自动装载操作；__autoload()函数的默认实现 spl_autoload( string $class_name[, string $file_extensions] ) : void'));


        var_dump(static::toStr('返回所有可用的SPL类 spl_classes()'));

    }


    /**
     * @note \ArrayObject 类允许对象作为数组使用。
     */
    public function arrayObjectTest()
    {
        $array = array('1' => 'one',
            '2' => 'two',
            '3' => 'three');
        $arrayObject = new ArrayObject($array);
        var_dump(static::toStr("初始化 \$arrayObject = new ArrayObject(". var_export($array,true) .")",$arrayObject));

        $arrayNew = array('0' => 'foo',
            '1' => 'bar',
            '2' => 'baz');
        $arrayObject->exchangeArray($arrayNew);
        var_dump(static::toStr("将当前数组与另一个数组或对象交换 \$arrayObject->exchangeArray(". var_export($arrayNew,true) .")",$arrayObject));

        var_dump(static::toStr("获取 ArrayObject 的迭代器类名 \$arrayObject->getIteratorClass()",$arrayObject->getIteratorClass()));

        var_dump(static::toStr("实例创建一个新的迭代器 \$arrayObject->getIterator()",$arrayObject->getIterator()));

        $arrayObject->setIteratorClass('HappyLin\OldPlugin\SingleClass\SPL\Iterators\ArrayIterator');
        var_dump(static::toStr("设置 ArrayObject 的迭代器类名 \$arrayObject->setIteratorClass('HappyLin\OldPlugin\SingleClass\SPL\Iterators\ArrayIterator')"));

        var_dump(static::toStr("获取 ArrayObject 的迭代器类名 \$arrayObject->getIteratorClass()",$arrayObject->getIteratorClass()));

        var_dump(static::toStr("实例创建一个新的迭代器 \$arrayObject->getIterator()",$arrayObject->getIterator()));


        var_dump('其余setFlags，asort，natsort 等和ArrayIterator()一样，不写了');

    }


    /**
     * @note 继承SplSubject； 自定 观测者 类函数测试
     */
    public function observerDesignPatternTest()
    {
        $observer = new Observer();
        $subject = new Subject();

        var_dump(static::toStr('观测者初始状态；',$observer));
        var_dump(static::toStr('被观测者初始状态；',$subject));

        var_dump(static::toStr('被观测者添加一个观察者 SplObserver，以便它可以收到更新通知。$subject->attach($observer);',$subject->attach($observer)));

        var_dump(static::toStr('被观测者更新数据 $subject->updateData(\'$subject更新了数据\')',$subject->updateData('$subject更新了数据')));

        var_dump(static::toStr('观测者初始状态；',$observer));
        var_dump(static::toStr('被观测者初始状态；',$subject));

    }


//    public function splTypeTest()
//    {
//
//
//        $true = new \SplBool(true);
//        if ($true) {
//            echo "TRUE\n";
//        }
//
//        $false = new \SplBool;
//        if ($false) {
//            echo "FALSE\n";
//        }
//
//    }



}




