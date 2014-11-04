<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * 模型
 * @author 自动生成
 */
class M_user extends MY_Model implements SplSubject
{
    public function __construct()
    {
        $this->table = 'user';
        parent::__construct();
    }
}