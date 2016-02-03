<?php
class VBIncomeModel{
	//http://114.215.209.115/VBIncome/listVBIncomePerday.action
	//http://114.215.209.115/VBIncome/listVBIncomePerMonth.action
	//http://114.215.209.115/VBIncome/listVBIcomeDeviceByDay.action
	//http://120.26.80.165/VBIncome/listVBIcomeDeviceByMonth.action

	//#########MODEL########################
	public function test($id){
		$url='';
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//http://114.215.209.115/VBIncome/listVBIncomePerday.action

	//#########MODEL########################
	public function listVBIncomePerday($openid,$groupid,$starttime,$endtime,$optiontime,$pagenum,$pagesize){
		$str='';
		if($groupid){$str=$str.'&groupId='.$groupid;}
		if($starttime){$str=$str.'&startTime='.urlencode($starttime);}
		if($endtime){$str=$str.'&endTime='.urlencode($endtime);}
		if($optiontime){$str=$str.'&optionTime='.urlencode($optiontime);}
		if($pagenum){$str=$str.'&pageNum='.$pagenum;}
		if($pagesize){$str=$str.'&pageSize='.$pagesize;}
		$url=C('javaback').'/VBIncome/listVBIncomePerday.action?wechatId='.$openid.$str;
		$json='{"data":[{"id":2,"code":null,"groupName":"bbbb","address":"bbbb","deviceId":null,"sn":null,"owner":null,"deviceType":null,"orderId":null,"eevId":null,"price":null,"number":null,"name":null,"expensesid":null,"epoId":null,"userId":null,"money":null,"createTime":"2016-01-26 00:00:00","preId":null,"serialType":null,"proportion":null,"paramMap":{"perTotalMoney":20,"totalMoney":6378}},{"id":2,"code":null,"groupName":"bbbb","address":"bbbb","deviceId":null,"sn":null,"owner":null,"deviceType":null,"orderId":null,"eevId":null,"price":null,"number":null,"name":null,"expensesid":null,"epoId":null,"userId":null,"money":null,"createTime":"2016-01-25 00:00:00","preId":null,"serialType":null,"proportion":null,"paramMap":{"perTotalMoney":105,"totalMoney":6378}}],"code":"A00000","msg":""}';
		$arr=url2arr($url,$json);
		return $arr;
	}

	//#########MODEL########################
	public function listVBIncomePerMonth($openid,$groupid,$starttime,$endtime,$pagenum,$pagesize){
		$str='';
		if($groupid){$str=$str.'&groupId='.$groupid;}
		if($starttime){$str=$str.'&startTime='.urlencode($starttime);}
		if($endtime){$str=$str.'&endTime='.urlencode($endtime);}
		if($pagenum){$str=$str.'&pageNum='.$pagenum;}
		if($pagesize){$str=$str.'&pageSize='.$pagesize;}
		$url=C('javaback').'/VBIncome/listVBIncomePerMonth.action?wechatId='.$openid.$str;
		$json='{"data":[{"id":2,"code":null,"groupName":"bbbb","address":"bbbb","deviceId":null,"sn":null,"owner":null,"deviceType":null,"orderId":null,"eevId":null,"price":null,"number":null,"name":null,"expensesid":null,"epoId":null,"userId":null,"money":null,"createTime":"2016-01-26 00:00:00","preId":null,"serialType":null,"proportion":null,"paramMap":{"perTotalMoney":20,"totalMoney":6378}},{"id":2,"code":null,"groupName":"bbbb","address":"bbbb","deviceId":null,"sn":null,"owner":null,"deviceType":null,"orderId":null,"eevId":null,"price":null,"number":null,"name":null,"expensesid":null,"epoId":null,"userId":null,"money":null,"createTime":"2016-01-25 00:00:00","preId":null,"serialType":null,"proportion":null,"paramMap":{"perTotalMoney":105,"totalMoney":6378}}],"code":"A00000","msg":""}';
		$arr=url2arr($url,$json);
		return $arr;
	}

	//#########MODEL########################
	public function listVBIcomeDeviceByDay($openid,$groupid,$starttime,$endtime,$pagenum,$pagesize){
		$str='';
		if($groupid){$str=$str.'&groupId='.$groupid;}
		if($starttime){$str=$str.'&startTime='.urlencode($starttime);}
		if($endtime){$str=$str.'&endTime='.urlencode($endtime);}
		if($pagenum){$str=$str.'&pageNum='.$pagenum;}
		if($pagesize){$str=$str.'&pageSize='.$pagesize;}
		$url=C('javaback').'/VBIncome/listVBIcomeDeviceByDay.action?wechatId='.$openid.$str;
		$json='{"data":[{"id":2,"code":null,"groupName":"bbbb","address":"bbbb","deviceId":null,"sn":null,"owner":null,"deviceType":null,"orderId":null,"eevId":null,"price":null,"number":null,"name":null,"expensesid":null,"epoId":null,"userId":null,"money":null,"createTime":"2016-01-26 00:00:00","preId":null,"serialType":null,"proportion":null,"paramMap":{"perTotalMoney":20,"totalMoney":6378}},{"id":2,"code":null,"groupName":"bbbb","address":"bbbb","deviceId":null,"sn":null,"owner":null,"deviceType":null,"orderId":null,"eevId":null,"price":null,"number":null,"name":null,"expensesid":null,"epoId":null,"userId":null,"money":null,"createTime":"2016-01-25 00:00:00","preId":null,"serialType":null,"proportion":null,"paramMap":{"perTotalMoney":105,"totalMoney":6378}}],"code":"A00000","msg":""}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	
	//#########MODEL########################
	public function listVBIcomeDeviceByMonth($openid,$groupid,$starttime,$endtime,$pagenum,$pagesize){
		$str='';
		if($groupid){$str=$str.'&groupId='.$groupid;}
		if($starttime){$str=$str.'&startTime='.urlencode($starttime);}
		if($endtime){$str=$str.'&endTime='.urlencode($endtime);}
		if($pagenum){$str=$str.'&pageNum='.$pagenum;}
		if($pagesize){$str=$str.'&pageSize='.$pagesize;}
		$url=C('javaback').'/VBIncome/listVBIcomeDeviceByMonth.action?wechatId='.$openid.$str;
		$json='{"data":[{"id":2,"code":null,"groupName":"bbbb","address":"bbbb","deviceId":null,"sn":null,"owner":null,"deviceType":null,"orderId":null,"eevId":null,"price":null,"number":null,"name":null,"expensesid":null,"epoId":null,"userId":null,"money":null,"createTime":"2016-01-26 00:00:00","preId":null,"serialType":null,"proportion":null,"paramMap":{"perTotalMoney":20,"totalMoney":6378}},{"id":2,"code":null,"groupName":"bbbb","address":"bbbb","deviceId":null,"sn":null,"owner":null,"deviceType":null,"orderId":null,"eevId":null,"price":null,"number":null,"name":null,"expensesid":null,"epoId":null,"userId":null,"money":null,"createTime":"2016-01-25 00:00:00","preId":null,"serialType":null,"proportion":null,"paramMap":{"perTotalMoney":105,"totalMoney":6378}}],"code":"A00000","msg":""}';
		$arr=url2arr($url,$json);
		return $arr;
	}
}
	
?>