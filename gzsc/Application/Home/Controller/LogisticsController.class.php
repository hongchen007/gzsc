<?php
namespace Home\Controller;
use Think\Controller;
class LogisticsController extends Controller {

    //物流
    public function logistics(){
      //实例化
      $express_company = M('express_company');
      $aaa = 'https://m.kuaidi100.com/query?type=shentong&postid=402523215812';
      $bbb = file_get_contents($aaa);
      $ccc = json_decode($bbb,true);
      dump($bbb);exit;
    }

    //经纬度
    public function du(){
      
    }


}