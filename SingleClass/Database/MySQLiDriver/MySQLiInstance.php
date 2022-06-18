<?php
/**
 * PHP和Mysql数据库之间的一个连接。
 *
 */

namespace HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver;

use HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver\{MysqliSTML,MysqliResult};


use mysqli, mysqli_stmt,mysqli_result, mysqli_warning, mysqli_driver;

use mysqli_sql_exception;

class MySQLiInstance extends mysqli
{

    private static $instance;

    public $MySQLiDriver;

    // 没发现获取sql的方法，只能这样做了
    public $prepareQuery;


    public function __construct($hostname = null, $username = null, $password = null, $database = null, $port = null, $socket = null)
    {

        parent::init();

//        if (!parent::options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
//            die('Setting MYSQLI_INIT_COMMAND failed');
//        }
//
//        if (!parent::options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
//            die('Setting MYSQLI_OPT_CONNECT_TIMEOUT failed');
//        }

        if (!parent::options(MYSQLI_OPT_LOCAL_INFILE, true)) {
            die('Setting MYSQLI_OPT_LOCAL_INFILE failed');
        }

        if (!parent::real_connect($hostname, $username, $password, $database, $port, $socket)) {
            throw new mysqli_sql_exception('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error() );
        }
        
        $this->MySQLiDriver = new mysqli_driver();
        $this->mysqliDriverReportMode(MYSQLI_REPORT_ALL & ~MYSQLI_REPORT_INDEX);
        
        $this->set_charset('utf8mb4');

    }


    /**
     * 获取重连配置
     */
    public function getMySQLiDriverInfo()
    {
        return [
            	'client_info'  => $this->MySQLiDriver->client_info,
                'client_version' => $this->MySQLiDriver->client_version,
                'driver_version' => $this->MySQLiDriver->driver_version,
                'embedded' => $this->MySQLiDriver->embedded,
                'reconnect' => $this->MySQLiDriver->reconnect,
                'report_mode' => $this->MySQLiDriver->report_mode
        ];
    }

    /**
     * 有助于在代码开发和测试期间改进查询的函数。根据标志，它报告来自 mysqli 函数调用或不使用索引（或使用错误索引）的查询的错误。
     *
     * $mode
     *  MYSQLI_REPORT_OFF    关闭报告（默认）
     *  MYSQLI_REPORT_ERROR  报告来自 mysqli 函数调用的错误
     *  MYSQLI_REPORT_STRICT 抛出 mysqli_sql_exception 错误而不是警告
     *  MYSQLI_REPORT_INDEX  如果查询中没有使用索引或错误索引，则报告
     *  MYSQLI_REPORT_ALL    设置所有选项（报告全部）
     *
     * @param int $mode
     * @return bool
     */
    public function mysqliDriverReportMode(int $mode): bool
    {
        return $this->MySQLiDriver->report_mode = $mode;
    }





    /**
     * 保留 改用DatabaseManager获取PDOMySqlDriver,PDOMySqlDriver里面包含PDOInstance所有方法
     * 通过懒加载获得实例（在第一次使用的时候创建）
     */
    public static function getInstance(string $driver='mysql'): MySQLiInstance
    {
        if($driver === 'mysql'){

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

        }else{
            throw new mysqli_sql_exception('I haven\'t defined the engine yet');
        }

        if (null === static::$instance) {
            static::$instance = new static($config['host'], $config['user'], $config['password'], $config['dbname'], $config['port']);
        }

        return static::$instance;
    }


    /**
     * 关闭先前打开的数据库连接
     * @return bool
     */
    public function close() : bool
    {
        return parent::close();
    }


    /**
     * 分配，或者初始化一个 MYSQL 对象，可以作为 mysqli_options() 和 mysqli_real_connect() 函数的传入参数使用。
     * 在调用 mysqli_real_connect() 函数之前调用其他的 mysqli 函数可能会调用失败。（mysqli_options() 函数除外）。
     * @return mysqli 返回一个对象。
     */
    public function init() : mysqli
    {
        return parent::init();
    }



    /**
     * 设置一个连接的扩展选项，这些选项可以改变这个连接的行为。
     * 如果要对多个选项进行设置，可以多次调用此函数来。
     * mysqli_options() 需要在 mysqli_init() 函数之后、 mysqli_real_connect() 函数之前被调用。
     *
     *
     * MYSQLI_OPT_CONNECT_TIMEOUT       连接超时设置，以秒为单位（在 Windows 平台上，PHP 5.3.1 之后才支持此选项）。options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)
     * MYSQLI_OPT_LOCAL_INFILE          启用或禁用 LOAD LOCAL INFILE 语句
     * MYSQLI_INIT_COMMAND              成功建立 MySQL 连接之后要执行的 SQL 语句  options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')
     * MYSQLI_READ_DEFAULT_FILE         从指定的文件中读取选项，而不是使用 my.cnf 中的选项
     * MYSQLI_READ_DEFAULT_GROUP        从 my.cnf 或者 MYSQL_READ_DEFAULT_FILE 指定的文件中读取指定的组中的选项。
     * MYSQLI_SERVER_PUBLIC_KEY         SHA-256 认证模式下，要使用的 RSA 公钥文件。
     * MYSQLI_OPT_NET_CMD_BUFFER_SIZE   内部命令/网络缓冲大小，仅在 mysqlnd 驱动下有效。
     * MYSQLI_OPT_NET_READ_BUFFER_SIZE  以字节为单位，读取 MySQL 命令报文时候的块大小，仅在 mysqlnd 驱动下有效。
     * MYSQLI_OPT_INT_AND_FLOAT_NATIVE  将整数和浮点数类型的列转换成 PHP 的数值类型，仅在 mysqlnd 驱动下有效。
     * MYSQLI_OPT_SSL_VERIFY_SERVER_CERT
     *
     *
     * @param int $option
     * @param mixed $value
     * @return bool
     */
    public function options($option,  $value) : bool
    {
        return parent::options($option, $value);
    }


    /**
     * 使用 SSL 建立到数据库之间的安全连接
     * 必须在调用 mysqli_real_connect() 函数之前调用此函数。除非启用 OpenSSL 支持，否则此函数无任何作用。
     *
     * 需要注意的是，在 PHP 5.3.3 之前的版本中， MySQL 原生驱动不支持建立 SSL 连接，所以，在使用 MySQL 原生驱动的时候，调用此函数会产生错误。从 PHP 5.3 开始，在 Windows 平台上，默认是启用 MySQL 原生驱动的。
     *
     * @param string $key 密钥文件的路径
     * @param string $cert 证书文件的路径
     * @param string $ca 签发机构的证书文件路径
     * @param string $capath 指向一个目录的路径，该目录下存放的是受信任的 CA 机构证书 PEM 格式的文件。
     * @param string $cipher SSL 加密允许使用的算法清单
     * @return bool
     */
    public function sslSet( string $key, string $cert, $ca = null, $capath = null, $cipher = null) : bool
    {
        return parent::ssl_set($key, $cert, $ca, $capath, $cipher);
    }


    /**
     *建立一个到 MySQL 服务器的链接。
     *
     * 与 mysqli_connect() 的不同点：
     *  ◦ mysqli_real_connect() 需要一个有效的对象，这个对象由 mysqli_init() 创建。
     *  ◦可以使用 mysqli_options() 设置各种连接设置。
     *  ◦提供 flags 参数。
     *
     * flags
     *  这里可以设置连接参数：
     *  MYSQLI_CLIENT_FOUND_ROWS 返回语句匹配的行数，而不是影响的行数
     *  MYSQLI_CLIENT_SSL 使用 SSL 加密
     *  MYSQLI_CLIENT_COMPRESS 使用压缩协议
     *  MYSQLI_CLIENT_INTERACTIVE 在关闭连接之前允许等待 interactive_timeout 秒，他替代 wait_timeout 设定。
     *  MYSQLI_CLIENT_IGNORE_SPACE 允许函数名称后有空格，这将使所有的函数名称成为保留字。
     *
     *
     * Note:
     * 从安全角度考虑，在 PHP 中不可以使用 MULTI_STATEMENT，若要执行多查询语句，请使用 mysqli_multi_query()。
     *
     * @param string $host 可以使用域名、IP 地址。如果传送 NULL 或者字符串 "localhost" 那么会使用通道替代 TCP/IP 连接本地服务器。
     * @param string $username MySQL 登录用户名
     * @param string $passwd 如果设置 NULL，那么会使用没有密码验证的方式尝试登录。这样可以为一个用户提供不同的权限，基于他是否提供了密码。
     * @param string $dbname 设置执行查询语句的默认数据库。
     * @param int $port 指定 MySQL 服务器的端口
     * @param string $socket 指定使用的 socket 或者命名通道。 指定 socket 参数并不能说明要采用何种方式连接数据库。连接数据的方式由 host 设定。
     * @param int $flags 这里可以设置连接参数
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public function realConnect( $host = null, $username = null, $passwd = null, $dbname = null, $port = null, $socket = null,  $flags = null )
    {
        return parent::real_connect($host, $username, $passwd, $dbname, $port, $socket, $flags );
    }



    /**
     * 返回上次调用mysqli_connect（）的最后一个错误代码。
     * 客户端错误消息编号列在MySQL errmsg.h头文件中，服务器错误消息编号列在mysqld_error.h中。在MySQL源代码发行版中，您可以在Docs/mysqld_error.txt文件中找到错误消息和错误号的完整列表。
     * @return int
     */
    public function getConnectErrno():int
    {
        return $this->connect_errno;
    }

    /**
     * 返回上次调用mysqli_connect（）的最后一个错误消息字符串。
     * @return string
     */
    public function getConnectError()
    {
        return $this->connect_error;
    }


    /**
     * 检查到服务器的连接是否还正常。在启用 mysqli.reconnect($this->MySQLiDriver->reconnect) 选项的前提下，如果连接已经断开， ping 操作会尝试重新建立连接。
     * Note: mysqlnd 驱动会忽略 php.ini 中的 mysqli.reconnect 选项，所以它不会自动重连。
     * @return bool
     */
    public function ping() : bool
    {
        return parent::ping();
    }

    /**
     * 返回当前连接的线程 ID，这个线程 ID 可以在 mysqli_kill() 函数中使用。
     * 如果 PHP 到数据库的连接中断了，然后使用 mysqli_ping() 函数重新建立连接的话，新的连接的线程 ID 会发生改变。所以，仅在需要的时候，调用本函数获取连接的线程 ID。
     */
    public function threadId()
    {
        return $this->thread_id;
    }


    /**
     * 让服务器杀掉 processid 参数指定的线程 ID。数据库连接对应的线程 ID 可以通过调用 mysqli_thread_id() 函数得到。
     * 如果仅仅想中止某个查询，请使用这个 SQL 语句： KILL QUERY processid。
     * @param int $processid
     * @return bool
     */
    public function kill($processid) : bool
    {
        return parent::kill($processid);
    }


    /**
     * 告知本数据库客户端库是否编译为线程安全的。
     * @return bool
     */
    public function threadSafe() : bool
    {
        return parent::thread_safe();
    }


    /**
     * 选择用于数据库查询的默认数据库
     * 本函数应该只被用在改变本次链接的数据库，你也能在mysqli_connect()第四个参数确认默认数据库。
     *
     * @param string $dbname 数据库名称
     * @return bool
     */
    public function selectDb( string $dbname) : bool
    {
        return parent::select_db($dbname);
    }


    /**
     * 刷新表或者缓存，或者重置主从服务器信息。
     *
     * MYSQLI_REFRESH_GRANT     刷新授权表。
     * MYSQLI_REFRESH_LOG       刷新日志，如执行 FLUSH LOGS SQL 语句。
     * MYSQLI_REFRESH_TABLES    刷新表缓存，就像执行 FLUSH TABLES SQL 语句一样。
     * MYSQLI_REFRESH_HOSTS     刷新主机缓存，就像执行 FLUSH HOSTS SQL 语句一样。
     * MYSQLI_REFRESH_STATUS    重置状态变量，如执行 FLUSH STATUS SQL 语句。
     * MYSQLI_REFRESH_THREADS   刷新线程缓存。
     * MYSQLI_REFRESH_SLAVE     在从复制服务器上：重置主服务器信息，并重新启动从服务器。 就像执行 RESET SLAVE SQL 语句一样。
     * MYSQLI_REFRESH_MASTER    在主复制服务器上：删除二进制日志索引中列出的二进制日志文件，     *
     *
     * @param int $options 使用 MySQLi 常量 中的 MYSQLI_REFRESH_* 常量作为刷新选项。
     * @return bool
     */
    public function refresh( $options) : bool
    {
        return parent::refresh($options);
    }


    /**
     * 此函数用来对字符串中的特殊字符进行转义，以使得这个字符串是一个合法的 SQL 语句。传入的字符串会根据当前连接的字符集进行转义，得到一个编码后的合法的 SQL 语句。
     * 在调用 mysqli_real_escape_string() 函数之前，必须先通过调用 mysqli_set_charset() 函数或者在 MySQL 服务器端设置字符集。更多信息请参考 字符集
     *
     *
     * @param string $escapestr
     * @return string
     */
    public function real_escape_string( $escapestr) : string
    {
        return parent::real_escape_string( $escapestr);
    }


    /**
     * 返回最近的mysqli函数调用产生的错误代码.
     * 客户端错误在Mysql errmsg.h头文件中列出, 服务端错误好在mysqld_error.h中列出. 在mysql源码分发包中的Docs/mysqld_error.txt你可以发现一个完整的错误消息和错误号.
     * @return int
     */
    public function getErrno():int
    {
        return $this->errno;
    }


    /**
     * 返回可能成功或失败的最近MySQLi函数调用的最后一条错误消息。
     *
     * @return string 描述错误的字符串。如果未发生错误，则为空字符串。
     */
    public function getError():string
    {
        return $this->error;
    }
    
    /**
     * 返回最新MySQLi函数调用的错误数组，该调用可能成功，也可能失败。
     *
     * @return array 错误列表，每个错误都作为关联数组，包含errno、error和sqlstate。
     */
    public function getErrorList() : array
    {
        return $this->error_list;
    }


    /**
     *  返回上一次 SQL 操作的 SQLSTATE 错误信息
     * 返回一个包含 SQLSTATE 错误码的字符串，表示上一次 SQL 操作的错误。错误码是由 5 个字符构成，'00000' 表示没有发生错误。错误码是由 ANSI SQL 和 ODBC 定义的，详细的清单请参见：» http://dev.mysql.com/doc/mysql/en/error-handling.html。
     *
     * @return string
     */
    public function sqlstate(){
        return $this->sqlstate;
    }


    /**
     * 分配并初始化一个语句对象用于mysqli_stmt_prepare().
     * 任何其后调用的mysqli_stmt函数都会失败直到mysqli_stmt_prepare()被调用.
     * @return mysqli_stmt
     */
    public function stmtInit() : MysqliSTML
    {
        return new MysqliSTML(parent::stmt_init());
    }



    /**
     * 做好执行 SQL 语句的准备，返回一个语句句柄，可以对这个句柄进行后续的操作。这里仅仅支持单一的 SQL 语句，不支持多 SQL 语句。
     * 在执行语句之前，需要使用 mysqli_stmt_bind_param() 函数对占位符参数进行绑定。同样，在获取结果之前，必须使用 mysqli_stmt_bind_result() 函数对返回的列值进行绑定。
     *
     * query
     *  Note:
     *      不需要在语句末尾增加分号（;）或者 \g 结束符。
     *      SQL 语句中可以包含一个或者多个问号（?）表示语句的参数。
     *  Note:
     *      SQL 语句中，仅允许在特定的位置出现问号参数占位符。例如，在 INSERT 语句中的 VALUES() 子句中可以使用参数占位符，来表示对应列的值。也可以在 WHERE 字句中使用参数来表示要进行比较的值。
     *      但是，并不是所有的地方都允许使用参数占位符，例如对于表名、列名这样的 SQL 语句中的标识位置，就不可以使用参数占位。 SELECT 语句中的列名就不可以使用参数。另外，对于 = 这样的逻辑比较操作也不可以在两侧都使用参数，否则服务器在解析 SQL 的时候就不知道该如何检测参数类型了。也不可以在 NULL 条件中使用问号，也就是说不可以写成：? IS NULL。一般而言，参数也只能用在数据操作（DML）语句中，不可以用在数据定义（DDL）语句中。
     *
     * @param string $query SQL 语句。
     * @return mysqli_stmt
     */
    public function prepare( $query):MysqliSTML
    {
        $this->prepareQuery = $query;
        
        return new MysqliSTML(parent::prepare($query));
        
    }


    /**
     * 执行一个单条数据库查询, 其结果可以使用mysqli_store_result()或mysqli_use_result()检索或存储.
     * 为了确定给定的查询是否真的返回一个结果集, 可以查看mysqli_field_count().
     *
     * @param string $query
     * @return bool
     */
    public function realQuery( string $query) : bool
    {
        return parent::real_query($query);
    }



    /**
     *  对数据库执行一次查询
     * 对于非 DML 查询（不是 INSERT、UPDATE 或 DELETE），此函数类似于调用 mysqli_real_query() 后跟 mysqli_use_result() 或 mysqli_store_result()。
     *
     * $resultmode
     *      常量 MYSQLI_USE_RESULT (用于使用无缓冲结果集 ) 或 MYSQLI_STORE_RESULT (用于使用缓冲结果集 ) 取决于所需的行为。 默认情况下，使用 MYSQLI_STORE_RESULT。
     *      如果您使用 MYSQLI_USE_RESULT 所有后续调用将返回的错误命令不同步，除非您调用 mysqli_free_result()
     *      使用 MYSQLI_ASYNC（可用于 mysqlnd），可以异步执行查询。 然后使用 mysqli_poll() 从此类查询中获取结果。
     *
     *
     * 如果你向 mysqli_query() 传递的语句比服务器的 max_allowed_packet 长，返回的错误代码会根据你使用的是 MySQLNative Driver (mysqlnd) 还是 MySQL Client Library (libmysqlclient) 而有所不同。 行为如下：
     * ◦ Linux 上的 mysqlnd 返回错误代码 1153。错误消息的意思是“得到一个大于 max_allowed_packet 字节的数据包”。
     * ◦ Windows 上的 mysqlnd 返回错误代码 2006。此错误消息表示“服务器已消失”。
     *
     *
     * @param string $query   sql字符串； 应正确转义查询中的数据。
     * @param int $resultmode
     * @return bool|\mysqli_result|void
     */
    public function query( $query, $resultmode = MYSQLI_STORE_RESULT )
    {
        $res = parent::query($query, $resultmode);
        if($res && $res instanceof mysqli_result){
            return new MysqliResult($res);
        }
        return $res;
    }



    /**
     * 执行一个 SQL 语句，或者多个使用分号分隔的 SQL 语句。
     * 要获得执行结果中的第一个结果集，请使用 mysqli_use_result() 或 mysqli_store_result() 函数。要读取后续的结果集，请使用 mysqli_more_results() 和 mysqli_next_result() 函数。
     * @param string $query
     * @return bool 如果第一个 SQL 语句就失败了，返回 FALSE。如果是批量执行 SQL 语句，必须首先调用 mysqli_next_result() 函数，才可以获取后续语句的错误信息。
     */
    public function multiQuery( string $query) : bool
    {
        return parent::multi_query($query);
    }



    /**
     * 检查上一次调用 mysqli_multi_query() 函数之后，是否还有更多的查询结果集。
     * @return bool
     */
    public function moreResults() : bool
    {
        return parent::more_results();
    }

    /**
     * mysqli_multi_query() 函数执行之后，为读取下一个结果集做准备，然后可以使用 mysqli_store_result() 或 mysqli_use_result() 函数读取下一个结果集。
     * @return bool
     */
    public function nextResult() : bool
    {
        return parent::next_result();
    }



    /**
     * 迁移 link 参数所指定的连接上的上一次查询返回的结果集，迁移之后的结果集可以在 mysqli_data_seek() 函数中使用。
     *
     * $option
     *  MYSQLI_STORE_RESULT_COPY_DATA （此选项仅在使用 mysqlnd 驱动且 PHP 5.6.0 之后可用）。将结果集从 mysqlnd 的内部缓冲区复制到 PHP 变量中。默认情况下，mysqlnd 采取一种引用策略尽量避免在内容中复制多份同样的结果集。例如，对于一个包含了很多行的结果集，每个行中的内容又不是很大，那么复制结果集的过程会导致内存使用率下降，因为用来保存结果集数据的 PHP 变量可能提前被释放掉。
     *
     * Note:
     * 执行查询之后，使用 mysqli_free_result() 函数来释放结果集所占用的内存，是一个很有用的实战经验。尤其是当使用 mysqli_store_result() 函数来转移数量较大的结果集的时候，释放结果集内存的操作尤为重要。
     *
     * @param int $option 指定的选项
     * @return mysqli_result 成功则返回一个缓冲的结果集对象，失败则返回 FALSE。
     */
    public function storeResult( $option =null)
    {
        $res = parent::store_result($option);
        if($res){
            return new MysqliResult($res);
        }
        return $res;
    }


    /**
     * 启动结果集检索
     * 用于从在数据库连接上使用 mysqli_real_query() 函数执行的最后一个查询中启动结果集的检索。
     *
     * 必须在检索查询结果之前调用此函数或 mysqli_store_result() 函数，并且必须调用其中一个函数以防止对该数据库连接的下一个查询失败。
     *
     * note:函数不会从数据库中传输整个结果集，因此不能使用诸如 mysqli_data_seek() 之类的函数移动到集中的特定行。 要使用此功能，必须使用 mysqli_store_result() 存储结果集。 如果在客户端执行大量处理，则不应使用 mysqli_use_result()，因为这将占用服务器并阻止其他线程更新正在从中获取数据的任何表。
     *
     * @return mysqli_result 返回未缓冲的结果对象，如果发生错误，则返回FALSE。
     */
    public function useResult()
    {
        $res = parent::use_result();
        if($res){
            return new MysqliResult($res);
        }
        return $res;
    }



    /**
     * 轮询连接;仅可用于 mysqlnd。
     *
     * mysqli::poll此方法是 static 的。
     *
     * @param array $read 要检测是否存在可以读取的结果集的连接的数组。
     * @param array $error 发生错误的，例如：SQL 语句执行失败或者已经断开的连接的数组。
     * @param array $reject 没有可以读取的结果集的连接的数组。
     * @param int $sec 秒为单位的最大等待时间，不可以为负数。
     * @param int $usec 微秒为单位的最大等待时间，不可以为负数。
     * @return int|false 成功执行则返回存在可以读取结果集的连接数量，否则 FALSE。
     */
    public static function poll( &$read,  &$error,  &$reject,  $sec,  $usec = 0 )
    {
        return parent::poll($read,$error, $reject,  $sec,  $usec);
        //return mysqli_poll($read,$error, $reject,  $sec,  $usec);
    }

    /**
     * 获取异步查询的结果，仅可用于 mysqlnd
     * @return mysqli_result 如果成功则返回 mysqli_result，否则返回 FALSE。
     */
    public function reap_async_query() : MysqliResult
    {
        $res = parent::reap_async_query();
        if($res){
            return new MysqliResult($res);
        }
        return $res;
    }





    /**
     * 函数返回一个包含最近执行的 SQL 语句信息的字符串。下面有一些参考样例：
     *
     *
     * 返回结果字符串示例
     * INSERT INTO...SELECT... Records: 100 Duplicates: 0 Warnings: 0
     * INSERT INTO...VALUES (...),(...),(...) Records: 3 Duplicates: 0 Warnings: 0
     * LOAD DATA INFILE ... Records: 1 Deleted: 0 Skipped: 0 Warnings: 0
     * ALTER TABLE ... Records: 3 Duplicates: 0 Warnings: 0
     * UPDATE ... Rows matched: 40 Changed: 40 Warnings: 0
     *
     * Note:
     * 如果所执行的 SQL 语句不是上面列出来的这几种类型的， mysqli_info() 函数会返回一个空字符串。
     *
     * @return string 函数返回一个包含最近执行的 SQL 语句信息的字符串。下
     */
    public function info()
    {
        return $this->info;
    }




    /**
     * 返回最后一条插入语句产生的自增 ID
     * mysqli_insert_id() 函数返回最后一个 SQL 语句（通常是 INSERT 语句）所操作的表中设置为 AUTO_INCREMENT 的列的值。如果最后一个 SQL 语句不是 INSERT 或者 UPDATE 语句，或者所操作的表中没有设置为 AUTO_INCREMENT 的列，返回值为 0。
     * 如果在所执行的 INSERT 或者 UPDATE 语句中使用了数据库函数 LAST_INSERT_ID()。有可能会影响 mysqli_insert_id() 函数的返回值。
     * @return int
     */
    public function insertId():int
    {
        return $this->insert_id;
    }

    /**
     * 最近查询的列数。在使用mysqli_store_result（）函数确定查询是否应生成非空结果集时，此函数非常有用，因为不知道查询的性质。
     * @return int 表示结果集中字段数的整数。
     */
    public function fieldCount():int
    {
        return $this->field_count;
    }


    


    /**
     * 获取上一个MySQL操作中受影响的行数
     *
     * 同 mysqli_affected_rows( mysqli $link) : int
     * 对于SELECT语句，mysqli_impacted_rows（）的工作方式与mysqli_num_rows（）类似
     *
     * @return int 返回受上次插入、更新、替换或删除查询影响的行数。
     */
    public function affectedRows():int
    {
        return $this->affected_rows;
    }




    /**
     * 从当前事务的保存点中移除一个命名保存点
     * @param string $name
     * @return bool
     */
    public function releaseSavepoint( string $name) : bool
    {
        return parent::release_savepoint($name);
    }

    /**
     * 在当前事务中增加一个命名保存点
     * @param string $name
     * @return bool
     */
    public function savepoint( $name) : bool
    {
        return parent::savepoint($name);
    }



    /**
     * 开启一个事务; 需要InnoDB引擎（默认情况下已启用
     *
     * flags
     * Valid flags are:
     *
     * ◦ MYSQLI_TRANS_START_READ_ONLY:  Start the transaction as "START TRANSACTION READ ONLY".Requires MySQL 5.6 and above.
     * ◦ MYSQLI_TRANS_START_READ_WRITE:  Start the transaction as "START TRANSACTION READ WRITE".Requires MySQL 5.6 and above.
     * ◦ MYSQLI_TRANS_START_WITH_CONSISTENT_SNAPSHOT:  Start the transaction as "START TRANSACTION WITH CONSISTENT SNAPSHOT".
     *
     * name
     * Savepoint name for the transaction.
     *
     * @param int $flags 模式：只读  读写  一致快照启动事务
     * @param string $name 事务的保存点名称
     * @return bool
     */
    public function beginTransaction(int $flags = 0, $name = null) : bool
    {
        return parent::begin_transaction($flags);
    }




    /**
     * 提交数据库连接的当前事务
     *
     * MYSQLI_TRANS_COR_AND_CHAIN
     *     Appends "AND CHAIN" to mysqli_commit() or mysqli_rollback(). 将“AND CHAIN”附加到 mysqli_commit() 或 mysqli_rollback()。
     * MYSQLI_TRANS_COR_AND_NO_CHAIN
     *     Appends "AND NO CHAIN" to mysqli_commit() or mysqli_rollback().
     * MYSQLI_TRANS_COR_RELEASE
     *     Appends "RELEASE" to mysqli_commit() or mysqli_rollback().
     * MYSQLI_TRANS_COR_NO_RELEASE
     *     Appends "NO RELEASE" to mysqli_commit() or mysqli_rollback().
     *
     *
     * @param int $flags MYSQLI_TRANS_COR_* 常量的位掩码。
     * @param string $name 如果提供，则执行 COMMIT $name。
     * @return bool
     */
    public function commit($flags = -1, $name = null) : bool
    {
        return parent::commit($flags, $name);
    }


    /**
     * 回滚当前事务 since 5.5 添加了标志和名称参数。
     * @param int $flags MYSQLI_TRANS_COR_* 常量的位掩码。
     * @param null $name 如果提供，则执行 ROLLBACK $name。
     * @return bool
     */
    public function rollback($flags = 0, $name = null) : bool
    {
        return parent::rollback();
    }





    /**
     * 打开或关闭本次数据库连接的自动命令提交事务模式。
     * 如需要确认当前连接的自动事务提交状态，可执行这个SQL请求SELECT @@autocommit.
     * @param bool $mode Whether to turn on auto-commit or not.
     * @return bool
     */
    public function autocommit($mode) :bool
    {
        return parent::autocommit($mode);
    }


    /**
     * 返回一个表述使用的连接类型的字符串
     * 
     * @param mysqli $link
     * @return string
     */
    public function getHostInfo() : string
    {
        return $this->host_info;
    }


    /**
     * 返回一个整数，表述 被link参数所表述的连接 所使用的MySQL协议的版本号.
     * @return int 返回一个整数来表述协议的版本号.
     */
    public function getProtocolVersion():int
    {
        return $this->protocol_version;
    }


    /**
     * 返回一个字符串，表述MySQLi扩展连接的MySQL服务器的版本号.
     * @return string
     */
    public function getServerInfo():string
    {
        return $this->server_info;
    }

    /**
     *  作为一个整数返回MySQL服务器的版本
     * @return int
     */
    public function getServerVersion():int
    {
        return $this->server_version;
    }



    /**
     * 返回 MySQL 客户端库的版本信息。
     * @return string
     */
    public function getClientInfo() : string
    {
        return parent::get_client_info();
    }


    /**
     * 作为一个整数返回客户端版本号.
     * @return int
     */
    public function getClientVersion() : int
    {
        return $this->client_version;
    }


    /**
     * 返回一个表示系统状态信息的字符串，字符串中的内容和 'mysqladmin status' 命令的输出结果类似，包含以秒为单位的运行时间、运行中的线程数、问题数、重新加载数以及打开的表数量等信息。
     * @return string 成功则返回表示系统状态信息的字符串，失败则返回 FALSE。
     */
    public function stat() : string
    {
        return parent::stat();
    }

    /**
     * 返回一个字符集对象，该对象提供当前活动字符集的多个属性。
     *
     * 函数返回具有以下属性的字符集对象：
     * charset
     *      字符集名称
     * collation
     *      排序规则名称
     * dir
     *      字符集描述从 (?) 或 "" 获取的目录，用于内置字符集
     * min_length
     *      最小字符长度（字节）
     * max_length
     *      最大字符长度（字节）
     * number
     *      内部字符集编号
     * state
     *      字符集状态（？）
     *
     * @return object 函数返回字符集对象
     */
    public function getCharset()
    {
        return parent::get_charset();
    }


    /**
     * 设置默认字符编码
     *
     * 这应该是首选的用于改变字符编码的方法，不建议使用mysqli_query()执行SQL请求的SET NAMES ...（如 SET NAMES utf8）。
     *
     * $mysqli->query("SET CHARACTER SET utf8");
     * $mysqli->set_charset('utf8mb4');
     *
     * @param string $charset 被设为默认的字符编码名。
     * @return bool
     */
    public function setCharset( string $charset) : bool
    {
        return parent::set_charset($charset);
    }


    /**
     * 返回当前数据库连接的默认字符编码。
     * @return string
     */
    public function characterSetName() : string
    {
        return parent::character_set_name();
    }





    /**
     * 返回客户端连接的统计数据，仅可用于 mysqlnd
     * 手册›Mysqlnd›Statistics
     * @return array|bool 返回一个数组，包含客户端连接的统计数据，否则 FALSE。
     */
    public function getConnectionStats()
    {
        return parent::get_connection_stats();
    }







    /**
     * 更改指定数据库连接的用户并设置当前数据库。
     * 为了成功更改用户，必须提供有效的用户名和密码参数，并且该用户必须具有访问所需数据库的足够权限。如果由于任何原因授权失败，当前用户身份验证将保留。
     * @param string $user
     * @param string $password
     * @param string $database
     * @return bool
     */
    public function changeUser( string $user, string $password, string $database) : bool
    {
        return parent::change_user($user, $password, $database);
    }


    /**
     * Get result of SHOW WARNINGS
     * @return mysqli_warning
     */
    public function getWarnings()
    {
        return parent::get_warnings();
    }


    /**
     * 返回给定链接的最后一次查询的警告数
     * 要检索警告消息，您可以使用 SQL 命令 SHOW WARNINGS [limit row_count]。
     * @return int 警告数，如果没有警告则为零。
     */
    public function warning_count():int
    {
        return $this->warning_count;
    }



    /**
     * 使用Fred Fish调试库执行调试操作。
     * 要使用mysqli_debug（）函数，必须编译MySQL客户端库以支持调试
     * @param string $message 表示要执行的调试操作的字符串
     * @return bool
     */
    public function debug( $message) : bool
    {
        return parent::debug($message);
    }


    /**
     * 这个函数设计用于超级权限用户执行将调试信息输出到连接相关的MySQL服务端日志
     * @return bool
     */
    public function dump_debug_info() : bool
    {
        return parent::dump_debug_info();
    }









}






