<?php
class GroupModel{
	//###################interface##############
	//http://120.26.80.165/proxyGroup/selectGroup.action
	

	//#########MODEL########################
	public function test($id){
		$url='';
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//http://120.26.80.165/proxyGroup/selectGroup.action
	

	//#########MODEL########################
	public function selectGroup($id,$groupName,$address){
		$cdt='';
		if($cdt&&$id){$cdt=$cdt.'&id='.$id;}else if(!$cdt&&$id){$cdt='id='.$id;}
		if($cdt&&$groupName){$cdt=$cdt.'&groupName='.$groupName;}else if(!$cdt&&$groupName){$cdt='groupName='.$groupName;}
		if($cdt&&$address){$cdt=$cdt.'&address='.$address;}else if(!$cdt&&$address){$cdt='address='.$address;}
		$url=C('javaback').'/proxyGroup/selectGroup.action'.$cdt;
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
}
?>