<?php
namespace Shop\Controller;
use Think\Controller;
class StoreController extends AllowController {
     //封装一个方法，传进一个父类Id，返回其下的所有子类集合
    Public static function subtrr($arr,$id,$len=1){
        $subs = array();
        foreach($arr as $k=>$v){
            if($v['cate_pid'] == $id){
                $v['len'] = $len;
                $subs[] = $v;
                $subs = array_merge($subs,self::subtrr($arr,$v['id'],$len+1));
            }
        }
        return $subs;
    }
    public static function subtree($info,$id){
        $subs=array();
        foreach($info as $v){
            if($v['cate_pid']==$id){
                $subs[]=$v;
                $subs=array_merge($subs,self::subtree($info,$v['id']));
            }
        }
        return $subs;
    }
//===============================================商铺基本信息==================================================
    //加载添加商户信息页面
    public function insert(){
        //加载模板
        $this->display();
    }
    //执行添加商户信息
    public function doinsert(){
        //实例化Model类
        $user = M('user');

        //验证规则  
        $rules  = array(
          array('user_store_name','require','商户名不能为空!'),
          array('user_store_name','','商户名已经存在！',0,'unique',1), 
        );
        if (!$user->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($user->getError());
        }

        //实例化文件上传类
        $upload=new \Think\Upload();
        //设置参数
        $upload->maxSize=0;//允许上传图片大小
        $upload->exts=array('jpg','jpeg','png','gif');//允许上传图片类型
        $upload->rootPath="./Public/Uploads/";//保存上传图片路径
        $upload->autoCheck =  false;
        //执行上传
        $info=$upload->upload();
        // dump($info);exit;
        if(!$info){
            $this->error($upload->getError());
        }else{
            //遍历
            foreach($info as $k=>$v){
                $path[]=$v['savepath'].$v['savename'];
            }
        }
        if(count($path) !== 5){
            $this->error("请选择5张图片");
        }
        // dump($path);exit;
        $data['user_store_name']=I('post.user_store_name','','strip_tags');
        $data['user_store_pic']=$path['0'];
        $data['user_store_pic1']=$path['1'];
        $data['user_store_pic2']=$path['2'];
        $data['user_store_pic3']=$path['3'];
        $data['user_store_pic4']=$path['4'];
        $data['user_store_evaluate']=5;
        $id=$_SESSION['info']['id'];
        // dump($id);exit;
        if($user->where("id=$id")->save($data)){ 
            $this->success('添加成功',U('Store/index'));
        }else{
            $this->error('添加失败');
        }
    }
    //商户列表信息
    public function index(){
        //实例化
        $User = M('user');
        //查询数据
        $id=$_SESSION['info']['id'];
        $UserInfo = $User->where("id=$id")->find();
        // dump($UserInfo);exit;
        //加载模板,分配变量
        $this->assign('UserInfo',$UserInfo);
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
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();
    }
    //执行修改
    public function doedit(){
        //实例化
        $user = M('user');
        $rules  = array(
          array('user_store_name','require','商户名不能为空!'), 
          array('user_store_address','require','商户地址不能为空!'), 
          array('user_phone','require','商户电话不能为空!'), 
          array('user_phone','/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/','商户电话格式不对!'), 
        );

        if(!$user->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($user->getError());
        }
        $data['user_store_name']=I('post.user_store_name','','strip_tags');
        $data['user_store_address']=I('post.user_store_address','','strip_tags');
        $data['user_phone']=I('post.user_phone','','strip_tags');
        $id=I('post.id','','strip_tags');
        $pic=I('post.xgpic','','strip_tags');
        $row=$user->find($id);
        // dump($row);exit;
        
        //验证唯一性
        $where['user_grade'] = array('in','2,3');
        $userinfo=$user->where($where)->field('id,user_phone,user_store_name')->select();
        //排除自己信息的其他信息
        foreach($userinfo as $k=>$v){
            if($v['id'] == $id){
                unset($userinfo[$k]);
            }
        }
        $user_store_name=array();
        $user_phone=array();
        foreach($userinfo as $ke=>$va){
            $user_store_name[] = $va['user_store_name'];
            $user_phone[] = $va['user_phone'];
        }
        if(in_array($data['user_store_name'],$user_store_name)){
            $this->error('商户名已存在！');
        }
        if($data['user_phone']){
            if(in_array($data['user_phone'],$user_phone)){
                $this->error('手机号已存在！');
            }
        }

        //判断是否修改图片
        if($pic == null){
            //执行修改
            if($user->where("id=$id")->save($data)){
                //跳转
                $this->success('修改成功',U('Store/index'));
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
            $upload->autoCheck =  false;
            //执行上传
            $info=$upload->upload();
            // dump($info);exit;
            if(!$info){
                $this->error($upload->getError());
            }else{
                //遍历
                foreach($info as $k=>$v){
                    $path[]=$v['savepath'].$v['savename'];
                }
            }
            if(count($path) !== 6){
                $this->error("请选择6张图片");
            }
            $data['user_store_name']=I('post.user_store_name','','strip_tags');
            $data['user_store_headerpic']=$path['0'];
            $data['user_store_pic']=$path['1'];
            $data['user_store_pic1']=$path['2'];
            $data['user_store_pic2']=$path['3'];
            $data['user_store_pic3']=$path['4'];
            $data['user_store_pic4']=$path['5'];

            //执行修改
            if($user->where("id=$id")->save($data)){
                unlink('./Public/Uploads/'.$row['user_store_pic']);//删除图片
                unlink('./Public/Uploads/'.$row['user_store_pic1']);//删除图片
                unlink('./Public/Uploads/'.$row['user_store_pic2']);//删除图片
                unlink('./Public/Uploads/'.$row['user_store_pic3']);//删除图片
                unlink('./Public/Uploads/'.$row['user_store_pic4']);//删除图片
                unlink('./Public/Uploads/'.$row['user_store_headerpic']);//删除图片
                $this->success('修改成功',U('Store/index'));
            }else{
                $this->error('修改失败');
            }  
        } 
    }

//======================================================商铺基本资料========================================================

    //商户列表信息
    public function storedata(){
        //实例化
        $User = M('user');
        //查询数据
        $id=$_SESSION['info']['id'];
        $UserInfo = $User->where("id=$id")->find();
        // dump($UserInfo);exit;
        //加载模板,分配变量
        $this->assign('val',$UserInfo);
        $this->display();
    }
    //加载修改页面
    public function storedataedit(){
        //实例化
        $user=M('user');
        //接收值
        $id = $_GET['id'];
        //查询数据
        $info=$user->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();
    }
    //执行修改
    public function dostoredataedit(){
        //实例化Model类
        $user = M('user');

        //验证规则
        $rules  = array(
          array('user_name','require','用户名不能为空!'), 
          array('user_store_name','require','商户名不能为空!'),
          array('user_id','require','生份证号不能为空!'), 
          array('user_id','/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/','生份证号格式不对!'), 
          array('user_store_lience','require','商户营业执照号不能为空!'), 
          array('user_store_lience','/^[0-9]*$/','商户营业执照号必须为数字!'), 
          array('user_store_registered','require','商户注册资金不能为空!'), 
          array('user_store_registered','/^[0-9]*$/','商户注册资金必须为数字!'), 
          array('user_store_cash','require','商户保证金不能为空!'), 
          array('user_store_cash','/^[0-9]*$/','商户保证金必须为数字!'), 
        );

        if(!$user->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($user->getError());
        }
        $data['user_name']=I('post.user_name','','strip_tags');
        $data['user_store_name']=I('post.user_store_name','','strip_tags');
        $data['user_id']=I('post.user_id','','strip_tags');
        $data['user_store_lience']=I('post.user_store_lience','','strip_tags');
        $data['user_store_cash']=I('post.user_store_cash','','strip_tags');
        $data['user_store_registered']=I('post.user_store_registered','','strip_tags');
        $id=I('post.id','','strip_tags');


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
        
        //执行修改
        if($user->where("id=$id")->save($data)){
         // unlink('./Public/Uploads/'.$row['user_store_pic']);//删除图片
         $this->success('修改成功',U('Store/storedata'));
        }else{
            $this->error('修改失败');
        }
    }

//======================================================商铺商品========================================================

    //加载添加商铺商品模板
    public function add(){
        //实例化Model类
        $cate = M('cate');
        $info = $cate->select();
        //查询数据
        $cateinfo=$this->subtrr($info,10);
        // dump($cateinfo);exit;
        //整理数据
        foreach($cateinfo as $k=>$v){
            $len = $v['len']-1;
            $cateinfo[$k]['cate_name'] = str_repeat('——|',$len).$v['cate_name'];

        }

        //分配变量
        $this->assign('list',$cateinfo);
        //加载模板
        $this->display();
    }
    //执行添加商铺商品基本信息
    public function doadd(){
        //实例化表
        $good = M('good');
        //分装规则
        $rules  = array(
          array('good_name','require','商品名称不能为空！'), 
          array('good_cate','require','商品分类不能为空！'), 
        );
        if (!$good->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($good->getError());
        }


        $pid=I('post.good_cate','','strip_tags');
        //实例化Model类
        $cate = M('cate');
        //分类名称
        $name = $cate->field('cate_name')->find($pid);
        //接受数据
        $data['good_name']=I('post.good_name','','strip_tags');
        $data['user_store_name']=$_SESSION['info']['user_store_name'];
        $data['cate_id']=$pid;
        $data['good_add_time']=date('Y-m-d H:i:s');
        $data['user_id']=session('info.id');
        // dump($data);exit;
        //判断商品类别，排除不是底层分类
        $cate_path = $cate->field('cate_path')->find($pid);
        $arr=explode(',',$cate_path['cate_path']);
        if(count($arr) == 2){
            $this->error('请不要选择根分类');
        }
        // dump($data);exit;
        if($good->add($data)){ 
            $this->success('添加成功',U('Store/good'));
        }else{
            $this->error('添加失败');
        }
    }

    //展示商铺商品
    public function good(){
        //实例化
        $good = M('good');
        $cate = M('cate');
        // dump(session('info.id'));exit;
        $info = $cate->select();
        //查询分类数据
        $cateinfo=$this->subtrr($info,10);
        //整理分类数据
        foreach($cateinfo as $k=>$v){
            $len = $v['len']-1;
            $cateinfo[$k]['cate_name'] = str_repeat('——|',$len).$v['cate_name'];

        }
        //搜索条件
        $good_name=I('get.good_name','','strip_tags');
        $cate_id=I('get.cate.id','','strip_tags');
        $good_state=I('get.good_state','','strip_tags');
        //分装查询条件
        $where=array();
        if(!empty($_GET['good_name'])){
            $where['good_name']=array('like',"%{$_GET['good_name']}%");
        }

        if(!empty($_GET['cate_id'])){
            $where['cate_id']=$_GET['cate_id'];
        }
        $where1['user_id'] = session('info.id'); 
        //查询商品数据数据
        $count=$good->where($where)->where($where1)->count();
        $p=getpage($count,10);
        $info=$good->where($where)->where($where1)->order('id')->limit($p->firstRow, $p->listRows)->select();
        foreach($info as $k=>$v){
            $a = $cate->field('cate_name')->find($v['cate_id']);
            $info[$k]['cate_name'] = $a['cate_name'];
        }

        // dump($cateinfo);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->assign('list',$cateinfo);
        $this->assign('page', $p->show());
        $this->display();

    }
    //删除商品
    public function del(){
        //实例化
        $good=M('good');
        $good_attr=M('good_attr');
        $file=M('file');
        $rele=M('rele');
        //接受值
        $id=I('get.id','','strip_tags');
        //查询图片
        $file_info=$file->where("good_id=$id")->select();
        // dump($file_info);exit;
        //开启事物
        M()->startTrans();
        //执行删除
        $result_good=$good->where("id=$id")->delete();
        $result_good_attr=$good_attr->where("good_id=$id")->delete();
        $result_file=$file->where("good_id=$id")->delete();
        $result_rele=$rele->where("good_id=$id")->delete();
        //页面跳转
        if($result_file && $result_rele && $result_good_attr && $result_good){
            //删除图片
            foreach($file_info as $k=>$v){
                unlink('./Public/Uploads/'.$v['file_pic']);
            }
            //事物成功
            M()->commit();
            $this->success('删除成功',U('Store/good'));
        }else{
            //事物回滚
            M()->rollback();
            $this->error('删除失败');
        }
    }
    //修改商品信息
    public function editgood(){
        //实例化
        $good=M('good');
        $cate = M('cate');
        $info = $cate->select();
        //接受值
        $id=I('get.id','','strip_tags');
        //查询修改数据
        $good_info=$good->where("id=$id")->find();
        //查询分类数据
        $cateinfo=$this->subtrr($info,10);
        //整理数据
        foreach($cateinfo as $k=>$v){
            $len = $v['len']-1;
            $cateinfo[$k]['cate_name'] = str_repeat('——|',$len).$v['cate_name'];

        }
        //加载模板，分配变量
        $this->assign('info',$good_info);
        $this->assign('list',$cateinfo);
        $this->display();
    }
    //执行修改商品信息
    public function doeditgood(){
        //实例化表
        $good = M('good');
        //分装规则
        $rules  = array(
          array('good_name','require','商品名称不能为空！'), 
          array('good_cate','require','商品分类不能为空！'), 
        );
        if (!$good->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($good->getError());
        }
        $pid=I('post.good_cate','','strip_tags');
        $id=I('post.id','','strip_tags');
        // dump($pid);exit;
        //实例化Model类
        $cate = M('cate');
        //分类名称
        $name = $cate->field('cate_name')->find($pid);
        //接受数据
        $data['good_name']=I('post.good_name','','strip_tags');
        $data['good_state']=I('post.good_state','','strip_tags');
        $data['cate_id']=$pid;
        // dump($data);exit;
        // dump($id);exit;
        //判断商品类别，排除不是底层分类
        $cate_path = $cate->field('cate_path')->find($pid);
        $arr=explode(',',$cate_path['cate_path']);
        if(count($arr) == 2){
            $this->error('请不要选择根分类');
        }
        // dump($date);exit;
        //修改商品信息
        $result_good=$good->where("id=$id")->save($data);
        // dump($date);exit;
        if($result_good){
            $this->success('修改成功',U('Store/good'));
        }else{
            $this->error('修改失败');
        }
    }

//=========================================商铺商品附加信息============================================

    //商品详细信息
    public function detail(){
        //实例化
        $good_attr = M('good_attr');
        $good=M('good');
        //接收数据
        $good_id=I('get.id','','strip_tags');
        //查询数据
        $info=$good_attr->where("good_id=$good_id")->select();
        $good_name=$good->where("id=$good_id")->field('good_name')->find();
        // dump($info);exit;
        //加载页面
        $this->assign('info',$info);
        $this->assign('id',$good_id);
        $this->assign('good_name',$good_name['good_name']);
        $this->display();
    }

    //添加商品详细信息页
    public function addattr(){
        //接收值
        $good_name=I('get.good_name','','strip_tags');
        $id=I('get.id','','strip_tags');
        //加载页面
        $this->assign('good_name',$good_name);
        $this->assign('id',$id);
        $this->display();
    }

    //执行添加商品附加信息
    public function doaddattr(){
        //实例化
        $good_attr=M('good_attr');
        $file=M('file');
        $rele=M('rele');
        //分装验证规则
        $rules  = array( 
          array('good_price','require','商品价格不能为空！'),
          array('good_des','require','商品描述不能为空！'),
          array('good_num','require','商品库存量不能为空！'),  
          array('good_price','/^(0|[1-9][0-9]{0,9})(\.[0-9]{1,2})?$/','商品价格格式不对'),
        );
        if (!$good_attr->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($good_attr->getError());
        }
        //收集good_attr表添加信息
        $date['good_attr_des']=I('post.good_des','','strip_tags');
        $date['good_attr_size']=I('post.good_size','','strip_tags');
        $date['good_attr_color']=I('post.good_color','','strip_tags');
        $date['good_attr_num']=I('post.good_num','','strip_tags');
        $date['good_attr_price']=I('post.good_price','','strip_tags');
        $date['good_id']=I('post.id','','strip_tags');
        $good_id=I('post.id','','strip_tags');
        

        //实例化文件上传类
        $upload=new \Think\Upload();
        //设置参数
        $upload->maxSize=0;//允许上传图片大小
        $upload->exts=array('jpg','jpeg','png','gif');//允许上传图片类型
        $upload->rootPath="./Public/Uploads/";//保存上传图片路径
        $upload->autoCheck = false;
        //执行上传
        $info=$upload->upload();
        // dump($info);exit;
        if(!$info){
            $this->error($upload->getError());
        }else{
            //遍历
            foreach($info as $k=>$v){
                $path[]=$v['savepath'].$v['savename'];
            }
        }

        //开启事物
        M()->startTrans();
        //添加数据到good_attr表
        $resultinfo=$good_attr->add($date);


        //收集file表添加信息
        $data['good_id']=I('post.id','','strip_tags');
        $lastgood_attr=$good_attr->order('id desc')->limit(1)->find();
        $data['good_attr_id']=$lastgood_attr['id'];
        // dump($data);exit;

        //添加数据到file表
        $result=array();
        foreach($path as $k=>$v){
            $data['file_pic']=$v;
            $result[$k]=$file->add($data);
        }

        //添加数据到rele表
        $date1['good_id']=I('post.id','','strip_tags');
        $date1['good_attr_id']=$lastgood_attr['id'];
        $good_attr_id=$lastgood_attr['id'];
        $fileinfo=$file->where("good_attr_id=$good_attr_id")->field('id')->select();
        foreach($fileinfo as $k=>$v){
            $date1['file_id']=$v['id'];
            $resultb[$k]=$rele->add($date1);
        }
        //事物的处理
        if(count($result)==count($path) && count($path)==count($resultb) && $resultinfo){
            //添加成功
            M()->commit();
            $this->success('添加成功',U('Store/detail',array('id'=>$good_id)));
        }else{
            //事务回滚
            M()->rollback();
            $this->error('添加失败');
        }
    }

    //删除商品附加信息
    public function delattr(){
        //实例化
        $good_attr=M('good_attr');//删一条
        $file=M('file');//删n条
        $rele=M('rele');//删n条
        //接受值
        $good_attr_id=I('get.good_attr_id','','strip_tags');
        //开启事物
        M()->startTrans();
        //查找商品id
        $good_id=$good_attr->where("id=$good_attr_id")->field('good_id')->find();
        $good_id=$good_id['good_id'];
        //查找对应file表信息
        $fileinfo=$file->where("good_attr_id=$good_attr_id")->select();
        // dump($fileinfo);exit;
        //删数据
        $result=$good_attr->where("id=$good_attr_id")->delete();
        $result1=$file->where("good_attr_id=$good_attr_id")->delete();
        $result2=$rele->where("good_attr_id=$good_attr_id")->delete();
        if($result && $result1 && $result2){
            foreach($fileinfo as $k=>$v){
                unlink('./Public/Uploads/'.$v['file_pic']);
            }
            M()->commit();
            $this->success("删除成功",U('Store/detail',array('id'=>$good_id)));
        }else{
            M()->rollback();
            $this->error("删除失败");
        }
    }

    //加载修改商品附加信息页面
    public function editattr(){
        //实例化表
        $good_attr=M('good_attr');
        $good=M('good');
        //接受值
        $good_attr_id=I('get.good_attr_id');
        //查找商品属性信息
        $good_attr_info=$good_attr->where("id=$good_attr_id")->find();
        //查找商品名称
        $good_id=$good_attr_info['good_id'];
        $good_name=$good->where("id=$good_id")->field('good_name')->find();

        //加载页面，分配数据
        $this->assign('good_attr_info',$good_attr_info);
        $this->assign('good_name',$good_name);
        $this->display();
    }

    //执行修改商品附加信息
    public function doeditattr(){
        //实例化
        $good_attr=M('good_attr');
        //分装验证规则
        $rules = array(
            array('good_attr_des','require','商品描述不能为空'),
            array('good_attr_price','require','商品价格不能为空'),
            // array('good_attr_price1','require','商品价格不能为空'),
            array('good_attr_num','require','商品库存量不能为空'),
            array('good_attr_price','/^(0|[1-9][0-9]{0,9})(\.[0-9]{1,2})?$/','商品价格格式不对'),
        );
        //执行验证规则
        if (!$good_attr->validate($rules)->create()) {
            $this->error($good_attr->getError());
        }
        //接收数据
        $date['good_attr_des']=I('post.good_attr_des','','strip_tags');
        $date['good_attr_price']=I('post.good_attr_price','','strip_tags');
        // $date['good_attr_price1']=I('post.good_attr_price1','','strip_tags');
        $date['good_attr_num']=I('post.good_attr_num','','strip_tags');
        $date['good_attr_color']=I('post.good_attr_color','','strip_tags');
        $date['good_attr_size']=I('post.good_attr_size','','strip_tags');
        $date['good_attr_state']=I('post.good_attr_state','','strip_tags');
        $id=I('post.id','','strip_tags');
        // dump($id);
        // dump($date);exit;
        //商品的id
        $good_id=$good_attr->where("id=$id")->field('good_id')->find();
        $good_id=$good_id['good_id'];
        //执行修改
        if($good_attr->where("id=$id")->save($date)){
            $this->success('修改成功',U('Store/detail',array("id"=>$good_id)));
        }else{
            $this->error('修改失败');
        }
    }

//==================================商品图片处理======================================

    //加载商品图片
    public function pic(){
        //实例化
        $file=M('file');
        $good_attr=M('good_attr');
        $good=M('good');
        //接收数据
        $good_attr_id=I('get.good_attr_id','','strip_tags');
        $info=$file->where("good_attr_id=$good_attr_id")->select();
        //查找商品属性
        $good_attr_info=$good_attr->where("id=$good_attr_id")->find();
        //查找商品名称
        $good_id=$good_attr_info['good_id'];
        $good_name=$good->where("id=$good_id")->field('good_name,id')->find();
        //合并
        $good_attr_info['good_name']=$good_name['good_name'];
        // dump($good_attr_info);exit;
        //加载模板,分配数据
        $this->assign('info',$info);
        $this->assign('good_attr_info',$good_attr_info);
        $this->display();
    }

    //添加商品图片页面
    public function addpic(){
        //实例化
        $good=M('good');
        $good_attr=M('good_attr');
        //接受值
        $id=I('get.id','','strip_tags');
        //商品属性信息
        $good_attr_info=$good_attr->where("id=$id")->find();
        //商品信息
        $good_id=$good_attr_info['good_id'];
        $good_info=$good->where("id=$good_id")->find();
        //加载页面,分配数据
        $this->assign('good_info',$good_info);
        $this->assign('good_attr_info',$good_attr_info);
        $this->display();
    }

    //执行添加商品图片
    public function  doaddpic(){
        //实例化
        $file=M('file');
        $rele=M('rele');
        //收集file表数据
        $data['good_id']=I('post.good_id','','strip_tags');
        $data['good_attr_id']=I('post.good_attr_id','','strip_tags');     
        //实例化文件上传类
        $upload=new \Think\Upload();
        //设置参数
        $upload->maxSize=0;
        $upload->exts=array('jpg','jpeg','png','gif');
        $upload->rootPath="./Public/Uploads/";
        //执行上传
        $info=$upload->upload();
        // dump($info);exit;
        if(!$info){
            $this->error($upload->getError());
        }else{
            //遍历
            foreach($info as $k=>$v){
                $path[]=$v['savepath'].$v['savename'];
            }
        }
        //开启事物
        M()->startTrans();
        //添加数据到file表
        foreach($path as $k=>$v){
            $data['file_pic'] = $v;
            $result_file[$k]=$file->add($data);
        }
        // dump($result_file);exit;
        //收集rele表信息
        $date['good_id']=I('post.good_id','','strip_tags');
        $date['good_attr_id']=I('post.good_attr_id','','strip_tags'); 
        //添加数据到rele表
        foreach($result_file as $k=>$v){
            $date['file_id']=$v;
            $result_rele[$k]=$rele->add($date);
        }
        //商品属性的id
        $good_attr_id=I('post.good_attr_id','','strip_tags');
        // dump($good_attr_id);exit;
        //事物处理加页面跳转
        if(count($path)==count($result_file) && count($result_file)==count($result_rele)){
            //事物成功
            M()->commit();
            $this->success('添加成功',U('Store/pic',array("good_attr_id"=>$good_attr_id)));
        }else{
            //事物回滚
            M()->rollback();
            $this->error('添加失败');
        }
    }

    //删除商品图片
    public function delpic(){
        //实例化
        $file=M('file');
        $rele=M('rele');
        //file表的id
        $id=I('get.id','','strip_tags');
        //判断是否为这个属性的最后一张图片
        $good_attr_id=$file->where("id=$id")->field('good_attr_id')->find();
        $good_attr_id=$good_attr_id['good_attr_id'];
        $rows=$file->where("good_attr_id=$good_attr_id")->field('id')->select();
        if(count($rows) <= 1){
            $this->error('一个属性至少保留一张图片');
        }
        //查找商品图片
        $file_pic=$file->where("id=$id")->field('file_pic')->find();
        //查找商品属性id
        $good_attr_id=$file->where("id=$id")->field('good_attr_id')->find();
        $good_attr_id=$good_attr_id['good_attr_id'];
        // dump($good_attr_id);exit;
        //删除数据
        M()->startTrans();
        $result_file=$file->where("id=$id")->delete();
        $result_rele=$rele->where("file_id=$id")->delete();
        // dump($file);exit;
        //执行页面跳转
        if($result_file && $result_rele){
            M()->commit();
            unlink('./Public/Uploads/'.$file_pic['file_pic']);
            $this->success('删除成功',U('Store/pic',array("good_attr_id"=>$good_attr_id)));
        }else{
            M()->rollback();
            $this->error('删除失败');
        }
    }

    //加载修改图片页面
    public function editpic(){
        //实例化
        $file=M('file');
        $good=M('good');
        //接受值
        $id=I('get.id','','strip_tags');
        //查询图片
        $file_pic=$file->where("id=$id")->field('file_pic,id')->find();
        // dump($file_pic);exit;
        //加载页面，分配变量
        $this->assign('info',$file_pic);
        $this->display();
    }
    
    //执行修改图片
    public function doeditpic(){
        //实例化
        $file=M('file');
        //接收数据            
        $id=I('post.id','','strip_tags');
        //原数据
        $row=$file->where("id=$id")->find();
        $good_attr_id=$row['good_attr_id'];
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
            foreach($info as $k=>$v){
                $path=$v['savepath'].$v['savename'];
            }
        }
        $data['file_pic']=$path;
        // var_dump($id);exit;
        //执行修改
        if($file->where("id=$id")->save($data)){
            unlink('./Public/Uploads/'.$row['file_pic']);//删除图片
            $this->success('修改成功',U('Store/pic',array("good_attr_id"=>$good_attr_id)));
        }else{
            $this->error('修改失败');
        } 
    }
}