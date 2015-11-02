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
		<a style='color:#fff'><?php echo ($ttl); ?></a>
	</div>
	<div class='col-md-3 col-xs-3'>
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

	<!--搜索开始-->
	
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
		
		<!--如果是一键预约就要直接选最近的-->
		<?php
 if($apntpnt){ ?>
		<script>
		// alert(<?php echo ($apntpnt['battery']); ?>);
		
		lgtd=<?php echo ($apntpnt['longitude']); ?>;
		lttd=<?php echo ($apntpnt['latitude']); ?>;
		ads='';
    	dvcid=<?php echo ($apntpnt['id']); ?>;
  
		var apntpnt=new BMap.Point(lgtd,lttd);
		
		var sContent =
				"<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+ads+"</h4>" + 
				"<img style='float:right;margin:4px' id='imgDemo' src='"+cdzpt+"' width='139' height='104' title=''/>" + 
				"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>惠充电智能充电桩，适合AA型、BB型、DD型电动汽车。</p>" + "<div class='infwdaptmt'><div><a class='pull-left btn btn-success' href='"+apntprx+"/"+dvcid+"'>预约</a><a class='pull-left btn btn-warning' style='margin-left:20px;' href='comment.html'>查看评论</a></div></div>"
				+
				"</div>";
		var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象

		lct(apntpnt,infoWindow,'','','','',ads);
		map.openInfoWindow(infoWindow,apntpnt); //开启信息窗口
		//driving.search(mypoint, apntpnt);

		 </script>
		<?php	 } ?>
		
		
	</div>
	

	


	
	
	<!--foot->

	 
<!-- bootstrap -->
<script src="__PUBLIC__/pblc/btstp3/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="__PUBLIC__/pblc/btstp3/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript">var vrfusrstat='__APP__/Cmn/vrfusrstat';</script>
<script type="text/javascript" src='__PUBLIC__/JS/index/base.js'></script>

</body>
</html>