<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/10/12
 * Time: 10:55
 */
class Admin_Menu_model extends CI_Model{
    private $table_menu;//后台菜单表
    public function __construct()
    {
        parent::__construct();
        $this->table_menu = 'cs_admin_menu';
    }

    /**
     * 获取权限菜单
     * @param string $where
     */
    public function get_left_menu($where = []){
        $_ACCESS_LIST = $this->session->userdata('_ACCESS_LIST');//用户登录时保存在session中的权限
        $menu_list = $this->get_list($where);
        if ($_ACCESS_LIST && $_ACCESS_LIST != 'ALL'){
            //删除不在权限内的菜单
            $_ACCESS_LIST = explode(',',$_ACCESS_LIST);
            foreach ($menu_list as $key=>$val){
                $action = $val['app'].'/'.$val['controller'].'/'.$val['action'];
                if ( ! in_array($action,$_ACCESS_LIST)){
                    unset($menu_list[$key]);
                }
            }
        }
        $data = [];
        foreach ($menu_list as $key=>$val){
            if ($val['parent_id'] == 0){
                $data[$key] = $val;
                $data[$key]['child'] = [];
                unset($menu_list[$key]);
                foreach ($menu_list as $k1=>$v1){
                    if ($v1['parent_id'] == $val['id']){
                        $data[$key]['child'][$k1] = $v1;
                        $data[$key]['child'][$k1]['child'] = [];
                        unset($menu_list[$k1]);
                        foreach ($menu_list as $k2=>$v2){
                            if ($v2['parent_id'] == $v1['id']){
                                $data[$key]['child'][$k1]['child'][] = $v2;
                                unset($menu_list[$k2]);
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    /**
     * 递归处理菜单数据和上面方法中的foreach是一样效果，可以使用这个也可以直接使用上面的foreach操作
     * @param $data
     * @param int $parent_id
     * @param int $level
     * @return array
     */
    public function handle_menu($data,$parent_id=0,$level=1){
        $arr = [];
        foreach ($data as $key=>$val){
            if ($val['parent_id'] == $parent_id){
                $val['level'] = $level;
                $child = $this->handle_menu($data,$val['id'],$level+1);
                if ($child && $level<4){
                    $val['child'] = $child;
                }
                $arr[] = $val;
            }

        }
        return $arr;
    }

    /**
     * 获取所有菜单
     * @param array $where
     */
    public function get_list($where = []){
        $this->db->select('id,parent_id,name,sort_order,status,app,controller,action,parameter,type');
        $this->db->where($where,null,false);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get($this->table_menu);
        $result = $query->result_array();
        $arr = [];
        foreach ($result as $key=>$val){
            $val['url'] = site_url($val['app'].'/'.$val['controller'].'/'.$val['action'].($val['parameter'] ? '?'.$val['parameter'] : ''));
            $arr[] = $val;
        }
        return $arr;
    }
    /**
     * 获取单条记录
     * @param array $where
     * @param string $field
     * @return mixed
     */
    public function get_row($where=[],$field='*'){
        if(!empty($field))$this->db->select($field);
        $query = $this->db->get_where($this->table_menu,$where,1);
        return $query->row_array();
    }
    /**
     * 添加数据
     * @param $data
     * @return bool
     */
    public function add_row($data=[]){
        if($this->db->insert($this->table_menu,$data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    /**
     * 更新数据
     * @param array $where
     * @param array $data
     */
    public function edit_row($where=[],$data=[]){
        $this->db->where($where,null,false);
        return $this->db->update($this->table_menu,$data);
    }
    /**
     * 查询该分类是否有子分类
     * @param $parent_id
     * @return bool
     */
    public function is_has_child($parent_id){
        $this->db->select('id');
        $query = $this->db->get_where($this->table_menu,['parent_id'=>$parent_id],1);
        $row = $query->row_array();
        if(isset($row['id'])&&$row['id']){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 删除数据
     * @param array $where
     * @return bool
     */
    public function remove_row($where=[]){
        if(!empty($where)){
            return $this->db->delete($this->table,$where);
        }
        return false;
    }
}