<?php
/**
 * 为了展示与操作 test 文件夹PHP文件
 */

namespace HappyLin\OldPlugin\SingleClass\FileSystem;


use HappyLin\OldPlugin\SingleClass\Network\HeaderHelp;
use HappyLin\OldPlugin\SingleClass\SPL\FileHandling\Shortcut\FileObject;

use HappyLin\OldPlugin\SingleClass\SPL\Iterators\RecursiveDirectoryIterator;


use HappyLin\OldPlugin\SingleClass\VariableAndType\Reflection\ReflectionClass;
use mysql_xdevapi\Exception;
use ReflectionMethod;
use HappyLin\OldPlugin\Test\TraitTest;

class PHPFileLink
{

    use TraitTest;

    /**
     * 文件地址
     * @var mixed|string
     */
    public $dir;

    /**
     * 文件及其文件夹正则匹配规则
     * @var string
     */
    public $filePattern;

    /**
     * 类方法正则匹配规则
     * @var string
     */
    public $methodPattern;


    /**
     * @var FileObject
     */
    public $fileObject;

    /**
     * @var array $_GET 参数
     */
    public $get = [];


    /**
     * @var array 遇到该函数方法；直接执行，不展示页面
     */
    public $excludeMethod;


    /**
     * PHPFileLink constructor.
     * 读取php文件并调用其中方法
     *
     * @param string $dir 脚本的路径
     * @param string $filePattern 文件及其文件夹正则匹配规则
     * @param string $methodPattern 类方法正则匹配规则
     */
    public function __construct(
        string $dir = null ,
        string $filePattern = '/.*(Test|Test.php)$/',
        string $methodPattern = '/.*(Test)$/',
        array $excludeMethod = array(
            'HappyLin\OldPlugin\Test\SingleClassTest' => array('apiTest','linshiTest')
        )

    )
    {

        HeaderHelp::getInstance()->setContentType('html');

        if(!$this->dir)$this->dir =  $_SERVER['SCRIPT_FILENAME'];

        $this->filePattern = $filePattern;

        $this->methodPattern = $methodPattern;

        $this->excludeMethod = $excludeMethod;

        //$this->route();
    }

    /**
     * @note 获取要搜索的测试类的文件夹
     */
    public function getShowDir()
    {
        $dir = realpath(__DIR__.'/../../Test/Public');
        $dir = str_replace('\\','/',$dir);

        !defined('HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR')&& define('HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR', $this->getRelativePath($dir, $this->dir));

        $this->dir = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR . '/..';

    }


    public function route($get)
    {
        //$oldpluginDir = str_replace('\\', '/', dirname(dirname(__DIR__)));


        $this->getShowDir();


        if(empty($get)){

            $this->showView();

        }else{
            $this->get = [
                'f' => isset($get['f'])?strval($get['f']):'',
                'm' => isset($get['m'])?strval($get['m']):''
            ];

            $filename = $this->dir .'/'. $this->get['f'];


            $this->fileObject = new FileObject($filename);
            if(!$this->fileObject->isFile()){
                $this->error('找不到文件');
                return;
            }

            $this->handle();

        }
    }

    public function getRelativePath($path1, $path2, $directory_separator = '/'){
        $arr1 = explode($directory_separator, $path1);
        $arr2 = explode($directory_separator, $path2);

        // 获取相同路径的部分
        $intersection = array_intersect_assoc($arr1, $arr2);

        $depth = 0;

        for($i=0,$len=count($intersection); $i<$len; $i++){
            $depth = $i;
            if(!isset($intersection[$i])){
                break;
            }
        }

        // 前面全部匹配
        if($i==count($intersection)){
            $depth ++;
        }

        // 将path2的/ 转为 ../，path1获取后面的部分，然后合拼

        // 计算前缀
        if(count($arr2)-$depth-1>0){
            $prefix = array_fill(0, count($arr2)-$depth-1, '..');
        }else{
            $prefix = array('.');
        }

        $tmp = array_merge($prefix, array_slice($arr1, $depth));

        $relativePath = implode($directory_separator, $tmp);

        return $relativePath;
    }



    public function showView()
    {

        //var_dump($this->dir);die();


        $recursiveDirectoryIterator = new RecursiveDirectoryIterator($this->dir.'/',\FilesystemIterator::KEY_AS_FILENAME | \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS);


        $recursiveDirectoryIterator = new \RecursiveRegexIterator($recursiveDirectoryIterator, $this->filePattern);

        include HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR .'/View/PHPFileLink.php';
    }


    private function handle()
    {

        $methodIterator = new \ArrayIterator([]);

        $classnameFile = str_replace('/', '\\', $this->get['f']);

        // 如果不是php文件；只展示页面数据
        if($this->fileObject->getExtension() !== 'php') {
            $classname = 'HappyLin\OldPlugin' . '\\'. 'Test'. '\\' . $classnameFile;
            $this->showPage($classname, $methodIterator);
            return;
        }

        $classname = 'HappyLin\OldPlugin' . '\\'. 'Test'. '\\' . substr($classnameFile, 0, -4);

        $reflectionClass = new ReflectionClass($classname);
        // 类不可初始化 或 方法不存在； 报错
        if(!$reflectionClass->isInstantiable()){
            $this->error();
            return;
        }


        if(!empty($this->get['m'])){

            $this->callMethod($reflectionClass);
        }else{
            $this->showMethod($reflectionClass);
        }
    }


    /**
     * 执行出错提示
     * @param string $msg 提示信息
     */
    private function error($msg = '未找到可执行方法')
    {
        HeaderHelp::getInstance()->setContentType('html')->setHttpCode('404');
        echo $msg;
    }

    /**
     * 展示文件内容
     * @param $classname 带命名空间文件名称
     */
    private function showPage(string $classname)
    {
        $get = $this->get;

        $methodIterator = [];

        $classstr = $this->fileObject->read();

        $classstr = htmlentities($classstr);

        $viewData = compact('classname','methodIterator','classstr', 'get');

        include HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR .'/View/PHPFileLinkMethod.php';
    }


    private function showMethod(ReflectionClass $reflectionClass)
    {
        $get = $this->get;
        $classname = $reflectionClass->getName();
        $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);

        $methodIterator = new \ArrayIterator($methods);
        $methodIterator = new \CallbackFilterIterator(
            $methodIterator,
            function ($current)
            {
                return preg_match($this->methodPattern, $current->getName());
            }
        );

        $classstr = $this->fileObject->read();

        $classstr = htmlentities($classstr);

        $viewData = compact('classname','methodIterator','classstr', 'get');

        include HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR .'/View/PHPFileLinkMethod.php';
    }


    private function callMethod(ReflectionClass $reflectionClass)
    {
        $method = $this->get['m'];

        if(!$reflectionClass->hasMethod($method) || !preg_match($this->methodPattern, $method)){
            $this->error();
            return;
        }



        $reflectionMethod = $reflectionClass->getMethod($method);
        if(!$reflectionMethod->isPublic()){
            $this->error();
            return;
        }

        $classname = $reflectionClass->getName();

        if(isset($this->excludeMethod[$classname]) && in_array($method ,$this->excludeMethod[$classname])){
            $reflectionMethod->invokeArgs($reflectionClass->newInstance(), []);
            return;
        }

        $methodstr = $this->fileObject->less($reflectionMethod->getStartLine()-1, $reflectionMethod->getEndLine()-$reflectionMethod->getStartLine()+1);
        $methodstr = htmlentities(implode('', $methodstr));

        //var_dump($reflectionMethod->getDocComment());

//        $aa = '';
//        // 开启无限缓冲区
//        ob_start();
//        try {
//            $reflectionMethod->invokeArgs($reflectionClass->newInstance(), []);
//        }catch (\ErrorException $exception){
//            //\HappyLin\OldPlugin\SingleClass\FileSystem\PHPFileLink::varDump($exception);
//            var_dump($exception);
//            $fileName = \HappyLin\OldPlugin\SingleClass\Url::scriptRootDir() . '/Test/SingleClass' . '/download.txt';
//            $file = \HappyLin\OldPlugin\SingleClass\SPL\FileHandling\Shortcut\FileObject::getInstance($fileName,'write');
//            $file->add(print_r($exception, true) . PHP_EOL);
//        }
//        $html = ob_get_clean();

        //$reflectionMethod->invokeArgs($reflectionClass->newInstance(), []);

        $viewData = compact('reflectionMethod','classname','methodstr');

        include HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR .'/View/PHPFileLinkMethodRes.php';
    }


    public static function varDump($err){
        var_dump($err);
    }


}







