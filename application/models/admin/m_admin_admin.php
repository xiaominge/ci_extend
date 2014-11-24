<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 管理员模型
 * @author 徐亚坤
 */

import('class.resource_model');

class M_admin_admin extends R_Model implements SplSubject
{
    
    public function __construct()
    {
        $this->directory = 'admin';
        $this->table = 'admin';
        $this->_primary = 'id';
        parent::__construct();
    }
    
    /*
     * 用户登录检测
    */
    public function check_user($username, $password)
    {
        $query = $this->db->query("SELECT id,pwd,encrypt,name,email,status,roleid FROM `admin` WHERE name = '".$username."' LIMIT 1");
        $data  = $query->row_array();
        if($data) {
            if($data['status'] == 1) {
                $password = password($password, $data['encrypt']);
                if($data['pwd'] == $password) {
                    $_SESSION[$this->config->item('admin_auth_key')]["info"]["id"]    = $data['id'];
                    $_SESSION[$this->config->item('admin_auth_key')]["info"]["name"]  = $data['name'];
                    $_SESSION[$this->config->item('admin_auth_key')]["info"]["email"] = $data['email'];
                    $_SESSION[$this->config->item('admin_auth_key')]["info"]["roleid"] = $data['roleid'];
                    return TRUE;
                } else {
                    return "用户密码错误！";
                }
            } else {
                return "该用户已禁用！";
            }
        } else {
            return "该用户不存在！";
        }
    }
    
    /*
     * 用户登录检测 By id
    */
    public function check_user_by_id($id)
    {
        $query = $this->db->query("SELECT id,pwd,name,email,status,roleid FROM `admin` WHERE id = '".$id."' LIMIT 1");
        $data = $query->row_array();
        if($data) {
            if($data['status'] == 1) {
                $_SESSION[$this->config->item('admin_auth_key')]["info"]["id"]    = $data['id'];
                $_SESSION[$this->config->item('admin_auth_key')]["info"]["name"]  = $data['name'];
                $_SESSION[$this->config->item('admin_auth_key')]["info"]["email"] = $data['email'];
                $_SESSION[$this->config->item('admin_auth_key')]["info"]["roleid"] = $data['roleid'];
                return TRUE;
            } else {
                return "该用户已禁用！";
            }
        } else {
            return "该用户不存在！";
        }
    }

    /**
     * 根据用户ID获取用户信息
     *
     * @access  public
     * @param   int
     * @return  object
     */
    public function get_user_by_uid($uid = 0)
    {
        return $this->db->where('id', $uid)->get('admin')->row();
    }

    /**
     * 修改用户自己密码
     *
     * @access  public
     * @return  bool
     */
    public function update_user_password_by_uid($uid)
    {
        $user = $this->get_user_by_uid($uid);
        $data['pwd'] = $this->input->post('new_pass');
        $data['pwd'] = password($data['pwd'], $user->encrypt);
        return $this->db->where('id', $uid)->update('admin', $data);      
    }
    
    public function r_where($get)
    {
        $where = array();

        if(isset($get['name']) && trim($get['name'])) {
            $where['name'] = "`name` LIKE '%".trim($get['name'])."%'";
        }
        if(isset($get['status']) && trim($get['status'])) {
            $where['status'] = "`status` = '".trim($get['status'])."'";
        }
        if(isset($get['roleid']) && trim($get['roleid'])) {
            $where['roleid'] = "`roleid` = '".trim($get['roleid'])."'";
        }

        return $where;
    }
}
