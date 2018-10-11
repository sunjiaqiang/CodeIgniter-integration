<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <base href="<?=base_url('')?>">
  <title>七牛oss整合plupload图片文件上传</title>
    <script src="<?=STATIC_PATH;?>js/jquery/jquery-1.9.1.min.js"></script>
    <script src="<?=STATIC_PATH;?>js/plupload/plupload.min.js"></script>
  <style>
     a{cursor:pointer;}
            body{background: #fff none repeat scroll 0 0; color: #333; font: 12px/1.5 "Microsoft YaHei","Helvetica Neue",Helvetica,STHeiTi,sans-serif; background-position: left top; background-repeat: repeat; background-attachment: scroll;}
            .clearfix:after{visibility:hidden; display:block; font-size:0; content:" "; clear:both; height:0}
            *:first-child+html .clearfix{zoom:1}
            ul,li{list-style: none;padding:0;margin:0}
            .upload_box{ width: 500px; padding: 5px; margin: 0 auto; box-shadow: 0 4px 20px 1px rgba(0, 0, 0, 0.2); }
            .upload_box h1{font-size: 14px;font-weight: 700;}
            .upload_box ul.pic_list{ overflow: hidden; }
            .upload_box ul.pic_list li{ width: 80px; height: 80px; float: left; margin:5px 0 5px 15px; position: relative; overflow: hidden; }
            .upload_box ul.pic_list li img{ width: 100%; height: 80px; }
            .upload_tip{ width: 100%; height: 25px;  background: rgba(0, 0, 0, 0.8) none repeat scroll 0 0; position: absolute; left: 0; bottom: -25px; }
            .progress{position:relative;padding: 1px; border-radius:3px; margin:30px 0 0 0;}
            .bar{background-color: green; display:block; width:0%; height:20px; border-radius:3px;}
            .percent{position:absolute; height:20px; display:inline-block;top:3px; left:2%; color:#fff}
            .upload_tip span,.upload_tip > i{
              color: green;
              font-size: 18px;
              margin: 0 0 0 10px;
              cursor: pointer;
              font-family: "宋体";
            }
            .upload_tip>i {
                color: red;
                font-family: "微软雅黑";
                font-style: normal;
            }
  </style>
</head>
<body>
  <div class="upload_box">
      <h1>文件上传</h1>
      <div class="upload_num">
        共<span class="uploaded_length">0</span>张，还能上传<span id="remain_upload">10</span>张
      </div>
      <ul class="pic_list">
      
        <li id="local_upload"><img src="<?php echo base_url();?>public/images/local_upload.png" id="upload_btn"></li>
       
       
      </ul>
  </div>
  <script>
     var upload_total=10;//总上传张数
     var uploader = new plupload.Uploader({
      runtimes: 'gears,html5,html4,silverlight,flash', //上传插件初始化选用那种方式的优先级顺序
      flash_swf_url: 'plupload/Moxie.swf', //flash文件地址
      silverlight_xap_url: 'plupload/Moxie.xap', //silverlight文件地址
      browse_button:"upload_btn",
      url:"<?php echo site_url('plupload/index/qiniuupload');?>",
      filters:{
        max_file_size:"8mb",
        mime_types:[
          {title:'files',extensions:"jpg,png,gif,jpeg"}
        ],
      }
     }); 
     uploader.init();

     uploader.bind('FilesAdded',function(up,files){
        var uploaded_length = $(".pic_list").children("li").length;
        console.log(files.length);
        if(files.length > upload_total){
          $("#local_upload").hide();
        }
        var li="";
        plupload.each(files,function(file){
          li+="<li class='li_upload' id='"+file.id+"'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
          uploaded_length++;
        });
        $(".pic_list").prepend(li);
        uploader.start();
     });

     uploader.bind('UploadProgress',function(up,file){
      var percent = file.percent;
      $("#"+file.id).find(".bar").css({"width":percent});
      $("#"+file.id).find(".percent").text(percent+"%");
     });

     uploader.bind('FileUploaded',function(up,file,info){
      var data = eval("("+info.response+")");
      console.log(data);
      if(data.error){
        alert(data.error);
        return false;
      }
      $("#"+file.id).html("<img class='img_common' src='" + data.pic + "' /><div  class='upload_tip'><span class='onLandR' onclick='reverse_left($(this))'>&lt;</span><span class='onLandR' onclick='reverse_right($(this))'>&gt;</span><i class='onDelPic' onclick=delPic('" + data.pic + "','" + file.id + "')>×</i></div>");
      hover_li();
      showUploadBtn();
     });

     uploader.bind('Error',function(up,err){
        alert(err.message);
     });

     function hover_li(){
      $(".pic_list").children('.li_upload').hover(function(){
        $(this).find(".upload_tip").stop(true,false).animate({"bottom":"0"});
      },function(){
        $(this).find(".upload_tip").stop(true,false).animate({"bottom":"-25px"});
      });
     }
     /**
      * 向左移动
      * [reverse_left description]
      * @param  {[type]} obj [description]
      * @return {[type]}     [description]
      */
     function reverse_left(obj){
        var this_li = obj.parents("li");
        var li_prev = this_li.prev();
        if(li_prev.hasClass("li_upload")){
          this_li.insertBefore(li_prev);
        }
     }
     /**
      * 向右移动
      * [reverse_right description]
      * @param  {[type]} obj [description]
      * @return {[type]}     [description]
      */
     function reverse_right(obj){
        var this_li = obj.parents("li");
        var li_next = this_li.next();
        if(li_next.hasClass("li_upload")){
          this_li.insertAfter(li_next);
        }
     }
     /**
      * 判断是否显示上传按钮
      * [showUploadBtn description]
      * @return {[type]} [description]
      */
     function showUploadBtn(){
        var uploaded_length = $(".img_common").length;
        console.log(uploaded_length);
        var remain_length = (upload_total-uploaded_length) > 0 ? (upload_total-uploaded_length) : 0;
        $(".uploaded_length").text(uploaded_length);
        $("#remain_upload").text(remain_length);
        if(uploaded_length >= upload_total){
          $("#local_upload").hide();
        }else{
          $("#local_upload").show();
        }
     }
     /**
      * 删除图片
      * [delPic description]
      * @param  {[type]} path [description]
      * @return {[type]}      [description]
      */
     function delPic(pic,fileid){
        $.ajax({
          type:"POST",
          url:"<?php echo site_url('plupload/index/qiniu_delete_file');?>",
          async:true,
          dataType:"json",
          data:{pic:pic},
          beforeSend:function(){
            //do something
          },
          success:function(data){
            if(data.status==1){
              $("#"+fileid).remove();
               showUploadBtn();
            }            
          },
          error:function(){
            //do something
          }
        });
     }
  </script>
</body>
</html>