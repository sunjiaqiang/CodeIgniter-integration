<?php
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/10/11
 * Time: 16:37
 */
class Admin_Adminuser_model extends CI_Model{
    private $table_admin_user;//后台用户表
    public function __construct()
    {
        parent::__construct();
        $this->table_admin_user = 'cs_admin_user';
    }

    /**
     * 登录后台
     * @param array $data
     */
    public function login(array $data = []){
        $user_row = $this->get_row(['name'=>$data['username'],'password'=>md5($data['password'])]);
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
}