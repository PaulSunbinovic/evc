<?php
// 本类由系统自动生成，仅供测试用途
class UsrAction extends Action {



	
	public function regist(){

		$wechatId=$_GET['openid'];
		$headImgUrl='http://'.str_replace('-gang-','/',$_GET['headimgurl']);
		$nickname=$_GET['nickname'];

		$url=C('javaback').'/carModel/brand.action';
		if(C('psnvs')==1){
			$json='{"data":["TESLA","BYD"],"code":"A00000","msg":null}';
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		$arr=json_decode($json,true);
		$carBrandls=$arr['data'];
		$carBrandlsnw=array();
		foreach ($carBrandls as $carBrandv) {
			
			$arrnw=array(
				'carBrand'=>$carBrandv,
				);
			array_push($carBrandlsnw, $arrnw);
		}
		
		$this->assign('carBrandls',$carBrandlsnw);

		

		$this->assign('wechatId',$wechatId);
		$this->assign('headImgUrl',$headImgUrl);
		$this->assign('nickname',$nickname);
		$this->display('regist');
	}

	public function getcarmodel(){
		$carBrand=$_POST['carBrand'];

		// if($carBrand=='B'){
		// 	$carBrand='BYD';
		// }else if($carBrand=='T'){
		// 	$carBrand='TESLA';
		// }

		$url=C('javaback').'/carModel/brandModel.action?brand='.$carBrand;
		$json=https_request($url);
		$arr=json_decode($json,true);
		$carModells=$arr['data'];
		$str="<option value='0'>选择车型号</option>";
		foreach ($carModells as $carModelv) {
			$tmp=explode('_',$carModelv);
			$str=$str."<option value='".$tmp[1]."'>".$tmp[0]."</option>";
		}
		$data['opts']=$str;
		$this->ajaxReturn($data,'json');
	}

	public function doregist(){
		
		$wechatId=$_GET['wechatId'];
		$headImgUrl=$_GET['headImgUrl'];
		$nickName=$_GET['nickName'];
		$mobile=$_GET['mobile'];
		

		//先验证验证码是否对得上
		$vrfnb=$_GET['vrfnb'];
       
        $vrf=M('vrf');
        $vrfo=$vrf->where("openid='".$wechatId."'")->find();
        if($vrfo['vrfnb']==$vrfnb){
            $url=C('javaback').'/user/init.action';
			$url=$url.'?wechatId='.$wechatId.'&headImgUrl='.$headImgUrl.'&nickName='.$nickName.'&mobile='.$mobile;
			if(C('psnvs')==1){
				$json='{"data":[],"code":"A00000","msg":"注册成功"}';
			}else{
				$json=https_request($url);
			}

			$arr=json_decode($json,true);

			if($arr['code']=='A00000'){
				session('openid',$wechatId);
				$data['rslt']='ok';
			}else{
				$data['rslt']='error';
			}

			$msg=$arr['msg'];

			
			$data['msg']=$msg;
			$data['url']=__URL__.'/'.$_GET['x'];

			$this->ajaxReturn($data,'json');
           
        }else{
           	$data['rslt']='error';
        	$data['msg']='验证码输入错误';
            $this->ajaxReturn($data,'json');
        }

		
	}

	public function usrct(){
		import('@.SS.SSAction');
		$ss = new SSAction();
		$usrdto=$ss->setss();

		import('@.WX.JssdkAction');
		$jssdk = new JssdkAction(C('appid'), C('appsecret'));
		$signPackage = $jssdk->GetSignPackage();
		$this->assign('spkg',$signPackage);

		$url=C('javaback').'/device/getByOwner.action?wechatId='.session('openid');
		if(C('psnvs')==1){
			$json='{"data": [{"id":1,"owner":1,"sn":"001","model":1,"city":null,"longitude":"121.572673","latitude":"31.212916","address":" 我的位 置","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""}, {"id":6,"owner":1,"sn":"006","model":1,"city":null,"longitude":"121.581845","latitude":"31.219382","address":" 汤臣湖庭花园 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""}, {"id":8,"owner":1,"sn":"008","model":1,"city":null,"longitude":"121.506252","latitude":"31.245374","address":" 上海东方明珠电视塔 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"01"}],"code":"A00000","msg":" 获取设备成功"}';
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		$arr=json_decode($json,true);
		$dvcls=$arr['data'];
		$dvclsnw=array();

		//根据BOB的意思，我们这里只管第一个桩
		$i=0;
		foreach($dvcls as $dvcv){
			if($i<1){$i=$i+1;}else{break;}
			//由于getByowner里面的状态是有问题的，所以，我们要通过device.getaction的方法来获取某个桩的值
			$url=C('javaback').'/device/get.action?deviceId='.$dvcv['id'];
			if(C('psnvs')==1){
				$json='{"data": {"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":" 龙沟新苑 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"02","capacity":1},"code":"A00000","msg":" 获取设备成功"}';
			}else{
				$json=https_request($url);
			}
			$arr=json_decode($json,true);
			$dvcv=$arr['data'];
			if($dvcv['status']==''||$dvcv['status']=='02'){
				$dvcv['stts']='off';$status='未充电';
			}else{
				$dvcv['stts']='on';$status='充电中';
			}
			//同时查看这个桩的定时时间，如果是有设定的话，控件需要变绿，并且有时间显示
			$url=C('javaback').'/device/timer.action?deviceId='.$dvcv['id'];
			if(C('psnvs')==1){
				$json='{"data":"2015-12-12 12:12:12","code":"A00000","msg":"获取定时时间成功"}';
			}else{
				$json=https_request($json);
			}
			$arr=json_decode($json,true);
			$tm=$arr['data'];
			if($tm){
				$str=strtotime($tm);
				$tm=date('h:i',$str);
				$cls_tag='success';
			}else{
				$cls_tag='default';
			}
			$timer=array(
				'cls_tag'=>$cls_tag,
				'tm'=>$tm,
				);
			$dvcv['timer']=$timer;

			if($dvcv['capacity']==1){
				$dvcv['fast_slow_charge']='1.5KW';
			}else if($dvcv['capacity']==2){
				$dvcv['fast_slow_charge']='3.5KW';
			}else{
				$dvcv{'fast_slow_charge'}='未设置';
			}
			array_push($dvclsnw, $dvcv);
		}
		
		$this->assign('dvcls',$dvclsnw);
		$this->assign('status',$status);

		import('@.WX.JssdkAction');
		$jssdk = new JssdkAction(C('appid'), C('appsecret'));
		$signPackage = $jssdk->GetSignPackage();
		$this->assign('spkg',$signPackage);

		$this->assign('ttl','个人中心');
		$this->display('usrct');
	}

	public function chongzhi(){
		$this->assign('ttl','充值');
		$this->display('chongzhi');
	}

	public function dochongzhi(){
		$money=$_POST['money'];
		$url=__ROOT__.'/wxpay/example/jsapi.php?money='.$money;
		$data['url']=$url;
		$this->ajaxReturn($data,'json');
	}

	public function doonoffdvc(){
		$dvcid=$_GET['dvcid'];
		$tm=$_GET['tm'];
		$oprt=$_GET['oprt'];
		$week=$_GET['week'];
		$openid=session('openid');

		//为预约订单生成carId，现在取消预约订单，因此也取消了这快的判断
		// $url=C('javaback').'/user/get.action?wechatId='.$openid;
		// if(C('psnvs')==1){
		// 	$json=https_request($url);
		// }else{
		// 	$json='{"data":{"user":{"id":1,"token":1,"wechatId":"12345","nickName":"王 峰","mobile":"13162951502","macId":"dadadaaf","headImgUrl":"baidu.com","createTime":"2015-09-13 10:37:53","updateTime":"2015-09-13 10:37:53","customer":true,"deviceOwner":false,"installser":false,"admin":false},"userAccount":{"id":1,"userId":1,"balance":990,"point":0,"createTime":"2015-09-13 10:37:54","updateTime":"2015-09-19 23:26:50","version":1},"carList": [{"id":1,"userId":1,"carModelId":1,"carNo":"沪 A11111","isDefault":false,"createTime":"2015-09-19 22:19:36","updateTime":"2015-09-19 22:19:40"}]},"code":"A00000","msg":null}';
		// }
		// $arr=json_decode($json,true);
		// //现在就处理他默认的车或者default的车
		// //先存了第一个，然后循环过程中如果发现那个是default的话就break掉
		// $carls=$arr['data']['carList'];
		// for($i=0;$i<count($carls);$i++){
		// 	if($i==0){
		// 		$carid=$carls[$i]['id'];
		// 	}
		// 	if($carls[$i]['isDefault']==true){
		// 		$carid=$carls[$i]['id'];
		// 		break;
		// 	}
		// }

		$str='';
		if($tm!=''){
			$data['sttm']=$tm;
			//现在不确定到底是闹铃模式还是啥，暂时先给个年吧
			$yr_mth_day=date('Y:m:d',time());
			$tm=$yr_mth_day.' '.$tm.':00';
			$tm=str_replace(' ', '+', $tm);//curl无法解析url的，所以要手动把参数改变下
			$str='&timeExp='.$tm;
		}
		if($week){
			$str=$str.'&dayExp='.$week;
		}

		//先预约
		// $url=C('javaback').'/order/appoint.action?wechatId='.session('openid').'&deviceId='.$dvcid.'&carId='.$carid;
		// if(C('psnvs')==1){
		// 	$json='{"data":4,"code":"A01408","msg":"用户余额不足"}';
		// }else{
		// 	$json=https_request($url);
		// }
		// $arr=json_decode($json,true);
		// if($arr['code']=='A00000'){
		// 	$url=C('javaback').'/device/operate.action?deviceId='.$dvcid.'&wechatId='.$openid.'&operation='.$oprt.$str;
		// 	if(C('psnvs')==1){
		// 		$json='{"data":null,"code":"A00000","msg":"系统错误"}';
		// 	}else{
		// 		$json=https_request($url);
		// 	}
		// 	//$json=https_request($url);
		// 	$arr=json_decode($json,true);
		// 	if($arr['code']=='A00000'){
		// 		$data['rslt']='ok';
		// 	}else{
		// 		$data['rslt']='error';
		// 	}
		// 	//logger($dvcid.' '.$arr['msg'],'log/log.txt');
		// 	$data['msg']=$arr['msg'];
		// }else{
		// 	$data['rslt']='error';
		// 	$data['msg']=$arr['msg'];
		// }
		//咱不搞预约订单了，直接开关
		$url=C('javaback').'/device/operate.action?deviceId='.$dvcid.'&wechatId='.$openid.'&operation='.$oprt.$str;
		if(C('psnvs')==1){
			$json='{"data":null,"code":"A00000","msg":"系统错误"}';
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		$arr=json_decode($json,true);
		if($arr['code']=='A00000'){
			$data['rslt']='ok';
		}else{
			$data['rslt']='error';
		}
		//logger($dvcid.' '.$arr['msg'],'log/log.txt');
		$data['msg']=$arr['msg'];

		
		


		$this->ajaxReturn($data,'json');
	}
	
	public function testclc(){
		$this->display('testclc');
	}

	public function fnddvcbydvcid(){
		$dvcid=$_GET['dvcid'];
		$url=C('javaback').'/device/get.action?deviceId='.$dvcid;
		if(C('psnvs')==1){
			$json='{"data": {"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":" 龙沟新苑 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":1},"code":"A00000","msg":" 获取设备成功"}';//------------时间呢
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		$arr=json_decode($json,true);
		$data['dvco']=$arr['data'];
		
		$url=C('javaback').'/device/timer.action?deviceId='.$dvcid;
		if(C('psnvs')==1){
			$json='{"data":"2015-12-12 12:12:12","code":"A00000","msg":"获取定时时间成功"}';
		}else{
			$json=https_request($json);
		}
		$arr=json_decode($json,true);
		$tm=$arr['data'];
		if($tm){
			$str=strtotime($tm);
			$tm=date('h:i',$str);
			$cls_tag='success';
		}else{
			$cls_tag='default';
		}
		$timer=array(
			'cls_tag'=>$cls_tag,
			'tm'=>$tm,
			);
		$data['timer']=$timer;
		$this->ajaxReturn($data,'json');
	}

	public function doChangeCapacity(){
		$dvcid=$_GET['dvcid'];
		$capacity=$_GET['capacity'];
		$openid=session('openid');
		$url=C('javaback').'/device/capacity.action?wechatId='.$openid.'&deviceId='.$dvcid.'&capacity='.$capacity;
		if(C('psnvs')==1){
			$json='{"data":null,"code":"A00000","msg":"设备操作成功"}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		if($arr['code']=='A00000'){
			$data['rslt']='ok';
			if($capacity==1){
				$str='1.5KW';
			}else if($capacity==2){
				$str='3.5KW';
			}else{
				$str='3.5KW';//默认3.5KW
			}
			$data['valueOfCapacity']=$str;
		}else{
			$data['rslt']='error';
		}
		$data['msg']=$arr['msg'];
		$this->ajaxReturn($data,'json');

	}

	public function cancelsttm(){
		$dvcid=$_GET['dvcid'];
		$url=C('javaback').'/device/removeJob.action?wechatId'.session('openid').'&deviceId='.$dvcid;
		if(C('psnvs')==1){
			$json='{"code": “A00000”,"msg": "操作成功","data": null}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		if($arr['code']=='A00000'){
			$data['rslt']='ok';
		}else{
			$data['rslt']='error';
		}
		$data['msg']=$arr['msg'];
		$this->ajaxReturn($data.'json');
	}

	


	//------------------------odrlist
	public function hstr_odr(){//history
		import('@.SS.SSAction');
		$ss = new SSAction();
		$usrdto=$ss->setss();
		$crls=$usrdto['carList'];

		
		
		$crlsnw=array();

		//给car设置些索引，避免接下来2重循环给服务器带来压力
		foreach ($crls as $crv) {
			$crlsnw[$crv['id']]=$crv;
		}

		//订单结果
		$url=C('javaback').'/order/getOrderPage.action?wechatId='.session('openid');
		if(C('psnvs')==1){
			$json='{"data":{"pageNo":0,"currentPage":1,"pageSize":10,"totalCount":12,"pageCount":2,"results":[{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true}]},"code":"A00000","msg":" 获取成功"}';
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		
		$arr=json_decode($json,true);
		$odrls=$arr['data']['results'];


		$pgsz=C('pgsz');
		if($arr['data']['totalCount']<=$pgsz){
			$upstr='已无更多内容';
		}else{
			$upstr='上拉加载更多...';
		}
		$this->assign('upstr',$upstr);

		$odrlsnw=array();
		//today
		$tdy=date('Y-m-d H:i:s',time());
		$tmp=explode('-',$tdy);
		$yr_tdy=$tmp[0];
		foreach ($odrls as $odrv) {
			//根据odr中的dvcid确定桩的信息
			$url=C('javaback').'/device/get.action?deviceId='.$odrv['deviceId'];
			if(C('psnvs')==1){
				$json='{"data": {"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":" 龙沟新苑 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},"code":"A00000","msg":" 获取设备成功"}';
			}else{
				$json=https_request($url);
			}
			//$json=https_request($url);
			
			$arr=json_decode($json,true);
			$odrv['dvcnm']=$arr['data']['address'];
			//根据odr中的crid来判断车的具体信息
			$odrv['cro']=$crlsnw[$odrv['carId']];

			$tmp=explode(' ',$odrv['createTime']);
			$odrv['crttmprx']=$tmp[0];
			$odrv['crttmtl']=$tmp[1];

			if($odrv['statusFinal']==true){
				$odrv['stat']=1;//做掉了
			}else{
				$odrv['stat']=0;//还没做,正在做
			}
			//如果是今年的就不显示年 略去秒
			$tm=strtotime($odrv['createTime']);
			$tmp=explode('-',$odrv['createTime']);
			$yr=$tmp[0];
			if($yr_tdy==$yr){
				$tm=date('m-d H:i',$tm);
			}else{
				$tm=date('Y-m-d H:i',$tm);
			}
			$odrv['createTime']=$tm;

			//如果是今年的就不显示年 略去秒
			if($odrv['endTime']){
				$tm=strtotime($odrv['endTime']);
				$tmp=explode('-',$odrv['endTime']);
				$yr=$tmp[0];
				if($yr_tdy==$yr){
					$tm=date('m-d H:i',$tm);
				}else{
					$tm=date('Y-m-d H:i',$tm);
				}
				$odrv['endTime']=$tm;
			}else{
				$odrv['endTime']='未完成';
			}



			$odrv['json']=json_encode($odrv);
			array_push($odrlsnw, $odrv);
		}

		$this->assign('odrls',$odrlsnw);



		$this->assign('ttl','历史记录');
		$this->display('hstr_odr');
	}
	public function dodnfrsh_odr(){
		$nwpg=$_GET['nwpg'];
		//需要根据当前最后一个订单id来查看后续还有啥更新的接口，这里我回一个没有的信息//一般情况下也用不到的
		$data['rslt']=0;//代表没有更新
		$this->ajaxReturn($data,'json');
	}
	public function doupld_odr(){
		
		//照道理是要根据最近的一个查下去后面的，可能设计到比较复杂的逻辑，这个以后再说
		import('@.SS.SSAction');
		$ss = new SSAction();
		$usrdto=$ss->setss();
		$crls=$usrdto['carList'];
		$crlsnw=array();
		//给car设置些索引，避免接下来2重循环给服务器带来压力
		foreach ($crls as $crv) {
			$crlsnw[$crv['id']]=$crv;
		}

		$nwpg=$_GET['nwpg']+1;
		$url=C('javaback').'/order/getOrderPage.action?wechatId='.session('openid').'&pageNo='.$nwpg;
		if(C('psnvs')==1){
			$json='{"data":{"pageNo":1,"currentPage":2,"pageSize":10,"totalCount":12,"pageCount":2,"results":[{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":"+3","createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true}]},"code":"A00000","msg":" 获取成功"}';
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		$arr=json_decode($json,true);
		$odrls=$arr['data']['results'];
		if(count($odrls)==0){
			$rslt=0;
			$nwpg=$nwpg-1;//发现无法到那一页就要回去
		}else{
			$rslt=1;
			$pgsz=C('pgsz');
			$upstr='上拉加载更多...';
			$odrlsnw=array();
			//today
			$tdy=date('Y-m-d H:i:s',time());
			$tmp=explode('-',$tdy);
			$yr_tdy=$tmp[0];
			foreach ($odrls as $odrv) {
				//根据odr中的dvcid确定桩的信息
				$url=C('javaback').'/device/get.action?deviceId='.$odrv['deviceId'];
				if(C('psnvs')==1){
					$json='{"data": {"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":" 龙沟新苑 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},"code":"A00000","msg":" 获取设备成功"}';
				}else{
					$json=https_request($url);
				}
				//$json=https_request($url);
				
							

				$arr=json_decode($json,true);
				$odrv['dvcnm']=$arr['data']['address'];
				//根据odr中的crid来判断车的具体信息
				$odrv['cro']=$crlsnw[$odrv['carId']];

				$tmp=explode(' ',$odrv['createTime']);
				$odrv['crttmprx']=$tmp[0];
				$odrv['crttmtl']=$tmp[1];

				if($odrv['statusFinal']==true){
					$odrv['stat']=1;//做掉了
				}else{
					$odrv['stat']=0;//还没做
				}
				//如果是今年的就不显示年 略去秒
				$tm=strtotime($odrv['createTime']);
				$tmp=explode('-',$odrv['createTime']);
				$yr=$tmp[0];
				if($yr_tdy==$yr){
					$tm=date('m-d H:i',$tm);
				}else{
					$tm=date('Y-m-d H:i',$tm);
				}
				$odrv['createTime']=$tm;

				//如果是今年的就不显示年 略去秒
				if($odrv['endTime']){
					$tm=strtotime($odrv['endTime']);
					$tmp=explode('-',$odrv['endTime']);
					$yr=$tmp[0];
					if($yr_tdy==$yr){
						$tm=date('m-d H:i',$tm);
					}else{
						$tm=date('Y-m-d H:i',$tm);
					}
					$odrv['endTime']=$tm;
				}else{
					$odrv['endTime']='未完成';
				}
				
				
				array_push($odrlsnw, $odrv);

			}

		}
		$data['odrls']=$odrlsnw;
		$data['nwpg']=$nwpg;
		$data['upstr']=$upstr;
		$data['rslt']=$rslt;//代表没有更新

		$this->ajaxReturn($data,'json');
	}


	//------------------------paylist
	public function hstr_pay(){//history
		
		//订单结果
		$url=C('javaback').'/pay/findUserPaymentOrder.action?wechatId='.session('openid');
		if(C('psnvs')==1){
			$json='{"data":{"pageNo":0,"currentPage":1,"pageSize":10,"totalCount":12,"pageCount":2,"results":[{"id":5,"transactionId":"1234512345123451234512345123451234512345","outTradeNo":"54321","bankType":null,"userId":1,"status":1,"macId":null,"money":1012,"payTime":"2015-09-19 12:00:00","createTime":"2015-09-19 23:23:41","updateTime":"2015-09-19 23:26:44","version":1},{"id":5,"transactionId":"12345","outTradeNo":"54321","bankType":null,"userId":1,"status":1,"macId":null,"money":1000,"payTime":"2015-09-19 12:00:00","createTime":"2015-09-19 23:23:41","updateTime":"2015-09-19 23:26:44","version":1},{"id":5,"transactionId":"12345","outTradeNo":"54321","bankType":null,"userId":1,"status":1,"macId":null,"money":1000,"payTime":"2015-09-19 12:00:00","createTime":"2015-09-19 23:23:41","updateTime":"2015-09-19 23:26:44","version":1},{"id":5,"transactionId":"12345","outTradeNo":"54321","bankType":null,"userId":1,"status":1,"macId":null,"money":1000,"payTime":"2015-09-19 12:00:00","createTime":"2015-09-19 23:23:41","updateTime":"2015-09-19 23:26:44","version":1},{"id":5,"transactionId":"12345","outTradeNo":"54321","bankType":null,"userId":1,"status":1,"macId":null,"money":1000,"payTime":"2015-09-19 12:00:00","createTime":"2015-09-19 23:23:41","updateTime":"2015-09-19 23:26:44","version":1},{"id":5,"transactionId":"12345","outTradeNo":"54321","bankType":null,"userId":1,"status":1,"macId":null,"money":1000,"payTime":"2015-09-19 12:00:00","createTime":"2015-09-19 23:23:41","updateTime":"2015-09-19 23:26:44","version":1},{"id":5,"transactionId":"12345","outTradeNo":"54321","bankType":null,"userId":1,"status":1,"macId":null,"money":1000,"payTime":"2015-09-19 12:00:00","createTime":"2015-09-19 23:23:41","updateTime":"2015-09-19 23:26:44","version":1},{"id":5,"transactionId":"12345","outTradeNo":"54321","bankType":null,"userId":1,"status":1,"macId":null,"money":1000,"payTime":"2015-09-19 12:00:00","createTime":"2015-09-19 23:23:41","updateTime":"2015-09-19 23:26:44","version":1},{"id":5,"transactionId":"12345","outTradeNo":"54321","bankType":null,"userId":1,"status":1,"macId":null,"money":1000,"payTime":"2015-09-19 12:00:00","createTime":"2015-09-19 23:23:41","updateTime":"2015-09-19 23:26:44","version":1},{"id":5,"transactionId":"12345","outTradeNo":"54321","bankType":null,"userId":1,"status":1,"macId":null,"money":1000,"payTime":"2015-09-19 12:00:00","createTime":"2015-09-19 23:23:41","updateTime":"2015-09-19 23:26:44","version":1}]},"code":"A00000","msg":"获取成功"}';
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		
		$arr=json_decode($json,true);
		$payls=$arr['data']['results'];

		$pgsz=C('pgsz');
		if($arr['data']['totalCount']<=$pgsz){
			$upstr='已无更多内容';
		}else{
			$upstr='上拉加载更多...';
		}
		$this->assign('upstr',$upstr);

		$paylsnw=array();
		
		//today
		$tdy=date('Y-m-d H:i:s',time());
		$tmp=explode('-',$tdy);
		$yr_tdy=$tmp[0];
			
		foreach ($payls as $payv) {
			$len=mb_strlen($payv['transactionId'],'utf-8');
			$former=mb_substr($payv['transactionId'], 0,18,'utf-8');
			$tail=mb_substr($payv['transactionId'], 18,($len-18),'utf-8');
			$payv['transactionId']=$former.'<br>'.$tail;
			$payv['money']=round($payv['money']/100,2);

			//如果是今年的就不显示年 略去秒
			$tm=strtotime($payv['createTime']);
			$tmp=explode('-',$payv['createTime']);
			$yr=$tmp[0];
			if($yr_tdy==$yr){
				$tm=date('m-d H:i',$tm);
			}else{
				$tm=date('Y-m-d H:i',$tm);
			}
			$payv['createTime']=$tm;

			array_push($paylsnw, $payv);
		}
		$this->assign('payls',$paylsnw);



		$this->assign('ttl','历史记录');
		$this->display('hstr_pay');
	}
	public function dodnfrsh_pay(){
		$nwpg=$_GET['nwpg'];
		//需要根据当前最后一个订单id来查看后续还有啥更新的接口，这里我回一个没有的信息//一般情况下也用不到的
		$data['rslt']=0;//代表没有更新
		$this->ajaxReturn($data,'json');
	}
	public function doupld_pay(){
		
		

		$nwpg=$_GET['nwpg']+1;
		$url=C('javaback').'/pay/findUserPaymentOrder.action?wechatId='.session('openid').'&pageNum='.$nwpg;
		if(C('psnvs')==1){
			$json='{"data":{"pageNo":0,"currentPage":1,"pageSize":10,"totalCount":12,"pageCount":2,"results":[{"id":5,"transactionId":"12345","outTradeNo":"54321","bankType":null,"userId":1,"status":1,"macId":null,"money":1012,"payTime":"2015-09-19 12:00:00","createTime":"2015-09-19 23:23:41","updateTime":"2015-09-19 23:26:44","version":1},{"id":5,"transactionId":"12345","outTradeNo":"54321","bankType":null,"userId":1,"status":1,"macId":null,"money":1000,"payTime":"2015-09-19 12:00:00","createTime":"2015-09-19 23:23:41","updateTime":"2015-09-19 23:26:44","version":1}]},"code":"A00000","msg":"获取成功"}';
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		$arr=json_decode($json,true);
		$payls=$arr['data']['results'];
		if(count($payls)==0){
			$rslt=0;
			$nwpg=$nwpg-1;//发现无法到那一页就要回去
		}else{
			$rslt=1;
			$pgsz=C('pgsz');
			$upstr='上拉加载更多...';
			$paylsnw=array();
			//today
			$tdy=date('Y-m-d H:i:s',time());
			$tmp=explode('-',$tdy);
			$yr_tdy=$tmp[0];
			foreach ($payls as $payv) {
				//如果是今年的就不显示年 略去秒
				$tm=strtotime($payv['createTime']);
				$tmp=explode('-',$payv['createTime']);
				$yr=$tmp[0];
				if($yr_tdy==$yr){
					$tm=date('m-d H:i',$tm);
				}else{
					$tm=date('Y-m-d H:i',$tm);
				}
				$payv['createTime']=$tm;
				$payv['money']=round($payv['money']/100,2);
				array_push($paylsnw, $payv);
				
			}
		}
		$data['payls']=$paylsnw;
		$data['nwpg']=$nwpg;
		$data['upstr']=$upstr;
		$data['rslt']=$rslt;//代表没有更新
		$this->ajaxReturn($data,'json');
	}
	//账户信息
	public function zhxx(){
		$this->assign('ttl','账户信息');
		$this->display('zhxx');
	}
	//收支信息
	public function shouzhi(){
		$this->assign('ttl','收支信息');
		$this->display('shouzhi');
	}

	public function dotakesample(){
		$url=C('javaback').'/device/get.action?deviceId='.$_GET['dvcid'];
		if(C('psnvs')==1){
			$json='{"data":{"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":" 龙沟新苑 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"01"},"code":"A00000","msg":" 获取设备成功"}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		if($arr['data']['status']=='01'){
			$data['rslt']='on';
		}else if($arr['data']['status']=='02'){
			$data['rslt']='off';
		}else{
			$data['rslt']='skip';
		}
		$this->ajaxReturn($data,'json');
	}


	public function dogetsmsvrf(){
        $usrcp=$_GET['usrcp'];
        $rdmnb=rand(1000,9999);
        $vrf=M('vrf');
        $openid=$_GET['wechatId'];
        $vrfo=$vrf->where("openid='".$openid."'")->find();
        if($vrfo){//有则改之
            $dt=array(
                    'vrfnb'=>$rdmnb,
                );
            $vrf->where('vrfid='.$vrfo['vrfid'])->setField($dt);
        }else{//无则加冕
            $dt=array(
                    'openid'=>$openid,
                    'vrfnb'=>$rdmnb,
                );
            $vrf->data($dt)->add();
        }
        //发送短信有点问题，先跳过
        $this->sendsms($usrcp,array($rdmnb,'5'),"48076");//send过慢造成ajax得到error 不过没事不影响
        //$data['vrfnb']=$rdmnb;
        $this->ajaxReturn($data,'json');//随便返回，其实没东西要返回的，意思一下而已
    }
    public function sendsms($to,$datas,$tempId){
    
         // 初始化REST SDK
        $rest=D('REST');
       
        
         // 发送模板短信
         echo "Sending TemplateSMS to $to <br/>";
         $result = $rest->sendTemplateSMS($to,$datas,$tempId);
         if($result == NULL ) {
             echo "result error!";
             break;
         }
         if($result->statusCode!=0) {
             echo "error code :" . $result->statusCode . "<br>";
             echo "error msg :" . $result->statusMsg . "<br>";
             //TODO 添加错误处理逻辑
         }else{
             echo "Sendind TemplateSMS success!<br/>";
             // 获取返回信息
             $smsmessage = $result->TemplateSMS;
             echo "dateCreated:".$smsmessage->dateCreated."<br/>";
             echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
             //TODO 添加成功处理逻辑
         }
        
    }

}