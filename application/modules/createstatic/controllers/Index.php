<?php
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/9/3
 * Time: 9:38
 */
 class Createstatic_Index_module extends CI_Module{
     public function __construct()
     {
         parent::__construct();
         $this->load->model('ajaxpage.Article_model');
     }
     /**
      * 生成静态首页
      */
     public function index(){
         if (strtolower($_SERVER['REQUEST_METHOD']) == 'post'){
             //修改最大执行时间
             ini_set('max_execution_time', '0');
             //修改此次最大运行内存
             ini_set ('memory_limit', '512M');
             $all_news = $this->Article_model->get_all(1,46809);
//            if (! file_exists('cache/article_ids.php')){
//
//            }
             create_folders('cache');
             $str = '<?php ';
             $str.=' return '.var_export($all_news,true).'';
             $str.=';';
             file_put_contents('cache/article_ids.php',$str);

             $all_cate = $this->Article_model->get_all_cate();
             $cat_str = "<?php \nreturn ".var_export($all_cate,true).";";
             file_put_contents('cache/article_cate.php',$cat_str);
             $page_size = 5;//每页生成条数
             $total = count($all_news);//总条数
             $total_page = ceil($total/$page_size);//总页数
             $this->success("准备工作已经结束，开始生成",site_url('createstatic/index/shengcheng?page_size='.$page_size.'&total_page='.$total_page.'&total='.$total.'&cur_page=1'),3);
             exit;
         }
//        $this->success("成功",'index','5');
//        exit;
         $this->load->view('index');
     }

     public function shengcheng(){
         $page_size = $this->input->get('page_size');
         $total_page = $this->input->get('total_page');
         $total = $this->input->get('total');
         $cur_page = $this->input->get('cur_page');
         $all_content_id = include ('cache/article_ids.php');
         $time_start = $this->input->get('time_start') ?: date('Y-m-d H:i:s');
         $all_cate = include ('cache/article_cate.php');

         $this->load->library('Mydir');
         if (count($all_content_id) > 0){
             $left_total =  $total - ($cur_page-1)*$page_size;
             //开始生成内容
             for ($i=0;$i<min($page_size,$left_total);$i++){
                 $article_id = array_shift($all_content_id);
                 $data = $this->Article_model->get_row_article($article_id);
                 $cat_name = $all_cate[$data['catid']] ? $all_cate[$data['catid']]['dirname'] : '';
                 if ($cat_name){
                     $pathname = 'jingtai/'.$cat_name.'/'.$article_id.'.html';
                 }else{
                     $pathname = 'jingtai/'.$article_id.'.html';
                 }

                 $tpl = 'article';
                 $html = $this->load->view($tpl,$data,true);
                 $this->mydir->unlinkFile($pathname);
                 $this->mydir->createFile($pathname);
                 $this->mydir->writeFile($pathname,$html);
             }

             $str = '<?php ';
             $str.=' return '.var_export($all_content_id,true).'';
             $str.=';';
             file_put_contents('cache/article_ids.php',$str);

             $ygx = $cur_page*$page_size;
             if ($cur_page == $total_page){
                 $ygx = $total;
             }

//            $percent = round($ygx/$total,2);

//            p($percent);
//            p($total);
             $ysc = ($total-count($all_content_id)+min(intval($page_size),count($all_content_id)));
             $percent = round($ysc/$total,2);
             $arr['percent'] = $percent;
             $arr['msg'] = "已生成".$ysc."个文件,总共需要生成".$total."个文件,到达".($percent*100)."%";
             $this->load->view('bar',$arr);
             $cur_page+=1;
             $url = site_url('createstatic/index/shengcheng?page_size='.$page_size.'&total_page='.$total_page.'&total='.$total.'&cur_page='.$cur_page.'&time_start='.$time_start);
//            echo $url;
             $timeout = 500;

//            echo $tmp;
             echo('<script>setTimeout("redirect(\''.$url.'\');",'.$timeout.');</script>');
             //exit;
//            echo ('<script>setTimeout("redirect('.$url.')",'.$timeout.');</script>');
             //$this->success("当前栏目【".$all_cate[$data['cat_id'] ?:'未知栏目']."】,共需更新<font color='red'>$total</font> 个网页,已更新<font color='red'>$ygx</font>个网页",site_url('createstatic/jingtai/shengcheng?page_size='.$page_size.'&total_page='.$total_page.'&total='.$total.'&cur_page='.$cur_page),1);

         }else{
             $time_start = $this->input->get('time_start');
             $time_end = date('Y-m-d H:i:s');
             $haoshi = floor((strtotime($time_end)-strtotime($time_start))/60);//分钟
             $arr['percent'] = 1;
             $arr['msg'] = "全部生成成功，耗时：".$haoshi."分钟";
             $arr['success_class'] = 'progress-success';
             $tmp = $this->load->view('bar',$arr,true);
             echo $tmp;
             //$this->success("全部生成成功",'','10');
         }


//        p("开始生成");
//        p($page_size.' '.$total_page.' '.$total);
     }

     public function get_cate_name($cat_id){
         $all_cate = include ('cache/article_cate.php');
         return isset($all_cate[$cat_id]) ? $all_cate[$cat_id] : '未知栏目';
     }

     /**
      * 操作错误跳转的快捷方法
      * @access protected
      * @param string $message 错误信息
      * @param string $jumpUrl 页面跳转地址
      * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
      * @return void
      */
     protected function error($message='',$jumpUrl='',$ajax=true) {
         $this->dispatchJump($message,0,$jumpUrl,$ajax);
     }

     /**
      * 操作成功跳转的快捷方法
      * @access protected
      * @param string $message 提示信息
      * @param string $jumpUrl 页面跳转地址
      * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
      * @return void
      */
     protected function success($message='',$jumpUrl='',$ajax=false) {
         $this->dispatchJump($message,1,$jumpUrl,$ajax);
     }

     /**
      * Ajax方式返回数据到客户端
      * @access protected
      * @param mixed $data 要返回的数据
      * @param String $type AJAX返回数据格式
      * @return void
      */
     protected function ajaxReturn($data,$type='') {
         if(empty($type)) $type  =   'json';
         switch (strtoupper($type)){
             case 'JSON' :
                 // 返回JSON数据格式到客户端 包含状态信息
                 header('Content-Type:application/json; charset=utf-8');
                 exit(json_encode($data));
             case 'XML'  :
                 // 返回xml格式数据
                 header('Content-Type:text/xml; charset=utf-8');
                 exit(xml_encode($data));
             case 'EVAL' :
                 // 返回可执行的js脚本
                 header('Content-Type:text/html; charset=utf-8');
                 exit($data);
             default     :
                 // 用于扩展其他返回格式数据
         }
     }

     /**
      * 默认跳转操作 支持错误导向和正确跳转
      * 调用模板显示 默认为public目录下面的success页面
      * 提示页面为可配置 支持模板标签
      * @param string $message 提示信息
      * @param Boolean $status 状态
      * @param string $jumpUrl 页面跳转地址
      * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
      * @access private
      * @return void
      */
     private function dispatchJump($message,$status=1,$jumpUrl='',$ajax=false) {
         if(true === $ajax) {// AJAX提交
             $data           =   is_array($ajax)?$ajax:array();
             $data['info']   =   $message;
             $data['status'] =   $status;
             $data['url']    =   $jumpUrl;
             $this->ajaxReturn($data);
         }
         if(is_int($ajax)) $data['waitSecond'] = $ajax;
         if(!empty($jumpUrl))$data['jumpUrl'] = $jumpUrl;
         $data['msgTitle'] = $message ? $message : ($status?'操作成功' : '操作失败');
         $data['status'] = $status;// 状态
         if($status) { //发送成功信息
             $data['message'] = $message;// 提示信息
             $data['waitSecond'] = $ajax;
             if(empty($jumpUrl)) $data['jumpUrl'] = $_SERVER["HTTP_REFERER"];
         }else{

             $data['error'] = $message;// 提示信息
             $data['waitSecond'] = $ajax;
             $data['jumpUrl'] = $jumpUrl?$jumpUrl:"javascript:history.back(-1);";
         }
         $buffer = '';
         ob_start();
         include(APPPATH.'controllers/errors/jump.php');
         $buffer = ob_get_contents();
         ob_end_clean();
         echo $buffer;exit;
     }
 }