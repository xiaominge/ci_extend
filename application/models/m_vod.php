<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 视频模型
 * @author 徐亚坤
 */
class M_vod extends MY_Model implements SplSubject
{
    public $info;
    
    public function __construct()
    {
        $this->table = 'vod';
        parent::__construct();
    }

}
