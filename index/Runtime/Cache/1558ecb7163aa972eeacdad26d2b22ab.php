<?php if (!defined('THINK_PATH')) exit();?><script src="__PUBLIC__/pblc/btstp3/js/jquery.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
//设置微信js的参数 PS：在服务号中也需要设置
var appId="<?php echo ($spkg['appId']); ?>";
var timestamp="<?php echo ($spkg['timestamp']); ?>";
var nonceStr="<?php echo ($spkg['nonceStr']); ?>";
var signature="<?php echo ($spkg['signature']); ?>";
	/*
* 注意：
* 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
* 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
* 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
*
* 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
* 邮箱地址：weixin-open@qq.com
* 邮件主题：【微信JS-SDK反馈】具体问题
* 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
*/

//-------------------为方便电脑端测试，不再依靠微信定位虚拟一个点为自己
wx.config({
//debug: true,
appId: appId,
timestamp: timestamp,
nonceStr: nonceStr,
signature: signature,
jsApiList: [
  // 所有要调用的 API 都要加到这个列表中
  // "openLocation",
  "getLocation",
  "scanQRCode",
]
});


wx.ready(function () {
// 在这里调用 API

	wx.scanQRCode({
		needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
		scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
		success: function (res) {
		var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
		}
	});	
	window.location.href='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx682ad2cc417fe8b9&redirect_uri=http://www.evchar.cn/evc/oauth2_openid.php&response_type=code&scope=snsapi_base&state=index&connect_redirect=1#wechat_redirect';
});
	
	

</script>