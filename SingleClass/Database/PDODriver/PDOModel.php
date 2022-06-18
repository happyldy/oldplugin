<?php
/**
 * 纯粹为了好理解
 *
 */

namespace HappyLin\OldPlugin\SingleClass\Database\PDODriver;


use HappyLin\OldPlugin\SingleClass\Database\DatabaseManager;

use PDO,PDOException;


class PDOModel
{
    
    
    
    

    /**
     * PDOInstance constructor.
     *
     */
    public function __construct()
    {


    }


    /**
     * @see \HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOMySqlDriver;
     * 
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        return DatabaseManager::getInstance()->connection('pdo')->$method(...$arguments);
        //return call_user_func([DatabaseManager::getInstance()->connection(), $method], ...$arguments);
        //return call_user_func_array([DatabaseManager::getInstance()->connection(), $method], $arguments);
    }


    

}






