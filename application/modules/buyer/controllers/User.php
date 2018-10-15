<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/14 0014
 * Time: 15:20
 */
class Buyer_User_module extends CI_Module{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin.Adminuser_model');
        $this->load->model('admin.Adminrole_model');
    }

    /**
     * 用户列表
     */
    public function index(){
        $table_user = 'cs_admin_user';
        $where = "$table_user.sid=100002";
        $page_config['per_page']=10;   //每页条数
        $page_config['num_links']=2;//当前页前后链接数量
        $page_config['base_url']=site_url('buyer/user/index');//url
        $page_config['param'] = '';//参数
        $page_config['seg']=4;//参数取 index.php之后的段数，默认为3，即index.php/control/function/18 这种形式
        $page_config['cur_page']=$this->uri->segment($page_config['seg']) ? $this->uri->segment($page_config['seg']):1;//当前页
        $page_config['total_rows'] = $this->Adminuser_model->get_count($where);
        $this->load->library('Mypage',$page_config);
        $result = $this->Adminuser_model->get_list($page_config['per_page'],$page_config['cur_page'],$where);
        $role_list = $this->Adminrole_model->get_usable_list();
        $data['list'] = $result;
        $data['role_list'] = $role_list;
        $data['index_url'] = site_url('buyer/user');
        $data["title"] = '用户管理';
        $this->load->view('buyer/user',$data);
    }

    /**
     * 增加|修改用户
     */
    public function edit(){
        if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
        {
            $data = $this->input->post('Form');
            $id = $this->input->post('id');
            if ($id){
                //修改
                $adminuser = array(
                    'realname' => $data['realname'],
                    'email' => $data['email'],
                    'is_open' => $data['is_open'],
                    'role_id' => $data['role_id'],
                    'sid' => 100002,
                    'avatar'=>$data['avatar'],
                    'qq'=>$data['qq'],
                    'gender'=>$data['gender']
                );
                if ($data['password']){
                    $adminuser['password'] = md5($data['password']);
                }
                $result = $this->Adminuser_model->edit_row(['id'=>$id],$adminuser);
            }else{
                //新增
                $adminuser = array(
                    'name' => $data['name'],
                    'realname' => $data['realname'],
                    'email' => $data['email'],
                    'password' => md5($data['password']),
                    'is_open' => $data['is_open'],
                    'role_id' => $data['role_id'],
                    'sid' => 100002,
                    'avatar'=>$data['avatar'],
                    'qq'=>$data['qq'],
                    'gender'=>$data['gender']
                );
                $adminuser['add_time'] = date('Y-m-d H:i:s',time());
                $result = $this->Adminuser_model->add_row($adminuser);
            }

            $returl =  site_url('buyer/user');
            if ($result){
                $this->success('保存成功！', $returl, true);
            }else{
                $this->error("保存失败！",$returl,true);
            }
        }
        $arr = [];
        $id = $this->input->get('id');
        $arr['ajax_check_name'] = site_url("buyer/user/ajax_check_name?id=0");
        if ($id){
            $arr['info'] = $this->Adminuser_model->get_row(['id'=>$id]);
        }else{
            $arr['info'] = [];
        }
        $role_list = $this->Adminrole_model->get_usable_list();
        $arr['role_list'] = $role_list;
        $this->load->view('buyer/user_edit',$arr);
    }

    /**
     * 异步验证用户名是否存在
     */
    public function ajax_check_name(){
        $arg_get = $this->input->get();
        $username = $arg_get['Form']['name'];
        $row = $this->Adminuser_model->get_row(['name' => addslashes($username), 'id !=' => intval($arg_get['id'])], '*');
        if (!empty($row) && is_array($row)) {
            $this->ajaxReturn('此用户名已存在!');
        } else {
            $this->ajaxReturn(true);
        }
    }

    /**
     * 异步删除用户
     */
    public function ajax_remove(){
        $id = $this->input->get('id');
        $result = $this->Adminuser_model->remove_row(['id'=>$id]);
        $returl =  site_url('buyer/user');
        if ($result) {
            $this->success('操作成功', $returl, true);
        } else {
            $this->error('操作失败', '', true);
        }
    }
}