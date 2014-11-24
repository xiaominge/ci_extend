<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 权限验证
 * @author 徐亚坤
 */

class Admin_hook
{
	/*
	 * 登录验证(Hook自动加载)
	 */
	public function aoto_verify()
	{
		$ci_obj =& get_instance();
		// 方法
		$method = $ci_obj->router->fetch_method();
		// 控制器
		$class = $ci_obj->router->fetch_class();
		// 目录
		$directory = $ci_obj->router->fetch_directory();
		// 开启认证
		if($ci_obj->config->item('admin_auth_on')) {
			// 若为实时认证
			if($ci_obj->config->item('admin_auth_type') == 2) {
				// 方法需要验证
				if(!in_array($directory, $ci_obj->config->item('admin_notauth_directory')) && !in_array($class, $ci_obj->config->item('admin_notauth_controller')) && !in_array($method, $ci_obj->config->item('admin_notauth_method'))) {
					if(!isset($_SESSION[$ci_obj->config->item('admin_auth_key')]["info"]["id"])) {
						error_redirct($ci_obj->config->item('admin_auth_gateway'), '您还没有登录');
					}
					$ci_obj->load->model("admin/m_admin");
					$STATUS = $ci_obj->m_admin->check_user_by_id($_SESSION[$ci_obj->config->item('admin_auth_key')]["info"]["id"]);
					if($STATUS !== TRUE) {
						error_redirct($ci_obj->config->item('admin_auth_gateway'), $STATUS);
					}
				}
			}
		}
	}

}