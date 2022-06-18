<?php
/**
 * 不知道分类的全在这里
 * 
 */


namespace HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits;


trait Extension
{


    /**
     * 检查一个扩展是否已经加载
     * @param string $name 扩展名称，大小写不敏感。
     * @retrun string
     */
    public static function extensionLoaded(string $name): bool
    {
        return extension_loaded($name);
    }

    /**
     * 该函数根据 module_name 返回模块内定义的所有函数的名称。
     * 例如：getExtensionFuncs("xml"));
     * @param string $module_name 模块名称。这个参数必须是小写（lowercase）的。
     * @return array 返回包含所有函数名的数组，如果 module_name 不是一个有效的扩展则返回 FALSE。
     */
    public static function getExtensionFuncs( string $module_name)
    {
        return get_extension_funcs($module_name);
    }

    /**
     * 该函数返回了 PHP 解析器里所有编译并加载的模块名。
     * @param bool $zend_extensions 只返回 Zend 扩展，并非类似 mysqli 的普通扩展。默认是 FALSE (返回普通扩展)。
     * @return array 返回所有模块名的一个索引数组(array)。
     */
    public static function getLoadedExtensions(bool $zend_extensions = FALSE) : array
    {
        return get_loaded_extensions($zend_extensions);
    }
    



}












