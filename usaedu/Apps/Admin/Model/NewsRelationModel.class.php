<?php

namespace Admin\Model;
use Think\Model\RelationModel;
class NewsRelationModel extends RelationModel{
    //关联查询用户所属的用户组
    protected $tableName='news';
    protected $_link = array(
        'attr' => array(
            'mapping_type' => self::MANY_TO_MANY,
            'class_name' => 'attr',
            'mapping_name' => 'attr',
            'foreign_key' => 'nid',
            'relation_foreign_key' => 'aid',
            'relation_table' => 'tp_news_attr'
        ),
        'cate'=>array(
        	'mapping_type' => self::BELONGS_TO,
        	'foreign_key' => 'cid',
        	'mapping_fields'=>'name',
        	'as_fields'=>'name:catname'
        	)
    );
}