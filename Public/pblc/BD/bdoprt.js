// 百度地图API功能
var map = new BMap.Map("allmap");

//生成driving对象
var driving = new BMap.DrivingRoute(map, {renderOptions:{map: map, autoViewport: true}});

// 用经纬度设置地图中心点
function lct(pnt,ifwd,lvl,ctr,clr,icn,ads){
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
			//######################根据商兄的建议，需要在点击的时候 先放大地图的尺寸
			map.setZoom(20);      
		   this.openInfoWindow(ifwd);
		   //图片加载完毕重绘infowindow
		   document.getElementById('imgDemo').onload = function (){
			   ifwd.redraw();   //防止在网速较慢，图片未加载时，生成的信息框高度比图片的总高度小，导致图片部分被隐藏
		   }
		});
	}
	map.addOverlay(marker);              // 将标注添加到地图中
	//map.panTo(point);      
	var label = new BMap.Label('<a class=lbl>'+ads+'</a>',{offset:new BMap.Size(-20,23)});
		label.setStyle({
		 color : "red",
		 fontSize : "13px",
		 height : "20px",
		 lineHeight : "20px",
		 fontFamily:"微软雅黑",
		 fontWeight:'bold',
		 backgroundColor:'#ccc',
		 
	 });
	//bob表示不要label
	//marker.setLabel(label);
}

//开发模式
// ctlgtd='120.207736';ctlttd='30.211754';
// paintpnt();

//adjust route
function adjstrt(pnt){
	driving.search(mypoint, pnt);
}

// ----------------------以下都是杜撰到点，因为测试点都在上海，定位到杭州没有意义，反正定位很准已经没问题了
// ctlgtd=121.576464;120.208989;120.207281;
// ctlttd=31.224494;30.213697;30.213426;
//上海版
// ctlgtd=121.576464;
// ctlttd=31.224494;
//北京版
//ctlgtd=116.449877;
//ctlttd=39.967977;
var icon_green={path:iconpath_green,width:23,height:23};
var icon_red={path:iconpath_red,width:23,height:23};
var icon_yellow={path:iconpath_yellow,width:23,height:23};
//########################
var wenyuan_green={path:wenyuanpath_green,width:26,height:26};
var wenyuan_red={path:wenyuanpath_red,width:26,height:26};
var wenyuan_yellow={path:wenyuanpath_yellow,width:26,height:26};
var wenyuan_my_location={path:wenyuanpath_my_location,width:23,height:23};
//#############
var qinfeng_green={path:qinfengpath_green,width:26,height:26};
var qinfeng_red={path:qinfengpath_red,width:26,height:26};
var qinfeng_yellow={path:qinfengpath_yellow,width:26,height:26};

var p=[];
function paintpnt(){
	

	mypoint=new BMap.Point(ctlgtd,ctlttd)
	lct(mypoint,'',lvl,'y','y',wenyuan_my_location,'我的位置');
	 
	
	$.ajax({
	    'type': 'GET',
	    'url': dspdvc,
	    // 'async':false,  
	    'contentType': 'application/json',

	    'data': {
	        'ctlgtd':ctlgtd, 
	        'ctlttd':ctlttd,
	        //'crmdlid':crmdlid,   
	    },
	    'dataType': 'json',
	    'success': function(data) {//var string='';
	    		for(var i=0;i<data['dvcls'].length;i++){//string=string+data['dvcls'][i]['address']+";\r\n";
	    			var lgtd=data['dvcls'][i]['longitude'];
	    			var lttd=data['dvcls'][i]['latitude'];
	    			var ads=data['dvcls'][i]['address'];
	    			var dvcid=data['dvcls'][i]['id'];

	    			//############判断是否是某个团体的
	    			var desc="惠充电智能充电桩。惠充电智能充电桩。惠充电智能充电桩。惠充电智能充电桩。惠充电智能充电桩。";
	    			var image=__pblc__+"/IMG/chongdianzhuang.jpg";

	    			if(data['dvcls'][i]['deviceAscription']===2){

	    				//################
	    				str=data['dvcls'][i]['opentm'];
		    			if(data['dvcls'][i]['online']=='n'){
		    				str=str+'（不在线）';
		    				var icon=qinfeng_red;
		    				var apntswc='';
		    			}else if(data['dvcls'][i]['chargestatus']=='on'){
		    				str=str+'（正在充电）';
		    				var icon=qinfeng_yellow;
		    				var apntswc='';
		    			}else if(data['dvcls'][i]['isOrder']==1){
		    				str=str+'（已被预约）';
		    				var icon=qinfeng_yellow;
		    				var apntswc='';
		    			}else if(data['dvcls'][i]['isOwner']==1){
		    				var icon=qinfeng_green;
		    				var apntswc='';
		    			}else if(data['dvcls'][i]['opentm']){
		    				var icon=qinfeng_green;
		    				var apntswc="<a class='pull-left btn btn-success' id='apntbutton_"+dvcid+"' onclick='showapntdtl("+dvcid+")'><i class='glyphicon glyphicon-time'></i> 预约</a>";
		    			}else{
		    				str=str+'（未开放共享）';
		    				var icon=qinfeng_red;
		    				var apntswc='';
		    			}
		    			//#############
		    			desc="惠充电祝秦风会2015年年会圆满成功！&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		    			image=__pblc__+"/IMG/qinfenghui.jpg";
	    			}else{
	    				str=data['dvcls'][i]['opentm'];
		    			if(data['dvcls'][i]['online']=='n'){
		    				str=str+'（不在线）';
		    				var icon=wenyuan_red;
		    				var apntswc='';
		    			}else if(data['dvcls'][i]['chargestatus']=='on'){
		    				str=str+'（正在充电）';
		    				var icon=wenyuan_yellow;
		    				var apntswc='';
		    			}else if(data['dvcls'][i]['isOrder']==1){
		    				str=str+'（已被预约）';
		    				var icon=wenyuan_yellow;
		    				var apntswc='';
		    			}else if(data['dvcls'][i]['isOwner']==1){
		    				var icon=wenyuan_green;
		    				var apntswc='';
		    			}else if(data['dvcls'][i]['opentm']){
		    				var icon=wenyuan_green;
		    				var apntswc="<a class='pull-left btn btn-success' id='apntbutton_"+dvcid+"' onclick='showapntdtl("+dvcid+")'><i class='glyphicon glyphicon-time'></i> 预约</a>";
		    			}else{
		    				str=str+'（未开放共享）';
		    				var icon=wenyuan_red;
		    				var apntswc='';
		    			}
	    			}

	    			
	    			
	    			
	    			p[dvcid]=new BMap.Point(lgtd,lttd);

					var sContent =
					"<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+ads+"</h4>" + 
					"<img style='float:right;margin:4px' id='imgDemo' src='"+image+"' width='139' height='104' title=''/>" + 
					"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+desc+"</p>" + "<div class='infwdaptmt'><div>"+apntswc+"<a class='pull-left btn btn-warning' href='"+__url__+"/cmnt/dvcid/"+dvcid+"' style='margin-left:5px'><i class='glyphicon glyphicon-comment'></i> 评论</a></div></div>"
					+
					"</div>";
					var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
					lct(p[dvcid],infoWindow,'','','',icon,ads+str);
	    		}
	           //alert(string);map.panTo(new BMap.Point(121.47940183013,31.312701688104));      
	    		//alert(data['dvcls'][0]['latitude']);
	    		showpathifhasodr();//这个函数在index.html里头，用来显示路径如果有ondoing订单的话
	            console.log("success");
	    },
	    'error':function() {
	            console.log("error");
	    }
	});
}
