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
<script>
var fnddvcbydvcid='__URL__/fnddvcbydvcid';
var cancelsttm='__URL__/cancelsttm';
</script>
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
		<div class='col-md-12 col-xs-12' style='padding:10px;margin-bottom:0px;background-color: #fff'>
			
		  	<div class='col-md-12 col-xs-12'>
		  		<div class='col-md-4 col-xs-4 nopadding'><img src="<?php echo ($usrdto['user']['headImgUrl']); ?>" style='width:80px;height:80px;margin-top:20px' class='img-circle'></div>
				<div class='col-md-8 col-xs-8 nopadding'>
					<div><h3><?php echo ($usrdto['user']['nickName']); ?></h3></div>
					<div>
						当前状态：<?php echo ($status); ?>
					</div>
					<div>8人看过，2人预约，125人加入</div>
				</div>
				
				
			</div>
			
		</div>
		
		
		<div class='col-md-12 col-xs-12' style='padding-bottom:20px' id='nine'>
			<?php if(is_array($dvcls)): $i = 0; $__LIST__ = $dvcls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dvcv): $mod = ($i % 2 );++$i;?><div class='col-md-4 col-xs-4' id="dvc_<?php echo ($dvcv['id']); ?>" onclick="onoff(<?php echo ($dvcv['id']); ?>)"><a class='btn btn-default btn-lg btn-block blk' ><i class='glyphicon glyphicon-off'></i> 关</a></div>
				<script>var doChangeCapacity="__URL__/doChangeCapacity";</script>
				<div class='col-md-4 col-xs-4' id="capacity_<?php echo ($dvcv['id']); ?>" onclick="changeCapacity(<?php echo ($dvcv['id']); ?>)"><a class='btn btn-default btn-lg btn-block blk' href='#'><i class='glyphicon glyphicon-flash'></i> <valueOfCapacity><?php echo ($dvcv['fast_slow_charge']); ?></valueOfCapacity></a></div>
				<div class='col-md-4 col-xs-4'  onclick="clc(<?php echo ($dvcv['id']); ?>)" id="btn_<?php echo ($dvcv['id']); ?>"><a class="btn btn-<?php echo ($dvcv['timer']['cls_tag']); ?> btn-lg btn-block blk" href='#'><i class='glyphicon glyphicon-time'></i> <?php echo ($dvcv['timer']['tm']); ?></a></div>
				<div class='col-md-4 col-xs-4 txtct'>开关</div>
				<div class='col-md-4 col-xs-4 txtct'>可调功率</div>
				<div class='col-md-4 col-xs-4 txtct'>半价电预约</div><?php endforeach; endif; else: echo "" ;endif; ?>
			
			
			<div class='col-md-4 col-xs-4'><a class='btn btn-default btn-lg btn-block blk' href='#'><i class='glyphicon glyphicon-adjust'></i> 半天</a></div>
			<div class='col-md-4 col-xs-4'><a class='btn btn-default btn-lg btn-block blk' href='#'><i class='glyphicon glyphicon-eye-open'></i> </a></div>
			<div class='col-md-4 col-xs-4'><a class='btn btn-warning btn-lg btn-block blk' href='__URL__/chongzhi'><i class='glyphicon glyphicon-yen'></i> </a></div>
			<div class='col-md-4 col-xs-4 txtct'>共享时段</div>
			<div class='col-md-4 col-xs-4 txtct'> 防盗激活</div>
			<div class='col-md-4 col-xs-4 txtct'> 充值</div>
			
			<div class='col-md-4 col-xs-4'><a class='btn btn-default btn-lg btn-block blk' href='#'><i class='glyphicon glyphicon-ok'></i> </a></div>
			<div class='col-md-4 col-xs-4'><a class='btn btn-default btn-lg btn-block blk' href='#'><i class='glyphicon glyphicon-list-alt'></i> </a></div>
			<div class='col-md-4 col-xs-4'><a class='btn btn-default btn-lg btn-block blk' href='#'><i class='glyphicon glyphicon-cog'></i> </a></div>
			<div class='col-md-4 col-xs-4 txtct'>设备自检</div>
			<div class='col-md-4 col-xs-4 txtct'>日报/月报</div>
			<div class='col-md-4 col-xs-4 txtct'>设置</div>
		</div>
		
		
		  
	</div>
	
	
	



	<!--主体结束-->

	<!--foot-->

	<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" id='modal' style='display: none'>
	  需要定时吗<b class="caret"></b>	
</button>

<!-- Modal -->
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id='cls'><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">定时设置</h4>
      </div>
      <div class="modal-body">
      	<div class='col-md-12 col-xs-12' style='text-align: center;font-size: 18px'><a id='dvcnm'></a></div>
		
		
		<!--
		经过反复实验可以确诊，在modal形式下clockpicker是有问题，你选的时候是无法在input里显示的
		所以我再jquery-clockpicker.js里头进行重写函数，详见//--------------的部分
		注意，为了逻辑优先，我不用min.js了
		-->
		<script type="text/javascript" src='__PUBLIC__/pblc/CLCK/bootstrap-clockpicker.min.js'></script>
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/pblc/CLCK/bootstrap-clockpicker.min.css">
		<script type="text/javascript" src='__PUBLIC__/pblc/CLCK/jquery-clockpicker.js'></script>
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/pblc/CLCK/jquery-clockpicker.min.css">
		<div class="input-group clockpicker" style="padding-top: 20px">
		    <input type="text" class="form-control" placeholder='点击选择时间' id='optm'>
		    <span class="input-group-addon">
		        <span class="glyphicon glyphicon-time"></span>
		    </span>
		</div>
		<script type="text/javascript" src='__PUBLIC__/pblc/CLCK/int.js'></script>
		
		<div class='col-md-12 col-xs-12 nopadding' style="margin-top: 20px">
			<div class='col-md-1 col-xs-1 padding-1-px week' id='day1'><a class="btn btn-default btn-block padding-w-1-px">一</a></div>
			<div class='col-md-1 col-xs-1 padding-1-px week' id='day2'><a class="btn btn-default btn-block padding-w-1-px">二</a></div>
			<div class='col-md-1 col-xs-1 padding-1-px week' id='day3'><a class="btn btn-default btn-block padding-w-1-px">三</a></div>
			<div class='col-md-1 col-xs-1 padding-1-px week' id='day4'><a class="btn btn-default btn-block padding-w-1-px">四</a></div>
			<div class='col-md-1 col-xs-1 padding-1-px week' id='day5'><a class="btn btn-default btn-block padding-w-1-px">五</a></div>
			<div class='col-md-1 col-xs-1 padding-1-px week' id='day6'><a class="btn btn-default btn-block padding-w-1-px">六</a></div>
			<div class='col-md-1 col-xs-1 padding-1-px week' id='day7'><a class="btn btn-default btn-block padding-w-1-px">七</a></div>
			<div class='col-md-3 col-xs-3 padding-1-px week' id='work'><a class='btn btn-default btn-block'>工作日</a></div>
			<div class='col-md-2 col-xs-2 padding-1-px week' id='everyweek'><a class='btn btn-default btn-block'>每周</a></div>
		</div>

		
		<div class='col-md-12 col-xs-12 nopadding' style='margin-top:20px'>
			<script>var dosttm='__URL__/dosttm';</script>
			<button class='btn btn-success btn-lg btn-block' id='sttm'>完成设定</button>
		</div>

		<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal" id='cancel'>取消</button>
        
      </div>
    </div>
  </div>
</div>
<script>var doonoffdvc='__URL__/doonoffdvc';</script>



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
<script>
	//这里搞个设备数组库
		
	var dvcls=new Array();
	<?php if(is_array($dvcls)): $i = 0; $__LIST__ = $dvcls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dvcv): $mod = ($i % 2 );++$i;?>//暂时默认为空初始时间，等到马哥得到定时的接口搞定后，再赋值，从uct.php开始
		dvcls[<?php echo ($dvcv['id']); ?>]='';<?php endforeach; endif; else: echo "" ;endif; ?>
		var dvcsttsls=new Array();
		<?php if(is_array($dvcls)): $i = 0; $__LIST__ = $dvcls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dvcv): $mod = ($i % 2 );++$i;?>//暂时默认为空初始时间，等到马哥得到定时的接口搞定后，再赋值，从uct.php开始
		dvcsttsls[<?php echo ($dvcv['id']); ?>]="<?php echo ($dvcv['stts']); ?>";
		check(<?php echo ($dvcv['id']); ?>);<?php endforeach; endif; else: echo "" ;endif; ?>
	
</script>



</body>
</html>