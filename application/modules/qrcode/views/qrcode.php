<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>php二维码</title>
</head>
<body>
<div class="search">
    <img src="<?=site_url('qrcode/index/qrcodes?data=').lock_url($url);?>">
    <img src="<?=site_url('qrcode/index/qrcodes2?data=').lock_url($url);?>">
</div>
</body>
</html>