<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <base href="<?= site_url('') ?>">
    <title>Excel导入</title>
    
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
      <h2 class="font-s16 yahei line-h36 b2bh1">游客信息</h2>
      <table id="step1-table" class="iframe-lineroad-table mb10 iframe-lineroad-border iframe-lineroad-border-second small-table-padding tc">
    <colgroup>
        <col width="40">
        <col width="60">
        <col width="60">
        <col width="180">
        <col width="100">
        <col width="50">
        <col width="50">
        <col width="70">
        <col width="50">
        </colgroup>
    <tbody id="guest-list-wrap">
          <tr class="landscape-no-border">
        <td colspan="3" class="landscape-title">可预订人数：<span class="orange-color"> <em id="remain-num" data-num="0">10</em>人（计划人数<em id="total-num">10</em>人） </span></td>
        <td colspan="6" class="tl"><div class="operation-list-wrap"> <a class="button-operation-small button-bg-blue search-spaceing" id="download_excel" style="background: transparent;color: #1c2654;border: 1px solid #1c2654;" href="javascript:;" file_path="public/doc/tourists_demo.xlsx">下载游客模板</a>
            <style>
                        input[type="file"]{opacity: 0;filter:alpha(opacity=0)}
                        .operation-list-wrap .button-operation-small{display: inline-block;}
                    </style>
            <input type="hidden" name="tourist_list" id="file_url"  />
            <a href="javascript:;" id="filePicker" class="button-operation-small button-bg-orange search-spaceing" >导入游客信息</a> </div></td>
      </tr>
          <tr class="landscape-no-border">
        <td colspan="9" class="tl"></td>
      </tr>
          <tr>
        <th class="title" colspan="2">序号/姓名</th>
        <th class="title">类别</th>
        <th class="title">证件类型/证件号码</th>
        <th class="title">手机号码</th>
        <th class="title">单房差</th>
        <th class="title">性别</th>
        <th class="title" >年龄</th>
        <th class="title">备注</th>
      </tr>
        </tbody>
  </table>
      <br />
    </div>
<hr>
</div>

<script type="text/x-jquery-tmpl" id="tmpl-user-list">
	<tr class="guest-list {{if category==0}} adult {{/if}}{{if category==1}} child {{/if}}{{if category==2}} baby {{/if}}">
		<td class="index">01</td>
		<td><input name="title[]" type="text" class="input-skin-1 input-auto-size" value="${title}" datatype="*" ></td>
		<td>
			<input type="hidden" name="category[]" {{if category==0}} value="0" > 成人{{/if}} {{if category==1}} value="1" > 儿童{{/if}} {{if category==2}} value="2" > 婴儿{{/if}}
		</td>
		<td><select name="cardcategory[]">
				<option value="1" {{if cardcategory==1}} selected {{/if}}>身份证</option>
				<option value="2" {{if cardcategory==2}} selected {{/if}}>护照</option>
				<option value="3" {{if cardcategory==3}} selected {{/if}}>港澳通行证</option>
				<option value="4" {{if cardcategory==4}} selected {{/if}}>军官证</option>
				<option value="5" {{if cardcategory==5}} selected {{/if}}>其他</option>
			</select>
			<input name="idcard[]" type="text" class="input-skin-1" style="width:140px" value="${idcard}"  datatype="{{if cardcategory==1}}idcard{{else cardcategory==2}}passport {{else}}*{{/if}}">
		</td>
		<td><input type="text" class="input-skin-1 input-auto-size" name="guestmobile[]" value="${guestmobile}" datatype="m"  ignore="ignore"></td>
		<td>
			<select name="singleroomflag[]">
				<option value="0" {{if singleroomflag==0}} selected="selected" {{/if}}>否</option>
				{{if category!=2}}<option value="1" {{if singleroomflag==1}} selected="selected" {{/if}}>是</option>{{/if}}
			</select>
		</td>
		<td class="sex">
			<select name="gender[]">
				<option value="1" {{if gender==1}} selected="selected" {{/if}}>男</option>
				<option value="2" {{if gender==2}} selected="selected" {{/if}}>女</option>
			</select>
		</td>
		<td class="age">${age}</td>
		<td><input name="guestdetail[]" type="text" class="input-skin-1 input-auto-size" value="${guestdetail}"></td>
	</tr>
</script>

<script>
$(function(){
	$('#download_excel').on('click',function(){
		var file_path = $(this).attr('file_path');
		var url = '<?=site_url("excel/index/download");?>'+'?file_path='+file_path;
		window.location.href = url;
	})
	
	
     var uploader = new plupload.Uploader({
      runtimes: 'gears,html5,html4,silverlight,flash', //上传插件初始化选用那种方式的优先级顺序
      flash_swf_url: 'plupload/Moxie.swf', //flash文件地址
      silverlight_xap_url: 'plupload/Moxie.xap', //silverlight文件地址
      browse_button:"filePicker",
      url:"<?php echo site_url('excel/index/ajax_upload');?>",
      filters:{
        max_file_size:"5mb",
        mime_types:[
          {title:'files',extensions:"xls,xlsx"}
        ],
      }
     }); 
     uploader.init();

     uploader.bind('FilesAdded',function(up,files){		
        uploader.start();
     });     
	 
	 uploader.bind('FileUploaded',function(up,file,info){
		 //文件上传成功之后的数据处理
		  var data = eval("("+info.response+")");
		  console.log(data);
		  var length = data.length;
		  
		  for(var i=0;i<length;i++){
				var o = {
						title: data[i].name,
						category: data[i].type,
						cardcategory: data[i].id_card_type,
						idcard: data[i].id_number,
						gender: data[i].gender,
						guestmobile: data[i].phone_num,
						singleroomflag: data[i].singleroom,
						age:data[i].age,
						guestdetail: data[i].note
					}; 	
			 add_info.user_list(o);	 
		  }
      
     });

     uploader.bind('Error',function(up,err){
        alert(err.message);
     });
	
})

var add_info = {
	user_list:function(option){
		var defaults = {
			'guestdetail':'', //备注
			'singleroomflag':0, //单房差标志
			'idcard':'', //证件号
			'guestmobile':'', //手机
			'title':'', //姓名
			'gender':1, //性别
			'category':0, //类型
			'cardcategory':1 //证件类型
		}
		$.extend(defaults,option);
		var html = $('#tmpl-user-list').tmpl(defaults);
		$('#guest-list-wrap').append(html);	
		add_info.orderGuestListIndex();
	},
	orderGuestListIndex:function(){
		$('#guest-list-wrap').find('.guest-list').each(function(index) {
			$(this).find('.index').text(index+1);
		});
	}	
}

</script>
</body>
</html>