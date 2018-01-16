<?php

namespace YanlongMa\Express;

/**
 * 快递单号查询
 *      文档地址：https://market.aliyun.com/products/57126001/cmapi011120.html
 *
 * Class Jisukdcx
 * @package YanlongMa\Express
 */
class Jisukdcx extends ExpressAbstract
{
    private $appCode;

    private $host = 'http://jisukdcx.market.alicloudapi.com/';

    // 物流状态
    private $deliveryStatus = [
        1 => '在途中',
        2 => '派件中',
        3 => '已签收',
        4 => '派件失败(拒签等)',
    ];

    /**
     * Jisukdcx constructor.
     * @param $appCode
     */
    public function __construct($appCode)
    {
        $this->appCode = $appCode;
    }

    /**
     * 获取 header
     *
     * @return array
     */
    private function getHeader()
    {
        return [
            'Authorization:APPCODE ' . $this->appCode
        ];
    }

    /**
     * 获取完整请求 url
     *
     * @param $path
     * @param array $params
     * @return string
     */
    private function getRequestUrl($path, $params = [])
    {
        return $this->host . trim($path, '/') . '?' . http_build_query($params);
    }

    /**
     * 查询运单号
     *
     * @param $number   运单号 69576009311
     * @param string $company 公司简称，默认为 auto，取 company() 方法中 type 字段
     * @return array
     */
    public function query($number, $company = 'auto')
    {
        $params = [
            'number' => $number,
            'type' => $company,
        ];
        $requestUrl = $this->getRequestUrl('express/query', $params);

        $options = [
            CURLOPT_HTTPHEADER => $this->getHeader()
        ];

        $client = new Client();
        $response = $client->request('GET', $requestUrl, [], $options);

        if ($response->getStatusCode() != 200) {
            return $this->result($response->getStatusCode(), '网络错误');
        }

        // 成功 {"status":"0","msg":"ok","result":{"number":"69576009311","type":"jd","list":[{"time":"2017-12-08 11:19:06","status":"货物已完成配送，感谢您选择京东配送"},{"time":"2017-12-08 11:19:06","status":"您的包裹已由物流公司揽收"}],"deliverystatus":"3","issign":"1"}}
        // 失败 {"status":"205","msg":"没有信息","result":""}
        $arr = json_decode($response->getBody(), true);
        if (!is_array($arr) || !array_key_exists('status', $arr) || $arr['status'] != 0) {
            return $this->result($arr['status'], $arr['msg']);
        }

        if (isset($this->deliveryStatus[$arr['result']['deliverystatus']])) {
            $arr['result']['deliverystatus_alias'] = $this->deliveryStatus[$arr['result']['deliverystatus']];
        }

        return $this->result(0, 'success', $arr['result']);
    }

    /**
     * 获取快递公司列表
     *
     * @return array
     */
    public function company()
    {
        $options = [
            CURLOPT_HTTPHEADER => $this->getHeader()
        ];

        $client = new Client();
        $response = $client->request('GET', $this->getRequestUrl('express/type'), [], $options);

        if ($response->getStatusCode() != 200) {
            return $this->result($response->getStatusCode(), '网络错误');
        }

        // 成功{"status":"0","msg":"ok","result":[{"name":"中通","type":"ZTO","letter":"Z","tel":"95311","number":"421447644512"}, {"name":"申通","type":"STO","letter":"S","tel":"95543","number":"403234843091"}]}
        $arr = json_decode($response->getBody(), true);
        if (!is_array($arr) || !array_key_exists('status', $arr) || $arr['status'] != 0) {
            return $this->result($arr['status'], $arr['msg']);
        }

        return $this->result(0, 'success', $arr['result']);
    }


}