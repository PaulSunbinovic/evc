<?php
// 本类由系统自动生成，仅供测试用途
class CmnAction extends Action {
	public function ssdsty(){
		session('openid',null);
	}
	public function hd_idx(){
		$this->display('hd_idx');
    }
    public function hd_std(){
		$this->display('hd_std');
    }
    public function ft_std(){
    	$this->display('ft_std');
    }
    public function hd_apntpnt(){
		$this->display('hd_apnt');
    }


	
	//呈现桩display device
	public function dspdvc(){
		import('@.SS.SSAction');
		$ss = new SSAction();
		$usro=$ss->setss();
		//默认车还没搞,现在都是只管一辆车的情况下
		//如果有人就把他到车型对应到桩找出来，否则就全找出来
		if($usro){
			$qry='?model='.$usro['carList'][0]['carModelId'].'&longitude='.$_GET['ctlgtd'].'&latitude='.$_GET['ctlttd'];
		}else{
			$qry='&longitude='.$_GET['ctlgtd'].'&latitude='.$_GET['ctlttd'];
		}
		//java后台
		$url=C('javaback').'/device/getAll.action'.$qry;
		if(C('psnvs')==1){

			//上海版
			// /$json='{"data":[{"id":1,"owner":2,"sn":"001","model":1,"city":null,"longitude":"121.572673","latitude":"31.212916","address":"我的位置","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":"龙沟新苑桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":3,"owner":2,"sn":"003","model":1,"city":null,"longitude":"121.557141","latitude":"31.216039","address":"世纪公园桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":4,"owner":2,"sn":"004","model":1,"city":null,"longitude":"121.570077","latitude":"31.219745","address":"上海浦东嘉里大酒店桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":5,"owner":2,"sn":"005","model":1,"city":null,"longitude":"121.566699","latitude":"31.214171","address":"上海人家99短租公寓桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":6,"owner":2,"sn":"006","model":1,"city":null,"longitude":"121.581845","latitude":"31.219382","address":"汤臣湖庭花园桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":7,"owner":2,"sn":"007","model":1,"city":null,"longitude":"121.564004","latitude":"31.200898","address":"花木新村桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":8,"owner":2,"sn":"008","model":1,"city":null,"longitude":"121.506252","latitude":"31.245374","address":"上海东方明珠电视塔桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},{"id":9,"owner":1,"sn":"FFFF","model":1,"city":null,"longitude":"120.208989","latitude":"30.213697","address":"钱龙大厦","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""}],"code":"A00000","msg":"获取设备列表成功"}';
			//北京版
			$json='{"data":[{"id":1,"owner":6,"sn":"80000001","model":1,"city":null,"longitude":"121.572673","latitude":"31.212916","address":"我的位置","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"02","capacity":1,"version":null,"path":null},{"id":2,"owner":25,"sn":"56725569","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":"龙沟新苑桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":2,"version":null,"path":null},{"id":3,"owner":14,"sn":"80000003","model":1,"city":null,"longitude":"121.557141","latitude":"31.216039","address":"世纪公园桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":1,"version":null,"path":null},{"id":4,"owner":110,"sn":"80000004","model":1,"city":null,"longitude":"121.570077","latitude":"31.219745","address":"上海浦东嘉里大酒店桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":2,"version":null,"path":null},{"id":5,"owner":178,"sn":"80000005","model":1,"city":null,"longitude":"121.566699","latitude":"31.214171","address":"上海人家99短租公寓桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":6,"owner":111,"sn":"80000006","model":1,"city":null,"longitude":"121.581845","latitude":"31.219382","address":"汤臣湖庭花园桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":7,"owner":112,"sn":"80000007","model":1,"city":null,"longitude":"121.564004","latitude":"31.200898","address":"花木新村桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":8,"owner":13,"sn":"80000008","model":1,"city":null,"longitude":"121.506252","latitude":"31.245374","address":"上海东方明珠电视塔桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":9,"owner":10,"sn":"c45d7306","model":1,"city":null,"longitude":"120.208989","latitude":"30.213697","address":"钱龙大厦","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":1,"version":null,"path":null},{"id":10,"owner":113,"sn":"d51d283c","model":1,"city":null,"longitude":"121.506252","latitude":"31.245374","address":"金桥小区10","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":11,"owner":114,"sn":"58a48d09","model":1,"city":null,"longitude":"121.506252","latitude":"31.245374","address":"金桥小区11","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":12,"owner":115,"sn":"adad0c25","model":1,"city":null,"longitude":"121.506252","latitude":"31.245374","address":"金桥小区12","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":13,"owner":25,"sn":"adfed8ff","model":1,"city":null,"longitude":"121.506252","latitude":"31.245374","address":"金桥小区13","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":14,"owner":116,"sn":"58d7400a","model":1,"city":null,"longitude":"121.506252","latitude":"31.245374","address":"金桥小区14","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":15,"owner":117,"sn":"58add0bc","model":1,"city":null,"longitude":"121.506252","latitude":"31.245374","address":"金桥小区15","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":17,"owner":11,"sn":"010","model":1,"city":null,"longitude":"121.570077","latitude":"31.219745","address":"上海浦东嘉里大酒店桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":18,"owner":null,"sn":"","model":1,"city":null,"longitude":"116.423457","latitude":"39.960742","address":"地坛公园","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":19,"owner":null,"sn":"","model":1,"city":null,"longitude":"116.447387","latitude":"39.962124","address":"柳芳北里社区","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":20,"owner":null,"sn":"","model":1,"city":null,"longitude":"116.458742","latitude":"39.942876","address":"三里屯","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":21,"owner":null,"sn":"","model":1,"city":null,"longitude":"116.423744","latitude":"39.891245","address":"天坛公园","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":22,"owner":null,"sn":"","model":1,"city":null,"longitude":"116.487847","latitude":"39.878179","address":"北京工业大学","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":23,"owner":null,"sn":"","model":1,"city":null,"longitude":"116.463557","latitude":"39.981367","address":"太阳宫公园","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":24,"owner":null,"sn":"","model":1,"city":null,"longitude":"116.480733","latitude":"39.977386","address":"四德公园","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null},{"id":25,"owner":null,"sn":"","model":1,"city":null,"longitude":"116.436105","latitude":"39.977441","address":"北京中医药大学","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":"","capacity":null,"version":null,"path":null}],"code":"A00000","msg":"获取设备列表成功"}';
		}else{
			$json=https_request($url);
		}
		//$json=https_request($url);
		$arr=json_decode($json,true);
		//百度LBS
		// $url='http://api.map.baidu.com/geosearch/v3/nearby?location='.$_GET['ctlgtd'].','.$_GET['ctlttd'].'&geotable_id='.C('tbid').'&radius=20000&ak='.C('svak').'&filter=deviceId:[1,2,3]';
		// $json=https_request($url);
		// $arr_bd=json_decode($json,true);
		// $arr_bd=$arr_bd['contents'];
		// //然后根据java后台到数据从百度LBS中
		
		//为了体现出那些桩已经被预约了
		

		$dvcls=$arr['data'];
		

		$data['dvcls']=$dvcls;
		$this->ajaxReturn($data,'json');

	}

	

	public function vrfusrstat(){//暂时有个漏洞，进入index的时候验证过的，所以原则上session中openid有无就可以说明他是否已经注册过了
		$x=$_GET['x'];
		//fortest start
		// $openid='ojxMBuJe07gSZDUwp0ZHGHEMHOR8';
		// session('openid',$openid);
		//fortest over
		$openid=session('openid');
		if($openid){
			if($x=='usrct'){
				$mtd='url';
				$url=__APP__.'/Usr/'.$x;	
			}else if($x=='apnt'){
				
				$mtd='trg';
				
			}
			
		}else{
			$mtd='url';
			$url='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx682ad2cc417fe8b9&redirect_uri='.C('HOST').'/oauth2_openid.php&response_type=code&scope=snsapi_base&state='.$x.'#wechat_redirect';
		
		}
		
		$data['mtd']=$mtd;
		$data['url']=$url;
    	
		$this->ajaxReturn($data,'json');
	}

	//为了扫码
	public function gtdvc(){
		$dvcid=$_GET['dvcid'];
		//获取opid crid dvcid
		//获取openid因为可能是从外面进来的人
		
		//不管session对于openid有的没的
		//都重新授权一遍
		$url='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx682ad2cc417fe8b9&redirect_uri='.C('HOST').'/oauth2_openid.php&response_type=code&scope=snsapi_base&state=qr&aaa=111#wechat_redirect';
	}
	public function qr(){
		$openid=session('openid');
		
		import('@.SS.SSAction');
		$ss = new SSAction();
		$usro=$ss->setss();
		$crls=$usro['carList'];
		//默认
		$cro=$crls[0];
		foreach ($crls as $crv) {
			if($crv['isDefault']==true){
				//重写
				$cro=$crv;
				break;
			}
		}
		$crid=$cro['id'];

		$dvcid=$_GET['dvcid'];

		$url=C('javaback').'/order/deviceMatchUser.action?wechatId='.$openid.'&deviceId='.$dvcid.'&carId='.$crid;
		$json=https_request($url);
		$arr=json_decode($json,true);

		$this->assign('msg',$arr['msg']);
		$this->display('Index/mtchrslt');
	}

	//通过微信给用户发送某些通知
	public function wxinfo(){
		$appid=C('appid');
		$appsecret=C('appsecret');
		//为了测试，我这里定了我测试号的appid etc
		//$appid='wx08c69e5ad5cc1a5e';$appsecret='95c2d97c3557a65b5f6f7e962b363256';
		//获取access_token
		$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
		$json=https_request($url);
		$arr=json_decode($json,true);
		$access_token=$arr['access_token'];
		//通过openid获取usrinfo
		$openid=$_GET['wechatId'];
		$url=C('javaback').'/user/get.action?wechatId='.$openid;

		if(C('psnvs')==1){
			$json_usr='{"data":{"user":{"id":1,"token":1,"wechatId":"12345","nickName":"王 峰","mobile":"13162951502","macId":"dadadaaf","headImgUrl":"baidu.com","createTime":"2015-09-13 10:37:53","updateTime":"2015-09-13 10:37:53","customer":true,"deviceOwner":false,"installser":false,"admin":false},"userAccount":{"id":1,"userId":1,"balance":990,"point":0,"createTime":"2015-09-13 10:37:54","updateTime":"2015-09-19 23:26:50","version":1},"carList": [{"id":1,"userId":1,"carModelId":1,"carNo":"沪 A11111","isDefault":false,"createTime":"2015-09-19 22:19:36","updateTime":"2015-09-19 22:19:40"}]},"code":"A00000","msg":null}';
		}else{
			$json_usr=https_request($url);
		}
		$arr_usr=json_decode($json_usr,TRUE);
		$usrnm=$arr_usr['data']['user']['nickName'];
		
		//通过dvcid获取dvcnm
		$dvcid=$_GET['deviceId'];
		$url=C('javaback').'/device/get.action?deviceId='.$dvcid;

		if(C('psnvs')==1){
			$json='{"data": {"id":2,"owner":2,"sn":"002","model":1,"city":null,"longitude":"121.575215","latitude":"31.203762","address":" 龙沟新苑 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},"code":"A00000","msg":" 获取设备成功"}';
		}else{
			$json=https_request($url);
		}
		$arr=json_decode($json,TRUE);

		$dvcnm=$arr['data']['address'];

		
		$evt=$_GET['event'].date('Y-m-d H:i:s',time());
		//为了测试，临时+个上来，加我的把
		$openid='ojxMBuJe07gSZDUwp0ZHGHEMHOR8';
		$json='{

		    "touser":"'.$openid.'",

		    "template_id":"'.C('mdlid').'",
			"url":"'.C('infodtl').'",

		    "topcolor":"#FF0000",

		    "data":{

		            "first": {

		                "value":"'.$usrnm.'",

		                "color":"#173177"

		            },

		            "keyword1":{

		                "value":"'.$dvcnm.'",

		                "color":"#173177"

		            },

		            "keyword2": {

		                "value":"'.$evt.'",

		                "color":"#173177"

		            },

		          
		            "remark":{

		                "value":"欢迎使用",

		                "color":"#173177"

		            }

		            

		            

		    }

		}';
		$url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
		$json=https_request($url,$json);
		echo $json;
	}


}

