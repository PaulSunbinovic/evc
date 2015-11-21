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
		$ss=D('SS');$dvc=D('Dvc');


		$openid=session('openid');
		$usro=$ss->setss();
		//默认车还没搞,现在都是只管一辆车的情况下
		//如果有人就把他到车型对应到桩找出来，否则就全找出来
		
		if($usro){
			$arr=$dvc->getAll($openid,$_GET['ctlgtd'],$_GET['ctlttd'],$usro['carList'][0]['carModelId']);
			
		}else{
			$arr=$dvc->getAll($openid,$_GET['ctlgtd'],$_GET['ctlttd']);
		}
						
		//为了体现出那些桩已经被预约了
		
		$dvclsnw=array();
		$dvcls=$arr['data'];
		//添加一个功能
		foreach($dvcls as $dvcv){
			//###################################
			//查看共享时间
			if($dvcv['listShareTime']){//以后有sharetime就是绿色好了
				$starttm=$dvcv['listShareTime'][0]['startTime'];
				$starttmuls=explode(":",$starttm);
				$starttm=$starttmuls[0].':'.$starttmuls[1];
				$endtm=$dvcv['listShareTime'][0]['endTime'];
				$endtmuls=explode(":",$endtm);
				$endtm=$endtmuls[0].':'.$endtmuls[1];
				$opentm=$starttm.'-'.$endtm;
			}else{
				$opentm='';
			}
			$dvcv['opentm']=$opentm;
			//##############################@
			//查看是否被充电
			$arr=$dvc->checkIsCharging($dvcv['id']);

			if($arr['data']==true){
				$dvcv['chargestatus']='on';
			}else{
				$dvcv['chargestatus']='off';
			}

			array_push($dvclsnw,$dvcv);
		}

		$data['dvcls']=$dvclsnw;
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
		//#############
		$odrno=$_GET['orderNo'];
		

		
		$evt=$_GET['event'].'\n'.date('Y-m-d H:i:s',time());
		//为了测试，临时+个上来，加我的把
		//$openid='ojxMBuJe07gSZDUwp0ZHGHEMHOR8';
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

		                "value":"'.$odrno.'",

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

