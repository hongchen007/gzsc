<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model
{
	public function Open($Tel)
	{
		header('Content-type: text/html; charset=utf-8');
		$Api = m('api');
		$ApiInfo = $Api->where('Id=1')->field('Uid,Key')->find();
		$Uid = $ApiInfo['Uid'];
		$Key = $ApiInfo['Key'];
		$Yzm = mt_rand(1001, 9999);
		$url = 'http://sms.webchinese.cn/web_api/?Uid=' . $Uid . '&Key=' . $Key . '&smsMob=' . $Tel . '&smsText=验证码:' . $Yzm;

		if (function_exists('file_get_contents')) {
			$file_contents = file_get_contents($url);
		}
		else {
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$file_contents = curl_exec($ch);
			curl_close($ch);
		}

		$Result['Tel'] = $Tel;
		$Result['phoneyz'] = $Yzm;
		$Result['phonetime'] = time();

		if ($_SESSION['YZM']['starttime'] == '') {
			$Result['starttime'] = time();
		}

		$_SESSION['YZM'] = $Result;
		return $file_contents;
	}
	//添加的
	public function login(){

		echo "111";exit;
	}
}

echo '' . "\r\n" . '' . "\r\n" . '' . "\r\n" . '';

