<?php
// 本类由系统自动生成，仅供测试用途
class UsrAction extends Action {

	public function guanzhuwomen(){
		$this->assign('ttl','关注我们，享受充电');
    	$this->display('guanzhuwomen');
	}

	
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
		
		//由于昵称可能会有空格，需要把空格给呵呵哒
		$nickName=str_replace(' ', '+', $nickName);

		//先验证验证码是否对得上
		$vrfnb=$_GET['vrfnb'];
       
        $vrf=M('vrf');
        $vrfo=$vrf->where("openid='".$wechatId."'")->find();
        if($vrfo['vrfnb']==$vrfnb){
            $url=C('javaback').'/user/init.action';
			$url=$url.'?wechatId='.$wechatId.'&headImgUrl='.$headImgUrl.'&nickName='.$nickName.'&mobile='.$mobile.'&wechatVersion='.$wechatVersion;
			if(C('psnvs')==1){
				$json='{"data":[],"code":"A00000","msg":"注册成功"}';
			}else{
				$json=https_request($url);
			}

			$arr=json_decode($json,true);
			if($arr['code']!='A00000'){
				logger('#','log/log_'.date('Y-m-d',time()).'.txt');
				logger('url: '.$url,'log/log_'.date('Y-m-d',time()).'.txt');
				logger('json: '.$json,'log/log_'.date('Y-m-d',time()).'.txt');
			}
			if($arr['code']=='A00000'){
				session('openid',$wechatId);
				$data['rslt']='ok';
			}else if($arr['code']=='A00005'){
				session('openid',$wechatId);
				$data['rslt']='mok';//migrant ok
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
		if($odro['status']===0||$odro['status']===4){
			//######################获取odrid
			$this->assign('odrid',$odro['id']);

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

			//################查看是不是9点
			$hour=date('H',time());
			if($hour<'09'){
				$dvco['enable']='n';
			}else{
				$dvco['enable']='y';
			}

			$this->assign('dvco',$dvco);
		}
		$this->assign('ttl','车主中心');
		$this->display('carmstct');
	}
	//###########################################
	public function gongzhuangmstct(){
		$ss=D('SS');$odr=D('Odr');$dvc=D('Dvc');$usr=D('Usr');$coupon=D('Coupon');

		//############获得openid
		$openid=session('openid');

		//#######
		$sn=$_GET['sn'];
		//如果有sn说明是扫码进来的还没有开启过没有预约过
		//如果没有sn说明已经是开启了（也就是预约了）
		$this->assign('sn',$sn);

		if(!$openid){
			header('location:https://open.weixin.qq.com/connect/oauth2/authorize?appid='.C('appid').'&redirect_uri='.C('HOST').'/oauth2_openid.php&response_type=code&scope=snsapi_base&state=gongzhuangmstct_'.$sn.'&connect_redirect=1#wechat_redirect');
		}

		

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

		
		$this->assign('ttl','车主中心');
		$this->display('gongzhuangmstct');
	}
	//############################
	public function doappointByScan(){
		$odr=D('Odr');$dvc=D('Dvc');

		$sn=$_GET['sn'];
		$openid=session('openid');

		$arr=$odr->appointByScan($sn,$openid);

		if($arr['code']=='A00000'){
						
			$dvcid=$arr['data']['deviceId'];
			$data['dvcid']=$dvcid;

			$odrid=$arr['data']['orderId'];
			$data['odrid']=$odrid;

			//然后就打开opration桩
			$arr=$dvc->operate($dvcid,$openid,'on');
			if($arr['code']=='A00000'){
				$rslt=1;
			}else{
				$rslt=2;
			}
			$data['msg']=$arr['msg'];
		}else{
			$rslt=0;
			$data['msg']=$arr['msg'];
		}

		$data['rslt']=$rslt;
		

		$this->ajaxReturn($data,'json');
	}
	###########
	public function doappointCancelWithScan(){
		$dvc=D('Dvc');$odr=D('Odr');

		$odrid=$_GET['odrid'];$openid=session('openid');

		$arr=$odr->appointCancelWithScan($openid,$odrid);

		if($arr['code']=='A00000'){
			$rslt=1;
		}else{
			$rslt=0;
		}
		$data['rslt']=$rslt;
		$data['msg']=$arr['msg'];

		$this->ajaxReturn($data,'json');
	}
	//#########################################
	public function usrct(){
		$ss=D('SS');$odr=D('Odr');$dvc=D('Dvc');$usr=D('Usr');$coupon=D('Coupon');$grp=D('Group');

		//############获得openid
		$openid=session('openid');

		//#####################查看余额
		$arr_usraccnt=$usr->getUserAccount($openid);
		$balance=floatval($arr_usraccnt['data']['balance']);
		$balance=$balance/100;
		$balance=xiaoshu($balance,2);
		$this->assign('balance',$balance);

		//####################查看优惠券
		$arr_coupon=$coupon->listCoupon($openid);
		$couponls=$arr_coupon['data'];
		$this->assign('couponnumber',count($couponls));
		
		//##########################
		$usrdto=$ss->setss();

		//###########################
		//由于这里的签名涉及到很多数据包括一些json等很多目录，比较复杂，不止一个文件这种比较复杂的东西我宁可使用impport模式
		import('@.WX.JssdkAction');
		$jssdk = new JssdkAction(C('appid'), C('appsecret'));
		$signPackage = $jssdk->GetSignPackage();
		$this->assign('spkg',$signPackage);

		
		//#################################
		//获取桩
		$arr_dvc_owner=$dvc->getByOwner(session('openid'));
		$dvcls=$arr_dvc_owner['data'];
		//#######获取桩id
		$dvcid=$_GET['dvcid'];
		
		//####判断
		//如果是0-1个桩直接进去相应的界面，如果超过2个需要进入到设备选择界面
		if(!$dvcid&&count($dvcls)>1){
			//半路走开
			$this->assign('dvcls',$dvcls);
			$this->assign('ttl','选择操作的设备');
			$this->display('selectdvc');
		}else{
			//处理每个桩的信息
			$dvclsnw=array();
			//根据BOB的意思，我们这里只管第一个桩
			//但是现在有了新情况，由于可能是王商在测试，绑了其他的桩，此时不一定是第一个
			$i=0;
			foreach($dvcls as $dvcv){
				if($dvcid){
					if($dvcv['id']!=$dvcid){
						continue;
					}
				}else{
					if($i<1){$i=$i+1;}else{break;}
				}
				
				//###############################################
				//由于getByowner里面的状态是有问题的，所以，我们要通过device.getaction的方法来获取某个桩的值
				$arr_dvc=$dvc->get($dvcv['id']);
				$dvcv=$arr_dvc['data'];

				$this->assign('dvco',$dvcv);
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
				if($arr_lastodr['data']['freeFlag']===0&&($arr_lastodr['data']['status']===0||$arr_lastodr['data']['status']===4)){
					$onodr='y';
				}else{
					$onodr='n';
				}
				$dvcv['onodr']=$onodr;

				
				//##################################
				//查看充电功率，默认就是1 (low) 否则1 是low 2 是high
				//这里在11月24日更新了接口需要搞上去
				$arr_capacity=$dvc->getCapacity($openid,$dvcv['id']);
				if($arr_capacity['data']===1){
					$dvcv['capacity']=1;
				}else if($arr_capacity['data']===2){
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
			
			//判断是否是分成者
			$arr_interest=$grp->isInterests($openid);
			$this->assign('isInterests',$arr_interest['data']);

			//判断他拥有的庄里头有多少个私桩
			//获取桩
			$arr_dvc_owner=$dvc->getByOwner(session('openid'));
			$dvcls=$arr_dvc_owner['data'];
			$count_private_dvc=0;
			foreach($dvcls as $dvcv){
				if($dvcv['deviceType']==1){$count_private_dvc++;}
			}
			$this->assign('count_private_dvc',$count_private_dvc);

			$this->assign('ttl','个人中心');
			$this->display('usrct');
		}
	}
	//#################开关
	public function doonoff(){
		$dvc=D('Dvc');$odr=D('Odr');

		$dvcid=$_GET['dvcid'];
		$oprt=$_GET['oprt'];
		$openid=session('openid');
		$iscarmst=$_GET['iscarmst'];
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
		if($iscarmst=='y'){
			$data['onodr']='n';
		}else{
			$arr_lastodr=$odr->getLastOrderByDeviceId($dvcid);
			if($arr_lastodr['data']['freeFlag']===0&&($arr_lastodr['data']['status']===0||$arr_lastodr['data']['status']===4)){
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
			//##############根据楠哥要求需要在车主 在充电之前如果小电 要变成大电 
			if($iscarmst=='y'){
				$arr_dvco=$dvc->get($dvcid);
				$dvco=$arr_dvco['data'];
				//由于目前没有好的接口准确检测，现在都是直接触发再说，管他之前是1.5KW 还是3.5KW
				$arr_capacity=$dvc->capacity($dvcid,$openid,'2');
				
			}

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
		if($arr_lastodr['data']['freeFlag']===0&&($arr_lastodr['data']['status']===0||$arr_lastodr['data']['status']===4)){
			$data['onodr']='y';
		}else{
			$data['onodr']='n';
		}
		//#################查看设备当前的状况
		//查看充电情况
		$arr_charge=$dvc->checkIsCharging($dvcid);
		if($arr_charge['data']==true){
			$data['stts']='on';
		}else{
			$data['stts']='off';
		}
		//只有在线和没有被约等情况才能被操作
		if($data['online']=='n'||$data['onodr']=='y'||$data['stts']=='on'){
			$data['rslt']='error';
			if($capacity==2){
				$data['capacity']=1;
			}else{
				$data['capacity']=2;
			}
			if($data['online']=='n'){$data['msg']='设备不在线！';}
			if($data['onodr']=='y'){$data['msg']='设备被预约！';}
			if($data['stts']=='on'){$data['msg']='设备充电中，请关闭开关后再切换！';}
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
		if($arr_lastodr['data']['freeFlag']===0&&($arr_lastodr['data']['status']===0||$arr_lastodr['data']['status']===4)){
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
		//#################################
		if(count($couponls)==0){
			$hascoupon='n';
		}else{
			$hascoupon='y';
		}
		$this->assign('hascoupon',$hascoupon);
		//###########################
		$couponlsnw=array();
		foreach ($couponls as $couponv) {
			$couponv['cValue']=round(floatval($couponv['cValue'])/100,2);
			$shorttm=date('Y-m-d',strtotime($couponv['expireTime']));
			$couponv['expireTime']=$shorttm;
			array_push($couponlsnw,$couponv);
		}

		$this->assign('couponls',$couponlsnw);

		$this->assign('ttl','我的优惠券');
		$this->display('coupon');

	}
	

	

	//###################订单历史列表
	public function hstr_odr(){//history
		$ss=D('SS');$odr=D('Odr');$dvc=D('Dvc');

		$openid=session('openid');
		//########################
		$usrdto=$ss->setss();
		//##############获取订单列表
		$pgnumber=1;
		$pgsize=C('pgsz');
		$startdate='2015-11-01';
		$enddate=date('Y-m-d',time());
		//------如果有传值就算dan，否则就按默认酱紫来：如果有预约的订单就跳转到正在进行的上面去，否则就到已完成
		if($_GET['odrstatus']||$_GET['odrstatus']=='0'){
			$odrstatus=$_GET['odrstatus'];
		}else{
			$arr_odr=$odr->getLastOrder($openid);
			if($arr_odr['data']['status']===4){
				$odrstatus=4;
			}else if($arr_odr['data']['status']===0){
				$odrstatus=0;
			}else{
				$odrstatus=6;
			}
		}
		//##########告诉页面现在看都是些啥订单
		$this->assign('odrstatus',$odrstatus);
		$arr_odrls=$odr->listOrders($openid,$pgnumber,$pgsize,$startdate,$enddate,$odrstatus);
		$odrls=$arr_odrls['data'];
		
		$pgnumber=2;
		$arr_odrls_next=$odr->listOrders($openid,$pgnumber,$pgsize,$startdate,$enddate,$odrstatus);
		if($arr_odrls_next){
			$upstr='已无更多内容';
		}else{
			$upstr='上拉加载更多...';
		}
		$this->assign('upstr',$upstr);


		

		$odrlsnw=array();
		//today
		$yr_tdy=date('Y',time());
		foreach ($odrls as $odrv) {
			//根据odr中的dvcid确定桩的信息
			$arr_dvco=$dvc->get($odrv['deviceId']);
			$odrv['dvcnm']=$arr_dvco['data']['address'];
			//##################得到显示年月
			//如果年份和今年一致
			$tm=strtotime($odrv['createTime']);
			$yr_odr=date('Y',$tm);
			if($yr_odr==$yr_tdy){
				$tm=date('m-d',$tm);
			}else{
				$tm=date('Y-m-d',$tm);	
			}
			
			$odrv['createTime']=$tm;
			//#########################消费结算
			$odrv['totalPrice']=round(floatval($odrv['totalPrice'])/100,2).'元';




			$odrv['json']=json_encode($odrv);
			array_push($odrlsnw, $odrv);
		}

		$this->assign('odrls',$odrlsnw);



		$this->assign('ttl','历史订单记录');
		$this->display('hstr_odr');
	}
	public function dodnfrsh_odr(){
		$nwpg=$_GET['nwpg'];
		//需要根据当前最后一个订单id来查看后续还有啥更新的接口，这里我回一个没有的信息//一般情况下也用不到的
		$data['rslt']='n';//代表没有更新
		$this->ajaxReturn($data,'json');
	}
	public function doupld_odr(){
		$ss=D('SS');$odr=D('Odr');$dvc=D('Dvc');

		$openid=session('openid');
		//照道理是要根据最近的一个查下去后面的，可能设计到比较复杂的逻辑，这个以后再说
		$usrdto=$ss->setss();
		
		//##############获取订单列表
		$pgnumber=$_GET['pgnumber']+1;
		$pgsize=C('pgsz');
		$startdate='2015-11-01';
		$enddate=date('Y-m-d',time());
		//------默认已完成6
		if($_GET['odrstatus']){$odrstatus=$_GET['odrstatus'];}else{$odrstatus='6';}
		$arr_odrls=$odr->listOrders($openid,$pgnumber,$pgsize,$startdate,$enddate,$odrstatus);
		$odrls=$arr_odrls['data'];
		
		//#############看看真的是否是有货（理论上有），还有看看下一页有没有货
		if(count($odrls)==0){
			$rslt='n';
			$pgnumber=$pgnumber-1;//发现无法到那一页就要回去
			$upstr='已无更多内容';
		}else{
			$rslt='y';
			
			$arr_odrls_next=$odr->listOrders($openid,$pgnumber+1,$pgsize,$startdate,$enddate,$odrstatus);
			if($arr_odrls_next){
				$upstr='已无更多内容';
			}else{
				$upstr='上拉加载更多...';
			}
			$odrlsnw=array();
			//##############today
			$yr_tdy=date('Y',time());
			
			foreach ($odrls as $odrv) {
				//根据odr中的dvcid确定桩的信息
				$arr_dvco=$dvc->get($odrv['deviceId']);
				$odrv['dvcnm']=$arr_dvco['data']['address'];

				
				//##################得到显示年月
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
				//###########金额
				$odrv['totalPrice']=round(floatval($odrv['totalPrice'])/100,2);


				array_push($odrlsnw, $odrv);

			}

		}
		$data['odrls']=$odrlsnw;
		$data['pgnumber']=$pgnumber;
		$data['upstr']=$upstr;
		$data['rslt']=$rslt;//代表没有更新

		$this->ajaxReturn($data,'json');
	}
	//##########################
	function payment(){
		$payment=D('Payment');$usr=D('Usr');

		$openid=session('openid');

		//#####################查看余额
		$arr_usraccnt=$usr->getUserAccount($openid);
		$balance=floatval($arr_usraccnt['data']['balance']);
		$balance=$balance/100;
		$balance=round($balance,2);
		$balance=(string)$balance;
		$pos=strpos($balance,'.');
		if($pos==false){
			$balance=$balance.'.00';
		}
		$this->assign('balance',$balance);


		$arr_payment=$payment->findUserPaymentOrder($openid,10,1);
		$paymentls=$arr_payment['data'];

		//#########查看下一页有没有货
		$arr_payment_next=$payment->findUserPaymentOrder($openid,10,2);
		if($arr_payment_next['data']){
			$this->assign('hasnext',1);
		}

		
		$this->assign('paymentls',$paymentls);

		######只有每个月的15和30可以提现
		$ri=date('d',time());
		if($ri=='15'||$ri=='30'){$this->assign('allowtixian',1);}else{$this->assign('allowtixian',0);}

		

		$this->assign('ttl','我的余额');
		$this->display('payment');
	}

	//################
	public function doupld_payment(){
		$payment=D('Payment');		
		//####参数获取
		$openid=session('openid');
		$nwpg=$_GET['nwpg'];
		
		$pg_want=(int)$nwpg+1;


		$arr_payment=$payment->findUserPaymentOrder($openid,10,$pg_want+1);
		$paymentls=$arr_payment['data'];

		if(count($paymentls)!==0){
			$rslt=1;
			$nwpg=$pg_want;
			$arr_payment_next=$payment->findUserPaymentOrder($openid,10,$pg_want+2);
			if($arr_payment_next['data']){
				$hasnext=1;
			}else{
				$hasnext=0;
			}

		}else{
			$rslt=0;
			//$nwpg照旧
			$hasnext=0;//这次都没有，还指望下次?。。。
		}

		//###分配参数
		$data['rslt']=$rslt;
		$data['nwpg']=$nwpg;
		$data['hasnext']=$hasnext;
		$data['paymentls']=$paymentls;

		$this->ajaxReturn($data,'json');
	}

	//################检查是否超时订单
	public function dochecktimeout(){
		$odr=D('Odr');

		$openid=session('openid');
		//##############
		$odrid=$_GET['odrid'];
		$arr_timeout=$odr->checkOrderIsTimeOut($openid,$odrid);
		if($arr_timeout['data']==true){
			$data['timeout']='y';
		}else{
			$data['timeout']='n';
		}
		$this->ajaxReturn($data,'json');
	}
	//################取消订单
	public function docancelapnt(){
		$odr=D('Odr');

		$openid=session('openid');
		//####################
		$odrid=$_GET['odrid'];
		$arr_cancel=$odr->appointCancel($openid,$odrid);
		if($arr_cancel['code']=='A00000'){
			$data['rslt']='ok';
		}else{
			$data['rslt']='error';
		}
		$data['msg']=$arr_cancel['msg'];
		$this->ajaxReturn($data,'json');
		
	}
	//################完成结算
	public function dojiesuan(){
		$odr=D('Odr');

		$openid=session('openid');
		//####################
		$odrid=$_GET['odrid'];
		$arr_jiesuan=$odr->handleOrderById($openid,$odrid);
		if($arr_jiesuan['code']=='A00000'){
			$data['rslt']='ok';
		}else{
			$data['rslt']='error';
		}
		$data['msg']=$arr_cancel['msg'];
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

	

	//###########移交桩

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
    //########
    public function testsentsms(){
    	$to='13567196593';
    	$datas=array('#@1064826900936#evchar',5);
    	$tempId='48076';
    	$this->sendsms($to,$datas,$tempId);
    }
    //#########
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
    //###########绑定桩
	public function binddvc(){
		$ss=D('SS');
		//##处理ss
		$usrdto=$ss->setss();

		//###处理微信
		import('@.WX.JssdkAction');
		$jssdk = new JssdkAction(C('appid'), C('appsecret'));
		$signPackage = $jssdk->GetSignPackage();
		$this->assign('spkg',$signPackage);

		//###跳转
		$this->assign('ttl','绑定设备');
		$this->display('binddvc');
	}
    //#######
    public function dobinddvc(){
    	//#######
    	$dvc=D('Dvc');
		//###获取参数
    	$sn=$_GET['sn'];
    	$lgtd=$_GET['lgtd'];
    	$lttd=$_GET['lttd'];
    	$openid=session('openid');
    	//###########
    	$arr_dvco=$dvc->getbysn($sn);
    	$arr=$dvc->addDevice($openid,$sn,$lgtd,$lttd,$arr_dvco['data']['address']);
    	//#########
    	if($arr['code']=='A00000'){
    		//绑定成功就获取他的dvcid，并存到session里头
    		$arr_dvco=$dvc->getbysn($sn);
    		$dvcid=$arr_dvco['data']['id'];
    		$data['dvcid']=$dvcid;
    		
    		$rslt='1';
    	}else{
    		$rlst='0';
    	}
    	//########
    	$data['rslt']=$rslt;
    	$data['msg']=$arr['msg'];
    	//####
    	$this->ajaxReturn($data,'json');
    }
    //########
    public function handdvc(){
    	//########
    	$dvc=D('Dvc');$grp=D('Group');
    	//#######
    	$dvcid=$_GET['dvcid'];
    	if($dvcid){
    		$arr_dvco=$dvc->get($dvcid);
    		$sn=$arr_dvco['data']['sn'];
    		$arr_dvco=$dvc->getbysn($sn);
    		
    		$this->assign('dvco',$arr_dvco['data']);
    	}
    	//###某个接口from臧艺获得groupls
    	$arr_grp=$grp->selectGroup('','','');
    	$grpls=$arr_grp['data'];
    	$this->assign('grpls',$grpls);


    	$this->assign('str',$str);
    	$this->assign('ttl','移交设备');
		$this->display('handdvc');
    }
    //#######
    public function dofindusrls(){
    	//#######
    	$usr=D('Usr');
		//###获取参数
    	$mobile=$_GET['mobile'];
    	
    	//###########
    	$arr=$usr->getByMoblie($mobile);
    	
    	//#########
    	if($arr['code']=='A00000'){
    		$rslt='1';
    	}else{
    		$rlst='0';
    	}
    	//########
    	$data['rslt']=$rslt;
    	$data['msg']=$arr['msg'];
    	$data['usrls']=$arr['data'];
    	//####
    	$this->ajaxReturn($data,'json');
    }
    //#######
    public function dohanddvc(){
    	//#######
    	$dvc=D('Dvc');
		//###获取参数
    	$wechatid=$_GET['wechatid'];
    	$dvcsn=$_GET['dvcsn'];
    	$address=$_GET['address'];
    	$groupid=$_GET['groupid'];
    	$deviceAscription=$_GET['deviceAscription'];
    	//###########
    	$arr=$dvc->handOverDevice($wechatid,$dvcsn,$address,$groupid,$deviceAscription);
    	
    	//#########
    	if($arr['code']=='A00000'){
    		$rslt='1';
    		
    	}else{
    		$rlst='0';
    	}
    	//########
    	$data['rslt']=$rslt;
    	$data['msg']=$arr['msg'];
    	$data['usrls']=$arr['data'];
    	//####
    	$this->ajaxReturn($data,'json');
    }
    //#######
    public function manager(){
    	$dvc=D('Dvc');

    	$dvcid=$_GET['dvcid'];

    	$arr_dvco=$dvc->get($dvcid);
    	$dvco=$arr_dvco['data'];


    	$this->assign('dvco',$dvco);
    	$this->assign('ttl','管理中心');
		$this->display('manager');
    }
   	//###########绑定桩
	public function mdfdvc(){
		$ss=D('SS');$dvc=D('Dvc');$grp=D('Group');

		$dvcid=$_GET['dvcid'];
		//##########
		$arr_dvco=$dvc->get($dvcid);
		$dvco=$arr_dvco['data'];
		$arr_dvco=$dvc->getbysn($dvco['sn']);
		$dvco=$arr_dvco['data'];
		//$this->assign('dvco',$dvco);

		//###某个接口from臧艺获得groupls
    	$arr_grp=$grp->selectGroup('','','');
    	$grpls=$arr_grp['data'];
    	$this->assign('grpls',$grpls);

		//##处理ss
		$usrdto=$ss->setss();

		//###处理微信
		import('@.WX.JssdkAction');
		$jssdk = new JssdkAction(C('appid'), C('appsecret'));
		$signPackage = $jssdk->GetSignPackage();
		$this->assign('spkg',$signPackage);

		//###跳转
		$this->assign('ttl','修改设备');
		$this->display('mdfdvc');
	}
    //#######
    public function domdfdvc(){
    	//#######
    	$dvc=D('Dvc');
    	
		//###获取参数
		$dvcid=$_GET['dvcid'];
		$owner=$_GET['owner'];
		$sn=$_GET['sn'];
		$model=$_GET['model'];
		$city=$_GET['city'];
		$lgtd=$_GET['lgtd'];
    	$lttd=$_GET['lttd'];
    	$address=$_GET['address'];
    	$peripheral=$_GET['peripheral'];
    	$ip=$_GET['ip'];
    	$serverIp=$_GET['serverIp'];
    	$serverPort=$_GET['serverPort'];
    	$pic=$_GET['pic'];
    	$battery=$_GET['battery'];
    	$status=$_GET['status'];
    	$capacity=$_GET['capacity'];
    	$listShareTime=$_GET['listShareTime'];
    	$user=$_GET['user'];
    	$isOrder=$_GET['isOrder'];
    	$isOwner=$_GET['isOwner'];
    	$version=$_GET['version'];
    	$path=$_GET['path'];
    	$time=$_GET['time'];
    	$week=$_GET['week'];
    	$paramMap=$_GET['paramMap'];
    	$deviceAscription=$_GET['deviceAscription'];
    	$groupId=$_GET['groupId'];
    	$deviceType=$_GET['deviceType'];
    	$newSn=$_GET['newSn'];
    	//###########
    	$arr=$dvc->updateDeviceInfo($dvcid,$owner,$sn,$model,$city,$lgtd,$lttd,$address,$peripheral,$ip,$serverIp,$serverPort,$pic,$battery,$status,$capacity,$listShareTime,$user,$isOrder,$isOwner,$version,$path,$time,$week,$paramMap,$deviceAscription,$groupId,$deviceType,$newSn);
    	
    	//#########
    	if($arr['code']=='A00000'){
    		//更改成功
    		$rslt='1';
    	}else{
    		$rlst='0';
    	}
    	//########
    	$data['rslt']=$rslt;
    	$data['msg']=$arr['msg'];
    	//####
    	$this->ajaxReturn($data,'json');
    }
    //#######
    public function dochangedvc(){
    	//#######
    	$dvc=D('Dvc');
		//###获取参数
		$sn=$_GET['sn'];
    	
    	//###########
    	$arr=$dvc->getbysn($sn);


    	
    	//#########
    	if($arr['code']=='A00000'){
    		//更改成功
    		$rslt='1';
    		$dvco=$arr['data'];
    		$data['dvco']=$dvco;
    	}else{
    		$rlst='0';
    	}
    	//########
    	$data['rslt']=$rslt;
    	$data['msg']=$arr['msg'];
    	//####
    	$this->ajaxReturn($data,'json');
    }
    //#########
    public function mdfusr(){
    	$this->assign('ttl','修改用户');
    	$this->display('mdfusr');
    }
    //#######
    public function dogetusro(){
    	$usr=D('Usr');
    	//####
    	$wechatid=$_GET['wechatid'];
    	//#####
    	$arr=$usr->get($wechatid);

    	if($arr['code']=='A00000'){
			$rslt=1;
    		$usro=$arr['data']['user'];
	    	$data['usro']=$usro;
	    	//####把用不着的数据进行整合
	    	//除外
	    	$arr_except=array();
	    	array_push($arr_except,'realName');
	    	
	    	$str=arr2strforjavascript($usro,$arr_except);
	    	$data['para']=$str;
    	}else{
    		$rslt=0;
    	}
    	$data['rslt']=$rslt;


    	
    	//###
    	$this->ajaxReturn($data,'json');

    }
    //#####
    public function domdfusr(){
    	$usr=D('Usr');

    	$realName=$_GET['realName'];
    	$para=$_GET['para'];

    	$para=$para.'&realName='.$realName;

    	$arr=$usr->changeUser($para);
    	if($arr['code']=='A00000'){
    		$rslt=1;
    	}else{
    		$rslt=0;
    	}

    	$data['rslt']=$rslt;
    	$data['msg']=$arr['msg'];
    	$this->ajaxReturn($data,'json');
    }

    public function dogetbalance(){
    	$usr=D('Usr');
    	$openid=$_GET['openid'];

    	$arr_usraccnt=$usr->getUserAccount($openid);
		$data['balance']=$arr_usraccnt['data']['balance'];
		$data['host']=C('HOST');

		$this->ajaxReturn($data,'json');
    
    }
    ###########收益显示
    public function shouyidisplay(){
    	header("Content-Type:text/html; charset=utf-8");
    	$usr=D('Usr');$grp=D('Group');$vbpi=D('VBPIncome');

    	$openid=session('openid');
    	$arr_usro=$usr->get($openid);
    	$usro=$arr_usro['data']['user'];
    	$this->assign('usro',$usro);
    	
    	//获取昨日收益和总收益
    	$arr_money=$grp->countMoney($openid);
    	$yestoday=number_format($arr_money['data']['yesterday'], 2, '.', '');
    	$total=number_format($arr_money['data']['total'], 2, '.', '');
    	$this->assign('yestoday',$yestoday);
    	$this->assign('total',$total);

    	//获取近一周的收益
    	$tm_today=time();
    	$tm_sevendaysago=$tm_today-6*24*60*60;
    	$starttime=date('Y-m-d',$tm_sevendaysago);
    	$endtime=date('Y-m-d',$tm_today);
    	$arr_vbpi=$vbpi->listVBPIncomePerday($openid,$starttime,$endtime);
    	$vbpils=$arr_vbpi['data'];
    	//由于如果没有收益当天，明慧就不传信息过来，所以需要一个判断
    	$arr=array();
    	for($i=0;$i<7;$i++){
    		$tm=$tm_sevendaysago+$i*24*60*60;
    		$data['tm']=date('m-d',$tm);
    		$tm_str=date('Y-m-d',$tm);
    		$flag=0;
    		foreach($vbpils as $vbpiv){
    			//萃取createTime
    			if($tm_str==date('Y-m-d',strtotime($vbpiv['createTime']))){
    				//说明遍历到了
    				$flag=1;
    				$money=$vbpiv['paramMap']['chartPerTotalMoney'];
    				$data['money']=xiaoshu($money/100,2);
    			}
    		}
    		if($flag==0){$data['money']='0.00';}
    		array_push($arr,$data);
    	}
    	$this->assign('shouyils',$arr);

    	//我的充电站集合
    	$arr_gdls=$grp->selectListGroupByUser($openid);
    	$gdls=$arr_gdls['data'];
    	$this->assign('gdls',$gdls);

    	$this->assign('ttl',$usro['nickName']);
    	$this->display('shouyidisplay');
    }

    #################
    public function shouyi_everyday(){
    	header("Content-Type:text/html; charset=utf-8");
    	$grp=D('Group');$vbi=D('VBIncome');$vpi=D('VPIncome');$dvc=D('Dvc');

    	$gdid=$_GET['gdid'];$this->assign('gdid',$gdid);
    	$openid=session('openid');

    	$type=$_GET['type'];$this->assign('type',$type);

    	if($type==0){
	    	//寻找grpo
	    	$arr_grpls=$grp->selectGroup($gdid);
	    	$gdo=$arr_grpls['data'][0];
	    	$ttl=$gdo['groupName'];
	    }else if($type==1){
	    	$arr_dvco=$dvc->get($gdid);$gdo=$arr_dvco['data'];
	    	$ttl=$gdo['deviceName'];
	    }
	    $this->assign('gdo',$gdo);

    	//每日收益
    	//获取到今日，起始日暂定是公司起始日把，就2016年2月1日好了
    	$starttime='2015-01-01';$endtime=date('Y-m-d',time());
    	if($type==1){
    		//私桩
    		$arr=$vpi->listVPIncomePerday($openid,$gdid,$starttime,$endtime,'',1,10);
    	}else{
    		//公桩
    		$arr=$vbi->listVBIncomePerday($openid,$gdid,$starttime,$endtime,'',1,10);
    	}
    	
    	$shouyi_everyday_ls=$arr['data'];
    	$arr_nw=array();
    	foreach($shouyi_everyday_ls as $shouyi_everyday_v){
    		//处理时间
    		$tm=strtotime($shouyi_everyday_v['createTime']);
    		$tm=date('Y-m-d',$tm);
    		$shouyi_everyday_v['time']=$tm;
    		$money=$shouyi_everyday_v['paramMap']['perTotalMoney'];
    		$money=xiaoshu($money/100,2);
    		$shouyi_everyday_v['money']=$money;
    		array_push($arr_nw,$shouyi_everyday_v);
    	}
    	$this->assign('shouyi_everyday_ls',$arr_nw);
    	//#########查看下一页有没有货
    	if($type==1){
    		//私桩
    		$arr_next=$vpi->listVPIncomePerday($openid,$gdid,$starttime,$endtime,'',2,10);
    	}else{
    		//公桩
    		$arr_next=$vbi->listVBIncomePerday($openid,$gdid,$starttime,$endtime,'',2,10);
    	}
		
		if($arr_next['data']){
			$this->assign('hasnext',1);
		}

    	$this->assign('ttl',$ttl);
    	$this->display('shouyi_everyday');
    }

    //################
	public function doupld_shouyi_everyday(){
		$vbi=D('VBIncome');	$vpi=D('VPIncome');	
		//####参数获取
		$openid=session('openid');
		$nwpg=$_GET['nwpg'];
		$gdid=$_GET['gdid'];
		$type=$_GET['type'];
		
		$pg_want=(int)$nwpg+1;


		//每日收益
    	//获取到今日，起始日暂定是公司起始日把，就2016年2月1日好了
    	$starttime='2015-01-01';$endtime=date('Y-m-d',time());
    	if($type==1){
    		//私桩
    		$arr=$vpi->listVPIncomePerday($openid,$gdid,$starttime,$endtime,'',$pg_want+1,10);
    	}else{
    		//公桩
    		$arr=$vbi->listVBIncomePerday($openid,$gdid,$starttime,$endtime,'',$pg_want+1,10);
    	}
    	$shouyi_everyday_ls=$arr['data'];
    	$arr_nw=array();
    	foreach($shouyi_everyday_ls as $shouyi_everyday_v){
    		//处理时间
    		$tm=strtotime($shouyi_everyday_v['createTime']);
    		$tm=date('Y-m-d',$tm);
    		$shouyi_everyday_v['time']=$tm;
    		$money=$shouyi_everyday_v['paramMap']['perTotalMoney'];
    		$money=xiaoshu($money/100,2);
    		$shouyi_everyday_v['money']=$money;
    		array_push($arr_nw,$shouyi_everyday_v);
    	}
    	$shouyi_everyday_ls=$arr_nw;

		if(count($shouyi_everyday_ls)!==0){
			$rslt=1;
			$nwpg=$pg_want;
			if($type==1){
    			//私桩
    			$arr_next=$vpi->listVPIncomePerday($openid,$gdid,$starttime,$endtime,'',$pg_want+2,10);
	    	}else{
	    		//公桩
	    		$arr_next=$vbi->listVBIncomePerday($openid,$gdid,$starttime,$endtime,'',$pg_want+2,10);
	    	}
			if($arr_next['data']){
				$hasnext=1;
			}else{
				$hasnext=0;
			}

		}else{
			$rslt=0;
			//$nwpg照旧
			$hasnext=0;//这次都没有，还指望下次?。。。
		}

		//###分配参数
		$data['rslt']=$rslt;
		$data['nwpg']=$nwpg;
		$data['hasnext']=$hasnext;
		$data['shouyi_everyday_ls']=$shouyi_everyday_ls;

		$this->ajaxReturn($data,'json');
	}

	#################
    public function shouyi_everymonth(){
    	header("Content-Type:text/html; charset=utf-8");
    	$grp=D('Group');$vbi=D('VBIncome');$vpi=D('VPIncome');$dvc=D('Dvc');

    	$gdid=$_GET['gdid'];$this->assign('gdid',$gdid);
    	$openid=session('openid');
    	$type=$_GET['type'];$this->assign('type',$type);
    	//寻找grpo
    	if($type==0){
	    	//寻找grpo
	    	$arr_grpls=$grp->selectGroup($gdid);
	    	$gdo=$arr_grpls['data'][0];
	    	$ttl=$gdo['groupName'];
	    }else if($type==1){
	    	$arr_dvco=$dvc->get($gdid);$gdo=$arr_dvco['data'];
	    	$ttl=$gdo['deviceName'];
	    }
	    $this->assign('gdo',$gdo);
    	

    	//每日收益
    	//获取到今日，起始日暂定是公司起始日把，就2016年2月1日好了
    	$starttime='2015-01-01';$endtime=date('Y-m-d',time());
    	if($type==1){
    		//私桩
    		$arr=$vpi->listVPIncomePerMonth($openid,$gdid,$starttime,$endtime,1,10);
    	}else{
    		//公桩
    		$arr=$vbi->listVBIncomePerMonth($openid,$gdid,$starttime,$endtime,1,10);
    	}
    	$shouyi_everymonth_ls=$arr['data'];
    	$arr_nw=array();
    	foreach($shouyi_everymonth_ls as $shouyi_everymonth_v){
    		$money=$shouyi_everymonth_v['paramMap']['perTotalMoney'];
    		$money=xiaoshu($money/100,2);
    		$shouyi_everymonth_v['money']=$money;
    		array_push($arr_nw,$shouyi_everymonth_v);
    	}
    	$this->assign('shouyi_everymonth_ls',$arr_nw);
    	//#########查看下一页有没有货
		//#########查看下一页有没有货
    	if($type==1){
    		//私桩
    		$arr_next=$vpi->listVPIncomePerMonth($openid,$gdid,$starttime,$endtime,2,10);
    	}else{
    		//公桩
    		$arr_next=$vbi->listVBIncomePerMonth($openid,$gdid,$starttime,$endtime,2,10);
    	}
    	if($arr_next['data']){
			$this->assign('hasnext',1);
		}

    	$this->assign('ttl',$ttl);
    	$this->display('shouyi_everymonth');
    }

    //################
	public function doupld_shouyi_everymonth(){
		$vbi=D('VBIncome');	$vpi=D('VPIncome');	
		//####参数获取
		$openid=session('openid');
		$nwpg=$_GET['nwpg'];
		$gdid=$_GET['gdid'];
		$type=$_GET['type'];
		
		$pg_want=(int)$nwpg+1;


		//每日收益
    	//获取到今日，起始日暂定是公司起始日把，就2016年2月1日好了
    	$starttime='2015-01-01';$endtime=date('Y-m-d',time());
    	if($type==1){
    		//私桩
    		$arr=$vpi->listVPIncomePerMonth($openid,$gdid,$starttime,$endtime,$pg_want+1,10);
    	}else{
    		//公桩
    		$arr=$vbi->listVBIncomePerMonth($openid,$gdid,$starttime,$endtime,$pg_want+1,10);
    	}
    	$shouyi_everymonth_ls=$arr['data'];
    	$arr_nw=array();
    	foreach($shouyi_everymonth_ls as $shouyi_everymonth_v){
    		$money=$shouyi_everymonth_v['paramMap']['perTotalMoney'];
    		$money=xiaoshu($money/100,2);
    		$shouyi_everymonth_v['money']=$money;
    		array_push($arr_nw,$shouyi_everymonth_v);
    	}
    	$shouyi_everymonth_ls=$arr_nw;

		if(count($shouyi_everymonth_ls)!==0){
			$rslt=1;
			$nwpg=$pg_want;
			if($type==1){
	    		//私桩
	    		$arr_next=$vpi->listVPIncomePerMonth($openid,$gdid,$starttime,$endtime,$pg_want+2,10);
	    	}else{
	    		//公桩
	    		$arr_next=$vbi->listVBIncomePerMonth($openid,$grpid,$starttime,$endtime,$pg_want+2,10);
	    	}
			if($arr_next['data']){
				$hasnext=1;
			}else{
				$hasnext=0;
			}

		}else{
			$rslt=0;
			//$nwpg照旧
			$hasnext=0;//这次都没有，还指望下次?。。。
		}

		//###分配参数
		$data['rslt']=$rslt;
		$data['nwpg']=$nwpg;
		$data['hasnext']=$hasnext;
		$data['shouyi_everymonth_ls']=$shouyi_everymonth_ls;

		$this->ajaxReturn($data,'json');
	}

	#################
    public function shouyi_daydevice(){
    	header("Content-Type:text/html; charset=utf-8");
    	$grp=D('Group');$vbi=D('VBIncome');$vpi=D('VPIncome');$dvc=D('Dvc');

    	$gdid=$_GET['gdid'];
    	$type=$_GET['type'];
    	$openid=session('openid');
    	$tm=$_GET['tm'];
    	$this->assign('tm',$tm);

    	//寻找grpo
    	if($type==0){
	    	//寻找grpo
	    	$arr_grpls=$grp->selectGroup($gdid);
	    	$gdo=$arr_grpls['data'][0];
	    	$ttl=$gdo['groupName'];
	    	
	    }else if($type==1){
	    	$arr_dvco=$dvc->get($gdid);$gdo=$arr_dvco['data'];
	    	$ttl=$gdo['deviceName'];
	    }
	    $this->assign('gdo',$gdo);
    	

    	//先看当日的收益
    	if($type==0){
	    	$arr=$vbi->listVBIncomePerday($openid,$gdid,$tm,$tm,'',1,10);
	    }else if($type==1){
	    	$arr=$vpi->listVPIncomePerday($openid,$gdid,$tm,$tm,'',1,10);
	    	
	    }
    	$money=$arr['data'][0]['paramMap']['perTotalMoney'];
    	$money=xiaoshu($money/100,2);
    	$this->assign('money',$money);


    	//某日某组的每个桩的收益情况
    	if($type==0){
	    	$arr=$vbi->listVBIcomeDeviceByDay($openid,$gdid,$tm,$tm,1,100);
	    }else if($type==1){
	    	$arr=$vpi->listVPIncomePerday($openid,$gdid,$tm,$tm,'',1,10);
	    	
	    }
    	
    	$shouyils=$arr['data'];
    	$arr_nw=array();
    	foreach($shouyils as $shouyiv){
    		//获取桩的信息
    		if($shouyiv['deviceId']){$dvcid=$shouyiv['deviceId'];}else{$dvcid=$shouyiv['id'];}
    		$arr_dvco=$dvc->get($dvcid);
    		$shouyiv['dvco']=$arr_dvco['data'];
    		//处理度数
    		$dushu=$shouyiv['paramMap']['perTotalNumber'];
    		$shouyiv['dgr']=xiaoshu($dushu,2);
    		//处理电费
    		$money=$shouyiv['paramMap']['degreeValue'];
    		$money=xiaoshu($money/100,2);
    		$shouyiv['dgr_money']=$money;
    		//处理服务费
    		$money=$shouyiv['paramMap']['serveValue'];
    		$money=xiaoshu($money/100,2);
    		$shouyiv['svr_money']=$money;
    		//处理总计
    		$money=$shouyiv['paramMap']['perTotalMoney'];
    		$money=xiaoshu($money/100,2);
    		$shouyiv['sum_money']=$money;

    		array_push($arr_nw,$shouyiv);
    	}
    	$this->assign('shouyils',$arr_nw);
    	//#########查看下一页有没有货
		// $arr_next=$vbi->listVBIcomeDeviceByDay($openid,$grpid,$tm,$tm,2,10);
		// if($arr_next['data']){
		// 	$this->assign('hasnext',1);
		// }

    	$this->assign('ttl',$ttl);
    	$this->display('shouyi_daydevice');
    }

    #################
    public function shouyi_monthdevice(){
    	header("Content-Type:text/html; charset=utf-8");
    	$grp=D('Group');$vbi=D('VBIncome');$vpi=D('VPIncome');$dvc=D('Dvc');

    	$gdid=$_GET['gdid'];
    	$type=$_GET['type'];
    	$openid=session('openid');
    	$month=$_GET['month'];
    	$this->assign('month',$month);

    	

    	$tm=strtotime($month);
    	$yr=date('Y',$tm);$mt=date('m',$tm);

    	//计算这个月的起始时间
    	$month_end=array('01'=>'31','02'=>'28','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31',);
    	if($mt=='02'&&$yr%4==0){$end='29';}else{$end=$month_end[$mt];}
    	$starttime=$month.'-01';
    	$endtime=$month.'-'.$end;

    	

    	//寻找grpo
    	if($type==0){
	    	//寻找grpo
	    	$arr_grpls=$grp->selectGroup($gdid);
	    	$gdo=$arr_grpls['data'][0];
	    	$ttl=$gdo['groupName'];
	    	
	    }else if($type==1){
	    	$arr_dvco=$dvc->get($gdid);$gdo=$arr_dvco['data'];
	    	$ttl=$gdo['deviceName'];
	    }
	    $this->assign('gdo',$gdo);

    	//先看当月的收益
    	if($type==0){
	    	$arr=$vbi->listVBIncomePerMonth($openid,$gdid,$starttime,$endtime,1,10);
	    }else if($type==1){
	    	$arr=$vpi->listVPIncomePerMonth($openid,$gdid,$starttime,$endtime,1,10);
	    	
	    }
    	$money=$arr['data'][0]['paramMap']['perTotalMoney'];
    	$money=xiaoshu($money/100,2);
    	$this->assign('money',$money);
    	

    	//某日某组的每个桩的收益情况
    	if($type==0){
	    	$arr=$vbi->listVBIcomeDeviceByMonth($openid,$grpid,$starttime,$endtime,1,100);
	    }else if($type==1){
	    	$arr=$vpi->listVPIncomePerMonth($openid,$gdid,$starttime,$endtime,1,10);
	    	
	    }
    	
    	$shouyils=$arr['data'];
    	$arr_nw=array();
    	foreach($shouyils as $shouyiv){
    		//获取桩的信息
    		if($shouyiv['deviceId']){$dvcid=$shouyiv['deviceId'];}else{$dvcid=$shouyiv['id'];}
    		$shouyiv['dvco']=$arr_dvco['data'];
    		//处理度数
    		$dushu=$shouyiv['paramMap']['perTotalNumber'];
    		$shouyiv['dgr']=xiaoshu($dushu,2);
    		//处理电费
    		$money=$shouyiv['paramMap']['degreeValue'];
    		$money=xiaoshu($money/100,2);
    		$shouyiv['dgr_money']=$money;
    		//处理服务费
    		$money=$shouyiv['paramMap']['serveValue'];
    		$money=xiaoshu($money/100,2);
    		$shouyiv['svr_money']=$money;
    		//处理总计
    		$money=$shouyiv['paramMap']['perTotalMoney'];
    		$money=xiaoshu($money/100,2);
    		$shouyiv['sum_money']=$money;

    		array_push($arr_nw,$shouyiv);
    	}
    	$this->assign('shouyils',$arr_nw);
    	//#########查看下一页有没有货
		// $arr_next=$vbi->listVBIcomeDeviceByDay($openid,$grpid,$tm,$tm,2,10);
		// if($arr_next['data']){
		// 	$this->assign('hasnext',1);
		// }

    	$this->assign('ttl',$ttl);
    	$this->display('shouyi_monthdevice');
    }

    #######
    public function tixian(){
    	$usr=D('Usr');

    	$openid=session('openid');
    	$arr_usro=$usr->get($openid);
    	$usro=$arr_usro['data']['user'];
    	$this->assign('usro',$usro);

    	//#####################查看余额
		$arr_usraccnt=$usr->getUserAccount($openid);
		$balance=floatval($arr_usraccnt['data']['balance']);
		$balance=$balance/100;
		$balance=xiaoshu($balance,2);
		$this->assign('balance',$balance);


    	$this->assign('ttl',$usro['nickName']);
    	$this->display('tixian');

    }

    #######
    public function dotixian(){
    	$with=D('WithdrawRecord');

    	$openid=session('openid');
    	$uname=trim($_GET['uname']);$bankcardno=trim($_GET['bankcardno']);$bankname=trim($_GET['bankname']);$withdrawvalue=$_GET['withdrawvalue']*100;

    	$arr=$with->createWithdrawRecord($uname,$openid,$bankcardno,$bankname,$withdrawvalue);

    	if($arr['code']=='A00000'){$rslt=1;}else{$rslt=0;}
    	$data['rslt']=$rslt;
    	$data['msg']=$arr['msg'];
    	$this->ajaxReturn($data,'json');

    }

    ######
    public function tixiansuccess(){
    	$usr=D('Usr');

    	$openid=session('openid');
    	$arr_usro=$usr->get($openid);
    	$usro=$arr_usro['data']['user'];

    	$this->assign('ttl',$usro['nickName']);
    	$this->display('tixiansuccess');
    }

    
}