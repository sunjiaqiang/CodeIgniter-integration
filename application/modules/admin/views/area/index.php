<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<base href="<?= site_url(''); ?>">
<title>地区列表</title>
<script type="text/javascript" src="static/js/jquery-1.9.1.min.js"></script>
<style type="text/css">
/*系统后台内容区域*/


html, body, div, dl, dt, dd, ul, p, th, td, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend {
	margin: 0;
	padding: 0;
}
/*body, input, button, select, textarea { font: 12px/1.5 Tahoma,'Microsoft Yahei','Simsun'; color:#444;}*/
body, input, button, select, textarea {
	color: #444;
}
cite, em, th {
	font-style: inherit;
	font-weight: inherit;
}
strong {
	font-weight: 700;
}
td, th, div {
	word-break: break-all;
	word-wrap: break-word;
}
table {
	border-collapse: collapse;
	border-spacing: 0;
}
th {
	text-align: left;
	font-weight: 100;
}
ol li {
	list-style: decimal outside;
}
ol {
	padding: 0 0 0 18px;
	margin: 0;
}
li {
	list-style: none;
}
img {
	border: 0;
}
html {
	-webkit-text-size-adjust: none;
}
/*
    ===================
    html5相关标签
    ===================
    */
article, aside, details, figcaption, figure, footer, header, hgroup, nav, section {
	display: block;
}

.content{ width:600px; margin:0 auto;}
.mb10{ margin: 10px 0;}
</style>
</head>
<body>
<form action="<?=site_url('admin/area/save');?>" method="post">
<div class="content">
  <div class="mb10"> 
    <script type="text/javascript">
       var dis_arr = ['continent','country','province','city','area'];
    </script>
    <select name="t[continent][]" id="continent" onchange="_showdistrict(dis_arr, 1)">
      <option value="-1" did="-1">选择洲</option>
    </select>
    <select name="t[country][]" id="country" onchange="_showdistrict(dis_arr, 2)">
      <option value="-1" did="-1">选择国家</option>
    </select>
    <select name="t[province][]" id="province" onchange="_showdistrict(dis_arr, 3)">
      <option value="-1" did="-1">选择省</option>
    </select>
    <select name="t[city][]" id="city" onchange="_showdistrict(dis_arr, 4)">
      <option value="-1" did="-1">选择市</option>
    </select>
    <select name="t[area][]" id="area">
      <option value="-1" did="-1">选择区/县</option>
    </select>
  </div>
  <a class="add" href="javascript:void(0);" onclick="add_dist(this);">增加归属地</a> </div>

	<div class="sub"><button type="submit">提交</button> </div>
</form>
  <script>
  	var district_url = '<?=site_url("admin/api/index?id=")?>';
	_showdistrict(dis_arr,0);
  	function _showdistrict(arr,level){
		var level_html = [
			'<option value="-1" did="-1">选择洲</option>',
			'<option value="-1" did="-1">选择国家1</option>',
			'<option value="-1" did="-1">选择省1</option>',
			'<option value="-1" did="-1">选择市1</option>',
			'<option value="-1" did="-1">选择区/县1</option>'
		];
		var id = -1;
		if(level == 1 && arr[0] && document.getElementById(arr[0])){
			id = $('#'+arr[0]).find('option:selected').attr('did');	
		}else if(level == 2 && arr[1] && document.getElementById(arr[1])){
			id = $('#'+arr[1]).find('option:selected').attr('did');		
		}else if(level == 3 && arr[2] && document.getElementById(arr[2])){
			id = $('#'+arr[2]).find('option:selected').attr('did');		
		}else if(level == 4 && arr[3] && document.getElementById(arr[3])){
			id = $('#'+arr[3]).find('option:selected').attr('did');		
		}
		
		console.log(id,level);
		
		
		if(id!=-1 || level == 0){
			if(level == 0){
				id = 0;	
			}	
			$.ajax({
				type:'GET',
				url:district_url+id,
				dataType:"json",
				success: function(msg){					
					console.log(msg);	
					var s = '';
					for(let i in msg){
						s+='<option value="'+msg[i].id+'" did="'+msg[i].id+'">'+msg[i].name+'</option>';
					}
					
					if(document.getElementById(arr[level])){
						$('#'+arr[level]).html(level_html[level]+s);	
						_showdistrict(arr,level+1);	
					}
				}
					
			})
		}else{
			if(document.getElementById(arr[level])){
				$('#'+arr[level]).html(level_html[level]);
				_showdistrict(arr,level+1);	
			}	
		}
		
			
	}
	var dist=0;
	function add_dist(obj){
		dist++;
		var ct = 'continent'+dist;
		var co = 'country'+dist;
		var pr = 'province'+dist;
		var ci = 'city'+dist;
		var ar = 'area'+dist;
		var dis_arr = "['"+ct+"','"+co+"','"+pr+"','"+ci+"','"+ar+"']";

		console.log(dis_arr);

		var html='<div class="mb10">';
		html+='<select name="t[continent][]" id="'+ct+'" onchange="_showdistrict('+dis_arr+', 1)">'
			+'<option value="-1" did="-1">选择洲</option>'
			+'</select>'
			+' <select name="t[country][]" id="'+co+'" onchange="_showdistrict('+dis_arr+', 2)">'
			+'<option value="-1" did="-1">选择国家1</option>'
			+'</select>'
			+' <select name="t[province][]" id="'+pr+'" onchange="_showdistrict('+dis_arr+', 3)">'
			+'<option value="-1" did="-1">选择省1</option>'
			+'</select>'
			+' <select name="t[city][]" id="'+ci+'" onchange="_showdistrict('+dis_arr+', 4)">'
			+'<option value="-1" did="-1">选择市1</option>'
			+'</select>'
			+' <select name="t[area][]" id="'+ar+'">'
			+'<option value="-1" did="-1">选择区/县1</option>'
			+'</select>';
		html+='&nbsp;&nbsp;<a class="remove" href="javascript:void(0);" onclick="remove_dist(this);">移除</a></div>';
		$(obj).before(html);
		_showdistrict([ct,co,pr,ci,ar],0);

	}

  </script>
  
</body>
</html>