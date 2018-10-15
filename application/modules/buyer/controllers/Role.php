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
}