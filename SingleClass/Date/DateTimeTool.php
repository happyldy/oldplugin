<?php
/**
 *
 *
 */


namespace HappyLin\OldPlugin\SingleClass\Date;





trait DateTimeTool
{

    /**
     * 取得一个脚本中所有日期时间函数所使用的默认时区
     *
     * 用 date_default_timezone_set() 函数设定的时区（如果设定了的话）
     * date.timezone 配置选项（如果设定了的话）
     * 如果以上选择都不成功，date_default_timezone_get() 会则返回 UTC 的默认时区。
     *
     * @retrun string
     */
    public static function dateDefaultTimezoneGet(): string
    {
        return date_default_timezone_get();
    }

    /**
     * 设定用于一个脚本中所有日期时间函数的默认时区； 默认北京时间
     *
     * 如果时区不合法则每个对日期时间函数的调用都会产生一条 E_NOTICE 级别的错误信息，如果使用系统设定或 TZ 环境变量则还会产生 E_STRICT 级别的信息。
     *
     * 除了用此函数，你还可以通过 INI 设置 date.timezone 来设置默认时区。
     *
     * @param string $timezone_identifier 时区标识符，例如 UTC 或 Europe/Lisbon。合法标识符列表见所支持的时区列表。
     * @return bool
     */
    public static function dateDefaultTimezoneSet(string $timezone_identifier = 'Asia/Shanghai') : bool
    {
        return date_default_timezone_set( $timezone_identifier);
    }


    /**
     *  格式化一个本地时间／日期
     * 返回将整数 timestamp 按照给定的格式字串而产生的字符串。如果没有给出时间戳则使用本地当前时间。换句话说，timestamp 是可选的，默认值为 time()。
     *
     * 有效的时间戳典型范围是格林威治时间 1901 年 12 月 13 日 20:45:54 到 2038 年 1 月 19 日 03:14:07。（此范围符合 32 位有符号整数的最小值和最大值）。不过在 PHP 5.1 之前此范围在某些系统（如 Windows）中限制为从 1970 年 1 月 1 日到 2038 年 1 月 19 日。
     *
     * 格式字串中不能被识别的字符将原样显示。Z 格式在使用 gmdate() 时总是返回 0。
     *
     * @return string
     */
    public static function date( string $format, int $timestamp=null)
    {
        $timestamp = $timestamp??time();
        return date($format, $timestamp);
    }


    /**
     * 将本地时间日期格式化为整数
     * 和 date() 不同，idate() 只接受一个字符作为 format 参数。
     *
     * @param string $format
     * @param int $timestamp
     * @return int
     */
    public static function idate( string $format, int $timestamp) : int
    {
        $timestamp = $timestamp??time();
        return idate($format, $timestamp);
    }

    /**
     * 返回一个根据 timestamp 得出的包含有日期信息的关联数组 array。如果没有给出时间戳则认为是当前本地时间。
     *
     * 返回的关联数组中的键名单元有以下几个：
     *
     * seconds"     秒的数字表示      0 到 59
     * "minutes"    分钟的数字表示     0 到 59
     * "hours"      小时的数字表示 0 到 23
     * "mday"       月份中第几天的数字表示 1 到 31
     * "wday"       星期中第几天的数字表示 0 (周日) 到 6 (周六)
     * "mon"        月份的数字表示 1 到 12
     * "year"       4 位数字表示的完整年份 比如： 1999 或 2003
     * "yday"       一年中第几天的数字表示 0 到 365
     * "weekday"    星期几的完整文本表示 Sunday 到 Saturday
     * "month"      月份的完整文本表示，比如 January 或 March January 到 December
     * 0            自从 Unix 纪元开始至今的秒数，和 time() 的返回值以及用于 date() 的值类似。  系统相关，典型值为从 -2147483648 到 2147483647。
     *
     * @param int $timestamp 时间戳
     * @return array
     */
    public static function getdate(int $timestamp=null) : array
    {
        $timestamp = $timestamp??time();
        return getdate($timestamp);
    }

    /**
     *  格式化一个 GMT/UTC 日期／时间
     *
     * 同 date() 函数完全一样，只除了返回的时间是格林威治标准时（GMT）。例如当在中国（GMT+0800）运行以下程序时，第一行显示"Jan 01 2000 00:00:00"而第二行显示"Dec31 1999 16:00:00"。
     *
     * echo date("M d Y H:i:s", mktime (0,0,0,1,1,2000));
     * echo gmdate("M d Y H:i:s", mktime (0,0,0,1,1,2000));
     *
     * @param string $format
     * @param int $timestamp
     * @return string
     */
    public static function gmdate( string $format, int $timestamp = null) : string
    {
        $timestamp = $timestamp??time();
        return gmdate( $format,  $timestamp);
    }






    /**
     * 返回自从 Unix 纪元（格林威治时间 1970 年 1 月 1 日 00:00:00）到当前时间的秒数。
     * @return int
     */
    public static function time() : int
    {
        return time();
    }


    /**
     * 将任何字符串的日期时间描述解析为 Unix 时间戳
     *
     * Note:
     * 有效的时间戳通常从 Fri, 13 Dec1901 20:45:54 UTC 到 Tue, 19 Jan 2038 03:14:07 UTC（对应于 32 位有符号整数的最小值和最大值）。
     * PHP 5.1.0 之前，不是所有的平台都支持负的时间戳，那么日记范围就被限制为不能早于 Unix 纪元。这意味着在 1970 年 1 月 1 日之前的日期将不能用在 Windows，一些 Linux 版本，以及几个其它的操作系统中。
     * 在 64 位的 PHP 版本中，时间戳的有效范围实际上是无限的，因为 64 位可以覆盖最多 2930 亿年的范围。
     *
     * Note:
     * 不同的分隔符，比如 m/d/y 或 d-m-y 会影响到解析结果：若以反斜线 (/) 为分隔，将会做为美洲日期 m/d/y 来解析；而当分隔符为短横线 (-) 或点 (.) 时，则将做为欧洲日期 d-m-y 格式来解析。当年份只有两位数字，且分隔符为短横线 (-时，日期字符串将被解析为 y-m-d 格式。
     * 为了避免潜在的歧义，最好使用 ISO 8601 标准格式 (YYYY-MM-DD) 或 DateTime::createFromFormat() 来表达。
     *
     * @param string $datetime 日期/时间字符串。正确格式的说明详见 日期与时间格式。
     * @param int $now 用来计算返回值的时间戳。
     * @return int 成功则返回时间戳，否则返回 FALSE。在 PHP 5.1.0 之前本函数在失败时返回 -1。
     */
    public static function strtotime( string $datetime, int $now = null ) : int
    {
        $now = $now??time();

        return strtotime($datetime,  $now);
    }







    /**
     *  取得一个日期的 Unix 时间戳
     *
     * @param int $hour  date("H")
     * @param int $minute  date("i")
     * @param int $second date("s")
     * @param int $month date("n")
     * @param int $day date("j")
     * @param int $year date("Y")
     * @return int mktime() 根据给出的参数返回 Unix 时间戳。如果参数非法，本函数返回 FALSE（在 PHP 5.1 之前返回 -1）。
     */
    public static function mktime(int $hour, int $minute = null, int $second = null, int $month = null, int $day = null, int $year = null) : int
    {
        $minute = $minute?? date("i");
        $second = $second?? date("s");
        $month = $month?? date("n");
        $day = $day?? date("j");
        $year = $year?? date("Y");

        return mktime($hour, $minute, $second, $month, $day, $year);
    }










    /**
     * microtime() 当前 Unix 时间戳以及微秒数。本函数仅在支持 gettimeofday() 系统调用的操作系统下可用。
     *
     * 如果调用时不带可选参数，本函数以 "msec sec" 的格式返回一个字符串，其中 sec 是自 Unix 纪元（0:00:00 January 1,1970 GMT）起到现在的秒数，msec 是微秒部分。字符串的两部分都是以秒为单位返回的。
     *
     * @param bool $get_as_float 如果给出了 get_as_float 参数并且其值等价于 TRUE，microtime() 将返回一个浮点数。
     * @return string | float
     */
    public static function microtime(bool $get_as_float = false )
    {
        return microtime($get_as_float);
    }



    /**
     * 取得当前时间
     *
     * 本函数是 gettimeofday(2) 的接口。返回一个关联数组，包含有系统调用返回的数据。
     *
     * 数组中的键为：
     * ◦ "sec" - 自 Unix 纪元起的秒数
     * ◦ "usec" - 微秒数
     * ◦ "minuteswest" - 格林威治向西的分钟数
     * ◦ "dsttime" - 夏令时修正的类型
     *
     * @param bool $return_float 当其设为 TRUE 时，会返回一个浮点数而不是一个数组。
     * @return array | float 当其设为 TRUE 时，会返回一个浮点数而不是一个数组。
     */
    public static function gettimeofday(bool $return_float = false)
    {
        return gettimeofday( $return_float);
    }


    /**
     * 从缩写中返回时区名称
     *
     * echo timezone_name_from_abbr("CET") . "\n";   Europe/Berlin
     * echo timezone_name_from_abbr("", 3600, 0) . "\n";    Europe/Paris
     * echo timezone_name_from_abbr("", 3600, 0) . "\n";    'Asia/Shanghai'
     *
     * @param string $abbr 时区缩写。
     * @param int $utcOffset 以秒为单位从 GMT 偏移。 默认为 -1，这意味着返回与 abbr 对应的第一个找到的时区。否则将搜索精确的偏移量，并且只有在未找到时才返回具有任何偏移量的第一个时区。
     * @param int $isDST 夏令时指示器。 默认为-1，表示搜索时不考虑时区是否有夏令时。 如果将其设置为 1，则假定 utcOffset 是有效的夏令时偏移量； 如果为 0，则假定 utcOffset 是一个没有有效夏令时的偏移量。 如果 abbr 不存在，则仅通过 utcOffset 和 isDST 搜索时区。
     * @return string|false 成功时返回时区名称或者在失败时返回 FALSE。
     */
    public static function timezoneNameFromAbbr( string $abbr, int $utcOffset = -1, int $isDST = -1 )
    {
        return timezone_name_from_abbr($abbr, $utcOffset, $isDST);
    }


    /**
     * 获取时区数据库的版本
     * @return string
     */
    public static function timezoneVersionGet() : string
    {
        return timezone_version_get();
    }




    // ············································以下感觉可有可无································


    /**
     * 取得本地时间 和 getdate很像，放弃它
     *
     * $is_associative = true关联数组中不同的键名为：
     *  "tm_sec" - 秒数， 0 到 59
     * ◦ "tm_min" - 分钟数， 0 到 59
     * ◦ "tm_hour" - 小时， 0 到 23
     * ◦ "tm_mday" - 月份中的第几日， 1 到 31
     * ◦ "tm_mon" - 年份中的第几个月， 0 (Jan) 到 11 (Dec)
     * ◦ "tm_year" - 年份，从 1900 开始
     * ◦ "tm_wday" - 星期中的第几天， 0 (Sun) 到 6 (Sat)
     * ◦ "tm_yday" - 一年中的第几天， 0 到 365
     * ◦ "tm_isdst" - 夏令时当前是否生效？  如果是生效的是正数， 0 代表未生效，负数代表未知。
     *
     * @param int $timestamp 可选的 timestamp 参数是一个 integer 的 Unix 时间戳，如未指定，参数值默认为当前本地时间。也就是说，其值默认为 time() 的返回值。
     * @param bool $is_associative 如果设为 FALSE 或未提供则返回的是普通的数字索引数组。如果该参数设为 TRUE 则 localtime() 函数返回包含有所有从 C 的 localtime 函数调用所返回的不同单元的关联数组。关联数组中不同的键名为：
     * @return array
     */
    public static function localtime( int $timestamp = null, bool $is_associative = false ) : array
    {
        $timestamp = $timestamp??time();
        return localtime($timestamp, $is_associative);

    }




    /**
     *  取得 GMT 日期的 UNIX 时间戳
     * 和 mktime() 完全一样，只除了返回值是格林威治标准时的时间戳。
     * Note: gmmktime() 内部使用了 mktime()，因此只有转换成本地时间也合法的时间才能用在其中。
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param int $month
     * @param int $day
     * @param int $year
     * @return int
     */
    public static function gmmktime(int $hour, int $minute = null, int $second = null, int $month = null, int $day = null, int $year = null) : int
    {
        $minute = $minute?? date("i");
        $second = $second?? date("s");
        $month = $month?? date("n");
        $day = $day?? date("j");
        $year = $year?? date("Y");

        return gmmktime($hour, $minute, $second, $month, $day, $year);
    }



    /**
     * 根据区域设置格式化本地时间／日期 像是date格式化日期的加强版，放弃不想 解压用 strptime( string $date, string $format) : array
     *
     * gmstrftime( string $format[, int $timestamp] ) : string  和 strftime() 的行为相同，只除了返回时间是格林威治标准时（GMT）。
     *
     *
     *
     * @param string $format
     * @param int $timestamp
     * @return string
     */
    public static function strftime( string $format, int $timestamp = null ) : string
    {
        $timestamp = $timestamp??time();
        return strftime($format,  $timestamp);
    }






    /**
     * 获取有关根据指定格式格式化的给定日期的信息
     * 与DateTime::createFromFormat()的格式一样，不过一个返回DateTime对象，一个返回数组
     *
     * <\? php
     * $date = "6.1.2009 13:00+01:00";
     * print_r(date_parse_from_format("j.n.Y H:iP", $date));
     * ?>
     * 以上例程会输出：
     * Array
     * (
     *     [year] => 2009
     *     [month] => 1
     *     [day] => 6
     *     [hour] => 13
     *     [minute] => 0
     *     [second] => 0
     *     [fraction] =>
     *     [warning_count] => 0
     *     [warnings] => Array
     *         (
     *         )
     *
     *     [error_count] => 0
     *     [errors] => Array
     *         (
     *         )
     *
     *     [is_localtime] => 1
     *     [zone_type] => 1
     *     [zone] => 3600
     *     [is_dst] =>
     * )
     * 7.2.0 返回数组的 zone 元素现在代表秒而不是分钟，并且它的符号被反转。 例如 -120 现在是 7200。
     *
     * @param string $format DateTime::createFromFormat() 接受的格式。
     * @param string $datetime 表示日期/时间的字符串。
     * @return array
     */
    public static function dateParseFromFormat( string $format, string $datetime) : array
    {
        return date_parse_from_format( $format, $datetime);
    }





    /**
     * 返回具有给定日期/时间详细信息的关联数组
     *
     * print_r(date_parse("2006-12-12 10:00:00.5 +1 week +1 hour"));
     *
     * @param string $datetime DateTime::__construct接受格式的日期/时间。
     * @return array|false
     */
    public static function dateParse( string $datetime)
    {
        return date_parse( $datetime);
    }







    /**
     * 返回一个包含有关日落/日出和黄昏开始/结束信息的数组
     *
     *
     * 成功返回数组或在失败时返回 FALSE。数组结构详列如下：
     *
     *
     *  sunriseThe                      日出的时间戳（天顶角 = 90°35'）
     *  sunsetThe                       日落的时间戳（天顶角 = 90°35'）。
     *  transitThe                      太阳到达顶峰时的时间戳，即到达最高点。
     *  civil_twilight_beginThe         民用黎明的开始（天顶角= 96°）。 它在日出时结束。
     *  civil_twilight_endThe           民用黄昏的结束（天顶角= 96°）。 它从日落开始。
     *  nautical_twilight_beginThe      航海黎明的开始（天顶角 = 102°）。 它在civil_twilight_begin 结束。
     *  nautical_twilight_endThe        航海黄昏的结束（天顶角 = 102°）。 它始于civil_twilight_end。
     *  astronomical_twilight_beginThe  天文黎明的开始（天顶角= 108°）。 它在 nautical_twilight_begin 结束。
     *  astronomical_twilight_endThe    文黄昏的结束（天顶角=108°）。 它从 nautical_twilight_end 开始。
     *
     * 数组元素的值要么是 UNIX 时间戳，如果太阳一整天都在各自的天顶之下，则为 FALSE，如果整日太阳在各自的天顶之上，则为 TRUE。
     *
     * @param int $timestamp 时间戳
     * @param float $latitude 纬度
     * @param float $longitude 经度
     * @return array|false 成功返回数组或在失败时返回 FALSE。
     */
    public static function dateSunInfo( int $timestamp, float $latitude, float $longitude)
    {
        return date_sun_info(  $timestamp,  $latitude,  $longitude);
    }


    /**
     * 返回给定的日期与地点的 日出时间  date_sunset 返回给定的日期与地点的日落时间 没用
     *
     * 例子
     * var_dump(static::date_sunrise(time(),SUNFUNCS_RET_STRING, 26.056334128199182, 119.31024586308608, 90.583333, 1));
     * 结果： 22.55，不准
     *
     *
     * @param int $timestamp
     * @param int $format
     * @param float|string $latitude  ini_get("date.default_latitude")
     * @param float|string $longitude ini_get("date.default_longitude")
     * @param float|string $zenith  ini_get("date.sunrise_zenith")
     * @param float|int $gmt_offset
     * @return mixed 按指定格式 format 返回的日出时间， 或者在失败时返回 FALSE。
     */
    public static function dateSunrise( int $timestamp, int $format = SUNFUNCS_RET_STRING, $latitude = null, $longitude = null, $zenith = null, $gmt_offset = 1 )
    {
        $latitude = $latitude??ini_get("date.default_latitude");
        $longitude = $longitude??ini_get("date.default_longitude");
        $zenith = $zenith??ini_get("date.sunrise_zenith");

        return date_sunrise( $timestamp, $format, $latitude, $longitude, $zenith, $gmt_offset);
    }





}







