$(document).ready(function(){  
	$('#loading').hide();
	
	var dvpd="<div id='pdldmr' style='text-align:center;'>上滑加载更多...</div>";
	
    var range = 250;             //距下边界长度/单位px  
    var elemt = 500;           //插入元素高度/单位px  
    //var maxnum = 20;            //设置加载最多次数  
    //var num = 1;  
    var totalheight = 0;   
    var main = $("#mainarea");                     //主体元素  
    
    
	main.append(dvpd);
	
    
    $(window).scroll(function(){
        var srollPos = $(window).scrollTop();    //滚动条距顶部距离(页面超出窗口的高度)  
          
        // console.log("滚动条到顶部的垂直高度: "+$(document).scrollTop());  
        // console.log("页面的文档高度 ："+$(document).height());  
        // console.log('浏览器的高度：'+$(window).height());  
          
        totalheight = parseFloat($(window).height()) + parseFloat(srollPos); 
        
        ///alert(($(document).height()-range)+' , '+totalheight+' , '+$('#hsnxt').val()+' , '+$('#pg').val());
        if(($(document).height()-range) <= totalheight&&exe==1) {

        	//由于手抖或者神马客观原因，导致，鼠标下拉的时候连续的触动此函数，所以，需要用一个参数让其第一次执行
        	//的过程中不执行其他由于手抖造成的误操作
            exe=0;//进入计算后不得再执行，直到这次搞定
        	$('#pdldmr').remove();
        	
        	
        	
        	$('#loading').show();
        	setTimeout(function () {

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
                                var str="<tr><td>"+srlnb+"</td><td>"+data['odrls'][i]['cro']['carNo']+"</td><td>"+data['odrls'][i]['dvcnm']+"</td><td>"+data['odrls'][i]['crttmprx']+"<br>"+data['odrls'][i]['crttmtl']+"</td><td>";
                                if(data['odrls'][i]['stat']=='1'){
                                    str=str+"<done style='color:#ccc'><i class='glyphicon glyphicon-time'></i> &nbsp;&nbsp;&nbsp;&nbsp;</done>";
                                }else{
                                    str=str+"<doing style='color:#3CB371'><i class='glyphicon glyphicon-time'></i> &nbsp;&nbsp;&nbsp;&nbsp;</doing>";
                                }
                                str=str+"</td></tr>";
                                $('tbody').append(str);
                            }
                            nwpg=data['nwpg'];
                            
                            
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