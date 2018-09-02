<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/2 0002
 * Time: 12:22
 * @description ci框架列表ajax分页
 */
    class Ajaxpage_Index_module extends CI_Module{
        public function __construct()
        {
            parent::__construct();
            $this->load->model('ajaxpage.Article_model');
        }
        public function index(){
            $cur_page = $this->input->post('cur_page');
            if( ! $cur_page){
                $cur_page = $this->uri->segment('3') ? $this->uri->segment(3) : 1;
            }
            $count = $this->Article_model->get_count();
            $page_config['mode'] = 'ajax';
            $page_config['cur_page'] = $cur_page;
            $page_config['total_rows'] = $count;
            $page_config['per_page'] = 10;
            $page_config['num_links'] = 2;
            $page_config['params'] = make_url(array());
            $page_config['base_url'] = site_url('ajaxpage/index/index');
            $this->load->library('Mypage',$page_config);
            $result = $this->Article_model->get_list($page_config['per_page'],$page_config['cur_page']);
            $data['list'] = $result;
            $this->load->view('ajax_page',$data);
        }
        /**
         * ajax分页
         */
        public function search_list(){
            $count = $this->Article_model->get_count();
            /*$data = $this->input->post();
            p($data);*/
            $page_config['mode'] = 'ajax';
            $page_config['cur_page'] = $this->input->post('page') ? $this->input->post('page') : 1;//当前页
            $page_config['total_rows'] = $count;
            $page_config['per_page'] = 10;
            $page_config['num_links'] = 2;
            $page_config['params'] = '';
            $page_config['base_url'] = site_url('ajaxpage/index/index');
            $this->load->library('Mypage',$page_config);
            $result = $this->Article_model->get_list($page_config['per_page'],$page_config['cur_page']);
            $data['list'] = $result;
            $content = $this->load->view('page_list',$data,true);//已缓冲区的形式返回，然后输出到浏览器
            echo $content;
            exit;
        }
    }