<!doctype html>
<html>
<head>
<title>编辑角色菜单权限</title>
<?php $this->load->module('admin/index/page_header');?>
<link href="<?=STATIC_PATH;?>lib/zTree/zTreeStyle/zTreeStyle.css" rel="stylesheet" />
<script type="text/javascript" src="<?=STATIC_PATH;?>lib/zTree/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="<?=STATIC_PATH;?>lib/zTree/jquery.ztree.excheck-3.5.js"></script>
</head>
<body>

<div class="wrap">
    <div id="home_toptip"></div>
	<div class="" style="color: #4d4d4d;margin-bottom: 20px;">
		系统管理 <span>&nbsp;&gt;&nbsp;</span><span><a style="color: #34a6df;" href="<?=$index_url;?>">角色管理</a></span>
	</div>
    <div class="nav">
        <ul>
			<li><a href="<?=$index_url;?>">角色管理</a></li>
			<li><a href="<?=$add_url;?>">添加角色</a></li>
            <li class="current"><a href="javascript:void(0)">编辑角色菜单权限</a></li>
        </ul>
    </div>
    <div class="table_full">
	    <form class="formvalidate" action="<?=$form_post;?>" method="post">
<!--	    <div class="h_a">编辑角色权限</div>-->
	    <div class="table_full">
            <ul id="treeDemo" class="ztree"></ul>
	    </div>
	    <div class="btn_wrap">
	        <div class="btn_wrap_pd">
				<input type="hidden" name="role_id" value="<?=$role_id;?>" />
				<input type="hidden" name="menu_id"/>
				<input type="hidden" name="type" value="1" />
	            <button id="submit" type="submit" class="btn btn_submit J_ajax_submit_btn">提交</button>
	        </div>
	    </div>
	    </form>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	//配置
	var setting = {
		check: {
			enable: true
		},
	    data: {
	        simpleData: {
	            enable: true,
	            idKey: "id",
	            pIdKey: "parent_id",
	        }
	    },
	    callback: {
	        beforeClick: function (treeId, treeNode) {
	            if (treeNode.isParent) {
	                zTree.expandNode(treeNode);
	                return false;
	            } else {
	                return true;
	            }
	        },
			onClick:function(event, treeId, treeNode){
				//栏目ID
				var catid = treeNode.catid;
				//保存当前点击的栏目ID
				setCookie('tree_catid',catid,1);
			}
	    }
	};
	//节点数据
	var zNodes =<?=$json;?>;
	var code;
	$.fn.zTree.init($("#treeDemo"), setting, zNodes);
	var zTree = $.fn.zTree.getZTreeObj("treeDemo"),py = "p",sy = "s",pn = "p",sn = "s",type = { "Y":py + sy, "N":pn + sn};
	zTree.setting.check.chkboxType = type;
	var str = 'setting.check.chkboxType = { "Y" : "' + type.Y + '", "N" : "' + type.N + '" };';
	if (!code) code = $("#code");
	code.empty();
	code.append("<li>"+str+"</li>");

	$('#submit').click(function(){

		var  nodes = zTree.getCheckedNodes(true); 
		var str = "";
		$.each(nodes,function(i,value){
			if (str != "") {
				str += ","; 
			}
			str += value.id;
		});
		$('.formvalidate').find('input[name="menu_id"]').val(str);
	})
});
</script>
</body>
</html>