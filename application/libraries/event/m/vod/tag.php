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
        $tags = ci()->m_tag->select_join('user.*,tag.*', 'user left join tag on tag.id=user.id');
        ci()->load->model('m_tv_url');
        $tv_urls = ci()->m_tv_url->select_join('*', 'tag left join tv_url on tag.id=tv_url.tv_id', 'tag.name like "%白%" and tag.type != 3');
        echo "<pre>";
        print_r($tags);
        print_r($tv_urls);
    }
}