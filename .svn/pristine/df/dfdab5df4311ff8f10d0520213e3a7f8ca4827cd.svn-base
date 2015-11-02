<?php
echo $_POST['carBrand'];
// function https_request($url,$data=null){
// 	$crl=curl_init();
// 	curl_setopt($crl, CURLOPT_URL, $url);
// 	curl_setopt($crl,CURLOPT_SSL_VERIFYPEER,false);
// 	curl_setopt($crl, CURLOPT_SSL_VERIFYHOST,false);
	
// 	if(!empty($data)){
// 		curl_setopt($crl, CURLOPT_POST,1);
// 		curl_setopt($crl, CURLOPT_POSTFIELDS,$data);
		
// 	}
// 	curl_setopt($crl,CURLOPT_RETURNTRANSFER,1);
// 	$output=curl_exec($crl);
// 	curl_close($crl);
	
// 	return $output; 
// }

// $msg='call back:{"appid":"wx682ad2cc417fe8b9","attach":"test","bank_type":"ICBC_CREDIT","cash_fee":"1","fee_type":"CNY","is_subscribe":"Y","mch_id":"1232972302","nonce_str":"8ab316bn2pthnynghi5n8l5imq85wwrz","openid":"ojxMBuJe07gSZDUwp0ZHGHEMHOR8","out_trade_no":"123297230220150919075045","result_code":"SUCCESS","return_code":"SUCCESS","sign":"106E27DC2EC02CC17813FB3B469C5E8E","time_end":"20150919075052","total_fee":"1","trade_type":"JSAPI","transaction_id":"1000520956201509190922973606"}';

// if(strpos($msg, 'call back:')==0){
// 	$tmp=explode('call back:',$msg);
// 	$arr=json_decode($tmp[1],true);

// 	$host=$_SERVER['HTTP_HOST'];
// 	$tmp=explode('/',$_SERVER['PHP_SELF']);
// 	$prjct=$tmp[1];
// 	$urlprx='http://'.$host.'/'.$prjct;

// 	if($arr['return_code']=='SUCCESS'){
// 		$url=$urlprx.'/index.php/Index/mysqlforrcd/out_trade_no/'.$arr['out_trade_no'].'/transaction_id/'.$arr['transaction_id'].'/openid/'.$arr['openid'].'/time_end/'.$arr['time_end'].'/total_fee/'.$arr['total_fee'].'/return_code/'.$arr['return_code'];
// 		$json=https_request($url);//有则改之无则加勉
// 		//若PHP库没有则添加到库并给JAVA后台送参数
// 		if($json=='no'){
// 			// $url='wangfeng';
// 			// https_request($url);
// 		}
// 	}
// }