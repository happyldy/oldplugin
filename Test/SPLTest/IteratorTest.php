<?php
/**
 *
 * 预定义接口
 *  Traversable {}                              // 检测一个类是否可以使用 foreach 进行遍历的接口。
 *  Iterator  extends Traversable{}             // （迭代器）接口
 *  IteratorAggregate  extends Traversable      // （聚合式迭代器）接口
 *  ArrayAccess {}                              // 提供像访问数组一样访问对象的能力的接口
 *  Serializable {}                             // 自定义序列化的接口。实现此接口的类将不再支持 __sleep() 和 __wakeup()。
 *  Closure {}                                  // 匿名函数的类.
 *
 *
 * ›SPL>接口
 *  Countable {}                            // 可被用于 count() 函数.
 *  OuterIterator  extends Iterator {}      // 用于迭代器上的迭代器
 *  RecursiveIterator  extends Iterator {}  // 实现递归迭代器的类可以用来递归地迭代迭代器。
 *  SeekableIterator  extends Iterator {}   // 可查找的迭代器。
 *
 *
 */



namespace HappyLin\OldPlugin\Test\SPLTest;


use HappyLin\OldPlugin\SingleClass\SPL\Iterators\{
    AppendIterator,
    IteratorIterator,
    ArrayIterator,
    CachingIterator,
    RecursiveDirectoryIterator,
    CallbackFilterIterator,
    RecursiveIteratorIterator,
    MultipleIterator,
    RecursiveTreeIterator,
    RegexIterator
};
use HappyLin\OldPlugin\Test\TraitTest;
use HappyLin\OldPlugin\SingleClass\Url;
use HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits\System;
use Symfony\Component\HttpKernel\EventListener\ValidateRequestListener;


class IteratorTest
{

    use TraitTest;
    use System;

    public function __construct()
    {
        $this->fileSaveDir = static::getTestDir() . '/Public/SingleClass';


        //InfiniteIterator 允许在迭代器上无限迭代，而无需在到达终点时手动倒带迭代器。
        //NoRewindIterator 此迭代器忽略倒带操作。 这允许在多个部分 foreach 循环中处理迭代器。
    }


    /**
     * MultipleIterator  implements Iterator
     * @note 对所有附加的迭代器进行顺序迭代的迭代器 (其实就是同索引的混合成一个数组，形成多维迭代器)
     */
    public function multipleIteratorTest()
    {
        $people = new ArrayIterator(array('John', 'Jane', 'Jack', 'Judy'));
        $roles  = new ArrayIterator(array('Developer', 'Scrum Master', 'Project Owner'));
        $salary   = new ArrayIterator(array(5000, 8000, 10000));

        $multipleIterator = new MultipleIterator();
        $multipleIterator->attachIterator($people, 'person');
        $multipleIterator->attachIterator($roles, 'role');
        $multipleIterator->attachIterator($salary , 'salary');


        var_dump(static::toStr('附加迭代器信息 $people', $people));
        var_dump(static::toStr('附加迭代器信息 $roles', $roles));
        var_dump(static::toStr('附加迭代器信息 $salary', $salary));

        var_dump(static::toStr('获取附加的迭代器实例数', $multipleIterator->countIterators()));

        foreach ($multipleIterator as $member) {
            print_r($member);
            echo "<br>";
        }

        var_dump(static::toStr('检查是否附加了迭代器$salary', $multipleIterator->containsIterator($salary)));

        var_dump(static::toStr('移除迭代器$salary', $multipleIterator->detachIterator($salary)));

        var_dump(static::toStr('设置标志 MI::MIT_NEED_ANY | MI::MIT_KEYS_ASSOC', $multipleIterator->setFlags(MultipleIterator::MIT_NEED_ANY | MultipleIterator::MIT_KEYS_ASSOC)));

        var_dump(static::toStr('获取附加的迭代器实例数', $multipleIterator->countIterators()));

        foreach ($multipleIterator as $member) {
            print_r($member);
            echo "<br>";
        }

    }










    /**
     * ArrayIterator  implements ArrayAccess  , SeekableIterator  , Countable  , Serializable
     * @note 数组迭代 加了排序
     */
    public function arrayIteratorTest()
    {
        $arrayIterator = new ArrayIterator(array('c', 'a', 'b', 'attr'=>1));
        var_dump($arrayIterator);
        var_dump(static::toStr('添加数据”d“', $arrayIterator->append('d')));

        //var_dump(static::toStr('设置 ArrayIterator 的行为标志（var_dump、foreach 等）'. ArrayIterator::STD_PROP_LIST , $arrayIterator->setFlags(ArrayIterator::STD_PROP_LIST)));
        //var_dump(static::toStr('获取 ArrayIterator 的行为标志', $arrayIterator->getFlags()));

        var_dump(static::toStr('设置 ArrayIterator 的行为标志（通过属性访问条目（读写都支持））'. ArrayIterator::ARRAY_AS_PROPS , $arrayIterator->setFlags(ArrayIterator::ARRAY_AS_PROPS)));
        var_dump(static::toStr('获取 ArrayIterator 的行为标志', $arrayIterator->getFlags()));
        var_dump(static::toStr('获取 数组中 attr值 $arrayIterator->attr', $arrayIterator->attr));

        var_dump($arrayIterator);

        var_dump(static::toStr('使用“自然顺序”算法按值对条目进行排序', $arrayIterator->natsort()));

        var_dump($arrayIterator);

        var_dump(static::toStr('获取数组的副本', $arrayIterator->getArrayCopy()));

    }






    /**
     * IteratorIterator  implements OuterIterator
     * @note 这个迭代器包装器允许将任何可遍历的东西转换为迭代器。 它只能用做基类，参数就可遍历不需要它
     *
     */
    public function iteratorIteratorTest()
    {
        //$iteratorIterator = new IteratorIterator(range(1,10));


        $aa = new class implements \Iterator
        {
            private $position = 0;
            private $container = array();

            public function __construct() {
                $this->container = array(
                    "zero",
                    "one" ,
                    "two",
                    "three",
                );
            }

            function rewind() {
                $this->position = 0;
            }

            function current() {
                return $this->container[$this->position];
            }

            function key() {
                return $this->position;
            }

            function next() {
                ++$this->position;
            }

            function valid() {
                return isset($this->container[$this->position]);
            }
        };

        $iteratorIterator = new IteratorIterator($aa);

        var_dump($iteratorIterator);

        foreach ($iteratorIterator as $item) {
            var_dump($item);
        }

        //var_dump($iteratorIterator->valid());

    }

    /**
     * 继承自 IteratorIterator
     * @note 可以用来集中多个迭代器集中处理
     */
    public function appendIteratorTest()
    {
        $appendIterator = new AppendIterator();

        var_dump($appendIterator);

        $array_a = new \ArrayIterator(array('a', 'b', 'c'));
        $array_b = new \ArrayIterator(array('d', 'e', 'f'));

        var_dump(static::toStr('添加迭代器ArrayIterator(array(\'a\', \'b\', \'c\')', $appendIterator->append($array_a)));
        var_dump(static::toStr('添加迭代器ArrayIterator(array(\'d\', \'e\', \'f\')', $appendIterator->append($array_a)));


        $appendIterator->rewind();

        var_dump(static::toStr('foreach 打印如下：'));
        foreach ($appendIterator as $current) {
            echo $current;
        }
        var_dump(static::toStr('重置迭代器位置', $appendIterator->rewind()));
        var_dump(static::toStr('获取已添加的迭代器', $appendIterator->getArrayIterator()));
        var_dump(static::toStr('获取当前的迭代器', $appendIterator->getInnerIterator()));
        var_dump(static::toStr('获取当前的迭代器索引', $appendIterator->getIteratorIndex()));

    }


    /**
     * CachingIterator  extends IteratorIterator  implements OuterIterator  , ArrayAccess  , Countable
     * @note 可以用来测试迭代器迭代流程
     */
    public function cachingIteratorTest()
    {
        $iterator = new ArrayIterator(array('a', 'b', 'c'));

        $cachingIterator = new CachingIterator($iterator,CachingIterator::FULL_CACHE);

        var_dump(static::toStr('获取实例FULL_CACHE的标志的位掩码', $cachingIterator->getFlags()));

        foreach ($cachingIterator as $value) {
            echo $value;
            if ($cachingIterator->hasNext()) {
                echo ', ';
            }
        }

        var_dump(static::toStr('检索缓存的内容', $cachingIterator->getCache()));


        var_dump(static::toStr('设置实例的标志的位掩码CALL_TOSTRING', $cachingIterator->setFlags(CachingIterator::CALL_TOSTRING)));
        var_dump(static::toStr('获取实例的标志的位掩码', $cachingIterator->getFlags()));


        var_dump(static::toStr('重置迭代器索引', $cachingIterator->rewind()));
        var_dump(static::toStr('获取缓存 echo $cachingIterator'));
        echo $cachingIterator;


        var_dump(static::toStr('设置实例的标志的位掩码TOSTRING_USE_KEY出错，只能重新new一个'));

        $cachingIterator = new CachingIterator($iterator,CachingIterator::TOSTRING_USE_KEY);


        var_dump(static::toStr('获取实例的标志的位掩码', $cachingIterator->getFlags()));

        var_dump(static::toStr('重置迭代器索引', $cachingIterator->rewind()));
        var_dump(static::toStr('获取缓存 echo $cachingIterator'));
        echo $cachingIterator;


    }



    /**
     * LimitIterator  extends IteratorIterator  implements OuterIterator
     * @note LimitIterator类允许遍历一个 Iterator 的限定子集的元素.
     *
     * 比 IteratorIterator 多了  getPosition() : int（获取内部迭代器的当前从零开始的位置。）
     *
     */
    public function limitIteratorTest()
    {
        $fruits = array(
            'a' => 'apple',
            'b' => 'banana',
            'c' => 'cherry',
            'd' => 'damson',
            'e' => 'elderberry'
        );
        $array_it = new ArrayIterator($fruits);


        /**
         * 限制的可选偏移量。
         */
        $offset  = 2;
        /**
         * 限制的可选计数。
         */
        $count = 3;
        /**
         * 如果偏移量小于 0 或计数小于 -1，则抛出 OutOfRangeException。
         */
        $limitIterator = new \LimitIterator($array_it, $offset, $count );


        foreach ($limitIterator as $item) {
            echo $limitIterator->getPosition() . ' ' . $item . "\n<br>";
        }
    }







    /**
     * RecursiveIteratorIterator  implements OuterIterator
     *
     * @note 比iteratorIterator多了深度， 当然参数也需要继承RecursiveIterator
     */
    public function recursiveIteratorIteratorTest()
    {

        $array = array(
            array(
                array(
                    array(
                        'leaf-0-0-0-0',
                        'leaf-0-0-0-1'
                    ),
                    'leaf-0-0-0'
                ),
                array(
                    array(
                        'leaf-0-1-0-0',
                        'leaf-0-1-0-1'
                    ),
                    'leaf-0-1-0'
                ),
                'leaf-0-0'
            )
        );

        var_dump($array);

        $recursiveIteratorIterator = new RecursiveIteratorIterator(new \RecursiveArrayIterator($array), RecursiveIteratorIterator::LEAVES_ONLY);

        foreach ($recursiveIteratorIterator as $key => $leaf) {
            //var_dump($recursiveIteratorIterator->getSubIterator() );
            //var_dump($recursiveIteratorIterator->getInnerIterator());
            echo "$key => $leaf <br>", PHP_EOL;
        }

    }


    /**
     * @note RecursiveTreeIterator  extends RecursiveIteratorIterator  implements OuterIterator 没啥用
     */
    public function recursiveTreeIteratorTest()
    {

        $it = new \RecursiveArrayIterator(array(1, 2, array(3, 4, array(5, 6, 7), 8), 9, 10));
        $tit = new RecursiveTreeIterator($it);

        foreach( $tit as $key => $value ){
            echo $value . PHP_EOL ."<br>";
        }



    }





    /**
     * FilesystemIterator  extends DirectoryIterator  implements SeekableIterator
     * DirectoryIterator  extends SplFileInfo  implements SeekableIterator [DirectoryIterator只比SplFileInfo 多了个isDot方法]
     * @note 展示某文件夹下的文件及其信息 FilesystemIterator
     */
    public function filesystemIteratorTest()
    {
        $dirName = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR . '/SingleClass';

        $filesystemIterator = new \FilesystemIterator($dirName);

        foreach ($filesystemIterator as $fileinfo) {
            echo $fileinfo->getFilename() . "\n<br>";
        }

    }

    /**
     * GlobIterator  extends FilesystemIterator  implements SeekableIterator  , Countable
     *
     * @note 相对与FilesystemIterator只是在构造函数时将文件路劲变成匹配规则
     *
     * 遍历一个文件系统行为类似于 glob().
     */
    public function globIteratorTest()
    {
        //var_dump(glob(HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR . '/SingleClass/*.txt'));

        //A glob() pattern.
        $pattern = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR . '/SingleClass/*.txt';

        // Option flags, the flags may be a bitmask of the FilesystemIterator constants.
        $flags = \FilesystemIterator::KEY_AS_FILENAME | \FilesystemIterator::CURRENT_AS_SELF | \FilesystemIterator::SKIP_DOTS;

        $iterator = new \GlobIterator($pattern, $flags);

        if (!$iterator->count()) {
            echo 'No matches';
        } else {
            $n = 0;

            printf("查找*.txt的数量Matched %d \r\n<br>", $iterator->count());

            foreach ($iterator as $item) {
                printf("[%d] %s\r\n<br>", ++$n, $iterator->key());
            }
        }

    }



    /**
     * RecursiveDirectoryIterator  extends FilesystemIterator  implements SeekableIterator  , RecursiveIterator
     *
     * @note 比 FilesystemIterator 多了关键的 getChildren 用于递归
     */
    public function recursiveDirectoryIteratorTest()
    {
        //$dirName = $this->fileSaveDir;
        $dirName = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR . '/SingleClass';

        $recursiveDirectoryIterator = new RecursiveDirectoryIterator($dirName);

        var_dump(static::toStr('设置处理标志', $recursiveDirectoryIterator->setFlags(\FilesystemIterator::KEY_AS_FILENAME | \FilesystemIterator::CURRENT_AS_SELF | \FilesystemIterator::SKIP_DOTS)));


        $recursiveDirectoryIterator->next();
        $recursiveDirectoryIterator->next();

        var_dump(static::toStr('返回相对于构造函数中给定目录的子路径', $recursiveDirectoryIterator->getSubPath()));
        var_dump(static::toStr('获取子路径和文件名', $recursiveDirectoryIterator->getSubPathname()));



        var_dump(static::toStr('返回当前条目是否是目录而不是 \'.\' 或者 \'..\' ', $recursiveDirectoryIterator->hasChildren()));
        var_dump(static::toStr('如果当前条目是目录，则返回当前条目的迭代器 ', $recursiveDirectoryIterator->isDir() && $recursiveDirectoryIterator->getChildren()));


        //var_dump(is_dir('./SingleClass\ceshi.avi'));die();

        foreach ( $recursiveDirectoryIterator as $key=>$item){
            //var_dump($key,$item);

            echo 'SubPathName: ' . $recursiveDirectoryIterator->getSubPathName() . "\n";
            echo 'SubPath:     ' . $recursiveDirectoryIterator->getSubPath() . "\n\n";

            echo "<br>";

            if($item->isDir() && $item->hasChildren()){
                $recursiveDirectoryIteratorChild = $item->getChildren();
                foreach ( $recursiveDirectoryIteratorChild as $k=>$i){
                    echo "<br>获取子集";
                    //var_dump($i);
                    echo 'SubPathName: ' . $recursiveDirectoryIteratorChild->getSubPathName() . "\n";
                    echo 'SubPath:     ' . $recursiveDirectoryIteratorChild->getSubPath() . "\n\n";
                    echo "<br>";
                }
            }
        }

    }


    /**
     * CallbackFilterIterator  extends FilterIterator  implements OuterIterator
     *  abstract FilterIterator  extends IteratorIterator  implements OuterIterator
     *  @note 从FilterIterator对象从写accept方法改成传入回调函数; 但它的深度只有一层
     */
    public function callbackFilterIteratorTest()
    {
        $dirName = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR . '/SingleClass';

        $filesystemIterator = new \FilesystemIterator($dirName);

        $large_files = new CallbackFilterIterator($filesystemIterator, function ($current) {
            return $current->isFile() && $current->getSize() > 104857600;
        });

        echo "打印文件大小大于104857600的文件<br>";
        foreach ($large_files as $file) var_dump($file);


        // Filter directories
        $files = new CallbackFilterIterator($filesystemIterator, function ($current, $key, $iterator) {
            return $current->isDir() && ! $iterator->isDot();
        });

        echo "打印所有文件<br>";
        foreach ($files as $file) var_dump($file);

    }


    /**
     * @note  RegexIterator  extends FilterIterator
     */
    public function regexIteratorTest()
    {

//        $names = new ArrayIterator(array('Ann', 'Bob', 'Charlie', 'David'));
//
//        $regexIterator = new RegexIterator($names, '/^[B-D]/');
//        foreach ($regexIterator as $name) {
//            echo $name . PHP_EOL;
//        }
//
//        var_dump(static::toStr('返回标志，有关可用标志的列表', $regexIterator->getFlags()));


        $test = array ('str1' => 'test 1', 'teststr2' => 'another test', 'str3' => 'test 123');
        $arrayIterator = new ArrayIterator($test);


        $regexIterator = new RegexIterator($arrayIterator, '/^test.*(\d+)/');
        var_dump(static::toStr("此迭代器可用于根据正则表达式过滤另一个迭代器。默认配置时：\n\$regexIterator = new RegexIterator( ". var_export($arrayIterator,true) .", '/^test.*(\d+)/'); \n结果："));

        foreach ($regexIterator as $key => $value) {
            echo $key . ' => ' . $value . "\n<br>";
        }


        var_dump(static::toStr("设置标志。 setFlags(RegexIterator::USE_KEY); 匹配输入键而不是输入值；\n结果："));
        $regexIterator->setFlags(RegexIterator::USE_KEY);
        foreach ($regexIterator as $key => $value) {
            echo $key . ' => ' . var_export($value,true) . "\n<br>";
        }


        var_dump(static::toStr("设置操作模式。 setMode(RegexIterator::GET_MATCH)；\n结果："));
        $regexIterator->setMode(RegexIterator::GET_MATCH);
        foreach ($regexIterator as $key => $value) {
            echo $key . ' => ' . var_export($value,true) . PHP_EOL;
        }

        var_dump(static::toStr("设置操作模式。 setMode(RegexIterator::ALL_MATCHES)；\n结果："));
        $regexIterator->setMode(RegexIterator::ALL_MATCHES);
        foreach ($regexIterator as $key => $value) {
            echo $key . ' => ' . var_export($value,true) . PHP_EOL;
        }


        var_dump(static::toStr("设置操作模式。 setMode还有 RegexIterator::REPLACE 和 RegexIterator::SPLIT； 
        以及 setPregFlags 的 PREG_OFFSET_CAPTURE PREG_UNMATCHED_AS_NULL PREG_PATTERN_ORDER PREG_SET_ORDER 
        参阅 ：HappyLin\OldPlugin\Test\TextProcessingTest下的方法[PCREModelTest，PCRETest]"));

    }



    /**
     * RecursiveFilterIterator  extends FilterIterator  implements OuterIterator  , RecursiveIterator
     *
     * @note 比CallbackFilterIterator多了RecursiveIterator ; 它可以递归判断子集
     *
     * 可用于遍历递归迭代器。
     *
     */
    public function recursiveFilterIteratorTest()
    {
        $array    = array("test1", array("check2", "test3",array("check4", "test5"), "test6"), "test7", 'check8', "test9");
        $recursiveIterator = new \RecursiveArrayIterator($array);


        $recursiveFilterIterator = new class($recursiveIterator) extends \RecursiveFilterIterator {

            public function accept() {
                return $this->hasChildren() || (strpos($this->current(), "test") !== FALSE);
            }
        };


        foreach ($recursiveFilterIterator as $value)
        {
            var_dump($value);
        }


        foreach(new RecursiveIteratorIterator($recursiveFilterIterator) as $key => $value)
        {
            echo $value . "\n";
        }

    }


    /**
     * ParentIterator  extends RecursiveFilterIterator  implements RecursiveIterator  , OuterIterator
     *
     * @note 这个扩展的 FilterIterator 允许使用 RecursiveIteratorIterator(用于遍历递归迭代器) 进行递归迭代，只显示那些有子元素的元素
     *
     */
    public function parentIteratorTest()
    {

        $array    = array("test1", array("check2", "test3",array("check4", "test5"), "test6"), "test7", 'check8', "test9");
        $recursiveIterator = new \RecursiveArrayIterator($array);


        $parentIterator = new \ParentIterator($recursiveIterator);


        foreach ($parentIterator as $item){
           var_dump($item);
        }

        foreach(new RecursiveIteratorIterator($parentIterator) as $key => $value)
        {
            echo $value . "\n";
        }
    }




}




