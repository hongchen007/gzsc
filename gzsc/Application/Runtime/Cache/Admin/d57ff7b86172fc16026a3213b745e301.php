<?php if (!defined('THINK_PATH')) exit();?><!--register.html-->
<!DOCTYPE html>
<html lang="zh" ng-app="sunApp">
<head>
<meta charset="UTF-8">
<title>注册</title>
</head>
<body ng-controller="registerController">
<form action="" class="register-form" ng-show="isShow1">
<div class="input-group">
<input type="text" class="mobile" ng-model="mobile" placeholder="手机号">
</div>
<div class="input-group">
<input type="text" class="pic-code" ng-model="picCode" placeholder="图片验证码">
<img class="img" src="{{picCodeUrl}}" alt="" ng-click="refresh()">
</div>
<div class="input-group">
<input type="text" class="sms-code" ng-model="SMSCode" placeholder="短信验证码">
<button class="btn-sms" ng-click="getSMSCode()" ng-disabled="btnSMSDisabled">{{btnSMSText}}</button>
</div>
<button class="confirm-btn" ng-click="next()">下一步</button>
</form>
<form action="" class="register-form" ng-show="isShow2">
<div class="input-group">
<input type="text" class="mobile" ng-model="mobile" placeholder="手机号" disabled="true">
</div>
<div class="input-group">
<input type="password" class="password" ng-model="password" placeholder="请输入密码">
<input type="password" class="password" ng-model="password2" placeholder="请再次输入密码">
</div>
<button class="confirm-btn" ng-click="getSMSCode()">注册</button>
</form>
</body>
</html>
<!-- // register.js
angular.module('sunApp').controller('registerController', function ($scope,$http,$httpParamSerializer,$state,$interval) { 
$scope.picCodeUrl = '/owner-bd/index.php/Home/CheckCode/getPicCode';
$scope.isShow1 = true;
$scope.isShow2 = false;
$scope.btnSMSText = '获取验证码';
$scope.btnSMSDisabled = false;
$scope.checkOver = false;
// 获取短信验证码
$scope.getSMSCode = function(){
var param = {
mobile: $scope.mobile,
picCode: $scope.picCode
};
$http({
method:'POST',
url:'/owner-bd/index.php/Home/SMS/getSMSCode',
//url: '/owner-fd/mock/common.json',
headers:{
'Content-Type':'application/x-www-form-urlencoded'
},
dataType: 'json',
data: $httpParamSerializer(param)
}).then(function successCallback(response) {
console.log(response.data);
if(response.data.code == '0'){
$scope.checkOver = true;
$scope.btnSMSDisabled = true;
var time = 60;
var timer = null;
timer = $interval(function(){
time = time - 1;
$scope.btnSMSText = time+'秒';
if(time == 0) {
$interval.cancel(timer);
$scope.btnSMSDisabled = false;
$scope.btnSMSText = '重新获取';
}
}, 1000);
}
}, function errorCallback(response) {
console.log(response.data);
});
}
// 验证短信验证码
$scope.next = function(){
if(!$scope.checkOver){
console.log('未通过验证');
return;
}
var param = {
mobile: $scope.mobile,
code: $scope.SMSCode
};
$http({
method:'POST',
url:'/owner-bd/index.php/Home/SMS/checkSMSCode',
//url: '/owner-fd/mock/common.json',
headers:{
'Content-Type':'application/x-www-form-urlencoded'
},
dataType: 'json',
data: $httpParamSerializer(param)
}).then(function successCallback(response) {
console.log(response.data);
if(response.data.code == '0'){
$scope.isShow1 = false;
$scope.isShow2 = true;
}
}, function errorCallback(response) {
console.log(response.data);
});
}
// 刷新图片验证码
$scope.refresh = function(){
$scope.picCodeUrl = '/owner-bd/index.php/Home/CheckCode/getPicCode?'+Math.random();
}
}); -->