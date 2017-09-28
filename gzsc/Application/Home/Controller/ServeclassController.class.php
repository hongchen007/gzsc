<?php
namespace Home\Controller;
use Think\Controller;
class ServeclassController extends Controller {
    

//==================================================二手车====================================================

    //二手车出租(综合)
    public function secondhandcarinfo(){
        //实例化
        $user                = M('user');
        $second_hand_car     = M('second_hand_car');
        $second_hand_carfile = M('second_hand_carfile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['brank'] = array('like',"%{$_GET['condition']}%");
            // dump($search);exit;
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $second_hand_car->where($where1)->where($search)->select();
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $second_hand_card_id = $v['id'];
            $fileinfo = $second_hand_carfile->where("second_hand_card_id=$second_hand_card_id")->field('file')->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //二手车出租(热门)
    public function secondhandcarghot(){
        //实例化
        $user                = M('user');
        $second_hand_car     = M('second_hand_car');
        $second_hand_carfile = M('second_hand_carfile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['brank'] = array('like',"%{$_GET['condition']}%");
            // dump($search);exit;
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $second_hand_car->where($where1)->where($search)->order('clicknum desc')->select();
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $second_hand_card_id = $v['id'];
            $fileinfo = $second_hand_carfile->where("second_hand_card_id=$second_hand_card_id")->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //二手车出租(店铺)
    public function secondhandcarstore(){
        //实例化
        $user            = M('user');
        $second_hand_car = M('second_hand_car');
        //查询条件
        if($_GET['user_store_name']){
            $where3['user_store_name'] = array('like',"%{$_GET['user_store_name']}%");
        }
        //二手车表状态为2的商店id
        $carinfo = $second_hand_car->where('states=2')->field('user_id')->select();
        //二维数组的去重
        foreach ($carinfo as $v){
            $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[]=$v;
        }
        $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $temp[$k]=explode(',',$v); //再将拆开的数组重新组装
        }
        // dump($temp);exit;
        //商店状态正常
        $where3['user_grade'] = 2;
        foreach($temp as $k=>$v){
            $where4['id'] = $v[0];
            $shop[$k] = $user->where($where3)->where($where4)->field('user_grade,id,user_store_headerpic,user_store_name,user_store_evaluate,user_store_pic,user_store_pic1,user_store_pic2,user_store_pic3,user_store_pic4,user_store_phone')->find();
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

    //二手车出租(筛选)
    // public function secondhandcarselect(){
    //     //实例化
    //     $user                = M('user');
    //     $second_hand_car     = M('second_hand_car');
    //     $second_hand_carfile = M('second_hand_carfile');
    //     //搜索条件
    //     $search=array();
    //     if(!empty($_GET['condition'])){
    //         $search['brank'] = array('like',"%{$_GET['condition']}%");
    //         // dump($search);exit;
    //     }
    //     //服务正常的状态
    //     $where1['states'] = 2;
    //     //查找数据
    //     $info = $second_hand_car->where($where1)->order('price')->where($search)->select();
    //     //删除未激活商户、禁用商户、禁用用户的服务
    //     foreach($info as $key=>$val){
    //         $map1['id'] = $val['user_id'];
    //         $userinfo = $user->where($map1)->field('user_grade')->find();
    //         if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
    //             unset($info[$key]);
    //         }
    //     }
    //     //图片
    //     foreach($info as $k=>$v){
    //         $second_hand_card_id = $v['id'];
    //         $fileinfo = $second_hand_carfile->where("second_hand_card_id=$second_hand_card_id")->field('file')->select();
    //         $info[$k]['file'] = $fileinfo;
    //     }
    //     //第几页
    //     if($_GET['p']){
    //         $p = I('get.p','','strip_tags');
    //     }
    //     //每页几条数据
    //     if(empty($_GET['len'])){
    //         $len = 10;
    //     }else{
    //         $len = $_GET['len'];
    //     }
    //     $first = 0+$len*($p-1);
    //     $info = array_slice($info,$first,$len);
    //     $this->ajaxreturn($info,'JSON'); 
    // }

//==================================================房屋出租houseforrent====================================================

    //货车出租(综合)
    public function houseforrentinfo(){
        //实例化
        $user                = M('user');
        $house_for_rent     = M('house_for_rent');
        $house_for_rentfile = M('house_for_rentfile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['house_type'] = array('like',"%{$_GET['condition']}%");
            // dump($search);exit;
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $house_for_rent->where($where1)->where($search)->select();
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $house_for_rend_id = $v['id'];
            $fileinfo = $house_for_rentfile->where("house_for_rend_id=$house_for_rend_id")->field('file')->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //货车出租(热门)
    public function houseforrentghot(){
        //实例化
        $user               = M('user');
        $house_for_rent     = M('house_for_rent');
        $house_for_rentfile = M('house_for_rentfile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['house_type'] = array('like',"%{$_GET['condition']}%");
            // dump($search);exit;
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $house_for_rent->where($where1)->where($search)->order('clicknum desc')->select();
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $house_for_rend_id = $v['id'];
            $fileinfo = $house_for_rentfile->where("house_for_rend_id=$house_for_rend_id")->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //货车出租(店铺)
    public function houseforrentstore(){
        //实例化·
        // echo "111";exit;
        $user            = M('user');
        $house_for_rent = M('house_for_rent');
        //查询条件
        if($_GET['user_store_name']){
            $where3['user_store_name'] = array('like',"%{$_GET['user_store_name']}%");
        }
        //房屋表状态为2的商店id
        $carinfo = $house_for_rent->where('states=2')->field('user_id')->select();
        //二维数组的去重
        foreach ($carinfo as $v){
            $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[]=$v;
        }
        $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $temp[$k]=explode(',',$v); //再将拆开的数组重新组装
        }
        // dump($temp);exit;
        //商店状态正常
        $where3['user_grade'] = 2;
        foreach($temp as $k=>$v){
            $where4['id'] = $v[0];
            $shop[$k] = $user->where($where3)->where($where4)->field('user_grade,id,user_store_headerpic,user_store_name,user_store_evaluate,user_store_pic,user_store_pic1,user_store_pic2,user_store_pic3,user_store_pic4,user_store_phone')->find();
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

//==================================================货车出租truckrend====================================================

    //货车出租(综合)
    public function truckrendinfo(){
        //实例化
        $user               = M('user');
        $truck_rend     = M('truck_rend');
        $truck_rendfile = M('truck_rendfile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['brand'] = array('like',"%{$_GET['condition']}%");
            // dump($search);exit;
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $truck_rend->where($where1)->where($search)->select();
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $truck_rend_id = $v['id'];
            $fileinfo = $truck_rendfile->where("truck_rend_id=$truck_rend_id")->field('file')->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //货车出租(热门)
    public function truckrendghot(){
        //实例化
        $user           = M('user');
        $truck_rend     = M('truck_rend');
        $truck_rendfile = M('truck_rendfile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['brand'] = array('like',"%{$_GET['condition']}%");
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $truck_rend->where($where1)->where($search)->order('clicknum desc')->select();
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $house_for_rend_id = $v['id'];
            $fileinfo = $truck_rendfile->where("house_for_rend_id=$house_for_rend_id")->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //货车出租(店铺)
    public function truckrendstore(){
        //实例化
        $user       = M('user');
        $truck_rend = M('truck_rend');
        //查询条件
        if($_GET['user_store_name']){
            $where3['user_store_name'] = array('like',"%{$_GET['user_store_name']}%");
        }
        //房屋表状态为2的商店id
        $carinfo = $truck_rend->where('states=2')->field('user_id')->select();
        //二维数组的去重 
        foreach ($carinfo as $v){
            $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[]=$v;
        }
        $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $temp[$k]=explode(',',$v); //再将拆开的数组重新组装
        }
        // dump($temp);exit;
        //商店状态正常
        $where3['user_grade'] = 2;
        foreach($temp as $k=>$v){
            $where4['id'] = $v[0];
            $shop[$k] = $user->where($where3)->where($where4)->field('user_grade,id,user_store_headerpic,user_store_name,user_store_evaluate,user_store_pic,user_store_pic1,user_store_pic2,user_store_pic3,user_store_pic4,user_store_phone')->find();
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

//==================================================家居装修homedecoration====================================================

    //家居装修(综合)
    public function homedecorationinfo(){
        //实例化
        $user                = M('user');
        $home_decoration     = M('home_decoration');
        $home_decorationfile = M('home_decorationfile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['des'] = array('like',"%{$_GET['condition']}%");
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $home_decoration->where($where1)->where($search)->select();
        // dump($info);exit;
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $home_decoration_id = $v['id'];
            $fileinfo = $home_decorationfile->where("home_decoration_id=$home_decoration_id")->field('file')->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //家居装修(热门)
    public function homedecorationghot(){
        //实例化
        $user                = M('user');
        $home_decoration     = M('home_decoration');
        $home_decorationfile = M('home_decorationfile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['des'] = array('like',"%{$_GET['condition']}%");
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $home_decoration->where($where1)->where($search)->order('clicknum desc')->select();
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $home_decoration_id = $v['id'];
            $fileinfo = $home_decorationfile->where("home_decoration_id=$home_decoration_id")->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //家居装修(店铺)
    public function homedecorationstore(){
        //实例化
        $user            = M('user');
        $home_decoration = M('home_decoration');
        //查询条件
        if($_GET['condition']){
            $where3['user_store_name'] = array('like',"%{$_GET['user_store_name']}%");
        }
        //房屋表状态为2的商店id
        $carinfo = $home_decoration->where('states=2')->field('user_id')->select();
        //二维数组的去重 
        foreach ($carinfo as $v){
            $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[]=$v;
        }
        $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $temp[$k]=explode(',',$v); //再将拆开的数组重新组装
        }
        // dump($temp);exit;
        //商店状态正常
        $where3['user_grade'] = 2;
        foreach($temp as $k=>$v){
            $where4['id'] = $v[0];
            $shop[$k] = $user->where($where3)->where($where4)->field('user_grade,id,user_store_headerpic,user_store_name,user_store_evaluate,user_store_pic,user_store_pic1,user_store_pic2,user_store_pic3,user_store_pic4,user_store_phone')->find();
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

//==================================================家政服务housekeeping====================================================

    //家政服务(综合)
    public function housekeepinginfo(){
        //实例化
        $user             = M('user');
        $housekeeping     = M('housekeeping');
        $housekeepingfile = M('housekeepingfile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['des'] = array('like',"%{$_GET['condition']}%");
            // dump($search);exit;
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $housekeeping->where($where1)->where($search)->select();
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $housekeeping_id = $v['id'];
            $fileinfo = $housekeepingfile->where("housekeeping_id=$housekeeping_id")->field('file')->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //家政服务(热门)
    public function housekeepingghot(){
        //实例化
        $user           = M('user');
        $housekeeping     = M('housekeeping');
        $housekeepingfile = M('housekeepingfile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['des'] = array('like',"%{$_GET['condition']}%");
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $housekeeping->where($where1)->where($search)->order('clicknum desc')->select();
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $housekeeping_id = $v['id'];
            $fileinfo = $housekeepingfile->where("housekeeping_id=$housekeeping_id")->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //家政服务(店铺)
    public function housekeepingstore(){
        //实例化
        $user       = M('user');
        $housekeeping = M('housekeeping');
        //查询条件
        if($_GET['user_store_name']){
            $where3['user_store_name'] = array('like',"%{$_GET['user_store_name']}%");
        }
        //房屋表状态为2的商店id
        $carinfo = $housekeeping->where('states=2')->field('user_id')->select();
        //二维数组的去重 
        foreach ($carinfo as $v){
            $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[]=$v;
        }
        $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $temp[$k]=explode(',',$v); //再将拆开的数组重新组装
        }
        // dump($temp);exit;
        //商店状态正常
        $where3['user_grade'] = 2;
        foreach($temp as $k=>$v){
            $where4['id'] = $v[0];
            $shop[$k] = $user->where($where3)->where($where4)->field('user_grade,id,user_store_headerpic,user_store_name,user_store_evaluate,user_store_pic,user_store_pic1,user_store_pic2,user_store_pic3,user_store_pic4,user_store_phone')->find();
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

//==================================================维修服务weixiuservice====================================================

    //家居装修(综合)
    public function weixiuserviceinfo(){
        //实例化
        $user                = M('user');
        $weixiu_service     = M('weixiu_service');
        $weixiu_servicefile = M('weixiu_servicefile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['des'] = array('like',"%{$_GET['condition']}%");
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $weixiu_service->where($where1)->where($search)->select();
        // dump($info);exit;
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $weixiu_service_id = $v['id'];
            $fileinfo = $weixiu_servicefile->where("weixiu_service_id=$weixiu_service_id")->field('file')->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //家居装修(热门)
    public function weixiuserviceghot(){
        //实例化
        $user                = M('user');
        $weixiu_service     = M('weixiu_service');
        $weixiu_servicefile = M('weixiu_servicefile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['des'] = array('like',"%{$_GET['condition']}%");
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $weixiu_service->where($where1)->where($search)->order('clicknum desc')->select();
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $weixiu_service_id = $v['id'];
            $fileinfo = $weixiu_servicefile->where("weixiu_service_id=$weixiu_service_id")->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //家居装修(店铺)
    public function weixiuservicestore(){
        //实例化
        $user            = M('user');
        $weixiu_service = M('weixiu_service');
        //查询条件
        if($_GET['user_store_name']){
            $where3['user_store_name'] = array('like',"%{$_GET['user_store_name']}%");
        }
        //房屋表状态为2的商店id
        $carinfo = $weixiu_service->where('states=2')->field('user_id')->select();
        //二维数组的去重 
        foreach ($carinfo as $v){
            $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[]=$v;
        }
        $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $temp[$k]=explode(',',$v); //再将拆开的数组重新组装
        }
        // dump($temp);exit;
        //商店状态正常
        $where3['user_grade'] = 2;
        foreach($temp as $k=>$v){
            $where4['id'] = $v[0];
            $shop[$k] = $user->where($where3)->where($where4)->field('user_grade,id,user_store_headerpic,user_store_name,user_store_evaluate,user_store_pic,user_store_pic1,user_store_pic2,user_store_pic3,user_store_pic4,user_store_phone')->find();
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

//==================================================医疗medialservice====================================================

    //医疗(综合)
    public function medialserviceinfo(){
        //实例化
        $user               = M('user');
        $medial_service     = M('medial_service');
        $medial_servicefile = M('medial_servicefile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['des'] = array('like',"%{$_GET['condition']}%");
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $medial_service->where($where1)->where($search)->select();
        // dump($info);exit;
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $medial_service_id = $v['id'];
            $fileinfo = $medial_servicefile->where("medial_service_id=$medial_service_id")->field('file')->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //医疗(热门)
    public function medialserviceghot(){
        //实例化
        $user                = M('user');
        $medial_service     = M('medial_service');
        $medial_servicefile = M('medial_servicefile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['des'] = array('like',"%{$_GET['condition']}%");
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $medial_service->where($where1)->where($search)->order('clicknum desc')->select();
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $medial_service_id = $v['id'];
            $fileinfo = $medial_servicefile->where("medial_service_id=$medial_service_id")->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //医疗(店铺)
    public function medialservicestore(){
        //实例化
        $user            = M('user');
        $medial_service = M('medial_service');
        //查询条件
        if($_GET['user_store_name']){
            $where3['user_store_name'] = array('like',"%{$_GET['user_store_name']}%");
        }
        //房屋表状态为2的商店id
        $carinfo = $medial_service->where('states=2')->field('user_id')->select();
        //二维数组的去重 
        foreach ($carinfo as $v){
            $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[]=$v;
        }
        $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $temp[$k]=explode(',',$v); //再将拆开的数组重新组装
        }
        // dump($temp);exit;
        //商店状态正常
        $where3['user_grade'] = 2;
        foreach($temp as $k=>$v){
            $where4['id'] = $v[0];
            $shop[$k] = $user->where($where3)->where($where4)->field('user_grade,id,user_store_headerpic,user_store_name,user_store_evaluate,user_store_pic,user_store_pic1,user_store_pic2,user_store_pic3,user_store_pic4,user_store_phone')->find();
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

//==================================================招聘信息inforservice====================================================

    //招聘信息(综合)
    public function inforserviceinfo(){
        //实例化
        $user            = M('user'); 
        $information     = M('information');
        $informationfile = M('informationfile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['seat'] = array('like',"%{$_GET['condition']}%");
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $information->where($where1)->where($search)->select();
        // dump($info);exit;
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $information_id = $v['id'];
            $fileinfo = $informationfile->where("information_id=$information_id")->field('file')->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //招聘信息(热门)
    public function inforserviceghot(){
        //实例化
        $user            = M('user');
        $information     = M('information');
        $informationfile = M('informationfile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['des'] = array('like',"%{$_GET['condition']}%");
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $information->where($where1)->where($search)->order('clicknum desc')->select();
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $information_id = $v['id'];
            $fileinfo = $informationfile->where("information_id=$information_id")->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //招聘信息(店铺)
    public function inforservicestore(){
        //实例化
        $user            = M('user');
        $information = M('information');
        //查询条件
        if($_GET['condition']){
            $where3['user_store_name'] = array('like',"%{$_GET['user_store_name']}%");
        }
        //房屋表状态为2的商店id
        $carinfo = $information->where('states=2')->field('user_id')->select();
        //二维数组的去重 
        foreach ($carinfo as $v){
            $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[]=$v;
        }
        $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $temp[$k]=explode(',',$v); //再将拆开的数组重新组装
        }
        // dump($temp);exit;
        //商店状态正常
        $where3['user_grade'] = 2;
        foreach($temp as $k=>$v){
            $where4['id'] = $v[0];
            $shop[$k] = $user->where($where3)->where($where4)->field('user_grade,id,user_store_headerpic,user_store_name,user_store_evaluate,user_store_pic,user_store_pic1,user_store_pic2,user_store_pic3,user_store_pic4,user_store_phone')->find();
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


//==================================================公司工厂company====================================================

    //公司工厂(综合)
    public function inforcompanyinfo(){
        //实例化
        $user        = M('user');
        $company     = M('company');
        $companyfile = M('companyfile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['company_name'] = array('like',"%{$_GET['condition']}%");
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $company->where($where1)->where($search)->select();
        // dump($info);exit;
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $company_id = $v['id'];
            $fileinfo = $companyfile->where("company_id=$company_id")->field('file')->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //公司工厂(热门)
    public function inforcompanyghot(){
        //实例化
        $user                = M('user');
        $company     = M('company');
        $companyfile = M('companyfile');
        //搜索条件
        $search=array();
        if(!empty($_GET['condition'])){
            $search['company_name'] = array('like',"%{$_GET['condition']}%");
        }
        //服务正常的状态
        $where1['states'] = 2;
        //查找数据
        $info = $company->where($where1)->where($search)->order('clicknum desc')->select();
        //删除未激活商户、禁用商户、禁用用户的服务
        foreach($info as $key=>$val){
            $map1['id'] = $val['user_id'];
            $userinfo = $user->where($map1)->field('user_grade')->find();
            if($userinfo['user_grade'] != 2 && $userinfo['user_grade'] != 5){
                unset($info[$key]);
            }
        }
        //图片
        foreach($info as $k=>$v){
            $company_id = $v['id'];
            $fileinfo = $companyfile->where("company_id=$company_id")->select();
            $info[$k]['file'] = $fileinfo;
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
        $this->ajaxreturn($info,'JSON'); 
    }

    //公司工厂(店铺)
    public function inforcompanystore(){
        //实例化
        $user            = M('user');
        $company = M('company');
        //查询条件
        if($_GET['condition']){
            $where3['user_store_name'] = array('like',"%{$_GET['user_store_name']}%");
        }
        //房屋表状态为2的商店id
        $carinfo = $company->where('states=2')->field('user_id')->select();
        //二维数组的去重 
        foreach ($carinfo as $v){
            $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[]=$v;
        }
        $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $temp[$k]=explode(',',$v); //再将拆开的数组重新组装
        }
        // dump($temp);exit;
        //商店状态正常
        $where3['user_grade'] = 2;
        foreach($temp as $k=>$v){
            $where4['id'] = $v[0];
            $shop[$k] = $user->where($where3)->where($where4)->field('user_grade,id,user_store_headerpic,user_store_name,user_store_evaluate,user_store_pic,user_store_pic1,user_store_pic2,user_store_pic3,user_store_pic4,user_store_phone')->find();
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

//==================================================服务详情inforservice====================================================




}