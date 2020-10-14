<?php

namespace Wjj1021\Polyv;

class Polyv
{
    private $appId;
    private $appSecret;
    private $timestamp;

    public function __construct($appId,$appSecret){
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->timestamp = time()*1000;
    }

    public function baseList($page=1,$pageSize=20){
        $url = 'https://api.polyv.net/live/v3/channel/basic/list';
        return $this->curlQuery($url,compact('page','pageSize'));
    }

    //public function


    private function getSign($params){
        // 1. 对加密数组进行字典排序
        foreach ($params as $key=>$value){
            $arr[$key] = $key;
        }
        sort($arr);
        $str = $this->appSecret;
        foreach ($arr as $k => $v) {
            $str = $str.$arr[$k].$params[$v];
        }
        $restr = $str.$this->appSecret;
        $sign = strtoupper(md5($restr));
        return $sign;
    }

    /**
     *
     * @param $url
     * @param array $param
     * @param string $method
     * @return mixed
     * @throws /\Exception
     */
    private function curlQuery($url,$param=[],$method='get'){
        $header = array(
            'Accept: application/json',
        );
        $publicParam = [
            'appId' => $this->appId,
            'timestamp' => $this->timestamp,
        ];
        $httpParam = array_merge($publicParam,$param);
        $httpParam['sign'] = $this->getSign($httpParam);

        if($method == 'get'){
            $url.= '?'.http_build_query($httpParam);;
        }

        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // 超时设置,以秒为单位
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        // 超时设置，以毫秒为单位
        // curl_setopt($curl, CURLOPT_TIMEOUT_MS, 500);
        // 设置请求头
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        //设置post方式提交
        if($method == 'post') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $httpParam);
        }

        //执行命令
        $data = curl_exec($curl);
        // 显示错误信息
        if (curl_error($curl)) {
            throw new \Exception('Error:'.curl_error($curl));
        }
        curl_close($curl);

        return json_decode($data,true);

    }
}
