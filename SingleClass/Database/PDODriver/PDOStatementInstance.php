<?php
/**
 * PDOStatement类重写
 * PDOInstance类中 prepare和query方法的返回对象；
 *
 */

namespace HappyLin\OldPlugin\SingleClass\Database\PDODriver;

use PDO,PDOStatement;

class PDOStatementInstance 
{

    public $PDOStatement;

    /**
     *
     *
     *
     */
    public function __construct(PDOStatement $PDOStatement)
    {
        $this->PDOStatement = $PDOStatement;
    }

    

    /**
     * 安排一个特定的变量绑定到一个查询结果集中给定的列。每次调用 PDOStatement::fetch() 或 PDOStatement::fetchAll() 都将更新所有绑定到列的变量。
     *
     * fetch方法获取数据才有用，模式为：
     * PDO::FETCH_BOUND(integer) 指定获取方式，返回 TRUE 且将结果集中的列值分配给通过 PDOStatement::bindParam() 或 PDOStatement::bindColumn() 方法绑定的 PHP 变量。
     *
     * @param mixed $column 结果集中的列号（从1开始索引）或列名。如果使用列名，注意名称应该与由驱动返回的列名大小写保持一致。
     * @param mixed $param 将绑定到列的 PHP 变量名称
     * @param int $type 通过 PDO::PARAM_* 常量指定的参数的数据类型。
     * @param int $maxlen 预分配提示。
     * @param mixed $driverdata 驱动的可选参数。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public function bindColumn( $column,  &$param, int $type = null, int $maxlen = null, $driverdata = null) : bool
    {
        return $this->PDOStatement->bindColumn($column,$param, $type, $maxlen, $driverdata);
    }


    /**
     * 绑定一个PHP变量到用作预处理的SQL语句中的对应命名占位符或问号占位符。 不同于 PDOStatement::bindValue() ，此变量作为引用被绑定，并只在 PDOStatement::execute() 被调用的时候才取其值。
     *
     * 大多数参数是输入参数，即，参数以只读的方式用来建立查询。一些驱动支持调用存储过程并作为输出参数返回数据，一些支持作为输入/输出参数，既发送数据又接收更新后的数据。
     *
     *
     * @param mixed $parameter 参数标识符。对于使用命名占位符的预处理语句，应是类似 :name 形式的参数名。对于使用问号占位符的预处理语句，应是以1开始索引的参数位置。
     * @param mixed $variable 绑定到 SQL 语句参数的 PHP 变量名。
     * @param int $data_type 使用 PDO::PARAM_* 常量明确地指定参数的类型。要从一个存储过程中返回一个 INOUT 参数，需要为 data_type 参数使用按位或操作符去设置 PDO::PARAM_INPUT_OUTPUT 位。
     * @param int $length 数据类型的长度。为表明参数是一个存储过程的 OUT 参数，必须明确地设置此长度。
     * @param mixed $driver_options 
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public function bindParam( $parameter, &$variable, int $data_type = PDO::PARAM_STR, int $length = null, $driver_options=null ) : bool
    {
        return $this->PDOStatement->bindParam($parameter,$variable, $data_type, $length, $driver_options);
    }


    /**
     * 把一个值绑定到一个参数
     *
     * @param mixed $parameter 参数标识符。对于使用命名占位符的预处理语句，应是类似 :name 形式的参数名。对于使用问号占位符的预处理语句，应是以1开始索引的参数位置。
     * @param mixed $value 绑定到参数的值
     * @param int $data_type 使用 PDO::PARAM_* 常量明确地指定参数的类型。
     * @return bool
     */
    public function bindValue($parameter, $value, int $data_type = PDO::PARAM_STR ) : bool
    {
        return $this->PDOStatement->bindValue($parameter, $value, $data_type);
    }




    /**
     * 执行预处理过的语句。如果预处理过的语句含有参数标记，必须选择下面其中一种做法：
     * ◦调用 PDOStatement::bindParam() 绑定 PHP 变量到参数标记：如果有的话，通过关联参数标记绑定的变量来传递输入值和取得输出值
     * ◦或传递一个只作为输入参数值的数组
     *
     * @param array $input_parameters 一个元素个数和将被执行的 SQL 语句中绑定的参数一样多的数组。所有的值作为 PDO::PARAM_STR 对待。不能绑定多个值到一个单独的参数；比如，不能绑定两个值到 IN（）子句中一个单独的命名参数。绑定的值不能超过指定的个数。如果在 input_parameters 中存在比 PDO::prepare() 预处理的SQL 指定的多的键名，则此语句将会失败并发出一个错误。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public function execute(array $input_parameters = null) : bool
    {
        return $this->PDOStatement->execute($input_parameters);
    }





    /**
     * 从结果集中获取下一行
     *
     * 参数
     * fetch_style
     *  控制下一行如何返回给调用者。此值必须是 PDO::FETCH_* 系列常量中的一个，缺省为 PDO::ATTR_DEFAULT_FETCH_MODE 的值 （默认为 PDO::FETCH_BOTH ）。
     *
     *      PDO::FETCH_LAZY：将结果集中的每一行作为一个对象返回，此对象的变量名对应着列名。结合使用 PDO::FETCH_BOTH 和 PDO::FETCH_OBJ，创建供用来访问的对象变量名;在 PDOStatement::fetchAll() 中无效。
     *
     *      PDO::FETCH_ASSOC：返回一个索引为结果集列名的数组; 将对应结果集中的每一行作为一个由列名索引的数组返回。如果结果集中包含多个名称相同的列，则PDO::FETCH_ASSOC每个列名只返回一个值。
     *
     *      PDO::FETCH_NAMED 指定获取方式，将对应结果集中的每一行作为一个由列名索引的数组返回。如果结果集中包含多个名称相同的列，则PDO::FETCH_ASSOC每个列名 返回一个包含值的数组。
     *
     *      PDO::FETCH_NUM：返回一个索引为以0开始的结果集列号的数组;将对应结果集中的每一行作为一个由列号索引的数组返回，从第 0 列开始。
     *
     *      PDO::FETCH_BOTH（默认）：返回一个索引为结果集列名和以0开始的列号的数组; 将对应结果集中的每一行作为一个由列号和列名索引的数组返回，从第 0 列开始。
     * 
     *      PDO::FETCH_OBJ：返回一个属性名对应结果集列名的匿名对象
     *
     *      PDO::FETCH_BOUND：返回 TRUE ，并分配结果集中的列值给 PDOStatement::bindColumn() 方法绑定的 PHP 变量。
     *
     *      PDO::FETCH_COLUMN 指定获取方式，从结果集中的下一行返回所需要的那一列。 通过指定 column-index 参数获取想要的列。
     *
     *      PDO::FETCH_CLASS：返回一个请求类的新实例，映射结果集中的列名到类中对应的属性名。如果 fetch_style 包含 PDO::FETCH_CLASSTYPE（例如：PDO::FETCH_CLASS |PDO::FETCH_CLASSTYPE），则类名由第一列的值决定
     *
     *      PDO::FETCH_INTO：更新一个被请求类已存在的实例，映射结果集中的列到类中命名的属性
     *
     *      PDO::FETCH_FUNC  允许在运行中完全用自定义的方式处理数据。（仅在 PDOStatement::fetchAll() 中有效）。
     *
     *      PDO::FETCH_GROUP  根据值分组返回。通常和 PDO::FETCH_COLUMN 或 PDO::FETCH_KEY_PAIR 一起使用。
     *
     *      PDO::FETCH_UNIQUE 只取唯一值。
     *
     *      PDO::FETCH_KEY_PAIR 获取一个有两列的结果集到一个数组，其中第一列为键名，第二列为值。自 PHP 5.2.3 起可用。
     *
     *      PDO::FETCH_CLASSTYPE  根据第一列的值确定类名。
     *
     *      PDO::FETCH_SERIALIZE  类似 PDO::FETCH_INTO ，但是以一个序列化的字符串表示对象。
     *
     *      PDO::FETCH_PROPS_LATE  设置属性前调用构造函数。自 PHP 5.2.0 起可用。
     *
     *
     * cursor_orientation
     *   对于 一个 PDOStatement 对象表示的可滚动游标，该值决定了哪一行将被返回给调用者。此值必须是 PDO::FETCH_ORI_* 系列常量中的一个，默认为 PDO::FETCH_ORI_NEXT。
     *   要想让 PDOStatement 对象使用可滚动游标，必须在用 PDO::prepare() 预处理SQL语句时，设置 PDO::ATTR_CURSOR 属性为 PDO::CURSOR_SCROLL。
     *      PDO::FETCH_ORI_NEXT(integer) 在结果集中获取下一行。仅对可滚动游标有效。
     *      PDO::FETCH_ORI_PRIOR(integer) 在结果集中获取上一行。仅对可滚动游标有效。
     *      PDO::FETCH_ORI_FIRST(integer) 在结果集中获取第一行。仅对可滚动游标有效。
     *      PDO::FETCH_ORI_LAST(integer) 在结果集中获取最后一行。仅对可滚动游标有效。
     *      PDO::FETCH_ORI_ABS(integer) 根据行号从结果集中获取需要的行。仅对可滚动游标有效。
     *      PDO::FETCH_ORI_REL(integer) 根据当前游标位置的相对位置从结果集中获取需要的行。仅对可滚动游标有效。
     *
     * offset
     * 对于一个 cursor_orientation 参数设置为 PDO::FETCH_ORI_ABS 的PDOStatement 对象代表的可滚动游标，此值指定结果集中想要获取行的绝对行号。
     * 对于一个 cursor_orientation 参数设置为 PDO::FETCH_ORI_REL 的PDOStatement 对象代表的可滚动游标，此值指定想要获取行相对于调用 PDOStatement::fetch() 前游标的位置
     *
     *
     * @param int $fetch_style 从一个 PDOStatement 对象相关的结果集中获取下一行。fetch_style 参数决定 POD 如何返回行。
     * @param int $cursor_orientation
     * @param int $cursor_offset
     * @return mixed 此函数（方法）成功时返回的值依赖于提取类型。在所有情况下，失败都返回 FALSE 。
     */
    public function fetch( int $fetch_style = null, int $cursor_orientation = PDO::FETCH_ORI_NEXT, int $cursor_offset = 0 )
    {
        return $this->PDOStatement->fetch($fetch_style, $cursor_orientation, $cursor_offset);
    }


    

    /**
     * 返回一个包含结果集中所有行的数组
     *
     * 参数
     *
     *
     * fetch_style
     *  控制返回数组的内容如同 PDOStatement::fetch() 文档中记载的一样。默认为 PDO::ATTR_DEFAULT_FETCH_MODE 的值（ 其缺省值为 PDO::FETCH_BOTH ）
     *
     *  想要返回一个包含结果集中单独一列所有值的数组，需要指定 PDO::FETCH_COLUMN 。通过指定 column-index 参数获取想要的列。
     *
     *  想要获取结果集中单独一列的唯一值，需要将 PDO::FETCH_COLUMN 和 PDO::FETCH_UNIQUE 按位或。
     *
     *  想要返回一个根据指定列把值分组后的关联数组，需要将 PDO::FETCH_COLUMN 和 PDO::FETCH_GROUP 按位或。
     * fetch_argument
     *  根据 fetch_style 参数的值，此参数有不同的意义：
     *
     * ◦ PDO::FETCH_COLUMN：返回指定以0开始索引的列。
     *
     * ◦ PDO::FETCH_CLASS：返回指定类的实例，映射每行的列到类中对应的属性名。
     *
     * ◦ PDO::FETCH_FUNC：将每行的列作为参数传递给指定的函数，并返回调用函数后的结果。
     *
     * ctor_args
     *  当 fetch_style 参数为 PDO::FETCH_CLASS 时，自定义类的构造函数的参数
     *
     * @param int $fetch_style 从一个 PDOStatement 对象相关的结果集中获取下一行。fetch_style 参数决定 POD 如何返回行。默认为 PDO::ATTR_DEFAULT_FETCH_MODE 的值（ 其缺省值为 PDO::FETCH_BOTH ）
     * @param mixed $fetch_argument
     * @param array $ctor_args 当 fetch_style 参数为 PDO::FETCH_CLASS 时，自定义类的构造函数的参数。
     * @return array
     */
    public function fetchAll(int $fetch_style = PDO::FETCH_NAMED,  $fetch_argument = null, array $ctor_args = array() )
    {
        if(!empty($fetch_argument)){
            return $this->PDOStatement->fetchAll($fetch_style,$fetch_argument,$ctor_args);
        }
        return $this->PDOStatement->fetchAll($fetch_style);
    }
        



    /**
     * 从结果集中的下一行返回单独的一列，如果没有了，则返回 FALSE 。
     *
     * @param int $column_number 你想从行里取回的列的索引数字（以0开始的索引）。
     * @return string 从结果集中的下一行返回单独的一列; fetchColumn() 取回数据，则没有办法返回同一行的另外一列。
     */
    public function fetchColumn(int $column_number = 0)
    {
        return $this->PDOStatement->fetchColumn($column_number);
    }


    /**
     * 获取下一行并作为一个对象返回。此函数（方法）是使用 PDO::FETCH_CLASS 或 PDO::FETCH_OBJ 风格的 PDOStatement::fetch() 的一种替代。
     * @param string $class_name 创建类的名称
     * @param array $ctor_args 此数组的元素被传递给构造函数。
     * @return mixed 返回一个属性名对应于列名的所要求类的实例， 或者在失败时返回 FALSE.
     */
    public function fetchObject(string $class_name = "stdClass", array $ctor_args )
    {
        return $this->PDOStatement->fetchObject($class_name, $ctor_args);
    }






    /**
     * 返回由 PDOStatement 对象代表的结果集中的列数。
     *
     * 如果是由 PDO::query() 返回的 PDOStatement 对象，则列数计算立即可用。
     * 如果是由 PDO::prepare() 返回的 PDOStatement 对象，则在调用 PDOStatement::execute() 之前都不能准确地计算出列数。
     * @return int 返回由 PDOStatement 对象代表的结果集中的列数。如果没有结果集，则 PDOStatement::columnCount() 返回 0。
     */
    public function columnCount() : int
    {
        return $this->PDOStatement->columnCount();
    }


    /**
     * 返回上一个由对应的 PDOStatement 对象执行DELETE、 INSERT、或 UPDATE 语句受影响的行数。
     *
     * 如果上一条由相关 PDOStatement 执行的 SQL 语句是一条 SELECT 语句，有些数据可能返回由此语句返回的行数。但这种方式不能保证对所有数据有效，且对于可移植的应用不应依赖于此方式。
     *
     * @return int
     */
    public function rowCount() : int
    {
        return $this->PDOStatement->rowCount();
    }



    /**
     * closeCursor() 释放到数据库服务的连接，以便发出其他 SQL 语句，但使语句处于一个可以被再次执行的状态。
     *
     * 当上一个执行的 PDOStatement 对象仍有未取行时，此方法对那些不支持再执行一个 PDOStatement 对象的数据库驱动非常有用。 如果数据库驱动受此限制，则可能出现失序错误的问题。
     *
     * closeCursor() 要么是一个可选驱动的特有方法（效率最高）来实现，要么是在没有驱动特定的功能时作为一般的PDO 备用来实现。一般的备用语义上与下面的 PHP 代码相同：
     *
     * @return bool
     */
    public function closeCursor() : bool
    {
        return $this->PDOStatement->closeCursor();
    }


    /**
     * 为语句设置默认的获取模式。
     *
     * PDOStatement::setFetchMode( int $mode) : bool
     *
     * PDOStatement::setFetchMode( int $PDO::FETCH_COLUMN, int $colno) : bool
     *
     * PDOStatement::setFetchMode( int $PDO::FETCH_CLASS, string $classname, array $ctorargs) : bool
     *
     * PDOStatement::setFetchMode( int $PDO::FETCH_INTO, object $object) : bool
     *
     * @param int $model 获取模式必须是 PDO::FETCH_* 系列常量中的一个。
     * @param mixed $classname(string)|$colno(int)|$object(object)  类名|列号|对象
     * @param array $ctorargs 构造函数参数。
     * @return bool
     */
    public function setFetchMode(int $model, $classname=null, array $ctorargs=[]) : bool
    {
//        if(!empty($classname)){
//            return $this->PDOStatement->setFetchMode($model, $classname=null,$ctorargs);
//        }
        return $this->PDOStatement->setFetchMode($model, $classname,$ctorargs);
    }


    /**
     * 打印一条 SQL 预处理命令
     * 打印出一条预处理语句包含的信息。提供正在使用的 SQL 查询、所用参数（Params）的数目、参数的清单、参数名、用一个整数表示的参数类型（paramtype）、键名或位置、值、以及在查询中的位置（如果当前 POD 驱动不支持，则为-1）。
     *
     * @return bool
     */
    public function debugDumpParams():void
    {
        $this->PDOStatement->debugDumpParams();
    }

    /**
     * 获取跟上一次语句句柄操作相关的 SQLSTATE
     * @return string 与 PDO::errorCode() 相同，只是 PDOStatement::errorCode() 只取回 PDOStatement 对象执行操作中的错误码。
     */
    public function errorCode():string
    {
        return $this->PDOStatement->errorCode();
    }
    
    
    /**
     * @return array
     */
    public function errorInfo() : array
    {
        return $this->PDOStatement->errorInfo();
    }



    /**
     * 在一个多行集语句句柄中推进到下一个行集
     *
     * 一些数据库服务支持返回一个以上行集（也被称为结果集）的存储过程。PDOStatement::nextRowset() 使你能够结合一个 PDOStatement 对象访问第二个以及后续的行集。上述的每个行集可以有不同的列集合。
     *
     * @return bool
     */
    public function nextRowset() : bool
    {
        return $this->PDOStatement->nextRowset();
    }



    /**
     * 得到语句的一个属性。当前，不存在通用的属性，只有驱动特定的属性：◦PDO::ATTR_CURSOR_NAME （Firebird 和 ODBC 特性）：获取 UPDATE ... WHERE CURRENT OF 的游标名称。
     *
     * @param int $attribute
     */
    public function getAttribute( int $attribute)
    {
        return $this->PDOStatement->getAttribute($attribute);
    }

    /**
     * 给语句设置一个属性。当前，没有通用的属性可以设置，只有驱动特定的属性：PDO::ATTR_CURSOR_NAME （Firebird 和 ODBC 特性）：为 UPDATE ... WHERE CURRENT OF 设置游标名称。
     *
     * @param int $attribute
     * @param mixed $value
     * @return bool
     */
    public function setAttribute(int $attribute, $value) : bool
    {
        return $this->PDOStatement->setAttribute($attribute, $value);
    }


}






