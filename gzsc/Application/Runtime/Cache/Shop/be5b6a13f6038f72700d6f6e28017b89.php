<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

  
   <title>后台-服务详情</title>
  
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

                <?php if($_SESSION['info']['user_grade']== 2 || $_SESSION['info']['user_grade']== 4): ?><li class="menu-list"><a href=""><i class="fa fa-th"></i> <span>商铺管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Store/index');?>">商铺基本信息</a></li>
                            <li><a href="<?php echo U('Store/storedata');?>">商铺基本资料</a></li>
                        </ul>
                    </li>

                    <li class="menu-list"><a href=""><i class="fa fa-th-large"></i> <span>商品管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Store/good');?>">所有商品</a></li>
                            <li><a href="<?php echo U('Store/add');?>">添加商品</a></li>
                        </ul>
                    </li>

                    <li class="menu-list"><a href=""><i class="fa fa-cogs"></i></i> <span>活动管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Activity/index');?>">浏览活动</a></li>
                            <li><a href="<?php echo U('Activity/add');?>">添加折扣活动</a></li>
                        </ul>
                    </li>

                    <li class="menu-list"><a href=""><i class="fa fa-th-large"></i> <span>服务管理</span></a>
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
                            <li><a href="<?php echo U('Order/index');?>">浏览订单</a></li>
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
                    </li><?php endif; ?>

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
        <span style="color:#6BC3A2;font-size:20px;line-height:50px;margin-left:450px;">多商城商户后台管理系统</span>
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
                        <span style="font-size:18px;color:black;line-height:50px;text-decoration:none;margin-right:20px;">您好！<?php echo ($_SESSION['info']['user_store_name']); ?></span>
                    </li>
                    <?php else: ?>
                    <li>
                        <img src="/gzsc/Public/Uploads/<?php echo ($_SESSION['info']['user_pic']); ?>" style="width:40px;" />
                        <span style="font-size:18px;color:black;line-height:50px;text-decoration:none;margin-right:20px;">您好！<?php echo ($_SESSION['info']['user_store_name']); ?></span>
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
       <button id="editable-sample_new" class="btn btn-primary"> 后台 &gt;-服务详情 </button> 
      </div>  
     </div> 

  <div class="panel-body"> 
   <div class="form"> 
    <form class="cmxform form-horizontal adminex-form" id="signupForm" method="post" enctype="multipart/form-data" action="<?php echo U('Service/secondhandcardoedit');?>" novalidate="novalidate"> 
    
    
     <div class="form-group "> 
      <label for="state" class="control-label col-lg-2" >图文</label> 
      <div class="col-lg-10"> 
        <?php if(is_array($files)): foreach($files as $key=>$val): ?><img src="/gzsc/Public/Uploads/<?php echo ($val["file"]); ?>" style="height:200px;"><?php endforeach; endif; ?>
      </div> 
     </div> 
     

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">联系人</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["name"]); ?>
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">手机号码</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["tel"]); ?> 
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">截止日期</label> 
      <div class="col-lg-10"> 
        <?php echo ($info["valid_time"]); ?>
      </div> 
     </div> 

<!--================================== 房屋出租 =================================-->

    <?php if($info["cate_id"] == 2): ?><div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">原区域</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["area"]); ?>
      </div> 
     </div> 


    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">户型</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["house_type"]); ?>
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">押金</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["cash"]); ?> 
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">付款方式</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["pay_method"]); ?> 
      </div> 
     </div> 

    <div class="form-group">
        <label class="col-sm-2 control-label">标题描述</label>
        <div class="col-sm-10">
          <?php echo ($info["des"]); ?>
        </div>
    </div>

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">电话隐私保护</label> 
      <div class="col-lg-10"> 
       <?php if($info['state'] == 1 ): ?>保护<?php endif; ?>
       <?php if($info['state'] == 2 ): ?>不保护<?php endif; ?> 
      </div> 
     </div><?php endif; ?> 

<!--================================== 货车出租 =================================-->

    <?php if($info["cate_id"] == 3): ?><div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">品牌</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["brand"]); ?>
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">车牌</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["car_num"]); ?> 
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">出厂年限</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["date_for_production"]); ?> 
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">截止日期</label> 
      <div class="col-lg-10"> 
        <?php echo ($info["valid_time"]); ?>
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">价格</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["price"]); ?>
      </div> 
     </div> 

    <div class="form-group">
        <label class="col-sm-2 control-label">标题描述</label>
        <div class="col-sm-10">
            <?php echo ($info["des"]); ?>
        </div>
    </div><?php endif; ?> 

<!--================================== 招聘信息 =================================-->

    <?php if($info["cate_id"] == 4): ?><div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">公司名称</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["company_name"]); ?>
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">公司简介</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["company_des"]); ?>
      </div> 
     </div> 

    <div class="form-group">
        <label class="col-sm-2 control-label">公司地址</label>
        <div class="col-sm-10">
            <?php echo ($info["address"]); ?>
        </div>
    </div>

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">招聘职位</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["seat"]); ?>
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">职位要求</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["job_req"]); ?>
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">薪酬（/月）</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["payment"]); ?> 
      </div> 
     </div><?php endif; ?> 

<!--================================== 维修服务 =================================-->

    <?php if($info["cate_id"] == 5): ?><div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">详细地址</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["address"]); ?>
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">付款方式</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["pay_method"]); ?>
      </div> 
     </div> 

    <div class="form-group">
        <label class="col-sm-2 control-label">标题描述</label>
        <div class="col-sm-10">
          <?php echo ($info["des"]); ?>
        </div>
    </div><?php endif; ?> 

<!--================================== 家政服务 =================================-->

    <?php if($info["cate_id"] == 6): ?><div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">详细地址</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["address"]); ?>
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">付款方式</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["pay_method"]); ?>
      </div> 
     </div> 

    <div class="form-group">
        <label class="col-sm-2 control-label">标题描述</label>
        <div class="col-sm-10">
          <?php echo ($info["des"]); ?>
        </div>
    </div><?php endif; ?> 

<!--================================== 家具装修 =================================-->

    <?php if($info["cate_id"] == 7): ?><div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">详细地址</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["address"]); ?>
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">付款方式</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["pay_method"]); ?>
      </div> 
     </div> 

    <div class="form-group">
        <label class="col-sm-2 control-label">标题描述</label>
        <div class="col-sm-10">
          <?php echo ($info["des"]); ?>
        </div>
    </div><?php endif; ?> 

<!--================================== 二手车 =================================-->

    <?php if($info["cate_id"] == 8): ?><div class="form-group "> 
      <label for="state" class="control-label col-lg-2" >行驶证照片</label> 
      <div class="col-lg-10"> 
        <img src="/gzsc/Public/Uploads/<?php echo ($info["driving_lience_pic"]); ?>" style="height:200px;">
      </div> 
     </div> 

     <div class="form-group "> 
      <label for="state" class="control-label col-lg-2" >行驶证照片</label> 
      <div class="col-lg-10"> 
        <img src="/gzsc/Public/Uploads/<?php echo ($info["lience_num_pic"]); ?>" style="height:200px;">
      </div> 
     </div> 

     <div class="form-group "> 
      <label for="state" class="control-label col-lg-2" >登记照照片</label> 
      <div class="col-lg-10"> 
        <img src="/gzsc/Public/Uploads/<?php echo ($info["register_pic"]); ?>" style="height:200px;">
      </div> 
     </div> 

     <div class="form-group "> 
      <label for="state" class="control-label col-lg-2" >购买发票照片</label> 
      <div class="col-lg-10"> 
        <img src="/gzsc/Public/Uploads/<?php echo ($info["bill_pic"]); ?>" style="height:200px;">
      </div> 
     </div>    

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">品牌</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["brank"]); ?> 
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">颜色</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["color"]); ?> 
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">首次上牌时间</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["first_time"]); ?>
      </div> 
     </div>  

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">截止日期</label> 
      <div class="col-lg-10"> 
        <?php echo ($info["valid_time"]); ?>
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">价格</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["price"]); ?>
      </div> 
     </div> 

    <div class="form-group">
        <label class="col-sm-2 control-label">标题描述</label>
        <div class="col-sm-10">
          <?php echo ($info["des"]); ?>
        </div>
    </div>

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">原看车区域</label> 
      <div class="col-lg-10"> 
       <?php echo ($info["area"]); ?>
      </div> 
     </div><?php endif; ?> 

<!--================================== 医疗 =================================-->

    <?php if($info["cate_id"] == 9): ?><div class="form-group "> 
        <label for="QQ" class="control-label col-lg-2">详细地址</label> 
        <div class="col-lg-10"> 
         <?php echo ($info["address"]); ?>
        </div> 
       </div> 

      <div class="form-group "> 
        <label for="QQ" class="control-label col-lg-2">付款方式</label> 
        <div class="col-lg-10"> 
         <?php echo ($info["pay_method"]); ?>
        </div> 
       </div> 

      <div class="form-group">
          <label class="col-sm-2 control-label">标题描述</label>
          <div class="col-sm-10">
            <?php echo ($info["des"]); ?>
          </div>
      </div><?php endif; ?> 

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

<!-- <script src="/gzsc/Public/Admin/js/getElement.js"></script>
<script src="/gzsc/Public/Admin/js/location.js"></script> -->

<!--Calendar-->
<!-- <script src="/gzsc/Public/Admin/js/calendar/clndr.js"></script>
<script src="/gzsc/Public/Admin/js/calendar/evnt.calendar.init.js"></script>
<script src="/gzsc/Public/Admin/js/calendar/moment-2.2.1.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore./gzsc/Public/Admin/js/1.5.2/underscore-min.js"></script> -->

<!--common scripts for all pages-->
<script src="/gzsc/Public/Admin/js/scripts.js"></script>

<!--Dashboard Charts-->
<script src="/gzsc/Public/Admin/js/dashboard-chart-init.js"></script>


</body>
</html>