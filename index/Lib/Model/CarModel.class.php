<?php
class CarModel{
	//##################interface###########
	//http://120.26.80.165/carModel/get.action?carModelId=1
	//
	//######MODEL###########
	public function test($id){
		$url='';
		$json='';
		$arr=url2arr($url,$json);
		return $arr;
	}
	//################
	public function carModel($carmdlid){
		$url=C('javaback').'/carModel/get.action?carModelId='.$carmdlid;;
		$json='{"data":{"id":2,"name":"","brand":"BYD","model":"唐"},"code":"A00000","msg":null}';
		$arr=url2arr($url,$json);
		return $arr;
	}
}
?>