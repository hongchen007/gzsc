<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title>Login</title>

    <link href="/gzsc/Public/Admin/css/style.css" rel="stylesheet">
    <link href="/gzsc/Public/Admin/css/style-responsive.css" rel="stylesheet"> 

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/gzsc/Public/Admin/js/html5shiv.js"></script>
    <script src="/gzsc/Public/Admin/js/respond.min.js"></script>
    <![endif]-->

    <style>
        .classify{
            display:flex;
        }
        .classify>li{
            width:50%;

        }
        .classify>li>a:hover{
            text-decoration: none;
        }
    </style>

</head>

<body class="login-body">

<div class="container">

    <div class="form-signin">
        <div class="form-signin-heading text-center">
        <h1 class="sign-title">管理员登录</h1>
            <ul class="classify">
                <li class="classify_A level active" a="0">
                    <a href="#">
                        <span style="color:#688AC2;">管理员登录</span>
                    </a>
                </li>

            </ul>
            <img src="/gzsc/Public/Admin/Images/login-logo.png" alt=""/>
        </div>

        <div class="sty">
            <div class="login-wrap">
                <input type="text" class="form-control" placeholder="请输入用户名或手机号" name="name" id="name" autofocus>
                <input type="password" class="form-control" name="pwd" placeholder="请输入密码" id="pwd">
                <button class="btn btn-lg btn-login btn-block" type="submit" id="btn">
                    <i class="fa fa-check"></i>
                </button>
            </div>
            <div class="login-wrap" style="display:none">
                <input type="text" class="form-control" placeholder="love" autofocus>
                <input type="password" class="form-control" placeholder="love">

                <button class="btn btn-lg btn-login btn-block" type="submit">
                    <i class="fa fa-check"></i>
                </button>

                <div class="registration">
                    Not a member yet?
                    <a class="" href="registration.html">
                        Signup
                    </a>
                </div>
                <label class="checkbox">
                    <input type="checkbox" value="remember-me"> Remember me
                    <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                </span>
                </label>

            </div>
        </div>
    </div>
</div>


<!-- Placed js at the end of the document so the pages load faster -->

<!-- Placed js at the end of the document so the pages load faster -->
<script src="/gzsc/Public/Admin/js/jquery-1.10.2.min.js"></script>
<script src="/gzsc/Public/Admin/js/bootstrap.min.js"></script>
<script src="/gzsc/Public/Admin/js/modernizr.min.js"></script>

</body>
<script type="text/javascript">
    $("#btn").click(function(){

        var URL="/gzsc/index.php/Home/Login";
        var name=$("#name").val();
        var pwd=$("#pwd").val();
        var code=$("#code").val();

       $.ajax({
           url: URL+'/dologin',
           type:"GET",
           dataType: 'text',
           data:{
               name:name,
               pwd:pwd,
               code:code
           },
           dataType:"json",
           success: function(data){
                if(data == 1){
                   alert("用户名不存在");
                }else if(data == 2){
                    alert("密码不正确");
                }else if(data == 3){
                    alert("你的权限不够，请联系管理员"); 
                }else{
                    window.location.href="/gzsc/index.php/Home/Index/index";
                }
           }
        });
        
    })
</script>

</html>