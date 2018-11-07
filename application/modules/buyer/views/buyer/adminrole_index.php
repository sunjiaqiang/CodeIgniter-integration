<!doctype html>
<html>
<head>
<title>管理角色列表页面</title>
<?php $this->load->module('admin/index/page_header');?>
<link rel="stylesheet" href="<?=STATIC_PATH;?>seller/css/reset.css">
<link rel="stylesheet" href="<?=STATIC_PATH;?>seller/css/iconfont.css">
<link rel="stylesheet" href="<?=STATIC_PATH;?>seller/css/base.css">
<link rel="stylesheet" href="<?=STATIC_PATH;?>seller/css/util.css">
<link rel="stylesheet" href="<?=STATIC_PATH;?>seller/css/seller.css?v=1">
</head>
<body>
<div class="wrap J_check_wrap">
  <div class="" style="color: #4d4d4d;margin-bottom: 20px;"> 系统管理 <span>&nbsp;&gt;&nbsp;</span><span><a style="color: #34a6df;" href="<?=site_url('buyer/role/index'); ?>">角色管理</a></span> </div>
  <div class="ui-bg-v1">
    <div class="bg-default p20">
      <div class="iframe-title-group">
        <div class="title-other clearfix">
          <h3 class="title-left">角色管理</h3>
        </div>
      </div>
      <form method="post" action="" class="iframe-input-checkform">
        <div>
          <div class="check-input mr15 fr">
              <?php if($is_add):?>
              <a href="<?=$add_url;?>" class="button-middle-v2 button-bg-yellow button-font-white"> 添加角色 </a>
              <?php endif;?>
          </div>
        </div>
      </form>
      <div class="iframe-table iframe-traffic-table data-table-1" id="content">
        <table width="100%" data-uri="<?=$ajax_status_url;?>">
          <thead>
            <tr>
              <th style="width:8%;">角色名称</th>
              <th style="width:8%;">角色描述</th>
              <th style="width:8%;">添加时间</th>
              <th style="width:2%;">状态</th>
              <?php if ($auth_count>0):?>
              <th style="width:8%;">操作</th>
                <?php endif;?>
            </tr>
          </thead>
          <?php if($list):?>
          <tbody>
            <?php foreach($list as $val):?>
            <tr>
              <td><?=$val['name'];?></td>
              <td style="width:4%;"><?=$val['remark'];?></td>
              <td style="width:4%;"><?=$val['add_time'];?></td>
              <td style="width:2%;"><img class="pointer" data-id="<?=$val['id'];?>" style="cursor: pointer;" data-field="status" data-value="<?=$val['status'];?>" src="<?=STATIC_PATH;?>b2b_index/images/icons/icon_<?=$val['status'];?>.png" /></td>
                <?php if ($auth_count>0):?>
                <td class=""><div class="mt10 mb10">
                  <?php if($val['name']!='超级管理员'):?>
                      <?php if($is_edit):?>
                      <a class="yun_shanchu traffic-control-color" href="<?=$val['edit_url'];?>">编辑</a>
                      <?php endif;?>
                      <?php if ($is_menu_authority):?>
                      <a class="yun_shanchu traffic-control-color" href="<?=$val['author_url'];?>">设置菜单权限</a>
                      <?php endif;?>
                      <?php if ($is_action_authority):?>
                      <a class="yun_shanchu traffic-control-color" href="<?=$val['set_action_url'];?>">设置操作权限</a>
                      <?php endif;?>
                      <?php if($is_del):?>
                      <a class="yun_shanchu traffic-control-color traffic-control-color-bianji doDel" href="javascript:;" data-uri="<?=$val['remove_url'];?>">删除</a>
                      <?php endif;?>
                  <?php endif;?>
                </div></td>
                <?php endif;?>
            </tr>
            <?php endforeach;?>
          </tbody>
          <?php endif;?>
        </table>
      </div>
      <div class="page_nav"> <?=$this->mypage->show();?> </div>
    </div>
  </div>
</div>
<script type="text/javascript">

</script>
</body>
</html>