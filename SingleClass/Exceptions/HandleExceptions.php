<?php
/**
 * 1 E_ERROR (int)  致命的运行时错误。这类错误一般是不可恢复的情况，例如内存分配导致的问题。后果是导致脚本终止不再继续运行。
 * 2 E_WARNING (int)  运行时警告 (非致命错误)。仅给出提示信息，但是脚本不会终止运行。
 * 4 E_PARSE (int)  编译时语法解析错误。解析错误仅仅由分析器产生。
 * 8 E_NOTICE (int)  运行时通知。表示脚本遇到可能会表现为错误的情况，但是在可以正常运行的脚本里面也可能会有类似的通知。
 * 16 E_CORE_ERROR (int)  在 PHP 初始化启动过程中发生的致命错误。该错误类似 E_ERROR，但是是由 PHP 引擎核心产生的。
 * 32 E_CORE_WARNING (int)  PHP 初始化启动过程中发生的警告 (非致命错误) 。类似 E_WARNING，但是是由 PHP 引擎核心产生的。
 * 64 E_COMPILE_ERROR (int)  致命编译时错误。类似 E_ERROR，但是是由 Zend 脚本引擎产生的。
 * 128 E_COMPILE_WARNING (int)  编译时警告 (非致命错误)。类似 E_WARNING，但是是由 Zend 脚本引擎产生的。
 * 256 E_USER_ERROR (int)  用户产生的错误信息。类似 E_ERROR，但是是由用户自己在代码中使用 PHP 函数 trigger_error()来产生的。
 * 512 E_USER_WARNING (int)  用户产生的警告信息。类似 E_WARNING，但是是由用户自己在代码中使用 PHP 函数 trigger_error()来产生的。
 * 1024 E_USER_NOTICE (int)  用户产生的通知信息。类似 E_NOTICE，但是是由用户自己在代码中使用 PHP 函数 trigger_error()来产生的。
 * 2048 E_STRICT (int)  启用 PHP 对代码的修改建议，以确保代码具有最佳的互操作性和向前兼容性。  PHP 5.4.0 之前的版本中不包含 E_ALL
 * 4096 E_RECOVERABLE_ERROR (int)  可被捕捉的致命错误。 它表示发生了一个可能非常危险的错误，但是还没有导致PHP引擎处于不稳定的状态。 如果该错误没有被用户自定义句柄捕获 (参见 set_error_handler())，将成为一个 E_ERROR　从而脚本会终止运行。  自 PHP 5.2.0 起
 * 8192 E_DEPRECATED (int)  运行时通知。启用后将会对在未来版本中可能无法正常工作的代码给出警告。  自 PHP 5.3.0 起
 * 16384 E_USER_DEPRECATED (int)  用户产少的警告信息。 类似 E_DEPRECATED, 但是是由用户自己在代码中使用PHP函数 trigger_error()来产生的。  自 PHP 5.3.0 起
 * 32767 E_ALL (int)  PHP 5.4.0 之前为 E_STRICT 除外的所有错误和警告信息。  PHP 5.4.x 中为 32767,PHP 5.3.x 中为 30719,PHP 5.2.x 中为 6143, 更早之前的 PHP 版本中为 2047。
 *
 *
 * Exception是所有PHP内部错误类的基类
 * public Exception::__construct([ string $message = ""[, int $code = 0[, Throwable $previous = NULL]]] )
 * message
 * 抛出的异常消息内容。
 * code
 * 异常代码。
 * previous
 * 异常链中的前一个异常。
 * Note: 如果子类的 $code 和 $message 属性已设置，在调用 Exception 父类的构造器时可以省略默认参数。
 *
 *
 * public ErrorException::__construct([ string $message = ""[, int $code = 0[, int $severity = E_ERROR[, string $filename = __FILE__[, int $lineno = __LINE__[, Exception $previous = NULL]]]]]] )
 * message
 * 抛出的异常消息内容。
 * code
 * 异常代码。
 * severity
 * 异常的严重级别。Note:severity 可以是任意 integer 值，即错误常量里面的值。
 * filename
 * 抛出异常所在的文件名。
 * lineno
 * 抛出异常所在的行号。
 * previous
 * 异常链中的前一个异常。
 *
 *
 * php7: 是所有PHP内部错误类的基类
 * public Error::__construct([ string $message = ""[, int $code = 0[, Throwable $previous = NULL]]] )
 *
 *
 *
 *
 * 手册：函数参考-》其他基本扩展-》spl ->异常
 *  BadFunctionCallException    extends LogicException              // 如果回调引用未定义的函数或缺少某些参数，则引发异常。
 *  BadMethodCallException      extends BadFunctionCallException    // 当一个回调方法是一个未定义的方法或缺失一些参数时会抛出该异常。
 *  DomainException             extends LogicException              // 如果值不符合定义的有效数据域，则引发异常
 *  InvalidArgumentException    extends LogicException              // 如果参数不是预期类型，则引发异常。
 *  LengthException             extends LogicException              // 如果长度无效，则引发异常。
 *  OutOfRangeException         extends LogicException              // 请求非法索引时引发异常。这表示应在编译时检测到的错误。
 *  LogicException              extends Exception                   // 表示程序逻辑错误的异常。代码里必须解决的异常。
 *
 *  OutOfBoundsException        extends RuntimeException            // 如果值不是有效键，则引发异常。这表示编译时无法检测到的错误。
 *  OverflowException           extends RuntimeException            // 将元素添加到完整容器时引发异常。
 *  RangeException              extends RuntimeException            // 在程序执行期间引发异常以指示范围错误。通常这意味着存在除Under/overflow之外的算术错误。这是DomainException的运行时版本。
 *  UnexpectedValueException    extends RuntimeException            // 如果值与一组值不匹配，则引发异常。典型当一个函数调用另一个函数并期望返回值为不包括算术或缓冲相关错误的特定类型或值时，就会发生这种情况。
 *  RuntimeException            extends Exception                   // 如果发生只能在运行时找到的错误，则引发异常。
 *
 *
 *
 * 语言参考-›预定义异常
 *
 *  TypeError               extends  Error          有三种情况会抛出    TypeError。第一种，传递给函数的参数类型与函数预期声明的参数类型不匹配；第二种，函数返回的值与声明的函数返回类型不匹配；第三种，调用 PHP 内置函数时，传递了非法的数字参数（仅限在严格模式下 / strict mode）。
 *  CompileError            extends  Error          是针对一些编译错误抛出的，之前是会发出致命错误。
 *  ArithmeticError         extends  Error          当执行数学运算时发生错误时被抛出。PHP7.0这些错误包括试图通过negativeamount执行位移位，以及对intdiv（）的任何调用，这将导致avalue超出整数的可能边界。
 *  AssertionError          extends  Error          在函数 assert() 断言失败时被抛出。
 *
 *  ArgumentCountError      extends  TypeError      当传递给用户定义的函数或方法的参数太少时被抛出。
 *  DivisionByZeroError     extends  ArithmeticError    当除数为零时被抛出。
 *  ParseError              extends  CompileError   当解析 PHP 代码时发生错误时抛出，比如当    eval()被调用出错时。
 *
 *
 *
 *
 *
 */


namespace HappyLin\OldPlugin\SingleClass\Exceptions;


// use HappyLin\OldPlugin\SingleClass\Exceptions\FatalErrorException;


use HappyLin\OldPlugin\SingleClass\Network\HeaderHelp;

use Exception,Throwable,ErrorException;



class HandleExceptions
{



    public function __construct()
    {
        $this->init();
    }


    /**
     * 注册错误处理方法
     */
    public function init()
    {
        /**
         * // 关闭所有PHP错误报告
         * error_reporting(0);
         *
         * // Report simple running errors 报告运行时错误
         * error_reporting(E_ERROR | E_WARNING | E_PARSE);
         *
         * // 报告 E_NOTICE也挺好 (报告未初始化的变量
         * // 或者捕获变量名的错误拼写)
         * error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
         *
         * // 除了 E_NOTICE，报告其他所有错误
         * error_reporting(E_ALL ^ E_NOTICE);
         *
         * // 报告所有 PHP 错误 (参见 changelog)
         * error_reporting(E_ALL);
         *
         * // 报告所有 PHP 错误
         * error_reporting(-1);
         *
         * // 和 error_reporting(E_ALL); 一样
         * ini_set('error_reporting', E_ALL);
         *
         *
         * 参数  level新的 error_reporting 级别。
         * 返回旧的 error_reporting 级别，或者在 level 参数未给出时返回当前的级别。
         */
        error_reporting(-1);

        /**
         * 设置用户的函数 (error_handler) 来处理脚本中出现的错误。
         * set_error_handler( callable $error_handler[, int $error_types = E_ALL | E_STRICT] ) : mixed
         *
         * 参数
         * error_handler
         * 以下格式的回调（callback）：可以传入 NULL 重置处理程序到默认状态。除了可以传入函数名，还可以传入引用对象和对象方法名的数组。
         *      handler( int $errno, string $errstr[, string $errfile[, int $errline[, array $errcontext]]] ) : bool
         *      errno第一个参数 errno，包含了错误的级别，是一个 integer。
         *      errstr第二个参数 errstr，包含了错误的信息，是一个 string。
         *      errfile第三个参数是可选的，errfile，包含了发生错误的文件名，是一个 string。
         *      errline第四个参数是一个可选项， errline，包含了错误发生的行号，是一个 integer。
         *      errcontext第五个可选参数， errcontext，是一个指向错误发生时活动符号表的 array。也就是说，errcontext 会包含错误触发处作用域内所有变量的数组。用户的错误处理程序不应该修改错误上下文（context）。Warning PHP 7.2.0 后此参数被弃用了。极其不建议依赖它。
         * 如果函数返回 FALSE，标准错误处理处理程序将会继续调用。
         *
         * error_types
         * 就像error_reporting 的 ini 设置能够控制错误的显示一样，此参数能够用于屏蔽 error_handler 的触发。如果没有该掩码，无论 error_reporting 是如何设置的， error_handler 都会在每个错误发生时被调用。
         *
         */
        set_error_handler([$this, 'handleError']);

        /**
         * 设置默认的异常处理程序，用于没有用 try/catch 块来捕获的异常。在 exception_handler 调用后异常会中止。
         *
         * 参数
         * exception_handler
         * 当一个未捕获的异常发生时所调用函数的名称。该处理函数需要接受一个参数，该参数是一个抛出的异常对象。
         * PHP 7 以前的异常处理程序签名：
         *      handler( Exception $ex) : void
         * 自 PHP 7 以来，大多数错误抛出 Error 异常，也能被捕获。 Error 和 Exception 都实现了 Throwable 接口。 PHP 7 起，处理程序的签名：
         *      handler( Throwable $ex) : void
         * 也可以传递 NULL 值用于重置异常处理函数为默认值。Caution注意，如果在用户回调里将 ex 参数的类型明确约束为Exception， PHP 7 中由于异常类型的变化，将会产生问题。
         *
         * 返回值
         * 返回之前定义的异常处理程序的名称，或者在错误时返回 NULL。如果之前没有定义错误处理程序，也会返回 NULL。
         */
        set_exception_handler([$this, 'handleException']);


        /**
         * 注册一个 callback ，它会在脚本执行完成或者 exit() 后被调用。
         * 可以多次调用 register_shutdown_function() ，这些被注册的回调会按照他们注册时的顺序被依次调用。如果你在注册的方法内部调用 exit()， 那么所有处理会被中止，并且其他注册的中止回调也不会再被调用。
         *
         * 参数
         * callback
         * 待注册的中止回调； 中止回调是作为请求的一部分被执行的，因此可以在它们中进行输出或者读取输出缓冲区。
         * parameter
         * 可以通过传入额外的参数来将参数传给中止函数
         * ...
         *
         */
        register_shutdown_function([$this, 'handleShutdown']);
    }




    /**
     * 设置用户的函数 (error_handler) 来处理脚本中出现的错误。
     *
     * @param  int  $level 包含了错误的级别，是一个 integer。
     * @param  string  $message 包含了错误的信息，是一个 string。
     * @param  string  $file 包含了发生错误的文件名，是一个 string。
     * @param  int  $line 包含了错误发生的行号，是一个 integer。
     * @param  array  $context PHP 7.2.0 后此参数被弃用了。极其不建议依赖它。
     * @return void
     *
     * @throws \ErrorException
     */
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        /**
         * error_reporting() 返回当前级别
         */
        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }


    /**
     * 设置默认的异常处理程序，用于没有用 try/catch 块来捕获的异常。在 exception_handler 调用后异常会中止。
     *
     * 参数
     * $e
     * PHP 7 以前的异常处理程序签名：
     *      handler( Exception $ex) : void
     * 自 PHP 7 以来，大多数错误抛出 Error 异常，也能被捕获。 Error 和 Exception 都实现了 Throwable 接口。 PHP 7 起，处理程序的签名：
     *      handler( Throwable $ex) : void
     *
     * @param  \Throwable  $e
     * @return void
     */
    public function handleException($e)
    {
        isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            ? $this->prepareJsonResponse( $e)
            : $this->prepareResponse($e);
    }


    /**
     * 脚本执行完成或者 exit() 后被调用。
     *
     * @return void
     */
    public function handleShutdown()
    {
        if (! is_null($error = $this->getLastError()) && in_array($error['type'], [E_COMPILE_ERROR, E_CORE_ERROR, E_ERROR, E_PARSE])) {
            $this->handleException(
                new \ErrorException($error['message'], $error['type'], 0, $error['file'], $error['line'], null)
            );
        }
    }



    /**
     * 打印错误信息
     *
     * @param  \Throwable  $e
     */
    private function prepareResponse( $e)
    {
        HeaderHelp::getInstance()->setContentType('html')->setHttpCode(500);
        echo '出错啦！！！';
        var_dump($e);
    }


    /**
     * 打印json类型错误信息
     *
     * @param  \Throwable  $e
     */
    private function prepareJsonResponse(Throwable $e)
    {

        HeaderHelp::getInstance()->setContentType('json')->setHttpCode(500);

        echo json_encode([
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'Code' => $e->getCode(),
            'trace' => $e->getTrace()
        ]);

    }



    /**
     * 产生一条 PHP 的回溯跟踪(backtrace)。
     *
     * 参数
     * options
     * 截至 5.3.6，这个参数是以下选项的位掩码：
     *      DEBUG_BACKTRACE_PROVIDE_OBJECT 是否填充 "object" 的索引。
     *      DEBUG_BACKTRACE_IGNORE_ARGS 是否忽略 "args" 的索引，包括所有的 function/method 的参数，能够节省内存开销。
     * 在 5.3.6 之前，仅仅能使用的值是 TRUE 或者 FALSE，分别等于是否设置 DEBUG_BACKTRACE_PROVIDE_OBJECT 选项。
     * limit
     * 截至 5.4.0，这个参数能够用于限制返回堆栈帧的数量。默认为 (limit=0) ，返回所有的堆栈帧。
     *
     * 返回值
     * 返回一个包含众多关联数组的 array。以下为有可能返回的元素：
     *      function string 当前的函数名，参见： __FUNCTION__。
     *      line integer 当前的行号。参见： __LINE__。
     *      file string 当前的文件名。参见： __FILE__。
     *      class string 当前 class 的名称。参见 __CLASS__
     *      object object 当前的 object。
     *      type string 当前调用的类型。如果是一个方法，会返回 "->"。如果是一个静态方法，会返回 "::"。如果是一个函数调用，则返回空。
     *      args array 如果在一个函数里，这会列出函数的参数。如果是在一个被包含的文件里，会列出包含的文件名。
     *
     * @param int $options DEBUG_BACKTRACE_PROVIDE_OBJECT
     * @param int $limit  0
     * @return array
     */
    public function debug_backtrace(int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT, int $limit = 0):array
    {
        return debug_backtrace($options, $limit);
    }
    
    
    

    /**
     * 获取关于最后一个发生的错误的信息。
     *
     * 返回了一个关联数组，描述了最后错误的信息，以该错误的 "type"、 "message"、"file" 和 "line" 为数组的键。如果该错误由 PHP 内置函数导致的，"message"会以该函数名开头。
     * 如果还没有错误则返回 NULL。
     */
    public function getLastError()
    {
        return error_get_last();
    }

    /**
     * 清除最近一次错误，使它无法通过 error_get_last() 获取。
     */
    public function clearLastError():void
    {
        error_clear_last();
    }

    /**
     * 在使用 set_error_handler() 改变错误处理函数之后，此函数可以用于还原之前的错误处理程序(可以是内置的或者也可以是用户所定义的函数)。
     * 该函数总是返回 TRUE。
     * @return bool true
     */
    public function restore_error_handler():bool
    {
        return restore_error_handler();
    }

    /**
     * 在使用 set_exception_handler() 改变异常处理函数之后，此函数可以用于还原之前的异常处理程序(可以是内置的或者也可以是用户所定义的函数)。
     * 该函数总是返回 TRUE。
     * @return bool true
     */
    public function restore_exception_handler():bool
    {
        return restore_exception_handler();
    }

    /**
     * 用于触发一个用户级别的错误条件，它能结合内置的错误处理器所关联，或者可以使用用户定义的函数作为新的错误处理程序(set_error_handler())。
     * 该函数在你运行出现异常时，需要产生一个特定的响应时非常有用。
     *
     *  1 E_ERROR (int)  致命的运行时错误。这类错误一般是不可恢复的情况，例如内存分配导致的问题。后果是导致脚本终止不再继续运行。
     *  2 E_WARNING (int)  运行时警告 (非致命错误)。仅给出提示信息，但是脚本不会终止运行。
     *  4 E_PARSE (int)  编译时语法解析错误。解析错误仅仅由分析器产生。
     *  8 E_NOTICE (int)  运行时通知。表示脚本遇到可能会表现为错误的情况，但是在可以正常运行的脚本里面也可能会有类似的通知。
     *  16 E_CORE_ERROR (int)  在 PHP 初始化启动过程中发生的致命错误。该错误类似 E_ERROR，但是是由 PHP 引擎核心产生的。
     *  32 E_CORE_WARNING (int)  PHP 初始化启动过程中发生的警告 (非致命错误) 。类似 E_WARNING，但是是由 PHP 引擎核心产生的。
     *  64 E_COMPILE_ERROR (int)  致命编译时错误。类似 E_ERROR，但是是由 Zend 脚本引擎产生的。
     *  128 E_COMPILE_WARNING (int)  编译时警告 (非致命错误)。类似 E_WARNING，但是是由 Zend 脚本引擎产生的。
     *  256 E_USER_ERROR (int)  用户产生的错误信息。类似 E_ERROR，但是是由用户自己在代码中使用 PHP 函数 trigger_error()来产生的。
     *  512 E_USER_WARNING (int)  用户产生的警告信息。类似 E_WARNING，但是是由用户自己在代码中使用 PHP 函数 trigger_error()来产生的。
     *  1024 E_USER_NOTICE (int)  用户产生的通知信息。类似 E_NOTICE，但是是由用户自己在代码中使用 PHP 函数 trigger_error()来产生的。
     *  2048 E_STRICT (int)  启用 PHP 对代码的修改建议，以确保代码具有最佳的互操作性和向前兼容性。  PHP 5.4.0 之前的版本中不包含 E_ALL
     *  4096 E_RECOVERABLE_ERROR (int)  可被捕捉的致命错误。 它表示发生了一个可能非常危险的错误，但是还没有导致PHP引擎处于不稳定的状态。 如果该错误没有被用户自定义句柄捕获 (参见 set_error_handler())，将成为一个 E_ERROR　从而脚本会终止运行。  自 PHP 5.2.0 起
     *  8192 E_DEPRECATED (int)  运行时通知。启用后将会对在未来版本中可能无法正常工作的代码给出警告。  自 PHP 5.3.0 起
     *  16384 E_USER_DEPRECATED (int)  用户产少的警告信息。 类似 E_DEPRECATED, 但是是由用户自己在代码中使用PHP函数 trigger_error()来产生的。  自 PHP 5.3.0 起
     *  32767 E_ALL (int)  PHP 5.4.0 之前为 E_STRICT 除外的所有错误和警告信息。  PHP 5.4.x 中为 32767,PHP 5.3.x 中为 30719,PHP 5.2.x 中为 6143, 更早之前的 PHP 版本中为 2047。
     *
     * 返回值
     * 如果指定了错误的 error_type 会返回 FALSE ，正确则返回 TRUE。
     *
     * @param string $error_msg 该 error 的特定错误信息，长度限制在了 1024 个字节。超过 1024 字节的字符都会被截断。
     * @param int $error_type 该 error 所特定的错误类型。仅 E_USER 系列常量对其有效，默认是 E_USER_NOTICE。
     */
    public function trigger_error(string $error_msg, int $error_type = E_USER_NOTICE):bool
    {
        trigger_error($error_msg, $error_type);
    }

    


//    /**
//     * 把错误信息发送到 web 服务器的错误日志，或者到一个文件里。
//     * Tip message 不能包含 null 字符。注意，message 可能会发送到文件、邮件、syslog 等。所以在调用 error_log() 前需要使用适合的转换/转义函数： base64_encode()、 rawurlencode() 或 addslashes()。
//     *
//     * 参数
//     * message
//     * 应该被记录的错误信息。
//     * message_type
//     * 设置错误应该发送到何处。可能的信息类型有以下几个：
//     *      error_log() 日志类型
//     *      0 message 发送到 PHP 的系统日志，使用操作系统的日志机制或者一个文件，取决于 error_log 指令设置了什么。这是个默认的选项。
//     *      1 message 发送到参数 destination 设置的邮件地址。第四个参数 extra_headers 只有在这个类型里才会被用到。
//     *      2 不再是一个选项。
//     *      3 message 被发送到位置为 destination 的文件里。字符 message 不会默认被当做新的一行。
//     *      4 message 直接发送到 SAPI 的日志处理程序中。
//     *
//     * destination
//     * 目标。它的含义描述于以上，由 message_type 参数所决定。
//     * extra_headers
//     * 额外的头。当 message_type 设置为 1 的时候使用。该信息类型使用了 mail() 的同一个内置函数。
//     *
//     * error_log( string $message[, int $message_type = 0[, string $destination[, string $extra_headers]]] ) : bool
//     *
//     * 返回值
//     * 成功时返回 TRUE， 或者在失败时返回 FALSE。
//     *
//     */
//    public function errorLog($message, ):bool
//    {
//        //例子： 但感觉用不了放弃
//
//        // 如果无法连接到数据库，发送通知到服务器日志
//        if (!Ora_Logon($username, $password)) {
//            error_log("Oracle database not available!", 0);
//        }
//
//        // 如果用尽了 FOO，通过邮件通知管理员
//        if (!($foo = allocate_new_foo())) {
//            error_log("Big trouble, we're all out of FOOs!", 1,
//                "operator@example.com");
//        }
//
//        // 调用 error_log() 的另一种方式:
//        error_log("You messed up!", 3, "/var/tmp/my-errors.log");
//    }





}
