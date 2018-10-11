<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/9/6
 * Time: 10:42
 */
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    class Excel_Index_module extends CI_Module{
        public function __construct()
        {
            parent::__construct();
            $this->load->model('ajaxpage.Article_model');
        }

        /**
         * excel导入1
         */
        public function index(){

            p($GLOBALS['test']);
            p(ROOTPATH);

            $this->load->view('index');
        }

        /**
         * 异步上传
         */
        public function ajax_upload(){
            $allow_ext = ['xls','xlsx'];//允许上传的类型
            $allow_max_size = 5*1024*1024;//5m=5242880 b 允许上传的大小
            $save_path = './public/uploads/xls/';//后面必须加/
            $this->load->library('myfile');
            $this->myfile->allowExts = $allow_ext;//配置上传类型
            $this->myfile->savePath = $save_path;//配置保存路径
            $this->myfile->maxSize = $allow_max_size;//配置允许上传的最大size
            $file_arr = $this->myfile->upload(2,'file');

            $file_name = $file_arr['file'];
            $inputFileType = 'Xlsx';
            $reader = IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($file_name);
            $sheetData = $spreadsheet->getSheet(0);
            $highestRow = $sheetData->getHighestDataRow();//获取excel总行数
            $child_num = 0 ;
            for ($row = 2; $row <= $highestRow; $row++) //行数是以第1行开始，第一行是标题
            {
                $name_tmp = $sheetData->getCell('A' . $row)->getValue() ;
                $result[$row - 2]['name'] = empty($name_tmp) ? '请填写姓名' : $name_tmp;
                $gender_tmp = $sheetData->getCell('B' . $row)->getValue();
                $result[$row - 2]['gender'] = empty($gender_tmp) ? 0 : ($gender_tmp == '男') ? 1 : 2;
                $result[$row - 2]['type'] = $this->_get_tourist_type($sheetData->getCell('C' . $row)->getValue());
                if($sheetData->getCell('C' . $row)->getValue() == '儿童') $child_num++;
                $result[$row-2]['phone_num'] = $sheetData->getCell('D'.$row)->getValue();
                $result[$row-2]['id_card_type'] = $this->_get_id_card_type($sheetData->getCell('E'.$row)->getValue());
                $id_num = $sheetData->getCell('F'.$row)->getValue();
                $result[$row-2]['id_number'] = $sheetData->getCell('F'.$row)->getValue();
                $singleroom_tmp = $sheetData->getCell('G'.$row)->getValue();
                $result[$row-2]['singleroom'] = empty($singleroom_tmp) ? 0 : ($singleroom_tmp == '是' ) ? 1 :0 ;
                $result[$row-2]['note'] = $sheetData->getCell('H'.$row)->getValue();
                $result[$row-2]['age'] = floor((time()-strtotime(substr($id_num,6,4)))/3600/24/365);
            }

            foreach ($result as $key=>$val){
                //去除脏数据
                if(!strlen($val['type']))
                {
                    unset($result[$key]);
                }
            }
            file_exists($file_name) and unlink($file_name);//上传完成删除数据
            echo json_encode($result);
        }

        /**
         * 导出数据到excel
         * @throws \PhpOffice\PhpSpreadsheet\Exception
         * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
         */
        public function export_xls(){
            $cur_page = ($this->input->get_post('page')) ? $this->input->get_post('page') : 1;
            $page_size = 1000;//每页导出一千条数据

            $export = $this->input->get_post('export');
            if($export == 1){
                $result = $this->Article_model->get_tourist($page_size,$cur_page);
                $spreadsheet = new Spreadsheet();
                $worksheet = $spreadsheet->getActiveSheet();
                //设置工作表标题名称
                $spreadsheet->getProperties()
                    ->setCreator("Maarten Balliauw")
                    ->setLastModifiedBy("Maarten Balliauw")
                    ->setTitle("游客表")
                    ->setSubject("Office 2007 XLSX Test Document")
                    ->setDescription(
                        "Test document for Office 2007 XLSX, generated using PHP classes."
                    )
                    ->setKeywords("office 2007 openxml php")
                    ->setCategory("Test result file");

                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', '姓名')
                    ->setCellValue('B1', '性别')
                    ->setCellValue('C1', '类型')
                    ->setCellValue('D1', '手机号')
                    ->setCellValue('E1', '证件类型')
                    ->setCellValue('F1', '证件号')
                    ->setCellValue('G1', '单房差')
                    ->setCellValue('H1', '备注');

                if (count($result) > 0){
                    foreach ($result as $key=>$val){
                        $index= $key+2;
                        $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('A'.$index,$val['name'])
                            ->setCellValue('B'.$index,$this->get_sex($val['gender']))
                            ->setCellValue('C'.$index,$this->change_tourist_type($val['type']))
                            ->setCellValue('D'.$index,$val['phone_num'])
                            ->setCellValue('E'.$index,$this->change_id_card_type($val['id_card_type']))
                            ->setCellValue('F'.$index,$val['id_number'])
                            ->setCellValue('G'.$index,($val['singleroom'] == 0) ? '否' : '是')
                            ->setCellValue('H'.$index,$val['note']);
                    }
                }

                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '333333'],
                        ],
                    ],
                ];

                $styleArrayBody = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '666666'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ],
                ];
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(60);
                $worksheet->getStyle('A1:H1')->applyFromArray($styleArray);
                $worksheet->getStyle('A2:H'.$index)->applyFromArray($styleArrayBody);

                $spreadsheet->getActiveSheet()->setTitle('游客表');
                $spreadsheet->setActiveSheetIndex(0);

                /* Here there will be some code where you create $spreadsheet */

                // redirect output to client browser
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="myfilep.xlsx"');
                header('Cache-Control: max-age=0');

                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
            }

            $total = $this->Article_model->get_tourist_count();

            $total_page = ceil($total/$page_size);
            $export_str = '';

            for($i=1;$i<=$total_page;$i++){
                $start = ($i-1)*$page_size;
                $end = $start+$page_size;
                if($i == $total_page) $end = $total;
                $export_str.='<option value="'.$i.'">'.$start.'-'.$end.'</option>';
            }
            $arr['export_str'] = $export_str;
            $this->load->view('export',$arr);

        }

        /**
         * 导出excel时转换类型
         * @param $type
         */
        public function change_tourist_type($type){
            switch ($type){
                case 1:
                    $str = "成人";
                    break;
                case 0:
                    $str = "儿童";
                    break;
                default:
                    $str = "未知";
            }
            return $str;
        }

        /**
         * 改变身份类型
         * @param $id_card_type
         */
        public function change_id_card_type($id_card_type){
            switch ($id_card_type){
                case 1:
                    $str = "身份证";
                    break;
                case 2:
                    $str = "护照";
                    break;
                case 3:
                    $str = "港澳通行证";
                    break;
                case 4:
                    $str = "台胞证";
                    break;
                case 5:
                    $str = "海员证";
                    break;
                case 6:
                    $str = "旅行证";
                    break;
                case 7:
                    $str = "其他";
                    break;
                default:
                    $str = "未知";
            }
            return $str;
        }

        /**
         * 获取性别
         * @param $gender
         */
        public function get_sex($gender){
            switch ($gender){
                case 0:
                    $str = "保密";
                    break;
                case 1:
                    $str = "男";
                    break;
                case 2:
                    $str = "女";
                    break;
                default:
                    $str = "未知";
            }
            return $str;
        }

        /**
         * 获取游客类型
         * @param string $type
         */
        private function _get_tourist_type($type)
        {
            if(empty($type)) return false;
            switch($type)
            {
                case '成人':
                    $result = 0 ;
                    break;

                case '儿童':
                    $result = 1 ;
                    break;

                default:
                    $result = 0 ;
                    break;
            }
            return $result ;
        }

        /**
         * 获取证件类型
         * @param string $type
         */
        private function _get_id_card_type($type)
        {
            switch($type)
            {
                case '身份证':
                    $result = 1 ;
                    break;
                case '护照':
                    $result = 2 ;
                    break;
                case '港澳通行证':
                    $result = 3 ;
                    break;
                case '台胞证':
                    $result = 4 ;
                    break;
                case '海员证':
                    $result = 5 ;
                    break;
                case '旅行证':
                    $result = 6 ;
                    break;
                case '其他':
                    $result = 7 ;
                    break;
                default:
                    $result = 1 ;
                    break;
            }
            return $result ;
        }

        /**
         * 下载文件
         */
        public function download(){
            $file_path = $this->input->get('file_path');
            if ( ! file_exists($file_path)){
                echo "文件不存在";
                exit();
            }
            download($file_path,'youkemuban.xlsx');
        }
    }