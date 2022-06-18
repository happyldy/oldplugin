<?php
/**
 * 该扩展所提供的函数用来检测在当前的区域设定下（参见 setlocale()），一个字符或者字符串是否仅包含指定类型的字符。
 * 需要提醒的是，如果可以满足需求，请优先考虑使用 ctype 函数，而不是正则表达式或者对应的 "str_*" 和 "is_*" 函数。因为 ctype 使用的是原生 C 库，所以会有明显的性能优势。
 */

namespace HappyLin\OldPlugin\Test\VariableAndTypeTest;

use HappyLin\OldPlugin\SingleClass\VariableAndType\Ctype;


use HappyLin\OldPlugin\Test\TraitTest;

use stdclass;


class CtypeTest
{

    use TraitTest;


    /**
     * @note 判断字符串类型
     */
    public function ctypeTest()
    {
        var_dump(static::toStr('Note: 如果给出一个 -128 到 255 之间(含)的整数, 将会被解释为该值对应的ASCII字符 (负值将加上 256 以支持扩展ASCII字符). 其它整数将会被解释为该值对应的十进制字符串.'));

        var_dump(static::toStr('判断；提供的 string,text 里面的字符是不是都是大写字母; ctype_upper( "ABCDE")', ctype_upper( "ABCDE")));

        var_dump(static::toStr('判断；提供的 string,text 里面的字符是不是都是小写字母; ctype_lower( "abcde")', ctype_lower( "abcde")));

        var_dump(static::toStr('判断；提供的 string,text 里面的所有字符是否只包含字符,等同于 (ctype_upper($text) || ctype_lower($text)); ctype_alpha( "ABCDEabcde")', ctype_alpha( "ABCDEabcde")));

        var_dump(static::toStr('判断；提供的 string,text 里面的字符是不是都是数字; ctype_digit( "12345")', ctype_digit( "12345")));

        var_dump(static::toStr('判断；提供的 string,text 里面的字符是不是都是字母和(或)数字字符; ctype_alnum( "34dfge343s")', ctype_alnum( "34dfge343s")));

        var_dump(static::toStr('判断；提供的 string,text 里面的字符最终被实际输出的时候都是某种形式的空白; ctype_space("\n\r\t")', ctype_space( "\n\r\t")));

        var_dump(static::toStr('判断；提供的 string,text 里面的字符输出都是可见的（没有空白）; ctype_graph("asdf\n\r\t ")', ctype_graph( "asdf\n\r\t ")));

        var_dump(static::toStr('判断；提供的 string,text 里面的字符是不是都是可以打印出来（包括空白）; ctype_print("\'arf12 ")', ctype_print( "'arf12 ")));

        var_dump(static::toStr('判断；提供的 string,text 里面的字符是不是都是控制字符。控制字符就是例如：换行、缩进、空格; ctype_cntrl("\n\r\t")', ctype_cntrl( "\n\r\t")));

        var_dump(static::toStr('判断；提供的 string,text 里面的字符是不是都是标点符号(不是字母、数字，也不是空白,不是\n\r\t); ctype_punct("*&$()")', ctype_punct( "*&$()")));

    }


}

