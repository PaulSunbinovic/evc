
$(function () {

	//------------------------接下来是通用部分
	$("#chongzhi").click(function(){
		var money=$('input[name=money]');
		
		//防止输入空
		if(isNaN($.trim(money.val()))){
			alert('钱数必须是数字');
			money.focus();
			return false;
		}
		
		
		
		var prmts=$("#chongzhi").parent().serialize();//parameters
		//防止既输入空又输入了有效值
		prmts=rmvblk(prmts);
		

		$.post(
			dochongzhi,
			prmts,
			function(data){
				location.href=data.url;
				
			
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