<?php

namespace HappyLin\OldPlugin\SingleClass\Database;


use HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOMySqlDriver;
use HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver\MySQLiDriver;

use PDO;


final class DatabaseManager
{

    private static $instance;

    /**
     * 数据库连接实例
     *
     * @var array
     */
    protected $connections = [];



    private function __construct( )
    {

    }


    /**
     * 防止实例被克隆（这会创建实例的副本）
     */
    private function __clone()
    {
    }

    /**
     * 防止反序列化（这将创建它的副本）
     */
    private function __wakeup()
    {
    }


    /**
     * 通过懒加载获得实例（在第一次使用的时候创建）
     */
    public static function getInstance(): DatabaseManager
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    
    
    
    

    /**
     * 获取数据库连接实例.
     * @param string $driver 使用的驱动器
     * @param int $code 数据库编号，同类型多个实例
     * @param string $name 目前就它
     * @return MySQLiDriver|PDOMySqlDriver|mixed
     */
    public function connection($driver = 'pdo', int $code = 0, $name = 'mysql')
    {
        if($driver === 'pdo'){
            return $this->makePDOConnection($name, $code);
        }elseif($driver === 'mysqli'){
            return $this->makeMySQLiConnection($name, $code);
            //return $this->connections[$driver . $name . $code] = new PDOMySqlDriver($config);
        }else{
            throw new  \InvalidArgumentException('I haven\'t defined the engine yet');
        }
    }




    /**
     * 创建PDO连接实例
     *
     * @param  string  $name
     * @return PDOMySqlDriver
     */
    public function makePDOConnection($name='mysql', int $code = 0)
    {
        if(!empty($this->connections['pdo' . $name . $code ])){
            return $this->connections['pdo' . $name . $code];
        }

        $config = $this->configuration($name);
        return $this->connections['pdo' . $name . $code] = new PDOMySqlDriver($config);
    }

    /**
     * 创建MySQL连接实例
     *
     * @param  string  $name
     * @return MySQLiDriver
     */
    public  function makeMySQLiConnection($name='mysql', int $code = 0)
    {
        if(!empty($this->connections['mysqli' . $name . $code ])){
            return $this->connections['mysqli' . $name . $code];
        }
        $config = $this->configuration($name);
        return $this->connections['mysqli' . $name . $code] = new MySQLiDriver($config);
    }
    

    /**
     * 获取配置参数
     *
     * @param string $name mysql | redis
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function configuration($name)
    {

        if($name !== 'mysql'){
            throw new  \InvalidArgumentException('I haven\'t defined the driver yet');
        }

        $config = array(
            'user' => 'mysqlConn',
            'password' => 'lin.test',
            'dbname' => 'test',
            'host' => '39.103.151.193',
            'port' => '3306',
            'options' => array(
//                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            )
        );

        return $config;
    }


    /**
     * 
     */
    public function getconnect($driver=null):array
    {
        if($driver){
            $targetCon = [];
            foreach ($this->connections as $k=>$v){
                if(strripos( $k, $driver) === 0)
                    $targetCon[$k] = $v;
            }
            return $targetCon;
        }
        
        return $this->connections;
    }
    
    
    public function disconnect($name = null)
    {

    }


    public function reconnect($name = null)
    {

    }


}
