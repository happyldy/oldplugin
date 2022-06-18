<?php
/**
 * 获取脚本运行中变量的函数
 *
 */


namespace HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits;


trait ScriptVariable
{

    /**
     * 返回当前所有已定义的常量名和值。这包含 define() 函数所创建的，也包含了所有扩展所创建的。
     * @param bool $categorize  让此函数返回一个多维数组，分类为第一维的键名，常量和它们的值位于第二维。
     * @return array
     */
    public static function getDefinedConstants(bool $categorize = FALSE) : array
    {
        return get_defined_constants($categorize);
    }


    /**
     * 脚本最初被称为"被包含的文件"，所以脚本自身也会和 include 系列函数引用的脚本列在一起。
     * 被多次 include 和 require 的文件在返回的 array 里只会列出一次。
     * @return array 返回所有被 include、 include_once、 require 和 require_once 的文件名。
     */
    public static function getIncludedFiles() : array
    {
        return get_included_files();
    }


    /**
     * 返回所有已定义函数的数组
     * function_exists
     * @param bool $exclude_disabled 禁用的函数是否应该在返回的数据里排除。
     * @return array 返回数组，包含了所有已定义的函数，包括内置(internal) 和用户定义的函数。 可通过$arr["internal"]来访问系统内置函数， 通过$arr["user"]来访问用户自定义函数 (参见示例)。
     */
    public static function getDefinedFunctions(bool $exclude_disabled = FALSE) : array
    {
        return get_defined_functions($exclude_disabled);
    }


    /**
     * 返回由当前脚本中已定义类的名字组成的数组。
     *
     * @return array
     */
    public static function getDeclaredClasses() : array
    {
        return get_declared_classes();
    }

    /**
     *  返回一个数组包含所有已声明的接口
     *
     * @return array 本函数返回一个数组，其内容是当前脚本中所有已声明的接口的名字。
     */
    public static function getDeclaredInterfaces() : array
    {
        return get_declared_interfaces();
    }

    /**
     * 返回所有已定义的 traits 的数组
     *
     * @return array 返回一个数组，其值包含了所有已定义的 traits 的名称。在失败的情况下返回 NULL。
     */
    public static function getDeclaredTraits()
    {
        return get_declared_traits();
    }



    /**
     * 返回所有当前活动资源的数组，可选择按资源类型过滤。
     * $type
     * 如果定义，这将导致 get_resources() 只返回给定类型的资源。 提供了资源类型列表。
     * 如果提供字符串 Unknown 作为类型，则只会返回未知类型的资源。
     * 如果省略，将返回所有资源。
     * @param string $type  如果定义，这将导致 get_resources() 只返回给定类型的资源。 资源类型列表›附录›资源类型列表;
     * @return array 返回当前活动资源的数组，按资源编号索引。
     */
    public static function getResources($type=null)
    {
        return get_resources($type);
    }




    /**
     * 获取一个环境变量的值
     * 和$_SERVER
     *
     * @param string $varname 变量名
     * @param bool $local_only 设置为 true 以仅返回本地环境变量（由操作系统或 putenv() 设置）。
     * @return string 返回环境变量 varname 的值，如果环境变量 varname 不存在则返回 FALSE。如果省略 varname，则所有环境变量都将作为关联数组 array 返回。
     */
    public static function getenv( string $varname = null, bool $local_only = FALSE)
    {
        return getenv($varname,$local_only);
    }






    /**
     * 设置允许脚本运行的时间，单位为秒。如果超过了此设置，脚本返回一个致命的错误。默认值为30秒，或者是在php.ini的max_execution_time被定义的值，如果此值存在
     * @param int $seconds 最大的执行时间，单位为秒。如果设置为0（零），没有时间方面的限制。
     * @return bool 成功时返回 TRUE，失败时返回 FALSE 。
     */
    public static function setTimeLimit( int $seconds) : bool
    {
        return set_time_limit($seconds);
    }


    /**
     * 返回 PHP 储存临时文件的默认目录的路径。
     * @return string 返回临时目录的路径。
     */
    public static function sysGetTempDir() : string
    {
        return sys_get_temp_dir();
    }







}












