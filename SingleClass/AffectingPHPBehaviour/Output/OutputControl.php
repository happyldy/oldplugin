<?php
/**
 * OutputControl当PHP脚本有输出时，输出控制函数可以用这些来控制输出。这在多种不同情况中非常有用，尤其是用来在脚本开始输出 数据后，发送http头信息到浏览器。
 * 输出控制函数不影响由 header() 或 setcookie()发送的文件头信息，仅影响象 echo这样的函数和PHP代码块间的数据。
 */


namespace HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\Output;

use HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\Output\Contract\Flush;

class OutputControl
{

    /**
     * 打开输出控制缓冲
     * ob_start([ callable $output_callback = NULL[, int $chunk_size = 0[, int $flags = PHP_OUTPUT_HANDLER_STDFLAGS]]] ) : bool
     *
     *  $output_callback
     *      handler( string $buffer[, int $phase] ) : string ;
     *          如果 output_callback 返回 FALSE ，其原来的输入内容被直接送到浏览器。
     *          ob_end_clean(), ob_end_flush(), ob_clean(), ob_flush() 和 ob_start() 不能从一个回调函数中调用。
     *          如果想要删除缓冲区的内容，从回调函数中返回一个"" (空字符串)。 更不能从一个回调函数中使用像print_r($expression, true) 或highlight_file($filename, true) 一样的输出缓冲函数。
     *          $phase : 比特掩码  自 PHP 5.4 起可用。
     *              PHP_OUTPUT_HANDLER_* 常量。
     *              PHP_OUTPUT_HANDLER_START        表示输出缓冲已经开始。
     *              PHP_OUTPUT_HANDLER_WRITE        表示正在刷新输出缓冲区，并且有数据要输出。  别名 PHP_OUTPUT_HANDLER_CONT(int)    表示缓冲区已被刷新，但输出缓冲将继续。
     *              PHP_OUTPUT_HANDLER_FLUSH        指示缓冲区已被刷新。
     *              PHP_OUTPUT_HANDLER_CLEAN        表示输出缓冲区已被清理。
     *              PHP_OUTPUT_HANDLER_FINAL        表示这是最终的输出缓冲操作。  别名 PHP_OUTPUT_HANDLER_END(int)     表示输出缓冲已结束。
     *              PHP_OUTPUT_HANDLER_CLEANABLE    控制是否可以清除 ob_start() 创建的输出缓冲区。
     *              PHP_OUTPUT_HANDLER_FLUSHABLE    控制是否可以刷新由 ob_start() 创建的输出缓冲区。
     *              PHP_OUTPUT_HANDLER_REMOVABLE    控制是否可以在脚本结束之前删除 ob_start() 创建的输出缓冲区。
     *              PHP_OUTPUT_HANDLER_STDFLAGS     默认的输出缓冲区标志集；当前相当于 PHP_OUTPUT_HANDLER_CLEANABLE | PHP_OUTPUT_HANDLER_FLUSHABLE | PHP_OUTPUT_HANDLER_REMOVABLE。
     *
     * @param null $output_callback  处理buffer中的数据。比如函数ob_gzhandler，将buffer中的数据压缩后再传送给浏览器。 handler( string $buffer[, int $phase] ) : string
     * @param int $chunk_size 指定output_buffering的值。$chunk_size默认值是0,表示直到脚本运行结束，php buffer中的数据才会发送到浏览器。如果你设置了$chunk_size的大小 ，则表示只要buffer中数据长度达到了该值，就会将buffer中 的数据发送给浏览器。
     * @param int $flags flags 参数代表了一个掩码位，用来控制对缓冲区的操作 PHP_OUTPUT_HANDLER_CLEANABLE PHP_OUTPUT_HANDLER_FLUSHABLE PHP_OUTPUT_HANDLER_REMOVABLE PHP_OUTPUT_HANDLER_STDFLAGS
     * @return bool
     */
    public function start ($output_callback = NULL, int $chunk_size = 0, int $flags = PHP_OUTPUT_HANDLER_STDFLAGS): bool
    {
        return ob_start(...func_get_args());
    }


    /**
     * 输出缓冲区并清空缓冲区
     * ob_flush()的作用就是将本来存在输出缓存中的内容取出来，设置为等待输出状态，但不会直接发送到客户端 ，需要先使用 ob_flush()再使用flush()，客户端才能立即获得脚本的输出。
     * 调用ob_flush()之后缓冲区内容将被丢弃。
     * @return mixed
     */
    public function flush(): void
    {
        ob_flush();
        flush();
    }


    /**
     * 清空（擦掉）缓冲区
     * 输出缓冲必须已被 ob_start() 以 PHP_OUTPUT_HANDLER_CLEANABLE 标记启动。否则 ob_clean() 不会有效果。
     * @return mixed
     */
    public function clean(): void
    {
        ob_clean();
    }

    /**
     * 清空（擦除）缓冲区; 关闭输出缓冲
     * 如果函数失败了，将引发一个E_NOTICE异常。
     * @return mixed
     */
    public function endClean(): bool
    {
        return ob_end_clean();
    }

    /**
     * 得到当前缓冲区的内容; 关闭输出缓冲
     * ob_get_clean() 实质上是一起执行了 ob_get_contents() 和 ob_end_clean()。
     * 返回输出缓冲区的内容，并结束输出缓冲区。如果输出缓冲区不是活跃的，即返回 FALSE 。
     * @return mixed
     */
    public function getClean(): string
    {
        return ob_get_clean();
    }


    /**
     * 冲刷出（送出）输出缓冲区内容; 关闭输出缓冲
     * 这个函数与ob_get_flush()相似，不同的是ob_get_flush()会把缓冲区中的内容作为字符串返回。
     * 如果函数失败了，将引发一个E_NOTICE异常。
     * @return mixed
     */
    public function endFlush(): bool
    {
        return ob_end_flush();
    }

    /**
     * 刷出（送出）缓冲区内容，以字符串形式返回内容; 关闭输出缓冲区。
     * 返回输出缓冲区的内容；或者是，如果没有起作用的输出缓冲区，返回FALSE 。
     * @return mixed
     */
    public function getFlush(): string
    {
        return ob_get_flush();
    }
    

    /**
     * 返回输出缓冲区的内容
     * 此函数返回输出缓冲区的内容，或者如果输出缓冲区无效将返回FALSE 。
     * @return mixed
     */
    public function getContents(): string
    {
        return ob_get_contents();
    }


    /**
     *  返回输出缓冲区内容的长度
     * 返回输出缓冲区内容的长度；或者返回FALSE——如果没有起作用的缓冲区。
     * @return mixed
     */
    public function getLength(): int
    {
        return ob_get_length();
    }


    /**
     * 返回输出缓冲机制的嵌套级别
     * 返回嵌套的输出缓冲处理程序的级别；或者是，如果输出缓冲区不起作用，返回零。
     *
     *     $level = ob_get_level();
     *     ob_start();
     *      try
     *      {
     *          include $view;
     *      }
     *      catch (Exception $e)
     *      {
     *          while (ob_get_level() > $level)
     *          {
     *              ob_end_clean();
     *          }
     *          throw $e;
     *      }
     *     return ob_get_clean();
     *
     * @return int
     */
    public function getLevel(): int
    {
        return ob_get_level();
    }




    /**
     * 得到所有输出缓冲区的状态
     * Array
     * (
     *     [level] => 2
     *     [type] => 0
     *     [status] => 0
     *     [name] => URL-Rewriter
     *     [del] => 1
     * )
     * level 输出嵌套级别
     * type PHP_OUTPUT_HANDLER_INTERNAL (0) 或者 PHP_OUTPUT_HANDLER_USER (1)
     * status PHP_OUTPUT_HANDLER_START (0), PHP_OUTPUT_HANDLER_CONT (1) or PHP_OUTPUT_HANDLER_END (2) 三个之一
     * name 起作用的输出处理程序的名字，或者是默认的输出处理程序的名字（如果没有设置的话）
     * del 由ob_start()设置的删除标签（Erase-flag）
     *
     * @param bool $full_status 设为TRUE 返回所有有效的输出缓冲区级别的状态信息。如果设为 FALSE 或者没有设置，仅返回最 顶层输出缓冲区的状态信息。
     * @return array
     */
    public function getStatus(bool $full_status = FALSE): array
    {
        return ob_get_status();
    }




    /**
     * ob_implicit_flush()将打开或关闭绝对（隐式）刷送。绝对（隐式）刷送将导致在每次输出调用后有一次刷送操作，以便不再需要对 flush() 的显式调用。
     *
     * @param bool $flag 设为TRUE 打开绝对刷送，反之是 FALSE 。
     */
    public function implicitFlush(bool $flag = true): void
    {
        ob_implicit_flush();
    }



    /**
     * 列出所有使用中的输出处理程序。
     * 此函数将返回一个数组，数组元素是正在使用中输出处理程序名（如果存在的输出处理程序的话）。如果启用了output_buffering 或者在 ob_start() 中创建了一个匿名函数，ob_list_handlers() 将返回 "default output handler"。
     * Array
     * (
     *     [0] => default output handler
     * )
     * @return array
     */
    public function listHandlers(bool $flag = true): array
    {
        return ob_list_handlers();
    }


    
    
    




}












