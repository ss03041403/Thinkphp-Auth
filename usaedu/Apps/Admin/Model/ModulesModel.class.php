<?php

namespace Admin\Model;
use Think\Model\RelationModel;
class modulesModel extends RelationModel{
    //关联查询用户所属的用户组
    protected $_link = array(
        'auth_rule' => array(
            'mapping_type' => self::HAS_MANY,
            //'class_name' => 'access',
            'mapping_name' => 'access',
            'foreign_key' => 'mid',
            'relation_table' => 'tp_auth_rule'
        )
    );
}