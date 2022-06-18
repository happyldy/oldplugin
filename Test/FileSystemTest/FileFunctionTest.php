<?php
/**
 * php.ini
 *  open_basedir                        string     将 PHP 可以访问的文件限制在指定的目录树中，包括文件本身。 此指令不受安全模式是打开还是关闭的影响。
 *  allow_url_fopen                     boolean    本选项激活了 URL 形式的 fopen 封装协议使得可以访问 URL 对象例如文件。默认的封装协议提供用 ftp 和 http 协议来访问远程文件，一些扩展库例如 zlib 可能会注册更多的封装协议。
 *  auto_detect_line_endings            boolean    当设为 On 时，PHP 将检查通过 fgets() 和 file() 取得的数据中的行结束符号是符合 Unix，MS-DOS，还是 Macintosh 的习惯。
 *                                                  这使得 PHP 可以和 Macintosh 系统交互操作，但是默认值是 Off，因为在检测第一行的 EOL 习惯时会有很小的性能损失，而且在 Unix 系统下使用回车符号作为项目分隔符的人们会遭遇向下不兼容的行为。
 *
 *
 * $mode
 * 'r' 只读方式打开，将文件指针指向文件头。
 * 'r+' 读写方式打开，将文件指针指向文件头。
 * 'w' 写入方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。
 * 'w+' 读写方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。
 * 'a' 写入方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之。
 * 'a+' 读写方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之。
 * 'x' 创建并以写入方式打开，将文件指针指向文件头。如果文件已存在，则 fopen() 调用失败并返回 FALSE，并生成一条 E_WARNING 级别的错误信息。如果文件不存在则尝试创建之。这和给底层的 open(2) 系统调用指定 O_EXCL|O_CREAT 标记是等价的。
 * 'x+' 创建并以读写方式打开，其他的行为和 'x' 一样。
 * 'c' Open the file for writing only. If the file does not exist, it iscreated. If it exists, it is neither truncated (as opposed to 'w'), nor the call to this function fails (as isthe case with 'x'). The file pointer ispositioned on the beginning of the file. This may be useful if it'sdesired to get an advisory lock (see flock())before attempting to modify the file, as using 'w' could truncate the file before the lockwas obtained (if truncation is desired, ftruncate() can be used after the lock isrequested).
 * 'c+' Open the file for reading and writing; otherwise it has the samebehavior as 'c'.
 *
 *
 * mode 数字 1 表示使文件可执行，数字 2 表示使文件可写，数字 4 表示使文件可读。
 *
 * inode是什么？
 *  一个文件由数据与元信息组成，元信息存储的是文件名、创建者、创建日期等等。存储元信息的区域叫做inode。每一个inode都有唯一不同的编号用来识别不同的编号，linux、unix使用inode来识别文件，不使用文件名。所以系统查找文件是通过inode节点
 *  文件储存在硬盘上，硬盘的最小存储单位叫做"扇区"（Sector）。每个扇区储存512字节（相当于0.5KB）。
 *  操作系统读取硬盘的时候，不会一个个扇区地读取，这样效率太低，而是一次性连续读取多个扇区，即一次性读取一个"块"（block）。这种由多个扇区组成的"块"，是文件存取的最小单位。"块"的大小，最常见的是4KB，即连续八个 sector组成一个 block。
 *  文件数据都储存在"块"中，那么很显然，我们还必须找到一个地方储存文件的元信息，比如文件的创建者、文件的创建日期、文件的大小等等。这种储存文件元信息的区域就叫做inode，中文译名为"索引节点"。
 *  每一个文件都有对应的inode，里面包含了与该文件有关的一些信息。
 *
 * 符号链接和硬链接的区别:
 *     incode编号
 *          硬链接文件的incode编号相同，是同一个文件，符号链接的incode编号则不同，是不同的文件；因此就文件内容而言，硬链接文件的文件内容完全相同，但是符号链接则完全不同（可以理解为符号链接文件中存储原始文件的路径，相当于windows系统的快捷方式）。
 *     是否可以在不同文件系统创建
 *          硬链接只能在同一个文件系统创建，但是符号链接可以跨文件系统创建。
 *     创建命令
 *          符号链接：ln -s 原始文件 符号链接文件；硬链接：ln 原始文件 符号链接文件。
 *     占用空间
 *          两者都仅占用很小的空间。
 *     是否可以对目录创建
 *          由于linux文件系统设计的关系，硬链接不可以对目录创建（会产生目录环），但是符号链接可以。
 *
 *
 * 独占锁：独占锁也叫排他锁,是指该锁一次只能被一个线程所持有。如果线程T对数据A加上排他锁后，则其他线程不能再对A加任何类型的锁。获得排它锁的线程即能读数据又能修改数据。
 * 共享锁：共享锁是指该锁可被多个线程所持有。如果线程T对数据A加上共享锁后，则其他线程只能对A再加共享锁，不能加排它锁。获得共享锁的线程只能读数据，不能修改数据。
 *
 *
 *
 * SHELL的通配符:
 *  *	        匹配0或任意个字符
 *  ？	        匹配一个任意字符
 *  [-]	        匹配中括号的字符。例如[a-b]，匹配小写字母，只会匹配集合中的一个
 *  [^]	        匹配除了中括号的一个字符。例如[^0-9]，匹配除了数字的字符，只会匹配集合中的一个
 *  {ab,ba}	    匹配其中一个字符串。例如匹配ab或ba
 *
 *
 *
 *
 *
 *
 *
 */



namespace HappyLin\OldPlugin\Test\FileSystemTest;

use HappyLin\OldPlugin\SingleClass\FileSystem\Filesystem\FileFunction;

use HappyLin\OldPlugin\SingleClass\{Url};


use HappyLin\OldPlugin\Test\TraitTest;

class FileFunctionTest{
    use TraitTest;


    public $fileSaveDir;



    public function __construct(){


        $this->fileSaveDir = static::getTestDir() . '/Public/SingleClass';

    }

    /**
     * @note 文件属性和操作的相关函数
     */
    public function fileTest()
    {

        $filename = $this->fileSaveDir .'/test.txt' ;
        $filename =  HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR.'/SingleClass/test.txt' ;
        //var_dump(static::toStr('使用文件：', $filename));

        $dirname = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR.'/SingleClass/testDir/test' ;

        if(file_exists($dirname)){
            rmdir($dirname);
        }
        var_dump(static::toStr('目录;创建(resource); mkdir', FileFunction::mkdir($dirname, 0755, true)));

        $newDirname = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR.'/SingleClass/testDir/testrename';
        var_dump(static::toStr('目录或文件;重命(resource);必要时会在不同目录间移动 rename', FileFunction::rename($dirname, $newDirname)));
        var_dump(static::toStr('目录;删除(resource); rmdir', FileFunction::rmdir($newDirname)));
        var_dump(static::toStr('目录;获取所在的磁盘分区的总大小; disk_total_space', FileFunction::disk_total_space(dirname($filename))));
        var_dump(static::toStr('目录;获取中的可用空间。 disk_free_space 别名 diskfreespace', FileFunction::disk_free_space(dirname($filename))));


        var_dump(static::toStr('路径;规范化的绝对路径名；realpath( string $path)', realpath($filename)));
        var_dump(static::toStr('路径;获取路径中的目录部分', FileFunction::dirname($filename, 1)));
        var_dump(static::toStr('路径;获取路径中的文件名部分; 去除后缀 .txt;  basename($filename, ".txt") ', FileFunction::basename($filename, ".txt")));
        var_dump(static::toStr('路径;获取文件路径的信息，可指定获取部分;  pathinfo($filename, PATHINFO_DIRNAME | PATHINFO_BASENAME | PATHINFO_EXTENSION | PATHINFO_FILENAME) ', FileFunction::pathinfo($filename, PATHINFO_DIRNAME | PATHINFO_BASENAME | PATHINFO_EXTENSION | PATHINFO_FILENAME)));

        var_dump(static::toStr('文件;获取的信息；lstat() 和 stat() 相同，只除了它会返回符号连接的状态。 stat( string $filename)')); //, stat($filename)


        var_dump(static::toStr('文件或符号;获取连接的信息；lstat( string $filename)', lstat($filename)));
        var_dump(static::toStr('文件;获取信息函数;', [
            '组; filegroup($filename): ' . filegroup($filename),
            '所有者; fileowner($filename): ' . fileowner($filename),
            sprintf('权限; fileperms($filename): %d (%o)', fileperms($filename), fileperms($filename)),
            '类型; filetype($filename): ' . filetype($filename),
            '大小; filesize($filename): ' . filesize($filename),
            '上次访问时间; fileatime($filename): ' . fileatime($filename),
            '修改时间; filemtime($filename): ' . filemtime($filename),
            'inode 修改时间; filectime($filename): ' . filectime($filename),
            'inode 节点号; fileinode($filename): ' . fileinode($filename),

        ]));

        $tempnamFileDir = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR.'/SingleClass';
        var_dump(static::toStr('文件创建；建立一个具有唯一文件名的文件;如果该目录不存在，tempnam() 会在系统临时目录中生成一个文件，并返回其文件名。 tempnam($tempnamFileDir, "prefix")', $tmpFile =  FileFunction::tempnam($tempnamFileDir, "pre")));
        unlink($tmpFile);
        var_dump(static::toStr('文件创建；以读写（w+）模式建立一个具有唯一文件名的临时文件，返回一个文件句柄。文件会在关闭后（用 fclose()）自动被删除，或当脚本结束后。; tmpfile() : resource'));

        var_dump(static::toStr('文件改；改变文件所属的组； FileFunction::chgrp($filename, "月荷锄归")'));  // 需要获取相关信息,就不执行了
        var_dump(static::toStr('文件改；改变文件模式', FileFunction::chmod($filename, 0755)));
        var_dump(static::toStr('文件改；将 PHP 的 umask 设定为 mask & 0777 并返回原来的 umask。umask([ int $mask] ) : int'));
        var_dump(static::toStr('文件改；改变文件的所有者； FileFunction::chown($filename, "月荷锄归")'));  // 需要获取相关信息,就不执行了
        var_dump(static::toStr('文件改；修改文件的访问和修改时间; touch($filename, time(), time())', FileFunction::touch($filename, time(), time())));

        $linkName = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR.'/SingleClass/linkToTest.txt';
        if(is_file($linkName)){
            unlink($linkName);
        }

        var_dump(static::toStr('链接文件;创建；硬连接; link($filename, $linkName)', FileFunction::link($filename, $linkName)));

        $symlinkName = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR.'/SingleClass/symlinkToTest.txt';
        if(is_file($symlinkName)){
            unlink($symlinkName);
        }



        var_dump(static::toStr('链接文件;创建；符号连接', FileFunction::symlink($this->fileSaveDir .'/test.txt', $symlinkName)));

        var_dump(static::toStr('链接文件;获取符号连接指向的目标( Windows 无法获取符号连接)', readlink($linkName)));


        var_dump(static::toStr('链接文件;改；改变符号链接文件的所有组 group； FileFunction::lchgrp($symlinkName, "月荷锄归")'));// 需要获取相关信息,就不执行了
        var_dump(static::toStr('链接文件;改；符号链接的所有者 FileFunction::lchown($symlinkName, "月荷锄归")'));// 需要获取相关信息,就不执行了


        var_dump(static::toStr('拷贝文件(resource)', FileFunction::copy($filename, $this->fileSaveDir .'/test.bat.txt')));

        var_dump(static::toStr('删除文件(resource)', FileFunction::unlink($this->fileSaveDir .'/test.bat.txt')));



        var_dump(static::toStr('判断 shell 统配符匹配文件名; fnmatch("*.txt",$filename)', FileFunction::fnmatch("*.txt",$filename)));

        var_dump(static::toStr('shells 所用的一般规则匹配文件路径; fnmatch("*.txt",$filename)', FileFunction::glob(HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR.'/SingleClass/test.*', 0)));

        

        var_dump(static::toStr('其他文件判断函数', [
            'file_exists($filename) — 文件或目录判断；文件或目录是否存在: ' . var_export(file_exists($filename),true),
            'is_dir( string $filename) - 文件判断；给定文件名是否是一个目录: ' . var_export(is_dir($filename),true),
            'is_file( string $filename)  - 文件判断；给定文件名是否为一个正常的文件: ' . var_export(is_file($filename),true),
            'is_executable( string $filename)  - 文件判断；给定文件名是否可执行: ' . var_export(is_executable($filename),true),
            'is_link( string $filename)  - 文件判断；给定文件名是否为一个符号连接: ' . var_export(is_link($filename),true),
            'is_readable( string $filename)  - 文件判断；给定文件名是否存在并且可读: ' . var_export(is_readable($filename),true),
            'is_writable( string $filename)  - 文件判断；给定文件名是否存在并且可写; 别名 is_writeable: ' . var_export(is_writable($filename),true),
            'is_uploaded_file( string $filename)  - 文件判断；文件是否是通过 HTTP POST 上传的: ' . var_export(is_uploaded_file($filename),true),
            'linkinfo( string $path) : int  - 文件判断；验证一个连接（由 path 所指向的）是否确实存在（使用 stat.h 中的 S_ISLNK 宏同样的方法）: ' . var_export(linkinfo($filename),true),
        ]));



        var_dump(static::toStr('其他文件函数', [
            'readfile( $filename ,false) =>  读取文件；并写入到输出缓冲',
            'file_put_contents =>  写入文件；将一个字符串写入文件',
            'file_get_contents =>  读取文件；将整个文件读入一个字符串',
            'file =>  读取文件；把整个文件读入一个数组中',
            'move_uploaded_file =>  移动文件；将上传的文件移动到新位置',

            'realpath_cache_size()  =>  文件缓存; 获取真实路径缓冲区的大小: ' . realpath_cache_size() ,
            'realpath_cache_get() =>  文件缓存; 真实路径缓存详情的数组。键是原始路径以及值为具体信息数组',
            'clearstatcache(false, null) =>  文件缓存; 清除文件状态缓存',
        ]));

        //var_dump(static::toStr('真实路径缓存详情的数组。键是原始路径以及值为具体信息数组', realpath_cache_get()));
        //var_dump(static::toStr('清除文件状态缓存; clearstatcache(false, null))', FileFunction::clearstatcache(false, null)));

        var_dump(static::toStr('其他函数', [
            'parse_ini_file =>  载入一个 ini 文件，并将其中的设置作为一个联合数组返回',
            'parse_ini_string =>  解析 ini 字符串，并将其中的设置作为一个联合数组返回',
            'popen( string $command, string $mode) =>  文件指针；打开进程文件指针； 返回一个和 fopen() 所返回的相同的文件指针，只不过它是单向的（只能用于读或写）并且必须用 pclose() 来关闭。此指针可以用于 fgets()，fgetss() 和 fwrite()。当模式为 \'r\'，返回的文件指针等于命令的 STDOUT，当模式为 \'w\'，返回的文件指针等于命令的 STDIN。 ',
            'pclose( resource $handle) =>  文件指针；关闭进程文件指针',
        ]));

        $output = shell_exec('ls \\');

        var_dump($output);
    }


    /**
     * @note 文件内容相关操作
     */
    public function fileHandleTest()
    {
        $filename = $this->fileSaveDir .'/test.txt' ;
        $filename = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR.'/SingleClass/test.txt' ;



        var_dump(static::toStr('使用文件：', $filename));


        var_dump(static::toStr('打开文件(resource); 或者 URL; fopen($filename, "w+b")', $handle = FileFunction::fopen($filename, "r+b")));

        var_dump(static::toStr('文件信息; fstat($handle)', FileFunction::fstat($handle)));


        $writeStr = "<p>Welcome! Today is the <?php echo(date('jS')); ?> of <?= date('F'); ?>.</p>\n".
                "11111 一一一 壹壹壹\n".
                "22222 二二二 贰贰贰\n".
                "33333 三三三 叁叁叁\n".
                "44444 四四四 肆肆肆\n".
                "55555 五五五 伍伍伍\n".
                "66666 六六六 陆陆陆\n".
                "77777 七七七 柒柒柒\n".
                "88888 八八八 捌捌捌\n".
                "99999 九九九 玖玖玖\n".
                "00000 十十十 拾拾拾";

        var_dump(static::toStr(
            '写入文件;把 string 的内容写入指针 handle 处。 fwrite 别名：fputs  ',
            FileFunction::fwrite($handle, $writeStr, 1024*500),
            PHP_EOL . $writeStr
        ));


        var_dump(static::toStr('指针倒回；将 handle 的文件位置指针设为文件流的开头;如果将文件以附加（"a" 或者 "a+"）模式打开，写入文件的任何数据总是会被附加在后面；', rewind($handle)));

        var_dump(static::toStr('指针中定位; 获取文件指针读/写的位置;', FileFunction::ftell($handle)));

        var_dump(static::toStr('指针中定位; 新位置从文件头开始以字节数度量; SEEK_SET SEEK_CUR SEEK_END; fseek($handle, 0, SEEK_SET)', FileFunction::fseek($handle, 0, SEEK_SET)));

        var_dump(static::toStr('获取一个字符从文件句柄中; fgetc($handle)', FileFunction::fgetc($handle)));

        fseek( $handle, 0);
        var_dump(static::toStr('获取一行字符。从文件句柄中; fgets($handle, 1024)', FileFunction::fgets($handle, 1024)));

//        fseek( $handle, 0);  // 已废弃
//        var_dump(static::toStr('获取一行字符。并过滤掉 HTML 标记; fgetss($handle, 1024)', FileFunction::fgetss($handle, 1024)));

        var_dump(static::toStr('获取一行字符。根据指定的 format（定义于 sprintf() 的文档中）来解释输入; fscanf($handle, "%s \%s %s")', FileFunction::fscanf($handle, "%s %s %s")));

        var_dump(static::toStr('获取一定长度；从文件指针 handle 读取最多 length 个字节', FileFunction::fread($handle, 3) ));

        var_dump(static::toStr('将文件截断到给定的长度。FileFunction::ftruncate($handle, 100)',FileFunction::ftruncate($handle, 100)));

        fseek( $handle, 0);
        var_dump(static::toStr('输出缓冲区;将给定的文件指针从当前的位置读取到 EOF 并把结果写到缓冲区。FileFunction::fpassthru($handle)'));
        FileFunction::fpassthru($handle);

        var_dump(static::toStr('判断文件指针是否到了文件结束的位置', FileFunction::feof($handle)));

        var_dump(static::toStr('关闭一个已打开的文件指针;fopen() 或 fsockopen() 成功打开的; ', FileFunction::fclose($handle)));


        var_dump(static::toStr('其他函数', [
            'fflush( $handle)   =>  强制将所有缓冲的输出写入 handle 文件句柄所指向的资源',
            'fputcsv($handle,[a,b,c], ",", """)   =>  从文件指针中读入一行并解析 CSV 字段',
            'fgetcsv($handle,0, ",", """)   =>  从文件指针中读入一行并解析 CSV 字段',

            'set_file_buffer   =>  stream_set_write_buffer() 的别名',

        ]));

    }


    /**
     * @note 一个文件锁的例子
     */
    public function fileHandleFlockTest(){

        set_time_limit(30);

        $fileLocker = new class  {
            protected static $loc_files = array();
            /**
             * @param $file_name
             * @param false $wait false:不阻塞; true:阻塞;
             * @return false|resource
             */
            public static function lockFile($file_name, $wait = false) {
                $loc_file = fopen($file_name, 'c');
                if ( !$loc_file ) {
                    throw new \Exception('Can\'t create lock file!');
                }
                if ( $wait ) {
                    $lock = flock($loc_file, LOCK_EX);
                } else {
                    $lock = flock($loc_file, LOCK_EX | LOCK_NB);
                }
                if ( $lock ) {
                    self::$loc_files[$file_name] = $loc_file;
                    fprintf($loc_file, "%s\n", getmypid());
                    return $loc_file;
                } else if ( $wait ) {
                    throw new \Exception('Can\'t lock file!');
                } else {
                    return false;
                }
            }


            public static function unlockFile($file_name) {
                fclose(self::$loc_files[$file_name]);
                @unlink($file_name);
                unset(self::$loc_files[$file_name]);
            }
        };




        $filename = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR.'/SingleClass/1.lock';

        if (!$fileLocker::lockFile($filename)) {
            echo "Can't lock file\n";
            echo '已有进程在执行！' . "\n";
            die();
        }

        echo '开始运行' . "\n";
        sleep(10);

        $fileLocker::unlockFile($filename);
        echo "All Ok\n";



//        for ($i = 1; $i <= 25; $i++) {
//
//            $res = $fileLocker::lockFile($filename);
//
//            if (!$res) {
//                echo "Can't lock file\n";
//                echo '已有进程在执行！' . "\n";
//                sleep(1);
//                //die();
//            }else{
//
//                echo '开始运行' . "\n";
//                sleep(10);
//
//                $fileLocker::unlockFile($filename);
//                echo "All Ok\n";
//
//                break;
//
//            }
//        }


    }




}

