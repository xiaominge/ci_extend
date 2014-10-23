<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 观察者实现类
 * @author 徐亚坤
 */

class observer implements SplObserver
{
    static private $object;
    public $scource;

    public function __construct($scource = 'o')
    {
        $this->scource = $scource;
        $this->event_path = APPPATH.'libraries/event/'.$scource.'/';
    } 

    public function update(SplSubject $subject, $args = '')
    {
        $event = $subject->event;
        $subject_class = str_replace('m_', '', strtolower(get_class($subject)));
        $event_path = $this->event_path.$subject_class.'/';

        if(is_dir($event_path)) {
            $observer_files = dir_list($event_path, 'php');
            
            foreach($observer_files as $file) {
                $ob_class = basename($file, ".php");
                if(!isset(self::$object[$this->scource][$subject_class][$ob_class])) {
                    require_once $file;
                    $class = 'event_'.$this->scource.'_'.$subject_class.'_'.$ob_class;
                    self::$object[$this->scource][$subject_class][$ob_class] = new $class($subject);
                }

                if(method_exists(self::$object[$this->scource][$subject_class][$ob_class], $event)) {
                    self::$object[$this->scource][$subject_class][$ob_class]->$event($args);
                }
            }

        }
    }
}
