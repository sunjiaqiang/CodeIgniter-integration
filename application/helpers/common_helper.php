<?php
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/7/26
 * Time: 16:10
 */
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