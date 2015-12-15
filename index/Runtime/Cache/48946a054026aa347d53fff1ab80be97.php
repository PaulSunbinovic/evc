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

<script type="text/javascript" src='__PUBLIC__/JS/index/handdvc.js'></script>
<link href="__PUBLIC__/CSS/index/handdvc.css" rel="stylesheet">



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

	
	
	<div class='col-md-12 col-xs-12 bd'>
		<!--#######寻找用户-->
		<div class='col-md-12 col-xs-12'>
			电话号码：<input class='form-control' id='mobile' placeholder='请输入手机号码以寻找用户'>
		</div>
		<div class='col-md-12 col-xs-12' style="margin-top: 20px">
			<script type="text/javascript">var dofindusrls='__URL__/dofindusrls';</script>
			<button class='btn btn-info btn-lg btn-block' id='getusrlsbymobile'>获取用户列表</button>
		</div>
		<div class='col-md-12 col-xs-12' style="margin-top: 20px">
			<select class="form-control" id='wechatid'>
			  <option value='无'>无</option>
			</select>
		</div>
		<div class='col-md-12 col-xs-12' style="margin-top: 20px">
			<script type="text/javascript">var dohanddvc='__URL__/dohanddvc';</script>
			<button class='btn btn-success btn-lg btn-block' id='dohanddvc'>移交设备</button>
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