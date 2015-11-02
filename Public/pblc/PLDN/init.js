$(function(){
	//如果 真实长度 scrollHeight 比 可视高度 长的话，需要添加展开的，一开始产生的就这么搞好了，接下来的，都要根据id一个个整在pldn的时候
	var extendls=$('.extend');
	for(var i=0;i<extendls.size();i++){
		var extendo= $(extendls[i]);
		var content=extendo.parent().parent().children('div')[1];
		if(content.scrollHeight<=content.offsetHeight){
			extendo.hide();
		}

	}

	$('.extend').click(function(){

		var divls=$(this).parent().parent().children('div');
		
		if($(divls[1]).hasClass('overflowhidden')){
			$(divls[1]).removeClass('overflowhidden');
			$(this).html("<i class='glyphicon glyphicon-triangle-top'></i> 收起");
		}else{
			$(divls[1]).addClass('overflowhidden');
			$(this).html("<i class='glyphicon glyphicon-triangle-bottom'></i> 展开");
		}
		
	})
})