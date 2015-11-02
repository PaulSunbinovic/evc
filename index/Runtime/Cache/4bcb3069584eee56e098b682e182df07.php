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
			<a style='color:#fff'>预约</a>
		</div>
		
		<div class='col-md-3 col-xs-3'>
			
		</div>
		
	</div>
	<!--导航结束-->

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
		<style type="text/css">
		#allmap{height:100%;width:100%;}
		</style>
		<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=S0VAW4LjQirp9FUmXF08Zvdy"></script>
		<div id="allmap"></div>
		
		

		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script>
		var ctlgtd;var ctlttd;var pntarr = [];var mypoint;var p=[];
		  /*
		   * 注意：
		   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
		   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
		   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
		   *
		   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
		   * 邮箱地址：weixin-open@qq.com
		   * 邮件主题：【微信JS-SDK反馈】具体问题
		   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
		   */
		  wx.config({
		    //debug: true,
		    appId: "<?php echo ($spkg['appId']); ?>",
		    timestamp: "<?php echo ($spkg['timestamp']); ?>",
		    nonceStr: "<?php echo ($spkg['nonceStr']); ?>",
		    signature: "<?php echo ($spkg['signature']); ?>",
		    jsApiList: [
		      // 所有要调用的 API 都要加到这个列表中
		      "openLocation",
		      "getLocation",
		      "scanQRCode",
		    ]
		  });
		  wx.ready(function () {
		    // 在这里调用 API
		    
		    wx.getLocation({
		        type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
		        success: function (res) {
		            var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
		            var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
		            var speed = res.speed; // 速度，以米/每秒计
		            var accuracy = res.accuracy; // 位置精度

		            mypnt={lgtd:longitude,lttd:latitude,name:'我的位置'};
		            
		             //百度地图部分，从微信上的google坐标 换算成 百度坐标
		            var ggPoint = new BMap.Point(mypnt.lgtd,mypnt.lttd);
		            var convertor = new BMap.Convertor();
			       	var pointArr = [];
			        pointArr.push(ggPoint);
			        convertor.translate(pointArr, 3, 5, translateCallback);

			        
		           
		            
		        }
	      	});

		  });
		</script>
		<script type="text/javascript">


			//坐标转换完之后的回调函数
		    translateCallback = function (data){
		      if(data.status === 0) {

		      	mypoint = data.points[0];
		      	//这段代码可以查看某个对象有哪些元素的
		      	// for(i in mypoint){
		      	// 	alert(i);//属性名称
		      	// 	alert(mypoint[i]);//属性值
		      	// }
		      	ctlgtd=mypoint['lng'];
		      	ctlttd=mypoint['lat'];

				var icon={path:'__PUBLIC__/IMG/circle.png',width:23,height:23,};
				lct(mypoint,'',<?php echo ($lvl); ?>,'y','y',icon);


				//有了中心点，就可以和LBS云一起计算附近的点//这部分先看bdlb实验室的ceshi.html然后看crl.php//他们可以提供数组结构或者json结构，现在用到的是数组
		        var url = "http://api.map.baidu.com/geosearch/v3/nearby?callback=?";
		        $.ajax({
		                'type': 'GET',
		                'url': url,
		                'contentType': 'application/json',
		                'data': {
		                        'location': ctlgtd+','+ctlttd, //检索关键字
		                        'geotable_id': 116349,
		                        'radius':40000,
		                        'ak': 'S0VAW4LjQirp9FUmXF08Zvdy'  //用户ak
		                },
		                'dataType': 'json',
		                'success': function(data) {
		                		var ctts=data.contents;
		                		
			       				
		                		for(i=0;i<ctts.length;i++){
		                			pnt={lgtd:ctts[i]['location'][0],lttd:ctts[i]['location'][1],title:ctts[i]['title']};
		                			pntarr.push(pnt);
		                			
		                			p[ctts[i]['cdzid']]=new BMap.Point(ctts[i]['location'][0],ctts[i]['location'][1]);

									var sContent =
									"<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+ctts[i]['title']+"</h4>" + 
									"<img style='float:right;margin:4px' id='imgDemo' src='__PUBLIC__/IMG/chongdianzhuang.jpg' width='139' height='104' title=''/>" + 
									"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>惠充电智能充电桩，适合AA型、BB型、CC型电动汽车。</p>" + "<div class='infwdaptmt'><div><a class='pull-left btn btn-success' href='adjstrt(p["+ctts[i]['cdzid']+"])'>预约</a><a class='pull-left btn btn-warning' style='margin-left:20px;' href='comment.html'>查看评论</a></div></div>"
									+
									"</div>";
									var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
									lct(p[ctts[i]['cdzid']],infoWindow);
		                		}
		                        console.log("success");
		                },
		                'error':function() {
		                        console.log("error");
		                }
		        });
		        
		      }
		    }
			// 百度地图API功能
			var map = new BMap.Map("allmap");
			
			//生成driving对象
			var driving = new BMap.DrivingRoute(map, {renderOptions:{map: map, autoViewport: true}});
			
			//根据搜索和需要的pX进行driving
			driving.search(mypoint, p<?php echo ($cdzid); ?>);

			// 用经纬度设置地图中心点
			function lct(pnt,ifwd,lvl,ctr,clr,icn){
				var myIcon; var marker;
				if(clr=='y'){
					map.clearOverlays(); 
				}
				if(ctr=='y'){
					map.centerAndZoom(pnt, lvl);
				}
				if(icn){
					myIcon = new BMap.Icon(icn.path, new BMap.Size(icn.height,icn.width));
					marker = new BMap.Marker(pnt,{icon:myIcon});  // 创建标注
				}else{
					marker = new BMap.Marker(pnt);  // 创建标注
				}
				if(ifwd){
					marker.addEventListener("click", function(){          
					   this.openInfoWindow(ifwd);
					   //图片加载完毕重绘infowindow
					   document.getElementById('imgDemo').onload = function (){
						   ifwd.redraw();   //防止在网速较慢，图片未加载时，生成的信息框高度比图片的总高度小，导致图片部分被隐藏
					   }
					});
				}
				map.addOverlay(marker);              // 将标注添加到地图中
				//map.panTo(point);      
				
			}

			//adjust route
			function adjstrt(pnt){
				driving.search(mypoint, pnt);
			}


		</script>
		

		<script>
			//假装通过数据库获取数据
			
			
			$(function(){
				
				$("#ctt").bind("input propertychange",function(){
					
				    var ctt=$.trim($('#ctt').val());
				    var ul="<ul  class='list-group'>";
				    var flag=0;
				    
				    if(ctt!=''){
				    	for(var i=0;i<pntarr.length;i++){
				    		if(pntarr[i]['title'].indexOf(ctt)!=-1){
						    	flag=1;
						    	ul=ul+"<li  class='list-group-item' onclick='panto(p["+pntarr[i]['cdzid']+"])'>"+pntarr[i]['title']+"</li>";
					    	}
				    	}
				    }
				    
				    if(flag==0){
				    	ul=ul+"<li  class='list-group-item'>暂无结果</li>";
				    }
				    ul=ul+"</ul><a class='btn btn-danger' style='width:100%' onclick='clspp()'>关闭搜索结果</a>";
				    $('#example').attr('data-content',ul);
				    $('#example').popover('show');
				})
			});
			function clspp(){
				$('#example').popover('hide');
			}
			function panto(pnt){
				map.panTo(pnt);
				$('#example').popover('hide');    
			}
			
		</script>
	</div>
	

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
					<a href='__URL__/order/lth/1000'>1000米</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href='__URL__/order/lth/2500'>2500米</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href='__URL__/order/lth/5000'>5000米</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href='__URL__/order/lth/10000'>10000米</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href='__URL__/order/lth/all'>不限</a>
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

	<!--主体结束-->
	<!--
	<iframe src="foot.html"  frameborder="0"></iframe>
	-->
	
	<!--foot开始-->
	<div class="col-md-12 col-xs-12 ft" style="text-align: center">
	  <a class='btn btn-primary btn-lg' style="border:0px;width:100%" id='push'>一键推送到车载系统</a>
	</div>
	<script type="text/javascript">
	$(function(){
		$('#push').click(function(){
			clspp();
			$('#allmap').hide();
			$('#info').show();
			setTimeout("location.href='user.html';", 2000);  
		})
	})
	</script>
	<div id='info' style="position: fixed;top:150px;width:80%;margin-left:10%;display:none" class='btn btn-primary btn-lg'>预约推送成功</div>
	<!--foot结束-->
	 
<!-- bootstrap -->
<script src="__PUBLIC__/pblc/btstp3/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="__PUBLIC__/pblc/btstp3/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript" src='__PUBLIC__/JS/index/base.js'></script>

</body>
</html>