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

    public function __construct()
    {

        parent::__construct();
    }

    /**
     * 首页
     */
    public function index()
    {
        // 载入类库
        $this->load->library('sharp_template');
        // 加载视图
        $view = $this->sharp_template->parse('message');

        require_once APPPATH.'libraries/lib/class/resource_controller.php';
        $resource_controller = new R_Controller();
        $resource_controller->index();

        exit($view);
    }
}