<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';



//--------------------获得钱数
$money=$_GET['money']*100;//单位是元 转化成分

$host=$_SERVER['HTTP_HOST'];
$tmp=explode('/',$_SERVER['PHP_SELF']);
$prjct=$tmp[1];
$urlprx='http://'.$host.'/'.$prjct;


//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
//还是防一手，为避免别人注入session导致非自己的微信号付钱还是再次获取openid比较好
// session_start();
// $openId=$_SESSION['openid'];

//------------------------获取JAVA充值订单号
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

$url="http://120.26.80.165/pay/create.action?wechatId=".$openId.'&money='.$money;
$json=https_request($url);
$arr=json_decode($json,true);
$odrid=$arr['data'];

//由于log.php 对于session油盐不进，所以只能用数据库的方式来储存了
$url=$urlprx.'/index.php/Index/odr/mtd/add/openid/'.$openId.'/odrid/'.$odrid;
https_request($url);
// $_SESSION['odrid']=$odrid;

$arr1=array('odrid'=>$odrid);

//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("预充电费");
$input->SetAttach("test");
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee($money);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
//--------------------------------------


$input->SetNotify_url($urlprx."/wxpay/example/notify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
//不用杂七杂八的打印出来到浏览器
// echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
// printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);
$arr2=json_decode($jsApiParameters,true);
$arr=array_merge($arr1,$arr2);
$json=json_encode($arr);


//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>


<script type="text/javascript">

//直接付便是
callpay();

//调用微信JS api 支付
function jsApiCall()
{
	WeixinJSBridge.invoke(
		'getBrandWCPayRequest',
		// <?php echo $jsApiParameters; ?>,
		//------------------------
		<?php echo $json; ?>,
		function(res){
			history.go(-2);
			// WeixinJSBridge.log(res.err_msg);
			// alert(res.err_code+res.err_desc+res.err_msg);
		}
	);
}

function callpay()
{
	if (typeof WeixinJSBridge == "undefined"){
	    if( document.addEventListener ){
	        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
	    }else if (document.attachEvent){
	        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
	        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
	    }
	}else{
	    jsApiCall();
	}
}
</script>
<script type="text/javascript">
//获取共享地址
function editAddress()
{
	WeixinJSBridge.invoke(
		'editAddress',
		<?php echo $editAddress; ?>,
		function(res){
			var value1 = res.proviceFirstStageName;
			var value2 = res.addressCitySecondStageName;
			var value3 = res.addressCountiesThirdStageName;
			var value4 = res.addressDetailInfo;
			var tel = res.telNumber;
			
			alert(value1 + value2 + value3 + value4 + ":" + tel);
		}
	);
}

window.onload = function(){
	// if (typeof WeixinJSBridge == "undefined"){
	//     if( document.addEventListener ){
	//         document.addEventListener('WeixinJSBridgeReady', editAddress, false);
	//     }else if (document.attachEvent){
	//         document.attachEvent('WeixinJSBridgeReady', editAddress); 
	//         document.attachEvent('onWeixinJSBridgeReady', editAddress);
	//     }
	// }else{
	// 	editAddress();
	// }
	//document.addEventListener('WeixinJSBridgeReady', editAddress, false);
};

</script>



