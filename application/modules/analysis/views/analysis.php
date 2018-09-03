<!doctype html>
<html>
<head>
<base href="<?php echo site_url('');?>">
<title>统计分析</title>

<script src="<?php echo base_url();?>public/js/jquery/jquery-1.9.1.min.js"></script>
<script src="public/js/Highcharts-6.0.3/code/highcharts.js"></script>
<script src="public/js/Highcharts-6.0.3/code/modules/exporting.js"></script>
<style>
.color-chujing {
	color: #009acb;
}
.color-red {
	color: #ff0000;
}
</style>
</head>
<body>
<div class="wrap J_check_wrap">
  
    <div class="table_list" id="content">

     <div id="container" style="min-width:400px;height:400px"></div>

    </div>
   
  
</div>


<script type="text/javascript">

$(function () {
		
		console.log(JSON.parse('<?php echo $month_arr?>'));
	
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '每月每个栏目的发布文章数'
        },
        subtitle: {
            text: '数据来源: https://www.cnblogs.com/phproom/'
        },
        xAxis: {
            categories: JSON.parse('<?php echo $month;?>'),
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: '文章数 (篇)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:1f} 篇</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                borderWidth: 0
            }
        },
        series: JSON.parse('<?php echo $month_arr?>')
       
    });
});

</script>
</body>
</html>