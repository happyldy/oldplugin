<?php

namespace HappyLin\OldPlugin\Test\DatabaseTest;


use HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver\{MySQLiInstance};
use HappyLin\OldPlugin\SingleClass\Database\DatabaseManager;

use HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits\System;
use HappyLin\OldPlugin\Test\TraitTest;
use PDO;



class DatabaseMySQLiTest
{
    use System,TraitTest;

    public $fileSaveDir;

    /**
     * @var \HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOMySqlDriver
     */
    public $conn;

    /**
     * @var \HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver\MySQLiDriver
     */
    public $link;

    public function __construct()
    {
        //$this->link = MySQLiInstance::getInstance('mysql');

//        $this->link = DatabaseManager::getInstance()->connection('mysqli');
        $this->link = DatabaseManager::getInstance()->makeMySQLiConnection();


//        // 抛出异常
//        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
    }



    /**
     * @note 获取mysql连接信息
     */
    public function mysqliConnAttrTest()
    {

        var_dump("连接错误码：{$this->link->getConnectErrno()}");
        var_dump("连接描述：{$this->link->getConnectError()}");
        var_dump("检查连接是否还正常。：{$this->link->ping()}");
        //var_dump("是否允许重连：{$this->link->reconnect}");
        var_dump("连接信息：{$this->link->getHostInfo()}");
        var_dump(static::toStr('获取mysqli_driver配置信息',$this->link->getMySQLiDriverInfo()));
        var_dump("MySQL协议的版本号：{$this->link->getProtocolVersion()}");
        var_dump("MySQL服务器的版本号：{$this->link->getServerInfo()}");
        var_dump("MySQL服务器的整数版本号：{$this->link->getServerVersion()}");
        var_dump("系统状态信息：{$this->link->stat()}");

        var_dump("客户端版本信息：{$this->link->getClientVersion()}");
        var_dump("客户端信息：{$this->link->getClientInfo()}");

        var_dump("线程安全：{$this->link->threadSafe()}");
        var_dump("mysql线程id：{$this->link->threadId()}");


        if ($result = $this->link->query("SELECT @@autocommit")) {
            $row = $result->fetchRow();
            var_dump(sprintf("自动事务提交状态: %s", $row[0]));;
            $result->free();
        }


        if ($result = $this->link->query("SELECT CURRENT_USER();")) {
            $row = $result->fetchRow();
            var_dump(sprintf("当前连接的账号: %s", $row[0]));;
            $result->free();
        }

        var_dump("字符集的多个属性：\n". var_export($this->link->getCharset(), true));
        var_dump("客户端连接的统计数据：\n" . var_export($this->link->getConnectionStats(), true) );


    }


    /**
     * @note 调试，获取上次错误信息和语句
     */
    public function mysqliQueryAttrTest()
    {
        $m = static::memoryGetPeakUsage();
        var_dump("最后一条SQL操作错误消息：{$this->link->getError()}");
        var_dump("SQL操作错误数组：\n" .  var_export($this->link->getErrorList(), true) );

        var_dump("上一次SQL操作的 SQLSTATE：{$this->link->sqlstate()}");

        var_dump("最后一次查询的警告数：{$this->link->warning_count()}");
        var_dump("最后一次查询的警告对象：\n" .  var_export($this->link->getWarnings(), true) );


    }


    /**
     * useResult和storeResult不同
     * 以及 query 和 real_query查询方式（query是 real_query 和 useResult|storeResult 的合集）； 都是返回mysqli_result
     * useResult 使用MySQL内存，一条条取数据numRows()为0； storeResult全取使用PHP内存numRows()正常
     *
     * @note  useResult和storeResult获取数据不同(占用php内存或mysql内存)
     */
    public function useResultAndstoreResultDiffTest()
    {

        $m = static::memoryGetPeakUsage();
        $realQuery = $this->link->realQuery("select id, name from test1000 where id < 2000");
        if ($realQuery) {
            $result =$this->link->useResult();
            var_dump($result->fetchRow());
            var_dump($result->fetchRow());

            var_dump($result->numRows());

            echo "total memory comsuption: " . (static::memoryGetPeakUsage() - $m) . " bytes\n";

            $result->close();
        } else {
            die('error');
        }


//        $m = static::memoryGetPeakUsage();
//        $realQuery = $this->link->realQuery("select id, name from test1000 where < 2000");
//        if ($realQuery) {
//            $result =$this->link->storeResult();
//            var_dump($result->fetchRow());
//            var_dump($result->fetchRow());
//
//
//            var_dump($result->numRows());
//
//            echo "total memory comsuption: " . (static::memoryGetPeakUsage() - $m) . " bytes\n";
//
//            $result->close();
//        } else {
//            die('error');
//        }



//        $m = memory_get_peak_usage();
//        // 直接执行query
//        $query = $this->link->query("select id, name from test1000 where id < 2000" ,MYSQLI_USE_RESULT);
//        var_dump($query->fetchRow());
//        var_dump($query->fetchRow());
//        echo "total memory comsuption: " . (memory_get_peak_usage() - $m)/1024 . " bytes\n";


//        $m = memory_get_peak_usage();
//        // 直接执行query
//        $query = $this->link->query("select id, name from test1000 where id < 2000");
//        var_dump($query->fetchRow());
//        var_dump($query->fetchRow());
//        echo "total memory comsuption: " . (memory_get_peak_usage() - $m)/1024 . " bytes\n";

    }



    /**
     * @note 一次执行多条语句
     */
    public function mysqliInstanceMultiQueryTest()
    {
        $query  = "SELECT CURRENT_USER();";
        $query .= "select id, name from test1000 where id < 2000";

        $realQuery = $this->link->multiQuery($query);

        do {
            // useResult 或 storeResult 获取结果集
            if ($result = $this->link->useResult()) {
                while ($row = $result->fetchRow()) {
                    printf("%s\n", $row[0]);
                }
                $result->free();
            }
            // 如果还有结果集 打印下划线
            if ($this->link->moreResults()) {
                print_r ("----------------- \n<br>");
            }
        } while ($this->link->moreResults() && $this->link->nextResult());

    }



    /**
     * 只在stmtInit和 prepare有返回
     * MySQLiInstance.prepare是   MySQLiInstance.stmtInit和MysqliSTML.prepare的合计
     *
     * 正常使用getResult 操作MysqliResult对象; 所以storeResult、bindResult、fetch 就这样了
     *
     * @note MysqliSTML查询数据
     */
    public function  mysqliStmlFetchTest()
    {
        // 缓存使用内存
        $m = static::memoryGetPeakUsage();

        //$stmt = $this->link->stmt_init();

        $stmt = $this->link->prepare("select id, name from test1000 where id > ? and created_at > ?");

        $stmt->bindParam('is', $id, $date);

        $id = 100;
        $date = '2020-01-05 20:51:41';

        $stmt->execute();

        // 从准备好的语句返回结果集元数据； 可以用来判断是否有结果集
        $result = $stmt->resultMetadata();
        var_dump($result);

        // 您必须为每个成功生成结果集（SELECT、SHOW、DESCRIBE、EXPLAIN）的查询调用 mysqli_stmt_store_result()，在所有情况下都不会损害或导致任何显着的性能损失。
        $stmt->storeResult();

        var_dump($stmt->numRows());


        // 当调用 mysqli_stmt_fetch() 获取数据时，MySQL 客户端/服务器协议将绑定列的数据放入指定的变量 var/vars 中。
        $stmt->bindResult($col1, $col2);


        //数据在不调用 mysqli_stmt_store_result() 的情况下无缓冲传输，这会降低性能（但会降低内存成本）。 看内存好像没变
        while ($stmt->fetch()) {
            printf("%s %s \n ", $col1, $col2);

        }

        echo "<br>total memory comsuption: " . (static::memoryGetPeakUsage() - $m) . " bytes\n";

        $stmt->close();

    }

    /**
     * 只在stmtInit和 prepare有返回
     * MySQLiInstance.prepare是   MySQLiInstance.stmtInit和MysqliSTML.prepare的合计
     *
     * @note 多种返回结果集字段组合方式
     */
    public function  mysqliResultTest()
    {
        // 缓存使用内存
        $m = static::memoryGetPeakUsage();


        var_dump("mysqli 获取结果的几种返回格式：" );

        $stmt = $this->link->prepare("select id, name from test1000 where id > ? and created_at > ? limit ?");
        $stmt->bindParam('isi', $id, $date, $limit);
        $id = 100;
        $date = '2020-01-05 20:51:41';
        $limit = 5;

        $stmt->execute();

        $result = $stmt->getResult();


        var_dump("mysqli_result->num_rows:" . $result->numRows());

        var_dump("\nmysqli_result->fetchRow: \n" . var_export($result->fetchRow(), true));

        $result->dataSeek(0);

        var_dump("\nmysqli_result->fetchAssoc: \n" . var_export($result->fetchAssoc(), true));

        $result->dataSeek(0);

        var_dump("\nmysqli_result->fetchArray(MYSQLI_ASSOC): \n" . var_export($result->fetchArray(MYSQLI_ASSOC), true));


        $result->dataSeek(0);

        var_dump("\nmysqli_result->fetchObject(class_name): \n" . var_export($result->fetchObject('\HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver\MysqliModel'), true));


        $result->dataSeek(0);

        var_dump("\nmysqli_result->fetchAll(MYSQLI_ASSOC): \n" . var_export($result->fetchAll(MYSQLI_ASSOC), true));

//        while ($row = $result->fetchArray(MYSQLI_NUM)){
//            var_dump( $row);
//        }

        echo "<br>total memory comsuption: " . (static::memoryGetPeakUsage() - $m) . " bytes\n";

        /* close statement */
        $stmt->close();

    }
    /**
     * 只在stmtInit和 prepare有返回
     * MySQLiInstance.prepare是   MySQLiInstance.stmtInit和MysqliSTML.prepare的合计
     *
     * show columns from test1000;  describe test1000 name;
     *
     * @note 结果集字段的提取方式
     */
    public function  mysqliResultFieldTest()
    {
        $m = static::memoryGetPeakUsage();

        $stmt = $this->link->prepare("select id, name from test1000 where id > ? and created_at > ? limit ?");
        $stmt->bindParam('isi', $id, $date, $limit);
        $id = 2;
        $date = '2020-01-05 20:51:41';
        $limit = 1;

        $stmt->execute();

        $result = $stmt->getResult();

        var_dump($result->fetchAssoc());


        var_dump("字段数量:" . $result->fieldCount());


        var_dump("\nfetchFieldDirect(1)指定获取字段信息的对象: \n" . var_export($result->fetchFieldDirect(1), true));

        // 下一次调用 mysqli_fetch_field() 将检索与该偏移量关联的列的字段定义。
        var_dump($result->fieldSeek(0));

        var_dump("\nfetchField获取下一个字段信息对象: \n" . var_export($result->fetchField(), true));


        var_dump("\nfetchFields全部字段信息对象: \n" . var_export($result->fetchFields(), true));


        $str = '';
        foreach ($result->lengths() as $i => $val) {
            $str .= sprintf("Field %2d has Length %2d  ", $i+1, $val);
        }

        var_dump($str);


        /* close statement */
        $stmt->close();

    }




    /**
     * @note 初始化mysql一些表格
     */
    public function mysqliFun()
    {
        // 随机日期格式 2020-10-21 13:21:06输入年
        $randDate =
            "drop function if exists `randDate`;
            create function `randDate`(year int(10)) returns varchar(60)
            begin
                declare YMD varchar(60) default  concat( CONCAT(FLOOR(year + (RAND() * 1)),'-',LPAD(FLOOR(1 + (RAND() * 11)),2,0),'-',LPAD(FLOOR(1 + (RAND() * 26)),2,0)));
                declare HMS varchar(60) default CONCAT(LPAD(FLOOR(0 + (RAND() * 23)),2,0),':',LPAD(FLOOR(0 + (RAND() * 59)),2,0),':',LPAD(FLOOR(0 + (RAND() * 59)),2,0));
                return CONCAT(YMD,' ',HMS );
            end;";

        // 根据传入的字符串，随机返回字符串
        $randString =
            "drop function if exists randString;
            create function randString(n int, chars_str text) returns text
            begin
                declare str_leng int default char_length(chars_str);
                declare return_str varchar(255) default '';
                declare i int default 0;
                while i < n do
                set return_str=concat(return_str,substring(chars_str,floor(1+rand()*str_leng),1));
                set i=i+1;
                end while;
                return return_str;
            end;";


        // 设置一些字符变量，与上面randString配合使用；
        $variable =
            "set @___charsNum = '0123456789';
            set @___charsLetter = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            set @___charsChinese = '赵钱孙李周吴郑王冯陈楮卫蒋沈韩杨朱秦尤许何吕施张孔曹严华金魏陶姜戚谢邹喻柏水窦章云苏潘葛奚范彭郎鲁韦昌马苗凤花方俞任袁柳酆鲍史唐费廉岑薛雷贺倪汤滕殷罗毕郝邬安常乐于时傅皮卞齐康伍余元卜顾孟平黄和穆萧尹姚邵湛汪祁毛禹狄米贝明臧计伏成戴谈宋茅庞熊纪舒屈项祝董梁杜阮蓝闽席季麻强贾路娄危江童颜郭梅盛林刁锺徐丘骆高夏蔡田樊胡凌霍虞万支柯昝管卢莫经房裘缪干解应宗丁宣贲邓郁单杭洪包诸左石崔吉钮龚程嵇邢滑裴陆荣翁荀羊於惠甄麹家封芮羿储靳汲邴糜松井段富巫乌焦巴弓牧隗山谷车侯宓蓬全郗班仰秋仲伊宫宁仇栾暴甘斜厉戎祖武符刘景詹束龙叶幸司韶郜黎蓟薄印宿白怀蒲邰从鄂索咸籍赖卓蔺屠蒙池乔阴郁胥能苍双闻莘党翟谭贡劳逄姬申扶堵冉宰郦雍郤璩桑桂濮牛寿通边扈燕冀郏浦尚农温别庄晏柴瞿阎充慕连茹习宦艾鱼容向古易慎戈廖庾终暨居衡步都耿满弘匡国文寇广禄阙东欧殳沃利蔚越夔隆师巩厍聂晁勾敖融冷訾辛阚那简饶空曾毋沙乜养鞠须丰巢关蒯相查后荆红游竺权逑盖益桓公万俟司马上官欧阳夏侯诸葛闻人东方赫连皇甫尉迟公羊澹台公冶宗政濮阳淳于单于太叔申屠公孙仲孙轩辕令狐锺离宇文长孙慕容鲜于闾丘司徒司空丌官司寇仉督子车颛孙端木巫马公西漆雕乐正壤驷公良拓拔夹谷宰父谷梁晋楚阎法汝鄢涂钦段干百里东郭南门呼延归海羊舌微生岳帅缑亢况后有琴梁丘左丘东门西门商牟佘佴伯赏南宫墨哈谯笪年爱阳佟';";


        $randNum =
            "drop function if exists randNum;
            create function randNum(n int) returns int
            begin
                declare i int default 0;
                set i=floor(rand()*POWER(10,n));
                return i;
            end;";

        $this->link->multiQuery("$randDate  $randString  $variable  $randNum");

        do {
            // useResult 或 storeResult 有结果集就释放与结果相关的内存
            if ($result = $this->link->storeResult()) {
                $result->free();
            }
        } while ($this->link->moreResults() && $this->link->nextResult());


        // 测试上面有没有效果
        //var_dump($this->link->query("SELECT randString(3, @___charsChinese);")->fetchRow());

    }

    /**
     * @note 创建users1000测试表；需要执行过PDOMysqlFun
     */
    public function mysqliCreateTest1000(int $insertNum = 50)
    {
        // 创建表格
        $createTableTest1000 =
            "DROP TABLE IF EXISTS `test1000`;
            CREATE TABLE `test1000` (
              `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
              `code` int(12)  NOT NULL DEFAULT 0,
              `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
              `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
              `created_at` timestamp  DEFAULT NULL,
              `created` int(11)  DEFAULT 0,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;";


        // 添加users1000表数据
        $insert_users1000 =
            "drop procedure if exists insertTest1000;
            create procedure insertTest1000(in max_num int(10))
            begin
                declare i int default 0;
                repeat
                    set i=i+1;
                    insert into test1000 (code, name, email, created_at, created) values(
                                    randNum(9),
                                    randString(3, @___charsChinese),
                                    CONCAT(randString(10, @___charsLetter),'@',randString(3, @___charsLetter),'.com'),
                                    randDate(2021),
                                    FLOOR(unix_timestamp()-365 * RAND()));
                    until i=max_num
                end repeat;
            commit;
            end;";


        $this->link->multiQuery("$createTableTest1000 $insert_users1000");

        do {
            // useResult 或 storeResult 有结果集就释放与结果相关的内存
            if ($result = $this->link->storeResult()) {
                $result->free();
            }
        } while ($this->link->moreResults() && $this->link->nextResult());

        // 查看全部存储过程
        //var_dump($this->link->query("show procedure status;")->fetchAll(MYSQLI_BOTH));
        // 查看过程创建语句
        //var_dump($this->link->query("show create procedure insert_users1000;")->fetchAll(MYSQLI_BOTH));


        $stmt = $this->link->prepare("CALL insertTest1000(?)");
        $stmt->bindParam('i', $insertNum);
        // 调用存储过程
        $stmt->execute();

    }


    /**
     * @note 创建users1000测试表；需要执行过PDOMysqlFun
     */
    public function mysqlCreateUsers1000(int $insertNum = 50)
    {
        // 创建表格
        $createTableUsers1000 =
            "DROP TABLE IF EXISTS `users1000`;
            CREATE TABLE `users1000` (
              `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
              `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
              `email_verified_at` timestamp NULL DEFAULT NULL,
              `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
              `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
              `created_at` timestamp  DEFAULT NULL,
              `updated_at` timestamp  DEFAULT NULL,
              `created` int(11)  DEFAULT 0,
              `updated` int(11)  DEFAULT 0,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;";



        // 添加users1000表数据
        $insert_users1000 =
            "drop procedure if exists insertUsers1000;
            create procedure insertUsers1000(in max_num int(10))
            begin
                declare i int default 0;
                repeat
                    set i=i+1;
                    insert into users1000 (name, email, email_verified_at, password, created_at, updated_at, created, updated) values(
                                    randString(3, @___charsChinese),
                                    CONCAT(randString(10, @___charsLetter),'@',randString(3, @___charsLetter),'.com'),
                                    randDate(2020),
                                    randString(10, @___charsLetter),
                                    randDate(2020),
                                    randDate(2021),
                                    FLOOR(unix_timestamp()-365 * RAND()),
                                    FLOOR(unix_timestamp()-365 * RAND()));
                    until i=max_num
                end repeat;
            commit;
            end; ";

        $this->link->multiQuery("$createTableUsers1000  $insert_users1000");

        do {
            // useResult 或 storeResult 有结果集就释放与结果相关的内存
            if ($result = $this->link->storeResult()) {
                $result->free();
            }
        } while ($this->link->moreResults() && $this->link->nextResult());

        // 查看过程创建语句
        //var_dump($this->link->query("show create procedure insertUsers1000;")->fetchAll(MYSQLI_BOTH));


        $stmt = $this->link->prepare("CALL insertUsers1000(?)");
        $stmt->bindParam('i', $insertNum);
        // 调用存储过程
        $stmt->execute();

    }


    /**
     * @note 重建 users1000 和 test1000 表格 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    public function initTableTest(){
        $this->mysqliFun();
        $this->mysqliCreateTest1000();
        $this->mysqlCreateUsers1000();
    }


    /**
     * @note 增删改查
     */
    public function mysqliIDUSTest()
    {



        // 增
        $stmt = $this->link->prepare("insert into test1000(name, email)value(?, ?)");
        $stmt->bindParam('ss', $name, $email);
        $name = 'one';
        $email = 'exampleone@xx.com';
        $stmt->execute();
        var_dump("增加的行数：" . $stmt->affectedRows());

        $name = 'two';
        $email = 'exampletwo@xx.com';
        $stmt->execute();
        var_dump("增加的行数：" . $stmt->affectedRows());



        // 删
        $stmt = $this->link->prepare("delete from test1000 where name=?");
        $stmt->bindParam('s', $name);
        $name = 'one';
        $stmt->execute();
        var_dump("删除了行数：" . $stmt->affectedRows());

        // 改
        $stmt = $this->link->prepare("update test1000 set created_at = ?, created=?  where name=? ");
        $stmt->bindParam('sis',$created_at, $created, $name);
        $name = 'two';
        $created = time();
        $created_at = date('Y-m-d H:i:s');
        $stmt->execute();
        var_dump("修改了行数：" . $stmt->affectedRows());

        // 查
        $stmt = $this->link->prepare("select id, name, email, created_at from test1000 where name = ?");
        $stmt->bindParam('s', $name);
        $name = 'two';
        $stmt->execute();
        var_dump("查询结果：" . var_export($stmt->getResult()->fetchAll(MYSQLI_ASSOC),true));
        var_dump($this->link->info());

    }


    /**
     * @note 事务
     */
    public function mysqlTransactionTest()
    {

        try {

            $this->link->beginTransaction();

            $stmt = $this->link->prepare("INSERT INTO test1000 (name, email) VALUES (?, ?)");
            $stmt->bindParam('ss', $name, $email);
            $name = '事务一';
            $email = 'exampleone@xx.com';
            $stmt->execute();

            $stmt = $this->link->prepare("INSERT INTO test1000 (name, email) VALUES (?, ?)");
            $stmt->bindParam('ss', $name,$email);

            $name = '事务二';
            //$name = '事务二所开发的技术框架开发就是大家分厘卡时间'; // 长度太长肯定失败
            $email = 'exampletwo@xx.com';
            $res = $stmt->execute();


//            // 事务中的事务
//            $this->link->beginTransaction();
//
//            $stmt = $this->link->prepare("INSERT INTO test1000 (name, email) VALUES (?, ?)");
//            $stmt->bindParam('ss', $name,$email);
//
//            $name = '事务四';
//            //$name = '事务二所开发的技术框架开发就是大家分厘卡时间'; // 长度太长肯定失败
//            $email = 'exampletwo@xx.com';
//            $res = $stmt->execute();
//
//            $this->link->commit();


            $stmt = $this->link->prepare("INSERT INTO test1000 (name, email) VALUES (?, ?)");
            $stmt->bindParam('ss', $name,$email);

            $name = '事务三';
            //$name = '事务三所开发的技术框架开发就是大家分厘卡时间'; // 长度太长肯定失败
            $email = 'exampletwo@xx.com';
            $res = $stmt->execute();

            $this->link->commit();

        } catch (\mysqli_sql_exception $exception) {
            // 获取所有MySQL连接判断是否在事务中，滚回
            $dbcon = \HappyLin\OldPlugin\SingleClass\Database\DatabaseManager::getInstance()->getconnect('mysqli');
            foreach($dbcon as $db){
                $db->rollBack();
            }
            // 处理完继续抛出
            throw $exception;
        }


        echo "事务执行成功";
    }


}















