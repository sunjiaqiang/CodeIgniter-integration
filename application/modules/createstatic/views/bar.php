<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="<?= site_url('') ?>">
    <title>生成</title>
    <link href="public/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="public/css/bootstrap-responsive.min.css" rel="stylesheet"/>
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
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="span2">
           <?=$msg;?>
        </div>
        
    </div>
    <hr>

    <div id="lay-dialog" style="margin:5px">
        <div id="progress" class="progress progress-striped active <?=$percent == 1 ? 'progress-success' : '';?>">
            <div class="bar" style=" width:<?=$percent*100;?>%"></div>
        </div>
    </div>
</div>

<script>
   /**
* JS操作框
* @author dayu
* @copyright			(C) 2009-2011 DayuCMS
* @lastmodify			2011-6-20 17:30
*/
function redirect(url)
{
	if(url=="javascript:history.back();")eval(url);
	else self.location.href=url;
}
</script>

</html>