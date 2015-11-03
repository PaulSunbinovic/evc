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

    	import('@.WX.JssdkAction');
		$jssdk = new JssdkAction(C('appid'), C('appsecret'));
		$signPackage = $jssdk->GetSignPackage();
		$this->assign('spkg',$signPackage);

		// $url="http://api.map.baidu.com/geosearch/v3/nearby?ak=S0VAW4LjQirp9FUmXF08Zvdy&geotable_id=116349&location=120.363991,30.32658&radius=1000";
		// $result=https_request($url);
		// $array=json_decode($result,TRUE);


		// $this->assign('cdzls',$array['contents']);
		// ojxMBuJe07gSZDUwp0ZHGHEMHOR8
		// --------------------------为了有用户进行测试我就牺牲下拿我到微信号来测了
		if(C('psnvs')==1){
			session('openid','12345');
		}else{
			//就跟随微信页面设置的那个
		}
		
		$openid=session('openid');
		import('@.SS.SSAction');
		$ss = new SSAction();
		$usrdto=$ss->setss();

		


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

		$this->display('index');
	}

	

	public function doapnt(){

		if($_GET['tp']=='ok'){//type onekey//一键获取点的话，需要算出最近点，然后产生订单
			//到时看马哥是不是给算出最近的点，我现在先假定我已经得到了
			// $mstnr='{"id":4,"owner":2,"sn":"004","model":1,"city":null,"longitude":"121.570077","latitude":"31.219745","address":"上海浦东嘉里大酒店桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""}';//most near
			// $apntpnt=json_decode($mstnr,true);

			$url=C('javaback').'/device/getAll.action?longitude='.$_GET['lgtd'].'&latitude='.$_GET['lttd'];
			if(C('psnvs')==1){
				$json='{"data":[{"id":1,"owner":2,"sn":"001","model":1,"city":null,"longitude":"121.572673","latitude":"31.212916","address":"我的位置","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":"龙沟新苑桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":3,"owner":2,"sn":"003","model":1,"city":null,"longitude":"121.557141","latitude":"31.216039","address":"世纪公园桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":4,"owner":2,"sn":"004","model":1,"city":null,"longitude":"121.570077","latitude":"31.219745","address":"上海浦东嘉里大酒店桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":5,"owner":2,"sn":"005","model":1,"city":null,"longitude":"121.566699","latitude":"31.214171","address":"上海人家99短租公寓桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":6,"owner":2,"sn":"006","model":1,"city":null,"longitude":"121.581845","latitude":"31.219382","address":"汤臣湖庭花园桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":7,"owner":2,"sn":"007","model":1,"city":null,"longitude":"121.564004","latitude":"31.200898","address":"花木新村桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":8,"owner":2,"sn":"008","model":1,"city":null,"longitude":"121.506252","latitude":"31.245374","address":"上海东方明珠电视塔桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":9,"owner":1,"sn":"FFFF","model":1,"city":null,"longitude":"120.208989","latitude":"30.213697","address":"钱龙大厦","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""}],"code":"A00000","msg":"获取设备列表成功"}';
			}else{
				$json=https_request($url);
			}
			//$json=https_request($url);
			$arr=json_decode($json,true);
			$apntpnt=$arr['data'][0];
		}else{//普通的话就需要直接获得装ID根据桩id 来进行
			//...一个GET桩ID的过程我就暂时省去了，反正最终也是获得预约桩的代码
			
			$dvcid=$_GET['tp'];
			$url=C('javaback').'/device/get.action?deviceId='.$dvcid;
			if(C('psnvs')==1){
				$json='{"data": {"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":" 龙沟新苑 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},"code":"A00000","msg":" 获取设备成功"}';
			}else{
				$json=https_request($url);
			}
			//$json=https_request($url);
			$arr=json_decode($json,true);
			$apntpnt=$arr['data'];
		}

		//反正不管是怎样都能拿到预约点

    	//先试着预约下
    	$url=C('javaback').'/order/appoint.action?wechatId='.session('openid').'&carId='.$_GET['crid'].'&deviceId='.$apntpnt['id'];
    	//force参数
    	$fc=$_GET['fc'];
    	if($fc==1){
    		$url=$url.'&force=true';
    		//若是强迫完成预约的话
    	}

    	if(C('psnvs')==1){
    		$json='{"data":4,"code":"A01408","msg":"用户余额不足"}';
    		$json='{"data":100,"code":"A00000","msg":"预约完成"}';
    	}else{
    		$json=https_request($url);
    	}
    	//$json=https_request($url);
    	$arr=json_decode($json,true);
    	if($arr['code']=='A01406'){
    		$rslt='hsodr';
    	}else if($arr['code']=='A01407'){
    		$rslt='hsbtm';
    	}else if($arr['code']=='A01408'){
    		$rslt='hsgp';
    	}else if($arr['code']=='A00000'){
    		$rslt='admt';
    	}

    	//hsodr  hsgp(区间) hsbtm(到底了) admt（允许预约） 
    	//假设得到结果是有单子需要删除
    	$data['rslt']=$rslt;
    	if($rslt=='hsodr'){//获得什么订单 订单的里面设备的ID是哪个
    		//甭管咋样，你既然要约，之前的东西必须清
	    	$url='http://120.26.80.165/order/getLastOrder.action&wechatId=12345';
	    	if(C('psnvs')==1){
	    		$json='{"id":1,"userId":1,"macId":null,"deviceId":2,"price":200,"startDegree":null,"endDegree":null,"carId":1,"status":0,"totalPrice":null,"createTime":"2015-09-20 11:43:16","updateTime":"2015-09-20 11:43:16","endTime":null,"version":0,"statusFinal":false}';
	    	}else{
	    		$json=https_request($url);
	    	}
	    	//$json=https_request($url);
	    	$odr=json_decode($json,true);
    		$data['odr']=$odr;
    		//根据订单里的dvcid获取桩信息？
    		$json='{"id":4,"owner":2,"sn":"004","model":1,"city":null,"longitude":"121.570077","latitude":"31.219745","address":"上海浦东嘉里大酒店桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""}';//most near
			$odrpnt=json_decode($json,true);
			$data['odrpnt']=$odrpnt;
    	}else if($rslt=='hsgp'){
    		//这里需要计算还有多少时间可以充电?这里直接就是5小时//mny?dvcid?tm?
    		$mny=8;
    		$tm=5;
    		$dvcid=$apntpnt['id'];
    		$data['mny']=$mny;
    		$data['tm']=$tm;
    		$data['dvcid']=$dvcid;
    	}else if($rslt=='hsbtm'){

    	}else if($rslt=='admt'){
    		
			
			$data['apntpnt']=$apntpnt;
			
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

	function dofnddvcls(){
		$url=C('javaback').'/device/search.action?addr='.$_GET['ctt'];
		if(session('openid')){
			$openid=session('openid');
			import('@.SS.SSAction');
			$ss = new SSAction();
			$usrdto=$ss->setss();
			$str='&carModelId'.$usrdto['carList'][0]['carModelId'];
			$url=$url.$str;
		}
		if(C('psnvs')==1){
			$json='{"data":[{"id":1,"owner":2,"sn":"001","model":1,"city":null,"longitude":"121.572673","latitude":"31.212916","address":"我的位置","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":"龙沟新苑桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":3,"owner":2,"sn":"003","model":1,"city":null,"longitude":"121.557141","latitude":"31.216039","address":"世纪公园桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":4,"owner":2,"sn":"004","model":1,"city":null,"longitude":"121.570077","latitude":"31.219745","address":"上海浦东嘉里大酒店桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":5,"owner":2,"sn":"005","model":1,"city":null,"longitude":"121.566699","latitude":"31.214171","address":"上海人家99短租公寓桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":6,"owner":2,"sn":"006","model":1,"city":null,"longitude":"121.581845","latitude":"31.219382","address":"汤臣湖庭花园桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":7,"owner":2,"sn":"007","model":1,"city":null,"longitude":"121.564004","latitude":"31.200898","address":"花木新村桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":8,"owner":2,"sn":"008","model":1,"city":null,"longitude":"121.506252","latitude":"31.245374","address":"上海东方明珠电视塔桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":9,"owner":1,"sn":"FFFF","model":1,"city":null,"longitude":"120.208989","latitude":"30.213697","address":"钱龙大厦","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""}],"code":"A00000","msg":"获取设备列表成功"}';
		}else{
			$json=https_request($url);
		}
		
		//$json=https_request($url);
		$arr=json_decode($json,true);
		$data['dvcls']=$arr['data'];
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
		return $rslt;
	}


}