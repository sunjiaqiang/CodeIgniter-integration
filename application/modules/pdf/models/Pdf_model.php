<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once './vendor/tecnickcom/tcpdf/tcpdf.php';
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/9/3
 * Time: 11:07
 */
    class Pdf_pdf_model extends CI_Model{
        /**
         * 打印pdf
         */
        public function print_pdf(){
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            // 设置文档信息
            $pdf->SetTitle('测试pdf');

            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            // 设置默认等宽字体
            $pdf->SetDefaultMonospacedFont('courier');

            // 设置间距
            $pdf->SetMargins(15, 27, 15);
            $pdf->SetCellPadding(0);
            $pdf->SetHeaderMargin(1);
            $pdf->SetFooterMargin(1);

            // 设置分页
            $pdf->SetAutoPageBreak(TRUE, 10);

            // set image scale factor
            $pdf->setImageScale(1.25);

            // set default font subsetting mode
            $pdf->setFontSubsetting(true);

            //设置字体
            //$pdf->SetFont('stsongstdlight', '', 10);
            $pdf->SetFont('stsongstdlight', '', 9, '', true);
            //$pdf->SetFont('droidsansfallback', '', 9);

            $pdf->AddPage();
            $pdf->writeHTML($this->cover());//写入pdf内容
            $pdf->writeHTML($this->body());//写入pdf内容
            $pdf->Image('public/images/fq_1.jpg',160,100,30);//写入图片
            $pdf->Output('pdf.pdf', 'I');
        }

        /**
         * 封面
         * @return string
         */
        public function cover(){
            $html='
          <table>
		    <tr><td style="height:25px;font-size: 28px;">GF-2014-240</td></tr>
		    <tr><td style="height:200px;font-size: 30px;text-align:center;"></td></tr>
		    <tr><td style="height:25px;font-size: 30px;text-align:center;">旅游合同</td></tr>
		    <tr><td style="height:25px;font-size: 30px;text-align:center;">（示范文本）</td></tr>
		    <tr><td style="height:300px;font-size: 30px;text-align:center;"></td></tr>
		    <tr><td style="height:25px;font-size: 30px;text-align:center;">国家旅游局</td></tr>
		    <tr><td style="height:25px;font-size: 30px;text-align:right;">制定&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
		    <tr><td style="height:25px;font-size: 30px;text-align:center;">国家工商行政管理总局</td></tr>
		    <tr><td style="height:25px;font-size: 30px;text-align:center;">二〇一四年四月</td></tr>
	    </table>
	    <p>
	    <p>
	    <p>
	    <p>
	    <p>
	    <p>
            ';
            return $html;
        }
        public function body(){
            $tmp = '
            <h2 style="text-align:center;">使用说明</h2>
	    1.本合同为示范文本，供中华人民共和国境内（不含港、澳、台地区）经营出境旅游业务或者边境旅游业务的旅行社
        （以下简称“出境社”）与出境旅游者（以下简称“旅游者”）之间签订团队出境包价旅游（不含赴台湾地区旅游）合同时
        使用。<br>
        2.双方当事人应当结合具体情况选择本合同协议条款中所提供的选择项，空格处应当以文字形式填写完整。<br>
        3.双方当事人可以书面形式对本示范文本内容进行变更或者补充，但变更或者补充的内容，不得减轻或者免除应当由出
        境社承担的责任。<br>
        4.本示范文本由国家旅游局和国家工商行政管理总局共同制定、解释，在全国范围内推行使用。<br>
            ';
            return $tmp;
        }
    }