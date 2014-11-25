<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 自定义控制器基类
 * @author 徐亚坤 hdyakun@sina.com
 */

class MY_Controller extends CI_Controller
{

    public function __construct() {
        parent::__construct();

        if($this instanceof SplSubject) {
            $observer = new observer('c');
            $this->attach($observer);
        }

        $charset = config('charset', 'UTF-8');
        header("content-type:text/html; charset=".$charset);
        $timezone = config('timezone', 'Asia/Shanghai');
        date_default_timezone_set($timezone);
    }

    public function attach(SplObserver $observer)
    {
        $this->observers[] = $observer;
    }

    public function detach(SplObserver $observer)
    {
        if($index = array_search($observer, $this->observers, true)) {
            unset($this->observers[$index]);
        }  
    }

    public function notify($args = '')
    {
        foreach($this->observers as $observer) {
            $observer->update($this, $args);
        }
    }
}
