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
}