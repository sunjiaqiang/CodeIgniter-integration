<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/1 0001
 * Time: 22:47
 * @description 整合plupload多图上传
 */
    class Plupload_index_module extends CI_Module{
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * 上传首页
         */
        public function index(){
            $this->load->view('upload');
        }

        /**
         * 上传图片
         */
        public function upload_pic(){
            $allow_ext = ['jpg','png','gif','jpeg'];//允许上传的类型
            $allow_max_size = 5*1024*1024;//5m=5242880 b 允许上传的大小
            $save_path = './public/uploads/';//后面必须加/

            $this->load->library('myfile');
            $this->myfile->allowExts = $allow_ext;
            $this->myfile->savePath = $save_path;
            $this->myfile->maxSize = $allow_max_size;
            $this->myfile->upload();
        }
        /**
         * 删除图片
         * @param $path 图片路径
         */
        public function del_img(){
            $path = $this->input->post('pic');
            file_exists($path) and unlink($path);
            $status = array(
                'status'=>1,
                'msg'=>"删除成功"
            );
            echo json_encode($status);
        }
    }