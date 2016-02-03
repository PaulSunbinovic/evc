<?php
/*
本文件位置
$redirect_url= "http://israel.duapp.com/weixin/oauth2_openid.php";

URL
https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx682ad2cc417fe8b9&redirect_uri=http://www.evchar.cn/evc/oauth2_openid.php&response_type=code&scope=snsapi_base&state=wx682ad2cc417fe8b9WXWCc4c1b2004388a3a529f39fc42c0c60e9#wechat_redirect
*/
$psnvs=0;
$code = $_GET["code"];
$state=$_GET['state'];
$appid='wx682ad2cc417fe8b9';
$appsecret='c4c1b2004388a3a529f39fc42c0c60e9';
$userinfo = getUserInfo($code,$appid,$appsecret);



session_start();//session开始后 之前的$X都无效了
$arrall=array();
$host=$_SERVER['HTTP_HOST'];
$tmp=explode('/',$_SERVER['PHP_SELF']);
$prjct=$tmp[1];
$urlprx='http://'.$host.'/'.$prjct;
//echo $userinfo['openid'];

if(!isset($userinfo['nickname'])){header("location: ".$urlprx."/index.php/Usr/guanzhuwomen");die;}


//header("location: wap.php");

$url='http://120.26.80.165/user/get.action?wechatId='.$userinfo['openid'];

if($psnvs==1){
	$json_usr='{"data":{"user":{"id":1,"token":1,"wechatId":"12345","nickName":"王 峰","mobile":"13162951502","macId":"dadadaaf","headImgUrl":"baidu.com","createTime":"2015-09-13 10:37:53","updateTime":"2015-09-13 10:37:53","customer":true,"deviceOwner":false,"installser":false,"admin":false},"userAccount":{"id":1,"userId":1,"balance":990,"point":0,"createTime":"2015-09-13 10:37:54","updateTime":"2015-09-19 23:26:50","version":1},"carList": [{"id":1,"userId":1,"carModelId":1,"carNo":"沪 A11111","isDefault":false,"createTime":"2015-09-19 22:19:36","updateTime":"2015-09-19 22:19:40"}]},"code":"A00000","msg":null}';
}else{
	$json_usr=https_request($url);
}
//$json_usr=https_request($url);
$arr_usr=json_decode($json_usr,TRUE);

if($arr_usr['data']){//若库里有
	$_SESSION['openid']=$userinfo['openid'];
	if($state=='index'){
		header("location: ".$urlprx."/index.php/Index/".$state);
	}else if($state=='usrct'){
		header("location: ".$urlprx."/index.php/Usr/".$state);
	}else if(strpos($state,'bind')===0){
		$tmp=explode('WXWC', $state);
		header("location: ".$urlprx."/index.php/Dvc/bind/dvcid/".$tmp[1]);
	}else if(strpos($state, 'qr')===0){
		$tmp=explode('_',$state);
		header("location: ".$urlprx."/index.php/Cmn/qr/dvcid/".$tmp[1]);
	}else if(strpos($state, 'gongzhuangmstct')===0){
		$tmp=explode('_',$state);
		header("location: ".$urlprx."/index.php/Usr/gongzhuangmstct/sn/".$tmp[1]);
	}
	
	
	
	
}else{//若库里没有
	
	if($state=='index'){
		header("location: ".$urlprx."/index.php/Index/".$state);
	}else{
		//头像数据加密便于传输
		$tmp=explode('http://',$userinfo['headimgurl']);
		//然后去掉斜杠
		$hdurl=str_replace('/','-gang-',$tmp[1]);

		
		header("location: ".$urlprx."/index.php/Usr/regist/openid/".$userinfo['openid']."/headimgurl/".$hdurl."/nickname/".$userinfo['nickname']);
	}
	
}
	





function getUserInfo($code,$appid,$appsecret)
{
// 	$appid = "wx08c69e5ad5cc1a5e";
// 	$appsecret = "95c2d97c3557a65b5f6f7e962b363256";

    //oauth2的方式获得openid
	$access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
	$access_token_json = https_request($access_token_url);
	$access_token_array = json_decode($access_token_json, true);
	$openid = $access_token_array['openid'];

    //非oauth2的方式获得全局access token
    $new_access_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
    $new_access_token_json = https_request($new_access_token_url);
	$new_access_token_array = json_decode($new_access_token_json, true);
	$new_access_token = $new_access_token_array['access_token'];
	
    //全局access token获得用户基本信息
    $userinfo_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$new_access_token&openid=$openid";
	$userinfo_json = https_request($userinfo_url);
	$userinfo_array = json_decode($userinfo_json, true);
	return $userinfo_array;
}

function https_request($url)
{
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($curl);
	if (curl_errno($curl)) {return 'ERROR '.curl_error($curl);}
	curl_close($curl);
	return $data;
}
?>
