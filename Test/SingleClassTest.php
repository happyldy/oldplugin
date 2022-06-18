<?php

namespace HappyLin\OldPlugin\Test;

use HappyLin\OldPlugin\SingleClass\{GraphImage, PinYin, Url, Curl, PictureSave};

use HappyLin\OldPlugin\SingleClass\Network\{HeaderHelp};

use HappyLin\OldPlugin\SingleClass\FileSystem\FileProcess;

use HappyLin\OldPlugin\SingleClass\SPL\FileHandling\Shortcut\FileObject;



class SingleClassTest
{

    use TraitTest;


    public $fileSaveDir;


    public function __construct()
    {
        $this->fileSaveDir = static::getTestDir() . '/Public/SingleClass';

        HeaderHelp::getInstance()->shortcutCORS();
    }


    /**
     * @note 测试接口用， 直接返回接收的数据 json格式；
     */
    public function apiTest()
    {

        HeaderHelp::getInstance()->setContentType('json')->execute();


//        $fileName = $this->fileSaveDir . '/download.txt';
//        $file = FileObject::getInstance($fileName,'write');
//        $_SERVER['__GET'] = $_GET;
//        $_SERVER['__POST'] = $_POST;
//        $_SERVER['__INPUT'] = Url::getContentType()==="application/json" ? json_decode(file_get_contents("php://input")): file_get_contents("php://input");
//        $file->add(print_r($_SERVER, true) . PHP_EOL);

        echo json_encode(
            [
                'phpInput' => Url::getContentType()==="application/json" ? json_decode(file_get_contents("php://input")): file_get_contents("php://input"),
                'get' => $_GET,
                'post' => $_POST
            ]
        );
    }


    /**
     * @note 生成验证码
     */
    public function graphImageTest()
    {
        $GraphImage = new GraphImage();

        $fileName = $this->fileSaveDir . '/verifyCode.png';

        $res = $GraphImage->verifyCode('helloWord', 5, 20, array(-30, 30))->save($fileName, 'png', true);

        if ($res) {
            $src = HAPPLYLIN_OLDPLUGIN_RELATAVE_DIR . '/SingleClass/verifyCode.png';
            echo "<img src='{$src}' />";
        } else {
            echo "<div>保存图片失败</div>";
        }
    }


    /**
     * @note 汉字转拼音
     */
    public function pinYinTest()
    {
        $Pinyin = new PinYin();

        $str = '林大莹';

        echo "<div>'{$str}'拼音：{$Pinyin->getpy($str)}</div>";

        echo "<div>'{$str}'获取拼音的大写首字母：{$Pinyin->getpy('林大莹',false)}</div>";
    }

    /**
     * @note Client URL 库；测试 获取百度网页
     */
    public function curlTest()
    {
        $curl = new Curl();
        $res = $curl->clearExtraOptions()
            ->setSSLVerify(true, $this->fileSaveDir . '/CA/cacert.pem')
            ->setCookieJar($this->fileSaveDir . '/cookie.txt')
            ->setFollowLocation(true)
            ->curlGet('www.baidu.com');

        //var_dump($res);
        var_dump('curl获取 www.baidu.com 的页面：');
        echo $res;
    }


    /**
     * @note Client URL 库；测试 并发获取网页信息
     */
    public function curlMultiTest()
    {
        $GLOBALS['successnum'] = 0;
        $GLOBALS['errornum'] = 0;

        //使用方法
        $deal = function ($data){
            if ($data["error"] == '') {
                $GLOBALS['successnum']++;
            } else {
                $GLOBALS['errornum']++;
                echo $data["url"]." -- ".$data["error"]."\n<br>";
            }
        };

        $urls = array();
        for ($i = 0; $i < 1; $i++) {
            $urls[] = 'http://www.baidu.com/s?wd=etao_'.$i;
//            $urls[] = 'http://www.so.com/s?q=etao_'.$i;
//            $urls[] = 'http://www.soso.com1/q?w=etao_'.$i;
            $urls[] = 'https://www.runoob.com/try/try.php?filename=trycss3_transition';
        }

        $curl = new Curl();

        $res = $curl->setSSLVerify(true, $this->fileSaveDir . '/CA/cacert.pem')
            ->setCookieJar($this->fileSaveDir . '/cookie.txt')
            ->multiPostCurl($urls, $deal);
        var_dump($res);
        var_dump($GLOBALS['successnum'], $GLOBALS['errornum']);
        
    }







}







//function get_debug_type($value)
//{
//    switch (true) {
//        case null === $value: return 'null';
//        case \is_bool($value): return 'bool';
//        case \is_string($value): return 'string';
//        case \is_array($value): return 'array';
//        case \is_int($value): return 'int';
//        case \is_float($value): return 'float';
//        case \is_object($value): break;
//        case $value instanceof \__PHP_Incomplete_Class: return '__PHP_Incomplete_Class';
//        default:
//            if (null === $type = @get_resource_type($value)) {
//                return 'unknown';
//            }
//
//            if ('Unknown' === $type) {
//                $type = 'closed';
//            }
//
//            return "resource ($type)";
//    }
//
//    $class = \get_class($value);
//
//    if (false === strpos($class, '@')) {
//        return $class;
//    }
//
//    return (get_parent_class($class) ?: key(class_implements($class)) ?: 'class').'@anonymous';
//}


