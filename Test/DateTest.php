<?php
/**
 *
 * GMT（Greenwich Mean Time）， 格林威治平时（也称格林威治时间）。它规定太阳每天经过位于英国伦敦郊区的皇家格林威治天文台的时间为中午12点。
 * UTC 是现在全球通用的时间标准，全球各地都同意将各自的时间进行同步协调。UTC 时间是经过平均太阳时（以格林威治时间GMT为准）、地轴运动修正后的新时标以及以秒为单位的国际原子时所综合精算而成。
 * DST（Daylight Saving Time），夏令时又称夏季时间，或者夏时制。
 *
 *
 *
 *
 * 日 --- ---
 *  d   月份中的第几天，有前导零的 2 位数字 01 到 31
 *  z   年份中的第几天 0 到 365
 *  j       月份中的第几天，没有前导零 1 到 31
 *  S       每月天数后面的英文后缀，2 个字符 st，nd，rd 或者 th。可以和 j 一起用
 *  a   所有天数，特定函数用
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
 */



namespace HappyLin\OldPlugin\Test;


use HappyLin\OldPlugin\SingleClass\Date\{DateTime, DateInterval, DateTimeZone, DateTimeTool};


use HappyLin\OldPlugin\Test\TraitTest;


class DateTest
{

    use DateTimeTool,TraitTest;



    public function __construct()
    {

    }
    



    /**
     * 就三方法，一种P···T···格式new一个，一种是静态字符串返回一个， 然后就格式化展示结果
     *
     * @note \DateInterval 类 时间段（\DateTime 辅助函数）；
     */
    public function dateIntervalTest()
    {
        $dateInterval = new DateInterval('P29Y10M02DT23H15M45S');
        var_dump('初始化一个DateInterval时间：' . $dateInterval->format('%Y-%m-%d %H:%i:%s'));

        //负数
        $dateInterval->invert = 1;

        // 不想用它，数字保险
        $res = DateInterval::createFromDateString('1 year + 1 weeks + 12 second');
        var_dump('DateInterval::createFromDateString初始化DateInterval：' . $res->format('%Y-%m-%d %H:%i:%s'));

    }



    /**
     * @note \DateTimeZone 类 获取时区相关信息 （\DateTime 辅助函数）
     */
    public function dateTimeZoneTest()
    {
        $dateZone  = new DateTimeZone('Asia/Shanghai');

        var_dump("时区相关的定位信息:\n" . var_export($dateZone->getLocation(), true));
        var_dump('时区名称:' . $dateZone->getName());
        // 相对于 GMT 的时差 秒；这个太麻烦; 不如getTransitions(time())[0]['offset']
        var_dump('时区相对于 UTC 的时差:' . $dateZone->getOffset(new DateTime('now', $dateZone)));
        var_dump("时区:\n" . var_export($dateZone->getTransitions(time()), true));

        //var_dump($dateZone::listAbbreviations());
        //var_dump($dateZone::listIdentifiers());

    }






    /**
     * @note \DateTime 类
     */
    public function dateTimeTest()
    {
        //$dateTime = new DateTime();
        $dateTime = new DateTime('2021-10-03T03:30:58+0800');
        var_dump('初始化DateTimes时区Asia/Shanghai时间为：' . $dateTime->format('Y-m-d H:i:s'));

        // 对应格式 对应时间字符串转化为DateTime对象，没啥用！
        $newDateTime = $dateTime::createFromFormat('j-M-Y|', '15-Feb-2009');
        var_dump( '对应格式\'j-M-Y|\' 对应时间字符串\'15-Feb-2009\'转化为DateTime对象' . $newDateTime->format('Y-m-d H:i:s'));

        // 29年后时间 29年前用sub方法
        $dateInterval = new DateInterval('P29Y10M02DT23H15M45S');
        $dateTime->add($dateInterval);
        var_dump('add(DateInterval)加上（sub 则是减去）29年10月23时15分45秒：' . $dateTime->format('Y-m-d H:i:s'));

        // 字符串修改时间
        $dateTime->modify('+1day +12second');
        var_dump("modify加上一天12秒："  . $dateTime->format('Y-m-d H:i:s'));

        $dateTime->setDate(2021,10,03);
        var_dump("setDate重置日期2021年10月03日："  . $dateTime->format('Y-m-d H:i:s'));

        $dateTime->setTime(12,12,12);
        var_dump("setDate重置时间12时12分12秒："  . $dateTime->format('Y-m-d H:i:s'));

        $dateTime->setISODate(2021,2,1);
        var_dump("setDate重置周2021年第2周第1天："  . $dateTime->format('Y-m-d H:i:s'));

        $dateTime->setTimestamp(strtotime('2021-10-03T03:30:58+0800'));
        var_dump("根据时间戳设置时间："  . $dateTime->format('Y-m-d H:i:s'));



        $dateTime02 = new DateTime('2020-10-01T03:30:58', new DateTimeZone('Asia/Shanghai'));
        var_dump("距离另一个datetime对象2020-10-01T12:00:00的差值【也可用比较运算符（\$date1 > \$date2）：bool】："  . $dateTime->diff($dateTime02, true)->format('%R%a天'));


        var_dump("获取时区："  . var_export($dateTime02->getTimezone(), true));


        var_dump("获取时区偏移量秒："  . $dateTime->getOffset());
        var_dump("获取时间戳："  . $dateTime->getTimestamp());
        var_dump("获取时区："  . var_export($dateTime->getTimezone(), true));

        var_dump("获取时区："  . var_export($dateTime02->getTimezone(), true));


        $dateTime->setTimezone(new \DateTimeZone('Europe/Amsterdam'));
        var_dump("修改时区Europe/Amsterdam(据UTC两小时)："  . $dateTime->format('Y-m-d H:i:s'));
        //var_dump("Europe/Amsterdam时区时差："  . (new \DateTimeZone('Europe/Amsterdam'))->);



    }







    /**
     * @note 日期相关函数
     */
    public function dateTimeToolTest()
    {


        var_dump(static::toStr('获取date时间ymd His ', static::date('ymd His', null)));


        var_dump(static::toStr('获取gmdate时间ymd His ', static::gmdate('ymd His', null)));


        var_dump(static::toStr('获取一个根据 timestamp 得出的包含有日期信息的关联数组', static::getdate()));


        var_dump(static::toStr('获取一个当前时间 time()', static::time()));

        var_dump(static::toStr('获取一个当前时间关联数组 gettimeofday() ', static::gettimeofday()));

        var_dump(static::toStr('获取当前 Unix 时间戳以及微秒数 microtime() ', static::microtime()));

        var_dump(static::toStr('获取当前 Unix 时间戳以及微秒数, 返回一个浮点数 microtime(true) ', static::microtime(true)));

        var_dump(static::toStr('获取一个日期的 Unix 时间戳 mktime(2)', static::mktime(2)));

        var_dump(static::toStr('获取一个 GMT 日期的 UNIX 时间戳 gmmktime(2)', static::gmmktime(2)));


        var_dump(static::toStr('从缩写中返回时区名称 timezone_name_from_abbr("", 8*3600, 0)', static::timezoneNameFromAbbr("", 8*3600, 0)));

        var_dump(static::toStr('获取时区数据库的版本', static::timezoneVersionGet()));



        var_dump(static::toStr('获取默认格式的给定日期的信息 date_parse("2006-12-12 10:00:00")  ', date_parse("2006-12-12 10:00:00")));

        var_dump(static::toStr('获取根据指定格式的给定日期的信息 date_parse_from_format("j.n.Y H:iP","6.1.2009 13:00+01:00")  ', static::dateParseFromFormat("j.n.Y H:iP","6.1.2009 13:00+01:00")));


        var_dump(static::toStr('返回给定的日期（time()）与地点(26.056334128199182, 119.31024586308608)的日出时间；--> 不准或不会用  ', static::dateSunrise(time(),SUNFUNCS_RET_STRING, 26.056334128199182, 119.31024586308608, 100, 1)));






    }

















}















