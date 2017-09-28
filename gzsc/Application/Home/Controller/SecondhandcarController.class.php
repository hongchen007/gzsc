<?php
namespace Home\Controller;
use Think\Controller;
class SecondhandcarController extends Controller {

	//发布二手车信息
  	public function addhandcar(){
  	    //实例化
		$second_hand_car     = M('second_hand_car');
		$second_hand_carfile = M('second_hand_carfile');
		//接收数据
		$json = I('get.json','','strip_tags');
		$jsoninfo = json_decode($json,true);
		$data['user_id']    = $jsoninfo['user_id'];
		$data['brank']      = $jsoninfo['brank'];
		$data['color']      = $jsoninfo['color'];
		$data['first_time'] = $jsoninfo['first_time'];
		$data['price']      = $jsoninfo['price'];
		$data['des']        = $jsoninfo['des'];
		$data['name']       = $jsoninfo['name'];
		$data['tel']        = $jsoninfo['tel'];
		$data['area']       = $jsoninfo['area'];
		$data['add_time']   = date('Y-m-d H:i:s');
		$url1 = $jsoninfo['url1'];
		$data['driving_lience_pic'] = $url1[0]['url'];
		$data['lience_num_pic']	    = $url1[1]['url'];
		$data['register_pic']	    = $url1[2]['url'];
		$data['bill_pic'] 		    = $url1[3]['url'];
		//插入second_hand_car数据
		$info1 = $second_hand_car->add($data);
		$url2 = $jsoninfo['url2'];
		$len1 = count($url2);
		foreach($url2 as $k=>$v){
			//插入second_hand_carfile数据
			$date['second_hand_card_id'] = $info1;
			$date['file'] 				= $v['url'];
			$date['add_time'] 			= date('Y-m-d H:i:s');
			$info2[$k] = $second_hand_carfile->add($date);
		}
		$len2 = count($info2);
		if($info1 && $len1 == $len2){
			$info['sucmsg'] = '发布成功';
			$info['code'] = 1;			
		}else{
			$info['errmsg'] = '发布失败';
			$info['code'] = 0;			
		}
		$this->ajaxreturn($info,'JSON');
    }
}