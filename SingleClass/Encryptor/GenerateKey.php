<?php
/**
 * 非对称加密
 * Class Cryptor
 */

namespace HappyLin\OldPlugin\SingleClass\Encryptor;

class GenerateKey
{

    private $config;

    private $passphrase = "#$^&dfg^&^$";

    private static $instance;


    /**
     * 不允许从外部调用以防止创建多个实例
     * 要使用单例，必须通过 Singleton::getInstance() 方法获取实例
     */
    private function __construct()
    {
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
    public static function getInstance(): GenerateKey
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }


    /**
     * 修改config配置
     * @param array $config
     */
    public static function setConfig(array $config=[]):GenerateKey
    {
        $instance = static::getInstance();

        $instance->config = array(
            // 自定义 openssl.conf 文件的路径
            "config" => null,
            // 指定应该使用多少位来生成私钥 512 1024  2048 4096 等
            "private_key_bits" => 1024,
            // 选择在创建CSR时应该使用哪些扩展。可选值有 OPENSSL_KEYTYPE_DSA, OPENSSL_KEYTYPE_DH, OPENSSL_KEYTYPE_RSA 或 OPENSSL_KEYTYPE_EC.
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
            // 摘要算法或签名哈希算法，通常是 openssl_get_md_methods() 之一
            "digest_alg" => 'sha256',

            // 是否应该对导出的密钥（带有密码短语）进行加密?
            "encrypt_key" => true,
            // cipher constants常量之一。
            "encrypt_key_cipher" => null,

            // 创建CSR时，选择使用哪个扩展
            "req_extensions" => null,
            // 选择在创建x509证书时应该使用哪些扩展
            "x509_extensions" => null,
            // 要求PHP7.1+, openssl_get_curve_names()之一。
            "curve_name" => null
        );

        // 判断是win系统
        if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
            // 我电脑的openssl.cnf文件路劲
            $config['config'] = 'D:\Program_Files\php\php742\extras\ssl\openssl.cnf';
        }
        $intersectKey = array_intersect_key($config ,$instance->config);
        if(count($intersectKey)){
            $instance->config = array_merge($instance->config, $intersectKey);
        }
        return $instance;
    }


    /**
     * 创建新的公钥和私钥
     * @return array  ['priKey','pubKey']
     */
    public static function creatingKey($passphrase = "#$^&dfg^&^$"):array
    {
        $instance = static::getInstance();

        $instance->setConfig();

        $instance->passphrase = $passphrase;

        // 生成公钥私钥资源
        $privkey = openssl_pkey_new($instance->config);

        if($privkey === false){
            throw UnexpectedValueException('Failed to generate a new private key;Check whether the openssl.cnf file is correct');
        }

        // 将 $privkey 当作 PEM 编码字符串导出并且将之保存到$priKey (通过引用传递的)中。
        openssl_pkey_export($privkey, $priKey,$instance->passphrase,$instance->config);
        
        // 返回包含密钥详情的数组
        $pubKey = openssl_pkey_get_details($privkey);
        
        $pubKey = $pubKey["key"];

        return array(
            'priKey' => $priKey,
            'pubKey' => $pubKey
        );
    }


    /**
     * 生成CSR证书
     *
     * X509 是证书规范
     * PKCS#7 是消息语法 （常用于数字签名与加密）
     * PKCS#12 个人消息交换与打包语法 （如.PFX .P12）打包成带公钥与私钥
     * 通过CA产生的出来的证书格式文件一般是以PFX P12格式发布给使用者（公钥与私钥），用户拿到证书后，可以通过IE来导入或直接双击向导安装证书，此时私钥安装到系统的私有密钥库中。
     *
     * P12是把证书压成一个文件，.pfx 。主要是考虑分发证书，私钥是要绝对保密的，不能随便以文本方式散播。所以P7格式不适合分发。.pfx中可以加密码保护，所以相对安全些。
     * P7一般是把证书分成两个文件，一个公钥一个私钥，有PEM和DER两种编码方式。PEM比较多见，就是纯文本的，P7一般是分发公钥用，看到的就是一串可见字符串，扩展名经常是.crt,.cer,.key等。DER是二进制编码。
     *
     *
     * @param string $priKey 私钥字符串
     * @param string $pubKey 公钥字符串
     * @return array 【cer，pfx】 公钥证书&私钥
     */
    public static function createCSR(string $priKey, string $pubKey)
    {
        $instance = static::getInstance();

        $privkeypass = $instance->passphrase; //私钥密码

        $dn = array(
            "countryName" => "ZH",                                  //所在国家
            "stateOrProvinceName" => "FUJIAN",                    //所在省份
            "localityName" => "FUZHOU",                        //所在城市
            "organizationName" => "lin da ying",         //注册人姓名
            "organizationalUnitName" => "PHP Documentation",   //组织名称
            "commonName" => "ldy test",                          //公共名称
            "emailAddress" => "3241573082@QQ.COM"                     //邮箱
        );

        $config = $instance->config;
        
        // 基于$dn生成新的 CSR （证书签名请求）
        $csr = openssl_csr_new($dn, $priKey,$config);

        // 从给定的 CSR 生成一个x509证书资源 ; 根据配置自己对证书进行签名
        $sscert = openssl_csr_sign($csr, null, $priKey, 365,$config);

        // 将 x509 以PEM编码的格式导出到名为 output 的字符串类型的变量中;
        openssl_x509_export($sscert, $csrkey);
        // 以 PKCS#12 文件格式 将 x509 导入到以out命名类型为字符串的变量中。将私钥存储到名为的出 PKCS12 文件格式的字符串。 导出密钥$privatekey
        openssl_pkcs12_export($sscert, $privatekey, $priKey, $privkeypass);
        
        return [
            'cer' =>$csrkey,
            'pfx' =>$privatekey
        ];
    }


    /**
     * @param $priv_pfx
     * @return int
     */
    public static function testCSR($priv_pfx)
    {
        $instance = static::getInstance();
        // 私钥密码
        $privkeypass = $instance->passphrase; //

        // 加密数据测试test
        $data = "测试数据！";

        // 读取公钥、私钥;获取私钥
        openssl_pkcs12_read($priv_pfx, $certs, $privkeypass); //读取公钥、私钥

        if(!$certs){
            throw new \UnexpectedValueException('Failed to export key from pkcs12 file');
        }
        
        // 私钥
        $prikeyid = $certs['pkey'];
        // 注册生成加密信息
        openssl_sign($data, $signMsg, $prikeyid,OPENSSL_ALGO_SHA1);
        // base64转码加密信息
        $signMsg = base64_encode($signMsg);




        // base64解码加密信息
        $unsignMsg=base64_decode($signMsg);
        // 读取公钥、私钥;获取公钥
        openssl_pkcs12_read($priv_pfx, $certs, $privkeypass);
        // 公钥
        $pubkeyid = $certs['cert']; 
        return $res = openssl_verify($data, $unsignMsg, $pubkeyid); //验证
    }



    
    

}






