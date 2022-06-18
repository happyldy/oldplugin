<?php

namespace HappyLin\OldPlugin\SingleClass;


class PictureSave  {

    
    private $dirBase;
    private static $instance;


    /**
     * 不允许从外部调用以防止创建多个实例
     * 要使用单例，必须通过 Singleton::getInstance() 方法获取实例
     */
    private function __construct($dirBase)
    {
        
        if(!$dirBase){
            $dirBase = dirname($_SERVER['SCRIPT_FILENAME']) . '/Test/SingleClass/image';
        }
        if (!is_dir($dirBase) && !mkdir($dirBase, 0777, true)) {
            throw new \InvalidArgumentException('The $dirBase cannot be created automatically');
        }
        $this->dirBase = $dirBase;
    }

    /**
     * 防止实例被克隆（这会创建实例的副本）
     */
    private function __clone()
    {
    }

    /**
     * 防止反序列化（这将创建它的副本）
     */
    private function __wakeup()
    {
    }


    /**
     * 通过懒加载获得实例（在第一次使用的时候创建）
     */
    public static function getInstance($dirBase=null): GenerateKey
    {
        if (null === static::$instance) {
            static::$instance = new static($dirBase);
        }
        return static::$instance;
    }



    public function curl_get_file_content($url) {

        $header = array(
            "Connection: Keep-Alive", 
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8", 
            "Pragma: no-cache", 
            "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3", 
            "User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:29.0) Gecko/20100101 Firefox/29.0"
        );
        $ch = curl_init();

        // 需要获取的 URL 地址，也可以在curl_init() 初始化会话的时候
        curl_setopt($ch, CURLOPT_URL, $url.'?'.http_build_query($param));
        // TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 启用时会将头文件的信息作为数据流输出。
        curl_setopt($ch, CURLOPT_HEADER, 0);
        
        // 设置 HTTP 头字段的数组。格式： array('Content-type: text/plain', 'Content-length: 100')
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // TRUE 时将会根据服务器返回 HTTP 头中的 "Location: " 重定向。（注意：这是递归的，"Location: " 发送几次就重定向几次，除非设置了 CURLOPT_MAXREDIRS，限制最大重定向次数。）。
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        // HTTP请求头中"Accept-Encoding: "的值。这使得能够解码响应的内容。支持的编码有"identity"，"deflate"和"gzip"。如果为空字符串""，会发送所有支持的编码类型。
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');

        // FALSE 禁止 cURL 验证对等ca证书（peer'scertificate）。要验证的交换证书可以在 CURLOPT_CAINFO 选项中设置，或在 CURLOPT_CAPATH中设置证书目录
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        // 是检查服务器SSL证书中是否存在一个公用名(common name); 设置成 2，会检查公用名是否存在，并且是否与提供的主机名匹配。 0 为不检查名称。在生产环境中，这个值应该是 2（默认值）。
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//严格校验
        
        
        $content = curl_exec($ch);
        $curlInfo = curl_getinfo($ch);

        //关闭连接
        curl_close($ch);

        if ($curlInfo['http_code'] == 200) {
            return $content;
        }
        return false;
    }




    /**
     * 判断保存的路径
     * @param	string	$type	图片类型（car）
     * @return	string
     */
    protected function imgSaveDir($type) {

        switch ($type) {
            case 'global': //核心图片
                $save_dir = 'images/images_index/app/';
                break;
            
            default: //其他未定义文件夹
                $save_dir = false;
                break;
        }
        return $save_dir;
    }


    /**
     * 允许上传的图片类型
     * @param	string	$type	图片类型（例如'image/png'）
     * @return	string
     */
    protected function allowImgType($type) {
        $mime = array(
            'image/png' => '.png',
            'image/jpg' => '.jpg',
            'image/jpeg' => '.jpg',
            'image/pjpeg' => '.jpg',
            'image/gif' => '.gif',
            'image/bmp' => '.bmp',
            'image/x-png' => '.png',
        );
        $imgtype = $mime[strtolower($type)];
        if(empty($imgtype)) return false;
        return $imgtype;
    }

    /**
     * 上传表单图片信息
     *
     * @param	string	$dirType	查询对象
     * @param	string/array	$image	图片（array(type=>'image/png',tmp_name=>文件路径)）
     * @param	string	$imgName	给图片起名称
     * @return	intval
     */
    protected function saveUploadFormImg(string $dirType,array $image,$imgName='') {
        if(empty($dirType) || empty($image)){
            array('status'=>0,'msg'=>'参数缺失');
        }

        $save_dir = $this->imgSaveDir($dirType);
        if(!$save_dir) return array('status'=>0,'msg'=>'图片储存的位置未定义');
        //给文件命名
        if(empty($imgName)){
            $imgName = date('d').time().getRand(9);
        }

        //传入数组
        if(is_array($image)){
            if(empty($image['type'])) return array('status'=>0,'msg'=>'图片类型缺失');
            if(empty($image['tmp_name'])) return array('status'=>0,'msg'=>'图片地址缺失');
            //判断图片类型
            $imgType = $this->allowImgType($image['type']);
            $local_file_path = $image['tmp_name'];
        }else{
            return array('status'=>0,'msg'=>'传入数据格式错误');
        }
        if(!$imgType) return array('status'=>0,'msg'=>'图片类型不符合要求');
        $save_url = $save_dir.$imgName.$imgType;
        
//        //判断是否是启用QINIU服务器
//        if(SYS_QINIU_START==1){
//            $uploadRes = $this->qiniuupload->uploadFile($save_url,$local_file_path);
//            if($uploadRes['status']==1){
//                return array('status'=>1,'msg'=>$uploadRes['data']['imgurl']);
//            }else{
//                return array('status'=>0,'msg'=>$uploadRes['msg']);
//            }
//        }

        //保存到本地
        //创建目录
        if (!is_dir($save_dir) && !mkdir($save_dir, 0777, true)) {
            return array('status'=>0,'msg'=>'创建图片文件夹失败');
        }
        $saveRess = move_uploaded_file($local_file_path, $save_url);
        if ($saveRess) {
            return array('status'=>1,'msg'=>$save_url);
        }else{
            return array('status'=>0,'msg'=>'图片保存失败');
        }

    }



    /**
     * 上传base64图片
     *
     * @param	string	$dirType	查询对象
     * @param	array	$image	图片（array(type=>'image/png',imgStr=>二进制流)）
     * @param	string	$name	给图片起名称
     * @return	array
     */
    protected function saveUploadBase64Img(string $dirType,array $image,string $name='') :array
    {
        if(empty($dirType) || empty($image)){
            array('status'=>0,'msg'=>'参数缺失');
        }

        $save_dir = $this->imgSaveDir($dirType);
        if(!$save_dir) return array('status'=>0,'msg'=>'图片储存的位置未定义');
        //给文件命名
        if(empty($imgName)){
            $imgName = date('d').time().getRand(9);
        }

        //传入数组
        if(is_array($image)){
            if(empty($image['type'])) return array('status'=>0,'msg'=>'图片类型缺失');
            if(empty($image['imgStr']))  return array('status'=>0,'msg'=>'图片base64缺失');
            //判断图片类型
            $imgType = $this->allowImgType($image['type']);
            $local_file_path = $image['imgStr'];
        }else{
            return array('status'=>0,'msg'=>'传入数据格式错误');
        }
        if(!$imgType) return array('status'=>0,'msg'=>'图片类型不符合要求');
        $save_url = $save_dir.$imgName.$imgType;
        
        
//        //判断是否是启用QINIU服务器
//        if(SYS_QINIU_START==1){
//            $uploadRes = $this->qiniuupload->uploadBase64($save_url,$local_file_path);
//            if($uploadRes['status']==1){
//                return array('status'=>1,'msg'=>$uploadRes['data']['imgurl']);
//            }else{
//                return array('status'=>0,'msg'=>$uploadRes['msg']);
//            }
//        }

        //保存到本地
        //创建目录失败
        if (!is_dir($save_dir) && !mkdir($save_dir, 0777, true)) {
            return array('status'=>0,'msg'=>'创建图片文件夹失败');
        }
        preg_match('/(.*)base64,(.*)/', $local_file_path, $matches);
        $local_file_path = $matches['2'];
        $local_file_path = base64_decode($local_file_path);
        $saveRess = file_put_contents($save_url, $local_file_path);
        if ($saveRess) {
            return array('status'=>1,'msg'=>$save_url);
        }else{
            return array('status'=>0,'msg'=>'图片保存失败');
        }
    }



    /**
     * 上传http://url地址图片
     *
     * @param	string	$dirType	查询对象
     * @param	array	$image	图片（http://url）
     * @param	string	$name	给图片起名称
     * @return	intval
     */
    protected function saveUploadHttpImg(string $dirType,$image,$name='') {
        if(empty($dirType) || empty($image)){
            array('status'=>0,'msg'=>'参数缺失');
        }
        $save_dir = $this->imgSaveDir($dirType);
        if(!$save_dir) return array('status'=>0,'msg'=>'图片储存的位置未定义');
        //给文件命名
        if(empty($imgName)){
            $imgName = date('d').time().getRand(9);
        }
        //传入url地址字符串
        if(is_string($image) && filter_var($image, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)){
            $type = strrchr($image, '.');
            $type = 'image/'.substr($type, 1);
            //判断图片类型
            $imgType = $this->allowImgType($type);
            $local_file_path = $image;
            $local_file_path = $this->curl_get_file_content($local_file_path) ;
            if(!$local_file_path){
                return array('status'=>0,'msg'=>'获取url图片信息失败');
            }
        }else{
            return array('status'=>0,'msg'=>'传入http://url地址错误');
        }
        if(!$imgType) return array('status'=>0,'msg'=>'图片类型不符合要求');
        $save_url = $save_dir.$imgName.$imgType;
        
//        //判断是否是启用QINIU服务器
//        if(SYS_QINIU_START==1){
//            $uploadRes = $this->qiniuupload->uploadBase64($save_url,'base64,'.$local_file_path);
//            if($uploadRes['status']==1){
//                return array('status'=>1,'msg'=>$uploadRes['data']['imgurl']);
//            }else{
//                return array('status'=>0,'msg'=>$uploadRes['msg']);
//            }
//        }

        //保存到本地  base64,
        //创建目录
        if (!is_dir($save_dir) && !mkdir($save_dir, 0777, true)) {
            return array('status'=>0,'msg'=>'创建图片文件夹失败');
        }
        $saveRess = file_put_contents($save_url, $local_file_path);

        if ($saveRess) {
            return array('status'=>1,'msg'=>$save_url);
        }else{
            return array('status'=>0,'msg'=>'图片保存失败');
        }

    }



}




