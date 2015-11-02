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

<script type="text/javascript" src='__PUBLIC__/JS/index/cmnt.js'></script>
<link href="__PUBLIC__/CSS/index/regist.css" rel="stylesheet">
<script>var fnddvcbydvcid='__URL__/fnddvcbydvcid';</script>


</head>
<body>
	
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
	<script>
	//返回键CSS失效了，修改下
	// var dvls=$('.nvgt').children('div');
	// $(dvls[0]).css('margin-top','10px');
	</script>

	<!--主体开始-->
	
	<div class='col-md-12 col-xs-12 bd' style='top:180px'>
		<div  class="col-md-12 col-xs-12 nopadding" style="height:150px;background-color: #fff;position:fixed;top:40px;z-index: 1000;border-bottom: solid 1px #ccc">
			
			
			<div class='col-md-12 col-xs-12' style='padding-top:15px'>
				<textarea class="form-control" rows="3" placeholder='在此写入评论'></textarea>
			</div>
			<div class='col-md-12 col-xs-12' style='margin-top:5px;margin-bottom:5px'>
			<button class='btn btn-success btn-block'>提交评论</button>
			</div>
			<div class='clearfix'></div>
		</div>
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/pblc/PLDN/iscroll.css">
		<div id='mainarea' class='col-md-12 col-xs-12'>
			
			<script type="text/javascript">var srlnb=0;//serial number</script>
			
        	<?php if(is_array($cmntls)): $i = 0; $__LIST__ = $cmntls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cmntv): $mod = ($i % 2 );++$i;?><script type="text/javascript">srlnb++;</script>
        		<div class="col-md-12 col-xs-12 nopadding cmnt" id="cmnt<?php echo ($cmntv['commId']); ?>">
        			<div style='height:20px;font-weight: bold'><?php echo ($cmntv['usrnn']); ?></div>
        			<div class="overflowhidden"><?php echo ($cmntv['content']); ?></div>
        			<div class='col-md-12 col-xs-12'>
        				<div class='pull-left extend'><i class='glyphicon glyphicon-triangle-bottom'></i> 展开</div>
        				<div class='pull-right cmnttm'><?php echo ($cmntv['commDate']); ?></div>
        				<div class='pull-right approve'><i class='glyphicon glyphicon-thumbs-up'></i> (<?php echo ($cmntv['approves']); ?>)</div>
        			</div>
        			
        		</div><?php endforeach; endif; else: echo "" ;endif; ?>
				
		</div>
		
		<script src='__PUBLIC__/pblc/PLDN/init.js'></script>     	
		<script type="text/javascript">
		
		var dodnfrsh='__URL__/dodnfrsh';//do slidedown fresh
		var doupld='__URL__/doupld';//do slideup loading
		//slideDown 和 slideUp函数写在hstr_odr.js里面//
		var nwpg=0;//now page 当前页必然是第0页初始时候
		var exe=1;//一上来就可以执行
		</script>
		<div id='loading' class='col-md-12 col-xs-12' style="text-align: center">加载中...</div>
		<script src="__PUBLIC__/pblc/PLDN/pldnld.js"></script>
	</div>
	





<!-- bootstrap -->
<script src="__PUBLIC__/pblc/btstp3/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="__PUBLIC__/pblc/btstp3/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript">var vrfusrstat='__APP__/Cmn/vrfusrstat';</script>
<script type="text/javascript" src='__PUBLIC__/JS/index/base.js'></script>

</body>
</html>