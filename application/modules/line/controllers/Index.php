<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/7/27
 * Time: 15:27
 */
    class Line_Index_module extends CI_Module{
        private $sid = 756;
        public function __construct()
        {
            parent::__construct();
            $this->load->model('line.Line_model');
        }

        /**
         * 线路列表
         */
        public function index(){
            $url = $this->input->get_post('url');
            $row = $this->Line_model->get_cat_row(['link_url'=>$url,'sid'=>$this->sid]);
            p($row);
            $this->set_where($row);

        }

        /**
         * 组装查询条件
         * @param array $row
         */
        public function set_where($row=[]){
            if (empty($row)) return false;
            $dist_citys = '1620,2420';//收客城市
            $shouke_str = 'FIND_IN_SET(0,l.dist_citys)';
            if ($dist_citys){
                $dist_citys = explode(',',$dist_citys);
                foreach ($dist_citys as $city){
                    $shouke_str .= ' OR FIND_IN_SET('.$city.',l.dist_citys)';
                }
            }
            if ($row['cat_type'] && $row['cat_type'] == 1){
                $area_id = 'd_city';
                $cat_val = $row['cat_value'];
                //按区域划分的分类，获取区域相关记录
                $cat_dist = $this->Line_model->get_cat_dist_row(['cat_id'=>$row['cat_id']]);
                if ($cat_dist['continent'] == $cat_val) $area_id = 'd_continent';
                if ($cat_dist['country'] == $cat_val) $area_id = 'd_country';
                if ($cat_dist['province'] == $cat_val) $area_id = 'd_province';
                if ($cat_dist['city'] == $cat_val) $area_id = 'd_city';
                $where = '('.$shouke_str.')'.' AND l.status=1 AND l.is_del=0 AND l.'.$area_id.'='.$cat_val;
            }else{
                $this->combine_where($row,$shouke_str);
            }
        }

        /**
         * 组合where条件
         * @param array $row
         */
        public function combine_where($row=[],$shouke_str=''){
            $cat_id = $row['cat_id'];
            $cat_list = $this->Line_model->get_index_cat();
            $childs = $this->Line_model->get_child($cat_list,$cat_id);
            $where = $shouke_str;

            //p($childs);

            if ($row['line_sort_id']) $where .= ' AND FIND_IN_SET('.$row['line_sort_id'].',l.product_sort)';
            $where_data=[];
            foreach ($childs as $key=>$item){

                if ( ! empty($item)){
                    $cat_value = $item['cat_value'];
                    $cat_type = $item['cat_type'];
                    switch ($cat_type){
                        case 1:
                            //按区域划分
                            $area_id = 'd_city';
                            $cat_dist = $this->Line_model->get_cat_dist_row(['cat_id'=>$item['cat_id']]);
                            if ($cat_dist['continent'] == $cat_value) $area_id = 'd_continent';
                            if ($cat_dist['country'] == $cat_value) $area_id = 'd_country';
                            if ($cat_dist['province'] == $cat_value) $area_id = 'd_province';
                            if ($cat_dist['city'] == $cat_value) $area_id = 'd_city';
                            $where_data[] = ['line_sort_id'=>$item['line_sort_id'],'area'=>[$area_id,$cat_value]];
                            break;
                        case 2:
                            //按景区划分
                            break;
                        case 3:
                            //按行程划分
                            if ($cat_value >= 4){
                                $where_data[] = ['line_sort_id'=>$item['line_sort_id'],'days'=>'>=4'];
                            }else{
                                $where_data[] = ['line_sort_id'=>$item['line_sort_id'],'days'=>'='.$cat_value];
                            }
                            break;
                    }
                }
            }

            p($where_data);

            $new_where2 = '';
            foreach ($where_data as $key=>$val){
                $new_where='';
                if ($val['line_sort_id']) $new_where .= 'FIND_IN_SET('.$val['line_sort_id'].',l.product_sort)';
                if (isset($val['area'])){
                    if ($new_where) $new_where.= ' AND ';
                    $new_where .= 'l.'.$val['area'][0].'='.$val['area'][1];
                }
                if (isset($val['days'])){
                    if ($new_where) $new_where .= ' AND ';
                    $new_where .= 'l.days'.$val['days'];
                }
                if ($new_where){
                    if ($new_where2) $new_where2.=' OR ';
                    $new_where2 .= '('.$new_where.')';
                }
            }

            if ($new_where2) $where .= ' AND ('.$new_where2.')';
            p($where);
        }
    }