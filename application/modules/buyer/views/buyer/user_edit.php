<!doctype html>
<html>
<head>
<base href="<?=site_url('');?>">
<title>增加线路</title>
<?php $this->load->module('admin/index/page_header'); ?>
<link rel="stylesheet" href="<?= STATIC_PATH; ?>b2b_index/css/buyer_style.css">
<link rel="stylesheet" href="<?= STATIC_PATH; ?>lib/layui-v2.1.5/css/layui.css"  media="all">
<style type="text/css">
        body {
            position: relative;
        }

        .container {
            width: auto !important;
            clear: both;
            padding: 0 20px;
            height: auto;
        }

        .content-wrap {
            width: auto;
            float: none;
            background: #fafafa;
            overflow: hidden;
            -webkit-box-shadow: 0px 0px 9px 2px rgba(191, 187, 191, 0.35);
            -moz-box-shadow: 0px 0px 9px 2px rgba(191, 187, 191, 0.35);
            box-shadow: 0px 0px 9px 2px rgba(191, 187, 191, 0.35);
            padding: 20px;
        }

        .mt20 {
            margin-top: 0 !important;
            padding: 20px 0;
        }

        .button-bg-lightblue {

            background: #f7931e;
            font-size: 12px;
            color: #fff;
            display: inline-block;
            text-align: center;
            cursor: pointer;
            border: 0;
        }

        .table-v1 .button-small {
            background: #2b94d9;
            font-size: 12px;
            color: #fff;
            padding: 0px 20px !important;
            display: inline-block;
            text-align: center;
            line-height: 20px !important;
            height: 20px !important;
            cursor: pointer;
            border-radius: 2px;
            border: 0;
        }

        .button-bg-gray, .button-bg-lightorange {
            background: #f15a24 !important;
            font-size: 12px;
            color: #fff;
            padding: 0px 20px !important;
            display: inline-block;
            text-align: center;
            line-height: 20px !important;
            height: 20px !important;
            cursor: pointer;
            border-radius: 2px;
            border: 0;
        }

        .green-btn {

            background: #34a6df;
            font-size: 12px;
            color: #fff;
            padding: 0px 20px;
            display: inline-block;
            text-align: center;
            margin-right: 10px;
            cursor: pointer;
        }

        .button-bg-blue {
            background: #34a6df;
            font-size: 12px;
            color: #fff;
            display: inline-block;
            text-align: center;
            margin-right: 10px;
            cursor: pointer;
            border: 0;
        }
    </style>
</head>
<body>
<div class="main mt20 clearfix">
  <div class="container">
    <div class="" style="color: #4d4d4d;margin-bottom: 20px;"> 系统管理 <span>&nbsp;&gt;&nbsp;</span><span><a style="color: #34a6df;" href="<?php echo site_url('buyer/user/index'); ?>">用户管理</a></span> </div>
    <div class="content-wrap">
      <div class="choose-tab"><a class="item cur">用户管理</a></div>
      <div class="admin-wrap">
        <form action="" method="post" class="formvalidate">
          <table class="table-v1 table-default-skin mt10">
            <tbody>
              <tr>
                <td class="head" width="70">用户名</td>
                <td><?php if (!$info):?>
                  <input type="text" name="Form[name]" class="import rounded" size="30"
                                           validate="{required:true,remote:'<?php echo $ajax_check_name; ?>'}">
                  <?php else: ?>
                  <?php echo $info['name']; ?>
                  <?php endif;?>
                </td>
              </tr>
              <tr>
                <td class="head">真实姓名<em class="red-color">*</em></td>
                <td><input type="text" id="realname" name="Form[realname]" validate="{required:true}"
                                       value="<?php echo $info ? $info['realname'] : '';?>" class="import">
                </td>
              </tr>
              <tr>
                <td class="head">密 码：</td>
                <td><input id="u_password" type="password" name="Form[password]" class="import rounded"
                                       size="30"
                                       validate1="{required:true,rangelength:[6,16],equalTo:'#confirm_password'}">
                </td>
              </tr>
              <tr>
                <td class="head">确认密码：</td>
                <td><input type="password" id="confirm_password" name="confirm_password"
                                       class="import rounded" size="30"
                                       validate1="{required:true,rangelength:[6,16],equalTo:'#u_password'}">
                </td>
              </tr>
              <tr>
                <td class="head">性别</td>
                <td><input type="radio" value="1" <?=$info ? (($info['gender']==1) ? 'checked' : '') : 'checked'?> name="Form[gender]">
                  男
                  <input type="radio" value="2" <?=$info ? (($info['gender']==2) ? 'checked' : '') : ''?> name="Form[gender]">
                  女
                  <input type="radio" value="0" <?=$info ? (($info['gender']==0) ? 'checked' : '') : ''?> name="Form[gender]" >
                  保密 </td>
              </tr>
              <tr>
                <td class="head">状态</td>
                <td><input type="radio" value="1" <?=$info ? (($info['is_open']==1) ? 'checked' : '') : 'checked'?> name="Form[is_open]">
                  正常
                  <input type="radio" value="0" <?=$info ? (($info['is_open']==0) ? 'checked' : '') : ''?> name="Form[is_open]">
                  停止 </td>
              </tr>
              <tr>
                <td class="head">电子邮箱<em class="red-color">*</em></td>
                <td><input type="text" id="email" name="Form[email]" validate="{required:true,email:true}"
                                       value="<?php echo $info ? $info['email'] : '';?>" class="import">
                </td>
              </tr>
              <tr>
                <td class="head">QQ号码</td>
                <td><input type="text" id="qq" name="Form[qq]" value="<?php echo $info ? $info['qq']:''; ?>"class="import">
                </td>
              </tr>
              <tr>
                <td class="head">角色管理</td>
                <td><?php foreach ($role_list as $item) { ?>
                  <input type="radio" <?=$info ? (($item['id']==$info['role_id']) ? 'checked' : '') : '';?> name="Form[role_id]" value="<?php echo $item['id'] ?>"
                                    validate="{required:true}" >
                  <?php echo $item['name'] ?>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td> 上传头像 </td>
                <td><div class="layui-upload">
                    <button type="button" class="layui-btn" id="test1">上传头像</button>
                    <div class="layui-upload-list">
                      <input type="hidden" name="Form[avatar]" value="<?=$info ? ($info['avatar'] ? $info['avatar'] : '') : '';?>">
                      <img class="layui-upload-img" id="demo1" width="105" height="105" <?=$info ? ($info['avatar'] ? "src=".$info['avatar'] : '') : '';?>>
                      <p id="demoText"></p>
                    </div>
                  </div></td>
              </tr>
            </tbody>
          </table>
          <div class="submit-btn-box">
            <input type="submit" class="blue-btn-big J_ajax_submit_btn" value="提交">
          </div>
          <input id="id" name="id" style="display:none" value="<?php echo $info ? $info['id']:0;?>">
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?=STATIC_PATH;?>lib/layui-v2.1.5/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<?php $this->load->module('admin/index/page_footer'); ?>
<script>
    layui.use('upload', function(){
        var $ = layui.jquery
            ,upload = layui.upload;

        //普通图片上传
        var uploadInst = upload.render({
            elem: '#test1'
            ,accept: 'file' //普通文件
            ,url: "<?php echo site_url('plupload/index/upload_pic');?>"
            ,exts: 'jpg|jpeg|png|gif' //只允许上传压缩文件
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo1').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                //如果上传失败
                if(res.code > 0){
                    return layer.msg('上传失败');
                }
                //上传成功
                console.log(res);
                $('input[name*=avatar]').val(res.pic);
            }
            ,error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });

    });
</script>
</body>
</html>
