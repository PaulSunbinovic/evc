<?php if (!defined('THINK_PATH')) exit();?>!DOCTYPE html>
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
<script>var fnddvcbydvcid='__URL__/fnddvcbydvcid';</script>

<link rel="stylesheet" type="text/css" href="__PUBLIC__/pblc/ISCROLL/iscroll.css">

</head>
<body onload="loaded()">

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

	<!--主体开始-->
	<div class='col-md-12 col-xs-12 bd' style='padding-top:10px'>
		<div class='col-md-6 col-xs-6'><a class='btn btn-success btn-block'>aaa</a></div>
		<div class='col-md-6 col-xs-6'><a class='btn btn-success btn-block'>aaa</a></div>
	</div>
	<div class='col-md-12 col-xs-12 bd' style='top:90px'>
		
		<div id="wrapper">
			<div id="scroller">
				<div id="scroller-pullDown">
					<span id="down-icon" class="icon-double-angle-down pull-down-icon"></span>
					<span id="pullDown-msg" class="pull-down-msg">下拉刷新</span>
				</div>
				<div id="scroller-content">
					<ul>
						<li>Pretty row 1</li>
						<li>Pretty row 2</li>
						<li>Pretty row 3</li>
						<li>Pretty row 4</li>
						<li>Pretty row 5</li>
						<li>Pretty row 6</li>
						<li>Pretty row 7</li>
						<li>Pretty row 8</li>
						<li>Pretty row 9</li>
						<li>Pretty row 10</li>
						<li>Pretty row 11</li>
						<li>Pretty row 12</li>
						<li>Pretty row 13</li>
						<li>Pretty row 14</li>
						<li>Pretty row 15</li>
						<li>Pretty row 16</li>
						<li>Pretty row 17</li>
						<li>Pretty row 18</li>
						<li>Pretty row 19</li>
						<li>Pretty row 20</li>
						<li>Pretty row 21</li>
						<li>Pretty row 22</li>
						<li>Pretty row 23</li>
						<li>Pretty row 24</li>
						<li>Pretty row 25</li>
						<li>Pretty row 26</li>
						<li>Pretty row 27</li>
						<li>Pretty row 28</li>
						<li>Pretty row 29</li>
						<li>Pretty row 30</li>
						<li>Pretty row 31</li>
						<li>Pretty row 32</li>
						<li>Pretty row 33</li>
						<li>Pretty row 34</li>
						<li>Pretty row 35</li>
						<li>Pretty row 36</li>
						<li>Pretty row 37</li>
						<li>Pretty row 38</li>
						<li>Pretty row 39</li>
						<li>Pretty row 40</li>
						<li>Pretty row 41</li>
						<li>Pretty row 42</li>
						<li>Pretty row 43</li>
						<li>Pretty row 44</li>
						<li>Pretty row 45</li>
						<li>Pretty row 46</li>
						<li>Pretty row 47</li>
						<li>Pretty row 48</li>
						<li>Pretty row 49</li>
						<li>Pretty row 50</li>
					</ul>
				</div>
				<div id="scroller-pullUp">
					<span id="up-icon" class="icon-double-angle-up pull-up-icon"></span>
					<span id="pullUp-msg" class="pull-up-msg">上拉刷新</span>
				</div>
			</div>
		</div>
		
		
	</div>
	


<script type="text/javascript" src="__PUBLIC__/pblc/ISCROLL/iscroll.js"></script>
<script type="text/javascript">
function loaded () {
	var myScroll,
		upIcon = $("#up-icon"),
		downIcon = $("#down-icon");
		
	myScroll = new IScroll('#wrapper', { probeType: 3, mouseWheel: true });
	
	myScroll.on("scroll",function(){
		var y = this.y,
			maxY = this.maxScrollY - y,
			downHasClass = downIcon.hasClass("reverse_icon"),
			upHasClass = upIcon.hasClass("reverse_icon");
		
		if(y >= 40){
			!downHasClass && downIcon.addClass("reverse_icon");
			return "";
		}else if(y < 40 && y > 0){
			downHasClass && downIcon.removeClass("reverse_icon");
			return "";
		}
		
		if(maxY >= 40){
			!upHasClass && upIcon.addClass("reverse_icon");
			return "";
		}else if(maxY < 40 && maxY >=0){
			upHasClass && upIcon.removeClass("reverse_icon");
			return "";
		}
	});
	
	myScroll.on("slideDown",function(){
		if(this.y > 40){
			alert("slideDown");
			upIcon.removeClass("reverse_icon")
		}
	});
	
	myScroll.on("slideUp",function(){
		if(this.maxScrollY - this.y > 40){
			alert("slideUp");
			upIcon.removeClass("reverse_icon")
		}
	});
}

</script>


<!-- bootstrap -->
<script src="__PUBLIC__/pblc/btstp3/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="__PUBLIC__/pblc/btstp3/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript">var vrfusrstat='__APP__/Cmn/vrfusrstat';</script>
<script type="text/javascript" src='__PUBLIC__/JS/index/base.js'></script>

</body>
</html>