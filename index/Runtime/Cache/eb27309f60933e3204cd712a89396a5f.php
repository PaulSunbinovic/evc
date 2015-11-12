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
		<div class='col-md-6 col-xs-6 nopadding col-md-offset-6 col-xs-offset-6' style='top:10px'>
			<img class='img-circle headimg' src='<?php echo ($headImgUrl); ?>' />
		</div>
		
		<div class='col-md-12 col-xs-12' style='top:20px'>
			<form>
			  <div class="form-group">
			  	<input type='hidden' name='wechatId' value='<?php echo ($wechatId); ?>'>
			  	<input type='hidden' name='headImgUrl' value='<?php echo ($headImgUrl); ?>'>
				<input type="text" class="form-control" name="nickName" placeholder="怩称" value='<?php echo ($nickname); ?>' readonly>
			  </div>
			  
			  <script type="text/javascript">var dogetsmsvrf='__URL__/dogetsmsvrf';</script>
				<div class="input-group">
			      <input class="form-control" placeholder="请输入手机号码" id="usrcp" name='mobile' type="tel" >
			      <span class="input-group-btn">
			        <button class="btn btn-primary" type="button" id="getsmsvrf">获取短信验证码</button>
			      </span>
			    </div>
			  
			  <div class="form-group" style='margin-top:20px'>
				<input type="tel" class="form-control" name="vrfnb" placeholder="请输入验证码" >
			  </div>
			 
			<div class="form-group" style='margin-top:20px;text-align: center'>
				 目前支持 比亚迪秦（14、15款），比亚迪唐，康迪
			</div>
			

			  <input type="button" class="btn btn-primary btn-lg btn-block" id='addusr' value='注册' disabled="">
		</div>

		
	</div>


<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" id='modal' style='display:none'>
	  获得券<b class="caret"></b><br>获得券<b class="caret"></b><br>获得券<b class="caret"></b><br>
</button>

<!-- Modal -->
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title" id="myModalLabel">获得充值券</h4>
      </div>
      <div class="modal-body" style='text-align: center;color:#449d44'>
      <h1>50元</h1>	
      </div>
      <div class="modal-footer">
        <a class="btn btn-success btn-lg btn-block" href='__URL__/usrct'>跳转进入个人中心</a>
        
      </div>
    </div>
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