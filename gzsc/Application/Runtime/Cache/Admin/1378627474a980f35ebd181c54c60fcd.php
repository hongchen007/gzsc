<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

  
   <title>后台-浏览电商广告轮播</title>
  
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

                <?php if($_SESSION['info']['user_grade']== 0 || $_SESSION['info']['user_grade']== 1): ?><li class="menu-list"><a href=""><i class="fa fa-cogs"></i></i> <span>分类管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Cate/index');?>">浏览分类</a></li>
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

                    <li class="menu-list"><a href=""><i class="fa fa-cogs"></i></i> <span>活动管理</span></a>
                        <ul class="sub-menu-list">
                            <li><a href="<?php echo U('Activity/index');?>">浏览活动</a></li>
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
       <button id="editable-sample_new" class="btn btn-primary"> 后台 &gt; 浏览电商广告轮播 </button> 
      </div> 
      <div class="btn-group pull-right"> 
       <a href="<?php echo U('Adsserve/add');?>"><button id="editable-sample_new" class="btn btn-primary"> Add New <i class="fa fa-plus"></i> </button></a> 
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
        <form class="form-inline" role="form" action="<?php echo U('Adsserve/index');?>" method="get" />

            <div class="form-group">服务类型：
              <select class="form-control m-bot15" name="cate" >
                  <option value="">--请选择--</option>
                  <?php if(is_array($info)): foreach($info as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["cate_name"]); ?></option><?php endforeach; endif; ?>
              </select>
            </div>

            <div class="form-group">图片的位置：
              <select class="form-control m-bot15" name="adsserve_address" >
                  <option value="">--请选择--</option>
                  <option value="1">头部</option>
                  <option value="2">中部</option>
              </select>
            </div>

            <div class="form-group">是否失效：
              <select class="form-control m-bot15" name="adsserve_status" >
                  <option value="">--请选择--</option>
                  <option value="1">正常</option>
                  <option value="2">失效</option>
              </select>
            </div>

            <div class="form-group">状态：
              <select class="form-control m-bot15" name="adsserve_state" >
                  <option value="">--请选择--</option>
                  <option value="1">正常</option>
                  <option value="2">禁用</option>
                  <option value="3">待审核</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">搜索</button>
        </form>
    </div>
     
      <table class="table table-striped table-hover table-bordered dataTable" id="editable-sample" aria-describedby="editable-sample_info"> 
       <thead>
        <tr role="row">
         <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 9%;" aria-label="First Name">服务类型</th>
         <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 9%;" aria-label="First Name">发布人</th>
         <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 9%;" aria-label="First Name">图片</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 9%;" aria-label="Last Name: activate to sort column ascending">链接地址</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 9%;" aria-label="Last Name: activate to sort column ascending">图片的位置</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 9%;" aria-label="Last Name: activate to sort column ascending">描述</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 9%;" aria-label="Points: activate to sort column ascending">添加时间</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 9%;" aria-label="Points: activate to sort column ascending">过期时间</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 9%;" aria-label="Points: activate to sort column ascending">是否失效</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 9%;" aria-label="Last Name: activate to sort column ascending">状态</th>
         <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1" colspan="1" style="width: 9%;" aria-label="Points: activate to sort column ascending">操作</th>
        </tr> 
       </thead> 
       <tbody role="alert" aria-live="polite" aria-relevant="all"> 
       <?php if(is_array($UserInfo)): foreach($UserInfo as $key=>$val): ?><tr class="odd"> 
         <td class=" "><?php echo ($val["cate_name"]); ?></td> 
         <td class=" ">
            <?php if($val["user_grade"] == 2): ?>商户:<?php echo ($val["user_store_name"]); ?></span>
            <?php elseif($val["user_grade"] == 5): ?>用户:<?php echo ($val["user_name"]); ?></span><?php endif; ?>         
         </td>
         <td class=" "><img src="/gzsc/Public/Uploads/<?php echo ($val['adsserve_pic']); ?>" style="height:100px;"></td>  
         <td class=" "><?php echo ($val["adsserve_http"]); ?></td> 
         <td class="  sorting_1">
            <?php if($val["adsserve_address"] == 1): ?>头部的图片轮播
            <?php elseif($val["adsserve_address"] == 2): ?>中间的图片轮播<?php endif; ?>
         </td> 
         <td class=" "><?php echo ($val["adsserve_descr"]); ?></td> 
         <td class=" "><?php echo ($val["add_time"]); ?></td>  
         <td class=" "><?php echo ($val["end_time"]); ?></td>  
         <td class="  sorting_1">
            <?php if($val["adsserve_status"] == 1): ?><span style="color:blue;"> 正常</span>
            <?php elseif($val["adsserve_status"] == 2): ?> <span style="color:red;">失效</span><?php endif; ?>
         </td>  
         <td class="sorting_1">
            <?php if($val["adsserve_state"] == 1): ?><span style="color:blue;"> 正常</span>
            <?php elseif($val["adsserve_state"] == 2): ?> <span style="color:red;">禁用</span>
            <?php elseif($val["adsserve_state"] == 3): ?> <span style="color:green;">待审核</span><?php endif; ?>
         </td> 
         <td class=" ">
          <?php if($val["adsserve_state"] == 1): ?><a href="/gzsc/index.php/Admin/Adsserve/detail/id/<?php echo ($val["id"]); ?>">详情</a> <br>
            <a href="/gzsc/index.php/Admin/Adsserve/edit/id/<?php echo ($val["id"]); ?>">修改</a> <br>
            <a href="/gzsc/index.php/Admin/Adsserve/del/id/<?php echo ($val["id"]); ?>">删除</a><br>
            <a href="/gzsc/index.php/Admin/Adsserve/stop/id/<?php echo ($val["id"]); ?>">禁用</a><?php endif; ?>
          <?php if($val["adsserve_state"] == 2): ?><a href="/gzsc/index.php/Admin/Adsserve/detail/id/<?php echo ($val["id"]); ?>">详情</a> <br>
            <a href="/gzsc/index.php/Admin/Adsserve/del/id/<?php echo ($val["id"]); ?>">删除</a><br>
            <a href="/gzsc/index.php/Admin/Adsserve/stop/id/<?php echo ($val["id"]); ?>">启用</a><?php endif; ?>
          <?php if($val["adsserve_state"] == 3): ?><a href="/gzsc/index.php/Admin/Adsserve/detail/id/<?php echo ($val["id"]); ?>">详情</a><br>
            <a href="/gzsc/index.php/Admin/Adsserve/del/id/<?php echo ($val["id"]); ?>">删除</a> <br> 
            <a href="/gzsc/index.php/Admin/Adsserve/pass/id/<?php echo ($val["id"]); ?>">通过审核</a><?php endif; ?>
         </td> 
        </tr><?php endforeach; endif; ?>
       </tbody>
      </table>

  <center>
    <div class="pages">
      <?php echo ($Page); ?>
    </div>
  </center/>
      
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