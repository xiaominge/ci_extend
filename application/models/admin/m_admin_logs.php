<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * 模型
 * @author 自动生成
 */
class M_admin_logs extends MY_Model implements SplSubject
{
    public function __construct()
    {
        $this->directory = 'admin';
        $this->table = 'logs';
        $this->_primary = 'id';
        parent::__construct();
    }
}