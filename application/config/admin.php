<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| admin config
|--------------------------------------------------------------------------
*/

// 是否开启认证
$config['admin_auth_on']              = true;
// 认证方式1,只登录认证;2,实时认证
$config['admin_auth_type']            = '2';
// SESSION标记
$config['admin_auth_key']             = 'MyAuth';
// 默认认证网关
$config['admin_auth_gateway']         = 'admin/index/login';
// 成功登录默认跳转模块
$config['admin_default_index']        = 'admin/index';
// 不需要验证的方法
$config['admin_notauth_method']        = array('login');


/* End of file admin.php */
/* Location: ./application/config/admin.php */
