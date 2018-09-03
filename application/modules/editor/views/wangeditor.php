<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<base href="<?=site_url('')?>">
<title>wangeditor</title>
 <script src="<?php echo base_url();?>public/js/jquery/jquery-1.9.1.min.js"></script>
<!-- 注意， 只需要引用 JS，无需引用任何 CSS ！！！-->
<script type="text/javascript" src="public/js/wangEditor-3.0.10/release/wangEditor.min.js"></script>
<script type="text/javascript" src="public/js/wangEditor-3.0.10/release/wangEditor-fullscreen-plugin.js"></script>
<link href="public/js/wangEditor-3.0.10/release/wangEditor-fullscreen-plugin.css">
<script src="public/js/layer/layer.js"></script>
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
  <!--<div id="div1" class="toolbar"> </div>
  <div style="padding: 5px 0; color: #ccc">中间隔离带</div>
  <div id="div2" class="text"></div>-->
  
  
  
  <div id="editor"></div> 
  
  <textarea id="text1" style="width:100%; height:200px; display:none;"></textarea>
  
</div>
<input type="hidden" name="content" value="">
<div class="submit">
	<a href="javascript:;" onClick="doDeal()">提交</a>
    <a href="javascript:;" onclick="get_img()">获取图片</a>
</div>
<script type="text/javascript">
	var E = window.wangEditor
	var editor = new E('#editor')  // 两个参数也可以传入 elem 对象，class 选择器
	 var $text1 = $('#text1')
	/*var E = window.wangEditor
	var editor = new E('#editor')*/
	// 或者 var editor = new E( document.getElementById('#editor') )
	/*editor.customConfig.lang = {
		'设置标题': 'title',
		'正文': 'p1',
		'链接文字': 'link text',
		'链接': 'link',
		'上传图片': 'upload image',
		'上传': 'upload',
		'创建': 'init'
		// 还可自定添加跟多
	 }*/
	editor.customConfig.uploadImgServer = '<?php echo site_url("editor/index/upload_wang");?>';  // 上传图片到服务器
	// 自定义菜单配置
    /*editor.customConfig.menus = [
        'head',
        'bold',
        'italic',
        'underline',
		'fullscreen'
    ]*/
	// 限制一次最多上传 5 张图片
	editor.customConfig.uploadImgMaxLength = 5;
	editor.customConfig.uploadImgMaxSize = 1024*400;
	
	editor.customConfig.uploadImgHooks = {
		before: function (xhr, editor, files) {
			//alert('23')
			// 图片上传之前触发
			// xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，files 是选择的图片文件

			// 如果返回的结果是 {prevent: true, msg: 'xxxx'} 则表示用户放弃上传
			// return {
			//     prevent: true,
			//     msg: '放弃上传'
			// }
		},
		success: function (xhr, editor, result) {
			
			if(result.error == -1){
				layer.msg(result.msg);	
			}
			// 图片上传并返回结果，图片插入成功之后触发
			// xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
		},
		error: function (xhr, editor) {
			console.log(xhr);
			// 图片上传出错时触发
			// xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
		}
	}
	
	
	editor.customConfig.customAlert = function (info) {
			console.log(info);
		// info 是需要提示的内容
		layer.msg('自定义提示：' + info)
	}
	
	editor.customConfig.linkCheck = function (text, link) {
	console.log(text) // 插入的文字
	console.log(link) // 插入的链接

	 return true // 返回 true 表示校验成功
	// return '验证失败' // 返回字符串，即校验失败的提示信息
	}


	
	
	
	
	editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            $text1.val(html)
        }
	
	editor.create();
	
	E.fullscreen.init('#editor');
	
	
	
	// 初始化 textarea 的值
    $text1.val(editor.txt.html());	
	
	
	
	
	function doDeal(){
		var text = editor.txt.text();
		var content = editor.txt.html();
		if(content == '<p><br></p>'){
			alert('请填写内容');	
		}	
		$("input[name='content']").val(content);
		alert(editor.txt.html());
	}
	
	function get_img(){
		var content = editor.txt.html();
		var img = $(content).find('img');
		console.log(img);
	}
	
</script>
</body>
</html>