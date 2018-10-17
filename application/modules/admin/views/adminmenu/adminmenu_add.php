<!doctype html>
<html>
<head>
<title>管理菜单添加</title>
<?php $this->load->module('admin/index/page_header');?>
</head>
<body>
<div class="wrap">
  <div id="home_toptip"></div>
  <div class="nav">
    <ul>
      <li><a href="<?php echo site_url('admin/index/adminmenu')?>">菜单管理</a></li>
      <li class="current"><a href="<?php echo site_url('admin/index/adminmenu_add')?>">添加菜单</a></li>
    </ul>
  </div>
  <div class="table_full">
    <form class="formvalidate" action="<?php echo $form_post;?>" method="post">
      <div class="h_a">添加菜单</div>
      <div class="table_full">
        <table width="100%">
          <col class="th" />
          <col/>
          <tbody>
            <tr>
              <th>父级菜单</th>
              <td><select name="Form[parent_id]" class="select rounded" style="font-family: 'Courier New', Courier, monospace;">
                  <option value="0">作为顶级菜单</option>
                  <?php echo $select_categorys;?>
                </select>
              </td>
            </tr>
            <tr>
              <th>菜单名称</th>
              <td><input type="text" name="Form[name]" class="input rounded" size="30" validate="{required:true}" /></td>
            </tr>
            <tr>
              <th>模块</th>
              <td><input type="text" name="Form[app]" value="" class="input rounded" size="30" validate="{required:true}" /></td>
            </tr>
            <tr>
              <th>控制器</th>
              <td><input type="text" name="Form[controller]" value="" class="input rounded" size="30" validate="{required:true}" /></td>
            </tr>
            <tr>
              <th>方法</th>
              <td><input type="text" name="Form[action]" value="" class="input rounded" size="30" validate="{required:true}" /></td>
            </tr>
            <tr>
              <th>参数</th>
              <td><input type="text" name="Form[parameter]" value="" class="input rounded" size="30" />
                <span>例:groupid=1&type=2</span></td>
            </tr>
            <tr>
              <th>排序</th>
              <td><input type="text" name="Form[sort_order]" value="" class="input rounded" size="30" /></td>
            </tr>
            <tr>
              <th>备注</th>
              <td><textarea name="Form[remark]" rows="5" cols="47"></textarea></td>
            </tr>
            <tr>
              <th>状态</th>
              <td><label>
                <input type="radio" value="1" name="Form[status]" checked="checked" />
                显示</label>
                <label>
                <input type="radio" value="0" name="Form[status]" />
                不显示</label>
                <span>需要明显不确定的操作时建议设置为不显示，例如：删除，修改等</span> </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="btn_wrap">
        <div class="btn_wrap_pd">
          <input type="hidden" name="id" value="0" />
          <button type="submit" class="btn btn_submit J_ajax_submit_btn">提交</button>
        </div>
      </div>
    </form>
  </div>
</div>
</body>
</html>
