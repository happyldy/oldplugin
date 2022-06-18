<?php

namespace HappyLin\OldPlugin\SingleClass\FileSystem;

class FileProcess
{

    /**
     * 覆盖字符串
     * @param string $filename 文件绝对路劲（文件夹不会自动创建）
     * @retrun string
     */
    public static function read(string $filename, string $str): string
    {
        //打开文件
        $handle = fopen($filename, "rb");
        //读取字符串
        $contents = fread($handle, filesize($filename));
        //关闭文件
        fclose($handle);
        return $contents;
    }

    /**
     * 覆盖字符串
     * @param string $filename 文件绝对路劲（文件夹不会自动创建）
     * @param string $str
     * @return int
     */
    public static function write(string $filename, string $str): int
    {
        //打开文件
        $fd = fopen($filename, "wb");
        //写入字符串
        $size = fwrite($fd, $str . PHP_EOL);
        //关闭文件
        fclose($fd);
        return $size;
    }

    /**
     * 添加字符串
     * @param string $filename 文件绝对路劲（文件夹不会自动创建）
     * @param string $str
     * @return int
     */
    public static function add($filename, $str): int
    {
        //打开文件
        $fd = fopen($filename, "ab");
        //写入字符串
        $size = fwrite($fd, $str . PHP_EOL);
        //关闭文件
        fclose($fd);
        return $size;
    }



    /**
     * 自定日志方法：加时间，print_r能转成字符串的都行
     * @param string $filename 文件绝对路劲（文件夹自动创建）
     * @param mixed $data print_r能转成字符串的都行
     * @return int
     */
    public static function log($filename, $data): int
    {
        $dir = dirname($filename);
        if (!is_dir($dir) && !mkdir($dir, 0777, true)) {
            throw new \InvalidArgumentException('Folder creation failed');
        }

        $str = sprintf("[%1\$s]\n%2\$s", date("Y/m/d h:i:s"), print_r($data,true));

        return static::add($filename, $str);
    }


    /**
     * 脚本路劲下log文件夹按天创建日志
     * @param string $filename 文件名 相对log路劲 text.txt | mylog/text.txt
     * @param mixed $data print_r能转成字符串的都行
     * @return int
     */
    public static function logDay($filename, $data):int
    {
        //获取储存目录
        $path = dirname($_SERVER['SCRIPT_FILENAME']) . '/logs/' . date('Ymd');
        //绝对路劲
        $filename = $path . '/' . $filename;
        //绝对目录
        $dir = dirname($filename);
        if (!is_dir($dir) && !mkdir($dir, 0777, true)) {
            throw new \InvalidArgumentException('Folder creation failed');
        }
        return file_put_contents($filename, print_r($data, true), FILE_APPEND);
    }


}







