<?php
class SSAction extends Action{
	function setss(){
		
		$openid=session('openid');
		//开发模式
		//$openid='ojxMBuJe07gSZDUwp0ZHGHEMHOR8';
		//$openid='ojxMBuCVyjkRAucWjPyA3xeDKsa0';
		//session('openid',$openid);

		$url=C('javaback').'/user/get.action?wechatId='.$openid;

		if(C('psnvs')==1){
			$json_usr='{"data":{"user":{"id":1,"token":1,"wechatId":"12345","nickName":"王 峰","mobile":"13162951502","macId":"dadadaaf","headImgUrl":"baidu.com","createTime":"2015-09-13 10:37:53","updateTime":"2015-09-13 10:37:53","customer":true,"deviceOwner":false,"installser":false,"admin":false},"userAccount":{"id":1,"userId":1,"balance":990,"point":0,"createTime":"2015-09-13 10:37:54","updateTime":"2015-09-19 23:26:50","version":1},"carList": [{"id":1,"userId":1,"carModelId":1,"carNo":"沪 A11111","isDefault":false,"createTime":"2015-09-19 22:19:36","updateTime":"2015-09-19 22:19:40"}]},"code":"A00000","msg":null}';
		}else{
			$json_usr=https_request($url);
		}
		
		
		$arr_usr=json_decode($json_usr,TRUE);
		$crls=$arr_usr['data']['carList'];
		$crlsnw=array();
		foreach ($crls as $crv) {
			$crmdlid=$crv['carModelId'];
			$url=C('javaback').'/carModel/get.action?carModelId='.$crmdlid;//根据modelId获取modelnm
			if(C('psnvs')==1){
				$json='{"data":{"id":2,"name":"","brand":"BYD","model":"唐"},"code":"A00000","msg":null}';
			}else{
				$json=https_request($url);
			}
			$arr=json_decode($json,true);
			$crv['brdmdl']=$arr['data'];
			array_push($crlsnw,$crv);
		}
		$arr_usr['data']['carList']=$crlsnw;
		
		$this->assign('usrdto',$arr_usr['data']);
		$this->assign('crls',$arr_usr['data']['carList']);

		

		return $arr_usr['data'];
	}

	
}
?>