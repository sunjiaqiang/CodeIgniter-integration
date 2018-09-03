<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/2 0002
 * Time: 12:24
 */
    class Ajaxpage_article_model extends CI_Model{
        /**
         * 获取列表
         */
        public function get_list($per_page=15,$cur_page=1,$where='',$orderby='inputtime desc'){
            $sql = "select fn.*,fc.name from article_news fn";
            $sql.= " left join article_category fc on fc.id = fn.catid";
            if( ! empty($where)){
                $sql.=" where $where";
            }
            $sql.= " order by $orderby";
            $sql.= " limit ?,?";
            $query = $this->db->query($sql,array(($cur_page-1)*$per_page,$per_page));
            //echo $this->db->last_query(),'<br>';
            $result = $query->result_array();
            return $result;
        }
        /**
         * 获取总条数
         */
        public function get_count($where=''){
            $sql = "select count(1) nums from article_news";
            if( ! empty($where)){
                $sql .= " where $where";
            }
            $query = $this->db->query($sql);
            $row = $query->row_array();
            return $row['nums'];
        }

        /**
         * 为scroll模块提供
         * @param int $cur_page
         * @param int $per_page
         * @return mixed
         */
        public function get_list3($cur_page = 1,$per_page = 10){
            $sql = "select * from article_news order by inputtime desc";
            $sql .= " limit ?,?";
            $query = $this->db->query($sql,array(($cur_page-1)*$per_page,$per_page));
            $result = $query->result_array();
            return $result;
        }

        /**
         * 用于静态生成模块
         * @param int $cur_page
         * @param int $page_size
         * @return array
         */
        public function get_all($cur_page=1,$page_size=300){
            $sql = "SELECT * FROM article_news ORDER BY id LIMIT ?,?";
            $query = $this->db->query($sql,array(($cur_page-1)*$page_size,$page_size));
            $result = $query->result_array();
            $arr = array_column($result,'id','id');
            return $arr;
        }

        /**
         * 获取所有文章栏目，用于静态生成
         * @return array
         */
        public function get_all_cate(){
            $sql = "SELECT * FROM article_category ORDER BY id";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            $data = array_column($result,null,'id');
            return $data;
        }
        /**
         * 获取单条数据
         * @param int $id
         */
        public function get_row_article($id=0){
            $sql = "SELECT * FROM article_news WHERE id=?";
            $query = $this->db->query($sql,array($id));
            $row = $query->row_array();
            return $row;
        }
    }