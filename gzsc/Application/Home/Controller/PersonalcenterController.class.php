<?php
namespace Home\Controller;
use Think\Controller;
class PersonalcenterController extends Controller {

//=============================================收获地址管理==================================
   //点击我的收获地址
    public function address(){
        //实例化
        $address = M('address');
        //接收值
        // $where1['user_id'] = $id = $_SESSION['Login']['id'];
        $where1['user_id'] = $id = $_GET['user_id'];
        //收获地址
        $addressinfo = $address->where($where1)->select();
        if($addressinfo){
            $info['sucmsg'] = $addressinfo;
            $info['code'] = 1;
        }else{
            $info['errmsg'] = '没有收获地址';
            $info['code'] = 0;
        }
        //不存在添加
        // dump($addressinfo);\
        $this->ajaxreturn($info);
    }

    //添加收获地址
    public function addressadd(){
        //实例化
        $address = M('address');
        //接收值
        $data['user_id'] = $where1['user_id'] = I('get.user_id','','strip_tags');
        //判断该用户是否用收获地址，如果有则不是默认，如果没有则是默认
        $addressinfo = $address->where($where1)->field('id')->find();
        if($addressinfo){
            $data['address'] = I('get.address','','strip_tags');
            $data['user_id'] = I('get.user_id','','strip_tags');
            $data['officer'] = I('get.officer','','strip_tags');
            $data['address_phone'] = I('get.address_phone','','strip_tags');
            $data['default'] = 2;
            $info = $address->add($data);
            if($info){
                $allinfo['code'] = 1;
                $allinfo['sucmsg'] = $info; 
                $this->ajaxreturn($allinfo,'JSON');
            }else{
                $allinfo['code'] =0;
                $allinfo['sucmsg'] = "添加失败"; 
                $this->ajaxreturn($allinfo,'JSON');                
            }
        }else{
            $data['address'] = I('get.address','','strip_tags');
            $data['officer'] = I('get.officer','','strip_tags');
            $data['address_phone'] = I('get.address_phone','','strip_tags');
            $data['default'] = 1;
            $info = $address->add($data);
            if($info){
                $allinfo['code'] = 1;
                $allinfo['sucmsg'] = $info; 
                $this->ajaxreturn($allinfo,'JSON');
            }else{
                $allinfo['code'] =0;
                $allinfo['sucmsg'] = "添加失败"; 
                $this->ajaxreturn($allinfo,'JSON');                
            }                    
        }
    }

    //删除收获地址
    public function deladdress(){
        //实例化
        $address = M('address');
        //接收数据
        $where1['id'] = I('get.id','','strip_tags');
        $where2['user_id'] = I('get.user_id','','strip_tags');
        //执行删除
        //判断是否为默认收获地址
        $addressinfo = $address->where($where1)->find();
        // dump($addressinfo);exit;
        if($addressinfo['default'] == 1){
            $sumaddrerss = $address->where($where2)->select();
            // dump($sumaddrerss);exit;
            if(count($sumaddrerss) == 1){
                $info = $address->where($where1)->delete();
                if($info){
                    $allinfo['code'] = 1;
                    $allinfo['sucmsg'] = '删除成功';
                }else{
                    $allinfo['code'] = 0;
                    $allinfo['sucmsg'] = '删除失败';            
                }             
            }else{
                foreach($sumaddrerss as $k=>$v){
                    $infoa = $address->where($where1)->delete();
                    $newaddress = $address->where($where2)->find();
                    $data['default'] = 1;
                    $where3['id'] = $newaddress['id']; 
                    $info1 = $address->where($where3)->save($data);
                }
                if($infoa == $info1){
                    $allinfo['code'] = 1;
                    $allinfo['sucmsg'] = '删除成功';                   
                }else{
                    $allinfo['code'] = 0;
                    $allinfo['sucmsg'] = '删除失败';            
                }
            }
        }else{
             //如果不是直接删除
            $info = $address->where($where1)->delete();
            if($info){
                $allinfo['code'] = 1;
                $allinfo['sucmsg'] = '删除成功';
            }else{
                $allinfo['code'] = 0;
                $allinfo['sucmsg'] = '删除失败';            
            }   
        }
        
        $this->ajaxreturn($allinfo);
    }

    //修改收获地址
    public function editaddress(){
        //实例化
        $address = M('address');
        //接收数据
        $where['id'] = I('get.id','','strip_tags');
        $data['user_id'] = I('get.user_id','','strip_tags');
        $data['address'] = I('get.address','','strip_tags');
        $data['officer'] = I('get.officer','','strip_tags');
        $data['address_phone'] = I('get.address_phone','','strip_tags');
        // dump($data);exit;
        //执行修改
        $info = $address->where($where)->save($data);
        if($info){
            $allinfo['code'] = 1;
            $allinfo['sucmsg'] = '修改成功';
        }else{
            $allinfo['code'] = 0;
            $allinfo['sucmsg'] = '修改失败';            
        }
        $this->ajaxreturn($allinfo);
    }

    //修改成默认
    public function defaddress(){
        //实例化
        $address = M('address');
        M()->startTrans();
        //接受值
        $where1['id'] = I('get.id','','strip_tags');
        $where2['user_id'] = I('get.user_id','','strip_tags');
        //把以前的默认收获地址改成非默认
        $addressinfo = $address->where($where2)->select();
        // dump($addressinfo);exit;
        foreach($addressinfo as $k=>$v){
            if($v['default'] == 1){
                $where3['id'] = $v['id'];
                $date['default'] = 2;
                $info1 = $address->where($where3)->save($date);
            }
        }
        //把现在的这个改成默认
        $data['default'] = 1;
        $info2 = $address->where($where1)->save($data);
        if($info1 && $info2){
            M()->commit();
            $info['code'] = 1;
            $info['sucmsg'] = '设置成功';
        }else{
            M()->rollback();
            $info['code'] = 0;
            $info['sucmsg'] = '设置失败';
        }
        $this->ajaxreturn($info);
    }

//=============================================订单管理==================================

}