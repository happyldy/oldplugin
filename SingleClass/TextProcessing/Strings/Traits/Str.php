<?php
/**
 * 
 * 
 */


namespace HappyLin\OldPlugin\SingleClass\TextProcessing\Strings\Traits;


trait Str
{


//    /**
//     * 将字符串转化成数组 （确保多字节安全的）
//     * @param $str
//     * @return array|false
//     */
//    public static function mbStringToArray ($str)
//    {
//        if (empty($str)) return false;
//        $len = mb_strlen($str);
//        $array = array();
//        for ($i = 0; $i < $len; $i++) {
//            $array[] = mb_substr($str, $i, 1);
//        }
//        return $array;
//    }
//
//    /**
//     * 将字符串分割成小块 （确保多字节安全的）
//     * chunk_split() 函数的变异
//     *
//     * @param string $str 要分割的字符。
//     * @param int $len 分割的尺寸。
//     * @param string $end 行尾序列符号。
//     * @return false|string
//     */
//    public static function mbChunkSplit1($str, int $len = 76, string $end = "\n")
//    {
//        if (empty($str)) return false;
//        $array = static::mbStringToArray($str);
//        $n = 0;
//        $new = '';
//        foreach ($array as $char) {
//            if ($n < $len) $new .= $char;
//            elseif ($n == $len) {
//                $new .= $glue . $char;
//                $n = 0;
//            }
//            $n++;
//        }
//        return $new;
//    }


    /**
     * 将字符串分割成小块 （确保多字节安全的）
     * chunk_split() 函数的变异
     *
     * @param string $str 要分割的字符。
     * @param int $len 分割的尺寸。
     * @param string $end 行尾序列符号。
     * @return string
     */
    public static function mbChunkSplit(string $str, int $len = 76, string $end = "\n")
    {
        $pattern = '~.{1,' . $len . '}~u'; // like "~.{1,76}~u"
        $str = preg_replace($pattern, '$0' . $end, $str);
        return rtrim($str, $end);
    }


    /**
     * 将 unicode 字符串分割成小块
     *
     * @param string $str 要分割的字符。
     * @param int $len 分割的尺寸。
     * @param string $end 行尾序列符号。
     * @return string
     */
    function cChunkSplitUnicode(string $str, int $len = 76, string $end = "\n") {
        $tmp = array_chunk(
            preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $len);
        $str = "";
        foreach ($tmp as $t) {
            $str .= join("", $t) . $end;
        }
        return $str;
    }



    /**
     * https://www.php.cn/php-weizijiaocheng-315448.html
     * @param $name
     * @return string
     */
    function unicode_encode($name)
    {
        $name = iconv('UTF-8', 'UCS-2', $name);
        $len = strlen($name);
        $str = '';
        for ($i = 0; $i < $len - 1; $i = $i + 2) {
            $c = $name[$i];
            $c2 = $name[$i + 1];
            if (ord($c) > 0) {   //两个字节的文字
                $str .= '\u' . base_convert(ord($c), 10, 16) . str_pad(base_convert(ord($c2), 10, 16), 2, 0, STR_PAD_LEFT);
            } else {
                $str .= $c2;
            }
        }
        return $str;
    }

//    /**
//     * https://www.php.cn/php-ask-472058.html
//     * $str 原始字符串
//     * $encoding 原始字符串的编码，默认GBK
//     * $prefix 编码后的前缀，默认"&#"
//     * $postfix 编码后的后缀，默认";"
//     */
//    function unicode_encode($str, $encoding = 'GBK', $prefix = '&#', $postfix = ';') {
//        $str = iconv($encoding, 'UCS-2', $str);
//        $arrstr = str_split($str, 2);
//        $unistr = '';
//        for($i = 0, $len = count($arrstr); $i < $len; $i++) {
//            $dec = hexdec(bin2hex($arrstr[$i]));
//            $unistr .= $prefix . $dec . $postfix;
//        }
//        return $unistr;
//    }


    /**
     * https://www.php.cn/php-weizijiaocheng-315448.html
     * 将unicode编码后的内容进行解码，编码后的内容格式：yoka\u738b （原始：yoka王）
     * @param $name
     * @return mixed|string
     */
    function unicode_decode($name)
    {
        // 转换编码，将unicode编码转换成可以浏览的utf-8编码
        $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
        preg_match_all($pattern, $name, $matches);
        if (!empty($matches))
        {
            $name = '';
            for ($j = 0; $j < count($matches[0]); $j++)
            {
                $str = $matches[0][$j];
                if (strpos($str, '\\u') === 0)
                {
                    $code = base_convert(substr($str, 2, 2), 16, 10);
                    $code2 = base_convert(substr($str, 4), 16, 10);
                    $c = chr($code).chr($code2);
                    $c = iconv('ucs-2', 'utf-8', $c);
                    $name .= $c;
                }
                else
                {
                    $name .= $str;
                }
            }
        }
        return $name;
    }


//    /**
//     * https://www.php.cn/php-ask-472058.html
//     * $str Unicode编码后的字符串
//     * $encoding 原始字符串的编码，默认GBK
//     * $prefix 编码字符串的前缀，默认"&#"
//     * $postfix 编码字符串的后缀，默认";"
//     */
//    function unicode_decode($unistr, $encoding = 'GBK', $prefix = '&#', $postfix = ';') {
//        $arruni = explode($prefix, $unistr);
//        $unistr = '';
//        for($i = 1, $len = count($arruni); $i < $len; $i++) {
//            if (strlen($postfix) > 0) {
//                $arruni[$i] = substr($arruni[$i], 0, strlen($arruni[$i]) - strlen($postfix));
//            }
//            $temp = intval($arruni[$i]);
//            $unistr .= ($temp < 256) ? chr(0) . chr($temp) : chr($temp / 256) . chr($temp % 256);
//        }
//        return iconv('UCS-2', $encoding, $unistr);
//    }





}


