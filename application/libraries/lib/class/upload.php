<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 上传类
 * @author 徐亚坤 http://www.jxwen.com/
 */

class upload
{

    public function __construct()
    {

    }

    /**
     * 上传图片
     * @return 
     */
    public function image($source = '')
    {
        // $config['max_size'] = '100';
        // $config['max_width']  = '1024';
        // $config['max_height']  = '768';
        $config['allowed_types'] = config('img_upload_ext');
        $date = date("Y/m/d/", time());
        $config['upload_path'] = config('upload_path').'images/'.$source.'/'.$date;
        
        $dir = dir_create($config['upload_path']);

        if(!$dir) {
            echo "<script>window.parent.thumb('error', '目录创建失败');</script>";
            exit();
        }
        $CI = ci();
        $CI->load->library('upload', $config);
        $field_name = "{$source}_image";
        if(!$CI->upload->do_upload($field_name)) {
            $error = $CI->upload->display_errors();
            echo "<script>window.parent.thumb('error', '{$error}');</script>";
            exit();
        } else {
            $upload_data = $CI->upload->data();
            $upload_path = $config['upload_path'].$upload_data['file_name'];
            echo "<script>window.parent.thumb('success', '上传成功', '{$upload_path}');</script>";
            exit();
        }
    }
    // end method
}
// end class