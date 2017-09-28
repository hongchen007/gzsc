<?php
namespace Shop\Controller;
use Think\Controller;
class AllowController extends Controller {
    //controller 控制器初始化方法
    public function _initialize(){
    	//检测session信息是否存在
    	if(!$_SESSION['info']){
    		$this->error('请先登录后台',U('Login/index'),1);
    	}
    }
}