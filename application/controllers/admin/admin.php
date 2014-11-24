<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 管理员控制器
 * @author 徐亚坤
 */

import('class.resource_controller');

class Admin extends R_Controller implements SplSubject
{

    public function __construct()
    {
        $this->model = 'm_admin_admin';
        $this->resource = 'admin';
        $this->resourceName = '管理员';

        parent::__construct();

        $method = $this->router->fetch_method();
        if($method == 'add') {
            $this->validator = array(
                array(
                    'field'   => 'name',
                    'label'   => '名称',
                    'rules'   => 'required',
                ),
                array(
                    'field'   => 'pwd',
                    'label'   => '密码',
                    'rules'   => 'required',
                ),
            );
        } else {
            $this->validator = array(
                array(
                    'field'   => 'name',
                    'label'   => '名称',
                    'rules'   => 'required',
                ),
            );
        }
    }

    /**
     * 修改密码
     */
    public function changepwd()
    {
        $this->load->model("admin/{$this->model}");
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        $this->form_validation->set_rules('old_pass', "旧密码", 'required');
        $this->form_validation->set_rules('new_pass', "新密码", 'required|min_length[6]|max_length[16]');
        $this->form_validation->set_rules('new_pass_confirm', "确认新密码", 'required|min_length[6]|max_length[16]|matches[new_pass]');
        if($this->form_validation->run() == FALSE) {
            $this->load->view('admin/'.$this->resource.'/password');
        } else {
            $uid = $_SESSION[$this->config->item('admin_auth_key')]["info"]["id"];
            $stored = $this->{$this->model}->get_user_by_uid($uid);
            if($stored) {
                $old_pass = password(trim($this->input->post('old_pass')), $stored->encrypt);
                if($old_pass == $stored->pwd) {
                    $this->{$this->model}->update_user_password_by_uid($uid);
                    success_redirct("/admin/{$this->resource}/changepwd", "密码更新成功!");
                } else {
                    error_redirct("/admin/{$this->resource}/changepwd", "旧密码验证失败!");
                }
            } else {
                error_redirct("/admin/{$this->resource}/changepwd", "用户信息丢失!");
            }
        }
    }
    // end method

    /**
     * 添加资源前置方法
     */
    public function before_add($input)
    {
        $input['ctime'] = time(); 
        $input['mtime'] = time();
        $this->load->helper('string');
        $input['encrypt'] = random_string();
        $input['pwd'] = password($input['pwd'], $input['encrypt']);

        $exists = $this->{$this->model}->exists('name', $input['name']);
        if($exists) {
            error_redirct("/admin/{$this->resource}/add", "用户名已被占用!");
        }
        return $input;
    }

    /**
     * 修改资源前置方法
     */
    public function before_edit($input)
    {
        $input['mtime'] = time();
        if(isset($input['pwd']) && $input['pwd']) {
            $uid = $_SESSION[$this->config->item('admin_auth_key')]["info"]["id"];
            $stored = $this->{$this->model}->get_user_by_uid($uid);
            $input['pwd'] = password($input['pwd'], $stored->encrypt);
        } elseif(isset($input['pwd'])) {
            unset($input['pwd']);
        }
        
        return $input;
    }

    /**
     * 批量删除资源前置方法
     */
    public function before_betch_destroy($ids)
    {
        $uid = $_SESSION[$this->config->item('admin_auth_key')]["info"]["id"];
        if(in_array($uid, $ids)) {
            error_redirct("/admin/{$this->resource}/index", "不要删除自己哦!");
        }
    }

    /**
     * 删除资源前置方法
     */
    public function before_delete($id)
    {
        $uid = $_SESSION[$this->config->item('admin_auth_key')]["info"]["id"];
        if($id == $uid) {
            error_redirct("/admin/{$this->resource}/index", "不要删除自己哦!");
        }
    }
    // end method
}
// end class

/* End of file admin.php */
/* Location: ./application/controllers/admin/admin.php */