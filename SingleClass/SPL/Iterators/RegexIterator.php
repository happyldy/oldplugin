<?php
/**
 * 此迭代器可用于根据正则表达式过滤另一个迭代器。
 * RegexIterator  extends FilterIterator
 *
 *
 * RegexIterator::ALL_MATCHES
 *      返回当前条目的所有匹配项（请参阅 preg_match_all()）。
 * RegexIterator::GET_MATCH
 *      返回当前条目的第一个匹配项（请参阅 preg_match()）。
 * RegexIterator::MATCH
 *      仅对当前条目执行匹配（过滤器）（参见 preg_match()）。
 * RegexIterator::REPLACE
 *      替换当前条目（参见 preg_replace(); 尚未完全实现）
 * RegexIterator::SPLIT
 *      返回当前条目的拆分值（请参阅 preg_split()）。
 *
 * 源码还有反向匹配 INVERT_MATCH
 *
 * RegexIterator::USE_KEY
 *      特殊标志：匹配输入键而不是输入值。
 *
 */


namespace HappyLin\OldPlugin\SingleClass\SPL\Iterators;



use RegexIterator as RI, Iterator;



class RegexIterator extends RI
{


    /**
     * RegexIterator constructor.
     *
     *  $mode
     *      RegexIterator::ALL_MATCHES
     *          返回当前条目的所有匹配项（请参阅 preg_match_all()）。
     *      RegexIterator::GET_MATCH
     *          返回当前条目的第一个匹配项（请参阅 preg_match()）。
     *      RegexIterator::MATCH
     *          仅对当前条目执行匹配（过滤器）（参见 preg_match()）。
     *      RegexIterator::REPLACE
     *          替换当前条目（参见 preg_replace(); 尚未完全实现）
     *      RegexIterator::SPLIT
     *          返回当前条目的拆分值（请参阅 preg_split()）。
     *
     *  $pregFlags
     *      PREG_PATTERN_ORDER      结果排序为$matches[0]保存完整模式的所有匹配, $matches[1] 保存第一个子组的所有匹配，以此类推。
     *      PREG_SET_ORDER          结果排序为$matches[0]包含第一次匹配得到的所有匹配(包含子组)， $matches[1]是包含第二次匹配到的所有匹配(包含子组)的数组，以此类推。
     *      PREG_OFFSET_CAPTURE     改变matches中的每一个匹配结果字符串元素，使其成为一个第0个元素为匹配结果字符串，第1个元素为匹配结果字符串在subject中的偏移量。
     *      PREG_UNMATCHED_AS_NULL  使用该标记，未匹配的子组会报告为 NULL；未使用时，报告为空的 string。
     *
     *
     * @param Iterator $iterator 要应用此正则表达式筛选器的迭代器。
     * @param string $pattern  要匹配的正则表达式。
     * @param int $mode 操作模式，有关模式列表，请参阅RegexIterator:：setMode（）。
     * @param int $flags RegexIterator::USE_KEY; 特殊标志， 请参阅RegexIterator:：setFlags（）以获取可用标志的列表
     * @param int $pregFlags 正则表达式标记。这些标志取决于操作模式参数：
     */
    public function __construct(Iterator $iterator, $pattern, $mode = RI::MATCH, $flags = 0, $pregFlags = 0)
    {
        parent::__construct($iterator, $pattern, $mode, $flags, $pregFlags);
    }


    /**
     * 设置操作模式。
     *
     * RegexIterator::ALL_MATCHES
     *      返回当前条目的所有匹配项（请参阅 preg_match_all()）。
     * RegexIterator::GET_MATCH
     *      返回当前条目的第一个匹配项（请参阅 preg_match()）。
     * RegexIterator::MATCH
     *      仅对当前条目执行匹配（过滤器）（参见 preg_match()）。
     * RegexIterator::REPLACE
     *      替换当前条目（参见 preg_replace(); 尚未完全实现）
     * RegexIterator::SPLIT
     *      返回当前条目的拆分值（请参阅 preg_split()）。
     *
     * @param int $mode
     */
    public function setMode($mode):void
    {
        parent::setMode($mode);
    }

    /**
     * @return int  返回操作模式，有关操作模式列表，请参阅RegexIterator:：setMode（）。
     */
    public function getMode(): int
    {
        parent::getMode();
    }

    /**
     * 设置标志。
     * RegexIterator::USE_KEY
     *      特殊标志：匹配输入键而不是输入值。
     *
     * @param int $flags 要设置的标志是类常量的位掩码。
     */
    public function setFlags($flags):void
    {
        parent::setFlags($flags);
    }


    /**
     * 返回标志，有关可用标志的列表，请参见RegexIterator:：setFlags（）
     * @return int
     */
    public function getFlags(): int
    {
        return parent::getFlags();
    }


    /**
     * 设置正则表达式标志。
     *
     *  $pregFlags
     *      PREG_PATTERN_ORDER      结果排序为$matches[0]保存完整模式的所有匹配, $matches[1] 保存第一个子组的所有匹配，以此类推。
     *      PREG_SET_ORDER          结果排序为$matches[0]包含第一次匹配得到的所有匹配(包含子组)， $matches[1]是包含第二次匹配到的所有匹配(包含子组)的数组，以此类推。
     *      PREG_OFFSET_CAPTURE     改变matches中的每一个匹配结果字符串元素，使其成为一个第0个元素为匹配结果字符串，第1个元素为匹配结果字符串在subject中的偏移量。
     *      PREG_UNMATCHED_AS_NULL  使用该标记，未匹配的子组会报告为 NULL；未使用时，报告为空的 string。
     *
     * 正则表达式标记。有关可用标志的概述，请参见RegexIterator:：_construct（）
     * @param int $pregFlags
     */
    public function setPregFlags($pregFlags): void
    {
        parent::setPregFlags($pregFlags);
    }

    /**
     * 返回正则表达式标志，有关标志列表，请参阅 RegexIterator::__construct()。
     *
     * @return int 返回正则表达式标志的位掩码。
     */
    public function getPregFlags(): int
    {
        parent::getPregFlags();
    }


    /**
     * 根据正则表达式匹配（字符串）Regex Iterator::current()（或 Regex Iterator::key() 如果设置了 Regex Iterator::USE_KEY 标志）。
     * @return bool
     */
    public function accept(): bool
    {
        return parent::accept();
    }


    /**
     * 迭代器索引回到开始
     * 这将迭代器倒回到开头
     */
    public function rewind():void
    {
        parent::rewind();
    }


    /**
     * 返回当前数组条目
     * 获取当前的节点。
     *
     * @return mixed 当前的双链接列表节点值
     */
    public function current()
    {
        return parent::current();
    }


    /**
     * 此函数返回当前节点索引
     * @return bool|float|int|string|void|null 当前节点索引。
     */
    public function key()
    {
        return parent::key();
    }

    /**
     * 移至下一个条目
     * 将迭代器移动到下一个节点。
     */
    public function next()
    {
        parent::next();
    }

    /**
     * 检查是否包含更多节点
     * @return bool 如果包含更多节点，则返回TRUE，否则返回FALSE
     */
    public function valid():bool
    {
        return parent::valid();
    }





}

