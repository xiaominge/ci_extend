<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 上传控制器
 * @author 徐亚坤
 */

import('class.upload');

class Upload extends MY_Controller
{

    function __construct()
    {
        $this->upload = new \Lib\Classes\upload();
        parent::__construct();
    }

    /**
     * 上传图片
     * @return
     */
    public function image($source = '', $old_url = '')
    {
        $this->upload->image($source, $old_url);
    }

}