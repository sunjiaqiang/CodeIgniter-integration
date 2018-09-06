<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <base href="<?= site_url('') ?>">
    <title>Excel导出</title>
    
    <script src="<?php echo base_url();?>public/js/jquery/jquery-1.9.1.min.js"></script>
    <script src="<?php echo base_url();?>public/js/plupload/plupload.min.js"></script>
    <script src="<?php echo base_url();?>public/js/jquery/jquery.tmpl.min.js"></script>
    
    <style>
a {
	color: #999;
	text-decoration:none;
}
a:hover {
	color: #ff0000;
	text-decoration:none;
}
a.cur {
	color: #ff0000;
}
h1, h2, h3, h4, h5, h6 {
	font-size: 100%;
	font-weight: normal;
}
.b2bh1 {
	padding-left: 15px;
	font-size: 14px;
	background: #28357c;
	height: 26px;
	line-height: 26px;
	color: #FFFFFF;
	font-family: "微软雅黑";
	border-top: 3px solid #ccc;
}
.iframe-lineroad-border-second {
	border-top-width: 1px;
	border-color: #bbbbbb #e0e0e0 #e0e0e0;
	table-layout: fixed;
	display: table;
	overflow: hidden;
}
.mb10 {
	margin-bottom: 10px;
}
.iframe-lineroad-table {
	vertical-align: middle;
	width: 100%;
}
.iframe-lineroad-border {
	border-style: solid;
	border-width: 1px 0 0 1px;
}
.tc {
	text-align: center;
}
.small-table-padding td {
	padding: 8px 0;
}
.iframe-lineroad-border-second td, .iframe-lineroad-border-second th {
	border-right: 1px solid #e0e0e0;
	border-bottom: 1px solid #e0e0e0;
}
.tl {
	text-align: left;
}
.orange-color {
	color: #f6922f;
}
.landscape-no-border {
	border-width: 1px;
	border-top-width: 2px;
}
.small-table-padding th {
	padding: 8px 10px;
}
#step1-table tbody tr th {
	background: #d3d9e6;
	color: #26377a;
	font-weight: 600;
}
.operation-list-wrap .button-operation-small {
	display: inline-block;
}
.operation-list-wrap .button-operation-small {
	padding: 3px 16px;
	margin: 0 6px;
}
.search-spaceing {
	margin: 0 8px;
}
.button-bg-blue {
	background-color: #2b94d9;
	border: 1px solid #2b94d9;
	font-size: 16px;
	border-radius: 5px;
	color: #fff;
}
.operation-list-wrap .button-operation-small {
	display: inline-block;
}
.operation-list-wrap .button-operation-small {
	padding: 3px 16px;
	margin: 0 6px;
}
.webuploader-container {
	display: block;
	overflow: hidden;
}
.webuploader-container {
	position: relative;
}
.search-spaceing {
	margin: 0 8px;
}
.button-bg-orange {
	background-color: #f7931e;
	border: 1px solid #f7931e;
	font-size: 16px;
	color: #fff;
	border-radius: 5px;
}
.button-operation-small {
	cursor: pointer;
	display: inline-block;
	font-size: 12px;
	height: 24px;
	padding: 0 8px;
	vertical-align: middle;
	line-height: 24px;
	margin: 2px 0;
}

.input-skin-1 {
    border: 1px solid #e2e2e2;
    height: 26px;
    line-height: 26px;
    padding: 0 10px;
    width: 150px;
}
.input-auto-size {
    width: 80%;
    padding: 0;
    text-indent: 6px;
}
#step1-table tbody tr th {
    background: #d3d9e6;
    color: #26377a;
    font-weight: 600;
}
</style>
    </head>
    <body>
<div class="container">
	<div class="fr mt10">
		<select name="epage" id="js-outExcel-select"><?php echo $export_str ?></select>
		<a class="button-middle-v1 frame-btn-warning button-font-white border-radius-5" href="javascript:;"
		   id="js-outExcel"
		   data-href="<?php echo site_url('excel/index/export_xls');?>"
		   title="">导出</a>
	</div>
</div>



<script>
$(function(){
	$('#js-outExcel').click(function () {
		var url = $(this).data('href');
		var val = $('#js-outExcel-select').val();
		var location = url +'?export=1'+ '&page=' + val;
		window.location.href = location;
	})
})

</script>
</body>
</html>