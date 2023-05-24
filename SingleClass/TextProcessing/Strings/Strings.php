<?php
/**
 *
 */

namespace HappyLin\OldPlugin\SingleClass\TextProcessing\Strings;


use phpDocumentor\Reflection\DocBlock\Tags\Deprecated;

class Strings{


    /**
     * 统计 string 中每个字节值（0..255）出现的次数，使用多种模式返回结果。
     *
     * 根据不同的 mode，count_chars() 返回下列不同的结果：
     * ◦ 0 - 以所有的每个字节值作为键名，出现次数作为值的数组。
     * ◦ 1 - 与 0 相同，但只列出出现次数大于零的字节值。
     * ◦ 2 - 与 0 相同，但只列出出现次数等于零的字节值。
     * ◦ 3 - 返回由所有使用了的字节值组成的字符串。
     * ◦ 4 - 返回由所有未使用的字节值组成的字符串。
     *
     * @param string $string 需要统计的字符串。
     * @param int $mode
     * @return int[]|string
     */
    public static function countChars( string $string, int $mode = 0 )
    {
        return count_chars($string, $mode );
    }


    /**
     * 计算字串出现的次数
     * 返回子字符串 needle 在字符串 haystack 中出现的次数。
     *
     * @param string $haystack 在此字符串中进行搜索。
     * @param string $needle 要搜索的字符串。
     * @param int $offset 开始计数的偏移位置。如果是负数，就从字符的末尾开始统计。
     * @param int $length 指定偏移位置之后的最大搜索长度。如果偏移量加上这个长度的和大于 haystack 的总长度，则打印警告信息。负数的长度 length 是从 haystack 的末尾开始统计的。
     * @return int 该函数返回 整型。
     */
    public static function substrCount( string $haystack, string $needle, int $offset = 0, int $length = -1 ) : int
    {
        return substr_count( $haystack, $needle, $offset, $length );
    }






    /**
     * 获取字符串长度
     *
     * @param string $string
     * @return int
     */
    public static function strlen( string $string) : int
    {
        return strlen( $string);
    }


    /**
     * 返回字符串的子串
     * 返回字符串 string 由 start 和 length 参数指定的子字符串。
     *
     * @param string $string 输入字符串。必须至少有一个字符。
     * @param int $start 如果 start 是非负数，返回的字符串将从 string 的 start 位置开始，从 0 开始计算。 如果 start 是负数，返回的字符串将从 string 结尾处向前数第 start 个字符开始。
     * @param int $length 正数的 length，返回的字符串将从 start 处开始最多包括 length 个字符（取决于 string 的长度）。负数的 length，那么 string 末尾处的 length 个字符将会被省略（若 start 是负数则从字符串尾部算起）。
     * @return string 返回提取的子字符串， 或者在失败时返回 FALSE。
     */
    public static function substr( string $string, int $start = 0, int $length = -1 ) : string
    {
        return substr( $string, $start, $length );
    }



    /**
     * 随机打乱一个字符串
     * 打乱一个字符串，使用任何一种可能的排序方案。
     *
     * @param string $str
     * @return string
     */
    public static function strShuffle( string $str) : string
    {
        return str_shuffle($str);
    }


    /**
     * 反转字符串
     *
     * @param string $string
     * @return string 返回 string 反转后的字符串。
     */
    public static function strrev( string $string) : string
    {
        return strrev( $string);
    }




    /**
     * 使用另一个字符串填充字符串为指定长度
     *
     * 该函数返回 input 被从左端、右端或者同时两端被填充到制定长度后的结果。如果可选的 pad_string 参数没有被指定，input 将被空格字符填充，否则它将被 pad_string 填充到指定长度。
     *
     * @param string $input 输入字符串。
     * @param int $pad_length 如果 pad_length 的值是负数，小于或者等于输入字符串的长度，不会发生任何填充，并会返回 input 。
     * @param string $pad_string 如果填充字符的长度不能被 pad_string 整除，那么 pad_string 可能会被缩短。
     * @param int $pad_type 选的 pad_type 参数的可能值为 STR_PAD_RIGHT，STR_PAD_LEFT 或 STR_PAD_BOTH。如果没有指定 pad_type，则假定它是 STR_PAD_RIGHT。
     * @return string 返回填充后的字符串。
     */
    public static function strPad( string $input, int $pad_length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT ) : string
    {
        return str_pad($input, $pad_length, $pad_string, $pad_type);
    }


    /**
     * 重复一个字符串
     *
     * @param string $input 待操作的字符串。
     * @param int $multiplier input 被重复的次数。必须大于等于 0。
     * @return string 返回重复后的字符串。
     */
    public static function strRepeat( string $input, int $multiplier) : string
    {
        return str_repeat( $input, $multiplier);
    }



    /**
     * 使用此函数将字符串分割成小块非常有用。
     * 例如将 base64_encode() 的输出转换成符合 RFC 2045 语义的字符串。它会在每 chunklen 个字符后边插入 end。
     *
     * @param string $body 要分割的字符。
     * @param int $chunklen 分割的尺寸。
     * @param string $end 行尾序列符号。
     * @return string 返回分割后的字符。
     */
    public static function chunkSplit( string $body, int $chunklen = 76, string $end = "\r\n" ) : string
    {
        return chunk_split($body, $chunklen, $end);
    }


    /**
     * 打断字符串为指定数量的字串
     * 使用字符串断点将字符串打断为指定数量的字串。
     *
     * @param string $str 输入字符串。
     * @param int $width 列宽度
     * @param string $break 使用可选的 break 参数打断字符串。
     * @param bool $cut 如果 cut 设置为 TRUE，字符串总是在指定的 width 或者之前位置被打断; 当它是 FALSE ，函数不会分割单词，哪怕 width 小于单词宽度。
     * @return string 返回打断后的字符串。
     */
    public static function wordwrap( string $str, int $width = 75, string $break = "\n", bool $cut = FALSE ) : string
    {
        return wordwrap($str, $width, $break, $cut);
    }


    /**
     * 删除字符串开头的空白字符（或其他字符）
     *
     * @param string $str 输入的字符串。
     * @param string $character_mask 指定想要删除的字符，简单地列出你想要删除的所有字符即可。使用..，可以指定字符的范围。
     * @return string 该函数返回一个删除了 str 最左边的空白字符的字符串。如果不使用第二个参数，
     */
    public static function ltrim( string $str, string $character_mask = " \t\n\r\0\x0B" ) : string
    {
        return ltrim($str,  $character_mask);
    }

    /**
     * 删除字符串末端的空白字符（或者其他字符）
     *
     * @param string $str 输入字符串。
     * @param string $character_mask 指定想要删除的字符列表。简单地列出你想要删除的全部字符。使用 .. 格式，可以指定一个范围。
     * @return string 返回改变后的字符串。
     */
    public static function rtrim( string $str, string $character_mask ) : string
    {
        return rtrim( $str, $character_mask );
    }


    /**
     * 去除字符串首尾处的空白字符（或者其他字符）
     *
     * 如果不使用第二个参数， ltrim() 仅删除以下字符：
     * ◦ " " (ASCII 32(0x20))，普通空白字符。
     * ◦ "\t" (ASCII 9(0x09))， 制表符.
     * ◦ "\n" (ASCII 10(0x0A))，换行符。
     * ◦ "\r" (ASCII 13(0x0D))，回车符。
     * ◦ "\0" (ASCII 0(0x00))， NUL空字节符。
     * ◦ "\x0B" (ASCII 11(0x0B))，垂直制表符。
     *
     *
     * @param string $str 待处理的字符串。
     * @param string $character_mask 过滤字符也可由 character_mask 参数指定。一般要列出所有希望过滤的字符，也可以使用 ".." 列出一个字符范围。
     * @return string
     */
    public static function trim( string $str, string $character_mask = " \t\n\r\0\x0B" ) : string
    {
        return trim( $str, $character_mask);
    }









    /**
     * 使一个字符串的第一个字符小写
     *
     * @param string $str 输入的字符串。
     * @return string 返回转换后的字符串。
     */
    public static function lcfirst( string $str) : string
    {
        return lcfirst($str);
    }


    /**
     * 将字符串的首字母转换为大写
     *
     * @param string $str 输入字符串。
     * @return string 返回结果字符串。
     */
    public static function ucfirst( string $str) : string
    {
        return ucfirst($str);
    }

    /**
     * 将字符串中每个单词的首字母转换为大写
     * 这里单词的定义是紧跟在 delimiters 参数（默认：空格符、制表符、换行符、回车符、水平线以及竖线）之后的子字符串
     *
     * @param string $str
     * @param string $delimiters 可选的 delimiters，包含了单词分割字符。
     * @return string
     */
    public static function ucwords( string $str, string $delimiters = " \t\r\n\f\v") : string
    {
        return ucwords( $str, $delimiters);
    }

    /**
     * 将字符串转化为小写
     *
     * @param string $string 输入字符串。
     * @return string 返回转换后的小写字符串。
     */
    public static function strtolower( string $string) : string
    {
        return strtolower($string);
    }

    /**
     * 将字符串转化为大写
     *
     * @param string $string
     * @return string
     */
    public static function strtoupper( string $string) : string
    {
        return strtoupper($string);
    }


    /**
     * 该函数返回一个字符串或者数组。该字符串或数组是将 subject 中全部的 search 都被 replace 替换之后的结果。
     * 如果没有一些特殊的替换需求（比如正则表达式），你应该使用该函数替换 ereg_replace() 和 preg_replace()。
     *
     *  如果 search 和 replace 为数组，那么 str_replace() 将对 subject 做二者的映射替换。 如果 replace 的值的个数少于 search 的个数，多余的替换将使用空字符串来进行
     *  如果 search 是一个数组而 replace 是一个字符串，那么 search 中每个元素的替换将始终使用这个字符串。该转换不会改变大小写。
     *
     * @param string|array $search 查找的目标值，也就是 needle。一个数组可以指定多个目标。
     * @param string|array $replace search 的替换值。一个数组可以被用来指定多重替换。
     * @param string|array $subject 执行替换的数组或者字符串。也就是 haystack。如果 subject 是一个数组，替换操作将遍历整个 subject，返回值也将是一个数组。
     * @param int $count 如果被指定，它的值将被设置为替换发生的次数。
     * @return string|array 该函数返回替换后的数组或者字符串。
     */
    public static function strReplace( $search, $replace, $subject, int &$count = null)
    {
        return str_replace( $search, $replace, $subject,$count);
    }



    /**
     *  str_replace() 的忽略大小写版本
     *
     * @param string|array $search
     * @param string|array $replace
     * @param string|array $subject
     * @param int $count
     * @return string|array
     */
    public static function strIreplace( $search,  $replace, $subject, &$count = null )
    {
        return str_ireplace($search, $replace, $subject, $count );
    }


    /**
     * 替换字符串的子串
     *
     *
     * @param string|array $string 输入字符串。
     * @param string|array $replacement 替换字符串。
     * @param string|array $start 如果 start 为正数，替换将从 string 的 start 位置开始。为负数，替换将从 string 的倒数第 start 个位置开始。
     * @param string|array $length 如果设定了这个参数并且为正数，表示 string 中被替换的子字符串的长度。如果设定为负数，它表示待替换的子字符串结尾处距离 string 末端的字符个数。如果没有提供此参数，那么它默认为 strlen( string ) （字符串的长度）。
     * @return string|array 返回结果字符串。如果 string 是个数组，那么也将返回一个数组。
     */
    public static function substrReplace( $string, $replacement, $start = 0, $length = -1 )
    {
        return substr_replace( $string, $replacement, $start, $length );
    }



    /**
     * 转换指定字符
     * 该函数返回 str 的一个副本，并将在 from 中指定的字符转换为 to 中相应的字符。比如， $from[$n]中每次的出现都会被替换为 $to[$n]，其中 $n 是两个参数都有效的位移(offset)。
     *
     * strtr( string $str, string $from, string $to) : string
     * strtr( string $str, array $replace_pairs) : string
     *
     * replace_pairs
     *      参数 replace_pairs 可以用来取代 to 和 from 参数，因为它是以 array('from' => 'to', ...) 格式出现的数组。
     *
     * 这两种行为模式有本质的不同!!!!! 使用三个参数，strtr() 将替换字节； 有两个，它可以替换更长的子串。
     *
     *
     *
     * @param string $str  待转换的字符串。
     * @param string $from 字符串中与将要被转换的目的字符 to 相对应的源字符。
     * @param string $to 字符串中与将要被转换的字符 from 相对应的目的字符。
     * @return string
     */
    public static function strtr( string $str, $from, string $to = null)
    {

        return strtr(...func_get_args());
    }







    /**
     * 标记分割字符串
     * strtok( string $str, string $token) : string
     * strtok( string $token) : string
     *
     * @param string $str 被分成若干子字符串的原始字符串。
     * @param string $token 分割 str 时使用的分界字符。
     * @return string 标记后的字符串。(标记之前的字符串。)
     */
    public static function strtok( string $str, string $token = null)
    {
        return strtok(...func_get_args());
    }






    /**
     * 将字符串转换为数组
     *
     * @param string $string 输入字符串。
     * @param int $split_length 每一段的长度。
     * @return array
     */
    public static function strSplit( string $string, int $split_length = 1 ) : array
    {
        return str_split($string, $split_length);
    }



    /**
     * 此函数返回由字符串组成的 array，每个元素都是 string 的一个子串，它们被字符串 delimiter 作为边界点分割出来。
     *
     * @param string $delimiter 边界上的分隔字符。
     * @param string $string 输入的字符串。
     * @param int $limit 正数，则返回的数组包含最多 limit 个元素，而最后那个元素将包含 string 的剩余部分。是负数，则返回除了最后的 -limit 个元素外的所有元素。
     * @return array
     */
    public static function explode( string $delimiter, string $string, int $limit = null) : array
    {
        return explode($delimiter, $string, $limit);
    }



    /**
     * 将一个一维数组的值转化为字符串
     *
     * @param string $glue 默认为空的字符串。
     * @param array $pieces 你想要转换的数组。
     * @return string 返回一个字符串，其内容为由 glue 分割开的数组的值。
     */
    public static function implode( string $glue = "", array $pieces) : string
    {
        return implode($glue, $pieces);
    }


    /**
     * 二进制安全比较字符串（从偏移位置比较指定长度）
     *
     *
     * @param string $main_str 待比较的第一个字符串。
     * @param string $str 待比较的第二个字符串。
     * @param int $offset 比较开始的位置。如果为负数，则从字符串结尾处开始算起。
     * @param int $length 比较的长度。默认值为 str 的长度与 main_str 的长度减去位置偏移量 offset 后二者中的较大者。
     * @param bool $case_insensitivity 如果 case_insensitivity 为 TRUE，比较将不区分大小写。
     * @return int 如果 main_str 从偏移位置 offset 起的子字符串小于 str，则返回小于 0 的数；如果大于 str，则返回大于 0 的数；如果二者相等，则返回 0。
     */
    public static function substrCompare( string $main_str, string $str, int $offset, int $length, bool $case_insensitivity = FALSE ) : int
    {
        return substr_compare( $main_str, $str, $offset, $length, $case_insensitivity = FALSE );
    }


    /**
     * 基于区域设置的字符串比较
     * strcoll() 使用当前区域设置进行比较
     *
     * @param string $str1 第一个字符串。
     * @param string $str2 第二个字符串。
     * @return int 如果 str1 小于 str2 返回 < 0；如果 str1 大于 str2 返回 > 0；如果两者相等，返回 0。
     */
    public static function strcoll( string $str1, string $str2) : int
    {
        return strcoll($str1, $str2);
    }



    /**
     * 二进制安全字符串比较
     *
     * @param string $str1 第一个字符串。
     * @param string $str2 第二个字符串。
     * @return int 如果 str1 小于 str2 返回 < 0；如果 str1 大于 str2 返回 > 0；如果两者相等，返回 0。
     */
    public static function strcmp( string $str1, string $str2) : int
    {
        return strcmp($str1, $str2);
    }

    /**
     * 二进制安全字符串比较（不区分大小写）。
     *
     * @param string $str1 第一个字符串。
     * @param string $str2 第二个字符串。
     * @return int 如果 str1 小于 str2 返回 < 0；如果 str1 大于 str2 返回 > 0；如果两者相等，返回 0。
     */
    public static function strcasecmp( string $str1, string $str2) : int
    {
        return strcasecmp($str1, $str2);
    }



    /**
     * 二进制安全比较字符串开头的若干个字符
     * 该函数与 strcmp() 类似，不同之处在于你可以指定两个字符串比较时使用的长度（即最大比较长度）。
     *
     * @param string $str1
     * @param string $str2
     * @param int $len 最大比较长度。
     * @return int 如果 str1 小于 str2 返回 < 0；如果 str1 大于 str2 返回 > 0；如果两者相等，返回 0。
     */
    public static function strncmp( string $str1, string $str2, int $len) : int
    {
        return  strncmp( $str1, $str2, $len);
    }


    /**
     * 二进制安全比较字符串开头的若干个字符（不区分大小写）
     * 该函数与 strcasecmp() 类似，不同之处在于你可以指定两个字符串比较时使用的长度（即最大比较长度）。
     *
     * @param string $str1
     * @param string $str2
     * @param int $len 最大比较长度。
     * @return int 如果 str1 小于 str2 返回 < 0；如果 str1 大于 str2 返回 > 0；如果两者相等，返回 0。
     */
    public static function strncasecmp( string $str1, string $str2, int $len) : int
    {
        return strncasecmp( $str1, $str2, $len);
    }








    /**
     * 使用自然排序算法比较字符串
     * 人类习惯对数字型字符串进行排序的比较算法，这就是"自然顺序"。注意该比较区分大小写。
     *
     * @param string $str1
     * @param string $str2
     * @return int 如果 str1 小于 str2 返回 < 0；如果 str1 大于 str2 返回 > 0；如果两者相等，返回 0。
     */
    public static function strnatcmp( string $str1, string $str2) : int
    {
        return strnatcmp( $str1, $str2);
    }


    /**
     *  使用"自然顺序"算法比较字符串（不区分大小写）
     *
     * @param string $str1
     * @param string $str2
     * @return int 如果 str1 小于 str2 返回 < 0；如果 str1 大于 str2 返回 > 0；如果两者相等，返回 0。
     */
    public static function strnatcasecmp( string $str1, string $str2) : int
    {
        return strnatcasecmp( $str1, $str2);
    }







    /**
     * 查找字符串首次出现的位置
     *
     * @param string $haystack 在该字符串中进行查找。
     * @param mixed $needle 如果是指针不是字符串，则将对其进行转换设置为整数，并作为字符的序数值应用。
     * @param int $offset 搜索会从字符串该字符数的起始位置开始统计。如果是负数，搜索会从字符串结尾指定字符数开始。
     * @return int | false
     */
    public static function strpos( string $haystack, $needle, int $offset = 0 )
    {
        return strpos( $haystack, $needle, $offset);
    }


    /**
     * 查找字符串首次出现的位置（不区分大小写）
     *
     * @param string $haystack 在该字符串中查找。
     * @param string $needle 注意 needle 可以是一个单字符或者多字符的字符串。
     * @param int $offset 从字符此数量的开始位置进行搜索。如果是负数，就从字符末尾此数量的字符数开始统计。
     * @return int | false 返回 needle 存在于 haystack 字符串开始的位置(独立于偏移量)。同时注意字符串位置起始于 0，而不是 1。 如果未发现 needle 将返回 FALSE。
     */
    public static function stripos( string $haystack, $needle, int $offset = 0)
    {
        return stripos( $haystack, $needle, $offset);
    }


    /**
     * 计算指定字符串在目标字符串中最后一次出现的位置
     * 返回字符串 haystack 中 needle 最后一次出现的数字位置。
     *
     * @param string $haystack 在此字符串中进行查找。
     * @param string $needle 如果 needle不是一个字符串，它将被转换为整型并被视为字符的顺序值。
     * @param int $offset 会查找字符串中任意长度的子字符串。负数值将导致查找在字符串结尾处开始的计数位置处结束。
     * @return int | false
     */
    public static function strrpos( string $haystack, string $needle, int $offset = 0)
    {
        return strrpos( $haystack, $needle, $offset = 0);
    }


    /**
     * 计算指定字符串在目标字符串中最后一次出现的位置（不区分大小写）
     *
     * @param string $haystack 在此字符串中进行查找。
     * @param string $needle 注意 needle 可以是一个单字符或者多字符的字符串。
     * @param int $offset 参数 offset 可以被指定来查找字符串中任意长度的子字符串。
     * @return int | false 返回 needle 相对于 haystack 字符串的位置(和搜索的方向和偏移量无关)。同时注意字符串的起始位置为 0 而非 1。
     */
    public static function strripos( string $haystack, string $needle, int $offset = 0)
    {
        return strripos( $haystack, $needle, $offset = 0);
    }


    /**
     * 查找字符串的首次出现
     * 返回 haystack 字符串从 needle 第一次出现的位置开始到 haystack 结尾的字符串。
     *
     * @param string $haystack 输入字符串
     * @param mixed $needle 如果 needle 不是一个字符串，那么它将被转化为整型并且作为字符的序号来使用。
     * @param bool $before_needle 若为 TRUE，strstr() 将返回 needle 在 haystack 中的位置之前的部分。
     * @return string | false
     */
    public static function strstr( string $haystack, $needle, bool $before_needle = FALSE)
    {
        return strstr( $haystack, $needle, $before_needle);
    }


    /**
     *  strstr() 函数的忽略大小写版本
     * 返回 haystack 字符串从 needle 第一次出现的位置开始到结尾的字符串。
     *
     * @param string $haystack
     * @param mixed $needle
     * @param bool $before_needle
     * @return string | false
     */
    public static function stristr( string $haystack,  $needle, bool $before_needle = FALSE )
    {
        return stristr( $haystack, $needle, $before_needle );
    }




    /**
     * 查找指定字符在字符串中的最后一次出现
     * 该函数返回 haystack 字符串中的一部分，这部分以 needle 的最后出现位置开始，直到 haystack 末尾。 此函数可安全用于二进制对象。
     *
     * @param string $haystack 在该字符串中查找。
     * @param mixed $needle 如果 needle 包含了不止一个字符，那么仅使用第一个字符。该行为不同于 strstr()。
     * @return string
     */
    public static function strrchr( string $haystack, $needle) : string
    {
        return strrchr( $haystack,  $needle);
    }







    /**
     * 在字符串中查找一组字符的任何一个字符
     *
     * @param string $haystack
     * @param string $char_list
     * @return string 返回一个以找到的字符开始的子字符串。如果没有找到，则返回 FALSE。
     */
    public static function strpbrk( string $haystack, string $char_list)
    {
        return strpbrk( $haystack, $char_list);
    }




    /**
     *  获取不匹配遮罩的起始子字符串的长度;(返回 str1 中，所有字符都不存在于 str2 范围的起始子字符串的长度。 )
     *  (从开始位置查找连续不在在 $characters 字符集合中的字符长度，)
     *
     *
     * @param string $string 要搜索的字符串。
     * @param string $characters 要查找的字符集。
     * @param int $start 查找的起始位置。
     * @param int $length 查找的长度。
     * @return int 查找的长度。
     */
    public static function strcspn( string $string, string $characters, int $start = 0, int $length = -1 ) : int
    {
        return strcspn( $string, $characters, $start, $length );
    }

    /**
     * 计算字符串中全部字符都存在于指定字符集合中的第一段子串的长度。(从开始位置查找连续在 $characters 字符集合中的字符长度，)
     *
     * 返回 subject 中全部字符仅存在于 mask 中的第一组连续字符(子字符串)的长度
     * 如果省略了 start 和 length 参数，则检查整个 subject 字符串；如果指定了这两个参数，则效果等同于调用 strspn(substr($subject, $start, $length), $mask)（
     *
     * @param string $string 要搜索的字符串
     * @param string $characters 字符集合
     * @param int $start  查找的起始位置。
     * @param int $length 查找的长度。
     * @return int 查找的长度。
     */
    public static function strspn( string $string, string $characters, int $start = 0, int $length = -1) : int
    {
        return strspn( $string, $characters, $start, $length);
    }










    /**
     * 计算两个字符串之间的编辑距离
     * 编辑距离，是指两个字串之间，通过替换、插入、删除等操作将字符串str1转换成str2所需要操作的最少字符数量。
     * 该算法的复杂度是 O(m*n)，其中 n 和 m 分别是str1 和str2的长度 （当和算法复杂度为O(max(n,m)**3)的similar_text()相比时，此函数还是相当不错的，尽管仍然很耗时。）。
     *
     * levenshtein('1 applea', '2 applesddd', 1, 1000, 1000000);
     *
     * @param string $str1 求编辑距离中的其中一个字符串
     * @param string $str2 求编辑距离中的另一个字符串
     * @param int $cost_ins 定义插入次数
     * @param int $cost_rep 定义替换次数
     * @param int $cost_del 定义删除次数
     * @return int 此函数返回两个字符串参数之间的编辑距离，如果其中一个字符串参数长度大于限制的255个字符时，返回-1。
     */
    public static function levenshtein( string $str1, string $str2, $cost_ins = null, $cost_rep = null, $cost_del = null) : int
    {
        return levenshtein(...func_get_args());
    }


    /**
     * 返回字符串中单词的使用情况
     *
     * @param string $string 字符串。
     * @param int $format 指定函数的返回值。当前支持的值如下：0 - 返回单词数量;   1 - 返回一个包含 string 中全部单词的数组;  2 - 返回关联数组。数组的键是单词在 string 中出现的数值位置，数组的值是这个单词
     * @param string $charlist 附加的字符串列表，其中的字符将被视为单词的一部分。[连接两单词的字符]
     * @return mixed 返回一个数组或整型数，这取决于 format 参数的选择。
     */
    public static function strWordCount( string $string, int $format = 0, string $charlist = null )
    {
        return str_word_count( $string, $format, $charlist );
    }





    /**
     * 获取数字格式信息
     * 返回包含本地化数字和货币格式信息的关联数组。
     *
     *  数组元素                描述
     * decimal_point        小数点字符
     * thousands_sep        千位分隔符
     * grouping Array       包含数字分组的数组
     * int_curr_symbol      国际货币符号（i.e. 美元）
     * currency_symbol      本地货币符号（i.e $）
     * mon_decimal_point    货币小数点字符
     * mon_thousands_sep    货币千位分隔符
     * mon_grouping         包含货币分组的数组
     * positive_sign        正值的符号
     * negative_sign        负值的符号
     * int_frac_digits      国际小数位数
     * frac_digits          本地小数位数
     * p_cs_precedes        TRUE if currency_symbol precedes a positive value, FALSEif it succeeds one 如果currency_symbol 在一个正值之前为真，如果它成功为一个则为假
     * p_sep_by_space       TRUE if a space separates currency_symbol from a positivevalue, FALSE otherwise 如果空格将货币符号与正值分开，则为 TRUE，否则为 FALSE
     * n_cs_precedes        TRUE if currency_symbol precedes a negative value, FALSEif it succeeds one  如果currency_symbol 位于负值之前为TRUE，如果为1，则为FALSE
     * n_sep_by_space       TRUE if a space separates currency_symbol from a negativevalue, FALSE otherwise 如果空格将货币符号与负值分开，则为 TRUE，否则为 FALSE
     * p_sign_posn          •0 - Parentheses surround the quantity and currency_symbol  •0 - 括号括住数量和货币符号
     *      •1 - 符号字符串位于数量和货币符号之前
     *      •2 - 符号字符串在数量和货币符号之后
     *      •3 - 符号字符串紧跟在currency_symbol 之前
     *      •4 - 符号字符串紧接在currency_symbol 之后
     *
     * n_sign_posn •0 - Parentheses surround the quantity and currency_symbol •0 - 括号括住数量和货币符号
     *      •1 - 符号字符串位于数量和货币符号之前
     *      •2 - 符号字符串在数量和货币符号之后
     *      •3 - 符号字符串紧跟在currency_symbol 之前
     *      •4 - 符号字符串紧接在currency_symbol 之后
     *
     *
     * @return array
     */
    public static function localeconv() : array
    {
        return localeconv();
    }


    /**
     * 用于访问区域设置类别的各个元素。与localeconv（）不同，它返回所有元素，nl_langinfo（）允许您选择任何特定元素。
     * 此函数未在 Windows 平台下实现。
     *
     * @param int $item 项可以是元素的整数值或元素的常量名称
     * @return string 以字符串形式返回元素，如果itemis无效，则返回FALSE。
     */
    public static function nlLanginfo( int $item)
    {
        return nl_langinfo($item);
    }


    /**
     * 设置地区信息
     *
     * 区域设置信息是按进程维护的，而不是按线程维护的。使用setlocale（）更改进程范围的区域设置
     * 
     * setlocale(LC_CTYPE, 'C'); // 设置本地设置为 C 语言本地设置
     * setlocale(LC_ALL, 'zh-CN');
     *
     * category 命名常量指定的受区域设置的功能类别:
     * ◦ LC_ALL 所有的设置
     * ◦ LC_COLLATE 字符串比较, 详见 strcoll()
     * ◦ LC_CTYPE 字符串的分类与转换, 参见例子 strtoupper()
     * ◦ LC_MONETARY 等同 localeconv()
     * ◦ LC_NUMERIC 对于小数点的分隔 (另请参见 localeconv())
     * ◦ LC_TIME 时间与格式 strftime()
     * ◦ LC_MESSAGES 系统响应 (如果PHP使用libintl编译)
     *
     * $locale
     *  如果区域设置为NULL或空字符串“”，则区域设置名称将从与上述类别名称相同的环境变量值或从“LANG”设置。
     *  如果区域设置为“0”，则区域设置不受影响，只返回当前设置。
     *  如果区域设置是一个数组或后跟其他参数，则每个数组元素或参数都将尝试设置为新区域设置，直到成功为止。如果在不同系统上的不同名称下知道某个区域设置，或者为可能不可用的区域设置提供故障反馈，则此选项非常有用。
     *
     *  类别/区域名称可在»RFC 1766(http://www.faqs.org/rfcs/rfc1766)和»ISO 639(http://www.loc.gov/standards/iso639-2/php/code_list.php)中找到。不同的系统具有不同的区域名称命名方案。
     *
     *  setlocale（）的返回值取决于PHP正在运行的系统。它准确地返回system setlocale函数返回的内容。
     *
     * @param int $category 命名常量指定的受区域设置的功能类别:
     * @param string | array ...$locale
     * @return string 返回新的当前区域设置，如果您的平台上未实现区域设置功能、指定的区域设置不存在或类别名称无效，则返回FALSE。
     */
    public static function setlocale( int $category, ...$locale )
    {
        return setlocale( $category, $locale );
    }



// ······································· 格式化字符串  ···············································



    /**
     * 将字符串解析成多个变量
     * 如果 encoded_string 是 URL 传递入的查询字符串（query string），则将它解析为变量并设置到当前作用域
     *
     * 返回数组里的值都已经 urldecode() 了。  QUERY_STRING
     *
     * 要获取当前的 QUERY_STRING，可以使用 $_SERVER['QUERY_STRING'] 变量
     *
     * @param string $encoded_string 输入的字符串
     * @param array $result 变量将会以数组元素的形式存入到这个数组
     */
    public static function parseStr( string $encoded_string, array &$result ) : void
    {
        parse_str( $encoded_string, $result );
    }



    /**
     * 将数字格式化成货币字符串
     * locale 设置中， LC_MONETARY 会影响此函数的行为。 在使用函数前，首先要用 setlocale() 来设置合适的区域设置（locale）。
     *
     * format
     *  格式字符串由以下几部分组成：
     *      单个 % 字符
     *      可选的标记（flags）
     *      可选的字段宽度
     *      可选的，左侧精度
     *      可选的，右侧精度
     *      必选的，单个转化字符
     *  标记(Flags)
     *  可选多个标记，分别是：
     *      =f      字符：=，并紧跟一个字符（单字节） f，用于数字填充。默认的填充字符是空格。
     *      ^       禁用分组字符（比如金额中的逗号。在本地区域设置 locale 中定义）。
     *      + or (  正负数字的格式。使用 +，将使用区域设置（locale）中相当于 + 和 - 的符号。如果使用 (，负数将被圆括号围绕。不设置的话，默认为 +。
     *      !       不输出货币符号（比如 ￥）。
     *      -       有这个符号的时候，将使字段左对齐（填充到右边），默认是相反的，是右对齐的（填充到左边）。
     *  字段宽度
     *      w       十进制数值字符串的宽度。字段将右对齐，除非使用了 - 标记。默认值 0。
     *  左侧精度
     *      #n      小数字符（比如小数点）前的最大位数 (n)。常用于同一列中的格式对齐。如果位数小于 n 则使用填充字符填满。如果实际位数大于 n，此设置将被忽略。
     *              如果没用 ^ 标识禁用分组，分组分隔符会在添加填充字符之前插入（如果有的话）。分组分隔符不会应用到填充字符里，哪怕填充字符是个数字。
     *              为了保证对齐，出现在之前或者之后的字符，都会填充必要的空格，保证正负情况下长度都一样。
     *  右侧精度
     *      .p      小数点后的一段数字 (p)。如果 p 的值是 0（零），小数点右侧的数值将被删除。如果不使用这个标记，默认展现取决于当前的区域设置。小数点后指定位数的数字，四舍五入格式化。
     *  转化字符
     *      i       根据国际化区域设置中的货币格式，格式化数值。（比如，locale 是 USA：USD 1,234.56）。
     *      n       根据国际化区域设置中国家的货币格式，格式化数值。（比如，locale 是 de_DE：EU1.234,56）。
     *      %       返回字符 %。
     *
     * @param string $format 格式字符串
     * @param float $number 需要格式化的数字。
     * @return string
     */
    public static function moneyFormat( string $format, float $number) : string
    {
        return money_format($format, $number);
    }




    /**
     * 以千位分隔符方式格式化一个数字
     *
     * @param float $number 你要格式化的数字
     * @param int $decimals 要保留的小数位数
     * @param string $dec_point 指定小数点显示的字符
     * @param string $thousands_sep 指定千位分隔符显示的字符
     * @return string 格式化以后的 number.
     */
    public static function numberFormat( float $number, int $decimals = 0, string $dec_point = ".", string $thousands_sep = ",") : string
    {
        return number_format( $number, $decimals, $dec_point, $thousands_sep);
    }


    /**
     * 返回格式化的字符串
     * 返回根据格式化字符串格式生成的字符串。
     *
     * 格式字符串由零个或多个指令组成：直接复制到结果的普通字符（不包括%）和转换规范，每个字符都会获取自己的参数。
     * 转换规范遵循此原型:  %[argnum$][flags][width][.precision]specifier
     *
     *  Argnum
     *  后跟
     *      $ 美元符号的整数，用于指定转换中要处理的数字参数。      例如： %2$s ；第二个字符串参数；
     *      - 在给定的字段宽度内左对齐；右对齐是默认值             例如： %2$-8s; 第二个字符串参数, 左对齐占八个字符；
     *      + 用加号 + 前缀正数； 默认只有负号前缀为负号。         例如： %1$-+04d；第一个字符串参数, 左对齐占四个字符；正整数加正号；
     *      （space）空格用空格填充结果。这是默认设置。
     *      0 只用零填充左边的数字。使用 s 说明符，这也可以用零填充右边。 例如： %04d ；'0004';    %4d ；'   4';
     *      '(char) 用字符 (char) 填充结果。                    例如：%2$'a-8s;  第二个字符串参数, 左对齐，用 a 填充空格
     *
     *  Width
     *      一个整数，表示此转换应产生多少个字符（最少）。
     *
     *  Precision精确度
     *      一段时间 。 后跟一个整数，其含义取决于说明符：                        例如： %1$'0-+4.2f 第一个字符串参数, 左对齐占四个字符；正整数加正号；整数四字符，小数 2 字符
     *      对于 e、E、f 和 Fspecifiers：这是小数点后要打印的位数（默认为 6）。
     *      对于 g 和 Gspecifiers：这是要打印的最大有效数字数。
     *      对于 s 说明符：它充当截止点，设置字符串的最大字符数限制。              列如： %2$'0-8.2s 第二个字符串参数, 左对齐，用 0 填充空格； 占八字符， 限制参数展示 2 字符； 其余 0 填充；
     *
     *      注意：如果指定的周期没有明确的精度值，则假定为 0。
     *      注意：尝试使用大于 PHP_INT_MAX 的位置说明符将生成警告。
     *
     *
     *      %   文字百分比字符。不需要参数。
     *      b   该参数被视为一个整数并表示为一个二进制数。
     *      c   该参数被视为一个整数，并作为带有该 ASCII 的字符表示。
     *      d   参数被视为整数并表示为（有符号的）十进制数。
     *      e   该参数被视为科学记数法（例如 1.2e+2）。自 PHP 5.2.1 起，精度说明符代表小数点后的位数。在早期版本中，它被视为有效数字的数量（少一位）。
     *      E   类似于 e 说明符，但使用大写字母（例如 1.2E+2）。
     *      f   该参数被视为一个浮点数并呈现为一个浮点数（语言环境感知）。
     *      F   该参数被视为浮点数并表示为浮点数（非语言环境感知）。自 PHP 5.0.3 起可用。
     *      g   一般格式。
     *          如果非零，则 P 等于精度，如果精度被省略，则为 6，如果精度为零，则为 1。那么，如果样式 E 的转换将具有 X 的指数：
     *          如果 P > X ≥ ?4，则转换为风格 f 和精度 P ? (X + 1)。否则，转换是样式 e 和精度 P ？ 1.
     *      G   与 g 说明符类似，但使用 E 和 f。
     *      o   该参数被视为一个整数并表示为一个八进制数。
     *      s   参数被处理并显示为字符串。
     *      u   参数被视为整数，并表示为无符号十进制数。
     *      x   该参数被视为一个整数，并以十六进制数（带小写字母）的形式表示。
     *      X   参数被视为整数，并以十六进制数（大写字母）表示。
     *
     *      警告 c 类型说明符忽略填充和宽度
     *      警告 尝试将字符串和宽度说明符与每个字符需要超过一个字节的字符集结合使用可能会导致意外结果
     *
     * string   s
     * integer  d, u, c, o, x, X, b
     * double   g, G, e, E, f, F
     *
     * @param string $format
     * @param mixed ...$values
     * @return string
     */
    public static function sprintf( string $format, ...$values)
    {
        return sprintf($format, ...$values);
    }



    /**
     * 输出格式化字符串
     *
     * @param string $format
     * @param mixed ...$args
     * @return int 返回输出字符串的长度。
     */
    public static function printf( string $format, ...$args) : int
    {
        return printf( $format, ...$args );
    }


    /**
     * 根据指定格式解析输入的字符
     * 这个函数 sscanf() 输入类似 printf()。 sscanf() 读取字符串str 然后根据指定格式format解析, 格式的描述文档见 sprintf()。
     *
     * 指定的格式字符串中的任意空白匹配输入字符串的任意空白.也就是说即使是格式字符串中的一个制表符 \t 也能匹配输入字符串中的一个单一空格字符
     *
     * $format
     *  The interpreted format for 解析str的格式, 除了以下不同外，其余的见 sprintf()的描述文档:
     *      函数不区分语言地区
     *      F, g, G 和 b 不被支持.
     *      D 表示十进制数字.
     *      i stands for integer with base detection. 代表带有碱基检测的整数。
     *      n 代表目前已经处理的字符数。
     *      s 遇到任意空格字符时停止读取。
     *
     * @param string $str 将要被解析的 字符串.
     * @param string $format The interpreted format for 解析str的格式, 除了上面不同外，其余的见 sprintf()的描述文档:
     * @param mixed ...$args 可以选参数将以引用方式传入，它们的值将被设置为解析匹配的值
     * @return mixed 如果仅传入了两个参数给这个函数，解析后将返回一个数组，否则，如果可选参数被传入，这个函数将返回被设置了值的个数
     */
    public static function sscanf( string $str, string $format, mixed &...$args )
    {
        return sscanf($str, $format,  ...$args );
    }








    // ······································· 转义  转化 编码  ···············································

    /**
     * 返回字符串，该字符串在属于参数 charlist 列表中的字符前都加上了反斜线。
     *
     * 当选择对字符 0，a，b，f，n，r，t 和 v 进行转义时需要小心，它们将被转换成 \0，\a，\b，\f，\n，\r，\t 和 \v。在 PHP 中，只有 \0（NULL），\r（回车符），\n（换行符）和 \t（制表符）是预定义的转义序列， 而在 C 语言中，上述的所有转换后的字符都是预定义的转义序列。
     *
     * 如
     *  "\0..\37"，将转义所有 ASCII 码介于 0 和 31 之间的字符。(八进制)
     *  addcslashes($not_escaped, "\0..\37!@\177..\377");  (ASCII 码介于 0 和 31 he 127 之后的用八进制表示)
     *  addcslashes($not_escaped, "!..~");  (ASCII 码介于 32 和 126 之间的用字母表示)
     *
     * @param string $str 要转义的字符。
     * @param string $charlist 如果 charlist 中包含有 \n，\r 等字符，将以 C 语言风格转换，而其它非字母数字且 ASCII 码低于 32 以及高于 126 的字符均转换成使用 八进制 表示。
     * @return string 返回转义后的字符。
     */
    public static function addcslashes( string $str, string $charlist) : string
    {
        return addcslashes( $str, $charlist);
    }


    /**
     * 反引用一个使用 addcslashes() 转义的字符串
     * 返回反转义后的字符串。可识别类似 C 语言的 \n，\r，... 八进制以及十六进制的描述。
     *
     * @param string $str 需要反转义的字符串。
     * @return string 返回反转义后的字符串。
     */
    public static function stripcslashes( string $str) : string
    {
        return stripcslashes( $str);
    }



    /**
     * 使用反斜线引用字符串
     *
     * 该字符串为了数据库查询语句等的需要在某些字符前加上了反斜线。这些字符是单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）。
     * 强烈建议使用 DBMS 指定的转义函数（比如 MySQL 是 mysqli_real_escape_string()，PostgreSQL 是 pg_escape_string()），
     *
     * @param string $str 要转义的字符。
     * @return string 返回转义后的字符。
     */
    public static function addslashes( string $str) : string
    {
        return addslashes( $str);
    }


    /**
     *  反引用一个引用字符串 -就是去除反斜杆
     *
     * @param string $str 输入字符串。
     * @return string 返回一个去除转义反斜线后的字符串（\' 转换为 ' 等等）。双反斜线（\\）被转换为单个反斜线（\）。
     */
    public static function stripslashes( string $str) : string
    {
        return stripslashes( $str);
    }




    /**
     * ROT13 编码简单地使用字母表中后面第 13 个字母替换当前字母，同时忽略非字母表中的字符。编码和解码都使用相同的函数，传递一个编码过的字符串作为参数，将得到原始字符串。
     *
     * @param string $str 输入字符串。
     * @return string 返回给定字符串的 ROT13 版本。
     */
    public static function strRot13( string $str) : string
    {
        return str_rot13($str);
    }


    /**
     * 返回相对应于 ascii 所指定的单个字符。
     * 此函数与 ord() 是互补的。
     *
     * @param int $ascii Ascii 码。
     * @return string 返回指定的字符
     */
    public static function chr( int $ascii) : string
    {
        return chr($ascii);
    }


    /**
     * 转换字符串第一个字节为 0-255 之间的值
     *
     * 如果字符串是 ASCII、 ISO-8859、Windows 1252之类单字节编码，就等于返回该字符在字符集编码表中的位置。但请注意，本函数不会去检测字符串的编码，尤其是不会识别类似 UTF-8 或 UTF-16 这种多字节字符的 Unicode 代码点（code point）。
     *
     * @param string $string 一个字符
     * @return int 返回 0 - 255 的整型值
     */
    public static function ord( string $string) : int
    {
        return ord( $string);
    }




    /**
     * 使用 uuencode 算法对一个字符串进行编码。
     * uuencode 算法会将所有（含二进制数据）字符串转化为可输出的字符，并且可以被安全的应用于网络传输。使用 uuencode 编码后的数据将会比源数据大35%左右
     *
     * @param string $data 需要被编码的数据。
     * @return string 返回 uuencode 编码后的数据 或者在失败时返回 FALSE。
     */
    public static function convertUuencode( string $data)
    {
        return convert_uuencode($data);
    }


    /**
     * 解码一个 uuencode 编码的字符串
     *
     * @param string $data uuencode 编码后的数据
     * @return string 返回解码后的字符串数据， 或者在失败时返回 FALSE.。
     */
    public static function convertUudecode( string $data)
    {
        return convert_uudecode($data);
    }





    /**
     * 此函数将给定的字符串从一种 Cyrillic 字符转换成另一种，返回转换之后的字符串。  已废弃
     *
     * 支持的类型有：
     * ◦ k - koi8-r
     * ◦ w - windows-1251
     * ◦ i - iso8859-5
     * ◦ a - x-cp866
     * ◦ d - x-cp866
     * ◦ m - x-mac-cyrillic
     *
     * @param string $str 要转换的字符。
     * @param string $from 单个字符，代表源 Cyrillic 字符集。
     * @param string $to 单个字符，代表了目标 Cyrillic 字符集。
     * @return string
     */
    public static function convertCyrString( string $str, string $from, string $to) : string
    {
        return convert_cyr_string($str, $from, $to);
    }







    // ······································· 进制转化  ···············································


    /**
     * 把二进制的参数 str 转换为的十六进制的字符串。转换使用字节方式，高四位字节优先。
     *
     * @param string $str 二进制字符串。
     * @return string 返回指定字符串十六进制的表示。
     */
    public static function bin2hex( string $str) : string
    {
        return bin2hex( $str);
    }

    /**
     * 转换十六进制字符串为二进制字符串
     *
     * Caution 这个函数不是 转换十六进制数字为二进制数字。这种转换可以使用base_convert() 函数
     *
     * @param string $data 十六进制表示的数据
     * @return string 返回给定数据的二进制表示 或者在失败时返回 FALSE。
     */
    public static function hex2bin( string $data)
    {
        return hex2bin($data);
    }







    // ······································· 加密 ···············································


    /**
     * 生成 str 的 32 位循环冗余校验码多项式。这通常用于检查传输的数据是否完整。
     *
     * 使用 hash("crc32b", $str) 代替
     *
     * @param string $str 要校验的数据。
     * @return int 返回 str crc32 校验的整数。
     */
    public static function crc32( string $str) : int
    {
        return crc32($str);
    }


    /**
     * 单向字符串散列
     * crypt() 返回一个基于标准 UNIX DES 算法或系统上其他可用的替代算法的散列字符串。
     * 推荐使用password_hash()
     *
     * @param string $str 待散列的字符串。
     * @param string $salt 可选的盐值字符串。如果没有提供，算法行为将由不同的算法实现决定，并可能导致不可预料的结束。
     * @return string
     */
    public static function crypt( string $str, string $salt = null) : string
    {
        return crypt($str, $salt);
    }



    /**
     * 计算文件的 sha1 散列值
     * 利用 » 美国安全散列算法 1，计算并返回由 filename 指定的文件的 sha1 散列值。该散列值是一个 40 字符长度的十六进制数字。
     *
     * @param string $filename 要散列的文件的文件名。
     * @param bool $raw_output 如果被设置为 TRUE，sha1 摘要将以 20 字符长度的原始格式返回。
     * @return string 成功返回一个字符串，否则返回 FALSE。
     */
    public static function sha1File( string $filename, bool $raw_output = FALSE ) : string
    {
        return sha1_file($filename, $raw_output);
    }

    /**
     * 计算字符串的 sha1 散列值
     *
     * @param string $str 输入字符串。
     * @param bool $raw_output 如果可选的 raw_output 参数被设置为 TRUE，那么 sha1 摘要将以 20 字符长度的原始格式返回，否则返回值是一个 40 字符长度的十六进制数字。
     */
    public static function sha1( string $str, bool $raw_output = false )
    {
        return sha1($str, $raw_output);
    }



    /**
     * 计算指定文件的 MD5 散列值
     *
     * @param string $filename 文件名
     * @param bool $raw_output 如果被设置为 TRUE，那么报文摘要将以原始的 16 位二进制格式返回。
     * @return string 成功返回字符串，否则返回 FALSE
     */
    public static function md5File( string $filename, bool $raw_output = FALSE) : string
    {
        return md5_file($filename, $raw_output);
    }


    /**
     * 计算字符串的 MD5 散列值
     *
     * @param string $filename $str
     * @param bool $raw_output 如果可选的 raw_output 被设置为 TRUE，那么 MD5 报文摘要将以16字节长度的原始二进制格式返回。
     * @return string 成功返回字符串，否则返回 FALSE
     */
    public static function md5( string $str, bool $raw_output = FALSE ) : string
    {
        return md5($str, $raw_output);
    }







// ······································· 资源类型 ···············································


    /**
     * 将格式化后的字符串写入到流
     * 写入一个根据 format 格式化后的字符串到由 handle 句柄打开的流中。
     *
     * @param resource $handle 文件系统指针，是典型地由 fopen() 创建的 resource(资源)。
     * @param string $format 格式字符串由零个或多个指令组成
     * @param mixed ...$vars
     * @return int
     */
    public static function fprintf( resource $handle, string $format, ...$vars ) : int
    {
        return fprintf($handle, $format, ...$vars);
    }


    /**
     * 解析 CSV 字符串为一个数组
     *
     * @param string $input 待解析的字符串。
     * @param string $delimiter 设定字段界定符（仅单个字符）。
     * @param string $enclosure 设定字段包裹字符（仅单个字符）。
     * @param string $escape 设置转义字符（仅单个字符）。默认为反斜线（\）。
     * @return array 返回一个包含读取到的字段的索引数组
     */
    public static function strGetcsv( string $input, string $delimiter = ",", string $enclosure = '"', string $escape = "\\" ) : array
    {
        return str_getcsv($input, $delimiter, $enclosure, $escape);
    }






    // ······································· html标签类型 ···············································


    /**
     * 在字符串 string 所有新行之前插入 '<br />' 或 '<br>'，并返回。
     *
     * @param string $string 输入字符串。
     * @param bool $is_xhtml 是否使用 XHTML 兼容换行符。
     * @return string 返回调整后的字符串。
     */
    public static function nl2br( string $string, bool $is_xhtml = TRUE) : string
    {
        return nl2br( $string, $is_xhtml);
    }



    /**
     * 将返回 htmlspecialchars() 和 htmlentities() 处理后的转换表。
     *
     * 特殊字符可以使用多种转换方式。 例如： " 可以被转换成 &quot;, &#34; 或者 &#x22. get_html_translation_table() 返回其中最常用的。
     *
     * $flags
     *  ENT_COMPAT      Table will contain entities for double-quotes, but not for single-quotes.  表将包含双引号的实体，但不包含单引号的实体。
     *  ENT_QUOTES      Table will contain entities for both double and single quotes.  表将包含双引号和单引号的实体。
     *  ENT_NOQUOTES    Table will neither contain entities for single quotes nor for double quotes. 表既不包含单引号也不包含双引号的实体。
     *  ENT_HTML401     Table for HTML 4.01.
     *  ENT_XML1        Table for XML 1.
     *  ENT_XHTML       Table for XHTML.
     *  ENT_HTML5       Table for HTML 5.
     *
     *
     * @param int $table 有两个新的常量 (HTML_ENTITIES 实体, HTML_SPECIALCHARS 特殊字符) 允许你指定你想要的表。
     * @param int $flags 一个或多个标志的位掩码，用于指定表将包含的引号以及表的文档类型。默认值为ENT_COMPAT|ENT_HTML401。
     * @param string $encoding 要使用的编码。如果省略，则此参数的默认值是 PHP 5.4.0 之前的 ISO-8859-1 反转，PHP 5.4.0 之后的 UTF-8。
     * @return array 将转换表作为一个数组返回。
     */
    public static function getHtmlTranslationTable(int $table = HTML_SPECIALCHARS, int $flags = ENT_COMPAT | ENT_HTML401, string $encoding = 'UTF-8' ) : array
    {
        return get_html_translation_table( $table, $flags, $encoding);
    }


    /**
     * 将HTML实体转换为其对应的字符
     * html_entity_decode（）与htmlentities（）相反，它将字符串中的html实体转换为相应的字符。
     * 更准确地说，该函数对所有实体（包括所有数字实体）进行解码，a）对所选文档类型（即XML）必须有效，此函数不解码可能在某些DTD（和b）中定义的命名实体，这些DTD的一个或多个字符位于与所选编码关联的编码字符集中，并且在ChosendDocument类型中是允许的。所有其他实体保持原样。
     *
     * $flags
     *  ENT_COMPAT      Table will contain entities for double-quotes, but not for single-quotes.  表将包含双引号的实体，但不包含单引号的实体。
     *  ENT_QUOTES      Table will contain entities for both double and single quotes.  表将包含双引号和单引号的实体。
     *  ENT_NOQUOTES    Table will neither contain entities for single quotes nor for double quotes. 表既不包含单引号也不包含双引号的实体。
     *  ENT_HTML401     Table for HTML 4.01.
     *  ENT_XML1        Table for XML 1.
     *  ENT_XHTML       Table for XHTML.
     *  ENT_HTML5       Table for HTML 5.
     *
     * @param string $string 输入字符串。
     * @param int $flags 一个或多个标志的位掩码，用于指定如何处理引号和使用哪种文档类型。默认值为ENT_COMPAT | ENT_HTML401
     * @param string $encoding 默认值根据使用的PHP版本而变化。在PHP5.6及更高版本中，默认的字符集配置选项用作默认值。PHP5.4和5.5将使用UTF-8作为默认值。PHP的早期版本使用ISO-8859-1。
     * @return string 返回已解码的字符串。
     */
    public static function htmlEntityDecode( string $string, int $flags = ENT_COMPAT | ENT_HTML401, string $encoding = null ) : string
    {
        $encoding = $encoding??ini_get("default_charset");
        return html_entity_decode( $string,  $flags, $encoding);
    }



    /**
     * 将字符转换为 HTML 转义字符
     * 本函数各方面都和 htmlspecialchars() 一样，除了 htmlentities() 会转换所有具有 HTML 实体的字符。
     * 如果要解码（反向操作），可以使用 html_entity_decode()。
     *
     * $flags
     *  ENT_COMPAT 会转换双引号，不转换单引号。
     *  ENT_QUOTES 既转换双引号也转换单引号。
     *  ENT_NOQUOTES 单/双引号都不转换
     *  ENT_IGNORE 静默丢弃无效的代码单元序列，而不是返回空字符串。不建议使用此标记，因为它» 可能有安全影响。
     *  ENT_SUBSTITUTE 替换无效的代码单元序列为 Unicode 代替符（Replacement Character）， U+FFFD (UTF-8) 或者 &#xFFFD; (其他)，而不是返回空字符串。
     *  ENT_DISALLOWED 为文档的无效代码点替换为 Unicode 代替符（Replacement Character）： U+FFFD (UTF-8)，或 &#xFFFD;（其他），而不是把它们留在原处。比如以下情况下就很有用：要保证 XML 文档嵌入额外内容时格式合法。
     *  ENT_HTML401 以 HTML 4.01 处理代码。
     *  ENT_XML1 以 XML 1 处理代码。
     *  ENT_XHTML 以 XHTML 处理代码。
     *  ENT_HTML5 以 HTML 5 处理代码。
     *
     * @param string $string 输入字符。
     * @param int $flags 一组位掩码标记，用于设置如何处理引号、无效代码序列、使用文档的类型。默认是 ENT_COMPAT | ENT_HTML401。
     * @param string $encoding
     * @param bool $double_encode
     * @return string
     */
    public static function htmlentities( string $string, int $flags = ENT_COMPAT | ENT_HTML401, string $encoding = null, bool $double_encode = TRUE ) : string
    {
        $encoding = $encoding??ini_get("default_charset");
        return htmlentities($string, $flags, $encoding, $double_encode);
    }


    /**
     * 将特殊的 HTML 实体转换回普通字符
     * 此函数的作用和 htmlspecialchars() 刚好相反。它将特殊的HTML实体转换回普通字符。
     * 被转换的实体有： &amp;， &quot; （没有设置ENT_NOQUOTES 时）, &#039; （设置了 ENT_QUOTES 时）， &lt; 以及&gt;。
     *
     * $flags
     *  ENT_COMPAT 转换双引号，不转换单引号。
     *  ENT_QUOTES 单引号和双引号都转换。
     *  ENT_NOQUOTES 单引号和双引号都不转换。
     *  ENT_HTML401 作为HTML 4.01编码处理。
     *  ENT_XML1 作为XML 1编码处理。
     *  ENT_XHTML 作为XHTML编码处理。
     *  ENT_HTML5 作为HTML 5编码处理。
     *
     * @param string $string 要解码的字符串
     * @param int $flags 一个或多个作为一个位掩码，来指定如何处理引号和使用哪种文档类型。默认为 ENT_COMPAT | ENT_HTML401
     * @return string 返回解码后的字符串。
     */
    public static function htmlspecialcharsDecode( string $string, int $flags = ENT_COMPAT | ENT_HTML401 ) : string
    {
        return htmlspecialchars_decode($string, $flags );
    }


    /**
     * 将特殊字符转换为 HTML 实体
     *
     * 如果传入字符的字符编码和最终的文档是一致的，则用函数处理的输入适合绝大多数 HTML 文档环境。然而，如果输入的字符编码和最终包含字符的文档是不一样的，想要保留字符（以数字或名称实体的形式），本函数以及 htmlentities() （仅编码名称实体对应的子字符串）可能不够用。这种情况可以使用 mb_encode_numericentity() 代替。
     *
     * 字符           替换后
     * & (& 符号)     &amp;
     * " (双引号)     &quot;，除非设置了 ENT_NOQUOTES
     * ' (单引号)     设置了 ENT_QUOTES 后， &#039;(如果是 ENT_HTML401) ，或者 &apos; (如果是 ENT_XML1、 ENT_XHTML 或 ENT_HTML5)。
     * < (小于)       &lt;
     * > (大于)       &gt;
     *
     * $flags
     *  ENT_COMPAT 会转换双引号，不转换单引号。
     *  ENT_QUOTES 既转换双引号也转换单引号。
     *  ENT_NOQUOTES 单/双引号都不转换
     *  ENT_IGNORE 静默丢弃无效的代码单元序列，而不是返回空字符串。不建议使用此标记，因为它» 可能有安全影响。
     *  ENT_SUBSTITUTE 替换无效的代码单元序列为 Unicode 代替符（Replacement Character）， U+FFFD (UTF-8) 或者 &#xFFFD; (其他)，而不是返回空字符串。
     *  ENT_DISALLOWED 为文档的无效代码点替换为 Unicode 代替符（Replacement Character）： U+FFFD (UTF-8)，或 &#xFFFD;（其他），而不是把它们留在原处。比如以下情况下就很有用：要保证 XML 文档嵌入额外内容时格式合法。
     *  ENT_HTML401 以 HTML 4.01 处理代码。
     *  ENT_XML1 以 XML 1 处理代码。
     *  ENT_XHTML 以 XHTML 处理代码。
     *  ENT_HTML5 以 HTML 5 处理代码。
     *
     *
     * @param string $string 待转换的 string。
     * @param int $flags  位掩码，由以下某个或多个标记组成，设置转义处理细节、无效单元序列、文档类型。默认是 ENT_COMPAT | ENT_HTML401。
     * @param string $encoding
     * @param bool $double_encode
     * @return string
     */
    public static function htmlspecialchars( string $string, int $flags = ENT_COMPAT | ENT_HTML401, string $encoding = null, bool $double_encode = TRUE ) : string
    {
        $encoding = $encoding??ini_get("default_charset");
        return htmlspecialchars( $string,  $flags, $encoding, $double_encode);
    }


    /**
     * 从字符串中去除 HTML 和 PHP 标记
     * 该函数尝试返回给定的字符串 str 去除空字符、HTML 和 PHP 标记后的结果。
     *
     * @param string $str 输入字符串。
     * @param string|null $allowable_tags 使用可选的第二个参数指定不被去除的字符列表。
     * @return string
     */
    public static function stripTags( string $str, string $allowable_tags = null ) : string
    {
        return strip_tags($str, $allowable_tags);
    }




    // ······································· other  ···············································



    /**
     * 计算字符串的变音键
     * 计算str的变音键, 与soundex() 类似，MyOne也为类似的发音词创建相同的关键字。它比soundex（）更准确，因为它知道英语发音的基本规则。
     * @param string $str 输入字符串
     * @param int $phonemes 默认值0表示没有限制。此参数将返回的变音键限制为音素字符的长度。但是，生成的音素始终被完全转录，因此生成的字符串长度可能略长于音素。
     * @return string|false 以字符串形式返回变音键，或者在失败时返回 FALSE.
     */
    public static function metaphone( string $str, int $phonemes = 0)
    {
        return metaphone($str, $phonemes);
    }


}

