<?php
//以下为日志

interface ILogHandler
{
	public function write($msg);
	
}

class CLogFileHandler implements ILogHandler
{
	private $handle = null;
	
	public function __construct($file = '')
	{
		$this->handle = fopen($file,'a');
	}
	
	public function write($msg)
	{
		fwrite($this->handle, $msg, 4096);
	}
	
	public function __destruct()
	{
		fclose($this->handle);
	}
}

class Log
{
	private $handler = null;
	private $level = 15;
	
	private static $instance = null;
	
	private function __construct(){}

	private function __clone(){}
	
	public static function Init($handler = null,$level = 15)
	{
		if(!self::$instance instanceof self)
		{
			self::$instance = new self();
			self::$instance->__setHandle($handler);
			self::$instance->__setLevel($level);
		}
		return self::$instance;
	}
	
	
	private function __setHandle($handler){
		$this->handler = $handler;
	}
	
	private function __setLevel($level)
	{
		$this->level = $level;
	}
	
	public static function DEBUG($msg)
	{
		self::$instance->write(1, $msg);
	}
	
	public static function WARN($msg)
	{
		self::$instance->write(4, $msg);
	}
	
	public static function ERROR($msg)
	{
		$debugInfo = debug_backtrace();
		$stack = "[";
		foreach($debugInfo as $key => $val){
			if(array_key_exists("file", $val)){
				$stack .= ",file:" . $val["file"];
			}
			if(array_key_exists("line", $val)){
				$stack .= ",line:" . $val["line"];
			}
			if(array_key_exists("function", $val)){
				$stack .= ",function:" . $val["function"];
			}
		}
		$stack .= "]";
		self::$instance->write(8, $stack . $msg);
	}
	
	public static function INFO($msg)
	{
		self::$instance->write(2, $msg);
	}
	
	private function getLevelStr($level)
	{
		switch ($level)
		{
		case 1:
			return 'debug';
		break;
		case 2:
			return 'info';	
		break;
		case 4:
			return 'warn';
		break;
		case 8:
			return 'error';
		break;
		default:
				
		}
	}
	
	protected function write($level,$msg)
	{	
		//-----------
		if(strpos($msg, 'call back:')==0){
			$tmp=explode('call back:',$msg);
			$arr=json_decode($tmp[1],true);

			$host=$_SERVER['HTTP_HOST'];
			$tmp=explode('/',$_SERVER['PHP_SELF']);
			$prjct=$tmp[1];
			$urlprx='http://'.$host.'/'.$prjct;

			if($arr['return_code']=='SUCCESS'){

				$time=$arr['time_end'];
				$year=substr($time,0,4);
				$month=substr($time,4,2);
				$day=substr($time,6,2);
				$hour=substr($time,8,2);
				$minute=substr($time,10,2);
				$second=substr($time,12,2);
				$time=$year.'-'.$month.'-'.$day.'+'.$hour.':'.$minute.':'.$second;

				$url=$urlprx.'/index.php/Index/mysqlforrcd/out_trade_no/'.$arr['out_trade_no'].'/transaction_id/'.$arr['transaction_id'].'/openid/'.$arr['openid'].'/time_end/'.$arr['time_end'].'/total_fee/'.$arr['total_fee'].'/return_code/'.$arr['return_code'];
				$json=$this->https_request($url);//有则改之无则加勉
				
				//若PHP库没有则添加到库并给JAVA后台送参数
				if($json=='no'){

					
					$url=$urlprx.'/index.php/Index/odr/mtd/get/openid/'.$arr['openid'];
					$odrid=$this->https_request($url);
					$url=$urlprx.'/index.php/Index/odr/mtd/dlt/openid/'.$arr['openid'];
					$this->https_request($url);
					// 
					// $odrid=$_SESSION['odrid'];
					
					$url1='http://120.26.80.165/pay/callback.action?wechatId='.$arr['openid'].'&money='.$arr['total_fee'].'&paymentOrderId='.$odrid.'&transactionId='.$arr['transaction_id'].'&outTradeNo='.$arr['out_trade_no'].'&bankType='.$arr['bank_type'].'&payTime='.$time;
					
					$json1=$this->https_request($url1);
				}
			}
		}
		
		// $url='http://120.26.80.165/pay/callback.action?wechatId=1&money=1&paymentOrderId=1&transactionId=1111&outTradeNo=222&bankType=ICBC&payTime=2015-10-10 10:10:10';


		if(($level & $this->level) == $level )
		{
			$msg = '['.date('Y-m-d H:i:s').']['.$this->getLevelStr($level).'] '.$msg.$url1.'aaaa'.$json1."\n";
			$this->handler->write($msg);
		}
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

}
