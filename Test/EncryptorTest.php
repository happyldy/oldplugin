<?php

namespace HappyLin\OldPlugin\Test;




use HappyLin\OldPlugin\SingleClass\Encryptor\{AESEncryptor,GenerateKey,RSAEncryptor,PwHash,Hash};
use HappyLin\OldPlugin\SingleClass\SPL\FileHandling\Shortcut\FileObject;
use HappyLin\OldPlugin\SingleClass\Url;
use HappyLin\OldPlugin\Test\TraitTest;

class EncryptorTest
{

    use TraitTest;


    public function __construct()
    {
        $this->fileSaveDir = static::getTestDir() . '/Public/SingleClass';
        
    }


    /**
     * @note 对称加密
     */
    public function AESEncryptorTest()
    {

        $data = '我是要加密的字符串';
        $key = '1234567890123456';

        $encrypted = AESEncryptor::encrypt($data, $key);

        echo "<div>'$data' (" . strlen($data) . ") => '$encrypted'<br></div>";

        $decrypted = AESEncryptor::decrypt($encrypted, $key);

        echo "<div>'$encrypted' => '$decrypted' (" . strlen($decrypted) . ")<br></div>";

        assert(strlen($data) === strlen($decrypted), 'The decrypted data will match the binary size of the encrypted data');
        assert($data === $decrypted, 'The encrypted data will match the decrypted data');

    }

    /**
     * @note 创建新的公钥和私钥
     */
    public function generateKeyTest()
    {
        // 创建RAS密钥
        $keyArr = GenerateKey::creatingKey();

        $privatefile = $this->fileSaveDir . '/Cert/privateKey.pem';
        $publidfile = $this->fileSaveDir . '/Cert/publidKey.pem';

        FileObject::getInstance($privatefile,'write')->write($keyArr['priKey']);
        FileObject::getInstance($publidfile,'write')->write($keyArr['pubKey']);
        
        var_dump($keyArr);
    }


    /**
     * @note 创建CSR证书
     */
    public function generateCSRTest()
    {
        // 创建RAS密钥
        $keyArr = GenerateKey::creatingKey(null);

        $privatefile = $this->fileSaveDir . '/Cert/CSRprivateKey.pem';
        $publidfile = $this->fileSaveDir . '/Cert/CSRpublidKey.pem';
        FileObject::getInstance($privatefile,'write')->write($keyArr['priKey']);
        FileObject::getInstance($publidfile,'write')->write($keyArr['pubKey']);

        var_dump(static::toStr('创建RSA密钥',$keyArr ));

        // 根据RSA密钥创建CSR证书
        $csr = GenerateKey::createCSR($keyArr['priKey'],$keyArr['pubKey']);

        $privateCSRFile = $this->fileSaveDir . '/Cert/CSRPfxPkc12.pfx';
        $publidCSRFile = $this->fileSaveDir . '/Cert/CSRCerPem.cer';
        FileObject::getInstance($privateCSRFile,'write')->write($csr['pfx']);
        FileObject::getInstance($publidCSRFile,'write')->write($csr['cer']);

        var_dump(static::toStr('根据RSA密钥创建CSR证书',$csr));


        // 测试证书的有效性
        $res = GenerateKey::testCSR($csr['pfx']);
        var_dump(static::toStr('测试证书的有效性', $res));
    }


    /**
     * @note 非对称加密
     */
    public function RSAEncryptorTest()
    {
        $privatefile = $this->fileSaveDir . '/Cert/privateKey.pem';
        $publidfile = $this->fileSaveDir . '/Cert/publidKey.pem';
        $RSAEncryptor = RSAEncryptor::setPrivateKey($privatefile)::setPublicKey($publidfile);



        $privateStr = $RSAEncryptor::privateEncrypt('我是加密数据');
        var_dump(static::toStr('私钥加密: 我是加密数据',$privateStr));

        $publicStr = $RSAEncryptor::publicDecrypt($privateStr);
        var_dump(static::toStr('公钥解密',$publicStr));



        $publicStr = $RSAEncryptor::publicEncrypt('我是公钥加密');
        var_dump(static::toStr('公钥加密: 我是公钥加密',$publicStr));

        $privateStr = $RSAEncryptor::privateDecrypt($publicStr);
        var_dump(static::toStr('私钥解密',$privateStr));

        
    }


    /**
     * @note 密码散列算法
     */
    public function pwHashTest()
    {
        $pw = 'sfsdfsdf';
        $hash = PwHash::passwordHash($pw);

        var_dump(static::toStr('password_hash 使用足够强度的单向散列算法创建密码的散列：\'sfsdfsdf\'', $hash));

        var_dump(static::toStr('验证密码是否和指定的散列值匹配', PwHash::passwordVerify($pw, $hash)));
        var_dump(static::toStr('关于此散列的信息数组', PwHash::passwordGetInfo($hash)));
    }


    /**
     * @note Hash 函数
     */
    public function hashTest()
    {

        $fileName = $this->fileSaveDir . '/test.txt';

        $fileObject = new FileObject($fileName);
        $fileObject->write('123456');

        $hashcs = new hash('md5');
        var_dump(static::toStr('创建 md5 hash 类', $hashcs));

        var_dump(static::toStr('使用给定文件的内容 \'123456\' 生成哈希值', $hashcs->hashUpdate('123456')->hashFinal()));

        var_dump(static::toStr('向活跃的哈希运算上下文中填充数据 \'123456\' ', $hashcs::hash('md5','123456')));

        var_dump(static::toStr('使用的哈希算法，"md5" 生成哈希值', $hashcs::hash('md5','123456')));

        var_dump(static::toStr('使用 md5 加密\'123456\'', md5('123456')));

        var_dump(static::toStr('适用于hash_hmac的已注册哈希算法列表', hash::hashAlgos()));


    }



}





