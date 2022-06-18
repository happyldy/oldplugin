<?php


namespace HappyLin\OldPlugin\Test\VariableAndTypeTest;

use HappyLin\OldPlugin\SingleClass\VariableAndType\Arrays;


use HappyLin\OldPlugin\Test\TraitTest;

use stdclass;


class ArraysTest
{

    use TraitTest;



    public function __construct()
    {

    }


    /**
     * @note 对数组整体操作： 填充 差集 交集
     */
    public function arraysTest()
    {
        $arr = range(1,5);
        $res = Arrays::shuffle($arr);
        var_dump(static::toStr('打乱数组;随机排列单元的顺序数组; 原数组 %s ；现数组： %s ', json_encode(range(1,5)),$arr, $res));

        $arr = ['a' => 97, 'B'=>66, ['foo' => 'foo','5'=>'bar'], 'D' => 68];

        var_dump(static::toStr('统计出数组里的所有元素的数量，或者对象里的东西; 模式：默认和递归；count 别名 sizeof； %s ', json_encode($arr), Arrays::count($arr,COUNT_RECURSIVE)));

        $arr = ['a' => 97, 'B'=>66, 'c' =>99, 'D' => 68];
        var_dump(static::toStr('统计次数;数组中所有的值出现次数; %s ', json_encode($arr), Arrays::arrayCountValues($arr)));

        var_dump(static::toStr('统计求和;对数组中所有值求和 ; %s ', json_encode($arr), Arrays::arraySum($arr)));

        var_dump(static::toStr('增；创建数组；根据范围创建数组，包含指定的元素; range( a, g, 2)', Arrays::range('a','g', 2 )));

        var_dump(static::toStr('增；创建数组；根据长度；开始索引，长度，固定值 ', Arrays::arrayFill(5,3, 'FillVal' )));


        var_dump(static::toStr('增；创建数组；根据键；keys索引数组，固定值 ', Arrays::arrayFillKeys(['foo', 5], 'FillVal' )));


        $arr = ['foo' => 'foo','5'=>'bar'];
        var_dump(static::toStr('增；创建副本；根据正负长度填充数组到指定长度；数字索引重置；[],+-size，固定值； ', $arr = Arrays::arrayPad($arr, 3,'FillVal' )));


        $arr = ["foo" => 9, 6 => 1, ];
        $arrBat = $arr;
        $res = Arrays::arrayUnshift($arr, 2,3);
        var_dump(static::toStr('增；在原数组开头插入一个或多个单元；数字索引重置；原数组： %s ;现数组： %s ; 结果：',json_encode($arrBat),json_encode($arr), $res));


        $arr = ['foo' => 'foo','5'=>'bar', 6 => 6];
        var_dump(static::toStr('删；弹出数组最后一个单元（出栈）；', Arrays::arrayPop($arr)));


        $arr = ["foo" => "foo","5"=>"bar", 6 => 6];
        $arrBat = $arr;
        $res = Arrays::arrayShift($arr);
        var_dump(static::toStr('删；弹出数组第一个单元；数字索引重置；原数组： %s ;现数组： %s ; 结果：', json_encode($arrBat),json_encode($arr), $res));

        $arr = ["foo" => "foo",5=>"bar", 6 => 6, 12 => 6, 'foobar'=>'foo'];
        var_dump(static::toStr('删；移除数组中重复的值；比较方式：字符串、数字;原数组： %s ;结果：', json_encode($arr),Arrays::arrayUnique($arr,SORT_REGULAR)));




        $arr = ["foo" => "foo","bar"=>"bar", 'foobar'=>'foobar'];
        $arrBat = $arr;
        $repaceArr  = ['Fill1'=>'FillVal1','Fill2'=>'FillVal2'];
        $res = Arrays::arraySplice($arr,1, 1,$repaceArr);
        var_dump(static::toStr(
            "数组增删改；根据替换长度; 引用原数组，填充数组不保留键名; \n 原数组： %s ; \n填充数组： %s  ;\n现数组： %s ; 结果：",
            json_encode($arrBat),
            json_encode($repaceArr),
            json_encode($arr),
            $res
        ));


        $arr = ['a' => 97, '66'=>'B', 'c' =>99, '68' => 'D'];
        var_dump(static::toStr('数组截取；根据长度; 模式：是否保留键名;', Arrays::arraySlice($arr,2, 2,true )));

        $arr = ['a' => 97, 'B'=>66, 'c' =>99, 'D' => 68];
        var_dump(static::toStr('数组分割截取；根据长度分割整个数组; 模式：是否保留键名;', Arrays::arrayChunk($arr,2, true )));



        var_dump(static::toStr('数组过滤；自定义回调函数; 修改原数组加引用符', Arrays::arrayFilter($arr,function ($value, $key)
        {
            if($value>=97){
                return false;
            }
            return true;
        }, ARRAY_FILTER_USE_BOTH )));

        var_dump(static::toStr(
            '遍历；自定义回调函数; 模式: 一个数组保留键名; 必须return;',
            Arrays::arrayMap(function ($value) {
                return sprintf('chr(%s) = %s', $value, chr($value));
            },
                $arr,
                $arr
            )
        ));



        var_dump(static::toStr(
            '遍历集和；自定义回调函数; 模式: 多数组重新创建索引；参数与数组数对应；否则为 null； 必须return; ["a"=> 1,"b"=> 2,3],[1,23,4,6]',
            Arrays::arrayMap(function ($val1, $val2)
            {
                return sprintf('val1 = %s  val2 = %s', $val1, $val2);
            },["a"=> 1,"b"=> 2,3],[1,23,4,6]
            )
        ));



        $fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
        $fruitsBat = $fruits;
        $res = Arrays::arrayWalk($fruits, function(&$item, $key, $prefix)
        {
            $item = "$prefix: $item";
        }, 'fruit' );
        var_dump(static::toStr(
            "遍历；回调参数没引用，不影响原数组，可以传递额外参数; 也只能修改value; \n 原数组： %s ; \n现数组： %s ; \n结果：",
            json_encode($fruitsBat),
            json_encode($fruits),
            $res
        ));


        $sweet = array('a' => 'apple', 'b' => 'banana');
        $fruits = array('sweet' => $sweet, 'sour' => 'lemon');
        $fruitsBat = $fruits;
        $res = Arrays::arrayWalkRecursive($fruits, function(&$item, $key, $prefix)
        {
            //echo "$key holds $item<br>\n";
            $item = "$prefix: $item";
        }, 'fruit' );
        var_dump(static::toStr(
            "遍历递归；会递归到更深层的数组；回调参数没引用，不影响原数组，可以传递额外参数; 也只能修改value; \n 原数组： %s ; \n现数组： %s ; \n结果：",
            json_encode($fruitsBat),
            json_encode($fruits),
            $res
        ));




        $other = [
            'Arrays::extract( array &$array[, int $flags = EXTR_OVERWRITE[, string $prefix = NULL]] ) : int class_alias  从数组中将变量导入到当前的符号表',
            'list( mixed $var[, mixed ...$vars] ) : array   把数组中的值赋给一组变量 ',
            'compact( mixed $var_name, mixed ...$var_names) : array   建立一个数组，包括变量名和它们的值',

            'current( array &$array) : mixed   返回当前被内部指针指向的数组单元的值; 别名 pos',
            'key( array $array) : mixed   返回数组中内部指针指向的当前单元的键名',
            'next( array &$array) : mixed   将数组中的内部指针向前移动一位',
            'prev( array &$array) : mixed   将数组的内部指针倒回一位',
            'end( array &$array) : mixed   将数组的内部指针指向最后一个单元 ',
            'reset( array &$array) : mixed    将数组的内部指针指向第一个单元',
            '漏过了的函数  array_product  array_push  array_rand array_replace_recursive array_replace array_reverse array_search '
        ];


        // 漏过了的函数  array_product  array_push  array_rand array_replace_recursive array_replace array_reverse array_search

        var_dump(static::toStr('其他数组方法：;', $other));

//        $size = "large";
//        $var_array = array("color" => "blue",
//            "size"  => "medium",
//            "shape" => "sphere");
//        extract($var_array, EXTR_PREFIX_SAME, "wddx");
//        echo "$color, $size, $shape, $wddx_size\n";
    }


    /**
     * @note 键名键值操作
     */
    public function arraysKeyOerationTest()
    {
        $arr = ['a' => 97, 'B'=>66, 'c' =>99, 'D' => 68];

        var_dump(static::toStr('键和值交换；数组中的键和值;array_flip  %s ',json_encode($arr), Arrays::arrayFlip($arr)));

        var_dump(static::toStr('键值判断；数组里是否是否存在某个值; 模式：是否判断类型;in_array %s ',json_encode($arr),Arrays::inArray( 66,$arr)));

        var_dump(static::toStr('键值获取；数组中所有的值并给其建立数字索引;array_values %s ',json_encode($arr), Arrays::arrayValues($arr)));

        var_dump(static::toStr('键值获取;数组的第一个键值;array_key_first %s ',json_encode($arr),Arrays::arrayKeyFirst($arr)));

        var_dump(static::toStr('键值获取;数组的最后一个键值;array_key_last  %s ',json_encode($arr), Arrays::arrayKeyLast($arr)));


        var_dump(static::toStr('键名判断；数组里是否有指定的键名或索引; array_key_exists 别名 key_exists ; %s ',json_encode($arr),Arrays::arrayKeyExists( 'a',$arr)));

        var_dump(static::toStr('键名获取;数组中部分的或所有的键名;array_keys  %s ',json_encode($arr), Arrays::arrayKeys($arr, 66,false)));



        //Arrays::arrayChangeKeyCase($arr,CASE_LOWER );
        var_dump(static::toStr('键名更新；模式：大写、小写;array_change_key_case %s ',json_encode($arr),Arrays::arrayChangeKeyCase($arr,CASE_LOWER )));





        $arr = ['a' => 97, 'B'=>66, 'c' =>99, 'D' => 68];
        $arrBat = $arr;
        $res = Arrays::sort($arr, SORT_REGULAR);
        var_dump(static::toStr("排序；根据值，按 数字、字符、自然排序等;删除原有的键名，而不是仅仅将键名重新排序。sort \n 原数组： %s ; \n现数组： %s ",json_encode($arrBat),json_encode($arr),$res));

        $arr = ['a' => 97, 'B'=>66, 'c' =>99, 'D' => 68];
        $arrBat = $arr;
        $res = Arrays::rsort($arr, SORT_REGULAR);
        var_dump(static::toStr("排序；根据值；与上面区别；它对数组 逆向排序 ;rsort \n 原数组： %s ; \n现数组： %s ",json_encode($arrBat),json_encode($arr),$res));


        $arr = ['a' => 97, 'B'=>66, 'c' =>99, 'D' => 68];
        $arrBat = $arr;
        $res = Arrays::usort($arr, function($a, $b)
        {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        });
        var_dump(static::toStr("排序；根据值；与上面区别；它使用 自定义回调函数 ；usort \n 原数组： %s ; \n现数组： %s ",json_encode($arrBat),json_encode($arr),$res));


        $arr = ['a' => 97, 'B'=>66, 'c' =>99, 'D' => 68];
        $arrBat = $arr;
        $res = Arrays::asort($arr, SORT_REGULAR);
        var_dump(static::toStr("排序；根据值，按 数字、字符、自然排序等; 保留原有的键名;asort \n 原数组： %s ; \n现数组： %s ",json_encode($arrBat),json_encode($arr),$res));



        $arr = ['a' => 97, 'B'=>66, 'c' =>99, 'D' => 68];
        $arrBat = $arr;
        $res = Arrays::arsort($arr, SORT_REGULAR);
        var_dump(static::toStr("排序；根据值；与上面区别它对数组逆向排序;arsort \n 原数组： %s ; \n现数组： %s ",json_encode($arrBat),json_encode($arr),$res));




        $arr = ['a' => 97, 'B'=>66, 'c' =>99, 'D' => 68];
        $arrBat = $arr;
        $res = Arrays::uasort($arr, function($a, $b)
        {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        });
        var_dump(static::toStr("排序；根据值；与上面区别；它使用 自定义回调函数 ;uasort \n 原数组： %s ; \n现数组： %s ",json_encode($arrBat),json_encode($arr),$res));



        $arr = array("img12.png", "img10.png", "img2.png", "img1.png");
        $arrBat = $arr;
        $res = Arrays::natsort($arr, SORT_REGULAR);
        var_dump(static::toStr("排序；根据值;保留原有的键名;natsort \n 原数组： %s ; \n现数组： %s ",json_encode($arrBat),json_encode($arr),$res));


        $arr = array("img12.png", "img10.png", "img2.png", "img1.png");
        $arrBat = $arr;
        $res = Arrays::natcasesort($arr, SORT_REGULAR);
        var_dump(static::toStr("排序；根据值;不区分大小写；保留原有的键名;natcasesort \n 原数组： %s ; \n现数组： %s ",json_encode($arrBat),json_encode($arr),$res));


        $arr = ['a' => 97, 'B'=>66, 'c' =>99, 'D' => 68];
        $arrBat = $arr;
        $res = Arrays::ksort($arr, SORT_REGULAR);
        var_dump(static::toStr("排序；根据键；对数组按照键名排序，保留键名到数据的关联;ksort \n 原数组： %s ; \n现数组： %s ",json_encode($arrBat),json_encode($arr),$res));


        $arr = ['a' => 97, 'B'=>66, 'c' =>99, 'D' => 68];
        $arrBat = $arr;
        $res = Arrays::krsort($arr, SORT_REGULAR);
        var_dump(static::toStr("排序；根据键；与上面区别它数组按照键名逆向排序;krsort \n 原数组： %s ; \n现数组： %s ",json_encode($arrBat),json_encode($arr),$res));



        $arr = ['c' =>99,'a' => 97, 'B'=>66,'D' => 68];
        $arrBat = $arr;
        $res = Arrays::uksort($arr, function($a, $b)
        {
            return strcasecmp($a, $b);
        });
        var_dump(static::toStr("排序；根据键；与上面区别它使用自定义函数;uksort \n 原数组： %s ; \n现数组： %s ",json_encode($arrBat),json_encode($arr),$res));








    }


    /**
     * @note arraysCollection数组集合：数组与数组
     */
    public function arraysArraysTest()
    {

        $ar1 = array("color" => array("favorite" => "red"), 10 => 5);
        $ar2 = array(10, "color" => array("favorite" => "green", 10 => "blue"));

        var_dump(static::toStr('数组结合；模式：合并一个或多个数组; 同名键名覆盖,数字键名重置；["color"=>["favorite"=>"red"],10=>5],[10,"color"=>["favorite"=>"green",10=>"blue"]]', Arrays::arrayMerge($ar1,$ar2)));

        var_dump(static::toStr('数组结合；模式：递归地合并一个或多个数组; 同名键名转数组；["color"=>["favorite"=>"red"],10=>5],[10,"color"=>["favorite"=>"green",10=>"blue"]]', Arrays::arrayMergeRecursive($ar1,$ar2)));

        var_dump(static::toStr('数组结合；模式：用一个数组的值作为其键名，另一个数组的值作为其值; [\'a\',\'B\',\'c\',\'D\'],[97,66,99,68] =》 ', Arrays::arrayCombine(['a','B','c' ,'D'],[97,66,99,68])));


        $array1 = ["a" => "green", "red", "blue", "red"];
        $array2 = ["b" => "green", "yellow", "red"];
        var_dump(static::toStr('数组集的差集; 根据值; ["a" => "green", "red", "blue", "red"], ["b" => "green", "yellow", "red"],··· =》 ', Arrays::arrayDiff($array1, $array2)));
        var_dump(static::toStr('数组集的差集; 根据键名; ["a" => "green", "red", "blue", "red"], ["b" => "green", "yellow", "red"],··· =》 ', Arrays::arrayDiffKey($array1, $array2)));
        var_dump(static::toStr('数组集的差集; 根据键名和值; ["a" => "green", "red", "blue", "red"], ["b" => "green", "yellow", "red"],··· =》 ', Arrays::arrayDiffAssoc($array1, $array2)));


        var_dump(static::toStr('数组集的差集回调函数说明：有点像先给传入数组key比对；再数组与数组key比对；value没有开放给回调函数'));

        $array1 = array(
            new stdclass,
            new stdclass,
            new stdclass,
            new stdclass,
        );
        $array2 = array(
            new stdclass, new stdclass,
        );

        $array1[0]->width = 11; $array1[0]->height = 3;
        $array1[1]->width = 7;  $array1[1]->height = 1;
        $array1[2]->width = 2;  $array1[2]->height = 9;
        $array1[3]->width = 5;  $array1[3]->height = 7;

        $array2[0]->width = 7;  $array2[0]->height = 5;
        $array2[1]->width = 9;  $array2[1]->height = 2;
        //var_dump($array1, $array2);;
        var_dump(static::toStr('数组集的差集; 根据键值, 自定义回调函数; ', Arrays::arrayUdiff($array1, $array2, function ($a, $b)
        {
            //var_dump(sprintf('a=%s;   b=%s;', var_export($a, true), var_export($b, true)));
            $areaA = $a->width * $a->height;
            $areaB = $b->width * $b->height;
            if ($areaA < $areaB) {
                return -1;
            } elseif ($areaA > $areaB) {
                return 1;
            } else {
                return 0;
            }
        })));

        $array1 = array('blue'  => 1, 'red'  => 2, 'green'  => 3, 'purple' => 4);
        $array2 = array('green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan'   => 8);
        //var_dump($array1, $array2);
        var_dump(static::toStr('数组集的差集; 根据键名, 自定义回调函数; ', Arrays::arrayDiffUkey($array1, $array2, function ($key1, $key2)
        {
            //var_dump(sprintf('key1 = %s;   key2 = %s;', $key1, $key2));
            if ($key1 == $key2)
                return 0;
            else if ($key1 > $key2)
                return 1;
            else
                return -1;
        })));

        $array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
        $array2 = array("a" => "green", "yellow", "red");
        //var_dump($array1, $array2);
        var_dump(static::toStr('数组集的差集; 根据键名和键值,但键值还是使用内部函数； 自定义回调函数; ', Arrays::arrayDiffUassoc($array1, $array2, function ($a, $b)
        {
            //var_dump(sprintf('a=%s;   b=%s;', $a, $b));
            if ($a === $b) {
                return 0;
            }
            return ($a > $b)? 1:-1;
        })));


        $cr = new class(1) {
            private $priv_member;
            function __construct($val)
            {
                $this->priv_member = $val;
            }

            static function getInstance($val)
            {
                return new static($val);
            }

            static function comp_func_cr($a, $b)
            {
                if ($a->priv_member === $b->priv_member) return 0;
                return ($a->priv_member > $b->priv_member)? 1:-1;
            }

            static function comp_func_key($a, $b)
            {
                if ($a === $b) return 0;
                return ($a > $b)? 1:-1;
            }

            function comp_func_strcasecmp($a, $b)
            {
                return strcasecmp($a, $b);
            }

        };

        $a = array("0.1" => $cr::getInstance(9), "0.5" => $cr::getInstance(12), 0 => $cr::getInstance(23), 1=> $cr::getInstance(4), 2 => $cr::getInstance(-15),);
        $b = array("0.2" => $cr::getInstance(9), "0.5" => $cr::getInstance(22), 0 => $cr::getInstance(3), 1=> $cr::getInstance(4), 2 => $cr::getInstance(-15),);
        var_dump(static::toStr('数组集的差集; 根据键名和键值,但键名还是使用内部函数； 自定义回调函数 ', Arrays::arrayUdiffAssoc($a, $b, array($cr, "comp_func_cr"))));


        $a = array("0.1" => $cr::getInstance(9), "0.5" => $cr::getInstance(12), 0 => $cr::getInstance(23), 1=> $cr::getInstance(4), 2 => $cr::getInstance(-15),);
        $b = array("0.2" => $cr::getInstance(9), "0.5" => $cr::getInstance(22), 0 => $cr::getInstance(3), 1=> $cr::getInstance(4), 2 => $cr::getInstance(-15),);
        var_dump(static::toStr('数组集的差集; 根据键名和键值; 自定义回调函数 ', Arrays::arrayUdiffUassoc($a, $b, array($cr, "comp_func_cr"), array($cr, "comp_func_key"))));




        $array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
        $array2 = array("a" => "green", "b" => "yellow", "blue", "red");

        var_dump(static::toStr('数组集的交集; 根据键值; ["a" => "green", "b" => "brown", "c" => "blue", "red"], ["a" => "green", "b" => "yellow", "blue", "red"] =》 ', Arrays::arrayIntersect($array1, $array2)));

        var_dump(static::toStr('数组集的交集; 根据键名; ["a" => "green", "b" => "brown", "c" => "blue", "red"], ["a" => "green", "b" => "yellow", "blue", "red"] =》 ', Arrays::arrayIntersectKey($array1, $array2)));

        var_dump(static::toStr('数组集的交集; 根据键名和键值; ["a" => "green", "b" => "brown", "c" => "blue", "red"], ["a" => "green", "b" => "yellow", "blue", "red"] =》 ', Arrays::arrayIntersectAssoc($array1, $array2)));




        $array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
        $array2 = array("a" => "GREEN", "B" => "brown", "yellow", "red");

        // 二进制比对字符，不区分大小写
        var_dump(static::toStr('数组集的交集; 根据键值; 自定义回调函数;', Arrays::arrayUintersect($array1, $array2, "strcasecmp")));
        var_dump(static::toStr('数组集的交集; 根据键名; 自定义回调函数;', Arrays::arrayIntersectUkey($array1, $array2, [$cr, 'comp_func_strcasecmp'])));
        var_dump(static::toStr('数组集的交集; 根据键名和键值,但键值还是使用内部函数； 自定义回调函数;', Arrays::arrayIntersectUassoc($array1, $array2, "strcasecmp")));

        var_dump(static::toStr('数组集的交集; 根据键值,但键名还是使用内部函数； 自定义回调函数;', Arrays::arrayUintersectAssoc($array1, $array2, "strcasecmp")));

        var_dump(static::toStr('数组集的交集; 根据键名和键值; 自定义回调函数;', Arrays::arrayUintersectUassoc($array1, $array2, "strcasecmp", "strcasecmp")));

    }









    /**
     * @note 多维数组操作
     */
    public function arraysMultidimensionalTest()
    {
        $records = array(
            array(
                'id' => 2135,
                'first_name' => 'John',
                'last_name' => 'Doe',
            ),
            array(
                'id' => 3245,
                'first_name' => 'Sally',
                'last_name' => 'Smith',
            ),
            array(
                'id' => 5342,
                'first_name' => 'Jane',
                'last_name' => 'Jones',
            ),
            array(
                'id' => 5623,
                'first_name' => 'Peter',
                'last_name' => 'Doe',
            )
        );

        var_dump(static::toStr('多维数组截取列；返回数组中指定的一列;', Arrays::arrayColumn($records, 'first_name', 'id' )));


        $data[] = array('volume' => 67, 'edition' => 2);
        $data[] = array('volume' => 86, 'edition' => 1);
        $data[] = array('volume' => 85, 'edition' => 6);
        $data[] = array('volume' => 98, 'edition' => 2);
        $data[] = array('volume' => 86, 'edition' => 6);
        $data[] = array('volume' => 67, 'edition' => 7);
        // 取得列的列表
        foreach ($data as $key => $row) {
            $volume[$key]  = $row['volume'];
            $edition[$key] = $row['edition'];
        }

        $dataBat = $data;
        //var_dump($volume, $edition);
        // 将数据根据 volume 降序排列，根据 edition 升序排列 // 把 $data 作为最后一个参数，以通用键排序； 效果就是 order by edition desc,volume desc
        $res = array_multisort($volume, SORT_DESC, $edition, SORT_DESC, $data);
        //var_dump($volume, $edition,$data);
        var_dump(static::toStr(
            "多个数组或多维数组进行排序; 多数组，后面的数组都按第一个数组排序方式再排序，前者一样时用后者排序规则；
以下效果等同 mysql 的：order by edition desc,volume desc；volume 又大到小小排序；遇到同值的volume；根据 edition 再由大到小排序\n 原数组 %s ;\n现数组： %s ；",
            $dataBat,
            $data,
            $res
        ));




    }




}

