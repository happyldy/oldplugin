<?php
/**
 * 日 --- ---
 *  d   月份中的第几天，有前导零的 2 位数字 01 到 31
 *  z   年份中的第几天 0 到 365
 *  j       月份中的第几天，没有前导零 1 到 31
 *  S       每月天数后面的英文后缀，2 个字符 st，nd，rd 或者 th。可以和 j 一起用
 *
 * 星期 --- ---
 *  N   ISO-8601 格式数字表示的星期中的第几天; 1（表示星期一）到 7（表示星期天）
 *  w       星期中的第几天，数字表示 0（表示星期天）到 6（表示星期六）
 *  W       ISO-8601 格式年份中的第几周，每周从星期一开始; 例如：42（当年的第 42 周）
 *  D       星期中的第几天，文本表示，3 个字母; 'sun' | 'mon' | 'tue' | 'wed' | 'thu' | 'fri' |'sat'
 *  l       星期几，完整的文本格式（"L"的小写字母）;'sunday' | 'monday' | 'tuesday' | 'wednesday' | 'thursday' |'friday' | 'saturday'
 *
 * 月 --- ---
 *  m   数字表示的月份，有前导零 01 到 12
 *  n       数字表示的月份，没有前导零 1 到 12
 *  t   指定的月份有几天 28 到 31
 *  F       月份，完整的文本格式， 'january' | 'february' | 'march' | 'april' | 'may' | 'june' |'july' | 'august' | 'september' | 'october' | 'november' | 'december'
 *  M       三个字母缩写表示的月份 'jan' | 'feb' | 'mar' | 'apr' | 'may' | 'jun' | 'jul' | 'aug' | 'sep' |'sept' | 'oct' | 'nov' | 'dec'
 *
 * 年 --- ---
 *  Y   4 位数字完整表示的年份 例如：1999 或 2003
 *  y       2 位数字表示的年份 例如：99 或 03
 *  L       是否为闰年 如果是闰年为 1，否则为 0
 *  o       ISO-8601 格式年份数字。这和 Y 的值相同，只除了如果 ISO 的星期数（W）属于前一年或下一年，则用那一年。 Examples: 1999 or 2003
 *
 * 时间 --- ---
 *  a       小写的上午和下午值 am 或 pm
 *  A       大写的上午和下午值 AM 或 PM
 *  B       Swatch Internet 标准时 000 到 999
 *  g       小时，12 小时格式，没有前导零 1 到 12
 *  G       小时，24 小时格式，没有前导零 0 到 23
 *  h       小时，12 小时格式，有前导零 01 到 12
 *  H   小时，24 小时格式，有前导零 00 到 23
 *  i   有前导零的分钟数 00 到 59>
 *  s   秒数，有前导零 00 到 59>
 *  u       毫秒 。需要注意的是 date() 函数总是返回 000000(7.0+ 是毫秒了) 因为它只接受 integer 参数， 而 DateTime::format() 才支持毫秒。  示例: 654321
 *
 * 时区 --- ---
 *  e   时区标识 例如：UTC，GMT，Atlantic/Azores
 *  I       是否为夏令时 如果是夏令时为 1，否则为 0
 *  O       与格林威治时间相差的小时数 例如：+0200
 *  P   与格林威治时间（GMT）的差别，小时和分钟之间有冒号分隔 例如：+02:00
 *  T   本机所在的时区 例如：EST，MDT（【译者注】在 Windows 下为完整文本格式，例如"Eastern Standard Time"，中文版会显示"中国标准时间"）。
 *  Z       时差偏移量的秒数。UTC 西边的时区偏移量总是负的，UTC 东边的时区偏移量总是正的。 -43200 到 43200
 *
 * 完整的日期／时间 --- ---
 *  c       ISO 8601 格式的日期 2004-02-12T15:19:21+00:00
 *  r       RFC 822 格式的日期 例如：Thu, 21 Dec 2000 16:01:07 +0200
 *  U       从 Unix 纪元（January 1 1970 00:00:00 GMT）开始至今的秒数 参见 time()
 *
 *
 *
 *
 */


namespace HappyLin\OldPlugin\SingleClass\Date;


use DateTime as DT, DateTimeZone, DateInterval;
use DateTimeImmutable;


class DateTime extends DT
{

    /**
     *
     *
     * 当 $time 参数是 UNIX 时间戳（例如 @946684800），或者已经包含时区信息（例如 2010-01-28T15:00:00+02:00）的时候， $timezone 参数和当前时区都将被忽略。
     *
     * @param string $time 日期/时间字符串。如果这个参数为字符串 "now" 表示获取当前时间。如果同时指定了 $timezone 参数，那么获取指定时区的当前时间。
     * @param DateTimeZone|null $timezone   DateTimeZone 对象，表示要获取哪个时区的 $time
     * @throws \Exception
     */
    public function __construct($time  = 'now', DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
    }


    /**
     * 返回被修改的 DateTime 对象， 或者在失败时返回 FALSE.
     *
     * 例子 add(new DateInterval('P7Y5M4DT4H3M2S'));
     *
     * @param DateInterval $interval DateInterval 对象。
     * @return DateTime
     */
    public function add(  $interval)
    {
        return parent::add($interval);
    }


    /**
     * 设置 DateTime 对象的日期  ； 大概也没用
     * @param int $year 年
     * @param int $month 月
     * @param int $day 日
     * @return DateTime|void
     */
    public function setDate($year, $month, $day)
    {
        parent::setDate($year, $month, $day);
    }


    /**
     * 设置 DateTime 对象的时间
     * @param int $hour 时
     * @param int $minute 分
     * @param int $second 秒
     * @param int $microsecond 微秒
     * @return false|DateTime
     */
    public function setTime($hour, $minute, $second = 0, $microsecond = 0)
    {
        return parent::setTime($hour, $minute, $second, $microsecond);
    }


    /**
     * 按时间戳修改日期
     * @param int $timestamp
     * @return DateTime
     */
    public function setTimestamp($timestamp)
    {
        return parent::setTimestamp($timestamp);
    }


    /**
     * 设置时区
     * @param DateTimeZone $timezone DateTimeZone 对象，表示要设置为时区。
     * @return DateTime
     */
    public function setTimezone( $timezone):DateTime
    {
        return parent::setTimezone($timezone); // TODO: Change the autogenerated stub
    }


    /**
     * 按年周修改日期
     * @param int $year 年
     * @param int $week 周
     * @param int $dayOfWeek 从周的第一天计算，日在一周内的偏移量。
     * @return DateTime|void
     */
    public function setISODate($year, $week, $dayOfWeek = 1)
    {
        parent::setISODate($year, $week, $dayOfWeek);
    }




    /**
     * 两个 DateTime 对象之间的差异。返回为 DateInterval对象
     * @param DateTimeInterface $targetObject 要比较的日期。
     * @param bool $absolute [可选] 是否返回绝对差值。
     * @return DateInterval|false  DateInterval 对象表示两个日期之间的差异或者在失败时返回 FALSE。
     */
    public function diff( $targetObject, $absolute = false)
    {
        return parent::diff($targetObject, $absolute);
    }



    /**
     * 返回时区偏移量 秒
     *
     * @return int 返回时区偏移量 秒
     */
    public function getOffset()
    {
        return parent::getOffset();
    }


    /**
     *  修改日期时间对象的值  (+month)加月有危险，不建议使用
     * 例子：
     * modify('+1day +12second')
     *
     * @param string $modifier 日期/时间字符串。正确格式的说明详见 日期与时间格式。
     * @return false|DateTime|void
     */
    public function modify($modifier)
    {
        parent::modify($modifier);
    }











    /**
     * 将 time 参数给定的日期时间字符串，根据 format 参数给定的格式解析为一个新的 DateTime 对象。
     * 如果在格式字符串中包含不可识别的字符，那么会导致解析失败，并且在返回的结构中附加一个错误信息。可以通过 DateTime::getLastErrors() 来探查解析是否存在错误。
     *
     *  $format
     *  |   将尚未被解析的字段，也即格式字符串中未明确指定的字段（年、月、日、时、分、秒、微秒以及时区）重置到 Unix Epoch 时间。  例如：'!d' 只存天
     *  !   将所有的字段（年、月、日、时、分、秒、微秒以及时区）重置到 Unix Epoch 时间。例如： 'j-M-Y|'  时分秒都为0
     *
     * @param string $format 在解析日期时间字符串的时候使用的格式 string。大部分格式和 date() 函数中的格式是一致的。
     * @param string $time 用来表示日期时间的字符串。
     * @param DateTimeZone $timezone DateTimeZone 对象，表示在解析日期时间字符串的时候需要使用的时区。
     * @return DateTime 返回一个 DateTime 对象。 或者在失败时返回 FALSE。
     */
    public static function createFromFormat(  $format,  $time, $timezone = null) : DT
    {
        if($timezone){
            return parent::createFromFormat($format, $time, $timezone);
        }
        return parent::createFromFormat($format, $time);
    }




//    /**
//     * 返回封装给定DateTimeImmutable对象的新DateTime对象  感觉没啥用，不看了
//     * @param DateTimeImmutable $object
//     * @return DT|void
//     */
//    public static function createFromImmutable(DateTimeImmutable $object)
//    {
//        return parent::createFromImmutable($object); // TODO: Change the autogenerated stub
//    }


    /**
     * 返回在解析日期时间字符串的过程中发生的警告和错误信息。
     * @return array|void
     */
    public static function getLastErrors()
    {
        return parent::getLastErrors(); // TODO: Change the autogenerated stub
    }

}






