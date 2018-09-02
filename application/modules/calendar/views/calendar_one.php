<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <base href="<?=site_url('');?>">
	<title>日历1</title>
    <script src="<?php echo base_url();?>public/js/jquery/jquery-1.9.1.min.js"></script>
    <style>
 table {
  border:1px solid #050;
 }

 .fontb {
  color:white;
  background:blue;
 }
 

 th {
  width:40px;
 }

 td,th {
  height:30px;
  text-align:center;

 }
 form {
  margin:0px;
  padding:0px;
 }
 .zhu-color {
	 color: #61b0ff !important;
 }
 .gray-color {
	 color: #888 !important;
 }
</style>

</head>
<body>
<div class="calendar">
	<?php $this->Calendar_model->out();?>
</div>

<script>
	function sign(obj){
		$.post("<?php echo site_url('calendar/index/sign');?>",{sign:1},function (data) {
			if(data.status==1){
				alert(data.msg);
			}else{
				alert(data.msg);
			}
		},'json')
	}
</script>
</body>
</html>