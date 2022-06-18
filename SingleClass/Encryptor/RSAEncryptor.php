<?php
/**
 * 非对称加密
 * Class Cryptor
 */

namespace HappyLin\OldPlugin\SingleClass\Encryptor;


class RSAEncryptor
{
    
    private $publicKey;
    private $privateKey;
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
    public static function getInstance(): RSAEncryptor
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }


    /**
     * 设置公钥
     * @param string $publicKey 传入公钥路劲或公钥字符串
     * @return RSAEncryptor
     */
    public static function setPublicKey(string $publicKey):RSAEncryptor
    {
        $instance = static::getInstance();

        $publicStr = $publicKey;
        if(is_file($publicKey)){
            $publicStr = file_get_contents($publicKey);
        }

        // 从证书中解析公钥，以供使用
        $instance->publicKey = openssl_pkey_get_public($publicStr);
        if (!$instance->publicKey) {
            throw new \UnexpectedValueException("Public key not available;");
        }
        return $instance;
    }

    

    /**
     * 设置私钥
     * @param string $pi_key 传入私钥路劲或私钥字符串
     * @return RSAEncryptor
     */
    public static function setPrivateKey(string $privateKey):RSAEncryptor
    {
        $instance = static::getInstance();

        $privateStr = $privateKey;
        if(is_file($privateKey)){
            $privateStr = file_get_contents($privateKey);
        }

        // 获取私钥
        $instance->privateKey =  openssl_pkey_get_private($privateStr, $instance->passphrase);

        if (!$instance->privateKey) {
            throw new \UnexpectedValueException("Private key not available;");
        }
        return $instance;
    }

    

    /**
     * 私钥加密
     * @param string $string 需要加密字符串
     * @param bool $spliceUrl 数据是否为符合url安全的字符串
     * @param int $padding OPENSSL_PKCS1_PADDING||OPENSSL_NO_PADDING
     * @return string
     */
    public static function privateEncrypt(string $string, bool $spliceUrl = true, $padding = OPENSSL_PKCS1_PADDING ):string
    {
        $instance = static::getInstance();
        $crypto = '';
        // openssl_private_encrypt()加密对加密串有字符限制(117字节)
        foreach (str_split($string, 117) as $chunk) {
            openssl_private_encrypt($chunk, $encryptStr, $instance->privateKey, $padding);
            $crypto .= $encryptStr;
        }
        $encrypted = $instance->urlsafe_b64encode($crypto, $spliceUrl);
        return $encrypted;
    }


  
    
    /**
     * 公钥解密
     * @param string $string 需要解密字符串
     * @param bool $spliceUrl 数据是否为符合url安全的字符串
     * @param int $padding OPENSSL_PKCS1_PADDING||OPENSSL_NO_PADDING
     * @return string
     */
    public static function publicDecrypt(string $string,bool $spliceUrl = true, $padding = OPENSSL_PKCS1_PADDING ):string
    {
        $instance = static::getInstance();
        $crypto = '';
        // openssl_public_decrypt()加密对加密串有字符限制(128字节)
        foreach (str_split($instance->urlsafe_b64decode($string, $spliceUrl), 128) as $chunk) {
            openssl_public_decrypt($chunk, $decryptStr, $instance->publicKey, $padding);
            $crypto .= $decryptStr;
        }
        return $crypto;
    }

    


    /**
     * 公钥加密
     * @param string $string  需要加密字符串
     * @param bool $spliceUrl  数据是否为符合url安全的字符串
     * @param int $padding  OPENSSL_PKCS1_PADDING||OPENSSL_NO_PADDING
     * @return string
     */
    public static function publicEncrypt(string $string,bool $spliceUrl = true, $padding = OPENSSL_PKCS1_PADDING ):string
    {
        $instance = static::getInstance();
        $crypto = '';
        
        // openssl_public_encrypt()加密对加密串有字符限制(117字节)
        foreach (str_split($string, 117) as $chunk) {
            openssl_public_encrypt($chunk, $encryptStr, $instance->publicKey, $padding);
            $crypto .= $encryptStr;
        }
        $encrypted = $instance->urlsafe_b64encode($crypto, $spliceUrl);
        return $encrypted;
    }
    
    
    /**
     * 私钥解密
     * @param string $string 需要解密字符串
     * @param bool $spliceUrl 数据是否为符合url安全的字符串
     * @param int $padding OPENSSL_PKCS1_PADDING||OPENSSL_NO_PADDING
     * @return string
     */
    public static function privateDecrypt(string $string,bool $spliceUrl = true, $padding = OPENSSL_PKCS1_PADDING ):string
    {
        $instance = static::getInstance();
        $crypto = '';
        // openssl_private_decrypt()加密对加密串有字符限制(128字节)
        foreach (str_split($instance->urlsafe_b64decode($string, $spliceUrl), 128) as $chunk) {
            openssl_private_decrypt($chunk, $decryptStr, $instance->privateKey, $padding);
            $crypto .= $decryptStr;
        }
        return $crypto;
    }

    /**
     * base64加密
     *
     * @param $string 数据
     * @param $spliceUrl 是否加密为符合url安全的字符串
     *
     */
    private function urlsafe_b64encode(string $string, $spliceUrl = true) {
        $string = base64_encode($string);
        if ($spliceUrl) {
            $string = str_replace(array('+','/','='),array('-','_',''),$string);
        }
        return $string;
    }

    /**
     * base64解密
     *
     * @param $string 加密的数据
     * @param $spliceUrl 加密的数据是否为符合url安全的字符串
     */
    private function urlsafe_b64decode(string $string, $spliceUrl = true) {
        if (!$spliceUrl) return base64_decode($string);
        $string = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($string) % 4;
        if ($mod4) {
            $string .= substr('====', $mod4);
        }
        return base64_decode($string);
    }
    
}






