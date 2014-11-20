<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 资源模型基类
 * @author 徐亚坤 http://www.jxwen.com/
 */

class R_Model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 计数
    */
    public function r_count($get)
    {
        $where = $this->r_where($get);
        if(array_filter($where)) {
            $where = implode(' AND ', array_filter($where));
            $query = $this->db->query("SELECT count(*) AS num FROM {$this->table} WHERE $where");
        } else {
            $query = $this->db->query("SELECT count(*) AS num FROM {$this->table}");
        }

        $data = $query->row_array();
        return $data['num'];
    }

    /*
     * 列表
    */
    public function r_ls($get, $limit, $order = 'id DESC')
    {
        $where = $this->r_where($get);
        if(array_filter($where)) {
            $where = implode(' AND ', array_filter($where));
            $query = $this->db->query("SELECT * FROM {$this->table} WHERE $where ORDER BY $order LIMIT $limit");
        } else {
            
            $query = $this->db->query("SELECT * FROM {$this->table} ORDER BY $order LIMIT $limit");
        }

        $data = $query->result();

        $this->explain();
        
        return $data;
    }

    /*
     * 获取查询条件
    */
    public function r_where($get)
    {
        $where = array();

        if(isset($get['name']) && trim($get['name'])) {
            $where['name'] = "`name` LIKE '%".trim($get['name'])."%'";
        }
        if(isset($get['status']) && trim($get['status'])) {
            $where['status'] = "`status` = '".trim($get['status'])."'";
        }

        return $where;
    }
}