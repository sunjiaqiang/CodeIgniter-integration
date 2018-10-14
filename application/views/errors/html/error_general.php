<!DOCTYPE html>
<html lang="en">
<head>
	<title>Error404</title>
	<style type="text/css">
		*{ margin:0; padding:0;}
		img{ border:none;}
		ul,li{ list-style:none;}
		a{ text-decoration:none;}
		body{ font-size:12px; font-family:"宋体"; background:#ededed;}

		.header,.butt{ width:960px; margin:0 auto;}

		.header{  overflow:hidden; border-bottom:solid 1px #CCCCCC; height:340px; width:980px; margin: auto;}
		.header_lt,.header_rt{ float:left; margin-top:50px; margin-bottom:50px;}
		.header_lt{ margin-left:0!important;}
		.header_rt{ margin-left:20px;}
		.rt_b{ line-height:30px; padding-left:40px;}
		.rt_b span{ font-size:14px; color:#707070; font-weight:700;}
		.rt_b a{ font-size:14px; color:#707070; font-weight:700;}
		.rt_b a:hover{ color:#ff8003;}
		.butt{ clear:both; overflow:hidden; text-align:center;}
		.biao{ font-size:16px; font-family:"微软雅黑"; color:#303030; text-align:center; margin-top:15px; overflow:hidden;}
		.qw{ float:left; width:550px;}
		.qw li{ float:left; display:block; margin-left:10px; margin-top:10px;}
		.qw li a{ display:block; width:100px; height:26px; line-height:26px; color:#ff7200; font-size:14px; font-weight:700;}
		.qw li a:hover{ color:#FFFFFF; background:#ff7200;}
		.par1{ overflow:hidden; margin-left:180px; margin-top:10px; clear:both;}
		div.gray p{color:#999}
	</style>
</head>
<body>
<!--	<div id="container">-->
<!--		<h1>--><?php //echo $heading; ?><!--</h1>-->
<!--		--><?php //echo $message; ?>
<!--	</div>-->
<div class="header">
	<div class="header_lt"><img src="<?=STATIC_PATH;?>images/error_1.jpg" /></div>
	<div class="header_rt">
		<div class="rt_t"><img src="<?=STATIC_PATH;?>images/error_2.gif" /></div>
		<div class="rt_b">
			<span>点击以下链接断续浏览网站</span><br />
			<a href="#" onclick='history.go(-1)'>>>返回上一页面</a><br />
			<a href="<?php echo site_url('')?>">>>返回首页</a>
			<div class="gray"><?php echo $message; ?></div>
		</div>
	</div>
</div>
</body>
</html>