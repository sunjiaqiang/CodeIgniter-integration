<!doctype html>
<html>
<head>
<base href="<?=site_url('');?>">
<title>管理菜单列表页面</title>
<?php $this->load->module('admin/index/page_header');?>
<link href="<?=STATIC_PATH;?>b2b_index/css/font_icon.css" rel="stylesheet" />
</head>
<body>
<div class="wrap J_check_wrap">
  <div class="nav">
    <ul>
      <li class="current"><a href="<?=$index_url;?>">菜单管理</a></li>
        <?php if($is_add):?>
      <li><a href="<?=$add_url;?>">添加菜单</a></li>
        <?php endif;?>
    </ul>
  </div>
  <form method="post" action="">
    <div class="table_list" id="content">
      <table width="100%" data-uri="<?=$ajax_status_url;?>">
        <thead>
          <tr>
              <?php if($is_edit || $is_del):?>
                  <td style="width:8%">操作</td>
              <?php endif;?>
            <td>菜单名称</td>
            <td>排序</td>
            <td>菜单模块/控制器/方法</td>
            <td>菜单状态</td>
          </tr>
        </thead>
        <tbody>
          <?php foreach($res as $k=>$v):?>
          <tr>
              <?php if($is_edit || $is_del):?>
            <td class="btn_min"><div class="operat hidden"> <a class="icon-cog action" href="javascript:;">处理</a>
                <div class="menu_select">
                  <ul>
                      <?php if($is_edit):?>
                    <li><a class="icon-pencil" href="<?=site_url('admin/index/actionmenu_edit?id='.$v['id']) ?>">编辑</a></li>
                      <?php endif;?>
                      <?php if($is_del):?>
                    <li><a class="icon-remove-2 doDel" href="javascript:;" data-uri="<?=site_url('admin/index/ajax_remove_actionmenu?id='.$v['id'])?>">删除</a></li>
                      <?php endif;?>
                  </ul>
                </div>
              </div></td>
              <?php endif;?>
            <td onClick="zhankai(<?=$v['id']?>)"><?=$v['name'];?></td>
            <td><input type="text" class="sort" value="<?=$v['sort_order']?>" alt="<?=$v['id']?>" size="5" onChange="edit_sort(this)" ></td>
            <td><?=$v['app'].'/'.$v['controller'].'/'.$v['action']?></td>
            <td><img class="pointer" data-id="<?=$v['id']?>" style="cursor: pointer;" data-field="status" data-value="<?=$v['status']?>" src="<?=STATIC_PATH.'b2b_index/images/icons/icon_'.$v['status'].'.png'?>" /></td>
          </tr>
          <?php foreach($v['list'] as $k1=>$v1):?>
          <tr style="display: none" class="level_<?=$v['id']?>">
              <?php if($is_edit || $is_del):?>
            <td class="btn_min"><div class="operat hidden"> <a class="icon-cog action" href="javascript:;">处理</a>
                <div class="menu_select">
                  <ul>
                      <?php if($is_edit):?>
                    <li><a class="icon-pencil" href="<?=site_url('admin/index/actionmenu_edit?id='.$v1['id']) ?>">编辑</a></li>
                      <?php endif;?>
                      <?php if($is_del):?>
                    <li><a class="icon-remove-2 doDel" href="javascript:;" data-uri="<?=site_url('admin/index/ajax_remove_actionmenu?id='.$v1['id'])?>">删除</a></li>
                      <?php endif;?>
                  </ul>
                </div>
              </div></td>
              <?php endif;?>
            <td onClick="zhankai2(<?=$v1['id']?>)">&nbsp;&nbsp;&nbsp;&nbsp;├─ <?=$v1['name'];?></td>
            <td><input type="text" class="sort" value="<?=$v1['sort_order']?>" alt="<?=$v1['id']?>" size="5" onChange="edit_sort(this)"></td>
            <td><?=$v1['app'].'/'.$v1['controller'].'/'.$v1['action']?></td>
            <td><img class="pointer" data-id="<?=$v1['id']?>" style="cursor: pointer;" data-field="status" data-value="<?=$v1['status']?>" src="<?=STATIC_PATH.'b2b_index/images/icons/icon_'.$v1['status'].'.png'?>" /></td>
          </tr>
           <?php if( ! empty($v1['list'])):?>
          <?php foreach($v1['list'] as $k2=>$v2):?>
          <tr style="display: none" class="level_<?=$v['id']?> leveo_<?=$v['id']?> level_<?=$v1['id']?>">
              <?php if($is_edit || $is_del):?>
            <td class="btn_min"><div class="operat hidden"> <a class="icon-cog action" href="javascript:;">处理</a>
                <div class="menu_select">
                  <ul>
                      <?php if($is_edit):?>
                    <li><a class="icon-pencil" href="<?=site_url('admin/index/actionmenu_edit?id='.$v2['id']) ?>">编辑</a></li>
                      <?php endif;?>
                      <?php if($is_del):?>
                    <li><a class="icon-remove-2 doDel" href="javascript:;" data-uri="<?=site_url('admin/index/ajax_remove_actionmenu?id='.$v2['id'])?>">删除</a></li>
                      <?php endif;?>
                  </ul>
                </div>
              </div></td>
              <?php endif;?>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;├─ <?=$v2['name'];?></td>
            <td><input type="text" class="sort" value="<?=$v2['sort_order']?>" alt="<?=$v2['id']?>" size="5" onChange="edit_sort(this)"></td>
            <td><?=$v2['app'].'/'.$v2['controller'].'/'.$v2['action']?></td>
            <td><img class="pointer" data-id="<?=$v2['id']?>" style="cursor: pointer;" data-field="status" data-value="<?=$v2['status']?>" src="<?=STATIC_PATH.'b2b_index/images/icons/icon_'.$v2['status'].'.png'?>" /></td>
          </tr>
          <?php endforeach;?>
          <?php endif;?>
          <?php endforeach;?>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
  </form>
</div>
<script type="text/javascript">
  function zhankai(id){
    if($(".level_"+id).eq(0).css('display')=='none'){
      $(".level_"+id).show();
      $(".leveo_"+id).hide();
    }else{
      $(".level_"+id).hide();
    }
  }
  function zhankai2(id){
    $(".level_"+id).toggle();
  }
  function edit_sort(obj){
    var id = obj.alt;
    var sort_order = obj.value;
    var data = 'id='+id+'&sort_order='+sort_order;
    $.ajax({
      type: "POST",
      url : "<?=site_url('admin/index/edit_sort')?>",
      data: data,
      success:function(result){
       if(result==1){
          window.location.href="<?=$index_url;?>";
       }else{
         alert('修改失败!请重试');return false;
       }
      }
        //var res=eval('(' + result + ')');
      });

  }

</script>
</body>
</html>
