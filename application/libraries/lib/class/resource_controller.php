<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 资源控制器基类
 * @author 徐亚坤 http://www.jxwen.com/
 */

class R_Controller extends MY_Controller
{
    public function __construct() {

        parent::__construct();
    }

    public function index()
    {
        $this->load->model('m_vod');

        $this->m_vod->event = '打印';
        $this->m_vod->notify(', hello world!<br />');

        $this->m_vod->aa();

        // model('m_user');
        // $user = $this->m_user->get('*', 'id=3');
        // echo "<pre>";print_r($user);exit();
    }
}