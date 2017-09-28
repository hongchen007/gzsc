<?php
namespace Shop\Controller;
use Think\Controller;
use Think\Page;
class ActivityController extends AllowController{

    //加载添加页面
    public function add(){
        //实例化
        $good = D('good');
        $discount = D('discount');
        //查询数据
        $user_id = $_SESSION['info']['id'];
        $where['good_state'] = array('in','2,3');
        $goodinfo = $good->where("user_id=$user_id")->where($where)->field('id,good_name')->select();
        $discountinfo = $discount->order('id desc')->select();
        foreach($discountinfo as $k=>$v){
            $discountinfo[$k]['des'] = 0.1*$v['des'];
        }
        //加载模板
        $this->assign('info',$goodinfo);
        $this->assign('info1',$discountinfo);
        $this->display();
    }

    //执行添加
    public function insert(){
        // echo "111";exit;
        // 实例化表
        $good = M('good');
        $good_attr = M('good_attr');
        M()->startTrans();
        //验证
        if(empty($_POST['good_id']) || empty($_POST['discount'])){
            $this->error('商品和折扣都不能为空');
        }
        //执行
        $map1['id'] = $where1['good_id'] = I('post.good_id','','strip_tags');
        $discount = I('post.discount','','strip_tags');
        //判断是否已经折扣
        $ginfo = $good->where($map1)->field('good_attr_discount')->find();
        if($ginfo == null || $ginfo == ""){
            $this->error('改商品已经添加折扣');
        }
        $goodattrinfo = $good_attr->where($where1)->field('id,good_attr_price1,good_attr_price')->select();
        //修改good_attr表
        $num1 = count($goodattrinfo);
        foreach($goodattrinfo as $k=>$v){
            $id = $v['id'];
            $data['good_attr_price1']   =  round($v['good_attr_price']*$discount/100,2);
            $num2 += $good_attr->where("id=$id")->save($data);
        }
        //修改good表
        $date['good_attr_discount'] = $discount/10;
        $goodinfo = $good->where($map1)->save($date);
        // dump($num1);
        // dump($num2);exit;
        if($num1 == $num2 && $goodinfo){ 
            M()->commit();
            $this->success('添加成功',U('Activity/index'));
        }else{
            M()->rollback();
            $this->error('添加失败');
        }
    }

    //加载显示页面
    public function index(){
        //实例化
        $good_attr = M('good_attr');
        $good = M('good');
        //搜索条件
        $where1=array();
        if(!empty($_GET['good_name'])){
            $where1['good_name'] = array('like',"%{$_GET['good_name']}%");
        }
        $where1['user_id'] = $_SESSION['info']['id'];
        //查询数据
        $goodinfo = $good->where($where1)->field('id,good_name,good_attr_discount')->select();
        foreach($goodinfo as $k=>$v){
            if(empty($v['good_attr_discount'])){
                unset($goodinfo[$k]);
            }
        }

        //总长
        $Total = count($goodinfo);
        //导入分页类
        $Page = getpage($Total,10);
        $goodinfo=array_slice($goodinfo,$Page->firstRow,$Page->listRows);

        $Page = $Page->show();
        //加载模板,分配变量
        $this->assign('info',$goodinfo);
        $this->assign('Page',$Page);
        $this->display();
    }

    //删除折扣、
    public function del(){
        //实例化
        $good      = M('good');
        $good_attr = M('good_attr');
        //接收数据
        $where1['id'] = $where2['good_id'] = I('get.id','','strip_tags');
        //删除good中的折扣
        $date['good_attr_discount'] = null;
        $goodinfo = $good->where($where1)->save($date);
        //删除good_attr中的price1
        $goodattrinfo = $good_attr->where($where2)->select();
        $num1 = count($goodattrinfo);
        foreach($goodattrinfo as $k=>$v){
            $map1['id'] = $v['id'];
            $data['good_attr_price1'] = null;
            $num2 += $good_attr->where($map1)->save($data);
        }
        if($num1 == $num2 && $goodinfo){
            $this->success('删除成功',U('Activity/index'));
        }else{
            $this->error('删除失败');
        }
    }

    //加载修改页面
    public function editdiscount(){
        //实例化
        $good = D('good');
        $discount = D('discount');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $goodname = $good->where("id=$id")->field('id,good_name,good_attr_discount')->find();
        $discountinfo = $discount->order('id desc')->select();
        foreach($discountinfo as $k=>$v){
            $discountinfo[$k]['des'] = $v['des']*0.1;
        }
        // dump($goodname);
        // dump($discountinfo);exit;
        //加载模板
        $this->assign('info',$goodname);
        $this->assign('info1',$discountinfo);
        $this->display();
    }

    //执行修改
    public function doeditdiscount(){
        //实例化
        $good = M('good');
        $good_attr = M('good_attr');
        M()->startTrans();
        //接收值
        $where['good_id'] = $id = I('post.id','','strip_tags');
        $discount = $date['good_attr_discount'] = I('post.discount','','strip_tags');
        //判断是否修改
        $discount1 = $good->where("id=$id")->field('good_attr_discount')->find();
        if($discount == $discount1['good_attr_discount']){
            $this->error('修改折扣与原折扣不能相等');
        }else{
            $goodinfo = $good->where("id=$id")->save($date);
            $goodattrinfo = $good_attr->where($where)->select();
            $num1 = count($goodattrinfo);
            foreach($goodattrinfo as $k=>$v){
                $data['good_attr_price1'] = $v['good_attr_price']*$discount*0.1;
                $map['id'] = $v['id'];
                $num2 += $good_attr->where($map)->save($data);
            }
            if($num1 == $num2 && $goodattrinfo){
                M()->commit();
                $this->success('修改成功',U('activity/index'));
            }else{
                M()->rollback();
                $this->error('修改失败');
            }
        }
    }

    //详细信息
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
}