<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 首页控制器
 * @author 徐亚坤
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
        $vod = $this->m_vod->get('`name` as dd', 'id=17');
        echo "<pre>";var_dump($vod);exit();
    }
}