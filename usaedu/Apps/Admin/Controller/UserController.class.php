<?php
namespace Admin\Controller;
use Think\Controller;

class UserController extends CommonController{

	 public function index(){
        //获取用户信息
        $user=D("user")->relation(true)->field("password",true)->select();
        $this->user=$user;
        //获取用户组信息
        $group=M("auth_group")->select();
        $obj=M("auth_rule");
        foreach($group as $k=>$v){
            $map['id'] = array('in',$group[$k]['rules']);
            $group[$k]['group']=$obj->where($map)->select();
        }
        $this->group=$group;
        //获取rule规则
        $this->rule=M("auth_rule")->select();
        $this->display();
    }

	//添加后台用户
	public function addUser(){
		$this->group=$group=M("auth_group")->field("id,title")->select();
        $this->display();
	}

	//添加后台用户表单处理
    public function addUserHandle(){
        if(IS_POST){
            $data=array(
                'username'=>I('username','','trim'),
                //'remark'=>I('remark','','trim'),
                'password'=>I('password','','md5'),
                'lock'=>I('lock',0,'intval'),
                'rsgtime'=>$_SERVER['REQUEST_TIME'],
                'login_num'=>0
            );
            if(!$data['username'])
            $this->error("用户名不能为空...");
            if(!isset($_POST['role_id'])){
                $this->error("请选择用户组...");
            }
            if($data['password']!=md5($_POST['repassword'])){
                $this->error("两次密码不一致...");
            }
            if(M("user")->where(array('username'=>$data['username']))->find()){
                $this->error("用户名已存在...");
            }
            if($lastInsertId=M("user")->add($data)){
                /*foreach($_POST['role_id'] as $k=>$v){
                    $arr=array(
                        'uid'=>$lastInsertId,
                        'group_id'=>$_POST['role_id'][$k]
                    );
                    M("auth_group_access")->add($arr);
                }*/
                $arr['uid']=$lastInsertId;
                $arr['group_id']= $_POST['role_id']; 
                M("auth_group_access")->add($arr);
                $this->success("添加成功...",U("User/index"));
            }else{
                $this->error("添加失败...");
            }
        }else{
        	$this->error("添加失败...");
            /*$this->group=$group=M("auth_group")->field("id,title")->select();
            $this->display();*/
        }
        
    }

    //锁定解锁用户
    public function UserLock(){
        $user=M('User');
        $data['id']=I('id');
        $data['lock']=I('lock');
        if($user->save($data)){
            $this->success('操作成功',U(index));
        }else{
            $this->error('操作失败');
        }
    }

    //删除用户
    public function delUser(){
        if(IS_GET){
            if(!isset($_GET['id'])){
                return false;
            }
            $id=I("id",0,"intval");
            if(!$id){
                return false;
            }
            if(M("user")->where(array("id"=>$id))->delete()){
                M("auth_group_access")->where(array("uid"=>$id))->delete();
                $this->success("删除成功...",U("Auth/index"));
            }else{
                $this->error("删除失败...");
            }
        }
    }
    //修改用户
    public function updateUser(){
        if(IS_POST){
            $id=I("id",0,"intval");
            if(!$id){
                return false;
            }
            $data['username']=I("username","","trim");
            //$data['remark']=I("remark","","trim");
            $data['lock']=I("lock",0,"intval");
            $tmp=0;
            if(isset($_POST['role_id'])){
                M("auth_group_access")->where(array("uid"=>$id))->delete();
                //foreach ($_POST['role_id'] as $key => $value) {
                //if(M("auth_group_access")->add(array("uid"=>$id,"group_id"=>$_POST['role_id'][$key]))){
                if(M("auth_group_access")->add(array("uid"=>$id,"group_id"=>$_POST['role_id']))){
                    $tmp=1;
                }
                //}
            }
            if(trim($_POST['password'])){
                if(md5($_POST['password'])!=md5($_POST['repassword'])){
                    $this->error("两次密码输入不一致...");
                }else{
                    $data['password']=I("password","","md5");
                }
            }
            if(M("user")->where(array("id"=>$id))->save($data)){
                $this->success("修改成功...",U("index"));
            }else{
                if($tmp){
                    $this->success("修改成功...",U("index"));
                }else{
                    $this->error("修改失败...");
                }
            }
        }elseif(IS_GET){
            if(!isset($_GET['id'])){
                return false;
            }
            $id=I("id",0,"intval");
            if(!$id){
                return false;
            }
            $this->user=$user=M("user")->where(array('id'=>$id))->field("password",true)->select();
            $user_group=M("auth_group_access")->where(array("uid"=>$id))->select();
            $group=M("auth_group")->select();
            foreach($user_group as $key => $value){
                $user_group[$key]['group_name']=M("auth_group")->where(array("id"=>$user_group[$key]['group_id']))->getField("title");
            }
            $this->user_group=$user_group;
            $group_id=$user_group[0]['group_id'];
            $this->assign('group_id',$group_id);
            $this->group=$group;            
            $this->display();
        }
    }

/*用户组^v^处理开始-----------------------------------------------------------------------------*/

    //添加用户组
    public function addGroup(){
        $this->display();
    }

    //添加用户组处理
    public function addGroupHandle(){
    	if(IS_POST){
            $data=array(
                'title'=>I('title','','trim'),
                'status'=>I('status',0,'intval')
                );
            if(!$data['title'])
            $this->error("用户组名称不能为空...");
            if(M("auth_group")->where(array('title'=>$data['title']))->find()){
                $this->error("用户组名称已存在...");
            }
            if(M("auth_group")->add($data)){
                $this->success("添加成功...",U("Admin/User/groupList"));
            }else{
                $this->error("添加失败...");
            }
        }else{
        	$this->error("添加失败...");
        }
    }

    //用户组列表
    public function groupList(){
        //获取用户组信息

        $group=M("auth_group");
        $count= $group->count();
        $page= new \Think\Page($count,10);//
        $show= $page->show();
        $group = $group->order('id asc')->limit($page->firstRow.','.$page->listRows)->select();
        $obj=M("auth_rule");
        foreach($group as $k=>$v){
            $map['id'] = array('in',$group[$k]['rules']);
            $group[$k]['group']=$obj->where($map)->select();
        }
        $this->group=$group;
        $this->assign('page',$show);
        //print_r($group);exit();
        $this->display();
    }

    //配置用户组的权限
    public function groupAuth(){
        if(I('id')){
            //角色id
            $group['id']=$where['id']=I('id');
            //角色名称
            $group['name']=I('name');
            $m=M('auth_group');
            //获取所有规则id
            $ruleID=$m->field('rules')->where($where)->select();
            $rule=D("RuleView");
            $mid=$rule->field('mid,moduleName')->group('mid')->select();

            foreach ($mid as $v) {
                $map['mid']=array('in',$v['mid']);
                //$map['status']='1';           
                $result[$v['moduleName']]=$rule->where($map)->select();
            }
            //print_r($result);exit();
            $this->group=$group;
            $this->result=$result;
            $this->ruleID=$ruleID;
            $this->display();
        }else{
            $this->error('操作出错');
        }
    }

    //更新用户组权限
    public function groupSetHandle(){
        if(IS_POST){
            $arr=I('rule');
            //print_r($arr);exit();
            $where['id']=I("groupID");
            $data['rules']=implode(',',$arr);
            $m=M('auth_group');
            //更新,返回影响行数
            $num=$m->where($where)->save($data);
            if($num){
                $this->success('权限更新成功!',U('groupList'));
            }else{
                $this->error('权限更新失败!');
            }
        }else{
            $this->error('权限更新失败!');
        }
    }

    //修改用户组
    public function updateGroup(){
        if(IS_GET){
            if(!isset($_GET['id'])){
                return false;
            }
            $id=I("id",0,"intval");
            if(!$id){
                return false;
            }
            $group=M("auth_group")->where(array("id"=>$id))->select();
            $rule=M("auth_rule")->select();
            foreach($rule as $k=>$v){
                if(in_array($rule[$k]['id'],explode(',',$group['rules']))){
                    $rule[$k]['is_checked']=1;
                }else{
                    $rule[$k]['is_checked']=0;
                }
            }
            $this->rule=$rule;
            $this->group=$group;
            $this->id=$id;
            $this->display();
        }elseif(IS_POST){
            $data=array(
                'title'=>I("title","","trim"),
                //'rules'=>implode(",",$_POST['rule']),
                'rules'=>I("rules","","trim"),
                'status'=>I("status","","trim")
            );

            if(M("auth_group")->where(array("id"=>$_POST['id']))->save($data)){
                $this->success("修改成功...",U("groupList"));
            }else{
                $this->error("修改失败...");
            }
        }else{
            $this->error("操作出错");
        }
    }

    //删除用户组
    public function delGroup(){
        if(IS_GET){
            if(!isset($_GET['id'])){
                //return false;
                $this->error("操作出错",'groupList',5);
            }
            $id=I("id",0,"intval");
            if(!$id){
                //return false;
                $this->error("操作出错",'groupList',5);
            }
            if(M("auth_group")->where(array("id"=>$id))->delete()){
                M("auth_group_access")->where(array("group_id"=>$id))->delete();
                $this->success("删除成功...",U("groupList"));
            }else{
                $this->error("删除失败...");
            }
        }else{
            $this->error("操作出错");
        }
    }
}