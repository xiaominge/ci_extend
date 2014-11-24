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

        parent::index();

        $output = ob_get_contents();
        ob_end_clean();

        if($this->input->all('dosubmit')) {
            $input = $this->input->except('name');
            print_r($input);
            echo get_request_method();
        } else {
            $this->load->view('index');
        }

        // 载入类库
        $this->load->library('sharp_template');
        // 加载视图
        $this->sharp_template->parse('message', array('output' => $output));
    }
}