$(document).ready(function(){  
		
    var range = 250;             //距下边界长度/单位px  
    var elemt = 500;           //插入元素高度/单位px  
    //var maxnum = 20;            //设置加载最多次数  
    //var num = 1;  
    var totalheight = 0;   
    var main = $("#mainarea");                     //主体元素  
    
    
    $(window).scroll(function(){
        var srollPos = $(window).scrollTop();    //滚动条距顶部距离(页面超出窗口的高度)  
          
        // console.log("滚动条到顶部的垂直高度: "+$(document).scrollTop());  
        // console.log("页面的文档高度 ："+$(document).height());  
        // console.log('浏览器的高度：'+$(window).height());  
        //#####这里可以+点注释，他的极限触发状况是
        //------------------------
        //-----------------------|
        //                       |
        //                       |
        //                       |scrolltop
        //                       |
        //                       |
        //----------------------X|
        //                      X|
        //                       |
        //                       |windowheight
        //-----------------------|
        //XX标明的是scrollbar这样是极限情况 此时 scrolltop+windowheight正好等于整体的documentheight
        //此时如果XX再往下的话就触发
        totalheight = parseFloat($(window).height()) + parseFloat(srollPos); 
        
        ///alert(($(document).height()-range)+' , '+totalheight+' , '+$('#hsnxt').val()+' , '+$('#pg').val());
        if(($(document).height()) <= totalheight&&exe==1) {

        	//由于手抖或者神马客观原因，导致，鼠标下拉的时候连续的触动此函数，所以，需要用一个参数让其第一次执行
        	//的过程中不执行其他由于手抖造成的误操作
            exe=0;//进入计算后不得再执行，直到这次搞定
        	
        	
        	
        	
        	$('#loading').html('加载中');
        	setTimeout(function () {

        		$.ajax({
                    'type': 'GET',
                    'url': doupld,
                    'async':false,  
                    'contentType': 'application/json',
                    'data': {
                        'nwpg':nwpg,
                        'gdid':gdid,
                        'type':type,
                    },
                    'dataType': 'json',
                    'success': function(data) {
                        if(data['rslt']==0){
                            //alert('无更新内容');
                            $('#loading').html('已无更多信息');
                        }else{
                            for(var i=0;i<data['shouyi_everymonth_ls'].length;i++){
                                var shouyi_everymonth_v=data['shouyi_everymonth_ls'][i];
                                srlnb++;
                                var str="<div class='col-md-12 col-xs-12 nopadding wrp'><div class='col-md-8 col-xs-8'>"+shouyi_everymonth_v['paramMap']['yearAndMonth']+"</div><div class='col-md-3 col-xs-3'>"+shouyi_everymonth_v['money']+"</div><div class='col-md-1 col-xs-1' onclick='window.location.href=\""+__url__+"/shouyi_monthdevice/month/"+shouyi_everymonth_v['paramMap']['yearAndMonth']+"/gdid/"+gdid+"/type/"+type+"\"'><i class='glyphicon glyphicon-menu-right'></i></div></div>";
                                $('#mainarea').append(str);
                            }
                            nwpg=data['nwpg'];
                            if(data['hasnext']==1){
                                $('#loading').html('下拉加载更多...');
                            }else{
                                $('#loading').html('已无更多信息');
                            }
                            
                            
                        }
                        exe=1;
                        console.log("success");           
                    },
                    'error':function() {
                        console.log("error");
                    }
                });

            }, 1000);
         
        }  
    });  
});  