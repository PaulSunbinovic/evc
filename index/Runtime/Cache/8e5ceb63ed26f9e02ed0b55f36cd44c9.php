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

<script type="text/javascript" src='__PUBLIC__/JS/index/payment.js'></script>
<link href="__PUBLIC__/CSS/index/payment.css" rel="stylesheet">


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

	
	<!--主体开始-->
	
	<div class='col-md-12 col-xs-12 bd' style='top:200px'>
		<div  class="col-md-12 col-xs-12 nopadding" style="height:150px;background-color: #fff;position:fixed;top:50px;z-index: 1000;border-bottom: solid 1px #ccc">
			<div class='col-md-12 col-xs-12' style='height: 40px;line-height: 40px'>
				<ft style='color:#aaa;font-size: 12px'>当前余额：</ft>
			</div>
			<div class='col-md-12 col-xs-12' style='height: 60px;line-height: 60px'>
				<ft style='color:#dfaa55;font-size: 50px'><?php echo ($balance); ?></ft><ft style='color:#dfaa55;font-size: 18px;margin-left: 10px'>元</ft>
			</div>
			<div class='col-md-12 col-xs-12 nopadding'>
				<div class='col-md-6 col-xs-6'><a class='btn btn-default btn-block disabled' style='background-color: #ddd' >提现（暂未开通）</a></div>
				<div class='col-md-6 col-xs-6'><a class='btn btn-success btn-block' href='__URL__/chongzhi'>充值</a></div>
			</div>
			<div class='clearfix'></div>
		</div>
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/pblc/PLDN/iscroll.css">
		<div id='mainarea' class='col-md-12 col-xs-12'>
			
			<script type="text/javascript">var srlnb=0;//serial number</script>
			
        	<?php if(is_array($paymentls)): $i = 0; $__LIST__ = $paymentls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$paymentv): $mod = ($i % 2 );++$i;?><script type="text/javascript">srlnb++;</script>
        		<div class="col-md-12 col-xs-12 nopadding wrp">
        			<div class='col-md-6 col-xs-6'><mingmu class='pull-left mingmu'><?php echo ($paymentv['desc']); ?></mingmu></div>
        			<div class='col-md-6 col-xs-6'><tm class='pull-right tm'><?php echo ($paymentv['tm']); ?></tm></div>
        		
        			<div class='col-md-12 col-xs-12' style="color:<?php echo ($paymentv['color']); ?>"><tm class='pull-right'><?php echo ($paymentv['mark']); echo ($paymentv['mny']); ?></tm></div>
        		</div><?php endforeach; endif; else: echo "" ;endif; ?>
					
		</div>
			
		<script type="text/javascript">
		//########初始化参数
		var dodnfrsh='__URL__/dodnfrsh_payment';//do slidedown fresh
		var doupld='__URL__/doupld_payment';//do slideup loading
		var nwpg=0;//now page 当前页必然是第0页初始时候
		var exe=1;//一上来就可以执行
		</script>
		<div id='loading' class='col-md-12 col-xs-12' style="text-align: center">加载中...</div>
		<script>
		<?php if($hasnext===1){ ?>$('#loading').html('下拉加载更多...');<?php }else{ ?>$('#loading').html('已无更多信息');<?php } ?>
		</script>
		<script src="__PUBLIC__/JS/index/payment.js"></script>
	</div>
	





<!-- bootstrap -->
<script src="__PUBLIC__/pblc/btstp3/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="__PUBLIC__/pblc/btstp3/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript">var vrfusrstat='__APP__/Cmn/vrfusrstat';</script>
<script type="text/javascript" src='__PUBLIC__/JS/index/base.js'></script>

</body>
</html>