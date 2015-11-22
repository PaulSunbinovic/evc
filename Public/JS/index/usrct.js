var admit_double_swc=1;
//########################开关相关
//开关总协调
function swc(obj){
    $obj=$(obj);
    var id=$obj.attr('id');
    var mark=id.split('_')[0];
    if(mark=='dvc'){
        //负责控制开关
        onoff(obj);
    }else if(mark=='capacity'){
        //负责控制功率
        changecapacity(obj);
    }else if(mark=='timer'){
        //负责控制半价电定时
        changetimer(obj);
    }else if(mark='share'){
        //负责控制共享
        changeshare(obj);
    }
}
//#########################
function onoff(obj){
    var $obj=$(obj);
    //现在获得的就是车主想达到的状态
    var id=$obj.attr('id');
    var dvcid=id.split('_')[1];
    var wantoprt='';
    var online='';var onodr='';//因为生成的data被二次利用，所以避免冲突，提取出来算了
    if($obj.attr('checked')=='checked'){
        wantoprt='on';
    }else{
        wantoprt='off';
    }
    $.ajax({
        'type': 'GET',
        'url': doonoff,
        'async':false,  
        'contentType': 'application/json',
        'data': {
            'dvcid':dvcid,
            'oprt':wantoprt,
        },
        'dataType': 'json',
        'success': function(data) {
            online=data['online'];
            onodr=data['onodr'];
            if(data.rslt=='error'){
                //错误就不用改变原来dvcsttsls中的状态
                check_dvc(data['stts'],dvcid,online,onodr);
                if(data['msg']){alert(data['msg']);}//有具体的错误才弹出来
            }else{//成功的alert只为测试用的
                //开启loading,知道失败和成功才结束
                $('#modal_loading').trigger('click');
                //每2秒钟访问一次桩，访问5次，持续10秒，直到检测操作执行掉了
                var i=0;
                var int=self.setInterval(
                        function(){
                            var stts='';//设定菊部变量，这样，data出来的值可以有地方寄存，万一到了5后，可以把当前的检测出来的状态写出来
                            if(i==5){
                                check_dvc(stts,dvcid,online,onodr);
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
                                    stts=data['stts'];//把当前状态登记下，万一到了5次了，可以告诉失败的接口
                                    if(data['stts']==wantoprt){
                                        check_dvc(wantoprt,dvcid,online,onodr);
                                        //#########由于成功操作开关的变化会导致capacity的变化，失败了无非就是照旧不去管############
                                        //########首先获取当前capacity的值
                                        if($('#capacity_'+dvcid).attr('checked')=='checked'){
                                            capacity=2;
                                        }else{
                                            capacity=1;
                                        }
                                        check_capacity(capacity,dvcid,online,onodr,stts);
                                        //之前一旦off是拟消失的，这里是成功，那么拟消失变成真消失（PS，去开的时候肯定是不会置1，去关的时候可能会拟置1，理论上不会有问题的把）
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
                    ,2000);
                
            }
                
            
                
                
                
            console.log("success");
        },
        'error':function() {
            console.log("error");
        }
    });
    
}
//#########################
function changecapacity(obj){
    var $obj=$(obj);
    //现在获得的就是车主想达到的状态
    var id=$obj.attr('id');
    var dvcid=id.split('_')[1];
    var wantcapacity='';
    var online='';var onodr='';var stts='';//因为生成的data被二次利用，所以避免冲突，提取出来算了
    if($obj.attr('checked')=='checked'){
        wantcapacity=2;
    }else{
        wantcapacity=1;
    }
    $.ajax({
        'type': 'GET',
        'url': dochangecapacity,
        'async':false,  
        'contentType': 'application/json',
        'data': {
            'dvcid':dvcid,
            'capacity':wantcapacity,
        },
        'dataType': 'json',
        'success': function(data) {
            online=data['online'];
            onodr=data['onodr'];
            stts=data['stts'];
            //不论成功失败都会有应该的值在的，所以直接退
            check_capacity(data['capacity'],dvcid,online,onodr,stts);
            if(data.rslt=='error'){
                //错误就不用改变原来dvcsttsls中的状态
                alert(data['msg']);
            }    
            console.log("success");
        },
        'error':function() {
            console.log("error");
        }
    });
    
}
//#########################
function changetimer(obj){
    var $obj=$(obj);
    //现在获得的就是车主想达到的状态
    var id=$obj.attr('id');
    var dvcid=id.split('_')[1];
    var wanttimer='';
    var online='';//因为生成的data被二次利用，所以避免冲突，提取出来算了
    if($obj.attr('checked')=='checked'){
        wanttimer='y';
    }else{
        wanttimer='n';
    }
    $.ajax({
        'type': 'GET',
        'url': dochangetimer,
        'async':false,  
        'contentType': 'application/json',
        'data': {
            'dvcid':dvcid,
            'timer':wanttimer,
        },
        'dataType': 'json',
        'success': function(data) {
            online=data['online'];
            //不论成功失败都会有应该的值在的，所以直接退
            check_timer(data['timer'],dvcid,online);
            if(data.rslt=='error'){
                //错误就不用改变原来dvcsttsls中的状态
                alert(data['msg']);
            }    
            console.log("success");
        },
        'error':function() {
            console.log("error");
        }
    });
    
}
//#########################
function changeshare(obj){
    var $obj=$(obj);
    //现在获得的就是车主想达到的状态
    var id=$obj.attr('id');
    var dvcid=id.split('_')[1];
    var wantshare='';
    var online='';var onodr='';//因为生成的data被二次利用，所以避免冲突，提取出来算了
    if($obj.attr('checked')=='checked'){
        wantshare='y';
    }else{
        wantshare='n';
    }
    $.ajax({
        'type': 'GET',
        'url': dochangeshare,
        'async':false,  
        'contentType': 'application/json',
        'data': {
            'dvcid':dvcid,
            'share':wantshare,
        },
        'dataType': 'json',
        'success': function(data) {
            online=data['online'];
            onodr=data['onodr'];
            //不论成功失败都会有应该的值在的，所以直接退
            check_share(data['share'],dvcid,online,onodr);
            if(data.rslt=='error'){
                //错误就不用改变原来dvcsttsls中的状态
                alert(data['msg']);
            }    
            console.log("success");
        },
        'error':function() {
            console.log("error");
        }
    });
    
}
//#########################
function check_dvc(stts,dvcid,online,onodr){
    //第一次check的时候还没有 开关化，此时这些理论是OK的，但是一旦开关话了，obj周围多了很多东西。。。。
    //不去除disable属性的话会影响后面的操作，后面永远都是灰掉的
    var $obj=$('#dvc_'+dvcid);$obj.removeAttr("disabled"); 

    var checkvalue=$obj.attr('checked');
    var $lbl=$('#lbl_swc_'+dvcid);
    var str='';
    var click='n';
    var dsb='n';
    if(online=='n'){
        dsb=='y';
        $lbl.html('设备不在线');
    }else{
        
        if(stts=='on'&&checkvalue!='checked'){
            click='y';
            str='ON';
        }else if(stts=='on'&&checkvalue=='checked'){
            str='ON';
        }else if(stts=='off'&&checkvalue=='checked'){
            click='y';
            str='OFF';
        }else if(stts=='off'&&checkvalue!='checked'){
            str='OFF';
        }
        //因为禁掉了就不能再滚动了，所以滚动后再禁
        if(onodr=='y'){
            dsb='y';
            str='已被预约，'+str;
        }
        $lbl.html(str);
        if(click=='y'){
            $obj.trigger('click');
        }
    } 
     //################
    if(dsb=='y'){
        $obj.attr('disabled',true);
    }
    changeswcshell($obj,dvcid,dsb);
    
    
}
//#########################
function check_capacity(capacity,dvcid,online,onodr,stts){
    //第一次check的时候还没有 开关化，此时这些理论是OK的，但是一旦开关话了，obj周围多了很多东西。。。。
    //不去除disable属性的话会影响后面的操作，后面永远都是灰掉的
    var $obj=$('#capacity_'+dvcid);$obj.removeAttr("disabled"); 

    var checkvalue=$obj.attr('checked');
    var $lbl=$('#lbl_capacity_'+dvcid);
    var str='';
    var click='n';
    var dsb='n';
    if(online=='n'){
        dsb='y';
        $lbl.html('设备不在线');
    }else{
        //##########以下都是要正确显示状态的
        
        if(capacity==2&&checkvalue!='checked'){
            click='y';
            str='3.5KW';
        }else if(capacity==2&&checkvalue=='checked'){
            str='3.5KW';
        }else if(capacity==1&&checkvalue=='checked'){
            click='y';
            str='1.5KW';
        }else if(capacity==1&&checkvalue!='checked'){
            str='1.5KW';
        }
        if(onodr=='y'){
            dsb='y';
            str='已被预约，'+str;
        }else if(stts=='on'){
            dsb='y';
            str='关闭开关后调节'+str;
        }
        $lbl.html(str);
        if(click=='y'){
            $obj.trigger('click');
        }
        
         //################
        if(dsb=='y'){
            $obj.attr('disabled',true);
        }
        changeswcshell($obj,dvcid,dsb);
        } 

    
}
//#########################
function check_timer(timer,dvcid,online){
    //第一次check的时候还没有 开关化，此时这些理论是OK的，但是一旦开关话了，obj周围多了很多东西。。。。
    //不去除disable属性的话会影响后面的操作，后面永远都是灰掉的
    var $obj=$('#timer_'+dvcid);$obj.removeAttr("disabled"); 

    var checkvalue=$obj.attr('checked');
    var $lbl=$('#lbl_timer_'+dvcid);
    var str='';
    var click='n';
    var dsb='n';
    if(online=='n'){
        dsb='y';
        $lbl.html('设备不在线');
    }else{
        if(timer=='y'&&checkvalue!='checked'){
            click='y';
            str='已开启';
        }else if(timer=='y'&&checkvalue=='checked'){
            str='已开启';
        }else if(timer=='n'&&checkvalue=='checked'){
            click='y';
            str='未启用';
        }else if(timer=='n'&&checkvalue!='checked'){
            str='未启用';
        }
        
        $lbl.html(str);
        if(click=='y'){
            $obj.trigger('click');
        }
               
    } 
     //################
    if(dsb=='y'){
        $obj.attr('disabled',true);
    }
    changeswcshell($obj,dvcid,dsb);
}
//#########################
function check_share(share,dvcid,online,onodr){
    //第一次check的时候还没有 开关化，此时这些理论是OK的，但是一旦开关话了，obj周围多了很多东西。。。。
    //不去除disable属性的话会影响后面的操作，后面永远都是灰掉的
    var $obj=$('#share_'+dvcid);$obj.removeAttr("disabled"); 

    var checkvalue=$obj.attr('checked');
    var $lbl=$('#lbl_share_'+dvcid);
    var str='';
    var click='n';
    var dsb='n';
    if(online=='n'){
        dsb='y';
        $lbl.html('设备不在线');
    }else{
       
        if(share=='y'&&checkvalue!='checked'){
            click='y';
            str='已共享';
        }else if(share=='y'&&checkvalue=='checked'){
            str='已共享';
        }else if(share=='n'&&checkvalue=='checked'){
            click='y';
            str='未设置';
        }else if(share=='n'&&checkvalue!='checked'){
            str='未设置';
        }
        if(onodr=='y'){
            dsb='y';
            str='已被预约，'+str;
        }
        $lbl.html(str);
        if(click=='y'){
            $obj.trigger('click');
        }
        
        
    } 
    //################
    if(dsb=='y'){
        $obj.attr('disabled',true);
    }
    changeswcshell($obj,dvcid,dsb);
}
//###################################
function changeswcshell($obj,dvcid,dsb){
    //################
    if(dsb=='y'){
        shellclass='bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-on bootstrap-switch-small bootstrap-switch-disabled bootstrap-switch-id-capacity_'+dvcid+' bootstrap-switch-animate';
    }else{
        shellclass='bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-on bootstrap-switch-small  bootstrap-switch-id-capacity_'+dvcid+' bootstrap-switch-animate'
    }
    if(swcinited==1){
        $obj.parent().parent().attr('class',shellclass);
    }
}
