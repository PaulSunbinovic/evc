<?php
function p($array){
	dump($array,1,'<pre>',0);//1表示输出 0表示以print_r方式打印
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
	//日志大小 10000
	$max_size=10000;//默认字节Byte
	if(!$log_filename){
		$log_filename='log.txt';//默认根目录
	}
	
	if(file_exists($log_filename)&&abs(filesize($log_filename))>$max_size){
		unlink($log_filename);
	}
	//date_default_timezone_set('PRC');
	file_put_contents($log_filename, date('Y-m-d H:i:s',time()).' '.$log_content."\r\n",FILE_APPEND);//双引号才换行
}



?>