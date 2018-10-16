<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/10/15
 * Time: 15:55
 */
class Buyer_Role_module extends CI_Module{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin.Adminuser_model');
        $this->load->model('admin.Adminrole_model');
        $this->load->model('admin.Menu_model');
    }

    /**
     * 角色列表
     */
    public function index(){
        $where = "sid=100002";
        $page_config['per_page']=20;   //每页条数
        $page_config['num_links']=2;//当前页前后链接数量
        $page_config['base_url']=site_url('buyer/role/index');//url
        $page_config['param'] = '';//参数
        $page_config['seg']=4;//参数取 index.php之后的段数，默认为3，即index.php/control/function/18 这种形式
        $page_config['cur_page']=$this->uri->segment($page_config['seg']) ? $this->uri->segment($page_config['seg']):1;//当前页
        $page_config['total_rows'] = $this->Adminrole_model->get_count($where);
        $this->load->library('Mypage',$page_config);
        $result = $this->Adminrole_model->get_list($page_config['per_page'],$page_config['cur_page'],$where);
        $data['list'] = $result;
        $this->load->view('buyer/adminrole_index',$data);
    }

    /**
     * 添加角色
     */
    public function add(){
        //数据保存URL
        $data['form_post'] = site_url('buyer/role/save');
        $data['ajax_check_name'] = site_url('buyer/role/ajax_check_name?id=0');
        $this->load->view('buyer/adminrole_add',$data);
    }

    /**
     * 角色编辑
     */
    public function edit(){
        $id = $this->input->get('id');
        $row = $this->Adminrole_model->get_row(['id'=>$id]);
        $data['row'] = $row;

        //数据保存URL
        $data['form_post'] = site_url('buyer/role/save');
        $data['ajax_check_name'] = site_url("buyer/role/ajax_check_name?id=$id");
        $this->load->view('buyer/adminrole_edit',$data);
    }
    /**
     * 保存角色信息
     */
    public function save(){
        $data = $this->input->post('Form');
        $data['sid'] = 100002;
        $id = $this->input->post('id');
        if ($id){
            //修改数据
            $data['edit_time'] = date('Y-m-d H:i:s',time());
            $res = $this->Adminrole_model->edit_row($data,['id'=>$id]);
        }else{
            //新增数据
            $data['add_time'] = date('Y-m-d H:i:s',time());
            $res = $this->Adminrole_model->add_row($data);
        }
        if($res){
            $this->success('保存成功',site_url('buyer/role/index'),true);
        }else{
            $this->error('保存失败',site_url('buyer/role/index'),true);
        }
    }

    /**
     * 修改状态信息
     */
    public function ajax_status(){
        $post = $this->input->post();
        $data[$post['field']] = $post['val'];
        $res = $this->Adminrole_model->edit_row($data,['id'=>$post['id']]);
        if($res){
            //操作日志
            $this->success('操作成功','',true);
        }else{
            $this->error('操作失败','',true);
        }
    }
    /**
     * 判断管理员角色的名称是否存在
     */
    public function ajax_check_name(){
        $arg_get = $this->input->get();
        $row = $this->Adminrole_model->get_row(['name'=>$arg_get['Form']['name'],'id !='=>$arg_get['id'],'sid'=>100002]);
        if(!empty($row) && is_array($row)){
            $this->ajaxReturn('此管理员角色名称已存在!');
        }else{
            $this->ajaxReturn(true);
        }
    }

    /**
     * 角色授权
     */
    public function set_authority(){
        $role_id = $this->input->get('id');
        if(empty($role_id)){
            $this->error('需要授权的角色不存在!',site_url('buyer/role/index'),1);
        }
        //菜单数据
        $result = $this->Menu_model->get_list('pingtai=2 AND status=1');
        //获取此角色的权限
        $priv_data = $this->Adminrole_model->get_access_list('role_id='.$role_id);
        $access_arr=[];
        if ($priv_data){
            foreach ($priv_data as $key=>$val){
                $access_arr[]=$val['app'].'/'.$val['controller'].'/'.$val['action'];
            }
        }
//        p($access_arr);
        foreach ($result as $rs) {
            $url = $rs['app'].'/'.$rs['controller'].'/'.$rs['action'];
            $data = [
                'id' => $rs['id'],
                'parent_id' => $rs['parent_id'],
                'name' => $rs['name'] . ($rs['type'] == 0 ? "(菜单项)" : ""),
                'checked' => (in_array($url,$access_arr)) ? true : false,//判断此菜单是否已授权
                'open' => true,
            ];
            $json[] = $data;
        }

        $data['json'] = json_encode($json);
        $data['role_id'] = $role_id;
        $data['form_post'] = site_url('buyer/role/save_authority');
        $this->load->view('buyer/adminrole_authority',$data);
    }

    /**
     * 保存权限
     */
    public function save_authority(){
        $arg_post = $this->input->post();
        $role_id = $arg_post['role_id'];
        if(empty($arg_post['menu_id'])){
            $this->error('请至少选择一个权限！','',true);
        }
        $menuidAll = explode(',', $arg_post['menu_id']);
        if (is_array($menuidAll) && count($menuidAll) > 0) {
            //菜单数据
            $menu_info = $this->Menu_model->get_list(['pingtai'=>2]);
            $menu_info = array_column($menu_info,null,'id');
            $addauthorize = [];
            //检测数据合法性
            foreach ($menuidAll as $menuid) {
                if (empty($menu_info[$menuid])) {
                    continue;
                }
                $info = [
                    'app' => $menu_info[$menuid]['app'],
                    'controller' => $menu_info[$menuid]['controller'],
                    'action' => $menu_info[$menuid]['action'],
                ];
                $info['role_id'] = $role_id;
                $info['sid'] = 100002;
                $addauthorize[] = $info;
            }

            //添加新权限
            $res = $this->Adminrole_model->add_role_access($role_id,$addauthorize);
            if($res){
                $this->success('授权成功！',site_url('buyer/role/index'),true);
            }else{
                $this->error('授权失败！',site_url('buyer/role/index'),true);
            }
        }else{
            $this->error("没有接收到数据，执行清除授权成功！",site_url('admin/adminrole/index'),true);
        }
    }
}