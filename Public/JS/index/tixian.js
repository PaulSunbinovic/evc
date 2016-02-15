$(function(){
	$('#tixian').click(function(){
		var bankcardno=$('#bankcardno');
		var uname=$('#uname');
		var bankname=$('#bankname');
		var withdrawvalue=$('#withdrawvalue');

		if($.trim(bankcardno.val())==''){alert('银行卡号不能为空');bankcardno.focus();return;}
		if(isNaN(bankcardno.val())==true){alert('银行卡号必须是数字');bankcardno.focus();return;}
		if($.trim(uname.val())==''){alert('姓名不能为空');uname.focus();return;}
		if($.trim(bankname.val())==''){alert('开户行名称不能为空');bankname.focus();return;}
		if($.trim(withdrawvalue.val())==''){alert('提现金额不能为空');withdrawvalue.focus();return;}
		if(isNaN(withdrawvalue.val())==true){alert('提现金额必须是数字');withdrawvalue.focus();return;}
        if(withdrawvalue.val()<100){alert('少于100元不可以提现');withdrawvalue.focus();return;}

		$.ajax({
            'type': 'GET',
            'url': dotixian,
            'async':false,  
            'contentType': 'application/json',
            'data': $('#gather').parent().serialize(),
            'dataType': 'json',
            'success': function(data) {
                if(data['rslt']==1){window.location.href=__url__+'/tixiansuccess';}else{alert(data['msg']);}
                console.log("success");
            },
            'error':function() {
                console.log("error");
            }
        });
	})

    $('#help').click(function(){
        $('#assist').trigger('click');
    })
})