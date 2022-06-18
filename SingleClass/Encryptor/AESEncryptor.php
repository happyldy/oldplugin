<?php
/**
 * 高级加密标准(AES,Advanced Encryption Standard) 对称加密
 * Class Cryptor
 */

namespace HappyLin\OldPlugin\SingleClass\Encryptor;

class AESEncryptor
{

    private $cipher_algo;
    private $hash_algo;
    private $iv_num_bytes;
    private $format;

    const FORMAT_RAW = 0;
    const FORMAT_B64 = 1;
    const FORMAT_HEX = 2;

    private static $instance;


    /**
     * Cryptor constructor.默认使用aes256加密、sha256密钥散列和base64编码构造密码器
     * @param string $cipher_algo 密码算法
     * @param string $hash_algo 密钥散列算法
     * @param int $format 加密数据的格式
     * @throws Exception
     */
    public function __construct(string $cipher_algo = 'aes-256-cbc', string $hash_algo = 'sha256', int $format = AESEncryptor::FORMAT_B64)
    {
        $this->cipher_algo = $cipher_algo;
        $this->hash_algo = $hash_algo;
        $this->format = $format;

        // $cipher_algos是可用的加密算法
        if (!in_array($cipher_algo, openssl_get_cipher_methods(true))) {
            throw new \Exception("AESEncryptor:: - unknown cipher algo {$cipher_algo}");
        }

        // $hash_algo是可用的摘要算法
        if (!in_array($hash_algo, openssl_get_md_methods(true))) {
            throw new \Exception("AESEncryptor:: - unknown hash algo {$hash_algo}");
        }

        // 获取密码iv长度
        $this->iv_num_bytes = openssl_cipher_iv_length($cipher_algo);

    }





    /**
     * 加密字符串
     * @param string $in 要加密的字符串
     * @param string $key 加密密钥
     * @param null $format 为输出编码重写。原始格式、B64格式或十六进制格式之一。
     * @return mixed|string  加密的字符串
     * @throws Exception
     */
    public function encryptString(string $in, $key, $format = null):string
    {
        if ($format === null) {
            $format = $this->format;
        }

        //  生成一个伪随机字节串，字节数由 length 参数指定;使用了强加密算法。返回值为FALSE的情况很少见，但已损坏或老化的有些系统上会出现。
        $iv = openssl_random_pseudo_bytes($this->iv_num_bytes, $isStrongCrypto);
        if (!$isStrongCrypto) {
            throw new \UnexpectedValueException("AESEncryptor::encryptString() - Not a strong key");
        }

        // 使用sha256方法计算摘要
        $keyhash = openssl_digest($key, $this->hash_algo, true);

        // 就两选项
        $opts = OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING;
        $encrypted = openssl_encrypt($in, $this->cipher_algo, $keyhash, $opts, $iv);

        if ($encrypted === false) {
            throw new \UnexpectedValueException('AESEncryptor::encryptString() - Encryption failed: ' . openssl_error_string());
        }

        // 结果包括IV和加密数据
        $res = $iv . $encrypted;

        // 格式化需要的加密数据
        if ($format == AESEncryptor::FORMAT_B64) {
            $res = base64_encode($res);
        } else if ($format == AESEncryptor::FORMAT_HEX) {
            $res = unpack('H*', $res)[1];
        }

        return $res;
    }

    /**
     * 解密字符串
     * @param string $in 要解密的字符串
     * @param string $key 解密密钥
     * @param int $format 输入编码的重写。原始格式、B64格式或十六进制格式之一
     * @return string      解密的字符串
     * @throws \Exception
     */
    public function decryptString($in, $key, $format = null):string
    {
        if ($format === null) {
            $format = $this->format;
        }

        $raw = $in;

        // 还原加密数据
        if ($format == AESEncryptor::FORMAT_B64) {
            $raw = base64_decode($in);
        } else if ($format == AESEncryptor::FORMAT_HEX) {
            $raw = pack('H*', $in);
        }

        // 并对字符串大小进行完整性检查
        if (strlen($raw) < $this->iv_num_bytes) {
            throw new \UnexpectedValueException('AESEncryptor::decryptString() - ' .
                'data length ' . strlen($raw) . " is less than iv length {$this->iv_num_bytes}");
        }

        //提取IV和加密数据
        $iv = substr($raw, 0, $this->iv_num_bytes);
        $raw = substr($raw, $this->iv_num_bytes);

        // Hash the key
        $keyhash = openssl_digest($key, $this->hash_algo, true);

        // and decrypt.
        $opts = OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING;
        $res = openssl_decrypt($raw, $this->cipher_algo, $keyhash, $opts, $iv);

        if ($res === false) {
            throw new \UnexpectedValueException('AESEncryptor::decryptString - decryption failed: ' . openssl_error_string());
        }

        return $res;
    }

    /**
     * 静态方便的加密方法
     * @param string $in 需要加密的字符串
     * @param string $key 加密密钥
     * @param int $format 为输出编码重写。原始格式、B64格式或十六进制格式之一
     * @return string      加密字符串
     */
    public static function encrypt($in, $key, $format = null):string
    {
        if (!self::$instance) {
            self::$instance = new AESEncryptor();
        }
        return self::$instance->encryptString($in, $key, $format);
    }

    /**
     * 静态方便的解密方法。
     * @param string $in 需要解密的字符串
     * @param string $key 解密密钥
     * @param int $format 输入编码的重写。原始格式、B64格式或十六进制格式之一
     * @return string      解密字符串
     */
    public static function decrypt($in, $key, $format = null):string
    {
        if (!self::$instance) {
            self::$instance = new AESEncryptor();
        }
        return self::$instance->decryptString($in, $key, $format);
    }

}






