$(document).ready(function(){
    doAjaxDel();
    initOperat()
    //分页控制
    $('.pgselect').change(function(){
        var page = $(this).val();
        var pram = $(this).attr('data-param');
        var url = $(this).attr('data-uri')+'/'+page+pram;
        window.location.href = url;
    });

    //切换
    $('.pointer').on('click', function() {
        var url = $(this).closest('table').attr("data-uri");
        var host = window.location.protocol+'//'+window.location.host;
        var new_url=url.replace(host,'');
        if (new_url.indexOf('index.php') > -1){
            new_url = new_url.replace('/index.php/','');
        }

        if (!check_url.check_auth(new_url)){
            return false;
        }

        var img    = this,
            s_val  = ($(img).attr('data-value'))== 0 ? 1 : 0,
            s_name = $(img).attr('data-field'),
            s_id   = $(img).attr('data-id'),
            s_src  = $(img).attr('src');
        s_msg = ($(img).attr('data-value'))== 0 ? '启用' : '禁用';
        $.ajax({
            url:url,
            cache:false,
            dataType:"json",
            data: {id:s_id, field:s_name, val:s_val},
            type:"POST",
            beforeSend:function(){
                $("#J_ajax_loading").stop().removeClass('ajax_error').addClass('ajax_loading').html("提交请求中，请稍候...").show();
            },
            error:function(){
                $("#J_ajax_loading").addClass('ajax_error').html("AJAX请求发生错误!").show().fadeOut(5000);
            },
            success:function(msgObj){
                $("#J_ajax_loading").hide();
                if(msgObj.status == '1'){
                    $("#J_ajax_loading").removeClass('ajax_error').addClass('ajax_success').html(msgObj.info).show().fadeOut(5000);
                    if(s_src.indexOf('icon_0')>-1) {
                        $(img).attr({'src':s_src.replace('icon_0','icon_1'),'data-value':s_val,'title':s_msg,'alt':s_msg});
                    } else {
                        $(img).attr({'src':s_src.replace('icon_1','icon_0'),'data-value':s_val,'title':s_msg,'alt':s_msg});
                    }
                }else{
                    $("#J_ajax_loading").removeClass('ajax_success').addClass('ajax_error').html(msgObj.info).show().fadeOut(5000);
                }
            }
        });
    });

})


/**
 * 操作按钮处理
 */
function initOperat(){
    $(".operat").each(function(){
        var operat = $(this);
        operat.find(".action").on("mouseenter DOMNodeInserted",function(){
            operat.removeClass("hidden").addClass("show_munu");
            var offset = operat.offset();
            var height = operat.find(".action").height();
            var action_width = operat.find(".action").outerWidth();
            var menu_select_width = operat.find(".menu_select").outerWidth();

            if(offset.top+operat.find(".menu_select").height()+height < $(window).height()){
                if(offset.left+menu_select_width< $(window).outerWidth()) operat.find(".menu_select").offset({left:offset.left,top:(Math.floor(offset.top)+1+height)});
                else operat.find(".menu_select").offset({left:(offset.left+action_width-menu_select_width),top:(Math.floor(offset.top)+1+height)});
                operat.find(".action").removeClass("top").addClass("bottom");
            }else{
                if(offset.left+menu_select_width< $(window).outerWidth()) operat.find(".menu_select").offset({left:offset.left,top:Math.ceil(offset.top)-1-operat.find(".menu_select").height()});
                else operat.find(".menu_select").offset({left:(offset.left+action_width-menu_select_width),top:Math.ceil(offset.top)-1-operat.find(".menu_select").height()});
                operat.find(".action").removeClass("bottom").addClass("top");
            }

        });
        operat.on("mouseleave",function(){
            operat.removeClass("show_munu").addClass("hidden");
        })
    })
}

/**
 * ajax删除操作
 */
function doAjaxDel(){
    $(".doDel").click(function(){
        var uri = $(this).attr("data-uri");

        console.log(uri.indexOf('?'));

        var host = window.location.protocol+'//'+window.location.host;
        var new_url=uri.replace(host,'');
        if (new_url.indexOf('index.php') > -1){
            new_url = new_url.replace('/index.php/','');
        }

        if (new_url.indexOf('?') > -1){
            var len = new_url.indexOf('?');
            var suffix = new_url.substring(len);
            new_url = new_url.replace(suffix,'');
        }

        if ( ! check_url.check_auth(new_url)) {
            return false;
        }

        var that = this;
        $.dialog.confirm("你确认删除操作吗？删除后无法恢复！", function () {
            $.ajax({
                url:uri,
                cache:false,
                dataType:'json',
                type:'POST',
                data:{},
                success:function(msgObj){
                    if(msgObj.status==1){
                        $.dialog.tips(msgObj.info);
                        $(that).closest('tr').remove();
                        $(that).closest('.album_box').remove();

                        //刷新列表
                        // location.reload();
                    }else{
                        $.dialog.alert(msgObj.info);
                    }
                    return false;
                }
            });
        }, function () {
        });
    });
}

var check_url={
    // 校验权限URL
    check_auth_url:window.location.protocol+'//'+window.location.host+'/admin/index/check_auth',
    check_auth:function (url) {

        $.ajaxSetup({async:false});
        $.post(check_url.check_auth_url,{url:url},function(data){
            rt = JSON.parse(data);
        });
        if (rt.status == -1){
            $.dialog.tips(rt.msg);
            // alert(rt.msg);
            return false;
        }else{
            return true;
        }

    }
}