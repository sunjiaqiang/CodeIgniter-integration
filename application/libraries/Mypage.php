<?php 
	/**
	* 自定义分页类
	* 支持ajax
	*/
	class Mypage{
		private $cur_page;//当前页
		private $total_rows;//总条数
		private $per_page;//每页显示的条数
		private $total_page;//总页数
		private $base_url;//当前页面链接地址
		private $first_page;//首页
		private $prev_page;//上一页
		private $next_page;//下一页
		private $last_page;//尾页
		private $num_links;//当前页前后显示几条页码
		private $params;//分页所带参数
		private $seg=3;
		private $mode='';//分页模式,为ajax时表示ajax分页
		private $model_name = 'search_list';//为ajax分页时的js函数名称

        /**
         * 构造函数初始化分页配置
         * Mypage constructor.
         * @param array $params 分页配置数组
         */
		public function __construct(array $params=array()){
			if (count($params)>0) {
				$this->initialize($params);
				log_message('info', 'Pagination Class Initialized');
			}
		}

        /**
         * 初始化分页配置
         * @param array $params 分页配置数组
         */
		public function initialize( array $params=array()){
			$this->cur_page = $params['cur_page'] ? intval($params['cur_page']) : 1;
			$this->total_rows = $params['total_rows'] ? intval($params['total_rows']) : '';
			$this->per_page = $params['per_page'] ? intval($params['per_page']) : 12;
			$this->base_url = isset($params['base_url']) ? $params['base_url'] : '';
			$this->first_page = isset($params['first_page']) ? $params['first_page'] : '首页';
			$this->prev_page = isset($params['prev_page']) ? $params['prev_page'] : '上一页';
			$this->next_page = isset($params['next_page']) ? $params['next_page'] : '下一页';
			$this->last_page = isset($params['last_page']) ? $params['last_page'] : '尾页';
			$this->num_links = isset($params['num_links']) ? $params['num_links'] : 2;
			$this->mode = isset($params['mode']) ? $params['mode'] : '';
			$this->model_name = isset($params['model_name']) ? $params['model_name'] : 'search_list';
			$this->params = isset($params['params']) ? $params['params'] : '';
			$this->total_page = ceil($this->total_rows/$this->per_page);
			$this->_myset_url($this->base_url);//设置链接地址
		}

		/**
         * 生成上一页页码地址
		 * [prev_page description]
		 * @return [type] [description]
		 */
		private function prev_page(){
			if($this->cur_page>1 && $this->total_page!=1){
				return $this->_get_link($this->_get_url($this->cur_page-1),$this->prev_page);
			}
			return '<span>'.$this->prev_page.'</span>';
		}
		/**
         * 生成下一页页码地址
		 * [next_page description]
		 * @return [type] [description]
		 */
		private function next_page(){
			if ($this->cur_page<$this->total_page) {
				return $this->_get_link($this->_get_url($this->cur_page+1),$this->next_page);
			}
			return '<span>'.$this->next_page.'</span>';
		}
		/**
         * 生成第一页页码地址
		 * [get_first_page description]
		 * @return [type] [description]
		 */
		private function get_first_page(){
			if ($this->cur_page>1 && $this->total_page!=1) {
				return $this->_get_link($this->_get_url(1),$this->first_page);
			}
			return '<span>'.$this->first_page.'</span>';
		}

        /**
         * 生成最后一页页码地址
         * @return string
         */
		private function get_last_page(){
			if ($this->cur_page<$this->total_page) {
				return $this->_get_link($this->_get_url($this->total_page),$this->last_page);
			}
			return '<span>'.$this->last_page.'</span>';
		}
		/**
         * 生成中间数字页码
		 * [now_bar description]
		 * @return [type] [description]
		 */
		private function now_bar(){
			$plus=$this->num_links;
			if ($this->cur_page>$plus) {
				$ben=$this->cur_page-$plus;				
				$end=$this->cur_page+$plus;
				if ($end>$this->total_page) {
					$ben=($this->total_page-2*$plus)>0 ? ($this->total_page-2*$plus) : 1;
					$end=$this->total_page;
				}
			}else{
				$ben=1;
				$end=$ben+2*$plus;
				$end=($end>$this->total_page) ? $this->total_page : $end;
			}
			$out='';
			for ($i=$ben; $i <= $end; $i++) {
				if ($i==$this->cur_page) {
				 	$out.='<span>'.$i.'</span>';
				 }else{				 	
					$out.=$this->_get_link($this->_get_url($i),$i);
				 } 
			}

			return $out;
		}
		/**
         * 生成下拉框页码选择
		 * [select_page description]
		 * @return [type] [description]
		 */
		private function select_page(){
			$url=$this->base_url.'/';
			$out='<select name="pagelect" class="pg_select" data-uri="'.$this->base_url.'" data-param="'.$this->params.'">';
			if($this->mode=='ajax'){
				$out='<select onchange="'.$this->model_name.'(this.value);return false;">';
			}
			for ($i=1; $i <= $this->total_page ; $i++) {
				if ($i==$this->cur_page) {
					$out.='<option selected value="'.$i.'">'.$i.'</option>';
				}else{
					$out.='<option value="'.$i.'">'.$i.'</option>';
				}
			}
		    $out.='</select>';
			return $out;
		}

		/**
         * 输出分页
		 * [show description]
		 * @return [type] [description]
		 */
		public function show(){
			return $this->show_total().$this->show_total_page().$this->get_first_page().$this->prev_page().$this->now_bar().$this->next_page().$this->get_last_page().'&nbsp;第'.$this->select_page().'页';
		}

		/**
         * 获取指定页码的地址
		 * [_get_url description]
		 * @param  [type] $num [description]
		 * @return [type]      [description]
		 */
		private function _get_url($num){
			if($this->mode == 'ajax') return $num;
			return $this->base_url.'/'.$num;
		}
        /**
        * 设置url头地址
        * @param: String $url
        * @return boolean
        */
        public function _myset_url($url)
        {
            /*$CI=&get_instance();
            $CI->load->helper('url');
            if (empty($url)) {//如果$url为空，要用uri_string()函数取uri段
                $cururl='';
                $cururl=uri_string();
                $segementarray=explode("/",$cururl);
                $c=0;
                for ($i=0; $i < sizeof($segementarray); $i++) {
                    if ($segementarray[$i] && $c < $this->seg-1) {//取uri_string()的seg-1段
                        $url=$url.'/'.$segementarray[$i];
                        $c++;
                    }
                }
            }
            $this->base_url=base_url($url);*/
            if (empty($url)) {
                   $cururl=$_SERVER['REDIRECT_QUERY_STRING'];
                   $url_arr=explode('/',$cururl);
                   foreach ($url_arr as $key => $val) {
                        if (empty($key)) {
                            unset($url_arr[$key]);
                        }
                   }
                   $c=0;
                  foreach ($url_arr as $key => $val) {
                     if($url_arr[$key] && $c<$this->seg-1){
                         $url=$url.'/'.$val;
                         $c++;
                     }

                  }
                   $this->base_url=base_url($url);
            }

        }
     
		/**
         * 获取指定地址的a链接
		 * [_get_link description]
		 * @param  [type] $url  [description]
		 * @param  [type] $text [description]
		 * @return [type]       [description]
		 */
		private function _get_link($url,$text){
			if($this->mode != 'ajax'){
				if ($this->params) {
					$url.=$this->params;
				}
			}

			if($this->total_page>1){
				if($this->mode == 'ajax'){
					if ($this->params) {
						$param = $this->params;
					}else{
						$param = '';
					}
					return '<a href="javascript:;" onclick="'.$this->model_name.'('.$url.')" param="'.$param.'">'.$text.'</a>';
				}
				return '<a href="'.$url.'">'.$text.'</a>';
			}
			return '<span>'.$text.'</span>';
		}
		/**
         * 获取总条数
		 * [show_total description]
		 * @return [type] [description]
		 */
		private function show_total(){
			return '共'.$this->total_rows.'条';
		}
		/**
         * 获取总页数
		 * [show_total_page description]
		 * @return [type] [description]
		 */
		private function show_total_page(){
			return '共'.$this->total_page.'页';
		}
	}
?>