<?php
class OdrModel{
	//#############interface#########
	//http://120.26.80.165/order/getLastOrder.action?wechatId=12345
	//http://120.26.80.165/order/getLastOrderByDeviceId.action?deviceId=1
	//http://120.26.80.165/order/appoint.action?wechatId=12345&deviceId=1&carId=1
	//http://114.215.209.115/order/listOrders.action?wechatId=ojxMBuPfL9ru7RCI1o2iSjw_8Ix0&pageNum=1&pageSize=10&startDate=2015-11-20&endDate=2015-11-22&orderStatus=2
	//http://114.215.209.115/order/checkOrderIsTimeOut.action?wechatId=ojxMBuPfL9ru7RCI1o2iSjw_8Ix0&deviceId=&orderId=332
	//http://114.215.209.115/order/appointCancel.action?wechatId=ojxMBuJe07gSZDUwp0ZHGHEMHOR8&deviceId=&orderId=460
	//http://114.215.209.115/order/handleOrderById.action?wechatId=ojxMBuJe07gSZDUwp0ZHGHEMHOR8&orderId=460
	//http://120.26.80.165/device/appointByScan.action?sn=aaa&wechatId=aaa
	//http://120.26.80.165/device/appointCancelWithScan.action?wechatId=aaa&orderId=bbb
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
	//#########MODEL########################
	public function appoint($openid,$dvcid,$carid){
		$str='';
		if($carid){$str=$str.'&carId='.$carid;}
		$url=C('javaback').'/order/appoint.action?wechatId='.$openid.'&deviceId='.$dvcid.$str;
		$json='{"data":4,"code":"A01407","msg":"用户余额不足"}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function listOrders($openid,$pgnumber,$pgsize,$startdate,$enddate,$odrstatus){
		$url=C('javaback').'/order/listOrders.action?wechatId='.$openid.'&pageNum='.$pgnumber.'&pageSize='.$pgsize.'&startDate='.$startdate.'&endDate='.$enddate.'&orderStatus='.$odrstatus;
		$json='{"data":[{"id":467,"userId":28,"macId":null,"deviceId":9,"price":200,"startDegree":0,"endDegree":null,"carId":null,"status":2,"totalPrice":null,"createTime":"2015-11-21 14:37:21","updateTime":"2015-11-22 14:37:54","endTime":null,"version":0,"freeFlag":0,"paramMap":null,"statusFinal":true}],"code":"A00000","msg":""}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function checkOrderIsTimeOut($openid,$odrid){
		$url=C('javaback').'/order/checkOrderIsTimeOut.action?wechatId='.$openid.'&orderId='.$odrid;
		$json='{"data":true,"code":"A00000","msg":""}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function appointCancel($openid,$odrid){
		$url=C('javaback').'/order/appointCancel.action?wechatId='.$openid.'&orderId='.$odrid;
		$json='{"data":null,"code":"A00000","msg":"订单预约已取消！"}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function handleOrderById($openid,$odrid){
		$url=C('javaback').'/order/handleOrderById.action?wechatId='.$openid.'&orderId='.$odrid;
		$json='{"data":{"id":460,"userId":6,"macId":null,"deviceId":9,"price":null,"startDegree":0,"endDegree":174,"carId":null,"status":6,"totalPrice":28884,"createTime":"2015-11-22 11:36:49","updateTime":"2015-11-23 01:29:15","endTime":null,"version":2,"freeFlag":0,"paramMap":null,"statusFinal":true},"code":"A00000","msg":""}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function appointByScan($sn,$openid){
		$url=C('javaback').'/order/appointByScan.action?sn='.$sn.'&wechatId='.$openid;
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//http://120.26.80.165/device/appointCancelWithScan.action?wechatId=aaa&orderId=bbb
	//#########MODEL########################
	public function appointCancelWithScan($openid,$odrid){
		$url=C('javaback').'/order/appointCancelWithScan.action?wechatId='.$openid.'&orderId='.$odrid;
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
}
?>