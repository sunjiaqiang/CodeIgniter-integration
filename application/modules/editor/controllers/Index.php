<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/9/3
 * Time: 10:46
 */
    class Editor_Index_module extends CI_Module{
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * wangeditor编辑器
         */
        public function wangeditor(){
            $this->load->view('wangeditor');
        }
        /**
         * wangEditor上传图片
         */
        public function upload_wang(){
            $target_path = 'public/uploads/wangeditor/';
            file_exists($target_path) OR create_folders($target_path);
            $arr = array();
            if( ! empty($_FILES)){
                foreach($_FILES as $key=>$val){
                    $type = strtolower(substr(strrchr($val['name'],'.'),1));
                    $typeArr=array("jpg","jpeg","png",'gif');
                    $type = strtolower(substr(strrchr($val['name'],'.'),1));
                    if( ! in_array($type,$typeArr)){
                        echo json_encode(array("error"=>-1,'msg'=>"文件类型不支持"));
                        exit;
                    }
                    $size = $val['size'];
                    if ($size>300*1024){
                        echo json_encode(array("error"=>-1,'msg'=>"图片超过大小300KB"));
                        exit;
                    }
                    $name = date('YmdHis',time()). rand(10000, 99999) .'.'.$type;
                    //echo $name,'<br>';
                    $pic_url = $target_path.$name;
                    $tmp_name = $val['tmp_name'];
                    if(copy ( $val['tmp_name'], $pic_url ) || move_uploaded_file($val['tmp_name'],iconv('utf-8','gbk',$pic_url))){
                        $arr[] = $pic_url;
                    }
                }
                $data=array(
                    'errno'=>0,
                    'data'=>$arr
                );
                echo json_encode($data);
            }

        }
    }