<?php
function p($array){
	dump($array,1,'<pre>',0);//1表示输出 0表示以print_r方式打印
}
function vd($array){
	var_dump($array);
}
function https_request($url,$data=null){
	$crl=curl_init();
	curl_setopt($crl, CURLOPT_URL, $url);
	curl_setopt($crl,CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($crl, CURLOPT_SSL_VERIFYHOST,false);
	
	if(!empty($data)){
		curl_setopt($crl, CURLOPT_POST,1);
		curl_setopt($crl, CURLOPT_POSTFIELDS,$data);
		
	}
	curl_setopt($crl,CURLOPT_RETURNTRANSFER,1);
	$output=curl_exec($crl);
	curl_close($crl);
	
	return $output; 
}
function rplspc($str){
	$str=str_replace(' ','+',$str);
	return $str;
}
/*
用法 logger('BB','log/log1.txt');(推荐)     logger('BB','./log/log1.txt');  logger('BB','log.txt');
 */
function logger($log_content,$log_filename){
		
	if(!$log_filename){
		$log_filename='log.txt';//默认根目录
	}
	//################注销掉就是不对大小做限制了
	// $max_size=1024*1024*10;//默认字节Byte 10MB
	// if(file_exists($log_filename)&&abs(filesize($log_filename))>$max_size){
	// 	unlink($log_filename);
	// }
	//#######################
	
	//date_default_timezone_set('PRC');
	
	if($log_content=='#'){
		file_put_contents($log_filename, '###################################################'."\r\n",FILE_APPEND);//双引号才换行##
	}else{
		file_put_contents($log_filename, date('Y-m-d H:i:s',time()).' '.$log_content."\r\n",FILE_APPEND);//双引号才换行
	}
	
}

function url2arr($url,$json){
	if(C('psnvs')!=1){
		$json=https_request($url);
	}
	$arr=json_decode($json,true);
	//if($arr['code']!='A00000'){
		logger('#','log/log_'.date('Y-m-d',time()).'.txt');
		logger('url: '.$url,'log/log_'.date('Y-m-d',time()).'.txt');
		logger('json: '.$json,'log/log_'.date('Y-m-d',time()).'.txt');
	//}
	$arr['url']=$url;
	//if($arr['code']=='A00000'){$arr['rslt']=1;}else{$arr['rstl']=0;}
	return $arr;

}

function arr2strforjavascript($arr,$arr_except){
	$str='';
	foreach ($arr as $key => $value) {
		# code...
		$hasexcept=0;
		# 让其一个个比较，如果都对不上就可以拿来整，否则直接淘汰
		foreach ($arr_except as $v) {
			# code...
			if($key==$v){
				$hasexcept=1;
				break;
			}
		}
		//分析
		if ($hasexcept===0) {
			if($str){$str=$str.'&'.$key.'='.$value;}else{$str=$key.'='.$value;}
		}else{
			continue;//跳过
		}

		
	}
	return $str;
}

function xiaoshu($num,$weishu){
	return number_format($num, $weishu, '.', '');
}
?>