<?php
/**
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
 * Mime 类型
 *  MIME (Multipurpose Internet Mail Extensions) 是描述消息内容类型的因特网标准。
 *  MIME 消息能包含文本、图像、音频、视频以及其他应用程序专用的数据。
 *  官方的 MIME 信息是由 Internet Engineering Task Force (IETF) 在下面的文档中提供的：
 *      RFC-822 Standard for ARPA Internet text messages
 *      RFC-2045 MIME Part 1: Format of Internet Message Bodies
 *      RFC-2046 MIME Part 2: Media Types
 *      RFC-2047 MIME Part 3: Header Extensions for Non-ASCII Text
 *      RFC-2048 MIME Part 4: Registration Procedures
 *      RFC-2049 MIME Part 5: Conformance Criteria and Examples
 *
 *
 */



namespace HappyLin\OldPlugin\Test\SPLTest;


use HappyLin\OldPlugin\SingleClass\SPL\FileHandling\{FileInfo, FileObject};
use \HappyLin\OldPlugin\SingleClass\SPL\FileHandling\Shortcut\FileObject as MyFileObject;


use HappyLin\OldPlugin\Test\TraitTest;
use HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits\System;

use HappyLin\OldPlugin\SingleClass\Url;

class FileHandlingTest
{

    use TraitTest;
    use System;

    public function __construct()
    {
        $this->fileSaveDir = static::getTestDir() . '/Public/SingleClass';
    }
    


    /**
     * @note SplFileInfo 类获取文件信息
     */
    public function fileInfoTest()
    {
        //$fileName = $this->fileSaveDir . '/FileHandlingTest.txt';

        $fileName = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR . '/SingleClass/FileHandlingTest.txt';

        $fileInfo = new FileInfo($fileName);


        var_dump(static::toStr('返回不带路径信息的文件、目录或链接的基本名', $fileInfo->getBasename('.txt')));
        var_dump(static::toStr('获取不包含任何路径信息的文件名', $fileInfo->getFilename()));
        var_dump(static::toStr('获取文件的路径，省略文件名和任何尾部斜杠', $fileInfo->getPath()));
        var_dump(static::toStr('获取文件路径', $fileInfo->getPathname()));
        var_dump(static::toStr('展开所有符号链接，解析相对引用并返回文件的真实路径 ', $fileInfo->getRealPath()));
        var_dump(static::toStr('获取文件的展名', $fileInfo->getExtension('')));
        var_dump(static::toStr('获取文件的类型', $fileInfo->getType()));
        var_dump(static::toStr('获取文件的文件大小（以字节为单位）', $fileInfo->getSize()));
        var_dump(static::toStr('检查此 SplFileInfo 对象引用的文件是否存在并且是常规文件。', $fileInfo->isFile()));
        var_dump(static::toStr('判断文件是否为目录', $fileInfo->isDir()));
        var_dump(static::toStr('判断文件是否为链接', $fileInfo->isLink()));
        var_dump(static::toStr('判断文件是否可读', $fileInfo->isReadable()));
        var_dump(static::toStr('获取文件系统链接的目标', $fileInfo->getLinkTarget()));
        var_dump(static::toStr('创建文件的 SplFileObject 对象', $fileInfo->openFile('r')));
        var_dump(static::toStr('有__toString()方法支持 echo $fileInfo;'));

        echo $fileInfo;

        var_dump(static::toStr('获取文件的最后访问时间', $fileInfo->getATime()));
        var_dump(static::toStr('获取文件内容更改的时间', $fileInfo->getMTime()));
        var_dump(static::toStr('获取文件 inode 的修改时间', $fileInfo->getCTime()));
        var_dump(static::toStr('获取文件组。', $fileInfo->getGroup()));
        var_dump(static::toStr('获取文件所有者。 所有者 ID 以数字格式返回。。', $fileInfo->getOwner()));
        var_dump(static::toStr('获取文件系统对象的 inode 编号', $fileInfo->getInode()));
        var_dump(static::toStr('获取文件的文件权限', $fileInfo->getPerms()));
        var_dump(static::toStr('判断文件是否可以执行', $fileInfo->isExecutable()));


        var_dump(static::toStr('获取文件父级的SplFileInfo对象', $fileInfo->getPathInfo()));
        var_dump(static::toStr('判断文件父级是否为目录', $fileInfo->getPathInfo()->isDir()));


    }


    /**
     * @note SplFileObject 类操作文件内容
     */
    public function fileObjectTest()
    {

        $fileName = $this->fileSaveDir . '/FileHandlingTest.txt';

        //$fileName = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR . '/SingleClass/FileHandlingTest.txt';

        $fileObject = new FileObject($fileName, 'a+b');


        var_dump('SplFileObject extends SplFileInfo implements RecursiveIterator, SeekableIterator');
        var_dump($fileObject);

        $str = "11111 一一一 壹壹壹\n".
                "22222 二二二 贰贰贰\n".
                "33333 三三三 叁叁叁\n".
                "44444 四四四 肆肆肆\n".
                "55555 五五五 伍伍伍\n".
                "66666 六六六 陆陆陆\n".
                "77777 七七七 柒柒柒\n".
                "88888 八八八 捌捌捌\n".
                "99999 九九九 玖玖玖\n".
                "00000 十十十 拾拾拾";

        // 置空原来的数据
        $fileObject->ftruncate(0);

        var_dump(static::toStr('写入数据'.$str, $fileObject->fwrite($str)));

        // 将文件倒回到第一行
        $fileObject->rewind();

        var_dump(static::toStr('收集文件的统计信息', $fileObject->fstat()));
        var_dump(static::toStr('获取为 SplFileObject 实例设置的标志作为 int', $fileObject->getFlags()));
        var_dump(static::toStr('判断是否到达文件尾', $fileObject->eof()));
        var_dump(static::toStr('获取文件中获取一个字符', $fileObject->fgetc()));
        var_dump(static::toStr('获取文件下一行的字符串', $fileObject->fgets()));
        var_dump(static::toStr('输出文件指针上的所有剩余数据', $fileObject->fpassthru()));

        var_dump(static::toStr('跳转索引文件中的第1行seek(0)', $fileObject->seek(0)));
        var_dump(static::toStr('文件索引从当前位置偏移六个字节(查找成功则返回 0，否则返回 -1)', $fileObject->fseek(6)));
        var_dump(static::toStr('文件流中当前偏移量', $fileObject->ftell()));


        var_dump(static::toStr('从文件中读取给定的字节数。', $fileObject->fread($fileObject->getSize())));

        var_dump(static::toStr('将文件倒回到第一行rewind()', $fileObject->rewind()));
        var_dump(static::toStr('根据格式"%s %s %s"解析来自文件的输入。', $fileObject->fscanf("%s %s %s")));


        var_dump(static::toStr('将文件截断为 9 字节', $fileObject->ftruncate(12)));


        // 将文件倒回到第一行
        $fileObject->rewind();

        //$output = ob_get_clean();
        //var_dump($a);
        //var_dump(static::toStr('强制将所有缓冲输出写入文件; 这个不知怎么用。', $fileObject->fflush()));

        var_dump(static::toStr('输出文件指针上的所有剩余数据。', $fileObject->fpassthru()));
    }


    /**
     * @note CSV 格式写入文件；和获取
     */
    public function fileObjectCSVTest()
    {
        $fileName = $this->fileSaveDir . '/FileHandlingTest.txt';

        $fileObject = new FileObject($fileName, 'a+b');


        $str = "11111 一一一 壹壹壹\n".
            "22222 二二二 贰贰贰\n".
            "33333 三三三 叁叁叁\n".
            "44444 四四四 肆肆肆\n".
            "55555 五五五 伍伍伍\n".
            "66666 六六六 陆陆陆\n".
            "77777 七七七 柒柒柒\n".
            "88888 八八八 捌捌捌\n".
            "99999 九九九 玖玖玖\n".
            "00000 十十十 拾拾拾";

        $strArr = explode("\n", $str);
        $strArr = array_map(function ($l){return explode(' ', $l);}, $strArr);


        // 置空原来的数据
        $fileObject->ftruncate(0);


        var_dump(static::toStr('设置要由 SplFileObject 使用的标志 READ_CSV', $fileObject->setFlags(FileObject::READ_CSV)));

        var_dump(static::toStr('写入数据'.$str));

        foreach ($strArr as $a) $fileObject->fputcsv($a);

        var_dump(static::toStr('获取用于解析 CSV 字段的分隔符、外壳和转义字符。', $fileObject->getCsvControl()));

        $fileObject->rewind();
        var_dump(static::toStr('从 CSV 格式的文件中获取一行', $fileObject->fgetcsv()));

        foreach ($fileObject as $item) {
            var_dump($item);
        }

    }


    /**
     * @note 一定义类 MyFileObject 操作文件
     */
    public function myFileObjectTest()
    {
        $fileName = $this->fileSaveDir . '/test.txt';

        $file = MyFileObject::getInstance($fileName,'read');

        // 模拟Linux  -l: lines 行数； -w: words 单词数 ；-c: bytes 字节
        var_dump($file->wc('lc'));


        var_dump(static::toStr('重新写入内容', $file->write("\n111111111111111111\n222222222222222222\n333333333333333333\n444444444444444444\n555555555555555555")));
        var_dump(static::toStr('添加内容', $file->add("\n666666666666666666\n777777777777777777\n888888888888888888\n999999999999999999")));

        var_dump(static::toStr('分行获取内容', $file->less(3,3)));
        var_dump(static::toStr('获取开头几行内容', $file->head(3)));
        var_dump(static::toStr('获取末尾几行内容', $file->tail(3)));
        var_dump(static::toStr('获取总行数', $file->getCountRow()));
        var_dump(static::toStr('获取字符串实时长度', $file->getRealSize()));
        var_dump(static::toStr('获取文件的 MIME 类型', $file->getMimeType()));
        var_dump(static::toStr('获取文件全部内容', $file->read()));

    }


    /**
     * @note 测试将数组下载为 Csv 文件
     */
    public function myFileObjectExportToCsvTest()
    {
        /**
         * 测试文件整体被作为回调函数使用，有脏输出，才加上 ob_clean(); 和 exit();
         */

        //清空（擦掉）缓冲区
        ob_clean();
        $data = [
            ['值1','值2','值3'],
            ['值11','值22','值33'],
            ['值111','值222','值333']
        ];
        $fileName = "测试导出 csv 文件文件名";

        \HappyLin\OldPlugin\SingleClass\Network\HeaderHelp::getInstance()->setContentType('application/vnd.ms-excel');
        //var_dump(\HappyLin\OldPlugin\SingleClass\Network\HeaderHelp::getInstance()->getHeaderOption());
        //die();

        $result = MyFileObject::exportToCsv($data,$fileName);

        exit();
    }




    /**
     * SplTempFileObject 类为临时文件提供面向对象的接口。
     *
     * extends SplFileObject  implements SeekableIterator  , RecursiveIterator
     * @note SplTempFileObject 类创建临时文件
     */
    public function splTempFileObjectTest()
    {
        $max_memory = 1024*1024;

        /**
         * 参数就一个  $max_memory
         * 临时文件使用的最大内存量（以字节为单位，默认为 2 MB）。 如果临时文件超过此大小，它将被移动到系统临时目录中的一个文件中。
         * 如果 max_memory 为负数，则只使用内存。 如果 max_memory 为零，则不会使用内存。
         */
        $tempFileObject = new \SplTempFileObject($max_memory);

        $tempFileObject->fwrite("This is the first line\n");
        $tempFileObject->fwrite("And this is the second.\n");
        echo "Written " . $tempFileObject->ftell() . " bytes to temporary file.\n\n";

        // Rewind and read what was written
        $tempFileObject->rewind();
        foreach ($tempFileObject as $line) {
            var_dump($line);
        }

    }



}




