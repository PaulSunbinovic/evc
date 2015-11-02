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
                    var str="<li onclick=showdtl("+data['odrls'][i]['id']+") style='line-height: 80px;'><div class='col-md-12 col-xs-12'><div class='col-md-4 col-xs-4 nopadding'>"+data['odrls'][i]['dvcnm']+"</div><div class='col-md-4 col-xs-4 nopadding'>"+data['odrls'][i]['createTime']+"</div><div class='col-md-2 col-xs-2 nopadding'>"+data['odrls'][i]['totalPrice']+"</div><div class='col-md-2 col-xs-2 nopadding' style='padding-left:20px;'>";
                    if(data['odrls'][i]['stat']=='1'){
                        str=str+"<done style='color:#ccc'><i class='glyphicon glyphicon-time'></i></done>";
                    }else{
                        str=str+"<doing style='color:#3CB371'><i class='glyphicon glyphicon-time'></i></doing>";
                    }
                    str=str+"</div></div></li>";
                    $('#thelist').append(str);
                    odrls[data['odrls'][i]['id']]=data['odrls'][i];
                    //这里说明一下，由于ajax 给的就是json话的数组，因此直接可以用//而普通的display不一样，给的是php的数组，js是不认识的，要json化后，传到前台，然后前台把其认为是数组
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

function showdtl(id){
    var odro=odrls[id];
    $('#crno').html(odro['cro']['carNo']);
    $('#dvcnm').html(odro['dvcnm']);
    $('#crttm').html(odro['createTime']);
    $('#edtm').html(odro['endTime']);
    $('#dgr').html(odro['endDegree']-odro['startDegree']);
    $('#fee').html(odro['totalPrice']);
    if(odro['statusFinal']==true){
        $('#stat').html('正在预约');
    }else{
        $('#stat').html('未完成');
    }


    $('#modal').trigger('click');
}