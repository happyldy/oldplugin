<?php


namespace HappyLin\OldPlugin\SingleClass\VariableAndType;


use spec\Prophecy\Doubler\DoublerSpec;

class Arrays
{

    /**
     * 从数组中将变量导入到当前的符号表
     * 检查每个键名看是否可以作为一个合法的变量名，同时也检查和符号表中已有的变量名的冲突。
     *
     * flags
     *  对待非法／数字和冲突的键名的方法将根据取出标记 flags 参数决定。可以是以下值之一：
     *      EXTR_OVERWRITE如果有冲突，覆盖已有的变量。
     *      EXTR_SKIP如果有冲突，不覆盖已有的变量。
     *      EXTR_PREFIX_SAME如果有冲突，在变量名前加上前缀 prefix。
     *      EXTR_PREFIX_ALL给所有变量名加上前缀 prefix。
     *      EXTR_PREFIX_INVALID仅在非法／数字的变量名前加上前缀 prefix。
     *      EXTR_IF_EXISTS仅在当前符号表中已有同名变量时，覆盖它们的值。其它的都不处理。举个例子，以下情况非常有用：定义一些有效变量，然后从 $_REQUEST 中仅导入这些已定义的变量。
     *      EXTR_PREFIX_IF_EXISTS仅在当前符号表中已有同名变量时，建立附加了前缀的变量名，其它的都不处理。
     *      EXTR_REFS将变量作为引用提取。这有力地表明了导入的变量仍然引用了 array 参数的值。可以单独使用这个标志或者在 flags 中用 OR 与其它任何标志结合使用。
     *  如果没有指定 flags，则被假定为 EXTR_OVERWRITE。
     *
     * @param array $array 一个关联数组。此函数会将键名当作变量名，值作为变量的值。对每个键／值对都会在当前的符号表中建立变量，并受到 flags 和 prefix 参数的影响。必须使用关联数组，数字索引的数组将不会产生结果，除非用了 EXTR_PREFIX_ALL 或者 EXTR_PREFIX_INVALID。
     * @param int $flags  对待非法／数字和冲突的键名的方法将根据取出标记 flags 参数决定。可以是以下值之一：
     * @param string|null $prefix 注意 prefix 仅在 flags 的值是 EXTR_PREFIX_SAME，EXTR_PREFIX_ALL，EXTR_PREFIX_INVALID 或 EXTR_PREFIX_IF_EXISTS 时需要。如果附加了前缀后的结果不是合法的变量名，将不会导入到符号表中。前缀和数组键名之间会自动加上一个下划线。
     * @return int 返回成功导入到符号表中的变量数目。
     */
    public static function extract( array &$array, int $flags = EXTR_OVERWRITE, string $prefix = NULL ) : int
    {
        $param = func_get_args();
        array_shift($param);
        return  extract($array, ...$param);
    }

    /**
     * 计算数组中的单元数目，或对象中的属性个数
     * 统计出数组里的所有元素的数量，或者对象里的东西。
     *
     * Caution count() 能检测递归来避免无限循环，但每次出现时会产生 E_WARNING 错误（如果 array 不止一次包含了自身）并返回大于预期的统计数字。
     *
     * @param mixed $array_or_countable
     * @param int $mode 如果可选的 mode 参数设为 COUNT_RECURSIVE（或 1），count() 将递归地对数组计数。对计算多维数组的所有单元尤其有用。
     * @return int
     */
    public static function count( $array_or_countable, int $mode = COUNT_NORMAL ) : int
    {
        return count( $array_or_countable, $mode );
    }

    /**
     * 统计数组中所有的值
     * array_count_values() 返回一个数组：数组的键是 array 里单元的值；数组的值是 array 单元的值出现的次数。
     *
     * @param array $array 统计这个数组的值
     * @return array 返回一个关联数组，用 array 数组中的值作为键名，该值在数组中出现的次数作为值。
     */
    public static function arrayCountValues( array $array ) : array
    {
        return array_count_values($array);
    }

    /**
     * 打乱数组
     * 本函数打乱（随机排列单元的顺序）一个数组。它使用的是伪随机数产生器，并不适合密码学的场合。
     *
     * @param array $array
     * @return bool
     */
    public static function shuffle( array &$array) : bool
    {
        return shuffle($array);
    }


    /**
     * 对数组中所有值求和
     *
     * @param array $array
     * @return number
     */
    public static function arraySum( array $array)
    {
        return array_sum( $array);
    }


    /**
     * 根据范围创建数组，包含指定的元素
     * 建立一个包含指定范围单元的数组。
     *
     * @param mixed $start 序列的第一个值。
     * @param mixed $end 序列结束于 end 的值。
     * @param int|float $step 如果设置了步长 step，会被作为单元之间的步进值。step 应该为正值。不设置step 则默认为 1。
     * @return array  返回的数组中从 start 到 end （含 start 和 end）的单元。
     */
    public static function range($start, $end, $step = 1 ) : array
    {
        return range( $start, $end, $step);
    }


    /**
     * 用给定的值填充数组
     * 用 value 参数的值将一个数组填充 num 个条目，键名由 start_index 参数指定的开始。
     *
     * @param int $start_index 数组的第一个索引值。 如果 start_index 是负数，那么返回的数组的第一个索引将会是 start_index ，而后面索引则从0开始。 (参见 例子)。
     * @param int $num 插入元素的数量。必须大于或等于 0。
     * @param mixed $value 用来填充的值。
     * @return array 返回填充后的数组。
     */
    public static function arrayFill( int $start_index, int $num, $value) : array
    {
        return array_fill( $start_index, $num, $value);
    }


    /**
     * 使用指定的键和值填充数组
     * 使用 value 参数的值作为值，使用 keys 数组的值作为键来填充一个数组。
     * @param array $keys 使用该数组的值作为键。非法值将被转换为字符串。
     * @param mixed $value 填充使用的值。
     * @return array 返回填充后的数组。
     */
    public static function arrayFillKeys( array $keys, $value) : array
    {
        return array_fill_keys( $keys,  $value);
    }


    /**
     * 在数组开头插入一个或多个单元
     *
     *
     * @param array $array 输入的数组。
     * @param mixed ...$values 插入的变量。
     * @return int 返回 array 数组新的单元数目。
     */
    public static function arrayUnshift( array &$array, ...$values) : int
    {
        return array_unshift($array, ...$values);
    }


    /**
     * 以指定长度将一个值填充进数组
     * 返回 array 的一个拷贝，并用 value 将其填补到 size 指定的长度。
     * 如果 size 为正，则填补到数组的右侧，如果为负则从左侧开始填补。
     * 如果 size 的绝对值小于或等于 array 数组的长度则没有任何填补。
     * 有可能一次最多填补 1048576 个单元。
     *
     * @param array $array 需要被填充的原始数组。
     * @param int $size 新数组的长度。
     * @param mixed $value 将被填充的值，只有在 array 的现有长度小于 size 的长度时才有效。
     * @return array 返回 array 用 value 填充到 size 指定的长度之后的一个副本。
     */
    public static function arrayPad( array $array, int $size,  $value) : array
    {
        return array_pad( $array, $size, $value);
    }





    /**
     * 弹出数组最后一个单元（出栈）
     * 弹出并返回 array 数组的最后一个单元，并将数组 array 的长度减一。
     *
     * Note: 使用此函数后会重置（reset()）array 指针。
     *
     * @param array $array 需要弹出栈的数组。
     * @return mixed 返回 array 的最后一个值。如果 array 是空（如果不是一个数组），将会返回 NULL 。
     */
    public static function arrayPop( array &$array)
    {
        return array_pop($array);
    }


    /**
     * 将 array 的第一个单元移出并作为结果返回，将 array 的长度减一并将所有其它单元向前移动一位。所有的数字键名将改为从零开始计数，文字键名将不变。
     *
     * Note: 使用此函数后会重置（reset()）array 指针。
     *
     * @param array $array 输入的数组。
     * @return mixed 返回移出的值，如果 array 为 空或不是一个数组则返回 NULL。
     */
    public static function arrayShift( array &$array)
    {
        return array_shift($array);
    }



    /**
     * 移除数组中重复的值
     * 接受 array 作为输入并返回没有重复值的新数组。
     * 注意键名保留不变。array_unique() 先将值作为字符串排序，然后对每个值只保留第一个遇到的键名，接着忽略所有后面的键名。这并不意味着在未排序的 array 中同一个值的第一个出现的键名会被保留。
     *
     * Note: 当且仅当 (string) $elem1 === (string) $elem2 时两个单元被认为相同。例如，字符串表达一样时，会使用首个元素。
     *
     * sort_flags
     * 第二个可选参数sort_flags 可用于修改排序行为：
     *
     * 排序类型标记：
     * ◦ SORT_REGULAR - 按照通常方法比较（不修改类型）
     * ◦ SORT_NUMERIC - 按照数字形式比较
     * ◦ SORT_STRING - 按照字符串形式比较
     * ◦ SORT_LOCALE_STRING - 根据当前的本地化设置，按照字符串比较
     *
     * @param array $array 输入的数组
     * @param int $sort_flags 第二个可选参数sort_flags 可用于修改排序行为：
     * @return array 返回过滤后的数组。
     */
    public static function arrayUnique( array $array, int $sort_flags = SORT_STRING) : array
    {
        return array_unique(...func_get_args());
    }





    /**
     * 把 input 数组中由 offset 和 length 指定的单元去掉，如果提供了 replacement 参数，则用其中的单元取代。
     *
     * 当给出了 replacement 时要移除从 offset 到数组末尾所有单元时，用 count($input) 作为 length。
     * 不保留替换数组 replacement 中的键名。
     *
     * @param array $input 输入的数组。
     * @param int $offset 如果 offset 为正，则从 input 数组中该值指定的偏移量开始移除。 如果 offset 为负，则从 input 末尾倒数该值指定的偏移量开始移除
     * @param int $length 如果省略 length，则移除数组中从 offset 到结尾的所有部分。 如果设置了 length 为零，不会移除单元。如果 length 为正值，则移除这么多单元。如果 length 为负值，则移除部分停止于数组末尾该数量的单元。
     * @param mixed|array $replacement 如果给出了 replacement 数组，则被移除的单元被此数组中的单元替代。如果用来替换 replacement 只有一个单元，那么不需要给它加上 array() 或方括号，除非该单元本身就是一个数组、一个对象或者 NULL。
     * @return array 返回一个包含有被移除单元的数组。
     */
    public static function arraySplice( array &$input, int $offset, int $length = null, $replacement = array() ) : array
    {
        $param = func_get_args();
        array_shift($param);
        return array_splice($input, ...$param );
    }



    /**
     * 从数组中取出一段
     * 返回根据 offset 和 length 参数所指定的 array 数组中的一段序列。
     * 参数 offset 标识的是数组中的位置，而不是键。
     *
     *
     * @param array $array 输入的数组。
     * @param int $offset 如果 offset 非负，则序列将从 array 中的此偏移量开始。  如果 offset 为负，则序列将从 array 中距离末端这么远的地方开始。
     * @param int|null $length 如果给出了 length 并且为正，则序列中将具有这么多的单元。如果 array 比 length 要短，只会保留有效的数组单元。如果给出了 length 并且为负，则序列将终止在距离数组末端这么远的地方。
     * @param bool $preserve_keys  默认会重新排序并重置数组的数字索引。你可以通过将 preserve_keys 设为 TRUE 来改变此行为。
     * @return array 返回其中一段。 如果 offset 参数大于 array 尺寸，就会返回空的 array。
     */
    public static function arraySlice( array $array, int $offset, int $length = NULL, bool $preserve_keys = FALSE ) : array
    {
        return array_slice(...func_get_args());
    }




    /**
     * 将一个数组分割成多个
     *
     * @param array $array 需要操作的数组
     * @param int $size 每个数组的单元数目
     * @param bool $preserve_keys 设为 TRUE，可以使 PHP 保留输入数组中原来的键名。如果你指定了 FALSE，那每个结果数组将用从零开始的新数字索引。默认值是 FALSE。
     * @return array 得到的数组是一个多维数组中的单元，其索引从零开始，每一维包含了 size 个元素。
     */
    public static function arrayChunk( array $array, int $size, bool $preserve_keys = false) : array
    {
        return array_chunk(...func_get_args());
    }


    /**
     * 用回调函数过滤数组中的单元
     *
     * @param array $array 要循环的数组
     * @param callable $callback 使用的回调函数; 如果没有提供 callback 函数，将删除 array 中所有等值为 FALSE 的条目。更多信息见转换为布尔值。
     * @param int $flag 决定callback接收的参数形式: ARRAY_FILTER_USE_KEY - callback接受键名作为的唯一参数;  ARRAY_FILTER_USE_BOTH - callback同时接受键名和键值
     * @return array 返回过滤后的数组。
     */
    public static function arrayFilter( array $array, callable $callback, int $flag = 0) : array
    {
        return array_filter(...func_get_args());
    }


    /**
     * 为数组的每个元素应用回调函数
     * array_map()：返回数组，是为 array 每个元素应用 callback函数之后的数组。
     * array_map() 返回一个 array，数组内容为 array1 的元素按索引顺序为参数调用 callback 后的结果（有更多数组时，还会传入 arrays 的元素）。 callback 函数形参的数量必须匹配 array_map() 实参中数组的数量。
     *
     * @param callable $callback 回调函数 callable，应用到每个数组里的每个元素。多个数组操作合并时，callback 可以设置为 NULL。如果只提供了 array 一个数组， array_map() 会返回输入的数组。
     * @param array $array 数组，遍历运行 callback 函数。
     * @param array ...$arrays 额外的数组列表，每个都遍历运行 callback 函数。
     * @return array 返回数组，包含 callback 函数处理之后 array (有多个数组时，为 arrays) 对应索引所有元素作为函数的参数。当仅仅传入一个数组时，返回的数组会保留传入参数的键（key）。传入多个数组时，返回的数组键是按顺序的 integer。
     */
    public static function arrayMap( $callback, array $array, array ...$arrays) : array
    {
        return array_map(...func_get_args());
    }


    /**
     * 使用用户自定义函数对数组中的每个元素做回调处理
     * 将用户自定义函数 funcname 应用到 array 数组中的每个单元。
     * array_walk() 不会受到 array 内部数组指针的影响。array_walk() 会遍历整个数组而不管指针的位置。
     *
     * Note:
     * 如果 callback 需要直接作用于数组中的值，则给 callback 的第一个参数指定为引用。这样任何对这些单元的改变也将会改变原始数组本身。
     * 参数数量超过预期，传入内置函数 (例如 strtolower())，将抛出警告，所以不适合当做 funcname。
     *
     *
     * @param array $array 输入的数组。
     * @param callable $callback 典型情况下 callback 接受两个参数。array 参数的值作为第一个，键名作为第二个。 只有 array 的值才可以被改变，用户不应在回调函数中改变该数组本身的结构。例如增加/删除单元，unset 单元等等。如果 array_walk() 作用的数组改变了，则此函数的的行为未经定义，且不可预期。
     * @param mixed|null $userdata 如果提供了可选参数 userdata，将被作为第三个参数传递给 callback funcname。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     * @throws E_WARNING 如果 callback 函数需要的参数比给出的多，则每次 array_walk() 调用 callback 时都会产生一个 E_WARNING 级的错误。
     */
    public static function arrayWalk( array &$array, callable $callback, $userdata = NULL ) : bool
    {
        return array_walk($array, $callback, $userdata );
    }


    /**
     * 对数组中的每个成员递归地应用用户函数
     * 将用户自定义函数 callback 应用到 array 数组中的每个单元。本函数会递归到更深层的数组中去。
     *
     *
     *
     * @param array $array 输入的数组。
     * @param callable $callback 典型情况下 callback 接受两个参数。array 参数的值作为第一个，键名作为第二个。 如果提供了可选参数 userdata，将被作为第三个参数传递给 callback。
     * @param mixed|null $userdata 如果提供了可选参数 userdata，将被作为第三个参数传递给 callback。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function arrayWalkRecursive( array &$array, $callback, $userdata = NULL) : bool
    {
        return array_walk_recursive($array, $callback, $userdata);
    }



    // ······································· 键值操作 ·····················································


    /**
     * 对数组排序
     * 本函数对数组进行排序。当本函数结束时数组单元将被从最低到最高重新安排。
     * Note: 和大多数 PHP 排序函数一样，sort() 使用了 » Quicksort 实现的。 在分区的中间选择主元，从而为已经排序的数组提供最佳时间。 然而，这是一个您不应该依赖的实现细节。
     * Note: 如果两个成员完全相同，那么它们在排序数组中的相对顺序是未定义的。
     *
     * Note: 此函数为 array 中的元素赋与新的键名。这将删除原有的键名，而不是仅仅将键名重新排序。
     *
     * Warning 在对含有混合类型值的数组以 sort_flags 为 SORT_REGULAR 排序时要小心，因为 sort() 可能会产生不可预知的结果。

     *
     * sort_flags
     * 可选的第二个参数 sort_flags 可以用以下值改变排序的行为：
     *
     * 排序类型标记：
     * ◦ SORT_REGULAR - 正常比较单元详细描述参见 比较运算符 章节
     * ◦ SORT_NUMERIC - 单元被作为数字来比较
     * ◦ SORT_STRING - 单元被作为字符串来比较
     * ◦ SORT_LOCALE_STRING - 根据当前的区域（locale）设置来把单元当作字符串比较，可以用 setlocale() 来改变。
     * ◦ SORT_NATURAL - 和 natsort() 类似对每个单元以"自然的顺序"对字符串进行排序。
     * ◦ SORT_FLAG_CASE - 能够与 SORT_STRING 或 SORT_NATURAL 合并（OR 位运算），不区分大小写排序字符串。
     *
     * @param array $array 要排序的数组。
     * @param int $sort_flags 改变排序的行为：
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function sort( array &$array, int $sort_flags = SORT_REGULAR) : bool
    {
        return sort($array,  $sort_flags);
    }



    /**
     * 对数组逆向排序
     *
     * @param array $array
     * @param int $sort_flags
     * @return bool
     */
    public static function rsort( array &$array, int $sort_flags = SORT_REGULAR) : bool
    {
        return rsort($array,  $sort_flags);
    }


    /**
     * 使用用户自定义的比较函数对数组中的值进行排序
     * 本函数将用用户自定义的比较函数对一个数组中的值进行排序。如果要排序的数组需要用一种不寻常的标准进行排序，那么应该使用此函数。
     *
     * Note: 此函数为 array 中的元素赋与新的键名。这将删除原有的键名，而不是仅仅将键名重新排序。
     *
     * 警告 $value_compare_func 从比较函数返回非整数值，例如 float，将导致内部转换为回调返回值的整数。 因此，诸如 0.99 和 0.1 之类的值都将转换为整数值 0，这会将这些值比较为相等。
     *
     * @param array $array 输入的数组
     * @param callable $value_compare_func callback ( mixed $a, mixed $b ) : int  在第一个参数小于，等于或大于第二个参数时，该比较函数必须相应地返回一个小于，等于或大于 0 的整数。注意：在 PHP 7.0.0 之前的版本中，整数的区间为 -2147483648 to 2147483647。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function usort( array &$array, $value_compare_func) : bool
    {
        return usort($array, $value_compare_func);
    }




    /**
     * 对数组进行排序并保持索引关系
     * 本函数对数组进行排序，数组的索引保持和单元的关联。主要用于对那些单元顺序很重要的结合数组进行排序。
     *
     * @param array $array 输入的数组
     * @param int $sort_flags 可以用可选的参数 sort_flags 改变排序的行为，详情见 sort()。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function asort( array &$array, int $sort_flags = SORT_REGULAR) : bool
    {
        return asort($array, $sort_flags);
    }


    /**
     * 对数组进行逆向排序并保持索引关系
     * 本函数对数组进行排序，数组的索引保持和单元的关联。主要用于对那些单元顺序很重要的结合数组进行排序。
     *
     * @param array $array
     * @param int $sort_flags 可以用可选的参数 sort_flags 改变排序的行为，详情见 sort()。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function arsort( array &$array, int $sort_flags = SORT_REGULAR ) : bool
    {
        return arsort($array, $sort_flags);
    }


    /**
     * 使用用户自定义的比较函数对数组中的值进行排序并保持索引关联
     *
     *
     * @param array $array
     * @param callable $value_compare_func
     * @return bool
     */
    public static function uasort( array &$array, callable $value_compare_func) : bool
    {
        return uasort($array, $value_compare_func);
    }


    /**
     *  用"自然排序"算法对数组排序
     * 本函数实现了一个和人们通常对字母数字字符串进行排序的方法一样的排序算法并保持原有键／值的关联，这被称为"自然排序"。
     *
     * @param array $array
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function natsort( array &$array) : bool
    {
        return natsort($array);
    }


    /**
     * 用"自然排序"算法对数组进行不区分大小写字母的排序
     *
     * @param array $array
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function natcasesort( array &$array) : bool
    {
        return natcasesort($array);
    }





    /**
     * 对数组按照键名排序
     * 对数组按照键名排序，保留键名到数据的关联。本函数主要用于关联数组。
     *
     * @param array $array
     * @param int $sort_flags 可以用可选参数 sort_flags 改变排序的行为，详情见 sort()。
     * @return bool
     */
    public static function ksort( array &$array, int $sort_flags = SORT_REGULAR) : bool
    {
        return ksort($array, $sort_flags);
    }

    /**
     * 对数组按照键名逆向排序
     * 对数组按照键名逆向排序，保留键名到数据的关联。主要用于结合数组。
     *
     * @param array $array
     * @param int $sort_flags
     * @return bool
     */
    public static function krsort( array &$array, int $sort_flags = SORT_REGULAR ) : bool
    {
        return krsort($array, $sort_flags);
    }


    /**
     * 使用用户自定义的比较函数对数组中的键名进行排序
     *
     * @param array $array 输入的数组。
     * @param callable $key_compare_func callback ( mixed $a, mixed $b ) : int  在第一个参数小于，等于或大于第二个参数时，该比较函数必须相应地返回一个小于，等于或大于 0 的整数。注意：在 PHP 7.0.0 之前的版本中，整数的区间为 -2147483648 to 2147483647。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function uksort( array &$array, callable $key_compare_func) : bool
    {
        return uksort($array, $key_compare_func);
    }




    /**
     * 交换数组中的键和值
     *
     * @param array $array
     * @return array
     */
    public static function arrayFlip( array $array) : array
    {
        return array_flip( $array);
    }


    /**
     * 检查数组中是否存在某个值
     * 大海捞针，在大海（haystack）中搜索针（ needle），如果没有设置 strict 则使用宽松的比较。
     *
     * @param mixed $needle 待搜索的值。 如果 needle 是字符串，则比较是区分大小写的。
     * @param array $haystack  待搜索的数组。
     * @param bool $strict 如果第三个参数 strict 的值为 TRUE 则 in_array() 函数还会检查 needle 的类型是否和 haystack 中的相同。
     * @return bool 如果找到 needle 则返回 TRUE，否则返回 FALSE。
     */
    public static function inArray( $needle, array $haystack, bool $strict = FALSE) : bool
    {
        return in_array( $needle, $haystack, $strict);
    }


    /**
     * 返回数组中所有的值
     * 返回 input 数组中所有的值并给其建立数字索引。
     *
     * @param array $array
     * @return array 返回含所有值的索引数组。
     */
    public static function arrayValues( array $array) : array
    {
        return array_values( $array);
    }



    /**
     * 将数组中的所有键名修改为全大写或小写
     *
     * @param array $array 需要操作的数组。
     * @param int $case 可以在这里用两个常量，CASE_UPPER 或 CASE_LOWER（默认值）。
     * @return array 返回一个键全是小写或者全是大写的数组；如果输入值（array）不是一个数组，那么返回FALSE
     */
    public static function arrayChangeKeyCase( array $array, int $case = CASE_LOWER ) : array
    {
        return array_change_key_case(...func_get_args());
    }




    /**
     * 检查数组里是否有指定的键名或索引
     * 数组里有键 key 时，array_key_exists() 返回 TRUE。 key 可以是任何能作为数组索引的值。
     *
     * @param mixed $key 要检查的键。
     * @param array $array 一个数组，包含待检查的键。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public static function arrayKeyExists( $key, array $array) : bool
    {
        return array_key_exists( $key, $array);
    }


    /**
     * 获取指定数组的第一个键值
     * 不影响到原数组的内部指针。
     *
     * @param array $array
     * @return mixed 返回 array 的第一个键值（如果不为空），否则返回 NULL。
     */
    public static function arrayKeyFirst( array $array)
    {
        if(version_compare(PHP_VERSION, 7.3)){
            return PHP_VERSION.' >= 7.3.0';
        }

        return array_key_first($array);
    }

    /**
     * 获取一个数组的最后一个键值
     * 不影响到原数组的内部指针。
     *
     * @param array $array
     * @return mixed 返回 array 的最后一个键值（如果不为空），否则返回 NULL。
     */
    public static function arrayKeyLast( array $array)
    {
        if(version_compare(PHP_VERSION, 7.3)){
            return PHP_VERSION.' >= 7.3.0';
        }
        return array_key_last($array);
    }


    /**
     * 返回数组中部分的或所有的键名
     * 如果指定了可选参数 search_value，则只返回该值的键名。否则 input 数组中的所有键名都会被返回。
     *
     * @param array $array 一个数组，包含了要返回的键。
     * @param mixed|null $search_value  一个数组，包含了要返回的键。
     * @param bool $strict 判断在搜索的时候是否该使用严格的比较（===）。
     * @return array
     */
    public static function arrayKeys( array $array, $search_value = null, bool $strict = false) : array
    {
        return array_keys(...func_get_args());
    }








    //········································· 数组集合：数组与数组···································




    /**
     * 计算数组的差集
     *
     * @param array $array 要被对比的数组
     * @param array ...$arrays 和更多数组进行比较
     * @return array 返回一个数组，该数组包括了所有在 array 中但是不在任何其它参数数组中的值。注意键名保留不变。保留数组 array 里的键。
     */
    public static function arrayDiff( array $array, array ...$arrays) : array
    {
        return array_diff(...func_get_args());
    }

    /**
     * 使用键名比较计算数组的差集
     *
     * @param array $array1 从这个数组进行比较
     * @param array $array2 针对此数组进行比较
     * @param array ...$arrays 更多比较数组
     * @return array 返回一个数组，该数组包括了所有出现在 array1 中但是未出现在任何其它参数数组中的键名的值。
     */
    public static function arrayDiffKey(array $array1, array $array2, array ...$arrays ) : array
    {
        return array_diff_key(...func_get_args());
    }



    /**
     * 带索引检查计算数组的差集 （键名和值都一样才废除）
     * 返回一个数组，该数组包括了所有在 array1 中但是不在任何其它参数数组中的值。注意和 array_diff() 不同的是键名也用于比较。
     *
     * @param array $array1 从这个数组进行比较
     * @param array $array2 被比较的数组
     * @param array ...$arrays 更多被比较的数组
     * @return array 返回一个数组，该数组包含array1中任何其他数组中不存在的所有值。
     */
    public static function arrayDiffAssoc(array $array1, array $array2, array ...$arrays ) : array
    {
        return array_diff_assoc(...func_get_args());
    }


    /**
     * 用回调函数比较数据来计算数组的差集
     * 使用回调函数比较数据，计算数组的不同之处。和 array_diff() 不同的是，前者使用内置函数进行数据比较。
     *
     * @param array $array1
     * @param array $array2
     * @param array ...$_
     * @param callable $value_compare_func callback ( mixed $a, mixed $b ) : int 回调对照函数。
     * @return array 返回 array1 里没有出现在其他参数里的所有值。
     */
    public static function arrayUdiff(array $array1, array $array2,  $_ = null, $value_compare_func = null) : array
    {
        return array_udiff(...func_get_args());
    }


    /**
     * 用回调函数对键名比较计算数组的差集
     *  返回一个数组，该数组包括了所有出现在 array1 中但是未出现在任何其它参数数组中的键名的值。注意关联关系保留不变。本函数和 array_diff() 相同只除了比较是根据键名而不是值来进行的。
     *
     * @param array $array1
     * @param array $array2
     * @param array ...$_
     * @param callable $key_compare_func callback ( mixed $a, mixed $b ) : int 在第一个参数小于，等于或大于第二个参数时，该比较函数必须相应地返回一个小于，等于或大于 0 的整数。注意：在 PHP 7.0.0 之前的版本中，整数的区间为 -2147483648 to 2147483647。
     * @return array 返回一个数组，该数组包含array1中任何其他数组中都不存在的所有项。
     */
    public static function arrayDiffUkey( array $array1, array $array2,  $_ = null, $key_compare_func = null) : array
    {
        return array_diff_ukey(...func_get_args());
    }



    /**
     * 用用户提供的回调函数做索引检查来计算数组的差集
     * 对比了 array1 和 array2 并返回不同之处。注意和 array_diff() 不同的是键名也用于比较。
     * 和 array_diff_assoc() 不同的是使用了用户自定义的回调函数，而不是内置的函数。
     *
     * @param array $array1 待比较的数组
     * @param array $array2 和这个数组进行比较
     * @param array ...$arrays   更多比较的数组
     * @param callable $key_compare_func callback ( mixed $a, mixed $b ) : int; 在第一个参数小于，等于或大于第二个参数时，该比较函数必须相应地返回一个小于，等于或大于 0 的整数。注意：在 PHP 7.0.0 之前的版本中，整数的区间为 -2147483648 to 2147483647。
     * @return array
     */
    public static function arrayDiffUassoc( array $array1, array $array2,  $arrays = null, $key_compare_func = null) : array
    {
        return array_diff_uassoc(...func_get_args());
    }



    /**
     * 带索引检查计算数组的差集，用回调函数比较数据
     *
     * @param array $array1
     * @param array $array2
     * @param array ...$_
     * @param callable $value_compare_func callback ( mixed $a, mixed $b ) : int
     * @return array 回一个数组，该数组包括了所有在 array1 中但是不在任何其它参数数组中的值。注意和 array_diff() 与 array_udiff() 不同的是键名也用于比较。数组数据的比较是用用户提供的回调函数进行的。在此方面和 array_diff_assoc() 的行为正好相反，后者是用内部函数进行比较的。
     */
    public static function arrayUdiffAssoc( array $array1, array $array2,  $_ = null, $value_compare_func = null) : array
    {
        return array_udiff_assoc(...func_get_args());
    }


    /**
     * 带索引检查计算数组的差集，用回调函数比较数据和索引
     * 返回一个数组，该数组包括了所有在 array1 中但是不在任何其它参数数组中的值。
     *
     * @param array $array1
     * @param array $array2
     * @param array ...$_
     * @param callable $value_compare_func callback ( mixed $a, mixed $b ) : int
     * @param callable $key_compare_func 对键名（索引）的检查也是由回调函数 key_compare_func 进行的。这和 array_udiff_assoc() 的行为不同，后者是用内部函数比较索引的。
     * @return array 返回一个数组，该数组包含array1中任何其他参数中不存在的所有值。
     */
    public static function arrayUdiffUassoc( array $array1, array $array2, $_ = null, $value_compare_func = null, $key_compare_func = null) : array
    {
        return array_udiff_uassoc(...func_get_args());
    }






    /**
     * 计算数组的交集
     * 返回一个数组，该数组包含了所有在 array1 中也同时出现在所有其它参数数组中的值。注意键名保留不变。
     *
     * @param array $array1 要检查的数组，作为主值。
     * @param array $array2 要被对比的数组。
     * @param array ...$_ 要对比的数组列表。
     * @return array 返回一个数组，该数组包含了所有在 array1 中也同时出现在所有其它参数数组中的值。
     */
    public static function arrayIntersect( array $array1, array $array2 , array ...$_ ) : array
    {
        return array_intersect(...func_get_args());
    }


    /**
     * 使用键名比较计算数组的交集
     * 返回一个数组，该数组包含了所有出现在 array1 中并同时出现在所有其它参数数组中的键名的值。
     *
     * @param array $array1 要检查的数组，作为主值。
     * @param array $array2 要被对比的数组。
     * @param array ...$_ 要对比的数组列表。
     * @return array 返回一个关联数组，该数组包含array1的所有条目，这些条目具有所有参数中存在的键。
     */
    public static function arrayIntersectKey( array $array1, array $array2, array ...$_ ) : array
    {
        return array_intersect_key(...func_get_args());
    }


    /**
     * 带索引检查计算数组的交集
     * array_intersect_assoc() 返回一个数组，该数组包含了所有在 array1 中也同时出现在所有其它参数数组中的值。注意和 array_intersect() 不同的是键名也用于比较。
     *
     * @param array $array1
     * @param array $array2
     * @param array ...$_
     * @return array array_intersect_assoc() 返回一个数组，该数组包含了所有在 array1 中也同时出现在所有其它参数数组中的值。注意和 array_intersect() 不同的是键名也用于比较。
     */
    public static function arrayIntersectAssoc( array $array1, array $array2, array ...$_ ) : array
    {
        return array_intersect_assoc(...func_get_args());
    }





    /**
     * 计算数组的交集，用回调函数比较数据
     * 返回一个数组，该数组包含了所有在 array1 中也同时出现在所有其它参数数组中的值。数据比较是用回调函数进行的。此比较是通过用户提供的回调函数来进行的。如果认为第一个参数小于，等于，或大于第二个参数时必须分别返回一个小于零，等于零，或大于零的整数。
     *
     * @param array $array1
     * @param array $array2
     * @param array ...$_
     * @param callable $value_compare_func callback ( mixed $a, mixed $b ) : int
     * @return array 返回一个数组，该数组包含所有参数中存在的Array1的所有值。
     */
    public static function arrayUintersect( array $array1, array $array2, $_ = null, $value_compare_func = null) : array
    {
        return array_uintersect(...func_get_args());
    }


    /**
     * 用回调函数比较键名来计算数组的交集
     * 返回一个数组，该数组包含了所有出现在 array1 中并同时出现在所有其它参数数组中的键名的值。
     *
     * @param array $array1 用于比较数组的初始数组。
     * @param array $array2
     * @param array ...$_
     * @param callable $key_compare_func callback ( mixed $a, mixed $b ) : int
     * @return array 返回其键存在于所有参数中的array1的值。
     */
    public static function arrayIntersectUkey( array $array1, array $array2, $_ = null, $key_compare_func = null) : array
    {
        return array_intersect_ukey(...func_get_args());
    }


    /**
     * 带索引检查计算数组的交集，用回调函数比较索引
     *
     * @param array $array1
     * @param array $array2
     * @param array ...$_
     * @param callable $key_compare_func callback ( mixed $a, mixed $b ) : int
     * @return array 返回其值存在于所有参数中的array1的值。
     */
    public static function arrayIntersectUassoc( array $array1, array $array2, $_ = null, $key_compare_func = null) : array
    {
        return array_intersect_uassoc(...func_get_args());
    }


    /**
     * 带索引检查计算数组的交集，用回调函数比较数据
     * 注意和 array_uintersect() 不同的是键名也要比较。数据是用回调函数比较的。
     *
     * @param array $array1
     * @param array $array2
     * @param array ...$_
     * @param callable $value_compare_func callback ( mixed $a, mixed $b ) : int
     * @return array 返回一个数组，该数组包含了所有在 array1 中也同时出现在所有其它参数数组中的值。
     */
    public static function arrayUintersectAssoc( array $array1, array $array2, $_ = null, callable $value_compare_func = null) : array
    {
        return array_uintersect_assoc(...func_get_args());
    }


    /**
     * 带索引检查计算数组的交集，用单独的回调函数比较数据和索引
     * 通过额外的索引检查、回调函数比较数据和索引来返回多个数组的交集。
     *
     * @param array $array1
     * @param array $array2
     * @param array ...$_
     * @param callable $value_compare_func callback ( mixed $a, mixed $b ) : int
     * @param callable $key_compare_func 键名比较的回调函数。
     * @return array 返回一个数组，该数组包含了所有在 array1 中也同时出现在所有其它参数数组中的值。
     */
    public static function arrayUintersectUassoc( array $array1, array $array2, $_ = null, callable $value_compare_func = null, callable $key_compare_func = null) : array
    {
        return array_uintersect_uassoc(...func_get_args());
    }




    /**
     * 合并一个或多个数组
     * 将一个或多个数组的单元合并起来，一个数组中的值附加在前一个数组的后面。返回作为结果的数组。
     * 如果输入的数组中有相同的字符串键名，则该键名后面的值将覆盖前一个值。然而，如果数组包含数字键名，后面的值将 不会 覆盖原来的值，而是附加到后面。
     * 如果输入的数组存在以数字作为索引的内容，则这项内容的键名会以连续方式重新索引。
     *
     * @param array ...$arrays 要合并的数组。
     * @return array 返回合并后的结果数组。如果参数为空，则返回空 array。
     */
    public static function arrayMerge(array ...$arrays) : array
    {
        return array_merge( ...$arrays);
    }


    /**
     * 递归地合并一个或多个数组
     * 将一个或多个数组的单元合并起来，一个数组中的值附加在前一个数组的后面。返回作为结果的数组。
     * 如果输入的数组中有相同的字符串键名，则这些值会被合并到一个数组中去，这将递归下去，因此如果一个值本身是一个数组，本函数将按照相应的条目把它合并为另一个数组。
     * 需要注意的是，如果数组具有相同的数值键名，后一个值将不会覆盖原来的值，而是附加到后面。
     *
     * @param array ...$arrays 数组变量列表，进行递归合并。
     * @return array 一个结果数组，其中的值合并自附加的参数。如果未传递参数调用，则会返回一个空 array。
     */
    public static function arrayMergeRecursive(array ...$arrays) : array
    {
        return array_merge_recursive(...$arrays);
    }





    /**
     * 创建一个数组，用一个数组的值作为其键名，另一个数组的值作为其值
     * 返回一个 array，用来自 keys 数组的值作为键名，来自 values 数组的值作为相应的值。
     *
     * @param array $keys 将被作为新数组的键。非法的值将会被转换为字符串类型（string）。
     * @param array $values 将被作为 Array 的值。
     * @return array 返回合并的 array，如果两个数组的单元数不同则返回 FALSE。
     */
    public static function arrayCombine( array $keys, array $values) : array
    {
        return array_combine($keys, $values);
    }










    // ······································· 多维数组 ·····················································

    /**
     * 返回数组中指定的一列
     * array_column() 返回input数组中键值为column_key的列， 如果指定了可选参数index_key，那么input数组中的这一列的值将作为返回数组中对应值的键。
     *
     * @param array $input 需要取出数组列的多维数组。如果提供的是包含一组对象的数组，只有 public 属性会被直接取出。为了也能取出 private 和 protected 属性，类必须实现 __get() 和 __isset() 魔术方法。
     * @param mixed $column_key 需要返回值的列，它可以是索引数组的列索引，或者是关联数组的列的键，也可以是属性名。也可以是NULL，此时将返回整个数组（配合index_key参数来重置数组键的时候，非常管用）
     * @param mixed $index_key 作为返回数组的索引/键的列，它可以是该列的整数索引，或者字符串键值。
     * @return array 从多维数组中返回单列数组。
     */
    public static function arrayColumn( array $input,  $column_key, $index_key = null ) : array
    {
        return array_column(...func_get_args());
    }


    /**
     * 不可用，改不了
     *
     * 对多个数组或多维数组进行排序
     * 可以用来一次对多个数组进行排序，或者根据某一维或多维对多维数组进行排序。
     * 关联（string）键名保持不变，但数字键名会被重新索引。
     * 如果两个成员完全相同，那么它们在排序数组中的相对顺序是未定义的。
     *
     *
     * array1_sort_flags
     *  为 array 参数设定选项：
     *
     *  排序类型标志：
     *      SORT_REGULAR - 将项目按照通常方法比较（不修改类型）
     *      SORT_NUMERIC - 按照数字大小比较
     *      SORT_STRING - 按照字符串比较
     *      SORT_LOCALE_STRING - 根据当前的本地化设置，按照字符串比较。它会使用 locale 信息，可以通过 setlocale() 修改此信息。
     *      SORT_NATURAL - 以字符串的"自然排序"，类似 natsort()
     *      SORT_FLAG_CASE - 可以组合 (按位或 OR) SORT_STRING 或者 SORT_NATURAL 大小写不敏感的方式排序字符串。
     *  参数可以和 array1_sort_order 交换或者省略，默认情况下是 SORT_REGULAR。
     *
     * @param array $array1 要排序的 array。
     * @param mixed|int $array1_sort_order 之前 array 参数要排列的顺序。 SORT_ASC 按照上升顺序排序， SORT_DESC 按照下降顺序排序。  此参数可以和 array1_sort_flags 互换，也可以完全删除，默认是 SORT_ASC 。
     * @param mixed|int $array1_sort_flags 为 array 参数设定选项： 参数可以和 array1_sort_order 交换或者省略，默认情况下是 SORT_REGULAR。
     * @param mixed ...$arrays 可选的选项，可提供更多数组，跟随在 sort order 和 sort flag 之后。提供的数组和之前的数组要有相同数量的元素。换言之，排序是按字典顺序排列的。
     * @return bool
     */
    public static function _arrayMultisort( array &$array1, &$array1_sort_order = null, &$array1_sort_flags = null, &...$arrays ) : bool
    {
        var_dump(
            $array1_sort_order,
            $array1_sort_flags,
            $arrays
        );

        return true;

        return array_multisort($array1, ...$arrays);
    }






}












