$(function(){
	//##########
	$('#getusrlsbymobile').click(function(){
		//###设置参参数
		var mobile=$('#mobile');
		
		//###检查是否是空
		if(mobile.val()==''){alert('手机号码不能为空');return false;}
		
		//###ajax
		$.ajax({
            'type': 'GET',
            'url': dofindusrls,
            'async':false,  
            'contentType': 'application/json',
            'data': {
                'mobile':mobile.val(),
                
            },
            'dataType': 'json',
            'success': function(data) {
            	if(data['rslt']==1){
            		var str="<option value='无'>无</option>";
                    var usrls=data['usrls'];
                    for(var i=0;i<usrls.length;i++){
                        var usro=usrls[i];
                        str=str+"<option value='"+usro['wechatId']+"'>"+usro['nickName']+"</option>";
                    }
                    $('#wechatid').html(str);
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
    //##########
    $('#dohanddvc').click(function(){
        //###设置参参数
        var wechatid=$('#wechatid');
        
        //###检查是否是空
        if(wechatid.val()==''){alert('请选择相应用户');return false;}
        
        //###ajax
        $.ajax({
            'type': 'GET',
            'url': dohanddvc,
            'async':false,  
            'contentType': 'application/json',
            'data': {
                'wechatid':wechatid.val(),
                
            },
            'dataType': 'json',
            'success': function(data) {
                alert(data['msg']);
                if(data['rslt']==1){
                    var cls=$(this).attr('class');
                    cls=cls+' disabled';
                    $(this).attr('class',cls);
                }
                
                console.log("success");
            },
            'error':function() {
                console.log("error");
            }
        });
        
    })


})

