<?php 


echo phpinfo();

//list($a,$b,$c) = [1,2,3];
//var_dump($a);//1
//var_dump($b);//2
//var_dump($c);//3

/*$start_time = '2017-09-06 15:12:20';
$end_time = '2018-09-08 10:20:45';

get_time($start_time,$end_time);

function get_time($start,$end){
    $start = strtotime($start);
    $end = strtotime($end);
    if ($start > $end){
        $diff_time = $start-$end;
    }else{
        $diff_time = $end-$start;
    }

    $year_t = 3600*24*365;
    $day_t = 3600*24;
    $hours_t = 3600;
    $minute_t = 60;

    $year = floor($diff_time/$year_t);
    $days = floor(($diff_time-$year*$year_t)/$day_t);
    $hours = floor(($diff_time-($year*$year_t)-($days*$day_t))/$hours_t);
    $minute = floor(($diff_time-($year*$year_t)-($days*$day_t)-$hours*$hours_t)/$minute_t);
    $seconds = $diff_time - $minute*$minute_t-$hours*$hours_t-$days*$day_t-$year*$year_t;
//    $minute = floor();

    echo $year.'年'.$days.'天'.$hours.'小时'.$minute.'分钟'.$seconds.'秒';
}*/