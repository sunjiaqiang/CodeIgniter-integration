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
    }