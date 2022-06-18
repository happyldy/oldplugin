<?php
/**
 * PDO类封装
 *
 */

namespace HappyLin\OldPlugin\SingleClass\Database\PDODriver;

use HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOStatementInstance;
use PDO,PDOStatement,PDOException;


class PDOInstance extends PDO
{

    private static $instance;


    /**
     * PDOInstance constructor.
     *
     * @param $dsn
     * @param null $username 用户名
     * @param null $password 密码
     * @param null $options 一个具体驱动的连接选项的键=>值数组。
     * @return Exception 如果试图连接到请求的数据库失败，则PDO::__construct() 抛出一个 PDO异常（PDOException） 。
     */
    public function __construct($dsn, $username = null, $password = null, $options = null)
    {
        parent::__construct($dsn, $username, $password, $options);
    }


    /**
     * 保留 改用DatabaseManager获取PDOMySqlDriver,PDOMySqlDriver里面包含PDOInstance所有方法
     * 通过懒加载获得实例（在第一次使用的时候创建）
     */
    public static function getInstance(string $driver='mysql'): PDOInstance
    {
        if($driver === 'mysql'){
            
            list($dsn, $username, $password, $options) = static::mysqlDriver();
            
        }else{
            throw new PDOException('I haven\'t defined the engine yet');
        }

        if (null === static::$instance) {
            static::$instance = new static($dsn, $username, $password, $options);
        }
        return static::$instance;
    }



    /**
     * PDOInstance constructor.
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
     * 
     * @return string 如果试图连接到请求的数据库失败，则PDO::__construct() 抛出一个 PDO异常（PDOException） 。
     */
    public static function mysqlDriver():array
    {
        // 暂时先这样吧，正常把这个搞成一个类；
        $dsnArr = array(
            'dbname' => 'test',
            'host' => '39.103.151.193',
        );
        $user = 'mysqlConn';
        $password = 'lin.test';
        $options = null;
        
        // 设计上面是传入或读取配置文件，下面处理返回；
        $dsn = 'mysql:';
        foreach ($dsnArr as $k=>$v){
            $dsn .= "{$k}={$v};";
        }
        return array(substr($dsn,0,-1), $user,$password, $options);
    }


    /**
     * 准备要执行的语句，并返回语句对象
     *
     * 用命名参数形式 WHERE calories < :calories
     * 用问号形式  calories < ?
     *
     *
     * $driver_options的设置
     *  选择游标类型PDO::ATTR_CURSOR； PDO 当前支持 PDO::CURSOR_FWDONLY 和 PDO::CURSOR_SCROLL。一般为 PDO::CURSOR_FWDONLY，除非确实需要一个可滚动游标。
     *      PDOStatementInstance::fetch()就必须设置为PDO::CURSOR_SCROLL
     *
     * 例如：
     *  $driver_options =  array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL);
     *
     * @param string $statement 必须是对目标数据库服务器有效的 SQL 语句模板。
     * @param array $driver_options 数组包含一个或多个 key=>value 键值对，为返回的 PDOStatement 对象设置属性。常见用法是：
     * @return PDOStatement 如果数据库服务器完成准备了语句， PDO::prepare() 返回 PDOStatement 对象。如果数据库服务器无法准备语句， PDO::prepare() 返回 FALSE 或抛出 PDOException (取决于 错误处理器)。
     */
    public function prepare($statement,  $driver_options = array()) :PDOStatementInstance
    {

        // return parent::prepare($statement, $driver_options); // : PDOStatement

        $PDOStatement = parent::prepare($statement, $driver_options);
        
        return new PDOStatementInstance($PDOStatement);
        
    }



    /**
     * PDO::query() 在单次函数调用内执行 SQL 语句，以 PDOStatement 对象形式返回结果集（如果有数据的话）。
     *
     * 如果传入函数的参数数量超过一个，多余的参数将相当于调用结果对象 PDOStatement::setFetchMode() 方法。
     *
     * FETCH_COLUMN:    指定获取方式，从结果集中的下一行返回所需要的那一列。
     * FETCH_CLASS:     指定获取方式，返回一个所请求类的新实例，映射列到类中对应的属性名。 如果所请求的类中不存在该属性，则调用 __set() 魔术方法
     * FETCH_INTO:      指定获取方式，更新一个请求类的现有实例，映射列到类中对应的属性名。
     *
     * @param string $statement  需要准备、执行的 SQL 语句。
     * @param int $mode   FETCH_系列常量；   $PDO::FETCH_COLUMN      $PDO::FETCH_CLASS      $PDO::FETCH_INTO
     * @param mixed $arg3                   int $colno              string $classname       object $object
     * @param array $ctorargs
     * @return PDOStatement PDO::query() 返回 PDOStatement 对象，或在失败时返回 FALSE。
     */
    public function query( $statement,  $mode = PDO::ATTR_DEFAULT_FETCH_MODE, $arg3 = null, array $ctorargs = array()) :PDOStatementInstance
    {
        // return parent::query( $statement,  $mode,  $arg3,  $ctorargs); // : PDOStatement


        if(!empty($arg3)){
            $PDOStatement = parent::query($statement, $mode, $arg3, $ctorargs);
        }else{
            $PDOStatement = parent::query($statement);
        }


        

        return new PDOStatementInstance($PDOStatement);
    }



    /**
     * 执行一条 SQL 语句，并返回受影响的行数
     * exec() 不会从一条 SELECT 语句中返回结果。对于在程序中只需要发出一次的 SELECT 语句，可以考虑使用 PDO::query()。对于需要发出多次的语句，可用 PDO::prepare() 来准备一个 PDOStatement 对象并用 PDOStatement::execute() 发出语句。
     *
     * PDO::errorInfo() can be used to test the SQLSTATE error code for '00000' (success) and '01000' (success with warning).
     *
     * @param string $statement 要被预处理和执行的 SQL 语句。
     * @return int 受修改或删除 SQL 语句影响的行数。Warning此函数可能返回布尔值 FALSE，但也可能返回等同于 FALSE 的非布尔值。可查看errorInfo
     */
    public function exec($statement)
    {
        return parent::exec($statement);
    }



    /**
     *  为 SQL 查询里的字符串添加引号
     *
     * 如果使用此函数构建 SQL 语句，强烈建议使用 PDO::prepare() 配合参数构建，而不是用 PDO::quote() 把用户输入的数据拼接进 SQL 语句。使用 prepare 语句处理参数，不仅仅可移植性更好，而且更方便、免疫 SQL 注入；相对于拼接 SQL 更快，客户端和服务器都能缓存编译后的 SQL 查询。
     *
     * PARAM_STR: 表示 SQL 中的 CHAR、VARCHAR 或其他字符串类型。
     *
     * @param string $string  要添加引号的字符串。
     * @param int $parameter_type 为驱动提示数据类型，以便选择引号风格。
     * @return string  返回加引号的字符串，理论上可以安全用于 SQL 语句。 如果驱动不支持这种方式，将返回 FALSE 。
     */
    public function quote( $string, $parameter_type = PDO::PARAM_STR )
    {
        return parent::quote($string, $parameter_type);
    }


    /**
     * 启动一个事务
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public function beginTransaction():bool
    {
        return parent::beginTransaction();

    }


    /**
     * 检查驱动内的一个事务当前是否处于激活。此方法仅对支持事务的数据库驱动起作用。
     * @return bool
     */
    public function inTransaction() : bool
    {
        return parent::inTransaction();
    }



    /**
     * 提交一个事务
     * @return bool
     */
    public function commit() : bool
    {
        return parent::commit();
    }


    /**
     *  回滚一个事务
     * 包括 MySQL 在内的一些数据库， 当在一个事务内有类似删除或创建数据表等 DLL 语句时，会自动导致一个隐式地提交。隐式地提交将无法回滚此事务范围内的任何更改。
     * MySQL中的DDL代表着数据库定义语句，用来创建数据库中的表、索引、视图、存储过程、触发器等。常用的语句关键字有：CREATE,ALTER,DROP,TRUNCATE,COMMENT,RENAME。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public function rollBack() : bool
    {
        return parent::rollBack();
    }



    /**
     * 返回最后插入行的ID，或者是一个序列对象最后的值，取决于底层的驱动。比如，PDO_PGSQL() 要求为 name 参数指定序列对象的名称。
     * 在不同的 PDO 驱动之间，此方法可能不会返回一个有意义或一致的结果，因为底层数据库可能不支持自增字段或序列的概念。
     *
     * 返回值：
     * 如果没有为参数 name 指定序列名称，PDO::lastInsertId() 则返回一个表示最后插入数据库那一行的行ID的字符串。
     * 如果为参数 name 指定了序列名称，PDO::lastInsertId() 则返回一个表示从指定序列对象取回最后的值的字符串。
     * 如果当前 PDO 驱动不支持此功能，则 PDO::lastInsertId() 触发一个 IM001 SQLSTATE 。
     *
     * @param string|null $name 应该返回ID的那个序列对象的名称。
     * @return string
     */
    public function lastInsertId($name = NULL) : string
    {
        return parent::lastInsertId();
    }


    /**
     * 返回一个可用驱动的数组
     * @return array 返回一个 包含可用 PDO 驱动名字的数组。如果没有可用的驱动，则返回一个空数组。
     */
    public static function getAvailableDrivers(): array
    {
        return parent::getAvailableDrivers();
    }


    /**
     * 获取跟数据库句柄上一次操作相关的 SQLSTATE
     * 仅检索直接在数据库句柄上执行的操作的错误代码。
     * 如果您通过 PDO::prepare() 或 PDO::query() 创建 PDOStatement 对象并在语句句柄上调用错误，PDO::errorCode() 将不会反映该错误。您必须调用 PDOStatement::errorCode() 以返回 在特定语句句柄上执行的操作的错误代码。
     *
     * @return mixed|void 如果数据库句柄没有进行操作，则返回 NULL。 否则返回一个 SQLSTATE，一个由5个字母或数字组成的在 ANSI SQL 标准中定义的标识符。 简要地说，一个 SQLSTATE 由前面两个字符的类值和后面三个字符的子类值组成。
     */
    public function errorCode()
    {
        return parent::errorCode();
    }


    /**
     * 获取与数据库句柄上一次操作相关的扩展错误信息
     *
     * 返回数组至少包含以下字段：
     * 0 SQLSTATE 错误代码（ANSI SQL 标准中定义的五个字符的字母数字标识符）。
     * 1 驱动程序特定的错误代码。
     * 2 驱动程序特定的错误消息
     * @return array 返回有关此数据库句柄执行的最后一个操作的错误信息数组。
     */
    public function errorInfo() : array
    {
        return parent::errorInfo();
    }



    /**
     * 取回一个数据库连接的属性 手册›PDO›预定义常量
     *
     *
     * PDO::ATTR_DRIVER_NAME           返回驱动名称。'mysql'
     * PDO::ATTR_SERVER_VERSION(integer)    此为只读属性；返回 PDO 所连接的数据库服务的版本信息。
     * PDO::ATTR_CLIENT_VERSION(integer)    此为只读属性；返回 PDO 驱动所用客户端库的版本信息。
     * PDO::ATTR_SERVER_INFO(integer)       此为只读属性。返回一些关于 PDO 所连接的数据库服务的元信息。
     * PDO::ATTR_CONNECTION_STATUS(integer)     连接状态 例如：39.103.151.193 via TCP/IP
     *
     * 可设置属性见setAttribute
     *
     *
     * @param int $attribute PDO::ATTR_* 常量中的一个。
     * @return mixed 成功调用则返回请求的 PDO 属性值。不成功则返回 null。
     */
    public function getAttribute($attribute)
    {
        return parent::getAttribute($attribute);
    }


    /**
     * 设置数据库句柄属性。
     *
     * # PDO::ATTR_AUTOCOMMIT （在OCI，Firebird 以及 MySQL中可用）：如果此值为 FALSE ，PDO 将试图禁用自动提交以便数据库连接开始一个事务。
     *
     * # PDO::ATTR_PREFETCH 设置预取大小来为你的应用平衡速度和内存使用。并非所有的数据库/驱动组合都支持设置预取大小。较大的预取大小导致性能提高的同时也会占用更多的内存
     *
     * # PDO::ATTR_TIMEOUT：指定超时的秒数。并非所有驱动都支持此选项，这意味着驱动和驱动之间可能会有差异。比如，SQLite等待的时间达到此值后就放弃获取可写锁，但其他驱动可能会将此值解释为一个连接或读取超时的间隔。需要 int 类型。
     *
     * PDO::ATTR_ERRMODE：错误报告。
     *      PDO::ERRMODE_SILENT：仅设置错误代码。 此为默认模式。
     *      PDO::ERRMODE_WARNING: 引发 E_WARNING 错误； 除设置错误码之外，PDO 还将发出一条传统的 E_WARNING 信息。如果只是想看看发生了什么问题且不中断应用程序的流程，那么此设置在调试/测试期间非常有用。
     *      PDO::ERRMODE_EXCEPTION: 抛出 exceptions 异常。此设置在调试期间也非常有用（记住：如果异常导致脚本终止，则事务被自动回滚）。
     *
     *
     * # PDO::ATTR_CASE：强制列名为指定的大小写。
     *      PDO::CASE_LOWER：强制列名小写。
     *      PDO::CASE_NATURAL：保留数据库驱动返回的列名。
     *      PDO::CASE_UPPER：强制列名大写。
     *
     * # PDO::ATTR_CURSOR_NAME 获取或设置使用游标的名称。当使用可滚动游标和定位更新时候非常有用。
     *
     * PDO::ATTR_CURSOR 选择游标类型。 PDO 当前支持 PDO::CURSOR_FWDONLY 和 PDO::CURSOR_SCROLL。一般为 PDO::CURSOR_FWDONLY，除非确实需要一个可滚动游标。
     *      PDO::CURSOR_FWDONLY 一般为这个
     *      PDO::CURSOR_SCROLL  PDOStatement::fetch()就必须设置为PDO::CURSOR_SCROLL
     *
     *
     * # PDO::ATTR_ORACLE_NULLS （在所有驱动中都可用，不仅限于Oracle）：转换 NULL 和空字符串。
     *      PDO::NULL_NATURAL: 不转换。
     *      PDO::NULL_EMPTY_STRING：将空字符串转换成 NULL。
     *      PDO::NULL_TO_STRING: 将 NULL 转换成空字符串。
     *
     * # PDO::ATTR_PERSISTENT 请求一个持久连接，而非创建一个新连接。 如果是在对象初始化之后用 PDO::setAttribute() 设置此属性，则驱动程序将不会使用持久连接。
     *      必须在new PDO('mysql:host=localhost;dbname=test', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
     *      如果使用 PDO ODBC 驱动且 ODBC 库支持 ODBC 连接池（有unixODBC 和 Windows 两种做法；可能会有更多），建议不要使用持久的 PDO 连接，而是把连接缓存留给 ODBC 连接池层处理。
     *
     *
     * # PDO::ATTR_STRINGIFY_FETCHES: 提取的时候将数值转换为字符串。 Requires bool.
     *
     * # PDO::ATTR_MAX_COLUMN_LEN 设置字段名最长的尺寸。
     *
     * # PDO::ATTR_DEFAULT_FETCH_MODE：设置默认的提取模式。关于模式的说明可以在 PDOStatement::fetch() 文档找到。
     *
     * # PDO::ATTR_EMULATE_PREPARES 启用或禁用预处理语句的模拟。 有些驱动不支持或有限度地支持本地预处理。使用此设置强制PDO总是模拟预处理语句（如果为 TRUE ），或试着使用本地预处理语句（如果为 FALSE）。如果驱动不能成功预处理当前查询，它将总是回到模拟预处理语句上。需要 bool 类型。
     *
     * # PDO::ATTR_DEFAULT_STR_PARAM  设置默认 string 参数类型; 自 PHP 7.2.0 起可用
     *      PDO::PARAM_STR_NATL 标记了字符使用的是国家字符集（national character set）。
     *      PDO::PARAM_STR_CHAR 标记了字符使用的是常规字符集（regular character set）。
     *
     * # PDO::ATTR_STATEMENT_CLASS：设置返回的 statement 类名。设置从PDOStatement派生的用户提供的语句类。不能用于持久的PDO实例。需要 array(string 类名, array(mixed 构造函数的参数))。
     *
     * # PDO::MYSQL_ATTR_USE_BUFFERED_QUERY （在MySQL中可用）：使用缓冲查询。
     *
     * # PDO::ATTR_FETCH_CATALOG_NAMES 将包含的目录名添加到结果集中的每个列名前面。目录名和列名由一个小数点分开（.）。此属性在驱动层面支持，所以有些驱动可能不支持此属性。
     * # PDO::ATTR_FETCH_TABLE_NAMES 将包含的表名添加到结果集中的每个列名前面。表名和列名由一个小数点分开（.）。此属性在驱动层面支持，所以有些驱动可能不支持此属性。
     *
     *
     * @param int $attribute
     * @param mixed $value
     * @return bool
     */
    public function setAttribute( $attribute,  $value) : bool
    {
        return parent::setAttribute( $attribute,  $value);
    }






    

}






