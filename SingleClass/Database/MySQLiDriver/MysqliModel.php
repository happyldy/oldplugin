<?php
/**
 * 纯粹为了符合当前框架使用模式
 * 数据模型基类
 *
 */

namespace HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver;





use HappyLin\OldPlugin\SingleClass\Database\DatabaseManager;

class MysqliModel
{
    

    
    

    /**
     *  constructor.
     *
     */
    public function __construct()
    {


    }


    /**
     * 
     * 
     * @see \HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver\MySQLiDriver;
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        return DatabaseManager::getInstance()->connection('mysqli')->$method(...$arguments);
    }














    

}






