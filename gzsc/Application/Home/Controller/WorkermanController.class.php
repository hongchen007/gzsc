<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {

	//加载登录页面
	public function index(){
		$this->display();
	}
    //验证码
    public function verify(){
    	$verify=new \Think\Verify();
    	$verify->fontSize=14;
    	$verify->length=4;
    	$verify->useNoise=false;
    	$verify->entry();
    }
	//执行登录
	public function login(){
        $User=M('user');
    	$verify=new \Think\Verify();
        if(!$verify->check($_POST['code'],"")){
            $this->ajaxreturn(1);
            exit;
        }
		$name = I('post.user',0,'strip_tags');
		$loginpwd = I('post.loginpwd',0,'strip_tags');
		$loginpwd1 = I('post.loginpwd1',0,'strip_tags');
		$info = $User->where("loginname = '{$name}' OR  phone = '{$name}' OR email = '{$name}'")->find();
		if(!$loginpwd){
			$this->ajaxreturn(2);exit;
		}elseif($loginpwd !== $loginpwd1){
			$this->ajaxreturn(3);exit;
		}elseif(!$name){
			$this->ajaxreturn(4);exit;
		}elseif(!$info){
			$this->ajaxreturn(5);exit;
		}elseif(md5($loginpwd) !== $info['loginpwd']){
			$this->ajaxreturn(6);exit;
		}else{
			$this->ajaxreturn(7);exit;
		}
	}
	//加载注册页面
    public function register(){
        $this->display();
    }
    //注册
    public function zhuce(){
    	if(IS_POST){
    		$User = M('user');
    		$phone = I('post.phone',0,'strip_tags');
    		if(!$phone){
    			echo 2;exit;
    		}
    		$info = $User->where("phone = '{$phone}'")->find();
    		if($info){
    			echo 3;exit;
    		}
    		$result = $User->Open($phone);
    		$this->ajaxreturn($result);
    	}
    }

 
    // public function login(){
    //     $name=$_POST['name'];
    //     $pwd=$_POST['pwd'];

    //     echo "111";
    //     // $this->ajaxreturn('akakkj');
    //     // $this->ajaxreturn('jnjjkjh');
    // } 

}