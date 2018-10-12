<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/10/12
 * Time: 16:10
 */
class Buyer_Index_module extends CI_Module{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function index(){
       p('散客线路');
    }
    public function index_new(){
        p('新主页01');
    }
}