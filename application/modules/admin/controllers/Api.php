<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/7/26
 * Time: 14:57
 */
    class Admin_Api_module extends CI_Module{
        public function __construct()
        {
            parent::__construct();
            $this->load->model('admin.Area_model');
        }
        public function index(){

            p(getcwd());
            p(__DIR__);
            exit;
            $id = $this->input->get('id');
            $list = $this->Area_model->get_area_by_id($id);
            echo json_encode($list);
            //$this->Area_model->get_area_by_id(20);
        }
    }