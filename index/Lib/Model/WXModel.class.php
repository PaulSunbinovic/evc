<?php
class WXModel{
	//https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=XXXXX&secret=xxxxx

	//######MODEL###########
	public function test($id){
		$url='';
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function getaccesstoken($appid,$secret){
		$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//######MODEL###########
	public function setsignpackage($id){
		$jsapiTicket = $this->getJsApiTicket();

	    // 注意 URL 一定要动态获取，不能 hardcode.
	    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	    $timestamp = time();
	    $nonceStr = $this->createNonceStr();

	    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
	    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

	    $signature = sha1($string);

	    $signPackage = array(
	      "appId"     => $this->appId,
	      "nonceStr"  => $nonceStr,
	      "timestamp" => $timestamp,
	      "url"       => $url,
	      "signature" => $signature,
	      "rawString" => $string
	    );
	    return $signPackage;
	}
	private function getJsApiTicket() {
	    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
	    $data = json_decode(file_get_contents("jsapi_ticket.json"));
	    if ($data->expire_time < time()) {
	      $accessToken = $this->getAccessToken();
	      // 如果是企业号用以下 URL 获取 ticket
	      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
	      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
	      $res = json_decode($this->httpGet($url));
	      $ticket = $res->ticket;
	      if ($ticket) {
	        $data->expire_time = time() + 7000;
	        $data->jsapi_ticket = $ticket;
	        $fp = fopen("jsapi_ticket.json", "w");
	        fwrite($fp, json_encode($data));
	        fclose($fp);
	      }
	    } else {
	      $ticket = $data->jsapi_ticket;
	    }

	    return $ticket;
	}

}
?>