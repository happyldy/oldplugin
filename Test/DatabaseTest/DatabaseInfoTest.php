<?php


namespace HappyLin\OldPlugin\Test\DatabaseTest;


use HappyLin\OldPlugin\SingleClass\Database\DatabaseManager;



use HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits\System;
use HappyLin\OldPlugin\Test\TraitTest;
use PDO;

class DatabaseInfoTest
{

    use System,TraitTest;


    /**
     * @var \HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOMySqlDriver
     */
    public $conn;



    public function __construct()
    {
        $this->conn = DatabaseManager::getInstance()->connection('pdo','0','mysql');

        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }





    /**
     * @note  展示tableInfoTest()信息
     */
    public function showTableMsg(array $info)
    {
        $msg = [
            'Name' => '表名称',
            'Engine' => '表的存储引擎',
            'Version' => '版本',
            'Row_format' => '行格式。对于MyISAM引擎，这可能是Dynamic，Fixed或Compressed。动态行的行长度可变，例如Varchar或Blob类型字段。固定行是指行长度不变，例如Char和Integer类型字段',
            'Rows' => '表中的行数。对于MyISAM和其他存储引擎，这个值是精确的，对于innoDB存储引擎，这个值通常是估算的',
            'Avg_row_length' => '平均每行包括的字节数 ',
            'Data_length' => '整个表的数据量(以字节为单位)',
            'Max_data_length' => '表可以容纳的最大数据量，该值和存储引擎相关',
            'Index_length' => '索引占用磁盘的空间大小(以字节为单位)  ！！！！！！！',
            'Data_free' => '对于MyISAM引擎，表示已经分配，但目前没有使用的空间。这部分空间包含之前被删除的行，以及后续可以被insert利用到的空间',
            'Auto_increment' => '下一个Auto_increment的值',
            'Create_time' => '表的创建时间',
            'Update_time' => '表的最近更新时间',
            'Check_time' => '使用 check table 或myisamchk工具最后一次检查表的时间',
            'Collation' => '表的默认字符集和字符排序规则',
            'Checksum' => '如果启用，保存的是整个表的实时校验和',
            'Create_options' => '创建表时指定的其他选项',
            'Comment' => '包含了其他额外信息，对于MyISAM引擎，保存的是表在创建时带的注释。如果表使用的是innodb引擎 ，保存的是InnoDB表空间的剩余空间。如果是一个视图，注释里面包含了VIEW字样。',
        ];

        $infoBak = [];
        foreach ($info as $k => $v) {

            if (!empty($msg[$k])) {
                $bakVal = str_pad($info[$k], 36 - strlen($k), ' ', STR_PAD_RIGHT) . "# " . $msg[$k];
            } else {
                $bakVal = $info[$k];
            }
            $infoBak[$k] = $bakVal;
        }

        var_dump(static::toStr(
            '表格状态信息',
            $infoBak
        ));

    }



    /**
     * SHOW TABLE STATUS [FROM db_name] [LIKE 'pattern'];         \G;
     * @note 表格状态信息 show table status from test like 'test%'
     */
    public function tableInfoTest($table='test1000%')
    {

        // 查
        $stmt = $this->conn->prepare("show table status from test like '$table'");

        $stmt->execute();
        $res = $stmt->fetchAll();

        $this->showTableMsg($res[0]);
    }






    /**
     * @note  展示tableInfoTest()信息
     */
    public function showDatabaseMsg(array $status)
    {

        $sort = ['基础', '线程', '查询', '事务', '延迟插入', '连接信息', '未知信息'];
        $msgArr = [
            '基础' =>
            [
                'Uptime' => '查看MySQL本次启动后的运行时间(单位：秒)',
                'default_storage_engine' => '默认数据库存储引擎',
                'Com_select' => '查看无缓存select语句的执行数',
                'Com_insert' => '查看insert语句的执行数',
                'Com_update' => '查看update语句的执行数',
                'Com_delete' => '查看delete语句的执行数',
                'Com_commit' => '查看提交事务计数',
                'Com_rollback' => '查看回滚事务计数',

            ],


            '线程' =>
            [

                'Threads_cached' => '查看线程缓存内的线程的数量',
                'Threads_connected' => '查看当前打开的连接的数量',
                'Threads_created' => '查看创建用来处理连接的线程数。如果Threads_created较大，你可能要增加thread_cache_size值。！！！！！！！！！！',
                'Threads_running' => '-查看激活的(非睡眠状态)线程数。',

            ],

            '查询'=>
            [

                'Innodb_rows_read' => '查询返回的行数',
                'Innodb_rows_inserted' => '查询返回的行数',
                'Innodb_rows_updated' => '更新成功的行数',
                'Innodb_rows_deleted' => '删除成功的行数',
                'Slow_launch_threads' => '查看慢查询；创建时间超过slow_launch_time秒的线程数。！！！！！！！！！！',
                'Slow_queries' => '查看慢查询；时间超过long_query_time秒的查询的个数。',

            ],

            '事务' =>
            [
                'Com_commit' => '查看提交事务计数',
                'Com_rollback' => '查看回滚事务计数',
                'Innodb_row_lock_current_waits' => '当前正在等待锁定的数量；',
                'Innodb_row_lock_time' => '从系统启动到现在锁定的总时间长度；',
                'Innodb_row_lock_time_avg' => '每次等待所花平均时间；',
                'Innodb_row_lock_time_max' => '从系统启动到现在等待最长的一次所花的时间；',
                'Innodb_row_lock_waits' => '从系统启动到现在总共等待的次数',

                'Table_locks_immediate' => '查看立即获得的表的锁的次数。',
                'Table_locks_waited' => '查看不能立即获得的表的锁的次数。如果该值较高，并且有性能问题，你应首先优化查询，然后拆分表或使用复制。！！！！！！！',

            ],

            '延迟插入' =>
            [
                'Delayed_insert_threads'  => '正在使用的延迟插入处理器线程的数量。 ',
                'Delayed_writes'  => '用INSERT DELAYED写入的行数。 ',
                'Delayed_errors'  => '用INSERT DELAYED写入的发生某些错误(可能重复键值)的行数。 ',
            ],

            '连接信息' =>
            [
                'Aborted_clients'  => '由于客户没有正确关闭连接已经死掉，已经放弃的连接数量。 ',
                'Aborted_connects'  => '尝试已经失败的MySQL服务器的连接的次数。 ',
                'Connections' => '查看试图连接到MySQL(不管是否连接成功)的连接数',

            ],



            '其它信息'=>
            [
                'Created_tmp_tables'  => '当执行语句时，已经被创造了的隐含临时表的数量。 ',

                'Flush_commands'  => '执行FLUSH命令的次数。 ',
                'Handler_delete'  => '请求从一张表中删除行的次数。 ',
                'Handler_read_first'  => '请求读入表中第一行的次数。 ',
                'Handler_read_key'  => '请求数字基于键读行。 ',
                'Handler_read_next'  => '请求读入基于一个键的一行的次数。 ',
                'Handler_read_rnd'  => '请求读入基于一个固定位置的一行的次数。 ',
                'Handler_update'  => '请求更新表中一行的次数。 ',
                'Handler_write'  => '请求向表中插入一行的次数。 ',
                'Key_blocks_used'  => '用于关键字缓存的块的数量。 ',
                'Key_read_requests'  => '请求从缓存读入一个键值的次数。 ',
                'Key_reads'  => '从磁盘物理读入一个键值的次数。 ',
                'Key_write_requests'  => '请求将一个关键字块写入缓存次数。 ',
                'Key_writes'  => '将一个键值块物理写入磁盘的次数。 ',
                'Max_used_connections'  => '同时使用的连接的最大数目。 ',
                'Not_flushed_key_blocks'  => '在键缓存中已经改变但是还没被清空到磁盘上的键块。 ',
                'Not_flushed_delayed_rows'  => '在INSERT DELAY队列中等待写入的行的数量。 ',
                'Open_tables'  => '打开表的数量。 ',
                'Open_files'  => '打开文件的数量。 ',
                'Open_streams'  => '打开流的数量(主要用于日志记载） ',
                'Opened_tables'  => '已经打开的表的数量。 ',
                'Questions'  => '发往服务器的查询的数量。 ',

            ],

            '未知信息' => []

            ];

        $infoBak = [];
        foreach ($status as $k => $v) {
            $msgKey = $v['Variable_name'];
            foreach ($msgArr as $mk => $msg){
                if (!empty($msg[$msgKey])) {
                    $infoBakVal = str_pad($v['Value'], 40 - strlen($msgKey), ' ', STR_PAD_RIGHT) . "# " . $msg[$msgKey];
                    $infoBak[$mk][$msgKey] = $infoBakVal;
                    continue 2;
                }
            }
            $infoBak['未知信息'][$msgKey] = $v['Value'];
        }
        var_dump(static::toStr(
            'mysql服务器 常见状态信息'
        ));

        foreach ($sort as  $v){
            var_dump(static::toStr(
                "$v",
                $infoBak[$v]
            ));
        }

    }




    /**
     *
     *
     * @note mysql服务器装状态  show status ; 部分信息
     */
    public function databaseInfoTest()
    {

        // 查
        $stmt = $this->conn->prepare("show status;");
        $stmt->execute();
        $res = $stmt->fetchAll();
        $this->showDatabaseMsg($res);



        $this->conn->prepare("show warnings;")->execute();

        var_dump(static::toStr(
            '查看警告信息',
            $stmt->fetchAll()
        ));

    }







    /**
     * @note  展示variablesInfoTest()信息
     */
    public function variablesInfoMsg(array $status)
    {
        $sort = ['基础', '连接', '二进制日志缓存', '查询缓存', '慢查询', '事务', '延迟插入', '其它', '未知'];
        $msgArr = [
            '基础' =>
                [
                    'version' => '服务器版本号',
                    'protocol_version' => 'MySQL服务器使用的客户端/服务器协议的版本。',
                    'basedir' => 'MySQL安装基准目录。可以用--basedir选项设置该变量。',
                    'datadir' => '数据目录。可以用--datadir选项设置该变量。',
                    'time_zone' => '当前的时区。初使值是‘SYSTEM‘(使用system_time_zone的值)，但可以用--default-time-zone选项在服务器启动时显式指定。',
                    'character_set_database' => '默认数据库使用的字符集。',
                    'character_set_client' => '来自客户端的语句的字符集。',
                    'character_set_results' => '用于向客户端返回查询结果的字符集。',
                    'server_id' => '--server-id选项的值。用于主复制服务器和从复制服务器。',
                    'socket' => 'Unix平台：用于本地客户端连接的套接字文件。默认为/var/lib/mysql/mysql.sock。Windows：用于本地客户端连接的命名管道名。默认为mysql。',
                    'sql_mode' => '当前的服务器SQL模式，可以动态设置。',
                    'log-error' => '错误日志的位置。',
                    'log_timestamps' => '控制错误日志信息的时间戳与时区，以及查询日志和慢日志写入文件时的时间戳与时区为本地system为本地时区。',
                    'explicit_defaults_for_timestamp' => ' 系统变量决定MySQL服务端对timestamp列中的默认值和NULL值的不同处理方法',
                ],

            '连接' =>
                [
                    'back_log' => '说明MySQL临时停止响应新请求前在短时间内可以堆起多少请求。（该值为“进”TCP/IP连接帧听队列的大小）',
                    'connect_timeout' => '服务器用Bad handshake响应前等待连接包的秒数',
                    'max_connect_errors' => '如果中断的与主机的连接超过该数目，该主机则阻塞后面的连接。你可以用 FLUSH HOSTS语句解锁锁定的主机。',
                    'max_connections' => '允许的并行客户端连接数目。增大该值则增加mysqld 需要的文件描述符的数量。',
                    'wait_timeout' => '服务器关闭非交互连接之前等待活动的秒数',
                    'interactive_timeout' => '数据库关闭一个交互的连接之前所要等待的秒数',
                    'slave_net_timeout' => '备库等待主库发送数据的超时时间，如果超过这个时间主库还未发送任何消息，开始尝试重连操作',

                ],
            '二进制日志缓存' =>
                [
                    'log_bin' => '是否启用二进制日志。',
                    'log_bin_basename' => 'binlog日志的基本文件名',
                    'log_bin_index' => 'binlog文件的索引文件，管理所有binlog文件',
                    'binlog_cache_size' => '在事务过程中容纳二进制日志SQL语句的缓存大小。二进制日志缓存是服务器支持事务存储引擎并且服务器启用了二进制日志(--log-bin选项)的前提下为每个客户端分配的内存。',
                    'expire_logs_days' => '二进制日志自动删除的天数。默认值为0,表示“没有自动删除”。启动时和二进制日志循环时可能删除。',
                    'binlog_format' => '设置日志三种格式：STATEMENT、ROW、MIXED 。',
                    'max_binlog_size' => '如果二进制日志写入的内容超出给定值，日志就会发生滚动。你不能将该变量设置为大于1GB或小于4096字节。 默认值是1GB。',
                    'expire_logs_days' => '设置binlog清理时间; 二进制日志自动删除的天数。默认值为0,表示“没有自动删除”。',
                    'binlog_group_commit_sync_delay' => '控制在二进制日志文件同步到磁盘之间等待多少微秒以把事务合并到一个binloggroup中一次性提交（单位:us）',

                ],

            '查询缓存' =>
                [
                    'query_cache_limit' => '不要缓存大于该值的结果。默认值是1048576(1MB)。',
                    'query_cache_min_res_unit' => '查询缓存分配的最小块的大小(字节)。 默认值是4096(4KB)。',
                    'query_cache_size' => '为缓存查询结果分配的内存的数量。默认值是0，即禁用查询缓存。请注意即使query_cache_type设置为0也将分配此数量的内存。',
                    'query_cache_type' => '设置查询缓存类型。',
                ],

            '慢查询' =>
                [
                    'slow_query_log'  => '是否开启慢sql记录，1表示开启',
                    'long_query_time'  => '记录sql语句到慢日志的执行时间阈值（s）',
                    'slow_query_log_file'  => '慢日志的路径及名称',
                ],
            '事务' =>
                [
                    'transaction_isolation' => '默认数据库隔离级别，读提交',
                    'innodb_lock_wait_timeout' => '定义InnoDB数据库锁超时时间',
                    'sync_binlog' => '为了确保binlog日志的安全，建议设置为1，这样每次事务提交时就会调用fdatasync()实时把binlog日志刷新到磁盘',
                ],

            '延迟插入' =>
                [
                    'delayed_insert_limit' => '插入delayed_insert_limit（延迟插入限制） 延迟行后，INSERT DELAYED 处理器线程检查是否有挂起的SELECT语句。如果有，在继续插入延迟的行之前，允许它们先执行（如果您的客户端不能等待INSERT完成）',
                    'delayed_insert_timeout' => 'INSERT DELAYED处理器线程终止前应等待INSERT语句的时间。',
                    'delayed_queue_size' => '这是各个表中处理INSERT DELAYED语句时队列中行的数量限制。如果队列满了，执行INSERT DELAYED语句的客户端应等待直到队列内再有空间。',
                    'binlog_group_commit_sync_no_delay_count' => '指定延迟时间内，一次组提交允许等待的最大事务数量',
                ],

            '其它' =>
                [
                    'auto_increment_increment' => 'AUTO_INCREMENT列的自增量',
                    'log-bin-trust-function-creators' => '当二进制日志启用后，这个变量就会启用。它控制是否可以信任存储函数创建者，不会创建写入二进制日志引起不安全事件的存储函数。',
                    'flush' => '如果用--flush选项启动mysqld该值为ON。清除一些MySQL使用内部缓存【HOSTS、LOGS、TABLES、STATUS】',
                    'flush_time' => '如果设为非零值，每隔flush_time秒则关闭所有表以释放硬盘资源并同步未清空的数据。',
                    'group_concat_max_len' => '允许的GROUP_CONCAT()函数结果的最大长度。',
                    'have_query_cache' => '如果mysqld支持查询缓存则为YES。',
                    'init_file' => '启动服务器时用--init-file选项指定的文件名。',
                    'local_infile' => '是否LOCAL支持LOAD DATA INFILE语句。',
                    'log_slave_updates' => '是否从服务器从主服务器收到的更新应记入从服务器自己的二进制日志。要想生效，必须启用从服务器的二进制记录。',
                    'long_query_time' => '如果查询时间超过该值，则增加Slow_queries状态变量。如果你正使用--log-slow-queries选项，则查询记入慢查询日志文件。',
                    'max_binlog_cache_size' => '如果多语句事务需要更大的内存，你会得到错误Multi-statement transaction required more than ‘max_binlog_cache_size‘ bytes of storage。',
                    'max_delayed_threads' => '不要启动大于该数目的线程来处理INSERT DELAYED语句。',
                    'max_error_count' => '保存由SHOW ERRORS或SHOW WARNINGS显示的错误、警告和注解的最大数目。',
                    'max_sort_length' => '当排序BLOB或TEXT值时使用的字节数。只使用每个值的前max_sort_length字节；其它的被忽略。',
                    'pid_file' => '进程ID (PID)文件的路径名。可以用--pid-file选项设置该变量。',
                    'time_format' => '该变量为使用',
                    'tmpdir' => '保存临时文件和临时表的目录。该变量可以设置为几个路径，按round-robin模式使用。在Unix中应该用冒号(‘:’)间隔开路径，在Windows、NetWare和OS/2中用分号(‘；’)。',
                    'tx_isolation' => '默认事务隔离级别。默认值为REPEATABLE-READ。',
                ],

            '未知' => []

        ];

        $infoBak = [];
        foreach ($status as $k => $v) {
            $msgKey = $v['Variable_name'];
            foreach($msgArr as $mk => $msg){
                if (!empty($msg[$msgKey])) {
                    $infoBakVal = str_pad($v['Value'], 50 - strlen($msgKey), ' ', STR_PAD_RIGHT) . "# " . $msg[$msgKey];
                    $infoBak[$mk][$msgKey] = $infoBakVal;
                    continue 2;
                }
            }
            $infoBak['未知'][$v['Variable_name']] = $v['Value'];

        }

        var_dump(static::toStr(
            'mysql服务器 常见配置信息'
        ));


        foreach ($sort as $v){

            var_dump(static::toStr(
                "$v",
                $infoBak[$v]
            ));
        }



    }



    /**
     * @note mysql服务器装配置信息  show variables ; 部分信息
     */
    public function variablesInfoTest()
    {

        // 查
        $stmt = $this->conn->prepare("show variables;");

        $stmt->execute();
        $res = $stmt->fetchAll();

        $this->variablesInfoMsg($res);

    }

    




    public function tran()
    {
        /**
         *

        SET autocommit=0;
        SELECT @@autocommit;


        BEGIN;

        SELECT name,role from users where id = 2000;
        update users set role=role+2 where id=2000;

        COMMIT

        ROLLBACK

         */
    }
    
    
}