<?php

namespace Lib\Classes;

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 上传类
 * @author 徐亚坤 hdyakun@sina.com
 */

class upload
{
    /**
     * 不需要重命名的来源
     * @array 
     */
    public $rename_source = array();

    /**
     * 构造函数
     * @void 
     */
    public function __construct()
    {

    }

    /**
     * 上传图片
     * @return 
     */
    public function image($source = '', $old_url = '')
    {
        // $config['max_size'] = '100';
        // $config['max_width']  = '1024';
        // $config['max_height']  = '768';

        // 上传字段名
        $field_name = "{$source}_image";
        // 设置允许上传拓展名
        $config['allowed_types'] = config('img_upload_ext');
        // 获取客户端文件名
        $file_name = $_FILES[$field_name]['name'];
        // 获取客户端文件拓展名
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        // 获取图片域名根目录
        $img_domain_path = config('img_domain_path');
        // 设置上传文件名
        $config['file_name'] = md5(microtime().uniqid()).'.'.$file_ext;
        // 设置文件上传目录
        $date = date("Y/m/d/", time());
        $config['upload_path'] = $img_domain_path.'uploads/images/'.$source.'/'.$date;

        // 如果传入旧文件地址
        if($old_url) {
            $old_url = base64_decode(urldecode($old_url));
            $old_url = ltrim($old_url, '/');
            if($this->rename_source && !in_array($source, $this->rename_source)) {
                $config['file_name'] = basename($old_url);
                $config['upload_path'] = $img_domain_path.pathinfo($old_url, PATHINFO_DIRNAME).'/';
            }
        }
        
        $dir = dir_create($config['upload_path'], config('img_domain_path'));

        if(!$dir) {
            echo "<script>window.parent.thumb('error', '目录创建失败');</script>";
            exit();
        }

        $CI = ci();
        $CI->load->library('upload', $config);

        if($old_url) {
            if(file_exists($img_domain_path.$old_url)) {
                @unlink($img_domain_path.$old_url);
            }
        }

        if(!$CI->upload->do_upload($field_name)) {
            $error = $CI->upload->display_errors();
            echo "<script>window.parent.thumb('error', '{$error}');</script>";
            exit();
        } else {
            $upload_data = $CI->upload->data();
            $upload_path = '/'.str_replace($img_domain_path, '', $config['upload_path']).$upload_data['file_name'];
            echo "<script>window.parent.thumb('success', '上传成功', '{$upload_path}');</script>";
            exit();
        }
    }
    // end method
}
// end class