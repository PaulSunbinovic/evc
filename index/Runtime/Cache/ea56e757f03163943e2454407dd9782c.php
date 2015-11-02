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
<script>var fnddvcbydvcid='__URL__/fnddvcbydvcid';</script>
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
				<div><img src="<?php echo ($usrdto['user']['headImgUrl']); ?>" style='width:30px;height:30px;margin-top:20px' class='img-circle pull-left'><h3 class='pull-left' style='margin-left: 20px'><?php echo ($usrdto['user']['nickName']); ?></h3></div>
				
				<div class='clearfix'></div>
				<table class='table table-responsive'>
					<tr><td>等级：<td></td><td>环保大师<i class='glyphicon glyphicon-star'></i><i class='glyphicon glyphicon-star'></i><i class='glyphicon glyphicon-star'></i><i class='glyphicon glyphicon-star'></i><i class='glyphicon glyphicon-star'></i></td></tr>
					<tr><td>车型：<td></td><td>
						<?php if(is_array($crls)): $i = 0; $__LIST__ = $crls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$crv): $mod = ($i % 2 );++$i; echo ($crv['brdmdl']['brand']); ?>&nbsp;&nbsp;<?php echo ($crv['brdmdl']['model']); ?><br><?php endforeach; endif; else: echo "" ;endif; ?>
					</td></tr>
					<tr><td>当前状态：<td></td><td>充电中</td></tr>
				</table>
				<div class='clearfix'></div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class='col-md-12 col-xs-12' style='margin-bottom: 20px'>
			<a class='btn btn-info btn-lg btn-block' href='__URL__/zhxx'><i class='glyphicon glyphicon-user'></i> 账户信息</a>
			<div class="progress">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;height:100px;">
    <span class="sr-only">45% Complete</span>
  </div>
</div>
		</div>
		
		<script>
		//这里搞个设备数组库
		var dvcls=new Array();
		<?php if(is_array($dvcls)): $i = 0; $__LIST__ = $dvcls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dvcv): $mod = ($i % 2 );++$i;?>//暂时默认为空初始时间，等到马哥得到定时的接口搞定后，再赋值，从uct.php开始
		dvcls[<?php echo ($dvcv['id']); ?>]='';<?php endforeach; endif; else: echo "" ;endif; ?>
		var dvcsttsls=new Array();
		<?php if(is_array($dvcls)): $i = 0; $__LIST__ = $dvcls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dvcv): $mod = ($i % 2 );++$i;?>//暂时默认为空初始时间，等到马哥得到定时的接口搞定后，再赋值，从uct.php开始
		dvcsttsls[<?php echo ($dvcv['id']); ?>]="<?php echo ($dvcv['stts']); ?>";<?php endforeach; endif; else: echo "" ;endif; ?>
		
		</script>
		
		<div class='col-md-12 col-xs-12'>
		  	<div class='col-md-12 col-xs-12' style='text-align: center;padding-bottom: 5px;border-bottom: 1px solid #ccc;font-size: 18px'>我的电桩</div>
		  
		    
			      <div style='padding-top:50px'>

			      	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
					<script>
					//设置微信js的参数 PS：在服务号中也需要设置
					var appId="<?php echo ($spkg['appId']); ?>";
					var timestamp="<?php echo ($spkg['timestamp']); ?>";
					var nonceStr="<?php echo ($spkg['nonceStr']); ?>";
					var signature="<?php echo ($spkg['signature']); ?>";
					</script>
					<script src='__PUBLIC__/pblc/WX/wxoprt.js'></script>
	
			     	<button class='btn btn-success btn-lg btn-block' id='opcmr' style="margin-bottom: 10px"><i class='glyphicon glyphicon-qrcode'></i> 添加设备</button>
					<link href="__PUBLIC__/pblc/btstp3/switch/bootstrap-switch.css" rel="stylesheet">
			        <table class='table table-responsive table-striped'>
			        	<thead>
			        		<tr><th>桩名</th><th>当前状态</th><th>定时情况</th></tr>
			        	</thead>
			        	<tbody>

				        	<?php if(is_array($dvcls)): $i = 0; $__LIST__ = $dvcls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dvcv): $mod = ($i % 2 );++$i;?><tr><td><?php echo ($dvcv['address']); ?></td>
				        		<td>
				        		<div>
				        			
				        			<?php if($dvcv['status']=='on'){ ?><!--?-->
	      							<input class="form-control" type="checkbox" checked id="dvc_<?php echo ($dvcv['dvcid']); ?>" onchange="onoff(<?php echo ($dvcv['id']); ?>)">
	      							<?php }else{ ?>
	      							<input class="form-control" type="checkbox" id="dvc_<?php echo ($dvcv['id']); ?>" onchange="onoff(<?php echo ($dvcv['id']); ?>)">
	      							<?php } ?>
	      							
	      								
	      							
	    						</div>
	    						</td>
								<td>
									<a class='btn btn-success' onclick="clc(<?php echo ($dvcv['id']); ?>)" id='btn_<?php echo ($dvcv['id']); ?>'>
										<i class='glyphicon glyphicon-time'></i> <tm id='tm_<?php echo ($dvcv['id']); ?>'>未设定</tm>									
									</a>
								</td>
	    						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			        	</tbody>
			        	
			        </table>
					<script src='__PUBLIC__/pblc/btstp3/switch/bootstrap-switch.js'></script>
					<script>
					$(function(argument) {
				      $('[type="checkbox"]').bootstrapSwitch();
				    })
					</script>
			      </div>
		      
		     
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
		
		<script src="__PUBLIC__/pblc/MBSCRL/js/appframework.js"></script>
		<link href="__PUBLIC__/pblc/MBSCRL/css/mobiscroll.custom-2.16.1.min.css" rel="stylesheet" type="text/css" />
    	<script src="__PUBLIC__/pblc/MBSCRL/js/mobiscroll.custom-2.16.1.min.js" type="text/javascript"></script>
		<script src="__PUBLIC__/pblc/MBSCRL/js/init.js" type="text/javascript"></script>
		<div class='col-md-12 col-xs-12 nopadding' style='margin-top:20px'>
			 <div data-role="fieldcontain" class="demo-cont" id="demo_cont_datetime">
	            <input type="text" id="demo_datetime" class='form-control' placeholder='点击输入时间' style="display:none">  
	            <input type="text" id="optm" class='form-control' placeholder='点击输入时间'>  
	           
	        </div>
		     
		</div>
		
		<div class='col-md-12 col-xs-12 nopadding' style='margin-top:20px'>
		<script>var dosttm='__URL__/dosttm';</script>
		<buttom class='btn btn-success btn-lg btn-block' id='sttm'>完成设定</buttom>
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


<!-- bootstrap -->
<script src="__PUBLIC__/pblc/btstp3/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="__PUBLIC__/pblc/btstp3/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript">var vrfusrstat='__APP__/Cmn/vrfusrstat';</script>
<script type="text/javascript" src='__PUBLIC__/JS/index/base.js'></script>




</body>
</html>