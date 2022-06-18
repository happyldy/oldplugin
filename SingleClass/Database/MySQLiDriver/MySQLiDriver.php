<?php
/**
 * 纯粹为了符合当前框架使用模式
 * 新建一个连接
 *
 */

namespace HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver;

use HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver\MySQLiInstance;



class MySQLiDriver
{


    private $connection;
    

    /**
     * PDOInstance constructor.
     *
     */
    public function __construct($config)
    {
        $this->connection = new MySQLiInstance($config['host'], $config['user'], $config['password'], $config['dbname'], $config['port']);
    }

    




    /**
     * 不在这里的就去调用MySQLiInstance方法
     *
     *
     * @see \HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver\MySQLiInstance;
     * @param  $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method,$parameters)
    {
        return $this->connection->$method(...$parameters);
    }




    

}






