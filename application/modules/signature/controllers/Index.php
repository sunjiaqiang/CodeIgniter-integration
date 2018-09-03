<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/9/3
 * Time: 10:39
 */
    class Signature_Index_module extends CI_Module{
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * 电子签名列表
         */
        public function index(){
            $sql = "select * from signature order by id";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            $data['list'] = $result;
            $this->load->view('signature',$data);
        }

        /**
         * 保存电子签名数据
         */
        public function save_signature(){
            $data = $this->input->post();
            $arr['sign_url'] = $data['dataUrl'];
            $result = $this->db->insert('signature',$arr);
            if($result){
                echo json_encode(array('status'=>1,'msg'=>"签名成功"));
            }else{
                echo json_encode(array('status'=>-1,'msg'=>"签名失败"));
            }
        }
    }