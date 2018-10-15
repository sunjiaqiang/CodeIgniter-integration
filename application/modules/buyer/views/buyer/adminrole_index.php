<!doctype html>
<html>
<head>
<title>管理角色列表页面</title>
<?php $this->load->module('admin/index/page_header');?>
<link rel="stylesheet" href="<?php echo STATIC_PATH;?>seller/css/reset.css">
<link rel="stylesheet" href="<?php echo STATIC_PATH;?>seller/css/iconfont.css">
<link rel="stylesheet" href="<?php echo STATIC_PATH;?>seller/css/base.css">
<link rel="stylesheet" href="<?php echo STATIC_PATH;?>seller/css/util.css">
<link rel="stylesheet" href="<?php echo STATIC_PATH;?>seller/css/seller.css?v=1">
</head>
<body>
<div class="wrap J_check_wrap">
  <div class="" style="color: #4d4d4d;margin-bottom: 20px;"> 系统管理 <span>&nbsp;&gt;&nbsp;</span><span><a style="color: #34a6df;" href="<?php echo site_url('buyer/role/index'); ?>">角色管理</a></span> </div>
  <div class="ui-bg-v1">
    <div class="bg-default p20">
      <div class="iframe-title-group">
        <div class="title-other clearfix">
          <h3 class="title-left">角色管理</h3>
        </div>
      </div>
      <form method="post" action="" class="iframe-input-checkform">
        <div>
          <div class="check-input mr15 fr"> <a href="<?php echo site_url('buyer/role/add')?>" class="button-middle-v2 button-bg-yellow button-font-white"> 添加角色 </a> </div>
        </div>
      </form>
      <div class="iframe-table iframe-traffic-table data-table-1" id="content">
        <table width="100%" data-uri="<?php echo site_url('buyer/role/ajax_status');?>">
          <thead>
            <tr>
              <th style="width:8%;">角色名称</th>
              <th style="width:8%;">角色描述</th>
              <th style="width:8%;">添加时间</th>
              <th style="width:2%;">状态</th>
              <th style="width:8%;">操作</th>
            </tr>
          </thead>
          <?php if($list):?>
          <tbody>
            <?php foreach($list as $val):?>
            <tr>
              <td><?php echo $val['name'];?></td>
              <td style="width:4%;"><?php echo $val['remark'];?></td>
              <td style="width:4%;"><?php echo $val['add_time'];?></td>
              <td style="width:2%;"><img class="pointer" data-id="<?php echo $val['id'];?>" style="cursor: pointer;" data-field="status" data-value="<?php echo $val['status'];?>" src="<?php echo STATIC_PATH;?>b2b_index/images/icons/icon_<?php echo $val['status'];?>.png" /></td>
              <td class=""><div class="mt10 mb10">
                  <?php if($val['name']!='超级管理员'):?>
                  <a class="yun_shanchu traffic-control-color" href="<?php echo $val['edit_url'];?>">编辑</a> <a class="yun_shanchu traffic-control-color" href="<?php echo $val['author_url'];?>">设置权限</a> <a class="yun_shanchu traffic-control-color traffic-control-color-bianji doDel" href="javascript:;" data-uri="<?php echo $val['remove_url'];?>">删除</a>
                  <?php endif;?>
                </div></td>
            </tr>
            <?php endforeach;?>
          </tbody>
          <?php endif;?>
        </table>
      </div>
      <div class="page_nav"> <?php echo $this->mypage->show();?> </div>
    </div>
  </div>
</div>
<script type="text/javascript">

</script>
</body>
</html>