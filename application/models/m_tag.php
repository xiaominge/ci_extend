<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 标签模型
 * @author 徐亚坤
 */
class M_tag extends MY_Model implements SplSubject
{
    public $info;
    
    public function __construct()
    {
        $this->table = 'tag';
        parent::__construct();
    }

}
