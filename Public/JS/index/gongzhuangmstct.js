$(function(){
    //如果没有传sn说明不是扫码进来开桩预约的，而是已经开桩预约好了的重新进来瞅瞅的
    if(sn==''){$('#result').html('预约成功！');return;}
    $.ajax({
        'type': 'GET',
        'url': doappointByScan,
        'async':false,  
        'contentType': 'application/json',
        'data': {
            'sn':sn,
        },
        'dataType': 'json',
        'success': function(data) {
           if(data.rslt=='0'){
                //错误就不用改变原来dvcsttsls中的状态
                $('#result').html(data['msg']);
                
            }else{//成功的alert只为测试用的
                var wantoprt='on';var online='y';var onodr='n';
                var dvcid=data['dvcid'];var odrid=data['odrid'];
                //开启loading,知道失败和成功才结束
                $('#modal_loading').trigger('click');
                //每2秒钟访问一次桩，访问5次，持续10秒，直到检测操作执行掉了
                var i=0;
                var int=self.setInterval(
                        function(){
                            var stts='';//设定菊部变量，这样，data出来的值可以有地方寄存，万一到了5后，可以把当前的检测出来的状态写出来
                            if(i==7){
                                //check_dvc(stts,dvcid,online,onodr);
                                $('#cancel_loading').trigger('click');
                                $('#result').html('操作失败！');
                                
                                $.ajax({
                                    'type': 'GET',
                                    'url': doappointCancelWithScan,
                                    'async':false,  
                                    'contentType': 'application/json',
                                    'data': {
                                        'odrid':odrid,
                             
                                    },
                                    'dataType': 'json',
                                    'success': function(data) {
                                        //假定是肯定取消成功的，因为，如果取消自动取消失败，会给用户感觉，我操，你什么时候给我在取消啊

                                       // break;
                                        console.log("success");
                                    },
                                    'error':function() {
                                        console.log("error");
                                    }
                                });
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
                                        // check_dvc(wantoprt,dvcid,online,onodr);
                                        $('#result').html('预约成功！');
                                        //之前一旦off是拟消失的，这里是成功，那么拟消失变成真消失（PS，去开的时候肯定是不会置1，去关的时候可能会拟置1，理论上不会有问题的把）
                                        $('#cancel_loading').trigger('click');
                                        //如果是关的话就要提示本次订单结束

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
})

