<?php
/**
 *
 * 1、就是记录下使用方法
 * 2、需要配合使用，无法单独使用的方法，
 */


namespace HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits;


trait Test
{



    /**
     * 测试占用内存
     */
    public static function memoryTest():void
    {
        //main script: get current memory, run one of the functions and calculate memory usage after
        $m = memory_get_peak_usage();

//        foreach (static::xrange(1,10000) as $i) {
//            echo "<div>{$i}</div>";
//        }

        foreach (range(1,10000) as $i) {
            echo  "<div>{$i}</div>";
        }

        echo "total memory comsuption: " . (memory_get_peak_usage() - $m) . " bytes\n";
    }




    /**
     * 解析传入脚本的选项。
     *
     * 参数
     * options 可能包含了以下元素：
     * •单独的字符（不接受值）
     * •后面跟随冒号的字符（此选项需要值）
     * •后面跟随两个冒号的字符（此选项的值可选）
     *
     * 例子：
     *      shell> php example.php -f "value for f" -v -a --required value --optional="optional value" --option
     *
     * @param string $options 该字符串中的每个字符会被当做选项字符，匹配传入脚本的选项以单个连字符(-)开头。  比如，一个选项字符串 "x" 识别了一个选项 -x。  只允许 a-z、A-Z 和 0-9。
     * @param array $longopts 选项数组。此数组中的每个元素会被作为选项字符串，匹配了以两个连字符(--)传入到脚本的选项。  例如，长选项元素 "opt" 识别了一个选项 --opt。
     * @param int $optind If the optind parameter is present, then theindex where argument parsing stopped will be written to this variable.
     * @return array
     */
    public static function getoptTest( string $options, array $longopts, int &$optind ) : array
    {

        $shortopts  = "";
        $shortopts .= "f:";  // Required value
        $shortopts .= "v::"; // Optional value
        $shortopts .= "abc"; // These options do not accept values

        $longopts  = array(
            "required:",     // Required value
            "optional::",    // Optional value
            "option",        // No value
            "opt",           // No value
        );
        $options = getopt($shortopts, $longopts);
    }



    /**
     * 垃圾回收机制 例子，非函数方法
     */
    public static function testXdebugDebugZval(string $filename, string $str): void
    {
        $a = "new string";
        $c = $b = $a;
        xdebug_debug_zval( 'a' ); //        a: (refcount=3, is_ref=0)='new string'； php7都是0
        unset( $b, $c );
        xdebug_debug_zval( 'a' ); //        a: (refcount=1, is_ref=0)='new string'； php7都是0
    }



}












