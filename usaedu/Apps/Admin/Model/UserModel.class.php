<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-10-20
 * Time: 下午12:54
 */
namespace Admin\Model;
use Think\Model\RelationModel;
class UserModel extends RelationModel{
    //关联查询用户所属的用户组
    protected $_link = array(
        'auth_group' => array(
            'mapping_type' => self::MANY_TO_MANY,
            'class_name' => 'auth_group',
            'mapping_name' => 'classify',
            'foreign_key' => 'uid',
            'relation_foreign_key' => 'group_id',
            'relation_table' => 'tp_auth_group_access'
        )
    );
}