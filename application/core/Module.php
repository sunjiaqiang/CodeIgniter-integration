<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * HMVC Module 类
 *
 * HMVC 核心对象
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @author		Hex
 * @category	HMVC
 * @link		http://codeigniter.org.cn/forums/thread-1319-1-2.html
 */
class CI_Module {

	/**
	 * Constructor
	 *
	 * @access public
	 */
	function __construct()
	{
		// 实例化自己的 Loader 类
		$CI =& get_instance();
		$this->load = clone $CI->load;

		// CI 系统对象采用引用传递的方式，直接赋值给 Module。
		// 当然也可以采用 clone 的方式，可能需要根据不同项目做权衡。
		foreach ($CI->load->get_base_classes() as $var => $class)
		{
			// 排除 Loader 类，因为已经 clone 过了
			if ($var == 'loader')
			{
				continue;
			}
			// 赋值给 Module
			$this->$var =& $CI->$var;
		}
		// 处理自动装载的类库和模型
		$autoload = array_merge($CI->load->_ci_autoload_libraries, $CI->load->_ci_autoload_models);
		foreach ($autoload as $item)
		{
			if (!empty($item) and isset($CI->$item))
			{
				$this->$item =& $CI->$item;
			}
		}
		// 处理数据库对象
		if (isset($CI->db))
		{
			$this->db =& $CI->db;
		}

		// 利用 PHP5 的反射机制，动态确定 Module 类名和路径
		$reflector = new ReflectionClass($this);

		$path = substr(dirname($reflector->getFileName()), strlen(realpath(APPPATH.'modules').DIRECTORY_SEPARATOR));
		$class_path = implode('/', array_slice(explode(DIRECTORY_SEPARATOR, $path), 0, -1));
		$class_name = $reflector->getName();

		// 通知 Loader 类，Module 就绪
		$this->load->_ci_module_ready($class_path, $class_name);

		// 把自己放到全局超级对象中
		$CI->$class_name = $this;

		log_message('debug', "$class_name Module Class Initialized");
	}

    //下面的方法是官方的hmvc扩展上自己扩展的提示信息方法
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
        include(APPPATH.(check_wap() ? 'errors/jump_m.php' : 'errors/jump.php'));
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;exit;
    }
}

// END Module Class

/* End of file Module.php */
/* Location: ./application/core/Module.php */
