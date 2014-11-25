<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 资源控制器基类
 * @author 徐亚坤 hdyakun@sina.com
 */

class R_Controller extends MY_Controller
{
    /**
     * 资源模型名称
     * @var string
     */
    public $model = '';

    /**
     * 资源名称（中文）
     * @var string
     */
    public $resourceName = '';

    /**
     * 资源标识
     * @var string
     */
    public $resource = '';

    /**
     * 验证
     * @var array
     */
    public $validator = array();

    protected $observers = array();

    protected $list_order = '';

    public $event;

    public $extend_data = array();

    public $list_data = array();

    public $edit_info = array();

    public function __construct() {
        parent::__construct();
    }

    /**
     * 资源列表
     */
    public function index($page = 1)
    {
        $this->load->helper('form');
        $page_size = $this->config->item('page_size');

        $base_url = site_url().'/admin/'.$this->resource."/index";
        $page_config = get_page_config($base_url, 4);
        $page_config['per_page'] = $page_size;

        $offset = ($page - 1) * $page_size;
        $limit = "$offset, $page_size";

        $this->load->model("admin/{$this->model}");

        $get = $this->input->get();
        $num = $this->{$this->model}->r_count($get);

        if($this->list_order) {
            $this->list_data = $this->{$this->model}->r_ls($this->input->get(), $limit, $this->list_order);
        } else {
            $this->list_data = $this->{$this->model}->r_ls($this->input->get(), $limit);
        }
        
        $this->load->library('pagination');
        $page_config['total_rows'] = $num;
        $this->pagination->initialize($page_config);
        
        $this->event = 'before_index';
        $this->notify();

        $this->ls_format();

        $data = array('list' => $this->list_data, 'resource' => $this->resource, 'extend_data' => $this->extend_data);
        // echo "<pre>";print_r($data);exit();
        $this->load->view('admin/'.$this->resource.'/index', $data);
    }

    /**
     * 资源添加
     */
    public function add()
    {
        $this->load->helper('form');
        $this->load->library('parser');
        $this->load->model("admin/{$this->model}");

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        $this->form_validation->set_rules($this->validator);

        $data = array('resource' => $this->resource);

        if($this->form_validation->run() == FALSE) {
            $this->load->view('admin/'.$this->resource.'/add', $data);
        } else {
            $input = $this->input->except('backid');
            $input = $this->before_add($input);

            $this->{$this->model}->event = 'before_add';
            $this->{$this->model}->notify();
            
            $status = $this->{$this->model}->insert($input);
            if($status) {
                $this->{$this->model}->event = 'after_add';
                $this->{$this->model}->notify($status);
                
                success_redirct("/admin/{$this->resource}/index", "添加成功！");
            } else {
                error_redirct("/admin/{$this->resource}/index", "添加失败！");
            }
        }
    }

    /**
     * 资源修改
     */
    public function edit($id = '', $return = FALSE)
    {
        $this->load->helper('form');
        $this->load->library('parser');

        $this->load->model("admin/{$this->model}");
        $this->{$this->model}->info = $this->{$this->model}->get('*', "id={$id}");

        $this->{$this->model}->event = 'after_get';
        $this->{$this->model}->notify();

        $this->edit_info = $this->{$this->model}->info;

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        $this->form_validation->set_rules($this->validator);

        $this->event = 'before_edit_view';
        $this->notify();

        $this->edit_format();

        $data = array('info' => $this->edit_info, 'id' => $id, 'resource' => $this->resource, 'extend_data' => $this->extend_data);
        // echo "<pre>";print_r($data);exit();
        if($this->input->post()) {
            if($this->validator && $this->form_validation->run() == FALSE) {
                $this->load->view('admin/'.$this->resource.'/edit', $data);
            } else {

                $this->{$this->model}->update_data = $this->before_edit($this->input->except('backid'));

                $this->{$this->model}->event = 'before_update';
                $this->{$this->model}->notify();

                $status = $this->{$this->model}->update($this->{$this->model}->update_data, $id);

                $this->{$this->model}->event = 'after_update';
                $this->{$this->model}->notify();

                if($return) {
                    return $status ? true : false;
                }
                if($status) {
                    success_redirct("/admin/{$this->resource}/edit/{$id}", "修改成功！");
                } else {
                    error_redirct("/admin/{$this->resource}/edit/{$id}", "修改失败！");
                }
            }
        } else {
            $this->load->view('admin/'.$this->resource.'/edit', $data);
        }
    }

    /**
     * 资源删除
     */
    public function delete($id, $force = false)
    {
        $this->before_delete($id);

        $this->load->model("admin/{$this->model}");

        $this->{$this->model}->event = 'before_delete';
        $this->{$this->model}->notify();

        if($force) {
            $status = $this->{$this->model}->delete($id);
        } else {
            $status = $this->{$this->model}->destroy($id);
        }

        $this->{$this->model}->event = 'after_delete';
        $this->{$this->model}->notify();

        // $this->output->enable_profiler(TRUE); exit();

        if($status) {
            success_redirct("/admin/{$this->resource}/index", "删除成功！");
        } else {
            error_redirct("/admin/{$this->resource}/index", "删除失败！");
        }
    }

    /**
     * 资源批量删除
     * DELETE      admin/resource/betch_destroy
     * @param
     */
    public function betch_destroy($force = false)
    {
        $data = $this->input->post();
        
        $ids = array_unique(array_filter(explode(',', $data['destroy_ids'])));
        if($ids) {
            $where = "`id` IN ('".implode("','", $ids)."')";
        } else {
            error_redirct("/admin/{$this->resource}/index", "请选择要删除的".$this->resourceName."!");
        }

        $this->before_betch_destroy($ids);

        $this->load->model("admin/{$this->model}");
        $this->{$this->model}->event = 'before_betch_destroy';
        $this->{$this->model}->notify($where);

        if($force) {
            $status = $this->{$this->model}->delete($where);
        } else {
            $status = $this->{$this->model}->destroy($where);
        }

        $this->{$this->model}->event = 'after_betch_destroy';
        $this->{$this->model}->notify();

        if($status) {
            success_redirct("/admin/{$this->resource}/index", $this->resourceName."删除成功！");
        } else {
            error_redirct("/admin/{$this->resource}/index", $this->resourceName."删除失败！");
        }
    }

    /**
     * 资源排序
     * DELETE      admin/resource/sort
     * @param  
     * @return 
     */
    public function sort()
    {
        $error = array();
        $data = $this->input->post();
        $this->load->model("admin/{$this->model}");
        $orders = $data['order'];
        foreach($orders as $id => $order) {
            if(!$this->{$this->model}->exists('id', $id)) {
                $error[] = '没有找到对应的'.$this->resourceName;
            } else {
                $data = array('order' => $order);
                $status = $this->{$this->model}->update($data, $id);
                if(!$status) {
                    $error[] = $this->resourceName.'排序失败。';
                }
            }
        }
        if(empty($error)) {
            success_redirct("/admin/{$this->resource}/index", $this->resourceName."排序成功。");
        } else {
            $error = implode('<br>', $error);
            error_redirct("/admin/{$this->resource}/index", $error);
        }
    }

    /**
     * 添加资源前置方法
     */
    public function before_add($input)
    {
        $input = array_filter($input);
        $input['ctime'] = time();
        $input['mtime'] = time();
        return $input;
    }

    /**
     * 修改资源前置方法
     */
    public function before_edit($input)
    {
        $input['mtime'] = time(); 
        return $input;
    }

    /**
     * 处理列表输出数据
     */
    public function ls_format()
    {
        foreach($this->list_data as $k => $v) {

            if(isset($v->ctime) && $v->ctime) {
                $this->list_data[$k]->ctime = date('Y-m-d H:i:s', $v->ctime);
            } else {
                $this->list_data[$k]->ctime = '暂无时间';
            }

            if(isset($v->mtime) && $v->mtime) {
                $this->list_data[$k]->mtime = date('Y-m-d H:i:s', $v->mtime);
            } else {
                $this->list_data[$k]->mtime = '暂无时间';
            }

        }
        // end foreach
    }
    // end method

    /**
     * 处理编辑输出数据
     */
    public function edit_format()
    {

    }

    /**
     * 批量删除资源前置方法
     */
    public function before_betch_destroy()
    {

    }

    /**
     * 删除资源前置方法
     */
    public function before_delete()
    {

    }

}