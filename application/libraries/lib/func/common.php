<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 函数库
 * @author 徐亚坤 http://www.jxwen.com/
 */

/* ---------------------辅助函数--------------------------------- */
/* ---------------------依赖环境--------------------------------- */

/**
 * @author 徐亚坤
 * 调用的时候 $CI = ci();
 */
function ci()
{
    $CI =& get_instance();
    return $CI;
}

/**
 * @author 徐亚坤
 * sql 信息
 */
function console($var = null)
{
    static $firephp = null;
    if(is_null($firephp)) {
        require_once APPPATH.'libraries/lib/class/firephp.php';
    }
    if(class_exists('FirePHP', false)) {
        $firephp = FirePHP::getInstance(true);
        $args = func_get_args();
        call_user_func_array(array($firephp, 'fb'), $args);
    } else {
        var_dump($var);
    }
}

if (! function_exists('style')) {
    /**
     * 样式别名加载（支持批量加载，后期可拓展为自动多文件压缩合并）
     * @author 徐亚坤
     * @param  dynamic  mixed  配置文件中的别名
     * @return string
     */
    function style()
    {
        $CI =& get_instance();
        $cssAliases = $CI->config->item('cssAliases');
        $styleArray = array_map(function ($aliases) use ($cssAliases) {
            if (isset($cssAliases[$aliases])) {
                return '<link media="all" type="text/css" rel="stylesheet" href="'.base_url($cssAliases[$aliases]).'">'.PHP_EOL;
            }
        }, func_get_args());
        return implode('', array_filter($styleArray));
    }
}

if (! function_exists('script')) {
    /**
     * 脚本别名加载（支持批量加载，后期可拓展为自动多文件压缩合并）
     * @author 徐亚坤
     * @param  dynamic  mixed  配置文件中的别名
     * @return string
     */
    function script()
    {
        $CI =& get_instance();
        $jsAliases = $CI->config->item('jsAliases');
        $scriptArray = array_map(function ($aliases) use ($jsAliases) {
            if (isset($jsAliases[$aliases])) {
                return '<script type="text/javascript" src="'.base_url($jsAliases[$aliases]).'"></script>'.PHP_EOL;
            }
        }, func_get_args());
        return implode('', array_filter($scriptArray));
    }
}

/**
 * 错误跳转
 * @author 徐亚坤
 */
if(!function_exists("error_redirct")) {
    function error_redirct($url = "", $contents = "操作失败", $time = 3)
    {
        
        $ci_obj = &get_instance();
        if($url != "") {
            //print_r($_SERVER);
            $url = site_url($url);
        } else {
            $url = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url();
        }
        $data['url'] = $url;
        $data['time'] = $time;
        $data['type'] = "error";
        $data['contents'] = $contents;
        $ci_obj->load->view("common/redirect", $data);
        $ci_obj->output->_display($ci_obj->output->get_output());
        die();
    }
}

/**
 * 正确跳转
 * @author 徐亚坤
 */
if(!function_exists("success_redirct")) {
    function success_redirct($url, $contents = "操作成功", $time = 3)
    {
        $ci_obj = &get_instance();
        if($url != "" ) {
            $url = site_url($url);
        } else {
            $url = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url();
        }
        $data['url'] = $url;
        $data['time'] = $time;
        $data['type'] = "success";
        $data['contents'] = $contents;
        $ci_obj->load->view("common/redirect", $data);
        $ci_obj->output->_display($ci_obj->output->get_output());
        die();
    }
}

/**
 * 分页配置
 * @author 徐亚坤
 */
if(!function_exists("get_page_config")) {
    function get_page_config($base_url, $uri_segment = 3)
    {
        $config['base_url'] = $base_url;
        $config['num_links'] = 5;
        $config['uri_segment'] = $uri_segment;
        $config['first_link'] = '首页';
        $config['last_link'] = '末页';
        $config['next_link'] = '下一页>';
        $config['prev_link'] = '<上一页';
        $config['use_page_numbers'] = TRUE;
        return $config;
    }
}

/**
 * 密码
 * @author 徐亚坤
 */
if(!function_exists("password")) {
    function password($password, $encrypt = '')
    {
        if($encrypt) {
            $password = md5(md5($password).$encrypt);
        } else {
            $password = md5($password);
        }
        return $password;
    }
}

/**
 * 创建目录
 * @author 徐亚坤
 * @param string $path 路径
 * @param string $mode 属性
 * @return string 如果已经存在则返回true，否则为flase
 */
function dir_create($path, $mode = 0777)
{
    if(is_dir($path) || $path == '') {
        return true;
    }

    $path = dir_path($path);
    $path = str_replace(str_replace('\\', '/', FCPATH), '', $path);
    $temp = array_filter(explode('/', $path));
    $cur_dir = FCPATH;

    foreach($temp as $name) {
        $cur_dir .= $name . '/';
        if (@is_dir($cur_dir)) continue;
        @mkdir($cur_dir, 0777, true);
        @chmod($cur_dir, 0777);
    }
    
    return is_dir(FCPATH.$path);
}

/**
 * 载入视图的缩略写法
 * @author 徐亚坤
 */
function lv($view, $vars = array(), $return = FALSE)
{
    $CI =& get_instance();
    if($return) {
        return $CI->load->view($view, $vars, true);
    } else {
        $CI->load->view($view, $vars, false);
    }
}

/**
 * 获取 get 数据
 * @author 徐亚坤
 */
function get($key, $clean = false)
{
    $CI =& get_instance();
    return $CI->input->get($key, $clean);
}

/**
 * 获取 post 数据
 * @author 徐亚坤
 */
function post($key, $clean = false)
{
    $CI =& get_instance();
    return $CI->input->post($key, $clean);
}

/**
 * 载入模型文件的缩略写法
 * @author 徐亚坤
 */
function model($model, $name = '', $db_conn = FALSE)
{
    $CI =& get_instance();
    $ret = $CI->load->model($model, $name, $db_conn);
    if($ret === false) {

        $path_and_file = explode('/', $model);

        if(count($path_and_file) > 1) {
            $filename = array_pop($path_and_file);
            $path = implode('/', $path_and_file);
        } else {
            $filename = $model;
            $path = '';
        }

        require_once APPPATH.'libraries/lib/class/create_model.php';

        if(!create_model::instance($filename, $path)) {
            exit("模型{$filename}无法创建！");
        } else {
            $CI->load->model($model, $name, $db_conn);
        }

    }
}

/**
 * 载入类库文件的缩略写法。
 * @author 徐亚坤
 */
function library($library = '', $params = NULL, $object_name = NULL)
{
    $CI =& get_instance();
    $CI->load->library($library, $params, $object_name);
}

/**
 * 获取配置信息
 * @author 徐亚坤
 */
function config($key, $default = '', $file = '')
{
    $CI =& get_instance();

    if($file) {
        $CI->config->load($file);
    }

    $item = $CI->config->item($key);
    
    if($item) {
        return $item;
    } elseif(!$item && $default) {
        return $default;
    } elseif(!$item && !$default) {
        return false;
    }
}

if (! function_exists('order_by')) {
    /**
     * 用于列表的排序标签
     * @param  string $columnName 列名
     * @param  string $default    是否默认排序列，up 默认升序 down 默认降序
     * @return string             a 标签排序图标
     */
    function order_by($columnName = '', $default = null)
    {
        $url = get_url();
        $query_arr = get_url_arr($url);

        if(isset($query_arr['sort_up'])) {
            $sortColumnName = $query_arr['sort_up'];
        } elseif(isset($query_arr['sort_down'])) {
            $sortColumnName = $query_arr['sort_down'];
        } else {
            $sortColumnName = false;
        }

        // URI 键
        if(isset($query_arr['sort_up']) && $sortColumnName == $columnName) {
            $orderType = 'sort_down';
        } else {
            $orderType = 'sort_up';
        }

        // 图标
        if($sortColumnName == $columnName) {
            $icon = isset($query_arr['sort_up']) ? 'sort-down' : 'sort-up';
        } elseif($sortColumnName === false && $default == 'asc') {
            $icon = 'sort-down';
        } elseif($sortColumnName === false && $default == 'desc') {
            $icon = 'sort-up';
        } else {
            $icon = 'sort';
        }

        $url_array = array();
        if(isset($query_arr['sort_up'])) {
            unset($query_arr['sort_up']);
        }
        if(isset($query_arr['sort_down'])) {
            unset($query_arr['sort_down']);
        }

        $sort = array();
        $sort[$orderType] = $columnName;

        foreach($query_arr as $k => $v) {
            $url_array[] = "{$k}={$v}";
        }
        foreach($sort as $k => $v) {
            $url_array[] = "{$k}={$v}";
        }
        $url_str = implode('&', $url_array);
        $play_url = current_url()."?".$url_str;

        $a  = '<a href="'.$play_url.'"';
        $a .= ' class="fa fa-'.$icon.'"></a>';
        return $a;
    }
}


/* -----------------------工具函数------------------------------- */
/* -----------------------环境无关------------------------------- */

/**
 * 判断是否链接
 * @author 徐亚坤
 */
if(!function_exists("is_http")) {
    function is_http($url)
    {
        $preg = "/(http:|https:)/";
        if(preg_match($preg, $url)) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * 计算数组深度
 * @author 徐亚坤
 * @param array $array
 * @return int
 */
function array_depth($array)
{
    $max_depth = 1;
    foreach($array as $value) {
        if(is_array($value)) {
            $max_depth = array_depth($value) + 1;
        }
    }
    return $max_depth;
}

/**
 * 将多维数组转为一维数组
 * @author 徐亚坤
 * @param array $arr
 * @return array
 */
function array_tile($arr)
{
    // 将数值第一元素作为容器，作地址赋值。
    $ar_room =& $arr[key($arr)];
    // 第一容器不是数组进去转
    if(!is_array($ar_room)) {
        // 转为成数组
        $ar_room = array($ar_room);
    }
    // 指针下移
    next($arr);
    // 遍历
    while(list($k, $v) = each($arr)) {
        // 是数组就递归深挖，不是就转成数组
        $v = is_array($v) ? call_user_func(__FUNCTION__, $v) : array($v);
        // 递归合并
        $ar_room = array_merge_recursive($ar_room, $v);
        // 释放当前下标的数组元素
        unset($arr[$k]);
    }
    return $ar_room;
}

/**
 * 转化 \ 为 /
 * @author 徐亚坤
 * @param string $path 路径
 * @return string 路径
 */
function dir_path($path)
{
    $path = str_replace('\\', '/', $path);
    if(substr($path, -1) != '/') {
        $path = $path . '/';
    }
    return $path;
}

/**
 * 列出目录下所有文件
 * @author 徐亚坤
 * @param string $path 路径
 * @param string $exts 扩展名
 * @param array $list 增加的文件列表
 * @return array 所有满足条件的文件
 */
function dir_list($path, $exts = '', $list = array())
{
    $path = dir_path($path);
    $files = glob($path.'*');

    foreach($files as $v) {
        if(!$exts || pathinfo($v, PATHINFO_EXTENSION) == $exts) {
            $list[] = $v;
            if(is_dir($v)) {
                $list = dir_list($v, $exts, $list);
            } 
        } 
    }
    return $list;
}

/**
 * 判断字符串纯汉字 OR 纯英文 OR 汉英混合
 * @author 徐亚坤
 * @return 1: 英文，2：纯汉字，3：汉字和英文
 */
function utf8_str($str)
{
    $mb = mb_strlen($str, 'utf-8');
    $st = strlen($str);
    if($st == $mb) {
        return 1;
    }
    if($st%$mb == 0 && $st%3 == 0) {
        return 2;
    }
    return 3;
}

/**
 * 获取字符串长度，支持中文和其他编码
 * @author 徐亚坤
 * @param string $str 需要计算的字符串
 * @param string $charset 字符编码
 * @return length int
*/
function abslength($str, $charset = 'utf-8')
{
    if(empty($str)) {
        return 0;
    }
    if(function_exists('mb_strlen')) {
        return mb_strlen($str, 'utf-8');
    } else {
        @preg_match_all("/./u", $str, $ar);
        return count($ar[0]);
    }
}

/**
 * 字符串截取，支持中文和其他编码
 * @author 徐亚坤
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @param string $strength 字符串的长度
 * @return string
 */
function msubstr($str, $start = 0, $length, $strength, $charset = "utf-8", $suffix = true)
{
    if(function_exists("mb_substr")) {
        if($suffix){
            if($length < $strength) {
                return mb_substr($str, $start, $length, $charset)."…";
            } else {
                return mb_substr($str, $start, $length, $charset);
            }
        } else {
            return mb_substr($str, $start, $length, $charset);
        }
    } elseif(function_exists('iconv_substr')) {
        // 是否加上点号
        if($suffix) {
            if($length < $strength) {
                return iconv_substr($str, $start, $length, $charset)."…";
            } else {
                return iconv_substr($str, $start, $length, $charset);
            }
        } else {
            return iconv_substr($str, $start, $length, $charset);
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
        if($suffix) {
            return $slice."…";
        } else {
            return $slice;
        }
    }
}

/**
 * 获取请求ip
 * @author 徐亚坤
 * @return ip 地址
 */
function ip()
{
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches[0] : '';
}

/**
 * 返回经addslashes处理过的字符串或数组
 * @author 徐亚坤
 * @param  $string 需要处理的字符串或数组
 * @return mixed
 */
function new_addslashes($string)
{
    if(!is_array($string)) {
        return addslashes ($string);
    }
    foreach($string as $key => $val) {
        $string[$key] = new_addslashes($val);
    }
    
    return $string;
}

/**
 * 返回经stripslashes处理过的字符串或数组
 * @author 徐亚坤
 * @param  $string 需要处理的字符串或数组
 * @return mixed
 */
function new_stripslashes($string)
{
    if(!is_array($string)) {
        return stripslashes($string);
    }
    foreach($string as $key => $val) {
        $string[$key] = new_stripslashes($val);
    }

    return $string;
}

/**
 * 返回经unserialize处理过的数组
 * @author 徐亚坤
 * @param $string 需要处理的字符串
 * @return mixed
 */
function new_unserialize($data)
{
    if(($ret = unserialize($data)) === false) {
        $ret = unserialize(stripslashes($data));
    }
    return $ret;
}

/**
 * 安全过滤函数
 *
 * @param  $string
 * @return string
 */
function safe_replace($string)
{
    $string = str_replace('%20', '', $string);
    $string = str_replace('%27', '', $string);
    $string = str_replace('%2527', '', $string);
    $string = str_replace('*', '', $string);
    $string = str_replace('"', '&quot;', $string);
    $string = str_replace("'", '', $string);
    $string = str_replace('"', '', $string);
    $string = str_replace(';', '', $string);
    $string = str_replace('<', '&lt;', $string);
    $string = str_replace('>', '&gt;', $string);
    $string = str_replace("{", '', $string);
    $string = str_replace('}', '', $string);
    $string = str_replace('\\', '', $string);
    return $string;
}

/**
 * 获取当前页面完整URL地址
 */
function get_url()
{
    if(isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') {
        $sys_protocal = 'https://';
    } else {
        $sys_protocal = 'http://';
    }
    if($_SERVER['PHP_SELF']) {
        $php_self = safe_replace($_SERVER['PHP_SELF']);
    } else {
        $php_self = safe_replace($_SERVER['SCRIPT_NAME']);
    }
    $path_info = isset($_SERVER['PATH_INFO']) ? safe_replace($_SERVER['PATH_INFO']) : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? safe_replace($_SERVER['REQUEST_URI']) : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.safe_replace($_SERVER['QUERY_STRING']) : $path_info);
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}

function get_url_arr($url)
{
    $params = array();
    $query = parse_url($url, PHP_URL_QUERY);

    if($query) {
        $queryParts = explode('&', $query);
    }
    if(isset($queryParts)) {
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
    }

    return $params;
}

function random($length, $chars = '0123456789')
{
    $numeric = preg_match('/^[0-9]+$/', $chars) ? 1 : 0;
    $seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
    if($numeric) {
        $hash = '';
    } else {
        $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
        $length--;
    }
    $max = strlen($seed) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $seed{mt_rand(0, $max)};
    }
    return $hash;
}
