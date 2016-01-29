<?php
class GroupModel{
	//###################interface##############
	//http://120.26.80.165/proxyGroup/selectGroup.action
	//http://114.215.209.115/proxyGroup/isInterests.action
	//http://114.215.209.115/proxyGroup/selectListGroupByUser.action
	//http://114.215.209.115/proxyGroup/countMoney.action
	

	//#########MODEL########################
	public function test($id){
		$url='';
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	

	//#########MODEL########################
	public function selectGroup($id,$groupName,$address){
		$cdt='';
		if($cdt&&$id){$cdt=$cdt.'&id='.$id;}else if(!$cdt&&$id){$cdt='id='.$id;}
		if($cdt&&$groupName){$cdt=$cdt.'&groupName='.$groupName;}else if(!$cdt&&$groupName){$cdt='groupName='.$groupName;}
		if($cdt&&$address){$cdt=$cdt.'&address='.$address;}else if(!$cdt&&$address){$cdt='address='.$address;}
		$url=C('javaback').'/proxyGroup/selectGroup.action'.$cdt;
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}

	//#########MODEL########################
	public function isInterests($openid){
		$url=C('javaback').'/proxyGroup/isInterests.action?wechatId='.$openid;
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}


	//#########MODEL########################
	public function selectListGroupByUser($openid){
		$url=C('javaback').'/proxyGroup/selectListGroupByUser.action?wechatId='.$openid;
		$json='{"data":[{"id":1,"code":"6379","groupName":"黄龙洞","address":"黄龙体育场对面","capacity":20.0},{"id":2,"code":"9635","groupName":"bbbb","address":"bbbb","capacity":20.0}],"code":"A00000","msg":"查询成功！"}';
		$arr=url2arr($url,$json);
		return $arr;
	}

	
	//#########MODEL########################
	public function countMoney($openid){
		$url=C('javaback').'/proxyGroup/countMoney.action?wechatId='.$openid;
		$json='{"data":{"total":63.78,"yesterday":0.0},"code":"A00000","msg":"查询成功！"}';
		$arr=url2arr($url,$json);
		return $arr;
	}
}
?>