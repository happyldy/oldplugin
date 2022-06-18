<?php
/**
 * 有关运行系统的函数
 * 
 */


namespace HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits;


trait System
{


    /**
     * 返回分配给你的 PHP 脚本的内存峰值字节数。
     * @param bool $real_usage 如果设置为 TRUE 可以获取从系统分配到的真实内存尺寸。如果未设置，或者设置为 FALSE，仅会报告 emalloc() 使用的内存。
     * @return int 返回内存峰值的字节数。
     */
    public static function memoryGetPeakUsage(bool $real_usage = false ): int
    {
        return memory_get_peak_usage($real_usage);
    }


    /**
     * 返回当前分配给你的 PHP 脚本的内存量，单位是字节（byte）。
     * @param bool $real_usage 如果设置为 TRUE，获取系统分配总的内存尺寸，包括未使用的页。如果未设置或者设置为 FALSE，仅仅报告实际使用的内存量。
     * @return int 返回内存量字节数。
     */
    public static function memoryGetUsage(bool $real_usage = false): int
    {
        return memory_get_usage($real_usage);
    }










    /**
     * 返回了包含当前运行 PHP 解释器或扩展版本信息的 string。
     * 只查php版本 PHP_VERSION
     * @param string $extension 可选的扩展名
     * @return string 如果指定了可选参数 extension，phpversion()会返回该扩展的版本。如果没有对应的版本信息，或者该扩展未启用，则返回 FALSE。
     */
    public static function phpversion(string $extension = null)
    {
        return phpversion(...func_get_args());
    }



    /**
     * 用于对比两个「PHP 规范化」的版本数字字符串。
     *
     * @param string $version1 第一个版本数。
     * @param string $version2 第二个版本数。
     * @param string $operator (此参数区分大小写，它的值应该是小写的)如果你指定了可选的第三个参数 operator，你可以测试两者的特定关系。可以的操作符分别是：<、 lt、<=、 le、>、 gt、>=、 ge、==、 =、eq、 !=、<> 和 ne。
     * @return mixed 默认情况下，在第一个版本低于第二个时，version_compare() 返回 -1；如果两者相等，返回 0；第二个版本更低时则返回 1; 当使用了可选参数 operator 时，如果关系是操作符所指定的那个，函数将返回 TRUE，否则返回 FALSE。
     */
    public static function versionCompare( string $version1, string $version2, string $operator = null)
    {
        return version_compare(...func_get_args());
    }






    /**
     * 返回了运行 PHP 的操作系统的描述。这和 phpinfo() 最顶端上输出的是同一个字符串。如果仅仅要获取操作系统的名称。可以考虑使用常量 PHP_OS，不过要注意该常量会包含 PHP 构建（built）时的操作系统名。
     *
     * 参数
     * mode
     * mode 是单个字符，用于定义要返回什么信息：
     * ◦ 'a'：此为默认。包含序列 "s n r v m" 里的所有模式。
     * ◦ 's'：操作系统名称。例如： FreeBSD。
     * ◦ 'n'：主机名。例如： localhost.example.com。
     * ◦ 'r'：版本名称，例如： 5.1.2-RELEASE。
     * ◦ 'v'：版本信息。操作系统之间有很大的不同。
     * ◦ 'm'：机器类型。例如：i386。
     *
     * 返回值
     * @param string $mode 单个字符，用于定义要返回什么信息：
     * @return string 返回描述字符串。
     */
    public static function phpUname(string $mode = "a") : string
    {
        return php_uname($mode);
    }

    /**
     * 返回描述 PHP 所使用的接口类型（the Server API, SAPI）的小写字符串。例如，CLI 的 PHP 下这个字符串会是 "cli"，Apache 下可能会有几个不同的值，取决于具体使用的 SAPI。以下列出了可能的值。
     * 可能返回的值包括了 aolserver、apache、 apache2filter、apache2handler、 caudium、cgi （直到 PHP 5.3）, cgi-fcgi、cli、 cli-server、 continuity、embed、fpm-fcgi、 isapi、litespeed、 milter、nsapi、 phttpd、pi3web、roxen、 thttpd、tux 和 webjames。
     * @return string 返回接口类型的小写字符串。
     */
    public static function phpSapiName() : string
    {
        return php_sapi_name();
    }


    /**
     * 获取当前 PHP 脚本所有者名称
     * @return string
     */
    public static function getCurrentUser() : string
    {
        return get_current_user();
    }


    /**
     * 获取 PHP 进程的 ID
     */
    public static function getmypid():int
    {
        return getmypid();
    }

    /**
     * 获取当前运行的 Zend 引擎的版本字符串。
     * @return string
     */
    public static function zendVersion(): string
    {
        return zend_version();
    }

    /**
     * 该函数返回当前线程的唯一识别符。
     * 该函数仅在以下情况有效：PHP 内置 ZTS（Zend 线程安全）的支持，并开启调试模式（--enable-debug）时。
     * @return int 以整型（integer）返回线程的 ID。
     */
    public static function zend_thread_id(): int
    {
        return zend_thread_id();
    }

    /**
     * 获取当前资源使用状况
     *
     * $dat = getrusage();
     * echo$dat[“ru_oublock”]；  //块输出操作数
     * echo$dat[“ru_inblock”]；  //块输入操作数
     * echo$dat[“ru_msgsnd”]；   //发送的IPC消息数
     * echo$dat[“ru_msgrcv”]；   //接收到的IPC消息数
     * echo$dat[“ru_maxrss”]；   //最大驻留集大小
     * echo$dat[“ru_ixrss”]；    //积分共享内存大小
     * echo$dat[“ru_idrss”]；    //整数非共享数据大小
     * echo$dat[“ru_minflt”]；   //页面回收次数（软页面错误）
     * echo$dat[“ru_majflt”]；   //页面错误数（硬页面错误）
     * echo$dat[“ru_nsignals”]； //接收到的信号数
     * echo$dat[“ru_nvcsw”]；    //自愿性上下文切换的数量
     * echo$dat[“ru_nivcsw”]；   //非自愿上下文切换的数量
     * echo$dat[“ru_nswap”]；    //互换数量
     * echo$dat[“ru_utime.tv_usec”]；    //使用的用户时间（微秒）
     * echo$dat[“ru_utime.tv_sec”]；     //使用的用户时间（秒）
     * echo$dat[“ru_stime.tv_usec”]；    //使用的系统时间（微秒）
     *
     * @param int $who 如果 who 是 1，getrusage 会使用 RUSAGE_CHILDREN 来调用。
     * @return array
     */
    public static function getrusage( int $who = 0 ) : array
    {
        return getrusage($who);
    }

    /**
     * @return bool
     */
    public static function isWin(): bool
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return true;
        }
        return false;
    }



}












