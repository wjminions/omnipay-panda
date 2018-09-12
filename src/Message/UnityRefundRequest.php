<?php

namespace Omnipay\Panda\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Panda\Helper;

/**
 * Class UnityRefundRequest
 *
 * @package Omnipay\Panda\Message
 */
class UnityRefundRequest extends AbstractUnityRequest
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
            'order_id',
            'merchant_id',
            'time',
            'refund_amount'
        );

        $data = array(
            'order_id'      => $this->getOrderId(),
            'merchant_id'   => $this->getMerchantId(),
            'time'          => $this->getTime(),
            'refund_amount' => $this->getRefundAmount(),
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

        $result = Helper::sendHttpRequest($this->getEndpoint('refund'), $data);

        $result = (array) json_decode($result);

        $sign = Helper::sign($result, $this->getkey());

        $result['is_paid'] = false;

        if (isset($result['sign'])) {
            if ($result['sign'] == $sign && $result['status'] == 'success') {
                $result['is_paid'] = true;
            }
        }

        return $this->response = new UnityRefundResponse($this, $result);
    }
}
