<?php
namespace Home\Controller;
use Think\Controller;
class DianshangController extends Controller {

  /**
   * 计算两点地理坐标之间的距离
   * @param  Decimal $longitude1 起点经度
   * @param  Decimal $latitude1  起点纬度
   * @param  Decimal $longitude2 终点经度 
   * @param  Decimal $latitude2  终点纬度
   * @param  Int     $unit       单位 1:米 2:公里
   * @param  Int     $decimal    精度 保留小数位数
   * @return Decimal
   */
    public function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=2){

        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $PI = 3.1415926;

        $radLat1 = $latitude1 * $PI / 180.0;
        $radLat2 = $latitude2 * $PI / 180.0;

        $radLng1 = $longitude1 * $PI / 180.0;
        $radLng2 = $longitude2 * $PI /180.0;

        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;

        $distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
        $distance = $distance * $EARTH_RADIUS * 1000;

        if($unit==2){
            $distance = $distance / 1000;
        }

        return round($distance, $decimal);

    }

  //电商首页
    public function indexaa(){
      //实例化表
      $user = M('user');
      $pics = M('pics');
      // 起点坐标
      if($_GET['lng'] == 0.0 && $_GET['lat'] == 0.0){
            $longitude1 = 113.947961;
            $latitude1  = 35.306758; 
        }else{
            $longitude1 = I('get.lng','','strip_tags');
            $latitude1  = I('get.lat','','strip_tags'); 
        }
      //附近商户
      $where3['user_grade'] = 2;
      $shop = $user->where($where3)->field('id,user_store_x,user_store_y,user_store_name,user_store_evaluate,user_store_pic,user_store_pic1,user_store_pic2,user_store_pic3,user_store_pic4,user_store_phone')->select();
      //计算距离
      foreach($shop as $k=>$v){
          $longitude2 = $v['user_store_x'];
          $latitude2  = $v['user_store_y'];
          $shop[$k]['distance'] = $this->getDistance($longitude1, $latitude1, $longitude2, $latitude2, 1);
      }   
      //排除距离大于5km的商户
      foreach($shop as $k=>$v){
        if($v['distance'] > 5000){
          unset($shop[$k]);
        }
      }
      //按照某个字段排序
      $sort = array(  
              'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
              'field'     => 'distance',       //排序字段  
      );  
      $arrSort = array();  
      foreach($shop AS $uniqid => $row){  
          foreach($row AS $key=>$value){  
              $arrSort[$key][$uniqid] = $value;  
          }  
      }  
      if($sort['direction']){  
          array_multisort($arrSort[$sort['field']], constant($sort['direction']), $shop);  
      }    
      foreach($shop as $k=>$v){
        $shop[$k]['user_store_pic'] = $v['user_store_pic'];
        $shop[$k]['user_store_pic1'] = $v['user_store_pic1'];
        $shop[$k]['user_store_pic2'] = $v['user_store_pic2'];
        $shop[$k]['user_store_pic3'] = $v['user_store_pic3'];
        $shop[$k]['user_store_pic4'] = $v['user_store_pic4'];
      }
      //头部的图片轮播
      foreach($shop as $k=>$v){
        $where1['store_id'] = $v['id'];
        $map1['pic_state']  = 1;
        $where1['pic_address'] = 1;  
        $headerpics[$k] = $pics->where($where1)->where($map1)->field('pic,pic_http,pic_descr')->select();     
      }
      foreach($headerpics as $k=>$v){
        foreach($v as $ke=>$va){
          $headerpicss[] = $va;
        }
      }
      //中部的图片轮播
      foreach($shop as $k=>$v){
        $where1['store_id'] = $v['id'];
        $map1['pic_state']  = 1;
        $where1['pic_address'] = 2;  
        $middlepics[$k] = $pics->where($where1)->where($map1)->field('pic,pic_http,pic_descr')->select();     
      }
      foreach($middlepics as $k=>$v){
        foreach($v as $ke=>$va){
          $middlepicss[] = $va;
        }
      }
      // dump($shop);
      // dump($headerpicss);
      // dump($middlepicss);exit;
      
      $res['headerpicss'] = $headerpicss;
      $res['middlepicss'] = $middlepicss;
      $res['shop'] = $shop;
      // dump($res);exit;
      if($res['shop']){
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
        $res['shop'] = array_slice($res['shop'],$first,$len);
        $info['code'] = '200';
        $info['res']['shop'] = $res['shop'];
      }else{
        $info['code'] = '400';
        $info['errmsg'] = "请求失败";
      }
      // echo (json_encode($info));exit;
      $this->ajaxReturn($res,'JSON');
    }

    //电商类目
    public function cate(){
      //实例化表
      $cate = M('cate');
      $good = M('good');
      //查询
      $where1['cate_name'] = '电商';
      $cate_id = $cate->where($where1)->field('id')->find();
      $where2['cate_pid'] = $cate_id['id'];
      $cateinfo = $cate->where($where2)->field('id,cate_name')->select();
      $info = array();
      foreach($cateinfo as $k=>$v){
        $where3['cate_pid'] = $v['id'];
        $info1 = $v['cate_name'];
        $info[$k]['name'] = $info1;
        $info[$k]['date'] = $cate->where($where3)->field('id,cate_name,cate_pic')->select();
      }
      // dump($info);exit;
      $this->ajaxReturn($info,'JSON');      
    }

    //电商类目分类页面    (综合)
    public function cateinfo(){
      //实例化
      $good  = M('good');
      $order = M('order');
      $user  = M('user');
      $rele  = M('rele');
      $file  = M('file');
      $good_attr   = M('good_attr');
      $orderdetail = M('orderdetail');
      //搜索条件
      $search=array();
      if(!empty($_GET['good_name'])){
          $search['good_name'] = array('like',"%{$_GET['good_name']}%");
      }
      
      //分类的id
      if($_GET['id']){
        $where1['cate_id'] = I('get.id','','strip_tags');
      }
      //该分类的所有商品
      $info = $good->where($where1)->where($search)->select();
      //商品的状态,排除商品的下架情况
      foreach($info as $k=>$v){
        if($v['good_state'] == 1){
          unset($info[$k]);
        }
      }
      //删除未激活商户和禁用商户的商品
     foreach($info as $key=>$val){
       $map1['id'] = $val['user_id'];
       $userinfo = $user->where($map1)->field('user_grade')->find();
       if($userinfo['user_grade'] != 2){
        unset($info[$key]);
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
      $info  = array_slice($info,$first,$len);
      
      // dump($info);exit;
      // echo (json_encode($info));exit;
      $this->ajaxreturn($info,'JSON');  
    }

    //电商类目分类页面    (热门) 销售量从大道小排序
    public function catehot(){
      //实例化
      $good = M('good');
      $order = M('order');
      $user = M('user');
      $rele = M('rele');
      $file = M('file');
      $good_attr = M('good_attr');
      $orderdetail = M('orderdetail');
      //搜索条件
      $search=array();
      if(!empty($_GET['good_name'])){
          $search['good_name'] = array('like',"%{$_GET['good_name']}%");
      }
      
      //分类的id
      $where1['cate_id'] = I('get.id','','strip_tags');
      //该分类的所有商品
      $info = $good->where($where1)->where($search)->select();
      //商品的状态,排除商品的下架情况
      foreach($info as $k=>$v){
        if($v['good_state'] == 1){
          unset($info[$k]);
        }
      }
      //删除未激活商户和禁用商户的商品
     foreach($info as $key=>$val){
       $map1['id'] = $val['user_id'];
       $userinfo = $user->where($map1)->field('user_grade')->find();
       if($userinfo['user_grade'] != 2){
        unset($info[$key]);
       }
     }
     // dump($info);
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
        $info[$k]['good_attr_price'] = $info2['good_attr_price'];
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
              'field'     => 'good_num',    //排序字段  
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

    //电商类目分类页面    (店铺)
    public function shopinfo(){
        //实例化
        $good = M('good');
        $user = M('user');
        //搜索条件
        $search=array();
        if(!empty($_GET['good_name'])){
            $search['good_name'] = array('like',"%{$_GET['good_name']}%");
        }
        
        //分类的id
        $where1['cate_id'] = I('get.id','','strip_tags');
        //该分类的所有商品
        $info = $good->where($where1)->where($search)->select();
        //商品的状态,排除商品的下架情况
        foreach($info as $k=>$v){
          if($v['good_state'] == 1){
            unset($info[$k]);
          }
        }
        //删除未激活商户和禁用商户的商品
        foreach($info as $key=>$val){
           $map1['id'] = $val['user_id'];
           $userinfo = $user->where($map1)->field('user_grade')->find();
           if($userinfo['user_grade'] != 2){
            unset($info[$key]);
           }
         }

       //查询该商品的所属店铺
       foreach($info as $k=>$v){
        $map2['user_store_name'] = $v['user_store_name'];
        $shopinfo[$k] = $user->where($map2)->field('user_store_name,user_store_evaluate,user_store_pic,user_store_pic1,user_store_pic2,user_store_pic3,user_store_pic4,user_store_phone')->find();
       }
       //图片的路径处理
        foreach($shopinfo as $k=>$v){
          $shopinfo[$k]['user_store_pic'] = $v['user_store_pic'];
          $shopinfo[$k]['user_store_pic1'] = $v['user_store_pic1'];
          $shopinfo[$k]['user_store_pic2'] = $v['user_store_pic2'];
          $shopinfo[$k]['user_store_pic3'] = $v['user_store_pic3'];
          $shopinfo[$k]['user_store_pic4'] = $v['user_store_pic4'];
        }
        $this->ajaxreturn($shopinfo,'JSON');  
    }

    //电商类目分类页面    (筛选) 价格从小到大排序
    public function searchinfo(){
      //实例化
      $good = M('good');
      $order = M('order');
      $user = M('user');
      $rele = M('rele');
      $file = M('file');
      $good_attr = M('good_attr');
      $orderdetail = M('orderdetail');
      //搜索条件
      $search=array();
      if(!empty($_GET['good_name'])){
          $search['good_name'] = array('like',"%{$_GET['good_name']}%");
      }
      
      //分类的id
      $where1['cate_id'] = I('get.id','','strip_tags');
      //该分类的所有商品
      $info = $good->where($where1)->where($search)->select();
      //商品的状态,排除商品的下架情况
      foreach($info as $k=>$v){
        if($v['good_state'] == 1){
          unset($info[$k]);
        }
      }
      //删除未激活商户和禁用商户的商品
     foreach($info as $key=>$val){
       $map1['id'] = $val['user_id'];
       $userinfo = $user->where($map1)->field('user_grade')->find();
       if($userinfo['user_grade'] != 2){
        unset($info[$key]);
       }
     }
     // dump($info);exit;
      //计算月销售量（这个月的）
        $begintime=date('Y-m-d H:i:s',mktime(0,0,0,date('m'),1,date('Y')));
        $endtime=date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('t'),date('Y')));
        $where3['orderdetail_time'] = array('BETWEEN', array($begintime,$endtime));
        foreach($info as $k=>$v){
          $map1['good_id'] = $v['good_id'];
          //有商品的id通过订单属性表查找订单的id和购买的数量
          $info1 = $orderdetail->where($map1)->where($where3)->field('order_id,good_num')->select();
          // dump($info1);
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
        $info[$k]['good_attr_price'] = $info2['good_attr_price'];
        $info[$k]['good_attr_des'] = $info2['good_attr_des'];
        //添加一张图片
        $map3['id'] = $info1['0']['file_id'];
        $info3 = $file->where($map3)->field('file_pic')->find();
        //拼接图片的路径
        $info[$k]['file_pic'] = $info3['file_pic'];
      }
      //按照价格倒序待续
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
}