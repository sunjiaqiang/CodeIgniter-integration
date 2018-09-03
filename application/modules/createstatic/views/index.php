<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="<?= site_url('') ?>">
    <title>列表</title>
    <link href="public/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="public/css/bootstrap-responsive.min.css" rel="stylesheet"/>
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
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="span2">
            <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse affix-top">
            </ul>
        </div>
        <div class="span10">
            <div class="row-fluid">
                <div class="block-content collapse in">
                    <form class="form-spe" id="form-spe" name="form-spe" action="<?= site_url('createstatic/index/index') ?>" method="post">
                        <div class="span12">
                            <div class="form-actions">
                                <button name="submit" type="submit" id="sub" class="btn btn-primary">生成</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div id="lay-dialog" style="margin:5px; display:none;">
    <div id="progress" class="progress progress-striped active">
        <div class="bar" style=""></div>
    </div>
</div>
</div>
<script>

</script>
</body>
</html>