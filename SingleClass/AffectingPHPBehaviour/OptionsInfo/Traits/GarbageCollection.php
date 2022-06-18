<?php
/**
 * 
 * 
 */


namespace HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits;


trait GarbageCollection
{


    
    
    /**
     * 强制收集所有现存的垃圾循环周期
     * @return int 返回收集的循环数量。
     */
    public static function gcCollectCycles(): int
    {
        return gc_collect_cycles();
    }


    /**
     *  返回循环引用计数器的状态
     * @return bool 如果垃圾收集器已启用则返回 TRUE，否则返回 FALSE。
     */
    public static function gcEnabled(): bool
    {
        return gc_enabled();
    }

    /**
     * 停用循环引用收集器
     * 停用循环引用收集器，设置 zend.enable_gc 为 0。
     */
    public static function gcDisable(): void
    {
        gc_disable();
    }

    /**
     * 激活循环引用收集器
     * 设置 zend.enable_gc 为 1，激活循环引用收集器。
     */
    public static function gcEnable(): void
    {
        gc_enable();
    }


    /**
     * 回收Zend引擎内存管理器使用的内存
     * @return int 返回释放的字节数。
     */
    public static function gcMemCaches(): int
    {
        return gc_mem_caches();
    }


    /**
     * 获取有关垃圾收集器的信息
     * @return array  返回包含以下元素的关联数组 ["runs" int,  "collected" int,  "threshold" int ,  "roots" int]

     */
    public static function gcStatus()
    {
        if(version_compare(PHP_VERSION,'7.3.0','<')){
            return false;
        }
        return gc_status();
    }


}












