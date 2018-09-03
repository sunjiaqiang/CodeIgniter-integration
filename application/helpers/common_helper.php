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