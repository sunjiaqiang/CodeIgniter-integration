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