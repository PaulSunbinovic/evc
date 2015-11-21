<?php
class UsrModel{
	//#############interface#####################
	//http://120.26.80.165/user/get.action?wechatId=12345
	//http://114.215.209.115/userAccount/getUserAccount.action?wechatId=ojxMBuPfL9ru7RCI1o2iSjw_8Ix0
	//
	//#########MODEL########################
	public function test($id){
		$url='';
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//##################################################################################
	public function get($openid){
		$url=C('javaback').'/user/get.action?wechatId='.$openid;
		$json='{"data":{"user":{"id":1,"token":1,"wechatId":"12345","nickName":"王 峰","mobile":"13162951502","macId":"dadadaaf","headImgUrl":"baidu.com","createTime":"2015-09-13 10:37:53","updateTime":"2015-09-13 10:37:53","customer":true,"deviceOwner":false,"installser":false,"admin":false},"userAccount":{"id":1,"userId":1,"balance":990,"point":0,"createTime":"2015-09-13 10:37:54","updateTime":"2015-09-19 23:26:50","version":1},"carList": [{"id":1,"userId":1,"carModelId":1,"carNo":"沪 A11111","isDefault":false,"createTime":"2015-09-19 22:19:36","updateTime":"2015-09-19 22:19:40"}]},"code":"A00000","msg":null}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function getUserAccount($openid){
		$url=C('javaback').'/userAccount/getUserAccount.action?wechatId='.$openid;
		$json='{"data":{"id":36,"userId":28,"balance":3000,"point":14940,"totalPoint":14940,"createTime":"2015-11-19 19:39:52","updateTime":"2015-11-19 19:39:54","version":45},"code":"A00000","msg":""}';
		$arr=url2arr($url,$json);
		return $arr;
	}
}


?>