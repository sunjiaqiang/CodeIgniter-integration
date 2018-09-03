<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="<?= site_url('') ?>">
    <title>发送邮件</title>
    <link href="public/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="public/css/bootstrap-responsive.min.css" rel="stylesheet"/>
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
<div class="container">
    <input type="text" name="email" value="">
    <button name="submit" type="submit" id="sub" class="btn btn-primary">发送</button>
</div>
<hr>
</div>
<script>
$(function(){
    $('#sub').on('click',function(){
        var email = $('input[name=email]').val();
        if ($.trim(email) == ''){
            alert("请输入邮箱");
            return;
        }
        $.post('<?=site_url("email/index/index");?>',{"email":email},function(data){
            if (data.error == 0){
                alert("邮件发送成功");
            }else{
                alert("邮件发送失败");
            }
        },'json');
    })
})
</script>
</body>
</html>