$(function(){
//##########
	$('#getusrlsbymobile').click(function(){
		//###设置参参数
		var mobile=$('#mobile');
		
		//###检查是否是空，楠哥说不给值也行
		//if($.trim(mobile.val())==''){alert('手机号码不能为空');return false;}
        //###检查格式
        var pttnmbl=/^1[34578][0-9]{9}$/;
        if($.trim(mobile.val())!=''&&!pttnmbl.test($.trim(mobile.val()))){
            alert('手机号码格式不正确！');
            mobile.focus();
            
            return false;
        }
		
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
            		var str="";
                    var usrls=data['usrls'];
                    for(var i=0;i<usrls.length;i++){
                        var usro=usrls[i];
                        str=str+"<li class='list-group-item wechatid' id='"+usro['wechatId']+"' onclick=chooseusr('"+usro['wechatId']+"')>"+usro['nickName']+"</li>";
                    }
                    $('#usrls').html(str);
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

    $('#domdfusr').click(function(){

        var realName=$('#realName');
        $.ajax({
            'type': 'GET',
            'url': domdfusr,
            'async':false,  
            'contentType': 'application/json',
            'data': {
                'realName':realName.val(),
                'para':para,
            },
            'dataType': 'json',
            'success': function(data) {
                if(data['rslt']==1){
                    
                    alert(data['msg']);
                    window.location.href=__url__+'/usrct';
                    
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

function chooseusr(wechatid){
    $('.wechatid').attr('class','list-group-item wechatid');
    $('#'+wechatid).attr('class','list-group-item wechatid active');
    $.ajax({
        'type': 'GET',
        'url': dogetusro,
        'async':false,  
        'contentType': 'application/json',
        'data': {
            'wechatid':wechatid,
            
        },
        'dataType': 'json',
        'success': function(data) {
            if(data['rslt']==1){
                para=data['para'];
                $('#realName').val(data['usro']['realName']);
            }else{
                alert(data['msg']);
            }
            
            console.log("success");
        },
        'error':function() {
            console.log("error");
        }
    })
        
    
}