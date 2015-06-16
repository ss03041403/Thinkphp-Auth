<?php
namespace Admin\Controller;
use Think\Controller;

class AuthController extends CommonController{

	//获取权限规则列表
    public function authList(){
        $m=D('RuleView');
        $count=$m->count();
        $page=new \Think\Page($count,10);
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $show=$page->show();
        $data=$m->limit($page->firstRow.','.$page->listRows)->order('id asc')->select();
        $this->assign('page',$show);
        $this->assign('num',$page->firstRow);
        $this->assign('data',$data);
        $this->display();
    }

    //添加后台权限
    public function addAuth(){
		$modules=M('Modules');
		$modules=$modules->select();
		$this->assign('modules',$modules);
		$this->display();
    }

    //后台权限表单处理
    public function addAuthHandle(){
    	if(IS_POST){
            //print_r($_POST);exit();
            $data=array(
                'name'=>I('name','','trim'),
                'title'=>I('title','','trim'),
                'status'=>I('status',0,'intval'),
                'condition'=>I('condition','','trim'),
                'mid'=>I('modules','','intval'),      
                );
            if(!$data['name'])
                $this->error("权限路径为空,添加失败...");
            if(!$data['title'])
                $this->error("权限名称为空,添加失败...");
            if(!$data['mid'])
                $this->error("所属模块为空,添加失败...");
            if(M("auth_rule")->add($data)){
                $this->success("添加成功...",U("AuthList"));
            }else{
                $this->error("添加失败...");
            }
        }else{
        	$this->error("添加失败...");
        }
    }

    //删除RULE
    public function deleteRule(){
        if(IS_GET){
            if(!isset($_GET['id'])){
                return false;
            }
            $id=I("id",0,"intval");
            if(!$id){
                return false;
            }
            if(M("auth_rule")->where(array("id"=>$id))->delete()){
                $this->success("删除成功...",U("AuthList"));
            }else{
                $this->error("删除失败...");
            }
        }
    }
    //修改RULE
    public function updateRule(){
        if(IS_POST){
            if(!isset($_POST['id'])){
                return false;
            }
            $id=I("id",0,"intval");
            unset($_POST['id']);
            if(!$id){
                return false;
            }
            if(M("auth_rule")->where(array("id"=>$id))->save($_POST)){
                $this->success("修改成功...",U("AuthList"));
            }else{
                $this->error("修改失败...");
            }
        }else{
            $rule['id']=$where['id']=I('id');
            $rule=D('RuleView');
            $rule=$rule->where($where)->select();
            $this->assign('rule',$rule);
            $modules=M('Modules');
            $modules=$modules->select();
            $this->assign('modules',$modules);
            $this->display();
        }
    }

/*后台权限分类操作——————————————————————————————————————————————————————————————————————————————————*/

    //权限分类列表
    public function authCateList(){
        $this->modules=M("modules")->select();
        $this->display();
    }
    //添加权限分类
    public function addAuthCate(){
        $this->display();
    }
    //处理权限分类添加
    public function addAuthCateHandle(){
        if(IS_POST){
            $data['moduleName']=I('moduleName');
            $modules=M('Modules');
            if($data['moduleName']==null){
                $this->error('添加失败');
            }else{
                if($modules->add($data)){
                    $this->success('添加成功',U('authCateList'));
                }else{
                    $this->error('添加失败');
                }
            }
        }else{
            $this->error('添加失败');
        }
    }

    //删除分类
    public function deleteCate(){
        if(IS_GET){
            if(!isset($_GET['id'])){
                return false;
            }
            $id=I("id",0,"intval");
            if(!$id){
                return false;
            }
            if(M("Modules")->where(array("id"=>$id))->delete()){
                $this->success("删除成功...",U("authCateList"));
            }else{
                $this->error("删除失败...");
            }
        }
    }

    //修改分类
    public function updateCate(){
        if(IS_POST){

        }else{
            if(!isset($_GET['id'])){
                $this->error("操作失败");
            }
            $id=$_GET['id'];
            $modules=M("Modules");
            $modules=$modules->where(array('id'=>$id))->select();
            $this->modules=$modules;
            $this->display();
        }
    }
}