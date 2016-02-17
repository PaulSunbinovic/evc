<?php
class PaymentModel{
	//#########################
	//http://localhost:8080/pay/findUserPaymentOrder.action?wechatId=ojxMBuPfL9ru7RCI1o2iSjw_8Ix0&pageSize=10&pageNum=1
	//#########MODEL########################
	public function test($id){
		$url='';
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function findUserPaymentOrder($openid,$pagesize,$pagenum){
		/*
		serialType--》    RECHARGE(1, "充值"), CHARGE(2, "充电，消费"), CHARGED(3, "充电，收益"), OVERTIME(4,
				"超时取消预约，消费"), OVERTIMED(5, "超时取消预约，收益");
				status 1 RMB 2 R+U 3 U 6 不管
		 */
		$url=C('javaback').'/pay/findUserPaymentOrder.action?wechatId='.$openid.'&pageSize='.$pagesize.'&pageNum='.$pagenum;
		$json='{"data":{"pageNo":0,"currentPage":2,"pageSize":10,"totalCount":16,"pageCount":0,"results":[{"id":39,"transactionId":"1000520956201509230963189956","outTradeNo":"123297230220150923075216","bankType":null,"userId":6,"status":6,"macId":null,"money":2,"payTime":"2015-09-23 07:52:24","createTime":"2015-09-23 07:52:15","updateTime":"2015-09-23 07:52:28","version":1,"serialType":1,"preId":0,"paramMap":null},{"id":33,"transactionId":"1000520956201509210951780754","outTradeNo":"123297230220150921225432","bankType":null,"userId":6,"status":6,"macId":null,"money":1,"payTime":"2015-09-21 22:54:45","createTime":"2015-09-21 22:54:31","updateTime":"2015-09-21 22:54:49","version":1,"serialType":1,"preId":0,"paramMap":null},{"id":32,"transactionId":"1000520956201509210951733002","outTradeNo":"123297230220150921224600","bankType":null,"userId":6,"status":6,"macId":null,"money":1,"payTime":"2015-09-21 22:46:08","createTime":"2015-09-21 22:45:59","updateTime":"2015-09-21 22:52:13","version":1,"serialType":1,"preId":0,"paramMap":null},{"id":30,"transactionId":"1000520956201509210951664457","outTradeNo":"123297230220150921223836","bankType":null,"userId":6,"status":6,"macId":null,"money":1,"payTime":"2015-09-21 22:38:43","createTime":"2015-09-21 22:38:35","updateTime":"2015-09-21 22:39:06","version":1,"serialType":1,"preId":0,"paramMap":null},{"id":28,"transactionId":"1000520956201509210951591576","outTradeNo":"123297230220150921223047","bankType":null,"userId":6,"status":6,"macId":null,"money":1,"payTime":"2015-09-21 22:31:01","createTime":"2015-09-21 22:30:46","updateTime":"2015-09-21 22:31:55","version":1,"serialType":1,"preId":0,"paramMap":null},{"id":12,"transactionId":"1000520956201509210949791509","outTradeNo":"123297230220150921193913","bankType":null,"userId":6,"status":6,"macId":null,"money":1,"payTime":"2015-09-21 19:39:23","createTime":"2015-09-21 19:39:14","updateTime":"2015-09-21 19:40:00","version":1,"serialType":1,"preId":0,"paramMap":null}]},"code":"A00000","msg":"获取成功"}';
		$arr=url2arr($url,$json);

		//##########从现在这个函数开始 都要进行进阶的判断
		$paymentls=$arr['data'];

		$paymentlsnw=array();
		//###提取serialType和status
		foreach($paymentls as $paymentv){
			$serialType=$paymentv['serialType'];
			$color_red='#dfaa55';$color_green='#00af50';
			$str_demonstrate='';
			if($paymentv['stauts']===2){$str_demonstrate='（部分优惠券抵扣）';}
			if($paymentv['stauts']===3){$str_demonstrate='（优惠券抵扣）';}
			switch ($serialType) {
				case 1:
					$paymentdesc='充值';
					$paymentmark='+';
					$paymentcolor=$color_green;
					break;

				case 2:
					$paymentdesc='充电消费'.$str_demonstrate;
					$paymentmark='-';
					$paymentcolor=$color_red;
					break;

				case 3:
					$paymentdesc='充电收益';
					$paymentmark='+';
					$paymentcolor=$color_green;
					break;

				case 4:
					$paymentdesc='超时取消预约消费'.$str_demonstrate;
					$paymentmark='-';
					$paymentcolor=$color_red;
					break;

				case 5:
					$paymentdesc='超时取消预约收益';
					$paymentmark='+';
					$paymentcolor=$color_green;
					break;


				case 7:
					$paymentdesc='公桩分成';
					$paymentmark='+';
					$paymentcolor=$color_green;
					break;

				case 8:
					$paymentdesc='提现';
					$paymentmark='-';
					$paymentcolor=$color_red;
					break;
				
			}
			//#####处理时间
			$tm=$paymentv['createTime'];
			$tm=strtotime($tm);
			$tm=date('Y-m-d',$tm);
			//######处理金钱
			$mny=round(floatval($paymentv['money'])/100,2);
			$mny=(string)$mny;
			$pos=strpos($mny, '.');
			if($pos==false){
				$mny=$mny.'.00';
			}
			

			//#############分配参数
			$paymentv['desc']=$paymentdesc;$paymentv['mark']=$paymentmark;$paymentv['color']=$paymentcolor;
			$paymentv['tm']=$tm;$paymentv['mny']=$mny;
			//###
			array_push($paymentlsnw,$paymentv);
		}
		$arr['data']=$paymentlsnw;

		return $arr;
	}	
} 
?>