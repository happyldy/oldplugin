<?php
/**
 * SPL 函数
 *
 *
 */


namespace HappyLin\OldPlugin\SingleClass\SPL;



class SPLFunctions
{

    /**
     * 本函数返回一个数组，该数组中包含了指定类class及其父类所实现的所有接口的名称。
     *
     * @param mixed $class 对象（类实例）或字符串（类名称）。
     * @param bool $autoload 是否允许使用__autoload 魔术函数来自动装载该类。默认值为TRUE。
     * @return array
     */
    public static function classImplements( $class, bool $autoload = true) : array
    {
        return class_implements($class, $autoload);
    }









}

