<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
            $this->load->model('admin.Menu_model');
        }

        /**
         * 后台首页
         * 因为使用的是iframe所以菜单在这里获取就可以
         */
        public function index(){
            //检测是否已登录
            $this->Adminuser_model->is_login();
//            p("登录成功");
//            p($this->session->userdata());
            $where = ['pingtai'=>2];
            //获取权限菜单
            $left_menu = $this->Menu_model->get_left_menu($where);
            $left_menu = array_values($left_menu);
            $left_menu = $left_menu[0]['child'];
            foreach ($left_menu as $key=>$val){
                $val['parent_id'] = 0;
                $left_menu[$key] = $val;
            }
//            p($left_menu);
            $json_menu = [];
            $i = 1;
            foreach ($left_menu as $key=>$val){
                $real_id = $val['id'];
                $val['id'] = $i;
                $key_index = $i;
                $json_menu[$key_index] = $val;
                $json_menu[$key_index]['parent_id'] = 0;
                $json_menu[$key_index]['real_id'] = $real_id;
                $i +=3;//这里的+3看你自己决定了
                foreach ($val['child'] as $k1=>$v1){
                    unset($json_menu[$key_index]['child'][$k1]);//这里为什么要这样呢，因为上层的$val中的child包含所有的值，不删除会出现重复值
                    $i+=3;
                    $sub1 = $i;
                    $json_menu[$key_index]['child'][$i] = $v1;
                    $json_menu[$key_index]['child'][$i]['id'] = $i;
                    $json_menu[$key_index]['child'][$i]['parent_id'] = $key_index;
                    $json_menu[$key_index]['child'][$i]['real_id'] = $v1['id'];
                    if (isset($v1['child']) && !empty($v1['child'])){
                        foreach ($v1['child'] as $k2=>$v2){
                            unset($json_menu[$key_index]['child'][$sub1]['child'][$k2]); //此操作和上面的是一致的
                            $json_menu[$key_index]['child'][$sub1]['child'][$i] = $v2;
                            $json_menu[$key_index]['child'][$sub1]['child'][$i]['id'] = $i;
                            $json_menu[$key_index]['child'][$sub1]['child'][$i]['parent_id'] = $key_index;
                            $json_menu[$key_index]['child'][$sub1]['child'][$i]['real_id'] = $v1['id'];
                            $i+=3;
                        }
                    }
                }
            }
            $data['left_menu'] = $json_menu;
            $data['tree_menu'] = $left_menu;//print_r($data['left_menu']);
            $this->load->view('frame',$data);
        }

        /**
         * 后台登录页
         */
        public function login(){
            $admin_user_id = $this->session->userdata('admin_user_id');
            if ($admin_user_id) redirect(site_url('admin/index/index'));
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
                    $this->error("您所在的用户组不存在或已禁用",site_url(''), 3);
                }
                if (trim($role_info['name']) == "超级管理员"){
                    $access_list = 'ALL';
                }else{
                    //查询角色所有权限
                    $access = $this->Adminrole_model->get_role_access(['role_id'=>$user_row['role_id']]);
                    if (empty($access)){
                        $this->error("您所在的用户组未分配权限",site_url(''), 3);
                    }
                    $access_list = [];
                    foreach ($access as $key=>$val){
                        switch($val['type']){
                            case 1://菜单权限，用于后台的菜单展示
                                $access_list[] = $val['app'].'/'.$val['controller'].'/'.$val['action'];
                                break;
                            case 0://操作权限，用于后台的具体操作方法(如:后台人员的编辑操作、删除操作、修改操作等具体的操作方法，如果没有相应权限则隐藏对应按钮或提示没有权限)
                                $action_access_list[] = $val['app'].'/'.$val['controller'].'/'.$val['action'];
                        }
                    }
                    $access_list = implode(',',$access_list);
                    $action_access_list = implode(',',$action_access_list);
//                    p($access_list);
                }
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
                    'last_login_time' => $user_row['last_login_time'],
                    'is_open' => $user_row['is_open'],
                    'email'=>$user_row['email'],
                    'avatar'=>$user_row['avatar'],
                    '_ACCESS_LIST' => $access_list,//权限信息，用于登录后分配后台操作菜单
                    '_ACTION_ACCESS_LIST'=>$action_access_list//事件权限
                );
//                p($newdata);
//                exit;
                $this->Adminuser_model->edit_row(['id'=>$user_row['id']],$update_data);
                $this->session->set_userdata($newdata);
                redirect(site_url('admin/index/index'));
            }else{
                $this->error("用户名或者密码错误或者账户被禁，登陆失败！",site_url('admin/index/login'), 3);
            }
        }

        /**
         * 引入公共头部
         */
        public function page_header(){
            $this->load->view('public/page_header');
        }
        /**
         * 引入公共尾部
         */
        public function page_footer(){
            $this->load->view('public/page_footer');
        }

        /**
         * 退出登录
         */
        public function logout(){
            $this->session->sess_destroy();
            $this->success('注销成功！', site_url('admin/index/login'), 2);
        }

        /**
         * 后台权限菜单管理
         */
        public function adminmenu(){
//            $_ACCESS_LIST = $this->session->userdata('_ACCESS_LIST');//用户登录时保存在session中的权限
//            $_ACTION_ACCESS_LIST = $this->session->userdata('_ACTION_ACCESS_LIST');//用户登录时保存在session中的权限
//            $_ACTION_ACCESS_LIST = explode(',',$_ACTION_ACCESS_LIST);
//            $is_add = (in_array('admin/index/adminmenu_add',$_ACTION_ACCESS_LIST) || $_ACCESS_LIST == 'ALL') ? 1 : 0;
//            $is_edit = (in_array('admin/index/adminmenu_edit',$_ACTION_ACCESS_LIST) || $_ACCESS_LIST == 'ALL') ? 1 : 0;
//            $is_del = (in_array('admin/index/ajax_remove_adminmenu',$_ACTION_ACCESS_LIST) || $_ACCESS_LIST == 'ALL') ? 1 : 0;
            $auth_url = [
                'is_add'=>'admin/index/adminmenu_add',
                'is_edit'=>'admin/index/adminmenu_edit',
                'is_del'=>'admin/index/ajax_remove_adminmenu'
            ];
            $auth_arr = check_auth($auth_url);

            $this->load->library('mytreeclass');
            $list = $this->Menu_model->get_list(['pingtai'=>2,'ismenu'=>1]);
            $res = [];
            foreach($list as $key=>$val){
                if($val['parent_id']==0){
                    $res[$key] = $val;
                    $res[$key]['list'] =array();
                    unset($list[$key]);
                    foreach($list as $k1=>$v1){
                        if($v1['parent_id']==$val['id']){
                            $res[$key]['list'][$k1]=$v1;
                            $res[$key]['list'][$k1]['list'] = array();
                            unset($list[$k1]);
                            foreach($list as $k2=>$v2){
                                if($v2['parent_id']==$v1['id']){
                                    array_push($res[$key]['list'][$k1]['list'], $v2);
                                    unset($list[$k2]);
                                }
                            }
                        }
                    }
                }
            }
            if ($auth_arr){
                foreach ($auth_arr as $key=>$val){
                    $data[$key] = $val;
                }
            }
            $data['index_url'] = site_url('admin/index/adminmenu');
            $data['add_url'] = site_url('admin/index/adminmenu_add');
            $data['ajax_status_url'] = site_url('admin/index/ajax_menu_status');
//            $data['is_add'] = $is_add;
//            $data['is_edit'] = $is_edit;
//            $data['is_del'] = $is_del;
            $data['res'] = $res;//print_r($data['res']);
            $this->load->view('adminmenu/adminmenu_index',$data);
        }

        /**
         * 事件菜单列表
         */
        public function actionmenu(){
//            p('事件菜单');
            $auth_url = [
                'is_add'=>'admin/index/actionmenu_add',
                'is_edit'=>'admin/index/actionmenu_edit',
                'is_del'=>'admin/index/ajax_remove_actionmenu'
            ];
            $auth_arr = check_auth($auth_url);
            $this->load->library('mytreeclass');
            $list = $this->Menu_model->get_action_list(['pingtai'=>2]);
            $res = [];
            foreach($list as $key=>$val){
                if($val['parent_id']==0){
                    $res[$key] = $val;
                    $res[$key]['list'] =array();
                    unset($list[$key]);
                    foreach($list as $k1=>$v1){
                        if($v1['parent_id']==$val['id']){
                            $res[$key]['list'][$k1]=$v1;
                            $res[$key]['list'][$k1]['list'] = array();
                            unset($list[$k1]);
                            foreach($list as $k2=>$v2){
                                if($v2['parent_id']==$v1['id']){
                                    if ($v2['ismenu'] == 1){//去掉菜单项
                                        unset($v2);
                                    }else{
                                        array_push($res[$key]['list'][$k1]['list'], $v2);
                                        unset($list[$k2]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($auth_arr){
                foreach ($auth_arr as $key=>$val){
                    $data[$key] = $val;
                }
            }
            $data['index_url'] = site_url('admin/index/actionmenu');
            $data['add_url'] = site_url('admin/index/actionmenu_add');
            $data['ajax_status_url'] = site_url('admin/index/ajax_actionmenu_status');
            $data['res'] = $res;//print_r($data['res']);
            $this->load->view('adminmenu/admin_actionmenu_index',$data);
        }
        /**
         * 添加菜单
         */
        public function actionmenu_add(){
            //引入树形类
            $this->load->library('mytreeclass');
            $parent_id = 0;
            $result = $this->Menu_model->get_action_list(['pingtai'=>2]);
            $array = array();
            foreach($result as $r){
                $r['selected'] = $r['id']==$parent_id ? 'selected':'';
                $array[] = $r;
            }
            $this->mytreeclass->init($array);
            $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
            $select_categorys = $this->mytreeclass->get_tree(0, $str);
            $data['select_categorys'] = $select_categorys;
            //数据保存URL
            $data['form_post'] = site_url('admin/index/actionmenu_save');
            $data['index_url'] = site_url('admin/index/actionmenu');
            $this->load->view('adminmenu/actionmenu_add',$data);
        }
        /**
         * 添加菜单
         */
        public function adminmenu_add(){
            //引入树形类
            $this->load->library('mytreeclass');
            $parent_id = 0;
            $result = $this->Menu_model->get_list(['pingtai'=>2]);
            $array = array();
            foreach($result as $r){
                $r['selected'] = $r['id']==$parent_id ? 'selected':'';
                $array[] = $r;
            }
            $this->mytreeclass->init($array);
            $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
            $select_categorys = $this->mytreeclass->get_tree(0, $str);
            $data['select_categorys'] = $select_categorys;
            //数据保存URL
            $data['form_post'] = site_url('admin/index/adminmenu_save');
            $this->load->view('adminmenu/adminmenu_add',$data);
        }

        /**
         * 修改菜单
         */
        public function adminmenu_edit(){
            $id = $this->input->get('id');
            //引入树形类
            $this->load->library('mytreeclass');
            $row = $this->Menu_model->get_row(['id'=>$id]);
            $parent_id = $row['parent_id'];
            $result = $this->Menu_model->get_list(['pingtai'=>2]);
            $array = [];
            foreach($result as $r){
                $r['selected'] = $r['id']==$parent_id ? 'selected':'';
                $array[] = $r;
            }
            $this->mytreeclass->init($array);
            $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
            $select_categorys = $this->mytreeclass->get_tree(0, $str);
            $data['select_categorys'] = $select_categorys;
            $data['row'] = $row;
            //数据保存URL
            $data['form_post'] = site_url('admin/index/adminmenu_save');
            $this->load->view('adminmenu/adminmenu_edit',$data);
        }
        /**
         * 修改菜单
         */
        public function actionmenu_edit(){
            $id = $this->input->get('id');
            //引入树形类
            $this->load->library('mytreeclass');
            $row = $this->Menu_model->get_action_row(['id'=>$id]);
            $parent_id = $row['parent_id'];
            $result = $this->Menu_model->get_action_list(['pingtai'=>2]);
            $array = [];
            foreach($result as $r){
                $r['selected'] = $r['id']==$parent_id ? 'selected':'';
                $array[] = $r;
            }
            $this->mytreeclass->init($array);
            $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
            $select_categorys = $this->mytreeclass->get_tree(0, $str);
            $data['select_categorys'] = $select_categorys;
            $data['row'] = $row;
            //数据保存URL
            $data['form_post'] = site_url('admin/index/actionmenu_save');
            $data['index_url'] = site_url('admin/index/actionmenu');
            $data['add_url'] = site_url('admin/index/actionmenu_add');
            $this->load->view('adminmenu/actionmenu_edit',$data);
        }
        /**
         * 保存菜单数据
         */
        public function adminmenu_save(){
            $data = $this->input->post('Form');
            $id = $this->input->post('id');
            if(empty($id)){
                $data['pingtai'] = 2;
                $res = $this->Menu_model->add_row($data);
            }else{
                $res = $this->Menu_model->edit_row(['id'=>$id],$data);
            }
            if($res){
                $this->success('操作成功',site_url('admin/index/adminmenu'),true);
            }else{
                $this->error('操作失败',site_url('dmin/index/adminmenu'),true);
            }
        }

        /**
         * 保存事件菜单数据
         */
        public function actionmenu_save(){
            $data = $this->input->post('Form');
            $id = $this->input->post('id');
            if(empty($id)){
                $data['ismenu'] = 0;
                $data['pingtai'] = 2;
                $res = $this->Menu_model->add_action_row($data);
            }else{
                $res = $this->Menu_model->edit_action_row(['id'=>$id],$data);
            }
            if($res){
                $this->success('操作成功',site_url('admin/index/actionmenu'),true);
            }else{
                $this->error('操作失败',site_url('dmin/index/actionmenu'),true);
            }
        }

        /**
         * 异步删除菜单
         */
        public function ajax_remove_adminmenu(){
            $id = $this->input->get('id');
            //判断是否有子菜单
            $is_has_child = $this->Menu_model->is_has_child($id);
            if($is_has_child){
                $this->error('该菜单存在子菜单,请先删除其子菜单!','',true);
            }
            $res = $this->Menu_model->remove_row(['id'=>$id]);
            if($res){
                $this->success('操作成功','',true);
            }else{
                $this->error('操作失败','',true);
            }
        }

        /**
         * 异步删除菜单
         */
        public function ajax_remove_actionmenu(){
            $id = $this->input->get('id');
            //判断是否有子菜单
            $is_has_child = $this->Menu_model->is_has_child($id,2);
            if($is_has_child){
                $this->error('该菜单存在子菜单,请先删除其子菜单!','',true);
            }
            $res = $this->Menu_model->remove_row(['id'=>$id],2);
            if($res){
                $this->success('操作成功','',true);
            }else{
                $this->error('操作失败','',true);
            }
        }

        /**
         * 异步修改菜单状态
         */
        public function ajax_menu_status(){
            $post = $this->input->post();
            $data[$post['field']] = $post['val'];
            $res = $this->Menu_model->edit_row(['id'=>$post['id']],$data);
            if($res){
                $this->success('操作成功','',true);
            }else{
                $this->error('操作失败','',true);
            }
        }
        /**
         * 异步修改菜单状态
         */
        public function ajax_actionmenu_status(){
            $post = $this->input->post();
            $data[$post['field']] = $post['val'];
            $res = $this->Menu_model->edit_row(['id'=>$post['id']],$data,2);
            if($res){
                $this->success('操作成功','',true);
            }else{
                $this->error('操作失败','',true);
            }
        }
        /**
         *
         * 修改状态信息
         */
         public function edit_sort(){
            $id = $this->input->get_post('id');
            $sort_order = $this->input->get_post('sort_order');
            $res = $this->Menu_model->edit_row(['id'=>$id],['sort_order'=>$sort_order]);
            if($res){
                echo 1;exit;
            }else{
                echo 0;exit;
            }
        }
        public function datan(){
            echo "后台";
        }

        /**
         * 权限校验
         */
        public function check_auth(){
            $url = $this->input->post('url');
            $_ACCESS_LIST = $this->session->userdata('_ACCESS_LIST');//用户登录时保存在session中的权限
            $_ACTION_ACCESS_LIST = $this->session->userdata('_ACTION_ACCESS_LIST');//用户登录时保存在session中的权限
            $_ACTION_ACCESS_LIST = explode(',',$_ACTION_ACCESS_LIST);
            $is_authed = (in_array($url,$_ACTION_ACCESS_LIST) || $_ACCESS_LIST == 'ALL') ? 1 : -1;
            $arr=[
                'status'=>$is_authed,
                'msg'=>($is_authed == 1) ? 'authed' :'没有权限'
            ];
            echo json_encode($arr);
        }
    }