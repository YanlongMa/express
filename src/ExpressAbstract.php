<?php

namespace YanlongMa\Express;

/**
 * 快递接口抽象类
 *
 * Class ExpressAbstract
 * @package YanlongMa\Express
 */
abstract class ExpressAbstract
{
    /**
     * 查询运单号
     *
     * @param $number
     * @param $company
     * @return mixed
     */
    abstract public function query($number, $company);

    /**
     * 获取快递公司列表
     *
     * @return mixed
     */
    abstract public function company();

    /**
     * 返回信息格式
     *
     * @param $code
     * @param $msg
     * @param array $data
     * @return array    错误码，0为成功，其它为失败
     */
    protected function result($code, $msg, $data = [])
    {
        return [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
    }
}