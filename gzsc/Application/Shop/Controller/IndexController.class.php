<?php
namespace Shop\Controller;
use Think\Controller;
class IndexController extends AllowController {

    public function index(){

    	//加载模板
        $this->display();
    }
}