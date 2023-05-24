<?php
declare(strict_types=1);
namespace HappyLin\OldPlugin\Test;

use HappyLin\OldPlugin\SingleClass\{GraphImage,
    PinYin,
    SPL\Iterators\RecursiveDirectoryIterator,
    TextProcessing\PCRE\PCRE,
    Url,
    Curl,
    PictureSave};

use HappyLin\OldPlugin\SingleClass\Network\{HeaderHelp};

use HappyLin\OldPlugin\SingleClass\FileSystem\FileProcess;

use HappyLin\OldPlugin\SingleClass\SPL\FileHandling\Shortcut\FileObject;



class SplFileObject extends \SplFileObject
{
    // GB2312  GB18030  UTF-8  UNICODE  
    public $code = '';
    public function __construct($filename, $mode = 'r', $useIncludePath = false, $context = null)
    {
        parent::__construct($filename, $mode, $useIncludePath, $context);
    }

    public function setInternalEncoding($code = 'GB18030'){
        $this->code = $code;
        return $this;
    }

    public function ffgetcsv()
    {
        $data = $this->fgetcsv();
        if(empty($data)){
            return $data;
        }
        if(!empty($this->code)){
            var_dump($data);
            $csv_str = implode(',', $data);
            $csv_str = mb_convert_encoding($csv_str, $this->code, 'UTF-8');
            $data =  str_getcsv($csv_str);
            //var_dump($data);
            $data = mb_convert_encoding($data, 'UTF-8', $this->code);
        }
        return $data;
    }
}


class SingleClassTest
{

    use TraitTest;


    public $fileSaveDir;


    public function __construct()
    {
        $this->fileSaveDir = static::getTestDir() . '/Public/SingleClass';

        HeaderHelp::getInstance()->shortcutCORS();
    }


    const DEFAULT_FALLBACK_ENCODING = 'CP1252';
    const GUESS_ENCODING = 'guess';
    const UTF8_BOM = "\xEF\xBB\xBF";
    const UTF8_BOM_LEN = 3;
    const UTF16BE_BOM = "\xfe\xff";
    const UTF16BE_BOM_LEN = 2;
    const UTF16BE_LF = "\x00\x0a";
    const UTF16LE_BOM = "\xff\xfe";
    const UTF16LE_BOM_LEN = 2;
    const UTF16LE_LF = "\x0a\x00";
    const UTF32BE_BOM = "\x00\x00\xfe\xff";
    const UTF32BE_BOM_LEN = 4;
    const UTF32BE_LF = "\x00\x00\x00\x0a";
    const UTF32LE_BOM = "\xff\xfe\x00\x00";
    const UTF32LE_BOM_LEN = 4;
    const UTF32LE_LF = "\x0a\x00\x00\x00";



    public function linshiTest()
    {

        $str = '[{"name": "facebook","messages": "0","consumers": "1"},{"name": "amq_rabbitmq_event","messages": "0","consumers": "1"}]';

        var_dump(json_decode($str, true));

    //     $data = [
    //         [
    //             'name'=>'linshi', 
    //             'value'=>'1'
    //         ],
    //         [
    //             'name'=>'linshi2', 
    //             'value'=>'2'
    //         ],
    //     ];
    //    echo  $str = json_encode($data);


die();
        phpinfo();
        die();

        $str = '[{"event_name":"ViewContent","event_time":1683366224,"event_source_url":"http:\/\/jaspers-market.com\/product\/1234","user_data":{"em":["8830eedd6c6b5ea97d181563a349476ca1bb25ace1f94b5c5e48d9cad727941b"],"ph":["254aa248acb47dd654ca3ea53f48c2c26d641d23d7e2e93a1ec56258df7674c4","6f4fcb9deaeadc8f9746ae76d97ce1239e98b404efe5da3ee0b7149740f89ad6"],"fbc":"fb.1.1554763741205.AbCdEfGhIjKlMnOpQrStUvWxYz12345678901","fbp":"fb.1.1558571054389.10981153971"},"custom_data":{"value":123.45,"currency":"usd","contents":[{"id":"product1234","quantity":1,"delivery_category":"home_delivery"}]},"action_source":"website"}]';
        
        
        var_export(json_decode($str,true));
        die();

'[{"event_name":"ViewContent","event_time":1683513007,"event_source_url":"http:\/\/jaspers-market.com\/product\/1234","user_data":{"em":["e45ce36248a3ec0cf15c1fed52d6de93ad87f43a640326a86a0aab92982af8ea","1ecf556b0f81fe9551ff7106a5c2377999e8e5219bd9bcd8544980f28d046269"],"ph":["c775e7b757ede630cd0aa1113bd102661ab38829ca52a6422ab782862f268646","e476a1537b03d06db3ffffdbe4ac07a137333c5f6ef58d7375a4238751d7c3d8"],"ge":["252f10c83610ebca1a059c0bae8255eba2f95be4d1d7bcfa89d7248a82d9f111","62c66a7a5dd70c3146618063c344e531e6d4b59e379808443ce962b3abd63c5a"],"db":["2a4fbac77ef76e8f1efa5506abb74761ea9b4769a8c623d473a91c594a4b021b","5ba57466168f9b07bace85e44b1e4e8bee574104e1a6a6f89f717dc923b3bd6b"],"ln":["7fbdad7321ac62f60030873e83a89c8b361df9133662cb05714cb4eafe8c401d","6627835f988e2c5e50533d491163072d3f4f41f5c8b04630150debb3722ca2dd"],"fn":["84b7057086132df12d080d28503833f0fae8e4609054667546b12e7269f83fc8","78675cc176081372c43abab3ea9fb70c74381eb02dc6e93fb6d44d161da6eeb3"],"ct":["3151a8f227c0e11fd9a7fd1aa24ebfee734503dea095c22c3b2fae09d62eeb25","3f0a36fd50124ea673e1e56a58f0292a168877bfc2d155da605d71b8bb36583b"],"st":["87b810070b7c739690268360ea392429368787010a558a1837643058d2437dce","6959097001d10501ac7d54c0bdb8db61420f658f2922cc26e46d536119a31126"],"zp":["5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5","e7042ac7d09c7bc41c8cfa5749e41858f6980643bc0db1a83cc793d3e24d3f77"],"country":["79adb2a2fce5c6ba215fe5f27f532d4e7edbac4b6a5e09e1ef3a08084a904621","6959097001d10501ac7d54c0bdb8db61420f658f2922cc26e46d536119a31126"],"external_id":["external_id-10",123]},"custom_data":{"value":123.45,"currency":"usd","contents":[{"id":"product1234","quantity":1,"delivery_category":"home_delivery"}]},"action_source":"website"}]';

        // $str = '/product-category/rings?fbclid=IwAR2Nfjs8iGFH7zaXGywAnhaB5ulSp0eN26Gir-N73MjkzuyBXvj0X2dzM0o';

        // var_dump(pathinfo($str));
        // var_dump(parse_url($str, PHP_URL_PATH));
        // die();

        // var_dump(ord(','));
        // var_dump(ord('，'));

        // $a = [6,3,7,8,2];
        // var_dump(asort($a, SORT_NUMERIC));

        // var_dump($a);


        // if(preg_match("/^\d+[|\d\\n]+\d+$/","1|2||1"))    echo('是数字');
        // else   echo('不是数字');


        // var_dump(empty(' '));


        //$str = 'a:1:{i:0;a:10:{s:14:"_product_block";s:1:"0";s:12:"_top_content";s:0:"";s:15:"_bottom_content";s:0:"";s:11:"_bubble_new";s:0:"";s:12:"_bubble_text";s:0:"";s:17:"_custom_tab_title";s:0:"";s:11:"_custom_tab";s:0:"";s:14:"_product_video";s:0:"";s:19:"_product_video_size";s:0:"";s:24:"_product_video_placement";s:0:"";}}';

        $str = 'a:1:{s:7:"pa_size";a:6:{s:4:"name";s:7:"pa_size";s:5:"value";s:0:"";s:8:"position";i:0;s:10:"is_visible";i:1;s:12:"is_variation";i:1;s:11:"is_taxonomy";i:1;}}';
        
        $str = 'a:1:{s:5:"color";a:6:{s:4:"name";s:5:"Color";s:5:"value";s:6:"Silver";s:8:"position";i:0;s:10:"is_visible";i:0;s:12:"is_variation";i:1;s:11:"is_taxonomy";i:0;}}';


        $str = 'a:1:{s:7:"pa_size";a:6:{s:4:"name";s:7:"pa_size";s:5:"value";s:0:"";s:8:"position";i:0;s:10:"is_visible";i:1;s:12:"is_variation";i:1;s:11:"is_taxonomy";i:1;}}';

        var_dump(unserialize($str));

        // $ips = ['203.209.224.0/24'];
        // $ip = '203.209.224.212';
        // var_dump($this->subnet_range_match($ip, $ips));



        die();

        // 失败
        $fail = '{"code":0,"reason":"","message":"","metadata":{"order_id":"1673395711005675","order_number":"BZ-KA008WQ-10000011","type":0,"status":0,"code":"U3110","result":"Refer to card issuer","remark":"请联系发卡行","html":"","sign":"4aec383508ff081211f3af2e601ca53f"}}';
        
        // 成功
        $success = '{"code":0,"reason":"","message":"","metadata":{"order_id":"1673373642209898","order_number":"BZ-KA008WQ-10000004","type":0,"status":1,"code":"U0000","result":"Transaction is approved","remark":"交易成功","html":"","sign":"1c79f06be0d11b87c86fc380b8872bc1"}}';
    
        //die($fail);
        die($success);


    }

    public function debug_backtrace()
    {
        var_dump(debug_backtrace()[0]);
    }



    public function subnet_range_match($ip, $acl) {
        try {
            $ipb = inet_pton($ip);
            $iplen = strlen($ipb);

            //var_dump($iplen);

            if (strlen($ipb) < 4) {
                return false;
            }
            foreach ($acl as $cidr) {
                $ar = explode('/',$cidr);
                $ip1 = $ar[0];
                $ip1b = inet_pton($ip1);
                $ip1len = strlen($ip1b);

                var_dump($ip1len , $iplen);

                if ($ip1len != $iplen) {
                    continue;
                }
                if (count($ar)>1) {
                    $bits=(int)($ar[1]);
                } else {
                    $bits = $iplen * 8;
                }
                for ($c=0; $bits>0; $c++) {
                    $bytemask = ($bits < 8) ? 0xff ^ ((1 << (8-$bits))-1) : 0xff;

                    var_dump(ord($ipb[$c]) , ord($ip1b[$c]), ($bytemask));

                    if (((ord($ipb[$c]) ^ ord($ip1b[$c])) & $bytemask) != 0) {
                        continue 2;
                    }
                    $bits-=8;
                }
                return true;
            }
        } catch (Exception $e) {}
        return false;
    }





    private static function guessEncodingTestBom(string &$encoding, string $first4, string $compare, string $setEncoding): void
    {
        if ($encoding === '') {
            if ($compare === substr($first4, 0, strlen($compare))) {
                $encoding = $setEncoding;
            }
        }
    }

    private static function guessEncodingBom(string $filename): string
    {
        $encoding = '';
        $first4 = file_get_contents($filename, false, null, 0, 4);
        if ($first4 !== false) {
            self::guessEncodingTestBom($encoding, $first4, self::UTF8_BOM, 'UTF-8');
            self::guessEncodingTestBom($encoding, $first4, self::UTF16BE_BOM, 'UTF-16BE');
            self::guessEncodingTestBom($encoding, $first4, self::UTF32BE_BOM, 'UTF-32BE');
            self::guessEncodingTestBom($encoding, $first4, self::UTF32LE_BOM, 'UTF-32LE');
            self::guessEncodingTestBom($encoding, $first4, self::UTF16LE_BOM, 'UTF-16LE');
        }

        return $encoding;
    }


    // public function diffCsvTest($csv_file='E:\script_file\ecshop\product20230315202244.csv', $csv_file2='C:\Users\admin\Desktop\tempEP\product20230220203920.csv')
    //public function diffCsvTest($csv_file='E:\script_file\ecshop\product20230315202244.csv', $csv_file2='C:\Users\admin\Downloads\wc-product-export-16-3-2023-1678938151783.csv')
    public function diffCsvTest($csv_file='E:\script_file\ecshop\product20230315202244.csv', $csv_file2='C:\Users\admin\Downloads\wc-product-export-16-3-2023-1678946750741.csv')
    {

        // $csv_file_object = (new \SplFileObject($csv_file, 'rb'));
        // $csv_file2_object = (new \SplFileObject($csv_file2, 'rb'));

        $csv_file_sku = $this->getSkuFromCsv($csv_file,'v_products_model');
        $csv_file2_sku = $this->getSkuFromCsv($csv_file2, 'SKU');

        var_dump(count($csv_file_sku));
        var_dump(count($csv_file2_sku));

        // var_dump(count(array_unique($csv_file_sku) ));
        // var_dump(count(array_unique($csv_file2_sku)));

        var_dump(array_diff( $csv_file_sku, $csv_file2_sku));

    }


    public function csvFileArrayCombineTest($csv_file = 'C:\Users\admin\Downloads\reviewx_ldy-reviewx-export-202303221679453144.csv')
    {
        $csv_file_object = (new \SplFileObject($csv_file, 'rb'));
        $title = $csv_file_object->fgetcsv();

        
        do{

            $data = $csv_file_object->fgetcsv();

            // var_dump($data);
        
            if(empty($data[0])){
                continue;
            }

            //var_dump($data);
            try{
                $data = array_combine($title, $data);

                if(!empty($data)){
                    echo count($data);
                }

            }catch(\Exception $e){

                var_dump($title, $data);
                die();
            }



        }while(! $csv_file_object->eof());

    }


    private function getSkuFromCsv($file, $sku='SKU')
    {

        $get_field_arr = [];
        $csv_file_object = (new \SplFileObject($file, 'rb'));
        $title = $csv_file_object->fgetcsv();

        do{

            $data = $csv_file_object->fgetcsv();

            // var_dump($data);
        
            if(empty($data[0])){
                continue;
            }

            //var_dump($data);
            $data = array_combine($title, $data);


            if($sku =='SKU'){
                if($data['Published'] == '1'){
                    if($data['Type'] != 'variation'){
                        $get_field_arr[] = $data[$sku];
                    }
                }

            }else{
                if($data['v_status'] == '1'){
                    $get_field_arr[] = $data[$sku];
                }
            }


        }while(! $csv_file_object->eof());

        return $get_field_arr;

    }






    // public function filterTest($domain_operation_record_file='C:\Users\admin\Downloads\2022.12.21 1639商品导出 (2).csv', $temporary_file = 'C:\Users\admin\Downloads\2022.12.21 1639商品导出-tem.csv')
    // public function filterTest($domain_operation_record_file='C:\Users\admin\Downloads\2022.12.22 1351商品导出.csv', $temporary_file = 'C:\Users\admin\Downloads\2022.12.21 1639商品导出-tem.csv')
    public function filterTest($domain_operation_record_file='C:\Users\admin\Downloads\2022.12.22 1350商品导出.csv', $temporary_file = 'C:\Users\admin\Downloads\2022.12.21 1639商品导出-tem.csv')
    {

        var_dump(mb_internal_encoding());


        // var_dump(mb_detect_encoding('Ⅱ'), 'Shift_JIS,GB2312,UTF-8,GBK');
        // die();
        // $domain_operation_record_file_object = (new SplFileObject($domain_operation_record_file, 'a+b'))->setInternalEncoding();
        // var_dump($domain_operation_record_file_object->ffgetcsv());
        // var_dump($domain_operation_record_file_object->ffgetcsv());
        // var_dump($domain_operation_record_file_object->ffgetcsv());
        // die();

        // setlocale(LC_CTYPE, 'C');
        // setlocale(LC_ALL,array('zh_CN.gb18030','zh_CN.gbk','zh_CN.gb2312'));
        // mb_internal_encoding('GB18030');
        // $csv_str = '"【代金引搎】ロレックス-gmtマスターⅡ-88","【代金引換】ロレックス GMTマスターⅡ",""';
        // $csv_str = mb_convert_encoding($csv_str, 'GB18030', 'UTF-8');
        // $data =  str_getcsv($csv_str);
        // var_dump($data);
        // var_dump(mb_convert_encoding($data, 'UTF-8', 'GB18030'));
        // die();



        $domain_operation_record_file_object = (new SplFileObject($domain_operation_record_file, 'a+b'))->setInternalEncoding();
        $temporary_file_object = (new SplFileObject($temporary_file, 'a+b'));
        $temporary_file_object->ftruncate(0);


        $title = $domain_operation_record_file_object->ffgetcsv();
        $temporary_file_object->fputcsv($title);

        do{
            // $temporary_data = [''];
            // if(!$temporary_file_object->eof()){
            //     $temporary_data = $temporary_file_object->fgetcsv();
            // }
            
            $data = $domain_operation_record_file_object->ffgetcsv();

            // var_dump($data);
        
            if(empty($data[0])){
                continue;
            }

            var_dump($data);
            // $data = array_combine($title, $data);

            

            // if(!empty($data['title'])){
            //     $data['price'] -= 3000;
            // }
           


            // $temporary_file_object->fputcsv($data);

        }while(! $domain_operation_record_file_object->eof());

        $temporary_file_object = null;
        $domain_operation_record_file_object = null;

        // unlink($domain_operation_record_file);
        // rename($temporary_file, $domain_operation_record_file); 

    }



    // 首饰混杂产品类型
    public function filterWPCsvKAYTest($domain_operation_record_file='C:\Users\admin\Downloads\wc-product-export-8-3-2023-1678248210154.csv', $temporary_file = 'C:\Users\admin\Desktop\kay_category.csv')
    {

        $domain_operation_record_file_object = (new \SplFileObject($domain_operation_record_file, 'rb'));
        $temporary_file_object = (new \SplFileObject($temporary_file, 'a+b'));
        $temporary_file_object->ftruncate(0);


        $title = $domain_operation_record_file_object->fgetcsv();
        $temporary_file_object->fputcsv($title);

        $cache_parent_sku = [];

        $variation_id = 1;
        do{

            $data = $domain_operation_record_file_object->fgetcsv();

            // var_dump($data);
        
            if(empty($data[0])){
                continue;
            }

            //var_dump($data);
            $data = array_combine($title, $data);

            if($data['Type'] == 'variable'){
                $cache_parent_sku[$data['SKU']] = $data['SKU'];

            
                $categories = $data['Categories'];
                if(empty($categories)){
                    throw new \Exception("产品属性未定义");
                }
                $categories = explode(',',$categories)[0];
                $categories = trim(explode('>',$categories)[0]);
                $categories = strtoupper($categories);
                $categories = str_replace(' ', '', $categories);

                $new_sku = $sku_prefix. $categories . str_pad(strval($variation_id), 5, "0", STR_PAD_LEFT);
                
                $cache_parent_sku[$data['SKU']] = $new_sku;
                $data['SKU'] = $new_sku;

                ++$variation_id;
            }

            if($data['Type'] == 'variation'){

                if(empty($cache_parent_sku[$data['Parent']])){
                    throw new \Exception('产品父级sku未找到');
                }
                $data['SKU'] = $cache_parent_sku[$data['Parent']] . '_'.$data['Attribute 1 value(s)'];

                $data['Parent'] = $cache_parent_sku[$data['Parent']];
            }

            $data['Tax class'] = '';
            $data['Stock'] = '999999';
            $data['Attribute 1 global'] = '1';

    
            $temporary_file_object->fputcsv($data);

        }while(! $domain_operation_record_file_object->eof());

        $temporary_file_object = null;
        $domain_operation_record_file_object = null;


        echo $temporary_file . "数据更新完成";

    }










    //public function fgetcsvTest($excel_path = 'C:\Users\admin\Downloads\2022.12.22 1351商品导出.csv')
    public function fgetcsvTest($excel_path = 'C:\Users\admin\Desktop\product20220802193106.csv')
    {
        $title = [];
        //单个csv读取
        $excel_file = fopen($excel_path, "r");
        //计数
        $excel_i = 1;

        $data_length = 0;
        while (!feof($excel_file)) {
            $excel_row_array = $this->_fgetcsv($excel_file);

            //跳过第一行
            if ($excel_i == 1) {
                $excel_i++;
                $title = $excel_row_array;
                var_export($title);
                die();
                continue;
            }
            $excel_i++;

            //读取报错跳出
            if (false === $excel_row_array) {
                continue;
            }
            //var_dump($excel_row_array);
            if($data_length == 0){
                $data_length = count($excel_row_array);
            }
            if($data_length != count($excel_row_array)){
                var_dump($excel_row_array);
                die();
            }
            
            var_dump(count($excel_row_array));
        }
        fclose($excel_file);
    }
    

    //读取csv一行
    public function _fgetcsv(& $handle, $length = null, $d = ',', $e = '"') {
        $d = preg_quote($d);
        $e = preg_quote($e);
        $_line = "";
        $eof=false;
        while ($eof != true) {
            $_line .= (empty ($length) ? fgets($handle) : fgets($handle, $length));
            $itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
            if ($itemcnt % 2 == 0)
                $eof = true;
        }
        $_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));
        $_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
        preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
        $_csv_data = $_csv_matches[1];
        for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++) {
            $_csv_data[$_csv_i] = preg_replace('/^' . $e . '(.*)' . $e . '$/s', '$1' , $_csv_data[$_csv_i]);
            $_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
        }
        return empty ($_line) ? false : $_csv_data;
    }


    public function csvmaxlengthTest()
    {
        $examplefile = "C:\Users\admin\Desktop\img\\testcsvmaxlength.csv";
        $fileObject = new \SplFileObject($examplefile, 'a+b');

        $fileObject->fputcsv(['title']);
        $fileObject->ftruncate(0);

        function getName($n) { 

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ,'; 
        
            $randomString = ''; 
        
            for ($i = 0; $i < $n; $i++) { 
        
                $index = rand(0, strlen($characters) - 1); 
        
                $randomString .= $characters[$index]; 
        
            } 
            return $randomString; 
        }



        $fileObject->fputcsv([getName(10000000)]);

    }





    public function ecshopToWpTest($baseDir = 'C:\Users\admin\Desktop\tempEP')
    {
        // 获取 wp 文件的标题和数据 示例 
        // $examplefile = "C:\Users\admin\Desktop\\product20220810181449 - test - 副本.csv";
        // $fileObject = new \SplFileObject($examplefile, 'a+b');
        // $exampletitle = $fileObject->fgetcsv();
        // $exampledata = $fileObject->fgetcsv();
        // $fileObject = null;
        // var_export($exampledata);
        // var_export($exampletitle);
        // die();
        

        $exampletitle = array (
            0 => 'Type',
            1 => 'SKU',
            2 => 'Name',
            3 => 'Published',
            4 => 'Is featured?',
            5 => 'Visibility in catalog',
            6 => 'Short description',
            7 => 'Description',
            8 => 'Date sale price starts',
            9 => 'Date sale price ends',
            10 => 'Tax status',
            11 => 'Tax class',
            12 => 'In stock?',
            13 => 'Stock?',
            14 => 'Low stock amount',
            15 => 'Backorders allowed?',
            16 => 'Sold individually?',
            17 => 'Allow customer reviews?',
            18 => 'Purchase note',
            19 => 'Sale price',
            20 => 'Regular price',
            21 => 'Categories',
            22 => 'Tags',
            23 => 'Shipping class',
            24 => 'Images',
            25 => 'Parent',
            26 => 'Grouped products',
            27 => 'Upsells',
            28 => 'Cross-sells',
            29 => 'External URL',
            30 => 'Button text',
            31 => 'Position',
            32 => 'Attribute 1 name',
            33 => 'Attribute 1 value(s)',
            34 => 'Attribute 1 visible',
            35 => 'Attribute 1 global',
            36 => 'Attribute 1 default',
            37 => 'Attribute 2 name',
            38 => 'Attribute 2 value(s)',
            39 => 'Attribute 2 visible',
            40 => 'Attribute 2 global',
            41 => 'Attribute 2 default',
        );
        $exampledata = array (
            0 => 'variable',
            1 => 'Custom_MLB_Jerseys_097',
            2 => 'Nationals Authentic Blue Cool Base MLB Jersey (S-3XL)',
            3 => '1',
            4 => '0',
            5 => 'visible',
            6 => '',
            7 => ' Body (Colors): 100% Pro-Brite nylon
          Body (White): 100% Pro-Brite polyester
          Side Panels/Collar/Cuffs: 100% lycratalic spandex dazzle
          Engineered Stripe Collar and Cuffs (specific to team): 100% polyester
          Embroidered number on the chest, back and sleeves
          Individual twill or dazzle letters for the player name
          NFL Equipment patch sewn on the bottom of the front collar or fabric insert
          NFL Equipment jock tag with numeric sizing is applied to the lower left bottom of the jersey
          Reebok logo embroidered on each sleeve
          Decorated in the team colors',
            8 => '',
            9 => '',
            10 => 'taxable',
            11 => '',
            12 => '1',
            13 => '999999',
            14 => '',
            15 => '0',
            16 => '0',
            17 => '1',
            18 => '',
            19 => '56.99',
            20 => '289.99',
            21 => 'Custom Jerseys > Customized MLB Jersey',
            22 => '',
            23 => '',
            24 => 'https://192.168.4.17/easyshop/wp-content/uploads/images/custom_jersey/customized_mlb/mlb-customized-097.jpg',
            25 => '',
            26 => '',
            27 => '',
            28 => '',
            29 => '',
            30 => '',
            31 => '0',
            32 => 'Size',
            33 => 'Medium/48,Large/50,ExtraLarge/52,XXLarge/54,XXXLarge/56',
            34 => '1',
            35 => '0',
            36 => '',
            37 => '',
            38 => '',
            39 => '',
            40 => '',
            41 => '',
        );

        $recursiveDirectoryIterator = new \RecursiveDirectoryIterator($baseDir,\FilesystemIterator::KEY_AS_FILENAME | \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS);
        foreach ($recursiveDirectoryIterator as $filename=>$item){
            if($item->isFile()){
                //var_dump($item->getRealPath());
                // ecshop 数据
                $ecshopfile = $item->getRealPath();

                // $ecshopfile = 'E:\work\shop\excel\MLB Jerseys.csv';
                //$ecshopfile = 'E:\work\shop\excel\NBA Jerseys.csv';


                // $field = [
                //     'v_products_model' => 'SKU',  // 
                //     'v_products_name_1' => 'Name',
                //     //'v_status' => 'Published',  // 
                //     'v_products_description_1' => 'Description',   //  0 或 9 下架  => private    其他 publish 
                //     'v_specials_price' => 'Sale price',
                //     'v_products_price' => 'Regular price',
                //     // 'v_categories_name_[14,20]' => 'Categories',
                //     // 'v_products_options_name_id' => 'Categories', // size:#100
                // ];
                $esfileObject = new \SplFileObject($ecshopfile, 'a+b');
                // var_dump($esfileObject->getPath());
                // var_dump($esfileObject->getFilename());

                //wp 数据文件
                $wpfile = $esfileObject->getPath() . '/wp/wp_' . $esfileObject->getFilename();
                $wpfileObject = new \SplFileObject($wpfile, 'a+b');
                $wpfileObject->ftruncate(0);
                $wpfileObject->fputcsv($exampletitle);


                $title = $esfileObject->fgetcsv();
                //var_dump($title);
                $num = 0;
                while(! $esfileObject->eof()){
                    ++$num;

                    $data = $esfileObject->fgetcsv();
                    if(empty($data[0])){
                        //var_dump($data);
                        break;
                    }
                    
                    $modifydata = [
                        'SKU' => $data[0],
                        'Name' => $data[2],
                        'Published' => $data[22] == '1'?'1':'0',
                        'Description' => $data[3],
                        'Sale price' => $data[5],
                        'Regular price' => $data[8],
                        'Categories' => '' , //14-20
                        'Images' => $data[1],
                        'Attribute 1 name' => explode('#', $data[23])[0],
                        'Attribute 1 value(s)' => $data[24],
                    ];

                    for($i=14; $i<=20; $i++){
                        if(!empty($data[$i])){
                            $modifydata['Categories']  .= $data[$i] . ' > ';
                        }
                    }
                    $modifydata['Categories'] = rtrim($modifydata['Categories'], ' > ');

                    $attributeval = explode('|', $modifydata['Attribute 1 value(s)']);
                    foreach($attributeval as $key=>$item){
                        $attributeval[$key] = explode(':',$item)[0];
                    }
                    $modifydata['Attribute 1 value(s)'] = implode(',', $attributeval);

                    $imgprefix = "https://192.168.4.17/easyshop/wp-content/uploads/images/";
                    $imgprefix = "https://kkeu2.okvips.com/wp-content/uploads/image/";
                    // $imgprefix = "images/";

                    $wpdata = $exampledata;
                    $wpdata[1] = $modifydata['SKU'];
                    $wpdata[2] = $modifydata['Name'];
                    $wpdata[3] = $modifydata['Published'];
                    $wpdata[7] = $modifydata['Description'];
                    $wpdata[19] = $modifydata['Sale price'];
                    $wpdata[20] = $modifydata['Regular price'];
                    $wpdata[21] = $modifydata['Categories'];
                    $wpdata[24] = $imgprefix . $modifydata['Images'];
                    $wpdata[32] = $modifydata['Attribute 1 name'];
                    $wpdata[33] = $modifydata['Attribute 1 value(s)'];

                    if (!empty($wpdata[33])) {
                        $wpfileObject->fputcsv($wpdata);
                        $this->getExampleDataChild($wpfileObject, $wpdata);
                    } else {
                        $wpdata[0] ='simple' ;
                        $wpfileObject->fputcsv($wpdata);
                    }

                    // var_dump($modifydata);
                    // die();
                }
                $esfileObject = null;
                $wpfileObject = null;
                echo "$ecshopfile 转化结束， 有 $num 个产品<br />";
            }
        }

    }


    public function getExampleDataChild(&$wpfileObject, $wpdata)
    {
        $attributeValue1 = explode(',', $wpdata[33]);
        $i = 0;
        foreach($attributeValue1 as $key1 => $attr1){
                
            // if($key1 == 0 && count($attributeValue2)<=1){
            //     continue;
            // }

            $insertData = $wpdata;

            // $insertData['Type'] = "variation";
            // $insertData['Attribute 1 value(s)'] = '"' . $attr1 .'"';
            // $insertData['SKU'] = $data['SKU'] . str_replace('.','-',$attr1); 
            // $insertData['Parent'] = $data['SKU'];
            // $insertData['Categories'] = '';
            // $insertData['Description'] = '';
            // $insertData['Attribute 1 visible'] = "";   

            // if(!empty($attributeValue2)){
            //     foreach($attributeValue2 as $attr2){
            //         $insertData['Attribute 1 value(s)'] = '"' . $attr2.'"';
            //         $insertData['SKU'] .= str_replace('.','-',$attr2);
            //     }                
            // }

            $insertData['0'] = "variation";
            $insertData['33'] =  $attr1 ;
            //$insertData['1'] = $wpdata['1'] . str_replace('.','-',$attr1); 
            $insertData['1'] = $wpdata['1'] . "-$i"; 
            $insertData['25'] = $wpdata['1'];
            $insertData['21'] = '';
            $insertData['7'] = '';
            $insertData['34'] = "";   

            $wpfileObject->fputcsv($insertData);
            ++$i;
        }

    }




    public function wpToEcshopTest($wp_file = 'C:\Users\admin\Downloads\wc-product-export-23-3-2023-1679555594860.csv', $ecshop_file = 'E:\other\ecshop\ecshop_test\web\tempEP\ecshop_aj.csv')
    // public function wpToEcshopTest($wp_file = 'C:\Users\admin\Downloads\wc-product-export-23-3-2023-1679576273844.csv', $ecshop_file = 'C:\Users\admin\Desktop\ecshop_aj_zp.csv')
    {

        // $str = 'image/AJ_sportstrend/2023/02/1865f90c0c97283b11edb7f76c3be5b93ae0-1.jpg';
        // var_dump(pathinfo($str));
        //die();

        $ecshop_title = array (
            0 => 'v_products_model',
            1 => 'v_products_image',
            2 => 'v_products_name_1',
            3 => 'v_products_description_1',
            4 => 'v_products_url_1',
            5 => 'v_specials_price',
            6 => 'v_specials_date_avail',
            7 => 'v_specials_expires_date',
            8 => 'v_products_price',
            9 => 'v_products_weight',
            10 => 'v_date_avail',
            11 => 'v_date_added',
            12 => 'v_products_quantity',
            13 => 'v_manufacturers_name',
            14 => 'v_categories_name_1',
            15 => 'v_categories_name_2',
            16 => 'v_categories_name_3',
            17 => 'v_categories_name_4',
            18 => 'v_categories_name_5',
            19 => 'v_categories_name_6',
            20 => 'v_categories_name_7',
            21 => 'v_tax_class_title',
            22 => 'v_status',
            23 => 'v_products_options_name_id',
            24 => 'v_products_options_values',
            25 => 'v_gender_filter',
            26 => 'v_color_filter',
            27 => 'v_number_filter',
            28 => 'v_series_filter',
            29 => 'v_style_filter',
            30 => 'v_team_filter',
            31 => 'v_player_filter',
            32 => 'v_products_options_name_id_2',
            33 => 'v_products_options_values_2',
            34 => 'v_products_options_name_id_3',
            35 => 'v_products_options_values_3',
            36 => 'v_meta_title',
            37 => 'v_meta_description',
          );

        $wp_file_obj = new \SplFileObject($wp_file, 'rb');


        $wp_title = $wp_file_obj->fgetcsv();

        // var_export(array_flip($wp_title));
        // die();
    

        
        $ecshop_file_obj = new \SplFileObject($ecshop_file, 'a+b');
        $ecshop_file_obj->ftruncate(0);
        $ecshop_file_obj->fputcsv($ecshop_title);


        $wp_data_all = [];

        while(! $wp_file_obj->eof()){
            

            $wp_data = $wp_file_obj->fgetcsv();
            if(empty($wp_data[0])){
                //var_dump($data);
                break;
            }


            if(count($wp_title) !=count($wp_data)){
                var_dump($wp_title);
                var_dump($wp_data);
                die();
            }

            $wp_data = array_combine($wp_title, $wp_data);

            if($wp_data['Type'] == 'variable' || $wp_data['Type'] == 'simple' ){
    
                $categories = $wp_data['Categories'];
    
                $categories_arr = explode(',', $categories);

                // 找出类型梯度最长的作为类型
                $cate_max_length = 0;
                foreach($categories_arr as $cate){
                    $cate_arr = explode('>', $cate);
                    if(count($cate_arr) > $cate_max_length){
                        $cate_max_length = count($cate_arr);
                        $categories = $cate_arr;
                    }
                }
    
                foreach($categories  as $key=>$val){
                    $categories[$key] = trim($val);
                }
    
    
                $wp_data['Categories'] = $categories;
            
                $wp_data_all[$wp_data['SKU']] = $wp_data;
    
            }else if($wp_data['Type'] == 'variation'){
    

                // $field = [
                //     'v_products_model' => 'SKU',  // 
                //     'v_products_name_1' => 'Name',
                //     //'v_status' => 'Published',  // 
                //     'v_products_description_1' => 'Description',   //  0 或 9 下架  => private    其他 publish 
                //     'v_specials_price' => 'Sale price',
                //     'v_products_price' => 'Regular price',
                //     // 'v_categories_name_[14,20]' => 'Categories',
                //     // 'v_products_options_name_id' => 'Categories', // size:#100
                // ];

                $wp_data_all[$wp_data['Parent']]['Sale price'] = $wp_data['Sale price'];
                $wp_data_all[$wp_data['Parent']]['Regular price'] = $wp_data['Regular price'];
                continue;
            }else{

                var_dump($wp_data);

                throw new \Exception("未知类型");
            }


            
        }


        foreach($wp_data_all as $wp_data){

            $wp_data = $this->price($wp_data);
    
            $data = array (
                'v_products_model' => $wp_data['SKU'],
                'v_products_image' =>  $this->v_products_image($wp_data['Images']) ,
                'v_products_name_1' => $wp_data['Name'],
                'v_products_description_1' =>  $wp_data['Description'],//str_replace( ['\n', '$200'], ['', '$168'], $wp_data['Description']),  //$this->clear_description($wp_data['Description']),
                'v_products_url_1' => '',
                'v_specials_price' => empty($wp_data['Sale price'])?$wp_data['Regular price']:$wp_data['Sale price'],
                'v_specials_date_avail' => '',
                'v_specials_expires_date' => '',
                'v_products_price' => $wp_data['Regular price'],
                'v_products_weight' => '',
                'v_date_avail' => '',
                'v_date_added' => date('Y-m-d H:i:s'),
                'v_products_quantity' => 999999,
                'v_manufacturers_name' => '',
                'v_categories_name_1' => '',
                'v_categories_name_2' => '',
                'v_categories_name_3' => '',
                'v_categories_name_4' => '',
                'v_categories_name_5' => '',
                'v_categories_name_6' => '',
                'v_categories_name_7' => '',
                'v_tax_class_title' => '--none--',
                'v_status' => $wp_data['Published'] == '1'? 1:0,
                'v_products_options_name_id' => '',
                'v_products_options_values' => '',
                'v_gender_filter' => '',
                'v_color_filter' => '',
                'v_number_filter' => '',
                'v_series_filter' => '',
                'v_style_filter' => '',
                'v_team_filter' => '',
                'v_player_filter' => '',
                'v_products_options_name_id_2' => '',
                'v_products_options_values_2' => '',
                'v_products_options_name_id_3' => '',
                'v_products_options_values_3' => '',
                'v_meta_title' => $wp_data['Name'],
                'v_meta_description' => $wp_data['Name'],
            );

            $this->v_categories_name_idx($data, $wp_data);
            $this->v_products_options_name_idx($data, $wp_data);
            $this->v_products_options_name_idx_2($data, $wp_data);

            $ecshop_file_obj->fputcsv($data);
        }

        echo "执行结束";
    }

    public function v_products_image($images)
    {
        $images = explode(',', $images);


        $img_list = [];

        $img_name_prefix = '';
        $img_first = '';
        foreach($images as $key => $img1){
            $img_old = str_replace(['https://www.shoehaven.top/wp-content/uploads/image/AJ_sportstrend/','https://www.shoehaven.top/wp-content/uploads/'], '', $img1);

            $img_info = pathinfo(trim($img_old));
            if($key == 0 ){
                $img_name_prefix = $img_info['filename'];
                $img = 'AJ_sportstrend/' . $img_name_prefix . '.' . $img_info['extension'];
                $img_first = $img;
            }else{
                $img = 'AJ_sportstrend/' . $img_name_prefix . '_' . $key  . '.' . $img_info['extension'];
            }

            // var_dump($img1, 'E:\other\wordpress\sportstrend.shop_20230306\wp-content\uploads/' . trim($img_old), 'E:\other\wordpress\sportstrend.shop_20230306\wp-content\uploads/' . $img);
            if(!file_exists('E:\other\wordpress\sportstrend.shop_20230306\wp-content\uploads/image/' . $img)){
                copy('E:\other\wordpress\sportstrend.shop_20230306\wp-content\uploads/' . trim($img_old), 'E:\other\wordpress\sportstrend.shop_20230306\wp-content\uploads/image/' . $img );
            }
            
            $img_list[] = $img;
        }

    
        return $img_first;
    }



    
    public function clear_description($description)
    {
        $description = preg_replace('/<div.*?>|<span.*?>|<dl.*?>|<dd.*?>|<dt.*?>|<a.*?>|<i.*?>|<ul.*?>|<li.*?>|<img.*?>/is', '', $description);
        $description = str_replace(['</div>', '</span>', '</dl>', '</dd>', '</dt>', '</a>', '</i>', '</ul>', '</li>', "\n", '\n'], '<br>', $description);
        $description = str_replace( '\n', '', $description);
        $description = preg_replace('/(<br>){2,}/is', '<br>', $description);

        $have = [
            'Minimum',
            'brand',
            'Origin',
            'sampling',
            'logo',
            'Production',
            'delivery',
            'combination',
            'model',
            '2021',
            'buyer',
            'Sample time',
            'Brand Name',
            'MOQ'
        ];
        $re = explode("<br>", $description);

        foreach ($re as $k => $v) {
            foreach ($have as $x => $y) {
                if (stripos($v, $y) !== false) {
                    unset($re[$k]);
                }
            }
        }

        $description = implode('<br>', $re);


        return $description;
    }


    public function price( $wp_data)
    {
        $price = [
            'Air Jordan 1' =>118,
            'Air Jordan 2' =>108,
            'Air Jordan 11' =>128,
            'Air Jordan 12' =>128,
            'Air Jordan 13' =>128,
            'Air Jordan 18' =>128,
            'Air Jordan 3' =>118,
            'Air Jordan 4' =>99,
            'Air Jordan 5' =>128,
            'Air Jordan 6' =>118,
            'Air Jordan 7' =>118,
            'Air Jordan Kids' =>99,
            'Other Jordans' =>118,
        ];


        if( $wp_data['Categories'][0] ){

        }

        $flag = false;
        foreach($price as $cate => $price){

            //var_dump(trim($wp_data['Categories'][0]) , $cate);
            if(trim($wp_data['Categories'][0]) == $cate){
                $flag = true;

                if(is_array($price)){
                    if(!in_array($wp_data['Sale price'], $price)){
                        // var_dump($wp_data['Sale price'], $price);
                        // var_dump($wp_data);
                        // throw new \Exception('价格有误');
                        $wp_data['Sale price'] = 118;
                    }
                }else{
                    if(strval($price)  != floatval($wp_data['Sale price']) ){

                        // var_dump($wp_data['Sale price'], $price);
                        // var_dump($wp_data);
                        // throw new \Exception('价格有误');

                        $wp_data['Sale price'] = $price;
                    }
                }
            }

        
        }

        if(!$flag){
            var_dump($wp_data);
            throw new \Exception('没找到该类型：'. $wp_data['Categories'][0]);
        }
        return $wp_data;

    }


    public function v_categories_name_idx(&$data, $wp_data)
    {
        foreach($wp_data['Categories'] as $key=>$category)
        {
            $data['v_categories_name_'. ($key+1)] = $category;
        }
    }

    public function v_products_options_name_idx(&$data, $wp_data)
    {
        $attr_name = $wp_data['Attribute 1 name'];
        
        if(empty($attr_name)){
            return;
        }

        $attr_value = $wp_data['Attribute 1 value(s)'];
        $attr_value_arr = explode(',', $attr_value);

        $attr_value_str = '';
        foreach($attr_value_arr as $key => $value){
            $attr_value_str .= trim($value) . ":" . ($key+1) . '|';
        }
        $attr_value_str  = rtrim($attr_value_str, '|');

        $data['v_products_options_name_id'] = $attr_name . '#1';
        $data['v_products_options_values'] = $attr_value_str;
    }


    public function v_products_options_name_idx_2(&$data, $wp_data)
    {
        if(!isset($wp_data['Attribute 2 name']) || empty($wp_data['Attribute 2 name'])){
            return;
        }
        $attr_name = $wp_data['Attribute 2 name'];
        


        $attr_value = $wp_data['Attribute 2 value(s)'];
        $attr_value_arr = explode(',', $attr_value);

        $attr_value_str = '';
        foreach($attr_value_arr as $key => $value){
            $attr_value_str .= trim($value) . ":" . ($key+1) . '|';
        }
        $attr_value_str  = rtrim($attr_value_str, '|');

        $data['v_products_options_name_id_2'] = $attr_name . '#1';
        $data['v_products_options_values_2'] = $attr_value_str;
    }


    public function ceshiTest()
    {

        $fileName = "C:\Users\admin\Desktop\\testimport.csv";
        $readdir = 'E:\other\wordpress\sites\var\www\html\site\wp-content\uploads\images/';
        //$readdir = 'E:\other\wordpress\test\wp-content\uploads\wpallimport\files\images/';


        // $readdir2 = 'E:\other\wordpress\test\wp-content\uploads\images2/';
        // $fileName2 = "C:\Users\admin\Desktop\\testimport - 2.csv";
        // $fileName = $fileName2;
        // $readdir = $readdir2;

        $examplefile = "C:\Users\admin\Desktop\\product20220810181449 - test - 副本.csv";
        $fileObject = new \SplFileObject($examplefile, 'a+b');
        $title = $fileObject->fgetcsv();
        $data = $fileObject->fgetcsv();
        $fileObject = null;


        $fileObject = new \SplFileObject($fileName, 'a+b');
        $fileObject->ftruncate(0);
        $fileObject->fputcsv($title);
        //$fileObject->fputcsv($data);

        // var_dump($title);
        // var_dump($data);


        $readdir = str_replace( '\\', '/', $readdir );
    
        $this->readimg( $readdir, $readdir, $fileObject, $data);

        $fileObject = null;
        var_dump('执行完毕');
    }


    public function readimg( $readdir, $baseDir = 'E:\other\wordpress\sites\var\www\html\site\wp-content\uploads\images/', &$fileObject, $data)
    {
        $i = 0;
        $recursiveDirectoryIterator = new \RecursiveDirectoryIterator($baseDir,\FilesystemIterator::KEY_AS_FILENAME | \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS);


        foreach ($recursiveDirectoryIterator as $filename=>$item){
            ++$i;
            
            if($item->isDir()){
                var_dump($baseDir.$filename);
                $baseDirChild = $baseDir.$filename . '/';

                $this->readimg($readdir, $baseDirChild, $fileObject, $data);
            }else if($item->isFile()){

                $data[1] = $filename . $i;

                $url = $baseDir.$filename;
                $url = str_replace( '\\', '/', $url );

                $url = str_replace( $readdir, '', $url );


                $data[24] = 'image/'.$url;
                $fileObject->fputcsv($data);

            }
        }


    }




    public function FZSiteTest()
    {
        $baseDir = 'E:\work\FZ壳站/';
        $recursiveDirectoryIterator = new RecursiveDirectoryIterator($baseDir,\FilesystemIterator::KEY_AS_FILENAME | \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS);

        $errorDir = [];
        $noexists = [];
        foreach ($recursiveDirectoryIterator as $filename=>$item){
            if($item->isDir()){

                $sqlfile = $baseDir.$filename.'\wp.sql\wp.sql';
                if(is_file($sqlfile)){
                    //var_dump($sqlfile);
                    if(!$this->pcreSqlTest($sqlfile)){
                        $noexists[] = $sqlfile;
                        //var_dump('不存在图片：'. $sqlfile);
                    }

                }else{
                    $errorDir[] =  "$sqlfile  不存在";
                }

            }
        }

        var_dump($errorDir);
        var_dump($noexists);
    }

    public function SKSiteTest()
    {
        set_time_limit(60*5);
        $baseDir = 'E:\work\sk壳站/';
        $recursiveDirectoryIterator = new RecursiveDirectoryIterator($baseDir,\FilesystemIterator::KEY_AS_FILENAME | \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS);

        $errorDir = [];
        $noexists = [];
        foreach ($recursiveDirectoryIterator as $filename=>$item){
            if($item->isDir()){

                $sqlfile = $baseDir.$filename.'\site\data.sql\data.sql';
                if(is_file($sqlfile)){
                    //var_dump($sqlfile);
                    if(!$this->pcreSqlTest($sqlfile)){
                        $noexists[] = $sqlfile;
                        //var_dump('不存在图片：'. $sqlfile);
                    }

                }else{
                    $errorDir[] =  "$sqlfile  不存在";
                }

            }
        }

        var_dump($errorDir);
        var_dump($noexists);

    }





    public function pcreSqlTest($sqlFile = null)
    {
        //var_dump($sqlFile);
        //$sqlFile = $this->fileSaveDir . '/sql/wpexists.sql';
        $sqlFile = 'E:\work\sk壳站\lisalandsmarket.com\site\data.sql\data.sql';

        $fileObj = new FileObject($sqlFile);

        //var_dump($fileObj->read());

        $matches = [];
        $res = preg_match_all("/[\s\S]?INSERT INTO `wp_posts` VALUES [^\n]*/", $fileObj->read(), $matches);
        //var_dump($matches);

        $num = 0;
        $checkNum = 30;

        foreach ($matches[0] as $sql){
            $str = substr($sql,32,-2);
            //var_dump($str);
            $wp_posts_col = explode('),(',$str);
            //var_dump($wp_posts_col);

            foreach ($wp_posts_col as $key=>$col){
                //var_dump($col);

                if($pos = strripos($col, 'product_variation', 0)){
                    //var_dump($pos, strlen($col));
                    if($pos > strlen($col)-60){
                        $num++;

                        if($num>$checkNum){
                        //var_dump('成功'. $key);
                            return true;
                            break;
                        }
                    }
                }

            }


        }



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


        if(!empty($_REQUEST['sleep'])){
            sleep(intval($_REQUEST['sleep']));
        }

        echo json_encode(
            [
                'php://input' => Url::getContentType()==="application/json" ? json_decode(file_get_contents("php://input")): file_get_contents("php://input"),
                'get' => $_GET,
                'post' => $_POST,
                '$_SERVER' => $_SERVER
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


