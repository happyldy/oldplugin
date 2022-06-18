<?php


namespace HappyLin\OldPlugin\Test\MathematicalTest;

use HappyLin\OldPlugin\SingleClass\Mathematical\BCMath;
use HappyLin\OldPlugin\SingleClass\Mathematical\Math;

use HappyLin\OldPlugin\Test\TraitTest;


class MathTest
{

    use TraitTest;



    public function __construct()
    {

    }

    /**
     * @note 杂项判断数值合法和随机数
     */
    public function mathTest()
    {
        var_dump(static::toStr('判断是否为有限值; 本机浮点数所允许范围中的一个合法的有限值，则返回 TRUE; is_finite(log(0))',is_finite(log(0))));

        var_dump(static::toStr('判断是否为无限值; 超出本平台的浮点数范围的值，则返回 TRUE； is_infinite(log(0))',is_infinite(log(0))));

        var_dump(static::toStr('判断是否为合法数值;不是一个数字（not a number）返回 TRUE; is_nan(acos(1.1))',is_nan(acos(1.1))));

        var_dump(static::toStr('找出最大值; max(4,6,8,5,9,5,1,2)',max(4,6,8,5,9,5,1,2)));
        var_dump(static::toStr('找出最小值; min(array(4,6,8,5,9,5,1,2))',min(array(4,6,8,5,9,5,1,2))));

        var_dump(static::toStr('返回范围为 (0, 1) 的一个伪随机数。 组合线性同余发生器; 本函数的周期等于这两个素数的乘积;lcg_value()',lcg_value()));
        var_dump(static::toStr('返回一个随机整数; rand(1,10)',rand(1,10)));
        var_dump(static::toStr('返回一个更好的随机数;比 libc 提供的 rand() 快四倍;  mt_rand(1,10)',mt_rand(1,10)));
        var_dump(static::toStr('Note: 不再需要用 srand() 或 mt_srand() 给随机数发生器播种，因为现在是由系统自动完成的。这两函数不写了'));


        var_dump(static::toStr('返回调用 rand() 可能返回的最大值; getrandmax()',getrandmax()));

    }


    /**
     * @note 数字计算操作
     */
    public function mathFunTest()
    {
        var_dump(static::toStr('绝对值; abs(-1)',abs(-1)));

        var_dump(static::toStr('进一法取整; ceil(1.23545)',ceil(1.23545)));
        var_dump(static::toStr('舍去法取整; floor(1.93545)',floor(1.93545)));
        var_dump(static::toStr('四舍五入取整; round(1.93545)',round(1.93545)));



        var_dump(static::toStr('除法结果取整; intdiv(999, 100)',intdiv(999, 100)));
        var_dump(static::toStr('除法的浮点数余数; fmod(4, 3)',fmod(4, 3)));
        var_dump(static::toStr('平方根; sqrt(4)',sqrt(4)));

        var_dump(static::toStr('计算 e 的指数,用\'e\'作为自然对数的底 2.718282.; exp(2)',exp(2)));

        var_dump(static::toStr('返回 exp(number) - 1; expm1(2)',expm1(2)));

        var_dump(static::toStr('自然对数; log( float $arg[, float $base = M_E] ); log( 8, 2) => ',log( 8, 2)));
        var_dump(static::toStr('指数表达式; pow( number $base, number $exp) : number; pow( 2, 4) => ',pow( 2, 4)));


        var_dump(static::toStr('得到圆周率值;M_PI/pi() ',pi()));

        var_dump(static::toStr('将角度转换为弧度; deg2rad(45)', deg2rad( 45)));
        var_dump(static::toStr('将弧度数转换为相应的角度数; rad2deg(M_PI_4)', rad2deg( M_PI_4)));

        var_dump(static::toStr('余弦;cos(60) => cos(deg2rad(60)) =>',$cos60 = cos(deg2rad(60))));
        var_dump(static::toStr('反余弦; acos(0.5) =>',acos($cos60)));
        //var_dump(rad2deg(acos($cos60)));


        var_dump(static::toStr('余弦;sin(30) => sin(deg2rad(30)) =>',$sin30 = sin(deg2rad(30))));
        var_dump(static::toStr('反正弦; asin(0.5) =>',asin($sin30)));
        //var_dump(rad2deg(asin($sin30)));

        var_dump(static::toStr('正切;tan(deg2rad(45)) =>',$tan45 = tan(deg2rad(45))));
        var_dump(static::toStr('反正切; atan(1) =>',atan($tan45)));






        $other = [
            '直角三角形的斜边长度; hypot( float $x, float $y) : float;  等同于 sqrt(x*x + y*y)。',
            '以 10 为底的对数; log10( float $arg) : float',
            '返回 log(1 + number); log1p( float $number) : float',

            '双曲余弦         cosh( float $arg) : float',
            '反双曲余弦       acosh( float $arg) : float',

            '双曲正弦         sinh( float $arg) : float',
            '反双曲正弦       asinh( float $arg) : float',

            '双曲正切         tanh( float $arg) : float',
            '反双曲正切       atanh( float $arg) : float',

            '两个参数的反正切  atan2( float $y, float $x) : float',
        ];

        var_dump(static::toStr('其他函数',$other));

    }

    /**
     * @note 进制转换
     */
    public function mathBinConversionTest()
    {
        var_dump(static::toStr('在任意进制之间转换数字; 返回字符串', Math::baseConvert('7f', 16, 10)));


        var_dump(static::toStr('十进制转换为二进制', decbin(127)));
        $binary = Math::baseConvert('7f', 16, 2);
        var_dump(static::toStr('二进制转换为十进制; 参数必须是字符', Math::bindec($binary)));


        var_dump(static::toStr('十进制转换为十六进制', dechex(127)));
        var_dump(static::toStr('十六进制转换为十进制', hexdec('7f')));

        var_dump(static::toStr('十进制转换为八进制', decoct(127)));
        var_dump(static::toStr('八进制转换为十进制', octdec (177)));

    }


    /**
     * @note 高精度计算
     */
    public function BCMathTest()
    {
        var_dump(static::toStr('设置所有bc数学函数的默认小数点保留位数; 22 ', BCMath::bcscale(22)));

        var_dump(static::toStr('比较两个任意精度的数字;  1.11111111111111111111  1.11111111111111111112  ', BCMath::bccomp('1.11111111111111111111', '1.11111111111111111112', 22)));
        var_dump(static::toStr('任意精度数字的加法计算; ', BCMath::bcadd('1.11111111111111111111', '1.11111111111111111112', 22)));
        var_dump(static::toStr('2个任意精度数字的减法; 1.11111111111111111112 - 1.11111111111111111111 =》  ', BCMath::bcsub('1.11111111111111111112', '1.11111111111111111111', 22)));


        var_dump(static::toStr('2个任意精度数字乘法计算; 12.014545 * 4.64611564 =》 ', BCMath::bcdiv('12.014545', '4.64611564', 22)));

        var_dump(static::toStr('2个任意精度的数字除法计算; 105/6.55957 =》 ', BCMath::bcdiv('105', '6.55957', 22)));


        var_dump(static::toStr('对一个任意精度数字取模(余数);  12.014545 % 4.64611564 =》', BCMath::bcmod('12.014545', '4.64611564')));


        var_dump(static::toStr('任意精度数字的二次方根;  5 ^ 2 =》', BCMath::bcsqrt('4', 22)));

        var_dump(static::toStr('任意精度数字的乘方;乘方根被转成 int 了！！  4 ^ 3 =》', BCMath::bcpow('4.2', '3', 2)));



        var_dump(static::toStr('将任意精度的数字提高到另一个，减少指定的模数; bcpowmod();'));





    }

}

