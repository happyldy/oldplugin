<?php

namespace HappyLin\OldPlugin\Test;


trait TraitTest
{

    public static function getTestDir(){
        return __DIR__;
    }

    /**
     * 所有传入对象转化为字符串，然后拼接返回
     * 模仿 sprintf 添加字符串参数: ' %s ' (两边都有空格) ;替换后面的对象
     *
     *
     * @param string $msg
     * @param mixed ...$vars
     * @return string|string[]
     */
    public static function toStr(string $msg, ...$vars)
    {
        $returnStr = $msg;

        $i = 0;

        $obj = array_shift( $vars);
        $pos = strpos($returnStr, ' %s ', 0);

        while( $pos !== false && $obj && ++$i<100)
        {
            $obj = var_export($obj, true);

            $returnStr = substr_replace($returnStr, $obj, $pos, 4);

            $pos = strpos($returnStr, ' %s ', $pos);
            $obj = array_shift( $vars);
        }

        if(isset($obj)){
            $returnStr .= ":";
            if(!is_string($obj) && !is_numeric($obj) && !is_bool($obj)){
                $returnStr .= PHP_EOL;
            }
            $returnStr .= var_export($obj, true);
        }

        foreach ($vars as $obj) {
            if (is_string($obj) || is_numeric($obj) || is_bool($obj)) {
                $returnStr .= " , " ;
            } else {
                $returnStr .= PHP_EOL ;
            }
            $returnStr .= var_export($obj, true);
        }

        return $returnStr;
    }


}















