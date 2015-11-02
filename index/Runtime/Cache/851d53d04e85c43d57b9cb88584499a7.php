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

<script type="text/javascript" src='__PUBLIC__/JS/index/baidumap.js'></script>
<script type="text/javascript" src='__PUBLIC__/JS/index/index.js'></script>

<link href="__PUBLIC__/CSS/index/base.css" rel="stylesheet">
<script>
var doapnt='__APP__/Index/doapnt';
var __url__='__URL__';
</script>

</head>
<body>

	
	<!--导航开始-->
<div class='col-md-12 col-xs-12 nvgt'>

	<div class='col-md-1 col-xs-1'>
		<!--
		<a class='pull-left hd_a_left' href="javascript:history.go(-1);"><i class='glyphicon glyphicon-menu-left'></i></a>
		-->
	</div>
	<div class='col-md-10 col-xs-10' style='text-align: center'>
		<a href="#" id='region' style='color:#fff'>
			附近 <b class="caret"></b>							
		</a>
		
		
	</div>

	<div class='col-md-1 col-xs-1'>
		<!--<a class='pull-right nvgt_a_right' href='search.html'><i class='glyphicon glyphicon-search'></i></a>-->
	</div>

</div>
<!--导航结束-->

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" id='modal' style='display: none'>
	  附近 <b class="caret"></b>	
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:200px;margin:80px auto;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">选择范围</h4>
      </div>
      <div class="modal-body">

        <ul class="dropdown-menu" style="display:block;position: relative">
			<li>
				<a href='__URL__/index/lth/1000'>10公里</a>
			</li>
			<li class="divider"></li>
			<li>
				<a href='__URL__/index/lth/2500'>25公里</a>
			</li>
			<li class="divider"></li>
			<li>
				<a href='__URL__/index/lth/5000'>50公里</a>
			</li>
			<li class="divider"></li>
			<li>
				<a href='__URL__/index/lth/10000'>100公里</a>
			</li>
			<li class="divider"></li>
			<li>
				<a href='__URL__/index/lth/all'>不限</a>
			</li>
		</ul>
		<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        
      </div>
    </div>
  </div>
</div>
	
<script>

	var crid=<?php echo ($usrdto['carList'][0]['id']); ?>;//暂时默认第一辆车是默认车
	var crno="<?php echo ($usrdto['carList'][0]['carNo']); ?>";
	var dvcid;
	var crmdlid=<?php echo ($usrdto['carList'][0]['carModelId']); ?>;
</script>
	

	<!--搜索开始-->
	<script type="text/javascript">var dofnddvcls='__URL__/dofnddvcls';</script>
	 <div class="col-md-12 col-xs-12 srch" style="line-height: 30px;padding-top:2px"  data-toggle="popover" title="搜索结果" data-placement="bottom" data-content="<ul  class='list-group'><li  class='list-group-item'>暂无结果</li></ul>" id='example'>
	

	    <div class="input-group">
	      <span class="input-group-btn">
	        <button class="btn btn-default" type="button"><i class='glyphicon glyphicon-search'></i></button>
	      </span>
	      <input type="text" class="form-control" placeholder="搜索..." id='ctt'>
	      <span class="input-group-btn">
	        <!--<button class="btn btn-default" type="button" id='srch'>搜索</button>-->
	      </span>
	    </div><!-- /input-group -->
	  </div><!-- /.col-lg-6 -->
	
	<!--搜索结束-->
	
	<!--主体开始-->
	<div class='col-md-12 col-xs-12 bd' style='top:80px;'>
				
		<script>
		//总
		var ctlgtd;var ctlttd;var pntarr = [];var mypoint;var p=[];
		</script>

		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script>
		//设置微信js的参数 PS：在服务号中也需要设置
		var appId="<?php echo ($spkg['appId']); ?>";
		var timestamp="<?php echo ($spkg['timestamp']); ?>";
		var nonceStr="<?php echo ($spkg['nonceStr']); ?>";
		var signature="<?php echo ($spkg['signature']); ?>";
		</script>
		<script src='__PUBLIC__/pblc/WX/wxoprt.js'></script>
		
		<link href='__PUBLIC__/pblc/BD/bd.css' rel="stylesheet">
		<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=S0VAW4LjQirp9FUmXF08Zvdy"></script>
		<div id="allmap"></div>
		<script type="text/javascript">
		//百度地图参数
		var dspdvc='__APP__/Cmn/dspdvc';
		var icnpth='__PUBLIC__/IMG/circle.png';
		var lvl=<?php echo ($lvl); ?>;
		var cdzpt='__PUBLIC__/IMG/chongdianzhuang.jpg';
		var apntprx='__URL__/order/deviceId';
		</script>
		<script type="text/javascript" src='__PUBLIC__/pblc/BD/bdoprt.js'></script>
		
		
	</div>
	

	


	<!--foot开始-->

<div class="btn-group btn-group-justified col-md-12 col-xs-12 ft" role="group" aria-label="...">
  <div class="btn-group" role="group" id='scanqr'>
    <a type="button" class="btn btn-primary" style='border:0px'><i class='glyphicon glyphicon-qrcode'></i><br>扫码</a>
  </div>
  <div class="btn-group" role="group"  id='apntok'>
    <a type="button" class="btn btn-primary" style='border:0px'><i class='glyphicon glyphicon-send'></i><br>一键预约</a>
  </div>
  <div class="btn-group" role="group"  id='usrct'>
    <a type="button" class="btn btn-primary" style='border:0px' ><i class='glyphicon glyphicon-user'></i><br>个人中心</a>
  </div>
</div>
<!--href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx682ad2cc417fe8b9&redirect_uri=http://www.evchar.cn/evc/oauth2_openid.php&response_type=code&scope=snsapi_base&state=usrct#wechat_redirect"-->
<!--foot结束-->

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal_qr" id='modal_qr' >
	  扫码 <b class="caret"></b>	
</button>

<!-- Modal -->
<div class="modal fade" id="myModal_qr" tabindex="-2" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id='cls'><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">选择扫码</h4>
      </div>
      <div class="modal-body">

        <div class='col-md-12 col-xs-12'>
        	<a class='btn btn-success btn-lg btn-block' id='opcmr'>到桩扫码</a>
        </div>
        <div class='clearfix'></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        
      </div>
    </div>
  </div>
</div>

<!--主体结束-->
<!--
<iframe src="foot.html"  frameborder="0"></iframe>
-->



<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal_cnclodr" id='modal_cnclodr' >
	  取消订单 <b class="caret"></b>	
</button>

<!-- Modal -->
<div class="modal fade" id="myModal_cnclodr" tabindex="-2" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id='cls_cnclodr'><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">取消订单</h4>
      </div>
      <div class="modal-body">

        <div class='col-md-12 col-xs-12' style='text-align: center;font-size: 20px;padding-top:20px;padding-bottom:20px'>
        	<script>var cnclodrid;</script>
        	您当前有一个订单:<a id='crno'></a>去<a id='ads'></a>充电的订单,如果不取消之前订单，将无法申请新订单。
        </div>
         <div class='col-md-12 col-xs-12'>
        	<div class='col-md-12 col-xs-12' style='padding-bottom:20px'>
        		<script>var docnclodr='__URL__/docnclodr';</script>
        		<a class='btn btn-success btn-lg btn-block' id='cnclapnt'>取消之前预约</a>
        	</div>

        	<div class='col-md-12 col-xs-12' style='padding-bottom:20px'>
        		<a class='btn btn-danger btn-lg btn-block' id='cls_cnclodr_trg'>关闭此对话框</a>
        	</div>
        </div>
        <div class='clearfix'></div>
      </div>
      
    </div>
  </div>
</div>


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal_hsgp" id='modal_hsgp' >
	  强制预约 <b class="caret"></b>	
</button>

<!-- Modal -->
<div class="modal fade" id="myModal_hsgp" tabindex="-2" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id='cls_hsgp'><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">余额提醒</h4>
      </div>
      <div class="modal-body">

        <div class='col-md-12 col-xs-12' style='text-align: center;font-size: 20px;padding-top:20px;padding-bottom:20px'>
        	<script>var cnclodrid;</script>
        	您的余额还有<a id='mny'></a>元，预计可充电<a id='tm'></a>小时。
        </div>
         <div class='col-md-12 col-xs-12'>
        	<div class='col-md-12 col-xs-12' style='padding-bottom:20px'>
        		<script>var docnclodr='__URL__/docnclodr';</script>
        		<a class='btn btn-success btn-lg btn-block' id='fcapnt'>依然进行预约</a>
        	</div>

        	<div class='col-md-12 col-xs-12' style='padding-bottom:20px'>
        		<a class='btn btn-danger btn-lg btn-block' id='cls_hsgp_trg'>关闭此对话框</a>
        	</div>
        </div>
        <div class='clearfix'></div>
      </div>
      
    </div>
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