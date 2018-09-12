<?php

namespace Omnipay\Panda\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Panda\Helper;

/**
 * Class UnityQueryRequest
 *
 * @package Omnipay\Panda\Message
 */
class UnityQueryRequest extends AbstractUnityRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate(
            'trade_no',
            'merchant_id',
            'time'
        );

        $data = array(
            'trade_no'      => $this->getTradeNo(),
            'merchant_id'   => $this->getMerchantId(),
            'time'          => $this->getTime(),
        );

        return $data;
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {

        $data['sign'] = Helper::sign($data, $this->getkey());

        $result = Helper::sendHttpRequest($this->getEndpoint('query'), $data);


        $result = (array) json_decode($result);

        $sign = Helper::sign($result, $this->getkey());

        $result['is_paid'] = false;

        if ($result['sign'] == $sign && $result['status'] == 'success') {
            $result['is_paid'] = true;
        }

        return $result;// 输出 Ping++ 返回 Unity 对象
    }
}
