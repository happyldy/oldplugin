<?php


namespace HappyLin\OldPlugin\Test\VariableAndTypeTest;



use HappyLin\OldPlugin\SingleClass\Date\DateTime;
use HappyLin\OldPlugin\Test\TraitTest;

use stdClass;


class VariableHandlingTest
{

    use TraitTest;



    public function __construct()
    {

    }

    /**
     * @note 变量操作，类型转换，判断，打印，压缩
     */
    public function variableHandlingTest()
    {

        var_dump(static::toStr(
            '转换变量类型：',
            [
                'boolval',
                'strval',
                'intval( mixed $var[,int $base = 10])',
                'floatval',
            ]
        ));


        $intSetype = $intVal = $int = $intBat = '123.22';
        var_dump(static::toStr(
            '设置变量的类型：有["boolean","int","float","string","array","object","null"]; 或 (unset)$xx、((object))$xx··· settype( mixed &$var, string $type) : bool ' . PHP_EOL.
            "三种写法：settype($intBat, 'int') = %s 结果： %s ;  intval($intBat) 结果:  %s ; (int)$intBat 结果：: %s ;",
            settype($intSetype, 'int'),
            $intSetype,
            intval($intVal),
            (int)$int
        ));


        var_dump(static::toStr(
            '检测变量类型：',
            [
                'empty( mixed $var) : bool',
                'isset',
                'is_bool',
                'is_array',
                'is_float',
                'is_int',
                'is_null',
                'is_numeric',
                'is_string',
                'is_object  包含：function class (stdClass)',
                'is_resource',
                'is_scalar 标量变量是指那些包含了 integer、float、string 或 boolean的变量',
                'is_callable( callable $name[, bool $syntax_only = false[, string &$callable_name]] ) : bool',
                'is_iterable 是否被可迭代伪类型接受即实现 Traversable 的对象 >=7.1',
                'is_countable( mixed $var) : bool; 验证变量的内容是实现 Countable 的数组或对象（count 方法） >=7.3',
            ]
        ));



        var_dump(static::toStr(
            '获取变量的类型：gettype( mixed $var) : string ["boolean", "integer", "double", "string","array","object","resource","NULL", "unknown type" ]',
            gettype(1.232)
        ));


        var_dump(static::toStr(
            '返回资源（resource）类型; 例如：mysql link  file  get_resource_type( resource $handle) : string  '
        ));


        var_dump(static::toStr(
            '返回由所有已定义变量所组成的数组; 限定当前所在文件和调用方法有关; get_defined_vars()   '
        ));


        var_dump(static::toStr(
            '其他函数：',
            [
                'var_dump',
                'var_export',
                'print_r',
                'debug_zval_dump  将内部 zend 值的字符串表示转储到输出； 与回收机制有关； 比 var_export 多了refcount参数 ',
                'unset',
                'serialize  返回字符串，此字符串包含了表示 value 的字节流，可以存储于任何地方。是对象时在序列动作之前调用该对象的成员函数 __sleep()。',
                'unserialize   当序列化对象时调用 __wakeup() 成员函数'
            ]
        ));




    }



}

