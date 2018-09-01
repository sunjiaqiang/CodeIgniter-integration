<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/7/24
 * Time: 15:55
 */
    class Line_Line_model extends CI_Model{
        private $table_line;//线路表
        private $table_line_info;//线路信息表
        private $table_buyer;//线路云关系表
        private $table_line_go;//线路团期表
        private $table_go_price;//团期价格表，主要是分销商使用
        private $table_area;//地区表
        private $table_recommend_cat;//推荐分类表
        private $table_recommend_cat_dist;//地区推荐记录表
        private $table_user;//后台用户表(各站点创始人)
        public function __construct()
        {
            parent::__construct();
            $this->table_line = $this->db->dbprefix("line");
            $this->table_line_info = $this->db->dbprefix("line_info");
            $this->table_buyer = $this->db->dbprefix("line_buyer");
            $this->table_go_price = $this->db->dbprefix("line_go_price");
            $this->table_line_go = $this->db->dbprefix("line_go");
            $this->table_recommend_cat = $this->db->dbprefix("citysite_recommend_line_cat");
            $this->table_recommend_cat_dist = $this->db->dbprefix("citysite_recommend_line_cat_dist");
            $this->table_user =  $this->db->dbprefix("admin_user");
        }
        public function index(){
            p('line_model');
        }

        /**
         * 通过url获取分类信息
         * @param array $where
         */
        public function get_cat_row(array $where=[]){
            $query = $this->db->select('*')
                ->from($this->table_recommend_cat)
                ->where($where)
                ->get();
            return $query->row_array();
        }

        /**
         * 获取区域划分的分类的地区相关记录
         * @param array $where
         * @return mixed
         */
        public function get_cat_dist_row(array $where=[]){
            $query = $this->db->select('*')
                ->from($this->table_recommend_cat_dist)
                ->where($where)
                ->get();
            return $query->row_array();
        }

        /**
         * 获取本站所有推荐位
         */
        public function get_index_cat(){
            $sql = "SELECT * FROM $this->table_recommend_cat WHERE is_open=1 AND is_open=1 AND sid=? ORDER BY sort_order ASC";
            $query = $this->db->query($sql,[756]);
            $result = $query->result_array();
            return $result;
        }

        /**
         * 获取当前分类的所有子分类
         * @param array $data
         * @param int $cat_id
         */
        public function get_child($data=[],$cat_id=0){
            $arr = [];
            foreach ($data as $key=>$val){
                if ($val['parent_id'] == $cat_id){
                    $arr[] = $val;
                    $temp = $this->get_child($data,$val['cat_id']);
                    if ( ! empty($temp)){
                        $arr = array_merge($arr,$temp);
                    }
                }
            }
            return $arr;
        }

    }