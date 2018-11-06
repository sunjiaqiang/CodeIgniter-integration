<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/9/3
 * Time: 13:50
 */
    class Analysis_Index_module extends CI_Module{
        public function __construct()
        {
            parent::__construct();
            $this->load->model('ajaxpage.Article_model');
        }

        /**
         * highcharts数据简单分析
         */
        public function index(){
            $year = $this->input->get_post('year') ? $this->input->get_post('year') : date('Y');
            $data = $this->Article_model->get_list2($year);
            for ($i=1;$i<=12;$i++){
                $date[] = $year.'-'.str_pad($i,2,0,STR_PAD_LEFT);
            }
            /*p($date);
            p($data);*/
            if( ! empty($data)){
                foreach ($data as $key=>$val){
                    $arr[$val['cat_name']][$val['add_time']] = $val['nums'];
                }
            }else{
                $cate = $this->Article_model->get_cate();
                $arr = array_flip($cate);
            }

            foreach ($arr as $key=>$val){
                $arr_month[$key]['name'] = $key;
                foreach ($date as $dk=>$dv){
                    if (is_array($val)){
                        if (array_key_exists($dv,$val)){
                            $arr_month[$key]['data'][] = (int)$val[$dv];
                        }else{
                            $arr_month[$key]['data'][] = 0;
                        }
                    }else{
                        $arr_month[$key]['data'][] = 0;
                    }
                }
            }

            foreach($date as $key=>$val){
                $tmp_arr = explode('-',$val);
                $tmp[]=$tmp_arr[0].'年'.$tmp_arr[1].'月';
            }

            /*p($arr);
            p($arr_month);*/
            $aix = array_keys($tmp);
            $aix_y = array_values($arr_month);
            //p($date);
            //p($aix_y);
            $data_arr['month'] = json_encode($tmp);
            $data_arr['month_arr'] = json_encode($aix_y);
            $this->load->view('analysis',$data_arr);
        }
    }