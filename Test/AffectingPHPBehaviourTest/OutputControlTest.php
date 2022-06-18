<?php
/**
 * OutputControl当PHP脚本有输出时，输出控制函数可以用这些来控制输出。这在多种不同情况中非常有用，尤其是用来在脚本开始输出 数据后，发送http头信息到浏览器。
 * 输出控制函数不影响由 header() 或 setcookie()发送的文件头信息，仅影响象 echo这样的函数和PHP代码块间的数据。
 */



namespace HappyLin\OldPlugin\Test\AffectingPHPBehaviourTest;


use HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\Output\Contract\Flush;
use HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\Output\OutputControl;



use HappyLin\OldPlugin\Test\TraitTest;


class OutputControlTest
{


    use TraitTest;


    public function __construct()
    {

    }

    /**
     * @note 输出缓冲控制
     */
    public function outputTest(){

        $outputControl = new OutputControl();

        var_dump(static::toStr('打开输出控制缓冲; 可选回调函数; ob_start()',[
            'ob_start(function ($buffer) {return (str_replace("apples", "oranges", $buffer));}, 0, PHP_OUTPUT_HANDLER_STDFLAGS);' => '自定义回调函数',
            'ob_start(\'ob_iconv_handler\')'  =>  '输出缓冲处理程序转换字符编码,将字符编码从 internal_encoding 转换到 output_encoding。 ;但iconv_set_encoding()这个有警告 用 ob_start("mb_output_handler") 替换',
            'ob_start("mb_output_handler")'  =>  '编码回调函数; 在输出缓冲中转换字符编码的回调函数 mb_http_output("UTF-8"); ob_start("mb_output_handler") ',
        ]));

        var_dump(static::toStr('输出缓冲； ob_flush()的作用就是将本来存在输出缓存中的内容取出来，设置为等待输出状态，但不会直接发送到客户端 ，需要先使用 ob_flush()再使用flush()，客户端才能立即获得脚本的输出; ob_flush();flush(); '));

        var_dump(static::toStr('获取缓冲; 输出缓冲区的内容；ob_get_contents();'));
        var_dump(static::toStr('获取缓冲; 输出缓冲区内容的长度；ob_get_length();'));
        var_dump(static::toStr('获取缓冲; 嵌套的输出缓冲处理程序的级别；getLevel();'));
        var_dump(static::toStr('获取缓冲; 得到所有输出缓冲区的状态；ob_get_status();'));

        var_dump(static::toStr('清空缓冲; 必须已被 ob_start() 以 PHP_OUTPUT_HANDLER_CLEANABLE 标记启动。clean();'));

        var_dump(static::toStr('关闭缓冲; 清空（擦除）缓冲区; 关闭输出缓冲； ob_end_clean()'));
        var_dump(static::toStr('关闭缓冲; 得到当前缓冲区的内容; 关闭输出缓冲; 实质上是一起执行了 ob_get_contents() 和 ob_end_clean()。；ob_get_clean();'));
        var_dump(static::toStr('关闭缓冲; 冲刷出（送出）输出缓冲区内容; 关闭输出缓冲; 这个函数与ob_get_flush()相似，不同的是ob_get_flush()会把缓冲区中的内容作为字符串返回；ob_end_flush()'));

        var_dump(static::toStr('将打开或关闭绝对（隐式）刷送。绝对（隐式）刷送将导致在每次输出调用后有一次刷送操作，以便不再需要对 flush() 的显式调用。ob_implicit_flush();'));
        var_dump(static::toStr('列出所有使用中的输出处理程序; ob_list_handlers();', $outputControl->listHandlers()));

        var_dump(static::toStr('其他函数;', [
            'output_add_rewrite_var' => '添加URL重写器的值（Add URL rewriter values）;此函数给URL重写机制添加名/值对。这种名值对将被添加到URL（以GET参数的形式）和表单（以input隐藏域的形式），当透明URL重写用 session.use_trans_sid 开启时同样可以添加到session ID。要注意，绝对URL(http://example.com/..)不能被重写。 ',
            'output_reset_rewrite_vars' => '重设URL重写器的值（Reset URL rewriter values）;移除所有的先前由 output_add_rewrite_var() 函数设置的重写变量',

        ]));
    }





    /**
     * @note 获取文件内容或class
     *
     * @param Flush $flush
     * @param int $max 预防死循环输出超过该时间：秒
     */
    public function shortcutGetContent($object)
    {
        // 开启无限缓冲区
        $this->start();

        print_r($object);

        return $this->getClean();
    }

    /**
     * @note 循环输出loop的数据
     *
     * @param Flush $flush
     * @param int $max 预防死循环输出超过该时间：秒
     */
    public function shortcutDownload(Flush $flush, int $second = 20)
    {
        // 开启无限缓冲区
        $this->start();
        $flush->start();

        // 预防死循环输出超过100次报错
        $endTime = time() + $second;

        foreach($flush->loop() as $flag){

//            var_dump($endTime-time(), $this->getLength());

            // 输出缓冲区
            $this->flush();
            if($flag){
                break;
            }
            if($endTime<=time()){
                break;
            }
        }

        // 输出缓冲区，关闭缓冲区
        $this->endFlush();
    }



}


