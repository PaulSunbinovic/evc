<?php
// 本类由系统自动生成，仅供测试用途

//include_once("./CCPRestSmsSDK.php");
//$ccp=D('CCP');


class DvcAction extends Action {
    public function scan(){
        $sn=$_GET['sn'];
        
        $url=C('javaback').'/device/get.action?sn='.$sn;
        if(C('psnvs')==1){
            $json='{"data":{"id":9,"owner":2,"sn":"FFFF","model":1,"city":null,"longitude":"120.208989","latitude":"30.213697","address":"钱龙大厦","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},"code":"A00000","msg":"获取设备成功"}';
        }else{
            $json=https_request($url);
        }
        $arr=json_decode($json,true);
        $dvcid=$arr['data']['id'];

        
        if($arr['data']['owner']){
            if($arr['data']['owner']==session('openid')){
                $str='此设备已经与您绑定';
            }else{
                $str='此设备已经与别人绑定';
            }
            $this->assign('ttl','扫码结果');
            $this->assign('str',$str);
            $this->display('result');
        }else{
            if(C('psnvs')==1){
                session('openid','12345');
                
                $this->bind($dvcid);
            }else{

                header("location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=".C('appid')."&redirect_uri=http://www.evchar.cn/evc/oauth2_openid.php&response_type=code&scope=snsapi_base&state=bindWXWC".$dvcid."&connect_redirect=1#wechat_redirect");
            }
        }

       
        
    }

    public function bind($dvcid){
        //测试是传值过来的，而实际上基本都是GET到的从微信端
        import('@.SS.SSAction');
        $ss = new SSAction();
        $usrdto=$ss->setss();

        if(!$dvcid){
            $dvcid=$_GET['dvcid'];
        }
        $this->assign('dvcid',$dvcid);
        $this->assign('ttl','绑定设备');
        $this->display('bind');
    }

    public function dogetsmsvrf(){
        $usrcp=$_GET['usrcp'];
        $rdmnb=rand(1000,9999);
        $vrf=M('vrf');
        $vrfo=$vrf->where("openid='".session('openid')."'")->find();
        if($vrfo){//有则改之
            $dt=array(
                    'vrfnb'=>$rdmnb,
                );
            $vrf->where('vrfid='.$vrfo['vrfid'])->setField($dt);
        }else{//无则加冕
            $dt=array(
                    'openid'=>session('openid'),
                    'vrfnb'=>$rdmnb,
                );
            $vrf->data($dt)->add();
        }
        //发送短信有点问题，先跳过
        //$this->sendsms($usrcp,array($rdmnb,'5'),"1");//send过慢造成ajax得到error 不过没事不影响
        $data['vrfnb']=$rdmnb;
        $this->ajaxReturn($data,'json');//随便返回，其实没东西要返回的，意思一下而已
    }
        
    public function dobind(){
        $vrfnb=$_GET['vrfnb'];
        $dvcid=$_GET['dvcid'];
        $vrf=M('vrf');
        $vrfo=$vrf->where("openid='".session('openid')."'")->find();
        if($vrfo['vrfnb']==$vrfnb){
            //成功，绑定成功
            $url=C('javaback').'/device/bindOwner.action?deviceId='.$dvcid.'&wechatId='.session('openid');
            if(C('psnvs')==1){
                $json='{"data": {"id":4,"owner":3,"sn":"004","model":1,"city":null,"longitude":"121.570077","latitude":"31.219745","address":" 上海浦东嘉里大酒店 桩","peripheral":null,"ip":null,"serverIp":null,"serverPort":null,"pic":"","battery":0,"status":""},"code":"A00000","msg":" 绑定桩主成功"}';
            }else{
                $json=https_request($url);
            }
            $arr=json_decode($json,true);
            if($arr['code']='A00000'){
                //说明成功了绑定，那么我这里也登记下
                $bind=M('bind');
                $dt=array(
                        'openid'=>session('openid'),
                        'dvcid'=>$dvcid,
                    );
                $bind->data($dt)->add();
            }
            $data['vrf']=1;
            $data['arr']=$arr;
            $data['url']=__APP__.'Usr/usrct';
            $this->ajaxReturn($data,'json');
        }else{
            //失败
            $data['vrf']=0;

            $this->ajaxReturn($data,'json');
        }

    }


    public function test(){
        $this->sendsms("13567196593",'4444',"1");
    }
    public function sendsms($to,$datas,$tempId){
    
         // 初始化REST SDK
        $rest=D('REST');
       
        
         // 发送模板短信
         echo "Sending TemplateSMS to $to <br/>";
         $result = $rest->sendTemplateSMS($to,$datas,$tempId);
         if($result == NULL ) {
             echo "result error!";
             break;
         }
         if($result->statusCode!=0) {
             echo "error code :" . $result->statusCode . "<br>";
             echo "error msg :" . $result->statusMsg . "<br>";
             //TODO 添加错误处理逻辑
         }else{
             echo "Sendind TemplateSMS success!<br/>";
             // 获取返回信息
             $smsmessage = $result->TemplateSMS;
             echo "dateCreated:".$smsmessage->dateCreated."<br/>";
             echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
             //TODO 添加成功处理逻辑
         }
        
    }

    

}

