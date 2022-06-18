<?php
/**
 * 
 * 关于配置的函数
 * 
 * PHP_INI_USER     可在用户脚本（例如 ini_set()）或 Windows 注册表（自 PHP 5.3 起）以及 .user.ini 中设定
 * PHP_INI_PERDIR   可在 php.ini，.htaccess 或 httpd.conf 中设定
 * PHP_INI_SYSTEM   可在 php.ini 或 httpd.conf 中设定
 * PHP_INI_ALL      可在任何地方设定
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */


namespace HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits;


trait Ini
{


    /**
     * 获取当前的 include_path 配置选项
     * @return string 返回字符串的路径。 -> ini_get('include_path');
     */
    public static function getIncludePath() : string
    {
        return get_include_path();
    }

    /**
     * 为当前脚本设置 include_path 运行时的配置选项。
     * @param string $new_include_path include_path 新的值。->  ini_set('include_path', '/usr/lib/pear');
     * @return string 成功时返回旧的 include_path 或者在失败时返回 FALSE。
     */
    public static function setIncludePath( string $new_include_path)
    {
        return set_include_path($new_include_path);
    }

    /**
     * 还原到 php.ini 中设置的 include_path 主值。
     */
    public static function restoreIncludePath() : void
    {
        restore_include_path();
    }
    
    
    /**
     * 获取 PHP 配置选项的值 ；同ini_get但它是配置文件的值
     * 此函数不会返回 PHP 编译的配置信息，或从 Apache 配置文件读取。
     * 检查系统是否使用了一个配置文件，并尝试获取 cfg_file_path 的配置设置的值。如果有效，将会使用一个配置文件。
     *
     * @param string $varname 配置选项的名称。
     * @retrun string 返回 option 指定的当前 PHP 配置变量的值，错误发生时返回 FALSE。
     */
    public static function getCfgVar(string $varname)
    {
        return get_cfg_var($varname);
    }


    /**
     * 成功时返回配置选项的值。同get_cfg_var但它是当前值
     *
     * @param string $varname 配置选项的名称。
     */
    public static function intGet($varname)
    {
        return ini_get($varname);
    }


    /**
     * 获取所有配置选项
     *
     * 返回值
     * 返回一个关联数组，指令名称是数组的键。如果 extension 不存在，返回 FALSE 并产生 E_WARNING 级错误。
     * 当 details 为 TRUE（默认），数组会包含 global_value（php.ini 中的设置）、local_value（可能是 ini_set() 或 .htaccess 中的设置） 以及 access（访问级别）。
     * 当 details 为 FALSE，这个值会是选项的当前值。
     * 参见手册章节中访问级别含义的信息。
     *
     * Note:
     * 指令可以有多个访问级别，这也是为什么 access 会显示适当的位掩码。
     *
     * @param null $extension 可选的扩展名称。如果设置了，此函数仅仅返回指定该扩展的选项。
     * @param bool $details 获取详细设置或者仅仅是每个设置的当前值。 默认是 TRUE（获取详细信息）。
     * @return array
     */
    public static function iniGetAll($extension = null, bool $details = true)
    {
        return ini_get_all($extension, $details);
    }


    /**
     * 成功时返回配置选项的值。
     *
     * @param string $varname 配置选项名称。
     * @return string 成功是返回配置选项值的字符串，null 的值则返回空字符串。如果配置选项不存在，将会返回 FALSE。
     */
    public static function iniGet( string $varname)
    {
        return ini_get($varname);
    }

    /**
     * 恢复配置选项的值
     * @param string $varname
     */
    public static function iniRestore ( string $varname) : void
    {
        ini_restore($varname);
    }

    /**
     * 设置指定配置选项的值。这个选项会在脚本运行时保持新的值，并在脚本结束时恢复。
     * @param string $varname 不是所有有效的选项都能够用 ini_set() 来改变的。这里有个有效选项的清单附录。php手册›附录>php.ini 配置›php.ini 配置选项列表
     * @param string $newvalue 选项新的值。
     * @return string 成功时返回旧的值，失败时返回 FALSE。
     */
    public static function iniSet( string $varname, string $newvalue)
    {
        return ini_set($varname, $newvalue);
    }


    /**
     * 检查是否有加载的 php.ini 文件，并取回它的路径。
     * @return string 已加载的 php.ini 路径，或在没有时返回 FALSE。
     */
    public static function phpIniLoadedFile()
    {
        return php_ini_loaded_file();
    }

    /**
     * 返回解析的 php.ini 后逗号分隔的配置文件列表。这些文件从编译时 --with-config-file-scan-dir 选项里指定的目录里找到。
     * 这些返回的配置文件也包括了 --with-config-file-scan-dir 选项里声明的路径。
     *
     * @return string 成功时返回逗号分隔的 .ini 文件字符串。每个逗号后紧跟新的一行。如果未设置指令 --with-config-file-scan-dir 将会返回 FALSE。如果它设置了，并且目录是空的，将会返回一个空字符串。如果有未识别的文件，此文件也会进入返回的字符串，但是会导致一个 PHP 错误。此 PHP 错误即会在编译时出现也会在使用 php_ini_scanned_files() 函数时出现。
     */
    public static function phpIniScannedFiles()
    {
        return php_ini_scanned_files();
    }


}












