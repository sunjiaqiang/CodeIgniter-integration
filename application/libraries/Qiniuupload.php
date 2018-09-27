<?php
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/9/26
 * Time: 19:49
 */
//本项目的依赖库，依赖于composer自动加载，在config/config.php中已经引入了autoload.php文件，所以这里不需要再次引入sdk下面的autoload.php
//config.php是自动载入的，所以类库已经自动加载，可以直接使用
// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;
class Qiniuupload{
    private $accessKeyId='';//AccessKey
    private $accessKeySecret='';//SecretKey
    private $bucket='';//创建的bucket
    private $returnBody = null;
    private $expires = 3600;//自定义凭证有效期（示例1小时，expires单位为秒，为上传凭证的有效时间）
    private $image_url = '';

    /**
     * 构造函数初始化上传配置
     * Qiniuupload constructor.
     */
    public function __construct()
    {
        $this->_initialize();
    }
    /**
     * 初始化配置
     */
    private function _initialize(){
        $CI = &get_instance();
        $CI->config->load('qiniuoss',TRUE);
        $config = $CI->config->item('oss','qiniuoss');
        $this->accessKeyId = $config['accessKeyId'];
        $this->accessKeySecret = $config['accessKeySecret'];
        $this->bucket = $config['bucket'];
        $this->returnBody = $config['returnBody'] ?: null;
        $this->expires = $config['expires'] ?: 3600;
        $this->image_url = $config['image_url'];
    }
    /**
     * 上传文件到oss服务器
     * @param string $local_file 本地文件路径
     * @param string $remote_file oss文件路径
     * @return string
     */
    public function _upload($local_file='',$remote_file=''){
        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = $this->accessKeyId;
        $secretKey = $this->accessKeySecret;
        $bucket = $this->bucket;
        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);
        // 简单上传凭证
        $expires = $this->expires;
        // 生成上传 Token
        //自定义上传回复（非callback模式）凭证
        $returnBody = $this->returnBody;
        $policy = array(
            'returnBody' => $returnBody
        );
        $token = $auth->uploadToken($bucket, null, $expires, $policy, true);
        //$token = $auth->uploadToken($bucket);
        // 要上传文件的本地路径
        $filePath = $local_file;
        // 上传到七牛后保存的文件名
        $key = $remote_file;
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null){
            return FALSE;
        }
        return  $this->image_url.'/'.$remote_file;
    }

    /**
     * 删除七牛oss文件
     * @param string $object 文件地址(不包含域名)
     */
    public function _delete_file($object=''){
        $auth = new Auth($this->accessKeyId, $this->accessKeySecret);
        $config = new \Qiniu\Config();
        $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
        $err = $bucketManager->delete($this->bucket, $object);
        if ($err) {
            return FALSE;
        }
        return TRUE;
    }
}