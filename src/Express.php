<?php

namespace YanlongMa\Express;

/**
 * 快递查询
 *
 * Class Express
 * @package YanlongMa\Express
 */
class Express
{
    // 服务类
    private $service;

    /**
     *  $obj = new Express(new Jisukdcx());
     *  $info = $obj->query('69576009311');
     *  var_dump($info);
     */
    public function __construct(ExpressAbstract $service)
    {
        $this->service = $service;
    }

    /**
     * 查询运单号
     *
     * @param $number
     * @param string $company
     * @return array
     */
    public function query($number, $company = 'auto')
    {
        return $this->service->query($number, $company);
    }

    /**
     * 获取快递公司列表
     *
     * @return array
     */
    public function company()
    {
        return $this->service->company();
    }

    /**
     * $info = (new Express())->query('69576009311');
     * $list = (new Express())->company();
     */
    /*
    public function __construct()
    {
        $this->service = new Jisukdcx();
    }
    */
}