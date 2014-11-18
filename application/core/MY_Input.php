<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 自定义输入类
 * @author 徐亚坤 http://www.jxwen.com/
 */

class MY_Input extends CI_Input
{

	public function __construct()
	{
		parent::__construct();
	}

	public function except($keys)
	{
	    $keys = is_array($keys) ? $keys : func_get_args();

	    $results = $this->all();

	    array_forget($results, $keys);

	    return $results;
	}

	public function all($key = null, $default = null)
	{
	    $CI = ci();
	    $method = get_request_method();
	    if($method == 'get') {
	        $input = $CI->input->get();
	    } else {
	        $input = $CI->input->post();
	    }
	    return array_get($input, $key, $default);
	}
}

/* End of file MY_Input.php */
/* Location: ./application/core/MY_Input.php */