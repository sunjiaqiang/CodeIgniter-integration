<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/2 0002
 * Time: 9:48
 */
    class Calendar_calendar_model extends CI_Model{
        private $year;
        private $month;
        private $data;
        public function __construct(){
            parent::__construct();
            $this->year = isset($_GET['year']) ? $_GET['year'] : date('Y');
            $this->month = isset($_GET['month']) ? $_GET['month'] : date('m');
        }

        /**
         * 设置数据
         * @param $data
         */
        public function set_data($data){
            $this->data = $data;
        }

        public function title(){
            $week=array("日","一","二","三","四","五","六");
            $calendar='';
            $calendar.='<thead><tr>';
            for($i=0; $i<count($week); $i++){
                if($i==0 || $i==6){
                    $calendar.="<th class='zhu-color'>$week[$i]</th>";
                }else{
                    $calendar.="<th>$week[$i]</th>";
                }
            }
            $calendar.='</tr></thead>';
            echo $calendar;
        }

        /**
         * 日历主体
         */
        public function get_list(){
            $calendar = '<div class="date-item">';
            //$calendar .= "<caption>".$year."年".$monthName."月</caption>";
            $calendar .= "<thead><tr>";

            $star_time = mktime(0,0,0,$this->month,1,$this->year);
            $dayOfWeek = date('w',$star_time);
            $month = $this->month;
            $days = date('t',mktime(0,0,0,$this->month,1,$this->year));
            $calendar .= "<caption>".$this->year."年".$month."月</caption>";
            $currentDay = 1;
            $calendar .= "</tr></thead><tbody><tr>";
            if ($dayOfWeek > 0) {
                $calendar .= "<td class='gray-color' colspan='$dayOfWeek'> </td>";
            }
            $month = str_pad($month, 2, "0", STR_PAD_LEFT);
            $bar = 0; //当前年月
            if(date('m') == $month && date('Y') == $this->year) { //当前年月
                $bar = date('d');
            }

            while ($currentDay <= $days) {
                $currentDayRel = str_pad($currentDay,2,'0',STR_PAD_LEFT);
                $date = "$this->year-$month-$currentDayRel";
                if($dayOfWeek==7){
                    $dayOfWeek=0;
                    $calendar.="</tr></tr>";
                }

                $is_sign = 0;
                if (array_key_exists($date,$this->data)){//当前循环日期是否已签到
                    //echo $date,"<br>";
                    $is_sign = $this->data[$date];
                    //p($price);
                }
                // Seventh column (Saturday) reached. Start a new row.


                if ($is_sign>0){
                    if ($bar>0){
                        if ($currentDay == $bar){
                            $tip = "今天<p class='red-color'>已签到</p>";
                        }elseif ($currentDay == $bar+1){
                            $tip = "明天<p class='gray-color'>请期待</p>";
                        }elseif ($currentDay == $bar+2){
                            $tip = "后天<p class='gray-color'>请期待</p>";
                        }else{
                            $tip= "$currentDay<p class='red-color'>已签到</p>";
                        }
                    }else{
                        $tip= "$currentDay<p class='red-color'>已签到</p>";
                    }
                }else{
                    if ($bar>0){
                        if ($currentDay == $bar){
                            $tip = "<a href='javascript:;' class='sign' onclick='sign(this)'>今天<p class='gray-color'>可签到</p></a>";
                        }elseif ($currentDay == $bar+1){
                            $tip = "明天<p class='gray-color'>请期待</p>";
                        }elseif ($currentDay==$bar+2){
                            $tip = "后天<p class='gray-color'>请期待</p>";
                        }else{
                            $tip = "$currentDay<p class='gray-color'>未签到</p>";
                        }

                    }else{
                        $tip="$currentDay<p class='gray-color'>未签到</p>";
                        // echo $tip;
                    }

                }

                $calendar.="<td>".$tip."</td>";

                $dayOfWeek++;
                $currentDay++;
                //echo $calendar;
            }

            if($dayOfWeek!=7){
                $remainDay = 7-$dayOfWeek;
                $calendar.="<td colspan='$remainDay'></td>";
            }
            $calendar .= "</tr>";
            $calendar .= "</tbody></div>";
            echo $calendar;
        }

        public function out(){
            echo '<table align="center">';
            $this->title();
            $this->get_list();
            echo "</table>";
        }

        /**
         * 获取签到数据
         */
        public function get_sign_data(){
            $start_time = mktime(0,0,0,$this->month,1,$this->year);
            $days = date('t',mktime(0,0,0,$this->month,1,$this->year));
            $end_time = mktime(11,59,59,$this->month,$days,$this->year);
            $sql = "select id,uid,FROM_UNIXTIME(sign_time,'%Y-%m-%d') s_time from t_sign where (sign_time>='$start_time' and sign_time<='$end_time') and uid=1 order by sign_time desc";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            $dayArr=array();
            if( ! $result) return [];
            for ($i=$days-1;$i>=0;$i--){
                $dayArr[] = date('Y-m-d',strtotime(date('Y-m-d',$end_time)."-$i days"));
            }

            foreach ($result as $key=>$val){
                $arr1[$val['s_time']] = $val;
            }
//            p($arr1);
            foreach ($dayArr as $key=>$val){
                if (array_key_exists($val,$arr1)){
                    $arr2[$val] = 1;
                }else{
                    $arr2[$val]=0;
                }
            }
//            p($arr2);
            //p($newArr);
            return $arr2;
        }

        /**
         * 签到
         */
        public function sign_up(){
            $data=array(
                'uid'=>1,
                'sign_time'=>time()
            );
            if($this->db->insert('t_sign',$data)){
                return $this->db->insert_id();
            }else{
                return FALSE;
            }
        }
    }