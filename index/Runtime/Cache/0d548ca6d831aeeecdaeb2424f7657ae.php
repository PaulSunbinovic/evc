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

<script type="text/javascript" src='__PUBLIC__/JS/index/zhxx.js'></script>
<link href="__PUBLIC__/CSS/index/zhxx.css" rel="stylesheet">

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

	<!--主体开始-->
	<div class='col-md-12 col-xs-12 bd' style='padding-top: 20px'>
		<div class='col-md-12 col-xs-12'>
			<div class='col-md-12 col-xs-12'>
				<select id='yr' class="btn btn-default btn-lg btn-block">
					
				</select>
			</div>
		</div>
		<script type="text/javascript">
			var d = new Date();
			var tsyr = d.getFullYear();//this year intiyear
			var str='';
			var intyr=2015;
			for(var i=intyr;i<=tsyr;i++){
				str=str+"<option value='"+i+"'>"+i+'</option>';
			}
			$('#yr').html(str);
		</script>

		<link rel="stylesheet" href="__PUBLIC__/pblc/SLD/css/idangerous.swiper.css">
		<link rel="stylesheet" href="__PUBLIC__/pblc/SLD/css/my.css">
		<div class="col-md-12 col-xs-12 wrap" style='margin-top: 20px'>
		    <div class="col-md-12 col-xs-12 nopadding tabs">
		        <a href="#" hidefocus="true" class="col-md-1 col-xs-1 nopadding month active">1</a>
		        <a href="#" hidefocus="true" class='col-md-1 col-xs-1 nopadding month'>2</a>
		        <a href="#" hidefocus="true" class='col-md-1 col-xs-1 nopadding month'>3</a>
		        <a href="#" hidefocus="true" class='col-md-1 col-xs-1 nopadding month'>4</a>
		        <a href="#" hidefocus="true" class='col-md-1 col-xs-1 nopadding month'>5</a>
		        <a href="#" hidefocus="true" class='col-md-1 col-xs-1 nopadding month'>6</a>
		        <a href="#" hidefocus="true" class='col-md-1 col-xs-1 nopadding month'>7</a>
		        <a href="#" hidefocus="true" class='col-md-1 col-xs-1 nopadding month'>8</a>
		        <a href="#" hidefocus="true" class='col-md-1 col-xs-1 nopadding month'>9</a>
		        <a href="#" hidefocus="true" class='col-md-1 col-xs-1 nopadding month'>10</a>
		        <a href="#" hidefocus="true" class='col-md-1 col-xs-1 nopadding month'>11</a>
		        <a href="#" hidefocus="true" class='col-md-1 col-xs-1 nopadding month'>12</a>
		    </div>    
		    <div class="col-md-12 col-xs-12 nopadding swiper-container">
		       <div class="swiper-wrapper">
		        <div class="swiper-slide">
		            <div class="content-slide">
		           
		            </div>
		        </div>
		        <div class="swiper-slide">
		            <div class="content-slide">
		           
		            </div>
		        </div>
		        <div class="swiper-slide">
		            <div class="content-slide">
		            
		            </div>
		        </div>
		         <div class="swiper-slide">
		            <div class="content-slide">
		           
		            </div>
		        </div>
		        <div class="swiper-slide">
		            <div class="content-slide">
		            
		            </div>
		        </div>
		         <div class="swiper-slide">
		            <div class="content-slide">
		           
		            </div>
		        </div>
		        <div class="swiper-slide">
		            <div class="content-slide">
		            
		            </div>
		        </div>
		         <div class="swiper-slide">
		            <div class="content-slide">
		           
		            </div>
		        </div>
		         <div class="swiper-slide">
		            <div class="content-slide">
		           
		            </div>
		        </div>
		        <div class="swiper-slide">
		            <div class="content-slide">
		            
		            </div>
		        </div>
		         <div class="swiper-slide">
		            <div class="content-slide">
		           
		            </div>
		        </div>
		        <div class="swiper-slide">
		            <div class="content-slide">
		            
		            </div>
		        </div>
		      </div>
		   </div>
		</div>
		<script type="text/javascript" src="__PUBLIC__/pblc/SLD/js/idangerous.swiper.min.js"></script> 
		<script type="text/javascript">
		//为了覆盖contet-slide覆盖区域可以覆盖到接近按钮不到点的位置，毕竟z-index比较高
		
		var tabsSwiper = new Swiper('.swiper-container',{
			speed:500,
			onSlideChangeStart: function(){
				//-------------这里在滑动的时候很多数据需要和后台交互
				$(".tabs .active").removeClass('active');
				$(".tabs a").eq(tabsSwiper.activeIndex).addClass('active');
				var ctx = document.getElementById("canvas").getContext("2d");
				window.myLine = new Chart(ctx).Line(lineChartData, {
					responsive: true
				});
			}
		});

		$(".tabs a").on('touchstart mousedown',function(e){
			e.preventDefault()
			$(".tabs .active").removeClass('active');
			$(this).addClass('active');
			tabsSwiper.swipeTo($(this).index());
		});

		$(".tabs a").click(function(e){
			e.preventDefault();
		});
		</script>

		
	</div>
	<div class='col-md-12 col-xs-12' style='position: fixed;top:180px;background-color: #fff;'>
	
	<script type="text/javascript" src='__PUBLIC__/pblc/CHART/Chart.js'></script>
	<canvas style='padding-right: 20px' id="canvas"></canvas>
	<script>
		var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
		var lineChartData = {
			// labels : ["","","","","5","","","","","10","","","","","15","","","","","20","","","","","25","","","","","30",""],
			// datasets : [
			// 	{
			// 		label: "My First dataset",
			// 		fillColor : "rgba(255,255,255,0.22)",//扇区色
			// 		strokeColor : "rgba(92,184,92,1)",//线条色
			// 		pointColor : "rgba(52,121,183,1)",//点的颜色
			// 		pointStrokeColor : "#fff",
			// 		pointHighlightFill : "#fff",
			// 		pointHighlightStroke : "rgba(220,220,220,1)",
			// 		data : [10,13,200,195,187,192,170,165,162,158,
			// 			170,173,167,163,157,153,147,247,245,246,
			// 			235,235,232,228,222,211,204,206,200,198,195
			// 		]
			// 	},
				
			// ]
			labels : ["","","5","","","11","","","17","","","23","","","29",""],
			datasets : [
				{
					label: "My First dataset",
					fillColor : "rgba(255,255,255,0.22)",//扇区色
					strokeColor : "rgba(92,184,92,1)",//线条色
					pointColor : "rgba(52,121,183,1)",//点的颜色
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [10,200,187,170,162,
							170,167,157,147,245,
							235,232,222,204,200,195
					]
				},
				
			]

		}

	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true
		});
		$('.swiper-slide').height($('#canvas').height()+'px');
	}
	//我再Chart.js里面的改了下//--------从而禁用了鼠标手机移动动作
	
	</script>


	<div class="col-md-12 col-xs-12">
		<script type="text/javascript">
		var dt=new Array(10,13,200,195,187,192,170,165,162,158,170,173,167,163,157,153,147,247,245,246,235,235,232,228,222,211,204,206,200,198,195);
		
		//翻页的时候都有更新</script>
		<script type="text/javascript">
			$(function(){
				
				$('#vwdtl').click(function(){
					$('#slg').html($('#yr').val()+'年,'+$('.month.active').html()+'月');
					//填充数据
					var str='';
					for(var i=0;i<dt.length;i++){
						substr='<tr><td>'+(i+1)+'</td><td>'+dt[i]+'</td></tr>';
						str=str+substr;
					}
					$('tbody').html(str);
					//触发modal
					$('#modal').trigger('click');
				})
			})
		</script>
		<a class='btn btn-success btn-lg btn-block' id='vwdtl'>查看详情</a>
	</div>
	</div>
	


	<!--主体结束-->

	<!--foot-->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style='display:none' id='modal'>
  显示细节
</button>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">详情描述</h4>
      </div>
      <div class="modal-body">
      		<div class='col-md-12 col-xs-12' id='slg' style='font-size: 18px'></div><!--slogen-->
       		<div class='col-md-12 col-xs-12' style='height:200px;overflow: scroll' id='tbctn'><!--table container-->
       			<table class='table table-responsive table-striped'>
       				<thead><tr><th>日期</th><th>金额</th></tr></thead>
       				<tbody>
       					
       				</tbody>
       				
       			</table>
       		</div>
       		<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">关闭当前</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$('#tbctn').height($(window).height()*0.5);
	
</script>


<!-- bootstrap -->
<script src="__PUBLIC__/pblc/btstp3/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="__PUBLIC__/pblc/btstp3/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript">var vrfusrstat='__APP__/Cmn/vrfusrstat';</script>
<script type="text/javascript" src='__PUBLIC__/JS/index/base.js'></script>

</body>
</html>