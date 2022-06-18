<?php
/**
 * 这是为了模拟其他框架; 它包含了PDOInstance类和PDOStatementInstance类；
 *
 *
 *
 * PDO_MySql 的预定义常量
 *
 * PDO::MYSQL_ATTR_USE_BUFFERED_QUERY 如果在PDO语句中将此属性设置为TRUE，则MySQL驱动程序将使用MySQL API的缓冲版本。如果您正在编写可移植代码，那么应该改用PDOStatement:：fetchAll（）。;require bool
 * PDO::MYSQL_ATTR_LOCAL_INFILE 启用“加载本地填充”。注意，在构造新的数据库句柄时，此常量只能在driver_options数组中使用。
 * PDO::MYSQL_ATTR_LOCAL_INFILE_DIRECTORY 允许将本地数据加载限制到位于此指定目录中的文件。请注意，此常量只能在构造新数据库句柄时在 driver_options 数组中使用。
 * PDO::MYSQL_ATTR_INIT_COMMAND  连接到 MySQL 服务器时执行的命令。 重新连接时会自动重新执行。请注意，此常量只能在构造新数据库句柄时在 driver_options 数组中使用
 * PDO::MYSQL_ATTR_READ_DEFAULT_FILE  从命名选项文件而不是从 my.cnf 读取选项。 如果使用 mysqlnd，则此选项不可用，因为 mysqlnd 不读取 mysqlconfiguration 文件。
 * PDO::MYSQL_ATTR_READ_DEFAULT_GROUP  从 my.cnf 或用 MYSQL_READ_DEFAULT_FILE 指定的文件中的命名组读取选项。 如果使用 mysqlnd，则此选项不可用，因为 mysqlnd 不读取 mysqlconfiguration 文件。
 * PDO::MYSQL_ATTR_MAX_BUFFER_SIZE 最大缓冲区大小。 默认为 1 MiB。 针对 mysqlnd 编译时不支持此常量
 * PDO::MYSQL_ATTR_DIRECT_QUERY  执行直接查询，不要使用准备好的语句。
 * PDO::MYSQL_ATTR_FOUND_ROWS  返回找到（匹配）的行数，而不是更改的行数。
 * PDO::MYSQL_ATTR_IGNORE_SPACE 允许在函数名称后使用空格。 使所有函数名保留字
 * PDO::MYSQL_ATTR_COMPRESS 启用网络通信压缩。 从 PHP 5.3.11 开始，在针对 mysqlnd 编译时也支持这一点。
 * PDO::MYSQL_ATTR_SSL_CA SSL 证书颁发机构的文件路径
 * PDO::MYSQL_ATTR_SSL_CAPATH 包含受信任 SSLCA 证书的目录的文件路径，这些证书以 PEM 格式存储。
 * PDO::MYSQL_ATTR_SSL_CERT  SSL 证书的文件路径。
 * PDO::MYSQL_ATTR_SSL_CIPHER 用于 SSL 加密的一个或多个允许密码的列表，采用 OpenSSL 理解的格式。 例如：DHE-RSA-AES256-SHA:AES128-SHA
 * PDO::MYSQL_ATTR_SSL_KEY  SSL 密钥的文件路径。
 * PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT  提供一种禁用服务器 SSL 证书验证的方法。自以下版本起 PHP 7.0.18 and PHP 7.1.4.
 * PDO::MYSQL_ATTR_MULTI_STATEMENTS  当设置为 FALSE 时，在 PDO::prepare() 和 PDO::query() 中禁用多查询执行。请注意，此常量只能在构造新数据库句柄时在 driver_options 数组中使用。 
 *
 * 例子：
 * $stmt = $db->prepare('select * from foo',array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
 */

namespace HappyLin\OldPlugin\SingleClass\Database\PDODriver;

use HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOInstance;

use PDO,PDOStatement,PDOException;

/**
 * Class PDOMySqlDriver
 * 该类方法不能与PDOInstance方法同名；这里面的方法只是为了模拟其他框架的select from where ;其他就不做了，又不是真写框架
 * @package HappyLin\OldPlugin\SingleClass\Database\PDODriver
 */
class PDOMySqlDriver
{

    /**
     * @var \HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOInstance
     */
    private $connection;


    public $select;
    public $table;
    public $where = [];
    
    /**
     *
     * PDO_MYSQL数据源名称（DSN）由以下元素组成
     *  DSN prefix
     *      The DSN prefix is mysql:.
     *  host
     *      The hostname on which the database server resides.
     *  port
     *      The port number where the database server is listening.
     *  dbname
     *      The name of the database.
     *  unix_socket
     *      The MySQL Unix socket (shouldn't be used with hostor port).
     *  charset
     *      The character set. See the character setconcepts documentation for more information.
     *
     * 'mysql:host=localhost;dbname=test'
     *
     * @param array $config mysql的配置信息
     * @return string 如果试图连接到请求的数据库失败，则PDO::__construct() 抛出一个 PDO异常（PDOException） 。
     */
    public function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";
        $this->connection = new PDOInstance($dsn, $config['user'],$config['password'], $config['options']);
    }


    public function getConnection()
    {
        return $this->connection;
    }



    public function select( $select)
    {
        $this->select = $select;
        return $this;
    }


    public function from($table)
    {
        $this->table = $table;
        return $this;
    }


    /**
     * $code
     *
     * PDO::PARAM_BOOL(integer) 表示布尔数据类型。  
     * PDO::PARAM_NULL(integer) 表示 SQL 中的 NULL 数据类型。  
     * PDO::PARAM_INT(integer) 表示 SQL 中的整型。  
     * PDO::PARAM_STR(integer) 表示 SQL 中的 CHAR、VARCHAR 或其他字符串类型。
     *
     * @param string|array $field  字段
     * @param string $operator  运算符
     * @param mixed $value  值
     * @param int $code PDO::常量 PDO::PARAM_INT | PDO::PARAM_STR
     */
    public function where($field, $operator = '', $value='', int $code)
    {
        if(is_array($field)){
            foreach ($field as $f){
                if(is_array($f)){
                    array_push($this->where, $field);
                }else{
                    array_push($this->where, [$field, $operator, $value, $code]);

                }
            }

        }else{
            array_push($this->where, [$field, $operator, $value, $code]);
        }
        return $this;
    }

    
    public function find($limit=100)
    {
        $prepare = "select {$this->select} from {$this->table} where ";

        foreach($this->where as $w){
            $prepare .=  " {$w[0]} {$w[1]} :{$w[0]} and ";
        }

        $prepare = substr($prepare, 0, -4);


        $prepare .= " limit {$limit}";


        $statement = $this->connection->prepare($prepare);

        foreach ($this->where as $w){
            $statement->bindValue($w[0], $w[2], $w[3]);
        }

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,'HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOModel');

    }


    
    /**
     * 不在这里的就去调用PDOInstance方法
     *
     * 
     * @see \HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOInstance
     * @param  $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method,$parameters)
    {
        return $this->connection->$method(...$parameters);
    }


}






