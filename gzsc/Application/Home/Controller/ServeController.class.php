<?php
namespace Home\Controller;
use Think\Controller;
class ServeController extends Controller {

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
        $adsserve = M('adsserve');
        $second_hand_car     = M('second_hand_car');
        $second_hand_carfile = M('second_hand_carfile');
        $house_for_rent      = M('house_for_rent');
        $house_for_rentfile  = M('house_for_rentfile');
        $truck_rend          = M('truck_rend');
        $truck_rendfile      = M('truck_rendfile');
        $home_decoration     = M('home_decoration');
        $home_decorationfile = M('home_decorationfile');
        $housekeeping        = M('housekeeping');
        $housekeepingfile    = M('housekeepingfile');
        $weixiu_service      = M('weixiu_service');
        $weixiu_servicefile  = M('weixiu_servicefile');
        $medial_service      = M('medial_service');
        $medial_servicefile  = M('medial_servicefile');
        $information         = M('information');
        $informationfile     = M('informationfile');
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
        $shop = $user->where($where3)->field('id,user_store_x,user_store_y')->select();
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
        //头部的图片轮播
        foreach($shop as $k=>$v){
            $where1['user_id'] = $v['id'];
            $map1['adsserve_state']  = 1;
            $where1['adsserve_address'] = 1;  
            $headerpics[$k] = $adsserve->where($where1)->where($map1)->field('adsserve_pic,adsserve_http,adsserve_descr')->select();     
        }
        foreach($headerpics as $k=>$v){
            foreach($v as $ke=>$va){
                $headerpicss[] = $va;
            }
        }
        //中部的图片轮播
        foreach($shop as $k=>$v){
            $where1['user_id'] = $v['id'];
            $map1['adsserve_state']  = 1;
            $where1['adsserve_address'] = 2;  
            $middlepics[$k] = $adsserve->where($where1)->where($map1)->field('adsserve_pic,adsserve_http,adsserve_descr')->select();     
        }
        foreach($middlepics as $k=>$v){
            foreach($v as $ke=>$va){
                $middlepicss[] = $va;
            }
        }
        //猜你喜欢
        foreach($shop as $k=>$v){
            $where2['user_id'] = $v['id'];
            $where2['states']  = 1;
            $where2['states']  = 1;
            $endtime = date('Y-m-d H:i:s');
            $where2['valid_time'] = array('LT',$endtime);

            $second_hand_carinfo[$k] = $second_hand_car->where($where2)->join('second_hand_carfile on second_hand_car.id=second_hand_carfile.second_hand_card_id')->field('second_hand_car.id,second_hand_car.des,second_hand_car.cate_id,second_hand_carfile.file')->find();

            $house_for_rentinfo[$k] = $house_for_rent->where($where2)->join('house_for_rentfile on house_for_rent.id=house_for_rentfile.house_for_rent_id')->field('house_for_rent.id,house_for_rent.des,house_for_rent.cate_id,house_for_rentfile.file')->find();

            $truck_rendinfo[$k] = $truck_rend->where($where2)->join('truck_rendfile on truck_rend.id=truck_rendfile.truck_rend_id')->field('truck_rend.id,truck_rend.des,truck_rend.cate_id,truck_rendfile.file')->find();

            $home_decorationinfo[$k] = $home_decoration->where($where2)->join('home_decorationfile on home_decoration.id=home_decorationfile.home_decoration_id')->field('home_decoration.id,home_decoration.des,home_decoration.cate_id,home_decorationfile.file')->find();

            $housekeepinginfo[$k] = $housekeeping->where($where2)->join('housekeepingfile on housekeeping.id=housekeepingfile.housekeeping_id')->field('housekeeping.id,housekeeping.des,housekeeping.cate_id,housekeepingfile.file')->find();

            $weixiu_serviceinfo[$k] = $weixiu_service->where($where2)->join('weixiu_servicefile on weixiu_service.id=weixiu_servicefile.weixiu_service_id')->field('weixiu_service.id,weixiu_service.des,weixiu_service.cate_id,weixiu_servicefile.file')->find();
 
            $medial_serviceinfo[$k] = $medial_service->where($where2)->join('medial_servicefile on medial_service.id=medial_servicefile.medial_service_id')->field('medial_service.id,medial_service.des,medial_service.cate_id,medial_servicefile.file')->find();
       
            $informationinfo[$k] = $information->where($where2)->join('informationfile on information.id=informationfile.information_id')->field('information.id,information.des,information.cate_id,informationfile.file')->find();

            $info[] = $second_hand_carinfo[$k];
            $info[] = $truck_rendinfo[$k];
            $info[] = $house_for_rentinfo[$k];
            $info[] = $home_decorationinfo[$k];
            $info[] = $housekeepinginfo[$k];
            $info[] = $weixiu_serviceinfo[$k];
            $info[] = $medial_serviceinfo[$k];
            $info[] = $informationinfo[$k];
        }
        foreach($info as $k=>$v){
            if($info[$k] == ''){
                unset($info[$k]);
            }
        }
        //合并
        $res['headerpicss'] = $headerpicss;
        $res['middlepicss'] = $middlepicss;
        $res['shop'] = $info;

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
        $this->ajaxReturn($res,'JSON');
    }

    //选择发布类目
    public function selectserve(){
        //实例化
        $cate = M('cate');
        $where1['cate_name'] = "服务";
        $cateid = $cate->where($where1)->field('id')->find(); 
        $where2['cate_pid'] = $cateid['id'];
        $cateinfo = $cate->where($where2)->field('id,cate_name,cate_pic')->select();
        $info['date'] = $cateinfo;
        $this->ajaxreturn($info,'JSON');
    }

    //发布二手车信息
    public function addhandcar(){
        //实例化
        $second_hand_car     = M('second_hand_car');
        $second_hand_carfile = M('second_hand_carfile');
        //接收数据
        $json = I('get.json','','strip_tags');
        $jsoninfo = json_decode($json,true);
        // dump($jsoninfo);
        $data['user_id']    = $jsoninfo['user_id'];
        $data['cate_id']    = $jsoninfo['cate_id'];
        $data['brank']      = $jsoninfo['brank'];
        $data['color']      = $jsoninfo['color'];
        $data['first_time'] = $jsoninfo['first_time'];
        $data['price']      = $jsoninfo['price'];
        $data['des']        = $jsoninfo['des'];
        $data['name']       = $jsoninfo['name'];
        $data['tel']        = $jsoninfo['tel'];
        $data['area']       = $jsoninfo['area'];
        $data['add_time']   = date('Y-m-d H:i:s');
        $data['valid_time'] = date('Y-m-d H:i:s',time()+604800);
        $url1               = $jsoninfo['url1'];
        $data['driving_lience_pic'] = $url1[0]['url'];
        $data['lience_num_pic']     = $url1[1]['url'];
        $data['register_pic']       = $url1[2]['url'];
        $data['bill_pic']           = $url1[3]['url'];
        // dump($data);exit;
        //插入second_hand_car数据
        $info1 = $second_hand_car->add($data);
        $url2 = $jsoninfo['url2'];
        $len1 = count($url2);
        foreach($url2 as $k=>$v){
            //插入second_hand_carfile数据
            $date['second_hand_card_id'] = $info1;
            $date['file']                = $v['url'];
            $date['add_time']            = date('Y-m-d H:i:s');
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

    //发布房屋出租信息
    public function houseforrent(){
        //实例化
        $house_for_rent     = M('house_for_rent');
        $house_for_rentfile = M('house_for_rentfile');
        //接收数据
        $json = I('get.json','','strip_tags');
        $jsoninfo = json_decode($json,true);
        // dump($jsoninfo);exit;
        $data['user_id']    = $jsoninfo['user_id'];
        $data['cate_id']    = $jsoninfo['cate_id'];
        $data['area']       = $jsoninfo['area'];
        $data['house_type'] = $jsoninfo['house_type'];
        $data['cash']       = $jsoninfo['cash'];
        $data['pay_method'] = $jsoninfo['pay_method'];
        $data['des']        = $jsoninfo['des'];
        $data['name']       = $jsoninfo['name'];
        $data['tel']        = $jsoninfo['tel'];
        $data['state']       = $jsoninfo['state'];
        $data['add_time']   = date('Y-m-d H:i:s');
        $data['valid_time'] = date('Y-m-d H:i:s',time()+604800);
        //插入second_hand_car数据
        $info1 = $house_for_rent->add($data);
        $url = $jsoninfo['url'];
        $len1 = count($url);
        foreach($url as $k=>$v){
            //插入second_hand_carfile数据
            $date['house_for_rend_id'] = $info1;
            $date['file']               = $v['url'];
            $date['add_time']           = date('Y-m-d H:i:s');
            $info2[$k] = $house_for_rentfile->add($date);
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

    //发布货车出租
    public function truckrend(){
        //实例化
        $truck_rend     = M('truck_rend');
        $truck_rendfile = M('truck_rendfile');
        //接收数据
        $json = I('get.json','','strip_tags');
        $jsoninfo = json_decode($json,true);
        // dump($jsoninfo);
        $data['user_id']             = $jsoninfo['user_id'];
        $data['cate_id']             = $jsoninfo['cate_id'];
        $data['brand']               = $jsoninfo['brand'];
        $data['car_num']             = $jsoninfo['car_num'];
        $data['date_for_production'] = $jsoninfo['date_for_production'];
        $data['price']               = $jsoninfo['price'];
        $data['des']                 = $jsoninfo['des'];
        $data['name']                = $jsoninfo['name'];
        $data['tel']                 = $jsoninfo['tel'];
        $data['add_time']            = date('Y-m-d H:i:s');
        $data['valid_time'] = date('Y-m-d H:i:s',time()+604800);
        //插入second_hand_car数据
        $info1 = $truck_rend->add($data);
        $url = $jsoninfo['url'];
        $len1 = count($url);
        foreach($url as $k=>$v){
            //插入second_hand_carfile数据
            $date['truck_rend_id'] = $info1;
            $date['file']               = $v['url'];
            $date['add_time']           = date('Y-m-d H:i:s');
            $info2[$k] = $truck_rendfile->add($date);
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

    //发布家居装修
    public function homedecoration(){
        //实例化
        $home_decoration     = M('home_decoration');
        $home_decorationfile = M('home_decorationfile');
        //接收数据
        $json = I('get.json','','strip_tags');
        $jsoninfo = json_decode($json,true);
        // dump($jsoninfo);
        $data['user_id']       = $jsoninfo['user_id'];
        $data['cate_id']       = $jsoninfo['cate_id'];
        $data['serve_cate']    = $jsoninfo['serve_cate'];
        $data['address']       = $jsoninfo['address'];
        $data['pay_method']    = $jsoninfo['pay_method'];
        $data['des']           = $jsoninfo['des'];
        $data['name']          = $jsoninfo['name'];
        $data['tel']           = $jsoninfo['tel'];
        $data['add_time']      = date('Y-m-d H:i:s');
        $data['valid_time']    = date('Y-m-d H:i:s',time()+604800);
        //插入second_hand_car数据
        $info1 = $home_decoration->add($data);
        $url = $jsoninfo['url'];
        $len1 = count($url);
        foreach($url as $k=>$v){
            //插入second_hand_carfile数据
            $date['home_decoration_id'] = $info1;
            $date['file']               = $v['url'];
            $date['add_time']           = date('Y-m-d H:i:s');
            $info2[$k] = $home_decorationfile->add($date);
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

    //发布家政服务
    public function housekeeping(){
        //实例化
        $housekeeping     = M('housekeeping');
        $housekeepingfile = M('housekeepingfile');
        //接收数据
        $json = I('get.json','','strip_tags');
        $jsoninfo = json_decode($json,true);
        // dump($jsoninfo);
        $data['user_id']       = $jsoninfo['user_id'];
        $data['cate_id']       = $jsoninfo['cate_id'];
        $data['serve_cate']    = $jsoninfo['serve_cate'];
        $data['address']       = $jsoninfo['address'];
        $data['pay_method']    = $jsoninfo['pay_method'];
        $data['des']           = $jsoninfo['des'];
        $data['name']          = $jsoninfo['name'];
        $data['tel']           = $jsoninfo['tel'];
        $data['add_time']      = date('Y-m-d H:i:s');
        $data['valid_time']    = date('Y-m-d H:i:s',time()+604800);
        //插入second_hand_car数据
        $info1 = $housekeeping->add($data);
        $url = $jsoninfo['url'];
        $len1 = count($url);
        foreach($url as $k=>$v){
            //插入second_hand_carfile数据
            $date['housekeeping_id']    = $info1;
            $date['file']               = $v['url'];
            $date['add_time']           = date('Y-m-d H:i:s');
            $info2[$k] = $housekeepingfile->add($date);
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

    //发布维修服务
    public function weixiuservice(){
        //实例化
        $weixiu_service     = M('weixiu_service');
        $weixiu_servicefile = M('weixiu_servicefile');
        //接收数据
        $json = I('get.json','','strip_tags');
        $jsoninfo = json_decode($json,true);
        // dump($jsoninfo);
        $data['user_id']       = $jsoninfo['user_id'];
        $data['cate_id']       = $jsoninfo['cate_id'];
        $data['serve_cate']    = $jsoninfo['serve_cate'];
        $data['address']       = $jsoninfo['address'];
        $data['pay_method']    = $jsoninfo['pay_method'];
        $data['des']           = $jsoninfo['des'];
        $data['name']          = $jsoninfo['name'];
        $data['tel']           = $jsoninfo['tel'];
        $data['add_time']      = date('Y-m-d H:i:s');
        $data['valid_time']    = date('Y-m-d H:i:s',time()+604800);
        //插入second_hand_car数据
        $info1 = $weixiu_service->add($data);
        $url = $jsoninfo['url'];
        $len1 = count($url);
        foreach($url as $k=>$v){
            //插入second_hand_carfile数据
            $date['weixiu_service_id']    = $info1;
            $date['file']               = $v['url'];
            $date['add_time']           = date('Y-m-d H:i:s');
            $info2[$k] = $weixiu_servicefile->add($date);
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

    //发布医疗服务
    public function medialservice(){
        //实例化
        $medial_service     = M('medial_service');
        $medial_servicefile = M('medial_servicefile');
        //接收数据
        $json = I('get.json','','strip_tags');
        $jsoninfo = json_decode($json,true);
        // dump($jsoninfo);
        $data['user_id']       = $jsoninfo['user_id'];
        $data['cate_id']       = $jsoninfo['cate_id'];
        $data['serve_cate']    = $jsoninfo['serve_cate'];
        $data['address']       = $jsoninfo['address'];
        $data['pay_method']    = $jsoninfo['pay_method'];
        $data['des']           = $jsoninfo['des'];
        $data['name']          = $jsoninfo['name'];
        $data['tel']           = $jsoninfo['tel'];
        $data['add_time']      = date('Y-m-d H:i:s');
        $data['valid_time']    = date('Y-m-d H:i:s',time()+604800);
        //插入second_hand_car数据
        $info1 = $medial_service->add($data);
        $url = $jsoninfo['url'];
        $len1 = count($url);
        foreach($url as $k=>$v){
            //插入second_hand_carfile数据
            $date['medial_service_id']    = $info1;
            $date['file']               = $v['url'];
            $date['add_time']           = date('Y-m-d H:i:s');
            $info2[$k] = $medial_servicefile->add($date);
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

    //发布招聘信息
    public function inforservice(){
        //实例化
        $information     = M('information');
        $informationfile = M('informationfile');
        //接收数据
        $json = I('get.json','','strip_tags');
        $jsoninfo = json_decode($json,true);
        // dump($jsoninfo);
        $data['user_id']       = $jsoninfo['user_id'];
        $data['cate_id']       = $jsoninfo['cate_id'];
        $data['company_name']  = $jsoninfo['company_name'];
        $data['company_des']   = $jsoninfo['company_des'];
        $data['address']       = $jsoninfo['address'];
        $data['content']       = $jsoninfo['content'];;
        $data['tel']           = $jsoninfo['tel'];
        $data['legal_person']  = $jsoninfo['legal_person'];
        $data['add_time']      = date('Y-m-d H:i:s');
        $data['valid_time']    = date('Y-m-d H:i:s',time()+604800);
        // dump($data);exit;
        //插入second_hand_car数据
        $info1 = $information->add($data);
        $url = $jsoninfo['url'];
        $len1 = count($url);
        foreach($url as $k=>$v){
            //插入second_hand_carfile数据
            $date['information_id']    = $info1;
            $date['file']               = $v['url'];
            $date['add_time']           = date('Y-m-d H:i:s');
            $info2[$k] = $informationfile->add($date);
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
    //发布公司工厂
    public function company(){
        //实例化
        $company     = M('company');
        $companyfile = M('companyfile');
        //接收数据
        $json = I('get.json','','strip_tags');
        $jsoninfo = json_decode($json,true);
        // dump($jsoninfo);
        $data['user_id']       = $jsoninfo['user_id'];
        $data['cate_id']       = $jsoninfo['cate_id'];
        $data['company_name']  = $jsoninfo['company_name'];
        $data['company_des']   = $jsoninfo['company_des'];
        $data['address']       = $jsoninfo['address'];
        $data['contents']      = $jsoninfo['contents'];
        $data['legal_person']  = $jsoninfo['legal_person'];
        $data['tel']           = $jsoninfo['tel'];
        $data['clicknum']      = $jsoninfo['clicknum'];
        $data['register_time'] = $jsoninfo['register_time'];
        $data['add_time']      = date('Y-m-d H:i:s');
        $data['valid_time']    = date('Y-m-d H:i:s',time()+604800);
        // dump($data);
        //插入second_hand_car数据
        $info1 = $company->add($data);
        // dump($data);exit;
        $url = $jsoninfo['url'];
        $len1 = count($url);
        foreach($url as $k=>$v){
            //插入second_hand_carfile数据
            $date['company_id']         = $info1;
            $date['file']               = $v['url'];
            $date['add_time']           = date('Y-m-d H:i:s');
            $info2[$k] = $companyfile->add($date);
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