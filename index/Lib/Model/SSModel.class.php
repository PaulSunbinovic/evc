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
		
		$this->assign('usrdto',$arr_usr['data']);
		$this->assign('crls',$arr_usr['data']['carList']);

		

		return $arr_usr['data'];
	}

	
}
?>