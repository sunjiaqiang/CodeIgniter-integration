<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test2_Home_Made_module extends CI_Module {

	/**
	 * 构造函数
	 *
	 * @return void
	 * @author
	 **/
	function __construct()
	{
		parent::__construct();
        $this->load->model('Main_data_model');
        $this->load->model('line.Line_model');
        $this->load->model('admin.Area_model');
	}

	function index()
	{
        $this->Area_model->get_area_by_id(20);
		// 这是装载本模块的模型，如果在本模块下找不到，则自动装载全局模型
		$this->Main_data_model->start();
		echo "hmvc<br>";
		$this->load->view('view_test');
	}
}
