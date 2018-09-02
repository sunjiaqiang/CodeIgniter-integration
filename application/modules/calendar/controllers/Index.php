<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/2 0002
 * Time: 9:46
 */
    class Calendar_Index_module extends CI_Module{
        public function __construct()
        {
            parent::__construct();
            $this->load->model('calendar.Calendar_model');
        }

        /**
         * 日历1
         */
        public function calendar_one(){
            //$this->Calendar_model->set_data($result);
            $sign_data = $this->Calendar_model->get_sign_data();
            //p($sign_data);

            $this->Calendar_model->set_data($sign_data);
            //p($result);
            $this->load->view('calendar_one');
        }
        /**
         * 签到
         */
        public function sign(){
            $sign = $this->input->post('sign');
            if($sign==1){
                $result = $this->Calendar_model->sign_up();
                if($result){
                    $data=array(
                        'status'=>1,
                        'msg'=>"签到成功"
                    );
                }else{
                    $data=array(
                        'status'=>-1,
                        'msg'=>"签到失败"
                    );
                }
                echo json_encode($data);
            }
        }

        /**
         * 日历2
         */
        public function calendar_two(){
            $month = $this->input->get('month') ? $this->input->get('month') : date('m');
            $month_start = mktime(0,0,0,$month,str_pad(1,2,0,STR_PAD_LEFT),date('Y'));
            $days = date('t',$month_start);
            //$w = date('w',$month_start);
            $k = 0;
            $arr = array();
            for ($i=1;$i<=$days;$i++){
                //当$w=0的时候代表星期天，用$w来进行分组
                $now_date = date('Y-m-d',mktime(0,0,0,$month,str_pad($i,2,0,STR_PAD_LEFT),date('Y')));
                $w = date('w',mktime(0,0,0,$month,$i,date('Y')));
                if ($w == 0){
                    $k++;
                }
                $arr[$k][$w] = $now_date;

            }
            //p($arr);
            $data['rili'] = $arr;
            $this->load->view('calendar_two',$data);
        }
    }