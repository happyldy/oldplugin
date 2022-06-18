<?php
/**
 * 一个预编译 SQL 语句。
 *
 *  mysqli_stmt::__construct( mysqli $link[, string $query] )
 *  $query，作为字符串。 如果省略此参数，则构造函数的行为与 mysqli_stmt_init() 相同，如果提供，则其行为与 mysqli_prepare() 相同。
 *
 *  它就是本函数的mysqliStmt
 *
 *
 */

namespace HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver;

use HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver\MysqliResult;

use mysqli_stmt,mysqli_result;



class MysqliSTML
{

    
    
    public $mysqliStmt;

    public function __construct(mysqli_stmt $mysqliStmt)
    {

        $this->mysqliStmt = $mysqliStmt;
    }




    /**
     * 准备要执行的 SQL 语句
     * 在执行语句或获取行之前，必须使用 mysqli_stmt_bind_param() 和/或 mysqli_stmt_bind_result() 将参数标记绑定到应用程序变量。
     * query
     *  Note:
     *      不需要在语句末尾增加分号（;）或者 \g 结束符。
     *      SQL 语句中可以包含一个或者多个问号（?）表示语句的参数。
     *  Note:
     *      SQL 语句中，仅允许在特定的位置出现问号参数占位符。例如，在 INSERT 语句中的 VALUES() 子句中可以使用参数占位符，来表示对应列的值。也可以在 WHERE 字句中使用参数来表示要进行比较的值。
     *      但是，并不是所有的地方都允许使用参数占位符，例如对于表名、列名这样的 SQL 语句中的标识位置，就不可以使用参数占位。 SELECT 语句中的列名就不可以使用参数。
     *      另外，对于 = 这样的逻辑比较操作也不可以在两侧都使用参数，否则服务器在解析 SQL 的时候就不知道该如何检测参数类型了。也不可以在 NULL 条件中使用问号，也就是说不可以写成：? IS NULL。
     *      一般而言，参数也只能用在数据操作（DML）语句中，不可以用在数据定义（DDL）语句中。
     *
     * @param string $query
     */
    public function prepare( string $query)
    {
        return $this->mysqliStmt->prepare($query);
    }





    /**
     * 为传递给 mysqli_prepare() 的 SQL 语句中的参数标记绑定变量。
     *
     * 如果变量的数据大小超过最大值。 允许的数据包大小（max_allowed_packet），您必须在类型中指定 b 并使用 mysqli_stmt_send_long_data() 以数据包的形式发送数据。
     *
     * 将 mysqli_stmt_bind_param() 与 call_user_func_array() 结合使用时必须小心。 请注意，mysqli_stmt_bind_param() 要求通过引用传递参数，而 call_user_func_array() 可以接受可以表示引用或值的变量列表作为参数。
     *
     * @param string $types 包含一个或多个字符的字符串，用于指定相应绑定变量的类型: i:整数; d:double; s:字符串; b:blob将在数据包中发送
     * @param mixed $var  变量的数量和字符串类型的长度必须与语句中的参数匹配。
     * @param mixed ...$vars
     * @return bool
     */
    public function bindParam(string $types,  &$var, &...$vars) : bool
    {
        return $this->mysqliStmt->bind_param($types,  $var, ...$vars);
    }


    /**
     * 执行先前使用 mysqli_prepare() 函数准备好的查询。 执行时，存在的任何参数标记将自动替换为适当的数据。
     * 如果语句是 UPDATE、DELETE 或 INSERT，则可以使用 mysqli_stmt_affected_rows() 函数确定受影响的总行数。 同样，如果查询产生结果集，则使用 mysqli_stmt_fetch() 函数。
     * 使用mysqli_stmt_execute（）时，在执行任何其他查询之前，必须使用mysqli_stmt_fetch（）函数获取数据。
     *
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public function execute() : bool
    {
        return $this->mysqliStmt->execute();
    }





    /**
     * 将结果集中的列绑定到变量。
     *
     * 当调用 mysqli_stmt_fetch() 获取数据时，MySQL 客户端/服务器协议将绑定列的数据放入指定的变量 var/vars 中。
     * 请注意，所有列必须在 mysqli_stmt_execute() 之后和调用 mysqli_stmt_fetch() 之前进行绑定。根据列类型绑定变量可以静默更改为相应的 PHP 类型。
     * 即使在部分检索了结果集之后，也可以随时绑定或重新绑定列。 新绑定在下次调用 mysqli_stmt_fetch() 时生效。
     *
     * @param mixed $var
     * @param mixed ...$vars
     * @return bool
     */
    public function bindResult( &$var, &...$vars) : bool
    {
        return $this->mysqliStmt->bind_result($var, ...$vars);
    }

    /**
     * 从准备好的语句中获取结果到由 mysqli_stmt_bind_result() 绑定的变量中。
     * 请注意，在调用 mysqli_stmt_fetch() 之前，所有列都必须由应用程序绑定。
     * 数据在不调用 mysqli_stmt_store_result() 的情况下无缓冲传输，这会降低性能（但会降低内存成本）。
     *
     * @return bool
     */
    public function fetch()
    {
        return $this->mysqliStmt->fetch();
    }


    /**
     * 从准备好的语句传输结果集
     *
     * 您必须为每个成功生成结果集（SELECT、SHOW、DESCRIBE、EXPLAIN）的查询调用 mysqli_stmt_store_result()，
     * 当且仅当您想缓冲客户端的完整结果集，以便后续的 mysqli_stmt_fetch() 调用返回缓冲 数据。
     *
     * 没有必要为其他查询调用mysqli_stmt_store_result()，但是如果调用了，在所有情况下都不会损害或导致任何显着的性能损失。
     * 您可以通过检查mysqli_stmt_result_metadata()是否返回FALSE来检测查询是否产生了结果集。
     *
     * @return bool
     */
    public function storeResult() : bool
    {
        return $this->mysqliStmt->store_result();
    }



    /**
     * 调用从准备好的语句查询返回结果集。
     * @return mysqli_result 为成功的 SELECT 查询返回结果集，或为其他 DML 查询或失败返回 FALSE。 mysqli_errno() 函数可用于区分两种类型的失败。
     */
    public function getResult()
    {
        $res = $this->mysqliStmt->get_result();
        if($res){
            return new MysqliResult($res);
        }
        return $res;
    }


    /**
     * 从准备好的语句返回结果集元数据
     * 如果传递给 mysqli_prepare() 的语句是生成结果集的语句，则 mysqli_stmt_result_metadata() 返回可用于处理元信息（例如字段总数和单个字段信息）的结果对象。
     *
     * 这个结果集指针可以作为参数传递给任何处理结果集元数据的基于字段的函数，例如：
     *  mysqli_num_fields()
     *  mysqli_fetch_field()
     *  mysqli_fetch_field_direct()
     *  mysqli_fetch_fields()
     *  mysqli_field_count()
     *  mysqli_field_seek()
     *  mysqli_field_tell()
     *  mysqli_free_result()
     *
     * 完成后应该释放结果集结构，您可以通过将其传递给 mysqli_free_result() 来实现
     *
     * @return mysqli_result | false 表示结果对象，如果发生错误则为false。
     */
    public function resultMetadata()
    {
        $res = $this->mysqliStmt->result_metadata();
        if($res){
            return new MysqliResult($res);
        }
        return $res;
    }


    /**
     * 检查上一次调用 mysqli_multi_query() 函数之后，是否还有更多的查询结果集。
     *
     * @return bool
     */
    public function moreResults() : bool
    {
        return $this->mysqliStmt->more_results();
    }



    /**
     * 查找语句结果集中的任意行
     * 此函数只能与通过使用 mysqli_store_result() 或 mysqli_query() 函数获得的缓冲结果一起使用。
     * mysqli_stmt_store_result() 必须在 mysqli_stmt_data_seek() 之前调用。
     * @param int $offset 必须介于零和总行数减一 (0.. mysqli_stmt_num_rows() - 1) 之间。
     */
    public function dataSeek( int $offset) : void
    {
        $this->mysqliStmt->data_seek();
    }

    /**
     * 从多个查询中读取下一个结果
     * mysqli_multi_query() 函数执行之后，为读取下一个结果集做准备，然后可以使用 mysqli_store_result() 或 mysqli_use_result() 函数读取下一个结果集。
     * @return bool
     */
    public function nextResult() : bool
    {
        return $this->mysqliStmt->next_result();
    }




    /**
     * 分块发送数据
     * 允许将参数数据分块（或块）发送到服务器，例如 如果 blob 的大小超过 max_allowed_packet 的大小。可以多次调用此函数以发送列的字符或二进制数据值的一部分，这些部分必须是 TEXT 或 BLOB 数据类型之一。
     *
     * @param int $param_nr 指示与数据关联的参数。 参数从 0 开始编号。
     * @param string $data 包含要发送的数据的字符串。
     * @return bool
     */
    public function sendLongData( int $param_nr, string $data) : bool
    {
        return $this->mysqliStmt->send_long_data($param_nr, $data);
    }





    /**
     * 返回最后执行的语句更改、删除或插入的总行数
     *
     * 此函数仅适用于更新表的查询。 为了从 SELECT 查询中获取行数，请改用 mysqli_stmt_num_rows()。
     *
     * @return int 大于零的整数表示受影响或检索的行数。零表示没有为 UPDATE/DELETE 语句更新的记录、没有与查询中的 WHERE 子句匹配的行或尚未执行任何查询。 -1 表示查询返回错误。NULL 表示提供给函数的参数无效。
     */
    public function affectedRows()
    {
        return $this->mysqliStmt->affected_rows;
    }


    /**
     * 返回结果集中的行数。 mysqli_stmt_num_rows() 的使用取决于您是否使用 mysqli_stmt_store_result() 来缓冲语句句柄中的整个结果集。
     * 如果您使用 mysqli_stmt_store_result()，则可能会立即调用 mysqli_stmt_num_rows()。
     * @return int 一个整数，表示结果集中的行数。
     */
    public function numRows():int
    {
        return $this->mysqliStmt->num_rows();
    }


    /**
     *
     * @return int 返回一个表示参数数量的整数。
     */
    public function param_count():int
    {
        return $this->mysqliStmt->param_count;
    }




    /**
     * 获取上一次 INSERT 操作生成的 ID
     * @return int
     */
    public function insertId():int
    {
        return $this->mysqliStmt->insert_id;
    }


    /**
     * 将客户端和服务器上的已准备语句重置为准备后的状态。
     * 它重置服务器上的语句、使用 mysqli_stmt_send_long_data() 发送的数据、未缓冲的结果集和当前错误。 它不清除绑定或存储的结果集。在执行准备好的语句（或关闭它）时将清除存储的结果集。
     * 要准备带有另一个查询的语句，请使用函数 mysqli_stmt_prepare()。
     *
     * @return bool
     */
    public function reset() : bool
    {
        return $this->mysqliStmt->reset();
    }









    /**
     * 关闭准备好的语句。 mysqli_stmt_close() 还释放语句句柄。 如果当前语句有未决或未读结果，该函数将取消它们，以便执行下一个查询。
     * @return bool
     */
    public function close() : bool
    {
        return $this->mysqliStmt->close();
    }

    /**
     * 释放与语句关联的结果内存，该内存由 mysqli_stmt_store_result() 分配。
     */
    public function freeResult() : void
    {
        $this->mysqliStmt->free_result();
    }







    /**
     *  返回上一次 SQL 操作的 SQLSTATE 错误信息
     * 返回一个包含 SQLSTATE 错误码的字符串，表示上一次 SQL 操作的错误。错误码是由 5 个字符构成，'00000' 表示没有发生错误。错误码是由 ANSI SQL 和 ODBC 定义的，详细的清单请参见：» http://dev.mysql.com/doc/mysql/en/error-handling.html。
     *
     * @return string
     */
    public function sqlstate():string
    {
        return $this->mysqliStmt->sqlstate;
    }

    /**
     * 返回最近调用的可以成功或失败的语句函数的错误代码。
     * 客户端错误消息编号列在 MySQL errmsg.h 头文件中，服务器错误消息编号列在 mysqld_error.h 中。在 MySQL 源代码分发中，您可以在文件 Docs/mysqld_error.txt 中找到错误消息和错误编号的完整列表
     * @return int 错误代码值。 零表示没有发生错误。
     */
    public function errno()
    {
        $this->mysqliStmt->errno;
    }


    /**
     * 返回最近调用的可能成功或失败的语句函数的错误数组。
     * @return array
     */
    public function errorList()
    {
        $this->mysqliStmt->error_list;
    }


    /**
     * 返回一个字符串，其中包含最近调用的可能成功或失败的语句函数的错误消息。
     * @return string
     */
    public function error()
    {
        $this->mysqliStmt->error;
    }


    /**
     * @return int 返回给定语句中的字段数
     */
    public function fieldCount():int
    {
        return $this->mysqliStmt->field_count;
    }

    /**
     * 获取显示警告的结果
     * @return object
     */
    public function getWarnings()
    {
        $this->mysqliStmt->get_warnings();
    }



    /**
     *  用于获取语句属性的当前值
     * @param int $attr
     * @return int 如果未找到该属性，则返回 FALSE，否则返回该属性的值。
     */
    public function attrGet( int $attr)
    {
        $this->mysqliStmt->attr_get($attr);
    }


    /**
     * 用于修改准备好的语句的行为。 可以多次调用此函数来设置多个属性。
     *
     * $attr
     *  要设置的属性。它可以具有以下值之一：
     *  MYSQLI_STMT_ATTR_UPDATE_MAX_LENGTH  设置为 TRUE 会导致 mysqli_stmt_store_result() 更新元数据 MYSQL_FIELD->max_length 值。
     *  MYSQLI_STMT_ATTR_CURSOR_TYPE  调用 mysqli_stmt_execute() 时为语句打开的游标类型。 模式可以是 MYSQLI_CURSOR_TYPE_NO_CURSOR（默认）或 MYSQLI_CURSOR_TYPE_READ_ONLY。
     *  MYSQLI_STMT_ATTR_PREFETCH_ROWS 使用游标时一次从服务器获取的行数。 mode 可以在 1 到 unsigned long 的最大值的范围内。 默认值为 1。
     *
     *
     * 如果您将 MYSQLI_STMT_ATTR_CURSOR_TYPE 选项与 MYSQLI_CURSOR_TYPE_READ_ONLY 一起使用，则当您调用 mysqli_stmt_execute() 时，将为语句打开一个游标。
     *  如果之前的 mysqli_stmt_execute() 调用已经有一个打开的游标，它会在打开一个新游标之前关闭该游标。
     *  mysqli_stmt_reset() 还会在准备语句以重新执行之前关闭任何打开的游标。
     *  mysqli_stmt_free_result() 关闭任何打开的游标。     *
     *
     * 如果为准备好的语句打开游标，则不需要 mysqli_stmt_store_result()。
     *
     * @param int $attr 要设置的属性。
     * @param int $mode 要分配给属性的值
     * @return bool
     */
    public function attrSet( int $attr, int $mode) : bool
    {
        $this->mysqliStmt->attr_set($attr, $mode);
    }

    

}






