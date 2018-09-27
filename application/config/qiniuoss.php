<?php
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/9/26
 * Time: 19:12
 * @description 七牛云oss配置文件
 */
$config['oss'] = [
    'accessKeyId'=>'dTZIkQOSYp6eg__13cD3Q53nc8fqsrWC76Rf0yBv',
    'accessKeySecret'=>'nEzd3h9bIdGgBCI0IqmK9fsLJ_oLy5E3NIsMpNhN',
    'bucket'=>'lb-images',
    'expires'=>3600,////自定义凭证有效期（示例1小时，expires单位为秒，为上传凭证的有效时间）
    'returnBody'=>'{"key":"$(key)","hash":"$(etag)","fsize":$(fsize),"bucket":"$(bucket)","name":"$(x:name)"}',//自定义上传回复的凭证
    'image_url'=>'http://images.lbxiaoxin.com'//在七牛云配置的cdn域名，也可以使用七牛云提供的临时域名进行测试
];
