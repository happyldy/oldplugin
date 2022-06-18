<?php


namespace HappyLin\OldPlugin\Test;


use mysql_xdevapi\Exception;
use function Qiniu\entry;

class RedisTest
{

    use TraitTest;

    public $redis;

    public function __construct()
    {


        $redis = new \Redis();
        if (!$redis) {
            echo "未找到 redis 扩展";
            exit();

        }

        $res = $redis->connect('127.0.0.1', 6379); //连接Redis

        if (!$res) {
            echo "redis 连接失败";
            exit();
        }

        $res = $redis->auth('lkiolkd.34534l.64534'); //密码验证
        if (!$res) {
            echo "redis 密码错误";
            exit();
        }

        $this->redis = $redis;


    }


    /**
     * @note 字符串
     */
    public function stringTest()
    {

        $res = $this->redis->set('cfun', 'Welcome!', ['nx', 'ex' => 300]);
        var_dump(static::toStr("设置字符串（会自动序列化数组） set('cfun', 'Welcome!', ['nx', 'ex' => 10])", $res));

        $res = $this->redis->setnx('name', 'boby');
        var_dump(static::toStr("设置字符串;如果键不存在 setnx('name', 'boby')", $res));

        $res = $this->redis->psetex('name', 10, 'cfun');
        var_dump(static::toStr("设置字符串;添加过期时间 毫秒 psetex('name', 10, 'cfun')", $res));

        $res = $this->redis->get('cfun');
        var_dump(static::toStr("获取字符串; get('cfun')", $res));

        $res = $this->redis->getSet('cfun', 'hi man');
        var_dump(static::toStr("获取字符串;并更新字符串 getSet('cfun', 'hi man')", $res));


        $res = $this->redis->strlen('name');
        var_dump(static::toStr("获取字符串长度 strlen('name')", $res));

        $res = $this->redis->getRange('cfun', 0, 3);
        var_dump(static::toStr("截取字符串 getRange('cfun', 0, 3)", $res));

        $res = $this->redis->append('cfun', 'haha');
        var_dump(static::toStr("拼接字符串（键不存则等同set） append('cfun', 'haha')", $res));

        $res = $this->redis->setRange('cfun', 7, ' to Beijing!');
        var_dump(static::toStr("替换字符串，指定偏移量开始，替换为另一指定字符串，成功返回替换后新字符串的长度； setRange('cfun', 7, ' to Beijing!')", $res));


        $res = $this->redis->incr('age');
        var_dump(static::toStr("整型++；加一；键不存在则初始化为0后加一、键值非整型返回false;成功后返回新值； incr('age')", $res));

        $res = $this->redis->incrBy('age', 10);
        var_dump(static::toStr("整型++；比 incr 可以指定存储的数字值增量值； incrBy('age', 10)", $res));

        $res = $this->redis->decr('age');
        var_dump(static::toStr("整型--；减一；将指定 key 存储的数字值减一； decr('age')", $res));

        $res = $this->redis->decrBy('age', 5);
        var_dump(static::toStr("整型--；将指定 key 存储的数字值减去指定减量值； decrBy('age', 5)", $res));


        $res = $this->redis->incrByFloat('age', 1.5);
        var_dump(static::toStr("浮点型++；给指定 key 存储的数字值增加指定浮点数增量。 ； incrByFloat('age', 1.5)", $res));


        $res = $this->redis->mset(['name' => 'cfun', 'age' => 18]);
        var_dump(static::toStr("批量添加字符串；一次设置多个键值对；成功返回 true； mset(['name' => 'cfun', 'age' => 18])", $res));

        $res = $this->redis->msetnx(['country' => 'China', 'city' => 'HangZhou']);
        var_dump(static::toStr("批量添加字符串；所有 key 都不存在的时候才能设置成功!! 成功返回 true； mset(['name' => 'cfun', 'age' => 18])", $res));

        $res = $this->redis->mget(['country', 'city', 'non-existent']);
        var_dump(static::toStr("批量获取字符串；返回一个键值对数组，其中不存在的 key 值为 false； mget(['country', 'city'])", $res));


        $res = $this->redis->del('age', 'city', 'country');
        var_dump(static::toStr("删除一个或多个字段； del('age', 'city', 'country'", $res));


    }


    /**
     * @note 哈希表
     */
    public function hashTest()
    {


        $res = $this->redis->hSet('user', 'name', 'user_name_text');
        $res = $this->redis->hSet('user', 'age', '30');
        $res = $this->redis->hSet('user', 'money', '0');
        $res = $this->redis->hSet('user', 'test', 'text_text');

        $res = $this->redis->hSet('user', 'realname', 'cfun');
        var_dump(static::toStr("字段赋值；若 hash 表不存在会先创建表再赋值，若字段已存在会覆盖旧值； hSet('user', 'realname', 'cfun')", $res));

        $res = $this->redis->hSetNx('user', 'realname', 'cfun');
        var_dump(static::toStr("字段赋值；若 hash 表不存在会先创建表，若字段已存在则不做任何操作。返回bool； hSetNx('user', 'realname', 'cfun')", $res));

        $res = $this->redis->hMset('user', ['name' => 'cfun', 'age' => 18]);
        var_dump(static::toStr("字段批量赋值；同时设置某个 hash 表的多个字段值。成功返回 true； hMset('user', ['name' => 'cfun', 'age' => 18])", $res));

        $res = $this->redis->hIncrBy('user', 'age', 10);
        var_dump(static::toStr("字段加减；指定字段加上指定增量值，若增量值为负数则相当于减法操作。若 hash 表不存在则先创建，若字段不存在则先初始化值为 0 再进行操作，若字段值为字符串则返回 false。设置成功返回字段新值。本操作的值被限制在 64 位(bit)有符号数字表示之内； hIncrBy('user', 'age', 10)", $res));

        $res = $this->redis->hIncrByFloat('user', 'money', 1.5);
        var_dump(static::toStr("字段加减；指定字段加上浮点数增量值。hIncrByFloat('user', 'money', 1.5)", $res));


        $res = $this->redis->hGet('user', 'realname');
        var_dump(static::toStr("获取字段值；若 hash 表不存在则返回 false。hGet('user', 'realname')", $res));

        $res = $this->redis->hMget('user', ['name', 'age', 'qweqwe']);
        var_dump(static::toStr("批量获取字段值；其中不存在的字段值为 false。hMget('user', ['name', 'age'])", $res));

        $res = $this->redis->hStrLen('user', 'realname');
        var_dump(static::toStr("获取字段；字符串长度；如果给定的键或者域不存在，那么命令返回 0。hStrLen('user', 'realname')", $res));


        $res = $this->redis->hDel('user', 'realname', 'test');
        var_dump(static::toStr("删除字段；返回删除数量。hDel('user', 'realname','test' )", $res));

        $res = $this->redis->hExists('user', 'realname');
        var_dump(static::toStr("表格操作；判断字段；判断字段是否存在，返回bool。hExists('user', 'realname')", $res));

        $res = $this->redis->hLen('user');
        var_dump(static::toStr("表格操作；获取表的字段数量。若 hash 表不存在返回 0，若 key 不为 hash 表则返回 false；hLen('user')", $res));

        $res = $this->redis->hKeys('user');
        var_dump(static::toStr("表格操作；获取某个 hash 表所有字段名。hash 表不存在时返回空数组，key 不为 hash 表时返回 false；hKeys('user')", $res));

        $res = $this->redis->hVals('user');
        var_dump(static::toStr("表格操作；获取表所有字段值。hVals('user')", $res));

        $res = $this->redis->hGetAll('user');
        var_dump(static::toStr("表格操作；获取表所有的字段和值。hGetAll('user')", $res));

    }


    /**
     * @note 列表
     */
    public function listTest()
    {


        $res = $this->redis->lPush('city', 'FuZhou', 'ShangHai', 'BeiJing');
        var_dump(static::toStr(
            "添加元素；从 list 头部插入一个或多个值。如果 key 不存在，一个空列表会被创建并执行 LPUSH 操作。当 key 存在但不是列表类型时返回false； 成功返回列表的新长度； lPush('city', 'FuZhou', 'ShangHai', 'BeiJing')",
            $res
        ));

        $res = $this->redis->lPushx('city', 'ShangHai');
        var_dump(static::toStr("添加元素；从 list 头部插入一个值。列表不存在时操作无效；返回列表的新长度； lPush('city', 'ShangHai')", $res));

        $res = $this->redis->rPush('city', 'NanJing');
        var_dump(static::toStr("添加元素；从 list 尾部插入一个或多个值；返回列表的新长度； rPush('city', 'NanJing')", $res));

        $res = $this->redis->rPushx('city', 'NanJing');
        var_dump(static::toStr("添加元素；从 list 尾部插入一个值；列表不存在时操作无效； rPushx('city', 'NanJing')", $res));

        $res = $this->redis->lInsert('city', \Redis::AFTER, 'changsha', 'nanjing');
        var_dump(static::toStr(
            "插入元素； 在列表中指定元素前或后面插入元素。若指定元素不在列表中，或列表不存在时，不执行任何操作。参数：列表 key，Redis::AFTER 或 Redis::BEFORE，基准元素，插入元素；返回值：插入成功返回插入后列表元素个数，若基准元素不存在返回 - 1，若 key 不存在返回 0，若 key 不是列表返回 false。lInsert('city', \Redis::AFTER, 'changsha', 'nanjing')",
            $res
        ));


        $res = $this->redis->lPop('city');
        var_dump(static::toStr("删除元素； 移除并返回列表的第一个元素，若 key 不存在或不是列表则返回 false； lPop('city')", $res));

        $res = $this->redis->blPop('city', 10);
        var_dump(static::toStr(
            "删除元素； 移除并获取列表的第一个元素。如果列表没有元素则会阻塞列表直到等待超时或发现可弹出元素为止。参数：key，超时时间（单位：秒）；返回值：[0=>key,1=>value]，超时返回 []； blPop('city', 10);",
            $res
        ));

        $res = $this->redis->rPop('city');
        var_dump(static::toStr("删除元素； 移除并返回列表的最后一个元素，若 key 不存在或不是列表则返回 false； rPop('city')", $res));

        $res = $this->redis->brPop('city', 10);
        var_dump(static::toStr("删除元素； 移除并获取列表的最后一个元素。如果列表没有元素则会阻塞列表直到等待超时或发现可弹出元素为止。参数：key，超时时间（单位：秒）；返回值：[0=>key,1=>value]，超时返回 []； brPop('city', 10)", $res));

        $res = $this->redis->ltrim('city', 1, 4);
        var_dump(static::toStr("删除元素； 对一个列表进行修剪，只保留指定区间的元素，其他元素都删除。成功返回 true； ltrim('city', 1, 4)", $res));


        $res = $this->redis->lrem('city', 'ShangHai', -2);
        var_dump(static::toStr(
            "删除元素； 根据第三个参数 count 的值，移除列表中与第二个参数相等的元素。count > 0 : 从表头开始向表尾搜索，移除与 value 相等的元素，数量为 count。count < 0 : 从表尾开始向表头搜索，移除与 value 相等的元素，数量为 count 的绝对值。count = 0 : 移除表中所有与 value 相等的值。返回实际删除元素个数； lrem('city', 'ShangHai', -2)",
            $res
        ));


        $res = $this->redis->lLen('city');
        var_dump(static::toStr("列表信息； 获取列表长度； lLen('city')", $res));

        $res = $this->redis->lindex('city', 0);
        var_dump(static::toStr("获取元素； 通过索引获取列表中的元素。若索引超出列表范围则返回 false； lindex('city', 0)", $res));

        $res = $this->redis->lrange('city', 0, -1);
        var_dump(static::toStr("获取元素； 获取列表指定区间中的元素。0 表示列表第一个元素，-1 表示最后一个元素，-2 表示倒数第二个元素； lrange('city', 0, -1)", $res));


        $res = $this->redis->lSet('city', 2, 'changsha');
        var_dump(static::toStr("设置元素； 通过索引设置列表中元素的值。若是索引超出范围，或对一个空列表进行 lset 操作，则返回 false； lSet('city', 2, 'changsha')", $res));


        $res = $this->redis->rpoplpush('city', 'city2');
        var_dump(static::toStr(
            "两个列表； 移除列表中最后一个元素，将其插入另一个列表头部，并返回这个元素。若源列表没有元素则返回 false； rpoplpush('city', 'city2')",
            $res
        ));


        $res = $this->redis->brpoplpush('city', 'city2', 1);
        var_dump(static::toStr(
            "两个列表； 移除列表中最后一个元素，将其插入另一个列表头部，并返回这个元素。如果列表没有元素则会阻塞列表直到等待超时或发现可弹出元素为止。参数：源列表，目标列表，超时时间（单位：秒）超时返回 false； brpoplpush('city', 'city2', 1)",
            $res
        ));


        // 删除 city2
        $res = $this->redis->del('age', 'city2');

    }


    /**
     * @note 集合
     */
    public function setTest()
    {

        $res = $this->redis->sAdd('myset', 'hello', 'world', 'test', 'test1', 'test2');
        var_dump(static::toStr(
            "添加元素，加入一个或多个；已经存在集合中的元素则忽略。若集合不存在则先创建，若 key 不是集合类型则返回 false，若元素已存在返回 +0，插入成功返回 +1；sAdd('myset', 'hello', 'world', 'test', 'test1', 'test2')",
            $res
        ));

        $res = $this->redis->sismember('myset', 'hello');
        var_dump(static::toStr("判断;指定元素是否是指定集合的成员，是返回 true，否则返回 false； sismember('myset', 'hello')", $res));

        $res = $this->redis->sPop('myset');
        var_dump(static::toStr("删除; 移除并返回集合中的一个随机元素； sPop('myset')", $res));

        $res = $this->redis->srem('myset', 'hello');
        var_dump(static::toStr("删除; 移除集合中指定的一个元素，忽略不存在的元素。删除成功返回 1，否则返回 0； srem('myset', 'hello')", $res));

        $res = $this->redis->sRandMember('myset', 2);
        var_dump(static::toStr(
            "获取元素; 返回集合中的一个或多个随机成员元素，返回元素的数量和情况由函数的第二个参数 count 决定：如果 count 为正数，且小于集合基数，那么命令返回一个包含 count 个元素的数组，数组中的元素各不相同。如果 count 大于等于集合基数，那么返回整个集合。如果 count 为负数，那么命令返回一个数组，数组中的元素可能会重复出现多次，而数组的长度为 count 的绝对值；sRandMember('myset', 2)",
            $res
        ));


        $res = $this->redis->sMembers('myset');
        var_dump(static::toStr("获取所有元素; sMembers('myset')", $res));


        $res = $this->redis->scard('myset');
        var_dump(static::toStr("获取集合信息; 获取集合中元素的数量； scard('myset')", $res));


        $res = $this->redis->sMove('myset', 'myset2', 'non-existent');
        var_dump(static::toStr(
            "两集合移动; 将指定成员从一个源集合移动到一个目的集合。若源集合不存在或不包含指定元素则不做任何操作，返回 false。参数：源集合，目标集合，移动元素； sMove('myset', 'myset2', 'non-existent')",
            $res
        ));

        $res = $this->redis->sInter('myset', 'myset2', 'myset3');
        var_dump(static::toStr(
            "多集合交集; 获取所有给定集合的交集，不存在的集合视为空集； sMove('myset', 'myset2', sInter('myset', 'myset2', 'myset3')",
            $res
        ));


        $res = $this->redis->sInterStore('output', 'key1', 'key2', 'key3');
        var_dump(static::toStr(
            "多两集合交集储存; 将所有给定集合的交集存储在指定的output目的集合中。若目的集合已存在则覆盖它。返回交集元素个数。参数：第一个参数为目标集合，存储交集； sMove('myset', 'myset2', sInter('myset', 'myset2', 'myset3')",
            $res
        ));

        $res = $this->redis->sUnion('myset', 'myset2', 'myset3');
        var_dump(static::toStr(
            "多集合并集; 获取所有给定集合的并集，不存在的集合视为空集； sUnion('myset', 'myset2', 'myset3')",
            $res
        ));


        $res = $this->redis->sUnionStore('myset4', 'myset', 'myset2', 'myset3');
        var_dump(static::toStr(
            "多集合并集储存;  将所有给定集合的并集存储在指定的目的集合中。若目的集合已存在则覆盖它。返回并集元素个数。参数：第一个参数为目标集合，存储并集； sUnionStore('myset4', 'myset', 'myset2', 'myset3');",
            $res
        ));


        $res = $this->redis->sDiff('myset', 'myset2', 'myset3');
        var_dump(static::toStr(
            "多集合差集;  获取所有给定集合之间的差集； sUnionStore('myset4', 'myset', 'myset2', 'myset3');",
            $res
        ));


        $res = $this->redis->sDiffStore('myset3', 'myset', 'myset2');
        var_dump(static::toStr(
            "多集合差集储存;  将所有给定集合之间的差集存储在指定的目的集合中。若目的集合已存在则覆盖它。返回差集元素个数。参数：第一个参数为目标集合，存储差集； sUnionStore('myset4', 'myset', 'myset2', 'myset3');",
            $res
        ));


        var_dump(static::toStr(
            "集合迭代;  迭代集合中的元素。参数：key，迭代器变量，匹配模式，每次返回元素数量（默认为 10 个）；sScan('myset',\$iterator, '*', 1);"
        ));

        //SSCAN   $redis->sScan('myset',$iterator, '*', 1);   迭代集合中的元素。参数：key，迭代器变量，匹配模式，每次返回元素数量（默认为 10 个）
        $iterator = null;
        while (false !== ($keys = $this->redis->sScan('myset', $iterator, '*', 1))) {
            foreach ($keys as $key) {
                echo $key . PHP_EOL;
            }
        }

    }


    /**
     * @note 有序集合
     */
    public function sortedSetTest()
    {

        //$res = $this->redis->zAdd('scores', 98, 'English', 90, 'physics');
        $res = $this->redis->zAdd('scores', ['NX'], 98, 'English', 90, 'physics', 95, 'chemistry');
        var_dump(static::toStr(
            "添加元素，将一个或多个成员元素及其分数值加入到有序集当中。如果某个成员已经是有序集的成员，则更新这个成员的分数值，并通过重新插入这个成员元素，来保证该成员在正确的位置上。分数值可以是整数值或双精度浮点数；zAdd('scores', ['NX'], 98, 'English', 90, 'physics', 95, 'chemistry')",
            $res
        ));

        $res = $this->redis->zScore('scores', 'math');
        var_dump(static::toStr(
            "获取元素，获取有序集中指定成员的分数值。若成员不存在则返回 false；zScore('scores', 'math')",
            $res
        ));

        $res = $this->redis->zRange('scores', 0, -1, true);
        var_dump(static::toStr(
            "获取元素，获取有序集中指定区间内的成员。成员按分数值递增排序，分数值相同的则按字典序来排序。参数：第四个参数表示是否返回各个元素的分数值，默认为 false；zRange('scores', 0, -1, true)",
            $res
        ));

        $res = $this->redis->zRevRange('scores', 0, -1, true);
        var_dump(static::toStr(
            "获取元素，获取有序集中指定区间内的成员。其中成员的位置按 score 值递减(从大到小)来排列。 具有相同 score 值的成员按字典序的逆序；zRevRange('scores', 0, -1, true)",
            $res
        ));


        $res = $this->redis->zRangeByScore('scores', 90, 100, ['withscores' => true]);
        var_dump(static::toStr(
            "获取元素，获取有序集中所有 score 值介于 min 和 max 之间(包括等于 min 或 max )的成员。有序集成员按 score 值递增(从小到大)次序排列。可选的 LIMIT 参数指定返回结果的数量及区间(就像SQL中的 SELECT LIMIT offset, count )；zRangeByScore('scores', 90, 100, ['withscores'=>true]) ",
            $res
        ));

        $res = $this->redis->zRevRangeByScore('scores', 100, 90, ['withscores' => true]);
        var_dump(static::toStr(
            "获取元素，获取有序集中指定分数区间的成员列表，按分数值递减排序，分数值相同的则按字典序的逆序来排序。注意，区间表示的时候大值在前，小值在后，默认使用闭区间；zRevRangeByScore('scores', 100, 90, ['withscores'=>true])",
            $res
        ));


        $res = $this->redis->zRank('scores', 'chemistry');
        var_dump(static::toStr(
            "元素排名，有序集中指定成员的排名，按分数值递增排序。分数值最小者排名为 0；zRank('scores', 'chemistry')",
            $res
        ));

        $res = $this->redis->zRevRank('scores', 'chemistry');
        var_dump(static::toStr(
            "元素排名，有有序集中指定成员的排名，按分数值递减排序。分数值最大者排名为 0；zRank('scores', 'chemistry')",
            $res
        ));


        $res = $this->redis->zRem('scores', 'chemistry', 'English');
        var_dump(static::toStr(
            "删除元素，移除有序集中的一个或多个成员，忽略不存在的成员。返回删除的元素个数；zRem('scores', 'chemistry', 'English')",
            $res
        ));


        $res = $this->redis->zRemRangeByRank('scores', 0, 2);
        var_dump(static::toStr(
            "删除元素，移除有序集中指定排名区间的所有成员；zRemRangeByRank('scores', 0, 2)",
            $res
        ));

        $res = $this->redis->zRemRangeByScore('scores', 80, 90);
        var_dump(static::toStr(
            "删除元素，移除有序集中指定分数值区间的所有成员；zRemRangeByScore('scores', 80, 90)",
            $res
        ));


        $res = $this->redis->zRemRangeByScore('scores', 80, 90);
        var_dump(static::toStr(
            "删除元素，移除有序集中指定分数值区间的所有成员；zRemRangeByScore('scores', 80, 90)",
            $res
        ));


        $res = $this->redis->zIncrBy('scores', 2, 'Chinese');
        var_dump(static::toStr(
            "元素++，对有序集中指定成员的分数值增加指定增量值。若为负数则做减法，若有序集不存在则先创建，若有序集中没有对应成员则先添加，最后再操作；zIncrBy('scores', 2, 'Chinese')",
            $res
        ));


        $res = $this->redis->zCard('scores');
        var_dump(static::toStr(
            "集合信息，获取指定有序集的元素数量；zCard('scores')",
            $res
        ));

        $res = $this->redis->zCount('scores', 90, 100);
        var_dump(static::toStr(
            "集合信息，指定分数区间的成员数量；zCount('scores', 90, 100)",
            $res
        ));


        $res = $this->redis->zRangeByLex('key', '-', '[c');
        var_dump(static::toStr(
            "分数相同时，有序集合的元素会根据成员的字典序（lexicographical ordering）来进行排序， 而这个命令则可以返回给定的有序集合键 key 中， 值介于 min 和 max 之间的成员。合法的 min 和 max 参数必须包含 ( 或者 [ ， 其中 ( 表示开区间）， 而 [ 则表示闭区间； + 表示正无限， 而 - 表示负无限；zRangeByLex('key', '-', '[c');"
        //,$res
        ));

        $res = $this->redis->zRangeByLex('key', '-', '[c');
        var_dump(static::toStr(
            "分数相同时，zRangeByLex的倒序；zRevRangeByLex(\$key, \$min, \$max, \$offset = null, \$limit = null) "
        //,$res
        ));

        var_dump(static::toStr(
            "ZLEXCOUNT(php Redis.php没有这个函数)   分数相同时，所有成员的分值都相同返回该集合中， 成员介于 min 和 max 范围内的元素数量。"
        ));


        var_dump(static::toStr(
            "多集合并集计算储存； 计算给定一个或多个有序集的并集，并将其存储到一个目的有序集中。结果集中某个成员的分数值是所有给定集下该成员分数值之和。返回值保存到 destination 的结果集的基数。zUnionStore('ko2', array('k1', 'k2'), array(1, 1),'sum');"
        ));


        var_dump(static::toStr(
            "多集合交集集计算储存；计算给定一个或多个有序集的交集，并将其存储到一个目的有序集中。结果集中某个成员的分数值是所有给定集下该成员分数值之和。返回值保存到 destination 的结果集的基数。zInterStore('ko4', array('k1', 'k2'), array(1, 5), 'max');"
        ));


        var_dump(static::toStr(
            "集合迭代;  迭代集合中的元素。ZSCAN;  zScan('zset', \$iterator)"
        ));
        //ZSCAN
        $iterator = null;
        while ($members = $this->redis->zScan('zset', $iterator)) {
            foreach ($members as $member => $score) {
                echo $member . ' => ' . $score . PHP_EOL;
            }
        }

    }


    /**
     * @note 地理位置
     */
    public function geoTest()
    {
        $res = $this->redis->geoAdd('myplaces', 119.317239, 26.018547, 'gaoGaiShan', 119.30919, 26.050101, 'JiangXin', 119.315694, 26.041856, 'shiFan');
        var_dump(static::toStr(
            "添加空间坐标；",
            "命令以标准的x,y格式接受参数，先输入经度，再输入纬度。GEOADD 能够记录的坐标是有限的： 非常接近两极的区域是无法被索引的。 精确的坐标限制由 EPSG:900913 / EPSG:3785 / OSGEO:41001 等坐标系统定义: ",
            "\n有效的经度介于 -180 度至 180 度之间\n有效的纬度介于 -85.05112878 度至 85.05112878 度之间。",
            "\ngeoAdd('myplaces',119.317239, 26.018547, 'gaoGaiShan', 119.30919, 26.050101, 'JiangXin',  119.315694,26.041856, 'shiFan');",
            $res
        ));


        $res = $this->redis->geoPos("myplaces", 'San Francisco', "Honolulu", "Maui");
        var_dump(static::toStr(
            "获取空间坐标；返回一个数组，每个项都给定位置元素的经度和纬度。 当给定的位置元素不存在时， 对应的数组项为空值。geoPos(\"myplaces\", 'San Francisco', \"Honolulu\", \"Maui\")",
            $res
        ));


        $res = $this->redis->geoDist('myplaces', 'Honolulu', 'San Francisco', 'km');
        var_dump(static::toStr(
            "计算距离；两个给定位置之间的距离。如果两个位置之间的其中一个不存在， 那么命令返回空值(默认使用米作为单位); geoDist('myplaces', 'Honolulu', 'San Francisco', 'km');)",
            $res
        ));


        $res = $this->redis->geoRadius('myplaces', 119.308759, 26.042376, 1500, 'm', ['WITHDIST', 'DESC']);
        var_dump(static::toStr(
            "半径筛选；以给定的经纬度为中心， 返回键包含的位置元素当中， 与中心的距离不超过给定最大距离的所有位置元素; geoRadius('myplaces', 119.308759,26.042376, 1500, 'm',['WITHDIST','DESC'])",
            $res
        ));


        $res = $this->redis->geoRadiusByMember('myplaces', 'shiFan', 1500, 'm', ['count' => 2]);
        var_dump(static::toStr(
            "半径筛选；与 GEORADIUS 命令不同点是；GEORADIUSBYMEMBER 的中心点是由给定的位置元素决定的， 而不是使用输入的经度和纬度来决定中心点；geoRadiusByMember('myplaces', 'shiFan', 1500, 'm', ['count' => 2])",
            $res
        ));


        $res = $this->redis->geoHash('myplaces', 'gaoGaiShan', 'JiangXin');
        var_dump(static::toStr(
            "获取geohash值；返回一个数组。 返回的 geohash 的位置与用户给定的位置元素的位置一一对应；geoHash('myplaces', 'gaoGaiShan', 'JiangXin')",
            $res
        ));


        var_dump(static::toStr(
            "其它:
            m 表示单位为米。
            km 表示单位为千米。
            mi 表示单位为英里。
            ft 表示单位为英尺
            
            WITHDIST ： 在返回位置元素的同时， 将位置元素与中心之间的距离也一并返回。 距离的单位和用户给定的范围单位保持一致。
            WITHCOORD ： 将位置元素的经度和维度也一并返回。
            WITHHASH ： 以 52 位有符号整数的形式， 返回位置元素经过原始 geohash 编码的有序集合分值。 这个选项主要用于底层应用或者调试， 实际中的作用并不大。
            
            ASC ： 根据中心的位置， 按照从近到远的方式返回位置元素。
            DESC ： 根据中心的位置， 按照从远到近的方式返回位置元素。
            COUNT \<count\> 选项去获取前 N 个匹配元素"
        ));


    }


    /**
     * @note HyperLogLog 基数统计的算法
     */
    public function HyperLogLogTest()
    {

        $res = $this->redis->pfAdd('HyperLogLogDataBase', array('mysql', 'redis', 'MongoDB'));
        var_dump(static::toStr(
            "增加；如果 HyperLogLog 估计的近似基数（approximated cardinality）在命令执行之后出现了变化，那么命令返回1，否则返回0。 如果命令执行时给定的键不存在，那么程序将先创建一个空的 HyperLogLog 结构， 然后再执行命令；pfAdd('HyperLogLogDataBase', array('mysql', 'redis', 'MongoDB'))",
            $res
        ));


        $res = $this->redis->pfCount('HyperLogLogDataBase');
        var_dump(static::toStr(
            "统计一个或多个并集已累计的数量；命令作用于单个键时，【命令作用于多个键时， 返回所有给定 HyperLogLog 的并集的近似基数，这个近似基数是通过将所有给定 HyperLogLog 合并至一个临时 HyperLogLog】返回储存在给定键的 HyperLogLog 的近似基数，如果键不存在，那么返回0；pfCount('HyperLogLogDataBase')",
            $res
        ));


        $res = $this->redis->pfMerge('HyperLogLogDataBase0', array('HyperLogLogDataBase'));
        var_dump(static::toStr(
            "合并； 将多个 HyperLogLog 合并（merge）为一个 HyperLogLog ， 合并后的 HyperLogLog 的基数接近于所有输入 HyperLogLog 的可见集合（observed set）的并集。如果该键并不存在， 那么命令在执行之前， 会先为该键创建一个空的; pfMerge('HyperLogLogDataBase0', array('HyperLogLogDataBase'))",
            $res
        ));

    }


    /**
     * @note 数据库操作
     */
    public function databaseTest()
    {

        $res = $this->redis->exists('cfun', 'bar', 'baz');
        var_dump(static::toStr(
            "判断键存在；exists('cfun', 'bar', 'baz')",
            $res
        ));

        $res = $this->redis->type('cfun');
        var_dump(static::toStr(
            "判断键类型； * - string: Redis::REDIS_STRING * - set:   Redis::REDIS_SET* - list:  Redis::REDIS_LIST * - zset:  Redis::REDIS_ZSET* - hash:  Redis::REDIS_HASH * - other: Redis::REDIS_NOT_FOUND；type('cfun')",
            $res
        ));


        $res = $this->redis->rename('cfun', 'cfunBak');
        var_dump(static::toStr(
            "修改键名称；将 key 改名为 newkey 。当 key 和 newkey 相同，或者 key 不存在时，返回一个错误。当 newkey 已经存在时， RENAME 命令将覆盖旧值， 返回bool；rename('cfun', 'cfunBak')",
            $res
        ));

        $res = $this->redis->renameNx('cfun', 'cfunBak');
        var_dump(static::toStr(
            "修改键名称；将 key 改名为 newkey 。当 key 和 newkey 相同，或者 key 不存在时，返回一个错误。当 newkey 已经存在时， RENAMENX 返回0， 返回bool；rename('cfun', 'cfunBak')",
            $res
        ));


        $res = $this->redis->del('cfunBak', 'non-existent');
        var_dump(static::toStr(
            "删除一个或多个键；删除给定的一个或多个 key 。不存在的 key 会被忽略。返回值被删除 key 的数量；del('cfunBak', 'non-existent')",
            $res
        ));


        $res = $this->redis->keys('user*');;
        var_dump(static::toStr(
            "查找键；查找所有符合给定模式 pattern 的 key用scan代替（SCAN   有scan、sscan、hscan、zscan）；keys('user*');",
            $res
        ));


        $res = $this->redis->randomKey();
        var_dump(static::toStr(
            "查找键；从当前数据库中随机返回(不删除)一个 key",
            $res
        ));


        $res = $this->redis->dbSize();
        var_dump(static::toStr(
            "数据库信息：获取当前数据库的 key 的数量； dbSize()",
            $res
        ));


        var_dump(static::toStr(
            "操作数据库：清空当前数据库中的所有 key； flushDB()"
        ));

        //$res = $this->redis->move('cfunBak', 1);
        var_dump(static::toStr(
            "多个库；切换到指定的数据库，数据库索引号 index 用数字值指定，以 0 作为起始索引值。select(0)"
        ));
        var_dump(static::toStr(
            "多个库数据转移；将当前数据库的 key 移动到给定的数据库 db 当中；move('cfunBak', 1)"
        ));
        var_dump(static::toStr(
            "多个库数据转移；对换指定的两个数据库， 使得两个数据库的数据立即互换；swapdb(0, 1)"
        ));


        var_dump(static::toStr(
            "操作所有数据库： 清空整个 Redis 服务器的数据； flushAll()"
        ));


        var_dump(static::toStr(
            "持久化:
            SAVE   \$redis->save()；将当前 Redis 实例的所有数据快照(snapshot)以 RDB 文件的形式保存到硬盘
            BGSAVE   \$redis->bgSave();   在后台异步(Asynchronously)保存当前数据库的数据到磁盘。客户端可以通过 LASTSAVE 命令查看相关信息，判断 BGSAVE 命令是否执行成功。
            BGREWRITEAOF   \$redis->bgrewriteaof();  执行一个 AOF文件 重写操作。重写会创建一个当前 AOF 文件的体积优化版本。AOF 重写由 Redis 自行触发， BGREWRITEAOF 仅仅用于手动触发重写操作。
            LASTSAVE   \$redis->lastSave();   返回最近一次 Redis 成功将数据保存到磁盘上的时间，以 UNIX 时间戳格式表示。"
        ));

        var_dump(static::toStr(
            "配置选项 :
                CONFIG_SET   命令可以动态地调整 Redis 服务器的配置(configuration)而无须重启。
                CONFIG_GET
                     * \$redis->config(\"GET\", \"*max-*-entries*\");
                     * \$redis->config(\"SET\", \"dir", "/var/run/redis/dumps/\");
                CONFIG_RESETSTAT   重置 INFO 命令中的某些统计数据，
                CONFIG_REWRITE   命令对启动 Redis 服务器时所指定的 redis.conf 文件进行改写： 因为 CONFIG_SET 命令可以对服务器的当前配置进行修改， 而修改后的配置可能和 redis.conf 文件中所描述的配置不一样， CONFIG REWRITE 的作用就是通过尽可能少的修改， 将服务器当前所使用的配置记录到 redis.conf 文件中。"
        ));





    }


    /**
     * @note 自动过期
     */
    public function expireTest()
    {
        $this->redis->set('cfun', 'Welcome!', ['nx', 'ex' => 300]);

        $res = $this->redis->expire('cfun', 180);
        var_dump(static::toStr(
            "设置生存时间；按秒数；当 key 过期时(生存时间为 0 )，它会被自动删除；expire('cfun', 300)",
            $res
        ));

        $res = $this->redis->pExpire('cfun', 180000);
        var_dump(static::toStr(
            "设置生存时间；按毫秒；pExpire('cfun', 180000)",
            $res
        ));


        var_dump($this->redis->get('cfun'));

        $res = $this->redis->expireAt('cfun', time() + 60);
        var_dump(static::toStr(
            "设置生存时间；按时间戳（秒）； 和 EXPIRE 不同在于 EXPIREAT 命令接受的时间参数是 UNIX 时间戳(unix timestamp); expireAt('cfun', time() + 60)",
            $res
        ));


        //$msecond = ((time() + 30) *1000);
        //$res = $this->redis->pExpireAt('cfun', 1652416949000000);
        var_dump(static::toStr(
            "设置生存时间；{ 实际运行没成功-未执行 }按时间戳（毫秒）；  pExpireAt('cfun', (time() + 30) *1000)"
        ));


        $res = $this->redis->ttl('cfun');
        var_dump(static::toStr(
            "获取剩余生存时间; 秒； 当 key 不存在时，返回 -2 。 当 key 存在但没有设置剩余生存时间时，返回 -1； ttl('cfun')",
            $res
        ));
        $res = $this->redis->pttl('cfun');
        var_dump(static::toStr(
            "获取剩余生存时间; 毫秒 pttl('cfun')",
            $res
        ));

        $res = $this->redis->persist('cfun');;
        var_dump(static::toStr(
            "设置永久生存时间; 将这个 key 从“易失的”(带生存时间 key )转换成“持久的”(一个不带生存时间、永不过期的 key )；persist('cfun')",
            $res
        ));


        $res = $this->redis->ttl('cfun');
        var_dump(static::toStr(
            "获取剩余生存时间; ttl('cfun')",
            $res
        ));

    }


    /**
     * @note 排序；列表，外键哈希排序
     */
    public function sortTest()
    {
        $res = $this->redis->del('sortFloatListTest', 'sortStringListTest', 'sortStringListTestRes', 'sortUid');

        $res = $this->redis->lPush('sortFloatListTest', 30, 1.5, 10, 8, 25);
        $res = $this->redis->sort('sortFloatListTest', array('sort' => 'desc'));
        var_dump(static::toStr(
            "简单排序；sort：默认升序asc, 降序 desc; 排序默认以数字作为对象，值被解释为双精度浮点数，然后进行比较; lPush('sortFloatListTest', 30,1.5,10,8,25); sort('sortFloatListTest', array('sort' => 'desc'))",
            $res
        ));

        $res = $this->redis->lPush('sortStringListTest', 'www.b', 'www.d', 'www.a', 'www.e', 'www.c');
        $res = $this->redis->sort('sortStringListTest', array('sort' => 'desc', 'alpha' => TRUE));
        var_dump(static::toStr(
            "字符串排序；ALPHA：需要显式地在 SORT 命令之后添加 ALPHA 修饰符; lPush('sortStringListTest', 'www.b','www.d','www.a','www.e','www.c'); sort('sortStringListTest', array('sort' => 'desc'));",
            $res
        ));


        $res = $this->redis->sort('sortStringListTest', array('sort' => 'desc', 'alpha' => TRUE, 'limit' => array(1, 3)));
        var_dump(static::toStr(
            "截取部分排序，limit offset count；sort('sortStringListTest', array('sort' => 'desc','alpha' => TRUE, 'limit' => array(1, 3)));",
            $res
        ));


        $res = $this->redis->sort('sortStringListTest', array('sort' => 'desc', 'alpha' => TRUE, 'limit' => array(1, 3), 'store' => 'sortStringListTestRes'));
        var_dump(static::toStr(
            "保存结果，STORE;  \nsort('sortStringListTest', array('sort' => 'desc','alpha' => TRUE, 'limit' => array(1, 3),'store' => 'sortStringListTestRes'));",
            "\nlrange('sortStringListTestRes', 0, -1)",
            $this->redis->lrange('sortStringListTestRes', 0, -1)
        ));


        $res = $this->redis->lPush('sortUid', 1, 2, 3, 4);
        $res = $this->redis->hMset('user:1', ['name' => 'foo', 'age' => 18]);
        $res = $this->redis->hMset('user:2', ['name' => 'bar', 'age' => 50]);
        $res = $this->redis->hMset('user:3', ['name' => 'baz', 'age' => 20]);
        $res = $this->redis->hMset('user:4', ['name' => 'foobar', 'age' => 10]);

        $res = $this->redis->sort('sortUid', array('by' => 'user:*->age', 'get' => ['user:*->age', 'user:*->name']));
        var_dump(static::toStr("使用外部 key 进行排序，BY;",
            "预定义哈希数据：
        \$this->redis->lPush('sortUid', 1,2,3,4);
        \$this->redis->hMset('user:1', ['name' => 'foo', 'age' => 18]);
        \$this->redis->hMset('user:2', ['name' => 'bar', 'age' => 50]);
        \$this->redis->hMset('user:3', ['name' => 'baz', 'age' => 20]);
        \$this->redis->hMset('user:4', ['name' => 'foobar', 'age' => 10]);",
            "\nsort('sortUid', array('by' => 'user:*->age','get' => ['user:*->age','user:*->name']));",
            $res
        ));


    }


    /**
     * @note 对数据集进行一次完整迭代
     */
    public function scanTest()
    {

        $res = $this->redis->del(
            'scanString:1', 'scanString:2', 'scanString:3',
            'scanHash:1', 'scanHash:2', 'scanHash:3',
            'scanset',
            'scansortSet'
        );


        // 字符串迭代
        $this->redis->set('scanString:1', 'Welcome1!', ['ex' => 100]);
        $this->redis->set('scanString:2', 'Welcome2!', ['ex' => 100]);
        $this->redis->set('scanString:3', 'Welcome3!', ['ex' => 100]);
        var_dump(static::toStr(
            "字符串迭代： 
            set('scanString:1', 'Welcome1!', ['ex' => 100]);
            set('scanString:2', 'Welcome2!', ['ex' => 100]);
            set('scanString:3', 'Welcome3!', ['ex' => 100]);
            scan(\$iterator, 'scanString*','1')"
        ));
        $iterator = null;
        while (false !== ($keys = $this->redis->scan($iterator, 'scanString*', 1))) {
            foreach ($keys as $key) {
                echo $key . PHP_EOL;
            }
        }

        // 哈希迭代
        var_dump(static::toStr(
            "哈希迭代： 
            hMset('scanHash:1', ['name' => 'foo', 'nameCode' => 18, 'age' => 18])
            hScan('scanHash:1',\$iterator, 'name*',2)"
        ));
        $this->redis->hMset('scanHash:1', ['name' => 'foo', 'nameCode' => 18, 'age' => 18]);
        $iterator = null;
        while (false !== ($keys = $this->redis->hScan('scanHash:1', $iterator, 'name*', 2))) {
            foreach ($keys as $key) {
                echo $key . PHP_EOL;
            }
        }


        // 集合迭代
        var_dump(static::toStr(
            "集合迭代： 
            sAdd('scanset', 'hello', 'world', 'test', 'test1', 'test2');
            sScan('smyset1',\$iterator, 'test*',2)"
        ));
        $this->redis->sAdd('scanset', 'hello', 'world', 'test', 'test1', 'test2');
        $iterator = null;
        while (false !== ($keys = $this->redis->sScan('scanset', $iterator, 'test*', 2))) {
            foreach ($keys as $key) {
                echo $key . PHP_EOL;
            }
        }


        // 有序集合迭代
        var_dump(static::toStr(
            "有序集合迭代： 
            zAdd('scansortSet', ['NX'],98, 'English', 90, 'physics', 95, 'chemistry');
            zScan('scansortSet', \$iterator)"
        ));
        $this->redis->zAdd('scansortSet', ['NX'], 98, 'English', 90, 'physics', 95, 'chemistry');
        $iterator = null;
        while ($members = $this->redis->zScan('scansortSet', $iterator, 'Eng*', 1)) {
            foreach ($members as $member => $score) {
                echo $member . ' => ' . $score . PHP_EOL;
            }
        }

    }


    /**
     * @note 事务
     */
    public function transactionTest()
    {


        var_dump(static::toStr(
            "Redis 不支持回滚； 
            Redis 脚本和事务：从定义上来说， Redis 中的脚本本身就是一种事务， 所以任何在事务里可以完成的事， 在脚本里面也能完成。 并且一般来说， 使用脚本要来得更简单，并且速度更快。"
        ));

        var_dump(static::toStr(
            "MULTI  multi()； 标记一个事务块的开始。
                EXEC  exec(); 执行所有事务块内的命令。
                DISCARD   discard();取消事务，放弃执行事务块内的所有命令。同时也会取消所有对 key 的监视
                WATCH   watch('x');   监视一个(或多个) key ，如果在事务执行之前这个(或这些) key 被其他命令所改动，那么事务将被打断。
                UNWATCH   unwatch();  取消 WATCH 命令对所有 key 的监视。"
        ));


        var_dump(static::toStr(
            "\n如果在执行 WATCH 命令之后， EXEC 命令或 DISCARD 命令先被执行了的话，那么就不需要再执行 UNWATCH 了。 因为 EXEC 命令会执行事务，因此 WATCH 命令的效果已经产生了；而 DISCARD 命令在取消事务的同时也会取消所有对 key 的监视，因此这两个命令执行之后，就没有必要执行 UNWATCH 了。"
        ));
        var_dump(static::toStr(
            "示例看注释！！"
        ));

        // 如果在执行 WATCH 命令之后， EXEC 命令或 DISCARD 命令先被执行了的话，那么就不需要再执行 UNWATCH 了。 因为 EXEC 命令会执行事务，因此 WATCH 命令的效果已经产生了；而 DISCARD 命令在取消事务的同时也会取消所有对 key 的监视，因此这两个命令执行之后，就没有必要执行 UNWATCH 了。

        /*         $res = $redis->multi()
                     ->set('key1', 'val1')
                      ->get('key1')
                      ->set('key2', 'val2')
                      ->get('key2')
                      ->exec();*/

        /**
         *
         * <pre>
         * $redis->watch('x');
         * // long code here during the execution of which other clients could well modify `x`
         * $ret = $redis->multi()
         *          ->incr('x')
         *          ->exec();
         * // $ret = FALSE if x has been modified between the call to WATCH and the call to EXEC.
         * </pre>
         *
         *
         *
         * <pre>
         * $redis->watch('x');
         * // long code here during the execution of which other clients could well modify `x`
         * $ret = $redis->multi()
         *          ->incr('x')
         *          ->exec();
         * // $ret = FALSE if x has been modified between the call to WATCH and the call to EXEC.
         * </pre>
         *
         *
         *
         *
         * <pre>
         * $ret = $this->redis->pipeline()
         *      ->ping()
         *      ->multi()->set('x', 42)->incr('x')->exec()
         *      ->ping()
         *      ->multi()->get('x')->del('x')->exec()
         *      ->ping()
         *      ->exec();
         * //$ret == array (
         * //    0 => '+PONG',
         * //    1 => [TRUE, 43],
         * //    2 => '+PONG',
         * //    3 => [43, 1],
         * //    4 => '+PONG');
         * </pre>
         *
         *
         *
         */


    }

    /**
     * https://redis.io/docs/manual/programmability/eval-intro/
     * @note 脚本
     */
    public function scriptTest()
    {

        $this->redis->script('flush');
        $this->redis->del('mylist');
        $this->redis->lPush('mylist', 'mylist1', 'mylist2', 'mylist3');


        $res = $this->redis->eval("return {1,2,3,redis.call('LRANGE','mylist',0,-1)}");
        var_dump(static::toStr(
            "直接执行；脚本会以原子性(atomic)的方式执行；脚本应该被写成纯函数(pure function)。 redis.call()【发生错误时，脚本会停止执行】 和 redis.pcall() 【出错时并不引发(raise)错误，而是返回一个带 err 域的 Lua 表(table)，用于表示错误：】的唯一区别在于它们对错误处理的不同。
            eval(\"return {1,2,3,redis.call('lrange','mylist',0,-1)}}\")",
            $res
        ));


        $sha = $this->redis->script('load', "return {1,2,3,redis.call('LRANGE','mylist',0,-1)}");
        var_dump(static::toStr(
            "缓存脚本；将一个脚本装入脚本缓存，但并不立即运行它； script('load', \"return {1,2,3,redis.call('LRANGE','mylist',0,-1)}\")",
            $sha
        ));


        $res = $this->redis->script('exists', $sha, 'sdfsdfsdfsdf');
        var_dump(static::toStr(
            "判断脚本存在；给定一个或多个脚本的 SHA1 校验和，返回一个包含 0 和 1 的列表； script('exists', $sha, 'sdfsdfsdfsdf')",
            $res
        ));


        $res = $this->redis->evalSha($sha);
        var_dump(static::toStr(
            "执行缓存脚本；evalSha($sha)",
            $res
        ));


        try {
            $res = $this->redis->script('kill');
        } catch (\Exception $e) {
            $res = ('执行成功返回 OK ，否则返回一个错误; 进入错误了');
        }
        var_dump(static::toStr(
            "杀死当前正在运行的脚本；假如当前正在运行的脚本已经执行过写操作，那么即使执行 SCRIPT KILL ，也无法将它杀死，因为这是违反 Lua 脚本的原子性执行原则的。在这种情况下，唯一可行的办法是使用 SHUTDOWN NOSAVE 命令，通过停止整个 Redis 进程来停止脚本的运行；script('kill');",
            $res
        ));

        $res = $this->redis->script('flush');
        var_dump(static::toStr(
            "清除所有脚本缓存；script('flush')",
            $res
        ));

    }


    /**
     * 参考： https://www.cnblogs.com/zhoujinyi/p/11664392.html
     * @note  展示infoTest()信息
     */
    public function showInfoMsg(array $info, string $type)
    {
        $type = strtolower($type);
        $msg = array(
            'server' =>
                [
                    'redis_version' => 'Redis 服务器版本',
                    'redis_git_sha1' => 'Git SHA1',
                    'redis_git_dirty' => 'Git dirty flag',
                    'redis_build_id' => '构建ID',
                    'redis_mode' => 'Redis启动模式：standalone、Sentinel、Cluster',
                    'os' => 'Redis 服务器的宿主操作系统',
                    'arch_bits' => '架构（32 或 64 位）',
                    'multiplexing_api' => 'Redis 所使用的事件处理机制',
                    'gcc_version' => '编译 Redis 时所使用的 GCC 版本    ',
                    'process_id' => '服务器进程的 PID',
                    'run_id' => 'Redis 服务器的随机标识符（用于 Sentinel 和集群',
                    'tcp_port' => 'TCP/IP 监听端口',
                    'uptime_in_seconds' => '自 Redis 服务器启动以来，经过的秒数',
                    'uptime_in_days' => '自 Redis 服务器启动以来，经过的天数',
                    'hz' => '调度serverCron每秒运行次数',
                    'configured_hz' => '',
                    'lru_clock' => '以分钟为单位进行自增的时钟，用于 LRU 管理',
                ],
            'clients' => [
                'connected_clients' => '已连接客户端的数量（不包括通过从属服务器连接的客户端）',
                'client_recent_max_output_buffer' => '当前连接的客户端当中，最长的输出列表',
                'client_recent_max_input_buffer' => '当前连接的客户端当中，最大输入缓存',
                'blocked_clients' => '正在等待阻塞命令（BLPOP、BRPOP、BRPOPLPUSH）的客户端的数量',
            ],

            'memory' =>
                [
                    'used_memory' => '由 redis 分配器（标准libc，jemalloc或其他分配器，例如tcmalloc）分配的内存总量，以字节（byte）为单位',
                    'used_memory_human' => '以可读的格式返回 redis 分配的内存总量',
                    'used_memory_rss' => '从操作系统的角度，返回 Redis 已分配的内存总量（俗称常驻集大小）。这个值和 top、ps 等命令的输出一致。',
                    'used_memory_rss_human' => '以可读的格式,操作系统角度,返回 redis 分配的内存总量',
                    'used_memory_peak' => 'redis 的内存消耗峰值（以字节为单位）',
                    'used_memory_peak_human' => '以可读的格式,返回 Redis 的内存消耗峰值',
                    'used_memory_peak_perc' => 'used_memory_peak在used_memory中所占的百分比，即(used_memory / used_memory_peak) *100%',
                    'used_memory_overhead' => '分配用于管理其内部数据结构的所有开销的总字节数，即维护数据集的内部机制所需的内存开销，包括所有客户端输出缓冲区、查询缓冲区、AOF重写缓冲区和主从复制的backlog',
                    'used_memory_startup' => '启动时消耗的初始内存量（以字节为单位）',
                    'used_memory_dataset' => '数据集的大小（以字节为单位，used_memory - used_memory_overhead）',
                    'used_memory_dataset_perc' => 'used_memory_dataset在净内存（used_memory-used_memory_startup）使用量中所占的百分比',
                    'allocator_allocated' => '分配器分配的内存',
                    'allocator_active' => '分配器活跃的内存',
                    'allocator_resident' => '分配器常驻的内存',
                    'total_system_memory' => '主机拥有的内存总量',
                    'total_system_memory_human' => '以可读的格式返回主机拥有的内存总量',
                    'used_memory_lua' => 'Lua引擎使用的字节数',
                    'used_memory_lua_human' => '以可读的格式返回Lua引擎使用内存',
                    'used_memory_scripts' => '',
                    'used_memory_scripts_human' => '',
                    'number_of_cached_scripts' => '',
                    'maxmemory' => '配置设置的最大可使用内存值，默认0，不限制',
                    'maxmemory_human' => '以可读的格式返回最大可使用内存值',
                    'maxmemory_policy' => '内存容量超过maxmemory后的处理策略,noeviction当内存使用达到阈值的时候，所有引起申请内存的命令会报错',
                    'allocator_frag_ratio' => '分配器的碎片率',
                    'allocator_frag_bytes' => '分配器的碎片大小（以字节为单位）',
                    'allocator_rss_ratio' => '分配器常驻内存比例',
                    'allocator_rss_bytes' => '分配器的常驻内存大小（以字节为单位）',
                    'rss_overhead_ratio' => '常驻内存开销比例',
                    'rss_overhead_bytes' => '常驻内存开销大小(以字节为单位)',
                    'mem_fragmentation_ratio' => '内存碎片率，used_memory_rss 和 used_memory 之间的比率',
                    'mem_fragmentation_bytes' => '内存碎片的大小（以字节为单位）',
                    'mem_not_counted_for_evict' => '被驱逐的大小',
                    'mem_replication_backlog' => 'repl_backlog',
                    'mem_clients_slaves' => 'clients_slaves',
                    'mem_clients_normal' => 'clients_normal',
                    'mem_aof_buffer' => 'aof时，占用的缓冲',
                    'mem_allocator' => '内存分配器（在编译时选择）',
                    'active_defrag_running' => '碎片整理是否处于活动状态',
                    'lazyfree_pending_objects' => '等待释放的对象数（由于使用ASYNC选项调用UNLINK或FLUSHDB和FLUSHALL）',

                ],

            'persistence' =>
                [

                    'loading' => '记录服务器是否正在载入持久化文件',
                    'rdb_changes_since_last_save' => '最近一次成功创建持久化文件之后，产生操作的次数',
                    'rdb_bgsave_in_progress' => '记录了服务器是否正在创建 RDB 文件',
                    'rdb_last_save_time' => '最近一次成功创建 RDB 文件的 UNIX 时间戳',
                    'rdb_last_bgsave_status' => '记录最近一次创建 RDB 文件的状态，是成功还是失败',
                    'rdb_last_bgsave_time_sec' => '记录了最近一次创建 RDB 文件耗费的秒数',
                    'rdb_current_bgsave_time_sec' => '如果正在创建 RDB 文件，记录当前的创建操作已经耗费的秒数',
                    'rdb_last_cow_size' => '上一次RBD保存操作期间写时复制的大小（以字节为单位）',
                    'aof_enabled' => 'AOF是否开启',
                    'aof_rewrite_in_progress' => '记录了是否正在创建 AOF 文件',
                    'aof_rewrite_scheduled' => '记录了 RDB 文件创建完毕之后，是否需要执行 AOF 重写操作',
                    'aof_last_rewrite_time_sec' => '最近一次创建 AOF 文件耗费的秒数',
                    'aof_current_rewrite_time_sec' => '如果正在创建 AOF 文件，那么记录当前的创建操作耗费的秒数',
                    'aof_last_bgrewrite_status' => '记录了最近一次创建 AOF 文件的状态，是成功还是失败',
                    'aof_last_write_status' => 'AOF的最后写入操作的状态，是成功还是失败',
                    'aof_last_cow_size' => '上一次AOF保存操作期间写时复制的大小（以字节为单位）',
                    'aof_current_size' => 'AOF 文件当前的大小',
                    'aof_base_size' => '最近一次启动或重写时的AOF文件大小',
                    'aof_pending_rewrite' => '记录了是否有 AOF 重写操作在等待 RDB 文件创建完毕之后执行',
                    'aof_buffer_length' => 'AOF缓冲区的大小',
                    'aof_rewrite_buffer_length' => 'AOF 重写缓冲区的大小',
                    'aof_pending_bio_fsync' => '后台 I/O 队列里面，等待执行的 fsync 数量',
                    'aof_delayed_fsync' => '被延迟的 fsync 调用数量，如果该值比较大，可以开启参数：no-appendfsync-on-rewrite=yes',

                    /*                如果正在进行加载操作，会有以下状态：
                                    loading_start_time:                //加载操作开始的时间戳
                                    loading_total_bytes:               //加载文件总大小
                                    loading_loaded_bytes:              //已加载的字节数
                                    loading_loaded_perc:               //已加载的百分比
                                    loading_eta_seconds:               //完成加载所需的秒数（以秒为单位）*/
                ],

            'stats' =>
                [
                    'total_connections_received' => '服务器接受的连接总数',
                    'total_commands_processed' => '服务器已执行的命令数量',
                    'instantaneous_ops_per_sec' => '服务器每秒钟执行的命令数量',
                    'total_net_input_bytes' => '启动以来，流入的字节总数',
                    'total_net_output_bytes' => '启动以来，流出的字节总数',
                    'instantaneous_input_kbps' => '接收输入的速率（每秒）',
                    'instantaneous_output_kbps' => '输出的速率（每秒）',
                    'rejected_connections' => '由于maxclients限制而被拒绝的连接数',
                    'sync_full' => '与slave full sync的次数      ',
                    'sync_partial_ok' => '接受的部分重新同步(psync)请求的数量',
                    'sync_partial_err' => '被拒绝的部分重新同步(psync)请求的数量',
                    'expired_keys' => 'key过期事件总数',
                    'expired_stale_perc' => '过期的比率',
                    'expired_time_cap_reached_count' => '过期计数',
                    'evicted_keys' => '由于最大内存限制而被驱逐的key数量',
                    'keyspace_hits' => 'key命中次数',
                    'keyspace_misses' => 'key未命中次数',
                    'pubsub_channels' => '发布/订阅频道的数量',
                    'pubsub_patterns' => '发布/订阅的模式数量',
                    'latest_fork_usec' => '最近一次 fork() 操作耗费的毫秒数（以微秒为单位）',
                    'migrate_cached_sockets' => '为迁移而打开的套接字数',
                    'slave_expires_tracked_keys' => '跟踪过期key数量（仅适用于可写从）',
                    'active_defrag_hits' => '活跃碎片执行的值重新分配的数量',
                    'active_defrag_misses' => '活跃碎片执行的中止值重新分配的数量',
                    'active_defrag_key_hits' => '活跃碎片整理的key数',
                    'active_defrag_key_misses' => '活跃碎片整理过程跳过的key数',
                ],


            'replication' =>
                [
                    'role' => '角色（master、slave），一个从服务器也可能是另一个服务器的主服务器',
                    'connected_slaves' => '连接slave实例的个数',
                    'slave0' => '连接的slave的信息',
                    'master_replid' => '服务器的复制ID',
                    'master_replid2' => '第二服务器复制ID，用于故障转移后的PSYNC，用于集群等高可用之后主从节点的互换',
                    'master_repl_offset' => '复制偏移量1',
                    'second_repl_offset' => '第二服务器复制偏移量2',
                    'repl_backlog_active' => '复制缓冲区状态',
                    'repl_backlog_size' => '复制缓冲区的大小（以字节为单位）',
                    'repl_backlog_first_byte_offset' => '复制缓冲区的偏移量，标识当前缓冲区可用范围',
                    'repl_backlog_histlen' => '复制缓冲区中数据的大小（以字节为单位）',

                    // 如果是从节点，会有以下状态：
                    'master_host' => 'Master IP',
                    'master_port' => 'Master Port',
                    'master_link_status' => 'Master的连接状态（up/down）',
                    'master_last_io_seconds_ago' => '最近一次主从交互之后的秒数',
                    'master_sync_in_progress' => '表示从服务器是否一直在与主服务器进行同步',
                    'slave_repl_offset' => '复制偏移量',
                    'slave_priority' => '从服务器的优先级',
                    'slave_read_only' => '从服务是否只读',

                    // 如果正在进行SYNC操作，会有以下状态：
                    'master_sync_left_bytes' => '同步完成前剩余的字节数',
                    'master_sync_last_io_seconds_ago' => '自SYNC操作以来最后一次传输I/O经过的秒数',

                    // 如果主服务器和副本服务器之间的链接断开，会有以下状态：
                    'master_link_down_since_seconds' => '主从连接断开后经过的秒数',
                    'connected_slaves' => '已连从的数量',
                    // 如果服务器配置（的Redis 5）有min-slaves-to-write（或以min-replicas-to-write）指令，会有以下状态：
                    'min_slaves_good_slaves' => '当前认为良好的副本数，对于每个副本，添加以下行：slaveXXX: id, IP address, port, state, offset, lag ',
                ],
            'CPU' =>
                [
                    'used_cpu_sys' => '消耗的系统CPU',
                    'used_cpu_user' => '消耗的用户CPU',
                    'used_cpu_sys_children' => '后台进程占用的系统CPU',
                    'used_cpu_user_children' => '后台进程占用的用户CPU',
                ]


        );

        $infoBak = [];
        foreach ($info as $k => $v) {
            //empty($msg[$type][$k])?$infoBak[$k] = $info[$k]: $infoBak[$msg[$type][$k]] = $info[$k];

            if (!empty($msg[$type][$k])) {
                $bakVal = str_pad($info[$k], 80 - strlen($k), ' ', STR_PAD_RIGHT) . "# " . $msg[$type][$k];
            } else {
                $bakVal = $info[$k];
            }
            $infoBak[$k] = $bakVal;
        }

        var_dump(static::toStr(
            $type,
            $infoBak
        ));

    }


    /**
     * @note 服务器的各种信息和统计数值
     */
    public function infoTest()
    {
        $this->showInfoMsg($this->redis->info("server"), "server");
        $this->showInfoMsg($this->redis->info("clients"), "clients");
        $this->showInfoMsg($this->redis->info("memory"), "memory");
        $this->showInfoMsg($this->redis->info("persistence"), "persistence");
        $this->showInfoMsg($this->redis->info("Stats"), "Stats");
        $this->showInfoMsg($this->redis->info("replication"), "replication");
        $this->showInfoMsg($this->redis->info("CPU"), "CPU");
    }


    /**
     * @note 调试
     */
    public function debuggTest()
    {

        if(!$this->redis->exists('city')){
            $res = $this->redis->lPush('city', 'FuZhou', 'ShangHai', 'BeiJing');
        }


        $res = $this->redis->ping('msg');
        var_dump(static::toStr(
            "PING;   使用客户端向 Redis 服务器发送一个 PING ，如果服务器运作正常的话，会返回一个 PONG; ping('msg')",
            $res
        ));
        $res = $this->redis->echo('message');
        var_dump(static::toStr(
            "ECHO;    打印一个特定的信息 message; ping('msg')",
            $res
        ));




        //var_dump($this->redis->slowLog('len'));
        //var_dump($this->redis->slowLog('reset'));
        $res = $this->redis->slowLog('get', 2);
        var_dump(static::toStr(
            "SLOWLOG; ",
            "\n查看当前日志的数量; slowLog('len')",
            "\n清空 slow log; slowLog('reset')",
            "\n查询执行时间的日志系统; slowLog('get', 2)",
            $res
        ));



        var_dump(static::toStr(
            "OBJECT; ",
            "\n引用所储存的值的次数。此命令主要用于除错:                object('refcount', 'city'):  ". $this->redis->object('refcount', 'city'),
            "\n自储存以来的空闲时间(idle， 没有被读取也没有被写入)，以秒为单位:  object('idletime', 'city'):  ". $this->redis->object('idletime', 'city'),
            "\n锁储存的值所使用的内部表示(representation):                   object('encoding', 'city'):  ". $this->redis->object('encoding', 'city')
        ));


        var_dump(static::toStr(
            "其它：",
            "\nMONITOR   实时打印出 Redis 服务器接收到的命令，调试用。",
            "\nDEBUG_OBJECT   redis> DEBUG OBJECT key   当 key 存在时，返回有关信息",
            "\nDEBUG_SEGFAULT   redis> DEBUG SEGFAULT  执行一个不合法的内存访问从而让 Redis 崩溃"
        ));


//
//MONITOR   实时打印出 Redis 服务器接收到的命令，调试用。
//DEBUG_OBJECT   redis> DEBUG OBJECT key   当 key 存在时，返回有关信息
//DEBUG_SEGFAULT   redis> DEBUG SEGFAULT  执行一个不合法的内存访问从而让 Redis 崩溃
//



    }


}