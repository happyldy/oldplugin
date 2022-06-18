<?php

namespace HappyLin\OldPlugin\SingleClass;




class GraphImage{


    public $img; //resource|GdImage|false

    public function __construct()
    {
    }

    /**
     * 测试
     * $text = 'HelloWorld';
     * 产生一个有5个混淆线条，字体为5，旋转角度在[-30,30]间的验证码
     * $img = verifyCode($text, 5, 5, array(-30, 30));
     * 设置输出类型为png图片
     * header("Content-type: image/png");
     * 输出
     * imagepng($img,'./aa.png');
     * 释放资源
     * imagedestroy($img);
     *
     *
     * @param $text
     * @param int $linect 需要混淆的线条个数
     * @param int $fontsize 字体大小，1到5
     * @param int[] $rotate 是否旋转
     * @param int[] $textcol 字体颜色RGB值，array(R,G,B)
     * @param int[] $bgcol 背景色RGB值，array(R,G,B)
     * @return $this
     */
    public function verifyCode(string $text,int $linect=6,int $fontsize=5,array $rotate=array(-44,44),array $textcol = array(255,0,0), $bgcol=array(255,255,255)):GraphImage
    {
        $len = strlen($text);
        $tximgw = imagefontwidth($fontsize);
        $tximgh = imagefontheight($fontsize);

        $imgof = $tximgw/2;
        $imgw = $len*($tximgw+$imgof);
        $imgh = $tximgh;

        $img = imagecreate($imgw, $imgh);
//        $img = imagecreatetruecolor($imgw, $imgh);

        imagefill($img, 0,0, imagecolorallocate($img, $bgcol[0], $bgcol[1], $bgcol[2]));

        // 输出字符
        for($i=0; $i<$len; ++$i){
            $char = $text[$i];
            $tximg = imagecreate($tximgw, $tximgh);
            $txbgcol = imagecolorallocate($tximg, $bgcol[0], $bgcol[1], $bgcol[2]);
            $txcol = imagecolorallocate($tximg, $textcol[0], $textcol[1], $textcol[2]);
            imagestring($tximg, $fontsize, 0, 0, $char, $txcol);
            $ag = $rotate?rand($rotate[0],$rotate[1]):0;

            // 旋转字符随机角度
            $oimg = imagerotate($tximg, $ag, $txbgcol);
            imagecopy($img, $oimg, $i*($tximgw+$imgof), 0 , 0 , 0 , imagesx($oimg) , imagesy($oimg));

            // 释放临时产生的图片资源
            imagedestroy($tximg);
            imagedestroy($oimg);
        }

        // 产生混淆的线条
        for($i=0; $i<$linect; ++$i){
            $x = rand(0, $imgw);
            $y = rand(0, $imgh);
            $x1 = rand(0, $imgw);
            $y1 = rand(0, $imgh);
            imageline ($img, $x, $y, $x1, $y1, imagecolorallocate($img, rand(0,255), rand(0,255), rand(0,255)));
        }
        $this->img = $img;

        return $this;
    }


    /**
     * @param $file
     * @param $type
     * @param false $cover 覆盖原图片
     * @return bool
     */
    public function save(string $fileName,string $type='jpeg', bool $cover = false):bool
    {
        
        if(!$cover && is_file($fileName)){
            return false;
        }

        if(!file_exists(dirname($fileName))){
            return false;
        }


        if($type === 'png'){
            imagepng($this->img, $fileName);
        }else{
            imagejpeg($this->img,$fileName);
        }
        imagedestroy($this->img);
        return true;

    }


    public function outputPng (){
        header("Content-type: image/png");
        if(!empty($this->img)){
            imagepng($this->img);
            imagedestroy($this->img);
        }
    }

    public function outputJpeg (){
        header("Content-type: image/jpeg");
        if(!empty($this->img)){
            imagejpeg($this->img);
            imagedestroy($this->img);
        }
    }



}












