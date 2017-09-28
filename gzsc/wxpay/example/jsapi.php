<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';


//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}
//数据
$arr = json_decode(base64_decode($_GET['state']));
// print_r($arr);
// print_r($arr->price);

//①、获取用户openid
$tools = new JsApiPay(); 
$openId = $tools->GetOpenid();
$input = new WxPayUnifiedOrder();
$input->SetBody("这是啥");								        //商品名称
$input->SetAttach("test");										//附加参数,可填可不填,填写的话,里边字符串不能出现空格  
$input->SetOut_trade_no('123'.rand(111111,999999).date("YmdHis"));	//订单号
$input->SetTotal_fee($arr->price*100);					        //支付金额,单位:分  
$input->SetTime_start(date("YmdHis")); 							//支付发起时间  
$input->SetTime_expire(date("YmdHis", time() + 600));			//支付超时  
$input->SetGoods_tag("test");
$input->SetNotify_url("http://hongchen.chuan.bxso2o.com/card/pay/example/notify.php"); 	//支付回调验证地址  ！！！！！
$input->SetTrade_type("JSAPI");									//支付类型 
$input->SetOpenid($openId);										//用户openID 
$order = WxPayApi::unifiedOrder($input); 						//统一下单
// echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
// printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
// $editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/*
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>

<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>微信支付页面-支付</title>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			// function(res){
			// 	WeixinJSBridge.log(res.err_msg);
			// 	alert(res.err_code+res.err_desc+res.err_msg);
			// }
			function(res){
				// alert(res.err_msg)
				//支付成功
           		if(res.err_msg == "get_brand_wcpay_request:ok") {
           			window.location.href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx426451259ba576c6&redirect_uri=http%3a%2f%2fhongchen.chuan.bxso2o.com%2fcard%2findex.php%2fHome%2fCard%2fhuiyuanzhongxin&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
           		}

           		//支付过程中用户取消
           		if(res.err_msg == "get_brand_wcpay_request:cancel" ) {
           			alert("支付取消");window.location.go(-1);
           		}

           		//支付失败
           		if(res.err_msg == "get_brand_wcpay_request:fail" ) {
           			alert("支付失败");window.location.go(-1);
           		}
       		}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	callpay()
	</script>
</head>
<body>
    <br/>
    <!-- <font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">1分</span>钱</b></font><br/><br/> -->
	<div align="center">
		<!-- <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button> -->
	</div>
</body>
</html>