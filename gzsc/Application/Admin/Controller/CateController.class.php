<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class CateController extends AllowController {

    public function index(){
        //获取搜索的条件
        // $where=array();
        // if(!empty($_GET['cate_name'])){
        //     $where['cate_name']=array('like',"%{$_GET['cate_name']}%");
        //     // dump($where);exit;
        // }
    	//实例化model类
        $mod=M('cate');
        //获取用户表数据
        $list=$mod->query('select *,concat(cate_path,",",id) as paths from cate order by paths');
        // dump($list);exit;
       // $list=$mod->field(array('*','concat(cate_path,id)'=>'paths',))->order('paths')->select();
        foreach($list as $key=>$value){
            //获取path列
            $z=$value['cate_path'];
            // var_dump($z);exit;
            //转换为数组
            $arr=explode(',',$z);
            //获取数组长度
            $len=count($arr);
            //获取逗号个数
            $gs=$len-1;
            //拼接分隔符  重复字符串
            $list[$key]['cate_name']=str_repeat('——|',$gs).$value['cate_name'];
        }
        //总长
        $Total = count($list);
        //导入分页类
        $Page = new Page($Total,10);
        //分页设置
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','末页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $list=array_slice($list,$Page->firstRow,$Page->listRows);

        $Page = $Page->show();
        $this->assign('Page',$Page);
        $this->assign('list',$list);
        //加载模板
        $this->display();
    }

    //封装分类查询方法
    public function cate(){
        //实例化Model类
        $cate = M('cate');
        $list=$cate->query('select *,concat(cate_path,",",id) as paths from cate order by paths');
        foreach($list as $key=>$value){
            //获取path列
            $z=$value['cate_path'];
            // var_dump($z);exit;
            //转换为数组
            $arr=explode(',',$z);
            //获取数组长度
            $len=count($arr);
            //获取逗号个数
            $gs=$len-1;
            //拼接分隔符  重复字符串
            $list[$key]['cate_name']=str_repeat('——|',$gs).$value['cate_name'];
            
        }
        return $list;
    }

    //加载添加会员模板
    public function add(){
        $list=$this->cate();
        // dump($list);exit;
        //分配变量
        $this->assign('list',$list);
        //加载模板
        $this->display('Cate/add');
    }

    //执行添加
    public function insert(){
        //实例化Model类
        $mod = M('cate');
        $rules  = array(
          array('cate_name','require','商品类别名不能为空！'),   
          array('cate_pid','require','请选择父类！'),   
          array('cate_name','','分类名已经存在！',0,'unique',1), 
        );
        if (!$mod->validate($rules)->create()){     
            // 如果创建失败 表示验证没有通过 输出错误提示信息     
            $this->error($mod->getError());
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
        // var_dump($_POST);exit;
        $data['cate_pid']=$_POST['cate_pid'];
        $data['cate_name']=$_POST['cate_name'];
        $data['cate_pic']=$path;
        //判断添加的类别是否是顶级分类
        // if($data['cate_pid']==0){
        //     $data['cate_path']='0';
        // }else{
        //     //获取父类的信息
        //     $info=$mod->find($data['cate_pid']);
        //     $data['cate_path']=$info['cate_path'].','.$info['id'];
        // }
        $info=$mod->find($data['cate_pid']);
        $data['cate_path']=$info['cate_path'].','.$info['id'];
        // dump($data);exit;
        //执行添加操作
        if($mod->add($data)){ 
            $this->success('添加成功',U('Cate/index'));
        }else{
            $this->error('添加失败');
        }
    }

    //执行删除
    public function del(){
        //实例化Model类
        $mod       = M('cate');
        $good      = M('good');
        $good_attr = M('good_attr');
        $file      = M('file');
        $id = I('get.id','','strip_tags');
        
        $info=$mod->where("id = $id")->select();
        dump($info);exit;
        //判断是否为一级分类
        if($info['cate_pid'] == 0){
            $this->error('不能删除一级分类');
        }
        //查询是否有子类
        if($info){
          $this->error('请先删除子类');
        };

        //删除该分类所有的商品  属性信息  和文件
        $goodinfo = $good->where("cate_id=$id")->field('id')->select();
        foreach($goodinfo as $k=>$v){
            $where['good_id'] = $v['id'];
            $good_attrinfo[$k] = $good_attr->where($where)->delete();
            $fileinfo[$k]          = $file->where($where)->delete();
            $goodinfo[$k]          = $good->where("cate_id=$id")->delete();
        }

        if($mod->delete($id)){
            $this->success('删除成功',U('Cate/index'));
        }else{
            $this->error('删除失败');
        }

    }

    //加载修改页面
    public function edit(){
        $mod=M('cate');
        $id=I('get.id','','strip_tags');
        $info=$mod->find($id);//查询需要修改的信息
        //分配数据
        $this->assign('info',$info);
        //加载模板
        $this->display();
    }


    //执行修改
    public function update(){
        // var_dump($_POST);exit;
        //实例化Model类
        $cate = M('cate');
        // $rules=array(
        //     array('cate_name','require','分类名不能为空'),
        //     );
        // if (!$cate->validate($rules)->create()){     
        //     // 如果创建失败 表示验证没有通过 输出错误提示信息     
        //     $this->error($cate->getError());
        // }
        // $data['cate_name']=I('post.cate_name','','strip_tags');
        $id=I('post.id','','strip_tags');
        $pic=I('post.xgpic','','strip_tags');
        // dump($data);exit;
        //判断是否修改商品图片
        if($pic == null){
            //执行修改
            if($cate->where("id=$id")->save($data)){
                //跳转
                $this->success('修改成功',U('Cate/index'));
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
            $data['cate_pic']=$path;
            // dump($data);exit;
            //执行修改
            $row=$cate->find($id);//获取修改的数据
            if($cate->where("id=$id")->save($data)){
                unlink('./Public/Uploads/'.$row['cate_pic']);//删除图片
                $this->success('修改成功',U('Cate/index'));
            }else{
                $this->error('修改失败');
            } 
        }
    }  
}