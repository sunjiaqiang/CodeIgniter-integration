<?php
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/9/12
 * Time: 17:36
 */

$today = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')));

$today_end = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1);

echo $today,'<br>';//今天开始时间

echo $today_end,'<br>';//今天结束时间

$yesterday_start = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')-1,date('Y')));
$yesterday_end = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y'))-1);

echo $yesterday_start,'<br>';//昨天开始时间

echo $yesterday_end,'<br>';//昨天结束时间

$w = date('w',strtotime($today));


$this_mon = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')-$w+1,date('Y')));

$this_sun = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')+(7-$w),date('Y')));

echo $this_mon,'<br>';//本周一时间

echo $this_sun,'<br>';//本周日时间

$last_week_mon = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')-$w+1-7,date('Y')));

$last_week_sun = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')-$w,date('Y')));
echo $last_week_mon,'<br>';//上周一

echo $last_week_sun,'<br>';//上周日

$last_yue_start = date('Y-m-d H:i:s',mktime(0,0,0,date('m')-1,str_pad(1,2,0,STR_PAD_LEFT),date('Y')));

$last_month_days = date('t',strtotime(date('Y').'-'.(date('m')-1).'-'.str_pad(1,2,0,STR_PAD_LEFT)));

$last_yue_end = date('Y-m-d H:i:s',mktime(0,0,0,date('m')-1,$last_month_days,date('Y')));


echo $last_yue_start,'<br>';//上月1号

echo $last_yue_end,'<br>';//上月末

$num = '20';

$num2 = '2220';

echo $num+$num2;