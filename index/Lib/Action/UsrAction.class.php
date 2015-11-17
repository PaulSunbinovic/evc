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

		//-------------直接调试模式，不用内啥
		//session('openid','ojxMBuJe07gSZDUwp0ZHGHEMHOR8');
		
		import('@.SS.SSAction');
		$ss = new SSAction();
		$usrdto=$ss->setss();

		import('@.WX.JssdkAction');
		$jssdk = new JssdkAction(C('appid'), C('appsecret'));
		$signPackage = $jssdk->GetSignPackage();
		$this->assign('spkg',$signPackage);

		//判断是否是车主，查看是否具有预约
		$url=C('javaback').'/order/getLastOrder.action?wechatId='.session('openid');
		if(C('psnvs')==1){
			$json='{"data":{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":2,"totalPrice":null,"createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":1,"statusFinal":true},"code":"A00000","msg":null}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		//如果是庄主的话，就不用体现这个按钮了，因为后面还会提到的
		//判断订单是否正在启用
		//假设正在约的状态
		if($arr['data']['status']===0){
			$isOnOdr=1;
		}else{
			$isOnOdr=0;
		}
		
		$this->assign('isOnOdr',$isOnOdr);
		if($isOnOdr==1){
			//获取这个桩的信息，等下用
			$url=C('javaback').'/device/get.action?deviceId='.$arr['data']['deviceId'];
			if(C('psnvs')==1){
				$json='{"data": {"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":" 龙沟新苑 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"02","capacity":1},"code":"A00000","msg":" 获取设备成功"}';
			}else{
				$json=https_request($url);
			}
			$arr=json_decode($json,true);
			$apntdvco=$arr['data'];
			if($usrdto['user']['id']!=$apntdvco['owner']){
				if($apntdvco['status']==''||$apntdvco['status']=='02'){
					$apntdvco['stts']='off';$status='未充电';
				}else{
					$apntdvco['stts']='on';$status='充电中';
				}
				$this->assign('apntdvco',$apntdvco);
			}else{
				//就看成没有预约
				$isOnOdr=0;
			}
		}
		
		

		//获取庄主信息
		$url=C('javaback').'/device/getByOwner.action?wechatId='.session('openid');
		if(C('psnvs')==1){
			$json='{"data": [{"id":1,"owner":1,"sn":"001","model":1,"city":null,"longitude":"121.572673","latitude":"31.212916","address":" 我的位 置","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""}, {"id":6,"owner":1,"sn":"006","model":1,"city":null,"longitude":"121.581845","latitude":"31.219382","address":" 汤臣湖庭花园 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""}, {"id":8,"owner":1,"sn":"008","model":1,"city":null,"longitude":"121.506252","latitude":"31.245374","address":" 上海东方明珠电视塔 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"01"}],"code":"A00000","msg":" 获取设备成功"}';
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		$arr=json_decode($json,true);
		$dvcls=$arr['data'];
		//判断是否是庄主
		if($dvcls){
			$isDvcOwner=1;
		}else{
			$isDvcOwner=0;
		}

		$dvclsnw=array();

		//根据BOB的意思，我们这里只管第一个桩
		$i=0;
		foreach($dvcls as $dvcv){
			if($i<1){$i=$i+1;}else{break;}
			//由于getByowner里面的状态是有问题的，所以，我们要通过device.getaction的方法来获取某个桩的值
			$url=C('javaback').'/device/get.action?deviceId='.$dvcv['id'];
			if(C('psnvs')==1){
				$json='{"data":{"id":9,"owner":9,"sn":"c45d7306","model":1,"city":null,"longitude":"120.208989","latitude":"30.213697","address":"钱龙大厦","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":null,"status":"02","capacity":2,"listShareTime":[{"id":null,"deviceId":9,"startTime":"00:00:00","endTime":"23:59:59","userId":null,"createTime":2015,"isEnable":null},{"id":null,"deviceId":9,"startTime":"00:00","endTime":"00:00","userId":null,"createTime":2015,"isEnable":null}],"isOrder":0,"version":null,"path":null,"time":null,"week":null},"code":"A00000","msg":"获取设备成功"}';
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
			//#############################
			//同时查看这个桩的定时时间，如果是有设定的话，控件需要变绿，并且有时间显示
			$url=C('javaback').'/device/getJobDay.action?wechatId='.session('openid').'&deviceId='.$dvcv['id'];
			if(C('psnvs')==1){
				$json='{"data":{"time":null,"week":null},"code":"A00000","msg":"操作成功"}';
			}else{
				$json=https_request($url);
			}
			$arr=json_decode($json,true);
			$tm=$arr['data']['time'];
			if($tm){
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

			//添加查看共享时
			if($dvcv['listShareTime']){
				//用starttm来判断是否是半天还是全天
				$starttm=$dvcv['listShareTime'][0]['startTime'];
				$tmls=explode(':',$starttm);
				
				if($tmls[0]=='00'){
					$str='全天';
					$status='allday';
					$color='success';
					$icon='glyphicon glyphicon-certificate';
				}else{
					$str='半天';
					$status='halfday';
					$color='warning';
					$icon='glyphicon glyphicon-adjust';
				}
			
			}else{
				$str='未设置';
				$status='noneday';
				$color='default';
				$icon='glyphicon glyphicon-remove-circle';
			}
			$arr_share=array(
					'str'=>$str,
					'status'=>$status,
					'color'=>$color,
					'icon'=>$icon,
					);
			$dvcv['arr_share']=$arr_share;

			//接下来是需要在进入后查看每个桩的是否在线，不在线直接灰掉
			$url=C('javaback').'/device/checkIsOnline.action?deviceId='.$dvcv['id'];
			if(C('psnvs')==1){
				$json='{"data":false,"code":"A00000","msg":"获取充电状态成功！"}';
			}else{
				$json=https_request($url);
			}
			$arr=json_decode($json,true);
			if($arr['data']==false){
				$disabled='disabled';
			}
			$dvcv['disabled']=$disabled;

			array_push($dvclsnw, $dvcv);
		}
		
		$this->assign('dvcls',$dvclsnw);
		

		
		

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
		$openTime=$_GET['openTime'];
		//默认是关闭预约开关是0，也就不用去管预约的开关，然而1的话就是要管的，要不显示这个开关的
		$data['clsapntswc']=0;
		//##############################################################
		//看看对应的wechatId
		$url=C('javaback').'/user/get.action?wechatId='.$openid;
		if(C('psnvs')==1){
			$json='{"data":{"user":{"id":1,"token":1,"wechatId":"12345","nickName":"王 峰","mobile":"13162951502","macId":"dadadaaf","headImgUrl":"baidu.com","createTime":"2015-09-13 10:37:53","updateTime":"2015-09-13 10:37:53","customer":true,"deviceOwner":false,"installser":false,"admin":false},"userAccount":{"id":1,"userId":1,"balance":990,"point":0,"createTime":"2015-09-13 10:37:54","updateTime":"2015-09-19 23:26:50","version":1},"carList": [{"id":1,"userId":1,"carModelId":1,"carNo":"沪 A11111","isDefault":false,"createTime":"2015-09-19 22:19:36","updateTime":"2015-09-19 22:19:40"}]},"code":"A00000","msg":null}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		//当前用户ID
		$usrid=$arr['data']['user']['id'];
		//##############################################################
		$url=C('javaback').'/order/getLastOrderByDeviceId.action?deviceId='.$dvcid;
		if(C('psnvs')==1){
			$json='{"data":{"id":65,"userId":27,"macId":null,"deviceId":9,"price":null,"startDegree":0,"endDegree":151,"carId":null,"status":6,"totalPrice":25066,"createTime":"2015-11-15 05:52:37","updateTime":"2015-11-15 05:52:41","endTime":"2015-11-15 05:52:41","version":1,"freeFlag":1,"statusFinal":true},"code":"A00000","msg":null}';//
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		$arr=json_decode($json,true);
		//设备预约用户ID
		$apntuserid=$arr['data']['userId'];
		//##############################################################
		//先判断设备是谁的
		$url=C('javaback').'/device/get.action?deviceId='.$dvcid;
		if(C('psnvs')==1){
			$json='{"data":{"id":9,"owner":14,"sn":"c45d7306","model":1,"city":null,"longitude":"120.208989","latitude":"30.213697","address":"钱龙大厦","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"01","capacity":1,"listShareTime":[{"id":1,"deviceId":9,"startTime":"9:00:00","endTime":"14:00:00","userId":null,"createTime":null},{"id":2,"deviceId":9,"startTime":"10:00:00","endTime":"18:00:00","userId":null,"createTime":null}],"isOrder":null,"version":null,"path":null,"time":"17:10","week":"SAT"},"code":"A00000","msg":"获取设备成功"}';//------------时间呢
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		$arr=json_decode($json,true);
		//桩拥有着的id
		$dvcownerid=$arr['data']['owner'];
		//以及设备有没有被预约
		$dvcisodr=$arr['data']['isOrder'];
		//##############################################################
		
		$str='';
		if($tm!=''){
			$data['sttm']=$tm;
			$str='&timeExp='.$tm;
		}
		if($week){
			$str=$str.'&dayExp='.$week;
		}

		
		//咱不搞预约订单了，直接开关
		//
		//这里有个问题，就是如果操作的桩不是自己的，那么肯定是预约的桩，而预约的桩需要先判断是否是约者操作的，毕竟可能这个人几天没换网页，早就不是他约的了，还显示他约的，造成误会，所以要双保险
		//给个状态，关于是否去开关到
		$admitOnOff=1;
		
		if($usrid!=$dvcownerid){
			//不是庄主的，那就是预约的按下来的
			//接下来就要判断是不是预约的人
			//目前只能根据用户最近订单来判断，以后以后再改
			//先根据桩判断谁约了他
			
			
			if($userid==$apntuserid){
				$apntOne=1;
			}else{
				$apntOne=0;
			}

			if($apntOne!=1){
				$admitOnOff=0;
				$data['rslt']='error';
				$data['msg']='您非本庄预约的用户，不能充电';
				//如果不是这个桩的预约用户，又不是桩主，那么这个桩消失算了
				$data['clsapntswc']=1;
			}else{
				//如果真TM是预约的用户那么他要是要关闭的话，如果操作成功就消失算了，PS桩主的话就不用动这个了，不高跌
				if($oprt=='off'){///js需要判断下，如果是关闭还成功了，哪就消失好了，否则还是不管他，让他留着
					//拟消失，如果操作成功的话
					$data['clsapntswc']=1;
				}
			}
			
			
		}else{

			//如果是桩主的话需要判断这个设备是不是已经被约了。。。。
			//说白了就是桩么被约了，约的人不是桩主。。。
			if($dvcisodr==1&&$apntuserid!=$usrid){
				$admitOnOff=0;
				$data['rslt']='error';
				$data['msg']='此桩已经被他人预约';
			}else{
				//是桩主的话如果设定定时的话呢就要顺便先设定下开放时间,其中不存在就算了
				if($tm){
					if($openTime!='noneday'){
						if($openTime=='allday'){$isallDay='true';}else if($openTime=='halfday'){$isallDay='false';}
						//由于臧艺失误需要先选出userid
						
						$url=C('javaback').'/shareTime/saveShareTime.action?userId='.$usrid.'&deviceId='.$dvcid.'&isallDay='.$isallDay;
						if(C('psnvs')==1){
							$json='{"data":null,"code":"A00000","msg":"保存成功！"}';
						}else{
							$json=https_request($url);
						}
						$arr=json_decode($json,true);
						
						if($arr['code']='A00000'){
							//操作成功后查询下当前的状态
							//添加查看共享时段
							
							if($openTime=='halfday'){
								$str='半天';
								$status='halfday';
								$color='warning';
								$icon='glyphicon glyphicon-adjust';
							}else if($openTime=='allday'){
								$str='全天';
								$status='allday';
								$color='success';
								$icon='glyphicon glyphicon-certificate';
							}else{
								$str='未设置';
								$status='noneday';
								$color='default';
								$icon='glyphicon glyphicon-remove-circle';
							}
							$arr_share=array(
									'str'=>$str,
									'status'=>$status,
									'color'=>$color,
									'icon'=>$icon,
									);
							$data['arr_share']=$arr_share;
							$data['rslt_svsharetm']='ok';
						}else{
							$data['rslt_svsharetm']='error';
						}
					}else{

					}
				}
				
			}

			

		}
		if($admitOnOff==1){

			
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
		}
		
		


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
		
		


		//接下来是周一到周末
		////同时查看这个桩的闹铃每周，只有week有用（我时间用timer的接口）
		$url=C('javaback').'/device/getJobDay.action?deviceId='.$dvcid.'&wechatId='.session('openid');
		if(C('psnvs')==1){
			$json='{"data":{"time":null,"week":null},"code":"A00000","msg":"操作成功"}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		if($arr['data']){
			$dayls=explode(',',$arr['data']['week']);
			$str='-';
			for($i=0;$i<count($dayls);$i++){
				if($dayls[$i]=='MON'){
					$str=$str.'1-';
				}else if($dayls[$i]=='TUE'){
					$str=$str.'2-';
				}else if($dayls[$i]=='WED'){
					$str=$str.'3-';
				}else if($dayls[$i]=='THU'){
					$str=$str.'4-';
				}else if($dayls[$i]=='FRI'){
					$str=$str.'5-';
				}else if($dayls[$i]=='SAT'){
					$str=$str.'6-';
				}else if($dayls[$i]=='SUN'){
					$str=$str.'7-';
				}
			}
		}
		$data['dayset']=$str;

		$tm=$arr['data']['time'];		
		if($tm){
			
			$cls_tag='success';
		}else{
			$cls_tag='default';
		}
		$timer=array(
			'cls_tag'=>$cls_tag,
			'tm'=>$tm,
			);
		$data['timer']=$timer;
		

		$url=C('javaback').'/user/get.action?wechatId='.session('openid');
		if(C('psnvs')==1){
			$json='{"data":{"user":{"id":1,"token":1,"wechatId":"12345","nickName":"王 峰","mobile":"13162951502","macId":"dadadaaf","headImgUrl":"baidu.com","createTime":"2015-09-13 10:37:53","updateTime":"2015-09-13 10:37:53","customer":true,"deviceOwner":false,"installser":false,"admin":false},"userAccount":{"id":1,"userId":1,"balance":990,"point":0,"createTime":"2015-09-13 10:37:54","updateTime":"2015-09-19 23:26:50","version":1},"carList": [{"id":1,"userId":1,"carModelId":1,"carNo":"沪 A11111","isDefault":false,"createTime":"2015-09-19 22:19:36","updateTime":"2015-09-19 22:19:40"}]},"code":"A00000","msg":null}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		//添加查看共享时段//XXXXXXXXXXXXXXXXXXX楠哥在改
		$url=C('javaback').'/shareTime/findShareTimeByUserIdAndDeviceId.action?userId='.$arr['data']['user']['id'].'&deviceId='.$dvcid;
		if(C('psnvs')==1){
			$json='{"data":{"sn":"80000001","isorder":0,"deviceId":1},"code":"A00000","msg":"查询成功！"}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		if($arr['data']['shareisall']==0){
			$str='半天';
			$status='halfday';
			$color='warning';
			$icon='glyphicon glyphicon-adjust';
		}else if($arr['data']['shareisall']==1){
			$str='全天';
			$status='allday';
			$color='success';
			$icon='glyphicon glyphicon-certificate';
		}else{
			$str='未设置';
			$status='noneday';
			$color='default';
			$icon='glyphicon glyphicon-remove-circle';
		}
		$data['status']=$status;

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


    public function dochangesharemode(){
    	$dvcid=$_GET['dvcid'];
    	//##############################
    	//先读取现在的状态----桩
    	$url=C('javaback').'/device/get.action?deviceId='.$dvcid;
		if(C('psnvs')==1){
			$json='{"data":{"id":9,"owner":9,"sn":"c45d7306","model":1,"city":null,"longitude":"120.208989","latitude":"30.213697","address":"钱龙大厦","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":null,"status":"02","capacity":2,"listShareTime":[{"id":null,"deviceId":9,"startTime":"00:00:00","endTime":"23:59:59","userId":null,"createTime":2015,"isEnable":null},{"id":null,"deviceId":9,"startTime":"00:00","endTime":"00:00","userId":null,"createTime":2015,"isEnable":null}],"isOrder":0,"version":null,"path":null,"time":null,"week":null},"code":"A00000","msg":"获取设备成功"}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		$dvco=$arr['data'];
		//#######################
		$openid=session('openid');
		//看看对应的wechatId
		$url=C('javaback').'/user/get.action?wechatId='.$openid;
		if(C('psnvs')==1){
			$json='{"data":{"user":{"id":1,"token":1,"wechatId":"12345","nickName":"王 峰","mobile":"13162951502","macId":"dadadaaf","headImgUrl":"baidu.com","createTime":"2015-09-13 10:37:53","updateTime":"2015-09-13 10:37:53","customer":true,"deviceOwner":false,"installser":false,"admin":false},"userAccount":{"id":1,"userId":1,"balance":990,"point":0,"createTime":"2015-09-13 10:37:54","updateTime":"2015-09-19 23:26:50","version":1},"carList": [{"id":1,"userId":1,"carModelId":1,"carNo":"沪 A11111","isDefault":false,"createTime":"2015-09-19 22:19:36","updateTime":"2015-09-19 22:19:40"}]},"code":"A00000","msg":null}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		//当前用户ID
		$usrid=$arr['data']['user']['id'];
		//#######################################
		if($dvco['listShareTime']){
			//用starttm来判断是否是半天还是全天
			$starttm=$dvco['listShareTime'][0]['startTime'];
			$tmls=explode(':',$starttm);
			
			if($tmls[0]=='00'){
				//全天变不设置
				$str='未设置';
				$status='noneday';
				$color='default';
				$icon='glyphicon glyphicon-remove-circle';

				$isallday='';
				$url=C('javaback').'/shareTime/removeShareTime.action?userId='.$usrid.'&deviceId='.$dvcid;
								
			}else{
				//半天变全天
				$str='全天';
				$status='allday';
				$color='success';
				$icon='glyphicon glyphicon-certificate';
				
				$isallday='&isallDay=true';
				$url=C('javaback').'/shareTime/saveShareTime.action?userId='.$usrid.'&deviceId='.$dvcid.$isallday;
			}
		
		}else{
			//未设置变半天
			$str='半天';
			$status='halfday';
			$color='warning';
			$icon='glyphicon glyphicon-adjust';

			$isallday='&isallDay=false';
			$url=C('javaback').'/shareTime/saveShareTime.action?userId='.$usrid.'&deviceId='.$dvcid.$isallday;
		}
		$arr_share=array(
				'str'=>$str,
				'status'=>$status,
				'color'=>$color,
				'icon'=>$icon,
				);
		//###################################################
		
		if(C('psnvs')==1){
			$json='{"data":null,"code":"A00000","msg":"保存成功！"}';
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
		//########################
		$data['arr_share']=$arr_share;
		$this->ajaxReturn($data,'json');
    }

    public function dochangetimer(){
    	$dvcid=$_GET['dvcid'];
    	$openid=session('openid');
    	//##############################
    	//先读取定时状态
    	$url=C('javaback').'/device/getJobDay.action?wechatId='.$openid.'&deviceId='.$dvcid;
		if(C('psnvs')==1){
			$json='{"data":{"time":null,"week":null},"code":"A00000","msg":"操作成功"}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		$jobo=$arr['data'];
		//########################################################
		//有定时，就要去取消
		if($jobo['time']){
			$url=C('javaback').'/device/removeJob.action?wechatId='.$openid.'&deviceId='.$dvcid;
			$color='default';
		}else{
			//没定时，设置成有定时
			$url=C('javaback').'/device/operate.action?deviceId='.$dvcid.'&wechatId='.$openid.'&operation=on&timeExp=22:00&dayExp=MON,TUE,WED,THU,FRI,SAT,SUN';
			$color='success';
		}
		if(C('psnvs')==1){
			$json='{"data":null,"code":"A00000","msg":"保存成功！"}';
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
		//########################
		
		$data['color']=$color;
		$this->ajaxReturn($data,'json');
    }

}