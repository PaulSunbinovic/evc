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

<link href="__PUBLIC__/CSS/index/base.css" rel="stylesheet">

<script type="text/javascript" src='__PUBLIC__/JS/index/chongzhi.js'></script>
<link href="__PUBLIC__/CSS/index/chongzhi.css" rel="stylesheet">
</head>
<body>

	
	<!--
	<iframe src="head.html"  frameborder="0" style="width:100%;height:100%;" scrolling="no"></iframe>
	-->
	

	<!--导航开始-->
<div class='col-md-12 col-xs-12 nvgt'>
	<div class='col-md-3 col-xs-3' >
		<a class='pull-left hd_a_left' href="javascript:history.go(-1);"><i class='glyphicon glyphicon-menu-left'></i></a>
	</div>
	<div class='col-md-6 col-xs-6' style="text-align: center">
		<a style='color:#fff'><?php echo ($ttl); ?></a>
	</div>
	<div class='col-md-3 col-xs-3' >
		<a class='pull-right hd_a_right' id='flsh'><i class='glyphicon glyphicon-repeat'></i></a>
	</div>
	
</div>
<!--导航结束-->
<script type="text/javascript">
	$(function(){
		$('#flsh').click(function(){
			window.location.reload();
		})
	})
</script>

	<!--主体开始-->
	<div class='col-md-12 col-xs-12 bd'>
		<div class="page-header" style='text-align: center'>
		  	<h1><small>选择面额进行充值</small></h1>
		</div>
		<div class='col-md-12 col-xs-12'>
			<div class='row' style='margin-top: 15px; margin-bottom: 15px;'>
				<div class="col-md-4 col-xs-4">
					<a class='btn btn-success btn-lg btn-block' href="__ROOT__/wxpay/example/jsapi.php?money=30">30元</a>
				</div>
				<div class="col-md-4 col-xs-4">
					<a class='btn btn-success btn-lg btn-block' href="__ROOT__/wxpay/example/jsapi.php?money=30">50元</a>
				</div>
				<div class="col-md-4 col-xs-4">
					<a class='btn btn-success btn-lg btn-block' href="__ROOT__/wxpay/example/jsapi.php?money=30">100元</a>
				</div>
			</div>
			<div class='row' style='margin-top: 15px; margin-bottom: 15px;'>
				<div class="col-md-4 col-xs-4">
					<a class='btn btn-success btn-lg btn-block' href="__ROOT__/wxpay/example/jsapi.php?money=30">200元</a>
				</div>
				<div class="col-md-4 col-xs-4">
					<a class='btn btn-success btn-lg btn-block' href="__ROOT__/wxpay/example/jsapi.php?money=30">300元</a>
				</div>
				<div class="col-md-4 col-xs-4">
					<a class='btn btn-success btn-lg btn-block' href="__ROOT__/wxpay/example/jsapi.php?money=30">500元</a>
				</div>
			</div>
			<div class='row' style='margin-top: 15px; margin-bottom: 15px;'>
				<div class="col-md-12 col-xs-12">
					<a class='btn btn-info btn-lg btn-block' data-toggle="modal" data-target="#myModal">自定义充值数</a>
				</div>
			</div>
		</div>
		
			 
		
		<style type="text/css">.modal-backdrop.in{opacity: 0.9}</style>
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">自定义充值数</h4>
		      </div>
		      <div class="modal-body">

				<form>
			      	<div class="form-group">
			    	    <div class="input-group">
					      <div class="input-group-addon">￥</div>
					      <input type="number" class="form-control input-lg" id="exampleInputAmount" placeholder="请输入金额" name='money'>
					      <div class="input-group-addon">元</div>
					    </div>
				  	</div>
					 <input type="button" class="btn btn-success btn-lg btn-block" id='chongzhi' value='立即充值'>
				</form>

		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
		        
		    </div>
		  </div>
		</div> 
			
		  
		
		 
		
	</div>
	

	

	<!--主体结束-->
	 
<!-- bootstrap -->
<script src="__PUBLIC__/pblc/btstp3/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="__PUBLIC__/pblc/btstp3/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript">var dochongzhi='__URL__/dochongzhi';</script>
<script type="text/javascript" src='__PUBLIC__/JS/index/base.js'></script>

</body>
</html>