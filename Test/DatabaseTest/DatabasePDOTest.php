<?php

namespace HappyLin\OldPlugin\Test\DatabaseTest;


use HappyLin\OldPlugin\SingleClass\Exceptions\HandleExceptions;
use HappyLin\OldPlugin\SingleClass\Database\PDODriver\{PDOInstance, PDOStatementInstance,PDOModel};
use HappyLin\OldPlugin\SingleClass\Database\MySQLiDriver\{MySQLiInstance};
use HappyLin\OldPlugin\SingleClass\Database\DatabaseManager;

use HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits\System;
use HappyLin\OldPlugin\Test\TraitTest;
use PDO;



class DatabasePDOTest
{

    use System,TraitTest;


    public $fileSaveDir;

    /**
     * @var \HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOMySqlDriver
     */
    public $conn;


    public $link;

    public function __construct()
    {
//        $this->conn = PDOInstance::getInstance('mysql');
        $this->conn = DatabaseManager::getInstance()->connection('pdo','0','mysql');
        // 抛出异常
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//        // 选择游标类型(mysql没有它)
//        $this->conn->setAttribute(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL);
//        dump($this->conn->getAttribute(10));
    }
    



    /**
     * @note 展示部分PDO常量对应的属性
     */
    public function PDOGetAttributeTest()
    {
        //"PREFETCH",  "TIMEOUT"
        $attributes = array(
            "AUTOCOMMIT", "ERRMODE", "CASE", "CLIENT_VERSION", "CONNECTION_STATUS",
            "ORACLE_NULLS", "PERSISTENT",  "SERVER_INFO", "SERVER_VERSION", 'DRIVER_NAME'
        );

        foreach ($attributes as $val) {
            echo "PDO::ATTR_$val 常量值是: " .constant("PDO::ATTR_$val") .'；   属性值是：';
            echo $this->conn->getAttribute(constant("PDO::ATTR_$val")) . "\n<br>";
        }

    }

    /**
     * @note 展示不同模式下获取数据的样式
     */
    public function PDOFetchTest()
    {
        $h = $this->conn->prepare('SELECT id, name
            FROM test1000
            WHERE id > ? limit 2');

        $maxId = 1;
        $h->bindParam(1, $maxId, PDO::PARAM_INT);
        //$h->bindValue(1, 300, PDO::PARAM_INT);

        $h->execute();

        $fetchStyle = [
            //'PDO::FETCH_LAZY', // fetchAll() 中无效。
            'PDO::FETCH_ASSOC',
            'PDO::FETCH_NAMED',
            'PDO::FETCH_NUM',
            'PDO::FETCH_BOTH',
            'PDO::FETCH_OBJ',
            //'PDO::FETCH_BOUND',  // 需要 bindColumn
            //'PDO::FETCH_COLUMN', // 需要 指定 column-index
            //'PDO::FETCH_CLASS',  // 需要指定class
            //'PDO::FETCH_INTO',  // 需要setFetchMode — 为语句设置默认的获取模式。
            //'PDO::FETCH_FUNC',  // 仅在 PDOStatement::fetchAll() 中有效
            //'PDO::FETCH_GROUP', // 和 PDO::FETCH_COLUMN 或 PDO::FETCH_KEY_PAIR 一起使用。
        ];

        foreach ($fetchStyle as $style){
            $h->execute();
            var_dump($style);
            var_dump($h->fetch(constant($style), PDO::FETCH_ORI_FIRST));

            if(constant($style) === PDO::FETCH_LAZY){
                continue;
            }

            $h->execute();
            var_dump($h->fetchAll(constant($style)));
        }


    }


    /**
     * @note 查询结果返回PDOModel对象数组
     */
    public function PDOFetchObjectTest()
    {

        $h = $this->conn->prepare('SELECT id as uid, name
            FROM test1000
            WHERE id > ? limit 2');

        $maxId = 1;
        $h->bindParam(1, $maxId, PDO::PARAM_INT);



        var_dump('setFetchMode + fetch');
        $h->execute();
        $h->PDOStatement->setFetchMode( PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOModel',array('测试'));
        while($row = $h->fetch()){
            var_dump($row);
        }

        var_dump('fetchObject');
        $h->execute();
        while($row = $h->fetchObject('HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOModel',array('测试'))){
            var_dump($row);
        }

        var_dump('fetchAll');
        $h->execute();
        var_dump($h->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,'HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOModel',array('测试')));

    }

    /**
     * @note 为语句设置默认的获取模式。
     */
    public function PDOSetFetchModeTest()
    {

        $h = $this->conn->prepare('SELECT id as uid, name
            FROM test1000
            WHERE id > ? limit 2');

        $maxId = 1;
        $h->bindParam(1, $maxId, PDO::PARAM_INT);
        $h->execute();


        var_dump('setFetchMode + PDO::FETCH_NUM');
        $h->execute();
        $h->PDOStatement->setFetchMode( PDO::FETCH_NUM);
        while($row = $h->fetch()){
            var_dump($row);
        }


        var_dump('setFetchMode + PDO::FETCH_COLUMN');
        $h->execute();
        $h->PDOStatement->setFetchMode( PDO::FETCH_COLUMN,1);
        while($row = $h->fetch()){
            var_dump($row);
        }


        var_dump('setFetchMode + PDO::FETCH_CLASS');
        $h->execute();
        $h->PDOStatement->setFetchMode( PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOModel',array('测试'));
        while($row = $h->fetch()){
            var_dump($row);
        }


        var_dump('setFetchMode + PDO::FETCH_INTO');
        $h->execute();
        $h->PDOStatement->setFetchMode( PDO::FETCH_INTO, new \HappyLin\OldPlugin\SingleClass\Database\PDODriver\PDOModel());
        while($row = $h->fetch()){
            var_dump($row);
        }


    }


    /**
     * @note 模拟框架的查询
     */
    public function PDOModelTest()
    {
        var_dump(PDOModel::getConnection());
        $res = PDOModel::select('id, name')->from('test1000')->where('id','<','300',PDO::PARAM_INT)->find(10);
        var_dump($res);
    }


    /**
     * @note 初始化mysql一些表格
     */
    public function PDOMysqlFun()
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
        //$this->conn->exec($randDate);

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
        //$this->conn->exec($randString);

        // 设置一些字符变量，与上面randString配合使用；
        $variable =
            "set @___charsNum = '0123456789';
            set @___charsLetter = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            set @___charsChinese = '赵钱孙李周吴郑王冯陈楮卫蒋沈韩杨朱秦尤许何吕施张孔曹严华金魏陶姜戚谢邹喻柏水窦章云苏潘葛奚范彭郎鲁韦昌马苗凤花方俞任袁柳酆鲍史唐费廉岑薛雷贺倪汤滕殷罗毕郝邬安常乐于时傅皮卞齐康伍余元卜顾孟平黄和穆萧尹姚邵湛汪祁毛禹狄米贝明臧计伏成戴谈宋茅庞熊纪舒屈项祝董梁杜阮蓝闽席季麻强贾路娄危江童颜郭梅盛林刁锺徐丘骆高夏蔡田樊胡凌霍虞万支柯昝管卢莫经房裘缪干解应宗丁宣贲邓郁单杭洪包诸左石崔吉钮龚程嵇邢滑裴陆荣翁荀羊於惠甄麹家封芮羿储靳汲邴糜松井段富巫乌焦巴弓牧隗山谷车侯宓蓬全郗班仰秋仲伊宫宁仇栾暴甘斜厉戎祖武符刘景詹束龙叶幸司韶郜黎蓟薄印宿白怀蒲邰从鄂索咸籍赖卓蔺屠蒙池乔阴郁胥能苍双闻莘党翟谭贡劳逄姬申扶堵冉宰郦雍郤璩桑桂濮牛寿通边扈燕冀郏浦尚农温别庄晏柴瞿阎充慕连茹习宦艾鱼容向古易慎戈廖庾终暨居衡步都耿满弘匡国文寇广禄阙东欧殳沃利蔚越夔隆师巩厍聂晁勾敖融冷訾辛阚那简饶空曾毋沙乜养鞠须丰巢关蒯相查后荆红游竺权逑盖益桓公万俟司马上官欧阳夏侯诸葛闻人东方赫连皇甫尉迟公羊澹台公冶宗政濮阳淳于单于太叔申屠公孙仲孙轩辕令狐锺离宇文长孙慕容鲜于闾丘司徒司空丌官司寇仉督子车颛孙端木巫马公西漆雕乐正壤驷公良拓拔夹谷宰父谷梁晋楚阎法汝鄢涂钦段干百里东郭南门呼延归海羊舌微生岳帅缑亢况后有琴梁丘左丘东门西门商牟佘佴伯赏南宫墨哈谯笪年爱阳佟';";
        //$this->conn->exec($variable);


        $randNum =
            "drop function if exists randNum;
            create function randNum(n int) returns int
            begin
                declare i int default 0;
                set i=floor(rand()*POWER(10,n));
                return i;
            end;";
        //$this->conn->exec($randNum);

        $res = $this->conn->exec("$randDate $randString $randNum $variable");

        // 测试上面有没有效果
        //var_dump($this->conn->query("SELECT randString(3, @___charsChinese);")->fetch());

    }


    /**
     * @note 创建users1000测试表；需要执行过PDOMysqlFun
     */
    public function PDOCreateTest1000(int $insertNum = 50)
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
        // 重置test1000表格
        $this->conn->exec($createTableTest1000);

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
            end ";

        $this->conn->exec($insert_users1000);
        //var_dump($this->conn->errorInfo());

        // 查看全部存储过程
        //var_dump($this->conn->query("show procedure status;")->fetch(PDO::FETCH_NAMED));
        // 查看过程创建语句
        //var_dump($this->conn->query("show create procedure insertTest1000;")->fetchAll(PDO::FETCH_NAMED));

        $stmt = $this->conn->prepare("CALL insertTest1000(?)");
        $stmt->bindValue(1, $insertNum, PDO::PARAM_INT, $insertNum);
        // 调用存储过程
        $stmt->execute();
        //var_dump($this->conn->errorInfo());
    }


    /**
     * @note 创建users1000测试表；需要执行过PDOMysqlFun
     */
    public function PDOCreateUsers1000(int $insertNum = 50)
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
        // 重置users1000表格
        $this->conn->exec($createTableUsers1000);


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
            end ";

        $this->conn->exec($insert_users1000);
        //var_dump($this->conn->errorInfo());

        // 查看过程创建语句
        //var_dump($this->conn->query("show create procedure insertUsers1000;")->fetchAll(PDO::FETCH_NAMED));

        $stmt = $this->conn->prepare("CALL insertUsers1000(?)");
        $stmt->bindValue(1, $insertNum, PDO::PARAM_INT, $insertNum);
        // 调用存储过程
        $stmt->execute();
        //var_dump($this->conn->errorInfo());
    }


    /**
     * @note 重建 users1000 和 test1000 表格 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    public function initTableTest(){
        $this->PDOMysqlFun();
        $this->PDOCreateUsers1000();
        $this->PDOCreateTest1000();
    }


    /**
     * @note 增删改查
     */
    public function PDOIDUS()
    {
        $stmt = $this->conn->prepare("INSERT INTO test1000 (name, email) VALUES (:name, :email)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);

        // 插入一行
        $name = 'one';
        $email = 'exampleone@xx.com';
        $stmt->execute();

        $oneid = $this->conn->lastInsertId();
        var_dump("插入{$stmt->rowCount()}行");

        // 用不同的值插入另一行
        $name = 'two';
        $email = 'exampletwo@xx.com';
        $stmt->execute();
        $twoid = $this->conn->lastInsertId();

        var_dump("插入{$stmt->rowCount()}行");


        //改
        $stmt = $this->conn->prepare("update test1000 set created = :created, created_at=:created_at where id = :id ;");

        $stmt->bindValue(':created', time(), PDO::PARAM_INT);
        $stmt->bindValue(':created_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->bindValue(':id', $twoid, PDO::PARAM_INT);
        $res = $stmt->execute();
        if(!$res){
            throw new \PDOException('修改执行失败');
        }
        var_dump("修改了{$stmt->rowCount()}行");

        // 查
        $stmt = $this->conn->prepare('select name, email,created_at from test1000 where id = :id;');
        $stmt->bindValue(':id', $twoid,PDO::PARAM_INT);
        $stmt->execute();
        var_dump($stmt->fetchAll());

        // 删
        $stmt = $this->conn->prepare("delete from test1000 where id = :id ;");
        $stmt->bindParam(':id', $oneid,PDO::PARAM_INT);
        $res = $stmt->execute();
        if(!$res){
            throw new \PDOException('删除执行失败');
        }
        var_dump("删除了{$stmt->rowCount()}行");
        
    }


    /**
     * @note PDO事务
     */
    public function PDOTransaction()
    {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare("INSERT INTO test1000 (name, email) VALUES (:name, :email)");
            $stmt->bindValue(':name', '事务一');
            $stmt->bindValue(':email', 'exampleone@xx.com');
            $stmt->execute();

            $name = '事务二';
            //$name = '事务二所开发的技术框架开发就是大家分厘卡时间';

            $stmt = $this->conn->prepare("INSERT INTO test1000 (name, email) VALUES (:name, :email)");
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':email', 'exampletwo@xx.com');
            $stmt->execute();

            $this->conn->commit();

        } catch (\PDOException $e) {
            // 获取所有MySQL连接判断是否在事务中，滚回
            $dbcon = \HappyLin\OldPlugin\SingleClass\Database\DatabaseManager::getInstance()->getconnect('pdo');
            foreach($dbcon as $db){
                if ($db->inTransaction())
                    $db->rollBack();
            }
            // 处理完继续抛出
            throw $e;
        }

        echo "事务执行成功";
    }


}


