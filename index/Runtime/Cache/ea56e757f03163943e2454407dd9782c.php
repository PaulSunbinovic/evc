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

<!--###########说明已经开关未被初始化过了########-->
<script type="text/javascript">swcinited=0;</script>
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


	<!--主体开始-->
	<div class='col-md-12 col-xs-12 bd_usrct'>
		<!--##########################################-->
		<div class='col-md-12 col-xs-12' style='padding:10px;margin-bottom:0px;background-color: #00af50'>
			
		  	<div class='col-md-12 col-xs-12'>
		  		<div class='col-md-4 col-xs-4 nopadding'><img src="<?php echo ($usrdto['user']['headImgUrl']); ?>" style='width:80px;height:80px;' class='img-circle'></div>
				<div class='col-md-7 col-xs-7 nopadding' style='color:#fff;'>
					<div><h3><?php echo ($usrdto['user']['nickName']); ?></h3></div>
					<!--因为IPhone上是蓝色的，这里再次强制转色-->
					<div class="color:#fff">
						<?php echo ($usrdto['user']['mobile']); ?>
					</div>
					
				</div>
				<div class='col-md-1 col-xs-1 nopadding' style='color:#fff;'>
					
					<div>
						<h3 class='pull-right'><i class='glyphicon glyphicon-menu-right'></i></h3>
					</div>
					
				</div>
				
				
			</div>
			
		</div>
		<!--##########################################-->
		<div class='col-md-12 col-xs-12 nopadding' style='height:90px;background-color: #fff'>
			<div class='col-md-4 col-xs-4 nopadding' style='height:90px;text-align: center;border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;padding-top:25px;'>
				<div><numb style='font-size: 25px;color:#00af50'><?php echo ($balance); ?></numb> <unt style='font-size: 10px;color:#00af50'>元</unt></div>
				<div>我的余额</div>
			</div>
			<div class='col-md-4 col-xs-4 nopadding' style='height:90px;text-align: center;border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;padding-top:25px;' onclick="window.location.href='__URL__/coupon'">
				<div><numb style='font-size: 25px;color:#00af50'><?php echo ($couponnumber); ?></numb> <unt style='font-size: 10px;color:#00af50'>个</unt></div>
				<div>我的优惠券</div>
			</div>
			<div class='col-md-4 col-xs-4 nopadding' style='height:90px;text-align: center;border-bottom: 1px solid #ccc;padding-top:25px;' onclick="window.location.href='__URL__/chongzhi'">
				<div><numb style='font-size: 25px;color:#00af50'><i class='glyphicon glyphicon-yen'></i></numb> <unt style='font-size: 10px;color:#00af50'></unt></div>
				<div>充值</div>
			</div>
		</div>
		<!--##########################################-->

		<link href="__PUBLIC__/pblc/SWC/bootstrap-switch.css" rel="stylesheet">
		
		<div class='col-md-12 col-xs-12 nopadding' style='margin-top:10px;'>
			<?php if(is_array($dvcls)): $i = 0; $__LIST__ = $dvcls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dvcv): $mod = ($i % 2 );++$i;?><!--##########################-->
				<div class='col-md-12 col-xs-12' style='border-bottom: 1px solid  #ccc;background-color: #fff;height:60px;line-height: 60px'>
					<div class='col-md-3 col-xs-3 nopadding' style='font-size: 16px'>
						<div class='pull-left'>
						<i class='glyphicon glyphicon-off' style='color:#f65641'></i> 开关
						</div>
					</div>
					<div class='col-md-9 col-xs-9 nopadding' style='font-size: 16px'>
						<div class='pull-right'>
						<lbl id="lbl_swc_<?php echo ($dvcv['id']); ?>" style='margin-right:5px'>OFF</lbl><input type="checkbox" id="dvc_<?php echo ($dvcv['id']); ?>" >
						</div>
					</div>

				</div>
				<script type="text/javascript">
				check_dvc("<?php echo ($dvcv['stts']); ?>","<?php echo ($dvcv['id']); ?>","<?php echo ($dvcv['online']); ?>","<?php echo ($dvcv['onodr']); ?>");
				</script>
				<script type="text/javascript">var doonoff='__URL__/doonoff';</script>
				<!--##########################-->
				<div class='col-md-12 col-xs-12' style='border-bottom: 1px solid  #ccc;background-color: #fff;height:60px;line-height: 60px'>
					<div class='col-md-3 col-xs-3 nopadding' style='font-size: 16px'>
						<div class='pull-left'>
						<i class='glyphicon glyphicon-stats' style='color:#6f7c88'></i> 可调功率
						</div>
					</div>
					<div class='col-md-9 col-xs-9 nopadding' style='font-size: 16px'>
						<div class='pull-right'>
						<lbl id="lbl_capacity_<?php echo ($dvcv['id']); ?>" style='margin-right:5px'>1.5KW</lbl><input type="checkbox" id="capacity_<?php echo ($dvcv['id']); ?>" >
						</div>
					</div>

				</div>
				<script type="text/javascript">
				check_capacity("<?php echo ($dvcv['capacity']); ?>","<?php echo ($dvcv['id']); ?>","<?php echo ($dvcv['online']); ?>","<?php echo ($dvcv['onodr']); ?>","<?php echo ($dvcv['stts']); ?>");
				</script>
				<script type="text/javascript">var dochangecapacity='__URL__/dochangecapacity';</script>
				<!--##########################-->
				<div class='col-md-12 col-xs-12' style='border-bottom: 1px solid  #ccc;background-color: #fff;height:60px;line-height: 60px'>
					<div class='col-md-3 col-xs-3 nopadding' style='font-size: 16px'>
						<div class='pull-left'>
						<i class='glyphicon glyphicon-flash' style='color:#f0ad4e'></i> 半价电
						</div>
					</div>
					<div class='col-md-9 col-xs-9 nopadding' style='font-size: 16px'>
						<div class='pull-right'>
						<lbl id="lbl_timer_<?php echo ($dvcv['id']); ?>" style='margin-right:5px'>未启用</lbl><input type="checkbox" id="timer_<?php echo ($dvcv['id']); ?>" >
						</div>
					</div>

				</div>
				<script type="text/javascript">
				check_timer("<?php echo ($dvcv['timer']); ?>","<?php echo ($dvcv['id']); ?>","<?php echo ($dvcv['online']); ?>");
				</script>
				<script type="text/javascript">var dochangetimer='__URL__/dochangetimer';</script>
				<!--##########################-->
				<div class='col-md-12 col-xs-12' style='border-bottom: 1px solid  #ccc;background-color: #fff;height:60px;line-height: 60px;margin-top:10px'>
					<div class='col-md-3 col-xs-3 nopadding' style='font-size: 16px'>
						<div class='pull-left'>
						<i class='glyphicon glyphicon-user' style='color:#6f7c88'></i> 共享时段
						</div>
					</div>
					<div class='col-md-9 col-xs-9 nopadding' style='font-size: 16px'>
						<div class='pull-right'>
						<lbl id="lbl_share_<?php echo ($dvcv['id']); ?>" style='margin-right:5px'>不共享</lbl><input type="checkbox" id="share_<?php echo ($dvcv['id']); ?>" >
						</div>
					</div>

				</div>
				<script type="text/javascript">
				check_share("<?php echo ($dvcv['share']); ?>","<?php echo ($dvcv['id']); ?>","<?php echo ($dvcv['online']); ?>","<?php echo ($dvcv['onodr']); ?>");
				</script>
				<script type="text/javascript">var dochangeshare='__URL__/dochangeshare';</script><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>

		<!--#############历史订单-->
		<div class='col-md-12 col-xs-12' style='border-bottom: 1px solid  #ccc;background-color: #fff;height:60px;line-height: 60px;margin-top:10px'>
			<div class='col-md-5 col-xs-5 nopadding' style='font-size: 16px'>
				<div class='pull-left'>
				<i class='glyphicon glyphicon-time' style='color:#6f7c88'></i> 历史订单记录
				</div>
			</div>
			<div class='col-md-7 col-xs-7 nopadding' style='font-size: 16px;color:#888' onclick="window.location.href='__URL__/hstr_odr'">
				<div class='pull-right'>
				<i class='glyphicon glyphicon-menu-right'></i>
				</div>
			</div>

		</div>

		<!--#############反馈-->
		<div class='col-md-12 col-xs-12' style='border-bottom: 1px solid  #ccc;background-color: #fff;height:60px;line-height: 60px;margin-top:10px'>
			<div class='col-md-5 col-xs-5 nopadding' style='font-size: 16px'>
				<div class='pull-left'>
				<i class='glyphicon glyphicon-edit' style='color:#6f7c88'></i> 反馈
				</div>
			</div>
			<div class='col-md-7 col-xs-7 nopadding' style='font-size: 16px;color:#888' onclick="window.location.href='http://www.evchar.cn'">
				<div class='pull-right'>
				<i class='glyphicon glyphicon-menu-right'></i>
				</div>
			</div>

		</div>

		  
	</div>
	
	
	



	<!--主体结束-->

	<!--foot-->





<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal_loading" id='modal_loading' style='display: none'>
	  loading<b class="caret"></b>	
</button>
<script>var dotakesample='__URL__/dotakesample'</script>
<!-- Modal -->
<div class="modal" id="myModal_loading" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style='margin-top:200px;' >
    <div class="modal-content">
      
      <div class="modal-body">
      	<div class='col-md-12 col-xs-12' style='text-align: center;font-size: 18px'>俺正在全力以赴...</div>
      	<div class='clearfix'></div>
      	<div class="progress">
		  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;height:100px;">
		    <span class="sr-only">loading...</span>
		  </div>
		</div>
		<div class="modal-footer">
	        <button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal" id='cancel_loading' style='display:none'>取消</button>
	        
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
<script src="__PUBLIC__/pblc/SWC/highlight.js"></script>
<script src='__PUBLIC__/pblc/SWC/bootstrap-switch.js'></script>
<script src='__PUBLIC__/pblc/SWC/main.js'></script>

<!--###########说明已经开关被初始化过了########-->
<script type="text/javascript">swcinited=1;</script>

</body>
</html>