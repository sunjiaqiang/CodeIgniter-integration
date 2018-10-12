<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/10/11
 * Time: 16:59
 */
class Admin_Adminrole_model extends CI_Model{
    private $table_role;//角色表
    private $table_role_access;//角色权限表
    public function __construct()
    {
        parent::__construct();
        $this->table_role = 'cs_admin_role';
        $this->table_role_access = 'cs_admin_role_authors';
    }

    /**
     * 获取一条角色信息
     * @param array $where
     */
    public function get_role_row($where = [],$field='*'){
        $this->db->select($field);
        $query = $this->db->get_where($this->table_role,$where,1);
        return $query->row_array();
    }

    /**
     * 获取角色的权限
     * @param array $where
     */
    public function get_role_access($where = []){
        $this->db->select('role_id,app,controller,action');
        $query = $this->db->get_where($this->table_role_access,$where);
        $result = $query->result_array();
        return $result;
    }
}