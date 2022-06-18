<?php
/**
 *
 * 国内主流坐标系类型主要有以下三种：
 *
 * 1、WGS84：一种大地坐标系，也是目前广泛使用的 GPS 全球卫星定位系统使用的坐标系。
 *
 * 2、GCJ02：由中国国家测绘局制订的地理信息系统的坐标系统，是由 WGS84 坐标系经过加密后的坐标系。
 *
 * 3、BD09：百度坐标系，在 GCJ02 坐标系基础上再次加密。其中 BD09LL 表示百度经纬度坐标，BD09MC 表示百度墨卡托米制坐标。
 *
 * 注意：百度地图 SDK 在国内（包括港澳台）使用的是 BD09LL 坐标（定位 SDK 默认使用 GCJ02 坐标）；在海外地区，统一使用 WGS84 坐标。
 *
 *
 */


namespace HappyLin\OldPlugin\SingleClass;


class LongitudeAndLatitude
{

    /**
     * @var array 大地坐标系资料WGS-84 长半径a=6378137 短半径b=6356752.3142 扁率f=1/298.2572236
     */
    public $VincentyConstants = array('a'=>6378137, 'b'=>6356752.3142, 'f'=>(1 / 298.257223563));

    

    /**
     *Calculate destination point given start point lat/long (numeric degrees),
     * bearing (numeric degrees) & distance (in m).
     * 使用方法： destinationVincenty(['lng'=>119.295309,'lat'=>26.010319],'-45',5000);
     */
    public  function destinationVincenty($lonlat, $brng, $dist) {
        $u = $this;
        $ct = $u->VincentyConstants;
        $a = $ct['a']; $b = $ct['b']; $f = $ct['f'];
        $lon1 = $lonlat['lng'];
        $lat1 = $lonlat['lat'];
        $s = $dist;
        $alpha1 = deg2rad($brng);
        $sinAlpha1 = sin($alpha1);
        $cosAlpha1 = cos($alpha1);
        $tanU1 = (1 - $f) * tan(deg2rad($lat1));
        $cosU1 = 1 / sqrt((1 + $tanU1 * $tanU1)); $sinU1 = $tanU1 * $cosU1;
        $sigma1 = atan2($tanU1, $cosAlpha1);
        $sinAlpha = $cosU1 * $sinAlpha1;
        $cosSqAlpha = 1 - $sinAlpha * $sinAlpha;
        $uSq = $cosSqAlpha * ($a * $a - $b * $b) / ($b * $b);
        $A = 1 + $uSq / 16384 * (4096 + $uSq * (-768 + $uSq * (320 - 175 * $uSq)));
        $B = $uSq / 1024 * (256 + $uSq * (-128 + $uSq * (74 - 47 * $uSq)));
        $sigma = $s / ($b * $A); $sigmaP = 2 * M_PI;
        while (abs($sigma - $sigmaP) > 1e-12) {
            $cos2SigmaM = cos(2 * $sigma1 + $sigma);
            $sinSigma = sin($sigma);
            $cosSigma = cos($sigma);
            $deltaSigma = $B * $sinSigma * ($cos2SigmaM + $B / 4 * ($cosSigma * (-1 + 2 * $cos2SigmaM * $cos2SigmaM) - $B / 6 * $cos2SigmaM * (-3 + 4 * $sinSigma * $sinSigma) * (-3 + 4 * $cos2SigmaM * $cos2SigmaM)));
            $sigmaP = $sigma;
            $sigma = $s / ($b * $A) + $deltaSigma;
        }
        $tmp = $sinU1 * $sinSigma - $cosU1 * $cosSigma * $cosAlpha1;
        $lat2 = atan2($sinU1 * $cosSigma + $cosU1 * $sinSigma * $cosAlpha1, (1 - $f) * sqrt($sinAlpha * $sinAlpha + $tmp * $tmp));
        $lambda = atan2($sinSigma * $sinAlpha1, $cosU1 * $cosSigma - $sinU1 * $sinSigma * $cosAlpha1);
        $C = $f / 16 * $cosSqAlpha * (4 + $f * (4 - 3 * $cosSqAlpha));
        $L = $lambda - (1 - $C) * $f * $sinAlpha * ($sigma + $C * $sinSigma * ($cos2SigmaM + $C * $cosSigma * (-1 + 2 * $cos2SigmaM * $cos2SigmaM)));
        $revAz = atan2($sinAlpha, -$tmp);// final bearing
        // return new OpenLayers.LonLat(lon1+u.deg(L), u.deg(lat2));
        // console.log(u.deg(revAz));
//            var_dump($lon1+$u->deg($L), $u->deg($lat2));
        return array('lng'=>$lon1+rad2deg($L), 'lat'=>rad2deg($lat2));
    }

    

    /**
     *  计算两组经纬度坐标 之间的距离
     *   params ：lat1 纬度1； lng1 经度1； lat2 纬度2； lng2 经度2； len_type （1:m or 2:km);
     *   return m or km
     */
    public function distance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 2) {
        $earth_radius = 6378.137;			//地球半径，假设地球是规则的球体
        $PI = 3.1415926;				   //$PI()圆周率
        $radLat1 = $lat1 * $PI/ 180.0;
        $radLat2 = $lat2 * $PI / 180.0;
        $a = $radLat1 - $radLat2;
        $b = ($lng1 * $PI / 180.0) - ($lng2 * $PI / 180.0);
        $s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
        $s = $s * $earth_radius;
        $s = round($s * 1000);
        if ($len_type == 2) {
            $s /= 1000;
        }
        return round($s, $decimal);
    }

    /// <summary>
    /// 中国正常坐标系GCJ02协议的坐标，转到 百度地图对应的 BD09 协议坐标
    /// </summary>
    /// <param name="lat">维度</param>
    /// <param name="lng">经度</param>
    public static function Convert_GCJ02_To_BD09( $lat, $lng)
    {
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $lng;
        $y = $lat;
        $z =sqrt($x * $x + $y * $y) + 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) + 0.000003 * cos($x * $x_pi);
        $lng = $z * cos($theta) + 0.0065;
        $lat = $z * sin($theta) + 0.006;
    }

    /// <summary>
    /// 百度地图对应的 BD09 协议坐标，转到 中国正常坐标系GCJ02协议的坐标
    /// </summary>
    /// <param name="lat">维度</param>
    /// <param name="lng">经度</param>
    public static function Convert_BD09_To_GCJ02( $lat, $lng)
    {
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $lng - 0.0065;
        $y = $lat - 0.006;
        $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
        $lng = $z * cos($theta);
        $lat = $z * sin($theta);

        return ['lat'=> $lat, 'lng'=>$lng];
    }


    /*
     * BD-09转化为GCJ-02 调用腾讯地图的转化接口，GCJ-02（谷歌、高德、腾讯）
     * http://open.map.qq.com/webservice_v1/guide-convert.html
     */
    public static function convertCoord($blat, $blng) {

        $url = "http://apis.map.qq.com/ws/coord/v1/translate?locations=".$blat.",".$blng."&type=3&key=5Q5BZ-5EVWJ-SN5F3-K6QBZ-B3FAO-RVBWM&";
        //var_dump($blng,$blat,$url);
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10);
        $req = curl_exec($ch);
        $arr = json_decode ($req,TRUE);
        //var_dump($arr);die();
        if(isset($arr['status']) && $arr['status'] == 0 && isset($arr['locations'][0])){
            return $arr['locations'][0];
        }
        return array();
    }







}












