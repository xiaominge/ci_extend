<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 拓展配置
 * @author 徐亚坤 http://www.jxwen.com/
 */

// js文件别名
$config['jsAliases'] = array(
    'jquery-21' => '/public/js/jquery-2.1.0.min.js',
    'jquery-bowser' => '/public/js/jquery.bowser.js',
    'common' => '/public/js/common.js',

    'ckform' => '/public/js/ckform.js',
    'bootstrap' => '/public/js/bootstrap.min.js',
);

// css文件别名
$config['cssAliases'] = array(
    'font-awesome' => '/public/css/font-awesome.css',

    'bootstrap-responsive' => '/public/css/bootstrap-responsive.min.css',
    'bootstrap' => '/public/css/bootstrap.min.css',
    'style' => '/public/css/style.css',
    'signin' => '/public/css/signin.css',
);


// 时区设置
$config['timezone'] = "Asia/Shanghai";
// 静态文件目录
$config['common_static'] = "/public/";
// 图片上传允许格式
$config['img_upload_ext'] = "gif|jpg|png|jpeg";
// 文件上传目录
$config['upload_path'] = "/uploads/";

// 页面大小
$config['page_size'] = "12";
// 项目名称
$config['project_name'] = "ci拓展";
// 版权信息
$config['project_copyright'] = "Copyright @ yakun";