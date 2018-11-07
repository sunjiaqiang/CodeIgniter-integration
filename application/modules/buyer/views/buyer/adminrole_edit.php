<!doctype html>
<html>
<head>
<title>管理角色编辑</title>
<?php $this->load->module('admin/index/page_header');?>
<link rel="stylesheet" href="<?=STATIC_PATH;?>seller/css/reset.css">
<link rel="stylesheet" href="<?=STATIC_PATH;?>seller/css/iconfont.css">
<link rel="stylesheet" href="<?=STATIC_PATH;?>seller/css/base.css">
<link rel="stylesheet" href="<?=STATIC_PATH;?>seller/css/util.css">
<link rel="stylesheet" href="<?=STATIC_PATH;?>seller/css/seller.css?v=1">
</head>
<body>
<div class="wrap">
  <div id="home_toptip"></div>
  <div class="" style="color: #4d4d4d;margin-bottom: 20px;"> 系统管理 <span>&nbsp;&gt;&nbsp;</span><span><a style="color: #34a6df;" href="<?=site_url('buyer/role/index'); ?>">角色管理</a></span> </div>
  <div class="ui-bg-v1">
    <div class="bg-default p20">
      <div class="iframe-title-group">
        <div class="title-other clearfix">
          <h3 class="title-left">编辑角色</h3>
        </div>
      </div>
      <form method="post" class="iframe-input-checkform">
        <div class="check-input mr15 fr"> <a href="<?=site_url('buyer/role/index')?>" class="button-middle-v2 button-bg-yellow button-font-white"> 角色列表 </a> </div>
      </form>
      <div class="table_full">
        <form class="formvalidate" action="<?=$form_post;?>" method="post">
            <input type="hidden" name="save_url" value="<?=$form_post;?>">
          <div class="table_full">
            <table width="100%">
              <col class="th" />
              <col/>
              <tbody>
                <tr>
                  <th>角色名称</th>
                  <td><input type="text" value="<?=$row['name'];?>" name="Form[name]" class="input rounded" size="30" validate="{required:true,rangelength:[1,20],remote:'<?=$ajax_check_name;?>'}" /></td>
                </tr>
                <tr>
                  <th>角色描述</th>
                  <td><textarea name="Form[remark]" rows="5" cols="47"><?=$row['remark'];?></textarea></td>
                </tr>
                <tr>
                  <th>状态</th>
                  <td><label>
                    <input type="radio" value="1"<?php if($row['status']==1):?> checked="checked"<?php endif;?> name="Form[status]" />
                    启用</label>
                    <label>
                    <input type="radio" value="0"<?php if($row['status']==0):?> checked="checked"<?php endif;?> name="Form[status]" />
                    禁用</label>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="btn_wrap">
            <div class="btn_wrap_pd">
              <input type="hidden" name="id" value="<?=$row['id'];?>" />
              <button type="submit" class="btn btn_submit J_ajax_submit_btn">提交</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
