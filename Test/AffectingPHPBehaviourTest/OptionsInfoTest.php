<?php
/**
 * 大杂烩
 *
 * 这些函数允许你获得许多关于PHP本身的参数，例如：运行时的配置，被加载的扩展，版本等
 *
 */



namespace HappyLin\OldPlugin\Test\AffectingPHPBehaviourTest;

use HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\OptionsInfo;



use HappyLin\OldPlugin\Test\TraitTest;


class OptionsInfoTest
{

    use TraitTest;


    public function __construct()
    {

    }

    /**
     * @note php init配置信息
     */
    public function iniTest()
    {
        var_dump(static::toStr('获取 PHP 配置选项的值',[
            'get_cfg_var($varname)' => '此函数不会返回 PHP 编译的配置信息，或从 Apache 配置文件读取'  ,
            'set_include_path($new_include_path)' => 'PHP 编译的配置信息当前值'  ,
            'ini_get_all()' => '获取所有配置选项; 数组会包含 global_value（php.ini 中的设置）、local_value（可能是 ini_set() 或 .htaccess 中的设置） 以及 access（访问级别）' ,
            'ini_get()' => '获取指定选项的值; ini_get(\'post_max_size\'):' . ini_get('post_max_size'),
        ]));

        var_dump(static::toStr('include_path 配置选项; ',[
            'get_include_path()' => '获取当前的 include_path 配置选项'  . OptionsInfo::getIncludePath(),
            'set_include_path($new_include_path)' => '为当前脚本设置 include_path 运行时的配置选项'  ,
            'restoreIncludePath()' => '还原到 php.ini 中设置的 include_path 主值'  ,
        ]));

        var_dump(static::toStr('设置配置指定选项的值。这个选项会在脚本运行时保持新的值，并在脚本结束时恢复。; ini_set($varname, $newvalue)'));
        var_dump(static::toStr('恢复配置选项的值; ini_restore($varname)'));
        var_dump(static::toStr('检查是否有加载的 php.ini 文件，并取回它的路径。; php_ini_loaded_file()'));
        var_dump(static::toStr('解析的 php.ini 后逗号分隔的配置文件列表。这些文件从编译时 --with-config-file-scan-dir 选项里指定的目录里找到。; php_ini_scanned_files()'));
        var_dump(static::toStr('parse_ini_file =>  载入一个 ini 文件，并将其中的设置作为一个联合数组返回'));
        var_dump(static::toStr('parse_ini_string =>  解析 ini 字符串，并将其中的设置作为一个联合数组返回'));

    }

    /**
     * @note 获取脚本已定义的变量和文件
     */
    public function scriptVariableTest()
    {
        var_dump(static::toStr('设置允许脚本运行的时间，单位为秒。如果超过了此设置，脚本返回一个致命的错误。默认值为30秒，或者是在php.ini的max_execution_time被定义的值; set_time_limit($seconds)', OptionsInfo::setTimeLimit(30)));

        var_dump(static::toStr('获取当前所有已定义的: ',[
            'get_defined_constants($categorize)' => '常量名和值。这包含 define() 函数所创建的，也包含了所有扩展所创建的',
            'get_included_files()' => '被 include、 include_once、 require 和 require_once 的文件名',
            'get_resources($type)' => '活动资源',
            'get_defined_functions($exclude_disabled)' => '函数',
            'get_declared_classes()' => '类的名字',
            'get_declared_interfaces()' => '接口',
            'get_declared_traits()' => 'traits',
        ]));
        var_dump(static::toStr('获取一个环境变量的值; getenv($varname,$local_only)'));
        var_dump(static::toStr('获取 PHP 储存临时文件的默认目录的路径; sys_get_temp_dir()', OptionsInfo::sysGetTempDir()));

    }


    /**
     * @note 获取系统相关变量
     */
    public function systemTest()
    {

        var_dump(static::toStr('获取 PHP 脚本的内存峰值字节数; memory_get_peak_usage(false)', OptionsInfo::memoryGetPeakUsage()));
        var_dump(static::toStr('获取 PHP 脚本的内存值字节数; memory_get_usage(false)', OptionsInfo::memoryGetUsage()));

        var_dump(static::toStr('获取 PHP 或扩展版本; phpversion()', OptionsInfo::phpversion()));
        var_dump(static::toStr('对比两个「PHP 规范化」的版本数字字符串; version_compare($version1, $version2, $operator)'));

        var_dump(static::toStr('获取运行 PHP 的操作系统的描述。这和 phpinfo() 最顶端上输出的是同一个字符串； php_uname($mode)', OptionsInfo::phpUname()));
        var_dump(static::toStr('获取描述 PHP 所使用的接口类型（the Server API, SAPI）的小写字符串； php_sapi_name()', OptionsInfo::phpSapiName()));

        var_dump(static::toStr('获取当前 PHP 进程的 ID； getmypid()', OptionsInfo::getmypid()));

        var_dump(static::toStr('获取当前线程的唯一识别符；（该函数仅在以下情况有效：PHP 内置 ZTS（Zend 线程安全）的支持，并开启调试模式（--enable-debug）时。） zend_thread_id()')); //, OptionsInfo::zend_thread_id()

        var_dump(static::toStr('获取当前 PHP 脚本所有者名称； get_current_user()', OptionsInfo::getCurrentUser()));

        var_dump(static::toStr('获取当前运行的 Zend 引擎的版本字符串； zend_version()', OptionsInfo::zendVersion()));

        var_dump(static::toStr('获取当前资源使用状况； getrusage($who)', OptionsInfo::getrusage()));

    }


    /**
     * @note 垃圾回收机制函数
     */
    public function garbageCollectionTest()
    {
        var_dump(static::toStr('强制收集所有现存的垃圾循环周期; gc_collect_cycles()',OptionsInfo::gcCollectCycles()));

        var_dump(static::toStr('循环引用计数器的状态; gc_enabled()',OptionsInfo::gcEnabled()));
        var_dump(static::toStr('循环引用收集器停用; gc_disable()',OptionsInfo::gcDisable()));
        var_dump(static::toStr('循环引用收集器激活; gc_enable()',OptionsInfo::gcEnable()));
        var_dump(static::toStr('回收Zend引擎内存管理器使用的内存; gc_mem_caches()',OptionsInfo::gcMemCaches()));
        var_dump(static::toStr('获取有关垃圾收集器的信息; gc_status()',OptionsInfo::gcStatus()));

        var_dump(static::toStr('如果你已经安装了» Xdebug，你能通过调用函数 xdebug_debug_zval()显示"refcount"和"is_ref"的值'));

//        $a = "new string";
//        $c = $b = $a;
//        xdebug_debug_zval( 'a' ); //        a: (refcount=3, is_ref=0)='new string'； php7都是0
//        unset( $b, $c );
//        xdebug_debug_zval( 'a' ); //        a: (refcount=1, is_ref=0)='new string'； php7都是0

    }


    /**
     * @note php已扩展的插件
     */
    public function extensionTest()
    {

        var_dump(static::toStr('检查一个扩展是否已经加载; extension_loaded("curl")',OptionsInfo::extensionLoaded('curl')));
        var_dump(static::toStr('根据 module_name 返回模块内定义的所有函数的名称; extension_loaded("xml")',OptionsInfo::extensionLoaded('xml')));
        var_dump(static::toStr('获取 PHP 解析器里所有编译并加载的模块名; get_loaded_extensions(FALSE)',OptionsInfo::getLoadedExtensions(FALSE)));

    }

    /**
     * @note 自由测试函数（接受脚本参数、断言）
     */
    public function testTest(){

        $m = memory_get_peak_usage();

        //OptionsInfo::memoryTest();

        var_dump(static::toStr('解析传入脚本的选项; getopt($shortopts, $longopts)'));  //OptionsInfo::getoptTest();
        var_dump(static::toStr('检查指定的 assertion 并在结果为 FALSE 时采取适当的行动; assert($assertion, string $description = "")')); // OptionsInfo::assert(false, "")
        var_dump(static::toStr('自定义方法： 将中文转为Html实体; 通过json_encode函数将中文转为unicode;')); // OptionsInfo::shortcuta()


        echo "total memory comsuption: " . (memory_get_peak_usage() - $m) . " bytes\n";

    }


}


