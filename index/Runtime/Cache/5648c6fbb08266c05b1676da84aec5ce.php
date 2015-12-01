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

<script type="text/javascript" src='__PUBLIC__/JS/index/usrct.js'></script>
<link href="__PUBLIC__/CSS/index/usrct.css" rel="stylesheet">
</head>
<body style='background-color: #ddd'>

	
	<!--
	<iframe src="head.html"  frameborder="0" style="width:100%;height:100%;" scrolling="no"></iframe>
	-->
	

	<!--导航开始-->
<style type="text/css">
	.nvgt_green{font-size: 20px;background-color: #00af50;height:50px;line-height: 50px;color:#fff;}
	.nvgt_green a{color:#fff;}
</style>
<div class='col-md-12 col-xs-12 nvgt_green nopadding'>
	<div class='col-md-3 col-xs-3' onclick="window.location.href='__APP__'" style="text-align: center">
		<a class='pull-left'><i class='glyphicon glyphicon-menu-left'></i></a>
	</div>
	<div class='col-md-6 col-xs-6' style="text-align: center">
		<a style='color:#fff' onclick='test()'><?php echo ($ttl); ?></a>
	</div>
	<div class='col-md-3 col-xs-3' onclick="window.location.reload()" style='text-align: center'>
		<a class='pull-right'><i class='glyphicon glyphicon-repeat'></i> </a>
	</div>
	
</div>

	<div class='col-md-12 col-xs-12 nopadding'>
		<?php if(is_array($couponls)): $i = 0; $__LIST__ = $couponls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$couponv): $mod = ($i % 2 );++$i;?><div class='col-md-12 col-xs-12 nopadding' style='height:100px;margin-top:5px;background-image: url(__PUBLIC__/IMG/coupon/coupon_III.png);height: 100px'>
				
				<div class='col-md-10 col-xs-10 nopadding' >
					<div class="pull-left" style="background-image: url(__PUBLIC__/IMG/coupon/coupon_I.png);width:34px;height:100px;background-color: #ddd"></div>
					<div class="pull-left" style="background-color: #00af50;font-size: 35px;color:#fff;line-height: 100px;text-align: center" ><?php echo ($couponv['cValue']); ?></div>
					<div class="pull-left" style="background-image: url(__PUBLIC__/IMG/coupon/coupon_II.png);width:56px;height:100px;background-color: #ddd"></div>
					<div class="pull-left" style="background-image: url(__PUBLIC__/IMG/coupon/coupon_III.png);height:100px;line-height: 27px;padding-top:10px;padding-bottom: 10px;background-color: #ddd">
						<lbl style='color:#ccc;padding-right: 10px'>券&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</lbl><?php echo ($couponv['cDescribe']); ?><br>
						<lbl style='color:#ccc;padding-right: 10px'>使用条件</lbl>无条件<br>
						<lbl style='color:#ccc;padding-right: 10px'>有效期至</lbl><?php echo ($couponv['expireTime']); ?>
					</div>
				</div>
				<div class='col-md-2 col-xs-2 nopadding'>
					<div class="pull-right" style="background-image: url(__PUBLIC__/IMG/coupon/coupon_IIII.png);width:70px;height:100px; background-color: #ddd"></div>			
				</div>
				
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	
	<?php if($hascoupon=='n'){ ?>
	<div class='col-md-12 col-xs-12 nopadding' style='background-color: #fff;height:100px;line-height: 100px;margin-top:5px;text-align: center'>
		您当前没有优惠券
		
	</div>
	<?php } ?>
	




<!-- bootstrap -->
<script src="__PUBLIC__/pblc/btstp3/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="__PUBLIC__/pblc/btstp3/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript" src='__PUBLIC__/JS/index/base.js'></script>





</body>
</html>