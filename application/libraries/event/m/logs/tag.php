<?php

namespace Event\M\Logs;

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 观察者
 * @author 徐亚坤
 */

class Tag
{
    protected $model;

    public function __construct(&$model)
    {
        $this->model = $model;
    }

    public function testworld($str = '')
    {
        echo ' world!';
    }
}