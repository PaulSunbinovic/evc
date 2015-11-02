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
                for(var i=0;i<data['payls'].length;i++){
                    srlnb++;
                    var str="<li><div class='col-md-12 col-xs-12 nopadding'><div class='col-md-5 col-xs-5 nopadding'>"+data['payls'][i]['transactionId']+"</div><div class='col-md-4 col-xs-4 nopadding'>"+data['payls'][i]['createTime']+"</div><div class='col-md-3 col-xs-3 nopadding'>"+data['payls'][i]['money']+"</div></div></li>";
                   
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