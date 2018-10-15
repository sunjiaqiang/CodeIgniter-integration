$(document).ready(function(){
    doAjaxDel();
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
 * ajax删除操作
 */
function doAjaxDel(){
    $(".doDel").click(function(){
        var uri = $(this).attr("data-uri");
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

