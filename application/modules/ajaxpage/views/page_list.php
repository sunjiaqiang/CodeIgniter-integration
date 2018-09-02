
<table>
  <thead>
  <th>id</th>
    <th>标题</th>
    <th>添加时间</th>
    <th>所属栏目</th>
    <th>状态</th>
      </thead>
    <?php foreach($list as $key=>$val):?>
  <tr>
    <td><?php echo $val['id'];?></td>
    <td><?php echo $val['title'];?></td>
    <td><?php echo date('Y-m-d H:i:s',$val['inputtime']);?></td>
    <td><?php echo $val['name'];?></td>
    <td><?php echo "正常";?></td>
  </tr>
  <?php endforeach;?>
</table>
<div class="page"> <?php echo $this->mypage->show();?> </div>
