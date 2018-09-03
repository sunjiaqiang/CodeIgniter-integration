<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/9/3
 * Time: 11:06
 */
    class Pdf_Index_module extends CI_Module{
        public function __construct()
        {
            parent::__construct();
            $this->load->model('pdf.Pdf_model');
        }
        public function index(){
            $this->Pdf_model->print_pdf();
        }
    }