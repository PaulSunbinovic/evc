<?php
class SSModel extends Action{
	public function setss(){
		$usr=D('Usr');$car=D('Car');
		
		$openid=session('openid');
		
		
		$arr_usr=$usr->get($openid);
		
		
		
		
		$crls=$arr_usr['data']['carList'];
		$crlsnw=array();
		foreach ($crls as $crv) {
			$carmdlid=$crv['carModelId'];
			$arr=$car->carModel($carmdlid);
			$crv['brdmdl']=$arr['data'];
			array_push($crlsnw,$crv);
		}
		$arr_usr['data']['carList']=$crlsnw;

		//################隐私设置电话号码转化成133****3333
		$mobile=$arr_usr['data']['user']['mobile'];
		$mobile_3_front=substr($mobile, 0,3);
		$mobile_4_tail=substr($mobile,7,4);
		$arr_usr['data']['user']['mobile']=$mobile_3_front.'****'.$mobile_4_tail;

		$this->assign('usrdto',$arr_usr['data']);


		$this->assign('crls',$arr_usr['data']['carList']);

		

		return $arr_usr['data'];
	}

	
}
?>