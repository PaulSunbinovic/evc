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

<script type="text/javascript" src='__PUBLIC__/JS/index/regist.js'></script>
<link href="__PUBLIC__/CSS/index/regist.css" rel="stylesheet">
</head>
<body>

	
	<!--
	<iframe src="head.html"  frameborder="0" style="width:100%;height:100%;" scrolling="no"></iframe>
	-->
	

	<!--导航开始-->
	<div class='col-md-12 col-xs-12 nvgt'>
		<div class='col-md-3 col-xs-3'>
			<a class='pull-left hd_a_left' href="javascript:history.go(-1);"><i class='glyphicon glyphicon-menu-left'></i></a>
		</div>
		<div class='col-md-6 col-xs-6' style="text-align: center">
			<a style='color:#fff'>注册</a>
		</div>
		<div class='col-md-3 col-xs-3'>
			
		</div>
		
	</div>
	<!--导航结束-->

	<!--主体开始-->
	<div class='col-md-12 col-xs-12 bd'>
		<div class='col-md-12 col-xs-12 nopadding col-md-offset-6 col-xs-offset-6' style='top:10px'>
			<img class='img-circle headimg' src='<?php echo ($headImgUrl); ?>' />
		</div>
		
		<div class='col-md-12 col-xs-12' style='top:20px'>
			<form>
			  <div class="form-group">
			  	<input type='hidden' name='wechatId' value='<?php echo ($wechatId); ?>'>
			  	<input type='hidden' name='headImgUrl' value='<?php echo ($headImgUrl); ?>'>
				<input type="text" class="form-control" name="nickName" placeholder="怩称" value='<?php echo ($nickname); ?>' readonly>
			  </div>
			  <div class="form-group">
				<input type="tel" class="form-control" name="mobile" placeholder="手机号码">
			  </div>
			  <div class="form-group">
			    <select class="form-control" name='carBrand'>
				  <option value="0">选择车品牌</option>
				  <?php if(is_array($carBrandls)): $i = 0; $__LIST__ = $carBrandls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$carBrandv): $mod = ($i % 2 );++$i;?><option value='<?php echo ($carBrandv['carBrand']); ?>'><?php echo ($carBrandv['carBrand']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			  </div>
			  <div class="form-group">
			    <select class="form-control" name='carModelId' disabled>
				  <option value='0'>选择车型号</option>
				</select>
			  </div>
			  <div class="form-group">
				<input type="text" class="form-control" name="carNo" placeholder="车牌号">
			  </div>
			  <!--
			  <div class="checkbox" style='text-align: center'>
			    <label>
			      注册代表同意<a>《用户协议》</a>
			    </label>
			  </div>
			  -->

			  <input type="button" class="btn btn-primary btn-lg btn-block" id='addusr' value='注册'>
		</div>

		
	</div>
	

	

	<!--主体结束-->
	 
<!-- bootstrap -->
<script src="__PUBLIC__/pblc/btstp3/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="__PUBLIC__/pblc/btstp3/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript">var url_doregist='__URL__/doregist/x/usrct'</script>
<script type="text/javascript">var url_getcarmodel='__URL__/getcarmodel'</script>
<script type="text/javascript" src='__PUBLIC__/JS/index/base.js'></script>

</body>
</html>