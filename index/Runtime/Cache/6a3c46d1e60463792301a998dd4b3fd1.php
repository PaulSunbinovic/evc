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
<link href="__PUBLIC__/CSS/index/regist.css" rel="stylesheet">
</head>
<body>

	
	<!--
	<iframe src="head.html"  frameborder="0" style="width:100%;height:100%;" scrolling="no"></iframe>
	-->
	

	<!--导航开始-->
	<div class='col-md-12 col-xs-12 nvgt'>
		<div class='col-md-3 col-xs-3'>
			<a class='pull-left nvgt_a_left' href="javascript:history.go(-1);"><i class='glyphicon glyphicon-menu-left'></i></a>
		</div>
		<div class='col-md-6 col-xs-6' style="text-align: center">
			<a style='color:#fff'>个人中心</a>
		</div>
		
		<div class='col-md-3 col-xs-3'>
			<a class='pull-right hd_a_right'><i class='glyphicon glyphicon-cog'></i></a>
		</div>
		
	</div>
	<!--导航结束-->

	<!--主体开始-->
	<div class='col-md-12 col-xs-12 bd'>
		<div class="jumbotron" class='col-md-12 col-xs-12' style='margin-bottom:0px'>
			<div class='pull-left'>
				<img src="<?php echo ($usro['headImgUrl']); ?>" style='width:100px;height:100px' class='img-circle'>
			</div>
		  	<div class='pull-left' style='margin-left:20px;'>
				<div><h3 style="margin-top:5px;"><?php echo ($usro['nickName']); ?></h3></div>
				<div>等级：环保大师<br>当前状态：充电中<br>用时：1小时</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class='col-md-12 col-xs-12' style='margin-bottom: 20px'>
			<a class='btn btn-success btn-lg btn-block' href='__URL__/chongzhi'>账户充值</a>
		</div>
		<div>
		<div class='col-md-12 col-xs-12'>
		    <ul id="myTabs" class="nav nav-tabs col-md-12 col-xs-12" role="tablist">
		      <li role="presentation" class="active col-md-4 col-xs-4"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true" class='col-md-12 col-xs-12' style='padding:10px 0px;'>基本信息</a></li>
		      <li class="col-md-4 col-xs-4" role="presentation"><a aria-expanded="false" href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" class='col-md-12 col-xs-12' style='padding:10px 0px;'>我的电桩</a></li>
		      <li class="col-md-4 col-xs-4" role="presentation"><a aria-expanded="false" href="#san" role="tab" id="profile-tab" data-toggle="tab" aria-controls="san" class='col-md-12 col-xs-12' style='padding:10px 0px;'>历史记录</a></li>
		    </ul>
		    <div id="myTabContent" class="tab-content">
		      <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" style='padding-top:50px'>
		        <table class='table table-responsive'>
		        	<tr><td><b>姓名</b></td><td>张锅仔</td></tr>
		        	<tr><td><b>电话号码</b></td><td>182***859</td></tr>
		        	<tr><td><b>车牌号</b></td><td>沪A ABCDEF</td></tr>
		        	
		        </table>
		      </div>
		      <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab"  style='padding-top:50px'>
		        <table class='table table-responsive'>
		        	<thead>
		        		<tr><th>序号</th><th>桩名</th></tr>
		        	</thead>
		        	<tbody>
		        	<tr><td>1</td><td>花木新村桩</td></tr>
		        	<tr><td>2</td><td>龙沟新苑桩</td></tr>
		        	</tbody>
		        	
		        </table>
		      </div>
		      <div role="tabpanel" class="tab-pane fade" id="san" aria-labelledby="san-tab"  style='padding-top:50px'>

		         <table class='table table-responsive'>
		        	<thead>
		        		<tr><th>序号</th><th>桩名</th><th>充电起始时间</th><th>充电结束时间</th><th>费用（元）</th></tr>
		        	</thead>
		        	<tbody>
		        	<tr><td>1</td><td>世纪公园桩</td><td>2015-07-20 07:00:00</td><td>2015-07-20 10:00:00</td><td>-3</td></tr>
		        	<tr><td>2</td><td>上海人家99短租公寓桩</td><td>2015-07-21 11:00:00</td><td>2015-07-21 13:00:00</td><td>-2</td></tr>
		        	<tr><td>3</td><td>龙沟新苑桩</td><td>2015-08-01 10:00:00</td><td>2015-08-23 12:00:00</td><td>+2</td></tr>
		        	<tr><td>4</td><td>汤臣湖庭花园桩</td><td>2015-08-03 11:00:00</td><td>2015-08-03 14:00:00</td><td>-3</td></tr>
		        	<tr><td>5</td><td>花木新村桩</td><td>2015-08-06 14:00:00</td><td>2015-08-06 19:00:00</td><td>+5</td></tr>
		        	<tr><td>6</td><td>花木新村桩</td><td>2015-08-06 23:00:00</td><td>2015-08-07 02:00:00</td><td>+3</td></tr>
		        	<tr><td>7</td><td>上海浦东嘉里大酒店桩</td><td>2015-08-08 10:00:00</td><td>2015-08-08 15:00:00</td><td>-5</td></tr>
		        	<tr><td>8</td><td>上海东方明珠电视塔桩</td><td>2015-08-13 11:00:00</td><td>2015-08-13 14:00:00</td><td>-3</td></tr>
		        	<tr><td>9</td><td>汤臣湖庭花园桩</td><td>2015-08-15 06:00:00</td><td>2015-08-15 10:00:00</td><td>-4</td></tr>
		        	<tr><td>10</td><td>龙沟新苑桩</td><td>2015-08-20 11:00:00</td><td>2015-08-20 14:00:00</td><td>+3</td></tr>
		        	<tr><td>11</td><td>上海人家99短租公寓桩</td><td>2015-08-23 15:00:00</td><td>2015-08-23 19:00:00</td><td>-4</td></tr>
		        	</tbody>
		        	
		        	
		        </table>
		        <div style='height: 50px'></div>
		      </div>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
	

	

	<!--主体结束-->

	<!--foot开始-->
	<div class="btn-group btn-group-justified col-md-12 col-xs-12 ft" role="group" aria-label="...">
	  <div class="btn-group" role="group">
	    <a type="button" class="btn btn-primary" style='border:0px' id='aaa'><i class='glyphicon glyphicon-th-list'></i><br>菜单</a>
	  </div>
	  <div class="btn-group" role="group">
	    <a type="button" class="btn btn-primary" style='border:0px' href="order.html"><i class='glyphicon glyphicon-send'></i><br>一键预约</a>
	  </div>
	  <div class="btn-group" role="group"  id='usrct'>
	    <a type="button" class="btn btn-primary" style='border:0px' ><i class='glyphicon glyphicon-user'></i><br>个人中心</a>
	  </div>
	</div>
	<!--href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx682ad2cc417fe8b9&redirect_uri=http://www.evchar.cn/evc/oauth2_openid.php&response_type=code&scope=snsapi_base&state=usrct#wechat_redirect"-->
	<!--foot结束-->
	 
<!-- bootstrap -->
<script src="__PUBLIC__/pblc/btstp3/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="__PUBLIC__/pblc/btstp3/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript">var vrfusrstat='__URL__/vrfusrstat';</script>
<script type="text/javascript" src='__PUBLIC__/JS/index/base.js'></script>

</body>
</html>