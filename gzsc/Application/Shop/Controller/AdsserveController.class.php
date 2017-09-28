<?php
namespace Shop\Controller;
use Think\Controller;
class AdsserveController extends AllowController{

    //加载添加页面
    public function add(){
        //实例化
        $cate = M('cate');
        //查找所有的服务
        $id = 1;
        $cateinfo = $cate->where("cate_pid=$id")->field('cate_name,id')->select();
        // dump($cateinfo);exit;
        //加载模板
        $this->assign('info',$cateinfo);
        $this->display();
    }

    //执行添加
    public function insert(){
        // 实例化表
        $adsserve            = M('adsserve');
        $second_hand_car     = M('second_hand_car');
        $second_hand_carfile = M('second_hand_carfile');
        $house_for_rent      = M('house_for_rent');
        $house_for_rentfile  = M('house_for_rentfile');
        $truck_rend          = M('truck_rend');
        $truck_rendfile      = M('truck_rendfile');
        $home_decoration     = M('home_decoration');
        $home_decorationfile = M('home_decorationfile');
        $housekeeping        = M('housekeeping');
        $housekeepingfile    = M('housekeepingfile');
        $weixiu_service      = M('weixiu_service');
        $weixiu_servicefile  = M('weixiu_servicefile');
        $medial_service      = M('medial_service');
        $medial_servicefile  = M('medial_servicefile');
        $information         = M('information');
        $informationfile     = M('informationfile');
        //添加数据规则
        $rules=array(
            array('adsserve_descr','require','图片描述不能为空'),
            array('adsserve_pic1','require','服务类型不能为空'),
            array('adsserve_http','require','链接ID不能为空'),
            array('adsserve_http','/^[0-9]*$/','链接ID必须为数字!'), 
            array('adsserve_http','','链接ID已经存在！',0,'unique',1), 
            );
        if (!$adsserve->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($adsserve->getError());
        }

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
        //判断服务类型
        $where['id'] = $id = I('post.adsserve_http','','strip_tags');
        $where['user_id']  = $_SESSION['info']['id'];
        $adsserve_pic1 = I('post.adsserve_pic1','','strip_tags');
        if($adsserve_pic1 == 2){
            $adsinfo = $house_for_rent->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 2;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/houseforrentinfo?id=".$id;
            }
        }elseif($adsserve_pic1 == 3){
            $adsinfo = $truck_rend->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 3;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/truckrendinfo?id=".$id;
            }
        }elseif($adsserve_pic1 == 4){
            $adsinfo = $information->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 4;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/inforserviceinfo?id=".$id;
            }
        }elseif($adsserve_pic1 == 5){
            $adsinfo = $weixiu_service->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 5;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/weixiuserviceinfo?id=".$id;
            }
        }elseif($adsserve_pic1 == 6){
            $adsinfo = $housekeeping->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 6;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/homedecorationinfo?id=".$id;
            }
        }elseif($adsserve_pic1 == 7){
            $adsinfo = $home_decoration->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 7;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/homedecorationinfo?id=".$id;
            }
        }elseif($adsserve_pic1 == 8 ){
            $adsinfo = $second_hand_car->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 8;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/secondhandcar?id=".$id;
            }
        }else{
            $adsinfo = $medial_service->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 9;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/medialserviceinfo?id=".$id;
            }
        }
        $data['adsserve_pic']     = $path;
        $data['adsserve_address'] = I('post.adsserve_address','','strip_tags');
        $data['adsserve_descr']   = I('post.adsserve_descr','','strip_tags');
        $data['adsserve_state']   = 3;
        $data['add_time']         = date('Y-m-d H:i:s');
        $data['end_time']         = date('Y-m-d H:i:s',time()+604800);
        // dump($data);exit;
        if($adsserve->add($data)){ 
            $this->success('添加成功',U('Adsserve/index'));
        }else{
            $this->error('添加失败');
        }
    }

    //加载显示页面
    public function index(){
        //实例化
        $adsserve = M('adsserve');
        $user     = M('user');
        $cate     = M('cate');
        //搜索条件
        $where1=array();
        if(!empty($_GET['adsserve_address'])){
            $where1['adsserve_address'] = $_GET['adsserve_address'];
        }
        if(!empty($_GET['adsserve_state'])){
            $where1['adsserve_state'] = $_GET['adsserve_state'];
        }
        if(!empty($_GET['cate'])){
            $where1['cate_id'] = $_GET['cate'];
        }
        $where1['user_id'] = $_SESSION['info']['id'];
        // dump($where1);exit;
        //查询数据
        $UserInfo = $adsserve->where($where1)->select();
        foreach($UserInfo as $k=>$v){
            $id = $v['user_id'];
            $userinfo1 = $user->where("id=$id")->field('user_grade,user_name,user_store_name')->find();
            // 3 禁用的商户   4未激活商户  6禁用的用户
            if($userinfo1['user_grade'] == 3 || $userinfo1['user_grade'] == 4 || $userinfo1['user_grade'] == 6){
                unset($UserInfo[$k]);
            }
        }
        //是否失效
        foreach($UserInfo as $k=>$v){
            if(strtotime($v['end_time']) > time()){
                $UserInfo[$k]['adsserve_status'] = "1";
            }else{
                $UserInfo[$k]['adsserve_status'] = "2";
            }
        }
        //查询是否失效
        if(!empty($_GET['adsserve_status'])){ 
            foreach($UserInfo as $k=>$v){
                if($_GET['adsserve_status'] == 1){
                    if($v['adsserve_status'] == 2){
                        unset($UserInfo[$k]);
                    }
                }else{
                    if($v['adsserve_status'] == 1){
                        unset($UserInfo[$k]);
                    }
                }
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
        //所属分类
        foreach($UserInfo as $k=>$v){
            $id = $v['cate_id'];
            $cateinfo = $cate->where("id=$id")->field('cate_name')->find();
            $UserInfo[$k]['cate_name'] = $cateinfo['cate_name'];
        }        
        // dump($UserInfo);exit;
        //总长
        $Total = count($UserInfo);
        //导入分页类
        $Page = getpage($Total,10);
        $UserInfo=array_slice($UserInfo,$Page->firstRow,$Page->listRows);

        $Page = $Page->show();
        //分类信息
        $cate_id = 1;
        $cateinfo = $cate->where("cate_pid=$cate_id")->field('cate_name,id')->select();
        // dump($cateinfo);exit;
        //加载模板,分配变量
        $this->assign('UserInfo',$UserInfo);
        $this->assign('info',$cateinfo);
        $this->assign('Page',$Page);
        $this->display();
    }

    //加载详情页
    public function detail(){
        //实例化
        $adsserve            = M('adsserve');
        // $cate                = M('cate');
        $second_hand_car     = M('second_hand_car');
        $second_hand_carfile = M('second_hand_carfile');
        $house_for_rent      = M('house_for_rent');
        $house_for_rentfile  = M('house_for_rentfile');
        $truck_rend          = M('truck_rend');
        $truck_rendfile      = M('truck_rendfile');
        $home_decoration     = M('home_decoration');
        $home_decorationfile = M('home_decorationfile');
        $housekeeping        = M('housekeeping');
        $housekeepingfile    = M('housekeepingfile');
        $weixiu_service      = M('weixiu_service');
        $weixiu_servicefile  = M('weixiu_servicefile');
        $medial_service      = M('medial_service');
        $medial_servicefile  = M('medial_servicefile');
        $information         = M('information');
        $informationfile     = M('informationfile');
        //接收数据
        $id = I('get.id','','strip_tags');
        //查询服务表
        $adsserveinfo = $adsserve->where("id=$id")->find();
        $aa = explode('=',$adsserveinfo['adsserve_http']);
        $where1['id'] = $aa[1];
        if($adsserveinfo['cate_id'] == 2){
            $info = $house_for_rent->where($where1)->find();
            $where2['house_for_rend_id'] = $info['id'];
            $files = $house_for_rentfile->where($where2)->field('file')->select();        
            $info['cate_id'] = 2;           
        }elseif($adsserveinfo['cate_id'] == 3){
            $info = $truck_rend->where($where1)->find();
            $where2['truck_rend_id'] = $info['id'];
            $files = $truck_rendfile->where($where2)->field('file')->select();        
            $info['cate_id'] = 3;            
        }elseif($adsserveinfo['cate_id'] == 4){
            $info = $information->where($where1)->find();
            $where2['information_id'] = $info['id'];
            $files = $informationfile->where($where2)->field('file')->select();          
            $info['cate_id'] = 4;          
        }elseif($adsserveinfo['cate_id'] == 5){
            $info = $weixiu_service->where($where1)->find();
            $where2['weixiu_service_id'] = $info['id'];
            $files = $weixiu_servicefile->where($where2)->field('file')->select();         
            $info['cate_id'] = 5; 
        }elseif($adsserveinfo['cate_id'] == 6){
            $info = $housekeeping->where($where1)->find();
            $where2['housekeeping_id'] = $info['id'];
            $files = $housekeepingfile->where($where2)->field('file')->select();           
            $info['cate_id'] = 6;            
        }elseif($adsserveinfo['cate_id'] == 7){
            $info = $home_decoration->where($where1)->find();
            $where2['home_decoration_id'] = $info['id'];
            $files = $home_decorationfile->where($where2)->field('file')->select();         
            $info['cate_id'] = 7;           
        }elseif($adsserveinfo['cate_id'] == 8){
            $info = $second_hand_car->where($where1)->find();
            $where2['second_hand_card_id'] = $info['id'];
            $files = $second_hand_carfile->where($where2)->field('file')->select();        
            $info['cate_id'] = 8;         
        }else{
            $info = $medial_service->where($where1)->find();
            $where2['medial_service_id'] = $info['id'];
            $files = $medial_servicefile->where($where2)->field('file')->select();        
            $info['cate_id'] = 9;         
        }
        // dump($files);
        // dump($info);exit;
       //加载页面，分配数据
        $this->assign('info',$info);
        $this->assign('files',$files);
        $this->display();

    }

    //删除
    public function del(){
        //实例化
        $adsserve = M('adsserve');
        //接收值
        $id = $_GET['id'];
        //删除数据库数据
        $row  = $adsserve->where("id=$id")->find();
        $info = $adsserve->where("id=$id")->delete();
        //返回
        if($info){
            $this->success('删除成功', U('Adsserve/index'));
            unlink('./Public/Uploads/'.$row['adsserve_pic']);//删除图片
        } else {
            $this->error('删除失败');
        }
    }

    //加载修改页面
    public function edit(){
        //实例化
        $adsserve = M('adsserve');
        $cate = M('cate');
        //查找所有的服务
        $id = 1;
        $cateinfo = $cate->where("cate_pid=$id")->field('cate_name,id')->select();
        // dump($cateinfo);exit;  
        //接收值
        $id = $_GET['id'];
        //查询数据
        $info=$adsserve->where("id=$id")->find();
        $adsserve_http = $info['adsserve_http'];
        $aa = explode('=',$adsserve_http);
        $info['adsserve_http'] = $aa[1];
        // dump($info);
        // dump($cateinfo);exit;
        //加载页面，分配数据
        $this->assign('info',$info);
        $this->assign('cateinfo',$cateinfo);
        $this->display();
    }

    //执行修改
    public function update(){
        // 实例化表
        $adsserve            = M('adsserve');
        $second_hand_car     = M('second_hand_car');
        $second_hand_carfile = M('second_hand_carfile');
        $house_for_rent      = M('house_for_rent');
        $house_for_rentfile  = M('house_for_rentfile');
        $truck_rend          = M('truck_rend');
        $truck_rendfile      = M('truck_rendfile');
        $home_decoration     = M('home_decoration');
        $home_decorationfile = M('home_decorationfile');
        $housekeeping        = M('housekeeping');
        $housekeepingfile    = M('housekeepingfile');
        $weixiu_service      = M('weixiu_service');
        $weixiu_servicefile  = M('weixiu_servicefile');
        $medial_service      = M('medial_service');
        $medial_servicefile  = M('medial_servicefile');
        $information         = M('information');
        $informationfile     = M('informationfile');
        //添加数据规则
        $rules=array(
            array('adsserve_descr','require','图片描述不能为空'),
            array('adsserve_pic1','require','服务类型不能为空'),
            array('adsserve_http','require','链接ID不能为空'),
            array('adsserve_http','/^[0-9]*$/','链接ID必须为数字!'), 
            array('adsserve_http','','链接ID已经存在！',0,'unique',1), 
            );
        if (!$adsserve->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($adsserve->getError());
        }

        //判断服务类型
        $where['id'] = $id = I('post.adsserve_http','','strip_tags');
        $adsserve_pic1 = I('post.adsserve_pic1','','strip_tags');
        if($adsserve_pic1 == 2){
            $adsinfo = $house_for_rent->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 2;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/houseforrentinfo?id=".$id;
            }
        }elseif($adsserve_pic1 == 3){
            $adsinfo = $truck_rend->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 3;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/truckrendinfo?id=".$id;
            }
        }elseif($adsserve_pic1 == 4){
            $adsinfo = $information->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 4;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/inforserviceinfo?id=".$id;
            }
        }elseif($adsserve_pic1 == 5){
            $adsinfo = $weixiu_service->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 5;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/weixiuserviceinfo?id=".$id;
            }
        }elseif($adsserve_pic1 == 6){
            $adsinfo = $housekeeping->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 6;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/homedecorationinfo?id=".$id;
            }
        }elseif($adsserve_pic1 == 7){
            $adsinfo = $home_decoration->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 7;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/homedecorationinfo?id=".$id;
            }
        }elseif($adsserve_pic1 == 8 ){
            $adsinfo = $second_hand_car->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 8;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/secondhandcar?id=".$id;
            }
        }else{
            $adsinfo = $medial_service->where($where)->field('user_id')->find();
            if(empty($adsinfo)){
                $this->error('该服务不存在！');
            }else{
                $data['user_id'] = $adsinfo['user_id'];
                $data['cate_id'] = 9;
                $data['adsserve_http'] = "/gzsc/index.php/Home/Servedetail/medialserviceinfo?id=".$id;
            }
        }
        $data['adsserve_address'] = I('post.adsserve_address','','strip_tags');
        $data['adsserve_descr']   = I('post.adsserve_descr','','strip_tags');
        $data['adsserve_state']   = 1;
        $data['add_time']         = date('Y-m-d H:i:s');
        $data['end_time']         = date('Y-m-d H:i:s',time()+604800);
        $pic                      = I('post.xgpic','','strip_tags');
        $id                       = I('post.id','','strip_tags');
        // dump($pic);
        // dump($id);
        // dump($data);exit;
        //判断是否修改商品图片
        if($pic == null){
            //执行修改
            if($adsserve->where("id=$id")->save($data)){
                //跳转
                $this->success('修改成功',U('Adsserve/index'));
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
            $data['adsserve_pic']=$path;
            // var_dump($data);exit;
            //执行修改
            $row=$adsserve->find($id);//获取修改的数据
            if($adsserve->where("id=$id")->save($data)){
                unlink('./Public/Uploads/'.$row['adsserve_pic']);//删除图片
                $this->success('修改成功',U('Adsserve/index'));
            }else{
                $this->error('修改失败');
            } 
        }
    }
}