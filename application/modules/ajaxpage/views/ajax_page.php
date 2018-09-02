<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<base href="<?php echo site_url('');?>">
<title>文章列表</title>
<script src="<?php echo base_url();?>public/js/jquery/jquery-1.9.1.min.js"></script>
<style>
a {
	color: #999
}
a:hover {
	color: #ff0000;
}
a.cur {
	color: #ff0000;
}
</style>
</head>
<body>
<?php echo date('Y-m-d H:i:s',time())?>
<div class="clearfix news_box">
<?php $this->load->view('page_list');?>
</div>
<form name="myform" method="post" action="<?=site_url('ajaxpage/index')?>">
<input type="hidden" name="cur_page" value="">
</form>
<script type="text/javascript">

$(function(){
	//$('form[name=myform]').submit();	
	var cur_page = $('input:hidden[name=cur_page]').val();
	if(cur_page){
		$('form[name=myform]').submit();		
	}
})

function search_list(page){
	var name = "南京";//$("#name").val();
	var data = {};
	data.name = name;
	data.page = page;
	//var data  = "name="+name+"&page="+page;
	$.ajax({
	   type:"POST",
	   url:"<?php echo site_url('ajaxpage/index/search_list?inajax=1')?>",
	   data:data,
	   success:function(result){
		   $('input:hidden[name=cur_page]').val(page);
		   $(".news_box").html(result);
	   }
　　});
}
</script> 
</body>
</html>