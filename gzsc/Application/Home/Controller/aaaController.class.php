<?php
namespace Home\Controller;
use Think\Controller;
class TextController extends Controller {

    //地址处理
    public function address($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $res = curl_exec($ch);
        curl_close($ch);
        if(curl_errno($ch)){
            var_dump(curl_error($ch));
        }
        $arr = json_decode($res,true);
        return $arr;
    }

    public function getLatLong($address){
        if (!is_string($address))die("All Addresses must be passed as a string");
        $_url = sprintf('http://maps.google.com/maps?output=js&q;=%s',rawurlencode($address));
        $_result = false;
        if($_result = file_get_contents($_url)) {
            if(strpos($_result,'errortips') > 1 || strpos($_result,'Did you mean:') !== false) return false;
            preg_match('!center:\s*{lat:\s*(-?\d+\.\d+),lng:\s*(-?\d+\.\d+)}!U', $_result, $_match);
            $_coords['lat'] = $_match[1];
            $_coords['long'] = $_match[2];
        }
        return $_coords;
    }

    public function index(){
    	echo "qqq";exit;
    	$address = "河南省新乡市牧野区红星城市发展广场";
    	$info=$this->getLatLong($address);
    	dump($info);exit;
    }

}