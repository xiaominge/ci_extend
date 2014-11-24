<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 首页控制器
 * @author 徐亚坤
 */

class Index extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 
     * 后台首页
     */
    public function index()
    {
        // 开启认证
        // 验证是否登录
        if($this->config->item('admin_auth_on')) {
            if(!isset($_SESSION[$this->config->item('admin_auth_key')]["info"]["id"])) {
                error_redirct($this->config->item('admin_auth_gateway'), "请先登录！");
            } else {
                $this->load->view('admin/index');
            }
        } else {
            $this->load->view('admin/index');
        }
    }

    /*
     * 用户登录
     */
    public function login()
    {
        $this->load->model("admin/m_admin_admin");
        $username = $this->input->all('username');
        $password = $this->input->all('password');

        if($username && $password) {
            $return = $this->m_admin_admin->check_user($username, $password);
            if($return === TRUE) {
                success_redirct($this->config->item('admin_default_index'), "登录成功！");
            } else {
                error_redirct($this->config->item('admin_auth_gateway'), $return);
                die();
            }
            
        } else {
            // session_destroy();
            $this->load->view("admin/login");
        }
    }

    /*
     * 用户退出
     */
    public function logout()
    {
        session_destroy();
        success_redirct($this->config->item('admin_auth_gateway'), "登出成功！", 2);
    }
}

/* End of file index.php */
/* Location: ./application/controllers/admin/index.php */