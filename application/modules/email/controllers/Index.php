<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/9/3
 * Time: 16:10
 */
    class Email_Index_module extends CI_Module{
        public function __construct()
        {
            parent::__construct();
        }
        public function index(){
            if (strtolower($_SERVER['REQUEST_METHOD']) == 'post'){
                $email = $this->input->post('email');
                $subject = "测试邮件标题";
                $content = "测试邮件内容";
                $arr = send_email($email,$subject,$content);
                echo json_encode($arr);
                exit;
            }
            $this->load->view('index');
        }
    }