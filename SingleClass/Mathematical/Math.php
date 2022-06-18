<?php



namespace HappyLin\OldPlugin\SingleClass\Mathematical;



class Math
{


    /**
     * 在任意进制之间转换数字
     * 返回一字符串，包含 number 以 tobase 进制的表示。number 本身的进制由 frombase 指定。
     * frombase 和 tobase 都只能在 2 和 36 之间（包括 2 和 36）。高于十进制的数字用字母 a-z 表示，例如 a 表示 10，b 表示 11 以及 z 表示 35。
     *
     * @param string $number 要转换的数字
     * @param int $frombase 要转换的数字的进制
     * @param int $tobase 要将数字转换为的进制
     * @return string 转换为进制的数字
     */
    public static function baseConvert( string $number, int $frombase, int $tobase) : string
    {
        return base_convert($number, $frombase, $tobase);
    }


    /**
     *  二进制转换为十进制
     * bindec() 将一个二进制数转换成 integer，或者出于大小的需要，转换为 float 类型。
     * bindec() 将所有的 binary_string 值解释为无符号整数。这是由于 bindec() 函数将其最高有效位视为数量级而非符号位。
     *
     * @param string $binary_string 要转换的二进制字符串; 参数必须为字符串。使用其他数据类型会导致不可预知的结果。
     * @return number 十进制数值
     */
    public static function bindec( string $binary_string)
    {
        return bindec( $binary_string);
    }



}

