<?php
C('zidingyi','在此定义的C方法变量，全局都能用');
C('PUBLIC','/evc/Public');
C('HOST','http://www.evchar.cn/evc');
C('javaback','http://120.26.80.165');
// C('javaback','http://114.215.209.115');
C('tbid','121238');
C('svak','7fb50a356af44df3a17eb6b59f81d3cb');
C('appid','wx682ad2cc417fe8b9');
C('appsecret','c4c1b2004388a3a529f39fc42c0c60e9');
C('psnvs',0);//personal version 个人模式
C('pgsz',10);//page size
C('infodtl','http://www.evchar.cn/evc/index.php/Usr/usrct');//info detail//推送下面的detail直接进
C('mdlid','yzAn22StihL6pj4mcWFRCeZCtIhjl2j9rrGv2A3_Ybk');//通知模板id

$arr1=array(
	//'配置项'=>'配置值'
	'URL_MODEL'	=>1,//path-info 模式
	//'SHOW_PAGE_TRACE' =>true,   
	//'SHOW_RUN_TIME' =>true,   //显示运行时间
	//'SHOW_ADV_TIME' =>true,   //显示详细的运行时间
	//'SHOW_DB_TIMES'=>true,//显示数据库操作次数
	//'SHOW_CACHE_TIMES'=>true,//显示缓存操作次数
	//'SHOW_USE_MEM'=>true,//显示内存开销
);

$arr2=include './config.inc.php';

return array_merge($arr1,$arr2);
?>
