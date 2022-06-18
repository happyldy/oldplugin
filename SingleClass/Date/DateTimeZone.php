<?php
/**
 *
 *
 */


namespace HappyLin\OldPlugin\SingleClass\Date;


use DateTimeZone as DTZ;


class DateTimeZone extends DTZ
{


    /**
     * DateTimeZone constructor.
     *
     *
     *
     * @param stirng $timezone 所支持的 timezone names之一. Asia/Shanghai
     */
    public function __construct($timezone)
    {
        parent::__construct($timezone);
    }


    /**
     *
     * @return array 返回与时区相关的定位信息，包括国家代码，纬度/经度和解释。
     */
    public function getLocation():array
    {
        return parent::getLocation();
    }


    /**
     *
     * @return string|void 返回时区名称。
     */
    public function getName()
    {
        return parent::getName();
    }


    /**
     * 该函数返回 datetime日期 相对于 GMT 的时差。 。 GMT 时差是通过 DateTimeZone 对象的时区信息计算出来的。
     * @param DateTime $datetime 用来计算时差的日期对象。
     * @return int 成功时返回精确到秒的时差， 或者在失败时返回 FALSE。
     */
    public function getOffset( $datetime)
    {
        return parent::getOffset($datetime);
    }


    /**
     * 成功返回转换数组的数字索引数组，或者在失败时返回false
     *
     * return array
     *  ts       int时间戳
     *  time     ISO8601格式的时间字符串
     *  offset   int 以秒为单位的 伦敦时间 偏移量
     *  isdst    bool Whether daylight saving time is active
     *  abbr     字符串时区缩写
     *
     * @param int $timestampBegin Begin timestamp.
     * @param int $timestampEnd End timestamp.
     * @return array|void
     */
    public function getTransitions($timestampBegin = null, $timestampEnd = null)
    {
        return parent::getTransitions($timestampBegin, $timestampEnd);
    }


    /**
     * 所有时区都取出了
     * @return array 返回一个包含 dst (夏令时)，时差和时区信息的关联数组
     */
    public static function listAbbreviations()
    {
        return parent::listAbbreviations();
    }

    /**
     * 返回一个包含了所有时区标示符的索引数组。
     *
     * DateTimeZone::AFRICA
     *      Africa time zones. 非洲
     * DateTimeZone::AMERICA
     *      America time zones. 美洲
     * DateTimeZone::ANTARCTICA
     *      Antarctica time zones. 南极洲
     * DateTimeZone::ARCTIC
     *      Arctic time zones. 北极
     * DateTimeZone::ASIA
     *      Asia time zones.  亚洲
     * DateTimeZone::ATLANTIC
     *      Atlantic time zones. 大西洋
     * DateTimeZone::AUSTRALIA
     *      Australia time zones. 澳洲
     * DateTimeZone::EUROPE
     *      Europe time zones.  欧洲
     * DateTimeZone::INDIAN
     *      Indian time zones.  印度
     * DateTimeZone::PACIFIC
     *      Pacific time zones.  太平洋
     * DateTimeZone::UTC
     *      UTC time zones. utc时区
     * DateTimeZone::ALL
     *      All time zones. 所有时区
     * DateTimeZone::ALL_WITH_BC
     *      All time zones including backwards compatible. 所有时区，包括向后兼容。
     * DateTimeZone::PER_COUNTRY
     *      Time zones per country.  每个国家/地区的时区。
     *
     *
     * @param int $timezoneGroup DateTimeZone 类中的常量之一。
     * @param null $countryCode 由两个字母组成，ISO 3166-1 兼容的国家代码。Note: 只有当 what 被设置为DateTimeZone::PER_COUNTRY时,该选项才会被使用。
     * @return array
     */
    public static function listIdentifiers($timezoneGroup = DTZ::ALL, $countryCode = null)
    {
        return DTZ::listIdentifiers($timezoneGroup, $countryCode);
    }


}







