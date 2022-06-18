<?php
/**
 * 代表从一个数据库查询中获取的结果集。
 *
 */

namespace HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver;




use mysqli_stmt,mysqli_result;


class MysqliResult
{
    
    
    public $mysqliResult;
    

    /**
     * PDOInstance constructor.
     */
    public function __construct(mysqli_result $mysqliResult)
    {
        $this->mysqliResult = $mysqliResult;

    }



    /**
     * 获取结果指针的当前字段偏移量
     *
     * @return int 返回上次mysqli_fetch_field（）调用所使用的字段光标的位置。此值可用作mysqli_field_seek（）的参数。
     */
    public function currentField():int
    {
        return $this->mysqliResult->current_field;
    }



    /**
     * mysqli_data_seek() 函数寻找由结果集中的偏移量指定的任意结果指针。
     * 此函数只能与通过使用 mysqli store_result() 或 mysqli_query() 函数获得的缓冲结果一起使用。
     * @param int $offset 字段偏移量。 必须介于零和行总数减一 (0..mysqli_num_rows() - 1) 之间。
     * @return bool
     */
    public function dataSeek( int $offset) : bool
    {
        return $this->mysqliResult->data_seek($offset);
    }



    /**
     * 以枚举数组的形式获取结果行
     *
     *从结果集中获取一行数据，并将其作为enumeratedarray返回，其中每列存储在从0（零）开始的数组偏移量中。对该函数的后续每次调用都将返回结果集中的下一行，如果没有更多行，则返回NULL。
     *
     * @return mixed mysqli_fetch_row（）返回与获取的行相对应的字符串数组，如果结果集中没有更多行，则返回NULL。
     */
    public function fetchRow()
    {
        return $this->mysqliResult->fetch_row();
    }

    /**
     * 获取结果行作为关联数组
     *
     * 此函数返回的字段名大小写敏感。
     * 此函数将 NULL 字段设置为 PHP NULL 值。
     *
     * @return array 返回与获取的行相对应的关联数组，如果没有更多行，则返回 NULL。
     */
    public function fetchAssoc()
    {
        return $this->mysqliResult->fetch_assoc();
    }


    /**
     * 以关联数组、数值数组或两者的形式获取结果行
     * 此函数返回的字段名大小写敏感。
     * 此函数将 NULL 字段设置为 PHP NULL 值。
     * 如果结果的两列或更多列具有相同的字段名称，则最后一列将优先并覆盖较早的数据。 为了访问具有相同名称的多个列，必须使用该行的数字索引版本。
     *
     * mysqli_fetch_array() 是 mysqli_fetch_row() 函数的扩展版本。 除了将数据存储在结果数组的数字索引中，mysqli_fetch_array() 函数还可以将数据存储在关联索引中，使用结果集的字段名称作为键。
     *
     * $resulttype:通过使用 MYSQLI_ASSOC 常量，该函数的行为将与 mysqli_fetch_assoc() 相同，而 MYSQLI_NUM 的行为将与 mysqli_fetch_row() 函数相同。 最后一个选项 MYSQLI_BOTH 将创建一个具有两者属性的数组。
     *
     * @param int $resulttype 此参数的可能值是常量 MYSQLI_ASSOC、MYSQLI_NUM 或 MYSQLI_BOTH。
     * @return mixed 如果 result 参数表示的结果集没有更多行，则返回与获取的行相对应的数组或 NULL。
     */
    public function fetchArray(int $resulttype = MYSQLI_BOTH)
    {
        return $this->mysqliResult->fetch_array($resulttype);
    }



    /**
     * 将结果集的当前行作为对象返回
     *
     * mysqli_fetch_object() 将返回当前行结果集作为一个对象，其中对象的属性表示在结果集中找到的字段的名称。
     * 请注意，mysqli_fetch_object() 在调用对象构造函数之前设置对象的属性。
     *
     * 此函数返回的字段名大小写敏感。
     * 此函数将 NULL 字段设置为 PHP NULL 值。
     *
     * @param string $class_name 要实例化的类的名称，设置其属性并返回。如果未指定，则返回一个 stdClass 对象。
     * @param array $params  传递给 class_name 对象的构造函数的可选参数数组。
     * @return object 如果结果集中没有更多行，则返回一个对象，该对象具有与获取的行相对应的字符串属性。
     */
    public function fetchObject(string $class_name = "stdClass", $params = [] ) : object
    {
        return $this->mysqliResult->fetch_object($class_name, $params);
    }


    /**
     * mysqli_fetch_all() 获取所有结果行并将结果集作为关联数组、数字数组或两者返回。
     * @param int $resulttype 此可选参数是一个常量，指示应从当前行数据生成什么类型的数组。 此参数的可能值是常量 MYSQLI_ASSOC、MYSQLI_NUM 或 MYSQLI_BOTH。
     * @return mixed 返回包含结果行的关联数组或数字数组。
     */
    public function fetchAll( $resulttype = null )
    {
        return $this->mysqliResult->fetch_all($resulttype);
    }





    /**
     * 获取结果中的字段数
     * @return int 返回指定结果集中的字段数。
     */
    public function fieldCount():int
    {
        return $this->mysqliResult->field_count;
    }


    /**
     * 从指定的结果集中返回一个包含字段定义信息的对象。
     *
     * object
     *  name         列的名称
     *  orgname      如果指定了别名，则为原始列名
     *  table        该字段所属的表名（如果没有计算）
     *  orgtable     原始表名，如果指定了别名
     *  def          该字段的默认值，表示为字符串
     *  max_length   结果集字段的最大宽度。
     *  length       字段的宽度，如表定义中所指定。
     *  charsetnr    字段的字符集编号。
     *  flags        一个整数，表示该字段的位标志。
     *  type         用于该字段的数据类型  MYSQLI_TYPE_*
     *  decimals     使用的小数位数（用于数字字段）
     *
     * @param int $fieldnr 字段编号。 该值必须在 0 到字段数 - 1 的范围内。
     * @return object 返回一个包含字段定义信息的对象，如果没有指定字段的字段信息可用，则返回 FALSE。
     */
    public function fetchFieldDirect( int $fieldnr)
    {
        return $this->mysqliResult->fetch_field_direct($fieldnr);
    }


    /**
     * 返回结果集中的下一个字段
     * 将结果集的一列的定义作为对象返回。 重复调用此函数以检索有关结果集中所有列的信息。
     *
     * name         列的名称
     * orgname      如果指定了别名，则为原始列名
     * table        该字段所属的表名（如果没有计算）
     * orgtable     原始表名，如果指定了别名
     * def          保留为默认值，当前总是 ""
     * db           数据库（自 PHP 5.3.6 起）
     * catalog      目录名，总是“def”（自 PHP 5.3.6 起）
     * max_length   结果集字段的最大宽度。
     * length       字段的宽度，如表定义中所指定。
     * charsetnr    字段的字符集编号。
     * flags        一个整数，表示该字段的位标志。
     * type         用于该字段的数据类型
     * decimals     使用的小数位数（对于整数字段）
     *
     * @return object 返回一个包含字段定义信息的对象，如果没有可用的字段信息，则返回 FALSE。
     */
    public function fetchField()
    {
        return $this->mysqliResult->fetch_field();
    }


    /**
     * 返回表示结果集中字段的对象数组
     * 此函数与 mysqli_fetch_field() 函数具有相同的用途，唯一的区别是，不是为每个字段一次返回一个对象，而是将列作为对象数组返回。
     *
     * name         列的名称
     * orgname      如果指定了别名，则为原始列名
     * table        该字段所属的表名（如果没有计算）
     * orgtable     原始表名，如果指定了别名
     * catalog      目录名，总是“def”（自 PHP 5.3.6 起）
     * max_length   结果集字段的最大宽度。
     * length       字段的宽度，如表定义中所指定。
     * charsetnr    字段的字符集编号。
     * flags        一个整数，表示该字段的位标志。
     * type         用于该字段的数据类型
     * decimals     使用的小数位数（对于整数字段）
     *
     *
     * @return array 返回包含字段定义信息的对象数组，如果没有可用的字段信息，则返回 FALSE。
     */
    public function fetchFields()
    {
        return $this->mysqliResult->fetch_fields();
    }









    /**
     * 将字段光标设置为给定的偏移量。 下一次调用 mysqli_fetch_field() 将检索与该偏移量关联的列的字段定义。
     * 要查找到一行的开头，请将偏移值传递为零。
     * @param int $fieldnr 字段编号。 该值必须在 0 到字段数 - 1 的范围内。
     * @return bool
     */
    public function fieldSeek( int $fieldnr) : bool
    {
        return $this->mysqliResult->field_seek($fieldnr);
    }


    /**
     * 释放与结果相关的内存
     * 当不再需要结果对象时，您应该始终使用 mysqli_free_result() 释放结果。
     *
     * public mysqli_result::close() : void
     * public mysqli_result::free_result() : void
     *
     */
    public function free() : void
    {
         $this->mysqliResult->free();
    }

    public function close() : void
    {
        $this->mysqliResult->close();
    }


    /**
     * 返回结果集中当前行的列长
     * mysqli_fetch_lengths() 函数返回一个数组，其中包含结果集中当前行的每一列的长度。
     * @return array
     */
    public function lengths()
    {
        return $this->mysqliResult->lengths;
    }


    /**
     * 获取结果中的行数
     * mysqli_num_rows() 的行为取决于使用的是缓冲还是未缓冲的结果集。对于未缓冲的结果集，mysqli_num_rows() 将不会返回正确的行数，直到检索到结果中的所有行。
     *
     * @return int 获取结果中的行数
     */
    public function numRows():int
    {
        return $this->mysqliResult->num_rows;
    }



}






