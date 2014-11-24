<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 首页控制器
 * @author 徐亚坤 http://www.jxwen.com/
 */

require_once APPPATH.'libraries/lib/class/resource_controller.php';

class Index extends R_Controller implements SplSubject
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 首页
     */
    public function index()
    {
        echo "<pre>";
        model('front/m_front_logs');
        $this->m_front_logs->event = 'testhello';
        $this->m_front_logs->notify();
        model('m_logs');
        $this->m_logs->event = 'testworld';
        $this->m_logs->notify();
    }
}