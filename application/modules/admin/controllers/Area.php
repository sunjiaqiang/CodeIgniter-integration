<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/7/26
 * Time: 15:34
 */
class Admin_Area_module extends CI_Module{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 地区首页
     */
    public function index(){
        $this->load->view('area/index');
    }
    public function save(){
        $data = $this->input->post();
        $arr = [];
        $key_arr = array_keys($data['t']);
        for($i=0;$i<count($data['t']['continent']);$i++){
            foreach($key_arr as $key=>$val){
                $arr[$i][$val] = $data['t'][$val][$i];
            }
        }
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
}