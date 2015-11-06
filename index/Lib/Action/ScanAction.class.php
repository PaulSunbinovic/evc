<?php
// 本类由系统自动生成，仅供测试用途

//include_once("./CCPRestSmsSDK.php");
//$ccp=D('CCP');


class ScanAction extends Action {
    public function scan(){
        import('@.WX.JssdkAction');
        $jssdk = new JssdkAction(C('appid'), C('appsecret'));
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('spkg',$signPackage);
        $this->display('scan');
       
        
    }

    

    

}

