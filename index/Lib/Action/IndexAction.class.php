<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {



	public function test(){
		
		logger('BB','log/log1.txt');
		// $fp = fopen('log.txt', 'r');
		// if (!$fp) {
		// echo 'Could not open file somefile.txt';
		// }
		// while ($char = fgetc($fp)) {
		// echo "$char";
		// }
	}


    public function index(){
    	$ss=D('SS');$odr=D('Odr');$dvc=D('Dvc');
    	//###############设置微信
    	import('@.WX.JssdkAction');
		$jssdk = new JssdkAction(C('appid'), C('appsecret'));
		$signPackage = $jssdk->GetSignPackage();
		$this->assign('spkg',$signPackage);
		//设置openid
		$openid=session('openid');
		$usrdto=$ss->setss();

		

		//######设定地图级别
		$lth=$_GET['lth'];
		if($lth==1000){
			$lvl=15;
		}else if($lth==2500){
			$lvl=14;
		}else if($lth==5000){
			$lvl=13;
		}else if($lth==10000){
			$lvl=12;
		}else if($lth=='all'){
			$lvl=11;
		}else{//默认
			$lvl=15;
		}
		$this->assign('lvl',$lvl);
		$this->assign('tbid',C('tbid'));

		//#############查看是否有预约有预约的话可以直接导航，除非他删除预约
		$arr_odro=$odr->getLastOrder($openid);
		$odro=$arr_odro['data'];
		if($odro['status']===0||$odro['status']===4){
			$dvcid_odr=$odro['deviceId'];
			//如果是公桩的话需要给前端提示，这样前端会引导他去公桩的车主中心
			$arr_dvco=$dvc->get($dvcid_odr);
			if($arr_dvco['data']['groupId']){
				$dvcid_odr='gong';
			}
		}else{
			$dvcid_odr='n';
		}
		$this->assign('dvcid_odr',$dvcid_odr);

		$this->display('index');
	}

	

	public function doapnt(){
		$dvc=D('Dvc');$odr=D('Odr');
		$openid=session('openid');
		//########说明：如果注册的，过来的时候肯定自动session注入了，否则是session空空如也，不注入的
		if($openid){
			//###针对注册的童鞋
			//#################获取预约的设备
			if($_GET['tp']=='ok'){//type onekey//一键获取点的话，需要算出最近点，然后产生订单
				
				$arr_dvcls=$dvc->getAll($openid,$_GET['lgtd'],$_GET['lttd']);

				$apntpnt=$arr_dvcls['data'][0];
			}else{//普通的话就需要直接获得装ID根据桩id 来进行
				//...一个GET桩ID的过程我就暂时省去了，反正最终也是获得预约桩的代码
				
				$dvcid=$_GET['tp'];
				$arr_dvco=$dvc->get($dvcid);
				
				$apntpnt=$arr_dvco['data'];
			}
			//设置下点的opentm，之后对于约好后重绘点有用
			if($apntpnt['listShareTime']){
				$starttm=$apntpnt['listShareTime']['startTime'];
				$starttmu=explode(':', $starttm);
				$starttm=$starttmu[0].':'.$starttm[1];
				$endtm=$apntpnt['listShareTime']['endTime'];
				$endtm=explode(':',$endtm);
				$endtm=$endtm[0].':'.$endtm[1];

				$apntpnt['opentm']=$starttm.'-'.$endtm;
			}else{
				$apntpnt['opentm']='';
			}
			$data['apntpnt']=$apntpnt;
			//反正不管是怎样都能拿到预约点
			//#######################进行预约
	    	$arr_odr=$odr->appoint($openid,$apntpnt['id']);
	    	
	   
	   		//###############结果反馈
	   		if($arr_odr['code']=='A00000'){
	   			$data['rslt']='ok';
	   		}else if($arr_odr['code']=='A01407'){
	   			$data['rslt']='moneynotenough';
	   		}else{//其他莫名其妙的错误，可能有这货自己其他地方有约会，还TM来约
	   			$data['rslt']='error';
	   		}
	   		$data['msg']=$arr_odr['msg'];
		}else{
			$url='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx682ad2cc417fe8b9&redirect_uri='.C('HOST').'/oauth2_openid.php&response_type=code&scope=snsapi_base&state=regist#wechat_redirect';
			$data['url']=$url;
			$data['rslt']='norgst';
		}

		
		
    	$this->ajaxReturn($data,'json');
		

		
	}

	function docnclodr(){
		$url='http://120.26.80.165/order/appointCancel.action?id=111';
		if(C('psnvs')==1){
			$json='{"data":null,"code":"A00001","msg":"系统错误"}';
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		$arr=json_decode($json,true);
		$data['msg']=$arr['msg'];
	}

	function dofnddvcls(){//接口失效了
		$dvc=D('Dvc');

		$addr=$_GET['ctt'];
		$arr_dvcls=$dvc->search($addr);
		$data['dvcls']=$arr_dvcls['data'];
		$this->ajaxReturn($data,'json');
	}
	
	function cmnt(){
		$dvcid=$_GET['dvcid'];//要不要增加wechatid来看看是否此wechatid的人赞过了
		$url=C('javaback').'/commnets/getComms.action?deviceId='.$dvcid.'&pageSize=10&pageNum=1&wechatId='.session('openid');
		if(C('psnvs')==1){
			$json='{"data":[{"commId":1,"deviceId":1,"userId":1,"commRefId":null,"content":"这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论","starLevel":1,"commDate":"2015-10-18 19:43:35","approves":null,"isApprove":0},{"commId":1,"deviceId":1,"userId":1,"commRefId":null,"content":"这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论","starLevel":1,"commDate":"2015-10-18 19:43:35","approves":null,"isApprove":0},{"commId":1,"deviceId":1,"userId":1,"commRefId":null,"content":"这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论","starLevel":1,"commDate":"2015-10-18 19:43:35","approves":null,"isApprove":0},{"commId":1,"deviceId":1,"userId":1,"commRefId":null,"content":"这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论","starLevel":1,"commDate":"2015-10-18 19:43:35","approves":null,"isApprove":0},{"commId":1,"deviceId":1,"userId":1,"commRefId":null,"content":"这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论","starLevel":1,"commDate":"2015-10-18 19:43:35","approves":null,"isApprove":0},{"commId":1,"deviceId":1,"userId":1,"commRefId":null,"content":"这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论","starLevel":1,"commDate":"2015-10-18 19:43:35","approves":null,"isApprove":0},{"commId":1,"deviceId":1,"userId":1,"commRefId":null,"content":"这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论","starLevel":1,"commDate":"2015-10-18 19:43:35","approves":null,"isApprove":0},{"commId":1,"deviceId":1,"userId":1,"commRefId":null,"content":"这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论","starLevel":1,"commDate":"2015-10-18 19:43:35","approves":null,"isApprove":0},{"commId":1,"deviceId":1,"userId":1,"commRefId":null,"content":"这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论","starLevel":1,"commDate":"2015-10-18 19:43:35","approves":null,"isApprove":0},{"commId":1,"deviceId":1,"userId":1,"commRefId":null,"content":"这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论这是一个评论","starLevel":1,"commDate":"2015-10-18 19:43:35","approves":null,"isApprove":0}],"code":"A00000","msg":""}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		$cmntls=$arr['data'];

		//看看下一页有没有货
		$url=C('javaback').'/commnets/getComms.action?deviceId='.$dvcid.'&pageSize=10&pageNum=2&wechatId='.session('openid');
		if(C('psnvs')==1){
			$json='{"data":[{"commId":1,"deviceId":1,"userId":1,"commRefId":null,"content":"content","starLevel":1,"commDate":"2015-10-18 19:43:35","approves":null,"isApprove":0}],"code":"A00000","msg":""}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		if($arr['data']){
			
		}


		$cmntlsnw=array();
		foreach ($cmntls as $cmntv) {
			//分析评论的条数，万一为null 则为0
			if(!$cmntv['approves']){
				$cmntv['approves']=0;
			}
			
			//获得发布评论的用户信息
			$usrid=$cmntv['userId'];
			$url=C('javaback').'/user/get.action?userId='.$usrid;
			if(C('psnvs')==1){
				$json='{"data":{"user":{"id":1,"token":1,"wechatId":"12345","nickName":"王 峰","mobile":"13162951502","macId":"dadadaaf","headImgUrl":"baidu.com","createTime":"2015-09-13 10:37:53","updateTime":"2015-09-13 10:37:53","customer":true,"deviceOwner":false,"installser":false,"admin":false},"userAccount":{"id":1,"userId":1,"balance":990,"point":0,"createTime":"2015-09-13 10:37:54","updateTime":"2015-09-19 23:26:50","version":1},"carList": [{"id":1,"userId":1,"carModelId":1,"carNo":"沪 A11111","isDefault":false,"createTime":"2015-09-19 22:19:36","updateTime":"2015-09-19 22:19:40"}]},"code":"A00000","msg":null}';
			}else{
				$json=https_request($url);
			}
			$arr=json_decode($json,true);
			$cmntv['usrnn']=$arr['data']['user']['nickName'];
			array_push($cmntlsnw,$cmntv);
		}
		$this->assign('cmntls',$cmntlsnw);

		//然后是计算设备

		$url=C('javaback').'/device/get.action?deviceId='.$dvcid;
		if(C('psnvs')==1){
			$json='{"data":{"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":" 龙沟新苑 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},"code":"A00000","msg":" 获取设备成功"}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		$dvco=$arr['data'];
		$this->assign('dvco',$dvco);

		$this->assign('ttl',$dvco['address'].'的评论');
		$this->display('cmnt');
	}

	//--------------以下的订单暂时由我们index承担
	function odr(){
		$mtd=$_GET['mtd'];
		$odr=M('odr');
		if($mtd=='add'){
			$openid=$_GET['openid'];
			$odrid=$_GET['odrid'];
			$dt=array(
					'openid'=>$openid,
					'odrid'=>$odrid,
				);
			$odr->data($dt)->add();
		}else if($mtd=='dlt'){
			$openid=$_GET['openid'];
			$odr->where("openid='".$openid."'")->delete();
		}else if($mtd=='get'){
			$openid=$_GET['openid'];
			//只有最近的一个才是真的他要充值的东西，其他的都是半路放弃的
			$odro=$odr->where("openid='".$openid."'")->order('id DESC')->find();
			$odrid=$odro['odrid'];
			echo $odrid;
		}

	}
	function mysqlforrcd(){

		$rcd=M('rcd');

		$out_trade_no=$_GET['out_trade_no'];
		$transaction_id=$_GET['transaction_id'];
		$openid=$_GET['openid'];
		$time_end=$_GET['time_end'];
		$total_fee=$_GET['total_fee'];
		$return_code=$_GET['return_code'];
		//由于交易id是唯一的，所以只要看交易id就OK了
		$rcdo=$rcd->where("out_trade_no='".$out_trade_no."'")->find();
		//没有的话我们就加上去，这样，下次再来看的时候就知道，已经加过了，不用理会了，保证我们只理会一次系统请求
		//因为啊，我们的微信支付成功后，我发现要发好几次请求，这样是不对的，我们只要搞一次就行了，不然会给java后台充好几次值
		//通过我们这样干预，就行了
		if($rcdo){
			$rslt='yes';
		}else{
			$dt=array(
					'out_trade_no'=>$out_trade_no,
					'transaction_id'=>$transaction_id,
					'openid'=>$openid,
					'time_end'=>$time_end,
					'total_fee'=>$total_fee,
					'return_code'=>$return_code,
				);
			$rcd->data($dt)->add();
			$rslt='no';
		}
		echo $rslt;
	}


	function getdvcsharedtl(){
		$dvcid=$_GET['dvcid'];
		$url=C('javaback').'/device/get.action?deviceId='.$dvcid;
		if(C('psnvs')==1){
			$json='{"data":{"id":9,"owner":9,"sn":"c45d7306","model":1,"city":null,"longitude":"120.208989","latitude":"30.213697","address":"钱龙大厦","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":null,"status":"02","capacity":2,"listShareTime":[{"id":null,"deviceId":9,"startTime":"00:00:00","endTime":"23:59:59","userId":null,"createTime":2015,"isEnable":null},{"id":null,"deviceId":9,"startTime":"00:00","endTime":"00:00","userId":null,"createTime":2015,"isEnable":null}],"isOrder":0,"version":null,"path":null,"time":null,"week":null},"code":"A00000","msg":"获取设备成功"}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,true);
		$data['dvco']=$arr['data'];

		$shareo=$arr['data']['listShareTime'][0];

		

		
		if($arr['code']=='A00000'){
			$data['rslt']='ok';
			if($shareo){
				$starttm=$shareo['startTime'];
				$tmls=explode(':',$starttm);
				$tm=$tmls[0];
				if($tm=='00'){
					$str='00:00-24:00';
				}else{
					$str='9:00-14:00';
				}
			}else{
				$str='未设置共享';
			}
			$data['shareTime']=$str;
		}else{
			$data['rslt']='error';
		}
		$data['msg']=$arr['msg'];

		$this->ajaxReturn($data,'json');

	}

}