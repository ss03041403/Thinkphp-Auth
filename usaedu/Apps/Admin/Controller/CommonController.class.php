<?php
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller{
	protected function _initialize(){
		if(!isset($_SESSION[C('USER_AUTH_KEY')])){ //判断是否有uid
            $this->redirect("Admin/Public/login");
        }
        $Auth = new \Think\Auth();
        //$module_name=CONTROLLER_NAME.'/'.ACTION_NAME;
        $module_name=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
        /*if($_SESSION['username']==C('ADMIN_AUTH_KEY')){    //以用户名来判断是否是超级管理员，绕过验证，不用用户组来判断的原因是用户组有时候是中文    ，而且常删除或更改。
                return true;
        }
        if(!$Auth->check($module_name,$_SESSION[C('USER_AUTH_KEY')])){
          $this->error('没有权限');
        }*/

        if(!authcheck($module_name,$_SESSION[C('USER_AUTH_KEY')])){
			$this->error('没有权限！');
		}
	}
}