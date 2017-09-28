<?php
namespace Admin\Controller;
use Think\Controller;
class PicsController extends AllowController{
    
    //加载添加图片页面
    public function add(){
        //加载模板
        $this->display();
    }

    //执行添加
    public function insert(){
        // echo "111";exit;
        // 实例化表
        $pics = M('pics');
        $good = M('good');
        //添加数据规则
        $rules=array(
            array('pic_descr','require','图片描述不能为空'),
            array('pic_http','require','链接ID不能为空'),
            array('pic_http','/^[0-9]*$/','链接ID必须为数字!'), 
            array('pic_http','','链接ID已经存在！',0,'unique',1), 
            );
        if (!$pics->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($pics->getError());
        }
        //实例化文件上传类
        $upload=new \Think\Upload();
        //设置参数
        $upload->maxSize=0;//允许上传图片大小
        $upload->exts=array('jpg','jpeg','png','gif');//允许上传图片类型
        $upload->rootPath="./Public/Uploads/";//保存上传图片路径

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
        $id       = I('post.pic_http','','strip_tags');
        $goodinfo = $good->where("id=$id")->field('user_id')->find();
        if(empty($goodinfo)){
            $this->error('该商品不存在！');
        }
        $data['pic_descr']   = I('post.pic_descr','','strip_tags');
        $data['pic_http']    = "/gzsc/index.php/Home/Goods/detail?id=".$id;
        $data['pic_address'] = I('post.pic_address','','strip_tags');
        $data['pic']         = $path;
        $data['pic_add_time']= date('Y-m-d H:i:s');
        $data['pic_state']   = 1;
        $data['store_id']    = $goodinfo['user_id'];
        $data['end_time']    = date('Y-m-d H:i:s',time()+604800);
        // dump($data);exit;
        if($pics->add($data)){ 
            $this->success('添加成功',U('Pics/index'));
        }else{
            $this->error('添加失败');
        }
    }

    //加载显示页面
    public function index(){
        //实例化
        $pics = M('pics');
        $user = M('user');
        $good = M('good');
        //搜索条件
        $where1=array();
        if(!empty($_GET['store_name'])){
            $where2['user_store_name'] = array('like',"%{$_GET['store_name']}%");
            $userinfo2 = $user->where($where2)->field('id')->find();
            $where1['store_id'] = $userinfo2['id'];
        }
        if(!empty($_GET['pic_http'])){
            $where1['pic_http'] = array('like',"%{$_GET['pic_http']}%");
        }
        if(!empty($_GET['pic_state'])){
            $where1['pic_state'] = $_GET['pic_state'];
        }
        // $count = $pics->where($where1)->count();
        // $p = getpage($count,10);
        //查询数据
        $UserInfo = $pics->where($where1)->select();
        foreach($UserInfo as $k=>$v){
            $aa = explode("=",$v['pic_http']);
            $map1['id'] = $aa[1];
            $goodinfo = $good->where($map1)->field('user_id')->find();
            $map2['id'] = $goodinfo['user_id'];
            $userinfo1 = $user->where($map2)->field('user_store_name')->find();
            $UserInfo[$k]['user_store_name'] = $userinfo1['user_store_name'];
        }
        foreach($UserInfo as $k=>$v){
            if(strtotime($v['end_time']) > time()){
                $UserInfo[$k]['pic_status'] = "1";
            }else{
                $UserInfo[$k]['pic_status'] = "2";
            }
        }

        //是否过期
        if(!empty($_GET['pic_status'])){ 
            if($_GET['pic_status'] == 1){
                foreach($UserInfo as $k=>$v){
                    if(strtotime($v['end_time']) < time()){
                        unset($UserInfo[$k]);
                    }                    
                }
            }else{
                foreach($UserInfo as $k=>$v){
                    if(strtotime($v['end_time']) > time()){
                        unset($UserInfo[$k]);
                    }                                       
                }
            }
        }
        //总长
        $Total = count($UserInfo);
        //导入分页类
        $Page = getpage($Total,10);
        $UserInfo=array_slice($UserInfo,$Page->firstRow,$Page->listRows);

        $Page = $Page->show();
        //加载模板,分配变量
        $this->assign('UserInfo',$UserInfo);
        $this->assign('Page',$Page);
        $this->display();
    }

    //详情
    public function detail(){
        //实例化
        $pics = M('pics');
        //接收值
        $id = I('get.id','','strip_tags');
        $picsinfo = $pics->where("id=$id")->field('pic_http')->find();
        $idinfo = explode('=',$picsinfo['pic_http']);
        $id = $idinfo[1];
        $this->redirect('Store/detail',array("id"=>$id));
    }

    //删除
    public function del(){
        //实例化
        $pics = M('pics');
        //接收值
        $id = $_GET['id'];
        //删除数据库数据
        $row = $pics->where("id=$id")->find();
        $info = $pics->where("id=$id")->delete();
        //返回
        if($info){
            $this->success('删除成功', U('Pics/index'));
            unlink('./Public/Uploads/'.$row['pic']);//删除图片
        } else {
            $this->error('删除失败');
        }
    }

    //禁用
    public function stop(){
        //实例化
        $pics=M('pics');
        //接受值
        $data['id'] = $_GET['id'];
        $data['pic_state'] = 2;
        //更新
        if($pics->save($data)){
            $this->success('禁用成功',U('Pics/index'));
        }else{
            $this->error('禁用失败');
        }
    }

    //通过审核
    public function pass(){
        //实例化
        $pics=M('pics');
        //接受值
        $data['id'] = $_GET['id'];
        $data['pic_state'] = 1;
        //更新
        if($pics->save($data)){
            $this->success('审核成功',U('Pics/index'));
        }else{
            $this->error('审核失败');
        }
    }

    //启用
    public function start(){
        //实例化
        $pics=M('pics');
        //接受值
        $data['id'] = $_GET['id'];
        $data['pic_state'] = 1;
        //更新
        if($pics->save($data)){
            $this->success('启用成功',U('Pics/index'));
        }else{
            $this->error('启用失败');
        }
    }


    //加载修改页面
    public function edit(){
        //实例化
        $pics=M('pics');
        //接收值
        $id = $_GET['id'];
        //查询数据
        $info=$pics->where("id=$id")->find();
        $pic_http = $info['pic_http'];
        $pic_http = substr($pic_http,37);
        $info['pic_http'] = $pic_http;
        // dump($pic_http);
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();
    }

    //执行修改
    public function update(){
        // var_dump($_POST);exit;
        //实例化Model类
        $pics = M('pics');
        $rules=array(
            array('pic_descr','require','图片描述不能为空'),
            array('pic_descr','require','图片描述不能为空'),
            array('pic_http','require','链接ID不能为空'),
            array('pic_http','/^[0-9]*$/','链接ID必须为数字!'), 
            );
        if (!$pics->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($pics->getError());
        }
        $data['pic_descr']   = I('post.pic_descr','','strip_tags');//描述
        $data['pic_http']    = "/gzsc/index.php/Home/Goods/detail?id=".I('post.pic_http','','strip_tags');
        $data['pic_address'] = I('post.pic_address','','strip_tags');
        $id                  = I('post.id','','strip_tags');
        $pic                 = I('post.xgpic','','strip_tags');
        if($_POST['end']){
            $data['end_time'] = I('post.end','','strip_tags');
        }
        // dump($data);exit;
        //判断是否修改商品图片
        if($pic == null){
            //执行修改
            if($pics->where("id=$id")->save($data)){
                //跳转
                $this->success('修改成功',U('Pics/index'));
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
            $data['pic']=$path;
            // var_dump($data);exit;
            //执行修改
            $row=$pics->find($id);//获取修改的数据
            if($pics->where("id=$id")->save($data)){
                unlink('./Public/Uploads/'.$row['pic']);//删除图片
                $this->success('修改成功',U('Pics/index'));
            }else{
                $this->error('修改失败');
            } 
        }
    }

}