<?php
class CouponModel{
	//http://120.26.80.165/coupon/listCoupon.action?wechatId=ojxMBuDIg7OQ1XaNoysHHQr2K9A8

	//#########MODEL########################
	public function test($id){
		$url='';
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//#########MODEL########################
	public function listCoupon($openid){
		$url=C('javaback').'/coupon/listCoupon.action?wechatId='.$openid;
		$json='{"data":[{"id":24,"useStatus":1,"userId":33,"cValue":1500,"cLimit":0,"cDescribe":"优惠券","createTime":"2015-11-16 22:24:30","updateTime":"2015-11-16 22:24:30","expireTime":"2016-01-15 00:00:00"},{"id":25,"useStatus":1,"userId":33,"cValue":1500,"cLimit":0,"cDescribe":"优惠券","createTime":"2015-11-16 22:24:30","updateTime":"2015-11-16 22:24:30","expireTime":"2016-01-15 00:00:00"},{"id":23,"useStatus":1,"userId":33,"cValue":3000,"cLimit":0,"cDescribe":"优惠券","createTime":"2015-11-16 22:24:30","updateTime":"2015-11-16 22:24:30","expireTime":"2015-12-01 00:00:00"}],"code":"A00000","msg":""}';
		$arr=url2arr($url,$json);
		return $arr;
	}

}
	
?>