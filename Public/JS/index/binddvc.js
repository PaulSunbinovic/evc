$(function(){
	//##########
	$('#binddvc').click(function(){
		//###设置参参数
		var sn=$('#sn');
		var lgtd=$('#lgtd');
		var lttd=$('#lttd');
		//###检查是否是空
		if(sn.val()==''){alert('SN码不能为空');return false;}
		//if(lgtd.val()==''){alert('经度不能为空');return false;}
		//if(lttd.val()==''){alert('纬度不能为空');return false;}
		//###ajax
		$.ajax({
            'type': 'GET',
            'url': dobinddvc,
            'async':false,  
            'contentType': 'application/json',
            'data': {
                'sn':sn.val(),
                'lgtd':lgtd.val(),
                'lttd':lttd.val(),
            },
            'dataType': 'json',
            'success': function(data) {
            	if(data['rslt']==1){
            		alert('绑定成功！');
            		window.location.href=__url__+'/usrct/dvcid/'+data['dvcid'];
            	}else{
            		alert(data['msg']);
            	}
            	
                console.log("success");
            },
            'error':function() {
                console.log("error");
            }
        });
		
	})


})

function freshgps(){
    wx.getLocation({
      type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
      async: false,  //----------加入等你呀，因为，wx产生坐标到时候由，异步的原因，百度先去了搞了，此时是没有坐标到，然后...
      success: function (res) {

          //#################如果获取不到纬度就刷新一次
          
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
}

