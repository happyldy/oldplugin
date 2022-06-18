<?php
/**
 * ReflectionClass 的测试类
 */

namespace HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass;

use HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass\FruitsTraits;

/**
 * Class Apple
 * ReflectionClass 的测试类
 * @package HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass
 */
class Apple extends Fruits {

    use FruitsTraits{
        FruitsTraits::toString as __toString;
    }


    /**
     * @const string CONSTTYPE
     */
    protected const CONSTTYPE = 'apple';

    /**
     * @var mixed|string
     */
    public $publicVar1;

    /**
     * @var string 其它水果
     */
    public $publicVar2 = 'orange';

    private $privateVar1;

    private static $privateStaticVar1 = 'privateStaticVar1';

    public static $publicStaticVar1 = 'publicStaticVar1';



    /**
     * Apple constructor.
     */
    public function __construct($publicVar1 = 'apple'){
        $this->publicVar1 = $publicVar1;
    }

    /**
     * @return string 水果种类
     */
    public function type() {
        return 'Apple';
    }


    /**
     * 说明水果味道
     * @param string $taste 味道
     * @param bool $other 其他水果
     * @return string
     */
    public function tasteLike(string $taste = 'sweet', bool $other = false): string
    {
        $desc =  sprintf("The apples are $taste");
        if($other){
            $desc .= ", $this->publicVar2 are also $taste ";
        }
        return $desc;
    }



    public static function getConstants()
    {
        // "static::class" here does the magic
        $reflectionClass = new \ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }




}

