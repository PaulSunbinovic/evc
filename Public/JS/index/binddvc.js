$(function(){
	//##########
	$('#binddvc').click(function(){
		//###设置参参数
		var sn=$('#sn');
		var lgtd=$('#lgtd');
		var lttd=$('#lttd');
		//###检查是否是空
		if(sn.val()==''){alert('SN码不能为空');return false;}
		if(lgtd.val()==''){alert('经度不能为空');return false;}
		if(lttd.val()==''){alert('纬度不能为空');return false;}
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

