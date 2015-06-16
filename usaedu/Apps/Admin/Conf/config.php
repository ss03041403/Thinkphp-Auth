<?php
return array(
	//'配置项'=>'配置值'
	/* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/Statics/Admin',
        '__ADDONS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/Addons',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
    ),
    'AUTH_CONFIG'=>array(
        'AUTH_ON' => true, //认证开关
        'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP' => 'tp_auth_group', //用户组数据表名
        'AUTH_GROUP_ACCESS' => 'tp_auth_group_access', //用户组明细表
        'AUTH_RULE' => 'tp_auth_rule', //权限规则表
        'AUTH_USER' => 'tp_members'//用户信息表
    ),
    //超级管理员id,拥有全部权限,只要用户uid在这个角色组里的,就跳出认证.可以设置多个值,如array('1','2','3')
    'ADMINISTRATOR'=>array('1'),
);