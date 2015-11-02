
$(function () {

	//------------------------接下来是通用部分
	$("#addusr").click(function(){
		var mobile=$('input[name=mobile]');
		var carBrand=$('select[name=carBrand]');
		var carModelId=$('select[name=carModelId]');
		var carNo=$('input[name=carNo]');
		
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
		
		if(carBrand.val()=='0'){
			alert('请选择车品牌！');
			return false;
		}
		if(carModelId.val()=='0'){
			alert('请选择车型号！');
			return false;
		}
		if($.trim(carNo.val())==''){
			alert('车牌号不能为空！');
			carNo.focus();
			return false;
		}
		
		
		var prmts=$("#addusr").parent().serialize();//parameters
		//防止既输入空又输入了有效值
		prmts=rmvblk(prmts);
		

		$.post(
			url_doregist,
			//'http://wangfengtest.duapp.com/user/init.action',
			prmts,
			function(data){
				
				alert(data.msg);
				location.href=data.url;
				
				
			
			},
			'json'
		);
		

		
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