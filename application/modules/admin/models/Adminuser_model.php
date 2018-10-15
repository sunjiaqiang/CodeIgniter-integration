<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/10/11
 * Time: 16:37
 */
class Admin_Adminuser_model extends CI_Model{
    private $table_admin_user;//后台用户表
    private $table_role;//角色表
    public function __construct()
    {
        parent::__construct();
        $this->table_admin_user = 'cs_admin_user';
        $this->table_role = 'cs_admin_role';
    }

    /**
     * 登录后台
     * @param array $data
     */
    public function login(array $data = []){
        $user_row = $this->get_row(['name'=>$data['username'],'password'=>md5($data['password']),'is_open'=>1]);
        return $user_row;
    }

    /**
     * 获取单条用户信息
     * @param array $where
     * @param string $field
     */
    public function get_row($where = [],$field='*'){
        $this->db->select($field);
        $query = $this->db->get_where($this->table_admin_user,$where,1);
        return $query ? $query->row_array() : [];
    }

    /**
     * 修改一条用户数据
     * @param array $where
     * @param array $data
     */
    public function edit_row($where = [],$data=[]){
        $this->db->where($where, NULL, FALSE);
        return $this->db->update($this->table_admin_user,$data);
    }
    /**
     * 获取总数量
     * @param array $where 查询条件
     */
    public function get_count($where=array()){
        $this->db->where($where, NULL, FALSE);
        $this->db->select('id');
        $this->db->from($this->table_admin_user);
        return $this->db->count_all_results();
    }
    /**
     * 获取所有管理管理员
     * @param int $page_size 每页显示数量
     * @param int $now_page 第几页
     * @param $where 选择条件
     * @return array
     */
    public function get_list($page_size=20,$now_page=1,$where){
        $table = $this->table_admin_user;
        $this->db->select($table.'.*');
        //$this->db->select($this->table_division.'.name as division_name');
//		$where[$table.'.sid'] = $GLOBALS['sid'];
        if(!empty($where))$this->db->where($where, NULL, FALSE);
        $this->db->select($this->table_role.'.name as role_name');
        $this->db->join($this->table_role, $this->table_role.".id=$table.role_id");
        //$this->db->join($this->table_division,$this->table_division.".id=$table.division_id");
        $query = $this->db->get($table,$page_size,($now_page-1)*$page_size);
        $data = [];
        foreach($query->result_array() as $row){
            $row['remove_url'] = site_url('admin/adminuser/ajax_remove?id='.$row['id']);
            $row['edit_url'] = site_url('admin/adminuser/edit?id='.$row['id']);
            $row['auth_url']   =  site_url('admin/adminuser/division_auth?id='.$row['id']);
            $row['division_name'] = '总部';
            $data[] = $row;
        }
        return $data;
    }

    /**
     * 新增数据
     * @param array $data
     */
    public function add_row($data = []){
        $result = $this->db->insert($this->table_admin_user,$data);
        if (false !== $result){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 删除用户
     * @param array $where
     */
    public function remove_row($where=[]){
        if ( ! empty($where) && is_array($where)){
            return $this->db->delete($this->table_admin_user,$where);
        }elseif(is_string($where)){
            $this->db->where($where,null,false);
            return $this->db->delete($this->table_admin_user);
        }
        return false;
    }
}