<!doctype html>
<html>
<head>
<title>增加线路</title>
<?php $this->load->module('admin/index/page_header');?>
<link rel="stylesheet" href="<?=STATIC_PATH;?>b2b_index/css/buyer_style.css">
<style type="text/css">
        body{
            position: relative;
        }
        .container{width:auto!important;
            clear: both;
            padding: 0 20px;
            height: auto;}
        .content-wrap{width:auto;float:none;
            background: #fafafa;
            overflow: hidden;
            -webkit-box-shadow: 0px 0px 9px 2px rgba(191,187,191,0.35);
            -moz-box-shadow: 0px 0px 9px 2px rgba(191,187,191,0.35);
            box-shadow: 0px 0px 9px 2px rgba(191,187,191,0.35);
            padding: 20px;}
        .mt20{margin-top:0!important;padding:20px 0;}
        .button-bg-lightblue {

            background: #f7931e;
            font-size: 12px;
            color: #fff;
            display: inline-block;
            text-align: center;
            cursor: pointer;
            border: 0;
        }
        .table-v1 .button-small{
            background: #2b94d9;
            font-size: 12px;
            color: #fff;
            padding: 0px 20px!important;
            display: inline-block;
            text-align: center;
            line-height:20px!important;
            height: 20px!important;
            cursor: pointer;
            border-radius: 2px;
            border:0;
        }
        .button-bg-gray, .button-bg-lightorange{
            background: #f15a24!important;
            font-size: 12px;
            color: #fff;
            padding: 0px 20px!important;
            display: inline-block;
            text-align: center;
            line-height:20px!important;
            height: 20px!important;
            cursor: pointer;
            border-radius: 2px;
            border:0;
        }
        .green-btn{

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
    <div class="" style="color: #4d4d4d;margin-bottom: 20px;"> 系统管理 <span>&nbsp;&gt;&nbsp;</span><span><a style="color: #34a6df;" href="<?=$index_url; ?>">用户管理</a></span> </div>
    <div class="content-wrap">
      <div class="choose-tab"> <a class="item cur">用户管理</a>
          <?php if ($is_add):?>
          <a href="<?=$add_url;?>" class="green-btn fr action-add-user accesscheck" data-accessurl="10902">创建用户</a>
          <?php endif;?>
      </div>
      <div class="admin-wrap">
        <table class="table-v1 table-default-skin mt10">
          <tbody>
            <tr align="center">
              <td class="head first" width="90">用户名</td>
              <td class="head" width="60">真实姓名</td>
              <td class="head" width="40">状态</td>
              <td class="head">管理类型</td>
              <td class="head" width="120">添加时间</td>
              <td class="head last" width="100">操作</td>
            </tr>
            <?php foreach($list as $val):?>
            <tr align="center">
              <td><?=$val['name'];?></td>
              <td><?=$val['realname'];?></td>
              <td><?=$val['is_open']?  '正常' : '<span style="color:orangered;">停止</span>';?></td>
              <td><?=$val['role_name']?></td>
              <td><?=$val['add_time']?></td>
              <td>
                  <?php if ($is_edit):?>
                  <a href="<?=site_url('buyer/user/edit?id='.$val['id'])?>" class="button-small button-bg-lightblue button-font-black edit-pay-info accesscheck">编辑</a>
                  <?php endif;?>
                <?php if ( ! $val['is_founder']):?>
                <?php //if($is_del):?>
                <a  class="button-small button-bg-lightorange button-font-orange accesscheck doDel" data-uri="<?=site_url('buyer/user/ajax_remove?id='.$val['id'])?>">删除</a>
                <?php //endif;?>
                <?php endif;?>
              </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
        <div class="mt20">
          <div class="page_nav"> <?=$this->mypage->show();?> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
</script>
<?php $this->load->module('admin/index/page_footer');?>
</body>
</html>
