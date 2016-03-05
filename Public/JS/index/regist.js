var gotourl='';
$(function () {

	//------------------------接下来是通用部分
	$("#addusr").click(function(){
		var mobile=$('input[name=mobile]');
		var vrfnb=$('input[name=vrfnb]');
		// var carBrand=$('select[name=carBrand]');
		// var carModelId=$('select[name=carModelId]');
		// var carNo=$('input[name=carNo]');
		
		//防止输入空
		if($.trim(mobile.val())==''){
			alert('手机号码不能为空！');
			mobile.focus();
			return false;
		}
		var pttnmbl=/^1[34578][0-9]{9}$/;
		if(!pttnmbl.test($.trim(mobile.val()))){
			alert('手机号码格式不正确！');
			mobile.focus();
			
			return false;
		}

		if($.trim(vrfnb.val())==''){
			alert('验证码不能为空');
			vrfnb.focus();
		}
		
		// if(carBrand.val()=='0'){
		// 	alert('请选择车品牌！');
		// 	return false;
		// }
		// if(carModelId.val()=='0'){
		// 	alert('请选择车型号！');
		// 	return false;
		// }
		// if($.trim(carNo.val())==''){
		// 	alert('车牌号不能为空！');
		// 	carNo.focus();
		// 	return false;
		// }
		// 
		$.ajax({
            'type': 'GET',
            'url': url_doregist,
            'async':false,  
            'contentType': 'application/json',
            'data': {
                'wechatId':$('input[name=wechatId]').val(),
                'headImgUrl':$('input[name=headImgUrl]').val(),
                'nickName':$('input[name=nickName]').val(),
                'mobile':$('input[name=mobile]').val(),
                'vrfnb':$('input[name=vrfnb]').val(),
            },
            'dataType': 'json',
            'success': function(data) {
            	alert(data.msg);
                if(data['rslt']=='ok'){
                	gotourl=data.url;
                	$('#modal').trigger('click');
                }else if(data['rslt']=='mok'){
                	gotourl=data.url;
                }              
				
                console.log("success");
            },
            'error':function() {
                console.log("error");
            }
        });
		
		
		// var prmts=$("#addusr").parent().serialize();//parameters
		// //防止既输入空又输入了有效值
		// prmts=rmvblk(prmts);
		

		// $.post(
		// 	url_doregist,
		// 	//'http://wangfengtest.duapp.com/user/init.action',
		// 	prmts,
		// 	function(data){
				
		// 		alert(data.msg);
		// 		location.href=data.url;
				
				
			
		// 	},
		// 	'json'
		// );
		

		
	})
	
	$("select[name=carBrand]").change(function(){
			
		var carBrand=$("select[name=carBrand]");
		var carModelId=$("select[name=carModelId]");
		if(carBrand.val()==0){
			carModelId.attr('disabled',true);
		}else{
			carModelId.attr('disabled',false);
		}
		
		

		$.post(
			url_getcarmodel,
			
			{'carBrand':carBrand.val()},
			function(data){
				
				carModelId.html(data.opts);
			
			},
			'json'
		);
		
	})
	
});


var prmts='';var str='';var ch='';
function rmvblk(prmts){//remove blank 去空格
	var prmtsnw='';//parameters new
	prmtsun=prmts.split('&');//parameters union
	for(var i=0;i<prmtsun.length;i++){
		if(i!=prmtsun.length-1){
			prmtsnw=prmtsnw+prmtsun[i].split('=')[0]+'='+superTrim(prmtsun[i].split('=')[1],'+')+'&';
		}else{
			prmtsnw=prmtsnw+prmtsun[i].split('=')[0]+'='+superTrim(prmtsun[i].split('=')[1],'+');
		}
	}
	return prmtsnw;
}

function   superTrim(str,ch) {  
	if(str.length>0 && str.indexOf(ch)!=-1){ //it is a string and have ch
	while(str.substring(0,1)==ch)  
			  str  =  str.substring(1,str.length);  
	while(str.substring(str.length-1,str.length)==ch)  
		str   =   str.substring(0,str.length-1);  
	}
	return   str;  
}


//-------------------------------------短信验证部分---------
$(function(){
    $('#getsmsvrf').click(function(){
                
        var usrcp=$('#usrcp');
        var wechatId=$('input[name=wechatId]');

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
                'wechatId':wechatId.val(),

            },
            'dataType': 'json',
            'success': function(data) {
                console.log("success");
            },
            'error':function() {
                console.log("error");
            }
        });
        $('#addusr').attr('disabled',false);
        countdown(starttm);
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