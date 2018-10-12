<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>平台系统</title>
<link href="<?=STATIC_PATH;?>b2b_index/css/font-awesome.min.css" rel="stylesheet">
<link href="<?=STATIC_PATH;?>b2b_index/css/index.css" rel="stylesheet">
<link href="<?=STATIC_PATH;?>b2b_index/css/buyer_style.css" rel="stylesheet">
<link href="<?=STATIC_PATH;?>b2b_index/font-awesome-4.5.0/css/font-awesome.css" rel="stylesheet">
<script type="text/javascript">
if (window.top !== window.self) {
	document.write = '';
	window.top.location.href = window.self.location.href;
	setTimeout(function() {
			document.body.innerHTML = '';
		},
		0);
}
</script>
<script src="<?=STATIC_PATH;?>js/jquery/jquery-1.9.1.min.js"></script>
<!-- layer 弹出层 专用start -->
<script src="<?=STATIC_PATH;?>js/layer/layer.js"></script>
<!-- layer 弹出层 end -->
</head>
<style>
    .optionsn a{
        opacity: .7;
        /*background-size:58px 58px ;*/
    }
    .refresh{
        background: url(<?=STATIC_PATH;?>b2b_index/images/refresh.jpg) center;
        position: fixed;
        right: 96px;
        top:95px;
        height: 58px !important;
        width: 58px !important;
    }
    .back{
        background: url(<?=STATIC_PATH;?>b2b_index/images/back.jpg) center;
        position: fixed;
        right: 38px;
        top:95px;
        height: 58px !important;
        width: 58px !important;
    }
    .menubar{
        padding-top: 107px;
    }
    @media screen and (max-width:1700px){
        .menubar{
            padding-top:67px !important;
        }
        .header li a{
            height: 40px;
            line-height:40px;
        }
        .tools{
            height: 40px !important;
        }
        .header li{
            height: 40px;
        }
        .phone-box{
            margin-top: 10px !important;
        }
        .refresh{
            top:135px !important;
        }
        .back{
            top:135px !important;
        }
    }
</style>
<style>

    /*******消息样式*********/
    .header .tools a {
        font-size: 14px;
    }

    /*.msg-count-wrap{visibility: hidden ;}*/

    .msg-envelope-wrap{position: relative;}
    .msg-envelope-wrap .circle-wrap{
        position: absolute;
        top: 23px;
        left: 19px;
        display: none;
        height: 8px;
        width: 8px;
        background:  url("<?=STATIC_PATH;?>b2b_index/images/msg-ico.png") no-repeat;
    }
</style>
<body>
<div class="wrap" style="height: 100%;overflow: hidden">
  <table width="100%" height="100%" style="table-layout:fixed;">
    <tbody>
      <tr class="head">
        <th style="text-align: center;"> <!--<div class="doahead cc">
                <img class="my1logo" src="<?php /*echo $sitelogo */?>" onerror="this.error=null;this.src='<?php /*echo URLPRE;*/?>static/public/images/nologo.jpg'" alt="管理中心"/>
                </div>-->
        </th>
        <td><div class="doahead cc"> <a href="<?php echo site_url('admin/index')?>" class="logo">此处是LOGO
            <!--                        <img src="-->
            <?//=STATIC_PATH;?>
            <!--b2b_index/images/logo.png">-->
            <div class="seller-sb" style="background-color:#f7931e">分销商系统</div>
            </a>
            <div class="nav">
              <ul id="J_B_main_block" style="padding-left:16px">
              </ul>
            </div>
            <!--                    <div class="nav navright" style="float: right;">
                        <ul style="padding-left:16px;float: right;">
                            <li class=""><a href="" >订单信息</a></li>
                            <li><a href="<?php /*echo site_url('');*/?>" class="home" target="_blank">平台首页</a></li>
                            <li><a href="<?php /*echo site_url('admin/index/logout');*/?>" >退出登录</a></li>
                        </ul>
                    </div>-->
            <div  style="float: right;">
              <div class="phone-box" style="float:left;  font-size: 20px; margin-top: 22px; margin-right: 60px; color: #fff;"><i style="padding-right: 8px;" class="fa fa-phone"></i>400-835-5166</div>
              <div class="header">
                <ul class="tools">
                  <li> <a href="<?php echo site_url('admin/index?redirect=buyer/profile/index');?>"> <i class="fa fa-user" aria-hidden="true"></i> <span >个人中心</span> </a> </li>
                  <li> <a href="<?php echo site_url('admin/index/logout');?>"> <i class="fa fa-power-off" aria-hidden="true"></i> 退出登录 </a> </li>
                </ul>
              </div>
            </div>
          </div></td>
      </tr>
      <tr class="tab">
        <th> <div class="search" style="display: none">
            <input size="50" placeholder="搜索操作" id="J_search_keyword" type="text">
            <button type="button" name="keyword" id="J_search" value="" data-url="<?php echo site_url();?>">搜索</button>
          </div></th>
        <td><div id="B_tabA" class="tabA"> <a href="" tabindex="-1" class="tabA_pre J_prev" id="J_prev" title="上一页"> 上一页 </a> <a href="" tabindex="-1" class="tabA_next" id="J_next" title="下一页"> 下一页 </a>
            <div style="margin:0 25px;min-height:1px;">
              <div style="position:relative;height:30px;width:100%;overflow:hidden;">
                <ul id="B_history" style="white-space:nowrap;position:absolute;left:0;top:0;">
                  <!--                                <li class="current" data-id="default" tabindex="0">-->
                  <!--                                  <span><a>后台首页</a></span>-->
                  <!--                                </li>-->
                </ul>
              </div>
            </div>
          </div></td>
      </tr>
      <tr class="content">
        <th style="overflow:hidden;"> <div class="B_menutop cl">
            <div class="adminavatar"> <img src="<?=STATIC_PATH;?>b2b_index/images/nophoto.jpg" onerror="this.error=null;this.src='<?=STATIC_PATH;?>b2b_index/images/nophoto.jpg'" /> </div>
            <div class="admininfo"> <a>姓名</a>
              <div>手机号</div>
            </div>
          </div>
          <div id="B_menunav">
            <div class="menubar">
              <dl id="B_menubar" data-id="bbs">
              </dl>
            </div>
            <div id="menu_next" class="menuNext" style="display: none;"> <a href="" class="pre" title="顶部超出，点击向下滚动"> 向下滚动 </a> <a href="" class="next" title="高度超出，点击向上滚动"> 向上滚动 </a> </div>
          </div></th>
        <td id="B_frame" style="height: 90%"><div id="breadCrumb" style="display:none;"> 常用操作&nbsp;<em>&raquo;</em>&nbsp;功能 </div>
          <div class="optionsn"> <a href="" class="refresh" id="J_refresh" title="刷新"></a> <a href="" class="back J_prev" id="J_back" title="返回"></a> </div>
          <div class="" id="loading" style="display: block; margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; width:62px; height:62px;">
            <!--                    加载中...-->
            <img class="" src="<?=STATIC_PATH;?>b2b_index/images/wait2.gif" alt=""/> </div>
          <iframe id="iframe_default" name="iframe_default" src="<?php echo site_url('admin/index/datan')?>" style=" width: 99.5%; display: inline;" data-id="default"  scrolling="auto" frameborder="0" > </iframe>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<style>

    .msg-main-wrap{text-align: left;padding:10px 10px 20px 10px;height: 180px;width: 95%}
    .msg-main-wrap h1{color: green;font-size: 15px;}
    .msg-main-wrap .msg-more-p{text-align:right;}
    .msg-main-wrap .msg-content-wrap{height: 65px;width: 95%;padding: 10px 1px ;overflow: hidden;text-overflow: ellipsis;}
    .msg-main-wrap .msg-more-p{width: 95%; font-size: 15px;}
    .msg-main-wrap .msg-more-p a{color: rgb(52,166,223);}


    .xubox_title {
        width: 100%;
        height: 40px;
        line-height: 40px;
        background: #0c99cf;
        font-size: 14px;
        color: #fff;
    }

    .xubox_setwin .xubox_close0 {
        width: 16px;
        height: 16px;
        background: url(<?php //echo URLPRE?>static/seller/js/layer/skin/default/layer-close-white.png) no-repeat;
        cursor: pointer;
    }

</style>
<script type="text/javascript">

var showMsg = true;
var mID = 0;

//iframe 加载事件
var iframe_default = document.getElementById('iframe_default');
$(iframe_default.contentWindow.document).ready(function() {
  $('#loading').hide();
  $(iframe_default).show();
});

var USUALL = [],
/*常用的功能模块*/
TEMP = [],
SUALL = USUALL.concat('-', [{
  name: '常用操作',
  disabled: true
}], TEMP),
SUBMENU_CONFIG = <?php echo json_encode($left_menu);?>,
/*主菜单区*/
imgpath = '',
times = 0,
getdescurl = '',
searchurl = '',
token = "";
//一级菜单展示
$(function() {
  var html = [];
  $.each(SUBMENU_CONFIG,
  function(i, v) {
    html.push('<li><a href="" data-real_id="' + v.real_id + '" data-id="' + v.id + '">' + v.name + '</a></li>');
  });
  $('#J_B_main_block').html(html.join(''));
  //后台位在第一个导航
  $('#J_B_main_block li:first > a').click();

});

$('#J_B_main_block').on('click', 'a',
function(e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).parent().addClass('current').siblings().removeClass('current');
  var data_id = $(this).attr('data-id');
  var data_list = SUBMENU_CONFIG[data_id];
  var html = '';
  var B_menubar = $('#B_menubar');
  html = show_left_menu(data_list['child']);
  console.log(html);
  B_menubar.html(html).attr('data-id', data_id).attr('data-real_id', $(this).attr('data-real_id'));
  //默认点击第一个
  $('#B_menubar dt:first > a').click();
  checkMenuNext();

});

//上一页下一页的点击
(function() {
  var menu_next = $('#menu_next');
  var B_menunav = $('#B_menunav');
  menu_next.on('click', 'a',
  function(e) {
    e.preventDefault();
    if (e.target.className === 'pre') {
      if (B_menunav.offset().top < B_menunav.parent().offset().top) {
        B_menunav.animate({
          'marginTop': '+=28px'
        },
        100);
      }
    } else if (e.target.className === 'next') {
      if (B_menunav.offset().top + B_menunav.height() >= $(window).height()) {
        B_menunav.animate({
          'marginTop': '-=28px'
        },
        100);
      }
    }
  });
})();

//左边菜单点击
$('#B_menubar').on('click', 'a',
function(e) {
  e.preventDefault();
  e.stopPropagation();

  var $this = $(this),
  _dt = $this.parent(),
  _dd = _dt.next('dd');

  //当前菜单状态
  //        _dt.addClass('current').siblings('dt.current').removeClass('current');
  $('.menubar').find('.current').removeClass('current');
  _dt.addClass('current');

  //子菜单显示&隐藏
  if (_dd.length) {
    _dt.toggleClass('current');
    _dd.toggle();
    //检查上下分页
    checkMenuNext();
    return false;
  };

  $('#loading').show().focus(); //显示loading
  $('#B_history li').removeClass('current');
  var data_id = $(this).attr('data-id'),
  li = $('#B_history li[data-id=' + data_id + ']');
  var href = this.href;

  iframeJudge({
    elem: $this,
    href: href,
    id: data_id
  });

});
//判断显示或创建iframe
function iframeJudge(options) {
  var elem = options.elem,
  href = options.href,
  id = options.id,
  li = $('#B_history li[data-id=' + id + ']');

  if (li.length > 0) {
    //如果是已经存在的iframe，则显示并让选项卡高亮,并不显示loading
    var iframe = $('#iframe_' + id);
    $('#loading').hide();
    li.addClass('current');
    if (iframe[0].contentWindow && iframe[0].contentWindow.location.href !== href) {
      iframe[0].contentWindow.location.href = href;
    }
    $('#B_frame iframe').hide();
    $('#iframe_' + id).show();
    showTab(li); //计算此tab的位置，如果不在屏幕内，则移动导航位置
  } else {
    //创建一个并加以标识
    var iframeAttr = {
      src: href,
      id: 'iframe_' + id,
      frameborder: '0',
      scrolling: 'auto',
      height: '100%',
      width: '100%'
    };
    var iframe = $('<iframe/>').prop(iframeAttr).appendTo('#B_frame');
    //        $('#loading').show();
    setTimeout(function() {
      $('#loading').show();
    },
    100);
    $(iframe[0].contentWindow.document).ready(function() {
      $('#B_frame iframe').hide();
      //            $('#loading').hide();
      setTimeout(function() {
        $('#loading').hide();
      },
      900);
      var li = $('<li tabindex="0"><span><a>' + elem.html() + '</a><a class="del" title="关闭此页">关闭</a></span></li>').attr('data-id', id).addClass('current');
      li.siblings().removeClass('current');
      li.appendTo('#B_history');
      showTab(li); //计算此tab的位置，如果不在屏幕内，则移动导航位置
      //$(this).show().unbind('load');
    });

  }

}
//显示顶部导航时作位置判断，点击左边菜单、上一tab、下一tab时公用
function showTab(li) {
  if (li.length) {
    var ul = $('#B_history'),
    li_offset = li.offset(),
    li_width = li.outerWidth(true),
    next_left = $('#J_next').offset().left - 9,
    //右边按钮的界限位置
    prev_right = $('.J_prev').offset().left + $('.J_prev').outerWidth(true); //左边按钮的界限位置
    if (li_offset.left + li_width > next_left) { //如果将要移动的元素在不可见的右边，则需要移动
      var distance = li_offset.left + li_width - next_left; //计算当前父元素的右边距离，算出右移多少像素
      ul.animate({
        left: '-=' + distance
      },
      200, 'swing');
    } else if (li_offset.left < prev_right) { //如果将要移动的元素在不可见的左边，则需要移动
      var distance = prev_right - li_offset.left; //计算当前父元素的左边距离，算出左移多少像素
      ul.animate({
        left: '+=' + distance
      },
      200, 'swing');
    }
    li.trigger('click');
  }
}

//顶部点击一个tab页
$('#B_history').on('click focus', 'li',
function(e) {
  e.preventDefault();
  e.stopPropagation();
  var data_id = $(this).data('id');
  $(this).addClass('current').siblings('li').removeClass('current');
  $('#iframe_' + data_id).show().siblings('iframe').hide(); //隐藏其它iframe
});

//顶部关闭一个tab页
$('#B_history').on('click', 'a.del',
function(e) {
  e.stopPropagation();
  e.preventDefault();
  var li = $(this).parent().parent(),
  prev_li = li.prev('li'),
  data_id = li.attr('data-id');
  li.hide(60,
  function() {
    $(this).remove(); //移除选项卡
    $('#iframe_' + data_id).remove(); //移除iframe页面
    var current_li = $('#B_history li.current');
    //找到关闭后当前应该显示的选项卡
    current_li = current_li.length ? current_li: prev_li;
    current_li.addClass('current');
    cur_data_id = current_li.attr('data-id');
    $('#iframe_' + cur_data_id).show();
  });
});

//刷新
$('#J_refresh').click(function(e) {
  e.preventDefault();
  e.stopPropagation();
  var id = $('#B_history .current').attr('data-id'),
  iframe = $('#iframe_' + id);
  if (iframe[0].contentWindow) {
    //common.js
    reloadPage(iframe[0].contentWindow);
  }
});

//下一个选项卡
$('#J_next').click(function(e) {
  e.preventDefault();
  e.stopPropagation();
  var ul = $('#B_history'),
  current = ul.find('.current'),
  li = current.next('li');
  showTab(li);
});

//上一个选项卡
$('.J_prev').click(function(e) {
  e.preventDefault();
  e.stopPropagation();
  var ul = $('#B_history'),
  current = ul.find('.current'),
  li = current.prev('li');
  showTab(li);
});

//重新刷新页面，使用location.reload()有可能导致重新提交
function reloadPage(win) {
  var location = win.location;
  location.href = location.pathname + location.search;
}

function checkMenuNext() {
  var B_menunav = $('#B_menunav');
  var menu_next = $('#menu_next');
  if (B_menunav.offset().top + B_menunav.height() >= $(window).height() || B_menunav.offset().top < B_menunav.parent().offset().top) {
    menu_next.show();
  } else {
    menu_next.hide();
  }
}

function show_left_menu(data) {
  var html = [];
  $.each(data,
  function(i, v) {
    html.push('<dt><a href="' + v.url + '" data-real_id="' + v.real_id + '" data-id="' + v.id + '">' + v.name + '</a></dt>');
  });
  return html.join('');
}



    (function () {
        console.log('自动运行');
    })()

</script>
</body>
</html>
