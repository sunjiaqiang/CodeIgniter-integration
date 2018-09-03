<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?=$title;?></title>
 <script src="<?php echo base_url();?>public/js/jquery/jquery-1.9.1.min.js"></script>
<!-- 注意， 只需要引用 JS，无需引用任何 CSS ！！！-->
<style type="text/css">

html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td {
    margin: 0;
    padding: 0;
    border: 0;
    outline: 0;
    font-size: 100%;
    vertical-align: baseline;
    background: transparent;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

div#ljTenement div.filterLine {
    min-height: 260px;
    padding: 22px;
    border: 1px solid #E6E6E6;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    margin-bottom: 20px;
}

div#ljTenement div.filterLine div.clearFix {
    width: 100%;
    margin-bottom: 12px;
    font-size: 14px;
}

div#ljTenement div.filterLine div.clearFix h1 {
    width: 70px;
    text-align: center;
}

.toolbar {
	border: 1px solid #ccc;
}
.text {
	border: 1px solid #ccc;
	height: 500px;
}
</style>
</head>
<body>

<div id="clock">
<?=$content;?>
</div>


</body>
</html>