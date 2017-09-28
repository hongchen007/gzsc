<?php
namespace Home\Controller;
use Think\Controller;
class ServedetailController extends Controller {

    //服务类的判别
    public function select(){
        //接收值
        $cate_id = I('get.cate_id','','strip_tags');
        $id = I('get.id','','strip_tags');
        if($cate_id == 2){
            $info = $this->houseforrentinfo($id);
        }elseif($cate_id == 3){
            $info = $this->truckrendinfo($id);
        }elseif($cate_id == 4){
            $info = $this->inforserviceinfo($id);
        }elseif($cate_id == 5){
            $info = $this->weixiuserviceinfo($id);
        }elseif($cate_id == 6){
            $info = $this->housekeepinginfo($id);
        }elseif($cate_id == 7){
            $info = $this->homedecorationinfo($id);
        }elseif($cate_id == 8){
            $info = $this->secondhandcar($id);
        }elseif($cate_id == 65){
            $info = $this->companyinfo($id);
        }else{
            $info = $this->medialserviceinfo($id);
        }
        $this->ajaxReturn($info,'JSON'); 
    }

    //二手车出租详情
    public function secondhandcar($id){
        //实例化
        $second_hand_car     = M('second_hand_car');
        $second_hand_carfile = M('second_hand_carfile');
        //查找数据
        $carinfo = $second_hand_car->where("id=$id")->find();
        $where['second_hand_card_id'] = $carinfo['id'];
        $carpicinfo = $second_hand_carfile->where($where)->field('file')->select();
        $carinfo['pic'] = $carpicinfo;
        return $carinfo;
    }

    //房屋出租详情
    public function houseforrentinfo($id){
        //实例化
        $house_for_rent     = M('house_for_rent');
        $house_for_rentfile = M('house_for_rentfile');
        //查找数据
        $carinfo = $house_for_rent->where("id=$id")->find();
        $where['house_for_rend_id'] = $carinfo['id'];
        $carpicinfo = $house_for_rentfile->where($where)->field('file')->select();
        $carinfo['pic'] = $carpicinfo;
        return $carinfo;
    }

    //货车出租详情
    public function truckrendinfo($id){
        //实例化
        $truck_rend     = M('truck_rend');
        $truck_rendfile = M('truck_rendfile');
        //查找数据
        $carinfo = $truck_rend->where("id=$id")->find();
        $where['truck_rend_id'] = $carinfo['id'];
        $carpicinfo = $truck_rendfile->where($where)->field('file')->select();
        $carinfo['pic'] = $carpicinfo;
        return $carinfo;
    }  

    //家居装修详情
    public function homedecorationinfo($id){
        //实例化
        $home_decoration     = M('home_decoration');
        $home_decorationfile = M('home_decorationfile');
        //查找数据
        $carinfo = $home_decoration->where("id=$id")->find();
        $where['home_decoration_id'] = $carinfo['id'];
        $carpicinfo = $home_decorationfile->where($where)->field('file')->select();
        $carinfo['pic'] = $carpicinfo;
        return $carinfo;
    }  

    //家政服务详情
    public function housekeepinginfo($id){
        //实例化
        $housekeeping     = M('housekeeping');
        $housekeepingfile = M('housekeepingfile');
        //查找数据
        $carinfo = $housekeeping->where("id=$id")->find();
        $where['housekeeping_id'] = $carinfo['id'];
        $carpicinfo = $housekeepingfile->where($where)->field('file')->select();
        $carinfo['pic'] = $carpicinfo;
        return $carinfo;
    }  

    //维修服务详情
    public function weixiuserviceinfo($id){
        //实例化
        $weixiu_service     = M('weixiu_service');
        $weixiu_servicefile = M('weixiu_servicefile');
        //查找数据
        $carinfo = $weixiu_service->where("id=$id")->find();
        $where['weixiu_service_id'] = $carinfo['id'];
        $carpicinfo = $weixiu_servicefile->where($where)->field('file')->select();
        $carinfo['pic'] = $carpicinfo;
        return $carinfo;
    }  

    //医疗详情
    public function medialserviceinfo($id){
        //实例化
        $medial_service     = M('medial_service');
        $medial_servicefile = M('medial_servicefile');
        //查找数据
        $carinfo = $medial_service->where("id=$id")->find();
        $where['medial_service_id'] = $carinfo['id'];
        $carpicinfo = $medial_servicefile->where($where)->field('file')->select();
        $carinfo['pic'] = $carpicinfo;
        return $carinfo;
    } 

    //招聘信息详情
    public function inforserviceinfo($id){
        //实例化
        $information     = M('information');
        $informationfile = M('informationfile');
        //查找数据
        $carinfo = $information->where("id=$id")->find();
        $where['information_id'] = $carinfo['id'];
        $carpicinfo = $informationfile->where($where)->field('file')->select();
        $carinfo['pic'] = $carpicinfo;
        return $carinfo;
    } 

    //公司工厂
    public function companyinfo($id){
        //实例化
        $company     = M('company');
        $companyfile = M('companyfile');
        //查找数据
        $carinfo = $company->where("id=$id")->find();
        $where['company_id'] = $carinfo['id'];
        $carpicinfo = $companyfile->where($where)->field('file')->select();
        $carinfo['pic'] = $carpicinfo;
        return $carinfo;        
    }
} 