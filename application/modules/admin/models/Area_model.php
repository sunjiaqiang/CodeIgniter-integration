<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/7/26
 * Time: 14:59
 */
class Admin_Area_model extends CI_Model
{
    private $table_area;

    public function __construct()
    {
        parent::__construct();
        $this->table_area = $this->db->dbprefix('area');

    }

    /**
     * 通过id获取地区信息
     * @param int $id
     */
    public function get_area_by_id($id = 0)
    {
        $arr = [];
        if ($id == 0){
            return $this->get_continent();
        }
        $sql = "SELECT * FROM $this->table_area WHERE id=? LIMIT 1";
        $query = $this->db->query($sql,[$id]);
        $row = $query->row_array();
        if ( ! empty($row)){
            $poi_code   = $row['poi_code'];
            $code_level = $row['code_level']+1;

            if($id == 40002){
                $code_level --;
                $poi_code = '0040002';
            }
            $sql = "SELECT * FROM $this->table_area WHERE code_level=? AND poi_code LIKE ? ORDER BY district_type ASC";
            $query = $this->db->query($sql,[$code_level,$poi_code.'%']);
            $arr = $query->result_array();
        }
        return $arr;
    }

    /**
     * @return array
     */
    public function get_continent()
    {
        $retval = [
            0 =>
                [
                    'sid' => '0',
                    'id' => '3900',
                    'name' => '亚洲',
                    'poi_code' => '0003900',
                    'code_level' => '1',
                    'district_type' => '1',
                ],
            1 =>
                [
                    'sid' => '0',
                    'id' => '3600',
                    'name' => '欧洲',
                    'poi_code' => '0003600',
                    'code_level' => '1',
                    'district_type' => '1',
                ],
            2 =>
                [
                    'sid' => '0',
                    'id' => '4100',
                    'name' => '大洋洲',
                    'poi_code' => '0004100',
                    'code_level' => '1',
                    'district_type' => '1',
                ],
            3 =>
                [
                    'sid' => '0',
                    'id' => '3700',
                    'name' => '北美洲',
                    'poi_code' => '0003700',
                    'code_level' => '1',
                    'district_type' => '1',
                ],
            4 =>
                [
                    'sid' => '0',
                    'id' => '4000',
                    'name' => '非洲',
                    'poi_code' => '0004000',
                    'code_level' => '1',
                    'district_type' => '1',
                ],
            5 =>
                [
                    'sid' => '0',
                    'id' => '3800',
                    'name' => '南美洲',
                    'poi_code' => '0003800',
                    'code_level' => '1',
                    'district_type' => '1',
                ],
        ];
        return $retval;
    }
}