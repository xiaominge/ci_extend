<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Autoload 自动载入
require BASEPATH.'../vendor/autoload.php';

// 载入数据库配置文件
require_once APPPATH.'config/database.php';
// Eloquent ORM
use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection($db['eloquent']);
$capsule->bootEloquent();