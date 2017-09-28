<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

  
   <title>后台-修改商品属性</title>
  
  <title>AdminEx</title>

  <!--icheck-->
  <link href="/guangzhoushangcheng/Public/Admin/js/iCheck/skins/minimal/minimal.css" rel="stylesheet">
  <link href="/guangzhoushangcheng/Public/Admin/js/iCheck/skins/square/square.css" rel="stylesheet">
  <link href="/guangzhoushangcheng/Public/Admin/js/iCheck/skins/square/red.css" rel="stylesheet">
  <link href="/guangzhoushangcheng/Public/Admin/js/iCheck/skins/square/blue.css" rel="stylesheet">

  <!--dashboard calendar-->
  <link href="/guangzhoushangcheng/Public/Admin/css/clndr.css" rel="stylesheet">

  <!--Morris Chart CSS -->
  <link rel="stylesheet" href="/guangzhoushangcheng/Public/Admin/js/morris-chart/morris.css">
  <link href="/guangzhoushangcheng/Public/Admin/css/mypage.css" rel="stylesheet" type="text/css"/>

  <!--common-->
  <link href="/guangzhoushangcheng/Public/Admin/css/style.css" rel="stylesheet">
  <link href="/guangzhoushangcheng/Public/Admin/css/style-responsive.css" rel="stylesheet">




  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="/guangzhoushangcheng/Public/Admin/js/html5shiv.js"></script>
  <script src="/guangzhoushangcheng/Public/Admin/js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="sticky-header">

<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side">

        <!--logo and iconic logo start-->
        <div class="logo">
            <a href="index.html"><img src="/guangzhoushangcheng/Public/Admin/images/logo.png" alt=""></a>
        </div>

        <div class="logo-icon text-center">
            <a href="index.html"><img src="/guangzhoushangcheng/Public/Admin/images/logo_icon.png" alt=""></a>
        </div>
        <!--logo and iconic logo end-->

        <div class="left-side-inner">

            <!-- visible to small devices only -->
            <div class="visible-xs hidden-sm hidden-md hidden-lg">
                <div class="media logged-user">
                    <img alt="" src="/guangzhoushangcheng/Public/Admin/images/photos/user-avatar.png" class="media-object">
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

                <?php if($_SESSION['info']['user_grade']== 0 || $_SESSION['info']['user_grade']== 1): ?><li class="menu-list"><a href=""><i class="fa fa-cogs"></i></i> <span>轮播图管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Pics/index');?>">浏览轮播图</a></li>
                            <li><a href="<?php echo U('Pics/add');?>">添加轮播图</a></li>
                        </ul>
                    </li>
                    
                    <li class="menu-list"><a href=""><i class="fa fa-thumbs-o-up"></i> <span>商城公告管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Storenotice/index');?>">浏览商城公告</a></li>
                            <li><a href="<?php echo U('Storenotice/add');?>">添加商城公告</a></li>
                        </ul>
                    </li><?php endif; ?>

                <?php if($_SESSION['info']['user_grade']== 2): ?><li class="menu-list"><a href=""><i class="fa fa-thumbs-o-up"></i> <span>商铺管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Store/index');?>">商铺基本信息</a></li>
                            <li><a href="<?php echo U('Store/good');?>">商铺所有商品</a></li>
                            <li><a href="<?php echo U('Store/add');?>">添加商铺商品</a></li>
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
                        <img src="/guangzhoushangcheng/Public/Uploads/<?php echo ($_SESSION['info']['user_pic']); ?>" style="width:40px;" />
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
       <button id="editable-sample_new" class="btn btn-primary"> 后台 &gt; 修改<?php echo ($good_name['good_name']); ?>商品属性 </button> 
      </div>  
     </div> 

  <div class="panel-body"> 
   <div class="form"> 
    <form class="cmxform form-horizontal adminex-form" id="signupForm" method="post" enctype="multipart/form-data" action="<?php echo U('Store/doeditattr');?>" novalidate="novalidate"> 
    

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">商品描述</label> 
      <div class="col-lg-10"> 
       <textarea class="form-control" name="good_attr_des"  cols="20" rows="5"><?php echo ($good_attr_info['good_attr_des']); ?></textarea> 
      </div> 
     </div> 

     <div class="form-group "> 
      <label for="state" class="control-label col-lg-2">商品价格</label> 
      <div class="col-lg-10"> 
       <input class="form-control" id="good_price" name="good_attr_price" type="text" value="<?php echo ($good_attr_info["good_attr_price"]); ?>" /> 
       <input class="form-control" id="id" name="id" type="hidden" value="<?php echo ($good_attr_info["id"]); ?>" /> 
      </div> 
     </div> 

     <div class="form-group "> 
      <label for="state" class="control-label col-lg-2">商品颜色</label> 
      <div class="col-lg-10"> 
       <input class="form-control" id="good_color" name="good_attr_color" type="text" value="<?php echo ($good_attr_info["good_attr_color"]); ?>" /> 
      </div> 
     </div> 

     <div class="form-group "> 
      <label for="state" class="control-label col-lg-2">商品大小</label> 
      <div class="col-lg-10"> 
       <input class="form-control" id="good_size" name="good_attr_size" type="text" value="<?php echo ($good_attr_info["good_attr_size"]); ?>" /> 
      </div> 
     </div> 

     <div class="form-group "> 
      <label for="state" class="control-label col-lg-2">库存量</label> 
      <div class="col-lg-10"> 
       <input class="form-control" id="good_num" name="good_attr_num" type="text" value="<?php echo ($good_attr_info["good_attr_num"]); ?>" /> 
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">修改商品状态</label> 
      <div class="col-lg-10"> 
        <select class="form-control m-bot15" name="good_attr_state">
           <option value="3" <?php if($good_attr_info["good_attr_state"] == 3): ?>selected<?php endif; ?>>在售</option> 
           <option value="1" <?php if($good_attr_info["good_attr_state"] == 1): ?>selected<?php endif; ?>>下架</option> 
           <option value="2" <?php if($good_attr_info["good_attr_state"] == 2): ?>selected<?php endif; ?>>新商品</option> 
        </select>
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
<script src="/guangzhoushangcheng/Public/Admin/js/jquery-1.10.2.min.js"></script>
<script src="/guangzhoushangcheng/Public/Admin/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="/guangzhoushangcheng/Public/Admin/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/guangzhoushangcheng/Public/Admin/js/bootstrap.min.js"></script>
<script src="/guangzhoushangcheng/Public/Admin/js/modernizr.min.js"></script>
<script src="/guangzhoushangcheng/Public/Admin/js/jquery.nicescroll.js"></script>

<!--easy pie chart-->
<script src="/guangzhoushangcheng/Public/Admin/js/easypiechart/jquery.easypiechart.js"></script>
<script src="/guangzhoushangcheng/Public/Admin/js/easypiechart/easypiechart-init.js"></script>

<!--Sparkline Chart-->
<script src="/guangzhoushangcheng/Public/Admin/js/sparkline/jquery.sparkline.js"></script>
<script src="/guangzhoushangcheng/Public/Admin/js/sparkline/sparkline-init.js"></script>

<!--icheck -->
<script src="/guangzhoushangcheng/Public/Admin/js/iCheck/jquery.icheck.js"></script>
<script src="/guangzhoushangcheng/Public/Admin/js/icheck-init.js"></script>

<!-- jQuery Flot Chart-->
<script src="/guangzhoushangcheng/Public/Admin/js/flot-chart/jquery.flot.js"></script>
<script src="/guangzhoushangcheng/Public/Admin/js/flot-chart/jquery.flot.tooltip.js"></script>
<script src="/guangzhoushangcheng/Public/Admin/js/flot-chart/jquery.flot.resize.js"></script>


<!--Morris Chart-->
<script src="/guangzhoushangcheng/Public/Admin/js/morris-chart/morris.js"></script>
<script src="/guangzhoushangcheng/Public/Admin/js/morris-chart/raphael-min.js"></script>

<!--Calendar-->
<!-- <script src="/guangzhoushangcheng/Public/Admin/js/calendar/clndr.js"></script>
<script src="/guangzhoushangcheng/Public/Admin/js/calendar/evnt.calendar.init.js"></script>
<script src="/guangzhoushangcheng/Public/Admin/js/calendar/moment-2.2.1.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore./guangzhoushangcheng/Public/Admin/js/1.5.2/underscore-min.js"></script> -->

<!--common scripts for all pages-->
<script src="/guangzhoushangcheng/Public/Admin/js/scripts.js"></script>

<!--Dashboard Charts-->
<script src="/guangzhoushangcheng/Public/Admin/js/dashboard-chart-init.js"></script>


</body>
</html>