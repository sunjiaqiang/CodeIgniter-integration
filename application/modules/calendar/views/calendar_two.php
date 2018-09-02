<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="UTF-8">
	<title>日历2</title>
	<style type="text/css">
* {
	margin: 0;
	padding: 0;
}
ul, li {
	list-style: none;
}
.main {
	width: 900px;
	margin: 0 auto;
}
</style>
        <script src="<?php echo base_url();?>public/js/jquery/jquery-1.9.1.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('input[type=button]').on('click',function(){
				var ids = new Array();
				if($('input[name="id[]"]:checked').size()>0){
					$('input[name=id[]]:checked').each(function(i,v) {
						ids.push($(this).val());
					});
					alert(ids.join(','));
				}	
			});			
		});
	</script>
	</head>
	<body>
    <div class="main">
      <table border="1" align="center" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td>日</td>
            <td>一</td>
            <td>二</td>
            <td>三</td>
            <td>四</td>
            <td>五</td>
            <td>六</td>
          </tr>
          <?php foreach($rili as $key=>$val):?>
          <tr>
            <?php for($i=0;$i<7;$i++):?>
            <?php if(isset($val[$i])):?>
            <td><?php echo date('j',strtotime($val[$i]))?></td>
            <?php else:?>
            <td>&nbsp;</td>
            <?php endif;?>
            <?php endfor;?>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
</body>
</html>