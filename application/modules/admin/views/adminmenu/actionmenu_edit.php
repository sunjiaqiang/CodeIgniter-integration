<!doctype html>
<html>
<head>
<title>管理菜单编辑</title>
<?php $this->load->module('admin/index/page_header');?>
</head>
<body>
<div class="wrap">
  <div id="home_toptip"></div>
  <div class="nav">
    <ul>
      <li><a href="<?=$index_url;?>">菜单管理</a></li>
      <li><a href="<?=$add_url;?>">添加菜单</a></li>
      <li class="current"><a href="javascript:void(0)">编辑菜单</a></li>
    </ul>
  </div>
  <div class="table_full">
    <form class="formvalidate" action="<?=$form_post;?>" method="post">
        <input type="hidden" name="save_url" value="<?=$form_post;?>">
      <div class="h_a">编辑菜单</div>
      <div class="table_full">
        <table width="100%">
          <col class="th" />
          <col/>
          <tbody>
            <tr>
              <th>父级菜单</th>
              <td><select name="Form[parent_id]" class="select rounded" style="font-family: 'Courier New', Courier, monospace;">
                  <option value="0">作为顶级菜单</option>
                  <?=$select_categorys;?>
                </select>
              </td>
            </tr>
            <tr>
              <th>菜单名称</th>
              <td><input type="text" name="Form[name]" value="<?=$row['name'];?>" class="input rounded" size="30" validate="{required:true}" /></td>
            </tr>
            <tr>
              <th>模块</th>
              <td><input type="text" name="Form[app]" value="<?=$row['app'];?>" value="" class="input rounded" size="30" validate="{required:true}" /></td>
            </tr>
            <tr>
              <th>控制器</th>
              <td><input type="text" value="<?=$row['controller'];?>" name="Form[controller]" class="input rounded" size="30" validate="{required:true}" /></td>
            </tr>
            <tr>
              <th>方法</th>
              <td><input type="text" value="<?=$row['action'];?>" name="Form[action]" class="input rounded" size="30" validate="{required:true}" /></td>
            </tr>
            <tr>
              <th>参数</th>
              <td><input type="text" value="<?=$row['parameter'];?>" name="Form[parameter]" class="input rounded" size="30" />
                <span>例:groupid=1&type=2</span></td>
            </tr>
            <tr>
              <th>排序</th>
              <td><input type="text" value="<?=$row['sort_order'];?>" name="Form[sort_order]" class="input rounded" size="30" /></td>
            </tr>
            <tr>
              <th>备注</th>
              <td><textarea name="Form[remark]" rows="5" cols="47"><?=$row['remark'];?></textarea></td>
            </tr>
            <tr>
              <th>状态</th>
              <td><label>
                <input type="radio" value="1"<?php if($row['status']==1):?> checked="checked"<?php endif;?> name="Form[status]" />
                显示</label>
                <label>
                <input type="radio" value="0"<?php if($row['status']==0):?> checked="checked"<?php endif;?> name="Form[status]" />
                不显示</label>
                <span>需要明显不确定的操作时建议设置为不显示，例如：删除，修改等</span> </td>
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
</body>
</html>
