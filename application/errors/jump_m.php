<?php $this->load->module('citysite/index/header',(array)$params);?>
<style type="text/css">

    .alert{    padding-top: 100px;}
    .alert .alert_body{ }
    .alert .alert_body h3{font-size:16px; font-weight:bold; margin:0;}
    .alert .alert_body .alertcont{/*margin:15px 0 0 15px; padding:5px 50px;*/ line-height:30px; color:#fff; min-height:30px; _height:30px;}
    .alert .alert_body .alertcont a{color:#fff; text-decoration:none;}
    .alert .alert_body .alertcont span{font-size:16px;}
    .alert .alert_body .span_btn{ /*padding:5px 50px;margin: 15px 0 0 15px*/;font-size:14px;}
    .alert .alert_body .span_btn img{border:0;}
/*    .alert .alert_body .success{ background:url("*/<?php //echo URLPRE;?>/*static/public/images/success.gif") left center no-repeat; }*/
/*    .alert .alert_body .error{ background:url("*/<?php //echo URLPRE;?>/*static/public/images/error.gif") left center no-repeat; }*/

    .message{}
    .message .alert_body{ padding:0; ;/* border:1px solid #cae3eb;*/}
    .message .alert_body h3{background-color:#e9f4f7; padding:3px 15px;}
    .message .alert_body h3 {
        background-color: rgb(77,77,77);
        padding: 3px 15px;
        color: #fff;
    }
    #href{color: #0d98ce}
    .message .alert_body {
        padding: 0;
        background: rgba(0,0,0,.7);
        margin: 0 auto;
        width: 80%;
        color: #fff;
        border-radius: 12px;
        text-align: center;
        padding:15px;
    }
</style>
<div class="alert message">
    <div class="alert_body">
            <?php if(isset($data['message'])&&$data['message']):?>
            <p class="alertcont success" id="successMsg">
                <span><a href="<?php echo($data['jumpUrl']); ?>"><?php echo($data['message']); ?></a></span>
            </p>
            <?php else:?>
            <p class="alertcont error" id="errorMsg">
                <span><a href="<?php echo($data['jumpUrl']); ?>"><?php echo($data['error']); ?></a></span>
            </p>
            <?php endif;?>
        <?php if($data['waitSecond']> 0){?>
        <p class="span_btn">系统会在<b id="wait"><?php echo intval($data['waitSecond']); ?></b>秒内自动跳转，如没有响应<a id="href" href="<?php echo $data['jumpUrl']; ?>">请点击!</a></p>
        <?php }?>
    </div>
</div>
<script type="text/javascript">
    (function(){
        <?php if($data['waitSecond']> 0){?>
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time == 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
        <?php }?>
    })();

    function jumpIt(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time == 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    }
</script>
<?php $this->load->module('citysite/index/footer');?>