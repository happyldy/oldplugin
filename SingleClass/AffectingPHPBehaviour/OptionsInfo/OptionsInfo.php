<?php
/**
 * 大杂烩
 *
 * 这些函数允许你获得许多关于PHP本身的参数，例如：运行时的配置，被加载的扩展，版本等
 *
 */


namespace HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo;

use HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits\{Ini, ScriptVariable, Extension, System, GarbageCollection, Test};
use Generator;

class OptionsInfo
{
    use Ini, ScriptVariable, Extension, System, GarbageCollection, Test;
    

    /**
     * 根据范围返回数值，包含指定的元素
     * @param $start 开始数值
     * @param $limit 结束数值
     * @param int $step 每次递增数值
     * @return \Generator
     */
    public static function xrange(int $start, int $limit, int $step = 1):Generator
    {
        if ($start < $limit) {
            if ($step <= 0) {
                throw new LogicException('Step must be +ve');
            }

            for ($i = $start; $i <= $limit; $i += $step) {
                yield $i;
            }
        } else {
            if ($step >= 0) {
                throw new LogicException('Step must be -ve');
            }

            for ($i = $start; $i >= $limit; $i += $step) {
                yield $i;
            }
        }
    }




    /**
     * assert() 会检查指定的 assertion 并在结果为 FALSE 时采取适当的行动。
     *
     * @param mixed $assertion  可以是任何返回值的表达式，该值将被执行，结果用于指示断言是成功还是失败。
     * @param string $description 描述性字符串
     * @return bool
     */
    public static function assert($assertion, string $description = ''): bool
    {
        /**
         * 使用配置替换 assert_options
         * zend.assertions 默认 1
         *  1: generate and execute code (development mode) 包异常，但还是会继续执行
         *  0: generate code but jump around it at runtime  这是不理会assert继续执行
         *  -1: do not generate code (production mode)   实际这报错 zend.assertions may be completely enabled or disabled only in php
         *
         * assert.exception  默认 0
         *  1: throw when the assertion fails, either bythrowing the object provided as the exceptionor by throwing a new AssertionError object if exception wasn't provided 抛出AssertionError对象
         *  0: use or generate a Throwable as described above, but onlygenerate a warning based on that object rather than throwing it(compatible with PHP 5 behaviour) 抛出AssertionError对象；但仅基于该对象生成警告，而不是将其丢弃（与PHP 5行为兼容）
         */
        ini_set('zend.assertions', 1);
        ini_set('assert.exception', 0);

        $customError = new class($description) extends \AssertionError {

            public function __construct($message = "", $code = 0, Throwable $previous = null)
            {
                parent::__construct($message, $code, $previous);
            }
        };

        /**
         * 检查一个断言是否为 FALSE
         *
         * @param mixed $assertion  可以是任何返回值的表达式，该值将被执行，结果用于指示断言是成功还是失败。
         * @param string $description 一个Throwable对象，而不是一个描述性字符串，在这种情况下，如果断言失败并且启用了assert.exceptioncon figuration指令，则将生成该对象。
         */
        return assert($assertion, $customError);
    }


    /**
     * assert() 会检查指定的 assertion 并在结果为 FALSE 时采取适当的行动。
     *
     * assert( mixed $assertion[, string $description] ) : bool
     *
     * @param mixed $assertion  在PHP5中，这必须是要计算的字符串或要测试的布尔值。在PHP7中，这也可以是任何返回值的表达式，该值将被执行，结果用于指示断言是成功还是失败。
     * @param string $description 如果 assertion 失败了，选项 description 将会包括在失败信息里。但在PHP7中，第二个参数可以是一个Throwable对象，而不是一个描述性字符串，在这种情况下，如果断言失败并且启用了assert.exceptionconfiguration指令，则将生成该对象。
     * @return bool
     */
    public static function assertphp5($assertion,string $description=''): bool
    {
        /**
         * 设置断言标志
         *
         * 参数
         * what
         * 断言标志
         *      ASSERT_ACTIVE       assert.active       1   启用 assert() 断言
         *      ASSERT_WARNING      assert.warning      1   为每个失败的断言产生一个 PHP 警告（warning）
         *      ASSERT_BAIL         assert.bail         0   在断言失败时中止执行
         *      ASSERT_QUIET_EVAL   assert.quiet_eval   0   在断言表达式求值时禁用 error_reporting
         *      ASSERT_CALLBACK     assert.callback  (NULL) 断言失败时调用回调函数 (回调函数应该接受三个参数。第一个参数包括了断言失败所在的文件。第二个参数包含了断言失败所在的行号，第三个参数包含了失败的表达式（如有任意 — 字面值例如 1 或者 "two" 将不会传递到这个参数）。 PHP 5.4.8 及更高版本的用户也可以提供第四个可选参数，如果设置了，用于将 description 指定到 assert()。 )
         * value
         * 标志的新值。
         */
        assert_options(ASSERT_ACTIVE,   true);

        assert_options(ASSERT_WARNING,  false);
        assert_options(ASSERT_BAIL,     true);
        assert_options(ASSERT_QUIET_EVAL, 1);
        assert_options(
            ASSERT_CALLBACK,
            function($file, $line, $code, $desc = null)
            {
                echo "Assertion Failed:<br />
                    File: '$file'<br />
                    Line: '$line'<br />
                    Code: '$code'<br />";

                if ($desc) {
                    echo "Desc: : {$desc} <br />";
                }
                echo "<br />";
            }
        );

        return assert($assertion, $description);
    }


    /**
     * 将中文转为Html实体; 通过json_encode函数将中文转为unicode
     */
    public static function shortcuta()
    {

        $str = <<<EOT
你好 world
EOT;

        function ChineseToEntity($str) {
            return preg_replace_callback(
                '/[\x{4e00}-\x{9fa5}]/u', // utf-8
                // '/[\x7f-\xff]+/', // if gb2312
                function ($matches) {
                    $json = json_encode(array($matches[0]));
                    preg_match('/\[\"(.*)\"\]/', $json, $arr);
                    /*
                     * 通过json_encode函数将中文转为unicode
                     * 然后用正则取出unicode
                     * Turn the Chinese into Unicode through the json_encode function, then extract Unicode from regular.
                     * I think this idea is seamless.
                    */
                    return '&#x'. str_replace('\\u', '', $arr[1]). ';';
                }, $str
            );
        }

        echo ChineseToEntity($str);

        var_dump($str);
    }






}












