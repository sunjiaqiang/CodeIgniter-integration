<?php
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/7/26
 * Time: 16:10
 */

if( ! function_exists('lock_url')){
    //加密函数
    function lock_url($txt,$key='xiaoqiang')
    {
        $txt = $txt.$key;
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";
        $nh = rand(0,64);
        $ch = $chars[$nh];
        $mdKey = md5($key.$ch);
        $mdKey = substr($mdKey,$nh%8, $nh%8+7);
        $txt = base64_encode($txt);
        $tmp = '';
        $i=0;$j=0;$k = 0;
        for ($i=0; $i<strlen($txt); $i++) {
            $k = $k == strlen($mdKey) ? 0 : $k;
            $j = ($nh+strpos($chars,$txt[$i])+ord($mdKey[$k++]))%64;
            $tmp .= $chars[$j];
        }
        return urlencode(base64_encode($ch.$tmp));
    }
}
if( ! function_exists('unlock_url')){
    //解密函数
    function unlock_url($txt,$key='xiaoqiang')
    {
        $txt = base64_decode(urldecode($txt));
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";
        $ch = $txt[0];
        $nh = strpos($chars,$ch);
        $mdKey = md5($key.$ch);
        $mdKey = substr($mdKey,$nh%8, $nh%8+7);
        $txt = substr($txt,1);
        $tmp = '';
        $i=0;$j=0; $k = 0;
        for ($i=0; $i<strlen($txt); $i++) {
            $k = $k == strlen($mdKey) ? 0 : $k;
            $j = strpos($chars,$txt[$i])-$nh - ord($mdKey[$k++]);
            while ($j<0) $j+=64;
            $tmp .= $chars[$j];
        }
        return trim(base64_decode($tmp),$key);
    }

}

if( ! function_exists('make_url')){
    //url参数组装
    function make_url($condition,$key='',$val=''){
        if(isset($condition[$key])){
            $condition[$key] = $val;
        }
        if(isset($condition[$key]) && $val==-1){
            unset($condition[$key]);
        }
        $link = '?';
        $suffix = '&';
        $arr='';
        foreach($condition as $key=>$val){
            $arr.= $key."=".$val.$suffix;
        }
        return rtrim($link.$arr,$suffix);
    }
}

if ( ! function_exists('create_folders')){
    /**
     * 递归创建目录
     * @param $path
     * @return bool
     */
    function create_folders($path){
        if ( ! is_dir($path)){
            create_folders(dirname($path));
        }
        return is_dir($path) OR mkdir($path,0777);
    }
}

/**
 * 发送邮件
 * @param  string $address 需要发送的邮箱地址
 * @param  string $subject 标题
 * @param  string $content 内容
 * @return boolean         是否成功
 */
if( ! function_exists('send_email')){
    function send_email($address,$subject,$content){
        $email_smtp='smtp.163.com';
        $email_username='';//此处填写你的163邮箱
        $email_password='';//此处填写你的163邮箱独立密码
        $email_from_name="邮件系统";//
        if(empty($email_smtp) || empty($email_username) || empty($email_password) || empty($email_from_name)){
            return array("error"=>1,"message"=>'邮箱配置不完整');
        }
        //引入邮件发送类
        require APPPATH.'libraries/PHPmailer/class.phpmailer.php';
        require APPPATH.'libraries/PHPmailer/class.smtp.php';
        $phpmailer=new Phpmailer();
        // 设置PHPMailer使用SMTP服务器发送Email
        $phpmailer->IsSMTP();
        // 设置为html格式
        $phpmailer->IsHTML(true);
        // 设置邮件的字符编码'
        $phpmailer->CharSet='UTF-8';
        // 设置SMTP服务器。
        $phpmailer->Host=$email_smtp;
        // 设置为"需要验证"
        $phpmailer->SMTPAuth=true;

        //$phpmailer->Port = 25;

        $phpmailer->SMTPSecure = 'ssl';
        $phpmailer->Port = 465;//25端口被阿里云给禁止了，现在使用465端口

        // 设置用户名
        $phpmailer->Username=$email_username;
        // 设置密码
        $phpmailer->Password=$email_password;
        // 设置邮件头的From字段。
        $phpmailer->From=$email_username;
        // 设置发件人名字
        $phpmailer->FromName=$email_from_name;

        //添加收件人地址，可以多次使用来添加多个收件人
        //$phpmailer->AddAddress($address);

        //这里我是设置了多个收件人

        $phpmailer->AddAddress($address);

        // 设置邮件标题
        $phpmailer->Subject=$subject;
        // 设置邮件正文
        $phpmailer->Body=$content;

        // 发送邮件。
        if(!$phpmailer->Send()) {
            $phpmailererror=$phpmailer->ErrorInfo;
            return array("error"=>1,"message"=>$phpmailererror);
        }else{
            return array("error"=>0);
        }
    }
}

/**
 * 另一种方法，推荐使用
 * 下载文件
 * @param $filename 文件地址
 * @param $out_name 文件别名
 */
if ( ! function_exists('download')){
    function download($filename,$out_name){
        $size = filesize($filename);
        $file = fopen($filename, 'r');

        header("content-type:application/octet-stream");
        header("accept-ranges:bytes" );
        header("Content-Length:" . $size);
        header("content-disposition:attachment;filename=" . $out_name);

        //echo fread($file, $size);

        $buffer=1024;
        $buffer_count=0;
        while(!feof($file)&&$size-$buffer_count>0){
            $data=fread($file,$buffer);
            $buffer_count+=$buffer;
            echo $data;
        }

        fclose($file);
    }
}
/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
if ( ! function_exists('get_client_ip'))
{
    function get_client_ip($type = 0, $adv = false) {
        $type = $type ? 1 : 0;
        static $ip = NULL;
        if ($ip !== NULL)
            return $ip[$type];
        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos)
                    unset($arr[$pos]);
                $ip = trim($arr[0]);
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}
/**
 * 判断手机端
 */
if(!function_exists('check_wap'))
{
    function check_wap()
    {
        /*if(site_url('')=='http://www.66diqiu.cn/'){
            return false;
        }*/
        if(stristr(@$_SERVER['HTTP_VIA'],"wap")){// 先检查是否为wap代理，准确度高
            return true;
        }elseif(strpos(strtoupper(@$_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0){// 检查浏览器是否接受 WML.
            return true;
        }elseif(preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])){//检查USER_AGENT
            return true;
        }else{
            return false;
        }
    }
}
/**
 * 检查是否有操作相应菜单的权限
 */
if ( ! function_exists('check_auth')){
    function check_auth($auth_arr){
        if ( ! is_array($auth_arr)) return false;
        $CI = & get_instance();
        $_ACCESS_LIST = $CI->session->userdata('_ACCESS_LIST');//用户登录时保存在session中的权限
        $_ACTION_ACCESS_LIST = $CI->session->userdata('_ACTION_ACCESS_LIST');//用户登录时保存在session中的权限
        $_ACTION_ACCESS_LIST = explode(',',$_ACTION_ACCESS_LIST);
        $arr = [];
        foreach ($auth_arr as $key=>$val){
            $arr[$key] = (in_array($val,$_ACTION_ACCESS_LIST) || $_ACCESS_LIST == 'ALL') ? 1 : 0;
        }
        return $arr;
    }
}

if (!function_exists('p')) {
    /**
     * [p 传递数据以易于阅读的样式格式化后输出]
     * @param  [type] $data [传递需要打印的数据]
     * @return [type]       [string]
     */
    if( ! function_exists('p')){
        function p($data){
            // 定义样式
            $str= '<pre style="display: block;padding: 9.5px;margin: 44px 0 0 0;font-size: 13px;line-height: 1.42857;color: #333;word-break: break-all;word-wrap: break-word;background-color: #dedee0;border: 1px solid #cccccc;border-radius: 4px;">';
            // 如果是boolean或者null直接显示文字；否则print
            if (is_bool($data)){
                $show_data=$data ? 'true' : 'false';
            }elseif (is_null($data)){
                $show_data='null';
            }else {
                $show_data=print_r($data,true);
            }
            $str.=$show_data;
            $str.='</pre>';
            echo $str;
        }
    }
}