<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit">
<!-- 避免IE使用兼容模式 -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>模拟用户-设置参数</title>
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
</head>
<body>
	<div class='col-md-12'>
		<div class="page-header">
		  <h1>前端模拟用户 <small>使用说明</small></h1>
		</div>
		<div>
			1、只要点击相应的用户就能模拟该用户进行微信操作<br>
			2、只要点击取消设定就可以取消<br>
			3、<a href='__APP__'>首页地图模拟地址</a><br>
			4、<a href='__APP__/Usr/usrct'>个人中心控制模拟地址</a>
			<br><br>
		</div>
	</div>
	<div class='col-md-12'>
		<button class='btn btn-success btn-lg btn-block' id='cancelset'>取消设置</button>
	</div>
	<div class='col-md-12'>
		<table class="table table-striped  table-hover">
		<thead>
			<tr>
				<th>id</th><th>wechat_id</th><th>nick_name</th><th>head_img_url</th><th>mobile</th>
			</tr>
		</thead>
		<tbody>
			
			<?php if(is_array($personls)): $i = 0; $__LIST__ = $personls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$personv): $mod = ($i % 2 );++$i; if($personv['wechat_id']==session('openid')){ $cls='info'; }else{ $cls=''; } ?>
		  	<tr onclick="setss('<?php echo ($personv[wechat_id]); ?>')" class="<?php echo ($cls); ?>" id="tr_<?php echo ($personv['wechat_id']); ?>">
			  <td><?php echo ($personv['id']); ?></td><td><?php echo ($personv['wechat_id']); ?></td><td><?php echo ($personv['nick_name']); ?></td>
			  <td><img src="<?php echo ($personv['head_img_url']); ?>" class="img-responsive img-circle" style='height:50px;width:50px'></td><td><?php echo ($personv['mobile']); ?></td>
			  
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			
		</tbody>
		</table>
	</div>
	
	<script>
	var dosetss='__URL__/dosetss';
	function setss(openid){
		$.ajax({
            'type': 'GET',
            'url': dosetss,
            'async':false,  
            'contentType': 'application/json',
            'data': {
                'openid':openid,
                
            },
            'dataType': 'json',
            'success': function(data) {
                   
                alert('设定成功！');
                //显示所有tr的class清空
                $('tr').attr('class','');
                $('#tr_'+openid).attr('class','info');
                console.log("success");
            },
            'error':function() {
                console.log("error");
            }
        });
	}
	var docancelset='__URL__/cancelset';
	$(function(){
		$('#cancelset').click(function(){
			$.ajax({
	            'type': 'GET',
	            'url': docancelset,
	            'async':false,  
	            'contentType': 'application/json',
	            'data': {
	              	                
	            },
	            'dataType': 'json',
	            'success': function(data) {
	                   
	                alert('取消设定成功！');
	                //显示所有tr的class清空
	                $('tr').attr('class','');
	                console.log("success");
	            },
	            'error':function() {
	                console.log("error");
	            }
	        });
		})
	})
	</script>
	

	

	<!--主体结束-->
	 
<!-- bootstrap -->
<script src="__PUBLIC__/pblc/btstp3/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="__PUBLIC__/pblc/btstp3/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript" src='__PUBLIC__/JS/index/base.js'></script>

</body>
</html>