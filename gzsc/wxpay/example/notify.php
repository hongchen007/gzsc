<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		//opid  money  订单号  
		print_r($data);
		// $data = json_encode($data);
		// echo "111";
		// echo "<script> window.location.href='http://hongchen.chuan.bxso2o.com/card/index.php/Home/Card/dozhifu?data=$data'</script>";
		PayNotifyCallBack::getdata($data);

		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}

		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		return true;
	}

	public function getdata($data){
		$openid = $data['openid']; 			//用户的唯一标识		
		$total_fee = $data['total_fee'];	//这个是加钱
		$ordernum  = $data['out_trade_no'];	//这个是订单号
		$url  =  "http://hongchen.chuan.bxso2o.com/card/index.php/Home/Card/dozhifu?openid=$openid&total_fee=$total_fee&ordernum=$ordernum";
		$html = file_get_contents($url);
		if($htm = "ok"){
			return "ok";
		}
	}
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);

