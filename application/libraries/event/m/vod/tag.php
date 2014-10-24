<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 观察者
 * @author 徐亚坤
 */

class event_m_vod_tag
{
    protected $model;

    public function __construct(&$model)
    {
        $this->model = $model;
    }

    public function 打印($str = '')
    {
        echo 'ok'.$str;
        ci()->load->model('m_tag');
        $tag = ci()->m_tag->get('name');
        echo "<pre>";var_dump($tag);
    }
}