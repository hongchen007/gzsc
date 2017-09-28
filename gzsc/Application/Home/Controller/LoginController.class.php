<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
	//加载登录页面
	public function index(){
        // echo '11100';

		$this->display();

	}
    //执行登录
    public function dologin(){
        //实例化
        $user=M('user');
        //接受值
        $where1['user_name'] = $name = I('get.username','','strip_tags');
        $pwd = I('get.pwd','','strip_tags');
        $where1['user_pwd'] = md5($pwd);
        // echo $name;
        // echo $pwd;
        //查询数据
        $info=$user->where("user_name='{$name}' OR user_phone='{$name}' OR user_store_name='{$name}'")->filter('strip_tags')->find();
        // dump($info);exit;
        // $grade=array(2); 15538165120
        if($info){
            if($info['user_pwd']==md5($pwd)){
                if($info['user_grade'] == 6){
                    $this->ajaxreturn(3); //你的账号被禁锢，请联系管理员
                    exit;                    
                }else{
                    $_SESSION['Login']['id'] = $info['id'];
                    $info=$user->where("user_name='{$name}' OR user_phone='{$name}'")->filter('strip_tags')->find();
                    // dump($info);exit;
                    $info['user_pic'] = $info['user_pic'];
                    $this->ajaxreturn($info,'JSON');
                    exit;
                }
            }else{
                $this->ajaxreturn(2);//密码错误
                exit;
            }
        }else{
            $this->ajaxreturn(1);//用户名不存在
            exit;
        }
    }
    //忘记密码
    public function forgetpwd(){
        //实例化
        $user = M('user');
        //接收值
        $user_name = I('get.user_name','','strip_tags');
        $user_id   = I('get.user_id','','strip_tags'); 
        $user_pwd  = I('get.user_pwd','','strip_tags');
        $user_pwd1 = I('get.user_pwd1','','strip_tags');
        $pwd = $data['user_pwd'] = md5($user_pwd);
        $info = $user->where("user_name='{$user_name}'")->filter('strip_tags')->find();
        // dump($info);exit;
        //判断
        if($info){
            if($user_id){
                if($user_pwd){
                    // if ($pwd == $info['user_pwd']){
                        if($user_pwd == $user_pwd1){
                            if($info['user_id'] == $user_id){ 
                                // if($pwd == $info['user_pwd']){}
                                $user_info = $user->where("user_name='{$user_name}'")->field('id')->find();
                                $data['id'] = $user_info['id'];
                                // dump($data);exit;
                                if($user->save($data)){
                                    $this->ajaxreturn(7);//找回密码成功
                                    exit;
                                }else{
                                    $this->ajaxreturn(6);//找回密码失败，请重新再试2
                                    exit;
                                }
                            }else{
                                $this->ajaxreturn(5);//身份证号不对
                                exit;
                            }
                        }else{
                            $this->ajaxreturn(4);//两次密码不一样
                            exit;   
                        }
                    // }else{
                    //     $this->ajaxreturn(8);//以上次密码一样
                    // }
                }else{
                    $this->ajaxreturn(3);//第一次的密码不能为空
                    exit; 
                }
            }else{
                $this->ajaxreturn(2);//身份证号不能为空
                exit;
            }
        }else{
            $this->ajaxreturn(1);//用户名不存在
            exit;
        }
    }
    //重置密码
    public function resetpwd(){
        $user = M('user');
        // $id = session('id');
        // $id = 27;
        $id = I('get.user_id','','strip_tags');
        $user_pwd = I('get.user_pwd','','strip_tags');
        $newpwd1 = I('get.newpwd1','','strip_tags');
        $newpwd2 = I('get.newpwd2','','strip_tags');
        $data['user_pwd'] = md5($newpwd1);
        $info = $user->where("id=$id")->field('user_pwd')->find();
        if(md5($user_pwd) == $info['user_pwd']){
            if($newpwd1){
                if($newpwd1 == $newpwd2){
                    if($user->where("id=$id")->save($data)){
                        $this->ajaxreturn(5);
                    }else{
                        $this->ajaxreturn(4);//重置密码失败
                    }
                }else{
                    $this->ajaxreturn(3);//两次新密码不正确
                }
            }else{
                $this->ajaxreturn(2);//新密码不能为空
            }
        }else{
            $this->ajaxreturn(1);//原不正确
        }
    }
    //地址的处理
    public function http_curl($url,$type='get',$res='json',$arr=''){

        //1.初始化curl
        $ch  =curl_init();
        //2.设置curl的参数
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        if($type == 'post'){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
        }
        //3.采集
        $output =curl_exec($ch);

        //4.关闭
        curl_close($ch);
        if($res=='json'){
            if(curl_error($ch)){
                //请求失败，返回错误信息
                return curl_error($ch);
            }else{
                //请求成功，返回错误信息

                return json_decode($output,true);
            }
        }
        echo var_dump( $output );
    }
    //获取验证码
    public function code(){
        //实例化
        $tel_code = M('tel_code');
        $user    = M('user');
        M()->startTrans();
        //接收值
        $tel = I('get.tel','','strip_tags');
        //查询数据库
        $starttime = date('Y-m-d H:i:s',time()-60);
        $where['addtime'] = array('GT',$starttime);
        $where['tel'] = $map['user_phone'] = $tel = I('get.tel','','strip_tags');
        $userinfo = $user->where($map)->field('id')->find();
        $codeinfo = $tel_code->where($where)->order('id desc')->find();
        // 判断该手机号是否已近被注册，一分钟内是否多次请求过
        if($userinfo){
            $suc['msg'] = '该手机号已经被注册！';
            $suc['state'] = '3';           
        }else{
            if($codeinfo){
                $suc['msg'] = '验证码已发过！';
                $suc['state'] = '2';
            }else{
                $data['code'] = $code = mt_rand(100000,999999);
                $data['addtime'] = date('Y-m-d H:i:s');
                $data['tel'] = $tel;
                $addcode = $tel_code->add($data);
                //发送短信请求
                $url = "http://smsapi.c123.cn/OpenPlatform/OpenApi?action=sendOnce&ac=1001@501395970001&authkey=E0B5E977FC315705D7F38DE948B2031E&cgid=8896&csid=&c=%e7%9f%ad%e4%bf%a1%e9%aa%8c%e8%af%81%e7%a0%81%e4%b8%ba%ef%bc%9a$code&m=$tel";
                $html = file_get_contents($url);
                $p = xml_parser_create();
                xml_parse_into_struct($p, $html, $vals, $index);
                xml_parser_free($p);
                $rescode = $vals[0]['attributes']['RESULT'];
                if($rescode == 1){
                    $suc['msg'] = '发送成功！';
                    $suc['state'] = '1';
                    M()->commit();
                }else if($rescode == 0){
                    $suc['msg'] = '帐户格式不正确(正确的格式为:员工编号@企业编号)！';
                    $suc['state'] = '0';
                    M()->rollback();              
                }else if($rescode == -1){
                    $suc['msg'] = '服务器拒绝(速度过快、限时或绑定IP不对等)如遇速度过快可延时再发！';
                    $suc['state'] = '-1';
                    M()->rollback();               
                }else if($rescode == -2){
                    $suc['msg'] = '密钥不正确！';
                    $suc['state'] = '-2';
                    M()->rollback();               
                }else if($rescode == -3){
                    $suc['msg'] = '密钥已锁定！';
                    $suc['state'] = '-3';
                    M()->rollback();               
                }else if($rescode == -4){
                    $suc['msg'] = '参数不正确(内容和号码不能为空，手机号码数过多，发送时间错误等)！';
                    $suc['state'] = '-4';
                    M()->rollback();              
                }else if($rescode == -5){
                    $suc['msg'] = '无此帐户！';
                    $suc['state'] = '-5';
                    M()->rollback();              
                }else if($rescode == -6){
                    $suc['msg'] = '帐户已锁定或已过期！';
                    $suc['state'] = '-6';
                    M()->rollback();           
                }else if($rescode == -7){
                    $suc['msg'] = '帐户未开启接口发送！';
                    $suc['state'] = '-7';
                    M()->rollback();             
                }else if($rescode == -8){
                    $suc['msg'] = '不可使用该通道组！';
                    $suc['state'] = '-8';
                    M()->rollback();             
                }else if($rescode == -9){
                    $suc['msg'] = '帐户余额不足！';
                    $suc['state'] = '-9';
                    M()->rollback();              
                }else if($rescode == -10){
                    $suc['msg'] = '内部错误！';
                    $suc['state'] = '-10';
                    M()->rollback();
                }else{
                    $suc['msg'] = '扣费失败！';
                    $suc['state'] = '-11';
                    M()->rollback();               
                }
            }            
        }
        $this->ajaxreturn($suc,"JSON");  
    }
    //注册
    public function register(){
        //实例化
        $user = D('user');
        $tel_code = M('tel_code');
        M()->startTrans();
        //接收数据
        $user_name  = I('get.user_name','','strip_tags');
        $user_id    = I('get.user_id','','strip_tags');
        $user_pwd   = I('get.user_pwd','','strip_tags');
        $tel        = I('get.tel','','strip_tags');
        $code       = I('get.code','','strip_tags');
        $user_grade = I('get.user_grade','','strip_tags');//4未激活商户;5会员
        //验证
        if(empty($user_name)){
            $suc['msg'] = '昵称不能为空';
            $suc['state'] = -1;
            $this->ajaxreturn($suc,'JSON'); 
        }
        if(empty($user_id)){
            $suc['msg'] = '生份证号不能为空';
            $suc['state'] = -2;
            $this->ajaxreturn($suc,'JSON'); 
        }
        if(empty($user_pwd)){
            $suc['msg'] = '密码不能为空';
            $suc['state'] = -3;
            $this->ajaxreturn($suc,'JSON'); 
        }
        if(empty($code)){
            $suc['msg'] = '验证码不能为空';
            $suc['state'] = -4;
            $this->ajaxreturn($suc,'JSON'); 
        }
        if(!preg_match("/^([\d]{17}[xX\d]|[\d]{15})$/",$user_id)){
            $suc['msg'] = '生份证号格式不对';
            $suc['state'] = -5;
            $this->ajaxreturn($suc,'JSON');    
        }
        if(!preg_match("/\w{6,12}/",$user_pwd)){
            $suc['msg'] = '密码格式不对';
            $suc['state'] = -6;
            $this->ajaxreturn($suc,'JSON');      
        }

        //首先验证验码是否失效
        $starttime = date('Y-m-d H:i:s',time()-300);
        $where['addtime'] = array('GT',$starttime);
        $where['tel'] = $tel;
        $codeinfo = $tel_code->where($where)->order('id desc')->find();
        // dump($codeinfo);
        if(empty($codeinfo)){
            $suc['msg'] = '验证码过期，请重新获取';
            $suc['state'] = -7;   
            $this->ajaxreturn($suc,'JSON');           
        }else{
            if($codeinfo['code'] != $code){
                $suc['msg'] = '验证码不正确';
                $suc['state'] = -8;  
                $this->ajaxreturn($suc,'JSON');                  
            }else{
                $map1['user_name']  = $user_name;
                $mapinfo1 = $user->where($map1)->find();
                if($mapinfo1){
                    $suc['msg'] = '该昵称已经存在';
                    $suc['state'] = -9;   
                    $this->ajaxreturn($suc,'JSON');                 
                }else{
                    $map2['user_id'] = $user_id;
                    $mapinfo2 = $user->where($map2)->find();
                    if($mapinfo2){
                        $suc['msg'] = '该身份证已经存在';
                        $suc['state'] = -10;   
                        $this->ajaxreturn($suc,'JSON');                 
                    }else{
                        $map3['user_phone'] = $user_phone;
                        $mapinfo3 = $user->where($map3)->find();
                        if($mapinfo3){
                            $suc['msg'] = '该手机号已经被注册';
                            $suc['state'] = -11;    
                            $this->ajaxreturn($suc,'JSON');                
                        }else{
                            $date['user_name']  = $user_name;
                            $date['user_id']    = $user_id;
                            $date['user_grade'] = $user_grade;
                            $date['user_pwd']   = md5($user_pwd);
                            $date['user_phone'] = $tel;
                            if($user->add($date)){
                                M()->commit();
                                $suc['msg'] = '注册成功！';
                                $suc['state'] = 1; 
                                $this->ajaxreturn($suc,'JSON'); 
                            }else{
                                M()->rollback();
                                $suc['msg'] = '注册失败！';
                                $suc['state'] = -12; 
                                $this->ajaxreturn($suc,'JSON'); 
                            }
                        }
                    }                   
                }  
            }
        }
    }
}