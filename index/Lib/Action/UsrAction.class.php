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
	//###########################################
	public function carmstct(){
		$ss=D('SS');$odr=D('Odr');$dvc=D('Dvc');$usr=D('Usr');$coupon=D('Coupon');

		//############获得openid
		$openid=session('openid');

		//#####################查看余额
		$arr_usraccnt=$usr->getUserAccount($openid);
		$balance=floatval($arr_usraccnt['data']['balance']);
		$balance=$balance/100;
		$balance=round($balance,2);
		$this->assign('balance',$balance);

		//####################查看优惠券
		$arr_coupon=$coupon->listCoupon($openid);
		$couponls=$arr_coupon['data'];
		$this->assign('couponnumber',count($couponls));
		
		//##########################
		$usrdto=$ss->setss();

		//###################获取预约的桩
		$arr_odro=$odr->getLastOrder($openid);
		$odro=$arr_odro['data'];
		if($odro['status']==0){
			$dvcid=$odro['deviceId'];
			//获取桩的信息
			$arr_dvco=$dvc->get($dvcid);
			$dvco=$arr_dvco['data'];
			//看看这个桩在不在线
			$arr_online=$dvc->checkIsOnline($dvco['id']);
			if($arr_online['data']==true){
				$dvco['online']='y';
			}else{
				$dvco['online']='n';
			}
			//###########################
			//查看充电情况
			$arr_charge=$dvc->checkIsCharging($dvco['id']);
			if($arr_charge['data']==true){
				$dvco['stts']='on';
			}else{
				$dvco['stts']='off';
			}
			
			//#####################################################
			//看看这个桩是不是被约掉了 如果
			//由于对于车主而言，这个桩肯定是被约的，而且是被自己约的，所以，对于车主而言，其实这车不算被别人约了 
			$dvco['onodr']='n';

			$this->assign('dvco',$dvco);
		}
		$this->assign('ttl','车主中心');
		$this->display('carmstct');
	}
	//#########################################
	public function usrct(){
		$ss=D('SS');$odr=D('Odr');$dvc=D('Dvc');$usr=D('Usr');$coupon=D('Coupon');

		//############获得openid
		$openid=session('openid');

		//#####################查看余额
		$arr_usraccnt=$usr->getUserAccount($openid);
		$balance=floatval($arr_usraccnt['data']['balance']);
		$balance=$balance/100;
		$balance=round($balance,2);
		$this->assign('balance',$balance);

		//####################查看优惠券
		$arr_coupon=$coupon->listCoupon($openid);
		$couponls=$arr_coupon['data'];
		$this->assign('couponnumber',count($couponls));
		
		//##########################
		$usrdto=$ss->setss();

		//###########################
		import('@.WX.JssdkAction');
		$jssdk = new JssdkAction(C('appid'), C('appsecret'));
		$signPackage = $jssdk->GetSignPackage();
		$this->assign('spkg',$signPackage);

		
		//#################################
		//获取桩
		$arr_dvc_owner=$dvc->getByOwner(session('openid'));
		$dvcls=$arr_dvc_owner['data'];
		//处理每个桩的信息
		$dvclsnw=array();
		//根据BOB的意思，我们这里只管第一个桩
		$i=0;
		foreach($dvcls as $dvcv){
			if($i<1){$i=$i+1;}else{break;}
			//###############################################
			//由于getByowner里面的状态是有问题的，所以，我们要通过device.getaction的方法来获取某个桩的值
			$arr_dvc=$dvc->get($dvcv['id']);
			$dvcv=$arr_dvc['data'];
			//看看这个桩在不在线
			$arr_online=$dvc->checkIsOnline($dvcv['id']);
			if($arr_online['data']==true){
				$dvcv['online']='y';
			}else{
				$dvcv['online']='n';
			}
			//###########################
			//查看充电情况
			$arr_charge=$dvc->checkIsCharging($dvcv['id']);
			if($arr_charge['data']==true){
				$dvcv['stts']='on';
			}else{
				$dvcv['stts']='off';
			}
			//#####################################################
			//看看这个桩是不是被约掉了 如果 freeflag是0（说明是外面的人约的）且正在被约中（staturs是0，其他都是已经搞定了订单过去了）
			$arr_lastodr=$odr->getLastOrderByDeviceId($dvcv['id']);
			if($arr_lastodr['freeFlag']==0&&$arr_lastodr['data']['status']==0){
				$onodr='y';
			}else{
				$onodr='n';
			}
			$dvcv['onodr']=$onodr;

			
			//##################################
			//查看充电功率，默认就是1 (low) 否则1 是low 2 是high
			if($dvcv['capacity']==1){
				$dvcv['capacity']=1;
			}else if($dvcv['capacity']==2){
				$dvcv['capacity']=2;
			}else{//默认
				$dvcv{'capacity'}=1;
			}
			
			//#############################
			//同时查看这个桩的定时时间，如果是有设定的话，控件需要变绿
			$arr_jobday=$dvc->getJobDay(session('openid'),$dvcv['id']);
			$tm=$arr_jobday['data']['time'];
			if($tm){
				$dvcv['timer']='y';
			}else{
				$dvcv['timer']='n';
			}

			
			//##################################
			//添加查看共享时
			if($dvcv['listShareTime']){
				//用starttm来判断是否是半天还是全天
				$dvcv['share']='y';
			}else{
				$dvcv['share']='n';
			}
			array_push($dvclsnw, $dvcv);
		}
		
		$this->assign('dvcls',$dvclsnw);
		

		$this->assign('ttl','个人中心');
		$this->display('usrct');
	}
	//#################开关
	public function doonoff(){
		$dvc=D('Dvc');$odr=D('Odr');

		$dvcid=$_GET['dvcid'];
		$oprt=$_GET['oprt'];
		$openid=session('openid');
		//##################查看设备在不在线
		//设备在不在线也要考虑
		$arr_online=$dvc->checkIsOnline($dvcid);
		if($arr_online['data']==true){
			$data['online']='y';
		}else{
			$data['online']='n';
		}
		//#####################
		//查看设备是否被约
		//其中如果是车主来开关的话，肯定是他自己约的，所以约别人的桩的参数只能是约别人长n，忽视被约的
		$ignoreapnt=$_GET['ignoreapnt'];
		if($ignoreapnt=='y'){
			$data['onodr']='n';
		}else{
			$arr_lastodr=$odr->getLastOrderByDeviceId($dvcid);
			if($arr_lastodr['freeFlag']==0&&$arr_lastodr['data']['status']==0){
				$data['onodr']='y';
			}else{
				$data['onodr']='n';
			}
		}
		//只有在线和没有被约等情况才能被操作
		if($data['online']=='n'||$data['onodr']=='y'){
			$data['rslt']='error';
			if($oprt=='on'){
				$data['stts']='off';
			}else{
				$data['stts']='on';
			}
			if($data['online']=='n'){$data['msg']='设备不在线！';}
			if($data['onodr']=='y'){$data['msg']='设备被预约！';}
		}else{
			//不如怎样都要告诉应该check的状态 1 应该呈现的stts 2 应该呈现的订单情况
			$arr_oprt=$dvc->operate($dvcid,$openid,$oprt);
			if($arr_oprt['code']=='A00000'){
				//成功的情况下是必然在线的
				$data['rslt']='ok';
				$data['stts']=$oprt;
			}else{
				//失败的情况有可能会因为不在线
				$data['rslt']='error';
				if($oprt=='on'){
					$data['stts']='off';
				}else{
					$data['stts']='on';
				}
				
			}
			$data['msg']=$data['msg'];
		}
		
		
		$this->ajaxReturn($data,'json');
	}
	public function dotakesample(){
		//99%的情况下只有在线才会触发这个
		$dvcid=$_GET['dvcid'];
		$dvc=D('Dvc');
		$arr_dvc=$dvc->checkIsCharging($dvcid);
		
		if($arr_dvc['data']==true){
			$data['stts']='on';
		}else{
			$data['stts']='off';
		}
		$this->ajaxReturn($data,'json');
	}
	//##################功率调整
	public function dochangecapacity(){
		$dvc=D('Dvc');$odr=D('Odr');

		$dvcid=$_GET['dvcid'];
		$capacity=$_GET['capacity'];
		$openid=session('openid');
		//##################查看设备在不在线
		//设备在不在线也要考虑
		$arr_online=$dvc->checkIsOnline($dvcid);
		if($arr_online['data']==true){
			$data['online']='y';
		}else{
			$data['online']='n';
		}
		//#####################
		//查看设备是否被约
		$arr_lastodr=$odr->getLastOrderByDeviceId($dvcid);
		if($arr_lastodr['freeFlag']==0&&$arr_lastodr['data']['status']==0){
			$data['onodr']='y';
		}else{
			$data['onodr']='n';
		}

		//只有在线和没有被约等情况才能被操作
		if($data['online']=='n'||$data['onodr']=='y'){
			$data['rslt']='error';
			if($capacity==2){
				$data['capacity']=1;
			}else{
				$data['capacity']=2;
			}
			if($data['online']=='n'){$data['msg']='设备不在线！';}
			if($data['onodr']=='y'){$data['msg']='设备被预约！';}
		}else{
			//不如怎样都要告诉应该check的状态 
			$arr_capacity=$dvc->capacity($dvcid,$openid,$capacity);
			if($arr_capacity['code']=='A00000'){
				//成功的情况下是必然在线的
				$data['rslt']='ok';
				$data['capacity']=$capacity;
			}else{
				//失败的情况有可能会因为不在线
				$data['rslt']='error';
				if($capacity==2){
					$data['capacity']=1;
				}else{
					$data['capacity']=2;
				}
				
			}
			$data['msg']=$data['msg'];
		}
		
		
		$this->ajaxReturn($data,'json');

	}
	//##################半价电定时调整
	public function dochangetimer(){
		$dvc=D('Dvc');$odr=D('Odr');$usr=D('Usr');

		$dvcid=$_GET['dvcid'];
		$timer=$_GET['timer'];
		$openid=session('openid');
		//##################查看设备在不在线
		//设备在不在线也要考虑
		$arr_online=$dvc->checkIsOnline($dvcid);
		if($arr_online['data']==true){
			$data['online']='y';
		}else{
			$data['online']='n';
		}
		

		//只有在线情况才能被操作
		if($data['online']=='n'){
			$data['rslt']='error';
			if($timer=='y'){
				$data['timer']='n';
			}else{
				$data['timer']='y';
			}
			if($data['online']=='n'){$data['msg']='设备不在线！';}
			
		}else{
			//不如怎样都要告诉应该check的状态 
			//开启半价电定时和关闭半价电定时
			if($timer=='y'){
				$arr_timer=$dvc->operate($dvcid,$openid,'on','22:00','MON,TUE,WED,THU,FRI,SAT,SUN');
			}else{
				$arr_timer=$dvc->removeJob($openid,$dvcid);
			}
			
			if($arr_timer['code']=='A00000'){
				//成功的情况下是必然在线的
				$data['rslt']='ok';
				$data['timer']=$timer;
			}else{
				//失败的情况有可能会因为不在线
				$data['rslt']='error';
				if($timer=='y'){
					$data['timer']='n';
				}else{
					$data['timer']='y';
				}
				
			}
			$data['msg']=$data['msg'];
		}
		
		$this->ajaxReturn($data,'json');

	}
	//##################共享调整
	public function dochangeshare(){
		$dvc=D('Dvc');$odr=D('Odr');$usr=D('Usr');

		$dvcid=$_GET['dvcid'];
		$share=$_GET['share'];
		$openid=session('openid');
		//##################查看设备在不在线
		//设备在不在线也要考虑
		$arr_online=$dvc->checkIsOnline($dvcid);
		if($arr_online['data']==true){
			$data['online']='y';
		}else{
			$data['online']='n';
		}
		//#####################
		//查看设备是否被约
		$arr_lastodr=$odr->getLastOrderByDeviceId($dvcid);
		if($arr_lastodr['freeFlag']==0&&$arr_lastodr['data']['status']==0){
			$data['onodr']='y';
		}else{
			$data['onodr']='n';
		}

		//只有在线和没有被约等情况才能被操作
		if($data['online']=='n'||$data['onodr']=='y'){
			$data['rslt']='error';
			if($share=='y'){
				$data['share']='n';
			}else{
				$data['share']='y';
			}
			if($data['online']=='n'){$data['msg']='设备不在线！';}
			if($data['onodr']=='y'){$data['msg']='设备被预约！';}
		}else{
			//不如怎样都要告诉应该check的状态 
			//开共享和删除共享的接口是不一样的
			$arr_usr=$usr->get($openid);
			if($share=='y'){
				$arr_share=$dvc->saveShareTime($arr_usr['data']['user']['id'],$dvcid,'false');
			}else{
				$arr_share=$dvc->removeShareTime($arr_usr['data']['user']['id'],$dvcid);
			}
			
			if($arr_share['code']=='A00000'){
				//成功的情况下是必然在线的
				$data['rslt']='ok';
				$data['share']=$share;
			}else{
				//失败的情况有可能会因为不在线
				$data['rslt']='error';
				if($share=='y'){
					$data['share']='n';
				}else{
					$data['share']='y';
				}
				
			}
			$data['msg']=$data['msg'];
		}
		
		
		$this->ajaxReturn($data,'json');

	}
	//#######################充值
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
	//############################券相关
	public function coupon(){
		$coupon=D('Coupon');

		$openid=session('openid');
		//##################
		$arr_coupon=$coupon->listCoupon($openid);
		$couponls=$arr_coupon['data'];
		$this->assign('couponls',$couponls);

		$this->assign('ttl','我的优惠券');
		$this->display('coupon');

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

	

	//####################短信
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