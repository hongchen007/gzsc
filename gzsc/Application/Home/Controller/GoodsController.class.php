<?php
namespace Home\Controller;
use Think\Controller;
use Org\Util;
class GoodsController extends Controller {

     //封装一个方法，传进一个父类Id，返回其下的所有子类集合
    Public static function subtrr($arr,$id,$len=1){
        $subs = array();
        foreach($arr as $a=>$b){
            if($b['pid'] == $id){
                $b['len'] = $len;
                $subs[] = $b;
                $subs = array_merge($subs,self::subtrr($arr,$b['id'],$len+1));
            }
        }
        return $subs;
    }

	//商品收藏
	public function collectgoods(){
		//实例化
		$collectgood = M('collectgood');
		$good_attr = M('good_attr');
		$good = M('good');
		$order = M('order');
		$orderdetail = M('orderdetail');
		//用户的id
		// $where1['user_id'] = $_SESSION['Login']['id'];
		$data['user_id'] = I('get.user_id','','strip_tags');
		//查询数据(商品属性-->商品名称-->商品所属店铺名称)
		$collectgoods = $collectgood->where($data)->select();
		// dump($collectgoods);
		$info = array();
		foreach($collectgoods as $k=>$v){
			//商品属性
			$where1['id'] = $v['good_attr_id'];
			$good_attrinfo = $good_attr->where($where1)->find();
			// dump($good_attrinfo);
			//商品名称和属性
			$where2['id'] = $good_attrinfo['good_id'];
			$goodinfo = $good->where($where2)->field('good_name,user_store_name')->find();
			$goodinfo['good_attr_des'] = $good_attrinfo['good_attr_des'];
			$goodinfo['good_attr_price'] = $good_attrinfo['good_attr_price'];
			$goodinfo['good_id'] = $good_attrinfo['good_id'];
			// dump($goodinfo);
			$info[$k] = $goodinfo;
		}
		// dump($info);
      	//计算月销售量(是否完成没有判断)
      	$begintime=date('Y-m-d H:i:s',mktime(0,0,0,date('m'),1,date('Y')));
      	$endtime=date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('t'),date('Y')));
      	$where3['orderdetail_time'] = array('BETWEEN', array($begintime,$endtime));
      	// dump($where3);exit;
      	foreach($info as $k=>$v){
        	$where4['good_id'] = $v['good_id'];
        	//有商品的id通过订单属性表查找订单的id和购买的数量
        	$info1 = $orderdetail->where($where4)->where($where3)->field('order_id,good_num')->select();
        	// dump($info1);
        	foreach($info1 as $ke=>$va){
	        	// $where5['id'] = $va['order_id'];
	        	// $where5['order_grade'] = 4;//商品是否订单完成
	        	// $info2 = $order->where($where5)->find();
	        	// dump($info2);exit;
	        	// if(empty($info2)){	
	        	// 	$info[$k]['good_num'] = 0;
	        	// }else{
	        		$info[$k]['good_num'] += $va['good_num'];
	        	// }   		
        	}

      	}

		dump($info);exit;
	}

//=========================================商品详情============================================
	//商品详情
	public function detail(){
	    //实例化
	    $good = M('good');
	    $order = M('order');
	    $user = M('user');
	    $rele = M('rele');
	    $file = M('file');
	    $good_attr = M('good_attr');
	    $evaluate = M('evaluate');
	    //1：接收商品id   (此时的商品下架情况在上级页面的时候已经做了处理，这里就不用再做处理)
	    $where1['id'] = $id = I('get.id','','strip_tags');
	    //2：查询商品表，找到商品所属商户的id，和商品的名称
	    $goodinfo = $good->where($where1)->field('id,user_id,good_name')->find();
	    //3：通过关联表找商品的属性id和文件id
	    $where2['good_id'] = $goodinfo['id'];
	    $releinfo = $rele->where($where2)->field('good_attr_id,file_id')->select();
	    //4：通过商品属性表找商品的属性
	    // foreach($releinfo as $k=>$v){
	    //     $where3['id'] = $v['good_attr_id'];
	    //     $goodattrinfo[$k] = $good_attr->where($where3)->find();
	    //     //5：通过商品的文件表找商品的图片
	    //     $where4['id'] = $v['file_id'];
	    //     $fileinfo[$k] = $file->where($where4)->find();
	    //     $goodattrinfo[$k]['file_pic'] = $fileinfo[$k]['file_pic'];
	    // }
	    $goodattrinfo = $good_attr->where($where2)->select();
	    $res = [];
		foreach ($goodattrinfo as $k => $v) {
		    $res[$v['good_attr_color']][] = $v;
		}
		//整合数据
		foreach($res as $k=>$v){
			$arr[] = $v;
			$kall[] = $k;
		}
		// dump($arr);
		// dump($kall);exit;
		foreach($arr as $k=>$v){
			foreach($v as $ke=>$vl){
				$arra[$k]['color']     = $kall[$k];
				$arra[$k]['date'][$ke] = $vl;
			}
		}
	    // dump($arra);exit;
	    // $this->ajaxreturn($arr,'JSON');exit;
	    //6：通过用户表找到商品所属商户的详细信息
	    $where5['id'] = $goodinfo['user_id'];
	    $storeinfo = $user->where($where5)->field('id,user_store_name,user_store_pic,user_store_phone,user_store_evaluate,user_store_address')->find();
	    $storeinfo['user_store_pic'] = $storeinfo['user_store_pic'];
	    $good_name = $goodinfo['good_name'];
	    $user_store_name = $storeinfo['user_store_name'];
	    // dump($storeinfo);exit;
	    // $good_info[$good_name] = $goodattrinfo;
	    // $good_info[$user_store_name] = $storeinfo;
	    //7：	第一条评论
	    //7.1:	通过评论表的时间倒序和商品的id找到评论的第一条id和品论的内容
	    $evaluateinfo = $evaluate->where($where2)->order('add_time desc')->find();
	    $countevaluate = $evaluate->where($where2)->count();
	    //7.2: 	通过评论的第一条的数据查找用户的id，从而得到哦用户的头像和名称
	    $where6['id'] = $evaluateinfo['user_id'];
	    $userinfo = $user->where($where6)->field('user_pic,user_name')->find();
	    $evaluateinfo['user_pic'] = $userinfo['user_pic'];
	    $evaluateinfo['user_name'] = $userinfo['user_name'];
	    //7.3： 通过用户的评论的第一条信息找评论的商品属性id，杏儿查找商品的属性
	    $where7['good_attr_id'] = $evaluateinfo['good_attr_id'];
	    $good_attr_info = $good_attr->where($hwere7)->field('good_attr_color,good_attr_size')->find();
	    $evaluateinfo['good_attr_color'] = $good_attr_info['good_attr_color'];
	    $evaluateinfo['good_attr_size'] = $good_attr_info['good_attr_size'];
	    $evaluateinfo['evaluate_num'] = $countevaluate;
	    //合并商品的评论   商品的属性     商品的商户
	    // $good_info['evaluateinfo'] = $evaluateinfo;
	    //图片轮播
	    $fileinfo = $file->where("good_id=$id")->field('file_pic')->select();
	    // dump($fileinfo);
	    //商品的属性，把相同样色的的尺码放在一起
	   
	    foreach($goodattrinfo as $k=>$v){
	    	$where['good_attr_color'] = $v['good_attr_color'];
	    	$goodinfo1 = $good_attr->where($where)->select();
	    }
	    // dump($res);
	    // dump($fileinfo);
	    // dump($evaluateinfo);exit;
	    $info['pic']    = $fileinfo;
	    $info['attr']   = $arra;
	    $info['eva']    = $evaluateinfo;
	    $info['store']  = $storeinfo;
	    $this->ajaxreturn($info,'JSON');
	}

	//商品详情  取消收藏/收藏(商品)
	public function goodcollect(){
		//实例化
		$collectgood = M('collectgood');
		//接收数据
		$data['user_id'] = I('get.user_id','','strip_tags');
		$data['good_attr_id'] = I('get.good_attr_id','','strip_tags');
		//查询是否已经收藏
		$where1['user_id'] = $data['user_id'];
		$where1['good_attr_id'] = $data['good_attr_id'];
		// dump($where1);exit;
		$info = $collectgood->where($where1)->field('id')->find();
		if($info){
			$id = $info['id'];
			$collectgood->where("id=$id")->delete();
			$this->ajaxreturn(1);
		}else{
			$data['add_time'] = date('Y-m-d H:i:s',time());
			$collectgood->add($data);
			$this->ajaxreturn(2);
		}
	}

	//商品是否收藏
	public function orcollect(){
		//实例化
		$colloctgood = M('collectgood');
		//接收数据
		$data['user_id'] = I('get.user_id','','strip_tags');
		$data['good_attr_id'] = I('get.good_attr_id','','strip_tags');
		//查询数据
		$collectgoodinfo = $colloctgood->where($data)->find();
		if($collectgoodinfo){
			$suc['msg'] = "已近收藏";
			$suc['state'] = '1';
			$this->ajaxreturn($suc,'JSON');
		}else{
			$suc['msg'] = "没有收藏";
			$suc['state'] = '0';
			$this->ajaxreturn($suc,'JSON');			
		}
	}

	//商品详情  取消收藏/收藏(商户)
	public function storecollect(){
		//实例化
		$collectstore = M('collectstore');
		//接收数据
		$data['user_id'] = I('get.user_id','','strip_tags');
		$data['store_id'] = I('get.store_id','','strip_tags');
		//查询是否已经收藏
		$where1['user_id'] = $data['user_id'];
		$where1['store_id'] = $data['store_id'];
		// dump($where1);exit;
		$info = $collectstore->where($where1)->field('id')->find();
		if($info){
			$id = $info['id'];
			$collectstore->where("id=$id")->delete();
			$this->ajaxreturn(1);
		}else{
			$data['add_time'] = date('Y-m-d H:i:s',time());
			$collectstore->add($data);
			$this->ajaxreturn(2);
		}
	}

	//商店是否收藏
	public function orstore(){
		//实例化
		$collectstore = M('collectstore');
		//接收数据
		$data['user_id'] = I('get.user_id','','strip_tags');
		$data['store_id'] = I('get.store_id','','strip_tags');
		//查询数据
		$info = $collectstore->where($data)->find();
		if($info){
			$suc['msg'] = "已近收藏";
			$suc['state'] = '1';
			$this->ajaxreturn($suc,'JSON');
		}else{
			$suc['msg'] = "没有收藏";
			$suc['state'] = '0';
			$this->ajaxreturn($suc,'JSON');			
		}
	}

	//加入购物车
	public function addshoppingcar(){
		//实例化
		$shoppingcar = M('shoppingcar');
		//1接收商品的id和商品属性id  通过session找到用户的id
		$where1['good_id'] = $data['good_id'] = I('get.good_id','','strip_tags');
		$where1['user_id'] = $data['user_id'] = I('get.user_id','','strip_tags');
		$where1['good_attr_id'] = $data['good_attr_id'] = I('get.good_attr_id','','strip_tags');
		$where1['store_id'] = $data['store_id'] = I('get.store_id');
		$data['add_time'] = date('Y-m-d H:i:s',time());
		if($_GET['good_num']){
			$data['good_num'] = I('get.good_num','','strip_tags');
		}else{
			$data['good_num'] = 1;
		}
		// dump($data);
		//判断是否已经加入购物车
		$info = $shoppingcar->where($where1)->find();
		if($info){
			$info1['code'] = 0;
			$info1['errmsg'] = "已经加入过购物车";
			$this->ajaxreturn($info1);//已经加入购物车
		}else{
			$shoppingcar = $shoppingcar->add($data);
			if($shoppingcar){
				$info1['code'] = 1;
				$info1['sucmsg'] = $shoppingcar;
				$this->ajaxreturn($info1,'JSON');//加入购物车成功
			}else{
				$info1['code'] = 0;
				$info1['errmsg'] = "加入购物车失败";				
				$this->ajaxreturn($info1,'JSON');//加入购物车失败
			}			
		}
	}

//=========================================购物车=====================================
	/*
		1结算-->确认订单(提交订单)-->
	 */

	//删除
	public function delshopping(){
		//实例化
		$shoppingcar = M('shoppingcar');
		M()->startTrans();
		//接收数据
		$json = I('get.json','','strip_tags');
		$jsoninfo = json_decode($json,true);
		$info = $jsoninfo['data'];
		$num1 = count($info);
		// dump($num1);
		// dump($jsoninfo);exit;
		// dump($num1);
		$num2 = 0;
		foreach($info as $k=>$v){
			$where['id'] = $v['id'];
			$delinfo = $shoppingcar->where($where)->delete();
			$num2 = $num2 + $delinfo;
		}
		if($num1 == $num2 && $num1 > 0){
			M()->commit();
			$info1['code'] = 1;
			$info1['sucmsg'] = '删除成功';
			$this->ajaxreturn($info1,'JSON');
		}else{
			M()->rollback();
			$info1['errmsg'] = '删除失败';
			$info1['code'] = 0;
			$this->ajaxreturn($info1,'JSON');			
		}
	}

	//购物车页面
	public function shoppingcar(){
		//实例化
		$shoppingcar = M('shoppingcar');
		$user = M('user');
		$good_attr = M('good_attr');
		$good = M('good');
		$file = M('file');
		//接收用户的id
		$where1['user_id'] = I('get.user_id');
		//查购物车标
		$shoppingcarinfo = $shoppingcar->where($where1)->select();
		$res = array(); 
		foreach ($shoppingcarinfo as $k => $v) {
		  $res[$v['store_id']][] = $v;
		}
		// dump($res);
		foreach($res as $k=>$v){
			//获取商店名称
			$where2['id'] = $k;
			$storeinfo = $user->where($where2)->field('id,user_store_name')->find();
			// dump($storeinfo);exit;
			foreach($v as $ke=>$va){
				// dump($va);
				//获取商品的图片
				$where3['good_attr_id'] = $va['good_attr_id'];
				$fileinfo = $file->where($where3)->field('file_pic')->find();
				// dump($fileinfo);
				//获取商品的名称
				$where4['id'] = $va['good_id'];
				$goodinfo = $good->where($where4)->field('id,good_name')->find();
				// dump($goodinfo);exit;
				//获取商品的属性
				$where5['id'] = $va['good_attr_id'];
				$good_attrinfo = $good_attr->where($where5)->field('id,good_attr_color,good_attr_size,good_attr_price,good_attr_price1,good_attr_des')->find();
				// dump($good_attrinfo);
				$info[$k]['store_name'] = $storeinfo['user_store_name'];
				$info[$k]['store_id'] = $storeinfo['id'];
				$info[$k]['date'][$ke]['store_pic']       = $fileinfo['file_pic'];
				$info[$k]['date'][$ke]['good_name']       = $goodinfo['good_name'];
				$info[$k]['date'][$ke]['good_id']         = $goodinfo['id'];
				$info[$k]['date'][$ke]['good_attr_id']    = $good_attrinfo['id'];
				$info[$k]['date'][$ke]['good_attr_color'] = $good_attrinfo['good_attr_color'];
				$info[$k]['date'][$ke]['good_attr_size']  = $good_attrinfo['good_attr_size'];
				$info[$k]['date'][$ke]['good_attr_des']   = $good_attrinfo['good_attr_des'];
				$info[$k]['date'][$ke]['good_num']        = $res[$k][$ke]['good_num'];
				$info[$k]['date'][$ke]['id']              = $res[$k][$ke]['id'];
				if($good_attrinfo['good_attr_price1']){
					$info[$k]['date'][$ke]['good_attr_price'] = $good_attrinfo['good_attr_price1'];
				}else{
					$info[$k]['date'][$ke]['good_attr_price'] = $good_attrinfo['good_attr_price'];
				}
			}
		}
		foreach($info as $k=>$v){
			$info1[] = $v;
		}
		$this->ajaxreturn($info1,'JSON');
		// dump($info1);exit;
	}

	//确认订单页面(收获地址)(商品就不需要传了)
	public function address(){
		//实例化
		$address = M('address');
		//接收数据
		$where1['user_id'] = I('get.user_id','','strip_tags');
		$addressinfo1 = $address->where($where1)->select();
		$info = array();
		if($addressinfo1){
			foreach($addressinfo1 as $k=>$v){
				if($v['default'] == 1){
					$info['sucmsg'] = [$v];
					$info['code'] = 200;
				}
			}
		}else{
			$info['errmsg'] = '请先填写地址';
			$info['code'] = 400;
		}
		// dump($info);exit;
		$this->ajaxreturn($info,'JSON');
	}

	//订单号的唯一性
	public function onlyorder(){
		//实例化
		$order = M('order');
		//订单号
		$order_num = time().rand(1111111,9999999);	//订单号
		$where=array();
		$begintime=date('Y-m-d H:i:s',time()-10000);
		$endtime=date('Y-m-d H:i:s',time());
		$where['order_addtime'] = array('BETWEEN', array($begintime,$endtime));
		$order_numinfo = $order->where($where)->field('order_num')->order('id desc')->select();
		foreach($order_numinfo as $aaa=>$bbb){
			if($order_num == $bbb['order_num']){
				self::onlyorder();
			}
		}
		return  $order_num;
	}

	//确认订单 (由购物车过来)  (点击提交订单)
	public function submitorder(){
		//实例化
		$order = M('order');
		$orderdetail = M('orderdetail');
		$address = M('address');
		$shoppingcar = M('shoppingcar');
		M()->startTrans();
		//接收数据
		$json = I('get.json','','strip_tags');
		$jsoninfo = json_decode($json,true);

		// dump($jsoninfo);

		//订单表信息($data)
		$user_id = $jsoninfo['user_id'];//用户id
		$address_id = $jsoninfo['id'];	//收货地址id

		// dump($user_id);
		// dump($address_id);

		unset($jsoninfo['id']);
		unset($jsoninfo['user_id']);

		// dump($jsoninfo);

		foreach($jsoninfo as $k=>$v){
			//订单表信息($data)
			$data[$k]['user_id']     =  $user_id;	//用户id
			$data[$k]['address_id']  =  $address_id;	//收货地址id
			$data[$k]['store_id']    =  $v[0]['user_store_id'];	//店铺id
			$data[$k]['order_num']   =  $order_num = $this->onlyorder();//订单号
			$data[$k]['order_addtime']  =  date('Y-m-d H:i:s',time());
			$data[$k]['order_grade'] =  1;

			// dump($data);exit;

			$dada[$k]['user_id']     =  $data[$k]['user_id'];	//用户id
			$dada[$k]['store_id']    =  $data[$k]['store_id'];	//店铺id
			foreach($v as $ke=>$va){
				$data[$k]['order_total'] += $va['good_num']*$va['good_attr_price'];//订单的价格774  45
				$date[$k][$ke]['good_id']          = $va['good_id'];
				$date[$k][$ke]['good_attr_id']     = $va['good_attr_id'];
				$date[$k][$ke]['good_attr_price']  = $va['good_attr_price'];
				$date[$k][$ke]['good_num']         = $va['good_num'];
				$date[$k][$ke]['orderdetail_time'] = date('Y-m-d H:i:s',time());

				$dada[$k][$ke]['good_id']         = $date[$k][$ke]['good_id'];
				$dada[$k][$ke]['good_attr_id']    = $date[$k][$ke]['good_attr_id'];
				$dada[$k][$ke]['good_attr_price'] = $date[$k][$ke]['good_attr_price'];
				$dada[$k][$ke]['good_num']        = $date[$k][$ke]['good_num'];
				$dada[$k][$ke]['user_id']         = $dada[$k]['user_id'];
				$dada[$k][$ke]['store_id']        = $dada[$k]['store_id'];
			}
			unset($dada[$k]['user_id']);
			unset($dada[$k]['store_id']);
 
			//插入订单表，查找刚刚插入的n条信息的id（一个商家一个订单号，一个价格）
			$addorder[$k] = $order->add($data[$k]);
			if(empty($addorder[$k])){
				M()->rollback();
				$info['errmsg'] = '订单失败';
				$info['code'] = 0;
				$this->ajaxreturn($info,'JSON');
			}
			$searchorder = $order->where($data[$k])->field('id')->find();
			$date[$k]['order_id'] = $searchorder['id'];
			//查找订单表对应的订单详情表的数据，并插入订单详情表
		}

		foreach($date as $k=>$v){
			foreach($v as $ke=>$val){
				$date[$k][$ke]['order_id'] = $v['order_id'];
			}
			unset($date[$k]['order_id']);
		}

		//把$date() 数据插入订单详情表
		foreach($date as $k=>$v){
			foreach($v as $ke=>$va){
				$adddetail[$k][$ke] = $orderdetail->add($va);
			}
			if(empty($adddetail[$k][$ke])){
				M()->rollback();
				$info['errmsg'] = '订单失败';
				$info['code'] = 0;
				$this->ajaxreturn($info,'JSON');
			}		
		}
		//删除购物车已经提交订单的信息
		foreach($dada as $k=>$v){
			$sumcar += count($v);
			foreach($v as $ke=>$va){
				$where['good_id']      = $va['good_id'];
				$where['good_attr_id'] = $va['good_attr_id'];
				$where['good_num']     = $va['good_num'];
				$where['user_id']      = $va['user_id'];
				$where['store_id']     = $va['store_id'];
				$delid += $shoppingcar->where($where)->delete();
			}
		}
		// dump($sumcar);
		// dump($delid);exit;
		if($sumcar == $delid){
			M()->commit();
			$info['code'] = 1;
			$info['sucmsg'] = $date;
			$this->ajaxreturn($info,'JSON');
		}else{
			M()->rollback();
			$info['errmsg'] = '订单失败';
			$info['code'] = 0;
			$this->ajaxreturn($info,'JSON');			
		}
	}

	//确认订单 (直接购买)  (点击提交订单)
	public function submitorder1(){
		//实例化
		$order = M('order');
		$orderdetail = M('orderdetail');
		$address = M('address');
		$shoppingcar = M('shoppingcar');
		// M()->startTrans();
		//接收数据
		$json = I('get.json','','strip_tags');
		$jsoninfo = json_decode($json,true);
		//订单表信息($data)
		$data['user_id']    = $jsoninfo['user_id'];	 			//用户id								
		$data['address_id'] = $jsoninfo['address_id']; 			//收货地址id
		$data['store_id']   = $jsoninfo['store_id']; 			//店铺id
		$data['order_num']  = $order_num = $this->onlyorder();//订单号
		$data['order_addtime'] = date('Y-m-d H:i:s',time());
		$data['order_grade'] = 1;
		$data['order_total'] =  $jsoninfo['good_num'] * $jsoninfo['good_attr_price'];
		//添加order表信息
		$orderinfo = $order->add($data);
		//订单详情表信息
		//查询刚刚添加到订单表的信息
		$orderlastid = $order->order('id desc')->field('id')->find();
		$date['order_id'] = $orderlastid['id'];
		$date['good_id']  = $jsoninfo['good_id'];
		$date['good_attr_id']    = $jsoninfo['good_attr_id'];
		$date['good_attr_price'] = $jsoninfo['good_attr_price'];
		$date['good_num']   = $jsoninfo['good_num'];
		$date['orderdetail_time'] = date('Y-m-d H:i:s',time());
		$orderdetailinfo = $orderdetail->add($date);
		// dump($orderdetailinfo);exit;
		if($orderinfo && $orderdetailinfo){
			M()->commit();
			$info['code'] = 1;
			$info['sucmsg'] = $date;
			$this->ajaxreturn($info,'JSON');
		}else{
			M()->rollback();
			$info['errmsg'] = '订单失败';
			$info['code'] = 0;
			$this->ajaxreturn($info,'JSON');			
		}
	}

	//支付完成把订单号传过来
	public function  payorder(){
		//实例化
		$order = M('order');
		M()->startTrans();
		//接收数据
		$json = I('get.json','','strip_tags');
		$jsoninfo = json_decode($json,true);
		$suminfo = count($jsoninfo);
		//修状态
		foreach($jsoninfo as $k=>$v){
			$where1['id'] = $v;
			$date['order_grade'] = 2;
			$suminfo1 += $order->where($where1)->save($date);
		}
		if($suminfo == $suminfo1 && $suminfo>0){
			M()->commit();
			$info['code'] = 1;
			$info['sucmsg'] = '支付成功';
		}else{
			M()->rollback();
			$info['code'] = 0;
			$info['sucmsg'] = '支付失败';
		}
		$this->ajaxreturn($info,'JSON');
	}

//=========================================统一下单=====================================================

	//统一下单
	public function tongyi(){
		//接收数据
		$json = I('get.json','','strip_tags');
		$jsoninfo = json_decode($json,true);
		//填写配置参数
		$options = array(
			'appid' 	=> 	'wxe761b7eec1eb651a',		//填写微信分配的公众开放账号ID
			'mch_id'	=>	'1488092332',				//填写微信支付分配的商户号
			'notify_url'=>	$jsoninfo['notify_url'],		//填写微信支付结果回调地址
			'key'		=>	'lkijikyhujtgrdtrwersRTYIOJKJLIJK'	//填写  商户支付密钥Key。审核通过后，在微信发送的邮件中查看
		);
		//统一下单方法
		$wechatAppPay = new \Org\Util\Wxpay($options);
		$params['body'] = $jsoninfo['body'];						//商品描述
		$params['out_trade_no'] = time().mt_rand(111111,999999);	//自定义的订单号
		$params['total_fee'] = $jsoninfo['total_fee'];				//订单金额 只能为整数 单位为分
		$params['trade_type'] = 'APP';								//交易类型 JSAPI | NATIVE | APP | WAP 
		$result = $wechatAppPay->unifiedOrder( $params );
		// print_r($result);
		//创建APP端预支付参数
		/** @var TYPE_NAME $result */
		$data = @$wechatAppPay->getAppPayParams( $result['prepay_id'] );

		print_r($data);		
	}

//=========================================订单========================================================

	//订单详情
	public function orderdetail(){
		//实例化
		$user      = M('user');
		$address   = M('address');
		$good      = M('good');
		$good_attr = M('good_attr');
		$file 	   = M('file');
		//接收值
		$json = I('get.json','','strip_tags');
		$jsoninfo = json_decode($json,true);
		// dump($jsoninfo);exit;
		//商家信息
		foreach($jsoninfo as $k=>$v){
			$where1['user_store_name'] = $k;
			$storeinfo = $user->where($where1)->field('user_store_name,user_store_headerpic,user_store_evaluate,user_store_phone,user_store_address')->find();
			$storeinfo['user_store_headerpic'] = $storeinfo['user_store_headerpic'];
		}

		//商品信息
		foreach($jsoninfo as $k=>$v){
			foreach($v as $ke=>$va){
				//实例化
				$good = M('good');
				$good_attr = M('good_attr');
				$where2['id'] = $va['good_id'];
				$where3['id'] = $va['good_attr_id'];
				$where4['good_attr_id'] = $va['good_attr_id'];
				//商品信息
				$goodinfo = $good->where($where2)->find();
				$good_attrinfo = $good_attr->where($where3)->find();
				$fileinfo = $file->where($where4)->find();
				$suminfo[$k][$ke]['giood_name'] = $goodinfo['good_name'];
				$suminfo[$k][$ke]['good_attr_des'] = $good_attrinfo['good_attr_des'];
				$suminfo[$k][$ke]['price'] = $va['good_attr_price'];
				$suminfo[$k][$ke]['good_num'] = $va['good_num'];
				$suminfo[$k][$ke]['good_pic'] = $fileinfo['file_pic'];
			}
		}
		$suminfo['user_store_name'] = $storeinfo['user_store_name'];
		$suminfo['user_store_headerpic'] = $storeinfo['user_store_headerpic'];
		$suminfo['user_store_evaluate'] = $storeinfo['user_store_evaluate'];
		$suminfo['user_store_phone'] = $storeinfo['user_store_phone'];
		$suminfo['user_store_address'] = $storeinfo['user_store_address'];
		$this->ajaxreturn($suminfo,'JSON');
	}

	//我的订单（全部）
	public function myorder(){
		//实例化
		$order = M('order');
		$orderdetail = M('orderdetail');
		$file = M('file');
		$good = M('good');
		$good_attr = M('good_attr');
		//接收数据
		$where1['user_id'] = I('get.user_id','','strip_tags');
		//查询数据-
		// $map['order_grade'] = 1;
		$orderinfo = $order->where($where1)->order('order_addtime desc')->select();
		// dump($orderinfo);exit;
		foreach($orderinfo as $k=>$v){
			//查找订单的详情
			$where2['order_id'] = $v['id'];
			$orderdetailinfo = $orderdetail->where($where2)->select();
			// dump($orderdetailinfo);
			//商品的信息
			foreach($orderdetailinfo as $ke=>$va){
				$where3['id'] = $va['good_id'];
				$where4['id'] = $va['good_attr_id'];
				$where5['good_attr_id'] = $va['good_attr_id'];
				$goodinfo = $good->where($where3)->find();
				$good_attrinfo = $good_attr->where($where4)->find();
				$fileinfo = $file->where($where5)->find();

				$shop[$k]['name']                         = $v['id'];
				$shop[$k]['store_id']                     = $v['store_id'];
				$shop[$k]['date'][$ke]['good_pic']        = $fileinfo['file_pic'];
				$shop[$k]['date'][$ke]['good_name']       = $goodinfo['good_name'];
				$shop[$k]['date'][$ke]['good_attr_des']   = $good_attrinfo['good_attr_num'];
				if($good_attrinfo['good_attr_price1']){
					$shop[$k]['date'][$ke]['good_attr_price'] = $good_attrinfo['good_attr_price1'];
				}else{
					$shop[$k]['date'][$ke]['good_attr_price'] = $good_attrinfo['good_attr_price'];
				}
				$shop[$k]['date'][$ke]['good_attr_color'] = $good_attrinfo['good_attr_color'];
				$shop[$k]['date'][$ke]['good_attr_size']  = $good_attrinfo['good_attr_size'];
				$shop[$k]['date'][$ke]['good_num']        = $va['good_num'];
				$shop[$k]['date'][$ke]['order_grade']     = $v['order_grade'];
				
			}
		}
		// dump($shop);exit;
  		//分页
	    if($shop){
	        //第几页
	        if($_GET['p']){
	          $p = I('get.p','','strip_tags');
	        }
	        //每页几条数据
	        if(empty($_GET['len'])){
	          $len = 10;
	        }else{
	          $len = $_GET['len'];
	        }
	        $first = 0+$len*($p-1);
	        $shop = array_slice($shop,$first,$len);
	        $info['code'] = '200';
	        $info['shop'] = $shop;
	    }else{
	        $info['code'] = '400';
	        $info['errmsg'] = "没有订单";
	    }
  		$this->ajaxreturn($info,'JSON');
  	}

	//我的订单（未支付）
	public function myorder1(){
		//实例化
		$order = M('order');
		$orderdetail = M('orderdetail');
		$file = M('file');
		$good = M('good');
		$good_attr = M('good_attr');
		//接收数据
		$where1['user_id'] = I('get.user_id','','strip_tags');
		//查询数据-
		$map['order_grade'] = 1;
		$orderinfo = $order->where($where1)->where($map)->order('order_addtime desc')->select();
		// dump($orderinfo);exit;
		foreach($orderinfo as $k=>$v){
			//查找订单的详情
			$where2['order_id'] = $v['id'];
			$orderdetailinfo = $orderdetail->where($where2)->select();
			// dump($orderdetailinfo);
			//商品的信息
			foreach($orderdetailinfo as $ke=>$va){
				$where3['id'] = $va['good_id'];
				$where4['id'] = $va['good_attr_id'];
				$where5['good_attr_id'] = $va['good_attr_id'];
				$goodinfo = $good->where($where3)->find();
				$good_attrinfo = $good_attr->where($where4)->find();
				$fileinfo = $file->where($where5)->find();

				$shop[$k]['name']                         = $v['id'];
				$shop[$k]['store_id']                     = $v['store_id'];
				$shop[$k]['date'][$ke]['good_pic']        = $fileinfo['file_pic'];
				$shop[$k]['date'][$ke]['good_name']       = $goodinfo['good_name'];
				$shop[$k]['date'][$ke]['good_attr_des']   = $good_attrinfo['good_attr_num'];
				if($good_attrinfo['good_attr_price1']){
					$shop[$k]['date'][$ke]['good_attr_price'] = $good_attrinfo['good_attr_price1'];
				}else{
					$shop[$k]['date'][$ke]['good_attr_price'] = $good_attrinfo['good_attr_price'];
				}
				$shop[$k]['date'][$ke]['good_attr_color'] = $good_attrinfo['good_attr_color'];
				$shop[$k]['date'][$ke]['good_attr_size']  = $good_attrinfo['good_attr_size'];
				$shop[$k]['date'][$ke]['good_num']        = $va['good_num'];
				$shop[$k]['date'][$ke]['order_grade']     = $v['order_grade'];
				
			}
		}
		// dump($shop);exit;
  		//分页
	    if($shop){
	        //第几页
	        if($_GET['p']){
	          $p = I('get.p','','strip_tags');
	        }
	        //每页几条数据
	        if(empty($_GET['len'])){
	          $len = 10;
	        }else{
	          $len = $_GET['len'];
	        }
	        $first = 0+$len*($p-1);
	        $shop = array_slice($shop,$first,$len);
	        $info['code'] = '200';
	        $info['shop'] = $shop;
	    }else{
	        $info['code'] = '400';
	        $info['errmsg'] = "没有订单";
	    }
  		$this->ajaxreturn($info,'JSON');
  	}

	//我的订单（未发货）
	public function myorder2(){
		//实例化
		$order = M('order');
		$orderdetail = M('orderdetail');
		$file = M('file');
		$good = M('good');
		$good_attr = M('good_attr');
		//接收数据
		$where1['user_id'] = I('get.user_id','','strip_tags');
		//查询数据-
		$map['order_grade'] = 2;
		$orderinfo = $order->where($where1)->where($map)->order('order_addtime desc')->select();
		// dump($orderinfo);
		foreach($orderinfo as $k=>$v){
			//查找订单的详情
			$where2['order_id'] = $v['id'];
			$orderdetailinfo = $orderdetail->where($where2)->select();
			// dump($orderdetailinfo);exit;
			//商品的信息
			foreach($orderdetailinfo as $ke=>$va){
				$where3['id'] = $va['good_id'];
				$where4['id'] = $va['good_attr_id'];
				$where5['good_attr_id'] = $va['good_attr_id'];
				$goodinfo = $good->where($where3)->find();
				$good_attrinfo = $good_attr->where($where4)->find();
				$fileinfo = $file->where($where5)->find();
				// dump($goodinfo);
				// dump($good_attrinfo);
				// dump($fileinfo);exit;
				$shop[$k]['name']                         = $v['id'];
				$shop[$k]['store_id']                     = $v['store_id'];
				$shop[$k]['date'][$ke]['good_pic']        = $fileinfo['file_pic'];
				$shop[$k]['date'][$ke]['good_name']       = $goodinfo['good_name'];
				$shop[$k]['date'][$ke]['good_attr_des']   = $good_attrinfo['good_attr_num'];
				$shop[$k]['date'][$ke]['good_attr_price'] = $orderdetailinfo[$ke]['good_attr_price'];
				$shop[$k]['date'][$ke]['good_attr_color'] = $good_attrinfo['good_attr_color'];
				$shop[$k]['date'][$ke]['good_attr_size']  = $good_attrinfo['good_attr_size'];
				$shop[$k]['date'][$ke]['good_num']        = $va['good_num'];
				$shop[$k]['date'][$ke]['order_grade']     = $v['order_grade'];
				
			}
		}
  		//分页
	    if($shop){
	        //第几页
	        if($_GET['p']){
	          $p = I('get.p','','strip_tags');
	        }
	        //每页几条数据
	        if(empty($_GET['len'])){
	          $len = 10;
	        }else{
	          $len = $_GET['len'];
	        }
	        $first = 0+$len*($p-1);
	        $shop = array_slice($shop,$first,$len);
	        $info['code'] = '200';
	        $info['shop'] = $shop;
	    }else{
	        $info['code'] = '400';
	        $info['errmsg'] = "没有订单";
	    }
  		$this->ajaxreturn($info,'JSON');
  	}

	//我的订单（已发货）
	public function myorder3(){
		//实例化
		$order = M('order');
		$orderdetail = M('orderdetail');
		$file = M('file');
		$good = M('good');
		$good_attr = M('good_attr');
		//接收数据
		$where1['user_id'] = I('get.user_id','','strip_tags');
		//查询数据-
		$map['order_grade'] = 3;
		$orderinfo = $order->where($where1)->where($map)->order('order_addtime desc')->select();
		// dump($orderinfo);exit;
		foreach($orderinfo as $k=>$v){
			//查找订单的详情
			$where2['order_id'] = $v['id'];
			$orderdetailinfo = $orderdetail->where($where2)->select();
			// dump($orderdetailinfo);
			//商品的信息
			foreach($orderdetailinfo as $ke=>$va){
				$where3['id'] = $va['good_id'];
				$where4['id'] = $va['good_attr_id'];
				$where5['good_attr_id'] = $va['good_attr_id'];
				$goodinfo = $good->where($where3)->find();
				$good_attrinfo = $good_attr->where($where4)->find();
				$fileinfo = $file->where($where5)->find();
				// dump($goodinfo);
				// dump($good_attrinfo);
				// dump($fileinfo);exit;
				$shop[$k]['name'] 						  = $v['id'];
				$shop[$k]['store_id']                     = $v['store_id'];
				$shop[$k]['date'][$ke]['good_pic']		  = $fileinfo['file_pic'];
				$shop[$k]['date'][$ke]['good_name']		  = $goodinfo['good_name'];
				$shop[$k]['date'][$ke]['good_attr_des']   = $good_attrinfo['good_attr_num'];
				$shop[$k]['date'][$ke]['good_attr_price'] = $orderdetailinfo[$ke]['good_attr_price'];
				$shop[$k]['date'][$ke]['good_attr_color'] = $good_attrinfo['good_attr_color'];
				$shop[$k]['date'][$ke]['good_attr_size']  = $good_attrinfo['good_attr_size'];
				$shop[$k]['date'][$ke]['good_num']		  = $va['good_num'];
				$shop[$k]['date'][$ke]['order_grade']	  = $v['order_grade'];
				
			}
		}
  		//分页
	    if($shop){
	        //第几页
	        if($_GET['p']){
	          $p = I('get.p','','strip_tags');
	        }
	        //每页几条数据
	        if(empty($_GET['len'])){
	          $len = 10;
	        }else{
	          $len = $_GET['len'];
	        }
	        $first = 0+$len*($p-1);
	        $shop = array_slice($shop,$first,$len);
	        $info['code'] = '200';
	        $info['shop'] = $shop;
	    }else{
	        $info['code'] = '400';
	        $info['errmsg'] = "没有订单";
	    }
  		$this->ajaxreturn($info,'JSON');
  	}

	//我的订单（已签收）
	public function myorder4(){
		//实例化
		$order = M('order');
		$orderdetail = M('orderdetail');
		$file = M('file');
		$good = M('good');
		$good_attr = M('good_attr');
		//接收数据
		$where1['user_id'] = I('get.user_id','','strip_tags');
		//查询数据-
		$map['order_grade'] = 4;
		$orderinfo = $order->where($where1)->where($map)->order('order_addtime desc')->select();
		// dump($orderinfo);exit;
		foreach($orderinfo as $k=>$v){
			//查找订单的详情
			$where2['order_id'] = $v['id'];
			$orderdetailinfo = $orderdetail->where($where2)->select();
			// dump($orderdetailinfo);
			//商品的信息
			foreach($orderdetailinfo as $ke=>$va){
				$where3['id'] = $va['good_id'];
				$where4['id'] = $va['good_attr_id'];
				$where5['good_attr_id'] = $va['good_attr_id'];
				$goodinfo = $good->where($where3)->find();
				$good_attrinfo = $good_attr->where($where4)->find();
				$fileinfo = $file->where($where5)->find();
				// dump($goodinfo);
				// dump($good_attrinfo);
				// dump($fileinfo);exit;
				$shop[$k]['name'] 						  = $v['id'];
				$shop[$k]['store_id']                     = $v['store_id'];
				$shop[$k]['date'][$ke]['good_pic'] 		  = $fileinfo['file_pic'];
				$shop[$k]['date'][$ke]['good_name'] 	  = $goodinfo['good_name'];
				$shop[$k]['date'][$ke]['good_attr_des']   = $good_attrinfo['good_attr_num'];
				$shop[$k]['date'][$ke]['good_attr_price'] = $orderdetailinfo[$ke]['good_attr_price'];
				$shop[$k]['date'][$ke]['good_attr_color'] = $good_attrinfo['good_attr_color'];
				$shop[$k]['date'][$ke]['good_attr_size']  = $good_attrinfo['good_attr_size'];
				$shop[$k]['date'][$ke]['good_num'] 		  = $va['good_num'];
				$shop[$k]['date'][$ke]['order_grade'] 	  = $v['order_grade'];
				
			}
		}
  		//分页
	    if($shop){
	        //第几页
	        if($_GET['p']){
	          $p = I('get.p','','strip_tags');
	        }
	        //每页几条数据
	        if(empty($_GET['len'])){
	          $len = 10;
	        }else{
	          $len = $_GET['len'];
	        }
	        $first = 0+$len*($p-1);
	        $shop = array_slice($shop,$first,$len);
	        $info['code'] = '200';
	        $info['shop'] = $shop;
	    }else{
	        $info['code'] = '400';
	        $info['errmsg'] = "没有订单";
	    }
  		$this->ajaxreturn($info,'JSON');
  	}

	//我的订单（以评价）
	public function myorder5(){
		//实例化
		$order = M('order');
		$orderdetail = M('orderdetail');
		$file = M('file');
		$good = M('good');
		$good_attr = M('good_attr');
		//接收数据
		$where1['user_id'] = I('get.user_id','','strip_tags');
		//查询数据-
		$map['order_grade'] = 5;
		$orderinfo = $order->where($where1)->where($map)->order('order_addtime desc')->select();
		// dump($orderinfo);exit;
		foreach($orderinfo as $k=>$v){
			//查找订单的详情
			$where2['order_id'] = $v['id'];
			$orderdetailinfo = $orderdetail->where($where2)->select();
			// dump($orderdetailinfo);
			//商品的信息
			foreach($orderdetailinfo as $ke=>$va){
				$where3['id'] = $va['good_id'];
				$where4['id'] = $va['good_attr_id'];
				$where5['good_attr_id'] = $va['good_attr_id'];
				$goodinfo = $good->where($where3)->find();
				$good_attrinfo = $good_attr->where($where4)->find();
				$fileinfo = $file->where($where5)->find();
				// dump($goodinfo);
				// dump($good_attrinfo);
				// dump($fileinfo);exit;
				$shop[$k]['name']						  = $v['id'];
				$shop[$k]['store_id']                     = $v['store_id'];
				$shop[$k]['date'][$ke]['good_pic'] 		  = $fileinfo['file_pic'];
				$shop[$k]['date'][$ke]['good_name'] 	  = $goodinfo['good_name'];
				$shop[$k]['date'][$ke]['good_attr_des']   = $good_attrinfo['good_attr_num'];
				$shop[$k]['date'][$ke]['good_attr_price'] = $orderdetailinfo[$ke]['good_attr_price'];
				$shop[$k]['date'][$ke]['good_attr_color'] = $good_attrinfo['good_attr_color'];
				$shop[$k]['date'][$ke]['good_attr_size']  = $good_attrinfo['good_attr_size'];
				$shop[$k]['date'][$ke]['good_num'] 		  = $va['good_num'];
				$shop[$k]['date'][$ke]['order_grade'] 	  = $v['order_grade'];
				
			}
		}
  		//分页
	    if($shop){
	        //第几页
	        if($_GET['p']){
	          $p = I('get.p','','strip_tags');
	        }
	        //每页几条数据
	        if(empty($_GET['len'])){
	          $len = 10;
	        }else{
	          $len = $_GET['len'];
	        }
	        $first = 0+$len*($p-1);
	        $shop = array_slice($shop,$first,$len);
	        $info['code'] = '200';
	        $info['shop'] = $shop;
	    }else{
	        $info['code'] = '400';
	        $info['errmsg'] = "没有订单";
	    }
  		$this->ajaxreturn($info,'JSON');
  	}  	

  	//我的订单(确认收货)
  	public function takegoods(){
  		//实例化
  		$order = M('order');
  		//接收值
  		$id = I('get.id','','strip_tags');
        //更改数据、
        $data['order_grade'] = 4;
       	$info1 = $order->where("id=$id")->save($data);
       	// dump($info1);exit;
        if($info1){
            $info['sucmsg'] = '订单完成';
            $info['code'] = 1;
        }else{
            $info['errmsg'] = '操作失败';
            $info['code'] = 0;
        }
        $this->ajaxreturn($info,'JSON');
  	}

//============================================评论========================================

  	//发表品论
  	public function evaluate(){
  		//实例化
  		$evaluate 	   = M('evaluate');
  		$evaluate_pics = M('evaluate_pics');
  		$order 	       = M('order');
  		$orderdetail   = M('orderdetail');
  		//接收数据
  		$json = I('get.json','','strip_tags');
  		$jsoninfo = json_decode($json,true);
  		// dump($jsoninfo);exit;
		// $data['pid']           = 0;
		$data['good_id']       = $jsoninfo['good_id'];
		$data['good_attr_id']  = $jsoninfo['good_attr_id'];
		$data['store_id']      = $jsoninfo['store_id'];
		$data['user_id']       = $jsoninfo['user_id'];
		$data['content']       = $jsoninfo['content'];
		$data['evaluate_star'] = $jsoninfo['evaluate_star'];
		$data['add_time']      = date('Y-m-d H:i:s');
		//插入语品论表
		$addevaluate = $evaluate->add($data);
		// dump($addevaluate);
		//有刚刚添加的评论中商品属性id，找订单详情订单id，改状态
		$laseevaluate = $evaluate->order("id desc")->find();
		$where1['good_attr_id'] = $laseevaluate['good_attr_id'];
		// dump($laseevaluate);
		$orderdetailinfo = $orderdetail->where($where1)->select();
		$len1 = count($order0info);
		// dump($len1);
		// dump($orderdetailinfo);
		if($len1  < 2){
			foreach($orderdetailinfo as $k=>$v){
				$where2['id'] = $v['order_id'];
				$date['order_grade'] = 5;
				$orderinfo = $order->where($where2)->save($date);
				// dump($orderinfo);exit;
			}
		}
		if($addevaluate && $orderinfo == 1){
			$picinfo = $jsoninfo['url'];
	  		foreach($picinfo as $k=>$v){
	  			$dada['evaluate_id'] = $addevaluate;
	  			$dada['evaluate_pic'] = $v['url'];
	  			$evaluate_picsinfo[$k] = $evaluate_pics->add($dada);
	  			if(empty($evaluate_picsinfo[$k])){
					$info['errmsg'] = '品论失败';
					$info['code'] = 0;
				}else{
					$info['sucmsg'] = '品论成功';
					$info['code'] = 1;					
				}
	  		}
		}else{
			$info['errmsg'] = '品论失败';
			$info['code'] = 0;			
		}
		$this->ajaxreturn($info,'JSON');
  	}

  	//商品评价
  	public function allevaluate(){
  		//实例化
  		$user = M('user');
  		$good = M('good');
  		$good_attr = M('good_attr');
  		$evaluate = M('evaluate');
  		$evaluate_pics = M('evaluate_pics');
  		$evaluate_giveup = M('evaluate_giveup');
  		//接收数据
  		$where1['good_id'] = I('get.good_id','','strip_tags');
  		$where1['store_id'] = I('get.store_id','','strip_tags');
  		$map1['pid'] = 0;

  		//通过商品id查询pid为0的评价
  		$evaluateinfo = $evaluate->where($where1)->where($map1)->select();
  		// dump($evaluateinfo);
  		foreach($evaluateinfo as $k=>$v){
	  		//查询商品属性
	  		$where2['id'] = $v['good_attr_id'];
	  		$good_attrinfo[$k] = $good_attr->where($where2)->field('good_attr_color,good_attr_size')->find();
	  		// dump($good_attrinfo);
	  		//查询品论人和头像
	  		$where3['id'] = $v['user_id'];
	  		$userinfo[$k] = $user->where($where3)->field('user_pic,user_name')->find();			
	  		// 查询品论的图片
	  		$where4['evaluate_id'] = $v['id'];
	  		$evaluate_picinfo[] = $evaluate_pics->where($where4)->select();
	  		// dump($evaluate_picinfo);exit;
	  		// 查询回复的信息条数
	  		$arr = $evaluate->field('id,pid')->select();
	  		$id = $v['id'];
	  		$evaluatepid[$k] = $this->subtrr($arr,$id);
	  		$evaluatelen[$k] = count($evaluatepid[$k]);
	  		//点赞量
	  		$where5['evaluate_id'] = $v['id'];
	  		$giveups[$k] = $evaluate_giveup->where($where5)->count();
  		}
  		//合并
  		foreach($evaluate_picinfo as $k=>$v){
  			foreach($v as $ke=>$va){
		  		$shop[$k]['id']              = $evaluateinfo[$k]['id'];	
		  		$shop[$k]['user_name']       = $userinfo[$k]['user_name'];	
		  		$shop[$k]['user_pic']        = $userinfo[$k]['user_pic'];	
		  		$shop[$k]['good_attr_color'] = $good_attrinfo[$k]['good_attr_color'];	
		  		$shop[$k]['good_attr_size']  = $good_attrinfo[$k]['good_attr_size'];		  			
		  		$shop[$k]['add_time']        = $evaluateinfo[$k]['add_time'];	  			
		  		$shop[$k]['evaluatelen']     = $evaluatelen[$k];
		  		$shop[$k]['giveup']          = $giveups[$k];
		  		$shop[$k]['pic'][]['url']    = $va['evaluate_pic'];
  			}
  		}
  		//分页
	    if($shop){
	        //第几页
	        if($_GET['p']){
	          $p = I('get.p','','strip_tags');
	        }
	        //每页几条数据
	        if(empty($_GET['len'])){
	          $len = 10;
	        }else{
	          $len = $_GET['len'];
	        }
	        $first = 0+$len*($p-1);
	        $shop = array_slice($shop,$first,$len);
	        $info['code'] = '200';
	        $info['shop'] = $shop;
	    }else{
	        $info['code'] = '400';
	        $info['errmsg'] = "请求失败";
	    }
  		$this->ajaxreturn($info,'JSON');
  	}

  	//评价回复页面
  	public function relyevaluate(){
  		//实例化
  		$evaluate      = M('evaluate');
  		$user          = M('user');
  		// $good          = M('good');
  		// $good_attr     = M('good_attr');
  		// $evaluate_pics = M('evaluate_pics');
  		$evaluate_giveup = M('evaluate_giveup');
  		//接收值
		$where1['id'] = $id = I('get.id','','strip_tags');
		//查询数据
		// $evaluateinfo = $evaluate->where($where1)->find();
		// dump($evaluateinfo);
  		//查询商品属性
  		// $where2['id'] = $evaluateinfo['good_attr_id'];
  		// $good_attrinfo = $good_attr->where($where2)->field('good_attr_color,good_attr_size')->find();
  		// dump($good_attrinfo);
  		//查询品论人和头像
  		// $where3['id'] = $evaluateinfo['user_id'];
  		// $userinfo = $user->where($where3)->field('user_pic,user_name')->find();	
  		// dump($userinfo);		
  		// 查询品论的图片
  		// $where4['evaluate_id'] = $evaluateinfo['id'];
  		// $evaluate_picinfo = $evaluate_pics->where($where4)->select();
  		// dump($evaluate_picinfo);
  		//点赞量
  		// $giveups = $evaluate_giveup->where($where4)->count();
  		// dump($giveups);
  		//回复人在评价表中的信息
  		$arr = $evaluate->field('id,pid,content')->select();
  		$evaluatepid = $this->subtrr($arr,$id);
  		// dump($evaluatepid);exit;
  		foreach($evaluatepid as $k=>$v){
  			//回复的内容和时间
  			$where5['id'] = $v['id'];
  			$relyuser1 = $evaluate->where($where5)->field('user_id,add_time,content')->find();
  			// dump($relyuser1);
  			//回复人名称
  			$where6['id'] = $relyuser1['user_id'];
  			$relyuser2 = $user->where($where6)->field('id,user_name')->find();
  			// dump($relyuser2);
  			//被回复人名称
  			$where7['id'] = $v['pid'];
  			$relyuser3 = $evaluate->where($where7)->field('user_id')->find();
  			$where8['id'] = $relyuser3['user_id'];
  			$relyuser4 = $user->where($where8)->field('id,user_name')->find();  		
  			// dump($relyuser4);
  			$relyinfo[$k]['add_time']    = $relyuser1['add_time'];
  			$relyinfo[$k]['content']     = $relyuser1['content'];
  			$relyinfo[$k]['user_name']   = $relyuser2['user_name'];
  			$relyinfo[$k]['user_id']     = $relyuser2['id'];
  			$relyinfo[$k]['user_id1']    = $relyuser4['id'];
  			$relyinfo[$k]['user_name1']  = $relyuser4['user_name'];
  		}
  		// //合并
  		// $shop['info']['user_pic']          = $userinfo['user_pic'];
  		// $shop['info']['user_name']         = $userinfo['user_name'];
  		// $shop['info']['good_attr_color']   = $good_attrinfo['good_attr_color'];
  		// $shop['info']['good_attr_size']    = $good_attrinfo['good_attr_size'];
  		// $shop['info']['pic'] 			   = $evaluate_picinfo;
  		// $shop['rele']			           = $relyinfo;

  		//分页
	    if($relyinfo){
	        //第几页
	        if($_GET['p']){
	          $p = I('get.p','','strip_tags');
	        }
	        //每页几条数据
	        if(empty($_GET['len'])){
	          $len = 10;
	        }else{
	          $len = $_GET['len'];
	        }
	        $first = 0+$len*($p-1);
	        $relyinfo = array_slice($relyinfo,$first,$len);
	        $info['code'] = '200';
	        $info['relyinfo'] = $relyinfo;
	    }else{
	        $info['code'] = '400';
	        $info['errmsg'] = "请求失败";
	    }
  		$this->ajaxreturn($info,'JSON');
  	}

  	//回复评价回复
  	public function relyback(){
  		//实例化
  		$evaluate = M('evaluate');
  		//接收数据
  		$json = I('get.json','','strip_tags');
  		$jsoninfo = json_decode($json,true);
  		// dump($jsoninfo);

		$data['pid']           = $jsoninfo['pid'];
		$data['good_id']       = $jsoninfo['good_id'];
		$data['good_attr_id']  = $jsoninfo['good_attr_id'];
		$data['store_id']      = $jsoninfo['store_id'];
		$data['user_id']       = $jsoninfo['user_id'];
		$data['content']       = $jsoninfo['content'];
		$data['add_time']      = date('Y-m-d H:i:s');
		$evaluateinfo = $evaluate->add($data);
		if(empty($evaluateinfo)){
			$info['errmsg'] = '品论失败';
			$info['code'] = 0;
		}else{
			$info['sucmsg'] = '品论成功';
			$info['code'] = 1;					
		}			
		$this->ajaxreturn($info,'JSON');
  	}
}

