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
		
		$url=C('javaback').'/user/init.action';
		
		$dt=$_POST;
		
		$url=$url.'?wechatId='.$dt['wechatId'].'&headImgUrl='.$dt['headImgUrl'].'&nickName='.$dt['nickName'].'&mobile='.$dt['mobile'].'&carBrand='.$dt['carBrand'].'&carModelId='.$dt['carModelId'].'&carNo='.$dt['carNo'];
		

		$json=https_request($url);
		$arr=json_decode($json,true);

		if($arr['code']=='A00000'){
			session('openid',$dt['wechatId']);
		}

		$msg=$arr['msg'];

		
		$data['msg']=$msg;
		$data['url']=__URL__.'/'.$_GET['x'];

		$this->ajaxReturn($data,'json');
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
		foreach($dvcls as $dvcv){
			//由于getByowner里面的状态是有问题的，所以，我们要通过device.getaction的方法来获取某个桩的值
			$url=C('javaback').'/device/get.action?deviceId='.$dvcv['id'];
			if(C('psnvs')==1){
				$json='{"data": {"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":" 龙沟新苑 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"01"},"code":"A00000","msg":" 获取设备成功"}';
			}else{
				$json=https_request($url);
			}
			$arr=json_decode($json,true);
			$dvcv=$arr['data'];
			if($dvcv['status']==''||$dvcv['status']=='02'){
				$dvcv['stts']='off';
			}else{
				$dvcv['stts']='on';
			}
			array_push($dvclsnw, $dvcv);
		}
		//p($dvclsnw);die;
		$this->assign('dvcls',$dvclsnw);

		
		import('@.WX.JssdkAction');
		$jssdk = new JssdkAction(C('appid'), C('appsecret'));
		$signPackage = $jssdk->GetSignPackage();
		$this->assign('spkg',$signPackage);

		$tm=date('Y-m-d H:i:s',time()+60);
		$this->assign('tm',$tm);

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
		$everyday=$_GET['everyday'];
		$openid=session('openid');


		$str='';
		if($tm!=''){
			$tm=$tm.':00';
			$tm=str_replace(' ', '+', $tm);//curl无法解析url的，所以要手动把参数改变下
			$str='&time='.$tm;
		}
		if($everyday){
			$str=$str.'&everyday=1';
		}

		//这里设置一个函数来搞定预约 暂时先空着，假设是没有预约的，可以搞起
		
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

		logger($dvcid.' '.$arr['msg'],'log/log.txt');
		$data['msg']=$arr['msg'];
		


		$this->ajaxReturn($data,'json');
	}
	
	

	public function fnddvcbydvcid(){
		$dvcid=$_GET['dvcid'];
		$url='http://120.26.80.165/device/get.action?deviceId='.$dvcid;
		if(C('psnvs')==1){
			$json='{"data": {"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":" 龙沟新苑 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},"code":"A00000","msg":" 获取设备成功"}';//------------时间呢
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		$arr=json_decode($json,true);
		$data['dvco']=$arr['data'];
		$this->ajaxReturn($data,'json');
	}

	public function dosttm(){
		$optm=$_GET['optm'];//补秒
		$clstm=$_GET['clstm'];
		$dvcid=$_GET['dvcid'];
		$openid=session('openid');
		
		$flg=1;
		$rslt='';
		if($optm){
			$optm=$optm.':00';
			$optm=rplspc($optm);
			$url=C('javaback').'/device/operate.action?deviceId='.$dvcid.'&wechatId='.$openid.'&operation=on&time='.$optm;
			if(C('psnvs')==1){
				$json='{"data":null,"code":"A00001","msg":"系统错误"}';
			}else{
				$json=https_request($url);
			}
			//$json=https_request($url);
			$arr=json_decode($json,true);
			if($arr['code']!='A00000'){
				$flg=0;
				$rlst=$rlst.' '.$arr['msg'];
			}
		}
		if($clstm){
			$clstm=$clstm.':00';
			$clstm=rplspc($clstm);
			$url=C('javaback').'/device/operate.action?deviceId='.$dvcid.'&wechatId='.$openid.'&operation=off&time='.$clstm;
			if(C('psnvs')==1){
				$json='{"data":null,"code":"A00001","msg":"系统错误"}';
			}else{
				$json=https_request($url);
			}
			//$json=https_request($url);
			$arr=json_decode($json,true);
			if($arr['code']!='A00000'){
				$flg=0;
				$rlst=$rlst.' '.$arr['msg'];
			}
		}
		$data['flg']=$flg;
		if($flg==0){
			//失败就啥都别管了，照旧
			
			$data['rslt']=$rlst;
		}else{
			//成功就要考虑到很多
			
			$data['rslt']='设置成功';
		}
		//获取最终的桩的状态
		$url=C('javaback').'/device/get.action?deviceId='.$dvcid;
		if(C('psnvs')==1){
			$json='{"data": {"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":" 龙沟新苑 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},"code":"A00000","msg":" 获取设备成功"}';
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		
		$arr=json_decode($json,true);
		//假设最终状态是启用了----------//怎么看启用了
		$data['fnlstat']=1;

		$this->ajaxReturn($data,'json');
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
		$url=C('javaback').'/http://120.26.80.165/device/get.action?deviceId='.$_GET['dvcid'];
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
}