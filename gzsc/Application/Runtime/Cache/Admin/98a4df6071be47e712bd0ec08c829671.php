<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

  
   <title>后台-商铺基本信息</title>
  
  <title>AdminEx</title>

  <!--icheck-->
  <link href="/gzsc/Public/Admin/js/iCheck/skins/minimal/minimal.css" rel="stylesheet">
  <link href="/gzsc/Public/Admin/js/iCheck/skins/square/square.css" rel="stylesheet">
  <link href="/gzsc/Public/Admin/js/iCheck/skins/square/red.css" rel="stylesheet">
  <link href="/gzsc/Public/Admin/js/iCheck/skins/square/blue.css" rel="stylesheet">

  <!--dashboard calendar-->
  <link href="/gzsc/Public/Admin/css/clndr.css" rel="stylesheet">

  <!--Morris Chart CSS -->
  <link rel="stylesheet" href="/gzsc/Public/Admin/js/morris-chart/morris.css">
  <link href="/gzsc/Public/Admin/css/mypage.css" rel="stylesheet" type="text/css"/>

  <!--common-->
  <link href="/gzsc/Public/Admin/css/style.css" rel="stylesheet">
  <link href="/gzsc/Public/Admin/css/style-responsive.css" rel="stylesheet">




  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="/gzsc/Public/Admin/js/html5shiv.js"></script>
  <script src="/gzsc/Public/Admin/js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="sticky-header">

<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side">

        <!--logo and iconic logo start-->
        <div class="logo">
            <a href="index.html"><img src="/gzsc/Public/Admin/images/logo.png" alt=""></a>
        </div>

        <div class="logo-icon text-center">
            <a href="index.html"><img src="/gzsc/Public/Admin/images/logo_icon.png" alt=""></a>
        </div>
        <!--logo and iconic logo end-->

        <div class="left-side-inner">

            <!-- visible to small devices only -->
            <div class="visible-xs hidden-sm hidden-md hidden-lg">
                <div class="media logged-user">
                    <img alt="" src="/gzsc/Public/Admin/images/photos/user-avatar.png" class="media-object">
                    <div class="media-body">
                        <h4><a href="#">John Doe</a></h4>
                        <span>"Hello There..."</span>
                    </div>
                </div>

                <h5 class="left-nav-title">Account Information</h5>
                <ul class="nav nav-pills nav-stacked custom-nav">
                  <li><a href="#"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                  <li><a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
                  <li><a href="#"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
                </ul>
            </div>

            <!--sidebar nav start-->

            <ul class="nav nav-pills nav-stacked custom-nav">
                <li class="active"><a href="index.html"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>

                <?php if($_SESSION['info']['user_grade']== 0 || $_SESSION['info']['user_grade']== 1): ?><li class="menu-list"><a href=""><i class="fa fa-user"></i> <span>人员管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('User/index');?>">浏览商户</a></li>
                            <li><a href="<?php echo U('User/insert');?>">添加商户</a></li>
                            <li><a href="<?php echo U('User/index_user');?>">浏览用户</a></li>
                            <li><a href="<?php echo U('User/insert_user');?>">添加用户</a></li>
                        <?php if($_SESSION['info']['user_grade']== 0 ): ?><li><a href="<?php echo U('User/index_admin');?>">浏览管理员</a></li>   
                            <li><a href="<?php echo U('User/insert_admin');?>">添加管理员</a></li><?php endif; ?>
                            <li><a href="<?php echo U('User/index_self');?>">个人中心</a></li>
                        </ul>
                    </li><?php endif; ?>

                <?php if($_SESSION['info']['user_grade']== 0 || $_SESSION['info']['user_grade']== 1): ?><li class="menu-list"><a href=""><i class="fa fa-cogs"></i></i> <span>商品分类管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Cate/index');?>">浏览商品分类</a></li>
                            <!-- <li><a href="<?php echo U('Cate/add');?>">添加商品分类</a></li> -->
                        </ul>
                    </li>

                    <li class="menu-list"><a href=""><i class="fa fa-th-large"></i> <span>商品管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Store/good');?>">所有商品</a></li>
                        </ul>
                    </li>

                    <li class="menu-list"><a href=""><i class="fa fa-cogs"></i></i> <span>服务管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Service/secondhandcar');?>">二手车</a></li>
                            <li><a href="<?php echo U('Service/houseforrent');?>">房屋出租</a></li>
                            <li><a href="<?php echo U('Service/truckrend');?>">货车出租</a></li>
                            <li><a href="<?php echo U('Service/homedecoration');?>">家居装修</a></li>
                            <li><a href="<?php echo U('Service/housekeeping');?>">家政服务</a></li>
                            <li><a href="<?php echo U('Service/weixiuservice');?>">维修服务</a></li>
                            <li><a href="<?php echo U('Service/medialservice');?>">医疗服务</a></li>
                            <li><a href="<?php echo U('Service/inforservice');?>">招聘信息</a></li>
                        </ul>
                    </li>

                    <li class="menu-list"><a href=""><i class="fa fa-th-large"></i> <span>订单管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Order/index');?>">所有订单</a></li>
                        </ul>
                    </li>                  

                    <li class="menu-list"><a href=""><i class="fa fa-cogs"></i></i> <span>电商广告管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Pics/index');?>">浏览电商广告</a></li>
                            <li><a href="<?php echo U('Pics/add');?>">添加电商广告</a></li>
                        </ul>
                    </li>

                    <li class="menu-list"><a href=""><i class="fa fa-cogs"></i></i> <span>服务广告管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Pics/index');?>">浏览服务广告</a></li>
                            <li><a href="<?php echo U('Pics/add');?>">添加服务广告</a></li>
                        </ul>
                    </li>

                    <li class="menu-list"><a href=""><i class="fa fa-thumbs-o-up"></i> <span>商城公告管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Storenotice/index');?>">浏览商城公告</a></li>
                            <li><a href="<?php echo U('Storenotice/add');?>">添加商城公告</a></li>
                        </ul>
                    </li><?php endif; ?>

<!--                 <?php if($_SESSION['info']['user_grade']== 2): ?><li class="menu-list"><a href=""><i class="fa fa-th"></i> <span>商铺管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Store/index');?>">商铺基本信息</a></li>
                        </ul>
                    </li>
                    <li class="menu-list"><a href=""><i class="fa fa-th-large"></i> <span>商铺商品管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Store/good');?>">商铺所有商品</a></li>
                            <li><a href="<?php echo U('Store/add');?>">添加商铺商品</a></li>
                        </ul>
                    </li>
                    <li class="menu-list"><a href=""><i class="fa fa-th-large"></i> <span>商铺订单管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Service/index');?>">商铺所有服务</a></li>
                            <li><a href="<?php echo U('Service/add');?>">添加商铺服务</a></li>
                        </ul>
                    </li><?php endif; ?> -->

            </ul>

            <!--sidebar nav end-->

        </div>
    </div>
    <!-- left side end-->
    
    <!-- main content start-->
    <div class="main-content">

        <!-- header section start-->
        <div class="header-section">
        <a class="toggle-btn"><i class="fa fa-bars"></i></a>
        <span style="color:#6BC3A2;font-size:20px;line-height:50px;margin-left:450px;">多商城后台管理系统</span>
            <!--toggle button start-->
            <!-- <a class="toggle-btn"><i class="fa fa-bars"></i></a> -->
            <!--toggle button end-->

            <!--search start-->
<!--        <form class="searchform" action="index.html" method="post">
                <input type="text" class="form-control" name="keyword" placeholder="Search here..." />
            </form> -->
            <!--search end-->

            <!--notification menu start -->
            <div class="menu-right">
                <ul class="notification-menu">
                    <?php if($_SESSION['info']['user_pic']== null): ?><li>
                        <span style="font-size:18px;color:black;line-height:50px;text-decoration:none;margin-right:20px;">您好！<?php echo ($_SESSION['info']['user_name']); ?></span>
                    </li>
                    <?php else: ?>
                    <li>
                        <img src="/gzsc/Public/Uploads/<?php echo ($_SESSION['info']['user_pic']); ?>" style="width:40px;" />
                        <span style="font-size:18px;color:black;line-height:50px;text-decoration:none;margin-right:20px;">您好！<?php echo ($_SESSION['info']['user_name']); ?></span>
                    </li><?php endif; ?>
                    <li>
                        <a href="<?php echo U('Login/loginout');?>" style="font-size:18px;color:black;line-height:50px;text-decoration:none;">退出</a>
                    </li>
                </ul>
            </div>
            <!--notification menu end -->

        </div>
        <!-- header section end-->

        <!-- page heading start-->
        <!--后台首页-->
         
   <div class="panel-body"> 
    <div class="adv-table editable-table "> 

     <div class="clearfix"> 
      <div class="btn-group"> 
       <button id="editable-sample_new" class="btn btn-primary"> 后台 &gt; 商铺基本信息 </button> 
      </div> 
<!--       <div class="btn-group pull-right"> 
       <a href="<?php echo U('Store/add');?>"><button id="editable-sample_new" class="btn btn-primary"> Add New <i class="fa fa-plus"></i> </button></a> 
       <ul class="dropdown-menu pull-right"> 
        <li><a href="#">Print</a></li> 
        <li><a href="#">Save as PDF</a></li> 
        <li><a href="#">Export to Excel</a></li> 
       </ul> 
      </div>  -->
     </div> 
     
     <div class="space15"></div> 
     <div id="editable-sample_wrapper" class="dataTables_wrapper form-inline" role="grid">
      
<!--      <div class="panel-body">
        <form class="form-inline" role="form" action="<?php echo U('Pics/index');?>" method="get" />
            
            <div class="form-group">
                <input class="form-control" id="exampleInputEmail2" value="<?php echo ($_GET['pic_http']); ?>" name="pic_http" placeholder="搜索图片链接地址" type="text">
            </div>

            <div class="form-group">状态：
              <select class="form-control m-bot15" name="pic_state" >
                  <option value="">--请选择--</option>
                  <option value="1">正常</option>
                  <option value="2">禁用</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">搜索</button>
        </form>
    </div> -->
<!-- 
      <div class="text-center price-head">
          <h1 class="color-terques"><?php echo ($UserInfo['user_store_name']); ?></h1>
          <p>
            <?php if($UserInfo["user_store_star"] == 5): ?>五星级<?php endif; ?>
            <?php if($UserInfo["user_store_star"] == 4): ?>四星级<?php endif; ?>
            <?php if($UserInfo["user_store_star"] == 3): ?>三星级<?php endif; ?>
            <?php if($UserInfo["user_store_star"] == 2): ?>二星级<?php endif; ?>
            <?php if($UserInfo["user_store_star"] == 1): ?>一星级<?php endif; ?>
          </p>
      </div>

        <div id="fourpic" style="margin:0 auto;text-align:center; ">
        <?php if($_SESSION['info']['user_store_pic']== null): ?>请完善信息！
        <?php else: ?>
          <img src="/gzsc/Public/Uploads/<?php echo ($UserInfo['user_store_pic']); ?>" style="width:200px;" alt="">
          <img src="/gzsc/Public/Uploads/<?php echo ($UserInfo['user_store_pic1']); ?>" style="width:200px;" alt="">
          <img src="/gzsc/Public/Uploads/<?php echo ($UserInfo['user_store_pic2']); ?>" style="width:200px;" alt="">
          <img src="/gzsc/Public/Uploads/<?php echo ($UserInfo['user_store_pic3']); ?>" style="width:200px;" alt="">
          <img src="/gzsc/Public/Uploads/<?php echo ($UserInfo['user_store_pic4']); ?>" style="width:200px;" alt=""><?php endif; ?> 
        </div>
        <div style="margin-left:300px;">
          手机号：<?php echo ($UserInfo['user_phone']); ?>
        </div> -->
     
      <table class="table table-striped table-hover table-bordered dataTable" id="editable-sample" aria-describedby="editable-sample_info"> 
       <thead>
        <tr role="row">
         <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 10%;" aria-label="First Name">主图片</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 10%;" aria-label="Last Name: activate to sort column ascending">图片1</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 10%;" aria-label="Last Name: activate to sort column ascending">图片2</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 10%;" aria-label="Last Name: activate to sort column ascending">图片3</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 10%;" aria-label="Last Name: activate to sort column ascending">图片4</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 10%;" aria-label="Last Name: activate to sort column ascending">商铺名称</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 10%;" aria-label="Last Name: activate to sort column ascending">商铺地址</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 10%;" aria-label="Last Name: activate to sort column ascending">商铺星级</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 10%;" aria-label="Last Name: activate to sort column ascending">电话</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 10%;" aria-label="Last Name: activate to sort column ascending">操作</th>
        </tr> 
       </thead> 
       <tbody role="alert" aria-live="polite" aria-relevant="all"> 
        <tr class="odd"> 
        <?php if(empty($UserInfo['user_store_pic']) == true): ?><td class=" ">请点击修改完善信息</td> 
          <td class=" ">请点击修改完善信息</td> 
          <td class=" ">请点击修改完善信息</td> 
          <td class=" ">请点击修改完善信息</td> 
          <td class=" ">请点击修改完善信息</td> 
        <?php else: ?>
          <td class=" "><img src="/gzsc/Public/Uploads/<?php echo ($UserInfo['user_store_pic']); ?>" style="width:100px;"></td> 
          <td class=" "><img src="/gzsc/Public/Uploads/<?php echo ($UserInfo['user_store_pic1']); ?>" style="width:100px;"></td> 
          <td class=" "><img src="/gzsc/Public/Uploads/<?php echo ($UserInfo['user_store_pic2']); ?>" style="width:100px;"></td> 
          <td class=" "><img src="/gzsc/Public/Uploads/<?php echo ($UserInfo['user_store_pic3']); ?>" style="width:100px;"></td> 
          <td class=" "><img src="/gzsc/Public/Uploads/<?php echo ($UserInfo['user_store_pic4']); ?>" style="width:100px;"></td><?php endif; ?>

         <td class=" "><?php echo ($UserInfo['user_store_name']); ?></td> 
          <?php if(empty($UserInfo['user_store_address']) == true): ?><td class=" ">请点击修改完善信息</td> 
          <?php else: ?>
            <td class=" "><?php echo ($UserInfo['user_store_address']); ?></td><?php endif; ?>
         <td class=" ">
          <?php if($UserInfo["user_store_star"] == 5): ?>五星级<?php endif; ?>
          <?php if($UserInfo["user_store_star"] == 4): ?>四星级<?php endif; ?>
          <?php if($UserInfo["user_store_star"] == 3): ?>三星级<?php endif; ?>
          <?php if($UserInfo["user_store_star"] == 2): ?>二星级<?php endif; ?>
          <?php if($UserInfo["user_store_star"] == 1): ?>一星级<?php endif; ?>
         </td> 
         <td class=" "><?php echo ($UserInfo['user_phone']); ?></td> 
         <td class=" "><a href="/gzsc/index.php/Admin/Store/edit/id/<?php echo ($UserInfo["id"]); ?>">修改</a></td> 
         </td> 
        </tr> 
       </tbody>
      </table>
     </div> 
    </div> 
   </div> 
  
        <!--body wrapper end-->

        <!--footer section start-->
        <footer>
            武林科技  红尘
        </footer>
        <!--footer section end-->


    </div>
    <!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="/gzsc/Public/Admin/js/jquery-1.10.2.min.js"></script>
<script src="/gzsc/Public/Admin/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="/gzsc/Public/Admin/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/gzsc/Public/Admin/js/bootstrap.min.js"></script>
<script src="/gzsc/Public/Admin/js/modernizr.min.js"></script>
<script src="/gzsc/Public/Admin/js/jquery.nicescroll.js"></script>

<!--easy pie chart-->
<script src="/gzsc/Public/Admin/js/easypiechart/jquery.easypiechart.js"></script>
<script src="/gzsc/Public/Admin/js/easypiechart/easypiechart-init.js"></script>

<!--Sparkline Chart-->
<script src="/gzsc/Public/Admin/js/sparkline/jquery.sparkline.js"></script>
<script src="/gzsc/Public/Admin/js/sparkline/sparkline-init.js"></script>

<!--icheck -->
<script src="/gzsc/Public/Admin/js/iCheck/jquery.icheck.js"></script>
<script src="/gzsc/Public/Admin/js/icheck-init.js"></script>

<!-- jQuery Flot Chart-->
<script src="/gzsc/Public/Admin/js/flot-chart/jquery.flot.js"></script>
<script src="/gzsc/Public/Admin/js/flot-chart/jquery.flot.tooltip.js"></script>
<script src="/gzsc/Public/Admin/js/flot-chart/jquery.flot.resize.js"></script>


<!--Morris Chart-->
<script src="/gzsc/Public/Admin/js/morris-chart/morris.js"></script>
<script src="/gzsc/Public/Admin/js/morris-chart/raphael-min.js"></script>


 <!-- <script src="/gzsc/Public/Admin/js/jquery-2.1.4.min.js"></script> -->



<!--Calendar-->
<!-- <script src="/gzsc/Public/Admin/js/calendar/clndr.js"></script>
<script src="/gzsc/Public/Admin/js/calendar/evnt.calendar.init.js"></script>
<script src="/gzsc/Public/Admin/js/calendar/moment-2.2.1.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore./gzsc/Public/Admin/js/1.5.2/underscore-min.js"></script> -->

<!--common scripts for all pages-->
<script src="/gzsc/Public/Admin/js/scripts.js"></script>

<!--Dashboard Charts-->
<script src="/gzsc/Public/Admin/js/dashboard-chart-init.js"></script>

<script type="text/javascript">
  $("#btn11").click(function(){
    var page=$("#page").attr("value");
    $("#link").attr('href','http://localhost/pcdd300/Home/Text/memberprofit/p/'+page+'.html');
  })
</script>

<script type="text/javascript">
  !function(){
    laydate.skin('molv');//切换皮肤，请查看skins下面皮肤库
    laydate({elem: '#demo'});//绑定元素
  }();

  //日期范围限制
  var start = {
      elem: '#start',
      format: 'YYYY-MM-DD',
      min: laydate.now(), //设定最小日期为当前日期
      max: '2099-06-16', //最大日期
      istime: true,
      istoday: false,
      choose: function(datas){
           end.min = datas; //开始日选好后，重置结束日的最小日期
           end.start = datas //将结束日的初始值设定为开始日
      }
  };

  var end = {
      elem: '#end',
      format: 'YYYY-MM-DD',
      min: laydate.now(),
      max: '2099-06-16',
      istime: true,
      istoday: false,
      choose: function(datas){
          start.max = datas; //结束日选好后，充值开始日的最大日期
      }
  };
  laydate(start);
  laydate(end);

  //自定义日期格式
  laydate({
      elem: '#test1',
      format: 'YYYY年MM月DD日',
      festival: true, //显示节日
      choose: function(datas){ //选择日期完毕的回调
          alert('得到：'+datas);
      }
  });

  //日期范围限定在昨天到明天
  laydate({
      elem: '#hello3',
      min: laydate.now(-1), //-1代表昨天，-2代表前天，以此类推
      max: laydate.now(+1) //+1代表明天，+2代表后天，以此类推
  });
</script>


</body>
</html>