<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<base href="<?=site_url('')?>">
<title>wangeditor</title>
	<link rel="stylesheet"href="<?php echo base_url();?>public/lib/editor.md-master/css/editormd.css" />
	<script src="<?php echo base_url();?>public/js/jquery/jquery-1.9.1.min.js"></script>
	<script src="<?php echo base_url();?>public/lib/editor.md-master/editormd.min.js"></script>
<style type="text/css">
.toolbar {
	border: 1px solid #ccc;
}
.text {
	border: 1px solid #ccc;
	height: 500px;
}
.w-e-toolbar {
	flex-wrap: wrap;
	-webkit-box-lines: multiple;
}

.w-e-toolbar .w-e-menu:hover{
	z-index: 10002!important;
}

.w-e-menu a {
	text-decoration: none;
}

.fullscreen-editor {
	position: fixed !important;
	width: 100% !important;
	height: 100% !important;
	left: 0px !important;
	top: 0px !important;
	background-color: white;
	z-index: 9999;
}

.fullscreen-editor .w-e-text-container {
	width: 100% !important;
	height: 95% !important;
}
</style>
</head>
<body>
<div class="search">
	<div id="my-editormd" >
		<textarea id="my-editormd-markdown-doc" name="my-editormd-markdown-doc" style="display:none;"></textarea>
		<!-- 注意：name属性的值-->
		<textarea id="my-editormd-html-code" name="my-editormd-html-code" style="display:none;"></textarea>
	</div>
  
</div>

<script type="text/javascript">
	$(function() {
		editormd("my-editormd", {//注意1：这里的就是上面的DIV的id属性值
			width   : "90%",
			height  : 640,
			syncScrolling : "single",
			path    : "<?php echo base_url();?>public/lib/editor.md-master/lib/",//注意2：你的路径
			saveHTMLToTextarea : true,//注意3：这个配置，方便post提交表单
			/**上传图片相关配置如下*/
			imageUpload : true,
			imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
			imageUploadURL : "<?=site_url('plupload/index/upload_markdown_pic')?>",//注意你后端的上传图片服务地址
		});
	});
</script>
</body>
</html>