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
        // 'async':false,  
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
            		var str="<tr><td>"+srlnb+"</td><td>"+data['odrls'][i]['cro']['carNo']+"</td><td>"+data['odrls'][i]['dvcnm']+"</td><td>"+data['odrls'][i]['crttmprx']+"<br>"+data['odrls'][i]['crttmtl']+"</td><td>";
            		if(data['odrls'][i]['stat']=='1'){
            			str=str+"<done style='color:#ccc'><i class='glyphicon glyphicon-time'></i> &nbsp;&nbsp;&nbsp;&nbsp;</done>";
            		}else{
            			str=str+"<doing style='color:#3CB371'><i class='glyphicon glyphicon-time'></i> &nbsp;&nbsp;&nbsp;&nbsp;</doing>";
            		}
            		str=str+"</td></tr>";
            		$('tbody').append(str);
            	}
            	nwpg=data['nwpg'];
            	$('#pullUp-msg').html(data['upstr']);
            	loaded();
			}

 			console.log("success");           
        },
        'error':function() {
            console.log("error");
        }
    });
}