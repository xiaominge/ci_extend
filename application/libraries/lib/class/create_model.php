<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 自动生成模型
 * @author 徐亚坤
 */

class create_model
{
    static $tpl = "<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * 模型
 * @author 自动生成
 */
class M_[table_name] extends MY_Model implements SplSubject
{
    public function __construct()
    {
        \$this->table = '[table_name]';
        parent::__construct();
    }
}";

    public static function instance($filename, $path = '')
    {
        $tablename = preg_replace('/^m_/i', '', $filename);
        $out = str_replace(array('[table_name]'), array($tablename), self::$tpl);
        if($path) {
            $filename = APPPATH."models/{$path}/{$filename}.php";
        } else {
            $filename = APPPATH."models/{$filename}.php";
        }
        
        file_put_contents($filename, $out) or exit("can't write $filename");
        return true;
    } 
} 
