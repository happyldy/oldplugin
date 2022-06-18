<?php
/**
 * ReflectionClass 的测试类
 */

namespace HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass;


/**
 * Class Fruits
 * @package HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass
 */
abstract class Fruits implements FruitsInterface {



    const CONSTBASETYPE = 'fruits';

    public $publicVar1;

    /**
     * Apple constructor.
     */
    public function __construct($publicVar1 = 'fruits'){
        $this->publicVar1 = $publicVar1;
    }

    public function type() {
        return 'fruits';
    }


    public static function getConstants()
    {
        // "static::class" here does the magic
        $reflectionClass = new ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }


}

