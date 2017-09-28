<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        // //实例化表
        // $user=M('user');
        // //查询条件
        // $where['user_grade'] = array('in','2,3');
        // //查询数据
        // $info = $user->where($where)->field('user_store_pic,user_store_pic1,user_store_pic2,user_store_pic3,user_store_pic4,user_store_name,user_store_address,user_phone,user_store_star')->select();
       	// echo json_encode($info);exit;
        //加载模板
        $this->display();
    }
}