<?php
/**
 *
 *
 */



namespace HappyLin\OldPlugin\Test\StreamsTest;


use HappyLin\OldPlugin\SingleClass\Streams\{StreamWrapper, StreamFunction};

use HappyLin\OldPlugin\Test\TraitTest;
use HappyLin\OldPlugin\SingleClass\AffectingPHPBehaviour\OptionsInfo\Traits\System;


class StreamsTest
{

    use TraitTest;
    use System;

    public function __construct()
    {

    }


//    /**
//     *
//     */
//    public function streamWrapperTest()
//    {
//        $streamWrapperTest = new StreamWrapper();
//    }

    private static function encodeHeader(array $header, string $headerStr = '')
    {
        $headerStr .= "\r\n";
        foreach ($header as $item=>$value){
            if($value){
                $headerStr .= "{$item}:{$value}\r\n";
                continue;
            }
            $headerStr .= "{$item}\r\n";
        }
        return trim($headerStr);
    }


    /**
     * @note 知识量不够，不行
     */
    public function streamContextTest()
    {

        StreamFunction::stream_context_create();

        $sendDate = array(
            'method' => 'get',
            'baz' => 'bomb',
        );
        $get_opts = array(
            'http'=>array(
                'method'  => "GET",
                'header'  => self::encodeHeader( array(
                    'Accept-language' => 'en',
                    "Cookie" => http_build_query(array(
                        'foo' => 'bar'
                    )),
                    'Content-type' => 'application/x-www-form-urlencoded',
                    'Content-length' => strlen(http_build_query($sendDate)),
                )),
                'content' => http_build_query($sendDate),
                //'proxy'=>"tcp://10.54.1.39:8000"
                //'proxy'=>"http://127.0.0.1:81"
                //'proxy'=>"http://127.0.0.1/composer/composer_test/vendor/happylin/oldplugin/index.php?f=SingleClassTest.php&m=apiTest"

            )
        );


        $sendDate['method'] = 'post';
        $post_opts = array(
            'http'=>array(
                'method'  => "POST",
                'header'  => self::encodeHeader( array(
                    'Accept-language' => 'en',
                    "Cookie" => http_build_query(array(
                        'foo' => 'bar'
                    )),
                    'Content-type' => 'application/x-www-form-urlencoded',
                    'Content-length' => strlen(http_build_query($sendDate)),
                )),
                'content' => http_build_query($sendDate),
//                'proxy'=>"tcp://10.54.1.39:8000"
                //'proxy'=>"tcp://127.0.0.1"
                //http://127.0.0.1/composer/composer_test/vendor/happylin/oldplugin/index.php?f=SingleClassTest.php&m=apiTest
            )
        );

        $default_opts = $get_opts;
        //$default_opts = $post_opts;

        $default = StreamFunction::stream_context_set_default($default_opts);

//        readfile('http://127.0.0.1/composer/composer_test/vendor/happylin/oldplugin/index.php?f=StreamsTest\StreamsTest.php');
//        readfile('https://www.baidu.com/composer/composer_test/vendor/happylin/oldplugin/index.php?f=SingleClassTest.php&m=apiTest');


//        die();

//        $default = StreamFunction::stream_context_get_default($default_opts);

//        $context = StreamFunction::stream_context_create($opts);


        var_dump($default);


//        $context = StreamFunction::stream_context_create($opts);


//        $fp = fopen('https://www.baidu.com/index.php?tn=monline_3_dg', 'r', false, $context);
//        fpassthru($fp);
//        fclose($fp);


    }




    public function test()
    {

    }





}















