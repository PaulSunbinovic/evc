<?php
class WXModel{
	//https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=XXXXX&secret=xxxxx

	//
	//#########MODEL########################
	public function getaccesstoken($appid,$secret){
		$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
}
?>