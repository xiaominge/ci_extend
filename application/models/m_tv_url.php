<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 电视剧地址模型
 * @author 徐亚坤
 */
class M_tv_url extends MY_Model implements SplSubject
{
    public $info;
    
    public function __construct()
    {
        $this->table = 'tv_url';
        parent::__construct();
    }

}
