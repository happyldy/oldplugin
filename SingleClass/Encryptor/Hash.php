<?php
/**
 * •hash_algos — 返回已注册的哈希算法列表
 * •hash_copy — 拷贝哈希运算上下文
 * •hash_equals — 可防止时序攻击的字符串比较
 * •hash_file — 使用给定文件的内容生成哈希值
 * •hash_final — 结束增量哈希，并且返回摘要结果
 * •hash_hkdf — Generate a HKDF key derivation of a supplied key input
 * •hash_hmac_algos — Return a list of registered hashing algorithms suitable for hash_hmac
 * •hash_hmac_file — 使用 HMAC 方法和给定文件的内容生成带密钥的哈希值
 * •hash_hmac — 使用 HMAC 方法生成带有密钥的哈希值
 * •hash_init — 初始化增量哈希运算上下文
 * •hash_pbkdf2 — 生成所提供密码的 PBKDF2 密钥导出
 * •hash_update_file — 从文件向活跃的哈希运算上下文中填充数据
 * •hash_update_stream — 从打开的流向活跃的哈希运算上下文中填充数据
 * •hash_update — 向活跃的哈希运算上下文中填充数据
 * •hash — 生成哈希值 （消息摘要）
 *
 */

namespace HappyLin\OldPlugin\SingleClass\Encryptor;

use http\Exception\UnexpectedValueException;

use HashContext;

class Hash
{
    
    // 由 hash_init() 函数返回的哈希运算上下文。以供 hash_update()， hash_update_stream()，hash_update_file(), 和 hash_final() 函数使用。
    private $HashContext;





    
    /**
     * @param string $algo 要使用的哈希算法名称，例如："md5"，"sha256"，"haval160,4" 等。如何获取受支持的算法清单，请参见 hash_algos()。
     * @param int $options 进行哈希运算的可选设置，目前仅支持一个选项：HASH_HMAC。当指定此选项的时候，必须 指定 key 参数。
     * @param string|null $key 当 options 参数为 HASH_HMAC 时，使用此参数传入进行 HMAC 哈希运算时的共享密钥。
     */
    public function __construct(string $algo, int $options = 0, string $key = NULL )
    {
        
        if($options === HASH_HMAC){
            if(!in_array($algo, static::hashHmacAlgos())){
                throw new UnexpectedValueException("$algo is not in the list of supported hashHmacAlgos algorithms");
            }
        }else{
            if(!in_array($algo, static::hashAlgos())){
                throw new UnexpectedValueException("$algo is not in the list of supported hashAlgos algorithms");
            }
        }
        // 初始化增量哈希运算上下文
        $this->HashContext = hash_init($algo, $options, $key);
    }
    


//    /**
//     * 通过懒加载获得实例（在第一次使用的时候创建）
//     */
//    public static function getInstance(): GenerateKey
//    {
//        if (null === static::$instance) {
//            static::$instance = new static();
//        }
//        return static::$instance;
//    }





    /**
     * 从外部传入的 由 hash_init() 函数返回的哈希运算上下文
     */
    public function setHashContext(HashContext $context):Hash
    {
        $this->HashContext = $context;
        return $this;
    }


    /**
     * 拷贝哈希运算上下文
     * @return HashContext 返回哈希运算上下文的一个复本。
     */
    public function hashCopy() : HashContext
    {
        return hash_copy($this->HashContext);
    }



    /**
     * 结束增量哈希，并且返回摘要结果
     * @param bool $raw_output 设置为 TRUE，输出格式为原始的二进制数据。设置为 FALSE，输出小写的 16 进制字符串。
     * @return string 如果 raw_output 设置为 TRUE， 则返回原始二进制数据表示的信息摘要，否则返回 16 进制小写字符串格式表示的信息摘要。
     */
    public function hashFinal(bool $raw_output = FALSE ) : string
    {
        return hash_final( $this->HashContext, $raw_output);
    }


    /**
     *  从文件向活跃的哈希运算上下文中填充数据
     * @param string $filename 要进行哈希运算的文件路径，支持 fopen 封装器。
     * @param resource|null $scontext 由 stream_context_create() 函数返回的流上下文。
     * @return bool 成功时返回 TRUE， 或者在失败时返回 FALSE。
     */
    public function hashUpdateFile(string $filename, resource $scontext = NULL ) : Hash
    {
        if(hash_update_file( $this->HashContext, $filename, $scontext)){
            return $this;
        };

        throw new UnexpectedValueException('Failed to populate data from file into active hash context');
    }


    /**
     * 从打开的流向活跃的哈希运算上下文中填充数据
     * @param resource $handle 创建流的函数返回的打开的文件句柄。
     * @param int $length 要从 handle 向活跃的哈希运算上下文中拷贝的最大字符数。
     * @return int 从 handle 向哈希运算上下文中实际填充的字节数量。
     */
    public function hashUpdateStream(resource $handle, int $length = -1) : Hash
    {
        hash_update_stream( $this->HashContext, $handle, $length);

        return $this;
    }


    /**
     * 向活跃的哈希运算上下文中填充数据
     *
     * @param HashContext $context 由 hash_init() 函数返回的哈希运算上下文。
     * @param string $data 要向哈希摘要中追加的数据。
     * @return bool 返回 TRUE。
     */
    public function hashUpdate(string $data) : Hash
    {
        hash_update($this->HashContext, $data);
        return $this;
    }




    /**
     * 修改config配置
     * @param array 返回一个数值索引的数组，包含了受支持的哈希算法名称。
     */
    public static function hashAlgos() : array
    {
        return hash_algos();
    }


    /**
     * 生成哈希值 （消息摘要）
     *
     * @param string $algo 要使用的哈希算法，例如："md5"，"sha256"，"haval160,4" 等。在 hash_algos() 中查看支持的算法。
     * @param string $data 要进行哈希运算的消息。
     * @param bool $raw_output 设置为 TRUE 输出原始二进制数据，设置为 FALSE 输出小写 16 进制字符串。
     * @return string
     */
    public static function hash( string $algo, string $data, bool $raw_output = FALSE ) : string
    {
        return hash($algo, $data, $raw_output);
    }


    

    /**
     * 比较两个字符串，无论它们是否相等，本函数的时间消耗是恒定的。
     * @param string $known_string 已知长度的、要参与比较的 string
     * @param string $user_string 用户提供的字符串
     * @return bool 当两个字符串相等时返回 TRUE，否则返回 FALSE。
     */
    public static function hashEquals( string $known_string, string $user_string) : bool
    {
        return hash_equals($known_string, $user_string);
    }


    /**
     * 使用给定文件的内容生成哈希值
     * @param string $known_string 已知长度的、要参与比较的 string
     * @param string $user_string 用户提供的字符串
     * @return bool 当两个字符串相等时返回 TRUE，否则返回 FALSE。
     */
    /**
     *  使用给定文件的内容生成哈希值
     * @param string $algo 要使用的哈希算法的名称，例如："md5"，"sha256"，"haval160,4" 等。在 hash_algos() 中查看支持的算法。
     * @param string $filename 要进行哈希运算的文件路径。支持 fopen 封装器。
     * @param bool $raw_output 设置为 TRUE，输出格式为原始的二进制数据。设置为 FALSE，输出小写的 16 进制字符串。
     * @return string 如果 raw_output 设置为 TRUE， 则返回原始二进制数据表示的信息摘要，否则返回 16 进制小写字符串格式表示的信息摘要。
     */
    public static function hashFile( string $algo, string $filename, bool $raw_output = FALSE )
    {
        if(!in_array($algo, static::hashAlgos())){
            return false;
        }

        return hash_file($algo, $filename, $raw_output);
    }


    /**
     * 返回一个数字索引数组，其中包含适用于hash_hmac（）的受支持哈希算法列表。
     * @return array
     */
    public static function hashHmacAlgos() : array
    {
        return hash_hmac_algos();
    }

    /**
     * 使用 HMAC 方法和给定文件的内容生成带密钥的哈希值
     *
     * @param string $algo 要使用的哈希算法名称，例如："md5"，"sha256"，"haval160,4" 等。如何获取受支持的算法清单，请参见 hash_hmac_algos() 函数。
     * @param string $filename 要进行哈希运算的文件路径，支持 fopen 封装器。
     * @param string $key 使用 HMAC 生成信息摘要时所使用的密钥。
     * @param bool $raw_output 设置为 TRUE 输出原始二进制数据，设置为 FALSE 输出小写 16 进制字符串。
     * @return string 如果 raw_output 设置为 TRUE， 则返回原始二进制数据表示的信息摘要，否则返回 16 进制小写字符串格式表示的信息摘要。如果 algo 参数指定的不是受支持的算法，或者无法读取 filename 给定的文件，则返回 FALSE。
     */
    public static function hashHmacFile( string $algo, string $filename, string $key, bool $raw_output = FALSE )
    {
        if(!in_array($algo, static::hashHmacAlgos())){
            return false;
        }
        return hash_hmac_file($algo, $filename, $key, $raw_output );
    }

    /**
     * 使用 HMAC 方法生成带有密钥的哈希值
     *
     * @param string $algo 要使用的哈希算法名称，例如："md5"，"sha256"，"haval160,4" 等。如何获取受支持的算法清单，请参见 hash_hmac_algos() 函数。
     * @param string $data 要进行哈希运算的消息。
     * @param string $key 使用 HMAC 生成信息摘要时所使用的密钥。
     * @param bool $raw_output  设置为 TRUE 输出原始二进制数据，设置为 FALSE 输出小写 16 进制字符串。
     * @return string 如果 raw_output 设置为 TRUE， 则返回原始二进制数据表示的信息摘要，否则返回 16 进制小写字符串格式表示的信息摘要。如果 algo 参数指定的不是受支持的算法，返回 FALSE。
     */
    public static function hashHmac( string $algo, string $data, string $key, bool $raw_output = FALSE ) : string
    {
        return hash_hmac($algo, $data, $key, $raw_output);
    }


    /**
     * 生成所提供密码的 PBKDF2 密钥导出 ; 更好的方案是使用 password_hash() 函数
     *
     * @param string $algo 哈希算法名称，例如 md5，sha256，haval160,4 等。受支持的算法清单请参见 hash_algos()。
     * @param string $password 要进行导出的密码。
     * @param string $salt 进行导出时所使用的"盐"，这个值应该是随机生成的。
     * @param int $iterations 进行导出时的迭代次数。
     * @param int $length 密钥导出数据的长度。如果传入 0，则使用所选算法的完整输出大小。如果 raw_output 为 TRUE，此参数为密钥导出数据的字节长度。如果 raw_output 为 FALSE，此参数为密钥导出数据的字节长度的 2 倍，因为 1 个字节数据对应的 2 个 16 进制的字符。
     * @param bool $raw_output 设置为 TRUE 输出原始二进制数据，设置为 FALSE 输出小写 16 进制字符串。
     * @return string
     */
    public static function hashPbkdf2( string $algo, string $password, string $salt, int $iterations, int $length = 0, bool $raw_output = FALSE ) : string
    {
        return hash_pbkdf2($algo, $password, $salt, $iterations, $length, $raw_output);
    }


    

}






