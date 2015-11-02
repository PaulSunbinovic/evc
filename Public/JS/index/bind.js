$(function(){
	$('#getsmsvrf').click(function(){
		
		
		var usrcp=$('#usrcp');
		if($.trim(usrcp.val())==''){
			alert('电话不能为空！');
			usrcp.focus();
			
			return false;
		}
		var pttnmbl=/^1[34578][0-9]{9}$/;
		if(!pttnmbl.test($.trim(usrcp.val()))){
			alert('手机号码格式不正确！');
			usrcp.focus();
			
			return false;
		}
		$(this).attr('disabled',true);
		
		var starttm=60;
		//给数据库写个验证码
		$.ajax({
            'type': 'GET',
            'url': dogetsmsvrf,
            'async':false,  
            'contentType': 'application/json',
            'data': {
                'usrcp':usrcp.val(),
            },
            'dataType': 'json',
            'success': function(data) {alert(data['vrfnb']);
            		$('#vrfnb').val(data['vrfnb']);
              //       alert('由于短信测试已经到达限制极限，不过测试是OK的，现在就直接把验证码贴到匡匡里面了');
                    console.log("success");
            },
            'error':function() {
                    console.log("error");
            }
        });
        $('#binddvc').attr('disabled',false);
        countdown(starttm);
	})

	$('#binddvc').click(function(){
		var vrfnb=$('#vrfnb');
		if($.trim(vrfnb.val())==''){
			alert('验证码不能为空！');
			vrfnb.focus();
			return false;
		}
		$.ajax({
            'type': 'GET',
            'url': dobind,
            'async':false,  
            'contentType': 'application/json',
            'data': {
            	'dvcid':$('#dvcid').val(),
            	'vrfnb':vrfnb.val(),  
            },
            'dataType': 'json',
            'success': function(data) {
                if(data['vrf']==1){
                	alert(data['arr']['msg']);
                	window.location.href=data['url'];
                }else{
                	
                	alert('验证码输入不正确');

                }
                console.log("success");
            },
            'error':function() {
                console.log("error");
            }
        });
	})
})

function countdown(starttm){
	if(starttm>0){
		$('#getsmsvrf').html('还剩下'+starttm+'秒...');
		starttm=starttm-1;
		setTimeout("countdown("+starttm+")",1000); 
	}else{
		$('#getsmsvrf').html('请再次获取验证码');
		$('#getsmsvrf').attr('disabled',false);
		$('#binddvc').attr('disabled',true);
	}
	
}