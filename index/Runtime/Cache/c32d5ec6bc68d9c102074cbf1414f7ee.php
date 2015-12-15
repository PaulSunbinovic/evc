<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<!-- 避免IE使用兼容模式 -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>电车惠</title>
<script src="__PUBLIC__/pblc/btstp3/js/jquery.js"></script>
<script src="__PUBLIC__/pblc/btstp3/js/jquery-migrate-1.1.0.min.js"></script>

<!-- 移动设备 -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<!-- bootstrap -->
<link href="__PUBLIC__/pblc/btstp3/css/bootstrap.css" rel="stylesheet">
<link href="data:text/css;charset=utf-8," data-href="__PUBLIC__/pblc/btstp3/css/bootstrap-theme.min.css" rel="stylesheet">
<link href="__PUBLIC__/pblc/btstp3/css/patch.css" rel="stylesheet">
<script src="__PUBLIC__/pblc/btstp3/js/ie-emulation-modes-warning.js"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- Favicons -->
<link rel="apple-touch-icon" href="__PUBLIC__/ICON/apple-touch-icon.png">
<link rel="icon" href="ICON/favicon.ico">


<link href="__PUBLIC__/CSS/index/base.css" rel="stylesheet">

<script type="text/javascript" src='__PUBLIC__/JS/index/binddvc.js'></script>
<link href="__PUBLIC__/CSS/index/binddvc.css" rel="stylesheet">


</head>
<body>
	
	<!--导航开始-->
<style type="text/css">
	.nvgt_green{font-size: 20px;background-color: #00af50;height:50px;line-height: 50px;color:#fff;position: fixed;z-index: 6000}
	.nvgt_green a{color:#fff;}
</style>
<div class='col-md-12 col-xs-12 nvgt_green nopadding'>
	<div class='col-md-3 col-xs-3' onclick="history.go(-1)" style="text-align: center">
		<a class='pull-left'><i class='glyphicon glyphicon-menu-left'></i></a>
	</div>
	<div class='col-md-6 col-xs-6' style="text-align: center">
		<a style='color:#fff' onclick='test()'><?php echo ($ttl); ?></a>
	</div>
	<div class='col-md-3 col-xs-3' onclick="window.location.reload()" style='text-align: center'>
		<a class='pull-right'><i class='glyphicon glyphicon-repeat'></i> </a>
	</div>
	
</div>

	
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script>
	//设置微信js的参数 PS：在服务号中也需要设置
	var appId="<?php echo ($spkg['appId']); ?>";
	var timestamp="<?php echo ($spkg['timestamp']); ?>";
	var nonceStr="<?php echo ($spkg['nonceStr']); ?>";
	var signature="<?php echo ($spkg['signature']); ?>";
	</script>
	<!--主体开始-->
	<script>
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

	    wx.getLocation({
	      type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
	      async: false,  //----------加入等你呀，因为，wx产生坐标到时候由，异步的原因，百度先去了搞了，此时是没有坐标到，然后...
	      success: function (res) {

	          //#################如果获取不到纬度就刷新一次
	          
              var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
              var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
              var speed = res.speed; // 速度，以米/每秒计
              var accuracy = res.accuracy; // 位置精度
              


              mypnt={lgtd:longitude,lttd:latitude,name:'我的位置'};
              
               //百度地图部分，从微信上的google坐标 换算成 百度坐标
              var ggPoint = new BMap.Point(mypnt.lgtd,mypnt.lttd);
              var convertor = new BMap.Convertor();
              var pointArr = [];
              pointArr.push(ggPoint);
              convertor.translate(pointArr, 3, 5, translateCallback);
         
	          
	      }
	   	});
		
	});

	//坐标转换完之后的回调函数
	translateCallback = function (data){
	  if(data.status === 0) {

	  	mypoint = data.points[0];
	  	//这段代码可以查看某个对象有哪些元素的
	  	// for(i in mypoint){
	  	// 	alert(i);//属性名称
	  	// 	alert(mypoint[i]);//属性值
	  	// }
	  	ctlgtd=mypoint['lng'];
	  	ctlttd=mypoint['lat'];
	    //调用百度的js里面到函数
	    $('#lgtd').val(ctlgtd);
	  	$('#lttd').val(ctlttd);
	    
	  }
	}
	</script>
	<div class='col-md-12 col-xs-12 bd'>
		<div style='height:50px;line-height: 50px;padding-left: 50px;border-bottom: 1px solid #ccc'>
			<nm style='font-size: 16px;font-weight: bold'><?php echo ($usrdto['user']['nickName']); ?></nm>
		</div>
		<div class='col-md-12 col-xs-12'>
			经度：<input class='form-control' readonly id='lgtd'>
			纬度：<input class='form-control' readonly id='lttd'>
			SN码：<input class='form-control' placeholder='请在此处设置SN码' id='sn'>
		</div>
		<div class='col-md-12 col-xs-12'>
			<button class='btn btn-success btn-lg btn-block' style='margin-top:20px' id='dobinddvc'>点击绑定</button>
		</div>
	</div>
	





<!-- bootstrap -->
<script src="__PUBLIC__/pblc/btstp3/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="__PUBLIC__/pblc/btstp3/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript">var vrfusrstat='__APP__/Cmn/vrfusrstat';</script>
<script type="text/javascript" src='__PUBLIC__/JS/index/base.js'></script>

</body>
</html>