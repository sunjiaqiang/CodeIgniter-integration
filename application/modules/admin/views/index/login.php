<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!doctype html>
<html>
    <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta content="telephone=no" name="format-detection"/>
    <meta name="viewport" content="initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>网站后台登录</title>
    <link rel="stylesheet" href="<?=STATIC_PATH;?>b2b_index/css/login.css">
    <script src="<?=STATIC_PATH;?>js/jquery/jquery-1.9.1.min.js"></script>
    <script type="text/javascript">
        if (window.parent !== window.self) {
            document.write = '';
            window.parent.location.href = window.self.location.href;
            setTimeout(function () {
                document.body.innerHTML = '';
            }, 0);
        }
    </script>
    <script type="text/javascript" src="<?=STATIC_PATH;?>b2b_index/js/superslide.2.1.js"></script>
    <script>
        $(function () {
            $('#js-show-protocol').click(function () {
                $.layer({
                    type: 1,
                    title: false,
                    area: ['742px', '543px'],
//                    area: ['742px', '553px'],
                    shadeClose: true,
                    closeBtn: [1, true],
                    page: {
                        html: $('#content-protocol').html()
                    }
                });
            })

            $('.login1-login-close').click(function () {
                alert('1234');
            })

        })
    </script>
    </head>
    <body>
<!-- 新样式   --> 

<!--header-->
<div class="boxWrap hearWap"> <!--<img src="<?=STATIC_PATH;?>b2b_index/images/login/logo.png" alt="">--> </div>
<!--   登录框     -->
<div class="loginWrap-box">
      <div class="loginWrap box">
    <div class="loginWrap-t box">会员登录</div>
    <div class="loginWrap-c">
          <form id="loginform" method="post" name="loginform" action="<?php echo $login_url; ?>">
        <!-- 登录名 -->
        <div class="login-name">
              <label>登录名</label>
              <input id="u" name="username" class="input_txt" tabindex="1" type="text"/>
            </div>
        <!-- 密码 -->
        <div class="login-pass">
              <label>密&nbsp;&nbsp;&nbsp;码</label>
              <input maxlength=16 type="password" id="p" name="password" tabindex="2" class="input_txt" type="text"/>
            </div>

        <button type="submit" class="login-btn" tabindex="4" id="subbtn">登录</button>
        <p class="agree">
              <input type="checkbox" value="0" checked disabled>
              <a href="javascript:;" id="js-show-protocol">我已阅读并同意《网站服务协议》</a> </p>
      </form>
        </div>
  </div>
    </div>
<!--banner-->
<div class="fullSlide">
      <div class="bd">
    <ul>
          <li _src="url(<?=STATIC_PATH;?>b2b_index/images/login/banner6.png)" style="background:transparent center 0 no-repeat;"></li>
          
        </ul>
  </div>
      <div class="hd">
        <ul>
        </ul>
  </div>
    </div>

<!-- 页脚 -->
<div class="footWrap">
      <div class="boxWrap">
    <p>Copyright © 大数据科技有限公司 All Rights Reserved.</p>
  </div>
    </div>
<script type="text/javascript">
        // 三块内容切换
        $(".list-full").hover(function(){
            var rgb = $(this).find(".num-t").css('background-color');

            $(".hr").css("color",rgb).show();
        },function(){
            $(".hr").hide();
        });
        

        var index1=1;
        var stime=setInterval(function(){
            $(".item7-content-nav ul").find('li').eq(index1).mouseover();
            index1++;
            if(index1==3){
                index1=0;
            }
        },2500);

        // 置顶
        $(window).scroll(function(){
            if ($(window).scrollTop()>500){
                $(".top").show();
            }else{$(".top").hide();
            }
        });
        //当点击跳转链接后，回到页面顶部位置
        $(".top").click(function(){
            $('body,html').animate({scrollTop:0},500);
            return false;
        });

        $(".fullSlide").hover(function(){
                $(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.5)
            },
            function(){
                $(this).find(".prev,.next").fadeOut()
            });
        $(".fullSlide").slide({
            titCell: ".hd ul",
            mainCell: ".bd ul",
            effect: "fold",
            autoPlay: true,
            autoPage: true,
            trigger: "click",
            startFun: function(i) {
                var curLi = jQuery(".fullSlide .bd li").eq(i);
                if ( !! curLi.attr("_src")) {
                    curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")
                }
            }
        });
    </script>
</body>
</html>