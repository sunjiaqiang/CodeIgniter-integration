<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/27
 * Time: 22:39
 */
    class Myfile{
        //允许的扩展名
        public $allowExts=["jpg","png",'gif','png'];
        //文件保存路径
        public $savePath='./uploads/';
        //最大上传大小 默认最大上传 2M =2097152 B
        public $maxSize=2097152;
        //最近一次的错误
        private $error='';

        /**
         * 上传图片方法
         * @param $return_type 1返回json格式，2返回数组格式
         * @param $resutn_name 返回的文件名
         */
        public function upload($return_type = 1,$resut_name='pic'){
            $this->createFolder($this->savePath);//创建上传文件夹
            $file = $_FILES['file'];
            $file['extension'] = $this->getExt($file['name']);
            $file['save_path'] = $this->savePath;
            $file['save_name'] = date('YmdHis').rand(1000,9999).'.'.$file['extension'];
            if( ! $this->check($file)){
                $arr['status'] = -1;
                $arr['error'] = $this->error;
                echo json_encode($arr);
                exit;
            }

            if( ! $this->save_file($file)){
                $arr['status'] = -1;
                $arr['error'] = $this->error;
                echo json_encode($arr);
                exit;
            }
            $arr['error'] = 0;
            $arr['status'] = 1;
            $arr[$resut_name] = $file['save_path'].$file['save_name'];
            $arr['msg'] = "上传成功";
            switch ($return_type){
                case 1:
                    echo json_encode($arr);
                case 2:
                    return $arr;
            }

        }

        /**
         * 上传图片方法
         * @param $return_type 1返回json格式，2返回数组格式
         * @param $resutn_name 返回的文件名
         */
        public function upload_markdown($return_type = 1,$resut_name='pic'){
            $this->createFolder($this->savePath);//创建上传文件夹
            $file = $_FILES['editormd-image-file'];
            $file['extension'] = $this->getExt($file['name']);
            $file['save_path'] = $this->savePath;
            $file['save_name'] = date('YmdHis').rand(1000,9999).'.'.$file['extension'];
            if( ! $this->check($file)){
                $arr['status'] = -1;
                $arr['error'] = $this->error;
                echo json_encode($arr);
                exit;
            }

            if( ! $this->save_file($file)){
                $arr['status'] = -1;
                $arr['error'] = $this->error;
                echo json_encode($arr);
                exit;
            }
            $arr['error'] = 0;
            $arr['success'] = 1;
            $arr['url'] = $file['save_path'].$file['save_name'];
            $arr['message'] = "上传成功";
            switch ($return_type){
                case 1:
                    echo json_encode($arr);
                case 2:
                    return $arr;
            }

        }

        /**
         * 上传文件
         * @param $file
         */
        private function save_file($file){
            $file_name = $file['save_path'].$file['save_name'];
            if( ! move_uploaded_file($file['tmp_name'],$file_name) && ! copy($file['tmp_name'],$file_name)){
                $this->error = "文件上传失败";
                return false;
            }
            return true;
        }


        /**
         * 检查上传文件
         * @param $file
         */
        private function check($file){
            if($file['error'] !== 0){
                $this->error($file['error']);
                return false;
            }
            //检测文件大小
            if(!$this->check_size($file['size'])){
                $this->error = '上传文件大小不符！';
                return false;
            }
            //检测文件扩展名
            if(!$this->check_ext($file['extension'])){
                $this->error = '上传文件类型不允许！';
                return false;
            }
            //检测是否非法上传
            if(!$this->checkUpload($file['tmp_name'])) {
                $this->error = '非法上传文件！';
                return false;
            }
            return true;
        }

        /**
         * 递归创建文件夹
         * @param string $path
         */
        public function createFolder($path=''){
            if( ! is_dir($path)){
                $this->createFolder(dirname($path));
            }
            return is_dir($path) OR mkdir($path,0777);
        }

        /**
         * 获取文件扩展名
         *
         * @param string $filename
         */
        private function getExt($filename=''){
            $num = strrpos($filename,'.');
            $ext = substr($filename,$num+1);
            return strtolower($ext);
        }

        /**
         * 检查上传大小是否合适
         * @param $size
         */
        private function check_size($size){
            return $size < $this->maxSize;
        }

        /**
         * 检查文件扩展名是否合法
         * @param $extension
         */
        private function check_ext($extension){
            if(!empty($this->allowExts))
                return in_array(strtolower($extension),$this->allowExts,true);
            return true;
        }
        /**
         * 检测是否非法上传
         */
        private function checkUpload($filename){
            return is_uploaded_file($filename);
        }
        /**
         * 捕获错误上传信息
         */
        private function error($errorCode){
            switch($errorCode) {
                case 1:
                    $this->error = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
                    break;
                case 2:
                    $this->error = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
                    break;
                case 3:
                    $this->error = '文件只有部分被上传';
                    break;
                case 4:
                    $this->error = '没有文件被上传';
                    break;
                case 6:
                    $this->error = '找不到临时文件夹';
                    break;
                case 7:
                    $this->error = '文件写入失败';
                    break;
                default:
                    $this->error = '未知上传错误！';
            }
            return ;
        }

    }