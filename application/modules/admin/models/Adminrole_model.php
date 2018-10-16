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
    /**
     * 获取可用角色列表
     */
    public function get_usable_list(){
        $where = ['status'=>1,'sid'=>100002];
        $this->db->where($where);
        $this->db->select('id,name');
        $query = $this->db->get($this->table_role);
        return $query->result_array();
    }

    /**
     * 获取角色总条数
     * @param string $where
     */
    public function get_count($where=''){
        $sql = "SELECT COUNT(1) nums FROM $this->table_role";
        $where ? $sql.=" WHERE $where" : '';
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['nums'];
    }
    /**
     * 获取所有管理管理员角色
     * @param int $page_size 每页显示数量
     * @param int $now_page 第几页
     * @param $where 选择条件
     * @return array
     */
    public function get_list($page_size=20,$cur_page=1,$where=''){
        $sql = "SELECT id,name,status,remark,add_time,edit_time FROM $this->table_role";
        $where ? $sql .= " WHERE $where" : '';
        $sql .= " ORDER BY id ASC LIMIT ?,?";
        $query = $this->db->query($sql,[($cur_page-1)*$page_size,$page_size]);
        $result = $query->result_array();
        $data = array();
        foreach($result as $row){
            $row['remove_url'] = site_url('buyer/role/ajax_remove?id='.$row['id']);
            $row['edit_url'] = site_url('buyer/role/edit?id='.$row['id']);
            $row['author_url'] = site_url('buyer/role/set_authority?id='.$row['id']);
            $data[] = $row;
        }
        return $data;
    }

    /**
     * 修改角色信息
     * @param array $data
     * @param string $where
     */
    public function edit_row($data=[],$where=''){
        $this->db->where($where,null,false);
        return $this->db->update($this->table_role,$data);
    }

    /**
     * 新增数据
     * @param array $data
     */
    public function add_row($data=[]){
        $result = $this->db->insert($this->table_role,$data);
        if (false !== $result){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    /**
     * 获取单条记录
     * @param array $where 查询条件
     * @param string $field
     * @return mixed
     */
    public function get_row($where=[],$field='*'){
        if(!empty($field))$this->db->select($field);
        $query = $this->db->get_where($this->table_role,$where,1);
        return $query->row_array();
    }

    /**
     * 根据条件获取角色权限
     * @param string $where
     */
    public function get_access_list($where=''){
        $sql = "SELECT role_id,app,controller,action FROM $this->table_role_access";
        $where ? $sql .= " WHERE $where" : '';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    /**
     * 添加多条数据
     * @param int $role_id 角色ID
     * @param $data
     */
    public function add_role_access($role_id,$data){
        //删除旧的数据
        $this->db->where(['role_id'=>$role_id],null,false);
        $this->db->delete($this->table_role_access);
        //添加信息的数据
        return $this->db->insert_batch($this->table_role_access,$data);
    }
}