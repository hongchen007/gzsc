<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

  
   <title>后台-修改商户</title>
  
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

                    <li class="menu-list"><a href=""><i class="fa fa-cogs"></i></i> <span>商品广告管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Pics/index');?>">浏览商品广告</a></li>
                            <li><a href="<?php echo U('Pics/add');?>">添加商品广告</a></li>
                        </ul>
                    </li>

                    <li class="menu-list"><a href=""><i class="fa fa-cogs"></i></i> <span>服务广告管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Adsserve/index');?>">浏览服务广告</a></li>
                            <li><a href="<?php echo U('Adsserve/add');?>">添加服务广告</a></li>
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
         

     <div class="clearfix" style="margin-left:10px;"> 
      <div class="btn-group"> 
       <button id="editable-sample_new" class="btn btn-primary"> 后台 &gt; 修改商户 </button> 
      </div>  
     </div> 

  <div class="panel-body"> 
   <div class="form"> 
    <form class="cmxform form-horizontal adminex-form" id="signupForm" method="post" enctype="multipart/form-data" action="<?php echo U('User/update');?>" novalidate="novalidate"> 

     <div class="form-group "> 
      <label for="loginname" class="control-label col-lg-2">修改用户名</label> 
      <div class="col-lg-10"> 
       <input class=" form-control" id="user_name" name="user_name" type="text" value="<?php echo ($info["user_name"]); ?>" /> 
       <input class=" form-control" id="id" name="id" type="hidden" value="<?php echo ($info["id"]); ?>" /> 
      </div> 
     </div> 

     <div class="form-group "> 
      <label for="loginname" class="control-label col-lg-2">修改商户名</label> 
      <div class="col-lg-10"> 
       <input class=" form-control" id="user_store_name" name="user_store_name" type="text" value="<?php echo ($info["user_store_name"]); ?>" /> 
      </div> 
     </div> 

     <div class="form-group "> 
      <label for="phone" class="control-label col-lg-2">修改身份证号</label> 
      <div class="col-lg-10"> 
       <input class=" form-control" id="user_id" name="user_id" type="text" value="<?php echo ($info["user_id"]); ?>" /> 
      </div> 
     </div> 

     <div class="form-group "> 
      <label for="phone" class="control-label col-lg-2">修改商户地址</label> 
      <div class="col-lg-10"> 
       <input class=" form-control" id="user_store_address" name="user_store_address" type="text" value="<?php echo ($info["user_store_address"]); ?>" /> 
      </div> 
     </div> 

<!--      <div class="form-group "> 
      <label for="state" class="control-label col-lg-2" >商户原图片</label> 
      <div class="col-lg-10"> 
        <img src="/gzsc/Public/Uploads/<?php echo ($info["user_store_pic"]); ?>">
      </div> 
     </div> 

     <div class="form-group "> 
      <label for="state" class="control-label col-lg-2">修改商户图片</label> 
      <div class="col-lg-10">
       <input id="user_store_pic" name="user_store_pic" type="file" onChange="document.getElementsByName('xgpic')[0].value=this.value" /> 
       <input type="hidden" name="xgpic">
       <input type="hidden" name="id" value="<?php echo ($info['id']); ?>">
      </div> 
     </div>  -->

     <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">修改商户营业执照号</label> 
      <div class="col-lg-10"> 
       <input class="form-control " id="user_store_lience" name="user_store_lience" type="text" value="<?php echo ($info["user_store_lience"]); ?>" /> 
      </div> 
     </div> 

     <div class="form-group "> 
      <label for="email" class="control-label col-lg-2">修改商户注册资金</label> 
      <div class="col-lg-10"> 
       <input class="form-control " id="user_store_registered" name="user_store_registered" type="text" value="<?php echo ($info["user_store_registered"]); ?>" /> 
      </div> 
     </div> 

     <div class="form-group "> 
      <label for="email" class="control-label col-lg-2">修改商户保证金</label> 
      <div class="col-lg-10"> 
       <input class="form-control " id="user_store_cash" name="user_store_cash" type="text" value="<?php echo ($info["user_store_cash"]); ?>" /> 
      </div> 
     </div> 

     <div class="form-group "> 
      <label for="email" class="control-label col-lg-2">修改抽成百分比</label> 
      <div class="col-lg-10"> 
       <input class="form-control " id="user_store_percent" name="user_store_percent" type="text" value="<?php echo ($info["user_store_percent"]); ?>" /> 
       <span style="color:red;">几就代表百分之几，请填两位的整数 eg：10就代表抽成百分之10,所以不能超过100</span>
      </div> 
     </div> 

     <div class="form-group"> 
      <div class="col-lg-offset-2 col-lg-10"> 
        <input class="btn btn-primary" type="submit" value="修改">
        <input class="btn btn-primary" type="reset" value="重置">
      </div> 
     </div> 
    </form> 
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