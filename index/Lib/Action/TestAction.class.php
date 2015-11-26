<?php
// 本类由系统自动生成，仅供测试用途


class TestAction extends Action {

	public function test(){
		$usr=D('Usr');
		$dvc=D('Dvc');
		$car=D('Car');

		$arr=$dvc->getAll('111','222');
		p($arr);
	}
	
    public function setpara(){
    	$personls=array();

    	//#####################
		$person=array(
				'id'=>'1',
				'wechat_id'=>'12345',
				'nick_name'=>'王峰',
				'head_img_url'=>'baidu.com',
				'mobile'=>'13162951502',

			);        
       	array_push($personls,$person);
       	//#####################
		$person=array(
				'id'=>'6',
				'wechat_id'=>'ojxMBuJe07gSZDUwp0ZHGHEMHOR8',
				'nick_name'=>'Paul',
				'head_img_url'=>'http://wx.qlogo.cn/mmopen/dibCvqHg4Wndtpupkeiau92hDv4vSHLynLBJvmuHicZiavGhFSmjzmp7DkjAxbGtkjHzYhPpQECU3xPicWGE2xlxribhQhatsao3HJ/0',
				'mobile'=>'13333333333',

			);        
       	array_push($personls,$person);
       	//#####################
		$person=array(
				'id'=>'7',
				'wechat_id'=>'ojxMBuGNHHn0L6AekqIc2lpiUMYw',
				'nick_name'=>'张仔锅',
				'head_img_url'=>'http://wx.qlogo.cn/mmopen/5nEus98y7iaHzD7AWr9Ab66W2AImchje7luUgooQ0N5PfLyBicPia3JwuVSqsJEOz1cKUZDkIIztjKz8hPy4kUtf8QU5TO8zltZ/0',
				'mobile'=>'19830617210',

			);        
       	array_push($personls,$person);
       	//#####################
		$person=array(
				'id'=>'9',
				'wechat_id'=>'ojxMBuI-HahoIOMNZCfxQ3xLzncU',
				'nick_name'=>'王商',
				'head_img_url'=>'http://wx.qlogo.cn/mmopen/Q0ib8NGLdFvELdCeRmO54j5YxjRriaAvp6TmS1ERCuODIvmeoolRJNeJ30U9aMzHaybicxF95ksAFIXeXWkR8TLobibcfJIsFuU6/0',
				'mobile'=>'13817086259',

			);        
       	array_push($personls,$person);
       	//#####################
		$person=array(
				'id'=>'10',
				'wechat_id'=>'ojxMBuNnkhLCHetxo_hy-D-GEyTY',
				'nick_name'=>'刘建',
				'head_img_url'=>'http://wx.qlogo.cn/mmopen/ajNVdqHZLLCJGGNZ6B7fFuBXjKQEEWbq5cq8N6qA1kRufej7eX8SKAhnyulAtzcPKZcgel0oFTuKhnpVd0icYrWSDMyjyhNh3I2DJlI8ay10/0',
				'mobile'=>'13023618720',

			);        
       	array_push($personls,$person);
       	//#####################
		$person=array(
				'id'=>'11',
				'wechat_id'=>'ojxMBuH9ttiW3keLS4KC-mKX4bCA',
				'nick_name'=>'Bob',
				'head_img_url'=>'http://wx.qlogo.cn/mmopen/77OGHpuQe1qHKulWgsVqDZYrvjGfsDr9OUT0yFibus1BBFDPAsbDApNa8EC8QbKdYZLDqmSiawAJS1rUKOS6301ib4sjsFUPma1/0',
				'mobile'=>'13818659165',

			);        
       	array_push($personls,$person);
       	//#####################
		$person=array(
				'id'=>'12',
				'wechat_id'=>'ojxMBuL7CUZGREjlV7hfGlr0OS8w',
				'nick_name'=>'刘威',
				'head_img_url'=>'http://wx.qlogo.cn/mmopen/Q3auHgzwzM6XcaIa5jtloYXagOtrCXRpiarMMcU2u2u5AEA0wV5DoWRBryzwIZ3Bd9zFAqvG8FIuzlh7Gk2qMUg/0',
				'mobile'=>'15821568650',

			);        
       	array_push($personls,$person);
       	//#####################
		$person=array(
				'id'=>'14',
				'wechat_id'=>'ojxMBuIXRwrB1cKzFfuxCEHqboVU',
				'nick_name'=>'朱明慧',
				'head_img_url'=>'http://wx.qlogo.cn/mmopen/77OGHpuQe1qHKulWgsVqDVwic7P0boeMCiaicDib0nde9maQsiarRtPxPx2lDdg9UticmzKWhib8y5xmpVicJ12hvc0WQxnmZiaiccFCic7/0',
				'mobile'=>'18658130532',

			);        
       	array_push($personls,$person);
       	//#####################
		$person=array(
				'id'=>'27',
				'wechat_id'=>'ojxMBuCVyjkRAucWjPyA3xeDKsa0',
				'nick_name'=>'李晓辰',
				'head_img_url'=>'http://wx.qlogo.cn/mmopen/77OGHpuQe1q8ooVMqQlhncNFtwAcJUGibicf4MjQcib4wgbQ2IRN8iasfGm30ljytxY622bxBzVTs5KL0CpbPEVhBA/0',
				'mobile'=>'15858274917',

			);        
       	array_push($personls,$person);
       	//#####################
		$person=array(
				'id'=>'28',
				'wechat_id'=>'ojxMBuPfL9ru7RCI1o2iSjw_8Ix0',
				'nick_name'=>'田广楠',
				'head_img_url'=>'http://wx.qlogo.cn/mmopen/kB7Cm8EnuqgZxOLUHWOPiaeBoLbiagyKZa6DUjWGdyXuTW3lx2XQ8cCIlkXurbBrw0iapoUVDgAVNXp2eq9yiaEcibpxJbuJYIGhe/0',
				'mobile'=>'15888836739',

			);        
       	array_push($personls,$person);
       	//#####################
		$person=array(
				'id'=>'42',
				'wechat_id'=>'ojxMBuCKTTV6pVP9oVET8HE9jhEc',
				'nick_name'=>'臧艺',
				'head_img_url'=>'http://wx.qlogo.cn/mmopen/Q0ib8NGLdFvELdCeRmO54jibicpjSgGrDPsCpYNVoyAqmyaEY6ia07YbsmoNFxBDD9BTT8TK5ibSibF5sgO3jSFP4P2uG1G1QMEwMl/0',
				'mobile'=>'18069801327',

			);        
       	array_push($personls,$person);
       	//#####################
		$person=array(
				'id'=>'38',
				'wechat_id'=>'ojxMBuO8dbQ0vfCQqCx0_r87G33A',
				'nick_name'=>'糖小白',
				'head_img_url'=>'http://wx.qlogo.cn/mmopen/ajNVdqHZLLDtCaGyUYM1zHfNyhjIC1CvyqXh0dFQOFL8ZkGx4Tnnic1cPpuicQYkXYoWWc9eEJlolZq7e8eojia3w/0',
				'mobile'=>'13817116106',

			);        
       	array_push($personls,$person);

        $this->assign('personls',$personls);
        $this->display('setpara');
    }

    public function dosetss(){
    	$openid=$_GET['openid'];
    	session('openid',$openid);
    	session('analog',1);
    	$this->ajaxReturn();
    }

    public function cancelset(){
    	session('openid',null);
    	session('analog',null);
    	$this->ajaxReturn();
    }
}

