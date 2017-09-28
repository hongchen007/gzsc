<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

  <title>物流信息</title>
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


    <style type="text/css">
        *{
            margin:0;
            padding:0;
        }
        #selectAge {
            width: 400px;
        }
        div.hidehaha {
            width: 80%;
            height: 200px;
            border: 1px solid #ddd;
            padding:1rem 0 1rem 1rem;
            overflow-y: auto;
            display:flex;
            flex-direction: row;
            flex-wrap: wrap;
        }
        .hidehaha>option{
            font-size:1.3rem;
            margin-right:0.5rem;
            padding-right:0.5rem;
            border-right:1px solid #ddd;
            height:30px;
        }
        .li_flex{
            list-style: none;
            display:flex;
            flex-wrap: wrap;
        }
        ul>li{
           /*!*width:40px;*!*/
            font-size:1.3rem;
            margin-right:0.5rem;
            padding-right:0.5rem;
            border-right:1px solid #ddd;
        }
    </style>
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
                    <li class="menu-list"><a href=""><i class="fa fa-th-large"></i> <span>商铺电商管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Store/good');?>">商铺所有商品</a></li>
                            <li><a href="<?php echo U('Store/add');?>">添加商铺商品</a></li>
                        </ul>
                    </li>
                    <li class="menu-list"><a href=""><i class="fa fa-th-large"></i> <span>商铺服务管理</span></a>
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
                    <li class="menu-list"><a href=""><i class="fa fa-th-large"></i> <span>商铺订单管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Order/index');?>">商铺所有订单</a></li>
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
        <title>后台-添加物流信息</title>

         <div class="clearfix" style="margin-left:10px;"> 
          <div class="btn-group"> 
           <button id="editable-sample_new" class="btn btn-primary"> 后台 &gt; 物流信息 </button> 
          </div>  

          <div class="btn-group pull-right"> 
           <a href="/gzsc/index.php/Admin/Order/index"><button id="editable-sample_new" class="btn btn-primary"><i class="fa fa-reply"></i> fa-reply</button></a> 
          </div>
         </div> 

  <div class="panel-body"> 
   <div class="form"> 
    <form class="cmxform form-horizontal adminex-form" id="signupForm" method="post" enctype="multipart/form-data" action="<?php echo U('Order/doaddwuliu');?>" novalidate="novalidate">   

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">修改物流</label> 
      <div class="col-lg-10"> 
        <div id="select">
            <input class="form-control" type="text" name="selectAge" id="selectAge">
            <div class="hidehaha">
                <ul class="li_flex">
                  <li>百世汇通</li>
                  <li>顺丰</li>
                  <li>圆通速递</li>
                  <li>韵达快运</li>
                  <li>申通</li>
                  <li>中通速递</li>
                  <li>天天快递</li>
                  <li>邮政小包（国内）</li>
                  <li>邮政小包（国际）</li>
                  <li>EMS(中文结果)</li>
                  <li>德邦物流</li>
                  <?php if(is_array($info)): foreach($info as $key=>$val): ?><li><?php echo ($val["name"]); ?></li><?php endforeach; endif; ?>
                </ul>
            </div>
        </div>
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">原物流</label> 
      <div class="col-lg-10"> 
       <input class="form-control " id="order_wuliucompany" name="order_wuliucompany" type="text" value="<?php echo ($info1["order_wuliucompany"]); ?>"/> 
       
      </div> 
     </div> 

    <div class="form-group "> 
      <label for="QQ" class="control-label col-lg-2">原订单号</label> 
      <div class="col-lg-10"> 
       <input class="form-control " id="order_wuliunum" name="order_wuliunum" type="text" value="<?php echo ($info1["order_wuliunum"]); ?>"/> 
       <input class="form-control " id="id" name="id" type="hidden" value="<?php echo ($id); ?>" /> 
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

 <script type="text/javascript">
    $(function () {
        $(".hidehaha").hide();
        $("#selectAge").focus(function () {
            $(".hidehaha").slideDown("slow");
            $("li").css("cursor","pointer");
            // onmouseover="this.style.cursor='hand'";
        });
        $("#selectAge").blur(function () {
            $(".hidehaha").slideUp("slow");
        });

    });
    $("li").click(function () {
        var list = $(this).html();
        $("#selectAge").val(list)
    });
</script>

</html>