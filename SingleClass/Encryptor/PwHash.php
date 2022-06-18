<?php
/**
 * 密码散列算法
 * Class PwHash
 */

namespace HappyLin\OldPlugin\SingleClass\Encryptor;

class PwHash
{
    
    /**
     * 以字符串数组的形式返回所有已注册密码哈希算法ID的完整列表。
     * @param array 返回可用的密码哈希算法ID。
     */
    public static function passwordAlgos(): array
    {
        return password_algos();

    }


    /**
     * 如果传入的散列值（hash）是由 password_hash() 支持的算法生成的，这个函数就会返回关于此散列的信息数组。
     *
     * 返回值
     * 返回三个元素的关联数组：
     * ◦ algo， 匹配 密码算法的常量
     * ◦ algoName，人类可读的算法名称
     * ◦ options，调用 password_hash() 时提供的选项。
     *
     * @param string $hash 一个由 password_hash() 创建的散列值。
     * @return array
     */
    public static function passwordGetInfo( string $hash) : array
    {
        return password_get_info( $hash);
    }


    /**
     * password_hash() 使用足够强度的单向散列算法创建密码的散列（hash）。 password_hash() 兼容 crypt()。所以， crypt() 创建的密码散列也可用于 password_hash()。
     *
     * 当前支持的算法：
     * ◦ PASSWORD_DEFAULT - 使用 bcrypt 算法 (PHP 5.5.0 默认)。注意，该常量会随着 PHP 加入更新更高强度的算法而改变。所以，使用此常量生成结果的长度将在未来有变化。因此，数据库里储存结果的列可超过60个字符（最好是255个字符）。
     * ◦ PASSWORD_BCRYPT - 使用 CRYPT_BLOWFISH 算法创建散列。这会产生兼容使用 "$2y$" 的 crypt()。结果将会是 60 个字符的字符串， 或者在失败时返回 FALSE。
     * ◦ PASSWORD_ARGON2I - 使用 Argon2i 散列算法创建散列。只有在 PHP 编译时加入 Argon2 支持时才能使用该算法。
     * ◦ PASSWORD_ARGON2ID - 使用 Argon2id 散列算法创建散列。只有在 PHP 编译时加入 Argon2 支持时才能使用该算法。
     *
     * @param string $password 用户的密码。 如果使用PASSWORD_BCRYPT 做算法，将使 password 参数最长为72个字符，超过会被截断。
     * @param mixed $algo  一个用来在散列密码时指示算法的密码算法常量。7.4.0 现在 algo 参数可支持 string 类型，但为了向后兼容也支持 int 类型。
     * @param array $options 一个包含有选项的关联数组。详细的参数说明，请参考文档 密码算法常数。省略后，将使用随机盐值与默认 cost。
     * @return string|false 返回散列后的密码， 或者在失败时返回 FALSE。
     */
    public static function passwordHash( string $password, $algo = PASSWORD_BCRYPT, array $options = [])
    {
        $hash = password_hash($password, PASSWORD_BCRYPT, $options);
        
        if(static::passwordNeedsRehash($hash,$algo,$options)){
            return false;
        }else{
            return $hash;
        }
    }


    /**
     *  检测散列值是否匹配指定的选项
     *
     * @param string $hash 一个由 password_hash() 创建的散列值。
     * @param mixed $algo 一个用来在散列密码时指示算法的密码算法常量。 7.4.0 现在 algo 参数可以支持 string 类型，但为了向后兼容性，同时支持 int 类型。
     * @param array $options 一个包含有选项的关联数组。详细的参数说明，请参考文档 密码算法常数。 目前支持两个选项：salt，在散列密码时加的盐（干扰字符串），以及cost，用来指明算法递归的层数。这两个值的例子可在 crypt() 页面找到。 省略后，将使用随机盐值与默认 cost。
     * @return bool 如果散列需要重新生成才能匹配指定的 algo 和 options，则返回 TRUE，否则返回 FALSE。
     */
    private static function passwordNeedsRehash(string $hash, $algo, array $options=[] ) : bool
    {
        return password_needs_rehash($hash,$algo, $options);
    }
    


    /**
     * 验证密码是否和指定的散列值匹配。
     *
     * 注意 password_hash() 返回的散列包含了算法、 cost 和盐值。因此，所有需要的信息都包含内。使得验证函数不需要储存额外盐值等信息即可验证哈希。
     * 时序攻击（timing attacks）对此函数不起作用。
     *
     * @param string $password 用户的密码。
     * @param string $hash hash
     * @return bool 如果密码和散列值匹配则返回 TRUE，否则返回 FALSE 。
     */
    public static function passwordVerify( string $password, string $hash) : bool
    {
        return password_verify( $password, $hash);
    }
    

}






