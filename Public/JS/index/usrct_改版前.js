var dvcid=0;var fctswc=1;//功能性开关 1则为有实际触发功能 0为只是动画
function onoff(id){
    dvcid=id;
   
    if(dvcsttsls[dvcid]=='off'){
        //alert('开');
        // var r=confirm("确定已经插枪？");
        // if(r==true){
            doonff('on','','');
        // }
        
        
    }else{
        //alert('关');
        // var r=confirm("点击确定将完成订单!");
        // if(r==true){
            doonff('off','','');
        // }
    }
}

//由于某些冲突，所以，tmofst在作为比对，是在jquery-clockpicker.js里面进行判断的。。。
var tmofst="";var stmod=1;//set mode 默认是提交设定
var weekSelectInit='';
function clc(id){//clock
    dvcid=id;
    
    $.ajax({
        'type': 'GET',
        'url': fnddvcbydvcid,
        'async':false,  
        'contentType': 'application/json',
        'data': {
            'dvcid':id,
            
        },
        'dataType': 'json',
        'success': function(data) {
            //当他弹出来后
            //
            //开放是半天还是一天，还是全天
            $('#openTime').val(data['status']);
            selectopentminit=$('#openTime').val();

            
            //初始化谁绿谁不绿
            var dayset=data['dayset'];
            if(dayset){
                var mon=dayset.indexOf('-1-');var tue=dayset.indexOf('-2-');var wed=dayset.indexOf('-3-');
                var thu=dayset.indexOf('-4-');var fri=dayset.indexOf('-5-');var sat=dayset.indexOf('-6-');
                var sun=dayset.indexOf('-7-');
                if(mon!=-1){changeDayMod('mon');}
                if(tue!=-1){changeDayMod('tue');}
                if(wed!=-1){changeDayMod('wed');}
                if(thu!=-1){changeDayMod('thu');}
                if(fri!=-1){changeDayMod('fri');}
                if(sat!=-1){changeDayMod('sat');}
                if(sun!=-1){changeDayMod('sun');}
                
            }
            //设置初始weekSelect状态
            weekSelectInit=$('#weekSelect').html();


            $('#dvcnm').html(data['dvco']['address']);
            $('#optm').val(data['timer']['tm']);
            if(data['timer']['tm']){
                tmofst=data['timer']['tm'];
                stmod=0;
                $('#sttm').attr('class','btn btn-default btn-lg btn-block');
                $('#sttm').html('取消设定');
            }
           
            console.log("success");
        },
        'error':function() {
                console.log("error");
        }
    });
    $('#modal').trigger('click');
}
function changeDayMod(daytype){
    if(daytype=='mon'){dayid='#day1';}else if(daytype=='tue'){dayid='#day2';}else if(daytype=='wed'){dayid='#day3';}else if(daytype=='thu'){dayid='#day4';}else if(daytype=='fri'){dayid='#day5';}else if(daytype=='sat'){dayid='#day6';}else if(daytype=='sun'){dayid='#day7';}
    var als=$(dayid).children('a');
    var a=als[0];
    classofa=$(a).attr('class');
    if(classofa.indexOf('default')==-1){
        classofa=classofa.replace(/success/g,'default');
    }else{
        classofa=classofa.replace(/default/g,'success');
    }
    $(a).attr('class',classofa);
}

$(function(){

    $('#openTime').change(function(){

        if($('#openTime').val()==selectopentminit){
            stmod=0;
            $('#sttm').attr('class','btn btn-default btn-lg btn-block');
            $('#sttm').html('取消设定'); 
        }else{
            stmod=1;
            $('#sttm').attr('class','btn btn-success btn-lg btn-block');
            $('#sttm').html('提交设定');

        }
    })

    $('#cnclstttm').click(function(){
        $('#stttm').val('');
    })

    $('#cnclendtm').click(function(){
        $('#endtm').val('');
    })

    $('#sttm').click(function(){
        //先获取每周参数
        var week='';
        for(var i=1;i<=7;i++){
            var day=$('#day'+i);
            var als=day.children('a');
            var strOfClass=$(als[0]).attr('class');
            if(strOfClass.indexOf('success')!=-1){//选中
                //转换成 MON 这种形式
                var d='';
                if(i==1){d='MON';}else if(i==2){d='TUE';}else if(i==3){d='WED';}else if(i==4){d='THU';}else if(i==5){d='FRI';}else if(i==6){d='SAT';}else if(i==7){d='SUN';}
                if(week==''){
                    week=d;
                }else{
                    week=week+','+d;
                }
            }
        }
        

        var openTime=$('#openTime').val();
        if(stmod==1){
            doonff('on',$('#optm').val(),week,openTime);
        }else{
            $.ajax({
                'type': 'GET',
                'url': cancelsttm,
                'async':false,  
                'contentType': 'application/json',
                'data': {
                    'dvcid':dvcid,
                    
                },
                'dataType': 'json',
                'success': function(data) {
                       
                    alert('取消设定成功！');
                    $('#cancel').trigger('click');
                    console.log("success");
                },
                'error':function() {
                        console.log("error");
                }
            });
        }
        
       
    })

    $('.week').click(function(){
        var als=$(this).children('a');
        var a=als[0];
        classofa=$(a).attr('class');
        if(classofa.indexOf('default')==-1){
            classofa=classofa.replace(/success/g,'default');
        }else{
            classofa=classofa.replace(/default/g,'success');
        }
        $(a).attr('class',classofa);
        var id=$(this).attr('id');
        if(id.indexOf('day')!=-1){
            var als=$('#work').children('a');
            var a=als[0];
            classofa='btn btn-default btn-block';
            $(a).attr('class',classofa);
        }
        checkWeekSelectChange();
    })

    $('#work').click(function(){
        var als=$(this).children('a');
        var a=als[0];
        classofa=$(a).attr('class');
        if(classofa.indexOf('default')==-1){
            var classofa5='btn btn-success btn-block padding-w-1-px';
            var classofa2='btn btn-default btn-block padding-w-1-px';
        }else{
            var classofa5='btn btn-default btn-block padding-w-1-px';
            var classofa2='btn btn-default btn-block padding-w-1-px';
        }
        
        for(var i=1;i<=5;i++){
            var als=$('#day'+i).children('a');
            var a=als[0];
            $(a).attr('class',classofa5);
        }
        for(var i=6;i<=7;i++){
            var als=$('#day'+i).children('a');
            var a=als[0];
            $(a).attr('class',classofa2);
        }
        checkWeekSelectChange();
    })



    $('#cncloptm').click(function(){
        $('#optm').val('');
    })

    // $('#optm').change(function(){
    //     alert();
    // })
    
})


function checkWeekSelectChange(){
    //当前状态下的数据和初始的对不上的话呢
    if(weekSelectInit==$('#weekSelect').html()){
        stmod=0;
        $('#sttm').attr('class','btn btn-default btn-lg btn-block');
        $('#sttm').html('取消设定'); 
    }else{
        stmod=1;
        $('#sttm').attr('class','btn btn-success btn-lg btn-block');
        $('#sttm').html('提交设定');
    }
    
}

function doonff(oprt,tm,week,openTime){
    //如果不在线就算了
    if(disabledls[dvcid]=='disabled'){
        return;
    }
    if(fctswc==1){
        $.ajax({
            'type': 'GET',
            'url': doonoffdvc,
            'async':false,  
            'contentType': 'application/json',
            'data': {
                'dvcid':dvcid,
                'tm':tm,
                'oprt':oprt,
                'week':week,
                'openTime':openTime,
            },
            'dataType': 'json',
            'success': function(data) {


                    
                //带着时间过来的，肯定是sttm派来的;不带时间过来的，肯定是直接整的开关
                if(tm){
                    $('#cls').trigger('click');
                    if(data['rslt']=='ok'){
                        //完成设定成功的话要给数组库添加值，以后只要和新成立的结论不正确的
                        //dvcls[dvcid]=tm;
                        $('#btn_'+dvcid).html("<a class='btn btn-success btn-lg btn-block blk' href='#'><i class='glyphicon glyphicon-time'></i> "+tm+"</a>");
                        //成功的话就以现在的状态为准，把当前的状态设置成初始状态
                        weekSelectInit=$('weekSelect').html();
                       
                    }else{
                        
                    }

                    //这个是设定共享时间
                    if(data['rslt_svsharetm']=='ok'){
                        //初始参考量变化
                        selectopentminit=$('#openTime').val(); 
                        //左下角变化
                        var shareobj=$('#share_'+dvcid);
                       
                        shareobj.html("<a class='btn btn-"+data['arr_share']['color']+" btn-lg btn-block blk' href='#'><i class='"+data['arr_share']['icon']+"''></i> "+data['arr_share']['str']+"</a>");
                        
                    }
                    
                    alert(data['msg']);
                    check(dvcid);
                }else{

                    if(data.rslt=='error'){
                        //错误就不用改变原来dvcsttsls中的状态
                        alert(data.msg);
                        check(dvcid);
                        //失败的话，如果检测到需要消失，那就消失
                        if(data['clsapntswc']==1){
                            $('#orderswc').hide();
                        }
                            
                    }else{//成功的alert只为测试用的
                        //开启loading,知道失败和成功才结束
                        $('#modal_loading').trigger('click');
                        //每半秒钟访问一次桩，访问20次，持续10秒，直到检测操作执行掉了
                        var i=0;
                        var int=self.setInterval(
                                function(){
                                    if(i==10){
                                        check(dvcid);
                                        $('#cancel_loading').trigger('click');
                                        alert('操作失败！');
                                        int=window.clearInterval(int);
                                        
                                    }
                                    i=i+1;
                                    $.ajax({
                                        'type': 'GET',
                                        'url': dotakesample,
                                        'async':false,  
                                        'contentType': 'application/json',
                                        'data': {
                                            'dvcid':dvcid,
                                            
                                        },
                                        'dataType': 'json',
                                        'success': function(data) {
                                            
                                            if(data['rslt']==oprt){
                                                dvcsttsls[dvcid]=oprt;

                                                check(dvcid);
                                                //之前一旦off是拟消失的，这里是成功，那么拟消失变成真消失（PS，去开的时候肯定是不会置1，去关的时候可能会拟置1，理论上不会有问题的把）
                                                if(data['clsapntswc']==1){
                                                    $('#orderswc').hide();
                                                }
                                                $('#cancel_loading').trigger('click');
                                                int=window.clearInterval(int);
                                            }
                                           // break;
                                            console.log("success");
                                        },
                                        'error':function() {
                                            console.log("error");
                                        }
                                    });
                                }
                            ,500);
                        
                    }
                    
                }
                    
                    
                    
                console.log("success");
            },
            'error':function() {
                console.log("error");
            }
        });
    }
    
}

function check_dvc(stts,dvcid){
  
    var $obj=$('#dvc_'+dvcid);
    var checkvalue=$obj.attr('checked');
    var lbl=$obj.parent().children('lbl')[0];
    var $lbl=$(lbl);
   
    if(stts=='notonline'){
        if(checkvalue=='checked'){$obj.trigger('click');}
        $obj.attr('disabled',true);
        $lbl.html('设备不在线');
    }else if(stts=='on'&&checkvalue!='checked'){
        $obj.trigger('click');
        $lbl.html('ON');
    }else if(stts=='off'&&checkvalue=='checked'){
        $obj.trigger('click');
        $lbl.html('OFF');
    }
    
}

function check_capacity(fast_slow_charge,dvcid){
  
    var $obj=$('#capacity'+dvcid);
    var checkvalue=$obj.attr('checked');
    var lbl=$obj.parent().children('lbl')[0];
    var $lbl=$(lbl);
   
    if(stts=='notonline'){
        if(checkvalue=='checked'){$obj.trigger('click');}
        $obj.attr('disabled',true);
        $lbl.html('设备不在线');
    }else if(stts=='on'&&checkvalue!='checked'){
        $obj.trigger('click');
        $lbl.html('ON');
    }else if(stts=='off'&&checkvalue=='checked'){
        $obj.trigger('click');
        $lbl.html('OFF');
    }
    
}

function changeCapacity(id){
    if(dvcsttsls[id]=='on'){
        alert('请先关闭充电，然后再调整充电功率，然后再开启充电！');
        return;
    }
    var objOfCapacity=$('#capacity_'+id);
    //思路 先获取设备原来的capacity状态，然后取相反就行了
    $.ajax({
        'type': 'GET',
        'url': fnddvcbydvcid,
        'async':false,  
        'contentType': 'application/json',
        'data': {
            'dvcid':id,
            
        },
        'dataType': 'json',
        'success': function(data) {
            var capacity=data['dvco']['capacity'];
            if(capacity==1){
                capacity=2;
            }else if(capacity=2){
                capacity=1;
            }else{
                capacity=2;
            }
            $.ajax({
                'type': 'GET',
                'url': doChangeCapacity,
                'async':false,  
                'contentType': 'application/json',
                'data': {
                    'dvcid':id,
                    'capacity':capacity,
                },
                'dataType': 'json',
                'success': function(data) {
                    if(data['rslt']=='ok'){
                        $('valueOfCapacity').html(data['valueOfCapacity']);
                     }else{
                        alert(data['msg']);
                     }
                   
                    
                   
                    console.log("success");
                },
                'error':function() {
                    console.log("error");
                }
            });
           
            console.log("success");
        },
        'error':function() {
                console.log("error");
        }
    });
}

//#####################share的变换
function changesharemode(id){
    $.ajax({
        'type': 'GET',
        'url': dochangesharemode,
        'async':false,  
        'contentType': 'application/json',
        'data': {
            'dvcid':id,
        },
        'dataType': 'json',
        'success': function(data) {
            if(data['rslt']=='ok'){
                var shareobj=$('#share_'+id);
                shareobj.html("<a class='btn btn-"+data['arr_share']['color']+" btn-lg btn-block blk' href='#'><i class='"+data['arr_share']['icon']+"''></i> "+data['arr_share']['str']+"</a>");
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

function changetimer(id){
    $.ajax({
        'type': 'GET',
        'url': dochangetimer,
        'async':false,  
        'contentType': 'application/json',
        'data': {
            'dvcid':id,
        },
        'dataType': 'json',
        'success': function(data) {
            if(data['rslt']=='ok'){
                var timerobj=$('#timer_'+id);
                timerobj.html("<a class='btn btn-"+data['color']+" btn-lg btn-block blk' href='#'><i class='glyphicon glyphicon-time'></i> </a>");
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