<?php
/**
 * 全局函数
 */


//if (! function_exists('dump')) {
//    /**
//     * Dump the passed variables and end the script.
//     *
//     * @param  mixed
//     * @return void
//     */
//    function dump(...$args)
//    {
//        foreach ($args as $x) {
//            VarDumper::dump($x);
//        }
//    }
//}


if (! function_exists('reflectionFunctionTest')) {
    /**
     * @param $obj
     * @return string
     */
    function reflectionFunctionTest($obj): string
    {
        return json_encode($obj);
    }

}



if (! function_exists('xrange')) {
    /**
     * 根据范围返回数值，包含指定的元素
     * @param $start 开始数值
     * @param $limit 结束数值
     * @param int $step 每次递增数值
     * @return \Generator
     */
    function xrange(int $start, int $limit, int $step = 1):\Generator
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

}


//if (! function_exists('assert')) {
//    /**
//     * assert() 会检查指定的 assertion 并在结果为 FALSE 时采取适当的行动。
//     *
//     * @param mixed $assertion  可以是任何返回值的表达式，该值将被执行，结果用于指示断言是成功还是失败。
//     * @param string $description 描述性字符串
//     * @return bool
//     */
//    function assert($assertion, string $description = ''): bool
//    {
//        /**
//         * 使用配置替换 assert_options
//         * zend.assertions 默认 1
//         *  1: generate and execute code (development mode) 包异常，但还是会继续执行
//         *  0: generate code but jump around it at runtime  这是不理会assert继续执行
//         *  -1: do not generate code (production mode)   实际这报错 zend.assertions may be completely enabled or disabled only in php
//         *
//         * assert.exception  默认 0
//         *  1: throw when the assertion fails, either bythrowing the object provided as the exceptionor by throwing a new AssertionError object if exception wasn't provided 抛出AssertionError对象
//         *  0: use or generate a Throwable as described above, but onlygenerate a warning based on that object rather than throwing it(compatible with PHP 5 behaviour) 抛出AssertionError对象；但仅基于该对象生成警告，而不是将其丢弃（与PHP 5行为兼容）
//         */
//        ini_set('zend.assertions', 1);
//        ini_set('assert.exception', 0);
//
//        $customError = new class($description) extends \AssertionError {
//
//            public function __construct($message = "", $code = 0, Throwable $previous = null)
//            {
//                parent::__construct($message, $code, $previous);
//            }
//        };
//
//        /**
//         * 检查一个断言是否为 FALSE
//         *
//         * @param mixed $assertion  可以是任何返回值的表达式，该值将被执行，结果用于指示断言是成功还是失败。
//         * @param string $description 一个Throwable对象，而不是一个描述性字符串，在这种情况下，如果断言失败并且启用了assert.exceptioncon figuration指令，则将生成该对象。
//         */
//        return assert($assertion, $customError);
//    }
//}



if (! function_exists('unicode_encode')) {
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
}



if (! function_exists('unicode_decode')) {
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

}





