<?php
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/10/11
 * Time: 15:30
 */
    class Admin_Index_module extends CI_Module{
        public function __construct()
        {
            parent::__construct();
            $this->load->model('admin.Adminuser_model');
            $this->load->model('admin.Adminrole_model');
        }

        /**
         * 后台首页
         */
        public function index(){
            p("登录成功");
        }

        /**
         * 后台登录页
         */
        public function login(){
            $data['login_url'] = site_url('admin/index/tologin');
//            $this->error("用户名或者密码错误，登陆失败！",site_url(''), 10);
            $this->load->view('index/login',$data);
        }

        /**
         * 登录方法
         */
        public function tologin(){
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if ( ! $username || ! $password){
                $this->error("用户名或密码不能为空",site_url(''), 3);
            }
            $user_row = $this->Adminuser_model->login(['username'=>$username,'password'=>$password]);
            if ($user_row){
                //获取用户角色信息
                $role_info = $this->Adminrole_model->get_role_row(['id'=>$user_row['role_id']]);
                if (empty($role_info) || $role_info['status'] == 0){
                    $this->error("您所属的角色不存在或已禁用",site_url(''), 3);
                }
                if (trim($role_info['name']) == "超级管理员"){
                    $accessList = 'ALL';
                }else{
                    //查询角色所有权限
                    $access = $this->Adminrole_model->get_role_access(['role_id'=>$user_row['role_id']]);
                    $access_list = [];
                    foreach ($access as $key=>$val){
                        $access_list[] = $val['app'].'/'.$val['controller'].'/'.$val['action'];
                    }
                    $access_list = implode(',',$access_list);
//                    p($access_list);
                    //更新登录信息
                    $update_data = array(
                        'last_login_time' => date('Y-m-d H:i:s',time()),
                        'last_login_ip' => get_client_ip(),
                    );
                    //写入session
                    $newdata = array(
                        'admin_user_id' => $user_row['id'],
                        'admin_user_name' => $user_row['name'],
                        'admin_realname' => $user_row['realname'],
                        'admin_role_id' => $user_row['role_id'],
                        'adminid' => $user_row['id'],
                        'authority' => $user_row['authority'],
                        'last_login_time' => $user_row['last_login_time'],
                        'is_open' => $user_row['is_open'],
                        '_ACCESS_LIST' => $access_list
                    );
                    $this->Adminuser_model->edit_row(['id'=>$user_row['id']],$update_data);
                    $this->session->set_userdata($newdata);
                    redirect(site_url('admin/index/index'));
                }

            }else{
                $this->error("用户名或者密码错误，登陆失败！",site_url('admin/index/login'), 3);
            }
        }
    }