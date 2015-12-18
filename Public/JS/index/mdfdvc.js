$(function(){
	//##########
	$('#mdfdvc').click(function(){
		//###设置参参数
		var sn=$('#sn');
		var lgtd=$('#lgtd');
		var lttd=$('#lttd');
        var address=$('#address');
        var version=$('#version');
        var groupid=$('#groupid');
        var deviceAscription=$('#deviceAscription');
		//###检查是否是空
		if(sn.val()==''){alert('SN码不能为空');return false;}
		if(lgtd.val()==''){alert('经度不能为空');return false;}
		if(lttd.val()==''){alert('纬度不能为空');return false;}
		//###ajax
		$.ajax({
            'type': 'GET',
            'url': domdfdvc,
            'async':false,  
            'contentType': 'application/json',
            'data': {
                'dvcid':dvcid,
                'sn':sn.val(),
                'lgtd':lgtd.val(),
                'lttd':lttd.val(),
                'address':address.val(),
                'version':version.val(),
                'groupid':groupid.val(),
                'deviceAscription':deviceAscription.val(),
                'path':path,
            },
            'dataType': 'json',
            'success': function(data) {
            	alert(data['msg']);
                //history.go(-1);
            	
                console.log("success");
            },
            'error':function() {
                console.log("error");
            }
        });
		
	})


})

function changedvc(){
    var sn=$('#sn');
    var lgtd=$('#lgtd');
    var lttd=$('#lttd');
    var address=$('#address');
    var version=$('#version');
    var groupid=$('#groupid');
    var deviceAscription=$('#deviceAscription');
    //################
    $.ajax({
        'type': 'GET',
        'url': dochangedvc,
        'async':false,  
        'contentType': 'application/json',
        'data': {
            'sn':sn.val(),
           
        },
        'dataType': 'json',
        'success': function(data) {
            if(data['rslt']==1){
                dvco=data['dvco'];

                dvcid=dvco['id'];
                owner=dvco['owner'];
                sn.val(dvco['sn']);
                model=dvco['model'];
                city=dvco['city'];
                lgtd.val(dvco['longitude']);
                lttd.val(dvco['latitude']);
                address.val(dvco['address']);
                peripheral=dvco['peripheral'];
                ip=dvco['ip'];
                serverIp=dvco['serverIp'];
                serverPort=dvco['serverPort'];
                pic=dvco['pic'];
                battery=dvco['battery'];
                status=dvco['status'];
                capacity=dvco['capacity'];
                listShareTime=dvco['listShareTime'];
                user=dvco['user'];
                isOrder=dvco['isOrder'];
                listShareTime=dvco['listShareTime'];
                isOwner=dvco['isOwner'];
                version.val(dvco['version']);
                path=dvco['path'];
                time=dvco['time'];
                week=dvco['week'];
                paramMap=dvco['paramMap'];
                deviceAscription.val(dvco['deviceAscription']);
                groupid.val(dvco['groupId']);
                deviceType=dvco['deviceType'];


                
                
               
                
                
            }else{
                 alert(data['msg']);
            }
            
           
            
            console.log("success");
        },
        'error':function() {
            console.log("error");
        }
    });

}