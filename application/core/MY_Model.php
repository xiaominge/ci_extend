<?php

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * 自定义模型基类
 * @author 徐亚坤 http://www.jxwen.com/
 */

class MY_Model extends CI_Model
{

    const parameter_error = 1;

    public $error_msg = '';

    /**
     * 数据库表名称
     * @var string
     */
    protected $table = '';

    protected $observers = array();
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        if($this instanceof SplSubject) {
            $observer = new observer('m');
            $this->attach($observer);
        }
    }

    /**
     * 设置查询
     * 
     */
    public function make_sql($field = '*', $where = null, $orderby = null, $limit = null)
    {
        if(is_array($field)) {
            $field = implode(',', $field);
        }

        $this->db->select($field);

        $this->db->from($this->table);

        if($where) {
            if(is_string($where)) {
                $this->db->where($where, NULL, false);
            } elseif(is_array($where)) {
                $this->db->where($where);
            }
        }

        if($orderby) {
            if(is_string($orderby)) {
                $this->db->order_by($orderby);
            } elseif(is_array($orderby)) {
                foreach($orderby as $k => $v) {
                    $this->db->order_by($k, $v);
                }
            }
        }

        if($limit) {
            $this->db->limit($limit);
        }
    }

    /**
     * 获取查询结果
     * 
     */
    public function get_result($method = 'result', $type = 'object')
    {
        if(!in_array($type, array('object', 'array')) || !in_array($method, array('result', 'row'))) {
            return $this->error(1);
        }
        $query = $this->db->get();
        $query_method = $method.'_'.$type;
        return $query->$query_method();
    }

    /**
     * 获取多条记录
     * @param mixed 需要获取的字段，索引数组或字符串
     * @param mixed 查询条件，关联数组或字符串
     * @param mixed 排序规则，关联数组或字符串
     * @param mixed 结果集条数限制，数字或字符串
     * @param string 结果集数据格式，值为(object 或 array)
     * @return array 多维数组
     */
    public function select($field = '*', $where = null, $orderby = null, $limit = null, $type = 'object')
    {
        $this->make_sql($field, $where, $orderby, $limit);
        
        $data = $this->get_result('result', $type);

        $this->explain();

        return $data;
    }

    /**
     * 关联查询
     */
    public function select_join($field = '*', $table = null, $where = null, $orderby = null, $limit = null, $type = 'object')
    {
        if($table) {
            $this->table = $table;
        }

        $this->make_sql($field, $where, $orderby, $limit);
        
        $data = $this->get_result('result', $type);

        $this->explain();

        return $data;
    }

    /**
     * 获取一条记录
     */
    public function get($field = '*', $where = null, $orderby = null, $type = 'object')
    {
        $this->make_sql($field, $where, $orderby, 1);
        
        $info = $this->get_result('row', $type);

        $this->explain();

        return $info;
    }

    /**
     * 获取 explain sql 信息
     */
    public function explain()
    {
        $explain = array();

        $sql = $this->db->last_query();
        
        $query = $this->db->query('EXPLAIN '.$sql);

        $explain = $query->row();
        
        console(array('sql' => $sql, 'explain' => $explain));
    }

    /**
     * 获取记录数
     */
    public function count($where = null)
    {
        $data = $this->get('count(*) AS num', $where);
        return $data->num;
    }

    /**
     * 判断记录是否存在
     */
    public function exists($field, $value, $where = null)
    {
        $this->make_sql($field, $where);

        $this->db->where("$field='$value'", null, false);

        $query = $this->db->get();

        return $query->num_rows() > 0 ? true : false;
    }

    /**
     * 添加
     */
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * 批量添加
     */
    public function insert_batch($data)
    {
        $this->db->insert_batch($this->table, $data);
        return true;
    }

    /**
     * 修改
     */
    public function update($data, $where)
    {
        if(is_numeric($where)) {
            $where = array('id' => $where);
        }

        $this->db->update($this->table, $data, $where);

        return true;
    }

    /**
     * 删除
     */
    public function delete($where)
    {
        if(is_numeric($where)) {
            $where = array('id' => $where);
        }

        if(!$where) {
            return $this->error(1);
        }

        $this->db->delete($this->table, $where);

        return true;
    }

    /**
     * 错误信息
     */
    private function error($error_code = null)
    {
        switch($error_code) {
            case self::parameter_error:
                $this->error_msg = '参数错误';
                break;
            default:
                $this->error_msg = '未知错误';
                break;
        }

        return array('code' => $error_code, 'msg' => $this->error_msg);
    }

    public function attach(SplObserver $observer)
    {
        $this->observers[] = $observer;
    }

    public function detach(SplObserver $observer)
    {
        if($index = array_search($observer, $this->observers, true)) {
            unset($this->observers[$index]);
        }  
    }

    public function notify($args = '')
    {
        foreach($this->observers as $observer) {
            $observer->update($this, $args);
        }
    }
}
