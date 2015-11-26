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
            'iscarmst':'y',
        },
        'dataType': 'json',
        'success': function(data) {
            online=data['online'];
            onodr=data['onodr'];
            if(data.rslt=='error'){
                //错误就不用改变原来dvcsttsls中的状态
                check_dvc(data['stts'],dvcid,online,onodr);
                if(data['msg']){alert(data['msg']);}//有具体的东西才弹出来
                
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
                                        //之前一旦off是拟消失的，这里是成功，那么拟消失变成真消失（PS，去开的时候肯定是不会置1，去关的时候可能会拟置1，理论上不会有问题的把）
                                        $('#cancel_loading').trigger('click');
                                        //如果是关的话就要提示本次订单结束

                                        int=window.clearInterval(int);
                                        if(stts=='off'){
                                            
                                            if(admit_double_swc==1){
                                                alert('本次订单结束');
                                                admit_double_swc=0;
                                                
                                                //貌似结算没有那么快，不能直接刷新获取，必须要在页面端进行假OK
                                                $('.hasodr').hide();
                                                $('#noodr').show();
                                                setTimeout('window.location.reload()',5000);
                                            }
                                           
                                        }
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
function check_dvc(stts,dvcid,online,onodr,enable){
    //第一次check的时候还没有 开关化，此时这些理论是OK的，但是一旦开关话了，obj周围多了很多东西。。。。
    //不去除disable属性的话会影响后面的操作，后面永远都是灰掉的
    var $obj=$('#dvc_'+dvcid);$obj.removeAttr("disabled"); 

    var checkvalue=$obj.attr('checked');
    var $lbl=$('#lbl_swc_'+dvcid);
    var str='';
    var click='n';
    
    if(online=='n'){
        $obj.attr('disabled',true);
        $lbl.html('设备不在线');
    }else{
        var dsb='n';
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
        }else if(enable=='n'){
            //说明9点没到还没开放
            dsb='y';
            str='请在9点以后开启,'+str;
        }
        $lbl.html(str);
        if(click=='y'){
            $obj.trigger('click');
        }
        if(dsb=='y'){
            $obj.attr('disabled',true);
        }
        
        
        
    } 

    
}

//############来源于hstr_odr.js
////###########################取消预约
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