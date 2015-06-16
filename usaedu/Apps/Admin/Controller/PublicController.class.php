<?php
namespace Admin\Controller;
use Think\Controller;

class PublicController extends Controller{
	public function index(){
		$this->display('login');
	}
	public function login(){
		if(IS_POST){
			print_r($_POST);
		}else{
			$this->display();
		}
	}

	//登出
    public function logout(){
        if($_SESSION[C('USER_AUTH_KEY')]) {
            session_destroy();
            $this->redirect("Public/login");
        }else {
            $this->error('已经登出！');
        }
    }

    //验证登陆表单
    public function checkLogin(){
        $username=I('username','');
        $password=I('password','');
        $verify_code=I('verify','');
        if($username==''||$password==''||$verify_code==''){
            //$this->redirect("Public/login");
            $this->error('各项不能为空');
        }
        if(!$this->_verifyCheck($verify_code)){
            $this->error("验证码错误！！！");
        }
        $user=M('user')->where(array('username'=>$username))->find();
        if(!$user||md5($password)!=$user['password']){
            $this->error("用户名或密码错误！！！");
        }
        if(!$user['lock']){   //status为0时表示锁定
            $this->error("用户被锁定！！！");
        }else{
            $data['login_ip'] =  get_client_ip();
            $data['login_time']=time();
            if(M("user")->where(array('id'=>$user['id']))->save($data)){
                M("user")->where(array('id'=>$user['id']))->setInc("login_num");
            }
			session(C('USER_AUTH_KEY'),$user['id']);
			session('username',$user['username']);
			$this->success("登录成功...",U("Admin/Index/index"));
		}
	}

	//验证码
	public function verify(){
        $config=array(
            'fontSize'=> 30,
            'codeSet' =>'1234567890',
            //$Verify->useImgBg=true;
            'imageW'=>200,
            'imageH'=>60,
            'length'  => 4,
            'useNoise' => true,
            'reset' => false,
            );
		$Verify =new \Think\Verify($config);
        $Verify->entry();
	}
	//验证验证码
	private function _verifyCheck($code, $id = ''){
		$verify = new \Think\Verify();
		return $verify->check($code, $id);
	}
}