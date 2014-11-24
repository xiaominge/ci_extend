<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 观察者实现类
 * @author 徐亚坤 http://www.jxwen.com/
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
        $event_path = $this->event_path.str_replace('_', '/', $subject_class).'/';

        if(is_dir($event_path)) {
            $observer_files = dir_list($event_path, 'php');
            foreach($observer_files as $file) {
                $ob_class = basename($file, ".php");
                if($subject->directory) {
                    $exists = isset(self::$object[$this->scource][$subject->directory][$subject_class][$ob_class]);
                } else {
                    $exists = isset(self::$object[$this->scource][$subject_class][$ob_class]);
                }
                if(!$exists) {
                    require_once $file;
                    if($subject->directory) {
                        $class = "\Event\\".strtoupper($this->scource)."\\".ucfirst($subject->directory)."\\".ucfirst($subject->table)."\\".ucfirst($ob_class);
                        self::$object[$this->scource][$subject->directory][$subject->table][$ob_class] = new $class($subject);
                    } else {
                        $class = "\Event\\".strtoupper($this->scource)."\\".ucfirst($subject->table)."\\".ucfirst($ob_class);
                        self::$object[$this->scource][$subject->table][$ob_class] = new $class($subject);
                    }
                }
                if($subject->directory) {
                    if(method_exists(self::$object[$this->scource][$subject->directory][$subject->table][$ob_class], $event)) {
                        self::$object[$this->scource][$subject->directory][$subject->table][$ob_class]->$event($args);
                    }
                } else {
                    if(method_exists(self::$object[$this->scource][$subject->table][$ob_class], $event)) {
                        self::$object[$this->scource][$subject->table][$ob_class]->$event($args);
                    }
                }
            }
        }
    }
}
