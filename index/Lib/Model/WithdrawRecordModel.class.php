<?php
class WithdrawRecordModel{
	//##################interface###########
	//http://114.215.209.115/ withdrawRecord/createWithdrawRecord.action
	//
	//######MODEL###########
	public function test($id){
		$url='';
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//################
	public function createWithdrawRecord($uname,$openid,$bankcardno,$bankname,$withdrawvalue){
		$url=C('javaback').'/withdrawRecord/createWithdrawRecord.action?uName='.urlencode($uname).'&wechatId='.$openid.'&bankCardNo='.urlencode($bankcardno).'&bankName='.urlencode($bankname).'&withdrawValue='.urlencode($withdrawvalue);
		$json='{"data":{"id":2,"name":"","brand":"BYD","model":"唐"},"code":"A00000","msg":null}';
		$arr=url2arr($url,$json);
		return $arr;
	}
}
?>