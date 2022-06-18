<?php
/**
 * ReflectionClass 的测试类
 */

namespace HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass;


/**
 * Class FruitsInterface
 * @package HappyLin\OldPlugin\Test\VariableAndTypeTest\TestClass
 */
trait  FruitsTraits {

    public function toString()
    {
        return "this is a " . $this->type();
    }

}

