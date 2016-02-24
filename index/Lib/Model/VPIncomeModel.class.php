<?php
class VPIncomeModel{
	//http://114.215.209.115/VPIncome/listVPIncomePerday.action
	//http://114.215.209.115/VPIncome/listVPIncomePerMonth.action
	//http://114.215.209.115/VPIncome/listVPIcomeDeviceByDay.action
	//http://120.26.80.165/VPIncome/listVPIcomeDeviceByMonth.action

	//#########MODEL########################
	public function test($id){
		$url='';
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//http://114.215.209.115/VPIncome/listVPIncomePerday.action

	//#########MODEL########################
	public function listVPIncomePerday($openid,$dvcid,$starttime,$endtime,$optiontime,$pagenum,$pagesize){
		$str='';
		if($dvcid){$str=$str.'&deviceId='.$dvcid;}
		if($starttime){$str=$str.'&startTime='.urlencode($starttime);}
		if($endtime){$str=$str.'&endTime='.urlencode($endtime);}
		if($optiontime){$str=$str.'&optionTime='.urlencode($optiontime);}
		if($pagenum){$str=$str.'&pageNum='.$pagenum;}
		if($pagesize){$str=$str.'&pageSize='.$pagesize;}
		$url=C('javaback').'/VPIncome/listVPIncomePerday.action?wechatId='.$openid.$str;
		$json='{"data":[{"id":2,"code":null,"groupName":"bbbb","address":"bbbb","deviceId":null,"sn":null,"owner":null,"deviceType":null,"orderId":null,"eevId":null,"price":null,"number":null,"name":null,"expensesid":null,"epoId":null,"userId":null,"money":null,"createTime":"2016-01-26 00:00:00","preId":null,"serialType":null,"proportion":null,"paramMap":{"perTotalMoney":20,"totalMoney":6378}},{"id":2,"code":null,"groupName":"bbbb","address":"bbbb","deviceId":null,"sn":null,"owner":null,"deviceType":null,"orderId":null,"eevId":null,"price":null,"number":null,"name":null,"expensesid":null,"epoId":null,"userId":null,"money":null,"createTime":"2016-01-25 00:00:00","preId":null,"serialType":null,"proportion":null,"paramMap":{"perTotalMoney":105,"totalMoney":6378}}],"code":"A00000","msg":""}';
		$arr=url2arr($url,$json);
		return $arr;
	}

	//#########MODEL########################
	public function listVPIncomePerMonth($openid,$dvcid,$starttime,$endtime,$pagenum,$pagesize){
		$str='';
		if($dvcid){$str=$str.'&deviceId='.$dvcid;}
		if($starttime){$str=$str.'&startTime='.urlencode($starttime);}
		if($endtime){$str=$str.'&endTime='.urlencode($endtime);}
		if($pagenum){$str=$str.'&pageNum='.$pagenum;}
		if($pagesize){$str=$str.'&pageSize='.$pagesize;}
		$url=C('javaback').'/VPIncome/listVPIncomePerMonth.action?wechatId='.$openid.$str;
		$json='{"data":[{"id":2,"code":null,"groupName":"bbbb","address":"bbbb","deviceId":null,"sn":null,"owner":null,"deviceType":null,"orderId":null,"eevId":null,"price":null,"number":null,"name":null,"expensesid":null,"epoId":null,"userId":null,"money":null,"createTime":"2016-01-26 00:00:00","preId":null,"serialType":null,"proportion":null,"paramMap":{"perTotalMoney":20,"totalMoney":6378}},{"id":2,"code":null,"groupName":"bbbb","address":"bbbb","deviceId":null,"sn":null,"owner":null,"deviceType":null,"orderId":null,"eevId":null,"price":null,"number":null,"name":null,"expensesid":null,"epoId":null,"userId":null,"money":null,"createTime":"2016-01-25 00:00:00","preId":null,"serialType":null,"proportion":null,"paramMap":{"perTotalMoney":105,"totalMoney":6378}}],"code":"A00000","msg":""}';
		$arr=url2arr($url,$json);
		return $arr;
	}

	
	
	
}
	
?>