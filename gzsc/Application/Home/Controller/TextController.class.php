<?php
namespace Home\Controller;
use Think\Controller;
class TextController extends Controller {

    // //地址处理
    // public function address($url){
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    //     curl_setopt($ch, CURLOPT_URL,$url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    //     $res = curl_exec($ch);
    //     curl_close($ch);
    //     if(curl_errno($ch)){
    //         var_dump(curl_error($ch));
    //     }
    //     $arr = json_decode($res,true);
    //     return $arr;
    // }

    // public function url1(){
    //     $key1 = "5e1d907387689cd2c224b15ca8267a41";
    //     $address1 = "新乡市牧野区";
    //     $ab = "http://restapi.amap.com/v3/geocode/geo?address=$address1&output=JSON&key=5e1d907387689cd2c224b15ca8267a41";
    //     $ab = file_get_contents($ab);
    //     $bc = json_decode($ab,true);
    //     dump($bc);exit;
    // }

    // public function getuser_store_xLong($address){
    //     if (!is_string($address))die("All Addresses must be passed as a string");
    //     $_url = sprintf('http://maps.google.com/maps?output=js&q;=%s',rawurlencode($address));
    //     $_result = false;
    //     if($_result = file_get_contents($_url)) {
    //         if(strpos($_result,'errortips') > 1 || strpos($_result,'Did you mean:') !== false) return false;
    //         preg_match('!center:\s*{user_store_x:\s*(-?\d+\.\d+),user_store_y:\s*(-?\d+\.\d+)}!U', $_result, $_match);
    //         $_coords['user_store_x'] = $_match[1];
    //         $_coords['long'] = $_match[2];

    //     }
    //     $user_store_x;
    //     $user_store_y;
    //     return $_coords;
    // }

    // public function juli(){
    //     //获取该点周围的4个点
    //     $distance = 5; //范围（单位千米）
    //     $user_store_x = 113.947962;
    //     $user_store_y = 35.306758;
    //     define('EARTH_RADIUS', 6371); //地球半径，平均半径为6371km
    //     $duser_store_y = 2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($user_store_x)));
    //     $duser_store_y = rad2deg($duser_store_y);
    //     $duser_store_x = $distance / EARTH_RADIUS;
    //     $duser_store_x = rad2deg($duser_store_x);
    //     $squares = array('left-top' => array('user_store_x' => $user_store_x + $duser_store_x, 'user_store_y' => $user_store_y - $duser_store_y), 
    //                      'right-top' => array('user_store_x' => $user_store_x + $duser_store_x, 'user_store_y' => $user_store_y + $duser_store_y),
    //                      'left-bottom' => array('user_store_x' => $user_store_x - $duser_store_x, 'user_store_y' => $user_store_y - $duser_store_y), 
    //                      'right-bottom' => array('user_store_x' => $user_store_x - $duser_store_x, 'user_store_y' => $user_store_y + $duser_store_y));
    //     // dump($squares['left-top']['user_store_x']);exit;
    //     //从数库查询匹配的记录
    //     // $info_sql = "select * from `A` where user_store_x<>0 and user_store_x>{$squares['right-bottom']['user_store_x']} and user_store_x<{$squares['left-top']['user_store_x']} and user_store_y>{$squares['left-top']['user_store_y']} and user_store_y<{$squares['right-bottom']['user_store_y']} ";
    //     $info_sql = "select * from user where user_store_x<>0 and user_store_x>{$squares['right-bottom']['user_store_x']} and user_store_x<{$squares['left-top']['user_store_x']} and user_store_y>{$squares['left-top']['user_store_y']} and user_store_y<{$squares['right-bottom']['user_store_y']} ";
    //     $Model = M();
    //     $result = $Model->query($info_sql);
    //     dump($result);exit;
    //     //获取两点之间的距离
    //     function getDistanceBetweenPointsNew($user_store_xitude1, $longitude1, $user_store_xitude2, $longitude2) {
    //         $theta = $longitude1 - $longitude2;
    //         $miles = (sin(deg2rad($user_store_xitude1)) * sin(deg2rad($user_store_xitude2))) + (cos(deg2rad($user_store_xitude1)) * cos(deg2rad($user_store_xitude2)) * cos(deg2rad($theta)));
    //         $miles = acos($miles);
    //         $miles = rad2deg($miles);
    //         $miles = $miles * 60 * 1.1515;
    //         $feet = $miles * 5280;
    //         $yards = $feet / 3;
    //         $kilometers = $miles * 1.609344;
    //         $meters = $kilometers * 1000;
    //         return compact('miles', 'feet', 'yards', 'kilometers', 'meters');
    //     }
    //     $point1 = array('user_store_x' => 40.770623, 'long' => - 73.964367);
    //     $point2 = array('user_store_x' => 40.758224, 'long' => - 73.917404);
    //     $distance = getDistanceBetweenPointsNew($point1['user_store_x'], $point1['long'], $point2['user_store_x'], $point2['long']);
    //     foreach ($distance as $unit => $value) {
    //         echo $unit . ': ' . number_format($value, 4) . '<br />';
    //     }
    // }

    public function aaa($lat1, $lng1, $lat2, $lng2){   
        // $bbb= 6367000; 
        $lat1 = ($lat1 * pi() ) / 180;   
        $lng1 = ($lng1 * pi() ) / 180;   
        $lat2 = ($lat2 * pi() ) / 180;   
        $lng2 = ($lng2 * pi() ) / 180;   
        $calcLongitude = $lng2 - $lng1;   
        $calcLatitude = $lat2 - $lat1;   
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);   
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));   
        $calculatedDistance = 6367000* $stepTwo;   
        return round($calculatedDistance);   
    }   
    public function juli1(){
        $limit = $this->aaa("39.916314","116.492301","39.976315","116.491302");  
        dump($limit);exit;
    }

//获取该点周围的4个点
// $distance = 1;//范围（单位千米）
// $lat = 113.873643; //user_store_x
// $lng = 22.573969;
// define('EARTH_RADIUS', 6371);//地球半径，平均半径为6371km
// $dlng = 2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($lat)));
// $dlng = rad2deg($dlng);
// $dlat = $distance/EARTH_RADIUS;
// $dlat = rad2deg($dlat);
// $squares = array('left-top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
//         'right-top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
//         'left-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
//         'right-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng)
//         );
// print_r($squares['left-top']['lat']);
// //从数库查询匹配的记录
// $info_sql = "select * from `A` where lat<>0 and lat>{$squares['right-bottom']['lat']} and lat<{$squares['left-top']['lat']} and lng>{$squares['left-top']['lng']} and lng<{$squares['right-bottom']['lng']} ";
// //获取两点之间的距离
// function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2) {
//   $theta = $longitude1 - $longitude2;
//   $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
//   $miles = acos($miles);
//   $miles = rad2deg($miles);
//   $miles = $miles * 60 * 1.1515;
//   $feet = $miles * 5280;
//   $yards = $feet / 3;
//   $kilometers = $miles * 1.609344;
//   $meters = $kilometers * 1000;
//   return compact('miles','feet','yards','kilometers','meters'); 
// }
// $point1 = array('lat' => 40.770623, 'long' => -73.964367);
// $point2 = array('lat' => 40.758224, 'long' => -73.917404);
// $distance = getDistanceBetweenPointsNew($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);
// foreach ($distance as $unit => $value) {
//   echo $unit.': '.number_format($value,4).'<br />';
// }


}