<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends AllowController {

	//商户列表
    public function index(){
        //实例化
        $User = M('user');
        //搜索条件
        $where1=array();
        if(!empty($_GET['user_name'])){
            $where1['user_name'] = array('like',"%{$_GET['user_name']}%");
        }
        if(!empty($_GET['user_store_name'])){
            $where1['user_store_name'] = array('like',"%{$_GET['user_store_name']}%");
        }
        if(!empty($_GET['user_grade'])){
            $where1['user_grade'] = $_GET['user_grade'];
        }

        //查询数据
        $where['user_grade'] = array('in','2,3,4');

        $count = $User->where($where)->where($where1)->count();
        $p = getpage($count,10);

        $UserInfo = $User->where($where)->where($where1)->limit($p->firstRow, $p->listRows)->select();
        // dump($UserInfo);exit;
    	//加载模板,分配变量
    	$this->assign('UserInfo',$UserInfo);
        $this->assign('page', $p->show()); // 赋值分页输出
        $this->display();
    }

    //删除商户
    public function del(){
    	//实例化
    	$User = M('user');
    	//接收值
    	$id = $_GET['id'];
    	//删除数据库数据
    	$info = $User->where("id=$id")->delete();
    	//返回
		if($info){
		    $this->success('删除成功', U('User/index'));
		} else {
		    $this->error('删除失败');
		}
    }

    //加载添加商户页面
    public function insert(){
    	//加载模板
    	$this->display();
    }

    //执行添加商户
    public function doinsert(){
        //实例化Model类
        $user = M('user');
        //验证规则  
        $rules  = array(
          array('user_name','require','用户名不能为空!'), 
          array('user_name','','用户名已经存在！',0,'unique',1), 
          array('user_store_name','require','商户名不能为空!'),
          array('user_store_name','','商户名已经存在！',0,'unique',1), 
          array('user_id','require','生份证号不能为空!'), 
          array('user_id','','生份证号已经存在！',0,'unique',1), 
          array('user_id','/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/','生份证号格式不对!'), 
          array('user_store_address','require','商户地址不能为空!'), 
          array('user_store_pic','require','商户图片不能为空!'), 
          array('user_store_lience','require','商户营业执照号不能为空!'), 
          array('user_store_lience','/^[0-9]*$/','商户营业执照号必须为数字!'), 
          array('user_store_lience','','户营业执照号已经存在！',0,'unique',1), 
          array('user_store_registered','require','商户注册资金不能为空!'), 
          array('user_store_registered','/^[0-9]*$/','商户注册资金必须为数字!'), 
          array('user_store_cash','require','商户保证金不能为空!'), 
          array('user_store_cash','/^[0-9]*$/','商户保证金必须为数字!'), 
          array('user_store_percent','require','抽成百分比不能为空!'), 
          array('user_store_percent','/^[0-9]{1,2}?$/','抽成百分比必须为一到两位的正整数!'), 
        );
        if (!$user->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($user->getError());
        }
        // //实例化文件上传类
        // $upload=new \Think\Upload();
        // //设置参数
        // $upload->maxSize=0;//允许上传图片大小
        // $upload->exts=array('jpg','jpeg','png','gif');//允许上传图片类型
        // $upload->rootPath="./Public/Uploads/";//保存上传图片路径
        // //执行上传
        // $info=$upload->upload();
        // if(!$info){
        //     $this->error($upload->getError());
        // }else{
        //     //遍历
        //     foreach($info as $key=>$file){
        //         $path=$file['savepath'].$file['savename'];
        //     }
        // }
        $data['user_name']=I('post.user_name','','strip_tags');
        $data['user_store_name']=I('post.user_store_name','','strip_tags');
        $data['user_id']=I('post.user_id','','strip_tags');
        $data['user_store_address']=I('post.user_store_address','','strip_tags');
        $data['user_store_lience']=I('post.user_store_lience','','strip_tags');
        $data['user_store_cash']=I('post.user_store_cash','','strip_tags');
        $data['user_store_registered']=I('post.user_store_registered','','strip_tags');
        $data['user_store_percent']=I('post.user_store_percent','','strip_tags');
        $data['user_add_time']=date('Y-m-d H:i:s');
        $data['user_pwd']=md5(123456);
        $data['user_grade']=4;
        $address = $data['user_store_address'];
        $ab = "http://restapi.amap.com/v3/geocode/geo?address=$address&output=JSON&key=5e1d907387689cd2c224b15ca8267a41";
        $ab = file_get_contents($ab);
        $bc = json_decode($ab,true);
        $cd = $bc['geocodes'][0]['location'];
        $dc = explode(',',$cd);
        $data['user_store_x'] = $dc[0];
        $data['user_store_y'] = $dc[1];
        // dump($data);exit;
        if($user->add($data)){ 
            $this->success('添加成功',U('User/index'));
        }else{
            $this->error('添加失败');
        }

    }

    //禁用商户
    public function stop(){
        //实例化
        $user=M('user');
        //接受值
        $data['id'] = $_GET['id'];
        $data['user_grade'] = 3;
        //更新
        if($user->save($data)){
            $this->success('禁用成功',U('User/index'));
        }else{
            $this->error('禁用失败');
        }
    }

    //启用商户
    public function start(){
        //实例化
        $user=M('user');
        //接受值
        $data['id'] = $_GET['id'];
        $data['user_grade'] = 2;
        //更新
        if($user->save($data)){
            $this->success('启用成功',U('User/index'));
        }else{
            $this->error('启用失败');
        }
    }

    //激活商户
    public function jihuo(){
        //实例化
        $user=M('user');
        //接受值
        $data['id'] = $_GET['id'];
        $data['user_grade'] = 2;
        //更新
        if($user->save($data)){
            $this->success('激活成功',U('User/index'));
        }else{
            $this->error('激活失败');
        }
    }

    //查看商户
    public function shopinfo(){
        //实例化
        $user=M('user');
        //接受值
        $data['id'] = $_GET['id'];
        //查询数据
        $info = $user->where($data)->find();
        // dump($info);exit;
        $this->assign('info',$info);
        $this->display();
    }

    //加载修改商户页面
    public function edit(){
        //实例化
        $user=M('user');
    	//接收值
    	$id = $_GET['id'];
        //查询数据
        $info=$user->where("id=$id")->find();
    	//加载页面，分配数据
    	$this->assign('info',$info);
    	$this->display();
    }

    //执行修改商户
    public function update(){
        //实例化Model类
        $user = M('user');

        //验证规则
        $rules  = array(
          array('user_name','require','用户名不能为空!'), 
          array('user_store_name','require','商户名不能为空!'),
          array('user_id','require','生份证号不能为空!'), 
          array('user_id','/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/','生份证号格式不对!'), 
          array('user_store_address','require','商户地址不能为空!'), 
          array('user_store_pic','require','商户图片不能为空!'), 
          array('user_store_lience','require','商户营业执照号不能为空!'), 
          array('user_store_lience','/^[0-9]*$/','商户营业执照号必须为数字!'), 
          array('user_store_registered','require','商户注册资金不能为空!'), 
          array('user_store_registered','/^[0-9]*$/','商户注册资金必须为数字!'), 
          array('user_store_cash','require','商户保证金不能为空!'), 
          array('user_store_cash','/^[0-9]*$/','商户保证金必须为数字!'), 
          array('user_store_percent','require','抽成百分比不能为空!'), 
          array('user_store_percent','/^[0-9]{1,2}?$/','抽成百分比必须为一到两位的正整数!'), 
        );

        if(!$user->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($user->getError());
        }
        $data['user_name']=I('post.user_name','','strip_tags');
        $data['user_store_name']=I('post.user_store_name','','strip_tags');
        $data['user_id']=I('post.user_id','','strip_tags');
        $data['user_store_address']=I('post.user_store_address','','strip_tags');
        $data['user_store_lience']=I('post.user_store_lience','','strip_tags');
        $data['user_store_cash']=I('post.user_store_cash','','strip_tags');
        $data['user_store_registered']=I('post.user_store_registered','','strip_tags');
        $data['user_store_percent']=I('post.user_store_percent','','strip_tags');
        $id=I('post.id','','strip_tags');
        $pic=I('post.xgpic','','strip_tags');
        $row=$user->find($id);
        //经纬度
        $address = $data['user_store_address'];
        $ab = "http://restapi.amap.com/v3/geocode/geo?address=$address&output=JSON&key=5e1d907387689cd2c224b15ca8267a41";
        $ab = file_get_contents($ab);
        $bc = json_decode($ab,true);
        $cd = $bc['geocodes'][0]['location'];
        $dc = explode(',',$cd);
        $data['user_store_x'] = $dc[0]; //精度
        $data['user_store_y'] = $dc[1]; //纬度
        // dump($data);exit;
        //验证唯一性
        $id=I('post.id','','strip_tags');
        $where['user_grade'] = array('in','2,3,4');
        $userinfo=$user->where($where)->field('id,user_name,user_store_name,user_id,user_store_lience')->select();
        //排除自己信息的其他信息
        foreach($userinfo as $k=>$v){
            if($v['id'] == $id){
                unset($userinfo[$k]);
            }
        }
        $user_name=array();
        $user_store_name=array();
        $user_id=array();
        $user_store_lience=array();
        foreach($userinfo as $ke=>$va){
            $user_name[] = $va['user_name'];
            $user_store_name[] = $va['user_store_name'];
            $user_id[] = $va['user_id'];
            $user_store_lience[] = $va['user_store_lience'];
        }
        if(in_array($data['user_name'],$user_name)){
            $this->error('用户名已存在！');
        }
        if(in_array($data['user_store_name'],$user_store_name)){
            $this->error('商户名已存在！');
        }
        if(in_array($data['user_id'],$user_id)){
            $this->error('省份证号已经存在！');
        }
        if(in_array($data['user_store_lience'],$user_store_lience)){
            $this->error('商户营业执照号已存在！');
        }
        

        //判断是否修改商品图片
        // if($pic == null){
        //     //执行修改
        //     if($user->where("id=$id")->save($data)){
        //         //跳转
        //         $this->success('修改成功',U('User/index'));
        //     }else{
        //         $this->error('修改失败');
        //     }
        // }else{
        //     //实例化文件上传类
        //     $upload=new \Think\Upload();
        //     //设置参数
        //     $upload->maxSize=0;//允许上传图片大小
        //     $upload->exts=array('jpg','jpeg','png','gif');//允许上传图片类型
        //     $upload->rootPath="./Public/Uploads/";//保存上传图片路径
        //     //执行上传
        //     $info=$upload->upload();
        //     if(!$info){
        //        $this->error($upload->getError());
        //     }else{
        //         //遍历
        //         foreach($info as $key=>$file){
        //            $path=$file['savepath'].$file['savename'];
        //         }
        //     }
        //     $data['user_store_pic']=$path;
            // dump($data);exit;
            //执行修改
            if($user->where("id=$id")->save($data)){
             // unlink('./Public/Uploads/'.$row['user_store_pic']);//删除图片
             $this->success('修改成功',U('User/index'));
            }else{
                $this->error('修改失败');
            }
        // }             
    }

//====================================用户操作======================================================


    //加载添加用户页面
    public function insert_user(){
        //加载模板
        $this->display();
    }
    //执行添加
    public function doinsert_user(){
        //实例化Model类
        $user = M('user');
        //验证规则  
        $rules  = array(
          array('user_name','require','用户名不能为空!'), 
          array('user_name','','用户名已经存在！',0,'unique',1), 
        );
        if (!$user->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($user->getError());
        }
        $data['user_name']=I('post.user_name','','strip_tags');
        $data['user_sex']=I('post.user_sex','','strip_tags');
        $data['user_phone']=I('post.user_phone','','strip_tags');
        $data['user_add_time']=date('Y-m-d H:i:s');
        $data['user_pwd']=md5(123456);
        $data['user_grade']=5;
        // dump($pic);exit;

        //执行添加
        if($user->add($data)){ 
            $this->success('添加成功',U('User/index_user'));
        }else{
            $this->error('添加失败');
        }
    }
    //加载显示页面
    public function index_user(){
        //实例化
        $User = M('user');
        //搜索条件
        $where1=array();
        if(!empty($_GET['user_name'])){
            $where1['user_name'] = array('like',"%{$_GET['user_name']}%");
        }
        if(!empty($_GET['user_grade'])){
            $where1['user_grade'] = $_GET['user_grade'];
        }
        //查询数据
        $where['user_grade'] = array('in','5,6');

        $count = $User->where($where)->where($where1)->count();
        $p = getpage($count,10);

        $UserInfo = $User->where($where)->where($where1)->limit($p->firstRow, $p->listRows)->select();
        // dump($UserInfo);exit;
        //加载模板,分配变量
        $this->assign('UserInfo',$UserInfo);
        $this->assign('page', $p->show()); // 赋值分页输出
        $this->display();
    }
    //禁用用户
    public function stop_user(){
        //实例化
        $user=M('user');
        //接受值
        $data['id'] = $_GET['id'];
        $data['user_grade'] = 6;
        //更新
        if($user->save($data)){
            $this->success('禁用成功',U('User/index_user'));
        }else{
            $this->error('禁用失败');
        }
    }
    //启用用户
    public function start_user(){
        //实例化
        $user=M('user');
        //接受值
        $data['id'] = $_GET['id'];
        $data['user_grade'] = 5;
        //更新
        if($user->save($data)){
            $this->success('启用成功',U('User/index_user'));
        }else{
            $this->error('启用失败');
        }
    }
    //删除用户
    public function del_user(){
        //实例化
        $User = M('user');
        //接收值
        $id = $_GET['id'];
        //删除数据库数据
        $info = $User->where("id=$id")->delete();
        //返回
        if($info){
            $this->success('删除成功', U('User/index_user'));
        } else {
            $this->error('删除失败');
        }
    }
    //加载修改页面
    public function edit_user(){
        //实例化
        $user=M('user');
        //接收值
        $id = $_GET['id'];
        //查询数据
        $info=$user->where("id=$id")->find();
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();
    }
    //执行修改
    public function update_user(){
        //实例化Model类
        $user = M('user');
        $rules  = array(
          array('user_name','require','用户名不能为空!'), 
        );

        if(!$user->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($user->getError());
        }
        $data['user_name']=I('post.user_name','','strip_tags');
        $data['user_phone']=I('post.user_phone','','strip_tags');
        $data['user_pwd']=md5(123456);
        $id=I('post.id','','strip_tags');

        //验证唯一性
        $where['user_grade'] = array('in','5,6');
        $userinfo=$user->where($where)->field('id,user_phone,user_name')->select();
        //排除自己信息的其他信息
        foreach($userinfo as $k=>$v){
            if($v['id'] == $id){
                unset($userinfo[$k]);
            }
        }
        $user_name=array();
        $user_phone=array();
        foreach($userinfo as $ke=>$va){
            $user_name[] = $va['user_name'];
            $user_phone[] = $va['user_phone'];
        }
        if(in_array($data['user_name'],$user_name)){
            $this->error('用户名已存在！');
        }
        if($data['user_phone']){
            if(in_array($data['user_phone'],$user_phone)){
                $this->error('手机号已存在！');
            }
        }

        //执行修改
        if($user->where("id=$id")->save($data)){
            $this->success('修改成功',U('User/index_user'));
        }else{
            $this->error('修改失败');
        }       
    }

//====================================管理员===============================================================

    //加载添加商户页面
    public function insert_admin(){
        //加载模板
        $this->display();
    }
    //执行添加商户
    public function doinsert_admin(){
        //实例化Model类
        $user = M('user');
        //验证规则  
        $rules  = array(
          array('user_name','require','管理员不能为空!'), 
          array('user_name','','管理员已经存在！',0,'unique',1), 
        );

        $data['user_name']=I('post.user_name','','strip_tags');
        $data['user_add_time']=date('Y-m-d H:i:s');
        $data['user_pwd']=md5(123456);
        $data['user_grade']=1;
        $pic=I('post.xgpic','','strip_tags');
        //判断是否有头像上传
        if($pic == null){
            //执行添加
            if($user->add($data)){ 
                $this->success('添加成功',U('User/index_admin'));
            }else{
                $this->error('添加失败');
            }
        }else{
            //实例化文件上传类
            $upload=new \Think\Upload();
            //设置参数
            $upload->maxSize=0;//允许上传图片大小
            $upload->exts=array('jpg','jpeg','png','gif');//允许上传图片类型
            $upload->rootPath="./Public/Uploads/";//保存上传图片路径
            //执行上传
            $info=$upload->upload();
            if(!$info){
               $this->error($upload->getError());
            }else{
                //遍历
                foreach($info as $key=>$file){
                   $path=$file['savepath'].$file['savename'];
                }
            }
            $data['user_pic']=$path;
            // dump($data);exit;
            //执行添加
            if($user->add($data)){ 
                $this->success('添加成功',U('User/index_admin'));
            }else{
                $this->error('添加失败');
            }
        }
    }
    //管理员列表
    public function index_admin(){
        //实例化
        $User = M('user');
        //搜索条件
        $where1=array();
        if(!empty($_GET['user_name'])){
            $where1['user_name'] = array('like',"%{$_GET['user_name']}%");
        }
        if(!empty($_GET['user_grade'])){
            $where1['user_grade'] = $_GET['user_grade'];
        }
        //查询数据
        $where['user_grade'] = array('in','1,11');

        $count = $User->where($where)->where($where1)->count();
        $p = getpage($count,10);

        $UserInfo = $User->where($where)->where($where1)->limit($p->firstRow, $p->listRows)->select();
        // dump($UserInfo);exit;
        //加载模板,分配变量
        $this->assign('UserInfo',$UserInfo);
        $this->assign('page', $p->show()); // 赋值分页输出
        $this->display();
    }
    //禁用管理员
    public function stop_admin(){
        //实例化
        $user=M('user');
        //接受值
        $data['id'] = $_GET['id'];
        $data['user_grade'] = 11;
        //更新
        if($user->save($data)){
            $this->success('禁用成功',U('User/index_admin'));
        }else{
            $this->error('禁用失败');
        }
    }
    //启用管理员
    public function start_admin(){
        //实例化
        $user=M('user');
        //接受值
        $data['id'] = $_GET['id'];
        $data['user_grade'] = 1;
        //更新
        if($user->save($data)){
            $this->success('启用成功',U('User/index_admin'));
        }else{
            $this->error('启用失败');
        }
    }
    //删除管理员
    public function del_admin(){
        //实例化
        $User = M('user');
        //接收值
        $id = $_GET['id'];
        //删除数据库数据
        $info = $User->where("id=$id")->delete();
        //返回
        if($info){
            $this->success('删除成功', U('User/index_admin'));
        } else {
            $this->error('删除失败');
        }
    }
    //加载修改页面
    public function edit_admin(){
        //实例化
        $user=M('user');
        //接收值
        $id = $_GET['id'];
        //查询数据
        $info=$user->where("id=$id")->find();
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();
    }
    //执行修改
    public function update_admin(){
        //实例化Model类
        $user = M('user');
        $rules  = array(
          array('user_name','require','管理员名不能为空!'), 
          array('user_pwd','require','密码不能为空!'), 
          array('user_name','','管理员名称已经存在！',0,'unique',1),
          array('user_pwd','user_pwd1','两次密码不一样',0,'confirm'),
        );

        if(!$user->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($user->getError());
        }
        $data['user_name']=I('post.user_name','','strip_tags');
        $data['user_pwd']=md5(I('post.user_pwd','','strip_tags'));
        $id=I('post.id','','strip_tags');
        $pic=I('post.xgpic','','strip_tags');
        $row=$user->find($id);
        // dump($row);
        // dump($pic);exit;
        // dump($data);exit;

        //验证唯一性
        $where['user_grade'] = array('in','1,11');
        $userinfo=$user->where($where)->field('id,user_name')->select();
        //排除自己信息的其他信息
        foreach($userinfo as $k=>$v){
            if($v['id'] == $id){
                unset($userinfo[$k]);
            }
        }
        $user_name=array();
        foreach($userinfo as $ke=>$va){
            $user_name[] = $va['user_name'];
        }
        if(in_array($data['user_name'],$user_name)){
            $this->error('用户名已存在！');
        }

        //判断是否修改图片
        if($pic == null){
            //执行修改
            if($user->where("id=$id")->save($data)){
                //跳转
                $this->success('修改成功',U('User/index_admin'));
            }else{
                $this->error('修改失败');
            }
        }else{
            //实例化文件上传类
            $upload=new \Think\Upload();
            //设置参数
            $upload->maxSize=0;//允许上传图片大小
            $upload->exts=array('jpg','jpeg','png','gif');//允许上传图片类型
            $upload->rootPath="./Public/Uploads/";//保存上传图片路径
            //执行上传
            $info=$upload->upload();
            if(!$info){
               $this->error($upload->getError());
            }else{
                //遍历
                foreach($info as $key=>$file){
                   $path=$file['savepath'].$file['savename'];
                }
            }
            $data['user_pic']=$path;
            // dump($data);exit;
            //执行修改
            if($user->where("id=$id")->save($data)){
             unlink('./Public/Uploads/'.$row['user_pic']);//删除图片
             $this->success('修改成功',U('User/index_admin'));
            }else{
                $this->error('修改失败');
            }
        }             
    }

//====================================个人中心===================================================

    
    //加载个人中心页面
    public function index_self(){
        //实例化
        $User = M('user');
        //查询数据
        $map['id'] = $_SESSION['info']['id'];
        $UserInfo = $User->where($map)->select();
        // dump($UserInfo);exit;
        //加载模板,分配变量
        $this->assign('UserInfo',$UserInfo);
        $this->display();
    }
    
    //加载修改页面
    public function edit_self(){
        //实例化
        $user=M('user');
        //接收值
        $id = $_GET['id'];
        //查询数据
        $info=$user->where("id=$id")->find();
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();
    }
    //执行修改
    public function update_self(){
        //实例化表
        $user=M('user');
        //接受值
        $pwd=I('post.user_pwd2','','strip_tags');
        $id=I('post.id','','strip_tags');
        //查询数据
        $info=$user->where("id=$id")->find();
        if($info['user_pwd'] !== md5($pwd)){
            $this->error("原密码不正确");
        }else{
            $rules  = array(
            array('user_name','require','管理员名不能为空!'), 
            array('user_pwd','require','密码不能为空!'), 
            array('user_name','','管理员名称已经存在！',0,'unique',1),
            array('user_pwd','user_pwd1','两次密码不一样',0,'confirm'),
            );

            if(!$user->validate($rules)->create()){     
                // 如果创建失败 表示验证没有通过 输出错误提示信息     
                $this->error($user->getError());
            }
            $data['user_name']=I('post.user_name','','strip_tags');
            $data['user_pwd']=md5(I('post.user_pwd','','strip_tags'));
            $id=I('post.id','','strip_tags');
            $pic=I('post.xgpic','','strip_tags');
            $row=$user->find($id);
            // dump($row);
            // dump($pic);exit;
            // dump($data);exit;

            //判断是否修改商品图片
            if($pic == null){
                //执行修改
                if($user->where("id=$id")->save($data)){
                    //跳转
                    $this->success('修改成功',U('User/index_self'));
                }else{
                    $this->error('修改失败');
                }
            }else{
                //实例化文件上传类
                $upload=new \Think\Upload();
                //设置参数
                $upload->maxSize=0;//允许上传图片大小
                $upload->exts=array('jpg','jpeg','png','gif');//允许上传图片类型
                $upload->rootPath="./Public/Uploads/";//保存上传图片路径
                //执行上传
                $info=$upload->upload();
                if(!$info){
                   $this->error($upload->getError());
                }else{
                    //遍历
                    foreach($info as $key=>$file){
                       $path=$file['savepath'].$file['savename'];
                    }
                }
                $data['user_pic']=$path;
                // dump($data);exit;
                //执行修改
                if($user->where("id=$id")->save($data)){
                 unlink('./Public/Uploads/'.$row['user_pic']);//删除图片
                 $this->success('修改成功',U('User/index_self'));
                }else{
                    $this->error('修改失败');
                }
            }           
        }
    }
}