<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 控制器基类
 * @author 徐亚坤 http://www.jxwen.com/
 */

class MY_Controller extends CI_Controller
{

    function __construct() {

        parent::__construct();
        header("content-type:text/html; charset=".$this->config->item('charset'));
        if($this instanceof SplSubject) {
            $observer = new observer('c');
            $this->attach($observer);
        }
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