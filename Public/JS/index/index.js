//假装通过数据库获取数据
			

$(function(){
	
	$("#ctt").bind("input propertychange",function(){
		
	    var ctt=$.trim($('#ctt').val());
	    var ul="<ul  class='list-group'>";
	    var flag=0;
	    
	    if(ctt!=''){

            $.ajax({
                'type': 'GET',
                'url': dofnddvcls,
                'async':false,  
                'contentType': 'application/json',
                'data': {
                    'ctt':ctt,  
                    // 'crmdlid',crmdlid,  
                },
                'dataType': 'json',
                'success': function(data) {
                        for(var i=0;i<data['dvcls'].length;i++){
                            
                            flag=1;
                            ul=ul+"<li  class='list-group-item' onclick='panto(p["+data['dvcls'][i]['id']+"])'>"+data['dvcls'][i]['address']+"</li>";
                            
                        }
                        
                        console.log("success");
                },
                'error':function() {
                        console.log("error");
                }
            });
	    	
	    }
	    
	    if(flag==0){
	    	ul=ul+"<li  class='list-group-item'>暂无结果</li>";
	    }
	    ul=ul+"</ul><a class='btn btn-danger' style='width:100%' onclick='clspp()'>关闭搜索结果</a>";
	    $('#example').attr('data-content',ul);
	    $('#example').popover('show');
	})



	$('#scanqr').click(function(){
        $('#example').popover('hide');
        $('#modal_qr').trigger('click');
    })

	$('#usrct').click(function(){
        $.ajax({
            'type': 'GET',
            'url': vrfusrstat,
            // 'async':false,  
            'contentType': 'application/json',
            'data': {
                'x':'usrct',     
            },
            'dataType': 'json',
            'success': function(data) {
                   
                    location.href=data.url;
                    
                    console.log("success");
            },
            'error':function() {
                    console.log("error");
            }
        });
    })

	$('#cls_cnclodr_trg').click(function(){
		$('#cls_cnclodr').trigger('click');
	})

	$('#cls_hsgp_trg').click(function(){
		$('#cls_hsgp').trigger('click');
	})

    $('#apntok').click(function(){
        $.ajax({
            'type': 'GET',
            'url': vrfusrstat,
            // 'async':false,  
            'contentType': 'application/json',
            'data': {
                'x':'apnt',
            },
            'dataType': 'json',
            'success': function(data) {
                   
                   if(data['mtd']=='url'){
                   	 	location.href=data['url'];
                   }else if(data['mtd']=='trg'){
                   		apnt('ok');
                   }
                    
                    console.log("success");
            },
            'error':function() {
                    console.log("error");
            }
        });
    })

    

    
});

function clspp(){
	$('#example').popover('hide');
}
function panto(pnt){
	map.panTo(pnt);
	$('#example').popover('hide');    
}


function showapntdtl(id){
    $.ajax({
        'type': 'GET',
        'url': getdvcsharedtl,
         // 'async':false, //同步异步无所谓到情况下就默认异步好了
        'contentType': 'application/json',
        'data': {
            'dvcid':id, 
            
        },
        'dataType': 'json',
        'success': function(data) {
            if(data['rslt']=='ok'){
                $('#myModalLabel_apntdtl').html(data['dvco']['address']);
                $('#shareTime').html(data['shareTime']);
                $('#confirm').attr('onclick','apnt('+id+')');
                $('#apntdtl').trigger('click');
            }else{
                alert(data['msg']);
            }
            
                
            console.log("success");
        },
        'error':function() {
            console.log("error");
        }
    });
}

function apnt(id){

	$.ajax({
        'type': 'GET',
        'url': doapnt,
         // 'async':false, //同步异步无所谓到情况下就默认异步好了
        'contentType': 'application/json',
        'data': {
            'tp':id, 
            //'crid':crid, 
            'lgtd':ctlgtd,
            'lttd':ctlttd,
        },
        'dataType': 'json',
        'success': function(data) {
        	if(data['rslt']=='hsodr'){
        		//有订单的话就要弹是否取消XX订单的对话框
        		// alert(data['odr']['id']);
        		$('#ads').html(data['odrpnt']['address']);
        		$('#crno').html(crno);
        		cnclodrid=data['odr']['id'];//用于如果要取消，直接从这个广域变量里拿了，不去后台要了
        		$('#modal_cnclodr').trigger('click');
        	}else if(data['rslt']=='hsgp'){
        		$('#mny').html(data['mny']);
        		$('#tm').html(data['tm']);
        		$('#modal_hsgp').trigger('click');
        		dvcid=data['dvcid'];
        	}else if(data['rslt']=='hsbtm'){
        		alert('余额不足，请充值后预约');
        	}else if(data['rslt']=='ok'){
        		lgtd=data['apntpnt']['longitude'];
				lttd=data['apntpnt']['latitude'];
				ads=data['apntpnt']['address'];
		    	dvcid=data['apntpnt']['id'];
		        str=data['apntpnt']['opentm'];
				var apntpnt=new BMap.Point(lgtd,lttd);
				//技术储备，万一那天用得到	
				// var sContent =
				// 		"<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+ads+"</h4>" + 
				// 		"<img style='float:right;margin:4px' id='imgDemo' src='"+cdzpt+"' width='139' height='104' title=''/>" + 
				// 		"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em;color:red'>预约此桩后，如果不赴约，须去个人中心取消此预约。</p>" + "<div class='infwdaptmt'><div><a class='pull-left btn btn-success' href='"+apntprx+"/"+dvcid+"'>确定预约</a></div></div>"
				// 		+
				// 		"</div>";
				// var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
                // map.openInfoWindow(infoWindow,apntpnt); //开启信息窗口
                var icon=icon_red;
                var apntswc="";
                p[dvcid]=new BMap.Point(lgtd,lttd);
				
                var sContent =
                "<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+ads+"</h4>" + 
                "<img style='float:right;margin:4px' id='imgDemo' src='"+cdzpt+"' width='139' height='104' title=''/>" + 
                "<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>惠充电智能充电桩。惠充电智能充电桩。惠充电智能充电桩。惠充电智能充电桩。惠充电智能充电桩。</p>" + "<div class='infwdaptmt'><div>"+apntswc+"<a class='pull-left btn btn-warning' href='"+__url__+"/cmnt/dvcid/"+dvcid+"' style='margin-left:5px'><i class='glyphicon glyphicon-comment'></i> 评论</a></div></div>"
                +
                "</div>";
                var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
                lct(p[dvcid],infoWindow,'','','',icon,ads+str);
                driving.search(mypoint, apntpnt);
                $('#cls_apntdtl').trigger('click');
                //###################################下面变化
                $('#apntok').html("<a type='button' class='btn btn-danger' style='border:0px' href='"+__app__+"/Usr/carmstct'><i class='glyphicon glyphicon-user'></i><br>车主中心</a>");
                $('#apntok').attr('id','apntX');//取消了原来的ID一面造成js上的冲突
        	}else if(data['rslt']=='moneynotenough'){
        		$('#cls_apntdtl').trigger('click');
                alert(data['msg']);
                location.href=__app__+'/Usr/chongzhi';
            }else{
            	$('#cls_apntdtl').trigger('click');
                alert(data['msg']);
                //未来可能是进入那个订单列表里面
            }
            
        		
        		
            console.log("success");
        },
        'error':function() {
                console.log("error");
        }
	});
}

