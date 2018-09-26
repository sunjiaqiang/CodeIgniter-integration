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
         * 阿里oss图片上传
         */
        public function index2(){
            $this->load->view('alioss_upload');
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

        /**
         * alioss上传文件(此处以图片为例)
         */
        public function aliupload(){
//            $this->load->library('aliupload');
//            $local_file = './video2.mp4';
//            $remote_file = date('Y-m-d').'/video2.mp4';
//            $result = $this->aliupload->_upload($local_file,$remote_file);
//            p($result);
            $this->load->library('aliupload');
            $local_file = $_FILES['file']['tmp_name'];
            $ext = substr($_FILES['file']['name'],strrpos($_FILES['file']['name'],'.')+1);
            $remote_file = date('Y-m').'/'.$_FILES['file']['name'].'.'.$ext;
            $result = $this->aliupload->_upload($local_file,$remote_file);
            $arr['error'] = 0;
            $arr['status'] = 1;
            $arr['pic'] = $result;
            $arr['msg'] = "上传成功";
            echo json_encode($arr);
        }
        /**
         * oss删除图片
         * @param $path 图片路径
         */
        public function oss_del_img(){
            $path = $this->input->post('pic');
            $this->config->load('alioss',TRUE);
            $config = $this->config->item('oss','alioss');
            $object = str_replace('http://'.$config['bucket'].'.'.$config['endpoint'].'/','',$path);
            $this->load->library('aliupload');
            $file_exist = $this->aliupload->_check_file_exist($object);
            if ($file_exist){
                $this->aliupload->_delete_file($object);
                $status = array(
                    'status'=>1,
                    'msg'=>"删除成功"
                );
            }else{
                $status = array(
                    'status'=>-1,
                    'msg'=>"文件不存在"
                );
            }
            echo json_encode($status);
        }
    }