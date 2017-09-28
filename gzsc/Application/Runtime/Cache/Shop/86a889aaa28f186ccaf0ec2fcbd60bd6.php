<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

  
   <title>后台-浏览商户</title>
  
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
                    <li class="menu-list"><a href=""><i class="fa fa-th-large"></i> <span>商铺商品管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Store/good');?>">商铺所有商品</a></li>
                            <li><a href="<?php echo U('Store/add');?>">添加商铺商品</a></li>
                        </ul>
                    </li>
                    <li class="menu-list"><a href=""><i class="fa fa-th-large"></i> <span>商铺服务管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Service/index');?>">商铺所有服务</a></li>
                            <li><a href="<?php echo U('Service/add');?>">添加商铺服务</a></li>
                        </ul>
                    </li>
                    
                    <li class="menu-list"><a href=""><i class="fa fa-th-large"></i> <span>商铺服务管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Service/index');?>">商铺所有服务</a></li>
                            <li><a href="<?php echo U('Service/add');?>">添加商铺服务</a></li>
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
         
   <div class="panel-body"> 
    <div class="adv-table editable-table "> 

     <div class="clearfix"> 
      <div class="btn-group"> 
       <button id="editable-sample_new" class="btn btn-primary"> 后台 &gt; 浏览商户 </button> 
      </div> 
      <div class="btn-group pull-right"> 
       <a href="<?php echo U('User/insert');?>"><button id="editable-sample_new" class="btn btn-primary"> Add New <i class="fa fa-plus"></i> </button></a> 
       <ul class="dropdown-menu pull-right"> 
        <li><a href="#">Print</a></li> 
        <li><a href="#">Save as PDF</a></li> 
        <li><a href="#">Export to Excel</a></li> 
       </ul> 
      </div> 
     </div> 
     
     <div class="space15"></div> 
     <div id="editable-sample_wrapper" class="dataTables_wrapper form-inline" role="grid">
        
     <div class="panel-body">
        <form class="form-inline" role="form" action="<?php echo U('User/index');?>" method="get" />
            
            <div class="form-group">
                <input class="form-control" id="exampleInputEmail2" value="<?php echo ($_GET['user_name']); ?>" name="user_name" placeholder="搜索用户名" type="text">
            </div>
           
            <div class="form-group">
                <input class="form-control" id="exampleInputEmail2" value="<?php echo ($_GET['user_store_name']); ?>" name="user_store_name" placeholder="搜索商户名" type="text">
            </div>

            <div class="form-group">状态：
              <select class="form-control m-bot15" name="user_grade" >
                  <option value="">--请选择--</option>
                  <option value="2">正常商户</option>
                  <option value="3">禁用商户</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">搜索</button>
        </form>
    </div>
     
      <table class="table table-striped table-hover table-bordered dataTable" id="editable-sample" aria-describedby="editable-sample_info"> 
       <thead>
        <tr role="row">
         <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 5%;" aria-label="First Name">用户名</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 5%;" aria-label="Last Name: activate to sort column ascending">状态</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 5%;" aria-label="Last Name: activate to sort column ascending">商户名</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 5%;" aria-label="Last Name: activate to sort column ascending">商户图片</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 5%;" aria-label="Points: activate to sort column ascending">身份证号</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 5%;" aria-label="Points: activate to sort column ascending">地址</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 5%;" aria-label="Status: activate to sort column ascending">商户营业执照号</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 5%;" aria-label="Edit: activate to sort column ascending">商户注册资金</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 5%;" aria-label="Edit: activate to sort column ascending">商户保证金</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 5%;" aria-label="Edit: activate to sort column ascending">操作</th>
        </tr> 
       </thead> 
       <tbody role="alert" aria-live="polite" aria-relevant="all"> 
       <?php if(is_array($UserInfo)): foreach($UserInfo as $key=>$val): ?><tr class="odd"> 
         <td class="  sorting_1"><?php echo ($val["user_name"]); ?></td> 
         <td class="  sorting_1">
            <?php if($val["user_grade"] == 1): ?><span style="color:blue;"> 超级管理员</span>
            <?php elseif($val["user_grade"] == 2): ?> <span style="color:green;">商户正常</span>
            <?php elseif($val["user_grade"] == 3): ?> <span style="color:red;">商户禁用</span><?php endif; ?>
         </td> 
         <td class=" "><?php echo ($val["user_store_name"]); ?></td> 
         <td class=" "><img src="/gzsc/Public/Uploads/<?php echo ($val['user_store_pic']); ?>" style="width:100px;"></td> 
         <td class=" "><?php echo ($val["user_id"]); ?></td> 
         <td class=" "><?php echo ($val["user_store_address"]); ?></td> 
         <td class=" "><?php echo ($val["user_store_lience"]); ?></td> 
         <td class=" "><?php echo ($val["user_store_registered"]); ?></td> 
         <td class=" "><?php echo ($val["user_store_cash"]); ?></td> 
         <td class=" ">
          <?php if($val["user_grade"] == 2): ?><a href="/gzsc/index.php/Shop/User/edit/id/<?php echo ($val["id"]); ?>">修改</a> <br>
            <a href="/gzsc/index.php/Shop/User/del/id/<?php echo ($val["id"]); ?>">删除</a><br>
            <a href="/gzsc/index.php/Shop/User/stop/id/<?php echo ($val["id"]); ?>">禁用</a>
          <?php else: ?>
            <a href="/gzsc/index.php/Shop/User/edit/id/<?php echo ($val["id"]); ?>">修改</a><br>
            <a href="/gzsc/index.php/Shop/User/del/id/<?php echo ($val["id"]); ?>">删除</a> <br> 
            <a href="/gzsc/index.php/Shop/User/start/id/<?php echo ($val["id"]); ?>">启用</a><?php endif; ?>
         </td> 
        </tr><?php endforeach; endif; ?>
            <tr class="content">
                <td colspan="3" bgcolor="#FFFFFF"><div class="pages">
                  <?php echo ($page); ?>
                </div></td>  
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