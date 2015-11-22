function slideDown(){
    $.ajax({
        'type': 'GET',
        'url': dodnfrsh,
        // 'async':false,  
        'contentType': 'application/json',
        'data': {
            'pgnumber':pgnumber,
            
        },
        'dataType': 'json',
        'success': function(data) {
            if(data['rslt']=='n'){
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
    var upstr='';
    $.ajax({
        'type': 'GET',
        'url': doupld,
        'async':false,  
        'contentType': 'application/json',
        'data': {
            'pgnumber':pgnumber,
        },
        'dataType': 'json',
        'success': function(data) {
            if(data['rslt']=='n'){
                alert('无更新内容');
                upstr=data['upstr'];
                //###############由于在执行完后下拉的异步最后给那个写上 上拉完成...神马的，所以我们只能延后半秒出现，这样的解决办法是最快的
                setTimeout("$('#pullUp-msg').html('"+upstr+"');",500);
                
            }else{
                for(var i=0;i<data['odrls'].length;i++){
                    srlnb++;
                    var str="<li style='line-height: 80px;'><div class='col-md-12 col-xs-12 nopadding'><div class='col-md-4 col-xs-4 nopadding'>"+data['odrls'][i]['dvcnm']+"</div><div class='col-md-3 col-xs-3 nopadding'>"+data['odrls'][i]['createTime']+"</div><div class='col-md-2 col-xs-2 nopadding'>"+data['odrls'][i]['totalPrice']+"</div><div class='col-md-3 col-xs-3 nopadding' style='padding-left:20px;'>";
                    if(data['odrls'][i]['status']=='0'){
                        str=str+"<button class='btn btn-danger' onclick='cancelapnt("+data['odrls'][i]['id']+")'>取消预约</button>";
                    }else if(data['odrls'][i]['status']=='5'){
                         str=str+"<button class='btn btn-danger' onclick='jiesuan("+data['odrls'][i]['id']+")'>完成结算</button>";
                    }else if(data['odrls'][i]['status']=='6'){
                        str=str+"<status style='color:#ccc'>已完成</status>";
                    }
                    str=str+'</div></div></li>';
                    
                    $('#thelist').append(str);
                    odrls[data['odrls'][i]['id']]=data['odrls'][i];
                    //这里说明一下，由于ajax 给的就是json话的数组，因此直接可以用//而普通的display不一样，给的是php的数组，js是不认识的，要json化后，传到前台，然后前台把其认为是数组
                }
                pgnumber=data['pgnumber'];
                upstr=data['upstr'];
                //###############由于在执行完后下拉的异步最后给那个写上 上拉完成...神马的，所以我们只能延后半秒出现，这样的解决办法是最快的
                setTimeout("$('#pullUp-msg').html('"+upstr+"');",500);
                
            }

            console.log("success");           
        },
        'error':function() {
            console.log("error");
        }
    });
}
//######################可能用的到，目前先不让用到就是查看详细
function showdtl(id){
    var odro=odrls[id];
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
//###########################取消预约
function cancelapnt(odrid){
    var execancelapnt='n';
     $.ajax({
        'type': 'GET',
        'url': dochecktimeout,
        'async':false,  
        'contentType': 'application/json',
        'data': {
            'odrid':odrid,
            
        },
        'dataType': 'json',
        'success': function(data) {
            if(data['timeout']=='y'){
                var r=confirm("您已经超过15分钟，此时取消将扣除一定的服务费，你确定真的要取消么？");
                if (r==true){
                    execancelapnt='y';
                }
                  
            }else{
                execancelapnt='y';
            }
            if(execancelapnt=='y'){
                $.ajax({
                    'type': 'GET',
                    'url': docancelapnt,
                    'async':false,  
                    'contentType': 'application/json',
                    'data': {
                        'odrid':odrid,
                        
                    },
                    'dataType': 'json',
                    'success': function(data) {
                        alert(data['msg']);
                        if(data['rslt']=='ok'){
                            window.location.reload();
                        }
                        console.log("success");           
                    },
                    'error':function() {
                        console.log("error");
                    }
                });
            }
            console.log("success");           
        },
        'error':function() {
            console.log("error");
        }
    });
}
//###########################完成结算
function jiesuan(odrid){
   
     $.ajax({
        'type': 'GET',
        'url': dojiesuan,
        'async':false,  
        'contentType': 'application/json',
        'data': {
            'odrid':odrid,
            
        },
        'dataType': 'json',
        'success': function(data) {
            if(data['rslt']=='ok'){
                alert('结算成功！');
                window.location.reload();
            }
            console.log("success");           
        },
        'error':function() {
            console.log("error");
        }
    });
}