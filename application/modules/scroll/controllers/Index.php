<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/2 0002
 * Time: 12:41
 */
    class Scroll_Index_module extends CI_Module{
        public function __construct()
        {
            parent::__construct();
            $this->load->model('ajaxpage.Article_model');
        }
        public function index(){
            $cur_page = $this->input->get_post('page') ? $this->input->get_post('page') : 1;
            $is_ajax = $this->input->get_post('is_ajax');
            $per_page = 10;
            $total = $this->Article_model->get_count();
            $total_page = ceil($total/$per_page);
            $result = $this->Article_model->get_list3($cur_page,$per_page);
            $data['list'] = $result;
            $data['total_page'] = $total_page;
            $data['page'] = $cur_page;
            if($is_ajax){
                echo json_encode($data);
                exit;
            }
            $this->load->view('scroll',$data);
        }
    }