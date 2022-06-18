<?php


namespace HappyLin\OldPlugin\Test\VariableAndTypeTest;

use HappyLin\OldPlugin\SingleClass\VariableAndType\FunctionHandling;
use HappyLin\OldPlugin\Test\TraitTest;
use stdclass;

class FunctionHandlingTest
{

    use TraitTest;



    public function __construct()
    {

    }


    /**
     * @note 函数相关操作
     */
    public function FunctionHandlingTest()
    {

        var_dump(static::toStr('get_defined_functions([ bool $exclude_disabled = FALSE] ) — 返回所有已定义函数的数组'));

        var_dump(static::toStr('function_exists — 如果给定的函数已经被定义就返回 TRUE '));

        var_dump(static::toStr('create_function — 创建一个匿名（lambda样式）函数； 此函数在内部执行eval（），因此具有与eval（）相同的安全问题；放弃！！ '));

        var_dump(static::toStr('call_user_func_array、call_user_func 调用回调函数看函数例子 callUserFuncArrayTest、callUserFuncTest；需要配合函数或类使用'));

        var_dump(static::toStr('forward_static_call_array、forward_static_call  与上面是同类但它针对上下文，直接用parent:: 放弃！！'));

        var_dump(static::toStr('func_num_args int、func_get_arg($i) mixed、func_get_args array； 获取函数参数看函数例子 funcGetArgTest；需要配合函数或类使用'));

        var_dump(static::toStr('register_tick_function、register_tick_function ； 配合流程控制的 declare 结构用来设定一段代码的执行指令；看函数例子registerTickFunctionTest'));

        var_dump(static::toStr('register_shutdown_function : void； 它会在脚本执行完成或者 exit() 后被调用；可以多次调用；用在HappyLin\OldPlugin\SingleClass\Exceptions'));



    }

    /**
     * 把第一个参数作为回调函数（callback）调用，把参数数组作（param_arr）为回调函数的的参数传入。
     * call_user_func_array( callable $callback, array $param_arr) : mixed
     *
     * 同类型 forward_static_call_array 针对上下文，直接用parent:: 放弃
     * @note 回调函数 call_user_func_array 例子
     */
    public  function callUserFuncArrayTest():void
    {
        $foobar = function ($arg, $arg2) {
            echo __FUNCTION__, " got $arg and $arg2\n<br>";
        };
        $foo = new class  {
            function bar($arg, $arg2) {
                echo __METHOD__, " got $arg and $arg2\n<br>";
            }
        };

        // Call the foobar() function with 2 arguments
        call_user_func_array($foobar, array("one", "two"));

        // Call the $foo->bar() method with 2 arguments
        call_user_func_array(array($foo, "bar"), array("three", "four"));
    }

    /**
     * 第一个参数 callback 是被调用的回调函数，其余参数是回调函数的参数。
     * call_user_func( callable $callback[, mixed $parameter[, mixed $...]] ) : mixed
     *
     * 同类型 forward_static_call 针对上下文，直接用parent:: 放弃
     * @note 回调函数 call_user_func 例子
     */
    public  function callUserFuncTest():void
    {
        $test = function($name){
            print "Hello $name!\n<br>";
        };

        $foo = new class {
            public function test($name) {
                print "Hello $name!\n<br>";
            }
        };

        call_user_func($test,'world'); // As of PHP 5.3.0
        call_user_func(array($foo, 'test'), 'world'); // As of PHP 5.3.0

    }


    /**
     * 函数多参数接收
     * func_num_args int 参数数量
     * func_get_arg($i) mixed 参数列表的某一项
     * func_get_args array 包含函数参数列表的数组
     * @note 函数多参数接收
     */
    public  function funcGetArgTest():void
    {
        $test = function($arg){
            $numargs = func_num_args();
            print "接收到{$numargs}个参数!\n<br>";

            for ($i = 0; $i < $numargs; $i++) {
                echo "参数 $i is: " . func_get_arg($i) . "<br />\n";
            }
            echo implode(func_get_args()) . "<br />\n";
        };
        $test('H','e','l','l','o');
    }


    /**
     * @note declare 结构注册回调函数
     */
    public function registerTickFunctionTest()
    {
//        function tick_handler($a = null)
//        {
//            echo "tick_handler() called\n{$a}<br>";
//        }
//        $a = 1;
//        tick_handler();
//
//        if ($a > 0) {
//            $a += 2;
//            tick_handler();
//            print($a);
//            tick_handler();
//        }
//        tick_handler();

        declare(ticks=1){
            register_tick_function($tick_handler = function ($a = null)
            {
                echo "tick_handler() called\n{$a}<br>";
            });
            $a = 1;
            if ($a > 0) {

                unregister_tick_function($tick_handler);

                $a += 2;
                print($a);
            }
        };
    }



}

