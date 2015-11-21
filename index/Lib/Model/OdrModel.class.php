<?php
class OdrModel{
	//#############interface#########
	//http://120.26.80.165/order/getLastOrder.action?wechatId=12345
	//http://120.26.80.165/order/getLastOrderByDeviceId.action?deviceId=1

	//
	//#########MODEL########################
	public function test($id){
		$url='';
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//################################
	public function getLastOrder($openid){
		$url=C('javaback').'/order/getLastOrder.action?wechatId='.$openid;
		$json='{"data":{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":null,"createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},"code":"A00000","msg":null}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function getLastOrderByDeviceId($dvcid){
		$url=C('javaback').'/order/getLastOrderByDeviceId.action?deviceId='.$dvcid;
		$json='{"data":{"id":65,"userId":27,"macId":null,"deviceId":9,"price":null,"startDegree":0,"endDegree":151,"carId":null,"status":6,"totalPrice":25066,"createTime":"2015-11-15 05:52:37","updateTime":"2015-11-15 05:52:41","endTime":"2015-11-15 05:52:41","version":1,"freeFlag":1,"statusFinal":true},"code":"A00000","msg":null}';
		$arr=url2arr($url,$json);
		return $arr;
	}
}
?>