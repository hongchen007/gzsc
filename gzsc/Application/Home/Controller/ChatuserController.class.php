<?php
namespace Home\Controller;
use Think\Controller;
class ChatuserController extends Controller {

    //个人中心
    public function per_cen(){
        //实例化
        $chat_user = M('chat_user');
        $user = M('user');
        //接收数据
        $where['user_id'] = I('get.id','','strip_tags');
        //查询数据
        $info = $chat_user->where($where)->find();
        if($info){
            $suc['code'] = 1;
            $suc['anno'] = "请求成功";
            $suc['msg']  = $info;
        }else{
            $suc['code'] = -1;
            $suc['anno'] = "请求失败";
            $suc['msg']  = "";            
        }
        $this->ajaxreturn($suc,'JSON');
    }

    //修改头像
    public function editheadpic(){
        //实例化
        $chat_user = M('chat_user');
        //接收数据
        $where['id'] = I('get.id','','strip_tags');
        $data['headpic'] = I('get.headpic','','strip_tags');
      
        if($chat_user->where($where)->save($data)){
            $suc['code'] = 1;
            $suc['anno'] = "修改成功";
        }else{
            $suc['code'] = -1;
            $suc['anno'] = "修改失败";            
        }
        $this->ajaxreturn($suc,'JSON');
    }

    //修改性别
    public function editsex(){
        //实例化
        $chat_user = M('chat_user');
        //接收数据
        $where['id'] = I('get.id','','strip_tags');
        $data['sex'] = I('get.sex','','strip_tags');
        // dump($data);exit;
        if($chat_user->where($where)->save($data)){
            $suc['code'] = 1;
            $suc['anno'] = "修改成功";
        }else{
            $suc['code'] = -1;
            $suc['anno'] = "修改失败";            
        }
        $this->ajaxreturn($suc,'JSON');
    }

    //修改地区
    public function editaddress(){
        //实例化
        $chat_user = M('chat_user');
        //接收数据
        $where['id'] = I('get.id','','strip_tags');
        $data['address'] = I('get.address','','strip_tags');
        // dump($data);exit;
        if($chat_user->where($where)->save($data)){
            $suc['code'] = 1;
            $suc['anno'] = "修改成功";
        }else{
            $suc['code'] = -1;
            $suc['anno'] = "修改失败";            
        }
        $this->ajaxreturn($suc,'JSON');
    }

    //修改个人介绍
    public function editself_intro(){
        //实例化
        $chat_user = M('chat_user');
        //接收数据
        $where['id'] = I('get.id','','strip_tags');
        $data['self_intro'] = I('get.self_intro','','strip_tags');
        // dump($data);exit;
        if($chat_user->where($where)->save($data)){
            $suc['code'] = 1;
            $suc['anno'] = "修改成功";
        }else{
            $suc['code'] = -1;
            $suc['anno'] = "修改失败";            
        }
        $this->ajaxreturn($suc,'JSON');
    }

}