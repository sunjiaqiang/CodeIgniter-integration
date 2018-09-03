<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<base href="<?=site_url('');?>">
<title>jquery手写签名插件</title>
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
#signatureparent {
	color: darkblue;
	background-color: darkgrey;
	/*max-width:600px;*/
	padding: 20px;
}
</style>
<script src="<?php echo base_url();?>public/js/jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="public/js/jq_signature/jq-signature.js"></script>
</head>
<body>
<div class="main">
  <ul>
    <?php foreach($list as $key=>$val):?>
    <li style="width:300px;"><img src="<?php echo $val['sign_url']?>" style=" width:100%; height:80px;"></li>
    <?php endforeach;?>
  </ul>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h3>基本例子：</h3>
        <p>Sign Below:</p>
        <div class="js-signature"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <h3>高级例子：</h3>
        <p>Sign Below:</p>
        <div class="js-signature" data-width="600" data-height="200" data-border="1px solid black" data-line-color="#3CC" data-auto-fit="true"></div>
        <p>
          <button id="clearBtn" class="btn btn-default" onclick="clearCanvas();">Clear Canvas</button>
          &nbsp;
          <button id="saveBtn" class="btn btn-default" onclick="saveSignature();" disabled>Save Signature</button>
        </p>
        <div id="signature">
          <p><em>Your signature will appear here when you click "Save Signature"</em></p>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(document).on('ready', function() {
	if ($('.js-signature').length) {
		$('.js-signature').jqSignature();
	}
});

function clearCanvas() {
	$('#signature').html('<p><em>Your signature will appear here when you click "Save Signature"</em></p>');
	$('.js-signature').eq(1).jqSignature('clearCanvas');
	$('#saveBtn').attr('disabled', true);
}

function saveSignature() {
	$('#signature').empty();
	var dataUrl = $('.js-signature').eq(1).jqSignature('getDataURL');
	
	$.ajax({
		type:'post',
		url:'<?php echo site_url("signature/index/save_signature");?>',
		data:{'dataUrl':dataUrl},
		async:false,
		dataType:'json',
		beforeSend: function(){
			//beforesend	
		},
		success:function(data){
			//success	
			if(data.status=1){
				alert(data.msg);	
			}else{
				alert(data.msg);	
			}
		},
		error:function(xhr){
			//error	
			console.log(xhr);
		}
	})
	
	var img = $('<img>').attr('src', dataUrl);
	$('#signature').append($('<p>').text("Here's your signature:"));
	$('#signature').append(img);
}

$('.js-signature').eq(1).on('jq.signature.changed', function() {
	$('#saveBtn').attr('disabled', false);
});
	
</script>
</body>
</html>