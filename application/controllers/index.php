<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 首页控制器
 * @author 徐亚坤 http://www.jxwen.com/
 */

class Index extends MY_Controller implements SplSubject
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * 首页
     */
    public function index()
    {
        $this->load->model('m_vod');

        $this->m_vod->event = '打印';
        $this->m_vod->notify(',hello world!');

        model('m_user');
        $user = $this->m_user->get('*', 'id=3');
        echo "<pre>";print_r($user);exit();
    }
}