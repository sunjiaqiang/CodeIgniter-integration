<!DOCTYPE html>
<html lang="en">
<head>
<base href="<?php echo site_url('');?>">
<meta charset="UTF-8">
<title>webupload多图上传</title>
    <script src="<?php echo base_url();?>public/js/jquery/jquery-1.9.1.min.js"></script>
    <!--引入CSS-->
    <link rel="stylesheet" type="text/css" href="public/js/webuploader-0.1.5/webuploader.css">
    <!--引入JS-->
    <script type="text/javascript" src="public/js/webuploader-0.1.5/webuploader.js"></script>

    <style>
    *{ margin: 0; padding: 0}
    ul,li{ list-style: none;}
    .center{ width: 600px; margin: 0 auto;}
</style>
</head>
<body>

<div class="center">
    <div class="list"></div>
<!--    <div id="uploader" class="wu-example">-->
<!--       -->
<!--        <div id="thelist" class="uploader-list"></div>-->
<!--        <div class="btns">-->
<!--            <div id="picker">选择文件</div>-->
<!--            <button id="ctlBtn" class="btn btn-default">开始上传</button>-->
<!--        </div>-->
<!--    </div>-->

    <div class="">
        <div>
        <input  name="Form[travelpath]" type="text"  style="display: none" id="travelpath-input" validate="{required:true}" />
        <div id="travelpath-filePicker">选择图片</div>
        <div id="travelpath-preview"> </div><span></span></div>

<!--        <div>-->
<!--            <input  name="Form[travelpath]" type="text"  style="display: none" id="travelpath-input_1" validate="{required:true}" />-->
<!--            <div id="travelpath-filePicker_1">选择图片</div>-->
<!--            <div id="travelpath-preview_1"> </div><span></span></div>-->
        <a class="btn_submit" href="javascript:void(0);" onclick="addrow(this,0);add_init_upload();">增加</a>

    </div>

</div>

<script>
$(function(){
    var server_url = "<?=site_url('webupload/index/upload_pic');?>";

    var BASE_URL = 'public';
    var uploader = WebUploader.create({
        auto:true,

        // swf文件路径
        //swf: BASE_URL + '/webuploader-0.1.5/Uploader.swf',

        // 文件接收服务端。
        server: server_url,

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#picker',
        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },
        compress: false,
        chunked:true,
        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false
    });
    // 当有文件被添加进队列的时候
    uploader.on( 'fileQueued', function( file ) {
        var $list = $('.list');
        $list.append( '<div id="' + file.id + '" class="item">' +
            '<h4 class="info">' + file.name + '</h4>' +
            '<p class="state">等待上传...</p>' +
            '</div>' );
    });
    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress .progress-bar');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<div class="progress progress-striped active">' +
                '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                '</div>' +
                '</div>').appendTo( $li ).find('.progress-bar');
        }

        $li.find('p.state').text('上传中');

        $percent.css( 'width', percentage * 100 + '%' );
    });
    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file ) {
        $( '#'+file.id ).addClass('upload-state-done');
    });

// 文件上传失败，显示上传出错。
    uploader.on( 'uploadError', function( file ) {
        var $li = $( '#'+file.id ),
            $error = $li.find('div.error');

        // 避免重复创建
        if ( !$error.length ) {
            $error = $('<div class="error"></div>').appendTo( $li );
        }

        $error.text('上传失败');
    });

// 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').remove();
    });
})
upload_image_register("<?=site_url('webupload/index/upload_pic');?>",'travelpath-filePicker','travelpath-input','travelpath-preview','<?=site_url("")?>');
/**
 * 图片上传进度
 * @param string server_url 图片处理路径 如：http://2014.ci.com/demo/demo/upload_image
 * @param string clickID 点击元素的ID
 * @param string inputID 上传成功之后，替换图片路径
 * @param string replaceId 要替换图片盒子
 */
function upload_image_register(server_url,clickID,inputID,replaceId,SRCPREFIX,WIDTH){
    var WIDTH = arguments[5] ? arguments[5] : 220;
    var allMaxSize = 6;
    var // 优化retina, 在retina下这个值是2
        ratio = window.devicePixelRatio || 1,

    // 缩略图大小
        thumbnailWidth = 100 * ratio,
        thumbnailHeight = 100 * ratio,

    // Web Uploader实例
        uploader;

    // 初始化Web Uploader
    uploader = WebUploader.create({

        // 自动上传。
        auto: true,
//是否压缩
        compress:false,
        // swf文件路径
        //swf: '<?php //echo URLPRE.'static/public/Lib/webuploader/js/Uploader.swf';?>',
        swf: window.location.protocol+'//'+window.location.host+'/public/js/webuploader/Uploader.swf',

        // 文件接收服务端。
        server: server_url,
        fileSizeLimit: allMaxSize*1024*1024,//限制大小10M，所有被选文件，超出选择不上

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        //pick: '#'+clickID,
        pick: {
            id: '#'+clickID,
            multiple:false,
            label: '选择图片'
        },

        // 只允许选择文件，可选。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png,ico',
            mimeTypes: 'image/*'
        }
    });


    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        $('#'+replaceId).html('<img width="50" height="50" src="public/images/load.gif">');
        var $progress = $( '#'+replaceId).next('span') ;
        $progress.empty().html('完成'+Math.floor(percentage * 100) + '%...');
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on('uploadSuccess',function( file,ret ) {
        if(ret.status==0){
            alert(ret.info);
        }else{
            var prefix = '';
            if(typeof(SRCPREFIX) != "undefined"){
                prefix =SRCPREFIX;
            }
            $('#'+inputID).val(ret.info);
            $('#'+replaceId).empty().html('<img width="'+WIDTH+'" src="'+ret.pic+'">');
            $('#'+replaceId).next('span').empty();
        }
        $( '#'+file.id ).addClass('upload-state-done');
    });
    //  验证大小
    uploader.on("error",function (type){
        if(type == "F_DUPLICATE"){
            alert("系统提示,请不要重复选择文件！");
        }else if(type == "Q_EXCEED_SIZE_LIMIT"){
            alert("系统提示<span class='C6'>所选附件总大小</span>不可超过<span class='C6'>" + allMaxSize + "M</span>哦！<br>换个小点的文件吧！");
        }

    });
}
var add_init_upload_i = 0;
function add_init_upload(){
    upload_image_register(
        "<?=site_url('webupload/index/upload_pic');?>",
        'travelpath-filePicker_'+add_init_upload_i,
        'travelpath-input_'+add_init_upload_i,
        'travelpath-preview_'+add_init_upload_i,
        '<?=site_url("")?>'
    );
    add_init_upload_i++;
}

    var addkey = 0;
    function addrow(obj,type){
        var html = '<div><input  name="Form[travelpath]" type="text"  style="display: none" id="travelpath-input_'+addkey+'" validate="{required:true}" /><div id="travelpath-filePicker_'+addkey+'">选择图片</div>'
        +'<div id="travelpath-preview_'+addkey+'"> </div><span></span></div>';
        addkey++;
        $(obj).before(html);

    }


</script>

</body>
</html>