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

<script type="text/javascript" src='__PUBLIC__/JS/index/hstr_odr.js'></script>
<link href="__PUBLIC__/CSS/index/regist.css" rel="stylesheet">


<link rel="stylesheet" type="text/css" href="__PUBLIC__/pblc/ISCRL/scrollbar.css">
<script type="application/javascript" src="__PUBLIC__/pblc/ISCRL/iscroll.js"></script>
<script type="text/javascript" src='__PUBLIC__/pblc/ISCRL/int.js'></script>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/pblc/ISCRL/int.css">


<script type="text/javascript">var docancelapnt='__URL__/docancelapnt';</script>
<script type="text/javascript">var dochecktimeout='__URL__/dochecktimeout';</script>
<script type="text/javascript">var dojiesuan='__URL__/dojiesuan';</script>
</head>
<body>
	
	<!--导航开始-->
<style type="text/css">
	.nvgt_green{font-size: 20px;background-color: #00af50;height:50px;line-height: 50px;color:#fff;}
	.nvgt_green a{color:#fff;}
</style>
<div class='col-md-12 col-xs-12 nvgt_green nopadding'>
	<div class='col-md-3 col-xs-3' onclick="window.location.href='__URL__/usrct'" style="text-align: center">
		<a class='pull-left'><i class='glyphicon glyphicon-menu-left'></i></a>
	</div>
	<div class='col-md-6 col-xs-6' style="text-align: center">
		<a style='color:#fff' onclick='test()'><?php echo ($ttl); ?></a>
	</div>
	<div class='col-md-3 col-xs-3' onclick="window.location.reload()" style='text-align: center'>
		<a class='pull-right'><i class='glyphicon glyphicon-repeat'></i> </a>
	</div>
	
</div>

	<!--###############################这里加上个切换 查看已完成订单，正在预约的订单，未结算订单3种-->
	<div class='col-md-12 col-xs-12 nopadding' style='position: fixed;top:50px;height:40px;line-height: 40px;background-color: #00af50;color:#fff;'>
		
		<?php if($odrstatus==0){ ?>
		<div class='col-md-3 col-xs-3 nopadding' style='text-align: center;background-color: #25ba69;color:#fff' onclick="window.location.href='__URL__/hstr_odr/odrstatus/0'">
		<?php }else{ ?>
		<div class='col-md-3 col-xs-3 nopadding' style='text-align: center;' onclick="window.location.href='__URL__/hstr_odr/odrstatus/0'">
		<?php } ?>
			已预约
		</div>
		<?php if($odrstatus==4){ ?>
		<div class='col-md-3 col-xs-3 nopadding' style='text-align: center;background-color: #25ba69;color:#fff' onclick="window.location.href='__URL__/hstr_odr/odrstatus/4'">
		<?php }else{ ?>
		<div class='col-md-3 col-xs-3 nopadding' style='text-align: center;' onclick="window.location.href='__URL__/hstr_odr/odrstatus/4'">
		<?php } ?>
			正充电
		</div>
		<?php if($odrstatus==6){ ?>
		<div class='col-md-3 col-xs-3 nopadding' style='text-align: center;background-color: #25ba69;color:#fff' onclick="window.location.href='__URL__/hstr_odr/odrstatus/6'">
		<?php }else{ ?>
		<div class='col-md-3 col-xs-3 nopadding' style='text-align: center;' onclick="window.location.href='__URL__/hstr_odr/odrstatus/6'">
		<?php } ?>
			已完成
		</div>
		<?php if($odrstatus==5){ ?>
		<div class='col-md-3 col-xs-3 nopadding' style='text-align: center;background-color: #25ba69;color:#fff' onclick="window.location.href='__URL__/hstr_odr/odrstatus/5'">
		<?php }else{ ?>
		<div class='col-md-3 col-xs-3 nopadding' style='text-align: center;' onclick="window.location.href='__URL__/hstr_odr/odrstatus/5'">
		<?php } ?>
			未结算
		</div>
		
	</div>

	<div class='col-md-12 col-xs-12' style='position:fixed;top:90px;z-index: 1000;border-bottom: 1px solid #ccc;height:50px;text-align: center;line-height: 50px;'>
		<!--<div class='col-md-1 col-xs-1 nopadding'>序号</div>-->
		<!--<div class='col-md-3 col-xs-3 nopadding'>车牌</div>-->
		<div class='col-md-4 col-xs-4 nopadding'>桩名</div>
		<div class='col-md-3 col-xs-3 nopadding'>创建时间</div>
		<div class='col-md-3 col-xs-3 nopadding'>消费</div>
		<div class='col-md-2 col-xs-2 nopadding'>状态</div>
	</div>
	<div id="wrapper">
		<div id="scroller">
			<div id="pullDown" style="text-align: center">
				<span class="pullDownLabel">下拉刷新</span>
			</div>
			
			<ul id="thelist" style='text-align: center;'>
			<script type="text/javascript">
			var srlnb=0;//serial number
			var odrls=new Array();
			var odrstatus=<?php echo ($odrstatus); ?>;
			</script>
				<?php if(is_array($odrls)): $i = 0; $__LIST__ = $odrls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$odrv): $mod = ($i % 2 );++$i;?><script type="text/javascript">
					srlnb++;
					odrls[<?php echo ($odrv['id']); ?>]=<?php echo ($odrv['json']); ?>;
					</script>

					<li style="line-height: 80px;">
						<div class='col-md-12 col-xs-12 '>
							<!--<div class='col-md-1 col-xs-1 nopadding'><?php echo ($i); ?></div>-->
							<!--<div class='col-md-3 col-xs-3 nopadding'><?php echo ($odrv['cro']['carNo']); ?></div>-->
							<div class='col-md-4 col-xs-4 nopadding'><?php echo ($odrv['dvcnm']); ?></div>
							<div class='col-md-3 col-xs-3 nopadding'><?php echo ($odrv['createTime']); ?></div>
							<div class='col-md-3 col-xs-3 nopadding'><?php echo ($odrv['totalPrice']); ?></div>
							<div class='col-md-2 col-xs-2 nopadding'>
							<?php if($odrv['status']=='0'){ ?>
							<button class='btn btn-danger btn-sm' onclick="cancelapnt(<?php echo ($odrv['id']); ?>)">取消预约</button>
							<?php }else if($odrv['status']=='5'){ ?>
							<button class='btn btn-info btn-sm' onclick="jiesuan(<?php echo ($odrv['id']); ?>)">完成结算</button>
							<?php }else if($odrv['status']=='6'){ ?>
							<status style='color:#00af50'>已完成</status>
							<?php } ?>
							</div>
						</div>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			
			<div id="pullUp" style="text-align: center">
				<span class="pullUpLabel" id='pullUp-msg'><?php echo ($upstr); ?></span>
			</div>
			
		</div>
	</div>
		<script type="text/javascript">
		var dodnfrsh='__URL__/dodnfrsh_odr';//do slidedown fresh
		var doupld='__URL__/doupld_odr';//do slideup loading
		//slideDown 和 slideUp函数写在hstr_odr.js里面//
		var pgnumber=1;//now page 当前页必然是第0页初始时候,王峰从1开始算的
		</script>
		
	
	

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style='display:none' id='modal'>
  显示细节
</button>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">预约订单详情</h4>
      </div>
      <div class="modal-body">
       		<div class='col-md-12 col-xs-12'>
       			<table class='table table-responsive table-striped' style='border: #fff'>
       				<tr><td>车牌号</td><td><ctt id='crno'></ctt></td></tr>
       				<tr><td>设备名称</td><td><ctt id='dvcnm'></ctt></td></tr>
       				<tr><td>创建时间</td><td><ctt id='crttm'></ctt></td></tr>
       				<tr><td>结束时间</td><td><ctt id='edtm'></ctt></td></tr>
       				<tr><td>消耗电量</td><td><ctt id='dgr'></ctt></td></tr>
       				<tr><td>消费情况</td><td><ctt id='fee'></ctt></td></tr>
       				<tr><td>完成情况</td><td><ctt id='stat'></ctt></td></tr>
       			</table>
       		</div>
       		<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-lg btn-block" data-dismiss="modal">关闭当前</button>
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