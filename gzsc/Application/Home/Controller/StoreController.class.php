<?php
namespace Home\Controller;
use Think\Controller;
class StoreController extends Controller {

    //商铺首页(商铺信息)
    public function store1(){
        //实例化
        $user = M('user');
        //查询数据
        $where['id'] = I('get.store_id','','strip_tags');
        $info = $user->where($where)->field('user_store_name,user_store_headerpic,user_store_address,user_store_phone,user_store_evaluate')->find();
        if($info){
            $info11['code'] = '200';
            $info11['sucmsg'] = $info;       
        }else{
            $info11['code'] = '400';
            $info11['msg']  = "请求失败";            
        }
        $this->ajaxreturn($info11,'JSON');   
    }

    //商铺首页(商品)
    public function store(){
        //实例化
        $good = M('good');
        $file = M('file');
        $orderdetail = M('orderdetail');

        //接收值
        $where['user_id'] = I('get.store_id','','strip_tags');
        //查询数据
        $goodinfo = $good->where($where)->select();
        foreach($goodinfo as $k=>$v){
            $map1['good_id'] = $v['id'];
            $fileinfo = $file->where($map1)->field('file_pic')->find();
            $goodinfo[$k]['file_pic'] = $fileinfo['file_pic'];
            $orderdetailinfo = $orderdetail->where($map1)->select();
            $goodinfo[$k]['num'] = 0;
            foreach($orderdetailinfo as $ke=>$va){
                $goodinfo[$k]['num'] += $va['good_num'];
            }
        }
        //商品的状态,排除商品的下架情况
        foreach($goodinfo as $k=>$v){
            if($v['good_state'] == 1){
            unset($goodinfo[$k]);
            }
        }
        //排序
        $sort = array(  
                'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
                'field'     => 'num',       //排序字段  
        );  
        $arrSort = array();  
        foreach($goodinfo AS $uniqid => $row){  
            foreach($row AS $key=>$value){  
                $arrSort[$key][$uniqid] = $value;  
            }  
        }  
        if($sort['direction']){  
            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $goodinfo);  
        }  
 

        if($goodinfo){
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
            $goodinfo = array_slice($goodinfo,$first,$len);               
            $info11['code'] = '200';
            $info11['sucmsg'] = $goodinfo;       
        }else{
            $info11['code'] = '400';
            $info11['msg']  = "请求失败";            
        }
        $this->ajaxreturn($info11,'JSON');        
    }

    //店家信息
    public function storedetail(){
        //实例化
        $user = M('user');
        //接收值
        $where['id'] = I('get.store_id','','strip_tags');
        //查询数据
        $storeinfo = $user->where($where)->field('user_store_headerpic,user_store_name,user_store_lience,user_store_registered,user_store_cash')->find();
        if($storeinfo){
            $info['code'] = '200';
            $info['sucmsg'] = $storeinfo;
        }else{
            $info['code'] = '400';
            $info['errmsg']  = "请求失败";            
        }
        $this->ajaxreturn($info,'JSON');
    }

    //店铺全部商品(综合)
    public function allgoods(){
        //实例化
        $user = M('user');
        $good = M('good');
        $good_attr = M('good_attr');
        $file = M('file');
        $rele = M('rele');
        $orderdetail = M('orderdetail');
        //接收数据
        $where1['user_id'] = $id = I('get.store_id','','strip_tags');
        //查询所有商品
        $info = $good->where($where1)->select();
        //商品的状态,排除商品的下架情况
        foreach($info as $k=>$v){
            if($v['good_state'] == 1){
            unset($info[$k]);
            }
        }
        //计算月销售量
        $begintime=date('Y-m-d H:i:s',mktime(0,0,0,date('m'),1,date('Y')));
        $endtime=date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('t'),date('Y')));
        $where3['orderdetail_time'] = array('BETWEEN', array($begintime,$endtime));
        foreach($info as $k=>$v){
            $map2['good_id'] = $v['id'];
          //有商品的id通过订单属性表查找订单的id和购买的数量
          $info1 = $orderdetail->where($map2)->where($where3)->field('order_id,good_num')->select();
          // dump($info);
          // dump($map2);
          // dump($info1);exit;
          $info[$k]['good_num'] = 0;
          foreach($info1 as $ke=>$va){
            // $where5['id'] = $va['order_id'];
            // $where5['order_grade'] = 4;//商品是否订单完成
            // $info2 = $order->where($where5)->find();
            // dump($info2);exit;
            // if(empty($info2)){ 
            //  $info[$k]['good_num'] = 0;
            // }else{
              $info[$k]['good_num'] += $va['good_num'];
            // }      
          }
        }
        // dump($info);exit;
        //添加商品的信息（第一个属性信息和第一个属性下的第一个文件信息）
        foreach($info as $k=>$v){
            $where4['good_id'] = $v['id'];
            //搜索关联表信息
            $info1 = $rele->where($where4)->select();
            //搜索第一条属性信息添加价格和描述
            $map2['id'] = $info1['0']['good_attr_id'];
            $info2 = $good_attr->where($map2)->field('good_attr_price,good_attr_des,good_attr_price1')->find();
            if($info2['good_attr_price1']){
                $info[$k]['good_attr_price'] = $info2['good_attr_price1'];
            }else{
            $info[$k]['good_attr_price'] = $info2['good_attr_price'];
        }
            $info[$k]['good_attr_des'] = $info2['good_attr_des'];
            //添加一张图片
            $map3['id'] = $info1['0']['file_id'];
            $info3 = $file->where($map3)->field('file_pic')->find();
            //拼接图片的路径
            $info[$k]['file_pic'] = $info3['file_pic'];
      }
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
      $info = array_slice($info,$first,$len);
      
      // dump($info);exit;
      // echo (json_encode($info));exit;
      $this->ajaxreturn($info,'JSON');  
    }

    //店铺全部商品(销量)
    public function allgoods1(){
        //实例化
        $user = M('user');
        $good = M('good');
        $good_attr = M('good_attr');
        $file = M('file');
        $rele = M('rele');
        $orderdetail = M('orderdetail');
        //接收数据
        $where1['user_id'] = $id = I('get.store_id','','strip_tags');
        //查询所有商品
        $info = $good->where($where1)->select();
        //商品的状态,排除商品的下架情况
        foreach($info as $k=>$v){
            if($v['good_state'] == 1){
            unset($info[$k]);
            }
        }
        //计算月销售量
        $begintime=date('Y-m-d H:i:s',mktime(0,0,0,date('m'),1,date('Y')));
        $endtime=date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('t'),date('Y')));
        $where3['orderdetail_time'] = array('BETWEEN', array($begintime,$endtime));
        foreach($info as $k=>$v){
            $map2['good_id'] = $v['id'];
          //有商品的id通过订单属性表查找订单的id和购买的数量
          $info1 = $orderdetail->where($map2)->where($where3)->field('order_id,good_num')->select();
          // dump($info);
          // dump($map2);
          // dump($info1);exit;
          $info[$k]['good_num'] = 0;
          foreach($info1 as $ke=>$va){
            // $where5['id'] = $va['order_id'];
            // $where5['order_grade'] = 4;//商品是否订单完成
            // $info2 = $order->where($where5)->find();
            // dump($info2);exit;
            // if(empty($info2)){ 
            //  $info[$k]['good_num'] = 0;
            // }else{
              $info[$k]['good_num'] += $va['good_num'];
            // }      
          }
        }
        // dump($info);exit;
        //添加商品的信息（第一个属性信息和第一个属性下的第一个文件信息）
        foreach($info as $k=>$v){
            $where4['good_id'] = $v['id'];
            //搜索关联表信息
            $info1 = $rele->where($where4)->select();
            //搜索第一条属性信息添加价格和描述
            $map2['id'] = $info1['0']['good_attr_id'];
            $info2 = $good_attr->where($map2)->field('good_attr_price,good_attr_des,good_attr_price1')->find();
            if($info2['good_attr_price1']){
                $info[$k]['good_attr_price'] = $info2['good_attr_price1'];
            }else{
            $info[$k]['good_attr_price'] = $info2['good_attr_price'];
        }
            $info[$k]['good_attr_des'] = $info2['good_attr_des'];
            //添加一张图片
            $map3['id'] = $info1['0']['file_id'];
            $info3 = $file->where($map3)->field('file_pic')->find();
            //拼接图片的路径
            $info[$k]['file_pic'] = $info3['file_pic'];
        }
        //按照销售量倒序待续
        $sort = array(  
                'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
                'field'     => 'num',       //排序字段  
        );  
        $arrSort = array();  
        foreach($info AS $uniqid => $row){  
            foreach($row AS $key=>$value){  
                $arrSort[$key][$uniqid] = $value;  
            }  
        }  
        if($sort['direction']){  
            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $info);  
        }  
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
        $info = array_slice($info,$first,$len);
          
          // dump($info);exit;
          // echo (json_encode($info));exit;
        $this->ajaxreturn($info,'JSON');  
    }

    //店铺全部商品(价格)
    public function allgoods2(){
        //实例化
        $user = M('user');
        $good = M('good');
        $good_attr = M('good_attr');
        $file = M('file');
        $rele = M('rele');
        $orderdetail = M('orderdetail');
        //接收数据
        $where1['user_id'] = $id = I('get.store_id','','strip_tags');
        //查询所有商品
        $info = $good->where($where1)->select();
        //商品的状态,排除商品的下架情况
        foreach($info as $k=>$v){
            if($v['good_state'] == 1){
            unset($info[$k]);
            }
        }
        //计算月销售量
        $begintime=date('Y-m-d H:i:s',mktime(0,0,0,date('m'),1,date('Y')));
        $endtime=date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('t'),date('Y')));
        $where3['orderdetail_time'] = array('BETWEEN', array($begintime,$endtime));
        foreach($info as $k=>$v){
            $map2['good_id'] = $v['id'];
          //有商品的id通过订单属性表查找订单的id和购买的数量
          $info1 = $orderdetail->where($map2)->where($where3)->field('order_id,good_num')->select();
          $info[$k]['good_num'] = 0;
          foreach($info1 as $ke=>$va){
                $info[$k]['good_num'] += $va['good_num'];    
            }
        }
        //添加商品的信息（最便宜的价格属性信息和他属性下的第一个文件信息）
        foreach($info as $k=>$v){
            $where4['good_id'] = $v['id'];
            //搜索关联表信息
            $info1 = $rele->where($where4)->select();
            //搜索最便宜的价格属性信息添加价格和描述
            $info2 = $good_attr->where($where4)->field('id,good_attr_price,good_attr_des,good_attr_price1')->select();
            foreach($info2 as $ke=>$va){
                if($v['good_attr_price1']){
                    $info2[$ke]['good_attr_price'] = $va['good_attr_price1'];
                }else{
                    $info2[$ke]['good_attr_price'] = $va['good_attr_price'];
                }
            }
            //按照good_attr_price倒序待续
            $sort = array(  
                    'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
                    'field'     => 'good_attr_price',       //排序字段  
            );  
            $arrSort = array();  
            foreach($info2 AS $uniqid => $row){  
                foreach($row AS $key=>$value){  
                    $arrSort[$key][$uniqid] = $value;  
                }  
            }  
            if($sort['direction']){  
                array_multisort($arrSort[$sort['field']], constant($sort['direction']), $info2);  
            }
            //最便宜的商品属性
            $info3 = $info2[0];
            $wap1['good_attr_id'] = $info3['id'];
            $info4 = $file->where($wap1)->field('file_pic')->find();
            $info[$k]['good_attr_price'] = $info3['good_attr_price'];
            $info[$k]['good_attr_des']   = $info3['good_attr_des'];
            $info[$k]['good_attr_id']    = $info3['id'];
            $info[$k]['file_pic']        = $info4['file_pic'];
        }

        //按照价格正序待续
        $sort = array(  
                'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
                'field'     => 'good_attr_price',       //排序字段  
        );  
        $arrSort = array();  
        foreach($info AS $uniqid => $row){  
            foreach($row AS $key=>$value){  
                $arrSort[$key][$uniqid] = $value;  
            }  
        }  
        if($sort['direction']){  
            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $info);  
        }  
        // dump($info);exit;
        if($info){
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
            $info = array_slice($info,$first,$len);
            $infoa['code'] = '200';
            $infoa['allinfo'] = $info; 
        }else{
            $infoa['code'] = '400';
            $infoa['errmsg'] = "店铺还没有商品";
        }
        // dump($info);exit;
        // echo (json_encode($info));exit;
        $this->ajaxreturn($infoa,'JSON'); 
    }

    //店铺上新
    public function newgoods(){
        //实例化
        $user = M('user');
        $good = M('good');
        $good_attr = M('good_attr');
        $file = M('file');
        $rele = M('rele');
        //接收数据
        $where1['user_id'] = $id = I('get.store_id','','strip_tags');
        $map1['good_attr_state'] = 2;//商品的状态   1下架  2新品上架    3正常
        //查询所有商品
        $goodinfo = $good->where($where1)->select();
        //查找每个商品下的属性和图片
        foreach($goodinfo as $k=>$v){
            $where2['good_id'] = $v['id'];
            $good_attr_info = $good_attr->where($where2)->where($map1)->select();
            foreach($good_attr_info as $ke=>$va){
                $where3['good_attr_id'] = $va['id'];
                $good_file = $file->where($where3)->field('file_pic')->find();
                $good_attr_info[$ke]['good_attr_pic'] = $good_file['file_pic'];
                $good_attr_info[$ke]['good_name'] = $v['good_name'];
             }
            $info[] = $good_attr_info;
        }
        $allinfo = array();
        foreach($info as $k=>$v){
            foreach($v as $ke=>$va){
                $allinfo[] = $va;
            }
        }
        if($allinfo){
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
            $allinfo = array_slice($allinfo,$first,$len);
            $info1['code'] = '200';
            $info1['allinfo'] = $allinfo; 
        }else{
            $info1['code'] = '400';
            $info1['errmsg'] = "店铺还没有商品";
        }
        // dump($where1);exit;
        $this->ajaxreturn($info1,'JSON');
    }

    //店铺活动
    public function activity(){
        //实例化
        $good = M('good');
        $user = M('user');
        $file = M('file');
        $good_attr = M('good_attr');
        //接收数据
        $where1['user_id'] = $id = I('get.store_id','','strip_tags');
        //查询数据
        $goodinfo = $good->where($where1)->field('id,good_attr_discount')->select();
        foreach($goodinfo as $k=>$v){
            if(empty($v['good_attr_discount'])){
                unset($goodinfo[$k]);
            }else{
                $goodinfo1[] = $v; 
            }
        }
        //找张照片
        foreach($goodinfo1 as $k=>$v){
            $where2['good_id'] = $v['id'];
            $fileinfo = $file->where($where2)->field('file_pic')->find(); 
            $goodinfo1[$k]['pic'] = $fileinfo['file_pic']; 
        }
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
        $goodinfo1 = array_slice($goodinfo1,$first,$len);

        if($goodinfo1){
            $info['code'] = '200';
            $info['shop'] = $goodinfo1;        
        }else{
            $info['code'] = '400';
            $info['errmsg'] = "请求失败";
        }
        // dump($shop);exit;
        $this->ajaxReturn($info,'JSON');        
    }

    //店铺搜索页面
    public function searchstore(){
        //实例化
        $user = M('user');
        //查询条件$search['good_name'] = array('like',"%{$_GET['good_name']}%");
        if($_GET['user_store_name']){
            $where3['user_store_name'] = array('like',"%{$_GET['user_store_name']}%");
        }
        // $where1['user_store_name'] = 'shangdianyi';
        $where3['user_grade'] = 2;
        $shop = $user->where($where3)->field('user_grade,id,user_store_name,user_store_evaluate,user_store_pic,user_store_pic1,user_store_pic2,user_store_pic3,user_store_pic4,user_store_phone')->select();
        foreach($shop as $k=>$v){
            $shop[$k]['user_store_pic'] = $v['user_store_pic'];
            $shop[$k]['user_store_pic1'] = $v['user_store_pic1'];
            $shop[$k]['user_store_pic2'] = $v['user_store_pic2'];
            $shop[$k]['user_store_pic3'] = $v['user_store_pic3'];
            $shop[$k]['user_store_pic4'] = $v['user_store_pic4'];
        }

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

        if($shop){
            $info['code'] = '200';
            $info['shop'] = $shop;        
        }else{
            $info['code'] = '400';
            $info['errmsg'] = "请求失败";
        }
        // dump($shop);exit;
        $this->ajaxReturn($info,'JSON');        
    }

}