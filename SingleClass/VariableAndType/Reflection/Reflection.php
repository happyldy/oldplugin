<?php
/**
 *
 *
 */

namespace HappyLin\OldPlugin\SingleClass\VariableAndType\Reflection;


use \Reflection as R;
use Reflector;

class Reflection extends R
{

    /**
     * 导出一个反射（reflection）。
     *
     * @param Reflector $reflector 导出的反射。
     * @param false $return 设为 TRUE 时返回导出结果，设为 FALSE（默认值）则忽略返回。
     * @return string|void|null 如果参数 return 设为 TRUE，导出结果将作为 string 返回，否则返回 NULL。
     */
    public static function export(Reflector $reflector, $return = false)
    {
        parent::export($reflector, $return);
    }


    /**
     * 获取修饰符的名称
     *
     * @param int $modifiers 根据标志位域获取修饰符。
     * @return array|void 修饰符名称的一个数组。
     */
    public static function getModifierNames($modifiers)
    {
        parent::getModifierNames($modifiers);
    }

}












