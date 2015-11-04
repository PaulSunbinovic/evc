var dvcid=0;var fctswc=1;//功能性开关 1则为有实际触发功能 0为只是动画
function onoff(id){
    dvcid=id;
    var obj=$('#dvc_'+id);
    var ckd=obj.attr('checked');

    if(ckd=='checked'){
        //alert('开');
        doonff('on','','')
        
    }else{
        //alert('关');
        doonff('off','','');
    }
}

function clc(id){//clock
    dvcid=id;
    var dttm=$('#demo_datetime');
    if(dttm.val()==dvcls[dvcid]){
        //说明没有改变，灰掉
        $('#sttm').addClass('disabled');
    }else{
        $('#sttm').removeClass('disabled');
    }
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
               
           $('#dvcnm').html(data['dvco']['address']);
            
            console.log("success");
        },
        'error':function() {
                console.log("error");
        }
    });
    $('#modal').trigger('click');
}
//只要mbiscroll他消逝，无论都是要给optm一个时间that时间的来源自然是来自demo_datetime that 真时间,然后要弹出来的
function modalRecureWhenClapse(){
    $('#optm').val($('#demo_datetime').val());
    $('#tm_'+dvcid).parent().trigger('click');
}

$(function(){

    $('#optm').click(function(){
        //触发取消
        $('#cancel').trigger('click');
        //触发隐藏的mobiscroll
        $('#demo_datetime').trigger('click');
        
    })
    
   
    

    
    $('#cnclstttm').click(function(){
        $('#stttm').val('');
    })

    $('#cnclendtm').click(function(){
        $('#endtm').val('');
    })

    $('#sttm').click(function(){

        doonff('on',$('#optm').val(),'');
       
    })

    $('#cncloptm').click(function(){
        $('#optm').val('');
    })
    
})

function doonff(oprt,tm,everyday){
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
                'everyday':everyday,
            },
            'dataType': 'json',
            'success': function(data) {
                    
                //带着时间过来的，肯定是sttm派来的;不带时间过来的，肯定是直接整的开关
                if(tm){
                    $('#cls').trigger('click');
                    if(data['rslt']=='ok'){
                        //完成设定成功的话要给数组库添加值，以后只要和新成立的结论不正确的
                        dvcls[dvcid]=tm;
                        $('#btn_'+dvcid).attr('class','btn btn-default');
                        $('#tm_'+dvcid).html('已设定');
                    }else{
                        $('#btn_'+dvcid).attr('class','btn btn-success');
                        $('#tm_'+dvcid).html('未设定');
                    }
                    alert(data['msg']);
                    check(dvcid);
                }else{

                    if(data.rslt=='error'){
                        //错误就不用改变原来dvcsttsls中的状态
                        alert(data.msg+' 操作失败！');
                        check(dvcid);
                        
                            
                    }else{//成功的alert只为测试用的
                        //开启loading,知道失败和成功才结束
                        $('#modal_loading').trigger('click');
                        //每半秒钟访问一次桩，访问20次，持续10秒，直到检测操作执行掉了
                        var i=0;
                        var int=self.setInterval(
                                function(){
                                    if(i==5){
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

function check(dvcid){
    
    //无论正确与否都要再次验证一遍
    //就是如果checked  就应该是 on 如果没对上就 要fctswc0模式自动按一下，而不是以前那样和之前相反，对了一层校验，增加鲁棒性//前提条件是checked和开关是严格对应的
    //反正最后成功与否改的都是数组库，至于开关的状态完全是根据和数组库是否对应，对的上就酸了，不堵上就给我按一下，变成对上，最终的结果是，数据组可以和开关永远对的上
    var obj=$('#dvc_'+dvcid);//目前操纵的devc
    var ckd=obj.attr('checked');
    if((ckd=='checked'&&dvcsttsls[dvcid]=='off')||(ckd!='checked'&&dvcsttsls[dvcid]=='on')){
        fctswc=0;//暂时不启用功能
        $('#dvc_'+dvcid).trigger('click');
        fctswc=1;//开启功能模式，下次点击再次有功能意义
    }
}

