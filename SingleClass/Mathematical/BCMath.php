<?php



namespace HappyLin\OldPlugin\SingleClass\Mathematical;



class BCMath
{

    /**
     * 设置所有bc数学函数的默认小数点保留位数
     *
     * @param int $scale  小数点保留位数.
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function bcscale( int $scale) : bool
    {
        return bcscale( $scale);
    }


    /**
     * 比较两个任意精度的数字
     * 把right_operand和left_operand作比较, 并且返回一个整数的结果.
     *
     * @param string $left_operand 左边的运算数, 是一个字符串.
     * @param string $right_operand 右边的运算数, 是一个字符串.
     * @param int $scale 可选的scale参数被用作设置指示数字，在使用来作比较的小数点部分.
     * @return int 如果两个数相等返回0, 左边的数left_operand比较右边的数right_operand大返回1, 否则返回-1.
     */
    public static function bccomp( string $left_operand, string $right_operand, int $scale = 0) : int
    {
        return bccomp(...func_get_args());
    }


    /**
     * 2个任意精度数字的加法计算
     * 左操作数和右操作数求和
     *
     * @param string $left_operand 左操作数，字符串类型
     * @param string $right_operand 右操作数，字符串类型
     * @param int $scale 此可选参数用于设置结果中小数点后的小数位数。也可通过使用 bcscale() 来设置全局默认的小数位数，用于所有函数。如果未设置，则默认为 0。
     * @return string
     */
    public static function bcadd( string $left_operand, string $right_operand, int $scale = 0 ) : string
    {
        return bcadd(...func_get_args());
    }


    /**
     *  2个任意精度数字的减法
     *
     * @param string $left_operand 左操作数，字符串类型
     * @param string $right_operand 右操作数，字符串类型
     * @param int $scale 此可选参数用于设置结果中小数点后的小数位数。也可通过使用 bcscale() 来设置全局默认的小数位数，用于所有函数。如果未设置，则默认为 0。
     * @return string  2个任意精度数字的减法
     */
    public static function bcsub( string $left_operand, string $right_operand, int $scale = 0 ) : string
    {
        return bcsub(...func_get_args());
    }


    /**
     * 2个任意精度数字乘法计算
     *
     * @param string $left_operand 左操作数，字符串类型
     * @param string $right_operand 右操作数，字符串类型
     * @param int $scale 此可选参数用于设置结果中小数点后的小数位数。也可通过使用 bcscale() 来设置全局默认的小数位数，用于所有函数。如果未设置，则默认为 0。
     * @return string 返回结果为字符串类型.
     */
    public static function bcmul( string $left_operand, string $right_operand, int $scale = 0 ) : string
    {
        return bcmul(...func_get_args());
    }



    /**
     * 2个任意精度的数字除法计算
     *
     * @param string $left_operand 左操作数，字符串类型
     * @param string $right_operand 右操作数，字符串类型
     * @param int $scale 此可选参数用于设置结果中小数点后的小数位数。也可通过使用 bcscale() 来设置全局默认的小数位数，用于所有函数。如果未设置，则默认为 0。
     * @return string 返回结果为字符串类型的结果，如果右操作数是0结果为null
     */
    public static function bcdiv( string $left_operand, string $right_operand, int $scale = 0) : string
    {
        return bcdiv(...func_get_args());
    }


    /**
     * 对一个任意精度数字取模
     * 对左操作数使用系数取模
     *
     * @param string $left_operand 对左操作数使用系数取模
     * @param string $modulus 字符串类型系数
     * @return string 返回字符串类型取模后结果，如果系数为0则返回null
     */
    public static function bcmod( string $left_operand, string $modulus) : string
    {
        return bcmod($left_operand, $modulus);
    }


    /**
     * 任意精度数字的二次方根
     *
     * @param string $operand 字符串类型的操作数.
     * @param int $scale 此可选参数用于设置结果中小数点后的小数位数。也可通过使用 bcscale() 来设置全局默认的小数位数，用于所有函数。如果未设置，则默认为 0。
     * @return string 返回二次方根的结果为字符串类型，如果操作数是负数则返回null.
     */
    public static function bcsqrt( string $operand, int $scale = 0 )
    {
        return bcsqrt(...func_get_args());
    }




    /**
     * 任意精度数字的乘方
     *
     * @param string $left_operand 左操作数，字符串类型
     * @param string $right_operand 右操作数，字符串类型
     * @param int $scale 此可选参数用于设置结果中小数点后的小数位数。也可通过使用 bcscale() 来设置全局默认的小数位数，用于所有函数。如果未设置，则默认为 0。
     * @return string 返回结果为字符串类型的结果，如果右操作数是0结果为null
     */
    public static function bcpow( string $left_operand, string $right_operand, int $scale = null ) : string
    {
        return bcpow(...func_get_args());
    }


    /**
     * 将任意精度的数字提高到另一个，减少指定的模数
     * 使用快速求幂方法将基数提高到模数的幂指数。
     *
     * 由于此方法使用模数运算，因此非正整数的数字可能会产生意想不到的结果。
     *
     * @param string $base 基数，作为一个整体设置（即比例必须为零）。
     * @param string $exponent 指数，作为非负整数字符串（即比例必须为零）
     * @param string $modulus 模数，作为一个整数字符串（即比例必须为零）。
     * @param int $scale 此可选参数用于设置结果中小数点后的小数位数。也可通过使用 bcscale() 来设置全局默认的小数位数，用于所有函数。如果未设置，则默认为 0。
     * @return string 以字符串形式返回结果，如果模数为 0 或指数为负，则返回 FALSE。
     */
    public static function bcpowmod( string $base, string $exponent, string $modulus, int $scale = 0 ) : string
    {
        return bcpowmod(...func_get_args());
    }



}

