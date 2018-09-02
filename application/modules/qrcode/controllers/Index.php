<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/2 0002
 * Time: 11:05
 */
    use PHPQRCode\QRcode;//命名空间，这里主要是使用composer，如果没有可以安装
    class Qrcode_Index_module extends CI_Module{
        public function __construct()
        {
            parent::__construct();
        }
        public function index(){
            // p(FCPATH);
            $data = "百度首页地址为：www.baidu.com";
            $arr['url'] = $data;
            $this->load->view('qrcode',$arr);
        }
        public function qrcodes(){
            $data = $this->input->get('data');
            $jiemi = unlock_url($data);
            //p($jiemi);
            // $data = urldecode($this->input->get('data'));

            $value = $jiemi;                  //二维码内容
            $errorCorrectionLevel = 'L';    //容错级别
            $matrixPointSize = 5;           //生成图片大小
            //此处也可以生成二维码，不是用composer
            require_once FCPATH.'application/libraries/phpqrcode/phpqrcode.php';
            //生成二维码图片
            $QR = QRcode::png($value,$outfile = false, $level = $errorCorrectionLevel, $size = 6, $margin = 2, $saveandprint=false);

        }

        public function qrcodes2(){
            $data = $this->input->get('data');
            $jiemi = unlock_url($data);
            //p($jiemi);
            // $data = urldecode($this->input->get('data'));

            $value = $jiemi;                  //二维码内容
            $errorCorrectionLevel = 'L';    //容错级别
            $matrixPointSize = 5;           //生成图片大小

            //这里使用composer下载的类来生成二维码
            $qrcode = new QRcode();
            $qrcode->png($value, false, $level = $errorCorrectionLevel, $size = 6, $margin = 2, $saveandprint=false);
            //这个方法也可以生成二维码，直接用类名+方法
            //\PHPQRCode\QRcode::png($value, false, $level = $errorCorrectionLevel, $size = 6, $margin = 2, $saveandprint=false);

        }

    }