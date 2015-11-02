function slideDown(){
	$.ajax({
        'type': 'GET',
        'url': dodnfrsh,
        // 'async':false,  
        'contentType': 'application/json',
        'data': {
        	'nwpg':nwpg,
            
        },
        'dataType': 'json',
        'success': function(data) {
            if(data['rslt']==0){
            	alert('无更新内容');
            }
 			console.log("success");           
        },
        'error':function() {
            console.log("error");
        }
    });
}
function slideUp(){
	$.ajax({
        'type': 'GET',
        'url': doupld,
        'async':false,  
        'contentType': 'application/json',
        'data': {
        	'nwpg':nwpg,
        },
        'dataType': 'json',
        'success': function(data) {
            if(data['rslt']==0){
            	alert('无更新内容');
            }else{
            	for(var i=0;i<data['odrls'].length;i++){
            		srlnb++;
            		var str="<li><div class='col-md-12 col-xs-12'><div class='col-md-1 col-xs-1 nopadding'>"+srlnb+"</div><div class='col-md-3 col-xs-3 nopadding'>"+data['odrls'][i]['cro']['carNo']+"</div><div class='col-md-4 col-xs-4 nopadding'>"+data['odrls'][i]['dvcnm']+"</div><div class='col-md-2 col-xs-2 nopadding'>"+data['odrls'][i]['createTime']+"</div><div class='col-md-1 col-xs-1 nopadding' style='padding-left:20px;'>";
            		if(data['odrls'][i]['stat']=='1'){
            			str=str+"<done style='color:#ccc'><i class='glyphicon glyphicon-time'></i></done>";
            		}else{
            			str=str+"<doing style='color:#3CB371'><i class='glyphicon glyphicon-time'></i></doing>";
            		}
            		str=str+"</div></div></li>";
            		$('#thelist').append(str);
            	}
            	nwpg=data['nwpg'];
            	$('#pullUp-msg').html(data['upstr']);
            	
			}

 			console.log("success");           
        },
        'error':function() {
            console.log("error");
        }
    });
}