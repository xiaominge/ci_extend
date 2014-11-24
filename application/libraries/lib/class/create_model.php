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
class M_[directory]_[table_name] extends MY_Model implements SplSubject
{
    public function __construct()
    {
        \$this->directory = '[directory]';
        \$this->table = '[table_name]';
        \$this->_primary = '[_primary]';
        parent::__construct();
    }
}";

    public static function instance($filename, $path = '', $primary)
    {
        if($path) {
            $tablename = str_replace('m_'.$path.'_', '', $filename);
            $out = str_replace(array('[table_name]', '[_primary]', '[directory]'), array($tablename, $primary, $path), self::$tpl);
        } else {
            $tablename = str_replace('m_', '', $filename);
            $out = str_replace(array('[table_name]', '[_primary]', '[directory]', 'M_'), array($tablename, $primary, $path, 'M'), self::$tpl);
        }
        
        if($path) {
            $filename = APPPATH."models/{$path}/{$filename}.php";
        } else {
            $filename = APPPATH."models/{$filename}.php";
        }
        
        file_put_contents($filename, $out) or exit("can't write $filename");
        return true;
    } 
}
