
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

//-------------------为方便电脑端测试，不再依靠微信定位虚拟一个点为自己
wx.config({
//debug: true,
appId: appId,
timestamp: timestamp,
nonceStr: nonceStr,
signature: signature,
jsApiList: [
  // 所有要调用的 API 都要加到这个列表中
  // "openLocation",
  "getLocation",
  "scanQRCode",
]
});
wx.ready(function () {
// 在这里调用 API

    wx.getLocation({
      type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
      async: false,  //----------加入等你呀，因为，wx产生坐标到时候由，异步的原因，百度先去了搞了，此时是没有坐标到，然后...
      success: function (res) {

          //#################如果获取不到纬度就刷新一次
          if(res.latitude){
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
          }else{
              //############当前偷懒的方法。。。有点风险
              window.location.reload();
          }

          

          
         
          
      }
   	});
		$('#opcmr').click(function(){
        $('#cls').trigger('click');
			   wx.scanQRCode({
	          needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
	          scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
	          success: function (res) {
	            var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
	          }
	      	});	
		})
});

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
    //调用百度的js里面到函数
    paintpnt();
  	// var icon={path:icnpth,width:23,height:23,};
  	// lct(mypoint,'',lvl,'y','y',icon,'我的位置');


	//有了中心点，就可以和LBS云一起计算附近的点//这部分先看bdlb实验室的ceshi.html然后看crl.php//他们可以提供数组结构或者json结构，现在用到的是数组
    // var url = "http://api.map.baidu.com/geosearch/v3/nearby?callback=?";
    // $.ajax({
    //         'type': 'GET',
    //         'url': url,
    //         'contentType': 'application/json',
    //         'data': {
    //                 'location': ctlgtd+','+ctlttd, //检索关键字
    //                 'geotable_id': 116349,
    //                 'radius':40000,
    //                 'ak': 'S0VAW4LjQirp9FUmXF08Zvdy'  //用户ak
    //         },
    //         'dataType': 'json',
    //         'success': function(data) {
    //         		var ctts=data.contents;
            		
       				
    //         		for(i=0;i<ctts.length;i++){
    //         			pnt={lgtd:ctts[i]['location'][0],lttd:ctts[i]['location'][1],title:ctts[i]['title'],deviceId:ctts[i]['deviceId']};
    //         			pntarr.push(pnt);
            			
    //         			p[ctts[i]['deviceId']]=new BMap.Point(ctts[i]['location'][0],ctts[i]['location'][1]);

				// 		var sContent =
				// 		"<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+ctts[i]['title']+"</h4>" + 
				// 		"<img style='float:right;margin:4px' id='imgDemo' src='__PUBLIC__/IMG/chongdianzhuang.jpg' width='139' height='104' title=''/>" + 
				// 		"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>惠充电智能充电桩，适合AA型、BB型、CC型电动汽车。</p>" + "<div class='infwdaptmt'><div><a class='pull-left btn btn-success' href='__URL__/order/deviceId/"+ctts[i]['deviceId']+"'>预约</a><a class='pull-left btn btn-warning' style='margin-left:20px;' href='comment.html'>查看评论</a></div></div>"
				// 		+
				// 		"</div>";
				// 		var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
				// 		lct(p[ctts[i]['deviceId']],infoWindow);
    //         		}
    //                 console.log("success");
    //         },
    //         'error':function() {
    //                 console.log("error");
    //         }
    // });
    
  }
}