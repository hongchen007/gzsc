<?php
namespace Admin\Controller;
use Think\Controller;
class ServiceController extends AllowController {

    //无线分类方法
    public static function subtrr($arr,$id,$len=1){
        $sub=array();
        foreach($arr as $k=>$v){
            if($v['cate_pid'] == $id){
                $v['len']=1;
                $sub[]=$v;
                $sub=array_merge($sub,self::subtrr($arr,$v['id'],$len+1));
            }
        }
        return $sub;
    }

//================================================二手车信息secondhandcar================================================================

    //通过审核
    public function secondhandcarpass(){
        //实例化
        $second_hand_car = M('second_hand_car');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 2;
        //改数据
        if($second_hand_car->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/secondhandcar'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //禁用
    public function secondhandcarstop(){
        //实例化
        $second_hand_car = M('second_hand_car');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 3;
        //改数据
        if($second_hand_car->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/secondhandcar'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //二手车展示
    public function secondhandcar(){
        //实例化
        $second_hand_car     = M('second_hand_car');
        $second_hand_carfile = M('second_hand_carfile'); 
        $user                = M('user'); 
        //分装查询条件
        $where=array();
        if(!empty($_GET['name'])){
            $where['name']=array('like',"%{$_GET['name']}%");
        }
        if(!empty($_GET['tel'])){
            $where['tel']=array('like',"%{$_GET['tel']}%");
        }
        if(!empty($_GET['states'])){
            $where['states']=array('like',"%{$_GET['states']}%");
        } 
        //查询商品数据数据
        $count=$second_hand_car->where($where)->count();
        $p=getpage($count,10);
        $info = $second_hand_car->where($where)->limit($p->firstRow, $p->listRows)->select();
        foreach($info as $k=>$v){
            $where1['id'] = $v['user_id'];
            $userinfo = $user->where($where1)->field('user_grade,user_name,user_store_name')->find();
            $info[$k]['user_grade']      = $userinfo['user_grade'];
            $info[$k]['user_name']       = $userinfo['user_name'];
            $info[$k]['user_store_name'] = $userinfo['user_store_name'];
            //判断是否过期
            if($v['valid_time'] > date('Y-m-d H:i:s')){
                $info[$k]['time'] = "正常";
            }else{
                $info[$k]['time'] = "失效";
            }
        }

        //加载数据
        // dump($info);exit;
        $this->assign('info',$info);
        $this->assign('page', $p->show());
        $this->display();
    }

    //二手车删除
    public function secondhandcardel(){
        //实例化
        $second_hand_car     = M('second_hand_car');
        $second_hand_carfile = M('second_hand_carfile');
        M()->startTrans();
        //接收数据
        $where1['id'] = $where2['second_hand_card_id'] = I('get.id','','strip_tags');
        //这条数据
        $row = $second_hand_car->where($where1)->field('driving_lience_pic,lience_num_pic,register_pic,bill_pic')->find();
        //删除数据
        $len1  = $second_hand_carfile->where($where2)->count();
        $info1 = $second_hand_car->where($where1)->delete();
        $carfileinfo = $second_hand_carfile->where($where2)->field('id,file')->select();
        foreach($carfileinfo as $k=>$v){
            $where3['id'] = $v['id'];
            $len2 += $second_hand_carfile->where($where3)->delete();
        }
        if($info1 && $len1 == $len2){
            M()->commit();
            unlink('./Public/Uploads/'.$row['driving_lience_pic']);//删除图片
            unlink('./Public/Uploads/'.$row['lience_num_pic']);//删除图片
            unlink('./Public/Uploads/'.$row['register_pic']);//删除图片
            unlink('./Public/Uploads/'.$row['bill_pic']);//删除图片
            foreach($carfileinfo as $k=>$v){
                unlink('./Public/Uploads/'.$carfileinfo['file']);//删除图片                
            }
            $this->success('删除成功',U('Service/secondhandcar'));
        }else{
            M()->rollback();
            $this->error('删除失败');           
        }          
    }

    //加载二手车修改页面
    public function secondhandcaredit(){
        //实例化
        $second_hand_car = M('second_hand_car');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$second_hand_car->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }   

    //执行二手车修改
    public function secondhandcardoedit(){
        //实例化
        $second_hand_car = M('second_hand_car');
        $rules  = array(
          array('brank','require','品牌不能为空!'), 
          array('color','require','颜色不能为空!'), 
          array('first_time','require','首次上牌时间不能为空!'), 
          array('price','require','价格不能为空!'), 
          array('des','require','标题描述不能为空!'), 
          array('name','require','联系人不能为空!'), 
          array('tel','require','手机号码不能为空!'), 
          array('tel','/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/','商户电话格式不对!'), 
        );

        if(!$second_hand_car->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($second_hand_car->getError());
        }
        $data['brank']      = I('post.brank','','strip_tags');
        $data['color']      = I('post.color','','strip_tags');
        $data['first_time'] = I('post.first_time','','strip_tags');
        $data['price']      = I('post.price','','strip_tags');
        $data['des']        = I('post.des','','strip_tags');
        $data['name']       = I('post.name','','strip_tags');
        $data['tel']        = I('post.tel','','strip_tags');
        $id                 = I('post.id','','strip_tags');
        $pic                = I('post.xgpic','','strip_tags');
        $row                = $second_hand_car->find($id);
        if(!empty($_POST['end'])){
            $data['valid_time']          = I('post.end','','strip_tags');
        }
        $yuaninfo = $second_hand_car->where("id=$id")->field('area')->find();
        //验证看车区域
        if($_POST['s_county'] == "市、县级市"){
            $data['area'] = $yuaninfo['area'];
        }else{
            $area1 = I('post.s_county','','strip_tags');    //县
            $area2 = I('post.s_city','','strip_tags');      //市
            $area3 = I('post.s_province','','strip_tags');  //省
            $data['area'] = $area3.$area2.$area1;            
        }
        // dump($row);
        // dump($data);exit;

        //判断是否修改图片
        if($pic == null){
            //执行修改
            if($second_hand_car->where("id=$id")->save($data)){
                //跳转
                $this->success('修改成功',U('Service/secondhandcar'));
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
            if(count($path) !== 4){
                $this->error("请选择4张图片");
            }
            $data['driving_lience_pic']= $path['0'];
            $data['lience_num_pic']    = $path['1'];
            $data['register_pic']      = $path['2'];
            $data['bill_pic']          = $path['3'];
            // dump($data);exit;
            //执行修改
            if($second_hand_car->where("id=$id")->save($data)){
                unlink('./Public/Uploads/'.$row['driving_lience_pic']);//删除图片
                unlink('./Public/Uploads/'.$row['lience_num_pic']);//删除图片
                unlink('./Public/Uploads/'.$row['register_pic']);//删除图片
                unlink('./Public/Uploads/'.$row['bill_pic']);//删除图片
                $this->success('修改成功',U('Service/secondhandcar'));
            }else{
                $this->error('修改失败');
            }  
        }
    } 

    //浏览图片
    public function secondhandcarfile(){
        //实例化
        $second_hand_car     = M('second_hand_car');
        $second_hand_carfile = M('second_hand_carfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $secondhandcarpic = $second_hand_carfile->where("second_hand_card_id=$id")->select();
        // dump($secondhandcarpic);exit;
        $this->assign('info',$secondhandcarpic);
        $this->assign('id',$id);
        $this->display();        
    }

    //删除图片
    public function delsecondhandcarfile(){
        //实例化
        $second_hand_car     = M('second_hand_car');
        $second_hand_carfile = M('second_hand_carfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $fileinfo = $second_hand_carfile->where("id=$id")->field('second_hand_card_id,file')->find();
        $second_hand_card_id = $fileinfo['second_hand_card_id'];
        // dump($fileinfo);exit;
        if($second_hand_carfile->where("id=$id")->delete()){
            unlink('./Public/Uploads/'.$fileinfo['file']);
            $this->success('删除成功',U('Service/secondhandcarfile',array("id"=>$second_hand_card_id)));
        }else{
            $this->error('修改失败');
        }       
    }

    //添加图片页面
    public function addsecondhandcarfile(){
        //接收值
        $id = I('get.id','','strip_tags');
        // dump($id);exit;
        //加载页面，分配数据
        $this->assign('id',$id);
        $this->display();         
    }

    //执行图片添加
    public function doaddsecondhandcarfile(){
        //实例化
        $second_hand_carfile = M('second_hand_carfile');
        //接收值
        $id = I('post.second_hand_card_id','','strip_tags');
        // dump($id);exit;
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
        //添加数据到second_hand_carfile表
        $data['second_hand_card_id'] = $id;
        $data['add_time'] = date('Y-m-d',time());
        foreach($path as $k=>$v){
            $data['file'] = $v;
            $resultinfo[$k] = $second_hand_carfile->add($data);
        }
        // dump(count($path));
        // dump(count($resultinfo));exit;
        if(count($path) == count($resultinfo)){
           //事物成功
            M()->commit();
            $this->success('添加成功',U('Service/secondhandcarfile',array("id"=>$id)));
        }else{
            //事物回滚
            M()->rollback();
            $this->error('添加失败');
        }       
    }

    //加载二手车修改图片页面
    public function editsecondhandcarfile(){
        //实例化
        $second_hand_carfile = M('second_hand_carfile');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$second_hand_carfile->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    } 

    //执行二手车图片修改
    public function doeditsecondhandcarfile(){
        //实例化
        $second_hand_carfile = M('second_hand_carfile');
        //接收值
        $id = I('post.id','','strip_tags');
        //查询数据
        $row = $second_hand_carfile->where("id=$id")->find();
        $id1 = $row['second_hand_card_id'];
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
        $data['file']=$path;
        //执行修改
        if($second_hand_carfile->where("id=$id")->save($data)){
            unlink('./Public/Uploads/'.$row['file']);//删除图片
            $this->success('修改成功',U('Service/secondhandcarfile',array("id"=>$id1)));
        }else{
            $this->error('修改失败');
        }         
    } 

//================================================房屋出租houseforrent================================================================

    //通过审核
    public function houseforrentpass(){
        //实例化
        $house_for_rent = M('house_for_rent');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 2;
        //改数据
        if($house_for_rent->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/houseforrent'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //禁用
    public function houseforrentstop(){
        //实例化
        $house_for_rent = M('house_for_rent');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 3;
        //改数据
        if($house_for_rent->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/houseforrent'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //房屋出租展示
    public function houseforrent(){
        //实例化
        $house_for_rent = M('house_for_rent');
        $user           = M('user'); 
        //分装查询条件
        $where=array();
        if(!empty($_GET['name'])){
            $where['name']=array('like',"%{$_GET['name']}%");
        }
        if(!empty($_GET['tel'])){
            $where['tel']=array('like',"%{$_GET['tel']}%");
        }
        if(!empty($_GET['states'])){
            $where['states']=array('like',"%{$_GET['states']}%");
        }
        //查询商品数据数据
        $count = $house_for_rent->where($where)->count();
        $p=getpage($count,10);
        $info  = $house_for_rent->where($where)->limit($p->firstRow, $p->listRows)->select();
        foreach($info as $k=>$v){
            $where1['id'] = $v['user_id'];
            $userinfo = $user->where($where1)->field('user_grade,user_name,user_store_name')->find();
            $info[$k]['user_grade']      = $userinfo['user_grade'];
            $info[$k]['user_name']       = $userinfo['user_name'];
            $info[$k]['user_store_name'] = $userinfo['user_store_name'];
            //判断是否过期
            if($v['valid_time'] > date('Y-m-d H:i:s')){
                $info[$k]['time'] = "正常";
            }else{
                $info[$k]['time'] = "失效";
            }
        }
        //加载数据
        // dump($info);exit;
        $this->assign('info',$info);
        $this->assign('page', $p->show());
        $this->display();
    }

    //房屋出租删除
    public function houseforrentdel(){
        //实例化
        $house_for_rent      = M('house_for_rent');
        $house_for_rentfile  = M('house_for_rentfile');
        M()->startTrans();
        //接收数据
        $where1['id'] = $where2['house_for_rend_id'] = I('get.id','','strip_tags');
        //删除数据
        $len1  = $house_for_rentfile->where($where2)->count();
        $info1 = $house_for_rent->where($where1)->delete();
        $carfileinfo = $house_for_rentfile->where($where2)->field('id,file')->select();
        foreach($carfileinfo as $k=>$v){
            $where3['id'] = $v['id'];
            $len2 += $house_for_rentfile->where($where3)->delete();
        }
        if($info1 && $len1 == $len2){
            M()->commit();
            foreach($carfileinfo as $k=>$v){
                unlink('./Public/Uploads/'.$carfileinfo['file']);//删除图片                
            }
            $this->success('删除成功',U('Service/houseforrent'));
        }else{
            M()->rollback();
            $this->error('删除失败');           
        }          
    }

    //加载房屋出租修改页面
    public function houseforrentedit(){
        //实例化
        $house_for_rent = M('house_for_rent');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$house_for_rent->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }  

    //执行房屋出租修改
    public function houseforrentdoedit(){
        //实例化
        $house_for_rent = M('house_for_rent');
        $rules  = array(
          array('area','require','区域不能为空!'), 
          array('house_type','require','户型不能为空!'), 
          array('cash','require','押金不能为空!'), 
          array('pay_method','require','付款方式不能为空!'), 
          array('des','require','标题描述不能为空!'), 
          array('name','require','联系人不能为空!'), 
          array('tel','require','手机号码不能为空!'), 
          array('tel','/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/','商户电话格式不对!'), 
        );

        if(!$house_for_rent->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($house_for_rent->getError());
        }
        $data['area']       = I('post.area','','strip_tags');
        $data['house_type'] = I('post.house_type','','strip_tags');
        $data['cash']       = I('post.cash','','strip_tags');
        $data['pay_method'] = I('post.pay_method','','strip_tags');
        $data['des']        = I('post.des','','strip_tags');
        $data['name']       = I('post.name','','strip_tags');
        $data['tel']        = I('post.tel','','strip_tags');
        $data['state']      = I('post.state','','strip_tags');
        if(!empty($_POST['end'])){
            $data['valid_time']          = I('post.end','','strip_tags');
        }
        $id                 = I('post.id','','strip_tags');
        $yuaninfo = $house_for_rent->where("id=$id")->field('area')->find();
        //验证看车区域
        if($_POST['s_county'] == "市、县级市"){
            $data['area'] = $yuaninfo['area'];
        }else{
            $area1 = I('post.s_county','','strip_tags');    //县
            $area2 = I('post.s_city','','strip_tags');      //市
            $area3 = I('post.s_province','','strip_tags');  //省
            $data['area'] = $area3.$area2.$area1;            
        }
        // dump($row);
        // dump($data);
        // dump($data);exit;
        //执行修改
        if($house_for_rent->where("id=$id")->save($data)){
            $this->success('修改成功',U('Service/houseforrent'));
        }else{
            $this->error('修改失败');
        }  
    } 

    //浏览图片
    public function houseforrentfile(){
        //实例化
        $house_for_rentfile = M('house_for_rentfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $houseforrentpic = $house_for_rentfile->where("house_for_rend_id=$id")->select();
        // dump($secondhandcarpic);exit;
        $this->assign('info',$houseforrentpic);
        $this->assign('id',$id);
        $this->display();        
    }

    //添加图片页面
    public function addhouseforrentfile(){
        //接收值
        $id = I('get.id','','strip_tags');
        // dump($id);exit;
        //加载页面，分配数据
        $this->assign('id',$id);
        $this->display();         
    }

    //执行图片添加
    public function doaddhouseforrentfile(){
        //实例化
        $house_for_rentfile = M('house_for_rentfile');
        //接收值
        $id = I('post.house_for_rend_id','','strip_tags');
        // dump($id);exit;
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
        //添加数据到second_hand_carfile表
        $data['house_for_rend_id'] = $id;
        $data['add_time'] = date('Y-m-d',time());
        foreach($path as $k=>$v){
            $data['file'] = $v;
            $resultinfo[$k] = $house_for_rentfile->add($data);
        }
        // dump(count($path));
        // dump(count($resultinfo));exit;
        if(count($path) == count($resultinfo)){
           //事物成功
            M()->commit();
            $this->success('添加成功',U('Service/houseforrentfile',array("id"=>$id)));
        }else{
            //事物回滚
            M()->rollback();
            $this->error('添加失败');
        }       
    }

    //删除图片
    public function delhouseforrentfile(){
        //实例化
        $house_for_rent     = M('house_for_rent');
        $house_for_rentfile = M('house_for_rentfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $fileinfo = $house_for_rentfile->where("id=$id")->field('house_for_rend_id,file')->find();
        $house_for_rend_id = $fileinfo['house_for_rend_id'];
        // dump($fileinfo);exit;
        if($house_for_rentfile->where("id=$id")->delete()){
            unlink('./Public/Uploads/'.$fileinfo['file']);
            $this->success('删除成功',U('Service/houseforrentfile',array("id"=>$house_for_rend_id)));
        }else{
            $this->error('修改失败');
        }       
    }

    //加载二手车修改图片页面
    public function edithouseforrentfile(){
        //实例化
        $house_for_rentfile = M('house_for_rentfile');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$house_for_rentfile->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }
    //执行房屋出租图片修改
    public function doedithouseforrentfile(){
        //实例化
        $house_for_rentfile = M('house_for_rentfile');
        //接收值
        $id = I('post.id','','strip_tags');
        //查询数据
        $row = $house_for_rentfile->where("id=$id")->find();
        $id1 = $row['house_for_rend_id'];
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
        $data['file']=$path;
        //执行修改
        if($house_for_rentfile->where("id=$id")->save($data)){
            unlink('./Public/Uploads/'.$row['file']);//删除图片
            $this->success('修改成功',U('Service/houseforrentfile',array("id"=>$id1)));
        }else{
            $this->error('修改失败');
        }         
    } 

//================================================货车出租truckrend================================================================

    //通过审核
    public function truckrendpass(){
        //实例化
        $truck_rend = M('truck_rend');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 2;
        //改数据
        if($truck_rend->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/truckrend'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //禁用
    public function truckrendstop(){
        //实例化
        $truck_rend = M('truck_rend');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 3;
        //改数据
        if($truck_rend->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/truckrend'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //货车出租展示
    public function truckrend(){
        //实例化
        $truck_rend = M('truck_rend');
        $user       = M('user'); 
        //分装查询条件
        $where=array();
        if(!empty($_GET['name'])){
            $where['name']=array('like',"%{$_GET['name']}%");
        }
        if(!empty($_GET['tel'])){
            $where['tel']=array('like',"%{$_GET['tel']}%");
        }
        if(!empty($_GET['states'])){
            $where['states']=array('like',"%{$_GET['states']}%");
        }
        //查询商品数据数据
        $count = $truck_rend->where($where)->count();
        $p=getpage($count,10);
        $info  = $truck_rend->where($where)->limit($p->firstRow, $p->listRows)->select();
        foreach($info as $k=>$v){
            $where1['id'] = $v['user_id'];
            $userinfo = $user->where($where1)->field('user_grade,user_name,user_store_name')->find();
            $info[$k]['user_grade']      = $userinfo['user_grade'];
            $info[$k]['user_name']       = $userinfo['user_name'];
            $info[$k]['user_store_name'] = $userinfo['user_store_name'];
            //判断是否过期
            if($v['valid_time'] > date('Y-m-d H:i:s')){
                $info[$k]['time'] = "正常";
            }else{
                $info[$k]['time'] = "失效";
            }
        }
        //加载数据
        // dump($info);exit;
        $this->assign('info',$info);
        $this->assign('page', $p->show());
        $this->display();
    }

    //货车出租删除
    public function truckrenddel(){
        //实例化
        $truck_rend      = M('truck_rend');
        $truck_rendfile  = M('truck_rendfile');
        M()->startTrans();
        //接收数据
        $where1['id'] = $where2['truck_rend_id'] = I('get.id','','strip_tags');
        //删除数据
        $len1  = $truck_rendfile->where($where2)->count();
        $info1 = $truck_rend->where($where1)->delete();
        $carfileinfo = $truck_rendfile->where($where2)->field('id,file')->select();
        // dump($carfileinfo);exit;
        foreach($carfileinfo as $k=>$v){
            $where3['id'] = $v['id'];
            $len2 += $truck_rendfile->where($where3)->delete();
        }
        if($info1 && $len1 == $len2){
            M()->commit();
            foreach($carfileinfo as $k=>$v){
                unlink('./Public/Uploads/'.$v['file']);//删除图片                
            }
            $this->success('删除成功',U('Service/truckrend'));
        }else{
            M()->rollback();
            $this->error('删除失败');           
        }          
    }

    //加载货车出租修改页面
    public function truckrendedit(){
        //实例化
        $truck_rend = M('truck_rend');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$truck_rend->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }  

    //执行货车出租修改
    public function truckrenddoedit(){
        //实例化
        $truck_rend = M('truck_rend');
        $rules  = array(
          array('brand','require','品牌不能为空!'), 
          array('car_num','require','车牌不能为空!'), 
          array('date_for_production','require','出厂年限不能为空!'), 
          array('price','require','价格不能为空!'), 
          array('des','require','标题描述不能为空!'), 
          array('name','require','联系人不能为空!'), 
          array('tel','require','手机号码不能为空!'), 
          array('tel','/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/','商户电话格式不对!'), 
        );

        if(!$truck_rend->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($truck_rend->getError());
        }
        $data['brand']               = I('post.brand','','strip_tags');
        $data['car_num']             = I('post.car_num','','strip_tags');
        $data['date_for_production'] = I('post.date_for_production','','strip_tags');
        $data['price']               = I('post.price','','strip_tags');
        $data['des']                 = I('post.des','','strip_tags');
        $data['name']                = I('post.name','','strip_tags');
        $data['tel']                 = I('post.tel','','strip_tags');
        if(!empty($_POST['end'])){
            $data['valid_time']          = I('post.end','','strip_tags');
        }
        $id                          = I('post.id','','strip_tags');
        // dump($row);
        // dump($data);
        // dump($data);exit;
        //执行修改
        if($truck_rend->where("id=$id")->save($data)){
            $this->success('修改成功',U('Service/truckrend'));
        }else{
            $this->error('修改失败');
        }  
    } 

    //浏览图片
    public function truckrendfile(){
        //实例化
        $truck_rendfile = M('truck_rendfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $truckrendpic = $truck_rendfile->where("truck_rend_id=$id")->select();
        // dump($id);exit;
        $this->assign('info',$truckrendpic);
        $this->assign('id',$id);
        $this->display();        
    }

    //添加图片页面
    public function addtruckrendfile(){
        //接收值
        $id = I('get.id','','strip_tags');
        // dump($id);exit;
        //加载页面，分配数据
        $this->assign('id',$id);
        $this->display();         
    }

    //执行图片添加
    public function doaddtruckrendfile(){
        //实例化
        $truck_rendfile = M('truck_rendfile');
        //接收值
        $id = I('post.truck_rend_id','','strip_tags');
        // dump($id);exit;
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
        //添加数据到second_hand_carfile表
        $data['truck_rend_id'] = $id;
        $data['add_time'] = date('Y-m-d',time());
        foreach($path as $k=>$v){
            $data['file'] = $v;
            $resultinfo[$k] = $truck_rendfile->add($data);
        }
        // dump(count($path));
        // dump(count($resultinfo));exit;
        if(count($path) == count($resultinfo)){
           //事物成功
            M()->commit();
            $this->success('添加成功',U('Service/truckrendfile',array("id"=>$id)));
        }else{
            //事物回滚
            M()->rollback();
            $this->error('添加失败');
        }       
    }

    //删除图片
    public function deltruckrendfile(){
        //实例化
        $truck_rend     = M('truck_rend');
        $truck_rendfile = M('truck_rendfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $fileinfo = $truck_rendfile->where("id=$id")->field('truck_rend_id,file')->find();
        $truck_rend_id = $fileinfo['truck_rend_id'];
        // dump($fileinfo);exit;
        if($truck_rendfile->where("id=$id")->delete()){
            unlink('./Public/Uploads/'.$fileinfo['file']);
            $this->success('删除成功',U('Service/truckrendfile',array("id"=>$truck_rend_id)));
        }else{
            $this->error('修改失败');
        }       
    }

    //加载货车修改图片页面
    public function edittruckrendfile(){
        //实例化
        $truck_rendfile = M('truck_rendfile');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$truck_rendfile->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }

    //执行货车出租图片修改
    public function doedittruckrendfile(){
        //实例化
        $truck_rendfile = M('truck_rendfile');
        //接收值
        $id = I('post.id','','strip_tags');
        //查询数据
        $row = $truck_rendfile->where("id=$id")->find();
        $id1 = $row['truck_rend_id'];
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
        $data['file']=$path;
        //执行修改
        if($truck_rendfile->where("id=$id")->save($data)){
            unlink('./Public/Uploads/'.$row['file']);//删除图片
            $this->success('修改成功',U('Service/truckrendfile',array("id"=>$id1)));
        }else{
            $this->error('修改失败');
        }         
    } 

//================================================家居装修homedecoration================================================================

    //通过审核
    public function homedecorationpass(){
        //实例化
        $home_decoration = M('home_decoration');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 2;
        //改数据
        if($home_decoration->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/homedecoration'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //禁用
    public function homedecorationstop(){
        //实例化
        $home_decoration = M('home_decoration');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 3;
        //改数据
        if($home_decoration->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/homedecoration'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //家居装修展示
    public function homedecoration(){
        //实例化
        $home_decoration = M('home_decoration');
        $user            = M('user'); 
        //分装查询条件
        $where=array();
        if(!empty($_GET['name'])){
            $where['name']=array('like',"%{$_GET['name']}%");
        }
        if(!empty($_GET['tel'])){
            $where['tel']=array('like',"%{$_GET['tel']}%");
        }
        if(!empty($_GET['states'])){
            $where['states']=array('like',"%{$_GET['states']}%");
        }
        //查询商品数据数据
        $count = $home_decoration->where($where)->count();
        $p=getpage($count,10);
        $info  = $home_decoration->where($where)->limit($p->firstRow, $p->listRows)->select();
        foreach($info as $k=>$v){
            $where1['id'] = $v['user_id'];
            $userinfo = $user->where($where1)->field('user_grade,user_name,user_store_name')->find();
            $info[$k]['user_grade']      = $userinfo['user_grade'];
            $info[$k]['user_name']       = $userinfo['user_name'];
            $info[$k]['user_store_name'] = $userinfo['user_store_name'];
            //判断是否过期
            if($v['valid_time'] > date('Y-m-d H:i:s')){
                $info[$k]['time'] = "正常";
            }else{
                $info[$k]['time'] = "失效";
            }
        }
        //加载数据
        // dump($info);exit;
        $this->assign('info',$info);
        $this->assign('page', $p->show());
        $this->display();
    }

    //家居装修删除
    public function homedecorationdel(){
        //实例化
        $home_decoration      = M('home_decoration');
        $home_decorationfile  = M('home_decorationfile');
        M()->startTrans();
        //接收数据
        $where1['id'] = $where2['home_decoration_id'] = I('get.id','','strip_tags');
        //删除数据
        $len1  = $home_decorationfile->where($where2)->count();
        $info1 = $home_decoration->where($where1)->delete();
        $carfileinfo = $home_decorationfile->where($where2)->field('id,file')->select();
        // dump($carfileinfo);exit;
        foreach($carfileinfo as $k=>$v){
            $where3['id'] = $v['id'];
            $len2 += $home_decorationfile->where($where3)->delete();
        }
        if($info1 && $len1 == $len2){
            M()->commit();
            foreach($carfileinfo as $k=>$v){
                unlink('./Public/Uploads/'.$v['file']);//删除图片                
            }
            $this->success('删除成功',U('Service/homedecoration'));
        }else{
            M()->rollback();
            $this->error('删除失败');           
        }          
    }

    //加载家居装修修改页面
    public function homedecorationedit(){
        //实例化
        $home_decoration = M('home_decoration');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$home_decoration->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }  

    //执行家居装修修改
    public function homedecorationdoedit(){
        //实例化
        $home_decoration = M('home_decoration');
        $rules  = array(
          array('address','require','地址不能为空!'), 
          array('pay_method','require','付款方式不能为空!'), 
          array('des','require','标题描述不能为空!'), 
          array('name','require','联系人不能为空!'), 
          array('tel','require','手机号码不能为空!'), 
          array('tel','/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/','商户电话格式不对!'), 
        );

        if(!$home_decoration->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($home_decoration->getError());
        }
        $data['address']             = I('post.address','','strip_tags');
        $data['pay_method']          = I('post.pay_method','','strip_tags');
        $data['des']                 = I('post.des','','strip_tags');
        $data['name']                = I('post.name','','strip_tags');
        $data['tel']                 = I('post.tel','','strip_tags');
        if(!empty($_POST['end'])){
            $data['valid_time']          = I('post.end','','strip_tags');
        }
        $id                          = I('post.id','','strip_tags');
        // dump($row);
        // dump($data);
        // dump($data);exit;
        //执行修改
        if($home_decoration->where("id=$id")->save($data)){
            $this->success('修改成功',U('Service/homedecoration'));
        }else{
            $this->error('修改失败');
        }  
    } 

    //浏览图片
    public function homedecorationfile(){
        //实例化
        $home_decorationfile = M('home_decorationfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $homedecorationpic = $home_decorationfile->where("home_decoration_id=$id")->select();
        // dump($id);exit;
        $this->assign('info',$homedecorationpic);
        $this->assign('id',$id);
        $this->display();        
    }

    //添加图片页面
    public function addhomedecorationfile(){
        //接收值
        $id = I('get.id','','strip_tags');
        // dump($id);exit;
        //加载页面，分配数据
        $this->assign('id',$id);
        $this->display();         
    }

    //执行图片添加
    public function doaddhomedecorationfile(){
        //实例化
        $home_decorationfile = M('home_decorationfile');
        //接收值
        $id = I('post.home_decoration_id','','strip_tags');
        // dump($id);exit;
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
        //添加数据到second_hand_carfile表
        $data['home_decoration_id'] = $id;
        $data['add_time'] = date('Y-m-d',time());
        foreach($path as $k=>$v){
            $data['file'] = $v;
            $resultinfo[$k] = $home_decorationfile->add($data);
        }
        // dump(count($path));
        // dump(count($resultinfo));exit;
        if(count($path) == count($resultinfo)){
           //事物成功
            M()->commit();
            $this->success('添加成功',U('Service/homedecorationfile',array("id"=>$id)));
        }else{
            //事物回滚
            M()->rollback();
            $this->error('添加失败');
        }       
    }

    //删除图片
    public function delhomedecorationfile(){
        //实例化
        $home_decoration     = M('home_decoration');
        $home_decorationfile = M('home_decorationfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $fileinfo = $home_decorationfile->where("id=$id")->field('home_decoration_id,file')->find();
        $home_decoration_id = $fileinfo['home_decoration_id'];
        // dump($fileinfo);exit;
        if($home_decorationfile->where("id=$id")->delete()){
            unlink('./Public/Uploads/'.$fileinfo['file']);
            $this->success('删除成功',U('Service/homedecorationfile',array("id"=>$home_decoration_id)));
        }else{
            $this->error('修改失败');
        }       
    }

    //加载家居装修修改图片页面
    public function edithomedecorationfile(){
        //实例化
        $home_decorationfile = M('home_decorationfile');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$home_decorationfile->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }

    //执行家居装修图片修改
    public function doedithomedecorationfile(){
        //实例化
        $home_decorationfile = M('home_decorationfile');
        //接收值
        $id = I('post.id','','strip_tags');
        //查询数据
        $row = $home_decorationfile->where("id=$id")->find();
        $id1 = $row['home_decoration_id'];
        // dump($id);
        // dump($id1);
        // dump($row);exit;
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
        $data['file']=$path;
        //执行修改
        if($home_decorationfile->where("id=$id")->save($data)){
            unlink('./Public/Uploads/'.$row['file']);//删除图片
            $this->success('修改成功',U('Service/homedecorationfile',array("id"=>$id1)));
        }else{
            $this->error('修改失败');
        }         
    } 

//================================================家政服务housekeeping================================================================

    //通过审核
    public function housekeepingpass(){
        //实例化
        $housekeeping = M('housekeeping');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 2;
        //改数据
        if($housekeeping->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/housekeeping'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //禁用
    public function housekeepingstop(){
        //实例化
        $housekeeping = M('housekeeping');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 3;
        //改数据
        if($housekeeping->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/housekeeping'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //家政服务展示
    public function housekeeping(){
        //实例化
        $housekeeping = M('housekeeping');
        $user         = M('user'); 
        //分装查询条件
        $where=array();
        if(!empty($_GET['name'])){
            $where['name']=array('like',"%{$_GET['name']}%");
        }
        if(!empty($_GET['tel'])){
            $where['tel']=array('like',"%{$_GET['tel']}%");
        }
        if(!empty($_GET['states'])){
            $where['states']=array('like',"%{$_GET['states']}%");
        }
        //查询商品数据数据
        $count = $housekeeping->where($where)->count();
        $p=getpage($count,10);
        $info  = $housekeeping->where($where)->limit($p->firstRow, $p->listRows)->select();
        foreach($info as $k=>$v){
            $where1['id'] = $v['user_id'];
            $userinfo = $user->where($where1)->field('user_grade,user_name,user_store_name')->find();
            $info[$k]['user_grade']      = $userinfo['user_grade'];
            $info[$k]['user_name']       = $userinfo['user_name'];
            $info[$k]['user_store_name'] = $userinfo['user_store_name'];
            //判断是否过期
            if($v['valid_time'] > date('Y-m-d H:i:s')){
                $info[$k]['time'] = "正常";
            }else{
                $info[$k]['time'] = "失效";
            }
        }
        //加载数据
        // dump($info);exit;
        $this->assign('info',$info);
        $this->assign('page', $p->show());
        $this->display();
    }

    //家政服务删除
    public function housekeepingdel(){
        //实例化
        $housekeeping      = M('housekeeping');
        $housekeepingfile  = M('housekeepingfile');
        M()->startTrans();
        //接收数据
        $where1['id'] = $where2['housekeeping_id'] = I('get.id','','strip_tags');
        //删除数据
        $len1  = $housekeepingfile->where($where2)->count();
        $info1 = $housekeeping->where($where1)->delete();
        $carfileinfo = $housekeepingfile->where($where2)->field('id,file')->select();
        // dump($carfileinfo);exit;
        foreach($carfileinfo as $k=>$v){
            $where3['id'] = $v['id'];
            $len2 += $housekeepingfile->where($where3)->delete();
        }
        if($info1 && $len1 == $len2){
            M()->commit();
            foreach($carfileinfo as $k=>$v){
                unlink('./Public/Uploads/'.$v['file']);//删除图片                
            }
            $this->success('删除成功',U('Service/housekeeping'));
        }else{
            M()->rollback();
            $this->error('删除失败');           
        }          
    }

    //加载家政服务修改页面
    public function housekeepingedit(){
        //实例化
        $housekeeping = M('housekeeping');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$housekeeping->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }  

    //执行家政服务修改
    public function housekeepingdoedit(){
        //实例化
        $housekeeping = M('housekeeping');
        $rules  = array(
          array('address','require','地址不能为空!'), 
          array('pay_method','require','付款方式不能为空!'), 
          array('des','require','标题描述不能为空!'), 
          array('name','require','联系人不能为空!'), 
          array('tel','require','手机号码不能为空!'), 
          array('tel','/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/','商户电话格式不对!'), 
        );

        if(!$housekeeping->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($housekeeping->getError());
        }
        $data['address']             = I('post.address','','strip_tags');
        $data['pay_method']          = I('post.pay_method','','strip_tags');
        $data['des']                 = I('post.des','','strip_tags');
        $data['name']                = I('post.name','','strip_tags');
        $data['tel']                 = I('post.tel','','strip_tags');
        if(!empty($_POST['end'])){
            $data['valid_time']          = I('post.end','','strip_tags');
        }
        $id                          = I('post.id','','strip_tags');
        // dump($row);
        // dump($data);
        // dump($data);exit;
        //执行修改
        if($housekeeping->where("id=$id")->save($data)){
            $this->success('修改成功',U('Service/housekeeping'));
        }else{
            $this->error('修改失败');
        }  
    } 

    //浏览图片
    public function housekeepingfile(){
        //实例化
        $housekeepingfile = M('housekeepingfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $housekeepingpic = $housekeepingfile->where("housekeeping_id=$id")->select();
        // dump($id);exit;
        $this->assign('info',$housekeepingpic);
        $this->assign('id',$id);
        $this->display();        
    }

    //添加图片页面
    public function addhousekeepingfile(){
        //接收值
        $id = I('get.id','','strip_tags');
        // dump($id);exit;
        //加载页面，分配数据
        $this->assign('id',$id);
        $this->display();         
    }

    //执行图片添加
    public function doaddhousekeepingfile(){
        //实例化
        $housekeepingfile = M('housekeepingfile');
        //接收值
        $id = I('post.housekeeping_id','','strip_tags');
        // dump($id);exit;
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
        //添加数据到second_hand_carfile表
        $data['housekeeping_id'] = $id;
        $data['add_time'] = date('Y-m-d',time());
        foreach($path as $k=>$v){
            $data['file'] = $v;
            $resultinfo[$k] = $housekeepingfile->add($data);
        }
        // dump(count($path));
        // dump(count($resultinfo));exit;
        if(count($path) == count($resultinfo)){
           //事物成功
            M()->commit();
            $this->success('添加成功',U('Service/housekeepingfile',array("id"=>$id)));
        }else{
            //事物回滚
            M()->rollback();
            $this->error('添加失败');
        }       
    }

    //删除图片
    public function delhousekeepingfile(){
        //实例化
        $housekeeping     = M('housekeeping');
        $housekeepingfile = M('housekeepingfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $fileinfo = $housekeepingfile->where("id=$id")->field('housekeeping_id,file')->find();
        $housekeeping_id = $fileinfo['housekeeping_id'];
        // dump($fileinfo);exit;
        if($housekeepingfile->where("id=$id")->delete()){
            unlink('./Public/Uploads/'.$fileinfo['file']);
            $this->success('删除成功',U('Service/housekeepingfile',array("id"=>$housekeeping_id)));
        }else{
            $this->error('修改失败');
        }       
    }

    //加载货车修改图片页面
    public function edithousekeepingfile(){
        //实例化
        $housekeepingfile = M('housekeepingfile');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$housekeepingfile->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }

    //执行家政服务图片修改
    public function doedithousekeepingfile(){
        //实例化
        $housekeepingfile = M('housekeepingfile');
        //接收值
        $id = I('post.id','','strip_tags');
        //查询数据
        $row = $housekeepingfile->where("id=$id")->find();
        $id1 = $row['housekeeping_id'];
        // dump($id);
        // dump($id1);
        // dump($row);exit;
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
        $data['file']=$path;
        //执行修改
        if($housekeepingfile->where("id=$id")->save($data)){
            unlink('./Public/Uploads/'.$row['file']);//删除图片
            $this->success('修改成功',U('Service/housekeepingfile',array("id"=>$id1)));
        }else{
            $this->error('修改失败');
        }         
    }

//================================================维修服务weixiuservice================================================================

    //通过审核
    public function weixiuservicepass(){
        //实例化
        $weixiu_service = M('weixiu_service');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 2;
        //改数据
        if($weixiu_service->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/weixiuservice'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //禁用
    public function weixiuservicestop(){
        //实例化
        $weixiu_service = M('weixiu_service');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 3;
        //改数据
        if($weixiu_service->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/weixiuservice'));
        }else{
            $this->error('修改失败'); 
        }
    }


    //维修服务展示
    public function weixiuservice(){
        //实例化
        $weixiu_service = M('weixiu_service');
        $user           = M('user'); 
        //分装查询条件
        $where=array();
        if(!empty($_GET['name'])){
            $where['name']=array('like',"%{$_GET['name']}%");
        }
        if(!empty($_GET['tel'])){
            $where['tel']=array('like',"%{$_GET['tel']}%");
        }
        if(!empty($_GET['states'])){
            $where['states']=array('like',"%{$_GET['states']}%");
        }
        //查询商品数据数据
        $count = $weixiu_service->where($where)->count();
        $p=getpage($count,10);
        $info  = $weixiu_service->where($where)->limit($p->firstRow, $p->listRows)->select();
        foreach($info as $k=>$v){
            $where1['id'] = $v['user_id'];
            $userinfo = $user->where($where1)->field('user_grade,user_name,user_store_name')->find();
            $info[$k]['user_grade']      = $userinfo['user_grade'];
            $info[$k]['user_name']       = $userinfo['user_name'];
            $info[$k]['user_store_name'] = $userinfo['user_store_name'];
            //判断是否过期
            if($v['valid_time'] > date('Y-m-d H:i:s')){
                $info[$k]['time'] = "正常";
            }else{
                $info[$k]['time'] = "失效";
            }
        }
        //加载数据
        // dump($info);exit;
        $this->assign('info',$info);
        $this->assign('page', $p->show());
        $this->display();
    }

    //维修服务删除
    public function weixiuservicedel(){
        //实例化
        $weixiu_service      = M('weixiu_service');
        $weixiu_servicefile  = M('weixiu_servicefile');
        M()->startTrans();
        //接收数据
        $where1['id'] = $where2['weixiu_service_id'] = I('get.id','','strip_tags');
        //删除数据
        $len1  = $weixiu_servicefile->where($where2)->count();
        $info1 = $weixiu_service->where($where1)->delete();
        $carfileinfo = $weixiu_servicefile->where($where2)->field('id,file')->select();
        // dump($carfileinfo);exit;
        foreach($carfileinfo as $k=>$v){
            $where3['id'] = $v['id'];
            $len2 += $weixiu_servicefile->where($where3)->delete();
        }
        if($info1 && $len1 == $len2){
            M()->commit();
            foreach($carfileinfo as $k=>$v){
                unlink('./Public/Uploads/'.$v['file']);//删除图片                
            }
            $this->success('删除成功',U('Service/weixiuservice'));
        }else{
            M()->rollback();
            $this->error('删除失败');           
        }          
    }

    //加载维修服务修改页面
    public function weixiuserviceedit(){
        //实例化
        $weixiu_service = M('weixiu_service');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$weixiu_service->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }  

    //执行维修服务修改
    public function weixiuservicedoedit(){
        //实例化
        $weixiu_service = M('weixiu_service');
        $rules  = array(
          array('address','require','地址不能为空!'), 
          array('pay_method','require','付款方式不能为空!'), 
          array('des','require','标题描述不能为空!'), 
          array('name','require','联系人不能为空!'), 
          array('tel','require','手机号码不能为空!'), 
          array('tel','/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/','商户电话格式不对!'), 
        );

        if(!$weixiu_service->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($weixiu_service->getError());
        }
        $data['address']             = I('post.address','','strip_tags');
        $data['pay_method']          = I('post.pay_method','','strip_tags');
        $data['des']                 = I('post.des','','strip_tags');
        $data['name']                = I('post.name','','strip_tags');
        $data['tel']                 = I('post.tel','','strip_tags');
        if(!empty($_POST['end'])){
            $data['valid_time']          = I('post.end','','strip_tags');
        }
        $id                          = I('post.id','','strip_tags');
        // dump($row);
        // dump($data);
        // dump($data);exit;
        //执行修改
        if($weixiu_service->where("id=$id")->save($data)){
            $this->success('修改成功',U('Service/weixiuservice'));
        }else{
            $this->error('修改失败');
        }  
    } 

    //浏览图片
    public function weixiuservicefile(){
        //实例化
        $weixiu_servicefile = M('weixiu_servicefile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $weixiuservicepic = $weixiu_servicefile->where("weixiu_service_id=$id")->select();
        // dump($id);exit;
        $this->assign('info',$weixiuservicepic);
        $this->assign('id',$id);
        $this->display();        
    }

    //添加图片页面
    public function addweixiuservicefile(){
        //接收值
        $id = I('get.id','','strip_tags');
        // dump($id);exit;
        //加载页面，分配数据
        $this->assign('id',$id);
        $this->display();         
    }

    //执行图片添加
    public function doaddweixiuservicefile(){
        //实例化
        $weixiu_servicefile = M('weixiu_servicefile');
        //接收值
        $id = I('post.weixiu_service_id','','strip_tags');
        // dump($id);exit;
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
        //添加数据到second_hand_carfile表
        $data['weixiu_service_id'] = $id;
        $data['add_time'] = date('Y-m-d',time());
        foreach($path as $k=>$v){
            $data['file'] = $v;
            $resultinfo[$k] = $weixiu_servicefile->add($data);
        }
        // dump(count($path));
        // dump(count($resultinfo));exit;
        if(count($path) == count($resultinfo)){
           //事物成功
            M()->commit();
            $this->success('添加成功',U('Service/weixiuservicefile',array("id"=>$id)));
        }else{
            //事物回滚
            M()->rollback();
            $this->error('添加失败');
        }       
    }

    //删除图片
    public function delweixiuservicefile(){
        //实例化
        $weixiu_service     = M('weixiu_service');
        $weixiu_servicefile = M('weixiu_servicefile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $fileinfo = $weixiu_servicefile->where("id=$id")->field('weixiu_service_id,file')->find();
        $weixiu_service_id = $fileinfo['weixiu_service_id'];
        // dump($fileinfo);exit;
        if($weixiu_servicefile->where("id=$id")->delete()){
            unlink('./Public/Uploads/'.$fileinfo['file']);
            $this->success('删除成功',U('Service/weixiuservicefile',array("id"=>$weixiu_service_id)));
        }else{
            $this->error('修改失败');
        }       
    }

    //加载货车修改图片页面
    public function editweixiuservicefile(){
        //实例化
        $weixiu_servicefile = M('weixiu_servicefile');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$weixiu_servicefile->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }

    //执行维修服务图片修改
    public function doeditweixiuservicefile(){
        //实例化
        $weixiu_servicefile = M('weixiu_servicefile');
        //接收值
        $id = I('post.id','','strip_tags');
        //查询数据
        $row = $weixiu_servicefile->where("id=$id")->find();
        $id1 = $row['weixiu_service_id'];
        // dump($id);
        // dump($id1);
        // dump($row);exit;
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
        $data['file']=$path;
        //执行修改
        if($weixiu_servicefile->where("id=$id")->save($data)){
            unlink('./Public/Uploads/'.$row['file']);//删除图片
            $this->success('修改成功',U('Service/weixiuservicefile',array("id"=>$id1)));
        }else{
            $this->error('修改失败');
        }         
    } 

//================================================医疗medialservice================================================================

    //通过审核
    public function medialservicepass(){
        //实例化
        $medial_service = M('medial_service');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 2;
        //改数据
        if($medial_service->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/medialservice'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //禁用
    public function medialservicestop(){
        //实例化
        $medial_service = M('medial_service');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 3;
        //改数据
        if($medial_service->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/medialservice'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //医疗展示
    public function medialservice(){
        //实例化
        $medial_service = M('medial_service');
        $user           = M('user');
        //分装查询条件
        $where=array();
        if(!empty($_GET['name'])){
            $where['name']=array('like',"%{$_GET['name']}%");
        }
        if(!empty($_GET['tel'])){
            $where['tel']=array('like',"%{$_GET['tel']}%");
        }
        if(!empty($_GET['states'])){
            $where['states']=array('like',"%{$_GET['states']}%");
        }
        //查询商品数据数据
        $count = $medial_service->where($where)->count();
        $p=getpage($count,10);
        $info  = $medial_service->where($where)->limit($p->firstRow, $p->listRows)->select();
        foreach($info as $k=>$v){
            $where1['id'] = $v['user_id'];
            $userinfo = $user->where($where1)->field('user_grade,user_name,user_store_name')->find();
            $info[$k]['user_grade']      = $userinfo['user_grade'];
            $info[$k]['user_name']       = $userinfo['user_name'];
            $info[$k]['user_store_name'] = $userinfo['user_store_name'];
            //判断是否过期
            if($v['valid_time'] > date('Y-m-d H:i:s')){
                $info[$k]['time'] = "正常";
            }else{
                $info[$k]['time'] = "失效";
            }
        }
        //加载数据
        // dump($info);exit;
        $this->assign('info',$info);
        $this->assign('page', $p->show());
        $this->display();
    }

    //医疗删除
    public function medialservicedel(){
        //实例化
        $medial_service      = M('medial_service');
        $medial_servicefile  = M('medial_servicefile');
        M()->startTrans();
        //接收数据
        $where1['id'] = $where2['medial_service_id'] = I('get.id','','strip_tags');
        //删除数据
        $len1  = $medial_servicefile->where($where2)->count();
        $info1 = $medial_service->where($where1)->delete();
        $carfileinfo = $medial_servicefile->where($where2)->field('id,file')->select();
        // dump($carfileinfo);exit;
        foreach($carfileinfo as $k=>$v){
            $where3['id'] = $v['id'];
            $len2 += $medial_servicefile->where($where3)->delete();
        }
        if($info1 && $len1 == $len2){
            M()->commit();
            foreach($carfileinfo as $k=>$v){
                unlink('./Public/Uploads/'.$v['file']);//删除图片                
            }
            $this->success('删除成功',U('Service/medialservice'));
        }else{
            M()->rollback();
            $this->error('删除失败');           
        }          
    }

    //加载医疗修改页面
    public function medialserviceedit(){
        //实例化
        $medial_service = M('medial_service');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$medial_service->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }  

    //执行医疗修改
    public function medialservicedoedit(){
        //实例化
        $medial_service = M('medial_service');
        $rules  = array(
          array('address','require','地址不能为空!'), 
          array('pay_method','require','付款方式不能为空!'), 
          array('des','require','标题描述不能为空!'), 
          array('name','require','联系人不能为空!'), 
          array('tel','require','手机号码不能为空!'), 
          array('tel','/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/','商户电话格式不对!'), 
        );

        if(!$medial_service->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($medial_service->getError());
        }
        $data['address']             = I('post.address','','strip_tags');
        $data['pay_method']          = I('post.pay_method','','strip_tags');
        $data['des']                 = I('post.des','','strip_tags');
        $data['name']                = I('post.name','','strip_tags');
        $data['tel']                 = I('post.tel','','strip_tags');
        if(!empty($_POST['end'])){
            $data['valid_time']          = I('post.end','','strip_tags');
        }
        $id                          = I('post.id','','strip_tags');
        // dump($row);
        // dump($data);
        // dump($data);exit;
        //执行修改
        if($medial_service->where("id=$id")->save($data)){
            $this->success('修改成功',U('Service/medialservice'));
        }else{
            $this->error('修改失败');
        }  
    } 

    //浏览图片
    public function medialservicefile(){
        //实例化
        $medial_servicefile = M('medial_servicefile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $medialservicepic = $medial_servicefile->where("medial_service_id=$id")->select();
        // dump($id);exit;
        $this->assign('info',$medialservicepic);
        $this->assign('id',$id);
        $this->display();        
    }

    //添加图片页面
    public function addmedialservicefile(){
        //接收值
        $id = I('get.id','','strip_tags');
        // dump($id);exit;
        //加载页面，分配数据
        $this->assign('id',$id);
        $this->display();         
    }

    //执行图片添加
    public function doaddmedialservicefile(){
        //实例化
        $medial_servicefile = M('medial_servicefile');
        //接收值
        $id = I('post.medial_service_id','','strip_tags');
        // dump($id);exit;
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
        //添加数据到second_hand_carfile表
        $data['medial_service_id'] = $id;
        $data['add_time'] = date('Y-m-d',time());
        foreach($path as $k=>$v){
            $data['file'] = $v;
            $resultinfo[$k] = $medial_servicefile->add($data);
        }
        // dump(count($path));
        // dump(count($resultinfo));exit;
        if(count($path) == count($resultinfo)){
           //事物成功
            M()->commit();
            $this->success('添加成功',U('Service/medialservicefile',array("id"=>$id)));
        }else{
            //事物回滚
            M()->rollback();
            $this->error('添加失败');
        }       
    }

    //删除图片
    public function delmedialservicefile(){
        //实例化
        $medial_service     = M('medial_service');
        $medial_servicefile = M('medial_servicefile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $fileinfo = $medial_servicefile->where("id=$id")->field('medial_service_id,file')->find();
        $medial_service_id = $fileinfo['medial_service_id'];
        // dump($fileinfo);exit;
        if($medial_servicefile->where("id=$id")->delete()){
            unlink('./Public/Uploads/'.$fileinfo['file']);
            $this->success('删除成功',U('Service/medialservicefile',array("id"=>$medial_service_id)));
        }else{
            $this->error('修改失败');
        }       
    }

    //加载货车修改图片页面
    public function editmedialservicefile(){
        //实例化
        $medial_servicefile = M('medial_servicefile');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$medial_servicefile->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }

    //执行医疗图片修改
    public function doeditmedialservicefile(){
        //实例化
        $medial_servicefile = M('medial_servicefile');
        //接收值
        $id = I('post.id','','strip_tags');
        //查询数据
        $row = $medial_servicefile->where("id=$id")->find();
        $id1 = $row['medial_service_id'];
        // dump($id);
        // dump($id1);
        // dump($row);exit;
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
        $data['file']=$path;
        //执行修改
        if($medial_servicefile->where("id=$id")->save($data)){
            unlink('./Public/Uploads/'.$row['file']);//删除图片
            $this->success('修改成功',U('Service/medialservicefile',array("id"=>$id1)));
        }else{
            $this->error('修改失败');
        }         
    } 

//================================================招聘信息inforservice================================================================

    //通过审核
    public function informationpass(){
        //实例化
        $information = M('information');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 2;
        //改数据
        if($information->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/inforservice'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //禁用
    public function informationstop(){
        //实例化
        $information = M('information');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 3;
        //改数据
        if($information->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/inforservice'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //招聘信息展示
    public function inforservice(){
        //实例化
        $information = M('information');
        $user        = M('user');
        //分装查询条件
        $where=array();
        if(!empty($_GET['name'])){
            $where['name']=array('like',"%{$_GET['name']}%");
        }
        if(!empty($_GET['tel'])){
            $where['tel']=array('like',"%{$_GET['tel']}%");
        }
        if(!empty($_GET['states'])){
            $where['states']=array('like',"%{$_GET['states']}%");
        }
        //查询商品数据数据
        $count = $information->where($where)->count();
        $p=getpage($count,10);
        $info  = $information->where($where)->limit($p->firstRow, $p->listRows)->select();
        foreach($info as $k=>$v){
            $where1['id'] = $v['user_id'];
            $userinfo = $user->where($where1)->field('user_grade,user_name,user_store_name')->find();
            $info[$k]['user_grade']      = $userinfo['user_grade'];
            $info[$k]['user_name']       = $userinfo['user_name'];
            $info[$k]['user_store_name'] = $userinfo['user_store_name'];
            //判断是否过期
            if($v['valid_time'] > date('Y-m-d H:i:s')){
                $info[$k]['time'] = "正常";
            }else{
                $info[$k]['time'] = "失效";
            }
        }
        //加载数据
        // dump($info);exit;
        $this->assign('info',$info);
        $this->assign('page', $p->show());
        $this->display();
    }

    //招聘信息删除
    public function inforservicedel(){
        //实例化
        $information      = M('information');
        $informationfile  = M('informationfile');
        M()->startTrans();
        //接收数据
        $where1['id'] = $where2['information_id'] = I('get.id','','strip_tags');
        //删除数据
        $len1  = $informationfile->where($where2)->count();
        $info1 = $information->where($where1)->delete();
        $carfileinfo = $informationfile->where($where2)->field('id,file')->select();
        // dump($carfileinfo);exit;
        foreach($carfileinfo as $k=>$v){
            $where3['id'] = $v['id'];
            $len2 += $informationfile->where($where3)->delete();
        }
        if($info1 && $len1 == $len2){
            M()->commit();
            foreach($carfileinfo as $k=>$v){
                unlink('./Public/Uploads/'.$v['file']);//删除图片                
            }
            $this->success('删除成功',U('Service/inforservice'));
        }else{
            M()->rollback();
            $this->error('删除失败');           
        }          
    }

    //加载招聘信息修改页面
    public function inforserviceedit(){
        //实例化
        $information = M('information');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$information->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }  

    //执行招聘信息修改
    public function inforservicedoedit(){
        //实例化
        $information = M('information');
        $rules  = array(
            array('company_name','require','公司名称不能为空!'), 
            array('company_des','require','公司简介不能为空!'), 
            array('address','require','公司地址不能为空!'), 
            array('seat','require','招聘职位不能为空!'), 
            array('job_req','require','职位要求不能为空!'), 
            array('payment','require','薪酬不能为空!'), 
            array('name','require','联系人不能为空!'), 
            array('tel','require','手机号码不能为空!'), 
            array('tel','/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/','商户电话格式不对!'), 
        );

        if(!$information->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($information->getError());
        }
        $data['company_name']        = I('post.company_name','','strip_tags');
        $data['company_des']         = I('post.company_des','','strip_tags');
        $data['address']             = I('post.address','','strip_tags');
        $data['seat']                = I('post.seat','','strip_tags');
        $data['job_req']             = I('post.job_req','','strip_tags');
        $data['payment']             = I('post.payment','','strip_tags');
        $data['name']                = I('post.name','','strip_tags');
        $data['tel']                 = I('post.tel','','strip_tags');
        if(!empty($_POST['end'])){
            $data['valid_time']          = I('post.end','','strip_tags');
        }
        $id                          = I('post.id','','strip_tags');
        // dump($row);
        // dump($data);
        // dump($data);exit;
        //执行修改
        if($information->where("id=$id")->save($data)){
            $this->success('修改成功',U('Service/inforservice'));
        }else{
            $this->error('修改失败');
        }  
    } 

    //浏览图片
    public function inforservicefile(){
        //实例化
        $informationfile = M('informationfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $inforservicepic = $informationfile->where("information_id=$id")->select();
        // dump($id);exit;
        $this->assign('info',$inforservicepic);
        $this->assign('id',$id);
        $this->display();        
    }

    //添加图片页面
    public function addinforservicefile(){
        //接收值
        $id = I('get.id','','strip_tags');
        // dump($id);exit;
        //加载页面，分配数据
        $this->assign('id',$id);
        $this->display();         
    }

    //执行图片添加
    public function doaddinforservicefile(){
        //实例化
        $informationfile = M('informationfile');
        //接收值
        $id = I('post.information_id','','strip_tags');
        // dump($id);exit;
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
        //添加数据到second_hand_carfile表
        $data['information_id'] = $id;
        $data['add_time'] = date('Y-m-d',time());
        foreach($path as $k=>$v){
            $data['file'] = $v;
            $resultinfo[$k] = $informationfile->add($data);
        }
        // dump(count($path));
        // dump(count($resultinfo));exit;
        if(count($path) == count($resultinfo)){
           //事物成功
            M()->commit();
            $this->success('添加成功',U('Service/inforservicefile',array("id"=>$id)));
        }else{
            //事物回滚
            M()->rollback();
            $this->error('添加失败');
        }       
    }

    //删除图片
    public function delinforservicefile(){
        //实例化
        $information     = M('information');
        $informationfile = M('informationfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $fileinfo = $informationfile->where("id=$id")->field('information_id,file')->find();
        $information_id = $fileinfo['information_id'];
        // dump($fileinfo);exit;
        if($informationfile->where("id=$id")->delete()){
            unlink('./Public/Uploads/'.$fileinfo['file']);
            $this->success('删除成功',U('Service/inforservicefile',array("id"=>$information_id)));
        }else{
            $this->error('修改失败');
        }       
    }

    //加载货车修改图片页面
    public function editinforservicefile(){
        //实例化
        $informationfile = M('informationfile');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$informationfile->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }

    //执行招聘信息图片修改
    public function doeditinforservicefile(){
        //实例化
        $informationfile = M('informationfile');
        //接收值
        $id = I('post.id','','strip_tags');
        //查询数据
        $row = $informationfile->where("id=$id")->find();
        $id1 = $row['information_id'];
        // dump($id);
        // dump($id1);
        // dump($row);exit;
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
        $data['file']=$path;
        //执行修改
        if($informationfile->where("id=$id")->save($data)){
            unlink('./Public/Uploads/'.$row['file']);//删除图片
            $this->success('修改成功',U('Service/inforservicefile',array("id"=>$id1)));
        }else{
            $this->error('修改失败');
        }         
    } 

//================================================公司工厂company================================================================

    //通过审核
    public function companypass(){
        //实例化
        $company = M('company');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 2;
        //改数据
        if($company->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/company'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //禁用
    public function companystop(){
        //实例化
        $company = M('company');
        //接收数据
        $id = I('get.id','','strip_tags');
        $date['states'] = 3;
        //改数据
        if($company->where("id=$id")->save($date)){
            $this->success('修改成功',U('Service/company'));
        }else{
            $this->error('修改失败'); 
        }
    }

    //公司工厂展示
    public function company(){
        //实例化
        $company = M('company');
        $user        = M('user');
        //分装查询条件
        $where=array();
        if(!empty($_GET['name'])){
            $where['company_name']=array('like',"%{$_GET['name']}%");
        }
        if(!empty($_GET['tel'])){
            $where['tel']=array('like',"%{$_GET['tel']}%");
        }
        if(!empty($_GET['states'])){
            $where['states']=array('like',"%{$_GET['states']}%");
        }
        //查询商品数据数据
        $count = $company->where($where)->count();
        $p=getpage($count,10);
        $info  = $company->where($where)->limit($p->firstRow, $p->listRows)->select();
        foreach($info as $k=>$v){
            $where1['id'] = $v['user_id'];
            $userinfo = $user->where($where1)->field('user_grade,user_name,user_store_name')->find();
            $info[$k]['user_grade']      = $userinfo['user_grade'];
            $info[$k]['user_name']       = $userinfo['user_name'];
            $info[$k]['user_store_name'] = $userinfo['user_store_name'];
            //判断是否过期
            if($v['valid_time'] > date('Y-m-d H:i:s')){
                $info[$k]['time'] = "正常";
            }else{
                $info[$k]['time'] = "失效";
            }
        }
        //加载数据
        // dump($info);exit;
        $this->assign('info',$info);
        $this->assign('page', $p->show());
        $this->display();
    }

    //公司工厂删除
    public function companydel(){
        //实例化
        $company      = M('company');
        $companyfile  = M('companyfile');
        M()->startTrans();
        //接收数据
        $where1['id'] = $where2['company_id'] = I('get.id','','strip_tags');
        //删除数据
        $len1  = $companyfile->where($where2)->count();
        $info1 = $company->where($where1)->delete();
        $carfileinfo = $companyfile->where($where2)->field('id,file')->select();
        // dump($carfileinfo);exit;
        foreach($carfileinfo as $k=>$v){
            $where3['id'] = $v['id'];
            $len2 += $companyfile->where($where3)->delete();
        }
        if($info1 && $len1 == $len2){
            M()->commit();
            foreach($carfileinfo as $k=>$v){
                unlink('./Public/Uploads/'.$v['file']);//删除图片                
            }
            $this->success('删除成功',U('Service/company'));
        }else{
            M()->rollback();
            $this->error('删除失败');           
        }          
    }

    //加载公司工厂修改页面
    public function companyedit(){
        //实例化
        $company = M('company');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$company->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }  

    //执行公司工厂修改
    public function companydoedit(){
        //实例化
        $company = M('company');
        $rules  = array(
            array('company_name','require','公司工厂名称不能为空!'), 
            array('company_des','require','公司工厂简介不能为空!'), 
            array('address','require','公司工厂地址不能为空!'), 
            array('register_time','require','公司工厂注册时间不能为空!'), 
            array('contents','require','主要经营不能为空!'), 
            array('legal_person','require','法人不能为空!'),  
            array('tel','require','手机号码不能为空!'), 
            array('tel','/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/','商户电话格式不对!'), 
        );

        if(!$company->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($company->getError());
        }
        $data['company_name']        = I('post.company_name','','strip_tags');
        $data['company_des']         = I('post.company_des','','strip_tags');
        $data['address']             = I('post.address','','strip_tags');
        $data['register_time']       = I('post.register_time','','strip_tags');
        $data['contents']            = I('post.contents','','strip_tags');
        $data['legal_person']        = I('post.legal_person','','strip_tags');
        $data['tel']                 = I('post.tel','','strip_tags');
        $id                          = I('post.id','','strip_tags');
        if(!empty($_POST['end'])){
            $data['valid_time']          = I('post.end','','strip_tags');
        }
        // dump($data);exit;
        //执行修改
        if($company->where("id=$id")->save($data)){
            $this->success('修改成功',U('Service/company'));
        }else{
            $this->error('修改失败');
        }  
    } 

    //浏览图片
    public function companyfile(){
        //实例化
        $companyfile = M('companyfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $companypic = $companyfile->where("company_id=$id")->select();
        // dump($companypic);exit;
        $this->assign('info',$companypic);
        $this->assign('id',$id);
        $this->display();        
    }

    //添加图片页面
    public function addcompanyfile(){
        //接收值
        $id = I('get.id','','strip_tags');
        // dump($id);exit;
        //加载页面，分配数据
        $this->assign('id',$id);
        $this->display();         
    }

    //执行图片添加
    public function doaddcompanyfile(){
        //实例化
        $companyfile = M('companyfile');
        //接收值
        $id = I('post.company_id','','strip_tags');
        // dump($id);exit;
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
        //添加数据到second_hand_carfile表
        $data['company_id'] = $id;
        $data['add_time'] = date('Y-m-d',time());
        foreach($path as $k=>$v){
            $data['file'] = $v;
            $resultinfo[$k] = $companyfile->add($data);
        }
        // dump(count($path));
        // dump(count($resultinfo));exit;
        if(count($path) == count($resultinfo)){
           //事物成功
            M()->commit();
            $this->success('添加成功',U('Service/companyfile',array("id"=>$id)));
        }else{
            //事物回滚
            M()->rollback();
            $this->error('添加失败');
        }       
    }

    //删除图片
    public function delcompanyfile(){
        //实例化
        $company     = M('company');
        $companyfile = M('companyfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        $fileinfo = $companyfile->where("id=$id")->field('company_id,file')->find();
        $company_id = $fileinfo['company_id'];
        // dump($fileinfo);exit;
        if($companyfile->where("id=$id")->delete()){
            unlink('./Public/Uploads/'.$fileinfo['file']);
            $this->success('删除成功',U('Service/companyfile',array("id"=>$company_id)));
        }else{
            $this->error('修改失败');
        }       
    }

    //加载修改图片页面
    public function editcompanyfile(){
        //实例化
        $companyfile = M('companyfile');
        //接收值
        $id = I('get.id','','strip_tags');
        //查询数据
        $info=$companyfile->where("id=$id")->find();
        // dump($info);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->display();          
    }

    //执行公司工厂图片修改
    public function doeditcompanyfile(){
        //实例化
        $companyfile = M('companyfile');
        //接收值
        $id = I('post.id','','strip_tags');
        //查询数据
        $row = $companyfile->where("id=$id")->find();
        $id1 = $row['company_id'];
        // dump($id);
        // dump($id1);
        // dump($row);exit;
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
        $data['file']=$path;
        // dump($id);
        // dump($data);exit;
        //执行修改
        if($companyfile->where("id=$id")->save($data)){
            unlink('./Public/Uploads/'.$row['file']);//删除图片
            $this->success('修改成功',U('Service/companyfile',array("id"=>$id1)));
        }else{
            $this->error('修改失败');
        }         
    } 

}