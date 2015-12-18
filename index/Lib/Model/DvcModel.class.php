<?php
class DvcModel{
	//###################interface##############
	//http://120.26.80.165/device/checkIsCharging.action?deviceId=26
	//http://120.26.80.165/device/getAll.action?wechatId=ojxMBuJe07gSZDUwp0ZHGHEMHOR8&longitude=124.576464&latitude=31.224494
	//http://120.26.80.165/device/get.action?deviceId=2
	//http://120.26.80.165/device/checkIsOnline.action?deviceId=1
	//http://120.26.80.165/device/getByOwner.action?wechatId=12345
	//http://120.26.80.165/device/getJobDay.action?wechatId=ojxMBuNnkhLCHetxo_hy-D-GEyTY&deviceId=1
	//http://120.26.80.165/device/operate.action?deviceId=9&wechatId=12345&operation=off&timeExp=20:18&dayExp=MON,TUE,WED,THU,SAT,SUN
	//http://120.26.80.165/device/capacity.action?wechatId=ojxMBuNnkhLCHetxo_hy-D-GEyTY&deviceId=9&capacity=2
	//http://120.26.80.165/shareTime/saveShareTime.action?userId=6&deviceId=1&isallDay=true
	//http://120.26.80.165/shareTime/removeShareTime.action?userId=27&deviceId=9
	//http://120.26.80.165/device/removeJob.action?wechatId=12345&deviceId=1
	//http://114.215.209.115/device/getCapacity.action?wechatId=12345&deviceId=1
	//http://114.215.209.115/addDevice.action?wechatId=12345&sn=11111111&longitude&latitude&model=1&address
	//http://120.26.80.165/device/getDeviceBySn.action?sn=4265bb79
	//http://120.26.80.165/device/handOverDevice.action?wechatId=12345&deviceId=100~$groupid,$deviceAscription
	//http://120.26.80.165/device/updateDeviceInfo.action?sn=12345&id=100&sn=111&longitude=111&latitude=111&address=111&version=111&groupid=111&path=111&deviceAscription=111
	//#########MODEL########################
	public function test($id){
		$url='';
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//##################################
	public function checkIsCharging($dvcid){
		$url=C('javaback').'/device/checkIsCharging.action?deviceId='.$dvcid;
		$json='{"data":true,"code":"A00000","msg":"获取充电状态成功！"}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#################################
	public function getAll($openid,$lgtd,$lttd,$mdl){
		if($mdl){$str='&model='.$mdl;}else{$str='';}
		$url=C('javaback').'/device/getAll.action?wechatId='.$openid.'&longitude='.$lgtd.'&latitude='.$lttd.$str;
		$json='{"data":[{"id":9,"owner":6,"sn":"7997a70d","model":1,"city":null,"longitude":"120.208989","latitude":"30.213697","address":"钱龙大厦","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":null,"status":"02","capacity":2,"listShareTime":[{"id":null,"deviceId":9,"startTime":"00:00:00","endTime":"23:59:59","userId":null,"createTime":null,"isEnable":1}],"isOrder":0,"isOwner":1,"version":null,"path":null,"time":null,"week":null}],"code":"A00000","msg":"获取设备列表成功"}';
		$arr=url2arr($url,$json);
		return $arr;
	}

	//################################
	public function get($dvcid){
		$url=C('javaback').'/device/get.action?deviceId='.$dvcid;
		$json='{"data":{"id":9,"owner":14,"sn":"c45d7306","model":1,"city":null,"longitude":"120.208989","latitude":"30.213697","address":"钱龙大厦","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"01","capacity":1,"listShareTime":[{"id":1,"deviceId":9,"startTime":"9:00:00","endTime":"14:00:00","userId":null,"createTime":null},{"id":2,"deviceId":9,"startTime":"10:00:00","endTime":"18:00:00","userId":null,"createTime":null}],"isOrder":null,"version":null,"path":null,"time":"17:10","week":"SAT"},"code":"A00000","msg":"获取设备成功"}';
		$arr=url2arr($url,$json);
		return $arr;
	}

	//###############################
	public function checkIsOnline($dvcid){
		$url=C('javaback').'/device/checkIsOnline.action?deviceId='.$dvcid;
		$json='{"data":true,"code":"A00000","msg":"获取在线状态成功！"}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function getByOwner($openid){
		$url=C('javaback').'/device/getByOwner.action?wechatId='.$openid;
		$json='{"data": [{"id":1,"owner":1,"sn":"001","model":1,"city":null,"longitude":"121.572673","latitude":"31.212916","address":" 我的位 置","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""}, {"id":6,"owner":1,"sn":"006","model":1,"city":null,"longitude":"121.581845","latitude":"31.219382","address":" 汤臣湖庭花园 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""}, {"id":8,"owner":1,"sn":"008","model":1,"city":null,"longitude":"121.506252","latitude":"31.245374","address":" 上海东方明珠电视塔 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""}],"code":"A00000","msg":" 获取设备成功"}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function getJobDay($openid,$dvcid){
		$url=C('javaback').'/device/getJobDay.action?wechatId='.$openid.'&deviceId='.$dvcid;
		$json='{"data":{"time":null,"week":null},"code":"A00000","msg":"操作成功"}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function operate($dvcid,$openid,$oprt,$timeExp,$dayExp){
		$str='';
		if($timeExp){$str=$str.'&timeExp='.$timeExp;}
		if($dayExp){$str=$str.'&dayExp='.$dayExp;}
		$url=C('javaback').'/device/operate.action?deviceId='.$dvcid.'&wechatId='.$openid.'&operation='.$oprt.$str;
		$json='{"data":null,"code":"A00001","msg":"系统错误"}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function capacity($dvcid,$openid,$capacity){
		$url=C('javaback').'/device/capacity.action?deviceId='.$dvcid.'&wechatId='.$openid.'&capacity='.$capacity;
		$json='{"data":null,"code":"A00000","msg":"设备操作成功"}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function saveShareTime($usrid,$dvcid,$isallday){
		$url=C('javaback').'/shareTime/saveShareTime.action?userId='.$usrid.'&deviceId='.$dvcid.'&isallDay='.$isallday;
		$json='{"data":null,"code":"A00000","msg":"保存成功！"}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function removeShareTime($usrid,$dvcid){
		$url=C('javaback').'/shareTime/removeShareTime.action?userId='.$usrid.'&deviceId='.$dvcid;
		$json='{"data":null,"code":"A00000","msg":"保存成功！"}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function removeJob($openid,$dvcid){
		$url=C('javaback').'/device/removeJob.action?wechatId='.$openid.'&deviceId='.$dvcid;
		$json='{"data":null,"code":"A00000","msg":"保存成功！"}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function getCapacity($openid,$dvcid){
		$url=C('javaback').'/device/getCapacity.action?wechatId='.$openid.'&deviceId='.$dvcid;
		$json='{"data":1,"code":"A00000","msg":"OK"}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//http://114.215.209.115/addDevice.action?wechatId=12345&sn=11111111&longitude&latitude

	//#########MODEL########################
	public function addDevice($openid,$sn,$lgtd,$lttd,$address){
		$url=C('javaback').'/device/addDevice.action?wechatId='.$openid.'&sn='.$sn.'&longitude='.$lgtd.'&latitude='.$lttd.'&model=1&address='.$address;
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function getbysn($sn){
		$url=C('javaback').'/device/getDeviceBySn.action?sn='.$sn;
		$json='{"data":{"id":48,"owner":134,"sn":"4265bb79","model":1,"city":null,"longitude":"121.610245","latitude":"31.148668","address":"NO:48","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":null,"battery":null,"status":"02","capacity":2,"listShareTime":[],"user":null,"isOrder":null,"isOwner":null,"version":null,"path":null,"time":null,"week":null,"paramMap":null,"deviceAscription":1},"code":"A00000","msg":"获取设备成功"}';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function handOverDevice($wechatid,$dvcsn,$address,$groupid,$deviceAscription){
		$url=C('javaback').'/device/handOverDevice.action?wechatId='.$wechatid.'&sn='.$dvcsn.'&address='.$address.'&groupId='.$groupid.'&deviceAscription='.$deviceAscription;
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function updateDeviceInfo($dvcid,$owner,$sn,$model,$city,$lgtd,$lttd,$address,$peripheral,$ip,$serverIp,$serverPort,$pic,$battery,$status,$capacity,$listShareTime,$user,$isOrder,$isOwner,$version,$time,$week,$paramMap,$deviceAscription,$groupId,$deviceType){
		$url=C('javaback').'/device/updateDeviceInfo.action?id='.$dvcid.'&owner='.$owner.'&sn='.$sn.'&model='.$model.'&city='.$city.'&longitude='.$lgtd.'&latitude='.$lttd.'&address='.$address.'&peripheral='.$peripheral.'&ip='.$ip.'&serverIp='.$serverIp.'&serverPort='.$serverPort.'&pic='.$pic.'&battery='.$battery.'&status='.$status.'&capacity='.$capacity.'&listShareTime='.$listShareTime.'&user='.$user.'&isOrder='.$isOrder.'&isOwner='.$isOwner.'&version='.$version.'&time='.$time.'&week='.$week.'&paramMap='.$paramMap.'&deviceAscription='.$deviceAscription.'&groupId='.$groupId.'&deviceType='.$deviceType;
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
}
?>