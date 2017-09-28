<?php
namespace Admin\Controller;
use Think\Controller;
class StorenoticeController extends AllowController {
    //加载添加图片页面
    public function add(){
        //加载模板
        $this->display();
    }
    //执行添加
    public function insert(){
        // 实例化表
        $store_notice=M('store_notice');
        //添加数据规则
        $rules=array(
            array('title','require','商城公告标题不能为空'),
            array('content','require','商城公告内容不能为空'),
            array('store_notice_http','require','商城公告地址不能为空'),
            array('store_notice_http','','商城公告地址已经存在！',0,'unique',1), 
            );
        if (!$store_notice->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($store_notice->getError());
        }
        //接受数据
        $data['title']=I('post.title','','strip_tags');
        $data['content']=I('post.content','','strip_tags');
        $data['store_notice_addtime']=date('Y-m-d H:i:s');
        $data['store_notice_state']=2;
        $data['store_notice_http']=I('post.store_notice_http','','strip_tags');
        // var_dump($data);exit;
        if($store_notice->add($data)){ 
            $this->success('添加成功',U('Storenotice/index'));
        }else{
            $this->error('添加失败');
        }
    }
    //加载显示页面
    public function index(){
        //实例化
        $store_notice = M('store_notice');
        //搜索条件
        $where1=array();
        if(!empty($_GET['store_notice_http'])){
            $where1['store_notice_http'] = array('like',"%{$_GET['store_notice_http']}%");
        }
        if(!empty($_GET['store_notice_state'])){
            $where1['store_notice_state'] = $_GET['store_notice_state'];
        }

        $count = $store_notice->where($where1)->count();
        $p = getpage($count,10);
        //查询数据
        $UserInfo = $store_notice->where($where1)->limit($p->firstRow, $p->listRows)->select();
        // dump($UserInfo);exit;
        //加载模板,分配变量
        $this->assign('UserInfo',$UserInfo);
        $this->assign('page', $p->show());
        $this->display();
    }
    //删除
    public function del(){
        //实例化
        $store_notice = M('store_notice');
        //接收值
        $id = $_GET['id'];
        //删除数据库数据
        $info = $store_notice->where("id=$id")->delete();
        //返回
        if($info){
            $this->success('删除成功', U('Storenotice/index'));
        } else {
            $this->error('删除失败');
        }
    }
    //禁用
    public function stop(){
        //实例化
        $store_notice=M('store_notice');
        //接受值
        $data['id'] = $_GET['id'];
        $data['store_notice_state'] = 2;
        //更新
        if($store_notice->save($data)){
            $this->success('禁用成功',U('Storenotice/index'));
        }else{
            $this->error('禁用失败');
        }
    }
    //启用
    public function start(){
        //实例化
        $store_notice=M('store_notice');
        //接受值
        $data['id'] = $_GET['id'];
        $data['store_notice_state'] = 1;
        //更新
        if($store_notice->save($data)){
            $this->success('启用成功',U('Storenotice/index'));
        }else{
            $this->error('启用失败');
        }
    }
    //加载修改页面
    public function edit(){
        //实例化
        $store_notice=M('store_notice');
        //接收值
        $id = $_GET['id'];
        //查询数据
        $info=$store_notice->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();
    }
    //执行修改
    public function update(){
        // 实例化表
        $store_notice=M('store_notice');
        //添加数据规则
        $rules=array(
            array('title','require','商城公告标题不能为空'),
            array('content','require','商城公告内容不能为空'),
            array('store_notice_http','require','商城公告地址不能为空'),
            );
        if (!$store_notice->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息
            $this->error($store_notice->getError());
        }
        //接受数据
        $data['title']=I('post.title','','strip_tags');
        $data['content']=I('post.content','','strip_tags');
        $id=I('post.id','','strip_tags');
        // var_dump($data);exit;
        if($store_notice->where("id=$id")->save($data)){ 
            $this->success('修改成功',U('Storenotice/index'));
        }else{
            $this->error('修改失败');
        }            
    }
}