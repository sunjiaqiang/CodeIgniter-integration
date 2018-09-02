<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
<title>滚动加载</title>
<script src="<?php echo base_url();?>public/js/jquery/jquery-1.9.1.min.js"></script>
<style>
a {
	color: #999
}
a:hover {
	color: #ff0000;
}
a.cur {
	color: #ff0000;
}
ul,li{ list-style: none;}
.search ul li{ height:110px; line-height:110px; margin:15px 0;}
</style>
</head>
<body>
<div class="search">
	<ul>
    	<?php foreach($list as $key=>$val):?>
    	<li><?=$val['title'];?></li>
        <?php endforeach;?>
    </ul>
    <a href="javascript:;" class="btn-grey btn" id="js-load-more">加载更多</a>
  </div>
</body>

<script>
var page = <?php echo $page+1;?>;
var loading = 0;

$(window).scroll(function(){
	//console.log($(window).height());
	totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
	 if ($(document).height() <= totalheight && !loading){
		 	loading = 1;
            var $js_load_more = $('#js-load-more');
            $js_load_more.text('加载中...');
			var html='';
			$.ajax({
				url:"<?php echo site_url('scroll/index/index');?>",
				type:"GET",
				async:true,
				data:{"page":page,"is_ajax":1},
				dataType:"json",
				beforeSend: function(){
					//beforesend	
				},
				success:function(data){
					//success  JSON.parse					
					console.log(data.list.length);
					
					if(data.list.length>0){
						for(var i=0;i<data.list.length;i++){							
							html+="<li>"+data.list[i].title+"</li>";
						}
						$(".search ul").append(html);	
						 $js_load_more.text('加载更多');
						loading = 0;
					}else{
						$js_load_more.text('没有更多了');	
					}
					
					page++;
					console.log($(document).height());
					return false;
				},
				error:function(xhr){
					//error	
				}					
			})	 
	}
	
});

</script>

</html>