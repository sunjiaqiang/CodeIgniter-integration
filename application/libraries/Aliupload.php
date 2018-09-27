<?php
/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2018/9/21
 * Time: 16:44
 */
//本项目的依赖库，依赖于composer自动加载，在config/config.php中已经引入了autoload.php文件，所以这里不需要再次引入sdk下面的autoload.php
//config.php是自动载入的，所以类库已经自动加载，可以直接使用
USE OSS\OssClient;
USE OSS\Core\OssException;
class Aliupload{
    private $accessKeyId = '';
    private $accessKeySecret = '';
    private $endpoint = '';
    private $bucket = '';
    /**
     * 构造函数初始化配置
     * Aliupload constructor.
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
        $CI->config->load('alioss',TRUE);
        $config = $CI->config->item('oss','alioss');
        $this->accessKeyId = $config['accessKeyId'];
        $this->accessKeySecret = $config['accessKeySecret'];
        $this->endpoint = $config['endpoint'];
        $this->bucket = $config['bucket'];
    }

    /**
     * 上传文件到oss服务器
     * @param string $local_file
     * @param string $remote_file
     * @return string
     * @throws OssException
     */
    public function _upload($local_file='',$remote_file=''){
        $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
        try{
            $result = $ossClient->uploadFile($this->bucket,$remote_file,$local_file);
            return $result['info']['url'];
        } catch(OssException $e) {
            return $e->getMessage();
        }
    }

    /**
     * 删除oss文件
     * @param string $object
     * @return null|string
     * @throws OssException
     */
    public function _delete_file($object=''){
        $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
        try{
            $ossClient->deleteObject($this->bucket, $object);
            return TRUE;
        } catch(OssException $e) {
            return $e->getMessage();
        }
    }

    /**
     * 检查文件是否存在
     * @param string $object
     * @return bool|string
     * @throws OssException
     */
    public function _check_file_exist($object=''){
        $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
        try{
            return $exist = $ossClient->doesObjectExist($this->bucket, $object);
        } catch(OssException $e) {
            return $e->getMessage();
        }
    }
}