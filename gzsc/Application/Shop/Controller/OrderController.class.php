<?php
namespace Shop\Controller;
use Think\Controller;
class OrderController extends AllowController {

    //地址处理
    public function address($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $res = curl_exec($ch);
        curl_close($ch);
        if(curl_errno($ch)){
            var_dump(curl_error($ch));
        }
        $arr = json_decode($res,true);
        return $arr;
    }

    //订单页面
    public function index(){
        //实例化
        $order = M('order');
        $user = M('user');
        $address = M('address');
        $where['store_id'] =$where2['id'] = $_SESSION['info']['id'];
        $userinfo = $user->where($where2)->field('user_store_percent')->find();
        // dump($where);exit;
        //搜索条件
        $where1=array();
        if(!empty($_GET['order_name'])){
            $map['user_name'] = I('get.order_name','','strip_tags');
            $userinfo1 = $user->where($map)->find();
            $where1['user_id'] = $userinfo1['id'];
        }
        if(!empty($_GET['order_num'])){
            $where1['order_num'] = I('get.order_num','','strip_tags');
        } 
        if(!empty($_GET['order_grade'])){
            $where1['order_grade'] = I('get.order_grade','','strip_tags');
        }
        $count = $order->where($where1)->where($where)->count();
        $p=getpage($count,10);
        $allorder = $order->where($where)->where($where1)->limit($p->firstRow, $p->listRows)->select();
        foreach($allorder as $k=>$v){
            //购买者
            $where2['id'] = $v['user_id'];
            $user_name = $user->where($where2)->field('user_name')->find();
            $allorder[$k]['user_name'] = $user_name['user_name'];
            //收获信息
            $where3['id'] = $v['address_id'];
            $addressinfo = $address->where($where3)->find();
            $allorder[$k]['address'] = $addressinfo['address'];
            $allorder[$k]['officer'] = $addressinfo['officer'];
            $allorder[$k]['address_phone'] = $addressinfo['address_phone'];
            $allorder[$k]['real_price'] = $v['order_total']*(100-$userinfo['user_store_percent'])/100;
        }
        //加载模板
        $this->assign('info',$allorder);
        $this->assign('page', $p->show());
        $this->display();
    }

    //订单详情
    public function detail(){
        //实例化
        $orderdetail = M('orderdetail');
        $good = M('good');
        $good_attr = M('good_attr');
        //接受值
        $where1['order_id'] = I('get.id','','strip_tags');
        //查询数据
        $orderdetail = $orderdetail->where($where1)->select();    
        foreach($orderdetail as $k=>$v){
            $where2['id'] = $v['good_id'];
            $where3['id'] = $v['good_attr_id'];
            $goodinfo = $good->where($where2)->field('good_name')->find();
            $good_attr_info = $good_attr->where($where3)->find();
            $orderdetail[$k]['good_name'] = $goodinfo['good_name'];
            $orderdetail[$k]['good_attr_color'] = $good_attr_info['good_attr_color'];
            $orderdetail[$k]['good_attr_size'] = $good_attr_info['good_attr_size'];
            $orderdetail[$k]['good_attr_des'] = $good_attr_info['good_attr_des'];
            $orderdetail[$k]['good_attr_price'] = $good_attr_info['good_attr_price'];
            $orderdetail[$k]['good_price1'] = $good_attr_info['good_attr_price']*$v['good_num'];
            $sumprice += $orderdetail[$k]['good_price1'];
        }
        //加载模板
        $this->assign('info',$orderdetail);
        $this->assign('sumprice',$sumprice);
        $this->display();        
    }

    //点击发货
    public function deliver(){
        //实例化
        $order = M('order');
        //接受值
        $id = I('get.id','','strip_tags');
        // dump($info);exit;
        //更改数据、
        $data['order_grade'] = 3;
        if($order->where("id=$id")->save($data)){
            $this->success('发货成功',U('Order/addwuliu',array("id"=>$id)));
        }else{
            $this->error('发货失败');
        }
    }

    //加载发货页面
    public function addwuliu(){
        //实例化
        $express_company = M('express_company'); 
        //接收数据
        $id = I('get.id','','strip_tags');
        //查询数据
        $info = $express_company->field('name')->select();
        //加载页面
        $this->assign('info',$info);
        $this->assign('id',$id);
        $this->display();
    }

    //执行加载发货
    public function doaddwuliu(){
        //实例化
        $express_company = M('express_company'); 
        $order           = M('order'); 
        //接收数据
        if($_POST['order_wuliucompany']){
            //验证规则  
            $rules  = array(
              array('order_wuliunum','require','订单号不能为空!'),
              array('order_wuliunum','/^[0-9]*$/','订单号必须为数字!'),
              array('order_wuliucompany','require','物流公司不能为空!'),
            );
            if (!$order->validate($rules)->create()){     
                // 如果创建失败 表示验证没有通过 输出错误提示信息     
                $this->error($order->getError());
            }
            $date['order_wuliunum']     = I('post.order_wuliunum','','strip_tags');
            $date['order_wuliucompany'] = I('post.order_wuliucompany','','strip_tags');
        }else{
            //验证规则  
            $rules  = array(
              array('order_wuliunum','require','订单号不能为空!'), 
              array('order_wuliunum','/^[0-9]*$/','订单号必须为数字!'),
              array('order_wuliucompany','require','物流公司不能为空!'), 
            );
            if (!$order->validate($rules)->create()){     
                // 如果创建失败 表示验证没有通过 输出错误提示信息     
                $this->error($order->getError());
            }
            $date['order_wuliunum']     = I('post.order_wuliunum','','strip_tags');
            $date['order_wuliucompany'] = I('post.order_wuliucompany','','strip_tags');
        }
        $id = I('post.id','','strip_tags');
        // dump($date);exit;
        //插入数据
        if($order->where("id=$id")->save($date)){
            $this->success('修改成功',U('Order/index')); 
        }else{
            $this->error('修改失败');
        }
    }


    //快递
    public function wuliuedit(){
        //实例化
        $express_company = M('express_company'); 
        $order           = M('order');
        //接收数据
        $id = I('get.id','','strip_tags');
        //查询数据
        $wuliuinfo = $express_company->field('name')->select();
        $orderinfo = $order->where("id=$id")->find();

        // dump($id);
        // dump($wuliuinfo);
        // dump($orderinfo);exit;
        //加载页面
        $this->assign('info',$wuliuinfo);
        $this->assign('info1',$orderinfo);
        $this->assign('id',$id);
        $this->display();
    }

    //物流
    public function wuliu(){
        //实例化 
        $order = M('order'); 
        $express_company = M('express_company');
        //接收数据
        $id = I('get.id','','strip_tags');
        //查询订单编号数据
        $wuliu = $order->where("id=$id")->field('order_wuliunum,order_wuliucompany')->find();
        $num = $wuliu['order_wuliunum'];
        //查询物流公司
        $where['name'] = $wuliu['order_wuliucompany'];
        $company = $express_company->where($where)->find();
        $type = $company['type'];
        $url="https://m.kuaidi100.com/query?type=".$type."&postid=".$num;
        $info = $this->address($url);
        // if($info[''])
        // dump($info);exit;
        $this->assign('info',$info);
        $this->display();
    }

}