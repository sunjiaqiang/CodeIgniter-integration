# CodeIgniter-integration(CI框架插件及功能整合)

基于CI框架3.1.9的hmvc模式整合的一些插件和常用功能，如果对hmvc不是很了解的同学，可以先百度一下，
如果你有php基础和框架使用经验(yii,thinkphp等)，一般来说这些功能都能整合进这些框架中。

# 安装及要求
clone本项目或者下载zip到本地
推荐使用composer安装：composer create-project sunjiaqiang/codeigniter-integration
PHP>=5.6，否则会报错

# 简介

使用CI框架在开发项目的过程中，整理了一下项目中常用的功能和SDK整合，当然这些功能在项目中使用频率都是比较高的，功能全部通过测试，放心使用，
此项目不是一套完整的项目，这是整合了各种功能，方便在开发新项目的时候拿来使用。

# 相关整合功能

将本项目clone下来，并配置好域名
假设你的域名为xxx.com

	1.plupload多图上传 访问地址http://xxx.com/plupload/index/index

	2.webupload多图上传 访问地址http://xxx.com/webupload/index/index
	
	3.PHPQRCode生成二维码 访问地址http://xxx.com/qrcode/index/index
	
	4.tcpdf生成pdf 访问地址http://xxx.com/pdf/index/index
	
	5.整合PHPmailer发送邮件 访问地址http://xxx.com/email/index/index(需要配置你自己的163邮箱和邮箱独立密码，并配置好邮箱相关配置)
	
	6.wangeditor编辑器整合 访问地址http://xxx.come/editor/index/wangeditor
	
	7.ajax无刷新分页 访问地址http://xxx.com/ajaxpage/index/index(正常的分页码，自定义的分页类，可以学到如何扩展ci框架)
	
	8.ajax滚动加载数据 访问地址http://xxx.com/scroll/index
	
	9.php日历签到 访问地址http://xxx.com/calendar/index/calendar_one
	
	10.php普通日历 访问地址http://xxx.com/calendar/index/calendar_two
	
	11.内容数据静态化 访问地址http://xxx.com/createstatic/index/index(批量数据生成)
	
	12.jquery电子签名 访问地址http://xxx.com/signature/index/index
	
	13.highcharts柱状图数据显示 访问地址http://xxx.com/analysis/index/index
	
	14.phpspreadsheet+jquery.tmpl数据导入导出excel 访问地址http://xxx.com/excel/index/index(导入excel)，http://xxx.com/excel/index/export_excel(导出excel)
	
	15.阿里云oss整合plupload文件上传与删除等功能 访问地址 http://xxx.com/plupload/index/alioss
	
	16.七牛云oss整合plupload文件上传与删除 访问地址 http://xxx.com/plupload/index/qiniu
	
	17.RBAC权限管理 访问地址 http://xxx.com/admin/index/login

# 基于角色的权限管理

目前功能已做到事件级别权限控制,如：后台用户的添加操作、删除操作和保存操作等具体到事件级的操作方法

17.RBAC权限管理，目前功能为：后台菜单全动态，权限只控制到菜单级后期会把权限控制到方法级，测试账号(管理员：蜡笔小新 密码：123456，普通用户：李力2 密码：123456)，使用管理员账号登录，可以使用的
功能有：系统管理下面的"菜单管理"、"事件菜单"、"用户管理"和"角色管理"，其它的都是添加的测试菜单。
相关界面预览：

后台登录
<img src="https://github.com/sunjiaqiang/CodeIgniter-integration/blob/master/public/%E7%95%8C%E9%9D%A2%E9%A2%84%E8%A7%88/RBAC/%E5%90%8E%E5%8F%B0%E7%99%BB%E9%99%86.jpg">

菜单管理
<img src="https://github.com/sunjiaqiang/CodeIgniter-integration/blob/master/public/%E7%95%8C%E9%9D%A2%E9%A2%84%E8%A7%88/RBAC/%E8%8F%9C%E5%8D%95%E7%AE%A1%E7%90%86.jpg">

用户管理
<img src="https://github.com/sunjiaqiang/CodeIgniter-integration/blob/master/public/%E7%95%8C%E9%9D%A2%E9%A2%84%E8%A7%88/RBAC/%E7%94%A8%E6%88%B7%E7%AE%A1%E7%90%86.jpg">

角色管理	
<img src="https://github.com/sunjiaqiang/CodeIgniter-integration/blob/master/public/%E7%95%8C%E9%9D%A2%E9%A2%84%E8%A7%88/RBAC/%E8%A7%92%E8%89%B2%E7%AE%A1%E7%90%86.jpg">

角色授权
<img src="https://github.com/sunjiaqiang/CodeIgniter-integration/blob/master/public/%E7%95%8C%E9%9D%A2%E9%A2%84%E8%A7%88/RBAC/%E8%A7%92%E8%89%B2%E6%8E%88%E6%9D%83.jpg">


# 相关库说明
阿里云和七牛云等这些库使用composer自动加载,使用阿里云和七牛云需要到对应官网按照教程申请好相关key和秘钥，然后将项目里面的配置文件配置完毕即可使用。
第7点ajax无刷新分页使用了自定义的分页类，url传参及分页样式自定义输出都是非常方便的，另外我对此分页类也写了一篇文章<a href="https://www.cnblogs.com/phproom/p/9588656.html" target="_blank">PHP+Mysql实现分页</a>和此分页功能类似。
	
# 使用说明
本着开源以及使广大猿们少走弯路和少造轮子的精神，开源这些源码，你可以使用到你的任何项目当中去，但是不得将此源码中的任何功能进行售卖，
一经发现本人保留追究其责任的权利。