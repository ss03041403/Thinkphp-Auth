<?php 
namespace Admin\Model;
use Think\Model\ViewModel;
class GroupMemberViewModel extends ViewModel{
	public $viewFields=array(		
		'member'=>array('_table'=>'tp_user','id'=>'mid','username'),		
		'groups'=>array('_table'=>'tp_auth_group_access','uid','group_id','_on'=>'member.uid=groups.uid')
		);
}
 ?>